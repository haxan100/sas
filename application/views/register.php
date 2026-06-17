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
    padding: 60px 20px 40px;
    line-height: 1.6;
}
.container { max-width: 540px; margin: 0 auto; }
.header { text-align: center; margin-bottom: 32px; }
.header h1 { color: #fff; font-size: 32px; font-weight: 700; margin-bottom: 8px; text-shadow: 0 2px 10px rgba(0,0,0,.1); }
.header p { color: rgba(255,255,255,.9); font-size: 15px; }
.form-card { 
    background: #fff; 
    border-radius: 20px; 
    padding: 40px; 
    box-shadow: 0 20px 60px rgba(0,0,0,.3);
}
.form-card h2 { 
    text-align: center; 
    margin-bottom: 8px; 
    color: #1a1a1a; 
    font-size: 24px;
    font-weight: 700;
}
.form-subtitle { 
    text-align: center; 
    color: #666; 
    font-size: 14px; 
    margin-bottom: 32px; 
}
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { margin-bottom: 24px; }
.form-group.full { grid-column: 1 / -1; }
.form-group label { 
    display: block; 
    margin-bottom: 8px; 
    color: #333; 
    font-weight: 600; 
    font-size: 14px;
}
.form-group label .required { color: #e74c3c; }
.form-group input, .form-group select, .form-group textarea { 
    width: 100%; 
    padding: 12px 16px; 
    border: 2px solid #e8e8e8; 
    border-radius: 10px; 
    font-size: 15px; 
    transition: all .3s;
    font-family: inherit;
    background: #fafafa;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
    outline: none; 
    border-color: #667eea; 
    background: #fff;
    box-shadow: 0 0 0 4px rgba(102,126,234,.1);
}
.form-group textarea { resize: vertical; min-height: 80px; }
.form-hint { 
    color: #888; 
    font-size: 13px; 
    display: block; 
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.form-hint::before { content: 'ℹ️'; font-size: 12px; }
.btn { 
    width: 100%; 
    padding: 16px; 
    border: none; 
    border-radius: 12px; 
    font-size: 16px; 
    font-weight: 700; 
    cursor: pointer; 
    transition: all .3s;
    font-family: inherit;
    margin-top: 8px;
}
.btn-primary { 
    background: linear-gradient(135deg, #667eea, #764ba2); 
    color: #fff;
    box-shadow: 0 4px 15px rgba(102,126,234,.4);
}
.btn-primary:hover { 
    transform: translateY(-2px); 
    box-shadow: 0 6px 25px rgba(102,126,234,.5);
}
.btn-primary:active { transform: translateY(0); }
.footer-links { 
    text-align: center; 
    margin-top: 24px; 
    padding-top: 24px;
    border-top: 1px solid #f0f0f0;
}
.footer-links a { 
    color: #667eea; 
    text-decoration: none; 
    font-weight: 600;
    font-size: 14px;
    transition: color .2s;
}
.footer-links a:hover { color: #764ba2; }
.footer-links span { color: #ccc; margin: 0 8px; }
.alert { 
    padding: 14px 18px; 
    border-radius: 10px; 
    margin-bottom: 24px; 
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
}
.alert-error { background: #fee; color: #c33; border-left: 4px solid #c33; }
.alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
.alert::before { font-size: 18px; }
.alert-error::before { content: '⚠️'; }
.alert-success::before { content: '✅'; }
@media (max-width: 600px) {
    .form-card { padding: 28px 20px; }
    .form-grid { grid-template-columns: 1fr; }
    body { padding: 40px 16px 24px; }
}
</style>
</head>
<body>
<div class="container">
<div class="header">
    <h1>🏪 Daftar Toko Baru</h1>
    <p class="form-subtitle">Mulai jualan online sekarang, gratis & mudah!</p>
</div>
<div class="form-card">
<form action="<?= base_url('register/submit') ?>" method="POST">
<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-error"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>
<div class="form-grid">
<div class="form-group full">
<label for="nama_toko">Nama Toko <span class="required">*</span></label>
<input type="text" id="nama_toko" name="nama_toko" value="<?= set_value('nama_toko') ?>" placeholder="Contoh: Toko Sembako Murah" required>
</div>
<div class="form-group full">
<label for="pemilik">Nama Pemilik <span class="required">*</span></label>
<input type="text" id="pemilik" name="pemilik" value="<?= set_value('pemilik') ?>" placeholder="Contoh: Budi Santoso" required>
</div>
<div class="form-group">
<label for="username">Username <span class="required">*</span></label>
<input type="text" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Contoh: tokosembako" required>
<small class="form-hint">Digunakan untuk login</small>
</div>
<div class="form-group">
<label for="password">Password <span class="required">*</span></label>
<input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
</div>
<div class="form-group full">
<label for="whatsapp">WhatsApp (No HP) <span class="required">*</span></label>
<input type="text" id="whatsapp" name="whatsapp" value="<?= set_value('whatsapp') ?>" placeholder="08123456789 atau +628123456789" required>
<small class="form-hint">Format: 08xxx atau +62xxx</small>
</div>
<div class="form-group">
<label for="kategori">Kategori <span class="required">*</span></label>
<select id="kategori" name="kategori" required>
<option value="">Pilih Kategori</option>
<option value="Makanan" <?= set_select('kategori','Makanan') ?>>Makanan</option>
<option value="Minuman" <?= set_select('kategori','Minuman') ?>>Minuman</option>
<option value="Sembako" <?= set_select('kategori','Sembako') ?>>Sembako</option>
<option value="Pakaian" <?= set_select('kategori','Pakaian') ?>>Pakaian</option>
<option value="Elektronik" <?= set_select('kategori','Elektronik') ?>>Elektronik</option>
<option value="Lainnya" <?= set_select('kategori','Lainnya') ?>>Lainnya</option>
</select>
</div>
<div class="form-group full">
<label for="alamat">Alamat (Opsional)</label>
<textarea id="alamat" name="alamat" rows="3" placeholder="Alamat toko (opsional)"><?= set_value('alamat') ?></textarea>
</div>
</div>
<button type="submit" class="btn btn-primary">Daftar Sekarang</button>
</form>
<div class="footer-links">
<span>Sudah punya toko?</span>
<a href="<?= base_url('admin') ?>">Login di sini</a>
</div>
</div>
</div>
</body>
</html>
