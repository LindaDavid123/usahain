<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($user) ? 'Edit User' : 'Tambah User'; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #333; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #007bff; box-shadow: 0 0 5px rgba(0, 123, 255, 0.25); }
        .error { color: #dc3545; font-size: 12px; margin-top: 3px; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #5a6268; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo site_url('user'); ?>" class="back-link">&larr; Kembali ke Daftar User</a>
        <h1><?php echo isset($user) ? 'Edit User' : 'Tambah User Baru'; ?></h1>

        <?php if ($this->form_validation->run() === FALSE): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="nama">Nama *</label>
                <input type="text" id="nama" name="nama" value="<?php echo isset($user) ? htmlspecialchars($user->nama) : set_value('nama'); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?php echo isset($user) ? htmlspecialchars($user->email) : set_value('email'); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password <?php echo isset($user) ? '(biarkan kosong jika tidak ingin mengubah)' : '*'; ?></label>
                <input type="password" id="password" name="password" <?php echo !isset($user) ? 'required' : ''; ?>>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role">
                    <option value="user" <?php echo (isset($user) && $user->role === 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo (isset($user) && $user->role === 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nama_usaha">Nama Usaha</label>
                <input type="text" id="nama_usaha" name="nama_usaha" value="<?php echo isset($user) ? htmlspecialchars($user->nama_usaha ?? '') : set_value('nama_usaha'); ?>">
            </div>

            <div>
                <button type="submit" class="btn">Simpan</button>
                <a href="<?php echo site_url('user'); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
