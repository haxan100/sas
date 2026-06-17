<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<style>:root { --tema-color: #6366f1; } @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('owner/_sidebar', ['current_page' => 'dashboard']); ?>
<div class="admin-main">
<?php $this->load->view('owner/_header', ['page_title' => 'Dashboard Owner', 'breadcrumb' => 'Ringkasan seluruh toko']); ?>
<main class="admin-content">
<?php if (!empty($pending_count) && $pending_count > 0): ?>
<a href="<?= base_url('owner/verifikasi') ?>" style="display:block;text-decoration:none;color:inherit;">
<div style="background:linear-gradient(135deg, #f59e0b, #d97706);color:#fff;padding:18px 22px;border-radius:12px;margin-bottom:20px;display:flex;align-items:center;gap:16px;box-shadow:0 4px 16px rgba(245,158,11,.3);transition:transform .2s;">
<div style="font-size:32px;animation:pulse 2s infinite;">⏳</div>
<div style="flex:1;">
<strong style="font-size:15px;display:block;margin-bottom:2px;"><?= $pending_count ?> Toko Menunggu Verifikasi!</strong>
<small style="opacity:.9;font-size:13px;">Klik untuk meninjau pendaftaran toko baru →</small>
</div>
<span style="font-size:20px;">→</span>
</div>
</a>
<?php endif; ?>

<div style="background:linear-gradient(135deg, #6366f1, #4f46e5);color:#fff;padding:28px;border-radius:14px;margin-bottom:20px;box-shadow:0 4px 16px rgba(99,102,241,.3);position:relative;overflow:hidden;">
<div style="position:relative;z-index:1;">
<h2 style="font-size:22px;margin-bottom:6px;">👑 Selamat datang, Owner!</h2>
<p style="opacity:.92;font-size:14px;line-height:1.5;">Kelola semua toko yang terdaftar di <strong>SAS TokoRumah</strong>. Pantau performa, tambah toko baru, dan lihat semua orderan dari seluruh toko.</p>
</div>
<div style="position:absolute;right:-30px;top:-30px;width:130px;height:130px;background:rgba(255,255,255,.1);border-radius:50%;"></div>
</div>

<div class="stats-grid">
<a href="<?= base_url('owner/toko_list') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-icon indigo">🏪</div>
<div class="stat-info">
<h3>Total Toko</h3>
<div class="num"><?= $total_toko ?></div>
</div>
</div>
</a>
<a href="<?= base_url('owner/dashboard') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-icon orange">📦</div>
<div class="stat-info">
<h3>Total Order</h3>
<div class="num"><?= $total_order ?></div>
</div>
</div>
</a>
<a href="<?= base_url('owner/dashboard') ?>" class="stat-card-link">
<div class="stat-card">
<div class="stat-icon green">💰</div>
<div class="stat-info">
<h3>Pendapatan</h3>
<div class="num num-sm">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
</div>
</div>
</a>
</div>

<div class="card">
<div class="card-header">
<div>
<h3 class="card-title">⚡ Aksi Cepat</h3>
<div class="card-desc">Pintasan menu owner</div>
</div>
</div>
<div class="card-body" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:10px;">
<a href="<?= base_url('owner/verifikasi') ?>" class="quick-link" <?= !empty($pending_count) && $pending_count > 0 ? 'style="background:#fffbeb;border-color:#f59e0b;"' : '' ?>>
<div class="quick-link-icon" style="background:linear-gradient(135deg, #f59e0b, #d97706);">✅</div>
<div class="quick-link-text">
<h4>Verifikasi</h4>
<small>Aktifkan toko baru <?= !empty($pending_count) && $pending_count > 0 ? '('.$pending_count.' pending)' : '' ?></small>
</div>
<span class="quick-link-arrow">→</span>
</a>
<a href="<?= base_url('owner/toko_list') ?>" class="quick-link">
<div class="quick-link-icon" style="background:linear-gradient(135deg, #6366f1, #4f46e5);">🏪</div>
<div class="quick-link-text">
<h4>Kelola Toko</h4>
<small>Tambah, edit, hapus toko</small>
</div>
<span class="quick-link-arrow">→</span>
</a>
<a href="<?= base_url('logs') ?>" class="quick-link">
<div class="quick-link-icon" style="background:linear-gradient(135deg, #8b5cf6, #7c3aed);">📋</div>
<div class="quick-link-text">
<h4>Activity Logs</h4>
<small>Monitor semua aktivitas</small>
</div>
<span class="quick-link-arrow">→</span>
</a>
<a href="<?= base_url('owner/akun') ?>" class="quick-link">
<div class="quick-link-icon" style="background:linear-gradient(135deg, #6366f1, #4f46e5);">👤</div>
<div class="quick-link-text">
<h4>Akun Saya</h4>
<small>Edit username & password</small>
</div>
<span class="quick-link-arrow">→</span>
</a>
<a href="<?= base_url() ?>" target="_blank" class="quick-link">
<div class="quick-link-icon" style="background:linear-gradient(135deg, #6366f1, #4f46e5);">👀</div>
<div class="quick-link-text">
<h4>Beranda</h4>
<small>Lihat halaman utama</small>
</div>
<span class="quick-link-arrow">↗</span>
</a>
</div>
</div>

<div class="card">
<div class="card-header">
<div>
<h3 class="card-title">🏪 Daftar Toko Aktif</h3>
<div class="card-desc"><?= $total_toko ?> toko terdaftar · <?= $aktif_count ?> aktif · <?= $pending_count ?> pending</div>
</div>
<a href="<?= base_url('owner/toko_list') ?>" class="btn btn-secondary btn-sm">Kelola semua →</a>
</div>
<?php if (empty($toko)): ?>
<div style="text-align:center;padding:30px;color:#9ca3af;">Belum ada toko. <a href="<?= base_url('owner/toko_list') ?>" style="color:#6366f1;">Tambah sekarang</a></div>
<?php else: ?>
<table class="recent-table">
<thead><tr><th>Nama Toko</th><th>Pemilik</th><th>Slug</th><th>Status</th><th>Order</th></tr></thead>
<tbody>
<?php foreach ($toko as $t): ?>
<tr>
<td><strong><?= htmlspecialchars($t->nama_toko) ?></strong></td>
<td><?= htmlspecialchars($t->pemilik) ?></td>
<td><a href="<?= base_url($t->slug) ?>" target="_blank" style="color:#6366f1;">/<?= $t->slug ?></a></td>
<td><span class="dt-badge" style="background:<?= $t->status == 'aktif' ? '#dcfce7' : '#fee2e2' ?>;color:<?= $t->status == 'aktif' ? '#166534' : '#991b1b' ?>;"><?= $t->status ?></span></td>
<td><span class="dt-badge" style="background:#dbeafe;color:#1e40af;"><?= $this->db->get_where('orders', ['toko_id' => $t->id])->num_rows() ?> order</span></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
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
<thead><tr><th>Kode</th><th>Toko</th><th>Pembeli</th><th>Total</th><th>Tanggal</th></tr></thead>
<tbody>
<?php foreach(array_slice($order, 0, 10) as $o): ?>
<tr>
<td><strong><?= $o->kode_order ?></strong></td>
<td><?= htmlspecialchars($o->nama_toko) ?></td>
<td><?= htmlspecialchars($o->nama_pembeli) ?><br><small style="color:#9ca3af;"><?= htmlspecialchars($o->blok_rumah) ?></small></td>
<td><strong>Rp <?= number_format($o->total_harga, 0, ',', '.') ?></strong></td>
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
</body>
</html>
