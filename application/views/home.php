<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { 
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #f8fafc;
    color: #1e293b;
    line-height: 1.6;
}
.container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

/* Hero Section */
.hero { 
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff; 
    padding: 80px 0; 
    text-align: center;
    position: relative;
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill-opacity="0.1"><circle cx="20" cy="20" r="10"/><circle cx="80" cy="60" r="15"/><circle cx="40" cy="80" r="8"/></svg>');
    background-size: 100px;
}
.hero-content { position: relative; z-index: 2; max-width: 800px; margin: 0 auto; }
.hero h1 { 
    font-size: 48px; 
    font-weight: 800; 
    margin-bottom: 20px;
    letter-spacing: -1px;
    line-height: 1.1;
}
.hero h1 span { color: #fbbf24; }
.hero p { 
    font-size: 20px; 
    opacity: 0.95; 
    margin-bottom: 32px;
    line-height: 1.7;
}
.hero .btn {
    display: inline-block;
    background: #fff;
    color: #6366f1;
    padding: 16px 40px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    font-size: 16px;
    transition: all .3s;
    box-shadow: 0 8px 30px rgba(0,0,0,.15);
}
.hero .btn:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,.2); }

/* Stats Section */
.stats { 
    background: #fff; 
    padding: 60px 0;
    border-bottom: 1px solid #e2e8f0;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 32px;
}
.stat-card {
    text-align: center;
    padding: 24px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 20px;
    transition: all .3s;
}
.stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,.05); }
.stat-icon {
    font-size: 48px;
    margin-bottom: 16px;
    display: block;
}
.stat-value {
    font-size: 36px;
    font-weight: 800;
    color: #6366f1;
    margin-bottom: 4px;
}
.stat-label { color: #64748b; font-size: 15px; font-weight: 500; }

/* Toko Grid */
.toko-section { padding: 80px 0; }
.toko-section h2 {
    text-align: center;
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 40px;
    color: #1e293b;
}
.toko-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 32px;
}
.toko-card {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    transition: all .3s;
    position: relative;
}
.toko-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0,0,0,.12);
}
.toko-header { position: relative; height: 160px; }
.toko-header img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.toko-badge {
    position: absolute;
    top: 16px; right: 16px;
    background: rgba(255,255,255,.95);
    backdrop-filter: blur(10px);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
}
.toko-body { padding: 24px; }
.toko-body h3 { 
    font-size: 24px; 
    font-weight: 700; 
    margin-bottom: 8px;
    color: #0f172a;
}
.toko-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #64748b;
    font-size: 15px;
    margin-bottom: 16px;
}
.toko-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}
.toko-body .btn {
    display: block;
    text-align: center;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    padding: 14px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all .3s;
}
.toko-body .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99,102,241,.3);
}

/* Features */
.features { 
    background: #fff; 
    padding: 80px 0; 
    border-top: 1px solid #e2e8f0;
}
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    margin-top: 40px;
}
.feature {
    text-align: center;
    padding: 40px 32px;
    background: #f8fafc;
    border-radius: 24px;
    transition: all .3s;
}
.feature:hover { background: #f1f5f9; }
.feature .icon {
    font-size: 56px;
    margin-bottom: 20px;
    display: block;
}
.feature h4 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #1e293b;
}
.feature p { color: #64748b; font-size: 16px; line-height: 1.6; }

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    padding: 80px 0;
    text-align: center;
}
.cta-section h2 {
    font-size: 40px;
    font-weight: 800;
    margin-bottom: 20px;
}
.cta-section p {
    font-size: 20px;
    opacity: 0.95;
    max-width: 600px;
    margin: 0 auto 32px;
}
.cta-section .btn {
    display: inline-block;
    background: #fff;
    color: #6366f1;
    padding: 16px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 16px;
    text-decoration: none;
    transition: all .3s;
}
.cta-section .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0,0,0,.2);
}

