<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Toko Controller
 * 
 * Untuk user view (pelanggan):
 * - index($slug)       → Halaman utama toko
 * - order($slug)       → Halaman order
 * - submit_order($slug) → Proses order (POST)
 * 
 * Untuk admin toko (login/logout only, sisanya di Admin controller):
 * - admin_login($slug) → Form login
 * - do_login($slug)    → Proses login
 * - admin_logout($slug)→ Logout
 */
class Toko extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Toko_model', 'Produk_model', 'Order_model', 'Kategori_model']);
        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form']);
        $this->load->helper('Log_helper');
    }

    // ============= HALAMAN USER (PELANGGAN) =============
    public function index($slug) {
        $toko = $this->Toko_model->get_by_slug($slug);
        if (!$toko || $toko->status != 'aktif') {
            $this->_notfound();
            return;
        }
        $data['toko'] = $toko;
        $data['produk'] = $this->Produk_model->get_by_toko($toko->id);
        $data['kategori'] = $this->Kategori_model->get_by_toko($toko->id);
        $this->load->view('user/toko_view', $data);
    }

    // Universal route handler - cek apakah slug valid
    public function route($slug) {
        $toko = $this->Toko_model->get_by_slug($slug);
        if ($toko && $toko->status == 'aktif') {
            $this->index($slug);
        } else {
            $this->_notfound();
        }
    }

    private function _notfound() {
        $data['title'] = '404 - Halaman Tidak Ditemukan';
        $this->load->view('errors/html/notfound_view', $data);
    }

    public function order($slug) {
        $toko = $this->Toko_model->get_by_slug($slug);
        if (!$toko || $toko->status != 'aktif') {
            show_404();
        }
        $data['toko'] = $toko;
        $data['produk'] = $this->Produk_model->get_by_toko($toko->id);
        $data['kategori'] = $this->Kategori_model->get_by_toko($toko->id);
        $this->load->view('user/toko_view', $data);
    }

    public function submit_order($slug) {
        $toko = $this->Toko_model->get_by_slug($slug);
        if (!$toko) {
            show_404();
        }

        $cart = json_decode($this->input->post('cart'), true);
        $nama = $this->input->post('nama_pembeli');
        $blok = $this->input->post('blok_rumah');
        $no_wa = $this->input->post('no_wa_pembeli');
        $metode = $this->input->post('metode_bayar');
        $catatan = $this->input->post('catatan');
        $status_bayar = $this->input->post('status_bayar') == '1' ? 'lunas' : 'belum';

        $items = [];
        $total = 0;
        $total_qty = 0;
        foreach ($cart as $c) {
            $p = $this->Produk_model->get_by_id($c['id']);
            if (!$p || $p->toko_id != $toko->id) continue;
            $harga_final = $this->Produk_model->get_harga_final($p);
            $qty = max(1, (int)$c['qty']);
            $sub = $harga_final * $qty;
            $total += $sub;
            $total_qty += $qty;
            $items[] = [
                'produk_id' => $p->id,
                'nama_produk' => $p->nama_produk,
                'harga' => $harga_final,
                'qty' => $qty,
                'subtotal' => $sub,
                'catatan' => isset($c['catatan']) ? $c['catatan'] : null,
            ];
        }

        $kode = 'TR-'.date('ymd').strtoupper(substr(md5(uniqid()),0,5));
        $order_data = [
            'kode_order' => $kode,
            'toko_id' => $toko->id,
            'nama_pembeli' => $nama,
            'blok_rumah' => $blok,
            'no_wa_pembeli' => $no_wa,
            'metode_bayar' => $metode,
            'status_bayar' => $status_bayar,
            'total_harga' => $total,
            'catatan' => $catatan,
            'status_order' => 'baru',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $order_id = $this->Order_model->insert_order($order_data, $items);
        
        // Log customer order
        Log_Helper::log_order_created($toko->id, $toko->nama_toko, $nama, $kode, $total);

        // Build WA message
        $msg = "Halo ".($toko->pemilik).", saya mau pesan:\n\n";
        foreach ($items as $it) {
            $msg .= "- ".$it['nama_produk']." x".$it['qty']." = Rp ".number_format($it['subtotal'],0,',','.')."\n";
            if (!empty($it['catatan'])) {
                $msg .= "  📝 ".$it['catatan']."\n";
            }
        }
        $msg .= "\nTotal: *Rp ".number_format($total,0,',', '.')."*\n";
        $msg .= "Nama: $nama\nBlok: $blok\n";
        if ($no_wa) $msg .= "WA: $no_wa\n";
        $msg .= "Bayar: ".strtoupper($metode);
        if ($metode == 'transfer') {
            $msg .= " (" . ($status_bayar == 'lunas' ? 'SUDAH TF' : 'BELUM TF') . ")";
        }
        $msg .= "\nKode: $kode";
        if ($catatan) $msg .= "\nCatatan: $catatan";
        $msg .= "\n\nMohon diproses ya, terima kasih!";

        $wa_url = "https://wa.me/".$toko->no_wa."?text=".rawurlencode($msg);

        echo json_encode([
            'status' => 'ok',
            'kode' => $kode,
            'wa_url' => $wa_url,
            'order_id' => $order_id,
        ]);
    }

    // ============= ADMIN AUTH (di sini, sisanya di Admin controller) =============
    public function admin_login($slug) {
        $toko = $this->Toko_model->get_by_slug($slug);
        if (!$toko) {
            redirect('admin');
        }
        $data['toko'] = $toko;
        $this->load->view('toko/login', $data);
    }

    public function do_login($slug) {
        $toko = $this->Toko_model->get_by_slug($slug);
        if (!$toko) {
            redirect('admin');
        }
        $u = $this->input->post('username');
        $p = $this->input->post('password');
        if ($u == $toko->username && password_verify($p, $toko->password)) {
            if ($toko->status != 'aktif') {
                $this->session->set_flashdata('error', 'Toko ini nonaktif. Hubungi owner.');
                redirect($slug.'/admin');
            }
            $this->session->sess_regenerate(TRUE);
            $this->session->set_userdata([
                'toko_id' => $toko->id,
                'toko_slug' => $toko->slug,
                'toko_nama' => $toko->nama_toko,
                'toko_tema' => $toko->tema_warna,
                'is_admin' => true,
            ]);
            redirect('admin/dashboard');
        }
        $this->session->set_flashdata('error', 'Username/password salah');
        redirect($slug.'/admin');
    }

    public function admin_logout($slug) {
        $this->session->unset_userdata(['toko_id', 'toko_slug', 'toko_nama', 'toko_tema', 'is_admin']);
        $this->session->sess_destroy();
        redirect('admin');
    }
}
