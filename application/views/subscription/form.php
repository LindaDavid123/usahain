<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($subscription) ? 'Edit Subscription' : 'Tambah Subscription'; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .navbar { background: #333; color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; margin-bottom: 20px; }
        .navbar a { color: #fff; text-decoration: none; margin-left: 15px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #333; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #007bff; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; margin-top: 20px; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #5a6268; }
        .error { color: #dc3545; font-size: 12px; margin-top: 3px; }
        .validation-errors { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2><?php echo isset($subscription) ? 'Edit Subscription' : 'Tambah Subscription'; ?></h2>
        <a href="<?php echo site_url('subscription'); ?>">&larr; Kembali</a>
    </div>

    <div class="container">
        <?php if (validation_errors()): ?>
            <div class="validation-errors"><?php echo validation_errors(); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="paket">Paket *</label>
                <select id="paket" name="paket" required>
                    <option value="">-- Pilih Paket --</option>
                    <option value="basic" <?php echo (isset($subscription) && $subscription->paket === 'basic') ? 'selected' : ''; ?>>Basic</option>
                    <option value="pro" <?php echo (isset($subscription) && $subscription->paket === 'pro') ? 'selected' : ''; ?>>Pro</option>
                    <option value="enterprise" <?php echo (isset($subscription) && $subscription->paket === 'enterprise') ? 'selected' : ''; ?>>Enterprise</option>
                </select>
            </div>

            <?php if (isset($subscription)): ?>
            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active" <?php echo ($subscription->status === 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($subscription->status === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    <option value="expired" <?php echo ($subscription->status === 'expired') ? 'selected' : ''; ?>>Expired</option>
                </select>
            </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="tgl_aktif">Tanggal Aktif *</label>
                <input type="date" id="tgl_aktif" name="tgl_aktif" value="<?php echo isset($subscription) ? $subscription->tgl_aktif : set_value('tgl_aktif'); ?>" required>
            </div>

            <div class="form-group">
                <label for="tgl_expired">Tanggal Kadaluarsa *</label>
                <input type="date" id="tgl_expired" name="tgl_expired" value="<?php echo isset($subscription) ? $subscription->tgl_expired : set_value('tgl_expired'); ?>" required>
            </div>

            <button type="submit" class="btn">Simpan</button>
            <a href="<?php echo site_url('subscription'); ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
