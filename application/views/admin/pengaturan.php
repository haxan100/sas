<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<?php $this->load->view('toko/_tema', ['toko' => $toko]); ?>
<style>
.setting-wrap { max-width: 800px; }
.color-pick { display: flex; align-items: center; gap: 12px; }
.color-pick input[type=color] { width: 54px; height: 44px; padding: 2px; border: 1px solid #d1d5db; border-radius: 8px; cursor: pointer; background: #fff; }
.color-pick input[type=text] { flex: 1; font-family: monospace; font-weight: 600; }
</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('toko/_sidebar', ['toko' => $toko, 'current_page' => 'pengaturan']); ?>
<div class="admin-main">
<?php $this->load->view('toko/_header', ['toko' => $toko, 'current_page' => 'pengaturan', 'page_title' => 'Pengaturan', 'breadcrumb' => 'Konfigurasi toko Anda']); ?>
<main class="admin-content">
<?php if ($this->session->flashdata('sukses')): ?>
<div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;border-left:4px solid #10b981;"><?= $this->session->flashdata('sukses') ?></div>
<?php endif; ?>

<div class="setting-wrap">
<form method="post" action="<?= base_url('admin/update_pengaturan') ?>" enctype="multipart/form-data">

<div class="setting-card">
<div class="setting-head">🏪 Informasi Toko</div>
<div class="setting-body two-col">
<div class="form-group">
<label class="form-label">Nama Toko *</label>
<input type="text" name="nama_toko" class="form-control" required value="<?= htmlspecialchars($toko->nama_toko) ?>">
</div>
<div class="form-group">
<label class="form-label">Pemilik</label>
<input type="text" name="pemilik" class="form-control" value="<?= htmlspecialchars($toko->pemilik) ?>">
</div>
<div class="form-group">
<label class="form-label">Kategori</label>
<input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($toko->kategori) ?>">
</div>
<div class="form-group">
<label class="form-label">No WhatsApp *</label>
<input type="text" name="no_wa" class="form-control" required value="<?= htmlspecialchars($toko->no_wa) ?>" placeholder="628xxx">
</div>
<div class="form-group" style="grid-column:span 2;">
<label class="form-label">Alamat</label>
<textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($toko->alamat) ?></textarea>
</div>
</div>
</div>

<div class="setting-card">
<div class="setting-head">💳 Pembayaran</div>
<div class="setting-body two-col">
<div class="form-group">
<label class="form-label">Nama Bank</label>
<input type="text" name="nama_bank" class="form-control" value="<?= htmlspecialchars($toko->nama_bank) ?>" placeholder="BCA / BRI / Mandiri">
</div>
<div class="form-group">
<label class="form-label">No Rekening</label>
<input type="text" name="no_rek" class="form-control" value="<?= htmlspecialchars($toko->no_rek) ?>">
</div>
<div class="form-group" style="grid-column:span 2;">
<label class="form-label">Atas Nama</label>
<input type="text" name="atas_nama" class="form-control" value="<?= htmlspecialchars($toko->atas_nama) ?>">
</div>
</div>
</div>

<div class="setting-card">
<div class="setting-head">🎨 Tampilan</div>
<div class="setting-body">
<div class="form-group" style="margin-bottom:18px;">
<label class="form-label">Warna Tema Toko</label>
<div class="color-pick">
<input type="color" name="tema_warna" id="colorPicker" value="<?= $toko->tema_warna ?>">
<input type="text" id="colorText" class="form-control" value="<?= $toko->tema_warna ?>" readonly>
</div>
</div>
<div class="form-group">
<label class="form-label">Logo Toko</label>
<div class="logo-area">
<div class="logo-preview">
<?php if ($toko->logo): ?>
<img src="<?= base_url('assets/uploads/'.$toko->logo) ?>">
<?php else: ?>
<span style="font-size:32px;">🏪</span>
<?php endif; ?>
</div>
<input type="file" name="logo" class="form-control" accept="image/*">
</div>
</div>
<div class="form-group">
<label class="form-label">Cover Toko (Banner)</label>
<div class="cover-area" style="margin-top:8px;">
<?php if (!empty($toko->cover_photo)): ?>
<div class="cover-preview" style="width:100%;max-width:400px;height:150px;border-radius:12px;overflow:hidden;margin-bottom:12px;background:#f0f0f0;">
<img src="<?= base_url('assets/uploads/'.$toko->cover_photo) ?>" style="width:100%;height:100%;object-fit:cover;">
</div>
<?php endif; ?>
<input type="file" name="cover_photo" class="form-control" accept="image/*">
<small style="color:#666;display:block;margin-top:6px;">Ukuran ideal: 1200x400 pixel (landscape)</small>
</div>
</div>
</div>
</div>

<div class="setting-card">
<div class="setting-head">🔒 Keamanan</div>
<div class="setting-body">
<div class="form-group">
<label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
<input type="password" name="password_baru" class="form-control" placeholder="********">
</div>
</div>
</div>

<button type="submit" class="btn-save">💾 Simpan Pengaturan</button>
</form>
</div>
</main>
<?php $this->load->view('toko/_bottom_nav', ['current_page' => 'pengaturan']); ?>
</div>
</div>
<script>
function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('show');
    document.getElementById('adminOverlay').classList.toggle('show');
}
const cp = document.getElementById('colorPicker');
const ct = document.getElementById('colorText');
if (cp) cp.addEventListener('input', () => ct.value = cp.value);
</script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>
</html>
