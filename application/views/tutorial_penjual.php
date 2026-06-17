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
    background: #fafafa; color: #1a1a1a; line-height: 1.6;
    min-height: 100vh; display: flex; flex-direction: column;
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
.tut-topbar .btn-cta { background: #ff6b35; color: #fff; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; }

/* Hero */
.tut-hero {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: #fff; padding: 50px 20px 70px; text-align: center;
    position: relative; overflow: hidden;
}
.tut-hero::before { content: ''; position: absolute; right: -50px; top: -50px; width: 200px; height: 200px; background: rgba(255,255,255,.1); border-radius: 50%; }
.tut-hero::after { content: ''; position: absolute; left: -80px; bottom: -100px; width: 250px; height: 250px; background: rgba(255,255,255,.08); border-radius: 50%; }
.tut-hero .back-link { display: inline-flex; align-items: center; gap: 4px; color: rgba(255,255,255,.85); font-size: 13px; margin-bottom: 16px; position: relative; z-index: 1; }
.tut-hero .back-link:hover { color: #fff; }
.tut-hero h1 { font-size: 32px; font-weight: 800; margin-bottom: 8px; position: relative; z-index: 1; }
.tut-hero p { font-size: 15px; opacity: .92; max-width: 600px; margin: 0 auto; position: relative; z-index: 1; }
.tut-wave { position: absolute; bottom: -1px; left: 0; right: 0; height: 60px; background: #fafafa; clip-path: polygon(0 60%, 100% 0, 100% 100%, 0 100%); }

/* Content */
.tut-container { max-width: 900px; margin: 0 auto; padding: 0 20px 60px; }
.tut-section { padding: 40px 0; }
.tut-section .section-head { text-align: center; margin-bottom: 30px; }
.tut-section .section-head h2 { font-size: 26px; font-weight: 700; color: #111; margin-bottom: 6px; }
.tut-section .section-head p { color: #6b7280; font-size: 14px; }

/* Steps */
.step-flow { position: relative; }
.step-flow::before { content: ''; position: absolute; left: 32px; top: 30px; bottom: 30px; width: 3px; background: linear-gradient(180deg, #ff6b35, #f7931e); border-radius: 2px; }
.step-item { display: flex; gap: 24px; margin-bottom: 30px; align-items: flex-start; }
.step-item:last-child { margin-bottom: 0; }
.step-num { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; flex-shrink: 0; position: relative; z-index: 1; box-shadow: 0 6px 16px rgba(255,107,53,.3); }
.step-content { flex: 1; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px 20px; }
.step-content h3 { font-size: 18px; font-weight: 700; color: #111; margin-bottom: 6px; }
.step-content p { color: #4b5563; font-size: 14px; line-height: 1.6; }
.step-content .checklist { list-style: none; padding: 0; margin-top: 8px; }
.step-content .checklist li { padding: 4px 0; display: flex; align-items: flex-start; gap: 6px; color: #4b5563; font-size: 13px; }
.step-content .checklist li::before { content: '✓'; color: #ff6b35; font-weight: 700; flex-shrink: 0; margin-top: 1px; }
.step-content .tip { background: linear-gradient(135deg, #fff7ed, #ffedd5); border-left: 4px solid #ff6b35; padding: 10px 14px; border-radius: 8px; font-size: 13px; color: #9a3412; margin-top: 10px; }
.step-content .tip strong { display: block; margin-bottom: 2px; }
.step-content .warn { background: linear-gradient(135deg, #fef3c7, #fde68a); border-left: 4px solid #f59e0b; padding: 10px 14px; border-radius: 8px; font-size: 13px; color: #78350f; margin-top: 10px; }
.step-content .warn strong { display: block; margin-bottom: 2px; }

/* Dashboard mockup */
.dash-mockup { max-width: 100%; margin: 20px auto; background: #1f2937; border-radius: 16px; padding: 16px; box-shadow: 0 20px 40px rgba(0,0,0,.15); }
.dash-screen { background: #fff; border-radius: 10px; overflow: hidden; }
.dash-header { background: linear-gradient(135deg, #ff6b35, #f7931e); padding: 16px; color: #fff; }
.dash-header .dash-title { font-size: 14px; font-weight: 700; }
.dash-header .dash-sub { font-size: 11px; opacity: .85; }
.dash-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; padding: 12px; }
.dash-stat { background: #f9fafb; border-radius: 8px; padding: 10px; text-align: center; }
.dash-stat .stat-val { font-size: 18px; font-weight: 800; color: #ff6b35; }
.dash-stat .stat-label { font-size: 10px; color: #6b7280; }
.dash-table { padding: 12px; }
.dash-table table { width: 100%; border-collapse: collapse; font-size: 11px; }
.dash-table th { background: #f3f4f6; padding: 6px 8px; text-align: left; color: #6b7280; }
.dash-table td { padding: 6px 8px; border-bottom: 1px solid #f3f4f6; }
.dash-table .badge { padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; }
.dash-table .badge-new { background: #dbeafe; color: #1d4ed8; }
.dash-table .badge-done { background: #d1fae5; color: #059669; }

/* Feature cards */
.feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; }
.feature-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; transition: all .3s; }
.feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,.08); }
.feature-card .icon { font-size: 36px; margin-bottom: 12px; }
.feature-card h4 { font-size: 16px; font-weight: 700; margin-bottom: 6px; color: #111; }
.feature-card p { color: #6b7280; font-size: 13px; }

/* Timeline */
.timeline { position: relative; }
.timeline::before { content: ''; position: absolute; left: 32px; top: 0; bottom: 0; width: 3px; background: linear-gradient(180deg, #ff6b35, #f7931e); border-radius: 2px; }
.timeline-item { display: flex; gap: 24px; margin-bottom: 24px; align-items: flex-start; }
.timeline-item:last-child { margin-bottom: 0; }
.timeline-icon { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0; position: relative; z-index: 1; box-shadow: 0 6px 16px rgba(255,107,53,.3); }
.timeline-content { flex: 1; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px 20px; }
.timeline-content h4 { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
.timeline-content p { color: #6b7280; font-size: 13px; }
.timeline-content .time { font-size: 12px; color: #ff6b35; font-weight: 600; }

/* FAQ */
.faq-item { background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; margin-bottom: 10px; overflow: hidden; }
.faq-q { padding: 14px 18px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; color: #111; user-select: none; }
.faq-q:hover { background: #fafafa; }
.faq-q .arrow { transition: transform .2s; }
.faq-a { padding: 0 18px 14px; color: #4b5563; display: none; line-height: 1.6; font-size: 14px; }
.faq-item.open .faq-q .arrow { transform: rotate(180deg); color: #ff6b35; }
.faq-item.open .faq-a { display: block; }

/* CTA */
.tut-cta { background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; padding: 40px 24px; text-align: center; border-radius: 16px; margin: 30px 0; }
.tut-cta h2 { font-size: 24px; font-weight: 800; margin-bottom: 8px; }
.tut-cta p { opacity: .9; font-size: 14px; margin-bottom: 18px; }
.tut-cta .btn { background: #fff; color: #ff6b35; padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 14px; display: inline-block; }
.tut-cta .btn:hover { background: #fff7ed; }

/* Success story */
.success-card { background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; border-radius: 16px; padding: 24px; margin: 20px 0; }
.success-card .quote { font-size: 18px; font-style: italic; margin-bottom: 12px; line-height: 1.5; }
.success-card .author { display: flex; align-items: center; gap: 12px; }
.success-card .avatar { width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,.3); display: flex; align-items: center; justify-content: center; font-size: 24px; }
.success-card .info .name { font-weight: 700; font-size: 14px; }
.success-card .info .detail { font-size: 12px; opacity: .85; }

.tut-footer { background: #fff; border-top: 1px solid #e5e7eb; padding: 24px 20px; text-align: center; color: #6b7280; font-size: 13px; margin-top: auto; }
.tut-footer a { color: #ff6b35; font-weight: 500; }

@media(max-width: 700px) {
    .tut-topbar nav a:not(.btn-cta) { display: none; }
    .tut-hero { padding: 36px 16px 60px; }
    .tut-hero h1 { font-size: 24px; }
    .step-flow::before { left: 22px; }
    .step-num, .timeline-icon { width: 48px; height: 48px; font-size: 18px; }
    .step-content { padding: 14px; }
    .tut-container { padding: 0 14px 40px; }
    .tut-section { padding: 30px 0; }
    .tut-section .section-head h2 { font-size: 20px; }
    .feature-grid { grid-template-columns: 1fr; }
    .dash-stats { grid-template-columns: repeat(3, 1fr); }
}
</style>
</head>
<body class="tut-body">

<div class="tut-topbar">
<a href="<?= base_url() ?>" class="logo">
<div class="logo-icon">🏪</div>
<span>Tutorial Penjual</span>
</a>
<nav>
<a href="<?= base_url('tutorial') ?>">← Pilih Peran</a>
<a href="<?= base_url('admin') ?>" class="btn-cta">Mulai Jualan</a>
</nav>
</div>

<section class="tut-hero">
<a href="<?= base_url('tutorial') ?>" class="back-link">← Pilih peran lain</a>
<h1>🏪 Panduan untuk Penjual</h1>
<p>Cara setup toko, tambah produk, dan kelola orderan dari dashboard.</p>
<div class="tut-wave"></div>
</section>

<div class="tut-container">

<!-- Fitur Unggulan -->
<section class="tut-section">
<div class="section-head">
<h2>Yang Bisa Anda Lakukan</h2>
<p>Semua fitur untuk mengelola toko online Anda</p>
</div>
<div class="feature-grid">
<div class="feature-card">
<div class="icon">🛒</div>
<h4>Kelola Produk</h4>
<p>Tambah, edit, atau hapus produk dengan mudah. Atur harga, stok, dan kategori.</p>
</div>
<div class="feature-card">
<div class="icon">📊</div>
<h4>Pantau Orderan</h4>
<p>Lihat semua orderan masuk, update status, dan history penjualan.</p>
</div>
<div class="feature-card">
<div class="icon">💬</div>
<h4>WhatsApp Otomatis</h4>
<p>Orderan langsung masuk ke WhatsApp Anda. Tidak perlu cek dashboard terus.</p>
</div>
<div class="feature-card">
<div class="icon">🎨</div>
<h4>Custom Tampilan</h4>
<p>Pilih warna tema, foto banner, dan info toko sesuai brand Anda.</p>
</div>
</div>
</section>

<!-- Cara Setup -->
<section class="tut-section">
<div class="section-head">
<h2>Persiapan Awal: Setup Toko</h2>
<p>5 menit pertama untuk mulai jualan</p>
</div>

<div class="step-flow">
<div class="step-item">
<div class="step-num">1</div>
<div class="step-content">
<h3>Daftar & Login ke Owner</h3>
<p>Buka halaman <strong>Owner</strong> untuk mendaftarkan toko baru atau login ke dashboard utama.</p>
<ul class="checklist">
<li>Klik menu "Owner" di beranda SAS TokoRumah</li>
<li>Register toko baru atau login jika sudah punya akun</li>
<li>Isi data toko: nama, deskripsi, lokasi</li>
</ul>
</div>
</div>

<div class="step-item">
<div class="step-num">2</div>
<div class="step-content">
<h3>Atur Info Toko</h3>
<p>Lengkapi profil toko Anda agar pelanggan percaya.</p>
<ul class="checklist">
<li>Nama toko yang mudah diingat</li>
<li>Nomor WhatsApp aktif (untuk terima orderan)</li>
<li>Jam operasional</li>
<li>Deskripsi singkat tentang toko Anda</li>
</ul>
</div>
</div>

<div class="step-item">
<div class="step-num">3</div>
<div class="step-content">
<h3>Tambah Kategori Produk</h3>
<p>Buat kategori untuk mengorganisir menu Anda.</p>
<ul class="checklist">
<li>Contoh: "Makanan", "Minuman", "Dessert"</li>
<li>Atau: "Mie Ayam", "Bakso", "Minuman"</li>
<li>Kategori akan muncul di halaman toko pelanggan</li>
</ul>
<div class="tip">
<strong>💡 Tip:</strong> Gunakan 3-5 kategori utama saja agar tampilan rapi.
</div>
</div>
</div>

<div class="step-item">
<div class="step-num">4</div>
<div class="step-content">
<h3>Tambah Produk Pertama</h3>
<p>Mulai tambahkan menu yang akan Anda jual.</p>
<ul class="checklist">
<li>Nama produk yang jelas (contoh: "Mie Ayam Original")</li>
<li>Harga (Rp 10.000)</li>
<li>Pilih kategori</li>
<li>Upload foto produk (opsional tapi disarankan)</li>
</ul>
<div class="tip">
<strong>💡 Foto penting:</strong> Produk dengan foto menarik 3x lebih banyak dilihat!
</div>
</div>
</div>

<div class="step-item">
<div class="step-num">5</div>
<div class="step-content">
<h3>Share Link Toko 🏆</h3>
<p>Toko Anda sudah siap! Bagikan link ke tetangga.</p>
<ul class="checklist">
<li>Link toko: <code style="background:#f3f4f6;padding:2px 6px;border-radius:4px;"><?= base_url() ?>[slug-toko]</code></li>
<li>Share ke grup WhatsApp perumahan</li>
<li>Print QR code dan tempel di mading</li>
<li>Tidak perlu pakai app baru!</li>
</ul>
</div>
</div>
</div>
</section>

<!-- Dashboard Preview -->
<section class="tut-section">
<div class="section-head">
<h2>Dashboard Admin Toko</h2>
<p>Semua orderan dan produk terkelola di satu tempat</p>
</div>

<div class="dash-mockup">
<div class="dash-screen">
<div class="dash-header">
<div class="dash-title">🏪 Mie Ayam Pak A</div>
<div class="dash-sub">Dashboard Admin</div>
</div>
<div class="dash-stats">
<div class="dash-stat">
<div class="stat-val">12</div>
<div class="stat-label">Order Baru</div>
</div>
<div class="dash-stat">
<div class="stat-val">48</div>
<div class="stat-label">Hari Ini</div>
</div>
<div class="dash-stat">
<div class="stat-val">Rp 580K</div>
<div class="stat-label">Total</div>
</div>
</div>
<div class="dash-table">
<table>
<tr>
<th>Pembeli</th>
<th>Items</th>
<th>Total</th>
<th>Status</th>
</tr>
<tr>
<td>Bahlil S.</td>
<td>Mie Ayam x2</td>
<td>Rp 26K</td>
<td><span class="badge badge-new">BARU</span></td>
</tr>
<tr>
<td>Ani W.</td>
<td>Es Teh x3</td>
<td>Rp 15K</td>
<td><span class="badge badge-done">SELESAI</span></td>
</tr>
</table>
</div>
</div>
</div>
</div>
</section>

<!-- Tips Sukses -->
<section class="tut-section">
<div class="section-head">
<h2>Tips Sukses Jualan Online</h2>
<p>Rahasia toko yang laris manis</p>
</div>

<div class="timeline">
<div class="timeline-item">
<div class="timeline-icon">📸</div>
<div class="timeline-content">
<h4>Gunakan Foto Produk yang Menarik</h4>
<p>Foto yang jernih dan cerah dengan background bersih bisa meningkatkan penjualan hingga 40%. Gunakan cahaya alami dan angle yang tepat.</p>
<div class="time">⏱️ 5 menit per produk</div>
</div>
</div>

<div class="timeline-item">
<div class="timeline-icon">⏰</div>
<div class="timeline-content">
<h4>Respons Cepat via WhatsApp</h4>
<p>Balas orderan dalam 5-15 menit. Semakin cepat, semakin percaya pelanggan. Matikan notifikasi agar tidak ada yang terlewat.</p>
<div class="time">⚡ Langsung</div>
</div>
</div>

<div class="timeline-item">
<div class="timeline-icon">🎁</div>
<div class="timeline-content">
<h4>Buat Promo Sederhana</h4>
<p>Tawarkan diskon order pertama, gratis ongkir area tertentu, atau buy 2 get 1. Semua bisa diatur di dashboard admin.</p>
<div class="time">💡 Promosi</div>
</div>
</div>

<div class="timeline-item">
<div class="timeline-icon">📢</div>
<div class="timeline-content">
<h4>Konsisten Promosi di Grup WA</h4>
<p>Posting menu harian di grup WA perumahan. Pakai format yang sama setiap hari agar warga familiar. Contoh: "🌟 Menu Hari Ini:"</p>
<div class="time">📅 Setiap hari</div>
</div>
</div>

<div class="timeline-item">
<div class="timeline-icon">⭐</div>
<div class="timeline-content">
<h4>Jaga Kualitas & Konsistensi</h4>
<p>Rasa dan tampilan harus konsisten. Satu kali mengecewakan bisa kehilangan pelanggan permanen. Minta feedback dan terus improve.</p>
<div class="time">🎯 Jangka panjang</div>
</div>
</div>
</div>
</section>

<!-- Cerita Sukses -->
<section class="tut-section">
<div class="success-card">
<div class="quote">"Dulu jualan lewat WA chat, ribet ngitung manual. Sekarang tinggal buka dashboard, semua orderan langsung ada. Penjualan naik 2x lipat!"</div>
<div class="author">
<div class="avatar">👨‍🍳</div>
<div class="info">
<div class="name">Pak Hendra</div>
<div class="detail">Mie Ayam Favorit · cluster Melati</div>
</div>
</div>
</div>
</section>

<!-- FAQ -->
<section class="tut-section">
<div class="section-head">
<h2>Pertanyaan Umum Seller</h2>
<p>Jawaban untuk hal yang sering ditanyakan</p>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Berapa biaya untuk pakai SAS TokoRumah?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p><strong>GRATIS 100%!</strong> Tidak ada biaya bulanan, tidak ada komisi per transaksi. Anda hanya perlu fokus jualan.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Apakah harus punya website sendiri?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Tidak! SAS TokoRumah sudah menyediakan halaman toko online siap pakai. Anda tinggal daftar, isi menu, dan share link. Semudah itu!</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Bagaimana cara pelanggan bayar?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Ada 2 opsi: <strong>Cash</strong> (bayar saat barang diantar/diterima) atau <strong>Transfer</strong> ke rekening yang Anda daftarkan. Anda yang tentukan metode mana yang aktif.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Orderan masuk ke mana?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Setiap ada orderan baru, sistem akan mengirim <strong>pesan otomatis ke WhatsApp Anda</strong> dengan detail lengkap: siapa beli apa, total harga, dan data pembeli. Anda juga bisa pantau semua orderan di dashboard admin.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Bagaimana kalau mau ubah harga atau stok?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Masuk ke dashboard admin toko, pilih menu "Produk". Klik produk yang mau diedit, ubah harga/stok, lalu simpan. Perubahan langsung terlihat di halaman toko.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Apakah bisa ada banyak admin satu toko?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Saat ini 1 toko = 1 akun admin utama. Namun Anda bisa share username/password ke keluarga/partner kerja. Semua orderan masuk ke nomor WA yang sama.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Bagaimana kalau toko mau ditutup sementara?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Masuk dashboard admin, ubah status toko menjadi "Nonaktif". Halaman toko akan tampil pesan "Toko sedang tutup" dan pelanggan tidak bisa order. Aktifkan lagi kapan saja.</p>
</div>
</div>
</section>

<div class="tut-cta">
<h2>Siap Memulai Jualan?</h2>
<p>Daftar sekarang gratis! 5 menit saja, langsung bisa terima orderan pertama.</p>
<a href="<?= base_url('admin') ?>" class="btn">Daftar / Login Admin →</a>
</div>

</div>

<div class="tut-footer">
<p>Bukan penjual? <a href="<?= base_url('tutorial/pembeli') ?>">Saya pembeli</a> · <a href="<?= base_url('tutorial') ?>">Pilih peran lain</a></p>
<p style="margin-top:6px;font-size:12px;">SAS TokoRumah © <?= date('Y') ?></p>
</div>

<script>
function toggleFaq(el) {
    const item = el.parentElement;
    const wasOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    if (!wasOpen) item.classList.add('open');
}

const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.style.opacity = '1';
            e.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.1 });
document.querySelectorAll('.step-item, .timeline-item, .faq-item, .feature-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'all .5s ease-out';
    observer.observe(el);
});
</script>
</body>
</html>
