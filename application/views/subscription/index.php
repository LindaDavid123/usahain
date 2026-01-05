<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #f5f8fa; margin: 0; padding: 0; color: #222; }
        .navbar { background: linear-gradient(90deg, #4A90E2 0%, #357ABD 100%); color: #fff; padding: 22px 0 14px 0; }
        .navbar .container { max-width: 900px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 32px; }
        .navbar-title { font-size: 1.5rem; font-weight: 800; letter-spacing: -1px; }
        .navbar-btns { display: flex; gap: 16px; align-items: center; }
        .navbar-btn { background: #fff; color: #357ABD; border: none; border-radius: 8px; padding: 8px 18px; font-weight: 600; cursor: pointer; transition: background 0.2s; text-decoration: none; }
        .navbar-btn:hover { background: #e3eafc; }
        .main { max-width: 900px; margin: 32px auto; padding: 32px; background: #fff; border-radius: 18px; box-shadow: 0 2px 12px rgba(74,144,226,0.08); }
        h1 { font-size: 2rem; font-weight: 800; margin-bottom: 18px; color: #357ABD; }
        .btn-add { background: linear-gradient(90deg, #4A90E2 0%, #357ABD 100%); color: #fff; border: none; border-radius: 8px; padding: 10px 26px; font-weight: 700; font-size: 1rem; margin-bottom: 24px; text-decoration: none; transition: background 0.2s; display: inline-block; }
        .btn-add:hover { background: #357ABD; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 14px 10px; text-align: left; border-bottom: 1px solid #e3eafc; }
        th { background: #f5f8fa; font-weight: 700; color: #357ABD; }
        tr:hover { background: #f0f6ff; }
        .badge { display: inline-block; padding: 5px 14px; border-radius: 14px; font-size: 0.95rem; font-weight: 700; }
        .badge.active { background: #d1f7c4; color: #2e7d32; }
        .badge.inactive { background: #ffe0b2; color: #b26a00; }
        .badge.expired { background: #ffcdd2; color: #c62828; }
        .action-btns { display: flex; gap: 8px; }
        .btn-action { padding: 8px 16px; border-radius: 7px; font-weight: 600; font-size: 0.98rem; border: none; cursor: pointer; text-decoration: none; transition: background 0.2s; }
        .btn-view { background: #e3eafc; color: #357ABD; }
        .btn-view:hover { background: #d0e2ff; }
        .btn-edit { background: #d1f7c4; color: #2e7d32; }
        .btn-edit:hover { background: #b9f6ca; }
        .btn-delete { background: #ffcdd2; color: #c62828; }
        .btn-delete:hover { background: #ffb4a9; }
        .empty { text-align: center; padding: 40px; color: #666; }
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
