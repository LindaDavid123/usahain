<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
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
        .actions { text-align: center; }
        .empty { color: #666; font-style: italic; text-align: center; padding: 40px 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar User</h1>
        <a href="<?php echo site_url('user/create'); ?>" class="btn">Tambah User Baru</a>

        <?php if (!empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Nama Usaha</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user->id_user; ?></td>
                            <td><?php echo htmlspecialchars($user->nama); ?></td>
                            <td><?php echo htmlspecialchars($user->email); ?></td>
                            <td><?php echo htmlspecialchars($user->role); ?></td>
                            <td><?php echo htmlspecialchars($user->nama_usaha ?? '-'); ?></td>
                            <td class="actions">
                                <a href="<?php echo site_url('user/view/' . $user->id_user); ?>" class="btn">Lihat</a>
                                <a href="<?php echo site_url('user/edit/' . $user->id_user); ?>" class="btn btn-edit">Edit</a>
                                <a href="<?php echo site_url('user/delete/' . $user->id_user); ?>" class="btn btn-delete">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">
                <p>Tidak ada user ditemukan. <a href="<?php echo site_url('user/create'); ?>">Buat user baru</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
