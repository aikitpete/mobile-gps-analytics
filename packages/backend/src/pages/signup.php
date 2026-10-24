<?php
$error = '';
$done = false;
$old = ['name' => '', 'surname' => '', 'email' => '', 'feedback' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    foreach ($old as $field => $_) {
        $old[$field] = trim((string) ($_POST[$field] ?? ''));
    }
    $password = (string) ($_POST['password'] ?? '');

    if ($old['name'] === '' || $old['surname'] === '' || mb_strlen($old['name']) > 40 || mb_strlen($old['surname']) > 40) {
        $error = 'Please enter your first and last name (up to 40 characters each).';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL) || strlen($old['email']) > 255) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 10) {
        $error = 'The password needs at least 10 characters.';
    } elseif (!hash_equals($password, (string) ($_POST['password2'] ?? ''))) {
        $error = 'The passwords do not match.';
    } else {
        try {
            $stmt = db()->prepare('INSERT INTO users (name, surname, email, password_hash, feedback) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([
                $old['name'],
                $old['surname'],
                $old['email'],
                password_hash($password, PASSWORD_DEFAULT),
                mb_substr($old['feedback'], 0, 500),
            ]);
            $done = true;
        } catch (PDOException $ex) {
            if ($ex->getCode() !== '23000') {
                throw $ex;
            }
            $error = 'An account with this email already exists.';
        }
    }
}
?>
<h2>Create an account</h2>
<?php if ($done): ?>
    <p class="ok">Registration successful. <a href="index.php?action=signin">Sign in</a> to start collecting.</p>
<?php else: ?>
<form method="post" class="stack">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <label>First name <input name="name" value="<?= e($old['name']) ?>" maxlength="40" required></label>
    <label>Last name <input name="surname" value="<?= e($old['surname']) ?>" maxlength="40" required></label>
    <label>Email <input type="email" name="email" value="<?= e($old['email']) ?>" required autocomplete="username"></label>
    <label>Password (10+ characters) <input type="password" name="password" minlength="10" required autocomplete="new-password"></label>
    <label>Repeat password <input type="password" name="password2" minlength="10" required autocomplete="new-password"></label>
    <label>Why do you want to take part? (optional)
        <textarea name="feedback" rows="3" maxlength="500"><?= e($old['feedback']) ?></textarea>
    </label>
    <?php if ($error !== ''): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
    <button type="submit">Register</button>
</form>
<p class="hint">New accounts start with the analyst role. An administrator can grant wider access.</p>
<?php endif; ?>
