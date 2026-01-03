<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus User</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .warning { background: #fff3cd; border: 1px solid #ffc107; color: #856404; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .user-info { background: #f8f9fa; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545; }
        .user-info p { margin-bottom: 5px; }
        .btn { display: inline-block; padding: 10px 20px; background: #dc3545; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        .btn:hover { background: #c82333; }
        .btn-cancel { background: #6c757d; }
        .btn-cancel:hover { background: #5a6268; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo site_url('user'); ?>" class="back-link">&larr; Kembali ke Daftar User</a>
        <h1>Konfirmasi Hapus User</h1>

        <div class="warning">
            <strong>⚠️ Peringatan!</strong> Aksi ini tidak dapat dibatalkan. User berikut akan dihapus secara permanen:
        </div>

        <div class="user-info">
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($user->nama); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($user->role); ?></p>
        </div>

        <form method="post" style="display: inline;">
            <button type="submit" class="btn">Ya, Hapus Sekarang</button>
        </form>
        <a href="<?php echo site_url('user'); ?>" class="btn btn-cancel">Batal</a>
    </div>
</body>
</html>
