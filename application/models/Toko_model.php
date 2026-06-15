<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Toko_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get('toko')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('toko', ['id' => $id])->row();
    }

    public function get_by_slug($slug) {
        return $this->db->get_where('toko', ['slug' => $slug])->row();
    }

    public function get_by_username($username) {
        return $this->db->get_where('toko', ['username' => $username])->row();
    }

    public function insert($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('toko', $data);
    }

    public function update($id, $data) {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        $this->db->where('id', $id);
        return $this->db->update('toko', $data);
    }

    public function delete($id) {
        return $this->db->delete('toko', ['id' => $id]);
    }

    public function count_all() {
        return $this->db->count_all('toko');
    }
}
