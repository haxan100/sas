<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
.admin-sidebar, .admin-header { --tema: #6366f1; }
.welcome-card { background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; padding: 28px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(99,102,241,.3); position: relative; overflow: hidden; }
.welcome-card::before { content: ''; position: absolute; right: -30px; top: -30px; width: 150px; height: 150px; background: rgba(255,255,255,.1); border-radius: 50%; }
.welcome-card::after { content: ''; position: absolute; right: 30px; bottom: -50px; width: 100px; height: 100px; background: rgba(255,255,255,.08); border-radius: 50%; }
.welcome-card h2 { font-size: 22px; margin-bottom: 6px; position: relative; z-index: 1; }
.welcome-card p { opacity: .92; position: relative; z-index: 1; line-height: 1.5; }

.stat-card-link { display: block; text-decoration: none; color: inherit; transition: transform .15s; }
.stat-card-link:hover { transform: translateY(-2px); }

.toko-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
.toko-card-link { display: block; text-decoration: none; color: inherit; transition: transform .15s; }
.toko-card-link:hover { transform: translateY(-2px); }
.toko-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
.toko-card-cover { height: 80px; display: flex; align-items: center; justify-content: center; font-size: 32px; }
.toko-card-body { padding: 16px; }
.toko-card-body h3 { font-size: 15px; margin-bottom: 4px; }
.toko-card-body p { color: #6b7280; font-size: 12px; margin-bottom: 10px; }
.toko-card-actions { display: flex; gap: 6px; flex-wrap: wrap; }

.recent-table { width: 100%; }
.recent-table th, .recent-table td { padding: 12px 16px; font-size: 14px; }
.recent-table thead th { background: #fafafa; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: .3px; font-weight: 600; }
.recent-table tbody tr { border-bottom: 1px solid #f3f4f6; }
.recent-table tbody tr:last-child { border-bottom: none; }
.recent-table tbody tr:hover { background: #fafafa; }
</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('owner/_sidebar', ['current_page' => 'dashboard']); ?>
<div class="admin-main">
<?php $this->load->view('owner/_header', ['page_title' => 'Dashboard Owner', 'breadcrumb' => 'Ringkasan seluruh toko']); ?>
<main class="admin-content">
<div class="welcome-card">
<h2>👑 Selamat datang, Owner!</h2>
<p>Kelola semua toko yang terdaftar di platform SAS TokoRumah. Pantau performa, tambah toko baru, dan lihat semua orderan dari seluruh toko.</p>
</div>

<div class="stats-grid">
<a href="<?= base_url('owner/dashboard') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-label">Total Toko <span class="icon">🏪</span></div>
<div class="stat-value"><?= $total_toko ?></div>
<div class="stat-change">↑ semua toko</div>
</div>
</a>
<a href="<?= base_url('owner/dashboard') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-label">Total Order <span class="icon">📦</span></div>
<div class="stat-value"><?= $total_order ?></div>
<div class="stat-change">↑ semua order</div>
</div>
</a>
<a href="<?= base_url('owner/dashboard') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-label">Total Pendapatan <span class="icon">💰</span></div>
<div class="stat-value" style="font-size:22px;">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
<div class="stat-change">↑ akumulasi</div>
</div>
</a>
</div>

<div class="card">
<div class="card-header">
<div>
<h3 class="card-title">🏪 Daftar Toko</h3>
<div class="card-desc">Semua toko yang terdaftar</div>
</div>
<a href="<?= base_url('owner/toko_tambah') ?>" class="btn btn-primary">+ Tambah Toko</a>
</div>
<div class="card-body">
<?php if (empty($toko)): ?>
<p style="text-align:center;padding:30px;color:#9ca3af;">Belum ada toko. <a href="<?= base_url('owner/toko_tambah') ?>" style="color:#6366f1;">Tambah sekarang</a></p>
<?php else: ?>
<div class="toko-grid">
<?php foreach($toko as $t): $color = $t->tema_warna ?: '#ff6b35'; ?>
<a href="<?= base_url($t->slug) ?>" target="_blank" class="toko-card-link">
<div class="toko-card">
<div class="toko-card-cover" style="background:linear-gradient(135deg, <?= $color ?>, <?= $color ?>cc);">
<?php if ($t->logo): ?>
<img src="<?= base_url('assets/uploads/'.$t->logo) ?>" style="width:100%;height:100%;object-fit:cover;">
<?php else: ?>🏪<?php endif; ?>
</div>
<div class="toko-card-body">
<h3><?= htmlspecialchars($t->nama_toko) ?></h3>
<p>📍 <?= htmlspecialchars($t->kategori) ?> · <?= htmlspecialchars($t->pemilik) ?></p>
<p style="color:#9ca3af;">/<?= $t->slug ?></p>
<div class="toko-card-actions">
<a href="<?= base_url($t->slug) ?>" target="_blank" class="btn btn-secondary btn-sm" onclick="event.stopPropagation()">👀 Lihat</a>
<a href="<?= base_url('owner/toko_edit/'.$t->id) ?>" class="btn btn-secondary btn-sm" onclick="event.stopPropagation()">✏️ Edit</a>
<?php if ($t->status == 'aktif'): ?>
<span class="dt-badge" style="background:#dcfce7;color:#166534;">aktif</span>
<?php else: ?>
<span class="dt-badge" style="background:#fee2e2;color:#991b1b;">nonaktif</span>
<?php endif; ?>
<a href="<?= base_url('owner/toko_hapus/'.$t->id) ?>" class="btn btn-secondary btn-sm" style="color:#dc2626;" onclick="event.stopPropagation(); return confirm('Hapus <?= htmlspecialchars($t->nama_toko) ?>?')">🗑️</a>
</div>
</div>
</div>
</a>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</div>

<div class="card">
<div class="card-header">
<div>
<h3 class="card-title">📦 Orderan Terbaru</h3>
<div class="card-desc">10 order terakhir dari semua toko</div>
</div>
</div>
<?php if (empty($order)): ?>
<div style="text-align:center;padding:30px;color:#9ca3af;">Belum ada orderan</div>
<?php else: ?>
<table class="recent-table">
<thead><tr><th>Kode</th><th>Toko</th><th>Pembeli</th><th>Total</th><th>Bayar</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
<tbody>
<?php foreach(array_slice($order, 0, 10) as $o): ?>
<tr>
<td><strong style="color:#111;"><?= $o->kode_order ?></strong></td>
<td><?= htmlspecialchars($o->nama_toko) ?></td>
<td><?= htmlspecialchars($o->nama_pembeli) ?><br><small style="color:#9ca3af;"><?= htmlspecialchars($o->blok_rumah) ?></small></td>
<td><strong>Rp <?= number_format($o->total_harga, 0, ',', '.') ?></strong></td>
<td>
<span class="dt-badge" style="background:<?= $o->metode_bayar == 'cash' ? '#dcfce7' : '#dbeafe' ?>;color:<?= $o->metode_bayar == 'cash' ? '#166534' : '#1e40af' ?>;"><?= strtoupper($o->metode_bayar) ?></span>
</td>
<td>
<span class="dt-badge" style="background:<?= $o->status_order == 'selesai' ? '#dcfce7' : ($o->status_order == 'diproses' ? '#fef3c7' : ($o->status_order == 'batal' ? '#fee2e2' : '#dbeafe')) ?>;color:<?= $o->status_order == 'selesai' ? '#166534' : ($o->status_order == 'diproses' ? '#92400e' : ($o->status_order == 'batal' ? '#991b1b' : '#1e40af')) ?>;"><?= $o->status_order ?></span>
</td>
<td><span style="color:#6b7280;"><?= date('d/m/Y H:i', strtotime($o->created_at)) ?></span></td>
<td><a href="<?= base_url('owner/order_detail/'.$o->id) ?>" class="btn btn-secondary btn-sm">Detail</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
</div>
</main>
<?php $this->load->view('toko/_footer'); ?>
</div>
</div>
</body>
</html>
