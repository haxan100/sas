<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Toko_model', 'Produk_model', 'Order_model', 'Kategori_model']);
        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form']);
        $this->load->helper('Log_helper');
        // Prevent caching of auth-protected pages
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: 0');
    }

    // ============= AUTH =============
    public function index()
    {
        if ($this->session->userdata('toko_id')) {
            redirect('admin/dashboard');
        }
        $this->load->view('admin/login');
    }

    public function register()
    {
        if ($this->session->userdata('toko_id')) {
            redirect('admin/dashboard');
        }
        $this->load->view('admin/register');
    }

    public function do_register()
    {
        header('Content-Type: application/json');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama_toko', 'Nama Toko', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('pemilik', 'Nama Pemilik', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]|callback_check_username_unique');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules('no_wa', 'No WhatsApp', 'required|callback_validate_wa_format|callback_check_wa_unique');
        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'required');
        $this->form_validation->set_rules('no_rek', 'No Rekening', 'required|min_length[5]|max_length[30]');
        $this->form_validation->set_rules('atas_nama', 'Atas Nama Rekening', 'required|min_length[3]|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $errors = strip_tags(validation_errors());
            echo json_encode([
                'status' => 'error',
                'message' => $errors,
                'csrf' => $this->security->get_csrf_hash(),
                'csrf_name' => $this->security->get_csrf_token_name()
            ]);
            return;
        }

        $nama_toko = trim($this->input->post('nama_toko'));
        $username = trim(strtolower($this->input->post('username')));
        $slug = url_title($nama_toko, '-', true);

        $existing_slug = $this->db->get_where('toko', ['slug' => $slug])->row();
        if ($existing_slug) {
            $slug = $slug . '-' . substr(md5(uniqid()), 0, 5);
        }

        // Format nomor WA: tambahkan 62 di depan
        $no_wa_raw = preg_replace('/[^0-9]/', '', $this->input->post('no_wa'));
        $no_wa = '62' . ltrim($no_wa_raw, '0');

        $data = [
            'nama_toko' => $nama_toko,
            'pemilik' => trim($this->input->post('pemilik')),
            'username' => $username,
            'password' => $this->input->post('password'),
            'slug' => $slug,
            'no_wa' => $no_wa,
            'kategori' => $this->input->post('kategori') ?: 'Makanan',
            'alamat' => $this->input->post('alamat'),
            'nama_bank' => $this->input->post('nama_bank'),
            'no_rek' => $this->input->post('no_rek'),
            'atas_nama' => $this->input->post('atas_nama'),
            'status' => 'aktif',
            'tema_warna' => '#ff6b35',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('toko', $data);
        $toko_id = $this->db->insert_id();

        // Auto login setelah register
        $this->session->sess_regenerate(TRUE);
        $this->session->set_userdata([
            'toko_id' => $toko_id,
            'toko_slug' => $slug,
            'toko_nama' => $nama_toko,
            'toko_tema' => '#ff6b35',
            'is_admin' => true,
        ]);

        echo json_encode([
            'status' => 'ok',
            'message' => 'Pendaftaran berhasil! Selamat datang di toko Anda.',
            'redirect' => base_url('admin/welcome'),
            'csrf' => $this->security->get_csrf_hash(),
            'csrf_name' => $this->security->get_csrf_token_name()
        ]);
    }

    public function check_username_unique($username)
    {
        $username = trim(strtolower($username));
        $existing = $this->db->get_where('toko', ['username' => $username])->row();
        if ($existing) {
            $this->form_validation->set_message('check_username_unique', 'Username "' . $username . '" sudah digunakan. Silakan pilih username lain.');
            return FALSE;
        }
        return TRUE;
    }

    public function validate_wa_format($no_wa)
    {
        $no_wa = preg_replace('/[^0-9]/', '', $no_wa);
        
        // Harus dimulai dengan 8 (format 8xxx)
        if (!preg_match('/^8[1-9][0-9]{7,11}$/', $no_wa)) {
            $this->form_validation->set_message('validate_wa_format', 'Nomor WhatsApp harus dimulai dengan 8 (contoh: 8123456789). Jangan gunakan 0 atau 62 di depan.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_wa_unique($no_wa)
    {
        // Format ke 62xxx untuk cek duplikat
        $no_wa_clean = preg_replace('/[^0-9]/', '', $no_wa);
        $no_wa_formatted = '62' . ltrim($no_wa_clean, '0');
        
        $existing = $this->db->get_where('toko', ['no_wa' => $no_wa_formatted])->row();
        if ($existing) {
            $this->form_validation->set_message('check_wa_unique', 'Nomor WhatsApp sudah terdaftar di toko lain.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_username()
    {
        header('Content-Type: application/json');
        $username = trim(strtolower($this->input->get('username')));
        
        if (strlen($username) < 3) {
            echo json_encode(['available' => false, 'message' => 'Username terlalu pendek']);
            return;
        }
        
        $existing = $this->db->get_where('toko', ['username' => $username])->row();
        echo json_encode(['available' => empty($existing)]);
    }

    public function check_wa()
    {
        header('Content-Type: application/json');
        $no_wa = preg_replace('/[^0-9]/', '', $this->input->get('no_wa'));
        $no_wa_formatted = '62' . ltrim($no_wa, '0');
        
        $existing = $this->db->get_where('toko', ['no_wa' => $no_wa_formatted])->row();
        echo json_encode(['available' => empty($existing)]);
    }

    public function do_login()
    {
        $u = $this->input->post('username');
        $p = $this->input->post('password');
        $toko = $this->Toko_model->get_by_username($u);
        if ($toko && password_verify($p, $toko->password)) {
            if ($toko->status == 'pending') {
                $this->session->set_flashdata('error', 'Akun Anda belum diverifikasi oleh Owner. Mohon tunggu konfirmasi aktivasi.');
                redirect('admin');
                return;
            }
            if ($toko->status != 'aktif') {
                $this->session->set_flashdata('error', 'Toko ini nonaktif. Hubungi owner.');
                redirect('admin');
                return;
            }
            $this->session->sess_regenerate(TRUE);
            $this->session->set_userdata([
                'toko_id' => $toko->id,
                'toko_slug' => $toko->slug,
                'toko_nama' => $toko->nama_toko,
                'toko_tema' => $toko->tema_warna,
                'is_admin' => true,
            ]);
            Log_Helper::log_login('admin', $toko->id, $toko->username, $toko->id, $toko->nama_toko);
            redirect('admin/dashboard');
        }
        $this->session->set_flashdata('error', 'Username/password salah');
        redirect('admin');
    }

    public function logout()
    {
        $toko_id = $this->session->userdata('toko_id');
        $toko_nama = $this->session->userdata('toko_nama');
        Log_Helper::log_logout('admin', $toko_id, $this->session->userdata('toko_slug'), $toko_id, $toko_nama);
        $this->session->unset_userdata(['toko_id', 'toko_slug', 'toko_nama', 'toko_tema', 'is_admin']);
        redirect('admin');
    }

    // ============= GUARD =============
    private function _cek()
    {
        if (!$this->session->userdata('toko_id') || !$this->session->userdata('is_admin')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('admin');
            exit;
        }
        $toko = $this->Toko_model->get_by_id($this->session->userdata('toko_id'));
        if (!$toko || $toko->status != 'aktif') {
            $this->session->unset_userdata(['toko_id', 'toko_slug', 'toko_nama', 'toko_tema', 'is_admin']);
            $this->session->set_flashdata('error', 'Toko nonaktif, hubungi owner');
            redirect('admin');
            exit;
        }
        return $toko;
    }

    // Helper: session toko untuk view
    private function _view_data($page, $title)
    {
        $toko = $this->_cek();
        return ['toko' => $toko, 'page' => $page, 'title' => $title];
    }

    // ============= PAGES =============
    public function dashboard()
    {
        $toko = $this->_cek();
        // First-time login: redirect to welcome
        if (empty($toko->onboarding_done) || $toko->onboarding_done == 0) {
            redirect('admin/welcome');
            return;
        }
        $data['toko'] = $toko;
        $data['title'] = 'Dashboard - ' . $toko->nama_toko;
        $data['produk'] = $this->Produk_model->get_by_toko($toko->id);
        $data['orders'] = $this->Order_model->get_by_toko_array($toko->id);
        $data['total_order'] = $this->Order_model->count_by_toko($toko->id);
        $data['total_pendapatan'] = $this->Order_model->total_pendapatan_toko($toko->id);
        $this->load->view('admin/dashboard', $data);
    }

    public function produk()
    {
        $toko = $this->_cek();
        $data['toko'] = $toko;
        $data['kategori'] = $this->Kategori_model->get_by_toko($toko->id);
        $data['title'] = 'Produk - ' . $toko->nama_toko;
        $this->load->view('admin/produk_list', $data);
    }

    public function orders()
    {
        $toko = $this->_cek();
        $data['toko'] = $toko;
        $data['title'] = 'Orderan - ' . $toko->nama_toko;
        $this->load->view('admin/orders_list', $data);
    }

    public function kategori()
    {
        $toko = $this->_cek();
        $data['toko'] = $toko;
        $data['title'] = 'Kategori - ' . $toko->nama_toko;
        $this->load->view('admin/kategori_list', $data);
    }

    public function pengaturan()
    {
        $toko = $this->_cek();
        $data['toko'] = $toko;
        $data['title'] = 'Pengaturan - ' . $toko->nama_toko;
        $this->load->view('admin/pengaturan', $data);
    }

    public function akun()
    {
        $toko = $this->_cek();
        $data['toko'] = $toko;
        $data['title'] = 'Akun - ' . $toko->nama_toko;
        $this->load->view('admin/akun', $data);
    }

    public function welcome()
    {
        $toko = $this->_cek();
        $data['toko'] = $toko;
        $data['title'] = 'Selamat Datang - ' . $toko->nama_toko;
        $this->load->view('admin/welcome', $data);
    }

    public function skip_tour()
    {
        $toko = $this->_cek();
        $this->Toko_model->mark_onboarding_done($toko->id);
        echo json_encode(['status' => 'ok']);
    }

    public function reset_tour()
    {
        $toko = $this->_cek();
        $this->Toko_model->reset_onboarding($toko->id);
        echo json_encode(['status' => 'ok']);
    }

    public function update_akun()
    {
        $toko = $this->_cek();
        $username_baru = trim($this->input->post('username'));
        $password_lama = $this->input->post('password_lama');
        $password_baru = $this->input->post('password_baru');
        $password_konfirm = $this->input->post('password_konfirm');

        if (empty($username_baru)) {
            echo json_encode(['status' => 'error', 'message' => 'Username tidak boleh kosong']);
            return;
        }

        // Cek duplikat username
        $existing = $this->Toko_model->get_by_username($username_baru);
        if ($existing && $existing->id != $toko->id) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah dipakai toko lain']);
            return;
        }

        $data_update = ['username' => $username_baru];

        // Update password kalau diisi
        if (!empty($password_baru)) {
            if (empty($password_lama) || !password_verify($password_lama, $toko->password)) {
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

        $this->Toko_model->update($toko->id, $data_update);

        // Update session username (slug tidak berubah karena username beda dari slug)
        $this->session->set_userdata('toko_nama', $toko->nama_toko);

        $msg = 'Akun diupdate';
        if (!empty($password_baru))
            $msg .= ' & password diganti';
        echo json_encode(['status' => 'ok', 'message' => $msg]);
    }

    public function update_pengaturan()
    {
        header('Content-Type: application/json');
        $toko = $this->_cek();

        // Konfigurasi Upload
        $config['upload_path'] = FCPATH . 'assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 5120; // Kita besarkan dulu batas uploadnya (5MB), nanti kita kompres
        $config['encrypt_name'] = TRUE; // Opsional: Ubah nama file jadi acak agar tidak bentrok

        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->load->library('image_lib'); // Load library untuk kompresi gambar

        $data = [
            'nama_toko' => $this->input->post('nama_toko'),
            'pemilik' => $this->input->post('pemilik'),
            'no_wa' => $this->input->post('no_wa'),
            'no_rek' => $this->input->post('no_rek'),
            'nama_bank' => $this->input->post('nama_bank'),
            'atas_nama' => $this->input->post('atas_nama'),
            'alamat' => $this->input->post('alamat'),
            'kategori' => $this->input->post('kategori'),
            'tema_warna' => $this->input->post('tema_warna'),
        ];

        if ($this->input->post('password_baru')) {
            $data['password'] = $this->input->post('password_baru');
        }

        // Variabel untuk menampung URL gambar baru yang akan dikirim ke AJAX
        $respon_gambar = [];

        // Proses Upload & Kompresi LOGO
        if (!empty($_FILES['logo']['name'])) {
            if ($this->upload->do_upload('logo')) {
                $gbr = $this->upload->data();

                // Konfigurasi Kompresi Logo (Maksimal 300x300 pixel, Kualitas 60%)
                $config_img['image_library'] = 'gd2';
                $config_img['source_image'] = $gbr['full_path'];
                $config_img['maintain_ratio'] = TRUE;
                $config_img['width'] = 300;
                $config_img['height'] = 300;
                $config_img['quality'] = '60%';

                $this->image_lib->clear();
                $this->image_lib->initialize($config_img);
                $this->image_lib->resize(); // Lakukan kompresi

                $data['logo'] = $gbr['file_name'];
                $respon_gambar['new_logo'] = base_url('assets/uploads/' . $data['logo']);
            } else {
                echo json_encode(['status' => 'error', 'message' => strip_tags($this->upload->display_errors())]);
                exit;
            }
        }

        // Proses Upload & Kompresi COVER
        if (!empty($_FILES['cover_photo']['name'])) {
            if ($this->upload->do_upload('cover_photo')) {
                $gbr = $this->upload->data();

                // Konfigurasi Kompresi Cover (Maksimal 800x400 pixel, Kualitas 60%)
                $config_img['image_library'] = 'gd2';
                $config_img['source_image'] = $gbr['full_path'];
                $config_img['maintain_ratio'] = TRUE;
                $config_img['width'] = 800;
                $config_img['height'] = 400;
                $config_img['quality'] = '60%';

                $this->image_lib->clear();
                $this->image_lib->initialize($config_img);
                $this->image_lib->resize(); // Lakukan kompresi

                $data['cover_photo'] = $gbr['file_name'];
                $respon_gambar['new_cover'] = base_url('assets/uploads/' . $data['cover_photo']);
            } else {
                echo json_encode(['status' => 'error', 'message' => strip_tags($this->upload->display_errors())]);
                exit;
            }
        }

        $this->Toko_model->update($toko->id, $data);
        $this->session->set_userdata('toko_nama', $this->input->post('nama_toko'));
        $this->session->set_userdata('toko_tema', $this->input->post('tema_warna'));

        // Kirim respons sukses beserta link gambar terbarunya
        echo json_encode([
            'status' => 'success',
            'message' => 'Pengaturan berhasil disimpan!',
            'gambar' => $respon_gambar
        ]);
        exit;
    }

    // ============= AJAX - PRODUK =============
    public function produk_ajax()
    {
        $toko = $this->_cek();
        $draw = intval($this->input->get('draw'));
        $search = $this->input->get('search')['value'] ?? '';
        $length = $this->input->get('length') ?: 10;
        $start = $this->input->get('start') ?: 0;

        $this->db->from('produk');
        $this->db->where('toko_id', $toko->id);
        $totalRecords = $this->db->count_all_results('', false);

        if (!empty($search)) {
            $s = $this->db->escape_like_str($search);
            $this->db->group_start();
            $this->db->like('nama_produk', $s);
            $this->db->or_like('kategori', $s);
            $this->db->or_like('deskripsi', $s);
            $this->db->group_end();
        }
        $totalFiltered = $this->db->count_all_results('', false);

        $order_col_idx = $this->input->get('order')[0]['column'] ?? 0;
        $order_dir = $this->input->get('order')[0]['dir'] ?? 'desc';
        $cols = [null, 'id', 'foto', 'nama_produk', 'kategori', 'harga', 'stok', 'status', null];
        $order_col = $cols[$order_col_idx] ?? 'id';
        if ($order_col)
            $this->db->order_by($order_col, $order_dir);
        $this->db->limit($length, $start);
        $rows = $this->db->get()->result();

        $data = [];
        foreach ($rows as $p) {
            $fotoCell = $p->foto
                ? '<img src="' . base_url('assets/uploads/' . $p->foto) . '" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">'
                : '<div style="width:50px;height:50px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:20px;">🍽️</div>';
            $hargaCell = (!empty($p->harga_diskon) && $p->harga_diskon > 0 && $p->harga_diskon < $p->harga)
                ? '<strong style="color:#dc2626;">Rp ' . number_format($p->harga_diskon, 0, ',', '.') . '</strong><br><small style="text-decoration:line-through;color:#9ca3af;">Rp ' . number_format($p->harga, 0, ',', '.') . '</small>'
                : '<strong>Rp ' . number_format($p->harga, 0, ',', '.') . '</strong>';
            $statusCell = '<span class="dt-badge" style="background:' . ($p->status == 'tersedia' ? '#dcfce7' : '#fee2e2') . ';color:' . ($p->status == 'tersedia' ? '#166534' : '#991b1b') . ';">' . $p->status . '</span>';
            $aksiCell = '<div class="table-actions-stack" style="display:flex;gap:6px;">
                <button class="btn btn-secondary btn-sm btn-icon" onclick="editProduk(' . $p->id . ')" title="Edit">✏️</button>
                <button class="btn btn-secondary btn-sm btn-icon" onclick="hapusProduk(' . $p->id . ')" title="Hapus">🗑️</button>
            </div>';
            $data[] = [
                '<input type="checkbox" class="produk-check" value="' . $p->id . '">',
                $p->id,
                $fotoCell,
                '<strong>' . htmlspecialchars($p->nama_produk) . '</strong>' . ($p->deskripsi ? '<br><small style="color:#9ca3af;">' . htmlspecialchars(substr($p->deskripsi, 0, 40)) . '</small>' : ''),
                '<span class="dt-badge" style="background:#dbeafe;color:#1e40af;">' . htmlspecialchars($p->kategori ?: 'Lainnya') . '</span>',
                $hargaCell,
                $p->stok,
                $statusCell,
                $aksiCell
            ];
        }
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function produk_bulk_action()
    {
        header('Content-Type: application/json');
        $toko = $this->_cek();
        $action = $this->input->post('action');
        $ids = $this->input->post('ids');

        if (!is_array($ids) || empty($ids)) {
            echo json_encode(['status' => 'error', 'message' => 'Pilih produk terlebih dahulu']);
            return;
        }

        $ids = array_values(array_filter(array_map('intval', $ids)));
        if (empty($ids)) {
            echo json_encode(['status' => 'error', 'message' => 'Produk tidak valid']);
            return;
        }

        $produk = $this->db->where('toko_id', $toko->id)->where_in('id', $ids)->get('produk')->result();
        if (empty($produk)) {
            echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
            return;
        }

        $validIds = array_map(function ($p) {
            return (int) $p->id;
        }, $produk);

        if ($action === 'delete') {
            foreach ($produk as $p) {
                if (!empty($p->foto)) {
                    $path = FCPATH . 'assets/uploads/' . $p->foto;
                    if (is_file($path)) {
                        @unlink($path);
                    }
                }
            }

            $this->db->where('toko_id', $toko->id)->where_in('id', $validIds)->delete('produk');
            echo json_encode(['status' => 'ok', 'message' => count($validIds) . ' produk dihapus']);
            return;
        }

        if ($action === 'habis') {
            $this->db->where('toko_id', $toko->id)->where_in('id', $validIds)->update('produk', ['status' => 'habis']);
            echo json_encode(['status' => 'ok', 'message' => count($validIds) . ' produk dibuat tidak tersedia']);
            return;
        }

        echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
    }

    public function produk_save()
    {
        header('Content-Type: application/json');
        $toko = $this->_cek();
        $id = $this->input->post('id');

        $old_produk = null;
        if ($id) {
            $old_produk = $this->Produk_model->get_by_id($id);
            if (!$old_produk || $old_produk->toko_id != $toko->id) {
                echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
                return;
            }
        }

        $config['upload_path'] = FCPATH . 'assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|avif|webp';
        $config['max_size'] = 5120;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->load->library('image_lib');

        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            if (!$this->upload->do_upload('foto')) {
                echo json_encode(['status' => 'error', 'message' => strip_tags($this->upload->display_errors())]);
                return;
            }

            $gbr = $this->upload->data();
            $config_img['image_library'] = 'gd2';
            $config_img['source_image'] = $gbr['full_path'];
            $config_img['maintain_ratio'] = TRUE;
            $config_img['width'] = 700;
            $config_img['height'] = 700;
            $config_img['quality'] = '65%';

            $this->image_lib->clear();
            $this->image_lib->initialize($config_img);
            $this->image_lib->resize();

            $foto = $gbr['file_name'];
        }

        $data = [
            'nama_produk' => $this->input->post('nama_produk'),
            'kategori' => $this->input->post('kategori') ?: 'Lainnya',
            'harga' => $this->input->post('harga'),
            'harga_diskon' => $this->input->post('harga_diskon') ?: 0,
            'deskripsi' => $this->input->post('deskripsi'),
            'stok' => $this->input->post('stok'),
            'status' => $this->input->post('status') ?: 'tersedia',
        ];
        if ($foto)
            $data['foto'] = $foto;

        if ($id) {
            $this->Produk_model->update($id, $data);
            if ($foto && !empty($old_produk->foto)) {
                $old_path = FCPATH . 'assets/uploads/' . $old_produk->foto;
                if (is_file($old_path)) {
                    @unlink($old_path);
                }
            }
            Log_Helper::log_produk_updated($toko->id, $toko->nama_toko, $toko->id, $toko->username, $old_produk->nama_produk, (array) $old_produk, $data);
            echo json_encode(['status' => 'ok', 'message' => 'Produk diupdate']);
        } else {
            $data['toko_id'] = $toko->id;
            $this->Produk_model->insert($data);
            Log_Helper::log_produk_created($toko->id, $toko->nama_toko, $toko->id, $toko->username, $data['nama_produk']);
            echo json_encode(['status' => 'ok', 'message' => 'Produk ditambah']);
        }
    }

    public function produk_get($id)
    {
        $toko = $this->_cek();
        $p = $this->Produk_model->get_by_id($id);
        if (!$p || $p->toko_id != $toko->id) {
            echo json_encode(['error' => 'not found']);
            return;
        }
        echo json_encode($p);
    }

    public function produk_hapus($id)
    {
        $toko = $this->_cek();
        $p = $this->Produk_model->get_by_id($id);
        if (!$p || $p->toko_id != $toko->id) {
            echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
            return;
        }
        $this->Produk_model->delete($id);
        Log_Helper::log_produk_deleted($toko->id, $toko->nama_toko, $toko->id, $toko->username, $p->nama_produk);
        echo json_encode(['status' => 'ok', 'message' => 'Produk dihapus']);
    }

    // ============= AJAX - ORDERS =============
    public function orders_ajax()
    {
        $toko = $this->_cek();
        $draw = intval($this->input->get('draw'));
        $totalRecords = $this->Order_model->dt_count_all($toko->id);
        $totalFiltered = $this->Order_model->dt_count_filtered($toko->id);
        $data = [];
        $orders = $this->Order_model->dt_list($toko->id);
        foreach ($orders as $o) {
            $row = [];
            $row[] = '#' . $o->id;
            $row[] = '<strong>' . htmlspecialchars($o->kode_order) . '</strong>';
            $row[] = htmlspecialchars($o->nama_pembeli) . '<br><small style="color:#9ca3af;">Blok ' . htmlspecialchars($o->blok_rumah) . '</small>';
            $row[] = '<strong>Rp ' . number_format($o->total_harga, 0, ',', '.') . '</strong>';
            $row[] = '<span class="dt-badge" style="background:' . ($o->metode_bayar == 'cash' ? '#dcfce7' : '#dbeafe') . ';color:' . ($o->metode_bayar == 'cash' ? '#166534' : '#1e40af') . ';">' . strtoupper($o->metode_bayar) . '</span>';
            $row[] = '<span class="dt-badge" style="background:' . ($o->status_bayar == 'lunas' ? '#dcfce7' : '#fee2e2') . ';color:' . ($o->status_bayar == 'lunas' ? '#166534' : '#991b1b') . ';">' . $o->status_bayar . '</span>';
            $row[] = '<span class="dt-badge" style="background:' . ($o->status_order == 'selesai' ? '#dcfce7' : ($o->status_order == 'diproses' ? '#fef3c7' : ($o->status_order == 'batal' ? '#fee2e2' : '#dbeafe'))) . ';color:' . ($o->status_order == 'selesai' ? '#166534' : ($o->status_order == 'diproses' ? '#92400e' : ($o->status_order == 'batal' ? '#991b1b' : '#1e40af'))) . ';">' . $o->status_order . '</span>';
            $row[] = date('d/m/Y H:i', strtotime($o->created_at));
            $row[] = '<button class="btn btn-secondary btn-sm btn-icon" onclick="viewOrder(' . $o->id . ')" title="Detail">👁️</button> ' . $this->_quick_order_buttons($o);
            $data[] = $row;
        }
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function order_get($id)
    {
        $toko = $this->_cek();
        $order = $this->Order_model->get_by_id($id);
        if (!$order || $order->toko_id != $toko->id) {
            echo json_encode(['error' => 'not found']);
            return;
        }
        $items = $this->Order_model->get_items($id);
        echo json_encode(['order' => $order, 'items' => $items]);
    }

    public function order_update($id)
    {
        $toko = $this->_cek();
        $order = $this->Order_model->get_by_id($id);
        if (!$order || $order->toko_id != $toko->id) {
            echo json_encode(['status' => 'error', 'message' => 'Order tidak ditemukan']);
            return;
        }
        $old_status_order = $order->status_order;
        $old_status_bayar = $order->status_bayar;
        $data = [
            'status_order' => $this->input->post('status_order'),
            'status_bayar' => $this->input->post('status_bayar'),
        ];
        $this->Order_model->update_status($id, $data);
        Log_Helper::log_order_updated($toko->id, $toko->nama_toko, $toko->id, $toko->username, $order->kode_order, $old_status_order . '/' . $old_status_bayar, $data['status_order'] . '/' . $data['status_bayar']);
        echo json_encode(['status' => 'ok', 'message' => 'Order diupdate']);
    }

    public function order_quick_update($id)
    {
        $toko = $this->_cek();
        $order = $this->Order_model->get_by_id($id);
        if (!$order || $order->toko_id != $toko->id) {
            echo json_encode(['status' => 'error', 'message' => 'Order tidak ditemukan']);
            return;
        }

        $valid_status = ['baru', 'diproses', 'selesai', 'batal'];
        $status = $this->input->get('status');
        if (!in_array($status, $valid_status)) {
            echo json_encode(['status' => 'error', 'message' => 'Status tidak valid']);
            return;
        }

        $old = $order->status_order . '/' . $order->status_bayar;
        $this->Order_model->update_status($id, ['status_order' => $status]);
        Log_Helper::log_order_updated($toko->id, $toko->nama_toko, $toko->id, $toko->username, $order->kode_order, $old, $status . '/' . $order->status_bayar);
        echo json_encode(['status' => 'ok', 'message' => 'Status order diupdate ke "' . ucfirst($status) . '"']);
    }

    // ============= AJAX - KATEGORI =============
    public function kategori_ajax()
    {
        $toko = $this->_cek();
        $draw = intval($this->input->get('draw'));
        $search = $this->input->get('search')['value'] ?? '';
        $length = $this->input->get('length') ?: 10;
        $start = $this->input->get('start') ?: 0;
        $order_col_idx = $this->input->get('order')[0]['column'] ?? 0;
        $order_dir = $this->input->get('order')[0]['dir'] ?? 'asc';
        $cols = ['id', 'nama', 'icon', 'jumlah_produk', null];
        $order_col = $cols[$order_col_idx] ?? 'urutan';
        if ($order_col == 'jumlah_produk')
            $order_col = 'id';

        $totalRecords = $this->Kategori_model->dt_count_all($toko->id);
        $totalFiltered = $this->Kategori_model->dt_count_filtered($toko->id, $search);
        $rows = $this->Kategori_model->dt_list($toko->id, $search, $start, $length, $order_col, $order_dir);

        $data = [];
        foreach ($rows as $k) {
            $data[] = [
                $k->id,
                '<strong>' . htmlspecialchars($k->nama) . '</strong>',
                $k->icon ? '<span style="font-size:20px;">' . htmlspecialchars($k->icon) . '</span>' : '<span style="color:#9ca3af;">-</span>',
                '<span class="dt-badge" style="background:#dbeafe;color:#1e40af;">' . $k->jumlah_produk . ' produk</span>',
                $k->urutan,
                '<div style="display:flex;gap:6px;">
                    <button class="btn btn-secondary btn-sm btn-icon" onclick="editKategori(' . $k->id . ')" title="Edit">✏️</button>
                    <button class="btn btn-secondary btn-sm btn-icon" onclick="hapusKategori(' . $k->id . ')" title="Hapus">🗑️</button>
                </div>'
            ];
        }
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function kategori_save()
    {
        $toko = $this->_cek();
        $id = $this->input->post('id');
        $nama = trim($this->input->post('nama'));
        if (empty($nama)) {
            echo json_encode(['status' => 'error', 'message' => 'Nama kategori wajib diisi']);
            return;
        }
        $existing = $this->db->get_where('kategori', ['toko_id' => $toko->id, 'nama' => $nama])->row();
        if ($existing && (!$id || $existing->id != $id)) {
            echo json_encode(['status' => 'error', 'message' => 'Kategori "' . $nama . '" sudah ada']);
            return;
        }
        $data = [
            'nama' => $nama,
            'icon' => $this->input->post('icon') ?: null,
            'urutan' => (int) $this->input->post('urutan') ?: 0,
        ];
        if ($id) {
            $this->Kategori_model->update($id, $data);
            echo json_encode(['status' => 'ok', 'message' => 'Kategori diupdate']);
        } else {
            $data['toko_id'] = $toko->id;
            $this->Kategori_model->insert($data);
            echo json_encode(['status' => 'ok', 'message' => 'Kategori ditambah']);
        }
    }

    public function kategori_get($id)
    {
        $toko = $this->_cek();
        $k = $this->Kategori_model->get_by_id($id);
        if (!$k || $k->toko_id != $toko->id) {
            echo json_encode(['error' => 'not found']);
            return;
        }
        echo json_encode($k);
    }

    public function kategori_hapus($id)
    {
        $toko = $this->_cek();
        $k = $this->Kategori_model->get_by_id($id);
        if (!$k || $k->toko_id != $toko->id) {
            echo json_encode(['status' => 'error', 'message' => 'Kategori tidak ditemukan']);
            return;
        }
        $this->db->where(['toko_id' => $toko->id, 'kategori' => $k->nama]);
        $this->db->update('produk', ['kategori' => 'Lainnya']);
        $this->Kategori_model->delete($id);
        echo json_encode(['status' => 'ok', 'message' => 'Kategori dihapus, produk dipindah ke "Lainnya"']);
    }

    private function _quick_order_buttons($o)
    {
        $btns = '';
        if ($o->status_order == 'baru') {
            $btns .= '<button class="btn btn-primary btn-sm btn-icon" onclick="quickUpdateOrder(' . $o->id . ', \'diproses\')" title="Proses">⏳</button> ';
            $btns .= '<button class="btn btn-danger btn-sm btn-icon" onclick="quickUpdateOrder(' . $o->id . ', \'batal\')" title="Batalkan">✕</button>';
        } elseif ($o->status_order == 'diproses') {
            $btns .= '<button class="btn btn-success btn-sm btn-icon" onclick="quickUpdateOrder(' . $o->id . ', \'selesai\')" title="Selesaikan">✓</button>';
            $btns .= '<button class="btn btn-danger btn-sm btn-icon" onclick="quickUpdateOrder(' . $o->id . ', \'batal\')" title="Batalkan">✕</button>';
        } elseif ($o->status_order == 'selesai' || $o->status_order == 'batal') {
            $btns .= '<button class="btn btn-secondary btn-sm btn-icon" onclick="quickUpdateOrder(' . $o->id . ', \'baru\')" title="Kembalikan ke Baru">↺</button>';
        }
        return $btns;
    }
}
