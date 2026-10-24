<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

// page name => requires login
const PAGES = [
    'intro' => false,
    'signin' => false,
    'signup' => false,
    'collect' => true,
    'view' => true,
    'data' => true,
    'analyze' => true,
];

$action = (string) ($_GET['action'] ?? 'intro');
$user = current_user();

if ($action === 'signout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $_SESSION = [];
    session_destroy();
    header('Location: index.php');
    exit;
}

if (!array_key_exists($action, PAGES)) {
    http_response_code(404);
    $action = 'intro';
}
if (PAGES[$action] && $user === null) {
    header('Location: index.php?action=signin');
    exit;
}

// Page files may redirect, so render them into a buffer before any output is sent.
ob_start();
require __DIR__ . '/../src/pages/' . $action . '.php';
$content = (string) ob_get_clean();

$menu = [
    'intro' => 'Intro',
    'collect' => 'Collect',
    'view' => 'Map',
    'data' => 'Data',
    'analyze' => 'Battery analysis',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mobile GPS Analytics</title>
    <link rel="stylesheet" href="css/style.css">
    <?= $head ?? '' ?>
</head>
<body data-csrf="<?= e(csrf_token()) ?>">
<header>
    <h1>Mobile GPS Analytics</h1>
    <nav>
        <?php foreach ($menu as $page => $label): ?>
            <?php if (!PAGES[$page] || $user !== null): ?>
                <a href="index.php?action=<?= e($page) ?>"<?= $page === $action ? ' class="active"' : '' ?>><?= e($label) ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($user === null): ?>
            <a href="index.php?action=signin"<?= $action === 'signin' ? ' class="active"' : '' ?>>Sign in</a>
            <a href="index.php?action=signup"<?= $action === 'signup' ? ' class="active"' : '' ?>>Sign up</a>
        <?php else: ?>
            <form method="post" action="index.php?action=signout" class="inline">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <span class="who"><?= e($user['name']) ?></span>
                <button type="submit">Sign out</button>
            </form>
        <?php endif; ?>
    </nav>
</header>
<main>
    <?= $content ?>
</main>
</body>
</html>
