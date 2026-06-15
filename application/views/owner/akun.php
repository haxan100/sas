<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<style>
.admin-sidebar, .admin-header, .bottom-nav { --tema: #6366f1; }
.setting-wrap { max-width: 600px; }
.profile-card { display: flex; align-items: center; gap: 16px; padding: 20px; background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 16px; }
.profile-avatar { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: 700; }
.profile-info h3 { font-size: 18px; margin-bottom: 2px; }
.profile-info p { color: #6b7280; font-size: 13px; }
.help-text { font-size: 12px; color: #9ca3af; margin-top: 4px; }
</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('owner/_sidebar', ['current_page' => 'akun']); ?>
<div class="admin-main">
<?php $this->load->view('owner/_header', ['page_title' => 'Akun Saya', 'breadcrumb' => 'Username & password owner']); ?>
<main class="admin-content">
<?php if ($this->session->flashdata('sukses')): ?>
<div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;border-left:4px solid #10b981;"><?= $this->session->flashdata('sukses') ?></div>
<?php endif; ?>

<div class="setting-wrap">
<div class="profile-card">
<div class="profile-avatar"><?= strtoupper(substr($owner->nama, 0, 1)) ?></div>
<div class="profile-info">
<h3><?= htmlspecialchars($owner->nama) ?></h3>
<p>👑 Super Admin · @<?= htmlspecialchars($owner->username) ?></p>
</div>
</div>

<form id="akunForm" onsubmit="return false;">
<div class="setting-card">
<div class="setting-head">👤 Identitas</div>
<div class="setting-body">
<div class="form-group">
<label class="form-label">Nama Lengkap</label>
<input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($owner->nama) ?>" placeholder="Nama owner">
</div>
<div class="form-group">
<label class="form-label">Username Login *</label>
<input type="text" name="username" id="akunUsername" class="form-control" required value="<?= htmlspecialchars($owner->username) ?>">
<p class="help-text">Username untuk login ke dashboard owner</p>
</div>
</div>
</div>

<div class="setting-card">
<div class="setting-head">🔒 Ganti Password</div>
<div class="setting-body">
<div class="form-group">
<label class="form-label">Password Lama</label>
<input type="password" name="password_lama" id="pwLama" class="form-control" placeholder="Kosongkan jika tidak ingin ganti">
<p class="help-text">Wajib diisi jika ingin ganti password</p>
</div>
<div class="form-group">
<label class="form-label">Password Baru</label>
<input type="password" name="password_baru" id="pwBaru" class="form-control" placeholder="Minimal 4 karakter" minlength="4">
</div>
<div class="form-group">
<label class="form-label">Konfirmasi Password Baru</label>
<input type="password" name="password_konfirm" id="pwKonfirm" class="form-control" placeholder="Ulangi password baru">
</div>
</div>
</div>

<button type="submit" class="btn-save" id="btnSimpan">💾 Simpan Perubahan</button>
</form>
</div>
</main>
<?php $this->load->view('toko/_footer'); ?>
</div>
</div>
<div class="toast" id="toast"><span id="toastMsg"></span></div>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
<script>
document.getElementById('akunForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const btn = document.getElementById('btnSimpan');
    btn.disabled = true; btn.textContent = '⏳ Menyimpan...';
    fetch('<?= base_url('owner/update_akun') ?>', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false; btn.textContent = '💾 Simpan Perubahan';
            toast(data.message, data.status);
            if (data.status === 'ok') {
                document.getElementById('pwLama').value = '';
                document.getElementById('pwBaru').value = '';
                document.getElementById('pwKonfirm').value = '';
            }
        })
        .catch(err => {
            btn.disabled = false; btn.textContent = '💾 Simpan Perubahan';
            toast('Error: ' + err, 'error');
        });
});
</script>
</body>
</html>
