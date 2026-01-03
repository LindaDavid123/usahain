<?php
$user = array_merge([
    'nama'  => 'User',
    'email' => '-',
    'role'  => '-'
], $user ?? []);
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,user-scalable=yes">
<meta name="theme-color" content="#1C6494">
<title>Dashboard Planning - <?= htmlspecialchars($user['nama']); ?></title>

<style>
:root {
    --primary: #1C6494;
    --primary-dark: #144d73;
    --primary-light: #2b7ec9;
    --secondary: #5bb7db;
    --accent: #65C1DF;
    --success: #2ecc71;
    --warning: #f39c12;
    --danger: #e74c3c;
    --bg: #f8f9fa;
    --bg-muted: #f0f4f8;
    --card-bg: #ffffff;
    --text: #1e293b;
    --text-secondary: #64748b;
    --shadow-sm: 0 2px 8px rgba(28,100,148,0.08);
    --shadow-md: 0 4px 16px rgba(28,100,148,0.12);
    --shadow-lg: 0 8px 24px rgba(28,100,148,0.16);
}

*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Inter,Segoe UI,Arial;background:var(--bg);color:var(--text)}

/* HEADER */
.header{
    background:linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    padding:20px 32px;
    color:#fff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:var(--shadow-md)
}
.header h3{font-size:20px;font-weight:700}
.header-right{display:flex;align-items:center;gap:14px}
.avatar{
    width:46px;height:46px;border-radius:50%;
    background:white;
    color:var(--warning);
    display:flex;align-items:center;justify-content:center;
    font-weight:700;box-shadow:var(--shadow-sm)
}
.logout-btn{
    background:rgba(255,255,255,.2);
    color:#fff;
    padding:9px 18px;
    border-radius:24px;
    font-size:13px;
    text-decoration:none;
    font-weight:600;
    transition:.3s ease;
    border:1.5px solid rgba(255,255,255,0.3)
}
.logout-btn:hover{
    background:rgba(255,255,255,.35);
    transform:translateY(-1px);
    box-shadow:0 4px 12px rgba(0,0,0,0.15)
}
.change-dashboard-btn{
    background:rgba(255,255,255,.15);
    color:#fff;
    padding:8px 16px;
    border-radius:20px;
    font-size:12px;
    text-decoration:none;
    font-weight:600;
    transition:.3s ease;
    border:1.5px solid rgba(255,255,255,0.25)
}
.change-dashboard-btn:hover{
    background:rgba(255,255,255,.3);
    transform:translateY(-1px)
}

/* CONTAINER */
.container{max-width:1150px;margin:28px auto;padding:0 24px}

/* WELCOME BANNER */
.welcome-banner{
    background:linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    border-radius:20px;
    padding:40px;
    color:white;
    margin-bottom:32px;
    box-shadow:var(--shadow-lg);
    position:relative;
    overflow:hidden
}
.welcome-banner::before{
    content:'';
    position:absolute;
    top:-50%;right:-10%;
    width:300px;height:300px;
    background:rgba(255,255,255,0.1);
    border-radius:50%;
    filter:blur(40px)
}
.welcome-banner h1{
    font-size:32px;
    font-weight:800;
    margin-bottom:12px;
    position:relative;
    z-index:2
}
.welcome-banner p{
    font-size:18px;
    opacity:0.95;
    position:relative;
    z-index:2
}

/* SECTION TITLE */
.section-title{
    font-weight:700;
    margin:32px 0 18px;
    display:flex;
    align-items:center;
    gap:8px;
    color:var(--primary);
    font-size:20px
}

/* PROGRESS CARD */
.progress-card{
    background:var(--card-bg);
    border-radius:16px;
    padding:28px;
    box-shadow:var(--shadow-sm);
    margin-bottom:32px;
    border:2px solid rgba(28,100,148,0.1)
}
.progress-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px
}
.progress-header h3{
    font-size:18px;
    color:var(--text)
}
.progress-percent{
    font-size:24px;
    font-weight:800;
    color:var(--primary)
}
.progress-bar-container{
    background:#e9ecef;
    height:12px;
    border-radius:20px;
    overflow:hidden;
    margin-bottom:16px
}
.progress-bar{
    background:linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
    height:100%;
    border-radius:20px;
    transition:width 1s ease
}
.progress-steps{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:12px;
    margin-top:20px
}
.step{
    padding:16px;
    background:#f8f9fa;
    border-radius:12px;
    border-left:4px solid #ddd;
    transition:.3s ease
}
.step.completed{
    background:#d4edda;
    border-left-color:var(--success)
}
.step.active{
    background:#cfe2ff;
    border-left-color:var(--primary)
}
.step h6{
    font-size:13px;
    font-weight:700;
    margin-bottom:4px
}
.step p{
    font-size:11px;
    color:var(--text-secondary)
}

