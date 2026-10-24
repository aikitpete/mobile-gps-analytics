<?php
declare(strict_types=1);

/**
 * Create a user with any role (used to bootstrap the first administrator).
 *
 *   php bin/create-user.php EMAIL FIRST_NAME LAST_NAME ROLE
 *
 * The password is read from the CREATE_USER_PASSWORD environment variable,
 * or prompted for on stdin if it is not set.
 */
require __DIR__ . '/../src/bootstrap.php';

[$script, $email, $name, $surname, $role] = array_pad($argv, 5, null);
if (!$email || !$name || !$surname || !in_array($role, ROLES, true)) {
    fwrite(STDERR, "Usage: php bin/create-user.php EMAIL FIRST_NAME LAST_NAME ROLE\nRoles: " . implode(', ', ROLES) . "\n");
    exit(1);
}

$password = env('CREATE_USER_PASSWORD');
if ($password === null) {
    fwrite(STDERR, 'Password: ');
    $password = trim((string) fgets(STDIN));
}
if (strlen($password) < 10) {
    fwrite(STDERR, "The password needs at least 10 characters.\n");
    exit(1);
}

$stmt = db()->prepare('INSERT INTO users (name, surname, email, password_hash, category) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$name, $surname, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
echo "Created user #" . db()->lastInsertId() . " ($role)\n";
