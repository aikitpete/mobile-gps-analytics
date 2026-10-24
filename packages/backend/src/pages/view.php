<?php
$head = '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">'
    . '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>'
    . '<script src="js/view.js" defer></script>';
?>
<h2>Map</h2>
<div class="split">
    <div id="map" role="img" aria-label="Map of recorded positions"></div>
    <aside>
        <h3>Users</h3>
        <div id="users">Loading…</div>
    </aside>
</div>
