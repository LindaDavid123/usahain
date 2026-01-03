<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($produk) ? 'Edit Analisis' : 'Tambah Analisis'; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .navbar { background: #333; color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; margin-bottom: 20px; }
        .navbar a { color: #fff; text-decoration: none; margin-left: 15px; }
        .container { max-width: 700px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #333; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; }
        input:focus, textarea:focus { outline: none; border-color: #007bff; }
        textarea { resize: vertical; min-height: 100px; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; margin-top: 20px; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #5a6268; }
        .validation-errors { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2><?php echo isset($produk) ? 'Edit Analisis' : 'Tambah Analisis'; ?></h2>
        <a href="<?php echo site_url('analisis'); ?>">&larr; Kembali</a>
    </div>

    <div class="container">
        <?php if (validation_errors()): ?>
            <div class="validation-errors"><?php echo validation_errors(); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="nama_produk">Nama Produk *</label>
                <input type="text" id="nama_produk" name="nama_produk" value="<?php echo isset($produk) ? htmlspecialchars($produk->nama_produk) : set_value('nama_produk'); ?>" required>
            </div>

            <div class="form-group">
                <label for="penjualan">Penjualan (Rp) *</label>
                <input type="number" id="penjualan" name="penjualan" step="0.01" value="<?php echo isset($produk) ? $produk->penjualan : set_value('penjualan'); ?>" required>
            </div>

            <div class="form-group">
                <label for="biaya_produksi">Biaya Produksi (Rp) *</label>
                <input type="number" id="biaya_produksi" name="biaya_produksi" step="0.01" value="<?php echo isset($produk) ? $produk->biaya_produksi : set_value('biaya_produksi'); ?>" required>
            </div>

            <div class="form-group">
                <label for="analisis">Analisis *</label>
                <textarea id="analisis" name="analisis" required><?php echo isset($produk) ? htmlspecialchars($produk->analisis) : set_value('analisis'); ?></textarea>
            </div>

            <button type="submit" class="btn">Simpan</button>
            <a href="<?php echo site_url('analisis'); ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
