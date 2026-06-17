<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
.admin-sidebar, .admin-header, .bottom-nav { --tema: #f59e0b; }
.pending-badge { background: #fef3c7; color: #92400e; padding: 2px 10px; border-radius: 10px; font-size: 11px; font-weight: 600; }
.active-badge { background: #dcfce7; color: #166534; padding: 2px 10px; border-radius: 10px; font-size: 11px; font-weight: 600; }
.rejected-badge { background: #fee2e2; color: #991b1b; padding: 2px 10px; border-radius: 10px; font-size: 11px; font-weight: 600; }
.verif-card { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 16px; border: 1px solid #e5e7eb; transition: all .2s; }
.verif-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.08); }
.verif-card.pending { border-left: 4px solid #f59e0b; }
.verif-card.aktif { border-left: 4px solid #10b981; }
.verif-card.rejected { border-left: 4px solid #ef4444; }
.card-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px; }
.card-header h3 { font-size: 16px; font-weight: 700; margin-bottom: 2px; }
.card-header .badge { font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 10px; }
.card-meta { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; margin-bottom: 14px; }
.card-meta .meta-item { background: #f9fafb; padding: 8px 12px; border-radius: 8px; }
.card-meta .meta-label { font-size: 11px; color: #6b7280; margin-bottom: 2px; }
.card-meta .meta-value { font-size: 13px; font-weight: 600; color: #111; }
.card-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.btn-approve { background: #10b981; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; }
.btn-approve:hover { background: #059669; transform: translateY(-1px); }
.btn-reject { background: #ef4444; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; }
.btn-reject:hover { background: #dc2626; transform: translateY(-1px); }
.btn-view { background: #3b82f6; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; }
.btn-view:hover { background: #1d4ed8; }
.btn-pending { background: #f59e0b; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; }
.btn-pending:hover { background: #d97706; }
.empty-state { text-align: center; padding: 60px 20px; color: #6b7280; }
.empty-state .icon { font-size: 64px; margin-bottom: 16px; }
.empty-state h3 { font-size: 18px; font-weight: 700; margin-bottom: 8px; color: #111; }
.empty-state p { font-size: 14px; }
.tab-nav { display: flex; gap: 4px; margin-bottom: 20px; background: #f3f4f6; padding: 4px; border-radius: 10px; }
.tab-btn { flex: 1; padding: 10px 16px; border: none; background: none; border-radius: 8px; font-size: 13px; font-weight: 600; color: #6b7280; cursor: pointer; transition: all .2s; }
.tab-btn:hover { color: #111; }
.tab-btn.active { background: #fff; color: #111; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
.tab-btn .count { display: inline-flex; align-items: center; justify-content: center; min-width: 20px; height: 20px; background: #e5e7eb; color: #374151; border-radius: 10px; font-size: 11px; font-weight: 700; margin-left: 6px; padding: 0 6px; }
.tab-btn.active .count { background: #f59e0b; color: #fff; }
.tab-btn.approved .count { background: #10b981; color: #fff; }
@media(max-width: 768px) {
    .card-meta { grid-template-columns: 1fr 1fr; }
    .card-actions { flex-direction: column; }
    .card-actions button { width: 100%; }
}
</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('owner/_sidebar', ['current_page' => 'verifikasi']); ?>
<div class="admin-main">
<?php $this->load->view('owner/_header', ['page_title' => 'Verifikasi Toko', 'breadcrumb' => 'Aktifkan atau nonaktifkan toko']); ?>
<main class="admin-content">

<?php if ($this->session->flashdata('sukses')): ?>
<div style="background:#dcfce7;color:#166534;padding:14px 16px;border-radius:8px;margin-bottom:16px;border-left:4px solid #10b981;font-weight:500;"><?= $this->session->flashdata('sukses') ?></div>
<?php endif; ?>

<div class="tab-nav">
<button class="tab-btn active" onclick="showTab('pending')">
Menunggu <span class="count" id="countPending"><?= $pending_count ?></span>
</button>
<button class="tab-btn approved" onclick="showTab('aktif')">
Aktif <span class="count" id="countAktif"><?= $aktif_count ?></span>
</button>
<button class="tab-btn" onclick="showTab('all')">
Semua <span class="count" id="countAll"><?= $total_count ?></span>
</button>
</div>

<div id="tabPending" class="tab-content">
<?php if (empty($pending_toko)): ?>
<div class="empty-state">
<div class="icon">✅</div>
<h3>Tidak ada yang pending</h3>
<p>Semua toko sudah diverifikasi atau belum ada pendaftaran baru.</p>
</div>
<?php else: ?>
<?php foreach ($pending_toko as $t): ?>
<div class="verif-card pending">
<div class="card-header">
<div>
<h3><?= htmlspecialchars($t->nama_toko) ?></h3>
<small style="color:#6b7280;"><?= htmlspecialchars($t->kategori) ?> · Daftar: <?= date('d/m/Y H:i', strtotime($t->created_at)) ?></small>
</div>
<span class="badge pending-badge">⏳ Pending</span>
</div>
<div class="card-meta">
<div class="meta-item">
<div class="meta-label">Pemilik</div>
<div class="meta-value"><?= htmlspecialchars($t->pemilik) ?></div>
</div>
<div class="meta-item">
<div class="meta-label">WhatsApp</div>
<div class="meta-value"><?= htmlspecialchars($t->no_wa) ?></div>
</div>
<div class="meta-item">
<div class="meta-label">Slug</div>
<div class="meta-value"><code><?= htmlspecialchars($t->slug) ?></code></div>
</div>
<div class="meta-item">
<div class="meta-label">Alamat</div>
<div class="meta-value"><?= htmlspecialchars($t->alamat ?: '-') ?></div>
</div>
</div>
<div class="card-actions">
<button class="btn-approve" onclick="verifToko(<?= $t->id ?>, 'aktif')">✅ Aktifkan Toko</button>
<button class="btn-reject" onclick="verifToko(<?= $t->id ?>, 'nonaktif')">❌ Tolak</button>
<button class="btn-view" onclick="detailToko(<?= $t->id ?>)">👁️ Detail</button>
</div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>

<div id="tabAktif" class="tab-content" style="display:none;">
<?php if (empty($aktif_toko)): ?>
<div class="empty-state">
<div class="icon">🏪</div>
<h3>Belum ada toko aktif</h3>
<p>Verifikasi toko baru untuk membuatnya aktif.</p>
</div>
<?php else: ?>
<?php foreach ($aktif_toko as $t): ?>
<div class="verif-card aktif">
<div class="card-header">
<div>
<h3><?= htmlspecialchars($t->nama_toko) ?></h3>
                <small style="color:#6b7280;"><?= htmlspecialchars($t->kategori) ?> · Aktif sejak: <?= date('d/m/Y', strtotime($t->created_at)) ?></small>
</div>
<span class="badge active-badge">✅ Aktif</span>
</div>
<div class="card-meta">
<div class="meta-item">
<div class="meta-label">Pemilik</div>
<div class="meta-value"><?= htmlspecialchars($t->pemilik) ?></div>
</div>
<div class="meta-item">
<div class="meta-label">WhatsApp</div>
<div class="meta-value"><?= htmlspecialchars($t->no_wa) ?></div>
</div>
<div class="meta-item">
<div class="meta-label">Slug</div>
<div class="meta-value"><code><?= htmlspecialchars($t->slug) ?></code></div>
</div>
<div class="meta-item">
<div class="meta-label">Username</div>
<div class="meta-value"><?= htmlspecialchars($t->username) ?></div>
</div>
</div>
<div class="card-actions">
<button class="btn-pending" onclick="verifToko(<?= $t->id ?>, 'pending')">⏸️ Nonaktifkan</button>
<a href="<?= base_url($t->slug) ?>" target="_blank" class="btn-view" style="text-decoration:none;">👁️ Lihat Toko</a>
</div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>

<div id="tabAll" class="tab-content" style="display:none;">
<div style="overflow-x:auto;">
<table class="table" style="width:100%;border-collapse:collapse;">
<thead>
<tr style="background:#f9fafb;">
<th style="padding:10px 12px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Toko</th>
<th style="padding:10px 12px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Pemilik</th>
<th style="padding:10px 12px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Slug</th>
<th style="padding:10px 12px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Status</th>
<th style="padding:10px 12px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Tanggal</th>
<th style="padding:10px 12px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach ($all_toko as $t): ?>
<tr style="border-bottom:1px solid #f3f4f6;">
<td style="padding:12px;">
<strong><?= htmlspecialchars($t->nama_toko) ?></strong><br>
<small style="color:#6b7280;"><?= htmlspecialchars($t->kategori) ?></small>
</td>
<td style="padding:12px;"><?= htmlspecialchars($t->pemilik) ?></td>
<td style="padding:12px;"><code><?= htmlspecialchars($t->slug) ?></code></td>
<td style="padding:12px;">
<?php if ($t->status == 'aktif'): ?>
<span class="active-badge">Aktif</span>
<?php elseif ($t->status == 'pending'): ?>
<span class="pending-badge">Pending</span>
<?php else: ?>
<span class="rejected-badge">Nonaktif</span>
<?php endif; ?>
</td>
<td style="padding:12px;font-size:12px;color:#6b7280;"><?= date('d/m/Y', strtotime($t->created_at)) ?></td>
<td style="padding:12px;">
<div style="display:flex;gap:6px;">
<?php if ($t->status == 'pending'): ?>
<button class="btn-approve" style="padding:6px 12px;font-size:12px;" onclick="verifToko(<?= $t->id ?>, 'aktif')">Aktifkan</button>
<button class="btn-reject" style="padding:6px 12px;font-size:12px;" onclick="verifToko(<?= $t->id ?>, 'nonaktif')">Tolak</button>
<?php elseif ($t->status == 'aktif'): ?>
<button class="btn-pending" style="padding:6px 12px;font-size:12px;" onclick="verifToko(<?= $t->id ?>, 'pending')">Nonaktifkan</button>
<?php else: ?>
<button class="btn-approve" style="padding:6px 12px;font-size:12px;" onclick="verifToko(<?= $t->id ?>, 'aktif')">Aktifkan</button>
<?php endif; ?>
<a href="<?= base_url($t->slug) ?>" target="_blank" class="btn-view" style="padding:6px 12px;font-size:12px;text-decoration:none;">Lihat</a>
</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

</main>
<?php $this->load->view('owner/_bottom_nav', ['current_page' => 'verifikasi']); ?>
</div>
</div>

<!-- Modal Detail -->
<div class="admin-modal" id="detailModal">
<div class="admin-modal-content">
<div class="admin-modal-head">
<h3 id="detailTitle">Detail Toko</h3>
<button class="admin-modal-close" onclick="closeDetailModal()">✕</button>
</div>
<div class="admin-modal-body" id="detailBody">
<div style="text-align:center;padding:40px;">⏳ Memuat...</div>
</div>
<div class="admin-modal-foot">
<button class="btn btn-secondary" onclick="closeDetailModal()">Tutup</button>
</div>
</div>
</div>

<div class="toast" id="toast"><span id="toastMsg"></span></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
<script>
const baseUrl = '<?= base_url() ?>';

function showTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
    document.getElementById('tab' + tab.charAt(0).toUpperCase() + tab.slice(1)).style.display = 'block';
    event.target.classList.add('active');
}

function verifToko(id, status) {
    const msg = status === 'aktif' 
        ? 'Aktifkan toko ini? Toko akan muncul di beranda dan bisa digunakan.' 
        : (status === 'pending' 
            ? 'Nonaktifkan toko ini? Toko tidak akan muncul di beranda.' 
            : 'Tolak toko ini? Pendaftaran akan ditolak.');
    if (!confirm(msg)) return;
    
    fetch(baseUrl + 'owner/toko_verif/' + id + '/' + status, { method: 'POST' })
        .then(r => r.json())
        .then(data => {
            toast(data.message, data.status === 'ok' ? 'success' : 'error');
            if (data.status === 'ok') {
                setTimeout(() => location.reload(), 1000);
            }
        });
}

function detailToko(id) {
    document.getElementById('detailBody').innerHTML = '<div style="text-align:center;padding:40px;">⏳ Memuat...</div>';
    document.getElementById('detailModal').classList.add('show');
    fetch(baseUrl + 'owner/toko_get/' + id)
        .then(r => r.json())
        .then(t => {
            if (!t || t.error) {
                document.getElementById('detailBody').innerHTML = '<div style="padding:20px;text-align:center;color:#ef4444;">Toko tidak ditemukan</div>';
                return;
            }
            document.getElementById('detailTitle').textContent = t.nama_toko;
            document.getElementById('detailBody').innerHTML = `
                <div style="display:grid;gap:12px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label style="font-size:11px;color:#6b7280;">Nama Toko</label><div style="font-weight:600;">${t.nama_toko || '-'}</div></div>
                        <div><label style="font-size:11px;color:#6b7280;">Pemilik</label><div style="font-weight:600;">${t.pemilik || '-'}</div></div>
                        <div><label style="font-size:11px;color:#6b7280;">Username</label><div style="font-weight:600;">${t.username || '-'}</div></div>
                        <div><label style="font-size:11px;color:#6b7280;">WhatsApp</label><div style="font-weight:600;">${t.no_wa || '-'}</div></div>
                        <div><label style="font-size:11px;color:#6b7280;">Kategori</label><div style="font-weight:600;">${t.kategori || '-'}</div></div>
                        <div><label style="font-size:11px;color:#6b7280;">Slug</label><div style="font-weight:600;"><code>${t.slug || '-'}</code></div></div>
                        <div><label style="font-size:11px;color:#6b7280;">Bank</label><div style="font-weight:600;">${t.nama_bank || '-'} ${t.no_rek ? '- ' + t.no_rek : ''}</div></div>
                        <div><label style="font-size:11px;color:#6b7280;">Atas Nama</label><div style="font-weight:600;">${t.atas_nama || '-'}</div></div>
                    </div>
                    <div><label style="font-size:11px;color:#6b7280;">Alamat</label><div style="font-weight:600;">${t.alamat || '-'}</div></div>
                    <div><label style="font-size:11px;color:#6b7280;">Status</label>
                        <div style="margin-top:4px;">
                            ${t.status === 'aktif' ? '<span class="active-badge">Aktif</span>' : (t.status === 'pending' ? '<span class="pending-badge">Pending</span>' : '<span class="rejected-badge">Nonaktif</span>')}
                        </div>
                    </div>
                    <div><label style="font-size:11px;color:#6b7280;">Tanggal Daftar</label><div style="font-weight:600;">${t.created_at ? new Date(t.created_at).toLocaleString('id-ID') : '-'}</div></div>
                </div>
            `;
        });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('show');
}
</script>
</body>
</html>
