<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$current = isset($current_page) ? $current_page : '';
?>
<nav class="bottom-nav">
<a href="<?= base_url('owner/dashboard') ?>" class="bottom-nav-item <?= $current == 'dashboard' ? 'active' : '' ?>">
<span class="ic">▦</span>
<span class="lb">Beranda</span>
</a>
<a href="<?= base_url('owner/toko_list') ?>" class="bottom-nav-item <?= $current == 'toko_list' ? 'active' : '' ?>">
<span class="ic">🏪</span>
<span class="lb">Toko</span>
</a>
<a href="<?= base_url('owner/akun') ?>" class="bottom-nav-item <?= $current == 'akun' ? 'active' : '' ?>">
<span class="ic">👤</span>
<span class="lb">Akun</span>
</a>
</nav>
