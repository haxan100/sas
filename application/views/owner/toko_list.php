<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-list.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
.admin-sidebar, .admin-header, .bottom-nav { --tema: #6366f1; }
</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('owner/_sidebar', ['current_page' => 'toko_list']); ?>
<div class="admin-main">
<?php $this->load->view('owner/_header', ['page_title' => 'Daftar Toko', 'breadcrumb' => 'Semua toko yang terdaftar']); ?>
<main class="admin-content">
<?php if ($this->session->flashdata('sukses')): ?>
<div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;border-left:4px solid #10b981;"><?= $this->session->flashdata('sukses') ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<div class="toolbar">
<div class="toolbar-left">
<input type="text" id="searchInput" class="form-control search" placeholder="🔍 Cari toko...">
</div>
<button class="btn btn-primary desktop-only" onclick="openTokoModal()">+ Tambah Toko</button>
</div>

<div class="table-wrap desktop-only">
<table id="tableToko" class="table" style="width:100%">
<thead>
<tr>
<th width="50">ID</th>
<th>Toko</th>
<th>Pemilik</th>
<th>Slug</th>
<th>WhatsApp</th>
<th>Status</th>
<th>Order</th>
<th>Lihat</th>
<th width="100">Aksi</th>
</tr>
</thead>
<tbody></tbody>
</table>
</div>

<div class="mobile-cards" id="mobileToko">
<div class="mobile-cards-loading">⏳ Memuat toko...</div>
</div>
</div>
</div>
</main>

<button class="fab mobile-only" onclick="openTokoModal()">+</button>
<?php $this->load->view('toko/_bottom_nav', ['current_page' => 'toko_list']); ?>
</div>
</div>

<!-- Modal Tambah/Edit Toko -->
<div class="admin-modal" id="tokoModal">
<div class="admin-modal-content">
<div class="admin-modal-head">
<h3 id="tokoModalTitle">Tambah Toko</h3>
<button class="admin-modal-close" onclick="closeTokoModal()">✕</button>
</div>
<form id="tokoForm" enctype="multipart/form-data">
<div class="admin-modal-body">
<input type="hidden" name="id" id="tokoId">
<div class="modal-form-grid">
<div class="form-group">
<label class="form-label">Nama Toko *</label>
<input type="text" name="nama_toko" id="tNama" class="form-control" required>
</div>
<div class="form-group">
<label class="form-label">Pemilik *</label>
<input type="text" name="pemilik" id="tPemilik" class="form-control" required>
</div>
<div class="form-group">
<label class="form-label">Slug (URL) *</label>
<input type="text" name="slug" id="tSlug" class="form-control" required placeholder="contoh: mieayam">
</div>
<div class="form-group">
<label class="form-label">Kategori</label>
<input type="text" name="kategori" id="tKategori" class="form-control" value="Makanan">
</div>
<div class="form-group">
<label class="form-label">Username Login *</label>
<input type="text" name="username" id="tUsername" class="form-control" required>
</div>
<div class="form-group">
<label class="form-label">Password <span id="tPasswordLabel">*</span></label>
<input type="text" name="password" id="tPassword" class="form-control">
<small id="tPasswordHint" style="color:#6b7280;font-size:12px;">*Wajib untuk toko baru</small>
</div>
<div class="form-group">
<label class="form-label">No WhatsApp *</label>
<input type="text" name="no_wa" id="tWa" class="form-control" required placeholder="628xxx">
</div>
<div class="form-group" id="statusField" style="display:none;">
<label class="form-label">Status</label>
<select name="status" id="tStatus" class="form-control">
<option value="aktif">Aktif</option>
<option value="nonaktif">Nonaktif</option>
</select>
</div>
<div class="form-group" style="grid-column:span 2;">
<label class="form-label">Alamat</label>
<textarea name="alamat" id="tAlamat" class="form-control" rows="2"></textarea>
</div>
<div class="form-group">
<label class="form-label">Bank</label>
<input type="text" name="nama_bank" id="tBank" class="form-control" placeholder="BCA / BRI / Mandiri">
</div>
<div class="form-group">
<label class="form-label">No Rekening</label>
<input type="text" name="no_rek" id="tRek" class="form-control">
</div>
<div class="form-group" style="grid-column:span 2;">
<label class="form-label">Atas Nama (Rekening)</label>
<input type="text" name="atas_nama" id="tAtasNama" class="form-control">
</div>
<div class="form-group">
<label class="form-label">Warna Tema</label>
<input type="color" name="tema_warna" id="tWarna" value="#ff6b35" class="form-control" style="height:44px;width:80px;padding:2px;">
</div>
<div class="form-group">
<label class="form-label">Status</label>
<input type="file" name="logo" id="tLogo" class="form-control" accept="image/*">
<small id="tLogoHint" style="color:#6b7280;font-size:12px;display:block;margin-top:4px;">*Upload logo (opsional)</small>
</div>
</div>
</div>
<div class="admin-modal-foot">
<button type="button" class="btn btn-secondary" onclick="closeTokoModal()">Batal</button>
<button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
</div>
</form>
</div>
</div>

<div class="toast" id="toast"><span id="toastMsg"></span></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
<script>
const baseUrl = '<?= base_url() ?>';
let tableToko;

$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#tableToko')) {
        $('#tableToko').DataTable().destroy();
    }
    tableToko = $('#tableToko').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: baseUrl + 'owner/toko_ajax', type: 'GET' },
        columns: [
            { name: 'id' },
            { orderable: false, searchable: false },
            { name: 'pemilik' },
            { name: 'slug' },
            { name: 'no_wa' },
            { name: 'status' },
            { orderable: false, searchable: false },
            { orderable: false, searchable: false },
            { orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            processing: '<div style="padding:20px;color:#6b7280;">⏳ Memuat...</div>',
            emptyTable: '<div style="padding:30px;color:#9ca3af;">Belum ada toko</div>'
        },
        initComplete: function() {
            $('.dataTables_length label').contents().filter(function() {
                return this.nodeType === 3;
            }).replaceWith('Tampilkan ');
        },
        drawCallback: function() {
            renderMobileTokoCards();
        }
    });

    $('#searchInput').on('keyup', function() {
        tableToko.search(this.value).draw();
    });
});

