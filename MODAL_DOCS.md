# 📋 Dokumentasi Semua Modal & Form

Total **5 modal** di 4 file view. Semua sudah support:
- ✅ Server-side validation
- ✅ AJAX save (no page reload)
- ✅ Mobile responsive
- ✅ Form scroll (badan scroll, footer sticky)

---

## 1. `kategoriModal` (Kategori Cepat)
**Lokasi:** `admin/kategori_list.php` & `admin/produk_list.php`

| Field | Tipe | Wajib | Keterangan |
|-------|------|-------|------------|
| Nama Kategori | text | ✅ | Nama kategori baru |
| Icon (emoji) | text | ❌ | 1 emoji, contoh 🍰 |

*Button: Tambah*

---

## 2. `produkModal` (Produk CRUD)
**Lokasi:** `admin/produk_list.php`

| Field | Tipe | Wajib | Keterangan |
|-------|------|-------|------------|
| id | hidden | ❌ | ID produk (kosong untuk tambah) |
| Nama Produk | text | ✅ | |
| Kategori | select | ✅ | Dropdown dari daftar kategori toko |
| Harga Normal (Rp) | number | ✅ | Harga dalam Rupiah |
| Harga Diskon | number | ❌ | Harus lebih kecil dari harga normal |
| Deskripsi | textarea | ❌ | |
| Stok | number | ❌ | Default 100 |
| Status | select | ❌ | Tersedia / Habis |
| Foto Produk | file | ❌ | image/*, max 2MB |

*Buttons: Batal, Simpan*

---

## 3. `kategoriModal` di Owner Toko
**Lokasi:** `admin/produk_list.php` (button `+` di samping select kategori)

Sama dengan **#1**. Muncul inline untuk tambah kategori cepat saat produk sedang di-edit.

---

## 4. `orderModal` (Order Detail + Update Status)
**Lokasi:** `admin/orders_list.php`

### Display (read-only):
- Info Pembeli (nama, blok, WhatsApp)
- Info Pembayaran (metode, status bayar)
- Tanggal order
- Catatan umum (kalau ada)
- Tabel item pesanan + catatan per item

### Form Update:
| Field | Tipe | Wajib | Keterangan |
|-------|------|-------|------------|
| Status Order | select | ❌ | Baru / Diproses / Selesai / Batal |
| Status Bayar | select | ❌ | Belum Lunas / Lunas |

*Buttons: Tutup, Update*

---

## 5. `tokoModal` (Toko CRUD)
**Lokasi:** `owner/toko_list.php`

| Field | Tipe | Wajib | Keterangan |
|-------|------|-------|------------|
| id | hidden | ❌ | ID toko (kosong untuk tambah) |
| Nama Toko | text | ✅ | |
| Pemilik | text | ✅ | Nama pemilik |
| Slug (URL) | text | ✅ | URL path, contoh: `mieayam` |
| Kategori | text | ❌ | Contoh: Makanan, Minuman |
| Username Login | text | ✅ | Untuk login admin toko |
| Password | text | ❌ | Wajib saat tambah, kosongkan saat edit |
| No WhatsApp | text | ✅ | Format: `628xxx` |
| Alamat | textarea | ❌ | |
| Bank | text | ❌ | BCA / BRI / Mandiri |
| No Rekening | text | ❌ | |
| Atas Nama (Rekening) | text | ❌ | |
| Warna Tema | color | ❌ | Color picker, default `#ff6b35` |
| Logo | file | ❌ | image/*, max 2MB |
| Status (edit only) | select | ❌ | Aktif / Nonaktif |

*Buttons: Batal, Simpan*

---

## ✅ Status Implementasi

| Modal | File | Status | Field Validation |
|-------|------|--------|------------------|
| Kategori Cepat | admin/kategori_list.php, admin/produk_list.php | ✅ OK | ✅ server-side |
| Produk CRUD | admin/produk_list.php | ✅ OK | ✅ server-side |
| Order Detail + Update | admin/orders_list.php | ✅ OK | ✅ server-side |
| Toko CRUD | owner/toko_list.php | ✅ OK | ✅ server-side |

## 🔧 Verifikasi Layar Penuh (Modal Tidak Kepotong)

Semua modal sudah support:
- ✅ Desktop: centered card, max-height 95vh, body scroll, footer sticky
- ✅ Mobile: bottom sheet, max-height 96vh, body scroll, footer sticky
- ✅ Swipe-down to close (mobile)
- ✅ Tap backdrop to close
- ✅ Toast notification feedback
- ✅ Hard refresh browser (`Ctrl+Shift+R`) untuk update CSS/JS

## 📝 Server-Side Validation

Setiap `*_save` controller endpoint punya validasi:

**Toko (Owner)**
- `nama_toko`, `pemilik`, `slug`, `username`, `no_wa` required
- Password required saat tambah
- File upload: image/* only, max 2MB

**Produk (Admin Toko)**
- `nama_produk`, `kategori`, `harga` required
- `harga_diskon` (kalau ada) harus lebih kecil dari `harga`
- File upload: image/* only, max 2MB

**Kategori**
- `nama` required
- Unik per toko (dicek di server)

**Order Update**
- `status_order` ∈ {baru, diproses, selesai, batal}
- `status_bayar` ∈ {belum, lunas}

## 🔍 Yang Perlu Dicek Manual

1. Buka `http://localhost/sas/owner/toko_list` (login: `admin` / `admin123`)
2. Test **+ Tambah Toko** - form scroll OK?
3. Test **Edit** toko existing - semua field ke-load?
4. Buka `http://localhost/sas/admin/produk` (login: `mieayam` / `mie123`)
5. Test **+ Tambah Produk** - dropdown kategori populated?
6. Test **+** di samping select kategori (tambah cepat)
7. Buka `http://localhost/sas/admin/orders`
8. Test **👁️** di order - modal detail + form update muncul?
9. Test status order & bayar change

Kalau ada field yang error/lupa di-input, kasih tahu saya.
