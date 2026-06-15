<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$slug = $toko->slug;
$current = isset($current_page) ? $current_page : '';
?>
<aside class="admin-sidebar" id="adminSidebar" style="--tema: <?= $toko->tema_warna ?: '#ff6b35' ?>;">
<div class="sidebar-brand">
<div class="logo-box">🏪</div>
<div>
<h2><?= htmlspecialchars($toko->nama_toko) ?></h2>
<small>Admin Panel</small>
</div>
</div>

<div class="sidebar-section">
<div class="sidebar-section-title">General</div>
<a href="<?= base_url('admin/dashboard') ?>" class="sidebar-link <?= $current == 'dashboard' ? 'active' : '' ?>">
<span class="icon">▦</span> Dashboard
</a>
<a href="<?= base_url('admin/orders') ?>" class="sidebar-link <?= $current == 'orders' ? 'active' : '' ?>">
<span class="icon">📦</span> Orderan
<?php if (isset($unread_orders) && $unread_orders > 0): ?>
<span class="badge-num"><?= $unread_orders ?></span>
<?php endif; ?>
</a>
<a href="<?= base_url('admin/produk') ?>" class="sidebar-link <?= $current == 'produk' ? 'active' : '' ?>">
<span class="icon">🍜</span> Produk
</a>
<a href="<?= base_url('admin/kategori') ?>" class="sidebar-link <?= $current == 'kategori' ? 'active' : '' ?>">
<span class="icon">🏷️</span> Kategori
</a>
</div>

<div class="sidebar-section">
<div class="sidebar-section-title">Akun</div>
<a href="<?= base_url('admin/akun') ?>" class="sidebar-link <?= $current == 'akun' ? 'active' : '' ?>">
<span class="icon">👤</span> Akun Saya
</a>
<a href="<?= base_url('admin/pengaturan') ?>" class="sidebar-link <?= $current == 'pengaturan' ? 'active' : '' ?>">
<span class="icon">⚙️</span> Pengaturan Toko
</a>
<a href="<?= base_url($slug) ?>" target="_blank" class="sidebar-link">
<span class="icon">👀</span> Lihat Toko
</a>
</div>

<div class="sidebar-section" style="margin-top:auto;">
<a href="<?= base_url('admin/logout') ?>" class="sidebar-link" style="color:#ef4444;">
<span class="icon">🚪</span> Logout
</a>
</div>
</aside>
