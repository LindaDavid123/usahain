<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat User</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .info-row { display: flex; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .info-label { font-weight: bold; min-width: 150px; color: #555; }
        .info-value { color: #333; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; margin-top: 20px; }
        .btn:hover { background: #0056b3; }
        .btn-edit { background: #28a745; }
        .btn-edit:hover { background: #218838; }
        .btn-delete { background: #dc3545; }
        .btn-delete:hover { background: #c82333; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo site_url('user'); ?>" class="back-link">&larr; Kembali ke Daftar User</a>
        <h1>Detail User</h1>

        <div class="info-row">
            <div class="info-label">ID User:</div>
            <div class="info-value"><?php echo htmlspecialchars($user->id_user); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Nama:</div>
            <div class="info-value"><?php echo htmlspecialchars($user->nama); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value"><?php echo htmlspecialchars($user->email); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Role:</div>
            <div class="info-value"><?php echo htmlspecialchars($user->role); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Nama Usaha:</div>
            <div class="info-value"><?php echo htmlspecialchars($user->nama_usaha ?? '-'); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Dibuat:</div>
            <div class="info-value"><?php echo $user->created_at ?? '-'; ?></div>
        </div>

        <div>
            <a href="<?php echo site_url('user/edit/' . $user->id_user); ?>" class="btn btn-edit">Edit</a>
            <a href="<?php echo site_url('user/delete/' . $user->id_user); ?>" class="btn btn-delete">Hapus</a>
        </div>
    </div>
</body>
</html>
