<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Logs_model', 'Toko_model']);
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    private function _cek() {
        if (!$this->session->userdata('owner_id')) {
            redirect('owner/login');
            exit;
        }
    }

    public function index() {
        $this->_cek();
        $data['title'] = 'Activity Logs - Owner Dashboard';
        $this->load->view('owner/logs_index', $data);
    }

    public function get_logs() {
        $this->_cek();
        
        $draw = intval($this->input->get('draw'));
        $start = intval($this->input->get('start'));
        $length = intval($this->input->get('length'));
        $search = $this->input->get('search')['value'] ?? '';
        $user_type = $this->input->get('user_type') ?? '';
        $toko_id = $this->input->get('toko_id') ?? '';
        $action = $this->input->get('action') ?? '';
        $module = $this->input->get('module') ?? '';
        $date_from = $this->input->get('date_from') ?? '';
        $date_to = $this->input->get('date_to') ?? '';

        $this->db->from('activity_logs');

        if (!empty($search)) {
            $s = $this->db->escape_like_str($search);
            $this->db->group_start();
            $this->db->like('user_name', $s);
            $this->db->or_like('toko_name', $s);
            $this->db->or_like('action', $s);
            $this->db->or_like('module', $s);
            $this->db->or_like('description', $s);
            $this->db->group_end();
        }

        if (!empty($user_type)) {
            $this->db->where('user_type', $user_type);
        }

        if (!empty($toko_id)) {
            $this->db->where('toko_id', $toko_id);
        }

        if (!empty($action)) {
            $this->db->where('action', $action);
        }

        if (!empty($module)) {
            $this->db->where('module', $module);
        }

        if (!empty($date_from)) {
            $this->db->where('DATE(created_at) >=', date('Y-m-d', strtotime($date_from)));
        }

        if (!empty($date_to)) {
            $this->db->where('DATE(created_at) <=', date('Y-m-d', strtotime($date_to)));
        }

        $totalRecords = $this->db->count_all_results('', false);

        if (!empty($search)) {
            $s = $this->db->escape_like_str($search);
            $this->db->group_start();
            $this->db->like('user_name', $s);
            $this->db->or_like('toko_name', $s);
            $this->db->or_like('action', $s);
            $this->db->or_like('module', $s);
            $this->db->or_like('description', $s);
            $this->db->group_end();
        }

        if (!empty($user_type)) {
            $this->db->where('user_type', $user_type);
        }

        if (!empty($toko_id)) {
            $this->db->where('toko_id', $toko_id);
        }

        if (!empty($action)) {
            $this->db->where('action', $action);
        }

        if (!empty($module)) {
            $this->db->where('module', $module);
        }

        if (!empty($date_from)) {
            $this->db->where('DATE(created_at) >=', date('Y-m-d', strtotime($date_from)));
        }

        if (!empty($date_to)) {
            $this->db->where('DATE(created_at) <=', date('Y-m-d', strtotime($date_to)));
        }

        $totalFiltered = $this->db->count_all_results('', false);

        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($length, $start);
        $logs = $this->db->get()->result();

        $data = [];
        foreach ($logs as $log) {
            $user_icon = $log->user_type === 'owner' ? '👑' : ($log->user_type === 'admin' ? '🏪' : '👤');
            $user_badge = '<span class="log-user-type '.$log->user_type.'">'.$user_icon.' '.ucfirst($log->user_type).'</span>';
            
            $toko_info = '';
            if ($log->toko_name) {
                $toko_info = '<div class="log-toko">🏪 '.htmlspecialchars($log->toko_name).'</div>';
            }

            $old_data_display = '';
            if ($log->old_data) {
                $old_data = json_decode($log->old_data, true);
                if ($old_data) {
                    $old_data_display = '<div class="log-diff"><strong>Sebelum:</strong><pre>'.htmlspecialchars(json_encode($old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)).'</pre></div>';
                }
            }

            $new_data_display = '';
            if ($log->new_data) {
                $new_data = json_decode($log->new_data, true);
                if ($new_data) {
                    $new_data_display = '<div class="log-diff"><strong>Sesudah:</strong><pre>'.htmlspecialchars(json_encode($new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)).'</pre></div>';
                }
            }

            $details = '';
            if ($old_data_display || $new_data_display) {
                $details = '<div class="log-details">'.$old_data_display.$new_data_display.'</div>';
            }

            $data[] = [
                $log->id,
                '<div class="log-row">
                    <div class="log-header">
                        <div class="log-info">
                            '.$user_badge.' 
                            <strong>'.htmlspecialchars($log->user_name).'</strong>
                            '.$toko_info.'
                        </div>
                        <div class="log-time">'.date('d/m/Y H:i:s', strtotime($log->created_at)).'</div>
                    </div>
                    <div class="log-body">
                        <div class="log-action">
                            <span class="log-module">'.htmlspecialchars($log->module).'</span>
                            <span class="log-action-text">'.htmlspecialchars($log->action).'</span>
                        </div>
                        <div class="log-description">'.htmlspecialchars($log->description).'</div>
                        '.$details.'
                        <div class="log-meta">
                            <small>IP: '.($log->ip_address ?: 'N/A').'</small>
                        </div>
                    </div>
                </div>',
                $log->module,
                $log->action,
                date('Y-m-d', strtotime($log->created_at)),
            ];
        }

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function stats() {
        $this->_cek();
        $stats = $this->Logs_model->get_stats();
        echo json_encode($stats);
    }

    public function filters() {
        $this->_cek();
        $filters = [
            'user_types' => ['owner', 'admin', 'customer'],
            'actions' => $this->db->distinct()->select('action')->order_by('action', 'ASC')->get('activity_logs')->result(),
            'modules' => $this->db->distinct()->select('module')->order_by('module', 'ASC')->get('activity_logs')->result(),
            'toko_list' => $this->db->distinct()->select('toko_id, toko_name')->where('toko_name IS NOT NULL')->order_by('toko_name', 'ASC')->get('activity_logs')->result(),
        ];
        echo json_encode($filters);
    }

    public function export_csv() {
        $this->_cek();
        
        $filename = 'activity_logs_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Tanggal', 'User Type', 'User', 'Toko', 'Module', 'Action', 'Description', 'IP Address', 'User Agent']);
        
        $this->db->order_by('created_at', 'DESC');
        $logs = $this->db->get('activity_logs')->result();
        
        foreach ($logs as $log) {
            fputcsv($output, [
                $log->id,
                $log->created_at,
                $log->user_type,
                $log->user_name,
                $log->toko_name,
                $log->module,
                $log->action,
                $log->description,
                $log->ip_address,
                $log->user_agent
            ]);
        }
        
        fclose($output);
    }

    public function clear_old_logs() {
        $this->_cek();
        $days = intval($this->input->post('days')) ?: 30;
        $date_limit = date('Y-m-d H:i:s', strtotime('-' . $days . ' days'));
        
        $this->db->where('created_at <', $date_limit);
        $deleted = $this->db->delete('activity_logs');
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Berhasil menghapus ' . $deleted . ' log lama (lebih dari ' . $days . ' hari)'
        ]);
    }
}
