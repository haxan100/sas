<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$current = isset($current_page) ? $current_page : '';
?>
<aside class="admin-sidebar" id="adminSidebar">
<div class="sidebar-brand">
<div class="logo-box" style="background:linear-gradient(135deg, #6366f1, #4f46e5);">👑</div>
<div>
<h2>SAS Owner</h2>
<small>Super Admin Panel</small>
</div>
</div>

<div class="sidebar-section">
<div class="sidebar-section-title">Manajemen</div>
<a href="<?= base_url('owner/dashboard') ?>" class="sidebar-link <?= $current == 'dashboard' ? 'active' : '' ?>">
<span class="icon">▦</span> Dashboard
</a>
<a href="<?= base_url('owner/toko_tambah') ?>" class="sidebar-link <?= $current == 'toko_tambah' ? 'active' : '' ?>">
<span class="icon">➕</span> Tambah Toko
</a>
</div>

<div class="sidebar-section" style="margin-top:auto;">
<a href="<?= base_url('owner/logout') ?>" class="sidebar-link" style="color:#ef4444;">
<span class="icon">🚪</span> Logout
</a>
</div>
</aside>
