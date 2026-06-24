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
    <style>
        .icon-picker {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 6px;
            max-height: 180px;
            overflow-y: auto;
            padding: 8px;
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .icon-picker-item {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: #fff;
            border: 2px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            transition: all .15s;
        }

        .icon-picker-item:hover {
            background: #f3f4f6;
        }

        .icon-picker-item.selected {
            border-color: var(--tema-color, #ff6b35);
            background: #fff8f3;
        }

        /* --- PERCANTIK DATATABLES --- */
        /* Sembunyikan pencarian bawaan datatable karena kita pakai custom search di toolbar */
        .dataTables_filter {
            display: none;
        }

        /* Tabel Utama */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
            margin-top: 15px !important;
        }

        table.dataTable thead th {
            background-color: #1e293b;
            color: white;
            padding: 12px 15px;
            font-weight: 600;
            border-bottom: none;
        }

        table.dataTable thead th:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        table.dataTable thead th:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        table.dataTable tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
        }

        table.dataTable tbody tr:hover {
            background-color: #f8fafc;
            /* Efek hover baris abu-abu terang */
        }

        /* --- CONTAINER BAWAH (Sejajar Info & Pagination) --- */
        .bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #f3f4f6;
            /* Garis pemisah tipis */
        }

        /* --- STYLE PAGINATION SEPERTI TARGET --- */
        .dataTables_paginate ul.pagination {
            display: flex;
            padding-left: 0;
            list-style: none !important;
            /* Wajib: Menghilangkan titik hitam */
            margin: 0;
            border-radius: 4px;
        }

        /* Hilangkan list style pada item */
        .dataTables_paginate ul.pagination li {
            list-style: none !important;
            margin: 0;
            padding: 0;
        }

        /* Desain kotak (menyambung) */
        .dataTables_paginate ul.pagination li .page-link {
            position: relative;
            display: block;
            padding: 6px 14px;
            margin-left: -1px;
            /* Membuat border saling menyatu */
            font-size: 14px;
            color: #4f46e5;
            /* Teks warna ungu/biru */
            background-color: #fff;
            border: 1px solid #d1d5db;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        /* Hover efek */
        .dataTables_paginate ul.pagination li .page-link:hover {
            z-index: 2;
            background-color: #f3f4f6;
            color: #3730a3;
        }

        /* Tombol Aktif (Kotak biru solid) */
        .dataTables_paginate ul.pagination li.active .page-link {
            z-index: 3;
            color: #fff !important;
            background-color: #2563eb !important;
            /* Warna biru */
            border-color: #2563eb !important;
        }

        /* Disabled efek (Jika mentok di halaman 1 atau terakhir) */
        .dataTables_paginate ul.pagination li.disabled .page-link {
            color: #9ca3af;
            pointer-events: none;
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        /* Melengkungkan sudut pinggir saja */
        .dataTables_paginate ul.pagination li:first-child .page-link {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        .dataTables_paginate ul.pagination li:last-child .page-link {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        /* Memperbaiki posisi info "Menampilkan x dari y" */
        .dataTables_info {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
            padding: 0 !important;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 767px) {
            .admin-body .dataTables_wrapper {
                display: block !important;
                padding: 0 !important;
            }

            .toolbar {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .toolbar .search,
            .toolbar .btn {
                width: 100%;
            }

            #tableKategori {
                display: table !important;
                min-width: 640px;
                width: 640px !important;
            }

            #tableKategori thead,
            #tableKategori tbody,
            #tableKategori tr,
            #tableKategori th,
            #tableKategori td {
                display: revert !important;
            }

            #tableKategori th,
            #tableKategori td {
                white-space: nowrap;
            }

            .bottom {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .dataTables_paginate ul.pagination {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body class="admin-body">
    <div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
    <div class="admin-wrap">
        <?php $this->load->view('toko/_sidebar', ['toko' => $toko, 'current_page' => 'kategori']); ?>
        <div class="admin-main">
            <?php $this->load->view('toko/_header', ['toko' => $toko, 'current_page' => 'kategori', 'page_title' => 'Kategori', 'breadcrumb' => 'Kelompokkan produk tokomu']); ?>
            <main class="admin-content">
                <?php if ($this->session->flashdata('sukses')): ?>
                    <div
                        style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;border-left:4px solid #10b981;">
                        <?= $this->session->flashdata('sukses') ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">🏷️ Daftar Kategori</h3>
                            <div class="card-desc">Kategori yang tampil di halaman toko</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <input type="text" id="searchInput" class="form-control search"
                                placeholder="🔍 Cari kategori...">
                            <button class="btn btn-primary" onclick="openKategoriModal()">+ Tambah Kategori</button>
                        </div>

                        <div class="table-responsive">
                            <table id="tableKategori" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="60">#</th>
                                        <th>Nama Kategori</th>
                                        <th>Icon</th>
                                        <th>Jumlah Produk</th>
                                        <th width="80">Urutan</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <button class="fab mobile-only" onclick="openKategoriModal()">+</button>
            <?php $this->load->view('toko/_bottom_nav', ['current_page' => 'kategori']); ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="admin-modal" id="kategoriModal">
        <div class="admin-modal-content">
            <div class="admin-modal-head">
                <h3 id="kategoriModalTitle">Tambah Kategori</h3>
                <button class="admin-modal-close" onclick="closeKategoriModal()">✕</button>
            </div>
            <form id="kategoriForm">
                <div class="admin-modal-body">
                    <input type="hidden" name="id" id="kategoriId">
                    <div class="form-group">
                        <label class="form-label">Nama Kategori *</label>
                        <input type="text" name="nama" id="kNama" class="form-control" required
                            placeholder="contoh: Mie Ayam, Minuman, Snack">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Icon (emoji)</label>
                        <input type="text" name="icon" id="kIcon" class="form-control" placeholder="🍜" maxlength="4"
                            style="font-size:20px;text-align:center;width:80px;">
                        <div class="icon-picker" style="margin-top:8px;">
                            <?php
                            $icons = ['🍜', '🍲', '🍚', '🥡', '🥢', '🍗', '🍖', '🥩', '🍱', '🍙', '🍣', '🍤', '🍥', '🥟', '🥠', '🥮', '🍢', '🍡', '🍧', '🍨', '🍦', '🥧', '🧁', '🍰', '🎂', '🍮', '🍭', '🍬', '🍫', '🍿', '🍩', '🍪', '🥛', '🍼', '☕', '🍵', '🥤', '🧋', '🧃', '🧊', '🍺', '🍻', '🥂', '🍷', '🥃', '🍸', '🍹', '🍶', '🥄', '🍴', '🥣', '🥡', '🌮', '🌯', '🥙', '🥗', '🥘', '🍳'];
                            foreach ($icons as $ic): ?>
                                <div class="icon-picker-item" onclick="pilihIcon('<?= $ic ?>')"><?= $ic ?></div>
                            <?php endforeach; ?>
                        </div>
                        <small style="color:#6b7280;font-size:12px;margin-top:4px;display:block;">Klik icon untuk
                            memilih, atau ketik sendiri</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="urutan" id="kUrutan" class="form-control" value="0" min="0">
                        <small style="color:#6b7280;font-size:12px;margin-top:4px;display:block;">Semakin kecil
                            angkanya, semakin awal muncul</small>
                    </div>
                </div>
                <div class="admin-modal-foot">
                    <button type="button" class="btn btn-secondary" onclick="closeKategoriModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="toast" id="toast"><span id="toastMsg"></span></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        const SLUG = '';
        const baseUrl = '<?= base_url() ?>';
        let tableKategori;

        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('adminOverlay').classList.toggle('show');
        }

        function pilihIcon(ic) {
            document.getElementById('kIcon').value = ic;
            document.querySelectorAll('.icon-picker-item').forEach(el => el.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
        }

        $(document).ready(function () {
            tableKategori = $('#tableKategori').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: { url: baseUrl + '/admin/kategori_ajax', type: 'GET' },
                dom: '<"top"l>rt<"bottom"ip><"clear">',

                // Pastikan table width 100%
                autoWidth: false,

                columns: [
                    { name: 'id' },
                    { name: 'nama' },
                    { name: 'icon' },
                    { name: 'jumlah_produk' },
                    { name: 'urutan' },
                    { orderable: false, searchable: false }
                ],
                columnDefs: [
                    { targets: [0, 2, 4, 5], className: 'text-center' }
                    // 0: #, 2: Icon, 4: Urutan, 5: Aksi -> posisinya rata tengah
                ],
                order: [[4, 'asc']],
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                    processing: '<div style="padding:20px;color:#6b7280;">⏳ Memuat...</div>',
                    emptyTable: '<div style="padding:30px;color:#9ca3af;text-align:center;">Belum ada kategori. Klik "+ Tambah Kategori" untuk mulai.</div>',
                    // Ubah teks pagination bawaan agar lebih ringkas
                    paginate: {
                        previous: "❮",
                        next: "❯"
                    }
                },
                initComplete: function () {
                    $('.dataTables_length label').contents().filter(function () {
                        return this.nodeType === 3;
                    }).replaceWith('Tampilkan ');
                }
            });

            $('#searchInput').on('keyup', function () {
                tableKategori.search(this.value).draw();
            });
        });

        function openKategoriModal() {
            document.getElementById('kategoriModalTitle').textContent = 'Tambah Kategori';
            document.getElementById('kategoriForm').reset();
            document.getElementById('kategoriId').value = '';
            document.getElementById('kUrutan').value = '0';
            document.querySelectorAll('.icon-picker-item').forEach(el => el.classList.remove('selected'));
            document.getElementById('kategoriModal').classList.add('show');
        }

        function closeKategoriModal() {
            document.getElementById('kategoriModal').classList.remove('show');
        }

        function editKategori(id) {
            fetch(baseUrl + '/admin/kategori_get/' + id)
                .then(r => r.json())
                .then(k => {
                    document.getElementById('kategoriModalTitle').textContent = 'Edit Kategori';
                    document.getElementById('kategoriId').value = k.id;
                    document.getElementById('kNama').value = k.nama;
                    document.getElementById('kIcon').value = k.icon || '';
                    document.getElementById('kUrutan').value = k.urutan || 0;
                    document.querySelectorAll('.icon-picker-item').forEach(el => {
                        el.classList.remove('selected');
                        if (el.textContent === k.icon) el.classList.add('selected');
                    });
                    document.getElementById('kategoriModal').classList.add('show');
                });
        }

        function hapusKategori(id) {
            if (!confirm('Hapus kategori ini? Produk dalam kategori ini akan dipindah ke "Lainnya".')) return;
            fetch(baseUrl + '/admin/kategori_hapus/' + id, { method: 'POST' })
                .then(r => r.json())
                .then(data => {
                    toast(data.message, data.status);
                    if (data.status === 'ok') tableKategori.ajax.reload();
                });
        }

        document.getElementById('kategoriForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const fd = new FormData(this);
            const btn = document.getElementById('btnSimpan');
            btn.disabled = true; btn.textContent = '⏳ Menyimpan...';
            fetch(baseUrl + '/admin/kategori_save', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    btn.disabled = false; btn.textContent = 'Simpan';
                    if (data.status === 'ok') {
                        toast(data.message, 'success');
                        closeKategoriModal();
                        tableKategori.ajax.reload();
                    } else {
                        toast(data.message, 'error');
                    }
                })
                .catch(err => {
                    btn.disabled = false; btn.textContent = 'Simpan';
                    toast('Error: ' + err, 'error');
                });
        });

        function toast(msg, type) {
            const t = document.getElementById('toast');
            t.className = 'toast ' + (type || 'info') + ' show';
            document.getElementById('toastMsg').textContent = (type === 'success' ? '✓ ' : '⚠ ') + msg;
            setTimeout(() => t.classList.remove('show'), 3000);
        }
    </script>
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>

</html>
