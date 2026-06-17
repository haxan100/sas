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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 60px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.container { max-width: 520px; width: 100%; }
.success-card { 
    background: #fff; 
    border-radius: 20px; 
    padding: 48px 40px; 
    box-shadow: 0 25px 70px rgba(0,0,0,.3);
    text-align: center;
}
.success-icon { 
    font-size: 72px; 
    margin-bottom: 24px;
    display: inline-block;
    width: 100px;
    height: 100px;
    line-height: 100px;
    background: linear-gradient(135deg, #28a745, #4caf50);
    border-radius: 50%;
    color: white;
    box-shadow: 0 10px 30px rgba(40,167,69,.3);
}
.success-card h2 { 
    color: #1a1a1a; 
    margin-bottom: 12px; 
    font-size: 28px;
    font-weight: 800;
}
.success-card p { 
    color: #666; 
    margin-bottom: 28px; 
    line-height: 1.7;
    font-size: 16px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}
.info-box { 
    background: #f8f9fa; 
    border: 1px solid #e9ecef; 
    padding: 20px; 
    border-radius: 12px; 
    text-align: left; 
    margin: 24px 0; 
    font-size: 15px; 
    color: #333;
}
.info-box strong { 
    color: #667eea; 
    font-size: 15px;
    display: block;
    margin-bottom: 10px;
}
.info-box ul { margin-left: 20px; margin-top: 8px; }
.info-box li { margin-bottom: 6px; }
.actions { margin-top: 32px; display: flex; gap: 16px; justify-content: center; }
.btn { 
    display: inline-block; 
    padding: 16px 32px; 
    border-radius: 12px; 
    font-weight: 700; 
    text-decoration: none; 
    transition: all .3s;
    font-family: inherit;
    border: none;
    cursor: pointer;
    font-size: 15px;
}
.btn-primary { 
    background: linear-gradient(135deg, #667eea, #764ba2); 
    color: #fff;
    box-shadow: 0 4px 15px rgba(102,126,234,.4);
}
.btn-primary:hover { 
    transform: translateY(-3px); 
    box-shadow: 0 8px 25px rgba(102,126,234,.5);
}
.btn-secondary { 
    background: #f8f9fa; 
    color: #667eea; 
    border: 2px solid #e8e8e8;
}
.btn-secondary:hover { 
    background: #f0f0f0; 
    border-color: #667eea;
    transform: translateY(-2px);
}
@media (max-width: 600px) {
    .success-card { padding: 40px 24px; }
    .actions { flex-direction: column; gap: 12px; }
    .btn { width: 100%; }
    body { padding: 40px 16px; }
}
</style>
</head>
<body>
<div class="container">
<div class="success-card">
<div class="success-icon">✓</div>
<h2>Pendaftaran Berhasil!</h2>
<p>Terima kasih telah mendaftar di SAS TokoRumah. Toko Anda sedang menunggu verifikasi dari owner.</p>
<div class="info-box">
<strong>📋 Status: Pending Verifikasi</strong>
<ul>
<li>Owner akan memeriksa data toko Anda dalam 24 jam</li>
<li>Anda akan menerima notifikasi saat toko disetujui</li>
</ul>
</div>
<div class="info-box">
<strong>💡 Langkah Selanjutnya</strong>
<ul>
<li>Tunggu notifikasi persetujuan dari owner</li>
<li>Login ke dashboard admin toko setelah disetujui</li>
<li>Kelola menu, lihat order, layani pelanggan via WhatsApp</li>
</ul>
</div>
<div class="actions">
<a href="<?= base_url() ?>" class="btn btn-primary">← Kembali ke Beranda</a>
<a href="<?= base_url('owner') ?>" class="btn btn-secondary">Login Owner</a>
</div>
</div>
</div>
</body>
</html>
