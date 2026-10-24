<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    $stmt = db()->prepare('SELECT uid, name, password_hash, category FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    // Always run a hash check so response time does not reveal whether the email exists.
    $hash = $row['password_hash'] ?? password_hash('placeholder', PASSWORD_DEFAULT);
    if (password_verify($password, $hash) && $row) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['uid' => (int) $row['uid'], 'name' => $row['name'], 'role' => $row['category']];
        header('Location: index.php?action=collect');
        exit;
    }
    $error = 'Email or password is incorrect.';
}
?>
<h2>Sign in</h2>
<form method="post" class="stack">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <label>Email <input type="email" name="email" required autocomplete="username"></label>
    <label>Password <input type="password" name="password" required autocomplete="current-password"></label>
    <?php if ($error !== ''): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
    <button type="submit">Sign in</button>
</form>
