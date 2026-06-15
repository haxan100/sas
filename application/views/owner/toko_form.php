<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-toko.css') ?>">
<?php $toko_warna = isset($toko) ? ($toko->tema_warna ?? '#ff6b35') : '#ff6b35'; ?>
<style>:root { --tema-color: <?= $toko_warna ?>; }</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php
$current_sidebar = isset($toko) ? '' : 'toko_tambah';
$this->load->view('owner/_sidebar', ['current_page' => $current_sidebar]);
?>
<div class="admin-main">
<?php
$page_title = isset($toko) ? 'Edit Toko' : 'Tambah Toko';
$this->load->view('owner/_header', ['page_title' => $page_title, 'breadcrumb' => 'Manajemen toko']);
?>
<main class="admin-content">
<?php if ($this->session->flashdata('sukses')): ?>
<div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;border-left:4px solid #10b981;"><?= $this->session->flashdata('sukses') ?></div>
<?php endif; ?>

<div class="setting-wrap">
<form method="post" action="<?= isset($toko) ? base_url('owner/toko_update/'.$toko->id) : base_url('owner/toko_simpan') ?>" enctype="multipart/form-data">

<div class="setting-card">
<div class="setting-head">🏪 Informasi Toko</div>
<div class="setting-body two-col">
<div class="form-group">
<label class="form-label">Nama Toko *</label>
<input type="text" name="nama_toko" class="form-control" required value="<?= htmlspecialchars($toko->nama_toko ?? '') ?>">
</div>
<div class="form-group">
<label class="form-label">Pemilik *</label>
<input type="text" name="pemilik" class="form-control" required value="<?= htmlspecialchars($toko->pemilik ?? '') ?>">
</div>
<div class="form-group">
<label class="form-label">Slug (URL) *</label>
<input type="text" name="slug" class="form-control" required value="<?= htmlspecialchars($toko->slug ?? '') ?>" placeholder="contoh: mieayam">
</div>
<div class="form-group">
<label class="form-label">Kategori</label>
<input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($toko->kategori ?? 'Makanan') ?>">
</div>
<div class="form-group">
<label class="form-label">Username Login *</label>
<input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($toko->username ?? '') ?>">
</div>
<div class="form-group">
<label class="form-label">Password <?= isset($toko) ? '(kosongkan jika tidak diubah)' : '*' ?></label>
<input type="text" name="password" class="form-control" <?= isset($toko) ? '' : 'required' ?>>
</div>
<div class="form-group">
<label class="form-label">No WhatsApp *</label>
<input type="text" name="no_wa" class="form-control" required value="<?= htmlspecialchars($toko->no_wa ?? '') ?>" placeholder="628xxx">
</div>
<?php if (isset($toko)): ?>
<div class="form-group">
<label class="form-label">Status</label>
<select name="status" class="form-control">
<option value="aktif" <?= $toko->status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
<option value="nonaktif" <?= $toko->status == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
</select>
</div>
<?php endif; ?>
<div class="form-group" style="grid-column:span 2;">
<label class="form-label">Alamat</label>
<textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($toko->alamat ?? '') ?></textarea>
</div>
</div>
</div>

<div class="setting-card">
<div class="setting-head">💳 Pembayaran</div>
<div class="setting-body two-col">
<div class="form-group">
<label class="form-label">Nama Bank</label>
<input type="text" name="nama_bank" class="form-control" value="<?= htmlspecialchars($toko->nama_bank ?? '') ?>" placeholder="BCA / BRI / Mandiri">
</div>
<div class="form-group">
<label class="form-label">No Rekening</label>
<input type="text" name="no_rek" class="form-control" value="<?= htmlspecialchars($toko->no_rek ?? '') ?>">
</div>
<div class="form-group" style="grid-column:span 2;">
<label class="form-label">Atas Nama</label>
<input type="text" name="atas_nama" class="form-control" value="<?= htmlspecialchars($toko->atas_nama ?? '') ?>">
</div>
</div>
</div>

<div class="setting-card">
<div class="setting-head">🎨 Tampilan</div>
<div class="setting-body">
<div class="form-group" style="margin-bottom:18px;">
<label class="form-label">Warna Tema Toko</label>
<div class="color-pick">
<input type="color" name="tema_warna" id="colorPicker" value="<?= $toko->tema_warna ?? '#ff6b35' ?>">
<input type="text" id="colorText" class="form-control" value="<?= $toko->tema_warna ?? '#ff6b35' ?>" readonly>
</div>
</div>
<div class="form-group">
<label class="form-label">Logo Toko</label>
<?php if (isset($toko) && $toko->logo): ?>
<p style="margin-bottom:8px;font-size:13px;color:#6b7280;">Logo saat ini: <strong><?= $toko->logo ?></strong></p>
<?php endif; ?>
<input type="file" name="logo" class="form-control" accept="image/*">
</div>
</div>
</div>

<button type="submit" class="btn-save">💾 Simpan Toko</button>
</form>
</div>
</main>
<?php $this->load->view('toko/_footer'); ?>
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
