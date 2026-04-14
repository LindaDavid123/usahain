<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$admin_user = array_merge([
    'nama' => 'Administrator',
    'email' => 'admin@usahain.com',
], (array) ($admin_user ?? []));
$back_url = (string) ($back_url ?? site_url('admin/users'));
$form = array_merge([
    'nama' => '',
    'email' => '',
    'nama_usaha' => '',
    'jenis_usaha' => '',
    'password' => '',
], (array) ($form ?? []));
$flash_success = $this->session->flashdata('success');
$flash_error = $this->session->flashdata('error');
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Tambah Pengguna - Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root { --primary:#1c6494; --text:#111827; --muted:#6b7280; --border:#e5e7eb; --bg:#f8fafc; }
* { box-sizing:border-box; margin:0; padding:0; }
body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); }
.container { max-width:860px; margin:24px auto; padding:0 16px; }
.topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
.title { font-size:20px; font-weight:700; color:var(--primary); }
.back { text-decoration:none; font-size:13px; font-weight:600; color:#374151; border:1px solid var(--border); border-radius:8px; padding:8px 10px; background:#fff; }
.card { background:#fff; border:1px solid var(--border); border-radius:12px; padding:20px; }
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group label { font-size:12px; color:#374151; font-weight:600; }
.form-input {
    height: 40px;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0 11px;
    font-size: 13px;
    color: #111827;
    background: #fff;
}
.helper { margin-top: 8px; font-size: 12px; color: var(--muted); }
.form-actions { margin-top: 14px; display:flex; gap:8px; align-items:center; }
.btn {
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 9px 12px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    background: #fff;
    color: #374151;
}
.btn.primary { border-color: var(--primary); background: var(--primary); color: #fff; }
.alert {
    margin-bottom: 12px;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 13px;
    font-weight: 500;
}
.alert.success { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
.alert.error { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }
@media (max-width: 700px) { .form-grid { grid-template-columns:1fr; } }
</style>
</head>
<body>
<div class="container">
    <div class="topbar">
        <h1 class="title">Tambah Pengguna</h1>
        <a href="<?= htmlspecialchars($back_url); ?>" class="back">Kembali</a>
    </div>

    <?php if (!empty($flash_success)): ?><div class="alert success"><?= htmlspecialchars((string) $flash_success); ?></div><?php endif; ?>
    <?php if (!empty($flash_error)): ?><div class="alert error"><?= htmlspecialchars((string) $flash_error); ?></div><?php endif; ?>

    <section class="card">
        <form method="post" action="<?= site_url('admin/store_user'); ?>">
            <input type="hidden" name="return_url" value="<?= htmlspecialchars($back_url); ?>">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-input" value="<?= htmlspecialchars((string) $form['nama']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-input" value="<?= htmlspecialchars((string) $form['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama Usaha</label>
                    <input type="text" name="nama_usaha" class="form-input" value="<?= htmlspecialchars((string) $form['nama_usaha']); ?>">
                </div>
                <div class="form-group">
                    <label>Jenis Usaha</label>
                    <input type="text" name="jenis_usaha" class="form-input" value="<?= htmlspecialchars((string) $form['jenis_usaha']); ?>">
                </div>
                <div class="form-group">
                    <label>Password (opsional)</label>
                    <input type="text" name="password" class="form-input" value="<?= htmlspecialchars((string) $form['password']); ?>" placeholder="Kosongkan untuk default">
                    <p class="helper">Default password: User@12345 (jika dikosongkan)</p>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn primary">Simpan Pengguna</button>
            </div>
        </form>
    </section>
</div>
</body>
</html>
