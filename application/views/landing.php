<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Usahain - Landing Page</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    :root{
      --brand-1: #1C6494;
      --brand-2: #2980b9;
      --accent: #65C1DF;
      --muted-bg: #f0f4f8;
      --blue-main:#1C6494;
    }

    body { 
      font-family: 'Inter', sans-serif; 
      background:var(--muted-bg);
      overflow-x:hidden;
    }

    .container{
      max-width:1200px !important;
    }

    /* NAVBAR UPDATED */
    .navbar {
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 16px rgba(0,0,0,0.06);
      padding: 14px 0;
      border-radius: 0 0 24px 24px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar-brand{
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
      font-size: 1.4rem;
      color: #1C6494 !important;
      transition: .3s;
    }

    .navbar-brand:hover{
      transform: scale(1.05);
    }

    .navbar-brand img{
      width: 45px;
      height: 45px;
    }

    .nav-link{
      color: #475569 !important;
      font-weight: 500;
      font-size: 0.95rem;
      transition: all .3s;
      padding: 10px 18px !important;
      margin: 0 6px;
      border-radius: 8px;
    }

    .nav-link:hover{
      color: #1C6494 !important;
      background: rgba(28, 100, 148, 0.05);
    }

    .nav-link.active{
      color: #1C6494 !important;
      font-weight: 600;
      background: rgba(28, 100, 148, 0.08);
    }

    .btn-login{
      background: white !important;
      border: 1.5px solid #e2e8f0 !important;
      color: #475569 !important;
      padding: 10px 24px !important;
      border-radius: 10px !important;
      font-weight: 600;
      transition: all .3s;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .btn-login:hover{
      background: #f8fafc !important;
      border-color: #1C6494 !important;
      color: #1C6494 !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(28, 100, 148, 0.15);
    }

    .btn-signup{
      background: linear-gradient(135deg, #1C6494, #2563eb) !important;
      border: none !important;
      color: white !important;
      padding: 10px 26px !important;
      border-radius: 10px !important;
      font-weight: 600;
      transition: all .3s;
      margin-left: 12px !important;
      box-shadow: 0 4px 12px rgba(28, 100, 148, 0.25);
    }

    .btn-signup:hover{
      background: linear-gradient(135deg, #164f75, #1d4ed8) !important;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(28, 100, 148, 0.35);
    }

    .btn-primary{
      background:#1C6494 !important;
      border-color:#1C6494 !important;
    }

    /* ICON WRAPPER */
    .feature-icon-sm{
      width:64px;
      height:64px;
      border-radius:14px;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:10px;
      background: linear-gradient(to bottom, #e6f7ff, #1e5a88);
      box-shadow:0 8px 20px rgba(2,6,23,0.06);
      flex: 0 0 64px;
    }

    .feature-icon-sm img{
      width:38px;
      height:38px;
      object-fit:contain;
    }

    /* HERO */
    .hero {
      background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #93c5fd 100%);
      padding: 100px 20px 80px;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
      border-radius: 50%;
    }

    .hero::after {
      content: '';
      position: absolute;
      bottom: -30%;
      left: -10%;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(28,100,148,0.1) 0%, transparent 70%);
      border-radius: 50%;
    }

    .hero-content {
      text-align: left;
      padding-right: 40px;
      position: relative;
      z-index: 2;
    }

    .hero h1 {
      color: #1e293b;
      font-size: 3.2rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      line-height: 1.15;
      letter-spacing: -0.02em;
    }

    .hero .highlight {
      color: #1C6494;
      position: relative;
      display: inline-block;
    }

    .hero .highlight::after {
      content: '';
      position: absolute;
      bottom: 4px;
      left: 0;
      right: 0;
      height: 12px;
      background: rgba(28, 100, 148, 0.2);
      z-index: -1;
      border-radius: 4px;
    }

    .hero p.lead {
      color: #475569;
      font-size: 1.15rem;
      margin-bottom: 2.5rem;
      line-height: 1.7;
      font-weight: 400;
    }

    .btn-get-started {
      background: linear-gradient(135deg, #1C6494, #2563eb) !important;
      color: white !important;
      padding: 14px 32px !important;
      border-radius: 12px !important;
      font-weight: 700;
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: all .3s;
      box-shadow: 0 8px 24px rgba(28, 100, 148, 0.3);
      font-size: 1.05rem;
    }

    .btn-get-started:hover {
      background: linear-gradient(135deg, #164f75, #1d4ed8) !important;
      transform: translateY(-3px);
      box-shadow: 0 12px 32px rgba(28, 100, 148, 0.4);
    }

    .hero-illustration {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 450px;
      z-index: 2;
    }

    .hero-illustration img {
      max-width: 100%;
      height: auto;
      filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));
    }

    .testimonial-card {
      background: white;
      padding: 16px 20px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      position: absolute;
      bottom: 60px;
      right: 20px;
      max-width: 280px;
      display: flex;
      gap: 12px;
      align-items: start;
    }

    .testimonial-card img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }

    .testimonial-card p {
      margin: 0;
      font-size: 13px;
      color: #4a5568;
      line-height: 1.5;
    }

    /* STAT CARD MODERN */
    .stat-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      padding: 20px 24px;
      box-shadow: 0 4px 20px rgba(28, 100, 148, 0.12);
      transition: all .3s ease;
      border: 1px solid rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(10px);
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 32px rgba(28, 100, 148, 0.2);
      background: white;
    }

    .stat-number {
      font-size: 32px;
      font-weight: 800;
      background: linear-gradient(135deg, #1C6494, #2563eb);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 4px;
    }

    .stat-label {
      font-size: 12px;
      margin-top: 4px;
      color: #64748b;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* FEATURES SECTION */
    .features-header {
      text-align: center;
      margin-bottom: 70px;
    }

    .features-subtitle {
      color: #1C6494;
      text-transform: uppercase;
      font-weight: 700;
      font-size: 0.85rem;
      letter-spacing: 2px;
      margin-bottom: 16px;
      display: inline-block;
      padding: 6px 20px;
      background: rgba(28, 100, 148, 0.1);
      border-radius: 20px;
    }

    .features-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: #1e293b;
      margin-bottom: 16px;
      line-height: 1.2;
    }

    .features-description {
      color: #64748b;
      font-size: 1.1rem;
      max-width: 700px;
      margin: 0 auto;
      line-height: 1.7;
    }

    /* FITUR CARD */
    .feature-card {
      border-radius: 20px;
      padding: 40px 35px;
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      box-shadow: 0 4px 20px rgba(28, 100, 148, 0.08);
      height: 100%;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: default;
      border: 2px solid rgba(255, 255, 255, 0.8);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #1C6494, #2563eb, #1C6494);
      transform: scaleX(0);
      transition: transform 0.4s;
    }

    .feature-card:hover::before {
      transform: scaleX(1);
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(28, 100, 148, 0.15);
      background: white;
      border-color: rgba(28, 100, 148, 0.2);
    }

    .feature-card .illustration {
      width: 100%;
      max-width: 240px;
      height: 180px;
      margin: 0 auto 28px;
      background: linear-gradient(135deg, rgba(28, 100, 148, 0.08) 0%, rgba(37, 99, 235, 0.08) 100%);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
      box-shadow: 0 4px 16px rgba(28, 100, 148, 0.06);
      transition: all 0.4s;
      position: relative;
    }

    .feature-card:hover .illustration {
      background: linear-gradient(135deg, rgba(28, 100, 148, 0.12) 0%, rgba(37, 99, 235, 0.12) 100%);
      transform: scale(1.05);
    }

    .feature-card .illustration::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 60%;
      height: 8px;
      background: rgba(28, 100, 148, 0.1);
      border-radius: 50%;
      filter: blur(4px);
    }

    .feature-card .illustration img {
      width: 90px;
      height: 90px;
      object-fit: contain;
      filter: drop-shadow(0 4px 8px rgba(28, 100, 148, 0.15));
      transition: transform 0.4s;
    }

    .feature-card:hover .illustration img {
      transform: scale(1.1) rotate(5deg);
    }

    .feature-card h5 {
      font-size: 1.35rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 14px;
      transition: color 0.3s;
    }

    .feature-card:hover h5 {
      color: #1C6494;
    }

    .feature-card p {
      font-size: 0.98rem;
      color: #64748b;
      line-height: 1.7;
      margin-bottom: 0;
    }
    .feature-row{
      display:flex;
      gap:16px;
      align-items:flex-start;
      text-align:left;
    }

    /* FITUR TAMBAHAN UPDATED */
    .feature-section-gradient{
      background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
      padding-top: 80px;
      padding-bottom: 80px;
      position: relative;
    }

    .feature-section-gradient::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(28, 100, 148, 0.2), transparent);
    }

    .section-title-main {
      text-align: center;
      margin-bottom: 50px;
    }

    .section-title-main h3 {
      font-size: 2.2rem;
      font-weight: 800;
      color: #1e293b;
      position: relative;
      display: inline-block;
    }

    .section-title-main h3::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, #1C6494, #2563eb);
      border-radius: 2px;
    }

    .section-subtitle {
      text-align: center;
      color: #6b7280;
      margin-bottom: 48px;
      font-size: 1.05rem
      padding-bottom:40px;
    }

    /* WHY BOX */
    .why-section {
      background: #f8fafc;
      padding: 80px 0;
    }

    .why-content-left {
      padding-right: 50px;
    }

    .why-content-left h3 {
      font-size: 2.5rem;
      font-weight: 800;
      color: #1e293b;
      margin-bottom: 24px;
      line-height: 1.2;
    }

    .why-content-left p {
      color: #64748b;
      font-size: 1rem;
      line-height: 1.7;
      margin-bottom: 16px;
    }

    .why-btn {
      background: linear-gradient(135deg, #1C6494, #2563eb);
      color: white;
      padding: 14px 36px;
      border-radius: 12px;
      font-weight: 700;
      border: none;
      display: inline-block;
      text-decoration: none;
      transition: all 0.3s;
      box-shadow: 0 8px 24px rgba(28, 100, 148, 0.3);
      margin-top: 20px;
    }

    .why-btn:hover {
      background: linear-gradient(135deg, #164f75, #1d4ed8);
      transform: translateY(-3px);
      box-shadow: 0 12px 32px rgba(28, 100, 148, 0.4);
      color: white;
    }

    .why-box {
      background: white;
      padding: 32px 28px;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(28, 100, 148, 0.08);
      height: 100%;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      border: 2px solid rgba(255, 255, 255, 0.8);
      position: relative;
    }

    .why-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #1C6494, #2563eb);
      border-radius: 20px 20px 0 0;
      transform: scaleX(0);
      transition: transform 0.4s;
    }

    .why-box:hover::before {
      transform: scaleX(1);
    }

    .why-box:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 40px rgba(28, 100, 148, 0.15);
      border-color: rgba(28, 100, 148, 0.2);
    }

    .why-icon {
      width: 80px;
      height: 80px;
      border-radius: 16px;
      margin: 0 0 20px 0;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.4s;
    }

    .why-box:hover .why-icon {
      transform: scale(1.1) rotate(5deg);
    }

    .why-box h6 {
      font-size: 1.15rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 12px;
    }

    .why-box p {
      color: #64748b;
      font-size: 0.95rem;
      line-height: 1.6;
      margin-bottom: 0;
    }

    @media(max-width:991px){
      .navbar-brand{
        font-size: 1.2rem;
      }
      .hero h1{
        font-size: 2.5rem;
      }
      .features-title{
        font-size: 2rem;
      }
    }

    @media(max-width:768px){
      .hero{
        padding: 60px 20px 50px;
      }
      .hero h1{
        font-size: 2rem;
      }
      .hero p.lead{
        font-size: 1rem;
      }
      .hero-content{
        padding-right: 0;
        text-align: center;
      }
      .btn-get-started{
        padding: 12px 24px !important;
        font-size: 0.95rem;
      }
      .feature-row{
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
      }
      .feature-icon-sm{
        margin-bottom: 10px;
      }
      .features-title{
        font-size: 1.75rem;
      }
      .stat-card{
        margin-bottom: 12px;
      }
    }

    @media(max-width:576px){
      .hero h1{
        font-size: 1.75rem;
      }
      .navbar-brand{
        font-size: 1.1rem;
      }
      .btn-login, .btn-signup{
        padding: 8px 16px !important;
        font-size: 0.9rem;
      }
    }

  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    
    <!-- Logo -->
    <a class="navbar-brand" href="<?= site_url(); ?>">
      <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="">
        <circle cx="16" cy="16" r="16" fill="#1C6494"/>
        <path d="M12 10h8a2 2 0 012 2v8a2 2 0 01-2 2h-8a2 2 0 01-2-2v-8a2 2 0 012-2z" fill="white"/>
        <circle cx="16" cy="16" r="3" fill="#1C6494"/>
      </svg>
      Usahain
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Content -->
    <div class="collapse navbar-collapse" id="navbarContent">
      
      <!-- Center Menu -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
        <li class="nav-item"><a class="nav-link" href="#how-it-works">Cara Kerja</a></li>
        <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
      </ul>

      <!-- Right Buttons -->
      <div class="d-flex align-items-center gap-2">
        <a class="btn btn-login" href="<?= site_url('auth/login'); ?>">Login</a>
        <a class="btn btn-signup" href="<?= site_url('auth/register'); ?>">Sign Up</a>
      </div>

    </div>

  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center">
      
      <!-- Left Content -->
      <div class="col-lg-5 col-md-12 mb-5 mb-lg-0">
        <div class="hero-content">
          <h1 class="fw-bold" style="font-size: 2.8rem; line-height: 1.2; margin-bottom: 20px;">
            Mulai Usaha Jadi <span class="highlight">Mudah</span>
          </h1>
          <p class="lead" style="color: #64748b; font-size: 1rem; line-height: 1.6; margin-bottom: 30px;">
            Platform terpadu untuk memulai, mengelola, dan mengembangkan UMKM anda
          </p>
          
          <div class="d-flex gap-3 flex-wrap">
            <a href="<?= site_url('auth/register'); ?>" class="btn btn-get-started" style="padding: 12px 28px !important;">
              Mulai Sekarang
            </a>
            <a href="#features" class="btn" style="background: transparent; border: 2px solid #1C6494; color: #1C6494; padding: 10px 26px; border-radius: 10px; font-weight: 600; transition: all 0.3s;">
              Pelajari Lebih Lanjut
            </a>
          </div>
        </div>
      </div>

      <!-- Right Visualization -->
      <div class="col-lg-7 col-md-12">
        <div style="position: relative;">
          
          <!-- Statistics Cards Row - Top -->
          <div class="d-flex gap-3 justify-content-center justify-content-lg-end mb-4 flex-wrap">
            <div class="stat-card" style="min-width: 130px; padding: 18px 22px;">
              <div class="stat-number" style="font-size: 30px; margin-bottom: 6px;">10K</div>
              <div class="stat-label" style="font-size: 11px;">UMKM Terdaftar</div>
            </div>
            <div class="stat-card" style="min-width: 130px; padding: 18px 22px;">
              <div class="stat-number" style="font-size: 30px; margin-bottom: 6px;">95%</div>
              <div class="stat-label" style="font-size: 11px;">Tingkat Kepuasan</div>
            </div>
            <div class="stat-card" style="min-width: 130px; padding: 18px 22px;">
              <div class="stat-number" style="font-size: 30px; margin-bottom: 6px;">24/7</div>
              <div class="stat-label" style="font-size: 11px;">Support Tersedia</div>
            </div>
          </div>

          <!-- Chart Card - Bottom -->
          <div style="background: white; padding: 28px; border-radius: 20px; box-shadow: 0 10px 30px rgba(28, 100, 148, 0.12); position: relative;">
            
            <!-- Chart Header with Icon -->
            <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
              <svg width="22" height="22" viewBox="0 0 20 20" fill="#1C6494">
                <path d="M3 13h4v4H3v-4zm6-6h4v10H9V7zm6-4h4v14h-4V3z"/>
              </svg>
              <span style="font-size: 15px; color: #1e293b; font-weight: 700;">Top Produksi</span>
            </div>
            
            <!-- Main Content: Products List + Chart + AI Score -->
            <div class="d-flex gap-3 align-items-end flex-wrap">
              
              <!-- Left: Product Progress Bars -->
              <div style="flex: 1; min-width: 200px;">
                <div style="margin-bottom: 16px;">
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 13px; color: #64748b; font-weight: 500;">Kopi Arabica</span>
                    <span style="font-size: 13px; font-weight: 700; color: #1C6494;">48%</span>
                  </div>
                  <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                    <div style="background: linear-gradient(90deg, #60a5fa, #3b82f6); width: 48%; height: 100%; border-radius: 4px;"></div>
                  </div>
                </div>
                
                <div style="margin-bottom: 16px;">
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 13px; color: #64748b; font-weight: 500;">Kue Kering</span>
                    <span style="font-size: 13px; font-weight: 700; color: #1C6494;">35%</span>
                  </div>
                  <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                    <div style="background: linear-gradient(90deg, #60a5fa, #3b82f6); width: 35%; height: 100%; border-radius: 4px;"></div>
                  </div>
                </div>
                
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 13px; color: #64748b; font-weight: 500;">Brownies</span>
                    <span style="font-size: 13px; font-weight: 700; color: #1C6494;">30%</span>
                  </div>
                  <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                    <div style="background: linear-gradient(90deg, #60a5fa, #3b82f6); width: 30%; height: 100%; border-radius: 4px;"></div>
                  </div>
                </div>
              </div>
              
              <!-- Center: Vertical Bar Chart -->
              <div style="display: flex; align-items: flex-end; gap: 10px; height: 110px; padding: 0 10px;">
                <div style="background: linear-gradient(to top, #3b82f6, #60a5fa); width: 20px; height: 75%; border-radius: 6px 6px 0 0;"></div>
                <div style="background: linear-gradient(to top, #3b82f6, #60a5fa); width: 20px; height: 90%; border-radius: 6px 6px 0 0;"></div>
                <div style="background: linear-gradient(to top, #3b82f6, #60a5fa); width: 20px; height: 60%; border-radius: 6px 6px 0 0;"></div>
                <div style="background: linear-gradient(to top, #3b82f6, #60a5fa); width: 20px; height: 50%; border-radius: 6px 6px 0 0;"></div>
              </div>
              
              <!-- Right: AI Health Score Card -->
              <div style="background: linear-gradient(135deg, #1C6494, #2563eb); color: white; padding: 24px 28px; border-radius: 16px; text-align: center; min-width: 150px;">
                <div style="display: flex; align-items: center; gap: 8px; justify-content: center; margin-bottom: 12px;">
                  <svg width="18" height="18" viewBox="0 0 16 16" fill="white" opacity="0.9">
                    <circle cx="8" cy="8" r="6.5" stroke="white" stroke-width="1.2" fill="none"/>
                    <path d="M8 4v4l2.5 1.5" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
                  </svg>
                  <span style="font-size: 11px; font-weight: 700; opacity: 0.95; text-transform: uppercase; letter-spacing: 0.5px;">AI Health Score</span>
                </div>
                <div style="font-size: 48px; font-weight: 800; line-height: 1; margin: 8px 0;">85</div>
                <div style="font-size: 13px; opacity: 0.9; font-weight: 500;">Kondisi Baik</div>
              </div>
              
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- FITUR UNGGULAN -->
<section class="feature-section-gradient" id="features">
  <div class="container text-center">
    
    <!-- Header -->
    <div style="margin-bottom: 60px;">
      <p style="color: #1C6494; text-transform: uppercase; font-weight: 700; font-size: 0.85rem; letter-spacing: 2px; margin-bottom: 16px;">FITUR UNGGULAN</p>
      <h2 style="font-size: 2.2rem; font-weight: 800; color: #1e293b; margin-bottom: 16px;">Kami Siap Membantu Anda Memulai</h2>
      <p style="color: #64748b; font-size: 1.05rem; max-width: 600px; margin: 0 auto;">Solusi lengkap untuk berbagai kebutuhan bisnis UMKM</p>
    </div>

    <!-- Features Grid -->
    <div class="row g-4 justify-content-center mb-5">

      <!-- AI Advisor -->
      <div class="col-md-6 col-lg-3">
        <div style="background: white; padding: 36px 28px; border-radius: 20px; box-shadow: 0 4px 20px rgba(28, 100, 148, 0.08); height: 100%; transition: all 0.3s; border: 2px solid rgba(255, 255, 255, 0.8); text-align: center;">
          <div style="width: 80px; height: 80px; border-radius: 16px; margin: 0 auto 24px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #E2E8FF, #C7D2FE);">
            <img src="assets/icons/robot.png" width="46" alt="AI Advisor">
          </div>
          <h5 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin-bottom: 14px;">AI Advisor</h5>
          <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">Dapatkan rekomendasi ide usaha yang tepat berdasarkan modal, minat, dan lokasi Anda</p>
          <a href="<?= site_url('auth/login'); ?>" style="color: #1C6494; font-weight: 600; font-size: 0.95rem; text-decoration: none;">Login untuk Mulai →</a>
        </div>
      </div>

      <!-- Kalkulator HPP -->
      <div class="col-md-6 col-lg-3">
        <div style="background: white; padding: 36px 28px; border-radius: 20px; box-shadow: 0 4px 20px rgba(28, 100, 148, 0.08); height: 100%; transition: all 0.3s; border: 2px solid rgba(255, 255, 255, 0.8); text-align: center;">
          <div style="width: 80px; height: 80px; border-radius: 16px; margin: 0 auto 24px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #E2E8FF, #C7D2FE);">
            <img src="assets/icons/abacus.png" width="46" alt="Kalkulator HPP">
          </div>
          <h5 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin-bottom: 14px;">Kalkulator HPP</h5>
          <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">Hitung harga pokok produksi dan tentukan harga jual yang menguntungkan</p>
          <a href="<?= site_url('auth/login'); ?>" style="color: #1C6494; font-weight: 600; font-size: 0.95rem; text-decoration: none;">Hitung HPP →</a>
        </div>
      </div>

      <!-- Pencatatan Keuangan -->
      <div class="col-md-6 col-lg-3">
        <div style="background: white; padding: 36px 28px; border-radius: 20px; box-shadow: 0 4px 20px rgba(28, 100, 148, 0.08); height: 100%; transition: all 0.3s; border: 2px solid rgba(255, 255, 255, 0.8); text-align: center;">
          <div style="width: 80px; height: 80px; border-radius: 16px; margin: 0 auto 24px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #E2E8FF, #C7D2FE);">
            <img src="assets/icons/money-bags.png" width="46" alt="Pencatatan Keuangan">
          </div>
          <h5 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin-bottom: 14px;">Pencatatan Keuangan</h5>
          <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">Catat pemasukan dan pengeluaran dengan mudah, lihat laba rugi real-time</p>
          <a href="<?= site_url('auth/login'); ?>" style="color: #1C6494; font-weight: 600; font-size: 0.95rem; text-decoration: none;">Mulai Catat →</a>
        </div>
      </div>

      <!-- Manajemen Risiko -->
      <div class="col-md-6 col-lg-3">
        <div style="background: white; padding: 36px 28px; border-radius: 20px; box-shadow: 0 4px 20px rgba(28, 100, 148, 0.08); height: 100%; transition: all 0.3s; border: 2px solid rgba(255, 255, 255, 0.8); text-align: center;">
          <div style="width: 80px; height: 80px; border-radius: 16px; margin: 0 auto 24px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #E2E8FF, #C7D2FE);">
            <img src="assets/icons/shield.png" width="46" alt="Manajemen Risiko">
          </div>
          <h5 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin-bottom: 14px;">Manajemen Risiko</h5>
          <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">Identifikasi dan kelola risiko bisnis Anda dengan checklist praktis</p>
          <a href="<?= site_url('auth/login'); ?>" style="color: #1C6494; font-weight: 600; font-size: 0.95rem; text-decoration: none;">Kelola Risiko →</a>
        </div>
      </div>

    </div>

    <!-- Button -->
    <div>
      <a href="<?= site_url('auth/login'); ?>" style="background: linear-gradient(135deg, #1C6494, #2563eb); color: white; padding: 14px 40px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 8px 24px rgba(28, 100, 148, 0.3); transition: all 0.3s;">
        Lihat Semua Fitur
      </a>
    </div>

  </div>
