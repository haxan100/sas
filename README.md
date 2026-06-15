# SAS TokoRumah

Platform **SaaS Toko Online Perumahan**. Setiap tetangga bisa punya toko online sendiri, pelanggan tinggal pilih menu & pesan via WhatsApp.

**Stack:** PHP 7.4+ · CodeIgniter 3 · MySQL/MariaDB · HTML/CSS/JS (vanilla, no framework JS)

---

## 🚀 Instalasi

### 1. Copy/Upload ke server

Letakkan folder `sas` (atau rename) di:
- **XAMPP:** `C:\xampp\htdocs\sas`
- **Linux Apache:** `/var/www/html/sas`
- **Shared hosting:** `public_html/sas`
- **cPanel:** `public_html/sas`

### 2. Set permissions (Linux/Mac)

```bash
chmod -R 755 sas/
chmod -R 777 sas/application/cache sas/application/logs sas/assets/uploads
chown -R www-data:www-data sas/  # sesuaikan user web server
```

### 3. Buat database MySQL

Buat database baru (contoh `sas_tokorumah`) via phpMyAdmin atau CLI:

```sql
CREATE DATABASE sas_tokorumah DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
```

Edit `application/config/database.php`:
```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'sas_tokorumah',
```

### 4. Set base_url (auto-detect)

Base URL auto-detect dari `$_SERVER['HTTP_HOST']`. Untuk memastikan benar, edit `application/config/config.php`:

```php
$config['base_url'] = 'https://domain.com/sas/';
```

### 5. (Opsional) Set environment via .env

Copy `.env.example` ke `.env`:
```bash
cp .env.example .env
```

Edit:
```env
CI_ENV=production
APP_NAME=SAS TokoRumah
APP_DEBUG=false
```

### 6. Jalankan installer

Buka browser:
```
http://localhost/sas/install
```

Akan otomatis membuat tabel + owner demo + 2 toko demo.

### 7. Login default

| Role | URL | Akun |
|------|-----|------|
| Owner (Super Admin) | `/owner` | `admin` / `admin123` |
| Admin Toko Mie Ayam | `/admin` | `mieayam` / `mie123` |
| Admin Toko Nasi Kucing | `/admin` | `nasikucing` / `mie123` |

**⚠️ Ganti semua password default setelah install pertama!**

---

## 📁 Struktur Folder

```
sas/
├── application/
│   ├── config/          # Konfigurasi CI (database, routes, dll)
│   │   ├── config.php        # base_url, CSRF, security
│   │   ├── database.php      # DB credentials
│   │   ├── environment.php   # Auto-detect dev/prod
│   │   └── routes.php        # URL routing
│   ├── controllers/
│   │   ├── Admin.php     # Admin Toko (login, dashboard, CRUD)
│   │   ├── Main.php      # Halaman utama + 404 handler
│   │   ├── Owner.php     # Owner (Super Admin)
│   │   └── Toko.php      # Halaman user (pelanggan)
│   ├── models/
│   │   ├── Toko_model.php
│   │   ├── Produk_model.php
│   │   ├── Order_model.php
│   │   └── Kategori_model.php
│   └── views/
│       ├── admin/        # View admin toko
│       ├── owner/        # View owner
│       ├── toko/         # Partials (sidebar, header, dll)
│       ├── user/         # View pelanggan
│       ├── errors/       # 404 handler
│       └── home.php      # Landing page
├── assets/
│   ├── css/            # Stylesheet (style.css, admin-toko.css, admin-list.css)
│   ├── js/             # JavaScript (admin.js)
│   ├── img/            # Static images
│   └── uploads/        # User uploads (logo, foto produk)
├── system/             # CodeIgniter 3 core (jangan edit)
├── .htaccess           # URL rewrite (mod_rewrite)
├── .env.example        # Template environment
├── index.php           # Entry point
├── install.sql         # SQL schema (opsional)
└── README.md
```

---

## ⚙️ Konfigurasi Production

### Apache (.htaccess sudah include)

Pastikan `mod_rewrite` aktif. `AllowOverride All` di virtual host.

### Nginx

Tambah di server block:
```nginx
location /sas/ {
    try_files $uri $uri/ /sas/index.php?$query_string;
}
location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}
```

### PHP

- PHP 7.4+ (tested on 7.4.30)
- Extensions: mysqli, gd (untuk upload foto), mbstring, session

### Database

MySQL 5.7+ atau MariaDB 10.2+. InnoDB support required.

---

## 🔐 Keamanan

- Password di-hash dengan `password_hash()` (bcrypt)
- CSRF protection aktif (dengan exception untuk endpoint AJAX)
- Session regenerate setelah login
- SQL injection dicegah via Active Record / query binding
- File upload validation (image only, max 2MB)
- No-cache headers untuk halaman auth

---

## 🛠️ Customization

### Tema warna per toko

Bisa diubah di **Owner → Edit Toko → Tema Warna** atau via PHP:
```php
$data['toko']->tema_warna = '#ff6b35';
```

### Custom CSS

Edit `assets/css/style.css` (global) atau `assets/css/admin-toko.css` (admin panel).
View-specific styles ada di `<style>` tag dalam view (intentional, scoped per view).

### Tambah halaman baru

1. Tambah method di `Admin.php` controller
2. Tambah route di `application/config/routes.php`
3. Buat view di `application/views/admin/`

---

## 🐛 Troubleshooting

| Error | Solusi |
|-------|--------|
| Too many redirects | Hapus cookies browser, hard refresh (Ctrl+F5) |
| 404 Not Found | Cek `mod_rewrite` aktif, `.htaccess` di root |
| Database connection error | Cek credentials di `database.php` |
| Session not working | Cek folder `application/cache` writable |
| Upload gagal | `chmod 777` ke `assets/uploads/` |
| Login selalu gagal | Cek tabel `owner` dan `toko`, default password saat install |

---

## 📞 Akun Default (WAJIB DIGANTI!)

| Username | Password | Role |
|----------|----------|------|
| admin | admin123 | Owner |
| mieayam | mie123 | Admin Toko Mie Ayam |
| nasikucing | mie123 | Admin Toko Nasi Kucing |

---

## 📝 Lisensi

Custom / proprietary.
