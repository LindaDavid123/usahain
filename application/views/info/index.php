<?php
$user = array_merge([
    'nama'  => 'User',
    'email' => '-',
    'role'  => '-',
    'usaha' => 'Bisnis Anda',
    'type'  => 'UMKM'
], $user ?? []);
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,user-scalable=yes">
<meta name="theme-color" content="#1C6494">
<title>Rekomendasi Informasi Bisnis - <?= htmlspecialchars($user['nama']); ?></title>

<style>
:root {
    --primary-color: #4A90E2;
    --primary-dark: #357ABD;
    --primary-light: #6BA4EC;
    --secondary-color: #7EC8E3;
    --secondary-light: #A8DCE8;
    --accent-color: #52D79A;
    --accent-dark: #2ecc71;
    --background: #F5F8FA;
    --card-bg: #ffffff;
    --text-primary: #2D3748;
    --text-secondary: #718096;
    --shadow-sm: 0 2px 8px rgba(74,144,226,0.08);
    --shadow-md: 0 4px 16px rgba(74,144,226,0.12);
    --shadow-lg: 0 8px 24px rgba(74,144,226,0.16);
}

*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Inter,Segoe UI,Arial;background:var(--background);color:var(--text-primary);line-height:1.6}

/* HEADER / NAVBAR */
.header{
    background:linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
    padding:20px 32px;
    color:#fff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:var(--shadow-md);
    position:sticky;
    top:0;
    z-index:100
}

.header h3{font-size:20px;font-weight:700}
.header small{opacity:.9}

.header-right{
    display:flex;
    align-items:center;
    gap:14px
}

.avatar{
    width:46px;height:46px;border-radius:50%;
    background:var(--card-bg);
    color:var(--primary-color);
    display:flex;align-items:center;justify-content:center;
    font-weight:700;
    box-shadow:var(--shadow-sm);
    border:2px solid rgba(255,255,255,0.3)
}

.logout-btn{
    background:rgba(255,255,255,.18);
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
    background:rgba(255,255,255,.3);
    border-color:rgba(255,255,255,0.5);
    transform:translateY(-1px);
    box-shadow:0 4px 12px rgba(0,0,0,0.15)
}

/* CONTAINER */
.container{max-width:1200px;margin:0 auto;padding:0 24px}

/* BANNER SECTION */
.info-banner{
    background:linear-gradient(135deg, var(--secondary-light) 0%, var(--secondary-color) 100%);
    color:#fff;
    padding:40px 32px;
    border-radius:16px;
    margin:30px 0;
    text-align:center;
    box-shadow:var(--shadow-md)
}

.info-banner h1{
    font-size:28px;
    font-weight:700;
    margin-bottom:10px
}

.info-banner p{
    font-size:14px;
    opacity:.95;
    max-width:600px;
    margin:0 auto
}

/* SEARCH & FILTER */
.controls-wrapper{
    display:flex;
    gap:12px;
    margin:30px 0 20px;
    flex-wrap:wrap;
    align-items:center
}

.search-box{
    flex:1;
    min-width:250px;
    position:relative
}

.search-box input{
    width:100%;
    padding:12px 16px 12px 44px;
    border:2px solid #e2e8f0;
    border-radius:10px;
    font-size:14px;
    transition:.3s ease;
    background:#fff
}

.search-box input:focus{
    outline:none;
    border-color:var(--primary-color);
    box-shadow:0 0 0 3px rgba(74,144,226,0.1)
}

.search-box::before{
    content:"🔍";
    position:absolute;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    font-size:18px
}

.filter-group{
    display:flex;
    gap:8px;
    flex-wrap:wrap
}

.filter-btn{
    padding:10px 18px;
    border:2px solid #e2e8f0;
    background:#fff;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    transition:.3s ease;
    color:var(--text-secondary)
}

.filter-btn:hover{
    border-color:var(--primary-color);
    color:var(--primary-color)
}

.filter-btn.active{
    background:var(--primary-color);
    border-color:var(--primary-color);
    color:#fff
}

/* SECTION TITLE */
.section-title{
    font-size:22px;
    font-weight:700;
    margin:40px 0 24px;
    color:var(--primary-color);
    text-align:center;
    padding:20px 0;
    border-bottom:3px solid var(--secondary-light);
    display:inline-block;
    width:100%
}

/* CARDS GRID */
.cards-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:20px;
    margin-bottom:40px
}

