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
<a href="<?= base_url('owner/toko_list') ?>" class="sidebar-link <?= $current == 'toko_list' ? 'active' : '' ?>">
<span class="icon">🏪</span> Toko
</a>
</div>

<div class="sidebar-section">
<div class="sidebar-section-title">Akun</div>
<a href="<?= base_url('owner/akun') ?>" class="sidebar-link <?= $current == 'akun' ? 'active' : '' ?>">
<span class="icon">👤</span> Akun Saya
</a>
</div>

<div class="sidebar-section" style="margin-top:auto;">
<a href="<?= base_url('owner/logout') ?>" class="sidebar-link" style="color:#ef4444;">
<span class="icon">🚪</span> Logout
</a>
</div>
</aside>
<script>
function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('show');
    document.getElementById('adminOverlay').classList.toggle('show');
}
</script>
