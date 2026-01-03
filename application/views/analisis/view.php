<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Analisis Produk</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .navbar { background: #333; color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; margin-bottom: 20px; }
        .navbar a { color: #fff; text-decoration: none; margin-left: 15px; }
        .container { max-width: 700px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .info-row { display: flex; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
        .info-label { font-weight: bold; min-width: 150px; color: #555; }
        .info-value { color: #333; flex: 1; }
        .analysis-box { background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0; border-radius: 4px; }
        .btn { display: inline-block; padding: 10px 20px; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; margin-top: 20px; }
        .btn-primary { background: #007bff; color: #fff; }
        .btn-primary:hover { background: #0056b3; }
        .btn-edit { background: #28a745; color: #fff; }
        .btn-edit:hover { background: #218838; }
        .btn-delete { background: #dc3545; color: #fff; }
        .btn-delete:hover { background: #c82333; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Detail Analisis Produk</h2>
        <a href="<?php echo site_url('analisis'); ?>">&larr; Kembali</a>
    </div>

    <div class="container">
        <h1>Detail Analisis Produk</h1>

        <div class="info-row">
            <div class="info-label">ID:</div>
            <div class="info-value"><?php echo $produk->id_produk; ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Nama Produk:</div>
            <div class="info-value"><?php echo htmlspecialchars($produk->nama_produk); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Penjualan:</div>
            <div class="info-value">Rp <?php echo number_format($produk->penjualan, 0, ',', '.'); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Biaya Produksi:</div>
            <div class="info-value">Rp <?php echo number_format($produk->biaya_produksi, 0, ',', '.'); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Margin Keuntungan:</div>
            <div class="info-value">Rp <?php echo number_format($produk->penjualan - $produk->biaya_produksi, 0, ',', '.'); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Tanggal Dibuat:</div>
            <div class="info-value"><?php echo $produk->created_at; ?></div>
        </div>

        <div class="analysis-box">
            <strong>Analisis:</strong>
            <p><?php echo nl2br(htmlspecialchars($produk->analisis)); ?></p>
        </div>

        <div>
            <a href="<?php echo site_url('analisis/edit/' . $produk->id_produk); ?>" class="btn btn-edit">Edit</a>
            <a href="<?php echo site_url('analisis/delete/' . $produk->id_produk); ?>" class="btn btn-delete">Hapus</a>
        </div>
    </div>
</body>
</html>
