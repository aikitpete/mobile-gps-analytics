<?php
require_once __DIR__ . '/../analysis.php';

$sql = 'SELECT u.uid, u.name, u.surname, d.latitude, d.longitude, d.battery_supported, d.battery_level, d.battery_charging, d.recorded_at
        FROM usagedata d JOIN users u ON u.uid = d.uid';
$params = [];
if (!can_view_all($user)) {
    $sql .= ' WHERE d.uid = ?';
    $params[] = $user['uid'];
}
$sql .= ' ORDER BY d.uid, d.recorded_at, d.id LIMIT 200000';
$stmt = db()->prepare($sql);
$stmt->execute($params);

$perUser = [];
foreach ($stmt as $r) {
    $uid = (int) $r['uid'];
    $perUser[$uid]['name'] = $r['name'] . ' ' . $r['surname'];
    $ts = (int) strtotime($r['recorded_at'] . ' UTC');
    $perUser[$uid]['battery'][] = [
        'ts' => $ts,
        'level' => $r['battery_supported'] ? ($r['battery_level'] !== null ? (float) $r['battery_level'] : null) : null,
        'charging' => $r['battery_charging'] === null ? null : (bool) $r['battery_charging'],
    ];
    $perUser[$uid]['points'][] = ['ts' => $ts, 'lat' => (float) $r['latitude'], 'lon' => (float) $r['longitude']];
}
?>
<h2>Battery cost of tracking</h2>
<p>
    Computed from consecutive samples that are at most 15 minutes apart with the battery discharging.
    Charging periods and gaps are ignored.
</p>
<?php if ($perUser === []): ?>
    <p>No data yet. Record a trace on the Collect page first.</p>
<?php else: ?>
<table class="grid">
    <thead>
        <tr><th>User</th><th>Samples</th><th>Tracked (h)</th><th>Battery used (%)</th><th>% per hour</th><th>Distance (km)</th><th>% per km</th></tr>
    </thead>
    <tbody>
    <?php foreach ($perUser as $info):
        $drain = battery_drain($info['battery']);
        $km = track_distance_km($info['points']);
        ?>
        <tr>
            <td><?= e($info['name']) ?></td>
            <td><?= count($info['points']) ?></td>
            <td><?= e($drain['hours']) ?></td>
            <td><?= e($drain['percent_used']) ?></td>
            <td><?= $drain['percent_per_hour'] === null ? '–' : e($drain['percent_per_hour']) ?></td>
            <td><?= e($km) ?></td>
            <td><?= $km > 0 && $drain['percent_used'] > 0 ? e(round($drain['percent_used'] / $km, 2)) : '–' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
