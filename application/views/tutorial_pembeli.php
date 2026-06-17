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
.tut-topbar .logo-icon { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px; }
.tut-topbar nav { display: flex; gap: 16px; align-items: center; }
.tut-topbar nav a { font-size: 14px; color: #6b7280; font-weight: 500; }
.tut-topbar nav a:hover { color: #3b82f6; }
.tut-topbar .btn-cta { background: #3b82f6; color: #fff; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; }

/* Hero */
.tut-hero {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
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
.step-flow::before { content: ''; position: absolute; left: 32px; top: 30px; bottom: 30px; width: 3px; background: linear-gradient(180deg, #3b82f6, #1d4ed8); border-radius: 2px; }
.step-item { display: flex; gap: 24px; margin-bottom: 30px; align-items: flex-start; }
.step-item:last-child { margin-bottom: 0; }
.step-num { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; flex-shrink: 0; position: relative; z-index: 1; box-shadow: 0 6px 16px rgba(59,130,246,.3); }
.step-content { flex: 1; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px 20px; }
.step-content h3 { font-size: 18px; font-weight: 700; color: #111; margin-bottom: 6px; }
.step-content p { color: #4b5563; font-size: 14px; line-height: 1.6; }
.step-content .checklist { list-style: none; padding: 0; margin-top: 8px; }
.step-content .checklist li { padding: 4px 0; display: flex; align-items: flex-start; gap: 6px; color: #4b5563; font-size: 13px; }
.step-content .checklist li::before { content: '✓'; color: #3b82f6; font-weight: 700; flex-shrink: 0; margin-top: 1px; }
.step-content .tip { background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-left: 4px solid #3b82f6; padding: 10px 14px; border-radius: 8px; font-size: 13px; color: #1e40af; margin-top: 10px; }
.step-content .tip strong { display: block; margin-bottom: 2px; }
.step-content .warn { background: linear-gradient(135deg, #fef3c7, #fde68a); border-left: 4px solid #f59e0b; padding: 10px 14px; border-radius: 8px; font-size: 13px; color: #78350f; margin-top: 10px; }
.step-content .warn strong { display: block; margin-bottom: 2px; }

/* Phone mockup */
.phone-mockup { max-width: 280px; margin: 20px auto; background: #1f2937; border-radius: 30px; padding: 12px; box-shadow: 0 20px 40px rgba(0,0,0,.15); }
.phone-screen { background: #fff; border-radius: 20px; padding: 16px; min-height: 320px; }
.phone-screen .ph-header { background: linear-gradient(135deg, #ff6b35, #f7931e); border-radius: 8px; padding: 12px; color: #fff; margin-bottom: 12px; text-align: center; font-size: 12px; }
.phone-screen .ph-item { display: flex; gap: 8px; padding: 8px; border: 1px solid #f3f4f6; border-radius: 8px; margin-bottom: 8px; }
.phone-screen .ph-img { width: 50px; height: 50px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
.phone-screen .ph-info { flex: 1; }
.phone-screen .ph-name { font-size: 11px; font-weight: 600; }
.phone-screen .ph-price { font-size: 11px; color: #ff6b35; font-weight: 700; }
.phone-screen .ph-btn { background: #ff6b35; color: #fff; border-radius: 16px; padding: 4px 8px; font-size: 10px; font-weight: 600; width: 50px; text-align: center; }
.phone-screen .ph-cart { background: #ff6b35; color: #fff; border-radius: 20px; padding: 8px; text-align: center; font-size: 12px; font-weight: 700; margin-top: 8px; }

/* FAQ */
.faq-item { background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; margin-bottom: 10px; overflow: hidden; }
.faq-q { padding: 14px 18px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; color: #111; user-select: none; }
.faq-q:hover { background: #fafafa; }
.faq-q .arrow { transition: transform .2s; }
.faq-a { padding: 0 18px 14px; color: #4b5563; display: none; line-height: 1.6; font-size: 14px; }
.faq-item.open .faq-q .arrow { transform: rotate(180deg); color: #3b82f6; }
.faq-item.open .faq-a { display: block; }

/* CTA */
.tut-cta { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: #fff; padding: 40px 24px; text-align: center; border-radius: 16px; margin: 30px 0; }
.tut-cta h2 { font-size: 24px; font-weight: 800; margin-bottom: 8px; }
.tut-cta p { opacity: .9; font-size: 14px; margin-bottom: 18px; }
.tut-cta .btn { background: #fff; color: #1d4ed8; padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 14px; display: inline-block; }
.tut-cta .btn:hover { background: #f3f4f6; }

.tut-footer { background: #fff; border-top: 1px solid #e5e7eb; padding: 24px 20px; text-align: center; color: #6b7280; font-size: 13px; margin-top: auto; }
.tut-footer a { color: #3b82f6; font-weight: 500; }

@media(max-width: 700px) {
    .tut-topbar nav a:not(.btn-cta) { display: none; }
    .tut-hero { padding: 36px 16px 60px; }
    .tut-hero h1 { font-size: 24px; }
    .step-flow::before { left: 22px; }
    .step-num { width: 48px; height: 48px; font-size: 18px; }
    .step-content { padding: 14px; }
    .tut-container { padding: 0 14px 40px; }
    .tut-section { padding: 30px 0; }
    .tut-section .section-head h2 { font-size: 20px; }
    .phone-mockup { max-width: 240px; }
}
</style>
</head>
<body class="tut-body">

<div class="tut-topbar">
<a href="<?= base_url() ?>" class="logo">
<div class="logo-icon">🛒</div>
<span>Tutorial Pembeli</span>
</a>
<nav>
<a href="<?= base_url('tutorial') ?>">← Pilih Peran</a>
<a href="<?= base_url() ?>" class="btn-cta">Cari Toko</a>
</nav>
</div>

<section class="tut-hero">
<a href="<?= base_url('tutorial') ?>" class="back-link">← Pilih peran lain</a>
<h1>🛒 Panduan untuk Pembeli</h1>
<p>Cara pesan makanan, minuman, atau jasa dari tetangga di perumahan Anda.</p>
<div class="tut-wave"></div>
</section>

<div class="tut-container">

<!-- Cara Order -->
<section class="tut-section">
<div class="section-head">
<h2>Cara Pesan di Toko</h2>
<p>5 langkah mudah dari buka link sampai orderan terkirim</p>
</div>

<div class="step-flow">
<div class="step-item">
<div class="step-num">1</div>
<div class="step-content">
<h3>Buka Link Toko</h3>
<p>Anda dapat link toko dari grup WhatsApp perumahan, atau scan QR code yang dishare tetangga.</p>
<ul class="checklist">
<li>Buka link di browser HP (Chrome, Safari, dll)</li>
<li>Tidak perlu install aplikasi tambahan</li>
<li>Tidak perlu login</li>
</ul>
<div class="phone-mockup">
<div class="phone-screen">
<div class="ph-header">🏪 Mie Ayam Pak A<br><small>Lokasi · WhatsApp</small></div>
<div class="ph-item">
<div class="ph-img">🍜</div>
<div class="ph-info"><div class="ph-name">Mie Ayam Original</div><div class="ph-price">Rp 10.000</div></div>
<div class="ph-btn">+</div>
</div>
<div class="ph-item">
<div class="ph-img">🥡</div>
<div class="ph-info"><div class="ph-name">Mie Ayam Bakso</div><div class="ph-price">Rp 13.000</div></div>
<div class="ph-btn">+</div>
</div>
</div>
</div>
</div>
</div>

<div class="step-item">
<div class="step-num">2</div>
<div class="step-content">
<h3>Pilih Menu &amp; Atur Jumlah</h3>
<p>Tekan tombol <strong>"+"</strong> untuk menambah menu. Atur jumlah sesuai yang Anda mau.</p>
<ul class="checklist">
<li>Misal: 2x Mie Ayam, 1x Es Teh</li>
<li>Lihat total update di keranjang (icon di kanan bawah)</li>
<li>Menu dengan harga coret = lagi diskon!</li>
</ul>
</div>
</div>

<div class="step-item">
<div class="step-num">3</div>
<div class="step-content">
<h3>Isi Data Diri</h3>
<p>Klik icon keranjang, lalu klik <strong>"Lanjut Pesan"</strong>. Isi nama &amp; blok rumah Anda.</p>
<ul class="checklist">
<li>Nama: contoh "Bahlil Santoso"</li>
<li>Blok: contoh "A-12" atau "Blok B No 5"</li>
<li>Nomor WhatsApp (opsional)</li>
<li>Catatan (opsional): "Pedas", "Tidak pakai bawang", dll</li>
</ul>
</div>
</div>

<div class="step-item">
<div class="step-num">4</div>
<div class="step-content">
<h3>Pilih Metode Bayar</h3>
<p>Pilih <strong>Cash</strong> (bayar saat barang diantar) atau <strong>Transfer</strong> (transfer ke rekening toko).</p>
<div class="tip">
<strong>💡 Cash lebih praktis:</strong>
Untuk perumahan sekitar, cash saat diantar biasanya lebih cepat. Tidak perlu transfer &amp; tunggu konfirmasi.
</div>
<div class="warn">
<strong>⚠️ Transfer?</strong>
Centang "Sudah transfer" hanya jika Anda SUDAH transfer. Kalau belum, kosongkan saja - nanti dikonfirmasi via WhatsApp.
</div>
</div>
</div>

<div class="step-item">
<div class="step-num">5</div>
<div class="step-content">
<h3>Kirim ke WhatsApp! 📱</h3>
<p>Klik <strong>"📱 Lanjut ke WhatsApp"</strong>. Aplikasi WhatsApp akan terbuka otomatis dengan pesan orderan yang sudah terformat rapi.</p>
<ul class="checklist">
<li>Anda tinggal klik <strong>Kirim</strong> di WhatsApp</li>
<li>Penjual akan menerima orderan Anda</li>
<li>Penjual akan membalas untuk konfirmasi</li>
<li>Siap diantar/diambil sesuai kesepakatan!</li>
</ul>
<div class="tip">
<strong>🎉 Selesai!</strong>
Tinggal tunggu barang diantar atau ambil di tempat. Untuk orderan berikutnya, toko Anda bisa langsung klik "Kirim Pesanan" lagi dari menu yang sama.
</div>
</div>
</div>
</section>

<!-- FAQ -->
<section class="tut-section">
<div class="section-head">
<h2>Pertanyaan yang Sering Ditanya</h2>
<p>Jawaban untuk hal-hal yang sering bikin bingung</p>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Apakah saya harus daftar akun dulu?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Tidak! Anda tidak perlu bikin akun atau login apapun. Cukup buka link toko, pilih menu, isi nama &amp; blok rumah, lalu klik tombol WhatsApp. Itu saja!</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Bagaimana saya tahu toko buka atau tutup?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Setiap toko punya status "Tersedia" atau "Habis" di setiap menu. Kalau semua menu "Habis", berarti toko sedang tutup. Anda bisa coba lagi nanti atau hubungi via WhatsApp.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Bagaimana cara bayar cash?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Pilih "Cash / Bayar di Tempat" saat order. Anda tinggal siapkan uang pas (atau lebih sedikit). Pembayaran dilakukan saat barang diantar ke rumah Anda atau saat Anda ambil di tempat.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Kalau transfer, ke rekening siapa?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Setiap toko mendaftarkan rekening mereka sendiri. Detailnya akan muncul setelah Anda pilih "Transfer Bank" - biasanya ada BCA/BRI/Mandiri atas nama pemilik toko.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Berapa lama pesanan diproses?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Tergantung toko. Biasanya 15-60 menit untuk makanan/minuman siap. Toko akan konfirmasi via WhatsApp setelah orderan Anda diterima. Anda juga bisa tanya langsung via chat.</p>
</div>
</div>

<div class="faq-item">
<div class="faq-q" onclick="toggleFaq(this)">
<span>Bagaimana kalau salah pilih menu?</span>
<span class="arrow">▾</span>
</div>
<div class="faq-a">
<p>Setelah klik "Kirim ke WhatsApp", tinggal chat ke pemilik toko untuk ubah/fix orderan Anda. Biasanya toko akan sangat membantu karena orderan via chat.</p>
</div>
</div>
</section>

<div class="tut-cta">
<h2>Siap Order?</h2>
<p>Minta link toko ke grup WA perumahan Anda, atau pilih toko langsung dari beranda.</p>
<a href="<?= base_url() ?>" class="btn">Lihat Daftar Toko →</a>
</div>

</div>

<div class="tut-footer">
<p>Bukan pembeli? <a href="<?= base_url('tutorial/penjual') ?>">Saya penjual / admin toko</a> · <a href="<?= base_url('tutorial') ?>">Pilih peran lain</a></p>
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
document.querySelectorAll('.step-item, .faq-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'all .5s ease-out';
    observer.observe(el);
});
</script>
</body>
</html>