function renderMobileTokoCards() {
    const container = document.getElementById('mobileToko');
    if (!container) return;
    const data = tableToko.rows({page: 'current'}).data();
    if (!data || data.length === 0) {
        container.innerHTML = '<div class="mobile-cards-loading">Belum ada toko</div>';
        return;
    }
    let html = '';
    data.each(function(row) {
        const [id, tokoHtml, pemilik, slug, wa, status, orders, lihat, aksi] = row;
        html += `<div class="card-list-item">
            <div class="img" style="background:linear-gradient(135deg, #6366f1, #4f46e5);color:#fff;">🏪</div>
            <div class="body">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:8px;">
                    <div>
                        <h4>${tokoHtml.replace(/<br>.*$/, '').replace(/<[^>]+>/g, '')}</h4>
                        <p>${pemilik} · <code>${slug}</code></p>
                    </div>
                </div>
                <div class="meta" style="margin-top:8px;">${status} ${orders}</div>
                <div style="margin-top:8px;display:flex;gap:6px;">${lihat} ${aksi}</div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
}

function openTokoModal() {
    document.getElementById('tokoModalTitle').textContent = 'Tambah Toko';
    document.getElementById('tokoForm').reset();
    document.getElementById('tokoId').value = '';
    document.getElementById('tPassword').required = true;
    document.getElementById('tPasswordLabel').textContent = '*';
    document.getElementById('tPasswordHint').textContent = '*Wajib untuk toko baru';
    document.getElementById('tWarna').value = '#ff6b35';
    document.getElementById('tLogoHint').textContent = '*Upload logo (opsional)';
    document.getElementById('statusField').style.display = 'none';
    document.getElementById('tokoModal').classList.add('show');
    setTimeout(() => document.getElementById('tNama').focus(), 100);
}

function closeTokoModal() {
    document.getElementById('tokoModal').classList.remove('show');
}

function editToko(id) {
    fetch(baseUrl + 'owner/toko_get/' + id)
        .then(r => r.json())
        .then(t => {
            if (!t || t.error) { toast('Toko tidak ditemukan', 'error'); return; }
            document.getElementById('tokoModalTitle').textContent = 'Edit Toko: ' + t.nama_toko;
            document.getElementById('tokoId').value = t.id;
            document.getElementById('tNama').value = t.nama_toko || '';
            document.getElementById('tPemilik').value = t.pemilik || '';
            document.getElementById('tSlug').value = t.slug || '';
            document.getElementById('tKategori').value = t.kategori || 'Makanan';
            document.getElementById('tUsername').value = t.username || '';
            document.getElementById('tPassword').value = '';
            document.getElementById('tPassword').required = false;
            document.getElementById('tPasswordLabel').textContent = '';
            document.getElementById('tPasswordHint').textContent = '*Kosongkan jika tidak diubah';
            document.getElementById('tWa').value = t.no_wa || '';
            document.getElementById('tAlamat').value = t.alamat || '';
            document.getElementById('tBank').value = t.nama_bank || '';
            document.getElementById('tRek').value = t.no_rek || '';
            document.getElementById('tAtasNama').value = t.atas_nama || '';
            document.getElementById('tWarna').value = t.tema_warna || '#ff6b35';
            document.getElementById('tStatus').value = t.status || 'aktif';
            document.getElementById('tLogoHint').textContent = '*Kosongkan jika tidak ingin ganti. File: ' + (t.logo || 'tidak ada');
            document.getElementById('statusField').style.display = 'block';
            document.getElementById('tokoModal').classList.add('show');
        });
}

function hapusToko(id) {
    if (!confirm('Hapus toko ini? Semua produk & orderan akan ikut terhapus.')) return;
    fetch(baseUrl + 'owner/toko_hapus/' + id, { method: 'POST' })
        .then(r => r.json())
        .then(data => {
            toast(data.message, data.status);
            if (data.status === 'ok') tableToko.ajax.reload();
        });
}

document.getElementById('tokoForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const btn = document.getElementById('btnSimpan');
    btn.disabled = true; btn.textContent = '⏳ Menyimpan...';
    fetch(baseUrl + 'owner/toko_save', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false; btn.textContent = 'Simpan';
            if (data.status === 'ok') {
                toast(data.message, 'success');
                closeTokoModal();
                tableToko.ajax.reload();
            } else {
                toast(data.message, 'error');
            }
        })
        .catch(err => {
            btn.disabled = false; btn.textContent = 'Simpan';
            toast('Error: ' + err, 'error');
        });
});
</script>
</body>
</html>
