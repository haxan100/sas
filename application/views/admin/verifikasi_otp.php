<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Verifikasi OTP · SAS TokoRumah</title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body.login-body { font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif; background: linear-gradient(135deg, #ff6b35 0%, #f7931e 50%, #fbbf24 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
.login-card { background: #fff; border-radius: 20px; box-shadow: 0 25px 60px rgba(0,0,0,.25); max-width: 440px; width: 100%; overflow: hidden; position: relative; z-index: 1; }
.login-header { background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; padding: 32px 32px 24px; text-align: center; }
.login-icon { width: 80px; height: 80px; border-radius: 20px; background: rgba(255,255,255,.2); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,.3); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 16px; }
.login-title { font-size: 24px; font-weight: 700; margin: 0 0 6px; }
.login-sub { font-size: 14px; opacity: .92; margin: 0; }
.login-body-form { padding: 28px 32px 32px; }
.alert { padding: 12px 14px; border-radius: 10px; margin-bottom: 18px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.alert-error { background: #fef2f2; color: #b91c1c; border-left: 4px solid #ef4444; }
.alert-success { background: #f0fdf4; color: #14532d; border-left: 4px solid #4ade80; }
.form-group { margin-bottom: 16px; }
.form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #374151; }
.form-input-wrap { position: relative; display: flex; align-items: center; }
.form-input-wrap.has-icon .form-control { padding-left: 40px; }
.form-input-wrap .icon-left { position: absolute; left: 12px; color: #9ca3af; font-size: 16px; pointer-events: none; }
.form-control { width: 100%; padding: 12px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all .15s; background: #fafafa; font-family: inherit; }
.form-control:focus { outline: none; border-color: #ff6b35; background: #fff; box-shadow: 0 0 0 4px rgba(255,107,53,.12); }
.btn-login { width: 100%; padding: 14px; background: linear-gradient(135deg, #ff6b35, #f7931e); color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; margin-top: 4px; }
.login-foot { text-align: center; padding: 20px 24px; background: #fafbfc; border-top: 1px solid #f3f4f6; font-size: 13px; color: #6b7280; }
.login-foot a { color: #ff6b35; text-decoration: none; font-weight: 600; }
</style>
</head>
<body class="login-body">
<div class="login-card">
<div class="login-header">
<div class="login-icon">📲</div>
<h1 class="login-title">Verifikasi OTP</h1>
<p class="login-sub">Kami telah mengirimkan kode OTP ke nomor <strong>+62<?= htmlspecialchars($phone) ?></strong></p>
</div>

<div class="login-body-form">
<div id="form-alert" class="alert" style="display: none;">
    <span id="form-alert-icon"></span>
    <span id="form-alert-message"></span>
</div>

<form method="post" action="<?= base_url('admin/do_verifikasi_otp') ?>" id="verifyOtpForm" autocomplete="off">
<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
<div class="form-group">
<label class="form-label">Kode OTP (5 digit)</label>
<div class="form-input-wrap has-icon">
<span class="icon-left">#️⃣</span>
<input type="text" name="otp" id="otp" class="form-control" required autofocus pattern="\d{5}" title="Masukkan 5 digit kode OTP" inputmode="numeric" maxlength="5" style="text-align:center; font-size: 1.5em; letter-spacing: 0.5em;">
</div>
</div>
<button type="submit" class="btn-login" id="btnSubmit">
    <span id="btnText">Verifikasi Kode</span>
</button>
</form>
</div>

<div class="login-foot">
<a href="<?= base_url('admin/lupa_password') ?>">Salah nomor? Kirim ulang</a>
</div>
</div>

<script>
$(document).ready(function() {
    $('#verifyOtpForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const btn = $('#btnSubmit');
        const btnText = $('#btnText');
        const alertDiv = $('#form-alert');
        const alertIcon = $('#form-alert-icon');
        const alertMsg = $('#form-alert-message');

        btn.prop('disabled', true);
        btnText.html('<span class="spinner"></span> Memverifikasi...');
        alertDiv.hide();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.csrf_hash) {
                    $('input[name="<?= $this->security->get_csrf_token_name(); ?>"]').val(response.csrf_hash);
                }

                if (response.status === 'success') {
                    alertDiv.removeClass('alert-error').addClass('alert-success');
                    alertIcon.text('✅');
                    alertMsg.text(response.message);
                    alertDiv.show();
                    setTimeout(function() {
                        window.location.href = response.redirect_url;
                    }, 800);
                } else {
                    alertDiv.removeClass('alert-success').addClass('alert-error');
                    alertIcon.text('⚠️');
                    alertMsg.text(response.message);
                    alertDiv.show();
                    btn.prop('disabled', false);
                    btnText.text('Verifikasi Kode');
                    if(response.redirect_url) {
                        setTimeout(function() { window.location.href = response.redirect_url; }, 1500);
                    }
                }
            },
            error: function() {
                alertDiv.removeClass('alert-success').addClass('alert-error');
                alertIcon.text('⚠️');
                alertMsg.text('Terjadi kesalahan koneksi.');
                alertDiv.show();
                btn.prop('disabled', false);
                btnText.text('Verifikasi Kode');
            }
        });
    });
});
</script>
</body>
</html>
