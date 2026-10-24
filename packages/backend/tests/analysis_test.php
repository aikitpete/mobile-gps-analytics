<?php
declare(strict_types=1);

require __DIR__ . '/../src/analysis.php';

$failures = 0;
function check(string $name, bool $ok): void
{
    global $failures;
    echo ($ok ? 'ok   ' : 'FAIL ') . $name . PHP_EOL;
    $failures += $ok ? 0 : 1;
}

// 60 samples, one per minute, level falls from 0.80 to 0.74 => 6 % in 59 minutes.
$readings = [];
for ($i = 0; $i < 60; $i++) {
    $readings[] = ['ts' => 1_700_000_000 + $i * 60, 'level' => 0.80 - $i * 0.001, 'charging' => false];
}
$d = battery_drain($readings);
check('discharge percent', abs($d['percent_used'] - 5.9) < 0.01);
check('discharge rate per hour', abs($d['percent_per_hour'] - 6.0) < 0.05);

// A charging interval and a 1 h gap are ignored.
$d = battery_drain([
    ['ts' => 0, 'level' => 0.50, 'charging' => false],
    ['ts' => 60, 'level' => 0.49, 'charging' => false],
    ['ts' => 120, 'level' => 0.55, 'charging' => true],
    ['ts' => 180, 'level' => 0.56, 'charging' => true],
    ['ts' => 3780, 'level' => 0.40, 'charging' => false],
]);
check('charging and gaps ignored', $d['percent_used'] === 1.0 && abs($d['hours'] - 60 / 3600) < 0.001);

check('no data gives null rate', battery_drain([])['percent_per_hour'] === null);
check('unsupported battery gives null rate', battery_drain([
    ['ts' => 0, 'level' => null, 'charging' => null],
    ['ts' => 60, 'level' => null, 'charging' => null],
])['percent_per_hour'] === null);

// One degree of latitude is about 111.2 km.
check('haversine', abs(haversine_km(55.0, 13.0, 56.0, 13.0) - 111.2) < 0.2);
check('track distance skips long gaps', track_distance_km([
    ['ts' => 0, 'lat' => 55.0, 'lon' => 13.0],
    ['ts' => 60, 'lat' => 55.001, 'lon' => 13.0],
    ['ts' => 7200, 'lat' => 56.0, 'lon' => 13.0],
]) < 0.2);

exit($failures === 0 ? 0 : 1);
