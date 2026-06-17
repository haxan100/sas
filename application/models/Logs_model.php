<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_model extends CI_Model {

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('activity_logs', $data);
    }

    public function get_all($limit = 100, $offset = 0) {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('activity_logs', $limit, $offset)->result();
    }

    public function get_by_toko($toko_id, $limit = 50, $offset = 0) {
        $this->db->where('toko_id', $toko_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('activity_logs', $limit, $offset)->result();
    }

    public function get_by_user_type($user_type, $limit = 100, $offset = 0) {
        $this->db->where('user_type', $user_type);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('activity_logs', $limit, $offset)->result();
    }

    public function get_by_action($action, $limit = 50, $offset = 0) {
        $this->db->where('action', $action);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('activity_logs', $limit, $offset)->result();
    }

    public function get_by_module($module, $limit = 100, $offset = 0) {
        $this->db->where('module', $module);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('activity_logs', $limit, $offset)->result();
    }

    public function count_all() {
        return $this->db->count_all('activity_logs');
    }

    public function count_by_toko($toko_id) {
        return $this->db->where('toko_id', $toko_id)->count_all_results('activity_logs');
    }

    public function count_by_user_type($user_type) {
        return $this->db->where('user_type', $user_type)->count_all_results('activity_logs');
    }

    public function get_last_24h() {
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-24 hours')));
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('activity_logs')->result();
    }

    public function get_stats() {
        $stats = [
            'total' => $this->count_all(),
            'by_type' => $this->_get_stats_by_type(),
            'by_action' => $this->_get_stats_by_action(),
            'by_module' => $this->_get_stats_by_module()
        ];
        return $stats;
    }

    private function _get_stats_by_type() {
        $query = $this->db->query("
            SELECT user_type, COUNT(*) as count 
            FROM activity_logs 
            GROUP BY user_type 
            ORDER BY count DESC
        ")->result();
        return $query;
    }

    private function _get_stats_by_action() {
        $query = $this->db->query("
            SELECT action, COUNT(*) as count 
            FROM activity_logs 
            GROUP BY action 
            ORDER BY count DESC 
            LIMIT 10
        ")->result();
        return $query;
    }

    private function _get_stats_by_module() {
        $query = $this->db->query("
            SELECT module, COUNT(*) as count 
            FROM activity_logs 
            GROUP BY module 
            ORDER BY count DESC 
            LIMIT 10
        ")->result();
        return $query;
    }

    public function truncate() {
        return $this->db->truncate('activity_logs');
    }
}
