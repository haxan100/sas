<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$page_title = isset($page_title) ? $page_title : 'Owner';
$breadcrumb = isset($breadcrumb) ? $breadcrumb : '';
$owner_nama = $this->session->userdata('owner_nama') ?: 'Owner';
$owner_initial = strtoupper(substr($owner_nama, 0, 1));
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
<a href="<?= base_url() ?>" class="icon-btn" title="Beranda">🏠</a>
<a href="<?= base_url('owner/akun') ?>" class="user-avatar" title="<?= htmlspecialchars($owner_nama) ?>" style="background:linear-gradient(135deg, #6366f1, #4f46e5);"><?= $owner_initial ?></a>
</div>
</header>
