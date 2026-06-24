<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?> · <?= htmlspecialchars($toko->nama_toko) ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-list.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<?php $this->load->view('toko/_tema', ['toko' => $toko]); ?>
<style>
.detail-section { margin-bottom: 20px; }
.detail-section h4 { font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f3f4f6; font-weight: 700; }
.detail-row { display: flex; padding: 5px 0; font-size: 14px; gap: 8px; }
.detail-row .label { width: 120px; color: #6b7280; flex-shrink: 0; font-size: 13px; }
.detail-row .value { color: #111; font-weight: 500; flex: 1; }
.item-table { width: 100%; border-collapse: collapse; }
.item-table th, .item-table td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #f3f4f6; }
.item-table th { background: #fafafa; text-align: left; font-weight: 600; color: #6b7280; font-size: 12px; }
.catatan-item { background: #fef3c7; padding: 6px 10px; border-radius: 6px; font-size: 12px; color: #92400e; margin-top: 4px; }
</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('toko/_sidebar', ['toko' => $toko, 'current_page' => 'orders']); ?>
<div class="admin-main">
<?php $this->load->view('toko/_header', ['toko' => $toko, 'current_page' => 'orders', 'page_title' => 'Orderan', 'breadcrumb' => 'Semua pesanan masuk']); ?>
<main class="admin-content">
<div class="card">
<div class="card-body">
<div class="toolbar">
<input type="text" id="searchInput" class="form-control search" placeholder="🔍 Cari kode/nama/block...">
</div>

<div class="table-wrap desktop-only">
<table id="tableOrders" class="table hide-col-mobile" style="width:100%">
<thead>
<tr>
<th width="60">ID</th>
<th>Kode</th>
<th>Pembeli</th>
<th>Total</th>
<th>Bayar</th>
<th>Status Bayar</th>
<th>Status Order</th>
<th>Tanggal</th>
<th width="80">Aksi</th>
</tr>
</thead>
<tbody></tbody>
</table>
</div>

<div class="mobile-cards" id="mobileOrders">
<div class="mobile-cards-loading">⏳ Memuat pesanan...</div>
</div>
</div>
</div>
</main>
<?php $this->load->view('toko/_bottom_nav', ['current_page' => 'orders']); ?>
<?php $this->load->view('toko/_footer'); ?>
</div>
</div>

<!-- Modal Detail -->
<div class="admin-modal" id="orderModal">
<div class="admin-modal-content lg">
<div class="admin-modal-head">
<h3>Detail Order <span id="orderKode" style="color:#3b82f6;"></span></h3>
<button class="admin-modal-close" onclick="closeOrderModal()">✕</button>
</div>
<div class="admin-modal-body" id="orderBody">
<div style="text-align:center;padding:40px;color:#9ca3af;">⏳ Memuat...</div>
</div>
<div class="admin-modal-foot">
<button class="btn btn-secondary" onclick="closeOrderModal()">Tutup</button>
</div>
</div>
</div>

<div class="toast" id="toast"><span id="toastMsg"></span></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
const SLUG = '';
const baseUrl = '<?= base_url() ?>';
let tableOrders;

function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('show');
    document.getElementById('adminOverlay').classList.toggle('show');
}

$(document).ready(function() {
    tableOrders = $('#tableOrders').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: baseUrl + '/admin/orders_ajax', type: 'GET' },
        columns: [
            { name: 'orders.id' },
            { name: 'orders.kode_order' },
            { name: 'orders.nama_pembeli' },
            { name: 'orders.total_harga' },
            { name: 'orders.metode_bayar' },
            { name: 'orders.status_bayar' },
            { name: 'orders.status_order' },
            { name: 'orders.created_at' },
            { orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            processing: '<div style="padding:20px;color:#6b7280;">⏳ Memuat data...</div>',
            emptyTable: '<div style="padding:30px;color:#9ca3af;">Belum ada orderan</div>'
        },
        initComplete: function() {
            $('.dataTables_length label').contents().filter(function() {
                return this.nodeType === 3;
            }).replaceWith('Tampilkan ');
        }
    });

    $('#searchInput').on('keyup', function() {
        tableOrders.search(this.value).draw();
    });

    // Mobile cards: render rows as cards
    tableOrders.on('draw', function() {
        renderMobileCards();
    });
});

let allOrdersData = [];
function renderMobileCards() {
    const container = document.getElementById('mobileOrders');
    if (!container) return;
    // Fetch current page data via DataTable rows
    const data = tableOrders.rows({page: 'current'}).data();
    if (!data || data.length === 0) {
        container.innerHTML = '<div class="mobile-cards-loading">Belum ada orderan</div>';
        return;
    }
    let html = '';
    data.each(function(row) {
        const [id, kode, pembeli, total, bayar, statusBayar, statusOrder, tanggal, aksi] = row;
        html += `<div class="card-list-item">
            <div class="body">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:8px;">
                    <div>
                        <h4>${kode}</h4>
                        <p>${pembeli}</p>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <div class="price" style="color:var(--tema);font-weight:700;">${total}</div>
                        <small style="color:#9ca3af;font-size:11px;">${tanggal}</small>
                    </div>
                </div>
                <div class="meta">
                    ${bayar} ${statusBayar} ${statusOrder}
                </div>
                <div style="margin-top:8px;">
                    <button class="btn btn-secondary btn-sm" onclick="viewOrder(${id})">👁️ Detail</button>
                </div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
}

function viewOrder(id) {
    document.getElementById('orderModal').classList.add('show');
    document.getElementById('orderBody').innerHTML = '<div style="text-align:center;padding:40px;color:#9ca3af;">⏳ Memuat...</div>';
    fetch(baseUrl + '/admin/order_get/' + id)
        .then(r => r.json())
        .then(data => renderOrder(data));
}

function renderOrder(data) {
    const o = data.order, items = data.items;
    document.getElementById('orderKode').textContent = o.kode_order;
    let itemsHtml = '<table class="item-table"><thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th style="text-align:right;">Subtotal</th></tr></thead><tbody>';
    items.forEach(it => {
        itemsHtml += `<tr>
            <td><strong>${escapeHtml(it.nama_produk)}</strong>${it.catatan ? `<div class="catatan-item">📝 ${escapeHtml(it.catatan)}</div>` : ''}</td>
            <td>Rp ${formatRupiah(it.harga)}</td>
            <td>${it.qty}</td>
            <td style="text-align:right;font-weight:600;">Rp ${formatRupiah(it.subtotal)}</td>
        </tr>`;
    });
    itemsHtml += `<tr><td colspan="3" style="text-align:right;font-weight:700;color:#111;">TOTAL</td><td style="text-align:right;font-weight:700;color:#ef4444;font-size:16px;">Rp ${formatRupiah(o.total_harga)}</td></tr>`;
    itemsHtml += '</tbody></table>';

    document.getElementById('orderBody').innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1.4fr;gap:24px;">
        <div>
            <div class="detail-section">
                <h4>👤 Pembeli</h4>
                <div class="detail-row"><div class="label">Nama</div><div class="value">${escapeHtml(o.nama_pembeli)}</div></div>
                <div class="detail-row"><div class="label">Blok</div><div class="value">${escapeHtml(o.blok_rumah)}</div></div>
                <div class="detail-row"><div class="label">WhatsApp</div><div class="value">${o.no_wa_pembeli || '-'}</div></div>
            </div>
            <div class="detail-section">
                <h4>💳 Pembayaran</h4>
                <div class="detail-row"><div class="label">Metode</div><div class="value">${o.metode_bayar.toUpperCase()}</div></div>
                <div class="detail-row"><div class="label">Status Bayar</div><div class="value">${o.status_bayar}</div></div>
            </div>
            <div class="detail-section">
                <h4>📅 Info</h4>
                <div class="detail-row"><div class="label">Tanggal</div><div class="value">${formatDate(o.created_at)}</div></div>
            </div>
            ${o.catatan ? `<div class="detail-section"><h4>📝 Catatan Umum</h4><div style="background:#fef3c7;padding:10px 14px;border-radius:8px;color:#92400e;font-size:13px;">${escapeHtml(o.catatan)}</div></div>` : ''}
        </div>
        <div>
            <div class="detail-section">
                <h4>🍜 Item Pesanan</h4>
                ${itemsHtml}
            </div>
        </div>
        </div>
        <div class="detail-section" style="background:#fafafa;padding:18px;border-radius:10px;margin-top:16px;border:1px solid #f3f4f6;">
            <h4 style="margin-bottom:12px;">🔄 Update Status</h4>
            <form id="updateOrderForm" style="display:flex;gap:10px;align-items:end;flex-wrap:wrap;">
                <div class="form-group" style="margin:0;flex:1;min-width:140px;">
                    <label class="form-label">Status Order</label>
                    <select name="status_order" class="form-control">
                        <option value="baru" ${o.status_order=='baru'?'selected':''}>Baru</option>
                        <option value="diproses" ${o.status_order=='diproses'?'selected':''}>Diproses</option>
                        <option value="selesai" ${o.status_order=='selesai'?'selected':''}>Selesai</option>
                        <option value="batal" ${o.status_order=='batal'?'selected':''}>Batal</option>
                    </select>
                </div>
                <div class="form-group" style="margin:0;flex:1;min-width:140px;">
                    <label class="form-label">Status Bayar</label>
                    <select name="status_bayar" class="form-control">
                        <option value="belum" ${o.status_bayar=='belum'?'selected':''}>Belum Lunas</option>
                        <option value="lunas" ${o.status_bayar=='lunas'?'selected':''}>Lunas</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    `;

    document.getElementById('updateOrderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const statusOrder = document.querySelector('[name="status_order"]').value;
    const statusBayar = document.querySelector('[name="status_bayar"]').value;
    const isComplete = statusOrder === 'selesai';
    const isCancel = statusOrder === 'batal';
    const isPaid = statusBayar === 'lunas';

    let confirmMsg = '';
    if (isComplete) confirmMsg = 'Tandai pesanan ini sebagai SELESAI?';
    else if (isCancel) confirmMsg = 'Batalkan pesanan ini?';
    else confirmMsg = 'Update status pesanan?';

    const iconType = isComplete ? 'success' : (isCancel ? 'warning' : 'question');
    const confirmBtn = isComplete ? 'Ya, Selesaikan' : (isCancel ? 'Ya, Batalkan' : 'Ya, Update');

    Swal.fire({
        icon: iconType,
        title: 'Konfirmasi',
        text: confirmMsg,
        showCancelButton: true,
        confirmButtonText: confirmBtn,
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) return;

        const fd = new FormData();
        fd.append('status_order', statusOrder);
        fd.append('status_bayar', statusBayar);

        fetch(baseUrl + '/admin/order_update/' + o.id, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, confirmButtonText: 'OK' }).then(() => {
                        tableOrders.ajax.reload();
                        viewOrder(o.id);
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Unknown error', confirmButtonText: 'OK' });
                }
            })
            .catch(err => Swal.fire({ icon: 'error', title: 'Error', text: 'Error: ' + err, confirmButtonText: 'OK' }));
    });
});
}

