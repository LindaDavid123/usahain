<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perencanaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #f5f8fa; margin: 0; color: #222; }
        .navbar { background: linear-gradient(90deg, #4A90E2 0%, #357ABD 100%); color: #fff; padding: 24px 0 16px 0; }
        .navbar .container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 32px; }
        .navbar-title { font-size: 1.7rem; font-weight: 800; letter-spacing: -1px; }
        .navbar-btns { display: flex; gap: 16px; align-items: center; }
        .navbar-btn { background: #fff; color: #357ABD; border: none; border-radius: 8px; padding: 8px 18px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .navbar-btn:hover { background: #e3eafc; }
        .navbar-avatar { width: 38px; height: 38px; border-radius: 50%; background: #fff; color: #357ABD; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem; }
        .main { max-width: 1200px; margin: 0 auto; padding: 32px; }
        .welcome-card { background: #eaf3fc; border-radius: 18px; padding: 32px 36px; margin-bottom: 32px; box-shadow: 0 2px 12px rgba(74,144,226,0.08); }
        .welcome-card h1 { font-size: 2rem; font-weight: 800; margin-bottom: 10px; }
        .welcome-card p { font-size: 1.1rem; color: #357ABD; }
        .progress-bar-wrap { background: #fff; border-radius: 12px; padding: 18px 24px; margin-bottom: 32px; box-shadow: 0 1px 6px rgba(74,144,226,0.06); }
        .progress-label { font-weight: 600; color: #357ABD; margin-bottom: 8px; }
        .progress-bar { background: #e3eafc; border-radius: 8px; height: 14px; width: 100%; overflow: hidden; }
        .progress-bar-inner { background: linear-gradient(90deg, #4A90E2 0%, #7EC8E3 100%); height: 100%; border-radius: 8px; width: 16.6%; transition: width 1s; }
        .progress-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .progress-info span { font-size: 1rem; color: #357ABD; }
        .checklist { background: #fff; border-radius: 14px; padding: 24px 28px; margin-bottom: 32px; box-shadow: 0 1px 6px rgba(74,144,226,0.06); }
        .checklist-title { font-weight: 700; color: #4A90E2; margin-bottom: 18px; font-size: 1.1rem; }
        .checklist-list { display: flex; flex-wrap: wrap; gap: 18px; }
        .checklist-item { display: flex; align-items: center; gap: 10px; background: #f5f8fa; border-radius: 8px; padding: 12px 18px; font-size: 1rem; font-weight: 500; color: #357ABD; min-width: 220px; }
        .checklist-item.checked { background: #d1f7c4; color: #2e7d32; font-weight: 700; }
        .checklist-item .icon { font-size: 1.2rem; }
        .tools-section { margin-bottom: 36px; }
        .tools-title { font-weight: 700; color: #4A90E2; margin-bottom: 18px; font-size: 1.1rem; }
        .tools-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .tool-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(74,144,226,0.06); padding: 28px 18px; display: flex; flex-direction: column; align-items: center; transition: box-shadow 0.2s; }
        .tool-card:hover { box-shadow: 0 6px 24px rgba(74,144,226,0.13); }
        .tool-icon { font-size: 2.2rem; margin-bottom: 12px; }
        .tool-title { font-weight: 700; color: #357ABD; margin-bottom: 8px; font-size: 1.1rem; text-align: center; }
        .tool-desc { color: #718096; font-size: 0.98rem; text-align: center; margin-bottom: 12px; }
        .tool-link { color: #4A90E2; font-weight: 600; text-decoration: none; margin-top: 8px; }
        .tool-link:hover { text-decoration: underline; }
        .guide-section { margin-bottom: 36px; }
        .guide-title { font-weight: 700; color: #4A90E2; margin-bottom: 18px; font-size: 1.1rem; }
        .guide-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .guide-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(74,144,226,0.06); padding: 24px 18px; display: flex; flex-direction: column; align-items: center; }
        .guide-icon { font-size: 2rem; margin-bottom: 10px; }
        .guide-title-card { font-weight: 700; color: #357ABD; margin-bottom: 6px; font-size: 1rem; text-align: center; }
        .guide-desc { color: #718096; font-size: 0.97rem; text-align: center; }
        @media (max-width: 900px) { .tools-grid, .guide-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 600px) { .main { padding: 12px; } .tools-grid, .guide-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="container">
                <div class="navbar-title">Dashboard Perencanaan</div>
                <div class="navbar-btns">
                    <a href="<?= site_url('auth/change_dashboard'); ?>" class="navbar-btn">🏢 Dashboard Operasional</a>
                    <a href="<?= site_url('auth/logout'); ?>" class="navbar-btn">Logout</a>
                    <div class="navbar-avatar">L</div>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="welcome-card">
                <h1>Selamat Datang, Calon Pengusaha!</h1>
                <p>Yuk mulai persiapan bisnis impianmu dengan tools yang powerful!</p>
                <div class="progress-bar-wrap">
                    <div class="progress-info">
                        <span>Persiapan Bisnis</span>
                        <span>1/6 Selesai</span>
                    </div>
                    <div class="progress-bar"><div class="progress-bar-inner"></div></div>
                </div>
            </div>
            <div class="checklist">
                <div class="checklist-title">✔ Checklist Persiapan Bisnis</div>
                <div class="checklist-list">
                    <div class="checklist-item checked"><span class="icon">✔</span> Tentukan Konsep Bisnis</div>
                    <div class="checklist-item"><span class="icon">💡</span> Hitung Modal & HPP</div>
                    <div class="checklist-item"><span class="icon">💡</span> Analisis Risiko Bisnis</div>
                    <div class="checklist-item"><span class="icon">💡</span> Riset Pasar & Kompetitor</div>
                    <div class="checklist-item"><span class="icon">💡</span> Buat Business Plan</div>
                    <div class="checklist-item"><span class="icon">💡</span> Persiapan Legalitas</div>
                </div>
            </div>
            <div class="tools-section">
                <div class="tools-title">🛠️ Tools Perencanaan Bisnis</div>
                <div class="tools-grid">
                    <div class="tool-card">
                        <div class="tool-icon">🤖</div>
                        <div class="tool-title">AI Business Advisor</div>
                        <div class="tool-desc">Konsultasi cerdas dengan AI untuk strategi bisnis Anda</div>
                        <a href="<?= site_url('advisor'); ?>" class="tool-link">Coba Sekarang</a>
                    </div>
                    <div class="tool-card">
                        <div class="tool-icon">🧮</div>
                        <div class="tool-title">Kalkulator HPP</div>
                        <div class="tool-desc">Hitung harga pokok produksi dengan akurat</div>
                        <a href="<?= site_url('hpp'); ?>" class="tool-link">Hitung HPP</a>
                    </div>
                    <div class="tool-card">
                        <div class="tool-icon">📈</div>
                        <div class="tool-title">Proyeksi Keuangan</div>
                        <div class="tool-desc">Simulasi dan prediksi untung-rugi bisnis</div>
                        <a href="<?= site_url('keuangan'); ?>" class="tool-link">Simulasi</a>
                    </div>
                    <div class="tool-card">
                        <div class="tool-icon">🎯</div>
                        <div class="tool-title">Analisis Produk</div>
                        <div class="tool-desc">Riset mendalam & analisis pasar produk Anda</div>
                        <a href="<?= site_url('analisis'); ?>" class="tool-link">Analisis</a>
                    </div>
                    <div class="tool-card">
                        <div class="tool-icon">🛡️</div>
                        <div class="tool-title">Analisis Risiko</div>
                        <div class="tool-desc">Identifikasi dan mitigasi potensi risiko bisnis</div>
                        <a href="<?= site_url('risiko'); ?>" class="tool-link">Kelola Risiko</a>
                    </div>
                    <div class="tool-card">
                        <div class="tool-icon">💡</div>
                        <div class="tool-title">Informasi Bisnis</div>
                        <div class="tool-desc">Tips, tren, dan insight terkini dunia UMKM</div>
                        <a href="<?= site_url('info'); ?>" class="tool-link">Lihat Info</a>
                    </div>
                </div>
            </div>
            <div class="guide-section">
                <div class="guide-title">📚 Panduan Memulai Bisnis</div>
                <div class="guide-progress" style="display:flex;gap:18px;margin-bottom:18px;">
                    <div class="guide-step completed" style="display:flex;align-items:center;gap:6px;color:#2e7d32;font-weight:700;">
                        <span style="font-size:1.2rem;">✔</span> 1
                    </div>
                    <div class="guide-step" style="display:flex;align-items:center;gap:6px;color:#357ABD;font-weight:600;">
                        <span style="font-size:1.2rem;">2</span>
                    </div>
                    <div class="guide-step" style="display:flex;align-items:center;gap:6px;color:#357ABD;font-weight:600;">
                        <span style="font-size:1.2rem;">3</span>
                    </div>
                </div>
                <div class="guide-grid">
                    <div class="guide-card">
                        <div class="guide-icon">🚀</div>
                        <div class="guide-title-card">Cara Memulai UMKM dari Nol</div>
                        <div class="guide-desc">Panduan langkah demi langkah untuk pemula</div>
                        <a href="<?= site_url('panduan/umkm'); ?>" class="tool-link" style="margin-top:10px;">Baca Selengkapnya</a>
                        <div class="guide-check" style="margin-top:10px;"><input type="checkbox" checked disabled> Selesai</div>
                    </div>
                    <div class="guide-card">
                        <div class="guide-icon">🔍</div>
                        <div class="guide-title-card">Riset Pasar yang Efektif</div>
                        <div class="guide-desc">Teknik riset pasar untuk kesuksesan UMKM</div>
                        <a href="<?= site_url('panduan/risetpasar'); ?>" class="tool-link" style="margin-top:10px;">Baca Selengkapnya</a>
                        <div class="guide-check" style="margin-top:10px;"><input type="checkbox" disabled> Tandai Selesai</div>
                    </div>
                    <div class="guide-card">
                        <div class="guide-icon">💰</div>
                        <div class="guide-title-card">Tips Kelola Modal Usaha</div>
                        <div class="guide-desc">Strategi cerdas pengelolaan keuangan bisnis</div>
                        <a href="<?= site_url('panduan/modalusaha'); ?>" class="tool-link" style="margin-top:10px;">Baca Selengkapnya</a>
                        <div class="guide-check" style="margin-top:10px;"><input type="checkbox" disabled> Tandai Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
