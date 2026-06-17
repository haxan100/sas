-- =====================================================
-- Add Activity Logs Table
-- =====================================================

USE `sas_tokorumah`;

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_type` ENUM('owner','admin','customer') NOT NULL,
  `user_id` INT(11) UNSIGNED DEFAULT NULL,
  `user_name` VARCHAR(100) DEFAULT NULL,
  `toko_id` INT(11) UNSIGNED DEFAULT NULL,
  `toko_name` VARCHAR(100) DEFAULT NULL,
  `action` VARCHAR(100) NOT NULL,
  `module` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL,
  `old_data` TEXT DEFAULT NULL,
  `new_data` TEXT DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_type` (`user_type`),
  KEY `user_id` (`user_id`),
  KEY `toko_id` (`toko_id`),
  KEY `action` (`action`),
  KEY `module` (`module`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Index untuk query performa
CREATE INDEX `idx_logs_search` ON `activity_logs` (`user_type`, `toko_id`, `created_at`);
