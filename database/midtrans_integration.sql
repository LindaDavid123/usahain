-- ============================================
-- SQL Migration untuk Midtrans Integration
-- Menambahkan kolom untuk tracking pembayaran
-- Tanggal: 2025-12-22
-- ============================================

-- Tambahkan kolom order_id untuk tracking Midtrans
ALTER TABLE `subscription` 
ADD COLUMN IF NOT EXISTS `order_id` VARCHAR(100) NULL AFTER `id_subs`,
ADD INDEX `idx_order_id` (`order_id`);

-- Tambahkan kolom payment_type untuk mencatat metode pembayaran aktual
ALTER TABLE `subscription` 
ADD COLUMN IF NOT EXISTS `payment_type` VARCHAR(50) NULL AFTER `metode_pembayaran`;

-- Tambahkan kolom transaction_time untuk timestamp pembayaran
ALTER TABLE `subscription` 
ADD COLUMN IF NOT EXISTS `transaction_time` DATETIME NULL AFTER `payment_type`;

-- Update enum status untuk include 'cancelled'
ALTER TABLE `subscription` 
MODIFY COLUMN `status` ENUM('active','inactive','expired','pending','cancelled') NOT NULL DEFAULT 'pending';

-- Verifikasi
-- DESCRIBE `subscription`;