/* Footer */
footer {
    background: #0f172a;
    color: #94a3b8;
    text-align: center;
    padding: 60px 20px;
}
.footer-content { max-width: 1200px; margin: 0 auto; }
.footer-logo {
    font-size: 32px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 20px;
    display: inline-block;
}
.footer-links {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin: 32px 0;
    flex-wrap: wrap;
}
.footer-links a {
    color: #94a3b8;
    text-decoration: none;
    font-weight: 500;
    transition: color .3s;
}
.footer-links a:hover { color: #fff; }
.cta-text {
    margin: 32px 0;
    font-size: 16px;
}
.cta-text a {
    color: #fbbf24;
    font-weight: 700;
    text-decoration: none;
}
.cta-text a:hover { color: #f59e0b; }
.footer-bottom {
    border-top: 1px solid #1e293b;
    padding-top: 32px;
    font-size: 14px;
}

@media (max-width: 768px) {
    .hero h1 { font-size: 32px; }
    .hero p { font-size: 16px; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .toko-grid { grid-template-columns: 1fr; }
    .features-grid { grid-template-columns: 1fr; }
    .footer-links { gap: 24px; }
}
</style>
</head>
<body>
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>🏪 SAS <span>TokoRumah</span></h1>
        <p>Platform SaaS untuk toko online perumahan. Setiap tetangga bisa punya toko sendiri dan melayani pelanggan lewat WhatsApp!</p>
        <a href="#toko-list" class="btn">Jelajahi Toko →</a>
    </div>
</section>



<!-- Toko List -->
<div class="toko-section" id="toko-list">
    <div class="container">
        <h2>🛍️ Toko Tersedia di Sekitar Anda</h2>
        <?php if (empty($toko)): ?>
        <div style="text-align:center;padding:80px 20px;">
            <div style="font-size:64px;margin-bottom:24px;">🔍</div>
            <h3 style="font-size:24px;margin-bottom:16px;">Belum ada toko di area Anda</h3>
            <p style="color:#64748b;font-size:16px;margin-bottom:32px;">Jadilah toko pertama di perumahan Anda!</p>
            <a href="<?= base_url('register') ?>" class="btn" style="display:inline-block;">Daftar Toko Sekarang</a>
        </div>
        <?php else: ?>
        <div class="toko-grid">
            <?php foreach ($toko as $t): if ($t->status != 'aktif') continue; $color = $t->tema_warna ?: '#6366f1'; ?>
            <div class="toko-card" style="border-top:4px solid <?= $color ?>">
                <div class="toko-header">
                    <?php if (!empty($t->cover_photo)): ?>
                    <img src="<?= base_url('assets/uploads/'.$t->cover_photo) ?>" alt="<?= htmlspecialchars($t->nama_toko) ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php elseif ($t->logo): ?>
                    <img src="<?= base_url('assets/uploads/'.$t->logo) ?>" alt="<?= htmlspecialchars($t->nama_toko) ?>">
                    <?php else: ?>
                    <div style="width:100%;height:100%;background:linear-gradient(135deg, <?= $color ?>, <?= $color ?>cc);display:flex;align-items:center;justify-content:center;font-size:48px;">🏪</div>
                    <?php endif; ?>
                    <div class="toko-badge">✅ Aktif</div>
                </div>
                <div class="toko-body">
                    <h3><?= htmlspecialchars($t->nama_toko) ?></h3>
                    <div class="toko-meta">
                        <span>📍 <?= htmlspecialchars($t->kategori) ?></span>
                        <span>👤 <?= htmlspecialchars($t->pemilik) ?></span>
                        <span>🕒 Aktif sejak <?= date('d/m/Y', strtotime($t->created_at)) ?></span>
                    </div>
                    <a href="<?= base_url($t->slug) ?>" class="btn">Buka Toko →</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Features -->
<div class="features">
    <div class="container">
        <h2 style="text-align:center;">⚡ Kenapa Pakai SAS TokoRumah?</h2>
        <div class="features-grid">
            <div class="feature">
                <span class="icon">🚀</span>
                <h4>Untuk Pemilik Toko</h4>
                <p>Buat toko dalam hitungan menit, kelola menu, track order, dan dapatkan pelanggan baru tanpa biaya tambahan!</p>
            </div>
            <div class="feature">
                <span class="icon">📱</span>
                <h4>Mobile Friendly</h4>
                <p>Desain responsif untuk HP. Pelanggan pesan langsung dari browser HP, langsung ke WhatsApp Anda!</p>
            </div>
            <div class="feature">
                <span class="icon">💰</span>
                <h4>Pembayaran Fleksibel</h4>
                <p>Dukung cash, transfer, atau COD. Pelanggan pilih metode yang mereka suka, Anda tetap terorganisir!</p>
            </div>
            <div class="feature">
                <span class="icon">🔒</span>
                <h4>Aman & Terpercaya</h4>
                <p>Data toko terlindungi, transaksi tercatat lengkap, dan semua aktivitas termonitor dalam dashboard owner!</p>
            </div>
            <div class="feature">
                <span class="icon">👥</span>
                <h4>Untuk Tetangga</h4>
                <p>Pelanggan dapat toko lokal terdekat, pesan dengan mudah, bayar cash/transfer, dan dapat produk favorit!</p>
            </div>
            <div class="feature">
                <span class="icon">📊</span>
                <h4>Analytics & Logs</h4>
                <p>Owner bisa monitor semua aktivitas sistem dalam satu dashboard dengan logging yang lengkap!</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="cta-section">
    <div class="container">
        <h2>🏪 Punya UMKM?</h2>
        <p>Bergabunglah dengan SAS TokoRumah sekarang dan mulai jualan online! Pendaftaran gratis, mudah, dan cepat!</p>
        <a href="<?= base_url('register') ?>" class="btn">Daftar Toko Sekarang</a>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="footer-content">
        <div class="footer-logo">🏪 SAS TokoRumah</div>
        <p style="margin-bottom:32px;">Platform SaaS toko online perumahan yang menghubungkan tetangga dengan toko lokal</p>
        <div class="footer-links">
            <a href="#toko-list">Toko</a>
            <a href="<?= base_url('register') ?>">Daftar</a>
        </div>
        
        <div class="footer-bottom">
            <p>SAS TokoRumah © 2026 — Dibuat untuk tetangga yang jualan 💛</p>
        </div>
    </div>
</footer>

<script>
// Load stats from server if data available
if (typeof statsData !== 'undefined') {
    document.getElementById('total-toko-stat').textContent = statsData.total_toko || 0;
    document.getElementById('total-order-stat').textContent = statsData.total_order || 0;
    document.getElementById('total-revenue-stat').textContent = 'Rp ' + (statsData.total_pendapatan || 0).toLocaleString('id-ID');
}
</script>
</body>
</html>
