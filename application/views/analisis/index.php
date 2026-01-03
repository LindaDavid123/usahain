<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Produk</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .navbar { background: #333; color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .navbar a { color: #fff; text-decoration: none; margin-left: 15px; }
        .container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; margin-bottom: 20px; }
        .btn:hover { background: #0056b3; }
        .btn-edit { background: #28a745; }
        .btn-edit:hover { background: #218838; }
        .btn-delete { background: #dc3545; }
        .btn-delete:hover { background: #c82333; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; }
        tr:hover { background: #f5f5f5; }
        .empty { text-align: center; padding: 40px; color: #666; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Analisis Produk</h2>
        <div>
            <a href="<?php echo site_url('auth/dashboard'); ?>">Dashboard</a>
            <a href="<?php echo site_url('auth/logout'); ?>">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Data Analisis Produk Saya</h1>
        <a href="<?php echo site_url('analisis/create'); ?>" class="btn">Tambah Analisis</a>

        <?php if (!empty($produk_list)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Penjualan</th>
                        <th>Biaya Produksi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produk_list as $p): ?>
                        <tr>
                            <td><?php echo $p->id_produk; ?></td>
                            <td><?php echo htmlspecialchars($p->nama_produk); ?></td>
                            <td>Rp <?php echo number_format($p->penjualan, 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($p->biaya_produksi, 0, ',', '.'); ?></td>
                            <td><?php echo $p->created_at; ?></td>
                            <td>
                                <a href="<?php echo site_url('analisis/view/' . $p->id_produk); ?>" class="btn">Lihat</a>
                                <a href="<?php echo site_url('analisis/edit/' . $p->id_produk); ?>" class="btn btn-edit">Edit</a>
                                <a href="<?php echo site_url('analisis/delete/' . $p->id_produk); ?>" class="btn btn-delete">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">
                <p>Belum ada data analisis produk. <a href="<?php echo site_url('analisis/create'); ?>">Buat baru</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
