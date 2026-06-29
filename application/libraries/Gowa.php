<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gowa {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->config('config');
    }

    public function send_otp(string $phone, string $otp): array
    {
        $url = $this->CI->config->item('go_wa_send_message_url');
        if (empty($url)) {
            throw new RuntimeException('API WhatsApp belum dikonfigurasi.');
        }

        $message = "LUPA PASSWORD \n\n"
                 . "Kode OTP kamu adalah:\n\n"
                 . "# {$otp}\n\n"
                 . "Kode berlaku 5 menit. Jangan bagikan kepada siapa pun.\n"
                 . "Dikirim: " . date('d M Y H:i') . ' WIB';

        $payload = [
            'phone' => '62' . $phone . '@s.whatsapp.net',
            'message' => $message,
            'is_forwarded' => false,
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 15,
        ]);

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        $http = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false || $err !== '') {
            throw new RuntimeException('Gagal menghubungi API WhatsApp: ' . $err);
        }

        $res = json_decode((string) $raw, true);
        if ($http < 200 || $http >= 300 || !is_array($res) || ($res['code'] ?? '') !== 'SUCCESS') {
            throw new RuntimeException('Gagal mengirim OTP WhatsApp.');
        }

        return $res;
    }
}
