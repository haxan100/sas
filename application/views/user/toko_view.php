<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?= htmlspecialchars($toko->nama_toko) ?> - Pesan Online</title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
:root { --tema: <?= $toko->tema_warna ?: '#ff6b35' ?>; --tema-light: <?= $toko->tema_warna ?: '#ff6b35' ?>22; }
* { -webkit-tap-highlight-color: transparent; }
body { background: #f5f7fb; }

.btn-pesan { background: var(--tema); color: #fff; border: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; }
.btn-pesan:hover { filter: brightness(0.9); }
.btn-pesan:disabled { background: #ccc; cursor: not-allowed; }

/* Header */
.user-header { background: linear-gradient(135deg, var(--tema), var(--tema)); color: #fff; padding: 24px 16px 20px; text-align: center; }
.user-header .logo-circle { width: 76px; height: 76px; border-radius: 50%; background: #fff; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,.15); }
.user-header .logo-circle img { width: 100%; height: 100%; object-fit: cover; }
.user-header h1 { font-size: 22px; margin-bottom: 4px; font-weight: 700; }
.user-header p { font-size: 13px; opacity: .9; }
.user-header .info-row { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; margin-top: 10px; font-size: 12px; }
.user-header .info-row span { background: rgba(255,255,255,.2); padding: 4px 10px; border-radius: 12px; }

/* Body container */
.user-body { background: #f5f7fb; border-radius: 24px 24px 0 0; margin-top: -16px; padding: 20px 14px 120px; min-height: 60vh; position: relative; z-index: 1; }

/* Search */
.search-box { background: #fff; border-radius: 12px; padding: 10px 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,.04); }
.search-box input { flex: 1; border: none; outline: none; font-size: 14px; }

/* Category Tabs */
.cat-tabs { display: flex; gap: 8px; overflow-x: auto; padding: 4px 0 12px; margin-bottom: 8px; scrollbar-width: none; }
.cat-tabs::-webkit-scrollbar { display: none; }
.cat-tab { flex-shrink: 0; padding: 8px 16px; background: #fff; border-radius: 20px; font-size: 13px; font-weight: 600; color: #555; cursor: pointer; border: 1.5px solid transparent; transition: all .2s; }
.cat-tab.active { background: var(--tema); color: #fff; box-shadow: 0 4px 12px var(--tema-light); }
.cat-tab:hover:not(.active) { border-color: var(--tema); color: var(--tema); }

/* Section title */
.section-title { font-size: 16px; font-weight: 700; margin: 16px 0 12px; color: #333; display: flex; justify-content: space-between; align-items: center; }
.section-title .count { font-size: 12px; color: #888; font-weight: 500; }

/* Product Card - New design: foto di kanan, info di kiri */
.produk-list { display: flex; flex-direction: column; gap: 12px; }
.produk-card { display: flex; gap: 12px; padding: 14px; background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.05); position: relative; transition: transform .15s; align-items: stretch; min-height: 120px; }
.produk-card:active { transform: scale(0.99); }
.produk-info { flex: 1; display: flex; flex-direction: column; justify-content: space-between; min-width: 0; }
.produk-info h4 { font-size: 15px; margin-bottom: 4px; color: #222; font-weight: 700; line-height: 1.3; }
.produk-info .desc { font-size: 12px; color: #888; margin-bottom: 8px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.produk-info .harga-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 8px; flex-wrap: wrap; }
.produk-info .harga { color: var(--tema); font-weight: 700; font-size: 17px; }
.produk-info .harga-coret { color: #999; text-decoration: line-through; font-size: 12px; font-weight: 500; }
.produk-info .stok-row { display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-top: auto; }
.produk-info .stok { font-size: 11px; color: #999; }
.produk-info .habis { color: #e74c3c; font-weight: 600; font-size: 11px; }
.produk-foto { width: 110px; height: 110px; border-radius: 12px; background: #f5f5f5; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; font-size: 40px; position: relative; }
.produk-foto img { width: 100%; height: 100%; object-fit: cover; }
.diskon-badge { position: absolute; top: 6px; left: 6px; background: #e74c3c; color: #fff; font-size: 10px; font-weight: 700; padding: 3px 7px; border-radius: 6px; z-index: 2; }
.produk-action-row { display: flex; align-items: center; gap: 6px; }
.qty-btn { width: 30px; height: 30px; border: none; background: #f0f0f0; color: #333; border-radius: 8px; font-size: 18px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.qty-btn.plus { background: var(--tema); color: #fff; }
.qty-btn:active { transform: scale(0.9); }
.qty-input { width: 32px; text-align: center; border: none; background: transparent; font-weight: 700; font-size: 14px; }

/* Tombol Tambah Pill */
.btn-tambah { background: #27ae60; color: #fff; border: none; padding: 7px 16px; border-radius: 20px; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; }
.cart-item { padding: 14px 0; border-bottom: 1px solid #f0f0f0; }
.cart-item-row { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
.cart-item-name { flex: 1; min-width: 0; }
.cart-item-name strong { font-size: 14px; color: #222; display: block; }
.cart-item-name small { font-size: 12px; color: #888; }
.cart-item-qty { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.cart-item-subtotal { min-width: 80px; text-align: right; font-weight: 700; color: var(--tema); font-size: 14px; flex-shrink: 0; }
.cart-item-note { display: flex; align-items: center; gap: 6px; margin-top: 4px; padding-left: 4px; }
.cart-item-note input { flex: 1; padding: 8px 10px; border: 1.5px solid #e8e8e8; border-radius: 8px; font-size: 12px; font-family: inherit; background: #fafafa; }
.cart-item-note input:focus { outline: none; border-color: var(--tema); background: #fff; }
.cart-item-note .icon { color: #999; font-size: 14px; }
.cart-item-remove { background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 18px; padding: 0 4px; }

.cart-item-controls { display: flex; align-items: center; gap: 6px; }
.qty-btn.cart { width: 30px; height: 30px; font-size: 16px; }

/* Sticky bottom bar - SELALU tampil */
.cart-bottom-bar { position: fixed; bottom: 0; left: 0; right: 0; max-width: 480px; margin: 0 auto; background: #fff; box-shadow: 0 -4px 20px rgba(0,0,0,.1); padding: 12px 16px; z-index: 90; border-radius: 16px 16px 0 0; transition: background .2s; }
.cart-bottom-bar.empty { background: #f8f9fa; }
.cart-bottom-bar-content { display: flex; justify-content: space-between; align-items: center; gap: 12px; }
.cart-bottom-left { display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0; }
.cart-bottom-icon { width: 44px; height: 44px; background: #f0f0f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
.cart-bottom-bar.has-items .cart-bottom-icon { background: var(--tema-light); }
.cart-bottom-text { display: flex; flex-direction: column; min-width: 0; flex: 1; }
.cart-bottom-text .title { font-size: 14px; font-weight: 700; color: #333; }
.cart-bottom-text .sub { font-size: 12px; color: #888; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cart-bottom-bar.has-items .cart-bottom-text .sub { color: var(--tema); font-weight: 600; }
.btn-lanjut { background: var(--tema); color: #fff; border: none; padding: 12px 20px; border-radius: 24px; font-weight: 700; font-size: 14px; cursor: pointer; white-space: nowrap; flex-shrink: 0; }
.btn-lanjut:disabled { background: #ccc; cursor: not-allowed; }
.btn-lanjut:hover:not(:disabled) { filter: brightness(0.9); }
.btn-lanjut.added { background: #27ae60; }

/* Modal */
.modal { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,.5); z-index: 200; align-items: flex-end; }
.modal.show { display: flex; }
.modal-content { background: #fff; width: 100%; max-width: 480px; margin: 0 auto; border-radius: 20px 20px 0 0; padding: 20px; max-height: 90vh; overflow-y: auto; animation: slideUp .3s; }
@keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
.modal-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #eee; }
.modal-head h3 { font-size: 18px; }
.modal-close { background: none; border: none; font-size: 24px; color: #888; cursor: pointer; }

/* Form */
.form-group-mobile { margin-bottom: 14px; }
.form-group-mobile label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #555; }
.form-group-mobile input, .form-group-mobile textarea, .form-group-mobile select { width: 100%; padding: 12px 14px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 14px; font-family: inherit; }
.form-group-mobile input:focus, .form-group-mobile textarea:focus, .form-group-mobile select:focus { outline: none; border-color: var(--tema); }

.order-summary { background: #f8f9fa; padding: 12px; border-radius: 10px; margin: 12px 0; }
.order-summary-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; }
.order-summary-total { border-top: 1px solid #ddd; padding-top: 8px; margin-top: 8px; font-weight: 700; font-size: 16px; }

/* Payment options - custom radio */
.pay-methods { display: flex; flex-direction: column; gap: 10px; }
.payment-option { display: flex; align-items: center; gap: 12px; padding: 14px; border: 2px solid #e0e0e0; border-radius: 12px; cursor: pointer; transition: all .2s; background: #fff; }
.payment-option:hover { border-color: var(--tema); }
.payment-option.active { border-color: var(--tema); background: var(--tema-light); }
.payment-radio { width: 22px; height: 22px; border: 2px solid #ccc; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; transition: all .2s; }
.payment-option.active .payment-radio { border-color: var(--tema); }
.payment-option.active .payment-radio::after { content: ''; width: 12px; height: 12px; background: var(--tema); border-radius: 50%; }
.payment-option input[type="radio"] { display: none; }
.payment-info { flex: 1; }
.payment-info strong { display: block; font-size: 14px; color: #333; margin-bottom: 2px; }
.payment-info small { font-size: 12px; color: #888; }
.payment-icon { font-size: 24px; flex-shrink: 0; }

.rek-info { background: linear-gradient(135deg, #e3f2fd, #bbdefb); padding: 14px; border-radius: 10px; margin: 10px 0; font-size: 14px; color: #1565c0; border-left: 4px solid #1976d2; }
.rek-info strong { color: #0d47a1; }
.rek-info .rek-num { font-size: 18px; font-weight: 700; letter-spacing: 0.5px; }

.checkbox-row { display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px; background: #fff8e1; border-radius: 10px; margin: 10px 0; font-size: 13px; color: #856404; border-left: 4px solid #ffc107; }
.checkbox-row input { display: none; }
.checkbox-row .check-box { width: 22px; height: 22px; border: 2px solid #ffc107; border-radius: 6px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: #fff; transition: all .2s; margin-top: 2px; }
.checkbox-row input:checked + .check-box { background: #ffc107; }
.checkbox-row input:checked + .check-box::after { content: '✓'; color: #fff; font-weight: 700; font-size: 14px; }

/* Order summary - warna JELAS */
.order-summary { background: #f0f4f8; padding: 14px 16px; border-radius: 12px; margin: 14px 0; border: 1px solid #e0e7ed; }
.order-summary-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; color: #333; }
.order-summary-row span:first-child { color: #555; font-weight: 500; }
.order-summary-row span:last-child { color: #222; font-weight: 600; }
.order-summary-total { border-top: 2px dashed #c0c8d0; padding-top: 10px; margin-top: 10px; font-weight: 700; font-size: 17px; }
.order-summary-total span { color: #222 !important; }
.order-summary-total span:last-child { color: var(--tema) !important; font-size: 19px; }

.wa-button { display: block; width: 100%; padding: 14px; background: #25D366; color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; text-align: center; margin-top: 12px; text-decoration: none; }
.wa-button:hover { background: #1ebd5a; }

.empty-state { text-align: center; padding: 60px 20px; color: #888; }
.empty-state .icon { font-size: 64px; margin-bottom: 10px; opacity: .5; }

@media(max-width: 480px) {
  .cat-tabs { padding-left: 4px; padding-right: 4px; }
}
</style>
</head>
<body>
<div class="user-wrap">
<div class="user-header">
<div class="logo-circle">
<?php if ($toko->logo): ?>
<img src="<?= base_url('assets/uploads/'.$toko->logo) ?>">
<?php else: ?>
<div style="font-size:40px;">🏪</div>
<?php endif; ?>
</div>
<h1><?= htmlspecialchars($toko->nama_toko) ?></h1>
<p>📍 <?= htmlspecialchars($toko->kategori ?: 'Toko') ?> · <?= htmlspecialchars($toko->pemilik) ?></p>
<div class="info-row">
<?php if ($toko->alamat): ?><span>📍 <?= htmlspecialchars($toko->alamat) ?></span><?php endif; ?>
<?php if ($toko->no_rek): ?><span>💳 <?= htmlspecialchars($toko->nama_bank) ?></span><?php endif; ?>
</div>
</div>

<div class="user-body">
<?php if (empty($produk)): ?>
<div class="empty-state">
<div class="icon">🍽️</div>
<h3>Belum ada menu</h3>
<p>Toko ini belum menambahkan menu. Silakan cek nanti.</p>
</div>
<?php else: ?>

<div class="search-box">
<span style="font-size:18px;">🔍</span>
<input type="text" id="searchInput" placeholder="Cari menu..." oninput="filterProduk()">
</div>

<?php if (!empty($kategori) && count($kategori) > 1): ?>
<div class="cat-tabs" id="catTabs">
<div class="cat-tab active" data-cat="all" onclick="filterCat('all', this)">🍽️ Semua</div>
<?php foreach ($kategori as $k): ?>
<div class="cat-tab" data-cat="<?= htmlspecialchars($k->nama) ?>" onclick="filterCat('<?= htmlspecialchars($k->nama) ?>', this)">
<?= htmlspecialchars($k->nama) ?>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<div class="produk-list" id="produkList">
<?php foreach ($produk as $p):
    $harga_final = (!empty($p->harga_diskon) && $p->harga_diskon > 0 && $p->harga_diskon < $p->harga) ? $p->harga_diskon : $p->harga;
    $has_diskon = (!empty($p->harga_diskon) && $p->harga_diskon > 0 && $p->harga_diskon < $p->harga);
    $pct = $has_diskon ? round((($p->harga - $p->harga_diskon) / $p->harga) * 100) : 0;
?>
<div class="produk-card" data-cat="<?= htmlspecialchars($p->kategori ?: 'Lainnya') ?>" data-nama="<?= htmlspecialchars(strtolower($p->nama_produk)) ?>">
<div class="produk-info">
<h4><?= htmlspecialchars($p->nama_produk) ?></h4>
<?php if ($p->deskripsi): ?>
<div class="desc"><?= htmlspecialchars($p->deskripsi) ?></div>
<?php endif; ?>
<div class="harga-row">
<span class="harga">Rp <?= number_format($harga_final, 0, ',', '.') ?></span>
<?php if ($has_diskon): ?>
<span class="harga-coret">Rp <?= number_format($p->harga, 0, ',', '.') ?></span>
<?php endif; ?>
</div>
<div class="stok-row">
<?php if ($p->status == 'habis' || $p->stok <= 0): ?>
<span class="habis">⚠️ Stok Habis</span>
<?php else: ?>
<span class="stok">Stok: <?= $p->stok ?></span>
<div class="produk-action-row" id="action-<?= $p->id ?>">
<button class="btn-tambah" onclick="tambahItem(<?= $p->id ?>)">+ Tambah</button>
</div>
<div class="produk-action-row" id="qty-row-<?= $p->id ?>" style="display:none;">
<button class="qty-btn" onclick="updateQty(<?= $p->id ?>, -1)">−</button>
<input type="number" id="qty-<?= $p->id ?>" class="qty-input" value="0" min="0" max="<?= $p->stok ?>" readonly>
<button class="qty-btn plus" onclick="updateQty(<?= $p->id ?>, 1)">+</button>
</div>
<?php endif; ?>
</div>
</div>
<div class="produk-foto">
<?php if ($has_diskon): ?><div class="diskon-badge"><?= $pct ?>%</div><?php endif; ?>
<?php if ($p->foto): ?>
<img src="<?= base_url('assets/uploads/'.$p->foto) ?>">
<?php else: ?>
🍽️
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>

<div class="empty-state" id="emptyFilter" style="display:none;">
<div class="icon">🔍</div>
<p>Menu tidak ditemukan</p>
</div>

<?php endif; ?>
</div>

<!-- Sticky Bottom Bar - SELALU tampil -->
<div class="cart-bottom-bar empty" id="cartBottomBar">
<div class="cart-bottom-bar-content">
<div class="cart-bottom-left">
<div class="cart-bottom-icon" id="cartIcon">🛒</div>
<div class="cart-bottom-text">
<div class="title" id="barTitle">Keranjang Kosong</div>
<div class="sub" id="barSub">Belum ada item dipilih</div>
</div>
</div>
<button class="btn-lanjut" id="btnLanjut" onclick="openCart()" disabled>+ Pilih Menu</button>
</div>
</div>

<!-- Cart Modal -->
<div class="modal" id="cartModal">
<div class="modal-content">
<div class="modal-head">
<h3>🛒 Keranjang</h3>
<button class="modal-close" onclick="closeCart()">✕</button>
</div>
<div id="cart-items"></div>
<div id="cart-empty" style="text-align:center;padding:30px;color:#888;">Keranjang kosong</div>
<div id="cart-footer" style="display:none;">
<div class="order-summary" style="background:transparent;padding:0;">
<div class="order-summary-row">
<span>Total Item</span>
<span id="cart-count-text">0</span>
</div>
<div class="order-summary-row order-summary-total">
<span>Total Harga</span>
<span id="cart-total" style="color:var(--tema);">Rp 0</span>
</div>
</div>
<button class="btn-pesan btn-block" onclick="goOrder()" style="margin-top:14px;">Lanjut Pesan →</button>
</div>
</div>
</div>

<!-- Order Modal -->
<div class="modal" id="orderModal">
<div class="modal-content">
<div class="modal-head">
<h3>📝 Data Pemesan</h3>
<button class="modal-close" onclick="closeOrder()">✕</button>
</div>
<form id="orderForm">
<div class="form-group-mobile">
<label>Nama Anda *</label>
<input type="text" name="nama_pembeli" required placeholder="contoh: Pak Rudi">
</div>
<div class="form-group-mobile">
<label>Blok Rumah *</label>
<input type="text" name="blok_rumah" required placeholder="contoh: A-12">
</div>
<div class="form-group-mobile">
<label>No WhatsApp (opsional)</label>
<input type="text" name="no_wa_pembeli" placeholder="628123456789">
</div>
<div class="form-group-mobile">
<label>Catatan (opsional)</label>
<textarea name="catatan" rows="2" placeholder="Pedas, kurang garam, dll"></textarea>
</div>

<div class="form-group-mobile">
<label>Metode Pembayaran *</label>
<label class="payment-option" onclick="selectPay('cash', this)">
<div class="payment-radio"></div>
<span class="payment-icon">💵</span>
<div class="payment-info">
<strong>Cash / Bayar di Tempat</strong>
<small>Bayar saat barang sampai</small>
</div>
<input type="radio" name="metode_bayar" value="cash" required>
</label>
<label class="payment-option" onclick="selectPay('transfer', this)">
<div class="payment-radio"></div>
<span class="payment-icon">🏦</span>
<div class="payment-info">
<strong>Transfer Bank</strong>
<small>Transfer ke rekening toko</small>
</div>
<input type="radio" name="metode_bayar" value="transfer" required>
</label>
</div>

<div class="rek-info" id="rekInfo" style="display:none;">
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
<strong>💳 Transfer ke Rekening Toko:</strong>
<button type="button" class="info-btn-user" onclick="showUserPayInfo()" title="Info pembayaran">?</button>
</div>
<span style="font-size:12px;opacity:0.8;">Bank:</span> <?= $toko->nama_bank ?: '-' ?><br>
<span style="font-size:12px;opacity:0.8;">No Rek:</span> <span class="rek-num"><?= $toko->no_rek ?: '-' ?></span><br>
<span style="font-size:12px;opacity:0.8;">a.n.</span> <?= $toko->atas_nama ?: '-' ?>
<div style="margin-top:8px;padding-top:8px;border-top:1px solid rgba(21,101,192,0.2);font-size:11px;color:#1565c0;">
✅ Bayar langsung ke rekening toko<br>
✅ Tidak ada potongan biaya admin
</div>
</div>

<!-- User Payment Info Modal -->
<div class="user-modal-overlay" id="userPayModalOverlay" onclick="closeUserPayInfo()">
<div class="user-modal" id="userPayModal">
<button class="user-modal-close" onclick="closeUserPayInfo()">✕</button>
<div class="user-modal-content">
<div class="user-modal-header">
<div class="user-modal-icon">💳</div>
<h3>Informasi Pembayaran Transfer</h3>
</div>
<div class="user-modal-body">
<p>Saat Anda memilih metode <strong>Transfer Bank</strong>, Anda akan membayar langsung ke rekening toko.</p>
<div class="user-highlight">
<span class="user-highlight-icon">✅</span>
<div>
<strong>Keuntungan untuk Anda:</strong>
<ul>
<li>Tidak ada biaya admin/potongan</li>
<li>Uang langsung masuk ke rekening toko</li>
<li>Transaksi lebih aman & transparan</li>
</ul>
</div>
</div>
<div class="user-highlight user-highlight-blue">
<span class="user-highlight-icon">ℹ️</span>
<div>
<strong>Cara Transfer:</strong>
<ol>
<li>Salin nomor rekening yang tertera</li>
<li>Buka aplikasi m-banking Anda</li>
<li>Transfer sesuai total pesanan</li>
<li>Centang "Sudah transfer" jika sudah selesai</li>
</ol>
</div>
</div>
</div>
</div>
</div>
</div>

<label class="checkbox-row" id="sudahTfRow" style="display:none;">
<input type="checkbox" name="status_bayar" value="1">
<div class="check-box"></div>
<div>
<strong>Sudah transfer</strong><br>
<span style="color:#856404;">Centang jika sudah transfer. Kalau belum, kosongkan saja.</span>
</div>
</label>

<div class="order-summary" id="orderSummary"></div>

<input type="hidden" name="cart" id="cartInput">
<button type="submit" class="btn-pesan btn-block" style="margin-top:14px;padding:14px;">📱 Lanjut ke WhatsApp →</button>
</form>
</div>
</div>

<!-- Success Modal -->
<div class="modal" id="successModal">
<div class="modal-content" style="text-align:center;padding:30px;">
<div style="font-size:60px;margin-bottom:14px;">✅</div>
<h3>Pesanan Berhasil!</h3>
<p style="color:#888;margin:10px 0 8px;font-size:14px;">Kode Order:</p>
<div style="background:#f0f0f0;padding:10px;border-radius:8px;font-family:monospace;font-size:18px;font-weight:700;margin-bottom:14px;" id="successKode">-</div>
<a href="#" id="waLink" class="wa-button" target="_blank">📱 Kirim ke WhatsApp Toko</a>
<button class="btn-pesan btn-block" style="background:#888;margin-top:10px;" onclick="location.reload()">Selesai</button>
</div>
</div>

<script>
const produk = <?= json_encode($produk) ?>;
const cart = {};
const baseUrl = '<?= base_url() ?>';
const slug = '<?= $toko->slug ?>';

function formatRupiah(n) { return 'Rp ' + n.toLocaleString('id-ID'); }
function getHargaFinal(p) { return (p.harga_diskon && p.harga_diskon > 0 && p.harga_diskon < p.harga) ? p.harga_diskon : p.harga; }

function tambahItem(id) {
    const p = produk.find(x => x.id == id);
    if (!p) return;
    const input = document.getElementById('qty-'+id);
    if (!input) return;
    let val = parseInt(input.value) + 1;
    if (val > p.stok) { alert('Stok maksimal ' + p.stok); return; }
    input.value = val;
    cart[id] = { id, nama: p.nama_produk, harga: getHargaFinal(p), qty: val };
    // Toggle button -> qty controls
    const actionRow = document.getElementById('action-'+id);
    const qtyRow = document.getElementById('qty-row-'+id);
    if (actionRow) actionRow.style.display = 'none';
    if (qtyRow) qtyRow.style.display = 'flex';
    updateCartUI();
}

function updateQty(id, delta) {
    const p = produk.find(x => x.id == id);
    if (!p) { console.log('Produk tidak ditemukan:', id); return; }
    const input = document.getElementById('qty-'+id);
    if (!input) { console.log('Input qty tidak ditemukan:', id); return; }
    let val = parseInt(input.value) + delta;
    if (val < 0) val = 0;
    if (val > p.stok) { alert('Stok maksimal ' + p.stok); val = p.stok; }
    input.value = val;
    if (val > 0) {
        cart[id] = { id, nama: p.nama_produk, harga: getHargaFinal(p), qty: val, catatan: cart[id] ? cart[id].catatan : '' };
    } else {
        delete cart[id];
        // Toggle back to Tambah button
        const actionRow = document.getElementById('action-'+id);
        const qtyRow = document.getElementById('qty-row-'+id);
        if (actionRow) actionRow.style.display = 'flex';
        if (qtyRow) qtyRow.style.display = 'none';
    }
    updateCartUI();
    // Update cart modal in place (no re-render to preserve focus on note input)
    if (document.getElementById('cartModal').classList.contains('show')) {
        updateCartModalInPlace(id, val);
    }
}

// Update hanya qty & subtotal di cart modal tanpa re-render (agar focus di input note tidak hilang)
function updateCartModalInPlace(changedId, newQty) {
    const items = Object.values(cart);
    if (items.length === 0) {
        document.getElementById('cart-items').innerHTML = '';
        document.getElementById('cart-empty').style.display = 'block';
        document.getElementById('cart-footer').style.display = 'none';
        return;
    }
    document.getElementById('cart-empty').style.display = 'none';
    document.getElementById('cart-footer').style.display = 'block';

    let total = 0, totalQty = 0;
    // Update changed item's qty display & subtotal
    if (changedId !== undefined && newQty !== undefined) {
        const item = document.querySelector(`.cart-item[data-id="${changedId}"]`);
        if (item) {
            if (newQty > 0) {
                const c = cart[changedId];
                const sub = c.harga * newQty;
                const qtyDisplay = item.querySelector('.cart-qty-display');
                const subtotal = item.querySelector('.cart-item-subtotal');
                const smallHarga = item.querySelector('.cart-item-name small');
                if (qtyDisplay) qtyDisplay.textContent = newQty;
                if (subtotal) subtotal.textContent = formatRupiah(sub);
                if (smallHarga) smallHarga.textContent = formatRupiah(c.harga) + ' × ' + newQty;
            } else {
                // Item dihapus - re-render
                renderCart();
                return;
            }
        }
    }

    // Recompute & update totals
    items.forEach(c => { total += c.harga * c.qty; totalQty += c.qty; });
    document.getElementById('cart-count-text').textContent = totalQty + ' item';
    document.getElementById('cart-total').textContent = formatRupiah(total);
}

function updateCartUI() {
    const items = Object.values(cart);
    const total_qty = items.reduce((s, c) => s + c.qty, 0);
    const total_harga = items.reduce((s, c) => s + (c.harga * c.qty), 0);
    const bar = document.getElementById('cartBottomBar');
    const icon = document.getElementById('cartIcon');
    const title = document.getElementById('barTitle');
    const sub = document.getElementById('barSub');
    const btnLanjut = document.getElementById('btnLanjut');

    if (total_qty > 0) {
        bar.classList.remove('empty');
        bar.classList.add('has-items');
        icon.textContent = '🛒';
        // Build summary: first item name + others count
        const firstItem = items[0];
        let summaryText = firstItem.nama;
        if (items.length > 1) summaryText += ` +${items.length - 1} lainnya`;
        title.textContent = `${total_qty} item · ${formatRupiah(total_harga)}`;
        sub.textContent = summaryText;
        btnLanjut.disabled = false;
        btnLanjut.classList.add('added');
        btnLanjut.textContent = 'Lihat →';
    } else {
        bar.classList.remove('has-items');
        bar.classList.add('empty');
        icon.textContent = '🛒';
        title.textContent = 'Keranjang Kosong';
        sub.textContent = 'Belum ada item dipilih';
        btnLanjut.disabled = true;
        btnLanjut.classList.remove('added');
        btnLanjut.textContent = '+ Pilih Menu';
    }
}

function openCart() {
    if (Object.keys(cart).length === 0) return; // Disabled saat kosong
    renderCart();
    document.getElementById('cartModal').classList.add('show');
}
function closeCart() { document.getElementById('cartModal').classList.remove('show'); }

function renderCart() {
    const items = Object.values(cart);
    const list = document.getElementById('cart-items');
    const empty = document.getElementById('cart-empty');
    const footer = document.getElementById('cart-footer');
    if (items.length === 0) { list.innerHTML = ''; empty.style.display = 'block'; footer.style.display = 'none'; return; }
    empty.style.display = 'none'; footer.style.display = 'block';
    let total = 0, totalQty = 0, html = '';
    items.forEach(c => {
        const sub = c.harga * c.qty; total += sub; totalQty += c.qty;
        const noteVal = c.catatan || '';
        html += `<div class="cart-item" data-id="${c.id}">
            <div class="cart-item-row">
                <div class="cart-item-name">
                    <strong>${c.nama}</strong>
                    <small>${formatRupiah(c.harga)} × ${c.qty}</small>
                </div>
                <div class="cart-item-subtotal">${formatRupiah(sub)}</div>
            </div>
            <div class="cart-item-row" style="justify-content:space-between;">
                <div class="cart-item-controls">
                    <button type="button" class="qty-btn cart minus" data-action="minus"><span>−</span></button>
                    <span class="cart-qty-display" style="font-weight:700;min-width:24px;text-align:center;font-size:14px;">${c.qty}</span>
                    <button type="button" class="qty-btn cart plus" data-action="plus"><span>+</span></button>
                </div>
                <button type="button" class="cart-item-remove" data-action="remove" title="Hapus">🗑️</button>
            </div>
            <div class="cart-item-note">
                <span class="icon">📝</span>
                <input type="text" class="cart-note-input" placeholder="Catatan (misal: pedas, kurang garam, dll)" value="${noteVal.replace(/"/g, '&quot;').replace(/</g, '&lt;')}">
            </div>
        </div>`;
    });
    list.innerHTML = html;
    document.getElementById('cart-count-text').textContent = totalQty + ' item';
    document.getElementById('cart-total').textContent = formatRupiah(total);

    // Attach event listeners to dynamically created buttons
    list.querySelectorAll('.cart-item').forEach(item => {
        const id = parseInt(item.dataset.id);
        const minusBtn = item.querySelector('[data-action="minus"]');
        const plusBtn = item.querySelector('[data-action="plus"]');
        const removeBtn = item.querySelector('[data-action="remove"]');
        const noteInput = item.querySelector('.cart-note-input');
        if (minusBtn) minusBtn.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); updateQty(id, -1); });
        if (plusBtn) plusBtn.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); updateQty(id, 1); });
        if (removeBtn) removeBtn.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); removeItem(id); });
        if (noteInput) noteInput.addEventListener('input', function() { setItemNote(id, this.value); });
        if (noteInput) noteInput.addEventListener('click', function(e) { e.stopPropagation(); });
    });
}

function setItemNote(id, val) {
    if (cart[id]) cart[id].catatan = val;
}

function removeItem(id) {
    delete cart[id];
    // Reset produk UI
    const input = document.getElementById('qty-'+id);
    if (input) input.value = 0;
    const actionRow = document.getElementById('action-'+id);
    const qtyRow = document.getElementById('qty-row-'+id);
    if (actionRow) actionRow.style.display = 'flex';
    if (qtyRow) qtyRow.style.display = 'none';
    updateCartUI();
    renderCart();
}

function goOrder() {
    if (Object.keys(cart).length === 0) { alert('Keranjang kosong!'); return; }
    closeCart();
    renderOrderSummary();
    document.getElementById('orderModal').classList.add('show');
}

function closeOrder() { document.getElementById('orderModal').classList.remove('show'); }

function selectPay(method) {
    document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
    event.currentTarget.classList.add('active');
    event.currentTarget.querySelector('input').checked = true;
    document.getElementById('rekInfo').style.display = method === 'transfer' ? 'block' : 'none';
    document.getElementById('sudahTfRow').style.display = method === 'transfer' ? 'flex' : 'none';
}

function renderOrderSummary() {
    const items = Object.values(cart);
    let total = 0, totalQty = 0, html = '<div style="font-weight:600;margin-bottom:8px;">Ringkasan Pesanan:</div>';
    items.forEach(c => { const sub = c.harga * c.qty; total += sub; totalQty += c.qty;
        html += `<div class="order-summary-row"><span>${c.nama} × ${c.qty}</span><span>${formatRupiah(sub)}</span></div>`;
    });
    html += `<div class="order-summary-row" style="color:#888;font-size:13px;"><span>Total ${totalQty} item</span><span></span></div>`;
    html += `<div class="order-summary-row order-summary-total"><span>TOTAL</span><span style="color:var(--tema);">${formatRupiah(total)}</span></div>`;
    document.getElementById('orderSummary').innerHTML = html;
}

document.getElementById('orderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fd.set('cart', JSON.stringify(Object.values(cart)));
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true; btn.textContent = '⏳ Memproses...';
    fetch(baseUrl + slug + '/submit_order', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'ok') {
            closeOrder();
            document.getElementById('waLink').href = data.wa_url;
            document.getElementById('successKode').textContent = data.kode;
            document.getElementById('successModal').classList.add('show');
        } else {
            alert('Gagal memproses pesanan');
            btn.disabled = false; btn.textContent = '📱 Lanjut ke WhatsApp →';
        }
    }).catch(err => {
        alert('Error: ' + err);
        btn.disabled = false; btn.textContent = '📱 Lanjut ke WhatsApp →';
    });
});

// ===== Filter kategori & search =====
function filterCat(cat, el) {
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    const cards = document.querySelectorAll('.produk-card');
    let visible = 0;
    cards.forEach(c => {
        if (cat === 'all' || c.dataset.cat === cat) { c.style.display = 'flex'; visible++; }
        else c.style.display = 'none';
    });
    document.getElementById('emptyFilter').style.display = visible === 0 ? 'block' : 'none';
    document.getElementById('searchInput').value = '';
}

function filterProduk() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.produk-card');
    let visible = 0;
    cards.forEach(c => {
        if (c.dataset.nama.includes(q)) { c.style.display = 'flex'; visible++; }
        else c.style.display = 'none';
    });
    document.getElementById('emptyFilter').style.display = visible === 0 ? 'block' : 'none';
}

// User Payment Info Modal Functions
function showUserPayInfo() {
    const overlay = document.getElementById('userPayModalOverlay');
    const modal = document.getElementById('userPayModal');
    overlay.classList.add('show');
    setTimeout(() => modal.classList.add('show'), 10);
    document.body.style.overflow = 'hidden';
}

function closeUserPayInfo() {
    const overlay = document.getElementById('userPayModalOverlay');
    const modal = document.getElementById('userPayModal');
    modal.classList.remove('show');
    setTimeout(() => {
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }, 300);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeUserPayInfo();
});
</script>

<style>
.info-btn-user {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    border: none;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.info-btn-user:hover {
    transform: scale(1.15);
    box-shadow: 0 2px 8px rgba(59,130,246,0.4);
}

.user-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    z-index: 300;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}
.user-modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.user-modal {
    background: #fff;
    border-radius: 20px;
    max-width: 400px;
    width: 100%;
    max-height: 85vh;
    overflow-y: auto;
    position: relative;
    transform: scale(0.9) translateY(20px);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 25px 60px rgba(0,0,0,0.3);
}
.user-modal.show {
    transform: scale(1) translateY(0);
    opacity: 1;
}

.user-modal-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: none;
    background: #f3f4f6;
    color: #6b7280;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    z-index: 1;
}
.user-modal-close:hover {
    background: #e5e7eb;
    color: #111;
}

.user-modal-content {
    padding: 24px;
}

.user-modal-header {
    text-align: center;
    margin-bottom: 16px;
}
.user-modal-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto 10px;
}
.user-modal-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #111;
    margin: 0;
}

.user-modal-body {
    font-size: 13px;
    color: #374151;
    line-height: 1.6;
}
.user-modal-body p {
    margin: 0 0 12px;
}

.user-highlight {
    background: linear-gradient(135deg, #dcfce7, #86efac);
    border: 1px solid #4ade80;
    border-radius: 10px;
    padding: 12px;
    display: flex;
    gap: 10px;
    margin: 12px 0;
}
.user-highlight-blue {
    background: linear-gradient(135deg, #dbeafe, #93c5fd);
    border-color: #60a5fa;
}
.user-highlight-icon {
    font-size: 20px;
    flex-shrink: 0;
}
.user-highlight ul,
.user-highlight ol {
    margin: 6px 0 0;
    padding-left: 16px;
    font-size: 12px;
}
.user-highlight li {
    margin: 3px 0;
}

@media(max-width: 480px) {
    .user-modal {
        border-radius: 16px 16px 0 0;
        max-height: 90vh;
    }
    .user-modal-overlay {
        align-items: flex-end;
        padding: 0;
    }
}
</style>
</body>
</html>
