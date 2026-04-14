<?php
$user = array_merge([
    'id_user'      => '',
    'nama'         => 'User',
    'email'        => '-',
    'nama_usaha'   => '-',
    'jenis_usaha'  => '-',
    'avatar_url'   => '',
    'oauth_provider' => 'local',
    'created_at'   => '-'
], (array)($user ?? []));

$errors = $errors ?? [];
$success = $success ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Segoe UI, Arial;
            background: #f8fafc;
            color: #1e293b;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #1f6b99;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* ===== HEADER ===== */
        .page-header {
            margin-bottom: 32px;
        }

        .page-header h1 {
            font-size: 22px;
            font-weight: 600;
            color: #1e293b;
        }

        .page-header p {
            display: none;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* ===== FORM SECTION ===== */
        .form-section {
            background: white;
            padding: 32px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .form-section-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
        }

        .form-section-desc {
            display: none;
        }

        /* ===== FORM GROUPS ===== */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #374151;
            font-size: 13px;
        }

        .form-label.required::after {
            content: '*';
            color: #ef4444;
            margin-left: 4px;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            color: #1e293b;
            transition: all 0.3s;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #1f6b99;
            box-shadow: 0 0 0 3px rgba(30, 111, 186, 0.08);
            background: #fff;
        }

        .form-input:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-helper {
            font-size: 12px;
            color: #64748b;
            margin-top: 6px;
        }

        .account-item {
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .account-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .account-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 6px;
        }

        .account-value {
            font-size: 14px;
            color: #0f172a;
            font-weight: 600;
        }

        .account-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .account-badge.verified {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .form-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ===== FORM ROW ===== */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        /* ===== BUTTONS ===== */
        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-start;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #f3f4f6;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
        }

        .btn-primary {
            background: #1E6FBA;
            color: white;
        }

        .btn-primary:hover {
            background: #175d99;
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .btn-secondary {
            background: transparent;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }

            .form-section {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .divider {
            height: 1px;
            background: #f3f4f6;
            margin: 32px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= site_url('user/profile/' . $user['id_user']); ?>" class="back-link">Kembali ke Profile</a>

        <div class="page-header">
            <h1>Pengaturan Akun</h1>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <span>✓</span>
                <div><?= htmlspecialchars($success); ?></div>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-error">
                    <span>!</span>
                    <div><?= htmlspecialchars($error); ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- PROFILE SECTION -->
        <div class="form-section">
            <div class="form-section-title">Data Profil</div>
            <div class="account-item">
                <div class="account-label">Nama</div>
                <div class="account-value"><?= htmlspecialchars($user['nama']); ?></div>
            </div>
            <div class="account-item">
                <div class="account-label">Email</div>
                <div class="account-value"><?= htmlspecialchars($user['email'] ?? '-'); ?></div>
                <span class="account-badge verified">Terverifikasi</span>
            </div>
            <div class="account-item">
                <div class="account-label">Metode Login</div>
                <div class="account-value"><?= $user['oauth_provider'] === 'google' ? 'Google OAuth' : 'Email dan Password'; ?></div>
            </div>

            <div class="form-actions">
                <a href="<?= site_url('user/edit/' . $user['id_user']); ?>" class="btn btn-primary">Edit Profil & Data Bisnis</a>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Keamanan Akun</div>

            <?php if ($user['oauth_provider'] === 'local'): ?>
                <form method="POST" action="<?= site_url('user/change_password'); ?>">
                    <div class="form-group">
                        <label class="form-label required">Password Lama</label>
                        <input type="password" name="password_lama" class="form-input" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">Password Baru</label>
                            <input type="password" name="password_baru" class="form-input" minlength="6" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Konfirmasi Password</label>
                            <input type="password" name="konfirmasi_password" class="form-input" minlength="6" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                        <a href="<?= site_url('user/profile/' . $user['id_user']); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    <span>!</span>
                    <div>Akun ini menggunakan Google OAuth. Perubahan password dilakukan dari akun Google Anda.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const inputs = this.querySelectorAll('input[required], select[required]');
                let isValid = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = '#ef4444';
                    } else {
                        input.style.borderColor = '#e2e8f0';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua bidang yang diperlukan');
                }
            });
        });
    </script>
</body>
</html>
