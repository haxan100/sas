<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body.tut-body {
    font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif;
    background: linear-gradient(135deg, #fafafa 0%, #f3f4f6 100%);
    color: #1a1a1a;
    line-height: 1.6;
    min-height: 100vh;
    display: flex; flex-direction: column;
}
a { color: inherit; text-decoration: none; }

/* Top bar */
.tut-topbar {
    background: rgba(255,255,255,.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid #e5e7eb;
    padding: 12px 20px;
    display: flex; justify-content: space-between; align-items: center;
    position: sticky; top: 0; z-index: 50;
}
.tut-topbar .logo { display: flex; align-items: center; gap: 8px; font-weight: 700; }
.tut-topbar .logo-icon { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px; }
.tut-topbar nav { display: flex; gap: 16px; align-items: center; }
.tut-topbar nav a { font-size: 14px; color: #6b7280; font-weight: 500; }
.tut-topbar nav a:hover { color: #ff6b35; }
.tut-topbar .btn-cta { background: #111; color: #fff; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; }

/* Hero */
.tut-hero {
    text-align: center;
    padding: 60px 20px 40px;
}
.tut-hero h1 { font-size: 36px; font-weight: 800; margin-bottom: 12px; }
.tut-hero h1 .gradient { background: linear-gradient(135deg, #ff6b35, #f7931e); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
.tut-hero p { font-size: 16px; color: #6b7280; max-width: 600px; margin: 0 auto; }
.tut-hero .emoji-row { font-size: 36px; margin-bottom: 16px; letter-spacing: 8px; }

/* Choose cards */
.tut-choose-wrap { max-width: 900px; margin: 0 auto; padding: 0 20px 60px; }
.tut-choose-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
.tut-choose-card {
    background: #fff; border: 2px solid #e5e7eb; border-radius: 18px; padding: 32px 24px;
    transition: all .3s; cursor: pointer; position: relative; overflow: hidden;
    text-decoration: none; color: inherit; display: block;
}
.tut-choose-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,.08); }
.tut-choose-card.pembeli:hover { border-color: #3b82f6; }
.tut-choose-card.penjual:hover { border-color: #ff6b35; }
.tut-choose-card::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(0,0,0,.03), transparent); transition: left .6s; }
.tut-choose-card:hover::before { left: 100%; }

.tut-choose-card .ribbon { position: absolute; top: 14px; right: -30px; background: #10b981; color: #fff; padding: 4px 36px; font-size: 11px; font-weight: 700; transform: rotate(35deg); }

.tut-choose-icon {
    width: 80px; height: 80px; border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 40px; margin-bottom: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,.1);
}
.tut-choose-card.pembeli .tut-choose-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: #fff; }
.tut-choose-card.penjual .tut-choose-icon { background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; }

.tut-choose-card h2 { font-size: 22px; font-weight: 700; margin-bottom: 8px; }
.tut-choose-card p { color: #6b7280; font-size: 14px; margin-bottom: 16px; }
.tut-choose-card ul { list-style: none; padding: 0; margin: 0 0 18px; }
.tut-choose-card ul li { padding: 4px 0; color: #4b5563; font-size: 13px; display: flex; align-items: center; gap: 6px; }
.tut-choose-card ul li::before { content: '✓'; color: #10b981; font-weight: 700; }

.tut-choose-card .arrow { color: #6b7280; font-size: 18px; transition: transform .2s; }
.tut-choose-card:hover .arrow { transform: translateX(4px); color: var(--accent, #ff6b35); }
.tut-choose-card.pembeli:hover .arrow { color: #3b82f6; }

/* Sections bawah */
.tut-section { padding: 50px 20px; max-width: 1000px; margin: 0 auto; }
.tut-section .section-head { text-align: center; margin-bottom: 32px; }
.tut-section .section-head h2 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
.tut-section .section-head p { color: #6b7280; }

/* Why use this */
.why-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; }
.why-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px; text-align: center; }
.why-card .icon { font-size: 30px; margin-bottom: 8px; }
.why-card h4 { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
.why-card p { color: #6b7280; font-size: 12px; }

/* Footer */
.tut-footer { background: #fff; border-top: 1px solid #e5e7eb; padding: 30px 20px; text-align: center; color: #6b7280; font-size: 13px; margin-top: auto; }
.tut-footer a { color: #ff6b35; font-weight: 500; }

/* Mobile */
@media(max-width: 700px) {
    .tut-topbar nav a:not(.btn-cta) { display: none; }
    .tut-hero { padding: 40px 16px 24px; }
    .tut-hero h1 { font-size: 26px; }
    .tut-choose-grid { grid-template-columns: 1fr; }
    .tut-choose-card { padding: 24px 20px; }
    .tut-section { padding: 36px 16px; }
}
</style>
</head>
<body class="tut-body">

<div class="tut-topbar">
<a href="<?= base_url() ?>" class="logo">
<div class="logo-icon">🏘️</div>
<span>SAS TokoRumah</span>
</a>
<nav>
<a href="<?= base_url() ?>">Beranda</a>
<a href="<?= base_url('admin') ?>">Login</a>
<a href="<?= base_url('admin') ?>" class="btn-cta">Mulai</a>
</nav>
</div>

<!-- Hero -->
<section class="tut-hero">
<div class="emoji-row">🛍️ 🏘️</div>
<h1>Tutorial <span class="gradient">SAS TokoRumah</span></h1>
<p>Pilih panduan sesuai peran Anda. Penjelasan lengkap dengan contoh nyata &amp; tips sukses.</p>
</section>

<!-- Choose -->
<div class="tut-choose-wrap">
<div class="tut-choose-grid">

<!-- Pembeli -->
<a href="<?= base_url('tutorial/pembeli') ?>" class="tut-choose-card pembeli">
<div class="ribbon">POPULER</div>
<div class="tut-choose-icon">🛒</div>
<h2>Saya Pembeli</h2>
<p>Panduan untuk tetangga yang mau pesan makanan/minuman dari toko sekitar.</p>
<ul>
<li>Cara cari & buka link toko</li>
<li>Cara pilih menu & atur jumlah</li>
<li>Cara bayar (cash / transfer)</li>
<li>Orderan terkirim via WhatsApp</li>
</ul>
<div style="display:flex;justify-content:space-between;align-items:center;">
<span style="font-size:13px;color:#3b82f6;font-weight:600;">Lihat panduan pembeli →</span>
<span class="arrow">→</span>
</div>
</a>

<!-- Penjual -->
<a href="<?= base_url('tutorial/penjual') ?>" class="tut-choose-card penjual">
<div class="tut-choose-icon">🏪</div>
<h2>Saya Penjual / Admin Toko</h2>
<p>Panduan lengkap untuk UMKM / tetangga yang mau mulai jualan online.</p>
<ul>
<li>Setup toko &amp; produk pertama</li>
<li>Kelola orderan dari dashboard</li>
<li>Atur tampilan &amp; pembayaran</li>
<li>Tips sukses jualan online</li>
</ul>
<div style="display:flex;justify-content:space-between;align-items:center;">
<span style="font-size:13px;color:#ff6b35;font-weight:600;">Lihat panduan penjual →</span>
<span class="arrow">→</span>
</div>
</a>

</div>
</div>

<!-- Why -->
<section class="tut-section">
<div class="section-head">
<h2>Kenapa SAS TokoRumah?</h2>
<p>Platform lokal yang dirancang khusus untuk tetangga di satu perumahan.</p>
</div>
<div class="why-grid">
<div class="why-card">
<div class="icon">💸</div>
<h4>100% Gratis</h4>
<p>Tanpa biaya bulanan, tanpa komisi.</p>
</div>
<div class="why-card">
<div class="icon">📱</div>
<h4>Cuma WhatsApp</h4>
<p>Pelanggan tidak perlu install app baru.</p>
</div>
<div class="why-card">
<div class="icon">🏘️</div>
<h4>Lokal</h4>
<p>Support tetangga di perumahan Anda.</p>
</div>
<div class="why-card">
<div class="icon">🚀</div>
<h4>Mudah</h4>
<p>5 menit setup, langsung jualan.</p>
</div>
</div>
</section>

<div class="tut-footer">
<p>Ingin tahu lebih lanjut? <a href="<?= base_url() ?>">Kembali ke beranda</a> atau <a href="<?= base_url('admin') ?>">login sekarang</a>.</p>
<p style="margin-top:6px;font-size:12px;">SAS TokoRumah © <?= date('Y') ?></p>
</div>

</body>
</html>
