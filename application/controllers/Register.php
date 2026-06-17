<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Toko_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['title'] = 'Daftar Toko Gratis - SAS TokoRumah';
        $this->load->view('register', $data);
    }

    public function submit() {
        $this->form_validation->set_rules('nama_toko', 'Nama Toko', 'required|trim');
        $this->form_validation->set_rules('pemilik', 'Nama Pemilik', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_dash|is_unique[toko.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('whatsapp', 'WhatsApp', 'required|trim|callback_validate_whatsapp');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('register');
        }

        $slug = url_title($this->input->post('nama_toko'), 'dash', TRUE);
        $slug_check = $this->Toko_model->get_by_slug($slug);
        if ($slug_check) {
            $slug .= '-' . substr(md5(uniqid()), 0, 5);
        }

        $data = [
            'nama_toko' => $this->input->post('nama_toko'),
            'slug' => $slug,
            'pemilik' => $this->input->post('pemilik'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'whatsapp' => $this->input->post('whatsapp'),
            'kategori' => $this->input->post('kategori'),
            'alamat' => $this->input->post('alamat'),
            'status' => 'pending',
            'tema_warna' => '#ff6b35'
        ];

        // Validasi format WhatsApp
        $whatsapp = $this->input->post('whatsapp');
        if (!$this->validate_whatsapp_format($whatsapp)) {
            $this->session->set_flashdata('error', 'Format WhatsApp harus dimulai dengan 08xxx atau +62xxx');
            redirect('register');
        }

        if ($this->Toko_model->insert($data)) {
            $this->session->set_flashdata('success', 'Pendaftaran berhasil! Menunggu verifikasi owner.');
            redirect('register/success');
        } else {
            $this->session->set_flashdata('error', 'Gagal mendaftar. Coba lagi.');
            redirect('register');
        }
    }

    public function success() {
        $data['title'] = 'Pendaftaran Berhasil - SAS TokoRumah';
        $this->load->view('register_success', $data);
    }

    public function validate_whatsapp($whatsapp) {
        return $this->validate_whatsapp_format($whatsapp);
    }

    private function validate_whatsapp_format($whatsapp) {
        $whatsapp = preg_replace('/[^0-9+\-]/', '', $whatsapp);
        $pattern = '/^(\+62|62|0)8[1-9][0-9]{7,11}$/';
        return preg_match($pattern, $whatsapp) === 1;
    }
}
