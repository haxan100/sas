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
/* Datatables style disamakan dengan kategori_list.php */
.produk-page .dataTables_filter { display: none; }
.produk-page table.dataTable { border-collapse: collapse !important; width: 100% !important; margin-top: 15px !important; }
.produk-page table.dataTable thead th { background-color: #1e293b; color: white !important; padding: 12px 15px !important; font-weight: 600; border-bottom: none !important; }
.produk-page table.dataTable thead th:first-child { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
.produk-page table.dataTable thead th:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }
.produk-page table.dataTable tbody td { padding: 12px 15px !important; vertical-align: middle; border-bottom: 1px solid #e5e7eb; }
.produk-page table.dataTable tbody tr:hover { background-color: #f8fafc; }
.produk-page .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
.produk-page .bottom { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #f3f4f6; }
.produk-page .dataTables_info { color: #6b7280; font-size: 14px; margin: 0; padding: 0 !important; }
.produk-page .dataTables_paginate ul.pagination { display: flex; padding-left: 0; list-style: none !important; margin: 0; border-radius: 4px; }
.produk-page .dataTables_paginate ul.pagination li { list-style: none !important; margin: 0; padding: 0; }
.produk-page .dataTables_paginate ul.pagination li .page-link { position: relative; display: block; padding: 6px 14px; margin-left: -1px; font-size: 14px; color: #4f46e5; background-color: #fff; border: 1px solid #d1d5db; text-decoration: none; transition: background-color 0.2s; }
.produk-page .dataTables_paginate ul.pagination li .page-link:hover { z-index: 2; background-color: #f3f4f6; color: #3730a3; }
.produk-page .dataTables_paginate ul.pagination li.active .page-link { z-index: 3; color: #fff !important; background-color: #2563eb !important; border-color: #2563eb !important; }
.produk-page .dataTables_paginate ul.pagination li.disabled .page-link { color: #9ca3af; pointer-events: none; background-color: #f9fafb; border-color: #d1d5db; }
.produk-page .dataTables_paginate ul.pagination li:first-child .page-link { border-top-left-radius: 6px; border-bottom-left-radius: 6px; }
.produk-page .dataTables_paginate ul.pagination li:last-child .page-link { border-top-right-radius: 6px; border-bottom-right-radius: 6px; }
.produk-page .bulk-toolbar { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; padding: 10px 12px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; }
.produk-page .bulk-toolbar .bulk-info { color: #6b7280; font-size: 13px; margin-right: auto; }
.produk-page .produk-check,
.produk-page #checkAllProduk { width: 16px; height: 16px; cursor: pointer; }

@media(max-width: 700px) {
  .produk-page .toolbar { flex-direction: column; align-items: stretch; }
  .produk-page .toolbar-left { width: 100%; flex-direction: column; align-items: stretch; }
  .produk-page .toolbar input.search { max-width: 100%; }
  .produk-page .filter-pills-wrap { display: flex; gap: 6px; overflow-x: auto; padding-bottom: 4px; }
  .produk-page .filter-pill { flex: 0 0 auto; }
  .produk-page .bulk-toolbar { align-items: stretch; flex-direction: column; }
  .produk-page .bulk-toolbar .bulk-info { margin-right: 0; }
  .produk-page .bulk-toolbar .btn { width: 100%; justify-content: center; }
  .produk-page .dataTables_wrapper { display: block !important; padding: 0 !important; }
  .produk-page .produk-table-wrap { display: block !important; }
  .produk-page #tableProduk { display: table !important; min-width: 820px; width: 820px !important; }
  .produk-page #tableProduk thead,
  .produk-page #tableProduk tbody,
  .produk-page #tableProduk tr,
  .produk-page #tableProduk th,
  .produk-page #tableProduk td { display: revert !important; }
  .produk-page #tableProduk th,
  .produk-page #tableProduk td { white-space: nowrap; }
  .produk-page .bottom { flex-direction: column; align-items: flex-start; gap: 12px; }
  .produk-page .dataTables_paginate ul.pagination { flex-wrap: wrap; }
  .produk-page .modal-form-grid { grid-template-columns: 1fr; }
  .produk-page .modal-form-grid .full { grid-column: span 1; }
}

@media(min-width: 701px) {
  .produk-page .mobile-cards { display: none !important; }
}
</style>
</head>
<body class="admin-body produk-page">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('toko/_sidebar', ['toko' => $toko, 'current_page' => 'produk']); ?>
<div class="admin-main">
<?php $this->load->view('toko/_header', ['toko' => $toko, 'current_page' => 'produk', 'page_title' => 'Produk', 'breadcrumb' => 'Manajemen menu & harga']); ?>
<main class="admin-content">
<?php if ($this->session->flashdata('sukses')): ?>
<div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;border-left:4px solid #10b981;"><?= $this->session->flashdata('sukses') ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<div class="toolbar">
<div class="toolbar-left">
<input type="text" id="searchInput" class="form-control search" placeholder="🔍 Cari produk...">
<?php if (!empty($kategori)): ?>
<div class="filter-pills-wrap">
<?php foreach ($kategori as $k): ?>
<span class="filter-pill" data-cat="<?= htmlspecialchars($k->nama) ?>" onclick="filterCat('<?= htmlspecialchars($k->nama, ENT_QUOTES) ?>', this)"><?= htmlspecialchars($k->nama) ?><span class="count"><?= $k->jumlah_produk ?></span></span>
<?php endforeach; ?>
<span class="filter-pill" data-cat="" onclick="filterCat('', this)">Semua</span>
</div>
<?php endif; ?>
</div>
<button class="btn btn-primary desktop-only" onclick="openProdukModal()">+ Tambah Produk</button>
</div>

<div class="bulk-toolbar">
<span class="bulk-info" id="bulkInfo">0 produk dipilih</span>
<button type="button" class="btn btn-secondary btn-sm" onclick="checkAllProduk()">Ceklis All</button>
<button type="button" class="btn btn-secondary btn-sm" onclick="uncheckAllProduk()">Uncek All</button>
<button type="button" class="btn btn-warn btn-sm" onclick="bulkProdukAction('habis')">Tidak Tersedia</button>
<button type="button" class="btn btn-danger btn-sm" onclick="bulkProdukAction('delete')">Hapus</button>
</div>

<div class="table-responsive produk-table-wrap">
<table id="tableProduk" class="table" style="width:100%">
<thead>
<tr>
<th width="40"><input type="checkbox" id="checkAllProduk" title="Pilih semua di halaman ini"></th>
<th width="50">ID</th>
<th width="70">Foto</th>
<th>Nama Produk</th>
<th>Kategori</th>
<th>Harga</th>
<th width="60">Stok</th>
<th width="100">Status</th>
<th width="100">Aksi</th>
</tr>
</thead>
<tbody></tbody>
</table>
</div>

</div>
</div>
</main>

<button class="fab mobile-only" onclick="openProdukModal()">+</button>
<?php $this->load->view('toko/_bottom_nav', ['current_page' => 'produk']); ?>
</div>
</div>

<!-- Modal Tambah/Edit Produk -->
<div class="admin-modal" id="produkModal">
<div class="admin-modal-content">
<div class="admin-modal-head">
<h3 id="produkModalTitle">Tambah Produk</h3>
<button class="admin-modal-close" onclick="closeProdukModal()">✕</button>
</div>
<form id="produkForm" enctype="multipart/form-data">
<div class="admin-modal-body">
<input type="hidden" name="id" id="produkId">
<div class="modal-form-grid">
<div class="form-group">
<label class="form-label">Nama Produk *</label>
<input type="text" name="nama_produk" id="pNama" class="form-control" required placeholder="contoh: Mie Ayam Original">
</div>
<div class="form-group">
<label class="form-label">Kategori *</label>
<div class="kategori-select-wrap">
<select name="kategori" id="pKategori" class="form-control" required>
<option value="">-- Pilih Kategori --</option>
<?php foreach ($kategori as $k): ?>
<option value="<?= htmlspecialchars($k->nama) ?>"><?= htmlspecialchars($k->nama) ?></option>
<?php endforeach; ?>
<option value="Lainnya">Lainnya (default)</option>
</select>
<button type="button" class="btn-tambah-kecil" onclick="openKategoriModal()" title="Tambah Kategori Baru">+</button>
</div>
</div>
<div class="form-group">
<label class="form-label">Harga Normal (Rp) *</label>
<input type="number" name="harga" id="pHarga" class="form-control" required min="0" placeholder="10000">
</div>
<div class="form-group">
<label class="form-label">Harga Diskon (kosongkan jika tidak ada)</label>
<input type="number" name="harga_diskon" id="pDiskon" class="form-control" min="0" placeholder="8000">
</div>
<div class="form-group full">
<label class="form-label">Deskripsi</label>
<textarea name="deskripsi" id="pDeskripsi" class="form-control" rows="2" placeholder="Deskripsi singkat menu..."></textarea>
</div>
<div class="form-group">
<label class="form-label">Stok</label>
<input type="number" name="stok" id="pStok" class="form-control" value="100" min="0">
</div>
<div class="form-group">
<label class="form-label">Status</label>
<select name="status" id="pStatus" class="form-control">
<option value="tersedia">✓ Tersedia</option>
<option value="habis">✕ Habis</option>
</select>
</div>
<div class="form-group full">
<label class="form-label">Foto Produk</label>
<input type="file" name="foto" class="form-control" accept="image/*">
<small id="fotoNote" style="color:#9ca3af;font-size:12px;display:block;margin-top:4px;">*Upload foto (opsional, max 2MB)</small>
</div>
</div>
</div>
<div class="admin-modal-foot">
<button type="button" class="btn btn-secondary" onclick="closeProdukModal()">Batal</button>
<button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
</div>
</form>
</div>
</div>

<!-- Modal Tambah Kategori Cepat -->
<div class="admin-modal" id="kategoriModal">
<div class="admin-modal-content">
<div class="admin-modal-head">
<h3>🏷️ Tambah Kategori Baru</h3>
<button class="admin-modal-close" onclick="closeKategoriModal()">✕</button>
</div>
<form id="kategoriCepatForm">
<div class="admin-modal-body">
<div class="form-group">
<label class="form-label">Nama Kategori *</label>
<input type="text" name="nama" id="kCepatNama" class="form-control" required placeholder="contoh: Snack, Dessert">
</div>
<div class="form-group">
<label class="form-label">Icon (emoji)</label>
<input type="text" name="icon" id="kCepatIcon" class="form-control" maxlength="4" style="font-size:20px;text-align:center;width:80px;" placeholder="🍰">
</div>
</div>
<div class="admin-modal-foot">
<button type="button" class="btn btn-secondary" onclick="closeKategoriModal()">Batal</button>
<button type="submit" class="btn btn-primary">Tambah</button>
</div>
</form>
</div>
</div>

<div class="toast" id="toast"><span id="toastMsg"></span></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
<script>
const baseUrl = '<?= base_url() ?>';
let tableProduk;

$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#tableProduk')) {
        $('#tableProduk').DataTable().destroy();
    }
    tableProduk = $('#tableProduk').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: { url: baseUrl + 'admin/produk_ajax', type: 'GET' },
        dom: '<"top"l>rt<"bottom"ip><"clear">',
        autoWidth: false,
        columns: [
            { orderable: false, searchable: false },
            { name: 'id' },
            { orderable: false, searchable: false },
            { name: 'nama_produk' },
            { name: 'kategori' },
            { name: 'harga' },
            { name: 'stok' },
            { name: 'status' },
            { orderable: false, searchable: false }
        ],
        order: [[1, 'desc']],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            processing: '<div style="padding:20px;color:#6b7280;">⏳ Memuat...</div>',
            emptyTable: '<div style="padding:30px;color:#9ca3af;">Belum ada produk</div>'
        },
        initComplete: function() {
            $('.dataTables_length label').contents().filter(function() {
                return this.nodeType === 3;
            }).replaceWith('Tampilkan ');
        },
        drawCallback: function() {
            document.getElementById('checkAllProduk').checked = false;
            updateBulkInfo();
        }
    });

    $('#searchInput').on('keyup', function() {
        tableProduk.search(this.value).draw();
    });

    $('#tableProduk').on('change', '.produk-check', updateBulkInfo);
    $('#checkAllProduk').on('change', function() {
        $('#tableProduk .produk-check').prop('checked', this.checked);
        updateBulkInfo();
    });
});

function getSelectedProdukIds() {
    return $('#tableProduk .produk-check:checked').map(function() {
        return this.value;
    }).get();
}

function updateBulkInfo() {
    const total = getSelectedProdukIds().length;
    document.getElementById('bulkInfo').textContent = total + ' produk dipilih';
    const visibleChecks = $('#tableProduk .produk-check');
    const checkedVisible = $('#tableProduk .produk-check:checked');
    const checkAll = document.getElementById('checkAllProduk');
    checkAll.checked = visibleChecks.length > 0 && visibleChecks.length === checkedVisible.length;
}

function checkAllProduk() {
    $('#tableProduk .produk-check').prop('checked', true);
    updateBulkInfo();
}

function uncheckAllProduk() {
    $('#tableProduk .produk-check, #checkAllProduk').prop('checked', false);
    updateBulkInfo();
}

function bulkProdukAction(action) {
    const ids = getSelectedProdukIds();
    if (ids.length === 0) {
        Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Pilih produk terlebih dahulu', confirmButtonText: 'OK' });
        return;
    }

    const message = action === 'delete'
        ? 'Hapus ' + ids.length + ' produk terpilih? Foto produk juga akan dihapus.'
        : 'Jadikan ' + ids.length + ' produk terpilih tidak tersedia?';

    Swal.fire({
        icon: 'warning',
        title: 'Konfirmasi',
        text: message,
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) return;

        const fd = new FormData();
        fd.append('action', action);
        ids.forEach(id => fd.append('ids[]', id));

        fetch(baseUrl + 'admin/produk_bulk_action', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, confirmButtonText: 'OK' }).then(() => {
                        uncheckAllProduk();
                        tableProduk.ajax.reload(null, false);
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Unknown error', confirmButtonText: 'OK' });
                }
            })
            .catch(err => Swal.fire({ icon: 'error', title: 'Error', text: 'Error: ' + err, confirmButtonText: 'OK' }));
    });
}

function openProdukModal() {
    document.getElementById('produkModalTitle').textContent = 'Tambah Produk';
    document.getElementById('produkForm').reset();
    document.getElementById('produkId').value = '';
    document.getElementById('pKategori').value = '';
    document.getElementById('pStok').value = '100';
    document.getElementById('pStatus').value = 'tersedia';
    document.getElementById('fotoNote').textContent = '*Upload foto produk (opsional)';
    const modal = document.getElementById('produkModal');
    modal.classList.add('show');
    setTimeout(() => {
        modal.querySelector('.admin-modal-content').style.display = 'flex';
        const body = modal.querySelector('.admin-modal-body');
        body.style.maxHeight = 'calc(100vh - 160px)';
        body.style.overflowY = 'auto';
        document.getElementById('pNama').focus();
    }, 50);
}

function closeProdukModal() {
    document.getElementById('produkModal').classList.remove('show');
}

function editProduk(id) {
    fetch(baseUrl + 'admin/produk_get/' + id)
        .then(r => r.json())
        .then(p => {
            if (p.error) { Swal.fire({ icon: 'error', title: 'Error', text: 'Produk tidak ditemukan', confirmButtonText: 'OK' }); return; }
            document.getElementById('produkModalTitle').textContent = 'Edit Produk';
            document.getElementById('produkId').value = p.id;
            document.getElementById('pNama').value = p.nama_produk || '';
            const katSelect = document.getElementById('pKategori');
            const exists = Array.from(katSelect.options).find(o => o.value === p.kategori);
            if (!exists && p.kategori) {
                const opt = new Option(p.kategori, p.kategori, true, true);
                katSelect.add(opt);
            }
            katSelect.value = p.kategori || 'Lainnya';
            document.getElementById('pHarga').value = p.harga || '';
            document.getElementById('pDiskon').value = p.harga_diskon || '';
            document.getElementById('pDeskripsi').value = p.deskripsi || '';
            document.getElementById('pStok').value = p.stok || 0;
            document.getElementById('pStatus').value = p.status || 'tersedia';
            document.getElementById('fotoNote').textContent = '*Kosongkan jika tidak ingin ganti. File saat ini: ' + (p.foto || 'tidak ada');
            const modal = document.getElementById('produkModal');
            modal.classList.add('show');
            setTimeout(() => {
                modal.querySelector('.admin-modal-content').style.display = 'flex';
                const body = modal.querySelector('.admin-modal-body');
                body.style.maxHeight = 'calc(100vh - 160px)';
                body.style.overflowY = 'auto';
            }, 50);
        });
    }

function hapusProduk(id) {
    Swal.fire({
        icon: 'warning',
        title: 'Hapus Produk?',
        text: 'Produk ini akan dihapus beserta fotonya.',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) return;
        fetch(baseUrl + 'admin/produk_hapus/' + id, { method: 'POST' })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, confirmButtonText: 'OK' }).then(() => {
                        tableProduk.ajax.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Unknown error', confirmButtonText: 'OK' });
                }
            });
    });
}

