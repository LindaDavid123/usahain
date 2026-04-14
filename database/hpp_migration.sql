-- HPP migration: add new product fields required by simplified HPP form
-- Run this script once on existing databases.

ALTER TABLE `kalkulator_hpp`
  ADD COLUMN IF NOT EXISTS `nama_produk` VARCHAR(250) NULL AFTER `id_user`,
  ADD COLUMN IF NOT EXISTS `kategori` VARCHAR(100) NULL AFTER `nama_produk`,
  ADD COLUMN IF NOT EXISTS `jumlah_produksi` INT NULL AFTER `kategori`;
