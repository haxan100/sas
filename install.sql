-- =====================================================
-- Database: sas_tokorumah
-- SaaS Toko Rumah - Multi Toko untuk Perumahan
-- =====================================================

CREATE DATABASE IF NOT EXISTS `sas_tokorumah` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sas_tokorumah`;

-- =====================================================
-- Tabel: owner (Super Admin / pemilik SaaS)
-- =====================================================
CREATE TABLE IF NOT EXISTS `owner` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Default owner: admin / admin123
INSERT INTO `owner` (`username`, `password`, `nama`) VALUES
('admin', '$2y$10$YQy4/4kL3V.qTvbWBVKKg.4nLh1Vh6wQ/8YHJ5Y3m9bM2YcGQ8kRa', 'Super Admin');

-- =====================================================
-- Tabel: toko (data toko masing2 bapak2)
-- =====================================================
CREATE TABLE IF NOT EXISTS `toko` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(50) NOT NULL,
  `nama_toko` VARCHAR(100) NOT NULL,
  `pemilik` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `no_wa` VARCHAR(20) NOT NULL,
  `no_rek` VARCHAR(50) DEFAULT NULL,
  `nama_bank` VARCHAR(50) DEFAULT NULL,
  `atas_nama` VARCHAR(100) DEFAULT NULL,
  `alamat` TEXT DEFAULT NULL,
  `kategori` VARCHAR(50) DEFAULT 'Umum',
  `logo` VARCHAR(255) DEFAULT NULL,
  `tema_warna` VARCHAR(20) DEFAULT '#ff6b35',
  `status` ENUM('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- =====================================================
-- Tabel: produk (menu / barang jualan)
-- =====================================================
CREATE TABLE IF NOT EXISTS `produk` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `toko_id` INT(11) UNSIGNED NOT NULL,
  `nama_produk` VARCHAR(100) NOT NULL,
  `harga` INT(11) NOT NULL DEFAULT 0,
  `deskripsi` TEXT DEFAULT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `stok` INT(11) DEFAULT 100,
  `status` ENUM('tersedia','habis') DEFAULT 'tersedia',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `toko_id` (`toko_id`),
  CONSTRAINT `fk_produk_toko` FOREIGN KEY (`toko_id`) REFERENCES `toko`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- =====================================================
-- Tabel: orders (pesanan user)
-- =====================================================
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_order` VARCHAR(20) NOT NULL,
  `toko_id` INT(11) UNSIGNED NOT NULL,
  `nama_pembeli` VARCHAR(100) NOT NULL,
  `blok_rumah` VARCHAR(50) NOT NULL,
  `no_wa_pembeli` VARCHAR(20) DEFAULT NULL,
  `metode_bayar` ENUM('cash','transfer') NOT NULL,
  `status_bayar` ENUM('belum','lunas') DEFAULT 'belum',
  `total_harga` INT(11) NOT NULL DEFAULT 0,
  `catatan` TEXT DEFAULT NULL,
  `status_order` ENUM('baru','diproses','selesai','batal') DEFAULT 'baru',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_order` (`kode_order`),
  KEY `toko_id` (`toko_id`),
  CONSTRAINT `fk_order_toko` FOREIGN KEY (`toko_id`) REFERENCES `toko`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- =====================================================
-- Tabel: order_items (detail item pesanan)
-- =====================================================
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) UNSIGNED NOT NULL,
  `produk_id` INT(11) UNSIGNED NOT NULL,
  `nama_produk` VARCHAR(100) NOT NULL,
  `harga` INT(11) NOT NULL,
  `qty` INT(11) NOT NULL DEFAULT 1,
  `subtotal` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `produk_id` (`produk_id`),
  CONSTRAINT `fk_item_order` FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
