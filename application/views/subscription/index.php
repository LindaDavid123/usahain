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
        .main { max-width: 900px; margin: 40px auto; padding: 32px; background: #fff; border-radius: 18px; box-shadow: 0 2px 12px rgba(31, 107, 153, 0.08); }
        h1 { font-size: 2rem; font-weight: 800; margin-bottom: 18px; color: var(--primary); }
        .subtitle { color: var(--text-muted); margin-bottom: 26px; }
        .btn-add { background: var(--gradient-primary); color: #fff; border: none; border-radius: 8px; padding: 10px 26px; font-weight: 700; font-size: 1rem; margin-bottom: 24px; text-decoration: none; transition: background 0.2s; display: inline-block; }
        .btn-add:hover { background: var(--primary-dark); }
        .card { border: 1px solid #e5ecf7; border-radius: 14px; padding: 24px; background: #fcfeff; }
        .info-row { display: flex; justify-content: space-between; gap: 12px; padding: 12px 0; border-bottom: 1px solid #edf2fb; }
        .info-row:last-of-type { border-bottom: none; }
        .info-label { color: var(--text-muted); font-weight: 600; }
        .info-value { color: var(--text-dark); font-weight: 700; text-transform: capitalize; }
        .badge { display: inline-block; padding: 5px 12px; border-radius: 14px; font-size: 0.9rem; font-weight: 700; background: #d1f7c4; color: var(--success); text-transform: capitalize; }
        @media (max-width: 700px) {
            .main { padding: 12px; }
            .info-row { flex-direction: column; gap: 6px; }
        }
    </style>
</head>
<body>
    <div class="main">
        <h1>Langganan Saya</h1>
        <p class="subtitle">Detail paket aktif akun Anda.</p>

        <?php if (! empty($active_subscription)): ?>
            <div class="card">
                <div class="info-row">
                    <span class="info-label">Nama Paket</span>
                    <span class="info-value"><?php echo htmlspecialchars($active_subscription->paket); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Aktif</span>
                    <span class="info-value"><?php echo ! empty($active_subscription->tgl_aktif) ? date('d M Y', strtotime($active_subscription->tgl_aktif)) : '-'; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="badge"><?php echo ucfirst($active_subscription->status); ?></span>
                </div>
                <a href="<?php echo site_url('subscription/pricing'); ?>" class="btn-add" style="margin-top: 22px; margin-bottom: 0;">Ganti Paket</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
