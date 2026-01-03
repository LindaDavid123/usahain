<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .navbar { background: #333; color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .navbar a { color: #fff; text-decoration: none; margin-left: 15px; }
        .container { max-width: 900px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; margin-bottom: 20px; }
        .btn:hover { background: #0056b3; }
        .btn-edit { background: #28a745; }
        .btn-edit:hover { background: #218838; }
        .btn-delete { background: #dc3545; }
        .btn-delete:hover { background: #c82333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; }
        tr:hover { background: #f5f5f5; }
        .empty { text-align: center; padding: 40px; color: #666; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Subscription</h2>
        <div>
            <a href="<?php echo site_url('auth/dashboard'); ?>">Dashboard</a>
            <a href="<?php echo site_url('auth/logout'); ?>">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Data Subscription Saya</h1>
        <a href="<?php echo site_url('subscription/create'); ?>" class="btn">Tambah Subscription</a>

        <?php if (!empty($subscriptions)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paket</th>
                        <th>Status</th>
                        <th>Tgl Aktif</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscriptions as $s): ?>
                        <tr>
                            <td><?php echo $s->id_subs; ?></td>
                            <td><?php echo htmlspecialchars($s->paket); ?></td>
                            <td><?php echo htmlspecialchars($s->status); ?></td>
                            <td><?php echo $s->tgl_aktif; ?></td>
                            <td><?php echo $s->tgl_expired; ?></td>
                            <td>
                                <a href="<?php echo site_url('subscription/view/' . $s->id_subs); ?>" class="btn">Lihat</a>
                                <a href="<?php echo site_url('subscription/edit/' . $s->id_subs); ?>" class="btn btn-edit">Edit</a>
                                <a href="<?php echo site_url('subscription/delete/' . $s->id_subs); ?>" class="btn btn-delete">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">
                <p>Belum ada subscription. <a href="<?php echo site_url('subscription/create'); ?>">Buat baru</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
