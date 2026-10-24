(function () {
    'use strict';

    var csrf = document.body.dataset.csrf;
    var $ = function (id) { return document.getElementById(id); };
    var timer = null;
    var sent = 0;
    var battery = null;

    function setStatus(text) { $('status').textContent = text; }

    function readBattery() {
        if (typeof navigator.getBattery !== 'function') { return Promise.resolve(); }
        return navigator.getBattery().then(function (b) { battery = b; }).catch(function () { battery = null; });
    }

    function send(payload) {
        return fetch('api.php?action=collect', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf },
            credentials: 'same-origin',
            body: JSON.stringify(payload)
        }).then(function (res) {
            if (!res.ok) { throw new Error('Server answered ' + res.status); }
            sent += 1;
            $('count').textContent = String(sent);
        });
    }

    function sample() {
        navigator.geolocation.getCurrentPosition(function (pos) {
            var c = pos.coords;
            var payload = {
                latitude: c.latitude,
                longitude: c.longitude,
                accuracy: c.accuracy,
                altitude: c.altitude,
                battery_supported: battery !== null,
                battery_level: battery ? battery.level : null,
                battery_charging: battery ? battery.charging : null,
                notes: navigator.userAgent
            };
            $('latitude').textContent = c.latitude.toFixed(6);
            $('longitude').textContent = c.longitude.toFixed(6);
            $('accuracy').textContent = Math.round(c.accuracy);
            $('battery').textContent = battery
                ? Math.round(battery.level * 100) + '%' + (battery.charging ? ' (charging)' : '')
                : 'not available';
            send(payload).then(function () { setStatus('Tracking'); })
                .catch(function (err) { setStatus('Could not send sample: ' + err.message); });
        }, function (err) {
            setStatus('Location unavailable: ' + err.message);
        }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
    }

    function start() {
        if (!navigator.geolocation) { setStatus('Geolocation is not supported by this browser.'); return; }
        readBattery().then(function () {
            sample();
            timer = setInterval(sample, parseInt($('interval').value, 10));
            $('toggle').textContent = 'Stop tracking';
            $('interval').disabled = true;
            setStatus('Tracking');
        });
    }

    function stop() {
        clearInterval(timer);
        timer = null;
        $('toggle').textContent = 'Start tracking';
        $('interval').disabled = false;
        setStatus('Idle');
    }

    $('toggle').addEventListener('click', function () { timer === null ? start() : stop(); });
})();
