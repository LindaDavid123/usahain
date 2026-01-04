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
    --primary: #4A90E2;
    --primary-dark: #357ABD;
    --primary-light: #6BA4EC;
    --secondary: #7EC8E3;
    --accent: #87CEEB;
    --success: #52D79A;
    --warning: #FFA76C;
    --warning-dark: #FF8C4B;
    --danger: #F57C7C;
    --bg: #F5F8FA;
    --bg-muted: #EDF2F7;
    --card-bg: #FFFFFF;
    --text: #2D3748;
    --text-secondary: #718096;
    --text-muted: #A0AEC0;
    --border-color: #E2E8F0;
    --shadow-xs: 0 1px 3px rgba(74,144,226,0.06);
    --shadow-sm: 0 2px 6px rgba(74,144,226,0.08);
    --shadow-md: 0 4px 12px rgba(74,144,226,0.10);
    --shadow-lg: 0 8px 20px rgba(74,144,226,0.12);
    --shadow-xl: 0 12px 28px rgba(74,144,226,0.15);
}

*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Inter,Segoe UI,Arial;background:var(--bg);color:var(--text)}

/* === NAVBAR PICKANS STYLE === */
.navbar-main{
    background:#fff;
    border-bottom:1px solid #e5e7eb;
    position:sticky;
    top:0;
    z-index:100;
    box-shadow:0 1px 3px rgba(0,0,0,0.08);
}
.navbar-container{
    max-width:1400px;
    margin:0 auto;
    padding:0 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    height:70px;
    gap:40px;
}
.navbar-left{
    display:flex;
    align-items:center;
    flex-shrink:0;
}
.navbar-brand{
    display:flex;
    align-items:center;
    gap:12px;
    text-decoration:none;
    transition:all 0.3s;
}
.navbar-brand:hover{
    opacity:0.8;
}
.navbar-logo{
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
.navbar-title{
    font-size:22px;
    font-weight:800;
    color:#1c6494;
    letter-spacing:-0.5px;
}
.navbar-center{
    display:flex;
    gap:32px;
    align-items:center;
    flex:1;
    justify-content:center;
}
.navbar-link{
    color:#4b5563;
    text-decoration:none;
    font-weight:500;
    font-size:14px;
    transition:all 0.3s;
    position:relative;
    padding:6px 0;
}
.navbar-link:hover{
    color:#1c6494;
}
.navbar-link.active{
    color:#1c6494;
    font-weight:700;
}
.navbar-link.active::after{
    content:'';
    position:absolute;
    bottom:-8px;
    left:0;
    right:0;
    height:3px;
    background:#1c6494;
    border-radius:2px;
}
.navbar-right{
    display:flex;
    align-items:center;
    gap:16px;
    flex-shrink:0;
}
.navbar-btn{
    padding:10px 20px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    transition:all 0.3s;
    border:none;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    gap:6px;
}
.navbar-btn.btn-secondary{
    background:#f3f4f6;
    color:#374151;
}
.navbar-btn.btn-secondary:hover{
    background:#e5e7eb;
    transform:translateY(-2px);
}
.navbar-btn.btn-logout{
    background:#dc2626;
    color:#fff;
}
.navbar-btn.btn-logout:hover{
    background:#b91c1c;
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(220,38,38,0.3);
}
.navbar-avatar{
    width:40px;
    height:40px;
    border-radius:50%;
    background:linear-gradient(135deg,#4a90e2 0%,#6ba4ec 100%);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:16px;
    flex-shrink:0;
}

/* RESPONSIVE NAVBAR */
@media(max-width:1024px){
    .navbar-container{
        gap:24px;
    }
    .navbar-center{
        gap:20px;
    }
    .navbar-link{
        font-size:13px;
    }
}
@media(max-width:768px){
    .navbar-container{
        height:auto;
        padding:12px 16px;
        flex-wrap:wrap;
        gap:12px;
    }
    .navbar-center{
        gap:16px;
        order:3;
        width:100%;
        justify-content:flex-start;
        flex:none;
    }
    .navbar-link{
        font-size:12px;
    }
    .navbar-right{
        gap:8px;
    }
    .navbar-btn{
        padding:8px 14px;
        font-size:12px;
    }
    .navbar-title{
        font-size:18px;
    }
}
@media(max-width:576px){
    .navbar-container{
        padding:10px 12px;
    }
    .navbar-logo{
        font-size:24px;
    }
    .navbar-title{
        font-size:16px;
    }
    .navbar-center{
        gap:12px;
    }
    .navbar-link{
        font-size:11px;
    }
    .navbar-btn{
        padding:6px 12px;
        font-size:11px;
    }
    .navbar-avatar{
        width:36px;
        height:36px;
        font-size:14px;
    }
}
    transform:translateY(-2px);
    border-color:rgba(255,255,255,0.5);
    box-shadow:0 3px 10px rgba(0,0,0,0.12)
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
    background:linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius:24px;
    padding:32px;
    box-shadow:0 6px 24px rgba(28,100,148,0.1);
    transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border:2px solid rgba(28,100,148,0.08);
    text-align:center;
    cursor:pointer;
    position:relative;
    overflow:hidden
}
.quick-card::before{
    content:'';
    position:absolute;
    bottom:-50%;
    left:50%;
    width:200px;
    height:200px;
    background:radial-gradient(circle, rgba(28,100,148,0.06) 0%, transparent 70%);
    border-radius:50%;
    transform:translateX(-50%);
    transition:all 0.5s
}
.quick-card:hover::before{
    bottom:-20%;
    transform:translateX(-50%) scale(1.2)
}
.quick-card:hover{
    transform:translateY(-8px) scale(1.02);
    box-shadow:0 16px 48px rgba(28,100,148,0.18);
    border-color:var(--secondary)
}
.quick-icon{
    font-size:56px;
    margin-bottom:18px;
    transition:transform 0.3s;
    position:relative;
    z-index:2
}
.quick-card:hover .quick-icon{
    transform:scale(1.15) rotate(5deg)
}
.quick-card h4{
    font-size:19px;
    font-weight:800;
    color:var(--primary);
    margin-bottom:12px;
    position:relative;
    z-index:2
}
.quick-card p{
    font-size:14px;
    color:var(--text-secondary);
    margin-bottom:18px;
    line-height:1.6;
    position:relative;
    z-index:2
}
.quick-btn{
    background:linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color:white;
    padding:12px 28px;
    border-radius:14px;
    text-decoration:none;
    display:inline-block;
    font-weight:700;
    font-size:14px;
    transition:all 0.3s;
    box-shadow:0 4px 16px rgba(28,100,148,0.2);
    position:relative;
    z-index:2
}
.quick-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 24px rgba(28,100,148,0.35)
}

