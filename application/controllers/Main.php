<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Toko_model', 'Order_model']);
    }

    public function index() {
        $data['title'] = 'SAS TokoRumah - Platform Toko Online Perumahan';
        $data['toko'] = $this->Toko_model->get_all();
        $this->load->view('home', $data);
    }

    public function notfound() {
        $data['title'] = '404 - Halaman Tidak Ditemukan';
        $this->load->view('errors/html/notfound_view', $data);
    }
}
