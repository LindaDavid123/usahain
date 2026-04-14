<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$admin_user = array_merge([
    'nama' => 'Administrator',
    'email' => 'admin@usahain.com',
], (array) ($admin_user ?? []));
$detail = array_merge([
    'id_user' => 0,
    'nama' => '-',
    'email' => '-',
    'role' => '-',
    'created_at' => null,
    'nama_usaha' => '-',
    'jenis_usaha' => '-',
    'paket' => '-',
    'status' => 'Aktif',
], (array) ($detail ?? []));
$back_url = (string) ($back_url ?? site_url('admin/users'));
$flash_success = $this->session->flashdata('success');
$flash_error = $this->session->flashdata('error');
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Detail Pengguna - Admin</title>
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
.grid { display:grid; grid-template-columns:1fr 1fr; gap:12px 16px; }
.item { border-bottom:1px solid #f1f5f9; padding-bottom:10px; }
.item:last-child { border-bottom:none; }
.label { font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:.4px; margin-bottom:6px; }
.value { font-size:14px; font-weight:600; color:#111827; }
.badge { display:inline-flex; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:600; border:1px solid; }
.badge.active { background:#dcfce7; color:#166534; border-color:#bbf7d0; }
.badge.inactive { background:#fee2e2; color:#991b1b; border-color:#fecaca; }
.alert {
    margin-bottom: 12px;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 13px;
    font-weight: 500;
}
.alert.success { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
.alert.error { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }
.form-card { margin-top: 14px; }
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
.form-actions {
    margin-top: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
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
.btn.danger { border-color: #fecaca; background: #fff1f2; color: #b91c1c; }
@media (max-width: 700px) { .grid { grid-template-columns:1fr; } }
@media (max-width: 700px) { .form-grid { grid-template-columns:1fr; } }
</style>
</head>
<body>
<div class="container">
    <div class="topbar">
        <h1 class="title">Detail Pengguna</h1>
        <a href="<?= htmlspecialchars($back_url); ?>" class="back">Kembali</a>
    </div>

    <?php if (!empty($flash_success)): ?><div class="alert success"><?= htmlspecialchars((string) $flash_success); ?></div><?php endif; ?>
    <?php if (!empty($flash_error)): ?><div class="alert error"><?= htmlspecialchars((string) $flash_error); ?></div><?php endif; ?>

    <section class="card">
        <div class="grid">
            <div class="item"><div class="label">Nama</div><div class="value"><?= htmlspecialchars((string) $detail['nama']); ?></div></div>
            <div class="item"><div class="label">Email</div><div class="value"><?= htmlspecialchars((string) $detail['email']); ?></div></div>
            <div class="item"><div class="label">Tanggal Daftar</div><div class="value"><?= !empty($detail['created_at']) ? date('d M Y H:i', strtotime((string) $detail['created_at'])) : '-'; ?></div></div>
            <div class="item"><div class="label">Paket</div><div class="value"><?= htmlspecialchars((string) $detail['paket']); ?></div></div>
            <div class="item"><div class="label">Role</div><div class="value"><?= htmlspecialchars((string) $detail['role']); ?></div></div>
            <div class="item"><div class="label">Status Akun</div><div class="value"><span class="badge <?= strtolower((string) $detail['status']) === 'aktif' ? 'active' : 'inactive'; ?>"><?= htmlspecialchars((string) $detail['status']); ?></span></div></div>
            <div class="item"><div class="label">Nama Usaha</div><div class="value"><?= htmlspecialchars((string) $detail['nama_usaha']); ?></div></div>
            <div class="item"><div class="label">Jenis Usaha</div><div class="value"><?= htmlspecialchars((string) $detail['jenis_usaha']); ?></div></div>
        </div>
    </section>

    <section class="card form-card">
        <form method="post" action="<?= site_url('admin/update_user/' . (int) $detail['id_user']); ?>">
            <input type="hidden" name="return_url" value="<?= htmlspecialchars($back_url); ?>">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-input" value="<?= htmlspecialchars((string) $detail['nama']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-input" value="<?= htmlspecialchars((string) $detail['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama Usaha</label>
                    <input type="text" name="nama_usaha" class="form-input" value="<?= htmlspecialchars((string) $detail['nama_usaha']); ?>">
                </div>
                <div class="form-group">
                    <label>Jenis Usaha</label>
                    <input type="text" name="jenis_usaha" class="form-input" value="<?= htmlspecialchars((string) $detail['jenis_usaha']); ?>">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Simpan Perubahan</button>
            </div>
        </form>

        <div class="form-actions">
            <form method="post" action="<?= site_url('admin/delete_user/' . (int) $detail['id_user']); ?>" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                <input type="hidden" name="return_url" value="<?= htmlspecialchars($back_url); ?>">
                <button type="submit" class="btn danger">Hapus Pengguna</button>
            </form>
        </div>
    </section>
</div>
</body>
</html>
