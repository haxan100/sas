<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_otp_codes_table extends CI_Migration {

    public function up()
    {
        $sql = "CREATE TABLE `otp_codes` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `phone` varchar(20) NOT NULL,
            `code` varchar(10) NOT NULL,
            `created_at` datetime NOT NULL,
            `expires_at` datetime NOT NULL,
            `used` tinyint(1) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            KEY `phone` (`phone`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->db->query($sql);
    }

    public function down()
    {
        $this->db->query("DROP TABLE `otp_codes`");
    }
}

