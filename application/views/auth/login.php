<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#F7FAFC;--card:#FFFFFF;--accent1:#004B79;--accent2:#009EE2;--cta:#18A0FB}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;color:#0f1724;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px}
        .card{width:100%;max-width:420px;background:var(--card);border-radius:16px;padding:36px;box-shadow:0 12px 40px rgba(2,6,23,0.08);}
        .title{font-size:22px;font-weight:700;text-align:center;margin-bottom:6px}
        .subtitle{font-size:14px;color:#64748b;text-align:center;margin-bottom:22px}

        label{display:block;font-size:13px;color:#334155;margin-bottom:8px}
        /* leave extra right padding to accommodate the eye icon */
        .input{width:100%;padding:14px 48px 14px 16px;border-radius:12px;border:1px solid #e6eef6;background:#fbfdff;font-size:15px}
        .field{margin-bottom:16px}

        .password-wrap{position:relative}
        .input-wrap{position:relative}
        .toggle-pass{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:transparent;border:none;cursor:pointer;color:#94a3b8;width:40px;height:40px;display:flex;align-items:center;justify-content:center;padding:0;border-radius:8px}
        .toggle-pass svg{display:block;vertical-align:middle}

        .remember{display:flex;align-items:center;gap:8px;color:#475569;font-size:14px;margin-bottom:18px}

        .btn-primary{width:100%;padding:14px;border-radius:12px;border:none;background:linear-gradient(90deg,var(--accent1),var(--accent2));color:#fff;font-weight:700;font-size:16px;cursor:pointer;box-shadow:0 8px 20px rgba(3,10,25,0.12)}
        .btn-primary:hover{opacity:0.95}

        .btn-google{width:100%;padding:14px;border-radius:12px;border:1px solid #dadce0;background:#fff;color:#3c4043;font-weight:600;font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:12px;margin-top:16px;transition:background 0.2s}
        .btn-google:hover{background:#f8f9fa;box-shadow:0 2px 8px rgba(0,0,0,0.08)}
        .btn-google img{width:20px;height:20px}

        .divider{display:flex;align-items:center;gap:14px;margin:20px 0;color:#94a3b8;font-size:13px}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:#e2e8f0}

        .small{font-size:13px;color:#64748b;text-align:center;margin-top:14px}
        .small a{color:var(--cta);text-decoration:none;font-weight:600}

        .error-box{background:#fff3f2;border:1px solid #FECACA;padding:12px;border-radius:10px;color:#9b2c2c;margin-bottom:14px}
        .validation-errors{background:#fff3f2;border:1px solid #FECACA;padding:12px;border-radius:10px;color:#9b2c2c;margin-bottom:14px}
    </style>
</head>
<body>
    <div class="card" role="main">
        <div class="title">Selamat Datang Kembali!</div>
        <div class="subtitle">Masuk ke akun Usahain Anda</div>

        <?php if ($this->form_validation->run() === FALSE): ?>
                <?php if (validation_errors()): ?>
                        <div class="validation-errors"><?php echo validation_errors(); ?></div>
                <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($error)): ?>
                <div class="error-box"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="field">
                <label for="email">Email</label>
                <input class="input" type="email" id="email" name="email" placeholder="nama@email.com" value="<?php echo set_value('email'); ?>" required>
            </div>

                        <div class="field password-wrap">
                                <label for="password">Password</label>
                                <div class="input-wrap">
                                    <input class="input" type="password" id="password" name="password" placeholder="Password Anda" required>
                                    <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan password" aria-pressed="false">
                    <!-- Eye icon (show) -->
                    <svg id="iconShow" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" stroke="#0f1724" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke="#0f1724" stroke-width="1.6" fill="none"/>
                    </svg>
                    <!-- Eye-off icon (hidden initially) -->
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

        <a href="<?php echo site_url('googleauth/login'); ?>" class="btn-google" style="text-decoration:none">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo">
            <span>Lanjutkan dengan Google</span>
        </a>

        <div class="small">Belum punya akun? <a href="<?php echo site_url('auth/register'); ?>">Daftar di sini</a></div>
    </div>

    <script>
        (function(){
            var t = document.getElementById('togglePass');
            var p = document.getElementById('password');
            var iconShow = document.getElementById('iconShow');
            var iconHide = document.getElementById('iconHide');
            if(!t||!p) return;
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
        })();
    </script>
</body>
</html>
