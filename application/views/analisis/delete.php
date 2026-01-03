<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus Analisis</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .navbar { background: #333; color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; margin-bottom: 20px; }
        .navbar a { color: #fff; text-decoration: none; margin-left: 15px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .warning { background: #fff3cd; border: 1px solid #ffc107; color: #856404; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .info { background: #f8f9fa; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .info p { margin: 5px 0; }
        .btn { display: inline-block; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; margin-right: 10px; margin-top: 20px; }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-danger:hover { background: #c82333; }
        .btn-secondary { background: #6c757d; color: #fff; }
        .btn-secondary:hover { background: #5a6268; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Hapus Analisis Produk</h2>
        <a href="<?php echo site_url('analisis'); ?>">&larr; Kembali</a>
    </div>

    <div class="container">
        <h1>Konfirmasi Hapus Analisis Produk</h1>

        <div class="warning">
            <strong>⚠️ Peringatan!</strong> Data analisis produk berikut akan dihapus secara permanen:
        </div>

        <div class="info">
            <p><strong>Nama Produk:</strong> <?php echo htmlspecialchars($produk->nama_produk); ?></p>
            <p><strong>Penjualan:</strong> Rp <?php echo number_format($produk->penjualan, 0, ',', '.'); ?></p>
            <p><strong>Biaya Produksi:</strong> Rp <?php echo number_format($produk->biaya_produksi, 0, ',', '.'); ?></p>
        </div>

        <form method="post" style="display: inline;">
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
        <a href="<?php echo site_url('analisis'); ?>" class="btn btn-secondary">Batal</a>
    </div>
</body>
</html>
