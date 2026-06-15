<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {

    public function get_by_toko($toko_id) {
        return $this->db->order_by('kategori ASC, id ASC')->get_where('produk', ['toko_id' => $toko_id])->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('produk', ['id' => $id])->row();
    }

    public function get_categories_by_toko($toko_id) {
        $this->db->select('kategori, COUNT(*) as total');
        $this->db->where('toko_id', $toko_id);
        $this->db->group_by('kategori');
        $this->db->order_by('kategori', 'ASC');
        return $this->db->get('produk')->result();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        if (empty($data['harga_diskon'])) $data['harga_diskon'] = 0;
        if (empty($data['kategori'])) $data['kategori'] = 'Lainnya';
        return $this->db->insert('produk', $data);
    }

    public function update($id, $data) {
        if (isset($data['harga_diskon']) && empty($data['harga_diskon'])) $data['harga_diskon'] = 0;
        if (isset($data['kategori']) && empty($data['kategori'])) $data['kategori'] = 'Lainnya';
        $this->db->where('id', $id);
        return $this->db->update('produk', $data);
    }

    public function delete($id) {
        return $this->db->delete('produk', ['id' => $id]);
    }

    public function get_harga_final($produk) {
        // Return effective price (diskon if ada dan lebih kecil)
        if (!empty($produk->harga_diskon) && $produk->harga_diskon > 0 && $produk->harga_diskon < $produk->harga) {
            return $produk->harga_diskon;
        }
        return $produk->harga;
    }
}

