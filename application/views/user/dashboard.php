<?php
$user = array_merge([
    'nama'  => 'User',
    'email' => '-',
    'role'  => '-',
    'usaha' => 'Bisnis Anda',
    'type'  => 'UMKM'
], $user ?? []);

$summary = array_merge([
    'today_sales'   => 0,
    'today_expense' => 0,
    'today_profit'  => 0
], $summary ?? []);

$transactions = $transactions ?? [];
?>


<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,user-scalable=yes">
    <title>Dashboard Gabungan - <?= htmlspecialchars($user['nama']); ?></title>
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
        .header{
            background:linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding:22px 36px 0 36px;
            color:#fff;
            display:flex;
            flex-direction:column;
            align-items:stretch;
            box-shadow:0 2px 12px rgba(74,144,226,0.12);
            position:relative;
            overflow:hidden;
            border-bottom:1px solid rgba(255,255,255,0.15)
        }
        .header-main{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        .header-left{
            display:flex;
            align-items:center;
            gap:16px;
            position:relative;
            z-index:2
        }
        .header-icon{
            width:48px;
            height:48px;
            border-radius:14px;
            background:rgba(255,255,255,0.20);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            box-shadow:0 4px 12px rgba(0,0,0,0.10);
            border:1px solid rgba(255,255,255,0.25)
        }
        .header-title h3{
            font-size:20px;
            font-weight:700;
            margin-bottom:4px;
            letter-spacing:-0.3px;
            text-shadow:0 1px 2px rgba(0,0,0,0.08)
        }
        .header-title small{
            opacity:.90;
            font-size:13px;
            font-weight:500;
            display:flex;
            align-items:center;
            gap:6px
        }
        .avatar{
            width:44px;
            height:44px;
            border-radius:50%;
            background:linear-gradient(135deg, #FFFFFF 0%, #FFF5E6 100%);
            color:var(--warning-dark);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            font-size:16px;
            box-shadow:0 3px 10px rgba(0,0,0,0.12);
            border:2px solid rgba(255,255,255,0.35);
            transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1)
        }
        .tab-switcher{
            display:flex;
            gap:0;
            margin:24px auto 0 auto;
            background:var(--bg-muted);
            border-radius:16px 16px 0 0;
            overflow:hidden;
            width:fit-content;
            box-shadow:0 2px 8px rgba(74,144,226,0.08);
        }
        .tab-btn{
            padding:14px 38px;
            font-size:16px;
            font-weight:700;
            color:var(--text-secondary);
            background:none;
            border:none;
            outline:none;
            cursor:pointer;
            transition:all 0.2s;
        }
        .tab-btn.active{
            background:var(--card-bg);
            color:var(--primary);
            box-shadow:0 2px 8px rgba(74,144,226,0.10);
        }
        .container{max-width:1150px;margin:28px auto;padding:0 24px}
        .tab-content{display:none;}
        .tab-content.active{display:block;animation:fadeIn 0.5s;}
        @keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
        /* Responsive */
        @media(max-width:991px){.container{padding:0 16px}.tab-btn{padding:12px 16px;font-size:15px}}
    </style>
</head>
<body>
    <div class="header">
        <div class="header-main">
            <div class="header-left">
                <div class="header-icon">📊</div>
                <div class="header-title">
                    <h3>Dashboard Usahain</h3>
                    <small>Gabungan Operasional &amp; Perencanaan</small>
                </div>
            </div>
            <div class="avatar"><?= strtoupper(substr($user['nama'],0,1)); ?></div>
        </div>
        <div class="tab-switcher">
            <button class="tab-btn active" id="tab-operasional" onclick="showTab('operasional')">Operasional</button>
            <button class="tab-btn" id="tab-perencanaan" onclick="showTab('perencanaan')">Perencanaan</button>
        </div>
    </div>
    <div class="container">
        <!-- OPERASIONAL DASHBOARD -->
        <div class="tab-content active" id="content-operasional">
            <?php /* ========== KONTEN DASHBOARD OPERASIONAL ========== */ ?>
            <!-- Bisnis Card, Aksi Cepat, Ringkasan, Transaksi, Tools Bisnis -->
            <!-- ... (copy konten utama dashboard operasional di sini, tanpa <html>, <head>, <body>) ... -->
            <?php /* Konten akan diisi pada langkah berikutnya */ ?>
        </div>
        <!-- PERENCANAAN DASHBOARD -->
        <div class="tab-content" id="content-perencanaan">
            <?php /* ========== KONTEN DASHBOARD PERENCANAAN ========== */ ?>
            <!-- Welcome Banner, Progress, Langkah Cepat, Tools, Tips -->
            <!-- ... (copy konten utama dashboard perencanaan di sini, tanpa <html>, <head>, <body>) ... -->
            <?php /* Konten akan diisi pada langkah berikutnya */ ?>
        </div>
    </div>
    <script>
    function showTab(tab) {
        document.getElementById('tab-operasional').classList.remove('active');
        document.getElementById('tab-perencanaan').classList.remove('active');
        document.getElementById('content-operasional').classList.remove('active');
        document.getElementById('content-perencanaan').classList.remove('active');
        if(tab==='operasional'){
            document.getElementById('tab-operasional').classList.add('active');
            document.getElementById('content-operasional').classList.add('active');
        }else{
            document.getElementById('tab-perencanaan').classList.add('active');
            document.getElementById('content-perencanaan').classList.add('active');
        }
    }
    </script>
</body>
</html>
