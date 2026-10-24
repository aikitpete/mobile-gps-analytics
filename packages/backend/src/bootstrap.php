<?php
declare(strict_types=1);

const ROLES = ['usability_analyst', 'data_analyst', 'data_admin', 'user_admin'];
const ROLES_VIEW_ALL = ['data_analyst', 'data_admin'];
const ROLES_DELETE = ['data_admin'];

function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    return ($value === false || $value === '') ? $default : $value;
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = env('DB_DSN', 'mysql:host=127.0.0.1;dbname=gps_analytics;charset=utf8mb4');
        $pdo = new PDO($dsn, env('DB_USER'), env('DB_PASS'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver === 'mysql') {
            $pdo->exec("SET time_zone = '+00:00'");
        } elseif ($driver === 'sqlite') {
            $pdo->exec('PRAGMA foreign_keys = ON');
        }
    }
    return $pdo;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function can_view_all(?array $user): bool
{
    return $user !== null && in_array($user['role'], ROLES_VIEW_ALL, true);
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_check(): void
{
    $expected = (string) ($_SESSION['csrf'] ?? '');
    $sent = (string) ($_POST['csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''));
    if ($expected === '' || !hash_equals($expected, $sent)) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }
}

function request_body(): array
{
    $type = $_SERVER['CONTENT_TYPE'] ?? '';
    if (str_starts_with($type, 'application/json')) {
        $decoded = json_decode((string) file_get_contents('php://input'), true);
        return is_array($decoded) ? $decoded : [];
    }
    return $_POST;
}

if (PHP_SAPI !== 'cli') {
    ini_set('display_errors', '0');
    set_exception_handler(static function (Throwable $e): void {
        error_log((string) $e);
        http_response_code(500);
        if (str_ends_with($_SERVER['SCRIPT_NAME'] ?? '', 'api.php')) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => 'Internal server error']);
        } else {
            echo 'Internal server error';
        }
    });

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: same-origin');

    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}
