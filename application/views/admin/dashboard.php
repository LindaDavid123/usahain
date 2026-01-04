<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin - Usahain</title>

<style>
:root{
    --primary:#4A90E2;
    --secondary:#7EC8E3;
    --bg:#F5F8FA;
    --card:#FFFFFF;
    --text:#2D3748;
    --muted:#718096;
    --shadow:0 4px 12px rgba(0,0,0,.08);
}
*{box-sizing:border-box;margin:0;padding:0}
body{
    font-family:Inter,Segoe UI,Arial,sans-serif;
    background:var(--bg);
    color:var(--text);
}

/* NAVBAR */
.navbar-main {
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.navbar-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
    height: 70px;
    padding: 0 32px;
}
.navbar-left {
    display: flex;
    align-items: center;
    min-width: fit-content;
}
.navbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: #1c6494;
    font-weight: 800;
    font-size: 22px;
    transition: opacity 0.2s;
}
.navbar-brand:hover {
    opacity: 0.8;
}
.navbar-logo {
    width:45px;
    height:45px;
    display:flex;
    align-items:center;
    justify-content:center;
}
.navbar-logo img{
    width:100%;
    height:100%;
    object-fit:contain;
}
.navbar-center {
    display: flex;
    gap: 32px;
    justify-content: center;
    flex: 1;
    align-items: center;
}
.navbar-link {
    position: relative;
    color: #4b5563;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: color 0.2s;
    padding-bottom: 8px;
}
.navbar-link:hover {
    color: #1c6494;
}
.navbar-link.active {
    color: #1c6494;
    font-weight: 700;
}
.navbar-link.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #1c6494;
    border-radius: 2px;
}
.navbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: fit-content;
}
.navbar-btn {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.navbar-btn.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}
.navbar-btn.btn-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
}
.navbar-btn.btn-logout {
    background: #dc2626;
    color: #fff;
}
.navbar-btn.btn-logout:hover {
    background: #b91c1c;
    transform: translateY(-2px);
}
.navbar-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4a90e2, #6ba4ec);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    transition: transform 0.2s;
}
.navbar-avatar:hover {
    transform: scale(1.05);
}
@media (max-width: 1024px) {
    .navbar-container {
        gap: 24px;
        padding: 0 24px;
    }
    .navbar-center {
        gap: 20px;
    }
    .navbar-btn {
        padding: 8px 16px;
        font-size: 13px;
    }
    .navbar-link {
        font-size: 13px;
    }
    .navbar-brand {
        font-size: 18px;
    }
}
@media (max-width: 768px) {
    .navbar-center {
        gap: 16px;
    }
    .navbar-container {
        gap: 16px;
        padding: 0 16px;
    }
    .navbar-link {
        font-size: 12px;
    }
    .navbar-brand {
        font-size: 16px;
    }
    .navbar-btn {
        padding: 6px 12px;
        font-size: 12px;
    }
    .navbar-avatar {
        width: 38px;
        height: 38px;
        font-size: 14px;
    }
}
@media (max-width: 576px) {
    .navbar-container {
        flex-wrap: wrap;
        gap: 10px;
        padding: 10px 12px;
        height: auto;
    }
    .navbar-center {
        order: 3;
        width: 100%;
        gap: 12px;
        margin-top: 8px;
    }
    .navbar-right {
        gap: 8px;
    }
    .navbar-link {
        font-size: 11px;
    }
    .navbar-btn {
        padding: 6px 10px;
        font-size: 11px;
    }
}

/* TABS */
.tabs{
    max-width:900px;
    margin:25px auto;
    display:flex;
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:var(--shadow);
}
.tab{
    flex:1;
    padding:16px;
    text-align:center;
    font-weight:600;
    color:var(--muted);
}
.tab.active{
    background:#EDF2F7;
    color:var(--primary);
}

