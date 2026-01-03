-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2025 pada 18.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usahain_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `al_advisor`
--

CREATE TABLE `al_advisor` (
  `id_ide` int(11) NOT NULL,
  `id_user` int(8) UNSIGNED NOT NULL,
  `modal` decimal(18,2) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `minat` varchar(100) DEFAULT NULL,
  `rekomendasi` text DEFAULT NULL,
  `riwayat_chat` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `al_advisor`
--

INSERT INTO `al_advisor` (`id_ide`, `id_user`, `modal`, `lokasi`, `minat`, `rekomendasi`, `riwayat_chat`, `created_at`) VALUES
(1, 6, 1000000.00, 'bandung', 'fashion', 'Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\n\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\n\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '', '2025-12-10 08:22:47'),
(2, 6, 5000000.00, 'jakarta', 'kuliner', 'Dengan modal Rp 5.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '', '2025-12-10 08:23:59'),
(3, 6, 5000000.00, 'bandung', 'fashion', 'Dengan modal Rp 5.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\n\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '', '2025-12-10 08:27:04'),
(4, 6, 1000000.00, 'jakarta', 'kuliner', 'Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"business apa yang cocok dengan kuliner es milo\",\"time\":\"2025-12-15 18:12:06\"},{\"from\":\"ai\",\"message\":\"Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\",\"time\":\"2025-12-15 18:12:06\"},{\"from\":\"user\",\"message\":\"Saya punya modal 10 juta di daerah kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 18:13:08\"},{\"from\":\"ai\",\"message\":\"Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\",\"time\":\"2025-12-15 18:13:08\"},{\"from\":\"user\",\"message\":\"business apa yang cocok dengan kuliner es milo\",\"time\":\"2025-12-15 18:37:14\"},{\"from\":\"ai\",\"message\":\"Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\",\"time\":\"2025-12-15 18:37:15\"},{\"from\":\"user\",\"message\":\"business apa yang cocok dengan kuliner es milo\",\"time\":\"2025-12-15 18:47:24\"},{\"from\":\"ai\",\"message\":\"Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\",\"time\":\"2025-12-15 18:47:25\"},{\"from\":\"user\",\"message\":\"Saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 18:55:29\"},{\"from\":\"ai\",\"message\":\"Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\",\"time\":\"2025-12-15 18:55:30\"},{\"from\":\"user\",\"message\":\"Kalau fokus kuliner minuman, strategi pemasaran online yang efektif apa?\",\"time\":\"2025-12-15 18:59:33\"},{\"from\":\"ai\",\"message\":\"Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\",\"time\":\"2025-12-15 18:59:33\"}]', '2025-12-16 00:11:29'),
(5, 6, 10000000.00, 'jakarta', 'kuliner', 'Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"Saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:01:49\"},{\"from\":\"ai\",\"message\":\"Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\",\"time\":\"2025-12-15 19:01:49\"},{\"from\":\"user\",\"message\":\"serius?\",\"time\":\"2025-12-15 19:02:33\"},{\"from\":\"ai\",\"message\":\"Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\",\"time\":\"2025-12-15 19:02:34\"}]', '2025-12-16 01:01:30'),
(6, 6, 10000000.00, 'jakarta', 'kuliner', 'Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"Saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:13:29\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:13:29\"},{\"from\":\"user\",\"message\":\"Saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:13:59\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:13:59\"}]', '2025-12-16 01:11:13'),
(7, 6, 10000000.00, 'jakarta', 'kuliner', 'Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"Saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:14:30\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:14:30\"},{\"from\":\"user\",\"message\":\"Saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:14:43\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:14:43\"},{\"from\":\"user\",\"message\":\"saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:16:43\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:16:43\"}]', '2025-12-16 01:14:24'),
(8, 6, 50000000.00, 'bandung', 'fashion', 'Modal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\n\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\n\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:17:34\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:17:35\"},{\"from\":\"user\",\"message\":\"saya punya modal 10 juta di kota, usaha apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:18:54\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:18:54\"},{\"from\":\"user\",\"message\":\"Gemini raw response:\",\"time\":\"2025-12-15 19:23:13\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:23:13\"},{\"from\":\"user\",\"message\":\"Saya punya modal 10 juta di kota, usaha kuliner apa yang cepat balik modal?\",\"time\":\"2025-12-15 19:25:46\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-15 19:25:46\"}]', '2025-12-16 01:17:27'),
(9, 8, 10000000.00, 'jakarta', 'kuliner', 'Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"Berikan ide bisnis dengan modal 10 juta\",\"time\":\"2025-12-17 01:47:26\"},{\"from\":\"ai\",\"message\":\"Maaf, AI sedang sibuk. Silakan coba lagi.\",\"time\":\"2025-12-17 01:47:29\"}]', '2025-12-17 07:47:01'),
(10, 10, 10000000.00, 'medan', 'fashion', 'Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\n\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"berikan ide bisnis yang bermodalkan 5 juta\",\"time\":\"2025-12-17 02:05:21\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nKelompokkan biaya menjadi modal awal, biaya operasional, dan cadangan. Prioritaskan pembelian bahan baku yang memberikan margin terbaik. Pertimbangkan model pre-order untuk mengurangi kebutuhan modal.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 02:05:26\"},{\"from\":\"user\",\"message\":\"berikan tipsnya\",\"time\":\"2025-12-17 02:05:57\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nDengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\\n\\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\\n\\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 02:06:02\"},{\"from\":\"user\",\"message\":\"tipsnya\",\"time\":\"2025-12-17 02:08:50\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nDengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\\n\\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\\n\\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 02:08:55\"},{\"from\":\"user\",\"message\":\"tipsnya\",\"time\":\"2025-12-17 02:10:47\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nDengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\\n\\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\\n\\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 02:10:51\"},{\"from\":\"user\",\"message\":\"tipsnya\",\"time\":\"2025-12-17 02:14:34\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nDengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\\n\\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\\n\\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 02:14:37\"}]', '2025-12-17 07:55:45'),
(11, 8, 50000000.00, 'surabaya', 'kuliner', 'Modal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"hitam\",\"time\":\"2025-12-17 11:36:20\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nModal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 11:36:20\"},{\"from\":\"user\",\"message\":\"halo\",\"time\":\"2025-12-17 11:39:03\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nModal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 11:39:15\"},{\"from\":\"user\",\"message\":\"halo\",\"time\":\"2025-12-17 11:40:39\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nModal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 11:40:41\"},{\"from\":\"user\",\"message\":\"halo\",\"time\":\"2025-12-17 11:59:38\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nModal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 11:59:40\"}]', '2025-12-17 17:35:46'),
(12, 8, 50000000.00, 'surabaya', 'kuliner', 'Modal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"halo\",\"time\":\"2025-12-17 12:00:38\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nModal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 12:00:40\"}]', '2025-12-17 18:00:35'),
(13, 8, 50000000.00, 'surabaya', 'kuliner', 'Modal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"halo\",\"time\":\"2025-12-17 12:04:10\"},{\"from\":\"ai\",\"message\":\"Halo! Senang bisa membantu Anda merencanakan usaha kuliner di Surabaya dengan modal Rp 50 juta. Surabaya adalah kota kuliner yang sangat dinamis, jadi kita perlu strategi yang tepat agar usaha Anda menonjol.\\n\\nMengingat modal yang Anda miliki, fokus terbaik adalah pada konsep yang minim *overhead* awal tapi memiliki potensi *viral* atau *niche* yang kuat. Saya sarankan Anda mempertimbangkan konsep **\\\"Nasi Kucing Premium\\/Kreasi\\\"** dengan sistem *delivery order* dan *takeaway* yang kuat. Surabaya punya banyak mahasiswa dan pekerja yang mencari makan malam atau dini hari yang enak dan terjangkau, namun tetap dengan sentuhan unik.\\n\\n**Alokasi Modal Praktis (Rp 50 Juta):**\\n\\n1.  **Peralatan Dasar (Kompor, Panci, Kulkas Kecil, Gerobak\\/Booth Lipat Sederhana):** Alokasikan sekitar Rp 15 Juta. Fokus pada alat yang benar-benar esensial dan berkualitas sedang agar awet.\\n2.  **Bahan Baku Awal & *Packaging*:** Siapkan Rp 10 Juta. Untuk *packaging*, jangan pelit; gunakan wadah yang menarik dan *food-grade* karena ini akan jadi daya tarik utama saat diantar.\\n3.  **Pemasaran Digital Awal & *Branding* (Logo, Foto Produk, Biaya *GoFood\\/GrabFood*):** Alokasikan Rp 10 Juta. Ini krusial di Surabaya. Anda harus tampil menarik di aplikasi *online*.\\n4.  **Sewa Tempat (Dapur Titip Jual\\/Kontrakan Kecil di area strategis, atau sistem *cloud kitchen*):** Rp 10 Juta untuk DP dan biaya operasional bulan pertama (pilih lokasi yang aksesnya mudah untuk kurir).\\n5.  **Dana Darurat\\/Operasional:** Sisanya, Rp 5 Juta.\\n\\nUntuk eksekusi, fokuslah pada menu andalan seperti Nasi Kucing dengan isian unik (misalnya, sambal matah ayam suwir, atau oseng mercon), dan jual juga sate-satean pendamping yang mudah dibuat. Mulai kecil, kuasai kualitas, dan dominasi area tertentu sebelum berekspansi.\",\"time\":\"2025-12-17 12:04:13\"}]', '2025-12-17 18:04:07'),
(14, 11, 50000000.00, 'surabaya', 'kuliner', 'Modal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"halo\",\"time\":\"2025-12-17 12:07:03\"},{\"from\":\"ai\",\"message\":\"Selamat pagi! Senang sekali bisa membantu Bapak\\/Ibu yang bersemangat memulai usaha kuliner di Surabaya dengan modal Rp50 juta. Surabaya adalah kota kuliner yang dinamis, jadi peluangnya besar asalkan strateginya tepat.\\n\\nMelihat modal dan lokasi Anda, saran saya adalah fokus pada konsep yang *niche* namun memiliki daya tarik tinggi di Surabaya, yaitu **Kuliner Kekinian dengan Sentuhan Khas Lokal (Fusion)**. Daripada langsung membuka warung besar, lebih baik kita mulai dengan format *cloud kitchen* atau *booth* makanan kecil yang fokus pada *delivery* dan *takeaway*.\\n\\n**Ide Usaha Spesifik:** \\\"Nasi Goreng Rempah Surabaya Pedas Manis\\\" yang disajikan dalam kemasan premium atau \\\"Martabak Mini Kekinian\\\" dengan *topping* unik khas Jawa Timur (misalnya rasa tape keju atau durian). Modal Rp50 juta cukup ideal untuk menyewa tempat kecil (atau dapur bersama), membeli peralatan standar (kompor, *freezer*, *tools*), serta stok bahan baku awal dan pemasaran digital awal.\\n\\n**Langkah Praktis:** Alokasikan sekitar Rp25 juta untuk sewa tempat\\/dapur dan peralatan. Sisanya (Rp25 juta) untuk bahan baku, *packaging* yang menarik (ini penting untuk diferensiasi), dan biaya promosi awal, terutama di media sosial dan aplikasi pesan antar makanan yang populer di Surabaya. Fokuskan dulu pada satu menu andalan agar kualitasnya terjamin.\\n\\nMari kita bahas lebih detail, kira-kira dari ide di atas, mana yang paling menarik minat Anda untuk kita kembangkan strateginya?\",\"time\":\"2025-12-17 12:07:06\"}]', '2025-12-17 18:07:00'),
(15, 11, 50000000.00, 'surabaya', 'kuliner', 'Modal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"halo\",\"time\":\"2025-12-17 12:09:11\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nModal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 12:09:55\"},{\"from\":\"user\",\"message\":\"apakah ada saran lain\",\"time\":\"2025-12-17 12:11:00\"},{\"from\":\"ai\",\"message\":\"Berikut jawaban singkat berdasarkan konteks Anda:\\n\\nModal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\\n\\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\\n\\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\\n\\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\\n\\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.\\n\\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.\",\"time\":\"2025-12-17 12:11:00\"}]', '2025-12-17 18:09:07'),
(16, 12, 50000000.00, 'surabaya', 'kuliner', 'Modal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"berikan ide bisnis yang seleniar dengan fashion\",\"time\":\"2025-12-17 16:52:12\"},{\"from\":\"ai\",\"message\":\"Halo! Dengan modal Rp 50 juta di Surabaya dan minat di kuliner, mencari ide yang *selinear* dengan fashion adalah langkah yang menarik. Kita bisa menggabungkan keduanya menjadi konsep *lifestyle* yang sedang tren.\\n\\nSaya menyarankan Anda fokus pada **\\\"Dessert Box\\/Snack Box Tematik dengan Sentuhan Desain Eksklusif\\\"**. Surabaya adalah pasar yang menyukai makanan cantik (Instagrammable). Daripada sekadar menjual kue, Anda menjual pengalaman presentasi yang elegan. Misalnya, membuat *signature box* yang desain kemasannya (karton, pita, kartu ucapan) selalu *up-to-date* mengikuti tren warna fashion terbaru (misalnya, warna pastel lembut atau *earth tone* yang sedang naik daun).\\n\\n**Alokasi Modal Praktis:** Alokasikan sekitar Rp 20 juta untuk peralatan dapur dasar (mixer, oven *entry-level* yang bagus, *chiller* kecil), Rp 15 juta untuk *branding* awal (desain logo, cetak kemasan premium awal, bahan baku awal), dan sisanya untuk *digital marketing* dan operasional bulan pertama. Fokuskan 70% energi Anda pada kualitas produk (rasa harus konsisten) dan 30% pada *packaging* yang \\\"berbicara\\\" layaknya produk *fashion*.\\n\\n**Strategi Penjualan:** Jual melalui *pre-order* ketat di awal untuk meminimalisir *food waste*. Jalin kerjasama dengan butik-butik lokal di Surabaya atau *personal stylist* untuk penawaran paket (*bundling*) saat mereka mengadakan *launching* koleksi baru. Ini memastikan produk Anda langsung menyentuh target pasar yang peduli estetika.\\n\\nIni adalah bisnis kuliner yang mengutamakan penampilan, persis seperti industri *fashion* yang selalu menonjolkan *styling* dan detail. Dengan modal Rp 50 juta, konsep ini sangat memungkinkan untuk dimulai skala kecil namun dengan *image* premium.\",\"time\":\"2025-12-17 16:52:15\"},{\"from\":\"user\",\"message\":\"apakah ada saran lain\",\"time\":\"2025-12-17 16:52:42\"},{\"from\":\"ai\",\"message\":\"Tentu saja, ada ide kreatif lain yang bisa Anda pertimbangkan, tetap mempertahankan koneksi dengan tren *fashion* namun dari sisi pengalaman bersantap.\\n\\nSaya sarankan Anda mengembangkan **\\\"Pop-Up Coffee & Light Bites Bar dengan Konsep *Styling Corner*\\\"**. Daripada menjual makanan berat, Anda menjual kopi spesialti atau minuman unik (seperti *infused water* atau *mocktail* menarik) yang disajikan dalam kemasan estetik, digabungkan dengan *spot* kecil di mana pengunjung bisa mencoba aksesoris atau melihat *display* produk *fashion* kecil (misalnya, syal, bros, atau tas kecil dari *brand* lokal yang sedang berkembang).\\n\\n**Pembagian Anggaran:** Dengan modal Rp 50 juta, fokuskan Rp 25 juta untuk sewa tempat *pop-up* (pilih lokasi yang sering dilewati target pasar *fashion* seperti dekat area kafe *hits* atau mal), Rp 15 juta untuk peralatan *brewing* dasar (mesin kopi *second* yang handal atau *manual brew set* profesional), dan sisanya untuk stok bahan baku minuman premium serta dekorasi yang bergaya (*aesthetic*).\\n\\n**Implementasi Praktis:** Anda tidak perlu punya toko permanen. Lakukan *pop-up* di akhir pekan di area strategis atau bahkan menyewa ruang kosong di dalam *department store* selama sehari. Kunci suksesnya adalah kolaborasi: ajak satu *brand fashion* kecil setiap bulan untuk mengisi *corner* Anda. Mereka mendapat tempat promosi, Anda mendapat *traffic* pengunjung yang tertarik dengan *vibe* gaya hidup.\\n\\nIni adalah bisnis yang memadukan *food & beverage* dengan *retail experience*. Anda menjual \\\"tempat nongkrong yang *stylish*\\\" daripada sekadar menjual kopi. Keunikan ini akan membuat Anda menonjol di tengah banyaknya kedai kopi di Surabaya.\",\"time\":\"2025-12-17 16:52:45\"},{\"from\":\"user\",\"message\":\"semisal modal baru 5 juta apakah ada ide\",\"time\":\"2025-12-17 16:53:37\"},{\"from\":\"ai\",\"message\":\"Modal Rp 5 juta di Surabaya untuk bisnis kuliner adalah tantangan yang membutuhkan fokus sangat tajam pada efisiensi dan penjualan langsung. Lupakan konsep kafe atau *pop-up* mewah. Kita harus kembali ke akar yang paling laku dan modal minim: **Bisnis Kuliner Berbasis Stok Barang Terbatas dan Pre-Order Kilat.**\\n\\nSaya sarankan Anda fokus pada **\\\"Topping Nasi\\/Mie Instan Premium Buatan Sendiri (Homemade Toppings)\\\"** yang dipasarkan melalui komunitas dan kantor. Di Surabaya banyak pekerja kantoran yang mencari opsi makan siang cepat namun ingin rasa yang lebih enak dari sekadar mi instan biasa. Anda menjual kelezatan *topping* seperti dendeng balado super pedas, ayam suwir pedas manis khas, atau telur asin premium dalam kemasan *jar* kecil.\\n\\n**Alokasi Modal Rp 5 Juta:** Ini harus sangat ketat. Alokasikan Rp 2 juta untuk bahan baku awal (memasak dalam jumlah kecil namun konsisten), Rp 1,5 juta untuk kemasan *jar* atau *pouch* yang bagus (label menarik itu wajib), dan Rp 1,5 juta sisanya untuk biaya *marketing* digital melalui WhatsApp Blast ke grup kantor\\/komunitas dan biaya transportasi saat pengiriman di area Surabaya Pusat\\/Selatan.\\n\\n**Strategi Praktis:** Jangan buka di banyak tempat. Fokuskan penjualan Anda pada **satu jenis *topping* unggulan** saja di awal (misalnya, hanya \'Ayam Matah Sambal Matah Khas Bali\'). Jualan wajib sistem *Pre-Order* (PO) harian atau dua harian. Anda hanya memasak sesuai pesanan yang masuk. Ini menghilangkan risiko kerugian bahan baku dan memastikan kesegaran produk, yang sangat penting untuk menjaga reputasi Anda di awal.\\n\\nDengan fokus pada produk tunggal yang sangat lezat dan strategi PO yang ketat, modal Rp 5 juta bisa berputar cepat dan memberikan Anda modal kerja untuk naik kelas di periode berikutnya. Ini adalah bisnis kuliner yang sangat mengandalkan rasa dan kecepatan distribusi.\",\"time\":\"2025-12-17 16:53:40\"}]', '2025-12-17 22:51:50'),
(17, 13, 1000000.00, 'jakarta', 'fashion', 'Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.\n\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\n\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"berikan ide usaha dengan modal yang saya pilih btadi\",\"time\":\"2025-12-17 18:16:25\"},{\"from\":\"ai\",\"message\":\"Halo! Dengan modal Rp1.000.000 di Jakarta dan minat di bidang *fashion*, ada beberapa ide usaha yang sangat memungkinkan untuk Anda mulai secara realistis dan praktis. Fokus utama kita adalah memaksimalkan modal kecil dengan memanfaatkan platform digital.\\n\\n**Ide Bisnis 1: *Thrifting* Spesialis (Baju Bekas Layak Pakai)**. Jakarta adalah surga *thrifting*. Alokasikan sekitar Rp700.000 untuk membeli stok awal di pasar loak atau *supplier* grosir (pilih kategori yang sedang tren, misalnya kemeja *vintage* atau *outer* rajut). Sisa Rp300.000 digunakan untuk biaya *branding* sederhana (hangtag, *packaging* plastik yang bagus) dan sedikit *boost* iklan di Instagram\\/TikTok. Kunci suksesnya adalah kurasi barang yang sangat baik dan foto produk yang menarik.\\n\\n**Ide Bisnis 2: Jasa *Custom* Aksesori *Pre-Order* (PO)**. Daripada stok barang jadi, fokuslah pada produk yang dibuat sesuai pesanan, seperti *tote bag* kanvas polos yang Anda dekorasi sendiri (lukis, bordir sederhana, atau *patch*), atau *scrunchie* bahan premium. Modal Rp1.000.000 bisa dialokasikan untuk membeli bahan baku minimal (kanvas, kain, benang, karet) sekitar Rp600.000, dan sisanya untuk *sample* produk dan promosi. Model PO meminimalkan risiko kerugian karena Anda hanya membeli bahan setelah ada pesanan masuk.\\n\\n**Ide Bisnis 3: Menjadi *Reseller* Produk Lokal Niche**. Cari produsen atau UMKM *fashion* lokal di luar Jakarta yang menjual produk unik (misalnya batik kontemporer, kaus dengan desain grafis lokal yang kuat, atau sepatu *sneakers* lokal) dengan sistem *reseller* atau *dropship* (jika memungkinkan). Gunakan modal Rp1.000.000 untuk membeli stok perkenalan yang paling laku (sekitar 10-15 item) dan fokuskan pemasaran Anda di area Jakarta tempat Anda tinggal atau bekerja, menggunakan testimoni dan konten yang menekankan keunikan produk tersebut.\\n\\nKetiga opsi ini menghindari biaya sewa tempat dan memungkinkan Anda memulai dari rumah (bisnis rumahan). Apapun yang Anda pilih, konsistensi dalam pemasaran digital adalah kunci untuk menarik pembeli di Jakarta. Selamat mencoba!\",\"time\":\"2025-12-17 18:16:29\"},{\"from\":\"user\",\"message\":\"berikan saran ide lain\",\"time\":\"2025-12-17 18:16:44\"},{\"from\":\"ai\",\"message\":\"Tentu saja! Dengan modal Rp1.000.000 dan lokasi di Jakarta, kita bisa mencari ide lain yang memanfaatkan tren konsumsi cepat di kota besar namun tetap menjaga modal tetap aman. Karena Anda tertarik pada *fashion*, mari kita coba fokus pada penyediaan solusi daripada sekadar menjual pakaian.\\n\\n**Ide Bisnis 4: Jasa *Styling* & *Outfit Builder* Digital Khusus Anak Muda Jakarta.** Daripada menjual fisik, jual keahlian Anda dalam memadupadankan pakaian. Alokasikan modal untuk pengembangan *personal branding* Anda sebagai *stylist* pemula. Gunakan Rp300.000 untuk membuat portofolio digital (foto diri dengan *outfit* yang Anda padu padankan) dan membuat materi promosi menarik di Instagram\\/TikTok. Sisa Rp700.000 bisa disimpan sebagai dana darurat atau dialokasikan untuk membuat beberapa aksesoris sederhana yang Anda gunakan sebagai \'pelengkap\' saat menawarkan jasa konsultasi *styling* (misalnya, bros atau syal buatan sendiri). Jasa ini minim risiko stok dan sangat dibutuhkan orang yang ingin tampil gaya tanpa harus boros beli baju baru.\\n\\n**Ide Bisnis 5: Distributor Bahan Kain\\/Kancing & Perlengkapan Jahit Skala Kecil.** Fokus pada bisnis hulu (bahan baku). Banyak penjahit rumahan atau pembuat busana skala kecil di Jakarta membutuhkan suplai bahan yang cepat dan dalam jumlah tidak terlalu besar. Cari distributor besar di pasar tekstil (seperti Tanah Abang atau Pasar Mayestik) dan beli bahan-bahan yang sedang dicari (misalnya, *lace*, kancing unik, atau *zipper* berkualitas) dalam jumlah kecil. Modal Rp1.000.000 bisa digunakan untuk membeli stok awal bahan yang cepat laku tersebut. Anda menjual kembali secara *online* kepada sesama pelaku UMKM *fashion* atau *home tailor*. Keunggulan Anda adalah kecepatan pengiriman di area Jakarta.\\n\\n**Ide Bisnis 6: *Pop-Up* Sewa Aksesori *Fashion* untuk Foto Produk\\/Acara.** Banyak *influencer*, *brand* kecil, atau bahkan individu yang butuh aksesori mewah atau unik hanya untuk satu sesi foto atau satu malam acara. Anda bisa menggunakan modal untuk membeli beberapa tas, sepatu, atau perhiasan imitasi premium yang sangat *eye-catching*. Tetapkan biaya sewa harian yang menarik. Rp1.000.000 dapat digunakan untuk mengakuisisi 3-5 item berkualitas tinggi yang memiliki nilai sewa tinggi. Pastikan Anda memiliki sistem deposit dan perjanjian sewa yang jelas untuk menghindari risiko kerusakan barang.\\n\\nPilihlah ide yang paling sesuai dengan kemampuan Anda dalam promosi dan jaringan. Untuk bisnis berbasis jasa (Ide 4), fokuslah pada kualitas presentasi digital Anda. Untuk ide berbasis produk (Ide 5 & 6), fokuslah pada efisiensi pembelian di pusat grosir.\",\"time\":\"2025-12-17 18:16:49\"},{\"from\":\"user\",\"message\":\"berikan sumber yang akurat\",\"time\":\"2025-12-17 18:17:08\"},{\"from\":\"ai\",\"message\":\"Tentu, sebagai penasihat usaha, saya akan memberikan panduan sumber daya yang akurat dan praktis untuk mendukung ide-ide bisnis *fashion* Anda di Jakarta dengan modal Rp1.000.000. Karena kita berfokus pada penjualan *online* dan efisiensi modal, sumber utama Anda akan datang dari platform digital dan pusat distribusi fisik yang terpercaya.\\n\\n**1. Sumber Bahan Baku dan Stok Barang (Untuk Ide Thrifting, Reseller, atau Distributor Bahan):**\\n\\nUntuk *thrifting* atau mencari bahan baku (Ide 2 & 5), Anda perlu mengunjungi pusat grosir tekstil dan barang bekas di Jakarta. **Tanah Abang** adalah pusat grosir tekstil terbesar dan tempat terbaik untuk mencari kain dalam jumlah kecil hingga besar. Untuk barang bekas berkualitas, cari informasi mengenai lokasi atau *supplier* terpercaya yang sering muncul di komunitas *thrifting* di media sosial; mereka sering mengadakan *live sale* atau membuka gudang di luar area pusat kota untuk efisiensi biaya. Selalu bandingkan harga antar *supplier* sebelum membeli dalam jumlah besar.\\n\\n**2. Platform Penjualan dan Pemasaran Digital:**\\n\\nPlatform adalah \\\"etalase\\\" gratis Anda. Fokuskan energi promosi di **Instagram dan TikTok**. Untuk membangun kepercayaan dan memudahkan transaksi, gunakan **Marketplace lokal terpercaya** seperti Tokopedia atau Shopee. Di sana, Anda bisa membuat toko virtual tanpa biaya sewa. Untuk memudahkan pembayaran, pastikan Anda memiliki rekening bank yang mudah diakses atau gunakan layanan pembayaran digital seperti QRIS.\\n\\n**3. Inspirasi dan Pengembangan Jasa (Untuk Ide Styling):**\\n\\nJika Anda memilih jasa *styling* (Ide 4), sumber akurasi Anda adalah tren terkini. Ikuti akun *fashion editor* atau *stylist* lokal maupun internasional di Instagram dan YouTube. Pelajari cara mereka menyusun *moodboard* dan menggunakan aplikasi perencanaan visual (seperti Pinterest) untuk menyajikan ide kepada klien. Kepercayaan akan datang dari konsistensi visual dan portofolio yang terstruktur, bukan dari sertifikat mahal.\\n\\n**4. Pembelajaran Bisnis dan Legalitas Dasar:**\\n\\nUntuk memastikan bisnis Anda sehat, pelajari dasar-dasar pembukuan sederhana (bisa menggunakan *spreadsheet* gratis). Sumber informasi praktis mengenai perpajakan UMKM dan regulasi dasar di Jakarta sering dibagikan oleh dinas terkait (seperti **Dinas Perindustrian, Perdagangan, Koperasi, dan UKM Provinsi DKI Jakarta**) melalui laman resmi atau akun media sosial mereka. Memahami dasar legalitas akan membuat bisnis Anda lebih kredibel di mata pelanggan.\",\"time\":\"2025-12-17 18:17:12\"},{\"from\":\"user\",\"message\":\"berikan link sumbernya\",\"time\":\"2025-12-17 18:17:34\"},{\"from\":\"ai\",\"message\":\"Saya mengerti bahwa Anda membutuhkan tautan (link) yang lebih spesifik untuk mendukung ide-ide bisnis Anda. Namun, sebagai penasihat yang memberikan saran praktis dan cepat untuk modal Rp1.000.000, sumber daya yang paling relevan seringkali bersifat dinamis (berubah cepat) dan berbasis komunitas di Jakarta. Memberikan satu tautan resmi tunggal untuk setiap kebutuhan spesifik (misalnya, tautan ke semua *supplier* *thrifting* di Jaktim) tidak mungkin dilakukan.\\n\\nBerikut adalah strategi pencarian sumber daya yang akan mengarahkan Anda ke tautan yang paling akurat saat ini:\\n\\n**1. Pusat Grosir Fisik (Tanah Abang & Pasar Tekstil):**\\nAlih-alih mencari tautan toko, fokuslah mencari tautan di **Google Maps** dengan kata kunci seperti \\\"Pusat Grosir Kain Tanah Abang\\\" atau \\\"Distributor Kancing Jakarta\\\". Anda akan menemukan lokasi toko-toko fisik yang relevan. Setelah menemukan lokasinya, cari ulasan dan foto terbaru dari pengguna lain untuk melihat barang apa yang mereka jual saat ini.\\n\\n**2. Komunitas Digital dan *Supplier* Barang Bekas:**\\nUntuk *thrifting* atau *reseller* produk lokal (Ide 1 & 3), sumber terbaik adalah **Instagram dan Facebook Groups**. Cari grup dengan nama seperti \\\"Komunitas Thrifting Jakarta\\\" atau gunakan tagar seperti #SupplierBajuJakarta. Di dalam grup-grup ini, para *supplier* sering mempromosikan stok terbaru mereka melalui unggahan atau sesi *live selling* yang secara otomatis menyertakan informasi kontak WhatsApp atau tautan toko *marketplace* mereka.\\n\\n**3. Promosi dan Jasa (Ide 4):**\\nUntuk jasa *styling* dan portofolio, sumber belajar terbaik Anda adalah **YouTube** dan **Pinterest**. Cari tutorial dengan kata kunci seperti \\\"Cara Membuat Moodboard Fashion\\\" atau \\\"Ide Konten OOTD TikTok\\\". Platform ini memberikan contoh visual terbaik untuk membangun portofolio Anda tanpa biaya.\\n\\n**4. Informasi Resmi dan UMKM DKI Jakarta:**\\nUntuk panduan legalitas dasar, perpajakan UMKM, dan pelatihan gratis dari pemerintah daerah, cari laman resmi **Dinas Koperasi, Usaha Kecil dan Menengah Provinsi DKI Jakarta** atau **Portal Layanan Terpadu UMKM Jakarta**. Mereka sering mengunggah informasi tentang program pendampingan atau pendaftaran usaha mikro secara berkala.\\n\\nIntinya, dengan modal terbatas, sumber daya terbaik Anda adalah informasi *real-time* yang ada di platform sosial dan mesin pencari, yang Anda gunakan untuk memvalidasi lokasi fisik terdekat atau kontak *supplier* yang aktif hari ini. Selamat berburu sumber!\",\"time\":\"2025-12-17 18:17:37\"}]', '2025-12-18 00:15:57'),
(18, 15, 10000000.00, 'yogyakarta', 'fashion', 'Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nTren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.\n\nBangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"berikan ide bisnis sesuai dengan modal dan lokasi saya\",\"time\":\"2025-12-18 09:56:42\"},{\"from\":\"ai\",\"message\":\"Selamat, modal Rp10 juta di Yogyakarta adalah titik awal yang sangat baik untuk bisnis *fashion*! Yogyakarta punya pasar yang dinamis, dari mahasiswa hingga turis. Dengan modal tersebut, fokuslah pada model bisnis yang meminimalkan risiko sewa tempat permanen di awal, seperti *reseller premium* atau bisnis *pre-order* berbasis digital.\\n\\nIde yang paling praktis adalah mendirikan bisnis **Thrifting *Exclusive*** atau **Fashion *Upcycling* Terkurasi**. Daripada menjual pakaian bekas secara massal, fokuslah pada kurasi baju-baju unik (misalnya *vintage* Amerika atau gaya Korea) yang sudah Anda cuci bersih dan perbaiki. Modal Rp10 juta bisa dialokasikan untuk pembelian stok awal (sekitar Rp5 juta), biaya *laundry* dan perbaikan kecil, serta pembuatan konten foto produk yang profesional di studio mini rumah Anda (sisa modal).\\n\\nAlternatif yang lebih berorientasi produk baru adalah **Aksesoris Custom Batik\\/Tenun Digital**. Yogyakarta adalah jantungnya batik. Daripada membuat kain utuh yang mahal, gunakan modal Anda untuk membeli kain perca atau stok kain kecil berkualitas, lalu desain dan cetak menjadi produk *fashion* bernilai jual tinggi seperti *tote bag* modern, *clutch*, atau *headband*. Ini sangat menarik bagi segmen turis dan mahasiswa yang mencari *fashion* etnik kontemporer.\\n\\nPemasaran harus difokuskan sepenuhnya secara *online* dan melalui *pop-up event* kecil. Manfaatkan Instagram dan TikTok untuk menunjukkan proses kurasi atau *styling* produk Anda. Karena Anda berlokasi di Jogja, lakukan kolaborasi dengan *micro-influencer* lokal atau buka *booth* kecil di acara kampus atau bazar akhir pekan. Pendekatan ini membuat modal Anda efisien dan pengembaliannya cepat terlihat.\",\"time\":\"2025-12-18 09:56:47\"}]', '2025-12-18 15:56:06');
INSERT INTO `al_advisor` (`id_ide`, `id_user`, `modal`, `lokasi`, `minat`, `rekomendasi`, `riwayat_chat`, `created_at`) VALUES
(19, 15, 5000000.00, 'yogyakarta', 'kuliner', 'Dengan modal Rp 5.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"berikan ide bisnisnya\",\"time\":\"2025-12-18 10:48:50\"},{\"from\":\"ai\",\"message\":\"Halo! Dengan modal Rp 5.000.000 dan lokasi di Yogyakarta, Anda punya peluang besar di kuliner. Mengingat modal yang terbatas, fokus pada konsep yang *niche* (spesifik) dan mudah dipasarkan secara *online* atau *pre-order* akan sangat membantu.\\n\\n**Ide Bisnis yang Bisa Dicoba:** **\\\"Sambal Nusantara Kemasan Premium\\\"**. Jogja adalah surganya kuliner dengan beragam pendamping makanan, dan sambal adalah salah satunya. Anda bisa fokus membuat 2-3 varian sambal andalan (misalnya, Sambal Bawang Goreng ala Jogja, Sambal Matah Bali, atau Sambal Ijo Padang) yang dikemas dalam botol kaca kecil yang menarik. Modal Rp 5 Juta bisa dialokasikan untuk bahan baku awal, desain label yang menarik, sekitar 100-150 botol kemasan, dan sedikit biaya promosi digital.\\n\\n**Strategi Praktis:** Jualannya bisa dimulai melalui Instagram dan layanan pesan antar lokal. Karena produk Anda tahan lama (awet), Anda bisa menjangkau pembeli di luar Jogja melalui jasa kirim. Manfaatkan momen makan siang atau makan malam dengan menawarkan paket *bundling* bersama lauk pendamping sederhana jika memungkinkan, atau fokuskan promosi pada pekerja kantoran dan mahasiswa yang ingin menambah \'nendang\' masakan rumahan mereka.\\n\\n**Variasi Kreatif Lain:** Jika sambal terasa terlalu umum, pertimbangkan **\\\"Minuman Herbal Tradisional Kekinian (Jamu Dingin)\\\".** Jogja kental dengan tradisi jamu. Anda bisa memodernisasinya menjadi minuman dingin menyegarkan seperti Kunyit Asam, Beras Kencur, atau Wedang Jahe dikemas dalam botol *sleek*. Permintaan akan minuman sehat sedang tinggi, dan modal Anda sangat cukup untuk membeli bahan baku segar dan botol *custom* minimalis.\\n\\nApapun pilihan Anda, kuncinya adalah konsisten menjaga rasa dan kualitas kemasan agar terlihat profesional sejak awal. Selamat mencoba!\",\"time\":\"2025-12-18 10:48:55\"}]', '2025-12-18 16:48:37'),
(20, 8, 10000000.00, 'jakarta', 'kuliner', 'Dengan modal Rp 10.000.000, Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.\n\nUntuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.\n\nManfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.\n\nBuat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.\n\nSelalu catat setiap transaksi untuk monitoring performa bisnis Anda.', '[{\"from\":\"user\",\"message\":\"berikan ide bisnisnya\",\"time\":\"2025-12-19 13:16:07\"},{\"from\":\"ai\",\"message\":\"Dengan modal Rp 10 juta di Jakarta dan minat di bidang kuliner, fokuslah pada konsep yang cepat laku, modal operasional terkontrol, dan memanfaatkan platform pesan antar. Salah satu ide yang sangat menjanjikan adalah **\\\"Rice Bowl Spesialis Sambal Nusantara\\\"**.\\n\\nKonsep ini sangat fleksibel. Anda bisa memulainya dengan 3-4 varian lauk (misalnya Ayam Geprek Level Pedas, Ikan Asin Cabe Ijo, dan Tempe Teri) yang dipadukan dengan nasi hangat dan sambal khas daerah (Sambal Matah Bali, Sambal Terasi Jawa, Sambal Dabu-Dabu Manado). Modal Rp 10 juta cukup dialokasikan untuk pembelian peralatan dapur minimal (rice cooker besar, kompor gas 1 tungku, pisau berkualitas), stok bahan baku awal yang segar, serta biaya branding sederhana (banner kecil dan kemasan ramah pengiriman).\\n\\nFokus utama Anda adalah efisiensi dapur dan pemasaran digital. Karena beroperasi di Jakarta, Anda harus mengoptimalkan GoFood\\/GrabFood. Pastikan foto produk terlihat menggugah selera, dan deskripsi menu menonjolkan keunikan sambal Anda. Awalnya, Anda bisa beroperasi dari dapur rumah (sistem *cloud kitchen* rumahan) untuk menekan biaya sewa tempat.\\n\\nStrategi pertumbuhan cepat adalah menjaga konsistensi rasa dan kecepatan pengiriman. Setelah stabil, kembangkan dengan menu \'Sambal of the Month\' atau paket bundling makan siang kantor. Keunggulan produk Anda adalah rasa pedas otentik yang dicari banyak orang Jakarta, dan kemasan yang mudah dibawa.\\n\\nDengan strategi ini, fokus pada *takeaway* dan pengiriman memungkinkan Anda mencapai BEP lebih cepat dibandingkan membuka tempat makan fisik, menjadikan ide ini realistis dan praktis dengan modal yang tersedia.\",\"time\":\"2025-12-19 13:16:15\"}]', '2025-12-19 19:15:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `analisis_produk`
--

CREATE TABLE `analisis_produk` (
  `id_produk` int(11) NOT NULL,
  `id_user` int(8) UNSIGNED NOT NULL,
  `nama_produk` varchar(250) DEFAULT NULL,
  `analisis` text DEFAULT NULL,
  `penjualan` decimal(14,2) DEFAULT NULL,
  `biaya_produksi` decimal(14,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kalkulator_hpp`
--

CREATE TABLE `kalkulator_hpp` (
  `id_hpp` int(11) NOT NULL,
  `id_user` int(8) UNSIGNED NOT NULL,
  `bahan` decimal(14,2) DEFAULT NULL,
  `tenaga_kerja` decimal(14,2) DEFAULT NULL,
  `total_biaya` decimal(18,2) DEFAULT NULL,
  `harga_jual` decimal(18,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `manajemen_risiko`
--

CREATE TABLE `manajemen_risiko` (
  `id_risiko` int(11) NOT NULL,
  `id_user` int(8) UNSIGNED NOT NULL,
  `jenis_usaha` varchar(100) DEFAULT NULL,
  `daftar_risiko` text DEFAULT NULL,
  `rekomendasi_mitigasi` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pencatatan_keuangan`
--

CREATE TABLE `pencatatan_keuangan` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(8) UNSIGNED NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `nominal` decimal(18,2) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `subscription`
--

CREATE TABLE `subscription` (
  `id_subs` int(11) NOT NULL,
  `id_user` int(8) UNSIGNED NOT NULL,
  `paket` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tgl_aktif` date DEFAULT NULL,
  `tgl_expired` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(8) UNSIGNED NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `oauth_provider` enum('local','google') DEFAULT 'local',
  `avatar_url` varchar(500) DEFAULT NULL,
  `nama` varchar(200) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_usaha` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `google_id`, `oauth_provider`, `avatar_url`, `nama`, `role`, `email`, `password`, `nama_usaha`, `created_at`) VALUES
(1, NULL, 'local', NULL, 'Administrator', 'admin', 'admin@example.com', '$2y$10$examplehashplaceholder', 'AdminUsaha', '2025-12-03 07:48:36'),
(3, NULL, 'local', NULL, 'Kris', 'user', 'admin@mail.com', '$2y$10$N489Mv6gDwI.23ubVN7c/Oko1OUSECIAD1pVWprtJTLikubhQwCB.', 'usahain', '2025-12-05 15:43:24'),
(4, NULL, 'local', NULL, 'Tasya', 'user', 'usahain@gmail.com', '$2y$10$8EasDzI5wtERyuG05nj10.MsNRAQYsY010dS2Vv1GRvGxQlVuf2he', 'usahain', '2025-12-09 11:32:20'),
(5, NULL, 'local', NULL, 'Ibu Achi', 'user', 'ibuachi@gmail.com', '$2y$10$80HsFjzKJURAswiQed0fXO11lnbXyV4.RcOTM0sN1zAsLkbJ.VgTu', 'Digital ', '2025-12-09 12:05:57'),
(6, NULL, 'local', NULL, 'kriss', 'user', 'kris@gmail.com', '$2y$10$hePU/vkh78IP63jfVElPIeQW5M2VV.oYoBda8Fl.HiT23wdkNqkjC', '-', '2025-12-10 08:14:40'),
(7, NULL, 'local', NULL, 'Tasya', 'user', 'tasya@gmail.com', '$2y$10$H/cfa4x/pxSylkbaKk./QuonkY.467BidyBs3BPpZ.6RXbc11tTLG', 'fashion', '2025-12-11 16:36:43'),
(8, NULL, 'local', NULL, 'Melanie', 'user', 'kriz@gmail.com', '$2y$10$I.IXQiMXSfvnHrohNYgN0OPpbjHFIIoQJvCyMj8Cpvn76fVJyPNBi', 'Usahain', '2025-12-16 10:10:15'),
(9, NULL, 'local', NULL, 'syasya', 'user', 'sya@gmail.com', '$2y$10$hX8KWnt82O.uUTlnOQsoGuOcWzPO/eefmhjjkM8q.Av4iwN8PX0nO', 'milo', '2025-12-16 11:56:43'),
(10, NULL, 'local', NULL, 'Guest-1765932945', 'user', NULL, '$2y$10$ZrHrHZR5Lw0.RALYr8D6oeYrgCOwO7jmKzvstMLa9JID.VPnpR8Lu', NULL, '2025-12-17 07:55:45'),
(11, NULL, 'local', NULL, 'Guest-1765969620', 'user', NULL, '$2y$10$PEs03QpZd67CrC1ItoLcBOI163YTOOW/V/Dn8zBqZ/7ZRb9LGTTi2', NULL, '2025-12-17 18:07:00'),
(12, NULL, 'local', NULL, 'Guest-1765986710', 'user', NULL, '$2y$10$gspmDzDQMd8TVtGtWIYKPOzcxvFYa12h5EKS9ZTJQpXsrpsXP15/W', NULL, '2025-12-17 22:51:50'),
(13, '114320042028976533661', 'google', 'https://lh3.googleusercontent.com/a/ACg8ocKmRGGFDTnENIjrcY4YeMz-iv5y6lCw3xIyql1hVcQvxa5q8w=s96-c', 'LINDA DAVID 23.12.3020', 'user', 'lindadavid@students.amikom.ac.id', NULL, NULL, '2025-12-18 00:04:58'),
(14, '117133254259408285080', 'google', 'https://lh3.googleusercontent.com/a/ACg8ocK4Ud-Ae0Seadva2IShRDcchpXXXIR3VjQ43lUoLP9AL7TpTw=s96-c', 'MARIA KRISTINA SURYATI 23.12.3028', 'user', 'mariakristinasuryati@students.amikom.ac.id', NULL, NULL, '2025-12-18 00:38:59'),
(15, '117514029875026621548', 'google', 'https://lh3.googleusercontent.com/a/ACg8ocK4yM5EvBfCTTPG8zxttP5pL9TzqpZNH9Rvbzr-NAmJ_ECIg32y=s96-c', 'TASYA ANGGRAENI FIRDAUS 23.12.2987', 'user', 'tasyaanggraenif@students.amikom.ac.id', NULL, NULL, '2025-12-18 15:55:15');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `al_advisor`
--
ALTER TABLE `al_advisor`
  ADD PRIMARY KEY (`id_ide`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `analisis_produk`
--
ALTER TABLE `analisis_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `kalkulator_hpp`
--
ALTER TABLE `kalkulator_hpp`
  ADD PRIMARY KEY (`id_hpp`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `manajemen_risiko`
--
ALTER TABLE `manajemen_risiko`
  ADD PRIMARY KEY (`id_risiko`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pencatatan_keuangan`
--
ALTER TABLE `pencatatan_keuangan`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id_subs`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`),
  ADD KEY `idx_google_id` (`google_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `al_advisor`
--
ALTER TABLE `al_advisor`
  MODIFY `id_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `analisis_produk`
--
ALTER TABLE `analisis_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kalkulator_hpp`
--
ALTER TABLE `kalkulator_hpp`
  MODIFY `id_hpp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `manajemen_risiko`
--
ALTER TABLE `manajemen_risiko`
  MODIFY `id_risiko` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pencatatan_keuangan`
--
ALTER TABLE `pencatatan_keuangan`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id_subs` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `al_advisor`
--
ALTER TABLE `al_advisor`
  ADD CONSTRAINT `al_advisor_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `analisis_produk`
--
ALTER TABLE `analisis_produk`
  ADD CONSTRAINT `analisis_produk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kalkulator_hpp`
--
ALTER TABLE `kalkulator_hpp`
  ADD CONSTRAINT `kalkulator_hpp_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `manajemen_risiko`
--
ALTER TABLE `manajemen_risiko`
  ADD CONSTRAINT `manajemen_risiko_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pencatatan_keuangan`
--
ALTER TABLE `pencatatan_keuangan`
  ADD CONSTRAINT `pencatatan_keuangan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
