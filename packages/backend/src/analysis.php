<?php
declare(strict_types=1);

/**
 * Battery cost of continuous tracking, computed from consecutive readings of one user.
 *
 * Only intervals where the battery is supported, not charging at either end, and the
 * readings are at most $maxGapSeconds apart are counted, so gaps (app closed, phone
 * asleep) and charging do not distort the rate.
 *
 * @param array<int, array{ts:int, level:?float, charging:?bool}> $readings sorted by ts ascending
 * @return array{percent_used:float, hours:float, percent_per_hour:?float}
 */
function battery_drain(array $readings, int $maxGapSeconds = 900): array
{
    $used = 0.0;
    $seconds = 0;
    for ($i = 1, $n = count($readings); $i < $n; $i++) {
        $prev = $readings[$i - 1];
        $cur = $readings[$i];
        if ($prev['level'] === null || $cur['level'] === null || $prev['charging'] || $cur['charging']) {
            continue;
        }
        $gap = $cur['ts'] - $prev['ts'];
        $delta = $prev['level'] - $cur['level'];
        if ($gap <= 0 || $gap > $maxGapSeconds || $delta < 0) {
            continue;
        }
        $used += $delta;
        $seconds += $gap;
    }
    $hours = $seconds / 3600;
    return [
        'percent_used' => round($used * 100, 2),
        'hours' => round($hours, 3),
        'percent_per_hour' => $seconds > 0 ? round($used * 100 / $hours, 2) : null,
    ];
}

/** Great-circle distance in kilometres between two points. */
function haversine_km(float $lat1, float $lon1, float $lat2, float $lon2): float
{
    $r = 6371.0088;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
    return 2 * $r * asin(min(1.0, sqrt($a)));
}

/**
 * Distance travelled along consecutive points, skipping jumps longer than $maxGapSeconds apart.
 *
 * @param array<int, array{ts:int, lat:float, lon:float}> $points sorted by ts ascending
 */
function track_distance_km(array $points, int $maxGapSeconds = 900): float
{
    $km = 0.0;
    for ($i = 1, $n = count($points); $i < $n; $i++) {
        $gap = $points[$i]['ts'] - $points[$i - 1]['ts'];
        if ($gap > 0 && $gap <= $maxGapSeconds) {
            $km += haversine_km($points[$i - 1]['lat'], $points[$i - 1]['lon'], $points[$i]['lat'], $points[$i]['lon']);
        }
    }
    return round($km, 3);
}
