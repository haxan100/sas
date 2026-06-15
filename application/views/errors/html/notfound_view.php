<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?> · SAS TokoRumah</title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif; background: linear-gradient(135deg, #f5f7fb 0%, #e0e7ff 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
.error-wrap { max-width: 600px; width: 100%; text-align: center; padding: 40px 30px; }
.error-illust { position: relative; width: 280px; height: 220px; margin: 0 auto 30px; }
.error-illust .num { font-size: 180px; font-weight: 900; color: #111; line-height: 1; letter-spacing: -8px; background: linear-gradient(135deg, #ff6b35, #f7931e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.error-illust .blob { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 200px; height: 200px; background: rgba(255, 107, 53, 0.08); border-radius: 50%; z-index: -1; animation: pulse 3s ease-in-out infinite; }
@keyframes pulse { 0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.6; } 50% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; } }
.error-title { font-size: 28px; font-weight: 700; color: #111; margin-bottom: 12px; }
.error-desc { color: #6b7280; font-size: 15px; line-height: 1.6; margin-bottom: 30px; max-width: 480px; margin-left: auto; margin-right: auto; }
.error-actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
.error-actions a { display: inline-flex; align-items: center; gap: 6px; padding: 12px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all .2s; }
.btn-primary-404 { background: #111; color: #fff; }
.btn-primary-404:hover { background: #1f2937; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.15); }
.btn-secondary-404 { background: #fff; color: #111; border: 1px solid #e5e7eb; }
.btn-secondary-404:hover { background: #f9fafb; border-color: #d1d5db; }
.error-search { margin-top: 30px; padding-top: 30px; border-top: 1px solid #e5e7eb; }
.error-search p { color: #9ca3af; font-size: 13px; margin-bottom: 14px; }
.error-search form { display: flex; gap: 8px; max-width: 380px; margin: 0 auto; }
.error-search input { flex: 1; padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; }
.error-search input:focus { outline: none; border-color: #ff6b35; box-shadow: 0 0 0 3px rgba(255,107,53,.15); }
.error-search button { padding: 10px 18px; background: #111; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
.error-hint { background: #fff; border-radius: 10px; padding: 16px 20px; margin-top: 24px; border: 1px solid #e5e7eb; text-align: left; }
.error-hint h4 { font-size: 13px; color: #6b7280; text-transform: uppercase; margin-bottom: 8px; letter-spacing: .5px; }
.error-hint ul { list-style: none; padding: 0; }
.error-hint li { padding: 4px 0; color: #4b5563; font-size: 13px; }
.error-hint li::before { content: '→ '; color: #ff6b35; font-weight: 700; }
@media(max-width: 480px) {
  .error-illust { width: 220px; height: 180px; }
  .error-illust .num { font-size: 130px; letter-spacing: -6px; }
  .error-title { font-size: 22px; }
}
</style>
</head>
<body>
<div class="error-wrap">
<div class="error-illust">
<div class="blob"></div>
<div class="num">404</div>
</div>
<h1 class="error-title">Halaman Tidak Ditemukan</h1>
<p class="error-desc">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan. Mungkin URL salah ketik, atau halaman sudah dihapus.</p>

<div class="error-actions">
<a href="<?= base_url() ?>" class="btn-primary-404">🏠 Kembali ke Beranda</a>
<a href="javascript:history.back()" class="btn-secondary-404">← Halaman Sebelumnya</a>
</div>

<div class="error-hint">
<h4>🔗 Halaman yang mungkin Anda cari:</h4>
<ul>
<li><a href="<?= base_url('owner') ?>" style="color:#111;text-decoration:none;">Login Owner (Super Admin)</a></li>
<li><a href="<?= base_url('admin') ?>" style="color:#111;text-decoration:none;">Login Admin Toko</a></li>
<li><a href="<?= base_url() ?>" style="color:#111;text-decoration:none;">Lihat Toko Aktif</a></li>
</ul>
</div>

<div class="error-search">
<p>Atau cari halaman di sini:</p>
<form onsubmit="event.preventDefault(); window.location.href = '<?= base_url() ?>' + document.getElementById('searchInput').value; return false;">
<input type="text" id="searchInput" placeholder="Coba: mieayam, admin, owner..." autofocus>
<button>Cari</button>
</form>
</div>
</div>
</body>
</html>
