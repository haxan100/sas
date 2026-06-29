<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Lupa Password · SAS TokoRumah</title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body.login-body {
    font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 50%, #fbbf24 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow-x: hidden;
    position: relative;
}

body.login-body::before, body.login-body::after {
    content: '';
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    opacity: .4;
    z-index: 0;
    animation: float 20s infinite ease-in-out;
}
body.login-body::before { width: 400px; height: 400px; background: #fbbf24; top: -100px; left: -100px; }
body.login-body::after { width: 300px; height: 300px; background: #ec4899; bottom: -80px; right: -80px; animation-delay: -10s; }
@keyframes float { 0%, 100% { transform: translate(0,0) scale(1); } 50% { transform: translate(30px, 20px) scale(1.1); } }

.login-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,.25);
    max-width: 440px;
    width: 100%;
    overflow: hidden;
    position: relative;
    z-index: 1;
    animation: cardIn .5s ease-out;
}
@keyframes cardIn { from { opacity: 0; transform: translateY(20px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }

.login-header {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: #fff;
    padding: 32px 32px 24px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.login-header::before { content: ''; position: absolute; right: -30px; top: -30px; width: 100px; height: 100px; background: rgba(255,255,255,.1); border-radius: 50%; }
.login-header::after { content: ''; position: absolute; left: -20px; bottom: -40px; width: 80px; height: 80px; background: rgba(255,255,255,.08); border-radius: 50%; }
.login-icon {
    width: 80px; height: 80px;
    border-radius: 20px;
    background: rgba(255,255,255,.2);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,.3);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 40px;
    margin: 0 auto 16px;
    position: relative; z-index: 1;
    animation: pulse 2s infinite;
}
@keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
.login-title { font-size: 24px; font-weight: 700; margin: 0 0 6px; position: relative; z-index: 1; }
.login-sub { font-size: 14px; opacity: .92; margin: 0; position: relative; z-index: 1; }

.login-body-form { padding: 28px 32px 32px; }

.alert {
    padding: 12px 14px; border-radius: 10px; margin-bottom: 18px; font-size: 13px; font-weight: 500;
    display: flex; align-items: center; gap: 8px;
    animation: shakeIn .4s;
}
@keyframes shakeIn { 0% { transform: translateX(0); } 25% { transform: translateX(-6px); } 50% { transform: translateX(6px); } 75% { transform: translateX(-3px); } 100% { transform: translateX(0); } }
.alert-error { background: #fef2f2; color: #b91c1c; border-left: 4px solid #ef4444; }
.alert-success { background: #f0fdf4; color: #14532d; border-left: 4px solid #4ade80; }

.form-group { margin-bottom: 16px; }
.form-label {
    display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #374151;
    display: flex; justify-content: space-between; align-items: center;
}
.form-input-wrap {
    position: relative;
    display: flex; align-items: center;
}
.form-input-wrap .form-control { padding-right: 44px; }
.form-input-wrap .icon-left { position: absolute; left: 12px; color: #9ca3af; font-size: 16px; pointer-events: none; }
.form-input-wrap .icon-right { position: absolute; right: 8px; background: none; border: none; color: #9ca3af; cursor: pointer; padding: 6px; border-radius: 6px; transition: all .15s; }
.form-input-wrap .icon-right:hover { color: #ff6b35; background: #fff3e0; }
.form-input-wrap.has-icon .form-control { padding-left: 40px; }

.form-control {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: all .15s;
    background: #fafafa;
    font-family: inherit;
}
.form-control:focus { outline: none; border-color: #ff6b35; background: #fff; box-shadow: 0 0 0 4px rgba(255,107,53,.12); }
.form-control::placeholder { color: #b5b8c0; }

.btn-login {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    margin-top: 4px;
    transition: all .2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    position: relative;
    overflow: hidden;
}
.btn-login::before {
    content: '';
    position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.3), transparent);
    transition: left .6s;
}
.btn-login:hover::before { left: 100%; }
.btn-login:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(255,107,53,.35); }
.btn-login:active { transform: translateY(0); }
.btn-login:disabled { opacity: .7; cursor: not-allowed; transform: none !important; }

.btn-login .spinner { display: inline-block; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: spin .8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

.login-divider {
    display: flex; align-items: center; gap: 12px; margin: 18px 0; color: #9ca3af; font-size: 12px; font-weight: 500;
}
.login-divider::before, .login-divider::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }

.login-foot {
    text-align: center; padding: 20px 24px;
    background: #fafbfc;
    border-top: 1px solid #f3f4f6;
    font-size: 13px; color: #6b7280;
}
.login-foot a { color: #ff6b35; text-decoration: none; font-weight: 600; transition: color .15s; }
.login-foot a:hover { color: #d65a2b; text-decoration: underline; }
.login-foot .divider { color: #d1d5db; margin: 0 8px; }

</style>
</head>
<body class="login-body">
<div class="login-card">
<div class="login-header">
<div class="login-icon">🔑</div>
<h1 class="login-title">Lupa Password</h1>
<p class="login-sub">Masukkan nomor telepon untuk reset password</p>
</div>

<div class="login-body-form">
<div id="form-alert" class="alert" style="display: none;">
    <span id="form-alert-icon"></span>
    <span id="form-alert-message"></span>
</div>

<form method="post" action="<?= base_url('admin/do_lupa_password') ?>" id="lupaPasswordForm" autocomplete="off">
<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
<div class="form-group">
<label class="form-label">Nomor Telepon</label>
<div class="form-input-wrap has-icon">
<span class="icon-left">📞</span>
<input type="tel" name="phone" id="phone" class="form-control" required autofocus placeholder="Contoh: 81234567890" oninput="validatePhone(this)">
</div>
</div>
<button type="submit" class="btn-login" id="btnSubmit">
<span id="btnText">Kirim Kode OTP</span>
</button>
</form>
</div>

<div class="login-foot">
<a href="<?= base_url('admin/login') ?>">← Kembali ke Login</a>
</div>
</div>

<script>
function validatePhone(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.startsWith('62')) {
        value = value.substring(2);
    }
    if (value.startsWith('0')) {
        value = value.substring(1);
    }
    input.value = value;
}

$(document).ready(function() {
    $('#lupaPasswordForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const btn = $('#btnSubmit');
        const btnText = $('#btnText');
        const alertDiv = $('#form-alert');
        const alertIcon = $('#form-alert-icon');
        const alertMsg = $('#form-alert-message');

        const phoneInput = $('#phone');
        if (!phoneInput.val().startsWith('8')) {
            alert('Nomor telepon harus diawali dengan angka 8.');
            return false;
        }

        btn.prop('disabled', true);
        btnText.html('<span class="spinner"></span> Mengirim...');
        alertDiv.hide();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                $('input[name="<?= $this->security->get_csrf_token_name(); ?>"]').val(response.csrf_hash);

                if (response.status === 'success') {
                    alertDiv.removeClass('alert-error').addClass('alert-success');
                    alertIcon.text('✅');
                    alertMsg.text('Berhasil! Mengarahkan ke halaman verifikasi...');
                    alertDiv.show();
                    setTimeout(function() {
                        window.location.href = response.redirect_url;
                    }, 1000);
                } else {
                    alertDiv.removeClass('alert-success').addClass('alert-error');
                    alertIcon.text('⚠️');
                    alertMsg.text(response.message);
                    alertDiv.show();
                    btn.prop('disabled', false);
                    btnText.text('Kirim Kode OTP');
                }
            },
            error: function() {
                alertDiv.removeClass('alert-success').addClass('alert-error');
                alertIcon.text('⚠️');
                alertMsg.text('Terjadi kesalahan koneksi. Coba lagi.');
                alertDiv.show();
                btn.prop('disabled', false);
                btnText.text('Kirim Kode OTP');
            }
        });
    });
});
</script>
</body>
</html>