</section>

<!-- PENAWARAN SPESIAL -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); position: relative; overflow: hidden;">
  
  <!-- Decorative Elements -->
  <div style="position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; background: linear-gradient(135deg, rgba(28, 100, 148, 0.08), rgba(37, 99, 235, 0.08)); border-radius: 50%; filter: blur(40px);"></div>
  <div style="position: absolute; bottom: -80px; right: -80px; width: 300px; height: 300px; background: linear-gradient(135deg, rgba(255, 193, 7, 0.08), rgba(255, 152, 0, 0.08)); border-radius: 50%; filter: blur(60px);"></div>
  
  <div class="container" style="position: relative; z-index: 2;">
    <div class="row align-items-center">
      
      <!-- Left Content -->
      <div class="col-lg-5 col-md-12 mb-5 mb-lg-0">
        <div style="padding-right: 40px;">
          <h2 style="font-size: 2.8rem; font-weight: 800; color: #1e293b; line-height: 1.2; margin-bottom: 20px;">
            Pilih Paket yang Sesuai untuk Bisnis Anda
          </h2>
          <p style="font-size: 1.05rem; color: #64748b; line-height: 1.7; margin-bottom: 30px;">
            Mulai dari gratis hingga paket premium dengan fitur lengkap. Tingkatkan bisnis UMKM Anda dengan tools yang tepat.
          </p>
          <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" fill="#22c55e" fill-opacity="0.1"/>
              <path d="M9 12l2 2 4-4" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span style="color: #475569; font-size: 0.95rem;">Tidak ada biaya tersembunyi</span>
          </div>
          <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" fill="#22c55e" fill-opacity="0.1"/>
              <path d="M9 12l2 2 4-4" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span style="color: #475569; font-size: 0.95rem;">Upgrade atau downgrade kapan saja</span>
          </div>
          <div style="display: flex; align-items: center; gap: 12px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" fill="#22c55e" fill-opacity="0.1"/>
              <path d="M9 12l2 2 4-4" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span style="color: #475569; font-size: 0.95rem;">Dukungan 24/7 untuk semua paket</span>
          </div>
        </div>
      </div>

      <!-- Right Pricing Cards -->
      <div class="col-lg-7 col-md-12">
        <div class="row g-4">
          
          <!-- Starter Card -->
          <div class="col-md-6">
            <div style="background: linear-gradient(135deg, #ffe4e8 0%, #ffc9d1 100%); padding: 32px 28px; border-radius: 24px; box-shadow: 0 8px 24px rgba(231, 76, 60, 0.15); height: 100%; transition: all 0.3s; border: 2px solid rgba(255, 255, 255, 0.8); position: relative;">
              <div style="position: absolute; top: 20px; right: 20px;">
                <span style="background: white; color: #e74c3c; font-size: 10px; font-weight: 700; padding: 6px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Most Popular</span>
              </div>
              <h6 style="font-size: 0.85rem; font-weight: 700; color: #e74c3c; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Starter</h6>
              <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Mulai Perjalanan</p>
              <div style="margin-bottom: 24px;">
                <h3 style="font-size: 3rem; font-weight: 800; color: #e74c3c; line-height: 1; margin-bottom: 4px;">
                  Rp<span style="font-size: 3.5rem;">0</span>
                </h3>
                <p style="font-size: 0.9rem; color: #666; margin: 0;">Gratis Selamanya</p>
              </div>
              <ul style="list-style: none; padding: 0; margin: 0 0 24px 0;">
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> 3 AI Advisor/bulan
                </li>
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> Max 20 transaksi
                </li>
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> Dashboard dasar
                </li>
              </ul>
              <a href="<?= site_url('auth/login'); ?>?redirect=subscription/pricing" style="background: #e74c3c; color: white; padding: 14px 0; border-radius: 12px; font-weight: 700; text-decoration: none; display: block; text-align: center; transition: all 0.3s;">
                Pilih Paket
              </a>
            </div>
          </div>

          <!-- Essential Card -->
          <div class="col-md-6">
            <div style="background: linear-gradient(135deg, #d4e8f7 0%, #b3d9f2 100%); padding: 32px 28px; border-radius: 24px; box-shadow: 0 8px 24px rgba(28, 100, 148, 0.2); height: 100%; transition: all 0.3s; border: 3px solid #1C6494; position: relative; transform: scale(1.02);">
              <div style="position: absolute; top: 20px; right: 20px;">
                <span style="background: linear-gradient(135deg, #FFD700, #FFA500); color: #1C6494; font-size: 10px; font-weight: 700; padding: 6px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);">PROMO</span>
              </div>
              <h6 style="font-size: 0.85rem; font-weight: 700; color: #1C6494; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Essential</h6>
              <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Otomatisasi Efisien</p>
              <div style="margin-bottom: 24px;">
                <h3 style="font-size: 3rem; font-weight: 800; color: #1C6494; line-height: 1; margin-bottom: 4px;">
                  Rp<span style="font-size: 3.5rem;">18K</span>
                </h3>
                <p style="font-size: 0.9rem; color: #666; margin: 0;">per bulan</p>
              </div>
              <ul style="list-style: none; padding: 0; margin: 0 0 24px 0;">
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> 10 AI Advisor/bulan
                </li>
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> Unlimited pencatatan
                </li>
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> Export PDF
                </li>
              </ul>
              <a href="<?= site_url('auth/login'); ?>?redirect=subscription/pricing" style="background: #1C6494; color: white; padding: 14px 0; border-radius: 12px; font-weight: 700; text-decoration: none; display: block; text-align: center; transition: all 0.3s; box-shadow: 0 4px 16px rgba(28, 100, 148, 0.3);">
                Pilih Paket
              </a>
            </div>
          </div>

          <!-- Growth Card -->
          <div class="col-md-6">
            <div style="background: linear-gradient(135deg, #e9dcf8 0%, #d4c5ed 100%); padding: 32px 28px; border-radius: 24px; box-shadow: 0 8px 24px rgba(155, 89, 255, 0.15); height: 100%; transition: all 0.3s; border: 2px solid rgba(255, 255, 255, 0.8); position: relative;">
              <div style="position: absolute; top: 20px; right: 20px;">
                <span style="background: linear-gradient(135deg, #ff9800, #f57c00); color: white; font-size: 10px; font-weight: 700; padding: 6px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);">POPULER</span>
              </div>
              <h6 style="font-size: 0.85rem; font-weight: 700; color: #9b59ff; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Growth</h6>
              <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Kembangkan Bisnis</p>
              <div style="margin-bottom: 24px;">
                <h3 style="font-size: 3rem; font-weight: 800; color: #9b59ff; line-height: 1; margin-bottom: 4px;">
                  Rp<span style="font-size: 3.5rem;">45K</span>
                </h3>
                <p style="font-size: 0.9rem; color: #666; margin: 0;">per bulan</p>
              </div>
              <ul style="list-style: none; padding: 0; margin: 0 0 24px 0;">
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> Unlimited AI Advisor
                </li>
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> 5 Analisis kompetitor
                </li>
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> Smart Alert
                </li>
              </ul>
              <a href="<?= site_url('auth/login'); ?>?redirect=subscription/pricing" style="background: #9b59ff; color: white; padding: 14px 0; border-radius: 12px; font-weight: 700; text-decoration: none; display: block; text-align: center; transition: all 0.3s;">
                Pilih Paket
              </a>
            </div>
          </div>

          <!-- Elite Card -->
          <div class="col-md-6">
            <div style="background: linear-gradient(135deg, #fff4d9 0%, #ffe9b3 100%); padding: 32px 28px; border-radius: 24px; box-shadow: 0 8px 24px rgba(255, 152, 0, 0.15); height: 100%; transition: all 0.3s; border: 2px solid rgba(255, 255, 255, 0.8); position: relative;">
              <div style="position: absolute; top: 20px; right: 20px;">
                <span style="background: linear-gradient(135deg, #4CAF50, #45a049); color: white; font-size: 10px; font-weight: 700; padding: 6px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);">TERBAIK</span>
              </div>
              <h6 style="font-size: 0.85rem; font-weight: 700; color: #ff9800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Elite</h6>
              <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Pendampingan Personal</p>
              <div style="margin-bottom: 24px;">
                <h3 style="font-size: 3rem; font-weight: 800; color: #ff9800; line-height: 1; margin-bottom: 4px;">
                  Rp<span style="font-size: 3.5rem;">85K</span>
                </h3>
                <p style="font-size: 0.9rem; color: #666; margin: 0;">per bulan</p>
              </div>
              <ul style="list-style: none; padding: 0; margin: 0 0 24px 0;">
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> 2 sesi konsultasi 1-on-1
                </li>
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> Unlimited analisis
                </li>
                <li style="padding: 8px 0; color: #475569; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                  <span style="color: #22c55e; font-size: 1.1rem;">✓</span> Priority Support
                </li>
              </ul>
              <a href="<?= site_url('auth/login'); ?>?redirect=subscription/pricing" style="background: #ff9800; color: white; padding: 14px 0; border-radius: 12px; font-weight: 700; text-decoration: none; display: block; text-align: center; transition: all 0.3s;">
                Pilih Paket
              </a>
            </div>
          </div>

        </div>

        <!-- Bottom Notice -->
        <div style="margin-top: 28px; text-align: center;">
          <p style="font-size: 0.85rem; color: #64748b; margin: 0;">
            💡 <strong>Detail lengkap fitur dan perbandingan</strong> tersedia di <a href="<?= site_url('subscription/pricing'); ?>" style="color: #1C6494; font-weight: 600; text-decoration: none;">halaman langganan</a>
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- WHY -->
<section id="why" class="why-section">
  <div class="container">
    <div class="row align-items-center">
      
      <!-- Left Content -->
      <div class="col-lg-5 col-md-12 mb-5 mb-lg-0">
        <div class="why-content-left">
          <h3>Mengapa Pilih Usahain?</h3>
          <p style="font-weight: 600; color: #1e293b; font-size: 1.05rem;">Kami memahami tantangan UMKM Indonesia</p>
          <p>Platform yang dirancang khusus untuk membantu pelaku UMKM dalam mengelola dan mengembangkan bisnis mereka dengan lebih efisien dan terstruktur.</p>
          <p>Dengan fitur-fitur yang mudah digunakan dan dukungan penuh dari tim kami, kesuksesan bisnis Anda adalah prioritas kami.</p>
          
          <a href="#features" class="why-btn">PELAJARI LEBIH LANJUT</a>
        </div>
      </div>

      <!-- Right Grid Cards -->
      <div class="col-lg-7 col-md-12">
        <div class="row g-4">
          
          <!-- Card 1 -->
          <div class="col-md-6">
            <div class="why-box">
              <div class="why-icon" style="background: linear-gradient(135deg, #E2E8FF, #C7D2FE);">
                <img src="assets/icons/target.png" width="42">
              </div>
              <h6>Mudah Dipahami</h6>
              <p>Interface intuitif & panduan step-by-step untuk memudahkan pengguna baru dalam menggunakan platform.</p>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="col-md-6">
            <div class="why-box">
              <div class="why-icon" style="background: linear-gradient(135deg, #FEE2E2, #FECACA);">
                <img src="assets/icons/energy.png" width="42">
              </div>
              <h6>Hemat Waktu</h6>
              <p>Otomatisasi perhitungan dan analisis yang biasanya memakan waktu berjam-jam menjadi hitungan menit.</p>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="col-md-6">
            <div class="why-box">
              <div class="why-icon" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                <img src="assets/icons/partners.png" width="42">
              </div>
              <h6>Dukungan Penuh</h6>
              <p>Tim support yang siap membantu perjalanan bisnis Anda kapan pun Anda membutuhkannya.</p>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="col-md-6">
            <div class="why-box">
              <div class="why-icon" style="background: linear-gradient(135deg, #FEE2E2, #FECACA);">
                <svg width="42" height="42" viewBox="0 0 24 24" fill="#ef4444">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                </svg>
              </div>
              <h6>Harga Terjangkau</h6>
              <p>Paket berlangganan dengan harga yang sesuai untuk semua skala bisnis UMKM Anda.</p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- FOOTER -->
