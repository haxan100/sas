<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daftar Toko Baru · SAS TokoRumah</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body.reg-body {
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

        body.reg-body::before,
        body.reg-body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .35;
            z-index: 0;
            animation: float 20s infinite ease-in-out;
        }

        body.reg-body::before {
            width: 400px;
            height: 400px;
            background: #fbbf24;
            top: -100px;
            left: -100px;
        }

        body.reg-body::after {
            width: 300px;
            height: 300px;
            background: #ec4899;
            bottom: -80px;
            right: -80px;
            animation-delay: -10s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(30px, 20px) scale(1.1);
            }
        }

        .reg-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .25);
            max-width: 520px;
            width: 100%;
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: cardIn .5s ease-out;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .reg-header {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #fff;
            padding: 32px 32px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .reg-header::before {
            content: '';
            position: absolute;
            right: -30px;
            top: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, .1);
            border-radius: 50%;
        }

        .reg-header::after {
            content: '';
            position: absolute;
            left: -20px;
            bottom: -40px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, .08);
            border-radius: 50%;
        }

        .reg-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, .3);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 16px;
            position: relative;
            z-index: 1;
        }

        .reg-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 6px;
            position: relative;
            z-index: 1;
        }

        .reg-sub {
            font-size: 14px;
            opacity: .92;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .reg-body-form {
            padding: 28px 32px 32px;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: shakeIn .4s;
        }

        @keyframes shakeIn {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-6px);
            }

            50% {
                transform: translateX(6px);
            }

            75% {
                transform: translateX(-3px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #10b981;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #374151;
        }

        .form-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input-wrap .form-control {
            padding-right: 44px;
        }

        .form-input-wrap .icon-left {
            position: absolute;
            left: 12px;
            color: #9ca3af;
            font-size: 16px;
            pointer-events: none;
        }

        .form-input-wrap .icon-right {
            position: absolute;
            right: 8px;
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            transition: all .15s;
        }

        .form-input-wrap .icon-right:hover {
            color: #ff6b35;
            background: #fff3e0;
        }

        .form-input-wrap.has-icon .form-control {
            padding-left: 40px;
        }

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

        .form-control:focus {
            outline: none;
            border-color: #ff6b35;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 107, 53, .12);
        }

        .form-control::placeholder {
            color: #b5b8c0;
        }

        .form-control:invalid {
            border-color: #fca5a5;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-reg {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-reg::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .3), transparent);
            transition: left .6s;
        }

        .btn-reg:hover::before {
            left: 100%;
        }

        .btn-reg:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(255, 107, 53, .35);
        }

        .btn-reg:active {
            transform: translateY(0);
        }

        .btn-reg:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none !important;
        }

        .info-box {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #fcd34d;
            border-radius: 10px;
            padding: 14px;
            margin-top: 16px;
            font-size: 12px;
            color: #92400e;
        }

        .info-box strong {
            color: #78350f;
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .info-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .info-box li {
            margin: 4px 0;
        }

        .reg-foot {
            text-align: center;
            padding: 20px 24px;
            background: #fafbfc;
            border-top: 1px solid #f3f4f6;
            font-size: 13px;
            color: #6b7280;
        }

        .reg-foot a {
            color: #ff6b35;
            text-decoration: none;
            font-weight: 600;
            transition: color .15s;
        }

        .reg-foot a:hover {
            color: #d65a2b;
        }

        @media(max-width: 520px) {
            .reg-card {
                border-radius: 16px;
            }

            .reg-header {
                padding: 28px 20px 20px;
            }

            .reg-body-form {
                padding: 22px 20px 24px;
            }

            .reg-icon {
                width: 70px;
                height: 70px;
                font-size: 36px;
            }

            .reg-title {
                font-size: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="reg-body">
    <div class="reg-card">
        <div class="reg-header">
            <div class="reg-icon">🏪</div>
            <h1 class="reg-title">Daftar Toko Baru</h1>
            <p class="reg-sub">Buat toko online untuk perumahan Anda</p>
        </div>

        <div class="reg-body-form">
            <div id="formAlert" class="alert" style="display:none;"></div>

            <form method="post" action="<?= base_url('admin/do_register') ?>" id="regForm" autocomplete="on">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Toko *</label>
                        <input type="text" name="nama_toko" id="nama_toko" class="form-control" required
                            placeholder="Contoh: Mie Ayam Pak A" value="<?= set_value('nama_toko') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Pemilik *</label>
                        <input type="text" name="pemilik" id="pemilik" class="form-control" required
                            placeholder="Nama lengkap Anda" value="<?= set_value('pemilik') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Username Login *</label>
                        <div class="form-input-wrap has-icon">
                            <span class="icon-left">👤</span>
                            <input type="text" name="username" id="username" class="form-control" required
                                placeholder=" Untuk login" value="<?= set_value('username') ?>" autocapitalize="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <div class="form-input-wrap">
                            <input type="password" name="password" id="password" class="form-control" required
                                placeholder="Min. 4 karakter" minlength="4">
                            <button type="button" class="icon-right" onclick="togglePassword()"
                                title="Lihat password">👁️</button>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">No WhatsApp *</label>
                        <div class="form-input-wrap has-icon">
                            <span class="icon-left">📱</span>
                            <input type="text" name="no_wa" id="no_wa" class="form-control" required
                                placeholder="8xxxxxxxxxx" value="<?= set_value('no_wa') ?>" maxlength="13">
                        </div>
                        <small class="form-hint">Contoh: 8123456789 (tanpa 0 atau 62)</small>
                        <div class="wa-error" id="waError" style="display:none;"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori Toko</label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Makanan & Minuman">Makanan & Minuman</option>
                            <option value="Martabak">Martabak</option>
                            <option value="Bakso">Bakso</option>
                            <option value="Mie Ayam">Mie Ayam</option>
                            <option value="Nasi Goreng">Nasi Goreng</option>
                            <option value="Jajanan">Jajanan</option>
                            <option value="Dessert">Dessert</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat / Lokasi</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2"
                        placeholder="Contoh: Cluster Melati, Jl. Anggrek Raya"><?= set_value('alamat') ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Bank * <button type="button" class="info-btn"
                                onclick="showInfoModal('rekening')" title="Info rekening">?</button></label>
                        <select name="nama_bank" id="nama_bank" class="form-control">
                            <option value="">- Pilih Bank -</option>
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BNI">BNI</option>
                            <option value="BTPN">BTPN / Jenius</option>
                            <option value="CIMB">CIMB Niaga</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No Rekening *</label>
                        <input type="text" name="no_rek" id="no_rek" class="form-control"
                            placeholder="Nomor rekening Anda" value="<?= set_value('no_rek') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Atas Nama Rekening *</label>
                    <input type="text" name="atas_nama" id="atas_nama" class="form-control"
                        placeholder="Nama pemilik rekening" value="<?= set_value('atas_nama') ?>" required>
                </div>

                <button type="submit" class="btn-reg" id="btnSubmit">
                    <span id="btnText">🚀 Daftar Sekarang</span>
                </button>

                <div style="text-align:center;margin-top:16px;">
                    <button type="button" class="info-link-btn" onclick="showInfoModal('gratis')">
                        <span style="font-size:16px;">ℹ️</span> Informasi Biaya & Pembayaran
                    </button>
                </div>
            </form>
        </div>

        <div class="reg-foot">
            <a href="<?= base_url('admin') ?>">← Sudah punya akun? Login</a>
            <span style="color:#d1d5db;margin:0 8px;">|</span>
            <a href="<?= base_url() ?>">Beranda</a>
        </div>
    </div>

    <!-- Info Modal -->
    <div class="info-modal-overlay" id="infoModalOverlay" onclick="closeInfoModal()">
        <div class="info-modal" id="infoModal">
            <button class="info-modal-close" onclick="closeInfoModal()">✕</button>
            <div class="info-modal-content" id="infoModalContent">
                <!-- Content will be injected here -->
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pw = document.getElementById('password');
            const btn = pw.nextElementSibling;
            if (pw.type === 'password') {
                pw.type = 'text';
                btn.textContent = '🙈';
            } else {
                pw.type = 'password';
                btn.textContent = '👁️';
            }
        }

        // AJAX Form Submission
        $('#regForm').on('submit', function (e) {
            e.preventDefault();
            
            var form = $(this);
            var btn = $('#btnSubmit');
            var btnText = $('#btnText');
            var alertBox = $('#formAlert');
            
            // Disable button & show loading
            btn.prop('disabled', true);
            btnText.html('<span style="display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .8s linear infinite;margin-right:8px;"></span> Mendaftar...');
            
            // Remove previous alerts
            alertBox.hide().removeClass('alert-error alert-success');
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'ok') {
                        // Tampilkan notifikasi sukses
                        showSuccessNotif(response.message);
                        
                        // Redirect ke dashboard setelah 2 detik
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000);
                    } else {
                        // Error
                        alertBox.addClass('alert-error')
                            .html('<span>⚠️</span><span>' + response.message + '</span>')
                            .fadeIn();
                        
                        // Update CSRF token if provided
                        if (response.csrf) {
                            $('input[name="' + response.csrf_name + '"]').val(response.csrf);
                        }
                    }
                },
                error: function (xhr) {
                    alertBox.addClass('alert-error')
                        .html('<span>⚠️</span><span>Terjadi kesalahan. Coba lagi.</span>')
                        .fadeIn();
                },
                complete: function () {
                    // Re-enable button only if error
                    if (!alertBox.hasClass('alert-success')) {
                        btn.prop('disabled', false);
                        btnText.html('🚀 Daftar Sekarang');
                    }
                }
            });
        });

        // Auto-generate slug from nama_toko
        document.getElementById('nama_toko')?.addEventListener('input', function () {
            const val = this.value.toLowerCase()
                .replace(/[^a-z0-9\s]/g, '')
                .replace(/\s+/g, '-')
                .substring(0, 30);
            const slugInput = document.getElementById('username');
            if (slugInput && !slugInput.dataset.edited) {
                slugInput.value = val;
            }
        });

        document.getElementById('username')?.addEventListener('input', function () {
            this.dataset.edited = 'true';
        });

        // Info Modal Functions
        const infoContents = {
            rekening: `
        <div class="info-modal-header">
            <div class="info-modal-icon">💳</div>
            <h3>Informasi Rekening</h3>
        </div>
        <div class="info-modal-body">
            <p>Rekening yang Anda masukkan akan ditampilkan kepada <strong>pembeli</strong> saat mereka memilih metode pembayaran transfer.</p>
            <div class="info-highlight">
                <span class="info-highlight-icon">🏦</span>
                <div>
                    <strong>Cara Kerja:</strong>
                    <ol>
                        <li>Pembeli pesan produk di toko Anda</li>
                        <li>Pembeli pilih metode "Transfer Bank"</li>
                        <li>Info rekening Anda tampil otomatis</li>
                        <li>Pembeli transfer langsung ke rekening Anda</li>
                    </ol>
                </div>
            </div>
            <p style="font-size:13px;color:#666;margin-top:12px;">Pastikan nomor rekening yang Anda masukkan sudah benar.</p>
        </div>
    `,
            gratis: `
        <div class="info-modal-header">
            <div class="info-modal-icon">✅</div>
            <h3>Biaya & Pembayaran</h3>
        </div>
        <div class="info-modal-body">
            <div class="info-badge-green">100% GRATIS</div>
            <div class="info-list">
                <div class="info-list-item">
                    <span class="info-check">✓</span>
                    <span>Tidak ada biaya pendaftaran</span>
                </div>
                <div class="info-list-item">
                    <span class="info-check">✓</span>
                    <span>Tidak ada biaya bulanan</span>
                </div>
                <div class="info-list-item">
                    <span class="info-check">✓</span>
                    <span>Tidak ada potongan admin/transaksi</span>
                </div>
                <div class="info-list-item">
                    <span class="info-check">✓</span>
                    <span>Tidak ada fee tersembunyi</span>
                </div>
            </div>
            <div class="info-highlight info-highlight-green">
                <span class="info-highlight-icon">💰</span>
                <div>
                    <strong>Uang masuk 100% ke rekening Anda!</strong>
                    <p style="margin:4px 0 0;font-size:13px;">Pembeli bayar langsung ke rekening toko Anda tanpa perantara.</p>
                </div>
            </div>
        </div>
    `
        };

        function showInfoModal(type) {
            const overlay = document.getElementById('infoModalOverlay');
            const modal = document.getElementById('infoModal');
            const content = document.getElementById('infoModalContent');

            content.innerHTML = infoContents[type] || '';
            overlay.classList.add('show');

            setTimeout(() => {
                modal.classList.add('show');
            }, 10);

            document.body.style.overflow = 'hidden';
        }

        function closeInfoModal() {
            const overlay = document.getElementById('infoModalOverlay');
            const modal = document.getElementById('infoModal');

            modal.classList.remove('show');

            setTimeout(() => {
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }, 300);
        }

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeInfoModal();
        });

        // Success Notification with Animation
        function showSuccessNotif(message) {
            // Buat overlay
            var overlay = $('<div class="success-overlay"></div>');
            // Buat notif card
            var notif = $(`
                <div class="success-notif">
                    <div class="success-icon-wrapper">
                        <div class="success-icon">✓</div>
                    </div>
                    <h3>Berhasil!</h3>
                    <p>${message}</p>
                    <div class="success-progress"></div>
                </div>
            `);
            
            $('body').append(overlay).append(notif);
            
            // Trigger animation
            setTimeout(function() {
                overlay.addClass('show');
                notif.addClass('show');
            }, 50);
        }

        // WhatsApp validation - real time
        const waInput = document.getElementById('no_wa');
        const waError = document.getElementById('waError');

        waInput.addEventListener('input', function () {
            let val = this.value.replace(/[^0-9]/g, '');

            // Auto-hapus 0 atau 62 di depan
            if (val.startsWith('0')) {
                val = val.substring(1);
                this.value = val;
            }
            if (val.startsWith('62')) {
                val = val.substring(2);
                this.value = val;
            }

            // Validasi format
            if (val.length > 0) {
                if (!val.startsWith('8')) {
                    waError.textContent = 'Nomor harus dimulai dengan 8 (contoh: 8123456789)';
                    waError.style.display = 'block';
                    this.classList.add('input-error');
                    this.classList.remove('input-success');
                } else if (val.length < 9) {
                    waError.textContent = 'Nomor terlalu pendek (minimal 9 digit)';
                    waError.style.display = 'block';
                    this.classList.add('input-error');
                    this.classList.remove('input-success');
                } else if (val.length > 13) {
                    waError.textContent = 'Nomor terlalu panjang (maksimal 13 digit)';
                    waError.style.display = 'block';
                    this.classList.add('input-error');
                    this.classList.remove('input-success');
                } else {
                    waError.style.display = 'none';
                    this.classList.remove('input-error');
                    this.classList.add('input-success');
                }
            } else {
                waError.style.display = 'none';
                this.classList.remove('input-error', 'input-success');
            }
        });

        // Username availability check - debounce
        let usernameTimer;
        const usernameInput = document.getElementById('username');

        // Tambah status element setelah username input
        const usernameStatus = document.createElement('div');
        usernameStatus.className = 'username-status';
        usernameInput.parentNode.appendChild(usernameStatus);

        usernameInput.addEventListener('input', function () {
            clearTimeout(usernameTimer);
            const val = this.value.trim().toLowerCase();

            if (val.length < 3) {
                usernameStatus.style.display = 'none';
                this.classList.remove('input-error', 'input-success');
                return;
            }

            usernameTimer = setTimeout(() => {
                fetch('<?= base_url('admin/check_username') ?>?username=' + encodeURIComponent(val))
                    .then(r => r.json())
                    .then(data => {
                        if (data.available) {
                            usernameStatus.textContent = '✓ Username tersedia';
                            usernameStatus.className = 'username-status available';
                            usernameInput.classList.remove('input-error');
                            usernameInput.classList.add('input-success');
                        } else {
                            usernameStatus.textContent = '✕ Username sudah digunakan';
                            usernameStatus.className = 'username-status taken';
                            usernameInput.classList.add('input-error');
                            usernameInput.classList.remove('input-success');
                        }
                    });
            }, 500);
        });
    </script>
    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .info-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            border: none;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-left: 6px;
            vertical-align: middle;
            line-height: 1;
        }

        .info-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
        }

        .info-link-btn {
            background: none;
            border: none;
            color: #6b7280;
            font-size: 13px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .info-link-btn:hover {
            background: #f3f4f6;
            color: #ff6b35;
        }

        /* Modal Overlay */
        .info-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .info-modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Modal */
        .info-modal {
            background: #fff;
            border-radius: 20px;
            max-width: 420px;
            width: 100%;
            max-height: 85vh;
            overflow-y: auto;
            position: relative;
            transform: scale(0.9) translateY(20px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }

        .info-modal.show {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .info-modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: #f3f4f6;
            color: #6b7280;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            z-index: 1;
        }

        .info-modal-close:hover {
            background: #e5e7eb;
            color: #111;
        }

        .info-modal-content {
            padding: 28px;
        }

        .info-modal-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .info-modal-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 12px;
        }

        .info-modal-header h3 {
            font-size: 20px;
            font-weight: 700;
            color: #111;
            margin: 0;
        }

        .info-modal-body {
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
        }

        .info-modal-body p {
            margin: 0 0 12px;
        }

        .info-highlight {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #fcd34d;
            border-radius: 12px;
            padding: 14px;
            display: flex;
            gap: 12px;
            margin: 16px 0;
        }

        .info-highlight-green {
            background: linear-gradient(135deg, #dcfce7, #86efac);
            border-color: #4ade80;
        }

        .info-highlight-icon {
            font-size: 24px;
            flex-shrink: 0;
        }

        .info-highlight ol {
            margin: 8px 0 0;
            padding-left: 18px;
            font-size: 13px;
        }

        .info-highlight ol li {
            margin: 4px 0;
        }

        .info-badge-green {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .info-list {
            margin: 16px 0;
        }

        .info-list-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-list-item:last-child {
            border-bottom: none;
        }

        .info-check {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #dcfce7;
            color: #166534;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        @media(max-width: 480px) {
            .info-modal {
                border-radius: 16px 16px 0 0;
                max-height: 90vh;
                margin-top: auto;
            }

            .info-modal-overlay {
                align-items: flex-end;
                padding: 0;
            }

            .info-modal.show {
                transform: scale(1) translateY(0);
            }
        }

        .form-hint {
            display: block;
            font-size: 11px;
            color: #6b7280;
            margin-top: 4px;
            padding-left: 4px;
        }

        .wa-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
            padding: 6px 10px;
            background: #fef2f2;
            border-radius: 6px;
            border-left: 3px solid #ef4444;
        }

        .username-status {
            font-size: 12px;
            margin-top: 4px;
            padding: 4px 8px;
            border-radius: 6px;
            display: none;
        }

        .username-status.available {
            display: block;
            color: #166534;
            background: #dcfce7;
        }

        .username-status.taken {
            display: block;
            color: #991b1b;
            background: #fee226;
        }

        .input-error {
            border-color: #ef4444 !important;
        }

        .input-success {
            border-color: #10b981 !important;
        }

        /* Success Notification */
        .success-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(8px);
            z-index: 9998;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .success-overlay.show {
            opacity: 1;
        }

        .success-notif {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            background: #fff;
            border-radius: 24px;
            padding: 40px;
            text-align: center;
            z-index: 9999;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-width: 360px;
            width: 90%;
        }
        .success-notif.show {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        .success-icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: iconPop 0.5s ease 0.2s both;
        }

        .success-icon {
            color: #fff;
            font-size: 40px;
            font-weight: 700;
        }

        @keyframes iconPop {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .success-notif h3 {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            margin: 0 0 8px;
        }

        .success-notif p {
            font-size: 14px;
            color: #6b7280;
            margin: 0 0 24px;
            line-height: 1.5;
        }

        .success-progress {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
        }

        .success-progress::after {
            content: '';
            display: block;
            height: 100%;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 2px;
            animation: progress 2s linear forwards;
        }

        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>
</body>

</html>