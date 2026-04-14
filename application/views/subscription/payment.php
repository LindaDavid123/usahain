<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Color System - Usahain Brand */
            --primary: #1F6B99;           /* Main brand blue */
            --primary-dark: #154A6F;      /* Dark blue */
            --primary-light: #2E7DB9;     /* Light blue */
            --text-dark: #1E293B;         /* Dark text */
            --text-muted: #64748B;        /* Muted text */
            --success: #2E7D32;           /* Green */
            --warning: #F57C00;           /* Orange */
            --danger: #C62828;            /* Red */
            --bg-light: #F8FAFC;          /* Light background */
            --gradient-primary: linear-gradient(90deg, #1F6B99 0%, #2E7DB9 100%);
        }

        body { font-family: 'Inter', Arial, sans-serif; background: var(--bg-light); margin: 0; padding: 0; color: var(--text-dark); }
        .navbar { background: var(--gradient-primary); color: #fff; padding: 22px 0 14px 0; }
        .navbar .container { max-width: 900px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 32px; }
        .navbar-title { font-size: 1.5rem; font-weight: 800; letter-spacing: -1px; }
        .navbar-btns { display: flex; gap: 16px; align-items: center; }
        .navbar-btn { background: #fff; color: var(--primary); border: none; border-radius: 8px; padding: 8px 18px; font-weight: 600; cursor: pointer; transition: background 0.2s; text-decoration: none; }
        .navbar-btn:hover { background: var(--bg-light); }
        .main { max-width: 900px; margin: 32px auto; padding: 32px; background: #fff; border-radius: 18px; box-shadow: 0 2px 12px rgba(31, 107, 153, 0.08); }
        h1 { font-size: 2rem; font-weight: 800; margin-bottom: 18px; color: var(--primary); }
        .btn-add { background: var(--gradient-primary); color: #fff; border: none; border-radius: 8px; padding: 10px 26px; font-weight: 700; font-size: 1rem; margin-bottom: 24px; text-decoration: none; transition: background 0.2s; display: inline-block; }
        .btn-add:hover { background: var(--primary-dark); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 14px 10px; text-align: left; border-bottom: 1px solid #e3eafc; }
        th { background: var(--bg-light); font-weight: 700; color: var(--primary); }
        tr:hover { background: #f0f6ff; }
        .badge { display: inline-block; padding: 5px 14px; border-radius: 14px; font-size: 0.95rem; font-weight: 700; }
        .badge.active { background: #d1f7c4; color: var(--success); }
        .badge.inactive { background: #ffe0b2; color: var(--warning); }
        .badge.expired { background: #ffcdd2; color: var(--danger); }
        .action-btns { display: flex; gap: 8px; }
        .btn-action { padding: 8px 16px; border-radius: 7px; font-weight: 600; font-size: 0.98rem; border: none; cursor: pointer; text-decoration: none; transition: background 0.2s; }
        .btn-view { background: #e3eafc; color: var(--primary); }
        .btn-view:hover { background: #d0e2ff; }
        .btn-edit { background: #d1f7c4; color: var(--success); }
        .btn-edit:hover { background: #b9f6ca; }
        .btn-delete { background: #ffcdd2; color: var(--danger); }
        .btn-delete:hover { background: #ffb4a9; }
        .empty { text-align: center; padding: 40px; color: var(--text-muted); }
        @media (max-width: 700px) {
            .main { padding: 12px; }
            th, td { padding: 10px 4px; font-size: 0.97rem; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="container">
            <div class="navbar-title">Subscription</div>
            <div class="navbar-btns">
                <a href="<?php echo site_url('auth/dashboard'); ?>" class="navbar-btn">Dashboard</a>
                <a href="<?php echo site_url('auth/logout'); ?>" class="navbar-btn">Logout</a>
            </div>
        </div>
    </div>
    <div class="main">
        <h1>Langganan Saya</h1>
        <a href="<?php echo site_url('subscription/pricing'); ?>" class="btn-add">+ Upgrade Paket</a>

        <?php if (! empty($subscriptions)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Status</th>
                        <th>Tanggal Aktif</th>
                        <th>Tanggal Berakhir</th>
                        <th>Sisa Hari</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscriptions as $s): ?>
                        <?php
                            $now       = new DateTime();
                            $expired   = new DateTime($s->tgl_expired);
                            $diff      = $now->diff($expired);
                            $days_left = $expired > $now ? $diff->days : 0;
                        ?>
                        <tr>
                            <td style="font-weight:700; text-transform:capitalize; color:#357ABD;"><?php echo htmlspecialchars($s->paket); ?></td>
                            <td>
                                <?php $status = strtolower($s->status); ?>
                                <span class="badge<?php echo $status; ?>">
                                    <?php echo ucfirst($s->status); ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($s->tgl_aktif)); ?></td>
                            <td><?php echo date('d M Y', strtotime($s->tgl_expired)); ?></td>
                            <td>
                                <?php if ($days_left > 0): ?>
                                    <strong style="color:<?php echo $days_left < 7 ? '#c62828' : '#2e7d32'; ?>">
                                        <?php echo $days_left; ?> hari
                                    </strong>
                                <?php else: ?>
                                    <span style="color: #999;">Expired</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">
                <p>Anda belum memiliki paket langganan aktif.</p>
                <a href="<?php echo site_url('subscription/pricing'); ?>" class="btn-add" style="margin-top: 16px;">Pilih Paket Langganan</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