/* QUICK START ACTIONS */
.quick-start{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:32px
}
.quick-card{
    background:var(--card-bg);
    border-radius:16px;
    padding:28px;
    box-shadow:var(--shadow-sm);
    transition:.3s ease;
    border:2px solid transparent;
    text-align:center;
    cursor:pointer
}
.quick-card:hover{
    transform:translateY(-6px);
    box-shadow:var(--shadow-lg);
    border-color:var(--secondary)
}
.quick-icon{
    font-size:48px;
    margin-bottom:16px
}
.quick-card h4{
    font-size:18px;
    font-weight:700;
    color:var(--primary);
    margin-bottom:10px
}
.quick-card p{
    font-size:14px;
    color:var(--text-secondary);
    margin-bottom:16px;
    line-height:1.5
}
.quick-btn{
    background:linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color:white;
    padding:10px 24px;
    border-radius:10px;
    text-decoration:none;
    display:inline-block;
    font-weight:600;
    font-size:14px;
    transition:.3s ease
}
.quick-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(28,100,148,0.3)
}

/* TOOLS GRID */
.tools-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
    margin-bottom:40px
}
.tool-box{
    background:var(--card-bg);
    border-radius:16px;
    padding:24px;
    box-shadow:var(--shadow-sm);
    transition:.3s ease;
    cursor:pointer;
    border:2px solid transparent;
    position:relative;
    overflow:hidden
}
.tool-box::before{
    content:'';
    position:absolute;
    top:0;left:0;right:0;
    height:4px;
    background:linear-gradient(90deg, var(--primary), var(--secondary));
    transform:scaleX(0);
    transition:.3s ease
}
.tool-box:hover{
    transform:translateY(-6px);
    box-shadow:var(--shadow-lg);
    border-color:var(--secondary)
}
.tool-box:hover::before{
    transform:scaleX(1)
}
.tool-icon{font-size:40px;margin-bottom:14px}
.tool-title{font-weight:700;margin-bottom:8px;font-size:16px;color:var(--primary)}
.tool-desc{font-size:13px;color:var(--text-secondary);margin-bottom:12px;line-height:1.4}
.tool-box a{
    color:var(--primary);
    text-decoration:none;
    font-weight:600;
    font-size:13px;
    transition:.3s ease
}
.tool-box a:hover{
    color:var(--secondary)
}

