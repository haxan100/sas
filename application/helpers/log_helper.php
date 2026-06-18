<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_Helper {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('Logs_model');
    }

    public static function log_activity($user_type, $user_id, $user_name, $toko_id, $toko_name, $action, $module, $description, $old_data = null, $new_data = null) {
        $CI =& get_instance();
        $CI->load->model('Logs_model');

        $data = [
            'user_type' => $user_type,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'toko_id' => $toko_id,
            'toko_name' => $toko_name,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'old_data' => is_array($old_data) ? json_encode($old_data) : $old_data,
            'new_data' => is_array($new_data) ? json_encode($new_data) : $new_data,
            'ip_address' => $CI->input->ip_address(),
            'user_agent' => substr($CI->input->user_agent(), 0, 255)
        ];

        return $CI->Logs_model->insert($data);
    }

    public static function log_owner_action($owner_id, $owner_name, $action, $description, $data = null) {
        return self::log_activity('owner', $owner_id, $owner_name, null, null, $action, 'Owner', $description, null, $data);
    }

    public static function log_admin_action($toko_id, $toko_name, $admin_id, $admin_name, $action, $module, $description, $old_data = null, $new_data = null) {
        return self::log_activity('admin', $admin_id, $admin_name, $toko_id, $toko_name, $action, $module, $description, $old_data, $new_data);
    }

    public static function log_customer_action($toko_id, $toko_name, $customer_name, $action, $description, $data = null) {
        return self::log_activity('customer', null, $customer_name, $toko_id, $toko_name, $action, 'Customer', $description, null, $data);
    }

    public static function log_toko_created($toko_id, $toko_name, $owner_id, $owner_name) {
        return self::log_owner_action($owner_id, $owner_name, 'CREATE_TOKO', 'Toko baru dibuat: ' . $toko_name, ['toko_id' => $toko_id, 'toko_name' => $toko_name]);
    }

    public static function log_toko_updated($toko_id, $toko_name, $owner_id, $owner_name, $old_data, $new_data) {
        return self::log_owner_action($owner_id, $owner_name, 'UPDATE_TOKO', 'Toko diperbarui: ' . $toko_name, $new_data);
    }

    public static function log_toko_verified($toko_id, $toko_name, $owner_id, $owner_name, $status) {
        return self::log_owner_action($owner_id, $owner_name, 'VERIFY_TOKO', 'Toko diverifikasi dengan status: ' . $status, ['toko_id' => $toko_id, 'status' => $status]);
    }

    public static function log_produk_created($toko_id, $toko_name, $admin_id, $admin_name, $produk_name) {
        return self::log_admin_action($toko_id, $toko_name, $admin_id, $admin_name, 'CREATE_PRODUK', 'Produk', 'Produk baru ditambahkan: ' . $produk_name, null, ['produk_name' => $produk_name]);
    }

    public static function log_produk_updated($toko_id, $toko_name, $admin_id, $admin_name, $produk_name, $old_data, $new_data) {
        return self::log_admin_action($toko_id, $toko_name, $admin_id, $admin_name, 'UPDATE_PRODUK', 'Produk', 'Produk diperbarui: ' . $produk_name, $old_data, $new_data);
    }

    public static function log_produk_deleted($toko_id, $toko_name, $admin_id, $admin_name, $produk_name) {
        return self::log_admin_action($toko_id, $toko_name, $admin_id, $admin_name, 'DELETE_PRODUK', 'Produk', 'Produk dihapus: ' . $produk_name, ['produk_name' => $produk_name], null);
    }

    public static function log_order_created($toko_id, $toko_name, $customer_name, $order_code, $total) {
        return self::log_customer_action($toko_id, $toko_name, $customer_name, 'CREATE_ORDER', 'Pesanan baru dibuat: ' . $order_code . ' Total: Rp' . number_format($total), ['order_code' => $order_code, 'total' => $total]);
    }

    public static function log_order_updated($toko_id, $toko_name, $admin_id, $admin_name, $order_code, $old_status, $new_status) {
        return self::log_admin_action($toko_id, $toko_name, $admin_id, $admin_name, 'UPDATE_ORDER', 'Order', 'Status pesanan diubah: ' . $order_code . ' dari ' . $old_status . ' ke ' . $new_status, ['old_status' => $old_status], ['new_status' => $new_status]);
    }

    public static function log_login($user_type, $user_id, $user_name, $toko_id = null, $toko_name = null) {
        return self::log_activity($user_type, $user_id, $user_name, $toko_id, $toko_name, 'LOGIN', 'Auth', $user_name . ' berhasil login', null, null);
    }

    public static function log_logout($user_type, $user_id, $user_name, $toko_id = null, $toko_name = null) {
        return self::log_activity($user_type, $user_id, $user_name, $toko_id, $toko_name, 'LOGOUT', 'Auth', $user_name . ' berhasil logout', null, null);
    }
}
