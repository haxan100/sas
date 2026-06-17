<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<?php $this->load->view('toko/_tema', ['toko' => $toko]); ?>
<style>
* { box-sizing: border-box; }
body.welcome-body {
    font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif;
    background: linear-gradient(135deg, #fafafa 0%, #f3f4f6 100%);
    margin: 0; padding: 0;
    min-height: 100vh;
}

.tour-wrap { max-width: 900px; margin: 0 auto; padding: 20px; min-height: 100vh; display: flex; flex-direction: column; }

/* Hero */
.tour-hero { background: linear-gradient(135deg, var(--tema-color, #ff6b35), var(--tema-color, #ff6b35)); color: #fff; padding: 40px 24px; border-radius: 18px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,.1); position: relative; overflow: hidden; }
.tour-hero::before { content: ''; position: absolute; right: -50px; top: -50px; width: 200px; height: 200px; background: rgba(255,255,255,.08); border-radius: 50%; }
.tour-hero::after { content: ''; position: absolute; left: -50px; bottom: -50px; width: 150px; height: 150px; background: rgba(255,255,255,.06); border-radius: 50%; }
.tour-hero h1 { font-size: 28px; margin: 0 0 8px; position: relative; z-index: 1; }
.tour-hero p { font-size: 15px; opacity: .92; margin: 0; position: relative; z-index: 1; }
.tour-hero .emoji { font-size: 48px; display: block; margin-bottom: 12px; position: relative; z-index: 1; animation: bounce 2s infinite; }
@keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }

/* Progress */
.tour-progress { display: flex; justify-content: space-between; align-items: center; margin: 24px 0 20px; padding: 0 10px; }
.tour-step-indicator { display: flex; gap: 6px; align-items: center; }
.tour-step-dot { width: 10px; height: 10px; border-radius: 50%; background: #e5e7eb; transition: all .3s; }
.tour-step-dot.active { background: var(--tema-color, #ff6b35); width: 28px; border-radius: 5px; }
.tour-step-dot.done { background: var(--tema-color, #ff6b35); }
.tour-step-text { font-size: 13px; color: #6b7280; font-weight: 500; }

/* Step card */
.step-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 28px 24px; box-shadow: 0 2px 12px rgba(0,0,0,.04); display: none; animation: fadeInUp .4s; }
.step-card.active { display: block; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

.step-icon { width: 72px; height: 72px; border-radius: 18px; background: linear-gradient(135deg, var(--tema-color, #ff6b35), var(--tema-color, #ff6b35)); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 36px; margin-bottom: 16px; box-shadow: 0 8px 20px rgba(0,0,0,.1); }
.step-title { font-size: 22px; font-weight: 700; color: #111; margin: 0 0 8px; }
.step-subtitle { font-size: 14px; color: #6b7280; margin: 0 0 20px; line-height: 1.5; }
.step-list { list-style: none; padding: 0; margin: 0 0 20px; }
.step-list li { padding: 10px 0; display: flex; align-items: flex-start; gap: 10px; font-size: 14px; color: #374151; line-height: 1.5; }
.step-list li::before { content: '✓'; color: #10b981; font-weight: 700; flex-shrink: 0; }
.step-tip { background: linear-gradient(135deg, #fef3c7, #fde68a); border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 8px; font-size: 13px; color: #78350f; margin: 16px 0; }
.step-tip strong { display: block; margin-bottom: 4px; }

/* Buttons */
.step-actions { display: flex; gap: 10px; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 20px; border-top: 1px solid #f3f4f6; flex-wrap: wrap; }
.btn-tour { padding: 11px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all .2s; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-tour-primary { background: var(--tema-color, #ff6b35); color: #fff; }
.btn-tour-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0,0,0,.15); }
.btn-tour-secondary { background: #f3f4f6; color: #374151; }
.btn-tour-secondary:hover { background: #e5e7eb; }
.btn-tour-skip { background: transparent; color: #6b7280; font-size: 13px; }
.btn-tour-skip:hover { color: #ef4444; }
.btn-tour:disabled { opacity: .5; cursor: not-allowed; }

/* Feature highlight cards */
.feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; margin: 16px 0; }
.feature-card { background: #fafbfc; border: 1px solid #f3f4f6; border-radius: 10px; padding: 14px; text-align: center; }
.feature-card .icon { font-size: 24px; margin-bottom: 6px; }
.feature-card .title { font-size: 12px; font-weight: 600; color: #111; margin-bottom: 2px; }
.feature-card .desc { font-size: 11px; color: #6b7280; }

/* Welcome confetti animation */
.confetti { position: fixed; width: 10px; height: 10px; pointer-events: none; animation: confettiFall 3s linear forwards; }
@keyframes confettiFall {
    0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
}

/* Responsive */
@media(max-width: 700px) {
    .tour-wrap { padding: 12px; }
    .tour-hero { padding: 28px 20px; }
    .tour-hero h1 { font-size: 22px; }
    .step-card { padding: 20px 16px; }
    .step-actions { flex-direction: column-reverse; }
    .btn-tour { width: 100%; justify-content: center; }
}
</style>
</head>
<body class="welcome-body">
<div class="tour-wrap">

<!-- Hero -->
<div class="tour-hero">
<span class="emoji">🎉</span>
<h1>Selamat Datang di Dashboard!</h1>
<p>Halo <strong><?= htmlspecialchars($toko->pemilik) ?></strong>, toko <strong><?= htmlspecialchars($toko->nama_toko) ?></strong> sudah siap. Mari kita mulai!</p>
</div>

<!-- Progress -->
<div class="tour-progress">
<div class="tour-step-indicator">
<div class="tour-step-dot active" data-step="1"></div>
<div class="tour-step-dot" data-step="2"></div>
<div class="tour-step-dot" data-step="3"></div>
<div class="tour-step-dot" data-step="4"></div>
<div class="tour-step-dot" data-step="5"></div>
</div>
<div class="tour-step-text"><span id="stepText">1 dari 5</span></div>
</div>

<!-- Step 1: Welcome -->
<div class="step-card active" data-step="1">
<div class="step-icon">👋</div>
<h2 class="step-title">Selamat Datang, Pak/Bu <?= htmlspecialchars($toko->pemilik) ?>!</h2>
<p class="step-subtitle">Ini adalah pusat kendali toko Anda. Dari sini, Anda bisa mengelola produk, menerima pesanan, dan mengatur tampilan toko.</p>
<div class="feature-grid">
<div class="feature-card"><div class="icon">📊</div><div class="title">Dashboard</div><div class="desc">Statistik toko</div></div>
<div class="feature-card"><div class="icon">📦</div><div class="title">Orderan</div><div class="desc">Pesanan masuk</div></div>
<div class="feature-card"><div class="icon">🍜</div><div class="title">Produk</div><div class="desc">Menu & harga</div></div>
<div class="feature-card"><div class="icon">🏷️</div><div class="title">Kategori</div><div class="desc">Kelompok menu</div></div>
<div class="feature-card"><div class="icon">⚙️</div><div class="title">Setting</div><div class="desc">Tampilan & akun</div></div>
</div>
<div class="step-tip">
<strong>💡 Tips UMKM:</strong>
Pelanggan lebih suka toko yang responsif. Cek orderan minimal 2x sehari supaya tidak ada pesanan terlewat!
</div>
<div class="step-actions">
<button class="btn-tour btn-tour-skip" onclick="skipTour()">Lewati tour</button>
<button class="btn-tour btn-tour-primary" onclick="nextStep(2)">Mulai Tour →</button>
</div>
</div>

<!-- Step 2: Produk -->
<div class="step-card" data-step="2">
<div class="step-icon">🍜</div>
<h2 class="step-title">Tambah Produk / Menu Anda</h2>
<p class="step-subtitle">Tambahkan menu makanan/minuman yang Anda jual. Bisa lebih dari satu, nanti dikelompokkan per kategori.</p>
<ul class="step-list">
<li>Buka menu <strong>Produk</strong> di sidebar</li>
<li>Klik <strong>+ Tambah Produk</strong></li>
<li>Isi nama, harga, foto, dan pilih kategori</li>
<li>Centang toggle <strong>Diskon</strong> kalau ada harga coret</li>
</ul>
<div class="step-tip">
<strong>📸 Foto produk:</strong>
Produk dengan foto menjual 3x lebih banyak! Pakai HP untuk foto, upload dari gallery.
</div>
<div class="step-actions">
<button class="btn-tour btn-tour-secondary" onclick="nextStep(1)">← Kembali</button>
<div>
<button class="btn-tour btn-tour-skip" onclick="skipTour()">Lewati</button>
<button class="btn-tour btn-tour-primary" onclick="goTo('produk')">Buka Halaman Produk →</button>
</div>
</div>
</div>

<!-- Step 3: Orderan -->
<div class="step-card" data-step="3">
<div class="step-icon">📦</div>
<h2 class="step-title">Pantau Orderan Masuk</h2>
<p class="step-subtitle">Orderan dari pelanggan akan masuk di menu Orderan. Anda bisa ubah statusnya: <strong>Baru → Diproses → Selesai</strong></p>
<ul class="step-list">
<li>Order <strong>Baru</strong> = belum dilihat</li>
<li>Order <strong>Diproses</strong> = sedang dibuat/disiapkan</li>
<li>Order <strong>Selesai</strong> = sudah diantar / diberikan</li>
<li>Order <strong>Batal</strong> = tidak diproses</li>
</ul>
<div class="step-tip">
<strong>📱 WhatsApp:</strong>
Pelanggan akan diarahkan ke WhatsApp Anda setelah order. Pastikan nomor WA yang didaftarkan aktif dan bisa menerima chat.
</div>
<div class="step-actions">
<button class="btn-tour btn-tour-secondary" onclick="nextStep(2)">← Kembali</button>
<div>
<button class="btn-tour btn-tour-skip" onclick="skipTour()">Lewati</button>
<button class="btn-tour btn-tour-primary" onclick="goTo('orders')">Buka Orderan →</button>
</div>
</div>
</div>

<!-- Step 4: Pengaturan Toko -->
<div class="step-card" data-step="4">
<div class="step-icon">⚙️</div>
<h2 class="step-title">Atur Tampilan Toko Anda</h2>
<p class="step-subtitle">Pelanggan akan melihat toko Anda di halaman publik. Pastikan tampilannya menarik & informatif.</p>
<ul class="step-list">
<li>Upload <strong>logo</strong> toko Anda</li>
<li>Pilih <strong>warna tema</strong> yang sesuai brand</li>
<li>Isi <strong>nomor rekening</strong> untuk pembayaran transfer</li>
<li>Tulis <strong>alamat</strong> toko / area layanan</li>
</ul>
<div class="step-tip">
<strong>🎨 Tips warna:</strong>
Makanan → merah/oranye (menggugah selera). Minuman → biru/hijau (segar). Jasa → biru/ungu (profesional).
</div>
<div class="step-actions">
<button class="btn-tour btn-tour-secondary" onclick="nextStep(3)">← Kembali</button>
<div>
<button class="btn-tour btn-tour-skip" onclick="skipTour()">Lewati</button>
<button class="btn-tour btn-tour-primary" onclick="goTo('pengaturan')">Buka Pengaturan →</button>
</div>
</div>
</div>

<!-- Step 5: Selesai -->
<div class="step-card" data-step="5">
<div class="step-icon">🎊</div>
<h2 class="step-title">Toko Anda Siap Berjualan!</h2>
<p class="step-subtitle">Anda sudah siap menerima pesanan. Share link toko ke tetangga, grup WA, atau sosmed Anda!</p>
<div class="feature-grid">
<a href="<?= base_url($toko->slug) ?>" target="_blank" class="feature-card" style="text-decoration:none;color:inherit;">
<div class="icon">🔗</div>
<div class="title">Link Toko</div>
<div class="desc"><?= base_url($toko->slug) ?></div>
</a>
<div class="feature-card"><div class="icon">📱</div><div class="title">WA</div><div class="desc">+<?= htmlspecialchars($toko->no_wa) ?></div></div>
<div class="feature-card"><div class="icon">👥</div><div class="title">Pelanggan</div><div class="desc">Tanpa batas</div></div>
</div>
<div class="step-tip">
<strong>🚀 Tips sukses:</strong>
1. Tambahkan minimal 5 menu favorit
2. Foto produk yang menarik
3. Respon order dalam 5 menit
4. Minta pelanggan repeat order!
</div>
<div class="step-actions">
<button class="btn-tour btn-tour-secondary" onclick="nextStep(4)">← Kembali</button>
<button class="btn-tour btn-tour-primary" onclick="completeTour()">🎉 Mulai Kelola Toko</button>
</div>
</div>

</div>

<script>
const baseUrl = '<?= base_url() ?>';
let currentStep = 1;
const totalSteps = 5;

function showStep(n) {
    document.querySelectorAll('.step-card').forEach(c => c.classList.remove('active'));
    document.querySelector(`.step-card[data-step="${n}"]`).classList.add('active');
    document.querySelectorAll('.tour-step-dot').forEach((d, i) => {
        d.classList.remove('active', 'done');
        if (i + 1 < n) d.classList.add('done');
        else if (i + 1 === n) d.classList.add('active');
    });
    document.getElementById('stepText').textContent = n + ' dari ' + totalSteps;
    currentStep = n;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep(n) { showStep(n); }

function goTo(page) {
    fetch(baseUrl + 'admin/skip_tour', { method: 'POST' })
        .then(r => r.json())
        .then(() => { window.location.href = baseUrl + 'admin/' + page; });
}

function skipTour() {
    if (confirm('Lewati tour? Anda bisa akses lagi dari menu Akun nanti.')) {
        fetch(baseUrl + 'admin/skip_tour', { method: 'POST' })
            .then(r => r.json())
            .then(() => { window.location.href = baseUrl + 'admin/dashboard'; });
    }
}

function completeTour() {
    fetch(baseUrl + 'admin/skip_tour', { method: 'POST' })
        .then(r => r.json())
        .then(() => { 
            spawnConfetti();
            setTimeout(() => { window.location.href = baseUrl + 'admin/dashboard'; }, 1500);
        });
}

function spawnConfetti() {
    const colors = ['#ff6b35', '#fbbf24', '#10b981', '#3b82f6', '#ec4899'];
    for (let i = 0; i < 50; i++) {
        const c = document.createElement('div');
        c.className = 'confetti';
        c.style.left = Math.random() * 100 + '%';
        c.style.background = colors[Math.floor(Math.random() * colors.length)];
        c.style.animationDelay = Math.random() * 0.5 + 's';
        c.style.animationDuration = (2 + Math.random() * 2) + 's';
        document.body.appendChild(c);
        setTimeout(() => c.remove(), 4000);
    }
}

// Keyboard navigation
document.addEventListener('keydown', e => {
    if (e.key === 'ArrowRight' && currentStep < totalSteps) showStep(currentStep + 1);
    if (e.key === 'ArrowLeft' && currentStep > 1) showStep(currentStep - 1);
    if (e.key === 'Escape') skipTour();
});
</script>
</body>
</html>
