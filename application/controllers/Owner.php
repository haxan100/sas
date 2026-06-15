<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Toko_model', 'Order_model']);
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: 0');
    }

    public function login() {
        if ($this->session->userdata('owner_id')) redirect('owner/dashboard');
        $this->load->view('owner/login');
    }    public function do_login() {
        $u = $this->input->post('username');
        $p = $this->input->post('password');
        $row = $this->db->get_where('owner', ['username' => $u])->row();
        if ($row && password_verify($p, $row->password)) {
            $this->session->sess_regenerate(TRUE);
            $this->session->set_userdata(['owner_id' => $row->id, 'owner_nama' => $row->nama]);
            redirect('owner/dashboard');
        }
        $this->session->set_flashdata('error', 'Username/password salah');
        redirect('owner/login');
    }

    public function logout() {
        $this->session->unset_userdata(['owner_id', 'owner_nama']);
        $this->session->sess_destroy();
        redirect('owner/login');
    }

    private function _cek() {
        if (!$this->session->userdata('owner_id')) {
            redirect('owner/login');
            exit;
        }
    }

    public function dashboard() {
        $this->_cek();
        $data['title'] = 'Dashboard Owner';
        $data['total_toko'] = $this->Toko_model->count_all();
        $data['total_order'] = $this->Order_model->count_all();
        $data['total_pendapatan'] = $this->Order_model->total_pendapatan();
        $data['toko'] = $this->Toko_model->get_all();
        $data['order'] = $this->Order_model->get_all();
        $this->load->view('owner/dashboard', $data);
    }

    // CRUD TOKO
    public function toko_tambah() {
        $this->_cek();
        $data['title'] = 'Tambah Toko';
        $this->load->view('owner/toko_form', $data);
    }

    public function toko_simpan() {
        $this->_cek();
        $slug = url_title($this->input->post('slug'), '-', true);
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['file_name'] = 'logo_'.time();
        $this->load->library('upload', $config);
        $logo = null;
        if ($this->upload->do_upload('logo')) {
            $logo = $this->upload->data('file_name');
        }

        $data = [
            'slug' => $slug,
            'nama_toko' => $this->input->post('nama_toko'),
            'pemilik' => $this->input->post('pemilik'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'no_wa' => $this->input->post('no_wa'),
            'no_rek' => $this->input->post('no_rek'),
            'nama_bank' => $this->input->post('nama_bank'),
            'atas_nama' => $this->input->post('atas_nama'),
            'alamat' => $this->input->post('alamat'),
            'kategori' => $this->input->post('kategori'),
            'tema_warna' => $this->input->post('tema_warna'),
            'logo' => $logo,
        ];
        $this->Toko_model->insert($data);
        $this->session->set_flashdata('sukses', 'Toko berhasil dibuat! Link: '.base_url($slug));
        redirect('owner/dashboard');
    }

    public function toko_edit($id) {
        $this->_cek();
        $data['toko'] = $this->Toko_model->get_by_id($id);
        $data['title'] = 'Edit Toko';
        $this->load->view('owner/toko_form', $data);
    }

    public function toko_update($id) {
        $this->_cek();
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);

        $data = [
            'slug' => url_title($this->input->post('slug'), '-', true),
            'nama_toko' => $this->input->post('nama_toko'),
            'pemilik' => $this->input->post('pemilik'),
            'username' => $this->input->post('username'),
            'no_wa' => $this->input->post('no_wa'),
            'no_rek' => $this->input->post('no_rek'),
            'nama_bank' => $this->input->post('nama_bank'),
            'atas_nama' => $this->input->post('atas_nama'),
            'alamat' => $this->input->post('alamat'),
            'kategori' => $this->input->post('kategori'),
            'tema_warna' => $this->input->post('tema_warna'),
            'status' => $this->input->post('status'),
        ];
        if ($this->input->post('password')) {
            $data['password'] = $this->input->post('password');
        }
        if ($this->upload->do_upload('logo')) {
            $data['logo'] = $this->upload->data('file_name');
        }
        $this->Toko_model->update($id, $data);
        $this->session->set_flashdata('sukses', 'Toko diupdate');
        redirect('owner/dashboard');
    }

    public function toko_hapus($id) {
        $this->_cek();
        $this->Toko_model->delete($id);
        redirect('owner/dashboard');
    }

    public function order_detail($id) {
        $this->_cek();
        $data['title'] = 'Detail Order';
        $data['order'] = $this->Order_model->get_by_id($id);
        $data['toko'] = $this->Toko_model->get_by_id($data['order']->toko_id);
        $data['items'] = $this->Order_model->get_items($id);
        $this->load->view('owner/order_detail', $data);
    }
}
