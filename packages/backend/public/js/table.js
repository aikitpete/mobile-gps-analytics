(function () {
    'use strict';

    var csrf = document.body.dataset.csrf;
    var host = document.getElementById('data');
    var state = { page: 1, limit: 20, sortKey: null, sortDir: 1 };
    var COLUMNS = ['id', 'uid', 'latitude', 'longitude', 'altitude', 'accuracy', 'battery_supported', 'battery_level', 'battery_charging', 'notes', 'recorded_at'];

    function el(tag, text, attrs) {
        var node = document.createElement(tag);
        if (text !== undefined && text !== null) { node.textContent = text; }
        Object.keys(attrs || {}).forEach(function (k) { node.setAttribute(k, attrs[k]); });
        return node;
    }

    function pager(meta) {
        var bar = el('div', null, { 'class': 'pager' });
        var prev = el('button', 'Previous', { type: 'button' });
        var next = el('button', 'Next', { type: 'button' });
        prev.disabled = meta.page <= 1;
        next.disabled = meta.page >= meta.pages;
        prev.addEventListener('click', function () { state.page -= 1; load(); });
        next.addEventListener('click', function () { state.page += 1; load(); });
        bar.append(prev, el('span', 'Page ' + meta.page + ' of ' + meta.pages + ' (' + meta.total + ' rows)'), next);
        return bar;
    }

    function render(data) {
        var rows = data.rows.slice();
        if (state.sortKey) {
            rows.sort(function (a, b) {
                var x = a[state.sortKey], y = b[state.sortKey];
                if (x === y) { return 0; }
                if (x === null) { return 1; }
                if (y === null) { return -1; }
                return (isNaN(x) || isNaN(y) ? String(x).localeCompare(String(y)) : Number(x) - Number(y)) * state.sortDir;
            });
        }
        var table = el('table', null, { 'class': 'grid' });
        var head = el('tr');
        if (data.can_delete) { head.append(el('th', '')); }
        COLUMNS.forEach(function (c) {
            var th = el('th', c, { tabindex: '0', role: 'button' });
            var sort = function () {
                state.sortDir = state.sortKey === c ? -state.sortDir : 1;
                state.sortKey = c;
                render(data);
            };
            th.addEventListener('click', sort);
            th.addEventListener('keydown', function (ev) { if (ev.key === 'Enter') { sort(); } });
            head.append(th);
        });
        var thead = el('thead');
        thead.append(head);
        table.append(thead);
        var body = el('tbody');
        rows.forEach(function (row) {
            var tr = el('tr');
            if (data.can_delete) {
                var cell = el('td');
                var del = el('button', 'Delete', { type: 'button' });
                del.addEventListener('click', function () { remove(row.id); });
                cell.append(del);
                tr.append(cell);
            }
            COLUMNS.forEach(function (c) { tr.append(el('td', row[c] === null ? '' : row[c])); });
            body.append(tr);
        });
        table.append(body);
        host.replaceChildren(pager(data.meta), table, pager(data.meta));
        host.dataset.loading = '';
    }

    function load() {
        fetch('api.php?action=list&limit=' + state.limit + '&page=' + state.page, { credentials: 'same-origin' })
            .then(function (r) { return r.json(); })
            .then(render)
            .catch(function () { host.textContent = 'Could not load data.'; });
    }

    function remove(id) {
        if (!window.confirm('Delete record ' + id + '?')) { return; }
        fetch('api.php?action=delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf },
            credentials: 'same-origin',
            body: JSON.stringify({ id: id })
        }).then(load);
    }

    load();
})();