.info-card{
    background:var(--card-bg);
    border-radius:12px;
    padding:28px;
    box-shadow:var(--shadow-sm);
    transition:.3s ease;
    border:2px solid transparent;
    border-left:4px solid var(--primary-color);
    position:relative;
    overflow:hidden;
    display:flex;
    flex-direction:column
}

.info-card:hover{
    transform:translateY(-4px);
    box-shadow:var(--shadow-lg);
    border-color:var(--secondary-light)
}

.info-card .icon{
    font-size:40px;
    margin-bottom:12px;
    display:block
}

.info-card h3{
    font-size:16px;
    font-weight:700;
    margin-bottom:12px;
    color:var(--text-primary);
    line-height:1.3
}

.info-card p{
    font-size:13px;
    color:var(--text-secondary);
    line-height:1.6;
    margin-bottom:16px;
    flex:1
}

.info-card ul{
    font-size:12px;
    color:var(--text-secondary);
    margin:16px 0;
    padding-left:20px;
}

.info-card ul li{
    margin-bottom:8px;
    line-height:1.5
}

.card-actions{
    display:flex;
    gap:8px;
    margin-top:auto
}

.btn-info, .btn-bookmark{
    padding:10px 18px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
    border:none;
    cursor:pointer;
    transition:.3s ease;
    display:inline-flex;
    align-items:center;
    gap:6px
}

.btn-info{
    background:linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
    color:#fff;
    flex:1
}

.btn-info:hover{
    transform:translateY(-2px);
    box-shadow:var(--shadow-md)
}

.btn-bookmark{
    background:#f7fafc;
    color:var(--text-secondary);
    border:2px solid #e2e8f0
}

.btn-bookmark:hover{
    background:#edf2f7;
    border-color:var(--primary-color);
    color:var(--primary-color)
}

.btn-bookmark.active{
    background:var(--accent-color);
    border-color:var(--accent-color);
    color:#fff
}

/* TIP CARDS */
.tip-card{
    background:var(--card-bg);
    border-radius:12px;
    padding:28px;
    box-shadow:var(--shadow-sm);
    transition:.3s ease;
    border:2px solid transparent;
    text-align:center;
    position:relative;
}

.tip-card:hover{
    transform:translateY(-4px);
    box-shadow:var(--shadow-md);
    border-color:var(--secondary-light)
}

.tip-card .icon{
    font-size:48px;
    margin-bottom:12px;
    display:block
}

.tip-card h3{
    font-size:16px;
    font-weight:700;
    margin-bottom:12px;
    color:var(--text-primary)
}

.tip-card p{
    font-size:13px;
    color:var(--text-secondary);
    line-height:1.6
}

/* RESOURCE SECTION - Accordion */
.resources-section{
    margin-bottom:40px
}

.resource-item{
    background:var(--card-bg);
    border-radius:12px;
    margin-bottom:12px;
    box-shadow:var(--shadow-sm);
    overflow:hidden;
    transition:.3s ease
}

.resource-header{
    padding:20px 24px;
    cursor:pointer;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
    color:#fff;
    font-weight:600;
    user-select:none;
    transition:.3s ease
}

.resource-header:hover{
    box-shadow:var(--shadow-md)
}

.resource-header .icon{
    margin-right:12px;
    font-size:24px
}

.resource-header .toggle{
    font-size:20px;
    transition:.3s ease
}

.resource-header.active .toggle{
    transform:rotate(180deg)
}

.resource-content{
    padding:0;
    max-height:0;
    overflow:hidden;
    transition:max-height 0.3s ease;
}

.resource-content.active{
    padding:20px 24px;
    max-height:2000px
}

.resource-content p{
    font-size:13px;
    color:var(--text-secondary);
    line-height:1.7;
    margin-bottom:12px
}

.resource-content ul{
    font-size:13px;
    color:var(--text-secondary);
    margin-left:20px;
    margin-bottom:12px
}

.resource-content ul li{
    margin-bottom:8px;
    line-height:1.6
}

.resource-links{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    margin-top:12px
}

.resource-link{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 14px;
    background:#f7fafc;
    border:1px solid #e2e8f0;
    border-radius:6px;
    font-size:12px;
    color:var(--primary-color);
    text-decoration:none;
    transition:.3s ease
}