function closeOrderModal() {
    document.getElementById('orderModal').classList.remove('show');
}

function escapeHtml(s) { if (!s) return ''; return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c]); }
function formatRupiah(n) { return parseInt(n).toLocaleString('id-ID'); }
function formatDate(s) { return new Date(s).toLocaleString('id-ID', {day:'2-digit',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'}); }

function quickUpdateOrder(id, status) {
    const statusLabels = { 'baru': 'Baru', 'diproses': 'Diproses', 'selesai': 'Selesai', 'batal': 'Batal' };
    const messages = {
        'diproses': 'Tandai pesanan ini sebagai DIPROSES?',
        'selesai': 'Tandai pesanan ini sebagai SELESAI?',
        'batal': 'Batalkan pesanan ini?',
        'baru': 'Kembalikan pesanan ke status BARU?'
    };
    const icons = { 'selesai': 'success', 'diproses': 'info', 'batal': 'warning', 'baru': 'question' };
    const confirmBtns = { 'selesai': 'Ya, Selesaikan', 'diproses': 'Ya, Proses', 'batal': 'Ya, Batalkan', 'baru': 'Ya, Kembalikan' };

    Swal.fire({
        icon: icons[status],
        title: 'Konfirmasi',
        text: messages[status],
        showCancelButton: true,
        confirmButtonText: confirmBtns[status],
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) return;

        const fd = new FormData();
        fd.append('status_order', status);
        fd.append('status_bayar', document.querySelector('#orderBody [name="status_bayar"]') ? document.querySelector('#orderBody [name="status_bayar"]').value : '');

        fetch(baseUrl + '/admin/order_quick_update/' + id + '?status=' + status)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, confirmButtonText: 'OK' }).then(() => {
                        tableOrders.ajax.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Unknown error', confirmButtonText: 'OK' });
                }
            })
            .catch(err => Swal.fire({ icon: 'error', title: 'Error', text: 'Error: ' + err, confirmButtonText: 'OK' }));
    });
}
</script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>
</html>
