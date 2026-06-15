<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$current = isset($current_page) ? $current_page : '';
?>
<nav class="bottom-nav">
<a href="<?= base_url('admin/dashboard') ?>" class="bottom-nav-item <?= $current == 'dashboard' ? 'active' : '' ?>">
<span class="ic">▦</span>
<span class="lb">Beranda</span>
</a>
<a href="<?= base_url('admin/orders') ?>" class="bottom-nav-item <?= $current == 'orders' ? 'active' : '' ?>">
<span class="ic">📦</span>
<span class="lb">Orderan</span>
<?php if (isset($unread_orders) && $unread_orders > 0): ?>
<span class="badge-num"><?= $unread_orders ?></span>
<?php endif; ?>
</a>
<a href="<?= base_url('admin/produk') ?>" class="bottom-nav-item <?= $current == 'produk' ? 'active' : '' ?>">
<span class="ic">🍜</span>
<span class="lb">Produk</span>
</a>
<a href="<?= base_url('admin/kategori') ?>" class="bottom-nav-item <?= $current == 'kategori' ? 'active' : '' ?>">
<span class="ic">🏷️</span>
<span class="lb">Kategori</span>
</a>
<a href="<?= base_url('admin/akun') ?>" class="bottom-nav-item <?= $current == 'akun' ? 'active' : '' ?>">
<span class="ic">👤</span>
<span class="lb">Akun</span>
</a>
</nav>
