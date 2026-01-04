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

/* HEADER */
.header{
    background:linear-gradient(90deg,var(--primary),var(--secondary));
    color:#fff;
    padding:30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.header h1{font-size:28px}
.avatar{
    width:56px;height:56px;
    border-radius:50%;
    background:#fff;
    color:var(--primary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:22px;
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

<!-- HEADER -->
<div class="header">
    <div>
        <h1>Dashboard Admin</h1>
        <div>Usahain Management System</div>
    </div>
    <div class="avatar">
        <?= strtoupper(substr($this->session->userdata('nama'),0,1)); ?>
    </div>
</div>

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