/* CARDS */
.container{max-width:1200px;margin:auto;padding:0 20px}
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
}
.card{
    background:var(--card);
    border-radius:16px;
    padding:22px;
    box-shadow:var(--shadow);
}
.card h3{color:var(--muted);font-size:15px}
.card .value{font-size:28px;font-weight:800;margin-top:8px}
.green{background:#E6F9ED;color:#2FB12F}
.blue{background:#EAF2FF;color:#4A90E2}
.purple{background:#F3E8FF;color:#B832E6}
.orange{background:#FFF5E6;color:#E67E22}

/* SECTION */
.section{
    margin-top:30px;
    background:#fff;
    border-radius:16px;
    padding:24px;
    box-shadow:var(--shadow);
}
.section h2{
    font-size:18px;
    margin-bottom:16px;
    color:var(--primary);
}

/* BAR */
.bar-bg{
    background:#EDF2F7;
    border-radius:10px;
    height:14px;
    overflow:hidden;
}
.bar{
    height:100%;
    background:linear-gradient(90deg,var(--primary),var(--secondary));
}
.row{
    display:flex;
    align-items:center;
    gap:14px;
    margin-bottom:12px;
}
.row span{flex:1}
.small{color:var(--muted);font-size:14px}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar-main">
    <div class="navbar-container">
        <div class="navbar-left">
            <a href="<?= site_url('admin/dashboard'); ?>" class="navbar-brand">
                <span class="navbar-logo"><img src="<?= base_url('assets/logo_usahain.png'); ?>" alt="Usahain"></span>
                <span class="navbar-title">Usahain Admin</span>
            </a>
        </div>
        <div class="navbar-center">
            <a href="<?= site_url('admin/dashboard'); ?>" class="navbar-link active">Dashboard</a>
            <a href="<?= site_url('admin/users'); ?>" class="navbar-link">Pengguna</a>
            <a href="<?= site_url('admin/fitur'); ?>" class="navbar-link">Fitur</a>
            <a href="<?= site_url('admin/pengaturan'); ?>" class="navbar-link">Pengaturan</a>
        </div>
        <div class="navbar-right">
            <div class="navbar-avatar"><?= strtoupper(substr($this->session->userdata('nama'),0,1)); ?></div>
            <a href="<?= site_url('auth/logout'); ?>" class="navbar-btn btn-logout" onclick="return confirm('Yakin ingin logout?')">Logout</a>
        </div>
    </div>
</nav>

<!-- TABS -->
<div class="tabs">
    <div class="tab active">📊 Overview</div>
    <div class="tab active">👥 Pengguna</div>
    <div class="tab active">🧩 Fitur</div>
    <div class="tab active">⚙️ Pengaturan</div>
</div>

<div class="container">

<!-- STAT CARDS -->
<div class="cards">
    <div class="card green">
        <h3>Total Pengguna</h3>
        <div class="value"><?= isset($total_users) ? $total_users : 0 ?></div>
        <div class="small">+<?= isset($new_users) ? $new_users : 0 ?> bulan ini</div>
    </div>

    <div class="card blue">
        <h3>Pengguna Aktif</h3>
        <div class="value"><?= isset($active_users) ? $active_users : 0 ?></div>
        <div class="small">Engagement rate</div>
    </div>

    <div class="card purple">
        <h3>Premium Users</h3>
        <div class="value"><?= isset($premium_users) ? $premium_users : 0 ?></div>
        <div class="small">Conversion</div>
    </div>

    <div class="card orange">
        <h3>Revenue Bulan Ini</h3>
        <div class="value">Rp <?= number_format(isset($revenue) ? $revenue : 0,0,',','.') ?></div>
        <div class="small">Dari subscription</div>
    </div>
</div>

<!-- FEATURE USAGE -->
<div class="section">
<h2>📈 Penggunaan Fitur (30 Hari)</h2>

<?php if (!empty($feature_usage) && is_array($feature_usage)): foreach($feature_usage as $f): ?>
<div class="row">
    <span><?= $f['name'] ?></span>
    <div class="bar-bg">
        <div class="bar" style="width:<?= $f['percent'] ?>%"></div>
    </div>
    <span class="small"><?= $f['count'] ?>x</span>
</div>

<?php endforeach; else: ?>
<div class="small" style="color:#aaa">Tidak ada data penggunaan fitur.</div>
<?php endif; ?>

</div>

</div>

</body>
</html>