<footer style="background: #1e293b; color: white; padding: 60px 0 0;">
  <div class="container">
    <div class="row">
      
      <!-- Logo & Description -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div style="margin-bottom: 24px;">
          <h3 style="font-size: 1.8rem; font-weight: 800; color: white; display: flex; align-items: center; gap: 10px;">
            <svg width="36" height="36" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="16" cy="16" r="16" fill="#65C1DF"/>
              <path d="M12 10h8a2 2 0 012 2v8a2 2 0 01-2 2h-8a2 2 0 01-2-2v-8a2 2 0 012-2z" fill="white"/>
              <circle cx="16" cy="16" r="3" fill="#1C6494"/>
            </svg>
            Usahain
          </h3>
        </div>
        <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.7; margin-bottom: 24px;">
          Platform terpadu untuk memulai, mengelola, dan mengembangkan UMKM Indonesia dengan fitur lengkap dan mudah digunakan.
        </p>
        <div style="display: flex; gap: 16px;">
          <a href="#" style="width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s; text-decoration: none;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
            </svg>
          </a>
          <a href="#" style="width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s; text-decoration: none;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
              <circle cx="4" cy="4" r="2"/>
            </svg>
          </a>
          <a href="#" style="width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s; text-decoration: none;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
            </svg>
          </a>
          <a href="#" style="width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s; text-decoration: none;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
              <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="#1e293b"/>
              <circle cx="17.5" cy="6.5" r="1.5" fill="#1e293b"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- Fitur Column -->
      <div class="col-lg-2 col-md-6 col-6 mb-4">
        <h6 style="font-size: 1rem; font-weight: 700; color: white; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Fitur</h6>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 12px;"><a href="<?= site_url('auth/login'); ?>" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">AI Advisor</a></li>
          <li style="margin-bottom: 12px;"><a href="<?= site_url('auth/login'); ?>" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Kalkulator HPP</a></li>
          <li style="margin-bottom: 12px;"><a href="<?= site_url('auth/login'); ?>" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Pencatatan Keuangan</a></li>
          <li style="margin-bottom: 12px;"><a href="<?= site_url('auth/login'); ?>" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Manajemen Risiko</a></li>
          <li style="margin-bottom: 12px;"><a href="<?= site_url('auth/login'); ?>" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Analisis Produk</a></li>
        </ul>
      </div>

      <!-- Perusahaan Column -->
      <div class="col-lg-2 col-md-6 col-6 mb-4">
        <h6 style="font-size: 1rem; font-weight: 700; color: white; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Perusahaan</h6>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 12px;"><a href="#why" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Tentang Kami</a></li>
          <li style="margin-bottom: 12px;"><a href="<?= site_url('subscription/pricing'); ?>" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Harga</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Karir</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Kontak</a></li>
        </ul>
      </div>

      <!-- Bantuan Column -->
      <div class="col-lg-2 col-md-6 col-6 mb-4">
        <h6 style="font-size: 1rem; font-weight: 700; color: white; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Bantuan</h6>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Blog</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Panduan</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">FAQ</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Support</a></li>
        </ul>
      </div>

      <!-- Legal Column -->
      <div class="col-lg-2 col-md-6 col-6 mb-4">
        <h6 style="font-size: 1rem; font-weight: 700; color: white; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Legal</h6>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Syarat & Ketentuan</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Kebijakan Privasi</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;">Keamanan</a></li>
        </ul>
      </div>

    </div>

    <!-- Bottom Bar -->
    <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 40px; padding: 24px 0;">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
          <p style="color: #64748b; margin: 0; font-size: 0.9rem;">© 2026 Usahain. All Rights Reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <p style="color: #64748b; margin: 0; font-size: 0.9rem;">
            Made with ❤️ for UMKM Indonesia
          </p>
        </div>
      </div>
    </div>

  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
