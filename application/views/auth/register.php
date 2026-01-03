<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#F7FAFC;--card:#FFFFFF;--accent1:#004B79;--accent2:#009EE2;--cta:#18A0FB}
        *{box-sizing:border-box}
        body{margin:0;background:linear-gradient(180deg, #F8FBFD 0%, #F7FAFC 100%);font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto;color:#0f1724;display:flex;align-items:flex-start;justify-content:center;min-height:100vh;padding:48px}
        .card{width:100%;max-width:420px;background:var(--card);border-radius:12px;padding:28px 28px 36px;box-shadow:0 12px 40px rgba(2,6,23,0.06)}
        .heading{font-size:20px;font-weight:700;text-align:center;margin-bottom:6px}
        .sub{font-size:13px;color:#64748b;text-align:center;margin-bottom:20px}

        label{display:block;font-size:13px;color:#334155;margin-bottom:8px}
        .input{width:100%;padding:12px 16px;border-radius:10px;border:1px solid #e6eef6;background:#fbfdff;font-size:14px}
        .field{margin-bottom:16px}

        .input-wrap{position:relative}
        .input.padding-right{padding-right:48px}
        .toggle-pass{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:transparent;border:none;cursor:pointer;color:#64748b;width:36px;height:36px;display:flex;align-items:center;justify-content:center;padding:0;border-radius:8px}

        .helper{font-size:12px;color:#94a3b8;margin-top:6px}
        .helper.important{color:#0f1724}

        .btn-primary{width:100%;padding:14px;border-radius:12px;border:none;background:linear-gradient(90deg,var(--accent1),var(--accent2));color:#fff;font-weight:700;font-size:16px;cursor:pointer;box-shadow:0 8px 20px rgba(3,10,25,0.08);margin-top:6px}

        .small{font-size:13px;color:#64748b;text-align:center;margin-top:14px}
        .small a{color:var(--cta);text-decoration:none;font-weight:600}

        .required-star{color:#ef4444;margin-left:6px}

        @media (max-width:520px){body{padding:20px} .card{padding:20px}}
    </style>
</head>
<body>
    <div class="card" role="main">
        <div class="heading">Daftar Akun Baru</div>
        <div class="sub">Bergabunglah dengan ribuan pengusaha sukses</div>

        <?php if ($this->form_validation->run() === FALSE): ?>
            <?php if (validation_errors()): ?>
                <div class="helper" style="background:#fff3f2;border:1px solid #FECACA;padding:10px;border-radius:8px;margin-bottom:12px;color:#9b2c2c">
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="field">
                <label for="nama">Nama Lengkap</label>
                <input class="input" type="text" id="nama" name="nama" placeholder="Nama lengkap Anda" value="<?php echo set_value('nama'); ?>" required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input class="input" type="email" id="email" name="email" placeholder="nama@email.com" value="<?php echo set_value('email'); ?>" required>
            </div>

            <!-- PASSWORD -->
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input class="input padding-right" type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    <button type="button" class="toggle-pass" id="togglePassReg" aria-label="Tampilkan password" aria-pressed="false">
                        <svg id="iconShowReg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" stroke="#0f1724" stroke-width="1.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3" stroke="#0f1724" stroke-width="1.4" fill="none"/>
                        </svg>
                        <svg id="iconHideReg" width="18" height="18" viewBox="0 0 24 24" fill="none" style="display:none">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" stroke="#0f1724" stroke-width="1.4" fill="none"/>
                            <path d="M3 3l18 18" stroke="#0f1724" stroke-width="1.4"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- KONFIRMASI PASSWORD -->
            <div class="field">
                <label for="konfirmasi_password">Konfirmasi Password</label>
                <div class="input-wrap">
                    <input class="input padding-right" type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password Anda" required>
                    <button type="button" class="toggle-pass" id="togglePassReg2" aria-label="Tampilkan password" aria-pressed="false">
                        <svg id="iconShowReg2" width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" stroke="#0f1724" stroke-width="1.4" fill="none"/>
                            <circle cx="12" cy="12" r="3" stroke="#0f1724" stroke-width="1.4"/>
                        </svg>
                        <svg id="iconHideReg2" width="18" height="18" viewBox="0 0 24 24" fill="none" style="display:none">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" stroke="#0f1724" stroke-width="1.4"/>
                            <path d="M3 3l18 18" stroke="#0f1724" stroke-width="1.4"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="field">
                <label for="nama_usaha">Nama Usaha <span class="required-star">*</span></label>
                <input class="input" type="text" id="nama_usaha" name="nama_usaha" placeholder="Nama usaha Anda (isi '-' jika belum punya)" value="<?php echo set_value('nama_usaha'); ?>">
                <div class="helper">Wajib diisi. Tulis "-" jika belum memiliki usaha</div>
            </div>

            <button type="submit" class="btn-primary">Daftar Sekarang</button>
        </form>

        <div class="small">Sudah punya akun? <a href="<?php echo site_url('auth/login'); ?>">Masuk di sini</a></div>
    </div>

<script>
(function(){
    function toggle(btnId, inputId, showId, hideId){
        var t=document.getElementById(btnId),
            p=document.getElementById(inputId),
            iconShow=document.getElementById(showId),
            iconHide=document.getElementById(hideId);
        if(!t||!p) return;
        t.addEventListener('click', function(){
            var pressed=t.getAttribute('aria-pressed')==='true';
            if(!pressed){
                p.type='text';
                t.setAttribute('aria-pressed','true');
                iconShow.style.display='none';
                iconHide.style.display='block';
            }else{
                p.type='password';
                t.setAttribute('aria-pressed','false');
                iconShow.style.display='block';
                iconHide.style.display='none';
            }
        });
    }

    toggle('togglePassReg','password','iconShowReg','iconHideReg');
    toggle('togglePassReg2','konfirmasi_password','iconShowReg2','iconHideReg2');
})();
</script>

</body>
</html>
