<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($advisor) ? 'Edit Konsultasi' : 'AI Business Advisor'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#E8F4F8;--card:#FFFFFF;--accent1:#004B79;--accent2:#0088C2;--cta:#18A0FB}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto;color:#0f1724;padding:20px}
        .container{max-width:480px;margin:0 auto}
        .card{background:var(--card);border-radius:16px;padding:32px;box-shadow:0 12px 40px rgba(2,6,23,0.06)}

        .header{text-align:center;margin-bottom:24px}
        .header-icon{font-size:32px;margin-bottom:8px}
        .heading{font-size:18px;font-weight:700;margin-bottom:4px;color:#0f1724}
        .sub{font-size:13px;color:#64748b}

        .form-group{margin-bottom:16px}
        label{display:block;font-size:13px;color:#334155;margin-bottom:8px;font-weight:600}
        select{width:100%;padding:12px 14px;border-radius:10px;border:1px solid #e6eef6;background:#fbfdff;font-size:14px;font-family:Inter;cursor:pointer;appearance:none;padding-right:40px;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;background-size:18px}

        .btn-group{margin-top:24px;display:flex;gap:12px}
        .btn{padding:14px 20px;border:none;border-radius:12px;cursor:pointer;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:14px;gap:8px;flex:1}
        .btn-primary{background:linear-gradient(90deg,var(--accent1),var(--accent2));color:white;box-shadow:0 8px 20px rgba(3,10,25,0.08)}
        .btn-secondary{background:#d1d5db;color:#374151}
        .btn:hover{opacity:0.9}

        .error{color:#ef4444;font-size:12px;margin-top:6px}

        @media (max-width:520px){
            .card{padding:20px}
            .btn-group{flex-direction:column}
            select{background-size:16px}
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="header">
                <div class="header-icon">🤖</div>
                <div class="heading">AI Business Advisor</div>
                <div class="sub">Dapatkan rekomendasi bisnis yang tepat untuk Anda</div>
            </div>

            <form method="post" action="<?= site_url('advisor/create'); ?>">
                <div class="form-group">
                    <label for="modal">Modal yang Tersedia</label>
                    <select id="modal" name="modal" required>
                        <option value="">Pilih range modal</option>
                        <option value="1000000" <?= (isset($advisor) && $advisor->modal == 1000000) ? 'selected' : ''; ?>>< 1 Juta</option>
                        <option value="5000000" <?= (isset($advisor) && $advisor->modal == 5000000) ? 'selected' : ''; ?>>1 - 5 Juta</option>
                        <option value="10000000" <?= (isset($advisor) && $advisor->modal == 10000000) ? 'selected' : ''; ?>>5 - 10 Juta</option>
                        <option value="50000000" <?= (isset($advisor) && $advisor->modal == 50000000) ? 'selected' : ''; ?>>10 - 50 Juta</option>
                        <option value="100000000" <?= (isset($advisor) && $advisor->modal == 100000000) ? 'selected' : ''; ?>>50 - 100 Juta</option>
                        <option value="500000000" <?= (isset($advisor) && $advisor->modal == 500000000) ? 'selected' : ''; ?>>100 - 500 Juta</option>
                        <option value="1000000000" <?= (isset($advisor) && $advisor->modal == 1000000000) ? 'selected' : ''; ?>> > 500 Juta</option>
                    </select>
                    <?= form_error('modal', '<div class="error">', '</div>'); ?>
                </div>

                <div class="form-group">
                    <label for="minat">Minat/Keahlian</label>
                    <select id="minat" name="minat" required>
                        <option value="">Pilih bidang minat</option>
                        <option value="kuliner" <?= (isset($advisor) && $advisor->minat == 'kuliner') ? 'selected' : ''; ?>>Kuliner & Makanan</option>
                        <option value="fashion" <?= (isset($advisor) && $advisor->minat == 'fashion') ? 'selected' : ''; ?>>Fashion & Pakaian</option>
                        <option value="teknologi" <?= (isset($advisor) && $advisor->minat == 'teknologi') ? 'selected' : ''; ?>>Teknologi & Digital</option>
                        <option value="jasa" <?= (isset($advisor) && $advisor->minat == 'jasa') ? 'selected' : ''; ?>>Jasa & Layanan</option>
                        <option value="pertanian" <?= (isset($advisor) && $advisor->minat == 'pertanian') ? 'selected' : ''; ?>>Pertanian & Agro</option>
                        <option value="pendidikan" <?= (isset($advisor) && $advisor->minat == 'pendidikan') ? 'selected' : ''; ?>>Pendidikan & Pelatihan</option>
                        <option value="pariwisata" <?= (isset($advisor) && $advisor->minat == 'pariwisata') ? 'selected' : ''; ?>>Pariwisata & Akomodasi</option>
                        <option value="lainnya" <?= (isset($advisor) && $advisor->minat == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                    </select>
                    <?= form_error('minat', '<div class="error">', '</div>'); ?>
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <select id="lokasi" name="lokasi" required>
                        <option value="">Pilih lokasi</option>
                        <option value="jakarta" <?= (isset($advisor) && $advisor->lokasi == 'jakarta') ? 'selected' : ''; ?>>Jakarta</option>
                        <option value="bandung" <?= (isset($advisor) && $advisor->lokasi == 'bandung') ? 'selected' : ''; ?>>Bandung</option>
                        <option value="surabaya" <?= (isset($advisor) && $advisor->lokasi == 'surabaya') ? 'selected' : ''; ?>>Surabaya</option>
                        <option value="medan" <?= (isset($advisor) && $advisor->lokasi == 'medan') ? 'selected' : ''; ?>>Medan</option>
                        <option value="yogyakarta" <?= (isset($advisor) && $advisor->lokasi == 'yogyakarta') ? 'selected' : ''; ?>>Yogyakarta</option>
                        <option value="semarang" <?= (isset($advisor) && $advisor->lokasi == 'semarang') ? 'selected' : ''; ?>>Semarang</option>
                        <option value="makassar" <?= (isset($advisor) && $advisor->lokasi == 'makassar') ? 'selected' : ''; ?>>Makassar</option>
                        <option value="lainnya" <?= (isset($advisor) && $advisor->lokasi == 'lainnya') ? 'selected' : ''; ?>>Lokasi Lainnya</option>
                    </select>
                    <?= form_error('lokasi', '<div class="error">', '</div>'); ?>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <span>📊</span>
                        Analisis & Rekomendasi
                    </button>
                    <a href="<?= site_url('advisor/chat'); ?>" class="btn btn-secondary">Tutup</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