/* TOOLS GRID */
.tools-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:40px
}
.tool-box{
    background:linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius:24px;
    padding:32px 28px;
    box-shadow:0 4px 20px rgba(28,100,148,0.08);
    transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor:pointer;
    border:2px solid rgba(28,100,148,0.08);
    position:relative;
    overflow:hidden
}
.tool-box::before{
    content:'';
    position:absolute;
    top:0;left:0;right:0;
    height:5px;
    background:linear-gradient(90deg, var(--primary), var(--secondary));
    transform:scaleX(0);
    transition:transform 0.4s
}
.tool-box::after{
    content:'';
    position:absolute;
    top:-50%;
    right:-50%;
    width:200px;
    height:200px;
    background:radial-gradient(circle, rgba(28,100,148,0.05) 0%, transparent 70%);
    transition:all 0.5s
}
.tool-box:hover::after{
    transform:translate(-20%, 20%)
}
.tool-box:hover{
    transform:translateY(-8px) scale(1.02);
    box-shadow:0 16px 50px rgba(28,100,148,0.15);
    border-color:var(--secondary);
    background:linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%)
}
.tool-box:hover::before{
    transform:scaleX(1)
}
.tool-icon{
    width:56px;
    height:56px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    margin-bottom:16px;
    box-shadow:0 4px 16px rgba(0,0,0,0.1);
    position:relative;
    z-index:2;
    transition:all 0.4s
}
.tool-box:hover .tool-icon{
    transform:scale(1.1) rotate(5deg);
    box-shadow:0 8px 24px rgba(0,0,0,0.15)
}
.tool-icon{background:linear-gradient(135deg, #3b82f6, #1C6494)}
.tool-title{
    font-weight:800;
    margin-bottom:12px;
    font-size:18px;
    color:var(--primary);
    position:relative;
    z-index:2
}
.tool-desc{
    font-size:14px;
    color:var(--text-secondary);
    margin-bottom:16px;
    line-height:1.6;
    position:relative;
    z-index:2
}
.tool-box a{
    color:var(--primary);
    text-decoration:none;
    font-weight:700;
    font-size:14px;
    transition:all 0.3s;
    position:relative;
    z-index:2;
    display:inline-flex;
    align-items:center;
    gap:6px
}
.tool-box a::after{
    content:'\2192';
    transition:transform 0.3s
}
.tool-box:hover a{
    color:var(--secondary)
}
.tool-box:hover a::after{
    transform:translateX(4px)
}

/* TIPS SECTION */
.tips-container{
    background:linear-gradient(135deg, #fef5e7 0%, #fff9e6 100%);
    border-radius:24px;
    padding:32px;
    margin-bottom:36px;
    border-left:6px solid var(--warning);
    box-shadow:0 6px 24px rgba(243,156,18,0.12);
    position:relative;
    overflow:hidden
}
.tips-container::before{
    content:'';
    position:absolute;
    top:-50%;
    right:-10%;
    width:300px;
    height:300px;
    background:radial-gradient(circle, rgba(243,156,18,0.08) 0%, transparent 70%);
    border-radius:50%
}
.tips-container h3{
    color:var(--warning);
    font-size:20px;
    margin-bottom:20px;
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:800;
    position:relative;
    z-index:2
}
.tip-item{
    background:white;
    padding:20px;
    border-radius:14px;
    margin-bottom:14px;
    display:flex;
    align-items:flex-start;
    gap:14px;
    box-shadow:0 3px 10px rgba(243,156,18,0.1);
    transition:all 0.3s;
    position:relative;
    z-index:2;
    border:2px solid transparent
}
.tip-item:hover{
    transform:translateX(8px);
    box-shadow:0 6px 20px rgba(243,156,18,0.15);
    border-color:rgba(243,156,18,0.2)
}
.tip-item::before{
    content:'💡';
    font-size:24px;
    flex-shrink:0;
    transition:transform 0.3s
}
.tip-item:hover::before{
    transform:scale(1.2) rotate(10deg)
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
    .header{padding:16px 20px;flex-direction:column;gap:14px;align-items:stretch}
    .header-left{justify-content:center}
    .header-right{width:100%;justify-content:center;flex-wrap:wrap}
    .change-dashboard-btn{font-size:11px;padding:8px 14px}
    .logout-btn{font-size:12px;padding:9px 18px}
    .avatar{width:40px;height:40px;font-size:15px}
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

<!-- NAVBAR - PICKANS STYLE -->
<nav class="navbar-main">
    <div class="navbar-container">
        <!-- Left: Logo & Brand -->
        <div class="navbar-left">
            <a href="<?= site_url('auth/dashboard'); ?>" class="navbar-brand">
                <span class="navbar-logo"><img src="<?= base_url('assets/logo_usahain.png'); ?>" alt="Usahain"></span>
                <span class="navbar-title">Usahain</span>
            </a>
        </div>

        <!-- Center: Navigation Menu -->
        <div class="navbar-center">
            <a href="<?= site_url('auth/dashboard'); ?>" class="navbar-link active">Dashboard</a>
            <a href="<?= site_url('auth/dashboard'); ?>" class="navbar-link">Fitur</a>
            <a href="<?= site_url('auth/dashboard'); ?>" class="navbar-link">Bantuan</a>
            <a href="<?= site_url('auth/dashboard'); ?>" class="navbar-link">Kontak</a>
        </div>

        <!-- Right: Action Buttons -->
        <div class="navbar-right">
            <a href="<?= site_url('auth/change_dashboard'); ?>" class="navbar-btn btn-secondary">🔄 Operasional</a>
            <div class="navbar-avatar" title="<?= htmlspecialchars($user['nama']); ?>">
                <?= strtoupper(substr($user['nama'], 0, 1)); ?>
            </div>
            <a href="<?= site_url('auth/logout'); ?>" 
               class="navbar-btn btn-logout"
               onclick="return confirm('Yakin ingin logout?')">
               Logout
            </a>
        </div>
    </div>

    <div class="container">
</nav>
   
    <!-- WELCOME BANNER -->
    <div class="welcome-banner">
        <h1>Selamat datang, <?= htmlspecialchars($user['nama']); ?>!</h1>
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
            <div class="tool-icon" style="background:linear-gradient(135deg, #06b6d4, #0891b2)">🤖</div>
            <div class="tool-title">AI Business Advisor</div>
            <div class="tool-desc">Konsultasi gratis dengan AI untuk ide usaha yang tepat</div>
            <a href="<?= site_url('advisor'); ?>">Mulai Konsultasi</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon" style="background:linear-gradient(135deg, #3b82f6, #1C6494)">💰</div>
            <div class="tool-title">Kalkulator Modal</div>
            <div class="tool-desc">Hitung kebutuhan modal awal untuk memulai bisnis</div>
            <a href="<?= site_url('hpp'); ?>">Hitung Modal</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon" style="background:linear-gradient(135deg, #8b5cf6, #6d28d9)">📊</div>
            <div class="tool-title">Analisis Pasar</div>
            <div class="tool-desc">Riset kompetitor dan analisa peluang pasar</div>
            <a href="<?= site_url('analisis'); ?>">Analisis</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon" style="background:linear-gradient(135deg, #f59e0b, #ea580c)">🛡️</div>
            <div class="tool-title">Manajemen Risiko</div>
            <div class="tool-desc">Identifikasi dan antisipasi risiko bisnis sejak dini</div>
            <a href="<?= site_url('risiko'); ?>">Kelola Risiko</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon" style="background:linear-gradient(135deg, #ec4899, #be185d)">📄</div>
            <div class="tool-title">Template Dokumen</div>
            <div class="tool-desc">Template proposal, invoice, dan dokumen bisnis lainnya</div>
            <a href="#templates">Download Template</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon" style="background:linear-gradient(135deg, #10b981, #059669)">📚</div>
            <div class="tool-title">Panduan UMKM</div>
            <div class="tool-desc">Artikel dan tutorial lengkap untuk UMKM pemula</div>
            <a href="#guides">Baca Panduan</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon" style="background:linear-gradient(135deg, #ef4444, #dc2626)">💳</div>
            <div class="tool-title">Simulasi Pinjaman</div>
            <div class="tool-desc">Hitung cicilan dan bunga pinjaman modal usaha</div>
            <a href="#loan">Simulasi</a>
        </div>

        <div class="tool-box">
            <div class="tool-icon" style="background:linear-gradient(135deg, #14b8a6, #0d9488)">🎓</div>
            <div class="tool-title">Pelatihan Gratis</div>
            <div class="tool-desc">Webinar, workshop, dan kursus gratis untuk UMKM</div>
            <a href="#training">Ikuti Pelatihan</a>
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
