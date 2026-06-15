<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Toko_model', 'Order_model']);
        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form']);
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: 0');
    }

    // ============= AUTH =============
    public function login() {
        if ($this->session->userdata('owner_id')) redirect('owner/dashboard');
        $this->load->view('owner/login');
    }

    public function do_login() {
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

    private function _get_owner() {
        $id = $this->session->userdata('owner_id');
        return $this->db->get_where('owner', ['id' => $id])->row();
    }

    // ============= PAGES =============
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

    // ============= TOKO LIST (dengan DataTable) =============
    public function toko_list() {
        $this->_cek();
        $data['title'] = 'Daftar Toko';
        $this->load->view('owner/toko_list', $data);
    }

    // ============= AKUN OWNER =============
    public function akun() {
        $this->_cek();
        $data['title'] = 'Akun Owner';
        $data['owner'] = $this->_get_owner();
        $this->load->view('owner/akun', $data);
    }

    public function update_akun() {
        $this->_cek();
        $owner = $this->_get_owner();
        $username_baru = trim($this->input->post('username'));
        $password_lama = $this->input->post('password_lama');
        $password_baru = $this->input->post('password_baru');
        $password_konfirm = $this->input->post('password_konfirm');
        $nama_baru = trim($this->input->post('nama'));

        if (empty($username_baru)) {
            echo json_encode(['status' => 'error', 'message' => 'Username tidak boleh kosong']);
            return;
        }

        // Cek duplikat username
        $existing = $this->db->get_where('owner', ['username' => $username_baru])->row();
        if ($existing && $existing->id != $owner->id) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah dipakai']);
            return;
        }

        $data_update = [
            'username' => $username_baru,
            'nama' => $nama_baru ?: $owner->nama,
        ];

        if (!empty($password_baru)) {
            if (empty($password_lama) || !password_verify($password_lama, $owner->password)) {
                echo json_encode(['status' => 'error', 'message' => 'Password lama salah']);
                return;
            }
            if (strlen($password_baru) < 4) {
                echo json_encode(['status' => 'error', 'message' => 'Password baru minimal 4 karakter']);
                return;
            }
            if ($password_baru !== $password_konfirm) {
                echo json_encode(['status' => 'error', 'message' => 'Konfirmasi password tidak cocok']);
                return;
            }
            $data_update['password'] = $password_baru;
        }

        $this->db->where('id', $owner->id);
        $this->db->update('owner', $data_update);

        // Update session
        $this->session->set_userdata('owner_nama', $data_update['nama']);

        $msg = 'Akun owner diupdate';
        if (!empty($password_baru)) $msg .= ' & password diganti';
        echo json_encode(['status' => 'ok', 'message' => $msg]);
    }

    // ============= CRUD TOKO (modal-based) =============
    public function toko_save() {
        $this->_cek();
        $id = $this->input->post('id');

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
            'tema_warna' => $this->input->post('tema_warna') ?: '#ff6b35',
        ];
        if ($this->input->post('password')) {
            $data['password'] = $this->input->post('password');
        }
        if ($logo) $data['logo'] = $logo;
        if ($id) {
            $data['status'] = $this->input->post('status') ?: 'aktif';
            $this->Toko_model->update($id, $data);
            $msg = 'Toko diupdate';
        } else {
            if (empty($data['password'])) {
                echo json_encode(['status' => 'error', 'message' => 'Password wajib diisi untuk toko baru']);
                return;
            }
            $this->Toko_model->insert($data);
            $msg = 'Toko ditambah: '.base_url($data['slug']);
        }
        echo json_encode(['status' => 'ok', 'message' => $msg]);
    }

    public function toko_get($id) {
        $this->_cek();
        $t = $this->Toko_model->get_by_id($id);
        echo json_encode($t);
    }

    public function toko_hapus($id) {
        $this->_cek();
        $this->Toko_model->delete($id);
        echo json_encode(['status' => 'ok', 'message' => 'Toko dihapus']);
    }

    // ============= DATA TABLE (server-side) =============
    public function toko_ajax() {
        $this->_cek();
        $draw = intval($this->input->get('draw'));
        $search = $this->input->get('search')['value'] ?? '';
        $length = $this->input->get('length') ?: 10;
        $start = $this->input->get('start') ?: 0;
        $order_col_idx = $this->input->get('order')[0]['column'] ?? 0;
        $order_dir = $this->input->get('order')[0]['dir'] ?? 'asc';
        $cols = ['id', 'nama_toko', 'pemilik', 'slug', 'kategori', 'no_wa', 'status', null, null];
        $order_col = $cols[$order_col_idx] ?? 'id';
        if ($order_col && $order_col !== 'jumlah_order') $this->db->order_by($order_col, $order_dir);

        $this->db->from('toko');
        $totalRecords = $this->db->count_all_results('', false);

        if (!empty($search)) {
            $s = $this->db->escape_like_str($search);
            $this->db->group_start();
            $this->db->like('nama_toko', $s);
            $this->db->or_like('pemilik', $s);
            $this->db->or_like('slug', $s);
            $this->db->or_like('kategori', $s);
            $this->db->or_like('no_wa', $s);
            $this->db->group_end();
        }
        $totalFiltered = $this->db->count_all_results('', false);

        $this->db->limit($length, $start);
        $rows = $this->db->get()->result();

        $data = [];
        foreach ($rows as $t) {
            // Count orders per toko
            $jumlah_order = $this->db->get_where('orders', ['toko_id' => $t->id])->num_rows();
            $statusBg = $t->status == 'aktif' ? '#dcfce7' : '#fee2e2';
            $statusFg = $t->status == 'aktif' ? '#166534' : '#991b1b';
            $data[] = [
                $t->id,
                '<div style="display:flex;align-items:center;gap:10px;"><div style="width:36px;height:36px;border-radius:8px;background:'.($t->tema_warna ?: '#ff6b35').';color:#fff;display:flex;align-items:center;justify-content:center;font-size:18px;">'.($t->logo ? '<img src="'.base_url('assets/uploads/'.$t->logo).'" style="width:100%;height:100%;border-radius:8px;object-fit:cover;">' : '🏪').'</div><div><strong>'.htmlspecialchars($t->nama_toko).'</strong><br><small style="color:#6b7280;">'.htmlspecialchars($t->kategori).'</small></div></div>',
                htmlspecialchars($t->pemilik),
                '<code>'.htmlspecialchars($t->slug).'</code>',
                htmlspecialchars($t->no_wa),
                '<span class="dt-badge" style="background:'.$statusBg.';color:'.$statusFg.';">'.$t->status.'</span>',
                '<span class="dt-badge" style="background:#dbeafe;color:#1e40af;">'.$jumlah_order.' order</span>',
                '<a href="'.base_url($t->slug).'" target="_blank" class="btn btn-secondary btn-sm btn-icon" title="Lihat">👀</a>',
                '<button class="btn btn-secondary btn-sm btn-icon" onclick="editToko('.$t->id.')" title="Edit">✏️</button> <button class="btn btn-secondary btn-sm btn-icon" onclick="hapusToko('.$t->id.')" title="Hapus">🗑️</button>',
            ];
        }
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
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
