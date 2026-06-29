<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Pastikan hanya bisa diakses dari CLI atau IP localhost untuk keamanan
        if (!$this->input->is_cli_request() && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            show_error('You don\'t have permission to access this page.', 403);
            exit;
        }
        $this->load->library('migration');
    }

    public function index()
    {
        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migrations ran successfully!';
        }
    }

    // Untuk rollback ke versi spesifik jika perlu
    public function version($version)
    {
        if ($this->migration->version($version) === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migrated to version: ' . $version;
        }
    }
}
