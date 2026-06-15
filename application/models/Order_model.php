<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function get_all() {
        $this->db->select('orders.*, toko.nama_toko, toko.slug');
        $this->db->from('orders');
        $this->db->join('toko', 'toko.id = orders.toko_id');
        $this->db->order_by('orders.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_toko($toko_id) {
        $this->db->order_by('created_at', 'DESC')->get_where('orders', ['toko_id' => $toko_id])->result();
    }

    public function get_by_toko_array($toko_id) {
        return $this->db->order_by('created_at', 'DESC')->get_where('orders', ['toko_id' => $toko_id])->result();
    }

    // ============= DataTable Server-Side =============
    private function _dt_query($toko_id = null) {
        $this->db->select('orders.*, toko.nama_toko, toko.slug');
        $this->db->from('orders');
        $this->db->join('toko', 'toko.id = orders.toko_id', 'left');
        if ($toko_id) {
            $this->db->where('orders.toko_id', $toko_id);
        }

        // Search
        $search = $this->input->get('search');
        if (!empty($search['value'])) {
            $s = $this->db->escape_like_str($search['value']);
            $this->db->group_start();
            $this->db->where("orders.kode_order LIKE '%$s%'", null, false);
            $this->db->or_where("orders.nama_pembeli LIKE '%$s%'", null, false);
            $this->db->or_where("orders.blok_rumah LIKE '%$s%'", null, false);
            $this->db->or_where("orders.no_wa_pembeli LIKE '%$s%'", null, false);
            $this->db->or_where("orders.catatan LIKE '%$s%'", null, false);
            $this->db->or_where("toko.nama_toko LIKE '%$s%'", null, false);
            $this->db->group_end();
        }

        // Order
        $order_col = $this->input->get('order')[0]['column'] ?? 0;
        $order_dir = $this->input->get('order')[0]['dir'] ?? 'desc';
        $columns = ['orders.id', 'orders.kode_order', 'toko.nama_toko', 'orders.nama_pembeli', 'orders.blok_rumah', 'orders.total_harga', 'orders.metode_bayar', 'orders.status_bayar', 'orders.status_order', 'orders.created_at'];
        if (isset($columns[$order_col])) {
            $this->db->order_by($columns[$order_col], $order_dir);
        } else {
            $this->db->order_by('orders.created_at', 'DESC');
        }
    }

    public function dt_count_all($toko_id = null) {
        if ($toko_id) {
            return $this->db->get_where('orders', ['toko_id' => $toko_id])->num_rows();
        }
        return $this->db->count_all('orders');
    }

    public function dt_count_filtered($toko_id = null) {
        $this->_dt_query($toko_id);
        return $this->db->get()->num_rows();
    }

    public function dt_list($toko_id = null) {
        $this->_dt_query($toko_id);
        $length = $this->input->get('length') ?: 10;
        $start = $this->input->get('start') ?: 0;
        $this->db->limit($length, $start);
        return $this->db->get()->result();
    }

    public function get_by_kode($kode) {
        return $this->db->get_where('orders', ['kode_order' => $kode])->row();
    }

    public function get_by_id($id) {
        return $this->db->get_where('orders', ['id' => $id])->row();
    }

    public function get_items($order_id) {
        return $this->db->get_where('order_items', ['order_id' => $order_id])->result();
    }

    public function insert_order($order_data, $items) {
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();
        foreach ($items as $it) {
            $it['order_id'] = $order_id;
            $this->db->insert('order_items', $it);
        }
        return $order_id;
    }

    public function update_status($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('orders', $data);
    }

    public function count_all() { return $this->db->count_all('orders'); }
    public function count_by_toko($toko_id) {
        return $this->db->get_where('orders', ['toko_id' => $toko_id])->num_rows();
    }
    public function total_pendapatan() {
        $r = $this->db->select_sum('total_harga')->get('orders')->row();
        return $r->total_harga ?? 0;
    }
    public function total_pendapatan_toko($toko_id) {
        $r = $this->db->select_sum('total_harga')->get_where('orders', ['toko_id' => $toko_id, 'status_bayar' => 'lunas'])->row();
        return $r->total_harga ?? 0;
    }
}
