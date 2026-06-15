<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Owner · SAS TokoRumah</title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
.login-card { background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.2); max-width: 420px; width: 100%; }
.login-icon { width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px; box-shadow: 0 8px 24px rgba(99,102,241,.3); }
.login-title { font-size: 22px; font-weight: 700; color: #111; text-align: center; margin-bottom: 6px; }
.login-sub { color: #6b7280; font-size: 14px; text-align: center; margin-bottom: 28px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #374151; }
.form-control { width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all .15s; }
.form-control:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
.btn-login { width: 100%; padding: 12px; background: #111; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 8px; }
.btn-login:hover { background: #1f2937; }
.alert { padding: 12px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
.alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; }
.login-foot { text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #f3f4f6; font-size: 13px; color: #6b7280; }
.login-foot a { color: #6366f1; text-decoration: none; font-weight: 500; }
.login-hint { background: #f9fafb; padding: 10px 14px; border-radius: 8px; margin-top: 16px; font-size: 12px; color: #6b7280; text-align: center; }
</style>
</head>
<body>
<div class="login-card">
<div class="login-icon">👑</div>
<h1 class="login-title">Owner Login</h1>
<p class="login-sub">Masuk untuk kelola semua toko</p>

<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-error"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<form method="post" action="<?= base_url('owner/do_login') ?>">
<div class="form-group">
<label>Username</label>
<input type="text" name="username" class="form-control" required autofocus placeholder="Masukkan username">
</div>
<div class="form-group">
<label>Password</label>
<input type="password" name="password" class="form-control" required placeholder="Masukkan password">
</div>
<button type="submit" class="btn-login">Masuk</button>
</form>

<?php if (ENVIRONMENT === 'development'): ?>
<div class="login-hint">
<strong>Mode Development:</strong><br>
Akun owner default di-setup saat install.
</div>
<?php endif; ?>

<div class="login-foot">
<a href="<?= base_url('admin') ?>">Login Admin Toko</a>
 ·
<a href="<?= base_url() ?>">← Beranda</a>
</div>
</div>
</body>
</html>
