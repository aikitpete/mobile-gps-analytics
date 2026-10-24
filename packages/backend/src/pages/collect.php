<?php $head = '<script src="js/collect.js" defer></script>'; ?>
<h2>Collect</h2>
<p>Keep this page open while you move. Each sample sends position and battery level to the server.</p>
<div class="stack narrow">
    <label>Sampling interval
        <select id="interval">
            <option value="5000">5 seconds</option>
            <option value="10000">10 seconds</option>
            <option value="20000" selected>20 seconds</option>
            <option value="60000">60 seconds</option>
        </select>
    </label>
    <div>
        <button id="toggle" type="button">Start tracking</button>
    </div>
</div>
<dl class="readout">
    <dt>Status</dt><dd id="status">Idle</dd>
    <dt>Latitude</dt><dd id="latitude">–</dd>
    <dt>Longitude</dt><dd id="longitude">–</dd>
    <dt>Accuracy (m)</dt><dd id="accuracy">–</dd>
    <dt>Battery</dt><dd id="battery">–</dd>
    <dt>Samples sent</dt><dd id="count">0</dd>
</dl>
<p class="hint">Battery readings need a browser that exposes the Battery Status API (Chromium-based browsers). Without it, positions are still recorded.</p>
