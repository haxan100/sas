<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
.hero { background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; padding: 60px 20px; text-align: center; }
.hero h1 { font-size: 36px; margin-bottom: 12px; }
.hero p { font-size: 18px; opacity: .9; max-width: 600px; margin: 0 auto 24px; }
.hero .btn { background: #fff; color: #ff6b35; padding: 14px 32px; }
.container { max-width: 1100px; margin: 0 auto; padding: 40px 20px; }
.toko-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; }
.toko-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,.06); transition: transform .2s; }
.toko-card:hover { transform: translateY(-4px); }
.toko-cover { height: 120px; background: linear-gradient(135deg, var(--c, #ff6b35), var(--c2, #f7931e)); display: flex; align-items: center; justify-content: center; font-size: 48px; }
.toko-body { padding: 16px; }
.toko-body h3 { margin-bottom: 6px; }
.toko-body p { color: #888; font-size: 13px; margin-bottom: 12px; }
.toko-body .btn { display: block; text-align: center; background: var(--c, #ff6b35); color: #fff; padding: 10px; border-radius: 8px; font-weight: 600; }
.features { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 40px; }
.feature { background: #fff; padding: 24px; border-radius: 12px; text-align: center; }
.feature .icon { font-size: 40px; margin-bottom: 10px; }
.feature h4 { margin-bottom: 8px; }
.feature p { color: #666; font-size: 14px; }
footer { background: #2c3e50; color: #fff; text-align: center; padding: 30px 20px; }
</style>
</head>
<body>
<section class="hero">
<h1>🏘️ SAS TokoRumah</h1>
<p>Platform SaaS untuk toko online perumahan. Setiap tetangga bisa punya toko sendiri!</p>
<a href="#toko-list" class="btn">Lihat Daftar Toko</a>
</section>

<div class="container" id="toko-list">
<h2 style="margin-bottom:24px;">🛍️ Toko Tersedia</h2>
<?php if (empty($toko)): ?>
<p style="text-align:center;padding:40px;color:#888;">Belum ada toko. <a href="<?= base_url('install') ?>">Install dulu</a> atau login sebagai owner.</p>
<?php else: ?>
<div class="toko-grid">
<?php foreach ($toko as $t): if ($t->status != 'aktif') continue; $color = $t->tema_warna ?: '#ff6b35'; ?>
<div class="toko-card" style="--c:<?= $color ?>">
<div class="toko-cover" style="--c:<?= $color ?>;background:linear-gradient(135deg,<?= $color ?>,<?= $color ?>cc);">
<?php if ($t->logo): ?><img src="<?= base_url('assets/uploads/'.$t->logo) ?>" style="width:100%;height:100%;object-fit:cover;"><?php else: ?>🏪<?php endif; ?>
</div>
<div class="toko-body">
<h3><?= htmlspecialchars($t->nama_toko) ?></h3>
<p>📍 <?= htmlspecialchars($t->kategori) ?> · <?= htmlspecialchars($t->pemilik) ?></p>
<a href="<?= base_url($t->slug) ?>" class="btn">Lihat Menu →</a>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<div class="features">
<div class="feature">
<div class="icon">⚡</div>
<h4>Untuk Pemilik Toko</h4>
<p>Buat toko, kelola menu, lihat orderan, semua dari satu tempat.</p>
</div>
<div class="feature">
<div class="icon">📱</div>
<h4>Mobile Friendly</h4>
<p>Pelanggan pesan langsung dari HP, tinggal klik & order ke WhatsApp.</p>
</div>
<div class="feature">
<div class="icon">💰</div>
<h4>Bayar Cash / Transfer</h4>
<p>Pilih metode pembayaran, semua fleksibel sesuai toko masing-masing.</p>
</div>
</div>
</div>

<footer>
<p>SAS TokoRumah © 2026 — Dibuat untuk tetangga yang jualan 💛</p>
<p style="margin-top:8px;font-size:13px;opacity:.7"><a href="<?= base_url('owner') ?>" style="color:#fff;">Login Owner</a></p>
</footer>
</body>
</html>
