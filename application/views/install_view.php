<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Install SAS TokoRumah</title>
<style>
body{font-family:system-ui;background:#f4f6fb;padding:30px}
.box{max-width:720px;margin:auto;background:#fff;padding:30px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08)}
h1{color:#333}
.ok{color:#27ae60;font-weight:600}
ul{list-style:none;padding:0}
li{padding:10px;background:#f0fdf4;border-left:4px solid #27ae60;margin:6px 0;border-radius:6px}
a{display:inline-block;margin-top:20px;padding:12px 24px;background:#ff6b35;color:#fff;text-decoration:none;border-radius:8px;margin-right:10px}
.cred{background:#fff3cd;padding:15px;border-radius:8px;margin-top:20px;border-left:4px solid #ffc107}
</style>
</head>
<body>
<div class="box">
<h1>✓ Install Berhasil</h1>
<p>Semua tabel sudah dibuat di database <code>sas_tokorumah</code>.</p>
<ul>
<?php foreach($status as $k=>$v): ?>
<li><strong><?= $k ?></strong> : <?= $v ?></li>
<?php endforeach ?>
</ul>

<div class="cred">
<strong>🎉 Instalasi Berhasil!</strong>
Semua tabel sudah dibuat di database <code>sas_tokorumah</code>.
<br><br>
Login dengan akun owner di <a href="<?= base_url('owner') ?>" style="color:#111;font-weight:600;"><?= base_url('owner') ?></a>
<br>
Login admin toko di <a href="<?= base_url('admin') ?>" style="color:#111;font-weight:600;"><?= base_url('admin') ?></a>
</div>

<div class="alert" style="background:#fff3cd;color:#856404;padding:14px 16px;border-radius:8px;margin-top:16px;border-left:4px solid #ffc107;">
<strong>⚠️ Penting:</strong> Ganti password default setelah instalasi pertama!
</div>

<a href="<?= base_url() ?>" class="btn">🏠 Kembali ke Beranda</a>
<a href="<?= base_url('admin') ?>" class="btn">🔐 Login Admin Toko</a>
</div>

<a href="<?= base_url() ?>">🏠 Halaman Depan</a>
<a href="<?= base_url('owner') ?>">👑 Dashboard Owner</a>
</div>
</body>
</html>
