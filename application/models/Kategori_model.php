<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {

    public function get_by_toko($toko_id) {
        $rows = $this->db->order_by('urutan ASC, nama ASC')->get_where('kategori', ['toko_id' => $toko_id])->result();
        foreach ($rows as $r) {
            $r->jumlah_produk = $this->db->get_where('produk', ['toko_id' => $toko_id, 'kategori' => $r->nama])->num_rows();
        }
        return $rows;
    }

    public function get_by_id($id) {
        return $this->db->get_where('kategori', ['id' => $id])->row();
    }

    public function get_by_toko_nama($toko_id, $nama) {
        return $this->db->get_where('kategori', ['toko_id' => $toko_id, 'nama' => $nama])->row();
    }

    public function insert($data) {
        if (empty($data['icon'])) $data['icon'] = null;
        if (empty($data['urutan'])) $data['urutan'] = 0;
        return $this->db->insert('kategori', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('kategori', $data);
    }

    public function delete($id) {
        return $this->db->delete('kategori', ['id' => $id]);
    }

    public function count_produk_in_kategori($kategori_id, $toko_id) {
        $k = $this->get_by_id($kategori_id);
        if (!$k) return 0;
        return $this->db->get_where('produk', ['toko_id' => $toko_id, 'kategori' => $k->nama])->num_rows();
    }

    // ============= DataTable Server-Side =============
    public function dt_count_all($toko_id) {
        return $this->db->get_where('kategori', ['toko_id' => $toko_id])->num_rows();
    }

    public function dt_count_filtered($toko_id, $search = '') {
        $this->db->from('kategori');
        $this->db->where('toko_id', $toko_id);
        if (!empty($search)) {
            $s = $this->db->escape_like_str($search);
            $this->db->group_start();
            $this->db->like('nama', $s);
            $this->db->or_like('icon', $s);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    public function dt_list($toko_id, $search = '', $start = 0, $length = 10, $order_col = 'id', $order_dir = 'asc') {
        $this->db->from('kategori');
        $this->db->where('toko_id', $toko_id);
        if (!empty($search)) {
            $s = $this->db->escape_like_str($search);
            $this->db->group_start();
            $this->db->like('nama', $s);
            $this->db->or_like('icon', $s);
            $this->db->group_end();
        }
        $this->db->order_by($order_col, $order_dir);
        $this->db->limit($length, $start);
        $rows = $this->db->get()->result();

        // Count produk per kategori
        foreach ($rows as $r) {
            $r->jumlah_produk = $this->db->get_where('produk', ['toko_id' => $toko_id, 'kategori' => $r->nama])->num_rows();
        }
        return $rows;
    }
}
