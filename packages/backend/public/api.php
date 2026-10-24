<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

function json_out(array $data, int $status = 200): never
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
    exit;
}

function number_or_null(mixed $value, float $min, float $max): ?float
{
    if ($value === null || $value === '') {
        return null;
    }
    if (!is_numeric($value) || $value < $min || $value > $max) {
        json_out(['error' => 'Value out of range'], 422);
    }
    return (float) $value;
}

$user = current_user();
if ($user === null) {
    json_out(['error' => 'Authentication required'], 401);
}

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$viewAll = can_view_all($user);

if ($action === 'collect' && $method === 'POST') {
    csrf_check();
    $body = request_body();
    $lat = number_or_null($body['latitude'] ?? null, -90, 90);
    $lon = number_or_null($body['longitude'] ?? null, -180, 180);
    if ($lat === null || $lon === null) {
        json_out(['error' => 'latitude and longitude are required'], 422);
    }
    $supported = !empty($body['battery_supported']);
    $stmt = db()->prepare(
        'INSERT INTO usagedata (uid, latitude, longitude, altitude, accuracy, battery_supported, battery_level, battery_charging, notes)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        $user['uid'],
        $lat,
        $lon,
        number_or_null($body['altitude'] ?? null, -1000, 100000),
        number_or_null($body['accuracy'] ?? null, 0, 1000000),
        $supported ? 1 : 0,
        $supported ? number_or_null($body['battery_level'] ?? null, 0, 1) : null,
        $supported && isset($body['battery_charging']) ? (int) (bool) $body['battery_charging'] : null,
        isset($body['notes']) ? mb_substr((string) $body['notes'], 0, 255) : null,
    ]);
    json_out(['id' => (int) db()->lastInsertId()], 201);
}

if ($action === 'list' && $method === 'GET') {
    $limit = max(1, min(100, (int) ($_GET['limit'] ?? 20)));
    $page = max(1, (int) ($_GET['page'] ?? 1));
    $where = $viewAll ? '' : 'WHERE uid = :uid';

    $count = db()->prepare("SELECT COUNT(*) FROM usagedata $where");
    if (!$viewAll) {
        $count->bindValue(':uid', $user['uid'], PDO::PARAM_INT);
    }
    $count->execute();
    $total = (int) $count->fetchColumn();

    $stmt = db()->prepare(
        "SELECT id, uid, latitude, longitude, altitude, accuracy, battery_supported, battery_level, battery_charging, notes, recorded_at
         FROM usagedata $where ORDER BY recorded_at DESC, id DESC LIMIT :limit OFFSET :offset"
    );
    if (!$viewAll) {
        $stmt->bindValue(':uid', $user['uid'], PDO::PARAM_INT);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', ($page - 1) * $limit, PDO::PARAM_INT);
    $stmt->execute();

    json_out([
        'rows' => $stmt->fetchAll(),
        'meta' => ['page' => $page, 'limit' => $limit, 'total' => $total, 'pages' => max(1, (int) ceil($total / $limit))],
        'can_delete' => in_array($user['role'], ROLES_DELETE, true),
    ]);
}

if ($action === 'locations' && $method === 'GET') {
    $uid = (int) ($_GET['uid'] ?? $user['uid']);
    if (!$viewAll && $uid !== $user['uid']) {
        json_out(['error' => 'Forbidden'], 403);
    }
    $stmt = db()->prepare('SELECT latitude, longitude FROM usagedata WHERE uid = ? ORDER BY recorded_at DESC, id DESC LIMIT 5000');
    $stmt->execute([$uid]);
    json_out(['locations' => array_map('array_values', $stmt->fetchAll())]);
}

if ($action === 'users' && $method === 'GET') {
    if ($viewAll) {
        $rows = db()->query('SELECT uid, name, surname FROM users ORDER BY name, surname')->fetchAll();
    } else {
        $stmt = db()->prepare('SELECT uid, name, surname FROM users WHERE uid = ?');
        $stmt->execute([$user['uid']]);
        $rows = $stmt->fetchAll();
    }
    json_out(['users' => $rows]);
}

if ($action === 'delete' && $method === 'POST') {
    csrf_check();
    if (!in_array($user['role'], ROLES_DELETE, true)) {
        json_out(['error' => 'Forbidden'], 403);
    }
    $id = (int) (request_body()['id'] ?? 0);
    $stmt = db()->prepare('DELETE FROM usagedata WHERE id = ?');
    $stmt->execute([$id]);
    json_out(['deleted' => $stmt->rowCount()]);
}

json_out(['error' => 'Not found'], 404);
