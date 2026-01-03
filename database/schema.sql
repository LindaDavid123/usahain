-- Schema SQL untuk aplikasi berdasarkan ERD
-- Lokasi file: database/schema.sql
-- Cara pakai: import file ini di MySQL (phpMyAdmin atau mysql CLI)

-- Buat database (ubah nama jika perlu)
CREATE DATABASE IF NOT EXISTS usahain_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE usahain_db;

-- Tabel user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `google_id` VARCHAR(255) UNIQUE,
  `oauth_provider` ENUM('local', 'google') DEFAULT 'local',
  `avatar_url` VARCHAR(500),
  `nama` VARCHAR(200) NOT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `email` VARCHAR(250) UNIQUE,
  `password` VARCHAR(255),
  `nama_usaha` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_google_id` (`google_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel subscription
CREATE TABLE IF NOT EXISTS `subscription` (
  `id_subs` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT(8) UNSIGNED NOT NULL,
  `paket` VARCHAR(50),
  `status` VARCHAR(50),
  `tgl_aktif` DATE,
  `tgl_expired` DATE,
  FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel analisis_produk
CREATE TABLE IF NOT EXISTS `analisis_produk` (
  `id_produk` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT(8) UNSIGNED NOT NULL,
  `nama_produk` VARCHAR(250),
  `analisis` TEXT,
  `penjualan` DECIMAL(14,2),
  `biaya_produksi` DECIMAL(14,2),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel manajemen_risiko
CREATE TABLE IF NOT EXISTS `manajemen_risiko` (
  `id_risiko` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT(8) UNSIGNED NOT NULL,
  `jenis_usaha` VARCHAR(100),
  `daftar_risiko` TEXT,
  `rekomendasi_mitigasi` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel pencatatan_keuangan
CREATE TABLE IF NOT EXISTS `pencatatan_keuangan` (
  `id_transaksi` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT(8) UNSIGNED NOT NULL,
  `kategori` VARCHAR(100),
  `jenis` VARCHAR(50),
  `nominal` DECIMAL(18,2),
  `tanggal` DATE,
  `catatan` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel kalkulator_hpp
CREATE TABLE IF NOT EXISTS `kalkulator_hpp` (
  `id_hpp` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT(8) UNSIGNED NOT NULL,
  `bahan` DECIMAL(14,2),
  `tenaga_kerja` DECIMAL(14,2),
  `total_biaya` DECIMAL(18,2),
  `harga_jual` DECIMAL(18,2),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel al_advisor (ide / rekomendasi AI)
CREATE TABLE IF NOT EXISTS `al_advisor` (
  `id_ide` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT(8) UNSIGNED NOT NULL,
  `modal` DECIMAL(18,2),
  `lokasi` VARCHAR(100),
  `minat` VARCHAR(100),
  `rekomendasi` TEXT,
  `riwayat_chat` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contoh user admin (opsional) — ubah password sebelum pakai di produksi
-- NOTE: password di bawah adalah placeholder (hash bcrypt). Ganti dengan hash yang valid.
INSERT INTO `user` (`nama`, `role`, `email`, `password`, `nama_usaha`)
VALUES ('Administrator', 'admin', 'admin@example.com', '$2y$10$examplehashplaceholder', 'AdminUsaha');

-- Selesai