.resource-link:hover{
    background:var(--primary-color);
    color:#fff;
    transform:translateY(-2px)
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    z-index:1000;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(4px);
    animation:fadeIn 0.3s ease
}

.modal.active{
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px
}

.modal-content{
    background:var(--card-bg);
    border-radius:16px;
    max-width:600px;
    width:100%;
    max-height:85vh;
    overflow-y:auto;
    box-shadow:var(--shadow-lg);
    animation:slideUp 0.3s ease
}

.modal-header{
    padding:24px;
    border-bottom:2px solid #e2e8f0;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:sticky;
    top:0;
    background:var(--card-bg);
    z-index:10
}

.modal-header h2{
    font-size:20px;
    color:var(--primary-color)
}

.modal-close{
    width:32px;
    height:32px;
    border-radius:50%;
    background:#f7fafc;
    border:none;
    cursor:pointer;
    font-size:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.3s ease
}

.modal-close:hover{
    background:#e2e8f0;
    transform:rotate(90deg)
}

.modal-body{
    padding:24px
}

.modal-body h3{
    font-size:16px;
    color:var(--text-primary);
    margin:16px 0 8px;
    display:flex;
    align-items:center;
    gap:8px
}

.modal-body p, .modal-body li{
    font-size:14px;
    color:var(--text-secondary);
    line-height:1.7
}

.modal-body ul{
    margin:12px 0;
    padding-left:24px
}

.modal-body li{
    margin-bottom:8px
}

.info-badge{
    display:inline-flex;
    align-items:center;
    gap:4px;
    padding:4px 10px;
    background:var(--secondary-light);
    color:var(--primary-dark);
    border-radius:12px;
    font-size:11px;
    font-weight:600;
    margin-top:8px
}

@keyframes fadeIn{
    from{opacity:0}
    to{opacity:1}
}

@keyframes slideUp{
    from{transform:translateY(30px);opacity:0}
    to{transform:translateY(0);opacity:1}
}

/* FOOTER */
.footer-simple {
    width: 100%;
    background: #f8fbfd;
    border-top: 1px solid #e6eef5;
    padding: 12px 0;
    font-size: 13px;
    color: #6c757d;
    margin-top:60px
}

.footer-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.footer-inner a{
    color:#6c757d;
    text-decoration:none;
    transition:.3s ease
}

.footer-inner a:hover{
    color:var(--primary-color)
}

/* TOAST NOTIFICATION */
.toast{
    position:fixed;
    bottom:24px;
    right:24px;
    background:var(--card-bg);
    padding:16px 20px;
    border-radius:10px;
    box-shadow:var(--shadow-lg);
    display:flex;
    align-items:center;
    gap:12px;
    min-width:280px;
    z-index:2000;
    animation:slideInRight 0.3s ease;
    border-left:4px solid var(--accent-color)
}

.toast.hide{
    animation:slideOutRight 0.3s ease;
}

@keyframes slideInRight{
    from{transform:translateX(400px);opacity:0}
    to{transform:translateX(0);opacity:1}
}

@keyframes slideOutRight{
    from{transform:translateX(0);opacity:1}
    to{transform:translateX(400px);opacity:0}
}

.toast-icon{
    font-size:24px
}

.toast-message{
    flex:1;
    font-size:14px;
    color:var(--text-primary)
}

.no-results{
    text-align:center;
    padding:60px 20px;
    color:var(--text-secondary)
}

.no-results .icon{
    font-size:64px;
    margin-bottom:16px;
    opacity:.5
}

.no-results h3{
    font-size:18px;
    margin-bottom:8px
}

.no-results p{
    font-size:14px
}

/* RESPONSIVE */
@media(max-width:768px){
    .header{padding:16px 20px}
    .header h3{font-size:18px}
    .avatar{width:38px;height:38px}
    
    .container{padding:0 16px}
    
    .info-banner{padding:30px 20px;margin:20px 0}
    .info-banner h1{font-size:22px}
    .info-banner p{font-size:13px}
    
    .controls-wrapper{flex-direction:column}
    .search-box{min-width:100%}
    
    .section-title{font-size:18px;margin:30px 0 16px}
    
    .cards-grid{grid-template-columns:1fr;gap:16px}
    
    .footer-inner{flex-direction:column;text-align:center}
    
    .toast{
        bottom:12px;
        right:12px;
        left:12px;
        min-width:auto
    }
}

