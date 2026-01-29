<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#F8FAFC;--card:#FFFFFF;--primary:#1F6B99;--primary-dark:#154A6F;--secondary:#7EC8E3;--success:#10B981;--danger:#EF4444;--text:#1E293B;--text-secondary:#64748B;--border:#E2E8F0}
        *{box-sizing:border-box}
        body{margin:0;background:linear-gradient(180deg, #F8FBFD 0%, #F7FAFC 100%);font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;color:var(--text);display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px}
        
        .login-container{display:flex;width:100%;max-width:900px;background:var(--card);border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.12);overflow:hidden;gap:0}
        
        .logo-section{flex:0 0 50%;background:linear-gradient(135deg, #0D2E47 0%, #1F5A8F 50%, #2E7DB9 100%);padding:60px 40px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:white;position:relative;overflow:hidden}
        .logo-section::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:repeating-linear-gradient(0deg, rgba(126, 200, 227, 0.03) 0px, rgba(126, 200, 227, 0.03) 1px, transparent 1px, transparent 40px),repeating-linear-gradient(90deg, rgba(126, 200, 227, 0.03) 0px, rgba(126, 200, 227, 0.03) 1px, transparent 1px, transparent 40px);z-index:0;pointer-events:none}
        .logo-section::after{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:radial-gradient(circle at 20% 50%, rgba(126, 200, 227, 0.08) 0%, transparent 50%),radial-gradient(circle at 80% 80%, rgba(46, 125, 185, 0.08) 0%, transparent 50%);z-index:1;pointer-events:none}
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 30px); }
        }
        
        .decorative-dots{position:absolute;width:100%;height:100%;pointer-events:none;z-index:2}
        .dot{position:absolute;width:8px;height:8px;background:rgba(126, 200, 227, 0.35);border-radius:50%;animation:pulse 4s ease-in-out infinite;border:1px solid rgba(126, 200, 227, 0.25)}
        .dot:nth-child(1){top:15%;right:12%;animation-delay:0s}
        .dot:nth-child(2){top:35%;right:8%;animation-delay:0.6s}
        .dot:nth-child(3){top:55%;left:8%;animation-delay:1.2s}
        .dot:nth-child(4){bottom:25%;right:15%;animation-delay:0.3s}
        .dot:nth-child(5){bottom:40%;left:12%;animation-delay:0.9s}
        .dot:nth-child(6){top:70%;right:5%;animation-delay:1.5s}
        .dot:nth-child(7){bottom:15%;right:40%;animation-delay:0.4s}
        .dot:nth-child(8){top:40%;left:15%;animation-delay:1.1s}
        
        @keyframes pulse {
            0%, 100% { opacity:0.3;transform:scale(1); }
            50% { opacity:0.7;transform:scale(1.1); }
        }
        
        .logo-wrapper{position:relative;z-index:3;text-align:center;margin-bottom:8px;padding:15px 0}
        .logo-wrapper::before{content:'';position:absolute;top:-30px;left:50%;transform:translateX(-50%);width:220px;height:220px;background:radial-gradient(circle, rgba(126, 200, 227, 0.15) 0%, transparent 70%);border-radius:50%;z-index:-1}
        .logo-wrapper::after{content:'';position:absolute;bottom:-25px;left:50%;transform:translateX(-50%);width:240px;height:80px;background:radial-gradient(ellipse at center, rgba(126, 200, 227, 0.1) 0%, transparent 70%);border-radius:50%;z-index:-1}
        .logo-wrapper img{width:180px;height:180px;transition:transform 0.3s ease;animation:logoFloat 3s ease-in-out infinite;filter:saturate(1.15) contrast(1.08);drop-shadow(0 8px 24px rgba(0, 0, 0, 0.15))}
        .logo-wrapper img:hover{transform:scale(1.08)}
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        
        .logo-text{position:relative;z-index:3;text-align:center}
        .logo-text h1{font-size:36px;font-weight:700;margin:8px 0 8px 0;color:white;letter-spacing:0.5px}
        .logo-text p{font-size:14px;color:rgba(255,255,255,0.9);margin:0;font-weight:300;line-height:1.7;opacity:0.95}
        
        .card{width:100%;flex:1;background:var(--card);padding:50px 45px;display:flex;flex-direction:column;justify-content:center}
        .title{font-size:26px;font-weight:700;text-align:left;margin-bottom:8px;color:var(--text)}
        .subtitle{font-size:14px;color:var(--text-secondary);text-align:left;margin-bottom:28px}

        label{display:block;font-size:13px;color:var(--text);margin-bottom:8px;font-weight:500}
        .input{width:100%;padding:14px 48px 14px 16px;border-radius:12px;border:1px solid var(--border);background:#fff;font-size:15px;color:var(--text)}
        .input:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(31,107,153,0.1)}
        .field{margin-bottom:16px}

        .password-wrap{position:relative}
        .input-wrap{position:relative}
        .toggle-pass{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:transparent;border:none;cursor:pointer;color:var(--text-secondary);width:40px;height:40px;display:flex;align-items:center;justify-content:center;padding:0;border-radius:8px}
        .toggle-pass svg{display:block;vertical-align:middle}

        .remember{display:flex;align-items:center;gap:8px;color:var(--text-secondary);font-size:14px;margin-bottom:18px}

        .btn-primary{width:100%;padding:14px;border-radius:12px;border:none;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;font-weight:700;font-size:16px;cursor:pointer;box-shadow:0 4px 12px rgba(31,107,153,0.25);transition:all 0.3s}
        .btn-primary:hover{opacity:0.95;transform:translateY(-2px);box-shadow:0 6px 16px rgba(31,107,153,0.35)}

        .btn-google{width:100%;padding:14px;border-radius:12px;border:1px solid var(--border);background:#fff;color:var(--text);font-weight:600;font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:12px;margin-top:16px;transition:background 0.2s;text-decoration:none;position:relative;z-index:1000}
        .btn-google:hover{background:#f8f9fa;box-shadow:0 2px 8px rgba(0,0,0,0.08)}
        .btn-google img{width:20px;height:20px}

        .divider{display:flex;align-items:center;gap:14px;margin:20px 0;color:var(--text-secondary);font-size:13px}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}

        .small{font-size:13px;color:var(--text-secondary);text-align:center;margin-top:16px}
        .small a{color:var(--primary);text-decoration:none;font-weight:600}
        .small a:hover{text-decoration:underline}

        .error-box{background:#FEE2E2;border:1px solid #FECACA;padding:12px;border-radius:10px;color:#991B1B;margin-bottom:14px;font-size:14px}
        .validation-errors{background:#FEE2E2;border:1px solid #FECACA;padding:12px;border-radius:10px;color:#991B1B;margin-bottom:14px}
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container{flex-direction:column;max-width:100%}
            .logo-section{flex:0 0 auto;padding:40px 30px;min-height:200px}
            .logo-wrapper img{width:150px;height:150px}
            .logo-text h1{font-size:24px;margin:15px 0 8px 0}
            .logo-text p{font-size:13px}
            .card{padding:35px 25px}
            .title{font-size:22px}
            .btn-google{font-size:14px}
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <div class="decorative-dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <div class="logo-wrapper">
                <img src="<?php echo base_url('assets/logo.png'); ?>" alt="Usahain Logo">
            </div>
            <div class="logo-text">
                <h1>Usahain</h1>
                <p>Platform Bisnis Terpercaya untuk Memulai dan Mengembangkan Usaha Anda</p>
            </div>
        </div>
        
        <!-- Form Section -->
        <div class="card" role="main">
        <div class="title">Selamat Datang Kembali!</div>
        <div class="subtitle">Masuk ke akun Usahain Anda</div>

        <?php if ($this->form_validation->run() === false): ?>
                <?php if (validation_errors()): ?>
                        <div class="validation-errors"><?php echo validation_errors(); ?></div>
                <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($error)): ?>
                <div class="error-box"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <?php if (isset($redirect) && $redirect): ?>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
            <?php endif; ?>

            <div class="field">
                <label for="email">Email</label>
                <input class="input" type="email" id="email" name="email" placeholder="nama@email.com" value="<?php echo set_value('email'); ?>" required>
            </div>

            <div class="field password-wrap">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input class="input" type="password" id="password" name="password" placeholder="Password Anda" required>
                    <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan password" aria-pressed="false">
                        <svg id="iconShow" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" stroke="#0f1724" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3" stroke="#0f1724" stroke-width="1.6" fill="none"/>
                        </svg>
                        <svg id="iconHide" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="display:none">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" stroke="#0f1724" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 3l18 18" stroke="#0f1724" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <label class="remember"><input type="checkbox" name="remember"> Ingat saya</label>

            <button type="submit" class="btn-primary">Masuk</button>
        </form>

        <div class="divider">atau</div>

        <button type="button" class="btn-google" id="btnGoogleLogin">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo">
            <span>Lanjutkan dengan Google</span>
        </button>

        <div class="small">Belum punya akun? <a href="<?php echo site_url('auth/register'); ?>">Daftar di sini</a></div>
        </div>
    </div>

    <script>
        (function(){
            // Toggle password visibility
            var t = document.getElementById('togglePass');
            var p = document.getElementById('password');
            var iconShow = document.getElementById('iconShow');
            var iconHide = document.getElementById('iconHide');
            
            if(t && p){
                t.addEventListener('click', function(){
                    var isPressed = t.getAttribute('aria-pressed') === 'true';
                    if(!isPressed){
                        p.type = 'text';
                        t.setAttribute('aria-pressed', 'true');
                        iconShow.style.display = 'none';
                        iconHide.style.display = 'block';
                        t.setAttribute('aria-label','Sembunyikan password');
                    } else {
                        p.type = 'password';
                        t.setAttribute('aria-pressed', 'false');
                        iconShow.style.display = 'block';
                        iconHide.style.display = 'none';
                        t.setAttribute('aria-label','Tampilkan password');
                    }
                });
            }

            // Google login button handler
            var btnGoogle = document.getElementById('btnGoogleLogin');
            if(btnGoogle) {
                btnGoogle.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Ambil redirect parameter jika ada
                    var redirectParam = '';
                    <?php if (isset($redirect) && $redirect): ?>
                        redirectParam = '?redirect=<?php echo urlencode($redirect); ?>';
                    <?php endif; ?>
                    
                    // Construct Google OAuth URL
                    var googleAuthUrl = '<?php echo site_url("googleauth/login"); ?>' + redirectParam;
                    
                    // Redirect ke halaman Google OAuth
                    window.location.href = googleAuthUrl;
                });
            }
        })();
    </script>
</body>
</html>