function filterCat(cat, el) {
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    tableProduk.column(4).search(cat ? '^' + cat.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '$' : '', true, false).draw();
}

document.getElementById('produkForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const btn = document.getElementById('btnSimpan');
    btn.disabled = true; btn.textContent = '⏳ Menyimpan...';
    fetch(baseUrl + 'admin/produk_save', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false; btn.textContent = 'Simpan';
            if (data.status === 'ok') {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, confirmButtonText: 'OK' }).then(() => {
                    closeProdukModal();
                    tableProduk.ajax.reload();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Unknown error', confirmButtonText: 'OK' });
            }
        })
        .catch(err => {
            btn.disabled = false; btn.textContent = 'Simpan';
            Swal.fire({ icon: 'error', title: 'Error', text: 'Error: ' + err, confirmButtonText: 'OK' });
        });
});

function openKategoriModal() {
    document.getElementById('kategoriCepatForm').reset();
    document.getElementById('kategoriModal').classList.add('show');
    setTimeout(() => document.getElementById('kCepatNama').focus(), 100);
}

function closeKategoriModal() {
    document.getElementById('kategoriModal').classList.remove('show');
}

document.getElementById('kategoriCepatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fd.set('urutan', '99');
    fetch(baseUrl + 'admin/kategori_save', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'ok') {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, confirmButtonText: 'OK' }).then(() => {
                    const katSelect = document.getElementById('pKategori');
                    const newName = document.getElementById('kCepatNama').value.trim();
                    const exists = Array.from(katSelect.options).find(o => o.value === newName);
                    if (!exists) {
                        const opt = new Option(newName, newName, true, true);
                        katSelect.add(opt);
                    }
                    katSelect.value = newName;
                    closeKategoriModal();
                    tableProduk.ajax.reload();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Unknown error', confirmButtonText: 'OK' });
            }
        });
});
</script>
</body>
</html>
