<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { 
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #f5f7fa;
    min-height: 100vh;
}
.container { max-width: 1400px; margin: 0 auto; padding: 20px; }

.header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 30px;
    border-radius: 16px;
    margin-bottom: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header h1 { font-size: 28px; font-weight: 700; }
.header p { opacity: 0.9; margin-top: 4px; }
.header-actions { display: flex; gap: 12px; }
.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    border: none;
    cursor: pointer;
    font-size: 14px;
}
.btn-primary { background: #fff; color: #667eea; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,.2); }
.btn-secondary { background: rgba(255,255,255,.2); color: #fff; }
.btn-secondary:hover { background: rgba(255,255,255,.3); }

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.stat-card .icon { font-size: 32px; margin-bottom: 8px; }
.stat-card .value { font-size: 28px; font-weight: 700; color: #1a1a1a; }
.stat-card .label { color: #666; font-size: 14px; }

.filters-card {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    margin-bottom: 24px;
}
.filters-title { font-weight: 600; margin-bottom: 16px; color: #333; }
.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
}
.filter-group label { display: block; font-size: 13px; color: #666; margin-bottom: 6px; }
.filter-group input, .filter-group select {
    width: 100%;
    padding: 10px 12px;
    border: 2px solid #e8e8e8;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color .2s;
}
.filter-group input:focus, .filter-group select:focus {
    outline: none;
    border-color: #667eea;
}
.filter-actions {
    display: flex;
    gap: 8px;
    align-items: flex-end;
}

.logs-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    overflow: hidden;
}

#logs-table {
    width: 100%;
    border-collapse: collapse;
}
#logs-table thead {
    background: #f8f9fa;
    position: sticky;
    top: 0;
}
#logs-table th {
    padding: 16px;
    text-align: left;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #e8e8e8;
    font-size: 14px;
}
#logs-table td {
    padding: 16px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: top;
}
#logs-table tr:hover { background: #fafafa; }

