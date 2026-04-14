<?php
$user = array_merge([
    'id_user'      => '',
    'nama'         => 'User',
    'email'        => '-',
    'nama_usaha'   => '',
    'jenis_usaha'  => '',
    'advisor_modal' => null,
    'advisor_minat' => '',
    'advisor_lokasi' => '',
    'advisor_tujuan' => '',
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
    <title>Edit Profil - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        .back-link:hover { text-decoration: underline; }

        .page-header { margin-bottom: 28px; }

        .page-header h1 {
            font-size: 22px;
            font-weight: 600;
            color: #1e293b;
        }

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

        .form-section {
            background: white;
            padding: 32px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .form-section-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
        }

        .form-group { margin-bottom: 24px; }

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

        .form-input, .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            color: #1e293b;
            transition: all 0.3s;
        }

        .form-input:focus, .form-select:focus {
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

        .form-helper {
            font-size: 12px;
            color: #64748b;
            margin-top: 6px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        .divider {
            height: 1px;
            background: #f3f4f6;
            margin: 32px 0;
        }

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

        .btn-primary:hover { background: #175d99; }

        .btn-secondary {
            background: transparent;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }

        .btn-secondary:hover { background: #f9fafb; }

        @media (max-width: 768px) {
            .container { padding: 16px; }
            .form-section { padding: 20px; }
            .form-row { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column; }
            .btn { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= site_url('user/profile/' . $user['id_user']); ?>" class="back-link">Kembali ke Profile</a>

        <div class="page-header">
            <h1>Edit Profil</h1>
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

        <div class="form-section">
            <form method="POST" action="<?= site_url('user/update_profile/' . $user['id_user']); ?>">
                <div class="form-section-title">Informasi Pribadi</div>

                <div class="form-group">
                    <label class="form-label required">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-input" value="<?= htmlspecialchars($user['nama']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" value="<?= htmlspecialchars($user['email'] ?? '-'); ?>" disabled>
                    <div class="form-helper">Email dikelola pada Pengaturan Akun dan tidak dapat diubah di sini.</div>
                </div>

                <div class="divider"></div>

                <div class="form-section-title">Informasi Bisnis</div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Usaha</label>
                        <input type="text" name="nama_usaha" class="form-input" value="<?= htmlspecialchars($user['nama_usaha'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Usaha</label>
                        <select name="jenis_usaha" class="form-select">
                            <option value="">-- Pilih Jenis Usaha --</option>
                            <option value="kuliner" <?= ($user['jenis_usaha'] === 'kuliner' ? 'selected' : ''); ?>>Kuliner</option>
                            <option value="fashion" <?= ($user['jenis_usaha'] === 'fashion' ? 'selected' : ''); ?>>Fashion</option>
                            <option value="kerajinan" <?= ($user['jenis_usaha'] === 'kerajinan' ? 'selected' : ''); ?>>Kerajinan</option>
                            <option value="jasa" <?= ($user['jenis_usaha'] === 'jasa' ? 'selected' : ''); ?>>Jasa</option>
                            <option value="retail" <?= ($user['jenis_usaha'] === 'retail' ? 'selected' : ''); ?>>Retail</option>
                            <option value="digital" <?= ($user['jenis_usaha'] === 'digital' ? 'selected' : ''); ?>>Digital</option>
                            <option value="lainnya" <?= ($user['jenis_usaha'] === 'lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="form-section-title">Data Bisnis Untuk AI Advisor</div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Modal (Rp)</label>
                        <input type="number" min="1" step="1000" name="advisor_modal" class="form-input" value="<?= htmlspecialchars((string) ($user['advisor_modal'] ?? '')); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Minat</label>
                        <input type="text" maxlength="100" name="advisor_minat" class="form-input" value="<?= htmlspecialchars((string) ($user['advisor_minat'] ?? '')); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Lokasi</label>
                        <input type="text" maxlength="100" name="advisor_lokasi" class="form-input" value="<?= htmlspecialchars((string) ($user['advisor_lokasi'] ?? '')); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tujuan</label>
                        <input type="text" maxlength="150" name="advisor_tujuan" class="form-input" value="<?= htmlspecialchars((string) ($user['advisor_tujuan'] ?? '')); ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="<?= site_url('user/profile/' . $user['id_user']); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