/* TIPS SECTION */
.tips-container{
    background:linear-gradient(135deg, #fef5e7 0%, #fff9e6 100%);
    border-radius:16px;
    padding:28px;
    margin-bottom:32px;
    border-left:6px solid var(--warning);
    box-shadow:var(--shadow-sm)
}
.tips-container h3{
    color:var(--warning);
    font-size:18px;
    margin-bottom:16px;
    display:flex;
    align-items:center;
    gap:10px
}
.tip-item{
    background:white;
    padding:16px;
    border-radius:10px;
    margin-bottom:12px;
    display:flex;
    align-items:flex-start;
    gap:12px;
    box-shadow:0 2px 6px rgba(243,156,18,0.1)
}
.tip-item::before{
    content:'💡';
    font-size:20px;
    flex-shrink:0
}
.tip-item p{
    margin:0;
    font-size:14px;
    line-height:1.6;
    color:var(--text)
}

/* RESPONSIVE */
@media(max-width:991px){
    .quick-start{grid-template-columns:repeat(2,1fr)}
    .tools-grid{grid-template-columns:repeat(2,1fr)}
    .progress-steps{grid-template-columns:repeat(2,1fr)}
}

@media(max-width:768px){
    .header{padding:18px 24px;flex-direction:column;gap:12px}
    .header-right{width:100%;justify-content:center}
    .welcome-banner{padding:32px 24px}
    .welcome-banner h1{font-size:26px}
    .welcome-banner p{font-size:16px}
    .quick-start{grid-template-columns:1fr}
    .tools-grid{grid-template-columns:1fr}
    .progress-steps{grid-template-columns:1fr}
}

@media(max-width:576px){
    .container{padding:0 16px}
    .welcome-banner h1{font-size:22px}
    .section-title{font-size:18px}
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <div>
        <h3>💡 Dashboard Perencanaan</h3>
        <small>Mulai perjalanan bisnis Anda</small>
    </div>
    <div class="header-right">
        <a href="<?= site_url('auth/change_dashboard'); ?>" class="change-dashboard-btn">🔄 Ganti Dashboard</a>
        <div class="avatar"><?= strtoupper(substr($user['nama'], 0, 1)); ?></div>
        <a href="<?= site_url('auth/logout'); ?>" class="logout-btn">Keluar</a>
    </div>
</div>

<div class="container">

    <!-- WELCOME BANNER -->
    <div class="welcome-banner">
        <h1>Selamat datang, <?= htmlspecialchars($user['nama']); ?>! 🚀</h1>
        <p>Mari mulai merencanakan bisnis impian Anda dengan panduan lengkap dari Usahain</p>
    </div>

    <!-- PROGRESS PERENCANAAN -->
    <div class="progress-card">
        <div class="progress-header">
            <h3>📊 Progress Perencanaan Bisnis</h3>
            <div class="progress-percent">25%</div>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar" style="width: 25%"></div>
        </div>
        
        <div class="progress-steps">
            <div class="step completed">
                <h6>✓ Profil Dibuat</h6>
                <p>Akun sudah siap</p>
            </div>
            <div class="step active">
                <h6>⏳ Cari Ide Usaha</h6>
                <p>Gunakan AI Advisor</p>
            </div>
            <div class="step">
                <h6>Hitung Modal</h6>
                <p>Kalkulator HPP</p>
            </div>
            <div class="step">
                <h6>Business Plan</h6>
                <p>Buat rencana bisnis</p>
            </div>
        </div>
    </div>

    <!-- LANGKAH CEPAT -->
    <h2 class="section-title">🎯 Langkah Cepat Memulai</h2>
    <div class="quick-start">
        
        <div class="quick-card">
            <div class="quick-icon">🤖</div>
            <h4>Dapatkan Ide Usaha</h4>
            <p>AI Advisor akan merekomendasikan ide bisnis sesuai modal dan minat Anda</p>
            <a href="<?= site_url('advisor'); ?>" class="quick-btn">Mulai Sekarang</a>
        </div>

        <div class="quick-card">
            <div class="quick-icon">🧮</div>
            <h4>Hitung Modal Awal</h4>
            <p>Gunakan kalkulator HPP untuk menentukan harga jual yang menguntungkan</p>
            <a href="<?= site_url('hpp'); ?>" class="quick-btn">Hitung HPP</a>
        </div>

        <div class="quick-card">
            <div class="quick-icon">📋</div>
            <h4>Buat Business Plan</h4>
            <p>Template lengkap untuk menyusun rencana bisnis profesional</p>
            <a href="<?= site_url('analisis'); ?>" class="quick-btn">Buat Plan</a>
        </div>

    </div>

    <!-- TOOLS PERENCANAAN -->
    <h2 class="section-title">🛠️ Tools Perencanaan Bisnis</h2>
    <div class="tools-grid">
        
        <div class="tool-box">
            <div class="tool-icon">🤖</div>
            <div class="tool-title">AI Business Advisor</div>
            <div class="tool-desc">Konsultasi gratis untuk ide usaha yang tepat</div>
            <a href="<?= site_url('advisor'); ?>">Mulai Konsultasi →</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon">💰</div>
            <div class="tool-title">Kalkulator Modal</div>
            <div class="tool-desc">Hitung kebutuhan modal awal bisnis</div>
            <a href="<?= site_url('hpp'); ?>">Hitung Modal →</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon">📊</div>
            <div class="tool-title">Analisis Pasar</div>
            <div class="tool-desc">Riset kompetitor dan peluang pasar</div>
            <a href="<?= site_url('analisis'); ?>">Analisis →</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon">🛡️</div>
            <div class="tool-title">Manajemen Risiko</div>
            <div class="tool-desc">Identifikasi dan antisipasi risiko bisnis</div>
            <a href="<?= site_url('risiko'); ?>">Kelola Risiko →</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon">📄</div>
            <div class="tool-title">Template Dokumen</div>
            <div class="tool-desc">Proposal, invoice, dan dokumen bisnis</div>
            <a href="#templates">Download Template →</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon">📚</div>
            <div class="tool-title">Panduan UMKM</div>
            <div class="tool-desc">Artikel dan tutorial lengkap</div>
            <a href="#guides">Baca Panduan →</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon">💳</div>
            <div class="tool-title">Simulasi Pinjaman</div>
            <div class="tool-desc">Hitung cicilan modal usaha</div>
            <a href="#loan">Simulasi →</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon">🎓</div>
            <div class="tool-title">Pelatihan Gratis</div>
            <div class="tool-desc">Webinar dan kursus untuk UMKM</div>
            <a href="#training">Ikuti Pelatihan →</a>
        </div>

    </div>

    <!-- TIPS MEMULAI USAHA -->
    <div class="tips-container">
        <h3>💡 Tips Memulai Usaha untuk Pemula</h3>
        
        <div class="tip-item">
            <p><strong>Mulai dari Passion:</strong> Pilih bisnis yang sesuai dengan minat dan keahlian Anda agar lebih mudah dijalankan.</p>
        </div>

        <div class="tip-item">
            <p><strong>Riset Pasar Dulu:</strong> Pastikan produk/jasa yang Anda tawarkan memiliki permintaan di pasar.</p>
        </div>

        <div class="tip-item">
            <p><strong>Hitung Modal Realistis:</strong> Jangan underestimate modal. Siapkan dana cadangan minimal 20% dari total modal.</p>
        </div>

        <div class="tip-item">
            <p><strong>Mulai dari Kecil:</strong> Tidak perlu langsung besar. Mulai skala kecil, pelajari, lalu kembangkan.</p>
        </div>

        <div class="tip-item">
            <p><strong>Catat Keuangan dari Hari Pertama:</strong> Kebiasaan mencatat keuangan sejak awal akan sangat membantu di masa depan.</p>
        </div>
    </div>

</div>

</body>
</html>
