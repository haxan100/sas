<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$slug = $toko->slug;
$current = isset($current_page) ? $current_page : '';
$page_title = isset($page_title) ? $page_title : 'Dashboard';
$breadcrumb = isset($breadcrumb) ? $breadcrumb : '';
?>
<header class="admin-header">
<div class="admin-header-left">
<button class="menu-btn" onclick="toggleSidebar()">☰</button>
<div>
<h1><?= $page_title ?></h1>
<?php if ($breadcrumb): ?>
<div class="breadcrumb"><?= $breadcrumb ?></div>
<?php endif; ?>
</div>
</div>
<div class="admin-header-right">
<div class="search-box">
<span>🔍</span>
<input type="text" placeholder="Cari...">
<kbd>⌘K</kbd>
</div>
<button class="icon-btn" title="Notifikasi">🔔</button>
<a href="<?= base_url('admin/akun') ?>" class="user-avatar" title="<?= htmlspecialchars($toko->pemilik) ?>">
<?= strtoupper(substr($toko->pemilik, 0, 1)) ?>
</a>
</div>
</header>