.log-row { width: 100%; }
.log-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 8px;
}
.log-info { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.log-user-type {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.log-user-type.owner { background: #fee2e2; color: #991b1b; }
.log-user-type.admin { background: #dbeafe; color: #1e40af; }
.log-user-type.customer { background: #d1fae5; color: #065f46; }
.log-toko { color: #666; font-size: 13px; }
.log-time { color: #888; font-size: 13px; }
.log-body { }
.log-action { margin-bottom: 6px; display: flex; gap: 8px; align-items: center; }
.log-module {
    background: #f0f0f0;
    padding: 3px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    color: #555;
}
.log-action-text { font-weight: 600; color: #333; font-size: 14px; }
.log-description { color: #555; font-size: 14px; line-height: 1.5; }
.log-details { margin-top: 10px; padding: 12px; background: #f8f9fa; border-radius: 8px; }
.log-diff pre {
    font-size: 11px;
    background: #fff;
    padding: 8px;
    border-radius: 4px;
    margin: 4px 0;
    overflow-x: auto;
    max-width: 500px;
}
.log-meta { margin-top: 8px; }
.log-meta small { color: #aaa; }

.dataTables_wrapper .dataTables_paginate { padding: 16px; }
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 8px 16px;
    margin: 0 2px;
    border-radius: 6px;
    background: #f0f0f0;
    cursor: pointer;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #667eea;
    color: #fff;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #667eea;
    color: #fff;
}

.no-data {
    text-align: center;
    padding: 60px 20px;
    color: #888;
}
.no-data .icon { font-size: 48px; margin-bottom: 16px; }

@media (max-width: 768px) {
    .header { flex-direction: column; gap: 16px; text-align: center; }
    .filters-grid { grid-template-columns: 1fr; }
    .stats-grid { grid-template-columns: 1fr 1fr; }
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container">
<div class="header">
    <div>
        <h1>📋 Activity Logs</h1>
        <p>Monitoring semua aktivitas sistem</p>
    </div>
    <div class="header-actions">
        <a href="<?= base_url('owner/dashboard') ?>" class="btn btn-secondary">← Dashboard</a>
        <a href="<?= base_url('logs/export_csv') ?>" class="btn btn-primary">📥 Export CSV</a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="icon">📊</div>
        <div class="value" id="stat-total">-</div>
        <div class="label">Total Logs</div>
    </div>
    <div class="stat-card">
        <div class="icon">👑</div>
        <div class="value" id="stat-owner">-</div>
        <div class="label">Owner Actions</div>
    </div>
    <div class="stat-card">
        <div class="icon">🏪</div>
        <div class="value" id="stat-admin">-</div>
        <div class="label">Admin Actions</div>
    </div>
    <div class="stat-card">
        <div class="icon">👤</div>
        <div class="value" id="stat-customer">-</div>
        <div class="label">Customer Actions</div>
    </div>
</div>

<div class="filters-card">
    <div class="filters-title">🔍 Filter Logs</div>
    <form id="filter-form">
    <div class="filters-grid">
        <div class="filter-group">
            <label>User Type</label>
            <select id="filter-user-type" name="user_type">
                <option value="">Semua</option>
                <option value="owner">Owner</option>
                <option value="admin">Admin</option>
                <option value="customer">Customer</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Toko</label>
            <select id="filter-toko" name="toko_id">
                <option value="">Semua Toko</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Module</label>
            <select id="filter-module" name="module">
                <option value="">Semua Module</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Action</label>
            <select id="filter-action" name="action">
                <option value="">Semua Action</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Dari Tanggal</label>
            <input type="date" id="filter-date-from" name="date_from">
        </div>
        <div class="filter-group">
            <label>Sampai Tanggal</label>
            <input type="date" id="filter-date-to" name="date_to">
        </div>
    </div>
    </form>
</div>

<div class="logs-card">
    <table id="logs-table">
        <thead>
            <tr>
                <th style="width:60px;">ID</th>
                <th>Detail Aktivitas</th>
                <th style="width:100px;">Module</th>
                <th style="width:120px;">Action</th>
                <th style="width:100px;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#logs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url('logs/get_logs') ?>',
            type: 'GET',
            data: function(d) {
                d.user_type = $('#filter-user-type').val();
                d.toko_id = $('#filter-toko').val();
                d.module = $('#filter-module').val();
                d.action = $('#filter-action').val();
                d.date_from = $('#filter-date-from').val();
                d.date_to = $('#filter-date-to').val();
            }
        },
        columns: [
            { data: 0 },
            { data: 1 },
            { data: 2, visible: false },
            { data: 3, visible: false },
            { data: 4, visible: false }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        language: {
            processing: '<div style="padding:20px;text-align:center;">Memuat data...</div>',
            emptyTable: '<div class="no-data"><div class="icon">📭</div><div>Belum ada aktivitas tercatat</div></div>'
        }
    });

    loadStats();
    loadFilters();

    $('#filter-user-type, #filter-toko, #filter-module, #filter-action, #filter-date-from, #filter-date-to').on('change', function() {
        table.ajax.reload();
    });

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
});

function loadStats() {
    $.get('<?= base_url('logs/stats') ?>', function(data) {
        $('#stat-total').text(data.total.toLocaleString());
        data.by_type.forEach(function(item) {
            if (item.user_type === 'owner') $('#stat-owner').text(item.count.toLocaleString());
            if (item.user_type === 'admin') $('#stat-admin').text(item.count.toLocaleString());
            if (item.user_type === 'customer') $('#stat-customer').text(item.count.toLocaleString());
        });
    });
}

function loadFilters() {
    $.get('<?= base_url('logs/filters') ?>', function(data) {
        data.toko_list.forEach(function(item) {
            $('#filter-toko').append('<option value="' + item.toko_id + '">' + item.toko_name + '</option>');
        });
        data.actions.forEach(function(item) {
            $('#filter-action').append('<option value="' + item.action + '">' + item.action + '</option>');
        });
        data.modules.forEach(function(item) {
            $('#filter-module').append('<option value="' + item.module + '">' + item.module + '</option>');
        });
    });
}
</script>
</body>
</html>
