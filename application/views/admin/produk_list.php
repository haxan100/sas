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
<?php $this->load->view('toko/_tema', ['toko' => $toko]); ?>
</head>
<body class="admin-body">
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

<div class="table-wrap desktop-only">
<table id="tableProduk" class="table" style="width:100%">
<thead>
<tr>
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

<div class="mobile-cards" id="mobileProduk">
<div class="mobile-cards-loading">⏳ Memuat produk...</div>
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
        ajax: { url: baseUrl + 'admin/produk_ajax', type: 'GET' },
        columns: [
            { name: 'id' },
            { orderable: false, searchable: false },
            { name: 'nama_produk' },
            { name: 'kategori' },
            { name: 'harga' },
            { name: 'stok' },
            { name: 'status' },
            { orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
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
            renderMobileProdukCards();
        }
    });

    $('#searchInput').on('keyup', function() {
        tableProduk.search(this.value).draw();
    });
});

function renderMobileProdukCards() {
    const container = document.getElementById('mobileProduk');
    if (!container) return;
    const data = tableProduk.rows({page: 'current'}).data();
    if (!data || data.length === 0) {
        container.innerHTML = '<div class="mobile-cards-loading">Belum ada produk.<br><br>Tekan tombol + di bawah untuk tambah</div>';
        return;
    }
    let html = '';
    data.each(function(row) {
        const [id, fotoHtml, nama, kategori, harga, stok, status, aksi] = row;
        const imgMatch = fotoHtml.match(/src="([^"]+)"/);
        const imgUrl = imgMatch ? imgMatch[1] : '';
        const isEmpty = !imgUrl;
        html += `<div class="card-list-item">
            <div class="img">${isEmpty ? '🍽️' : '<img src="' + imgUrl + '">'}</div>
            <div class="body">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:8px;">
                    <div style="min-width:0;flex:1;">
                        <h4 style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${nama.replace(/<br>.*$/, '').replace(/<[^>]+>/g, '')}</h4>
                        <span class="dt-badge" style="background:#dbeafe;color:#1e40af;font-size:10px;">${kategori.replace(/<[^>]+>/g, '')}</span>
                        <p style="margin-top:4px;">${harga}</p>
                    </div>
                </div>
                <div class="meta" style="margin-top:8px;">
                    <small style="color:#6cae0;">Stok: ${stok}</small>
                    ${status}
                </div>
                <div style="margin-top:8px;display:flex;gap:6px;">${aksi}</div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
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
    setTimeout(() => document.getElementById('pNama').focus(), 100);
}

function closeProdukModal() {
    document.getElementById('produkModal').classList.remove('show');
}

function editProduk(id) {
    fetch(baseUrl + 'admin/produk_get/' + id)
        .then(r => r.json())
        .then(p => {
            if (p.error) { toast('Produk tidak ditemukan', 'error'); return; }
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
    if (!confirm('Hapus produk ini?')) return;
    fetch(baseUrl + 'admin/produk_hapus/' + id, { method: 'POST' })
        .then(r => r.json())
        .then(data => {
            toast(data.message, data.status);
            if (data.status === 'ok') tableProduk.ajax.reload();
        });
}

function filterCat(cat, el) {
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    tableProduk.column(3).search(cat ? '^' + cat.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '$' : '', true, false).draw();
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
                toast(data.message, 'success');
                closeProdukModal();
                tableProduk.ajax.reload();
            } else {
                toast('Gagal: ' + (data.message || 'Unknown'), 'error');
            }
        })
        .catch(err => {
            btn.disabled = false; btn.textContent = 'Simpan';
            toast('Error: ' + err, 'error');
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
                toast(data.message, 'success');
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
            } else {
                toast(data.message, 'error');
            }
        });
});
</script>
</body>
</html>
