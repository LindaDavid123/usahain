-- ============================================================
-- SQL MIGRATION: Tambah kolom yang hilang di tabel user
-- ============================================================
-- 
-- Jalankan script ini di phpMyAdmin untuk menambahkan kolom
-- yang diperlukan untuk fitur bisnis_info
--
-- Database: usahain_db
-- Table: user
--
-- ============================================================

-- 1. Tambahkan kolom jenis_usaha jika belum ada
ALTER TABLE `user` ADD COLUMN `jenis_usaha` VARCHAR(100) NULL DEFAULT NULL AFTER `nama_usaha`;

-- 2. Ubah tipe data nama_usaha dari VARCHAR(255) menjadi VARCHAR(100)
ALTER TABLE `user` MODIFY COLUMN `nama_usaha` VARCHAR(100) NULL DEFAULT NULL;

-- 3. Tambahkan kolom updated_at jika belum ada (untuk tracking)
ALTER TABLE `user` ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- 4. Tambahkan kolom data bisnis untuk AI Advisor
ALTER TABLE `user` ADD COLUMN `advisor_modal` DECIMAL(18,2) NULL DEFAULT NULL AFTER `jenis_usaha`;
ALTER TABLE `user` ADD COLUMN `advisor_minat` VARCHAR(100) NULL DEFAULT NULL AFTER `advisor_modal`;
ALTER TABLE `user` ADD COLUMN `advisor_lokasi` VARCHAR(100) NULL DEFAULT NULL AFTER `advisor_minat`;
ALTER TABLE `user` ADD COLUMN `advisor_tujuan` VARCHAR(150) NULL DEFAULT NULL AFTER `advisor_lokasi`;

-- ============================================================
-- VERIFICATION QUERIES (jalankan untuk memverifikasi)
-- ============================================================

-- Check struktur tabel user
-- DESCRIBE user;

-- Check kolom yang telah ditambahkan
-- SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE 
-- FROM INFORMATION_SCHEMA.COLUMNS 
-- WHERE TABLE_NAME = 'user' AND TABLE_SCHEMA = 'usahain_db'
-- ORDER BY ORDINAL_POSITION;

-- Sample insert untuk testing
-- INSERT INTO `user` (nama, email, password, nama_usaha, jenis_usaha, oauth_provider)
-- VALUES ('Test User', 'test@example.com', 'hashedpassword123', 'Warung Makan Berkah', 'Kuliner', 'local');

-- ============================================================
-- SELESAI
-- ============================================================
-- Script ini telah ditambahkan ke database/bisnis_info_migration.sql
-- Jalankan di phpMyAdmin atau gunakan mysql CLI:
-- mysql -u root -p usahain_db < database/bisnis_info_migration.sql
