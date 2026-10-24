(function () {
    'use strict';

    var COLORS = ['#d62728', '#1f77b4', '#2ca02c', '#9467bd', '#ff7f0e', '#17becf', '#8c564b', '#e377c2'];
    var map = L.map('map').setView([55.7039, 13.1935], 13);
    var layer = L.layerGroup().addTo(map);
    var boxes = [];

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    function draw() {
        layer.clearLayers();
        var all = [];
        var pending = boxes.filter(function (b) { return b.input.checked; });
        Promise.all(pending.map(function (b) {
            return fetch('api.php?action=locations&uid=' + encodeURIComponent(b.uid), { credentials: 'same-origin' })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    (data.locations || []).forEach(function (p) {
                        L.circleMarker(p, { radius: 4, color: b.color, weight: 1, fillOpacity: 0.7 }).addTo(layer);
                        all.push(p);
                    });
                });
        })).then(function () {
            if (all.length) { map.fitBounds(L.latLngBounds(all), { padding: [20, 20], maxZoom: 17 }); }
        });
    }

    fetch('api.php?action=users', { credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            var host = document.getElementById('users');
            host.textContent = '';
            (data.users || []).forEach(function (u, i) {
                var label = document.createElement('label');
                var input = document.createElement('input');
                var swatch = document.createElement('span');
                var color = COLORS[i % COLORS.length];
                input.type = 'checkbox';
                input.checked = true;
                input.addEventListener('change', draw);
                swatch.className = 'swatch';
                swatch.style.background = color;
                label.append(input, swatch, document.createTextNode(' ' + u.name + ' ' + u.surname));
                host.append(label);
                boxes.push({ uid: u.uid, input: input, color: color });
            });
            if (!boxes.length) { host.textContent = 'No users.'; }
            draw();
        });
})();
