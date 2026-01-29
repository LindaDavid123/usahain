<?php
/**
 * Quick table creation script for pencatatan_keuangan
 * Run this file once in your browser to create the missing table
 */

// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'usahain_db';

try {
    // Connect to MySQL
    $conn = new mysqli($host, $user, $password, $database);
    
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS `pencatatan_keuangan` (
      `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
      `id_user` int(8) UNSIGNED NOT NULL,
      `kategori` varchar(100) DEFAULT NULL,
      `jenis` varchar(50) DEFAULT NULL,
      `nominal` decimal(18,2) DEFAULT NULL,
      `tanggal` date DEFAULT NULL,
      `catatan` text DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id_transaksi`),
      KEY `id_user` (`id_user`),
      CONSTRAINT `pencatatan_keuangan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    if ($conn->query($sql) === TRUE) {
        echo "<h2 style='color: green;'>✓ Tabel pencatatan_keuangan berhasil dibuat!</h2>";
        echo "<p>Anda dapat menghapus file ini (create_table.php)</p>";
    } else {
        echo "<h2 style='color: red;'>Error membuat tabel:</h2>";
        echo "<p>" . $conn->error . "</p>";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