@media(max-width:576px){
    .header{padding:14px 16px}
    .header h3{font-size:16px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .header small{display:none}
    
    .container{padding:0 12px}
    
    .info-banner{padding:24px 16px;border-radius:12px;margin:16px 0}
    .info-banner h1{font-size:20px}
    
    .section-title{font-size:16px;margin:24px 0 12px}
    
    .info-card,.tip-card{padding:20px}
    .info-card .icon,.tip-card .icon{font-size:32px}
    .info-card h3,.tip-card h3{font-size:14px}
    .info-card p,.tip-card p{font-size:12px}
    
    .card-actions{flex-direction:column}
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div>
        <h3>ℹRekomendasi Informasi Bisnis</h3>
    </div>

    <div class="header-right">
        <a href="<?= base_url('auth/logout'); ?>" 
           class="logout-btn"
           onclick="return confirm('Yakin ingin logout?')">
           Logout
        </a>
        <div class="avatar"><?= strtoupper(substr($user['nama'],0,1)); ?></div>
    </div>
</div>

<div class="container">

    <!-- BANNER -->
    <div class="info-banner">
        <h1>Rekomendasi Informasi Bisnis</h1>
        <p>Pelajari langkah-langkah penting, strategi, dan tips untuk sukses UMKM Indonesia</p>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="controls-wrapper">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari informasi bisnis..." onkeyup="filterCards()">
        </div>
        <div class="filter-group">
            <button class="filter-btn active" onclick="filterByCategory('semua')">Semua</button>
            <button class="filter-btn" onclick="filterByCategory('izin')">Izin & Legal</button>
            <button class="filter-btn" onclick="filterByCategory('tips')">Tips Bisnis</button>
            <button class="filter-btn" onclick="filterByCategory('sumber-daya')">Sumber Daya</button>
        </div>
    </div>

    <!-- SECTION 1: LEGALISITAS & PERIZINAN -->
    <div class="section-title" id="section-izin">📋 Legalisitas & Perizinan Usaha</div>
    <div class="cards-grid" id="izinCards">
        <div class="info-card" data-category="izin" data-keywords="siup izin tempat kerja operasional">
            <span class="icon">📄</span>
            <h3>Surat Izin Tempat Usaha (SIUP)</h3>
            <p>Izin dasar untuk operasional tempat usaha</p>
            <ul>
                <li>Persyaratan: KTP, surat keterangan dari kelurahan</li>
                <li>Proses: Permohonan ke DPMPTSP setempat</li>
                <li>Masa berlaku: 5 tahun</li>
            </ul>
            <div class="card-actions">
                <button class="btn-info" onclick="showDetailModal('siup')">📖 Detail</button>
                <button class="btn-bookmark" onclick="toggleBookmark(this)">🔖</button>
            </div>
        </div>

        <div class="info-card" data-category="izin" data-keywords="pirt izin edar produk makanan">
            <span class="icon">📋</span>
            <h3>PIRT (Pangan Industri Rumah Tangga)</h3>
            <p>Izin khusus untuk produk makanan/minuman</p>
            <ul>
                <li>Untuk: Produk makanan dan minuman</li>
                <li>Proses: Uji lab, dokumentasi produksi</li>
                <li>Durasi: 2-4 minggu</li>
            </ul>
            <div class="card-actions">
                <button class="btn-info" onclick="showDetailModal('pirt')">📖 Detail</button>
                <button class="btn-bookmark" onclick="toggleBookmark(this)">🔖</button>
            </div>
        </div>

        <div class="info-card" data-category="izin" data-keywords="sertifikat industri rumah tangga irt">
            <span class="icon">🏭</span>
            <h3>Sertifikat Industri Rumah Tangga</h3>
            <p>Sertifikat untuk usaha mikro di rumah</p>
            <ul>
                <li>Untuk: UMKM dengan produksi di rumah</li>
                <li>Persyaratan: Permohonan sederhana, verifikasi</li>
                <li>Manfaat: Legalitas + akses pasar lebih luas</li>
            </ul>
            <div class="card-actions">
                <button class="btn-info" onclick="showDetailModal('irt')">📖 Detail</button>
                <button class="btn-bookmark" onclick="toggleBookmark(this)">🔖</button>
            </div>
        </div>

        <div class="info-card" data-category="izin" data-keywords="halal sertifikasi bpjph">
            <span class="icon">✨</span>
            <h3>Sertifikasi Halal</h3>
            <p>Sertifikasi halal untuk produk konsumsi</p>
            <ul>
                <li>Wajib untuk: Produk makanan & minuman</li>
                <li>Proses: Permohonan ke BPJPH, audit dokumen</li>
                <li>Masa berlaku: 4 tahun</li>
            </ul>
            <div class="card-actions">
                <button class="btn-info" onclick="showDetailModal('halal')">📖 Detail</button>
                <button class="btn-bookmark" onclick="toggleBookmark(this)">🔖</button>
            </div>
        </div>

        <div class="info-card" data-category="izin" data-keywords="merek dagang hki trademark">
            <span class="icon">™️</span>
            <h3>Pendaftaran Merek Dagang</h3>
            <p>Perlindungan hukum untuk brand Anda</p>
            <ul>
                <li>Fungsi: Proteksi dari peniruan merek</li>
                <li>Proses: Permohonan ke Ditjen HKI Kemenkumham</li>
                <li>Durasi: 1-2 tahun</li>
            </ul>
            <div class="card-actions">
                <button class="btn-info" onclick="showDetailModal('merek')">📖 Detail</button>
                <button class="btn-bookmark" onclick="toggleBookmark(this)">🔖</button>
            </div>
        </div>

        <div class="info-card" data-category="izin" data-keywords="bpom obat suplemen kosmetik">
            <span class="icon">🏥</span>
            <h3>Izin BPOM</h3>
            <p>Izin dari Badan POM untuk produk kesehatan</p>
            <ul>
                <li>Untuk: Obat tradisional, suplemen, kosmetik</li>
                <li>Persyaratan: Dokumen teknis, uji lab BPOM</li>
                <li>Validitas: 5 tahun</li>
            </ul>
            <div class="card-actions">
                <button class="btn-info" onclick="showDetailModal('bpom')">📖 Detail</button>
                <button class="btn-bookmark" onclick="toggleBookmark(this)">🔖</button>
            </div>
        </div>
    </div>

    <!-- SECTION 2: TIPS SUKSES MEMBANGUN UMKM -->
    <div class="section-title" id="section-tips">💡 Tips Sukses Membangun UMKM</div>
    <div class="cards-grid" id="tipsCards">
        <div class="tip-card" data-category="tips" data-keywords="manajemen operasional efisiensi">
            <span class="icon">🎯</span>
            <h3>Kelola Manajemen Usaha Anda</h3>
            <p>Terapkan sistem manajemen yang terstruktur untuk meningkatkan efisiensi operasional dan profitabilitas bisnis Anda secara berkelanjutan.</p>
        </div>

        <div class="tip-card" data-category="tips" data-keywords="digital marketing media sosial online">
            <span class="icon">📱</span>
            <h3>Manfaatkan Digital Marketing</h3>
            <p>Gunakan media sosial, website, dan email marketing untuk menjangkau audiens lebih luas dengan biaya yang lebih efisien dan terukur.</p>
        </div>

        <div class="tip-card" data-category="tips" data-keywords="kualitas produk pelanggan standar">
            <span class="icon">⭐</span>
            <h3>Fokus pada Kualitas Produk</h3>
            <p>Kualitas adalah kunci loyalitas pelanggan. Jaga standar produk, dengarkan feedback, dan terus improve berdasarkan kebutuhan pasar.</p>
        </div>

        <div class="tip-card" data-category="tips" data-keywords="kompetitor analisis strategi">
            <span class="icon">🔍</span>
            <h3>Analisis Kompetitor</h3>
            <p>Pelajari strategi kompetitor, identifikasi keunggulan mereka, dan cari celah pasar untuk diferensiasi produk atau layanan Anda.</p>
        </div>

        <div class="tip-card" data-category="tips" data-keywords="networking kemitraan jaringan">
            <span class="icon">🤝</span>
            <h3>Bangun Jaringan & Kemitraan</h3>
            <p>Networking adalah aset berharga. Bergabunglah dengan komunitas bisnis, bangun kemitraan strategis, dan perluas jaringan supplier.</p>
        </div>

        <div class="tip-card" data-category="tips" data-keywords="keuangan cash flow laporan">
            <span class="icon">💰</span>
            <h3>Kelola Keuangan dengan Baik</h3>
            <p>Kelola keuangan dengan disiplin, pisahkan dana pribadi dan bisnis,