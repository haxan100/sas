<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    public function index() {
        $status = [];

        // Cek / buat tabel owner
        if ($this->db->table_exists('owner')) {
            $status['owner'] = 'Tabel owner sudah ada';
        } else {
            $this->db->query("CREATE TABLE `owner` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(50) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `nama` VARCHAR(100) NOT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `username` (`username`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

            $hash = password_hash('admin123', PASSWORD_DEFAULT);
            $this->db->query("INSERT INTO owner (username, password, nama) VALUES (?, ?, ?)",
                ['admin', $hash, 'Super Admin']);
            $status['owner'] = 'Tabel owner DIBUAT + admin/admin123';
        }

        // Toko
        if (!$this->db->table_exists('toko')) {
            $this->db->query("CREATE TABLE `toko` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
            $status['toko'] = 'Tabel toko DIBUAT';
        } else { $status['toko'] = 'Tabel toko sudah ada'; }

        // Produk
        if (!$this->db->table_exists('produk')) {
            $this->db->query("CREATE TABLE `produk` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
            $status['produk'] = 'Tabel produk DIBUAT';
        } else { $status['produk'] = 'Tabel produk sudah ada'; }

        // Orders
        if (!$this->db->table_exists('orders')) {
            $this->db->query("CREATE TABLE `orders` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
            $status['orders'] = 'Tabel orders DIBUAT';
        } else { $status['orders'] = 'Tabel orders sudah ada'; }

        // Order items
        if (!$this->db->table_exists('order_items')) {
            $this->db->query("CREATE TABLE `order_items` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
            $status['order_items'] = 'Tabel order_items DIBUAT';
        } else { $status['order_items'] = 'Tabel order_items sudah ada'; }

        // Sample toko
        $sample = $this->db->get_where('toko', ['slug' => 'mieayam'])->row();
        if (!$sample) {
            $hash2 = password_hash('mie123', PASSWORD_DEFAULT);
            $this->db->query("INSERT INTO toko (slug, nama_toko, pemilik, username, password, no_wa, no_rek, nama_bank, atas_nama, kategori, tema_warna) VALUES
                ('mieayam','Mie Ayam Pak A','Pak A','mieayam',?,'6281234567890','1234567890','BCA','Pak A','Makanan','#e74c3c'),
                ('nasikucing','Nasi Kucing Bu B','Bu B','nasikucing',?,'6289876543210','0987654321','BRI','Bu B','Makanan','#27ae60')
            ", [$hash2, $hash2]);

            $this->db->query("INSERT INTO produk (toko_id, nama_produk, harga, deskripsi, stok) VALUES
                (1,'Mie Ayam Original',12000,'Mie ayam dengan kuah kaldu ayam',100),
                (1,'Mie Ayam Bakso',15000,'Mie ayam + bakso sapi',100),
                (1,'Mie Ayam Komplit',18000,'Mie ayam + bakso + pangsit',100),
                (2,'Nasi Kucing Biasa',5000,'Nasi kucing sambal teri',100),
                (2,'Nasi Kucing Spesial',8000,'Nasi kucing + ayam + telur',100)");
            $status['sample'] = 'Sample 2 toko DIBUAT';
        } else {
            $status['sample'] = 'Sample toko sudah ada';
        }

        $data['status'] = $status;
        $this->load->view('install_view', $data);
    }
}
