<?php
$user = $user ?? [
    'nama'  => 'User',
    'usaha'=> 'Bisnis Anda',
    'type' => 'UMKM'
];

$summary = array_merge([
    'today_sales'   => 0,
    'today_expense' => 0,
    'today_profit'  => 0
], $summary ?? []);

$transactions = $transactions ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Usahain</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Segoe UI,Arial,sans-serif;background:#f2f6f9;color:#333}

        .navbar{
            background:#2b7ec9;
            color:#fff;
            padding:16px 24px;
            display:flex;
            justify-content:space-between;
            align-items:center
        }

        .navbar h2{font-size:22px}
        .navbar a{color:#fff;text-decoration:none;font-weight:600}

        .container{
            max-width:1100px;
            margin:24px auto;
            padding:16px
        }

        .welcome{
            background:#fff;
            padding:20px;
            border-radius:12px;
            margin-bottom:20px
        }

        .welcome h1{font-size:22px;margin-bottom:6px}
        .welcome p{color:#666}

        .summary{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:14px;
            margin-bottom:20px
        }

        .card{
            background:#fff;
            padding:18px;
            border-radius:12px
        }

        .card small{color:#888}
        .card h3{margin-top:6px}

        .green{color:#2fb12f}
        .red{color:#e74c3c}
        .blue{color:#2b7ec9}

        .menu{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:14px;
            margin-bottom:20px
        }

        .menu a{
            background:#fff;
            padding:18px;
            border-radius:12px;
            text-decoration:none;
            color:#333;
            transition:.2s
        }

        .menu a:hover{
            background:#2b7ec9;
            color:#fff
        }

        .transaksi{
            background:#fff;
            border-radius:12px;
            padding:18px
        }

        .trx{
            display:flex;
            justify-content:space-between;
            padding:12px;
            background:#f7f9fb;
            border-radius:8px;
            margin-bottom:8px
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Usahain Dashboard</h2>
    <div>
        <?= htmlspecialchars($user['nama']); ?>
        |
        <a href="<?= site_url('auth/logout'); ?>">Logout</a>
    </div>
</div>

<div class="container">

    <!-- WELCOME -->
    <div class="welcome">
        <h1>Selamat Datang, <?= htmlspecialchars($user['nama']); ?> 👋</h1>
        <p><?= htmlspecialchars($user['usaha']); ?> • <?= htmlspecialchars($user['type']); ?></p>
    </div>

    <!-- SUMMARY -->
    <div class="summary">
        <div class="card">
            <small>Pendapatan Hari Ini</small>
            <h3 class="green">Rp <?= number_format($summary['today_sales'],0,',','.'); ?></h3>
        </div>
        <div class="card">
            <small>Pengeluaran Hari Ini</small>
            <h3 class="red">Rp <?= number_format($summary['today_expense'],0,',','.'); ?></h3>
        </div>
        <div class="card">
            <small>Laba Bersih</small>
            <h3 class="blue">Rp <?= number_format($summary['today_profit'],0,',','.'); ?></h3>
        </div>
    </div>

    <!-- MENU -->
    <div class="menu">
        <a href="#">💰 Pencatatan Keuangan</a>
        <a href="#">📊 Analisis Produk</a>
        <a href="#">⚠️ Manajemen Risiko</a>
        <a href="#">🧮 Kalkulator HPP</a>
        <a href="#">📋 Subscription</a>
        <a href="#">🤖 AI Advisor</a>
    </div>

    <!-- TRANSAKSI -->
    <div class="transaksi">
        <h3>📋 Transaksi Terbaru</h3>
        <br>

        <?php if($transactions): ?>
            <?php foreach($transactions as $t): ?>
                <div class="trx">
                    <div>
                        <strong><?= htmlspecialchars($t['title']); ?></strong><br>
                        <small><?= htmlspecialchars($t['time']); ?></small>
                    </div>
                    <div style="font-weight:700;color:<?= $t['amount']<0?'#e74c3c':'#2fb12f'; ?>">
                        <?= ($t['amount']<0?'-Rp ':'+Rp ') . number_format(abs($t['amount']),0,',','.'); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:#888">Belum ada transaksi</p>
        <?php endif; ?>

    </div>

</div>

</body>
</html>
