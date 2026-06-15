<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?> · <?= htmlspecialchars($toko->nama_toko) ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<?php $this->load->view('toko/_tema', ['toko' => $toko]); ?>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('toko/_sidebar', ['toko' => $toko, 'current_page' => 'dashboard']); ?>
<div class="admin-main">
<?php $this->load->view('toko/_header', ['toko' => $toko, 'current_page' => 'dashboard', 'page_title' => 'Beranda', 'breadcrumb' => 'Ringkasan toko']); ?>
<main class="admin-content">
<div class="welcome-card">
<h2>👋 Hai, <?= htmlspecialchars($toko->pemilik) ?>!</h2>
<p>Selamat datang di dashboard <strong><?= htmlspecialchars($toko->nama_toko) ?></strong>.</p>
</div>

<div class="stats-grid">
<a href="<?= base_url('admin/orders') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-icon orange">📦</div>
<div class="stat-info">
<h3>Order</h3>
<div class="num"><?= $total_order ?></div>
</div>
</div>
</a>
<a href="<?= base_url('admin/orders') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-icon green">💰</div>
<div class="stat-info">
<h3>Pendapatan</h3>
<div class="num num-sm">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
</div>
</div>
</a>
<a href="<?= base_url('admin/produk') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-icon blue">🍜</div>
<div class="stat-info">
<h3>Produk</h3>
<div class="num"><?= count($produk) ?></div>
</div>
</div>
</a>
</div>

<div class="card">
<div class="card-header">
<div>
<h3 class="card-title">⚡ Aksi Cepat</h3>
<div class="card-desc">Pintasan menu</div>
</div>
</div>
<div class="card-body" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:10px;">
<a href="<?= base_url('admin/produk') ?>" class="quick-link">
<div class="quick-link-icon">🍜</div>
<div class="quick-link-text">
<h4>Produk</h4>
<small>Tambah & edit menu</small>
</div>
<span class="quick-link-arrow">→</span>
</a>
<a href="<?= base_url('admin/orders') ?>" class="quick-link">
<div class="quick-link-icon">📦</div>
<div class="quick-link-text">
<h4>Orderan</h4>
<small>Lihat pesanan masuk</small>
</div>
<span class="quick-link-arrow">→</span>
</a>
<a href="<?= base_url('admin/kategori') ?>" class="quick-link">
<div class="quick-link-icon">🏷️</div>
<div class="quick-link-text">
<h4>Kategori</h4>
<small>Kelompokkan produk</small>
</div>
<span class="quick-link-arrow">→</span>
</a>
<a href="<?= base_url($toko->slug) ?>" target="_blank" class="quick-link">
<div class="quick-link-icon">👀</div>
<div class="quick-link-text">
<h4>Lihat Toko</h4>
<small>Buka dari sisi user</small>
</div>
<span class="quick-link-arrow">↗</span>
</a>
</div>
</div>

<div class="card">
<div class="card-header">
<div>
<h3 class="card-title">📦 Orderan Terbaru</h3>
<div class="card-desc">5 pesanan terakhir</div>
</div>
<a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary btn-sm">Lihat semua →</a>
</div>
<?php if (empty($orders)): ?>
<div style="text-align:center;padding:30px;color:#9ca3af;">Belum ada orderan</div>
<?php else: ?>
<table class="recent-table">
<thead><tr><th>Kode</th><th>Pembeli</th><th>Total</th><th>Status</th><th>Tanggal</th></tr></thead>
<tbody>
<?php foreach(array_slice($orders, 0, 5) as $o): ?>
<tr>
<td><strong><?= $o->kode_order ?></strong></td>
<td><?= htmlspecialchars($o->nama_pembeli) ?><br><small style="color:#9ca3af;"><?= htmlspecialchars($o->blok_rumah) ?></small></td>
<td><strong>Rp <?= number_format($o->total_harga, 0, ',', '.') ?></strong></td>
<td>
<span class="dt-badge" style="background:<?= $o->metode_bayar == 'cash' ? '#dcfce7' : '#dbeafe' ?>;color:<?= $o->metode_bayar == 'cash' ? '#166534' : '#1e40af' ?>;"><?= strtoupper($o->metode_bayar) ?></span>
</td>
<td><span style="color:#6b7280;"><?= date('d/m/Y H:i', strtotime($o->created_at)) ?></span></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
</div>
</main>
<?php $this->load->view('toko/_bottom_nav', ['current_page' => 'dashboard']); ?>
</div>
</div>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>
</html>
