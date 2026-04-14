<?php
$user = array_merge([
    'id_user'      => '',
    'nama'         => 'User',
    'email'        => '-',
    'nama_usaha'   => '-',
    'jenis_usaha'  => '-',
    'advisor_modal' => null,
    'advisor_minat' => '',
    'advisor_lokasi' => '',
    'advisor_tujuan' => '',
    'avatar_url'   => '',
    'oauth_provider' => 'local',
    'created_at'   => '-'
], (array)($user ?? []));

$flashSuccess = $this->session->flashdata('success');
$flashError = $this->session->flashdata('error');

$rawNama = trim((string)($user['nama'] ?? 'User'));
$displayNama = $rawNama !== '' ? $rawNama : 'User';
$nimSubtitle = '';

if (preg_match('/\b\d{2}\.\d{2}\.\d{4}\b/', $displayNama, $nimMatch)) {
    $nimSubtitle = $nimMatch[0];
    $displayNama = trim(str_replace($nimMatch[0], '', $displayNama));
    $displayNama = preg_replace('/\s{2,}/', ' ', $displayNama);
    if ($displayNama === '') {
        $displayNama = $rawNama;
        $nimSubtitle = '';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Usahain</title>
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

        /* ===== HEADER ===== */
        .header {
            background: #1E6FBA;
            color: white;
            padding: 32px 28px;
            border-radius: 16px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(31, 107, 153, 0.15);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-identity {
            display: flex;
            align-items: center;
            gap: 20px;
            min-width: 0;
            flex: 1;
        }

        .profile-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            flex-shrink: 0;
            overflow: hidden;
            object-fit: cover;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info h1 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .profile-subtitle {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.72);
            margin-bottom: 4px;
            font-weight: 500;
        }

        .profile-info p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
            margin-bottom: 0;
            font-weight: 400;
        }

        /* ===== NAV TABS ===== */
        .nav-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 40px;
        }

        .nav-tab {
            padding: 16px 24px;
            border: none;
            background: none;
            color: #6b7280;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            border-bottom: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 8px;
        }

        .nav-tab i,
        .nav-tab svg {
            width: 15px;
            height: 15px;
            stroke-width: 2;
        }

        .nav-tab:hover {
            color: #1E6FBA;
        }

        .nav-tab.active {
            color: #1E6FBA;
            border-bottom: 2px solid #1E6FBA;
            border-radius: 8px 8px 0 0;
        }

        /* ===== CONTENT SECTIONS ===== */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== INFO CARDS ===== */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            align-items: stretch;
        }

        .info-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .info-card-label {
            font-size: 10px;
            font-weight: 500;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .info-card-value {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            word-break: break-word;
            line-height: 1.4;
        }

        .info-card-value.email-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            word-break: normal;
        }

        .info-card-secondary {
            font-size: 14px;
            color: #64748b;
            margin-top: 8px;
        }

        /* ===== ACTIVITY SECTION ===== */
        .activity-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #1f6b99;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 8px;
        }

        .activity-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 15px;
        }

        .activity-date {
            font-size: 12px;
            color: #94a3b8;
        }

        .activity-desc {
            font-size: 14px;
            color: #64748b;
            margin-top: 8px;
            line-height: 1.5;
        }

        /* ===== BUTTONS ===== */
        .btn-group {
            display: flex;
            gap: 12px;
            justify-content: flex-start;
            margin-bottom: 40px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: #1E6FBA;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #175d99;
        }

        .btn-secondary {
            background: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-logout-outline {
            background: transparent;
            border: 1px solid #ef4444;
            color: #ef4444;
            padding: 8px 12px;
        }

        .btn-logout-outline i,
        .btn-logout-outline svg {
            width: 16px;
            height: 16px;
        }

        .btn-logout-outline:hover {
            background: rgba(239,68,68,0.08);
        }

        .page-logout {
            display: flex;
            justify-content: flex-end;
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        /* ===== STATS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #e2e8f0;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: #1f6b99;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .profile-identity {
                width: 100%;
            }

            .nav-tabs {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .nav-tab {
                padding: 12px 16px;
                font-size: 14px;
                white-space: nowrap;
            }

            .info-grid, .stats-grid {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-wrap: wrap;
            }
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #1f6b99;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 24px;
            font-size: 14px;
            width: 24px;
            height: 24px;
            justify-content: center;
            border-radius: 6px;
        }

        .back-link:hover {
            background: #e8f4fb;
            text-decoration: none;
        }

        .back-link i,
        .back-link svg {
            width: 14px;
            height: 14px;
        }

        .alert-banner {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-banner.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-banner.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .settings-business-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-top: 24px;
        }

        .settings-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
            margin-top: 16px;
        }

        .settings-form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .settings-label {
            font-size: 12px;
            font-weight: 600;
            color: #334155;
        }

        .settings-input {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: #0f172a;
            font-family: inherit;
        }

        .settings-input:focus {
            outline: none;
            border-color: #1E6FBA;
            box-shadow: 0 0 0 3px rgba(30, 111, 186, 0.12);
        }

        .settings-note {
            margin-top: 8px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= site_url('auth/dashboard'); ?>" class="back-link" aria-label="Dashboard">
            <i data-lucide="arrow-left"></i>
        </a>

        <!-- PROFILE HEADER -->
        <div class="header">
            <div class="profile-identity">
                <div class="profile-avatar">
                    <?php if (!empty($user['avatar_url'])): ?>
                        <img src="<?= htmlspecialchars($user['avatar_url']); ?>" alt="Avatar">
                    <?php else: ?>
                        <?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)); ?>
                    <?php endif; ?>
                </div>
                <div class="profile-info">
                    <h1><?= htmlspecialchars($displayNama); ?></h1>
                    <?php if ($nimSubtitle !== ''): ?>
                    <div class="profile-subtitle"><?= htmlspecialchars($nimSubtitle); ?></div>
                    <?php endif; ?>
                    <p><?= htmlspecialchars($user['email'] ?? '-'); ?></p>
                    <p>Bergabung <?= date('d M Y', strtotime($user['created_at'])); ?></p>
                </div>
            </div>
        </div>

        <?php if (!empty($flashSuccess)): ?>
            <div class="alert-banner success"><?= htmlspecialchars($flashSuccess); ?></div>
        <?php endif; ?>
        <?php if (!empty($flashError)): ?>
            <div class="alert-banner error"><?= htmlspecialchars($flashError); ?></div>
        <?php endif; ?>

        <!-- NAV TABS -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('overview', this)">
                <i data-lucide="layout-dashboard"></i>
                <span>Ringkasan</span>
            </button>
            <button class="nav-tab" onclick="showTab('business', this)">
                <i data-lucide="briefcase"></i>
                <span>Data Bisnis</span>
            </button>
            <button class="nav-tab" onclick="showTab('activity', this)">
                <i data-lucide="activity"></i>
                <span>Aktivitas</span>
            </button>
            <button class="nav-tab" onclick="showTab('settings', this)">
                <i data-lucide="settings"></i>
                <span>Pengaturan</span>
            </button>
        </div>

        <!-- TAB: OVERVIEW -->
        <div id="overview" class="tab-content active">
            <div class="btn-group">
                <a href="<?= site_url('user/edit/' . $user['id_user']); ?>" class="btn btn-primary">
                    <span>Edit Profile</span>
                </a>
                <a href="<?= site_url('user/settings'); ?>" class="btn btn-secondary">
                    <span>Pengaturan Akun</span>
                </a>
            </div>

            <h2 style="margin-bottom: 24px; font-size: 20px; color: #1e293b;">Informasi Akun</h2>
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-card-label">Nama Lengkap</div>
                    <div class="info-card-value"><?= htmlspecialchars($user['nama']); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Email</div>
                    <div class="info-card-value email-ellipsis" title="<?= htmlspecialchars($user['email'] ?? '-'); ?>"><?= htmlspecialchars($user['email'] ?? '-'); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Metode Autentikasi</div>
                    <div class="info-card-value">
                        <?php echo $user['oauth_provider'] === 'google' ? 'Google' : 'Email'; ?>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Terdaftar Sejak</div>
                    <div class="info-card-value"><?= date('d M Y', strtotime($user['created_at'])); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Status Akun</div>
                    <div class="info-card-value" style="color: #10b981;">Aktif</div>
                </div>
            </div>

            <div style="margin-top: 20px; background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                <div>
                    <div class="info-card-label" style="margin-bottom: 6px;">Paket Saat Ini</div>
                    <div class="info-card-value">Aktif Beroperasi</div>
                </div>
                <a href="<?= site_url('subscription'); ?>" class="btn btn-primary">
                    <span>Upgrade</span>
                </a>
            </div>
        </div>

        <!-- TAB: BUSINESS -->
        <div id="business" class="tab-content">
            <div class="btn-group">
                <a href="<?= site_url('user/edit/' . $user['id_user']); ?>" class="btn btn-primary">
                    <span>Edit Data Bisnis</span>
                </a>
            </div>

            <h2 style="margin-bottom: 24px; font-size: 20px; color: #1e293b;">Data Bisnis Anda</h2>
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-card-label">Nama Usaha</div>
                    <div class="info-card-value"><?= htmlspecialchars($user['nama_usaha'] ?? '-'); ?></div>
                    <div class="info-card-secondary">
                        Nama resmi bisnis Anda
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Jenis Usaha</div>
                    <div class="info-card-value"><?= htmlspecialchars($user['jenis_usaha'] ?? '-'); ?></div>
                    <div class="info-card-secondary">
                        Kategori industri utama
                    </div>
                </div>
            </div>

            <?php if (!empty($user['nama_usaha']) || !empty($user['jenis_usaha'])): ?>
            <div style="margin-top: 40px; padding: 24px; background: #e8f4fb; border-radius: 12px; border-left: 4px solid #1f6b99;">
                <h3 style="color: #1f6b99; margin-bottom: 12px; font-size: 16px;">Tips Pengembangan</h3>
                <ul style="color: #1f6b99; margin-left: 20px; line-height: 1.8; font-size: 14px;">
                    <li>Konsistenkan branding bisnis Anda di semua platform</li>
                    <li>Catat semua transaksi untuk monitoring keuangan yang akurat</li>
                    <li>Manfaatkan tools Usahain untuk strategi dan analisis bisnis</li>
                    <li>Evaluasi performa bisnis secara berkala</li>
                </ul>
            </div>
            <?php endif; ?>
        </div>

        <!-- TAB: ACTIVITY -->
        <div id="activity" class="tab-content">
            <h2 style="margin-bottom: 24px; font-size: 20px; color: #1e293b;">Aktivitas Terbaru</h2>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?= $advisor_count ?? 0; ?></div>
                    <div class="stat-label">Konsultasi AI</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $transaksi_count ?? 0; ?></div>
                    <div class="stat-label">Transaksi Tercatat</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $analisis_count ?? 0; ?></div>
                    <div class="stat-label">Analisis Produk</div>
                </div>
            </div>

            <h3 style="margin: 32px 0 16px 0; font-size: 16px; color: #1e293b;">Riwayat Aktivitas</h3>
            
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $activity): ?>
                <div class="activity-item">
                    <div class="activity-header">
                        <div class="activity-title"><?= htmlspecialchars($activity['title']); ?></div>
                        <div class="activity-date"><?= date('d M Y', strtotime($activity['date'])); ?></div>
                    </div>
                    <div class="activity-desc"><?= htmlspecialchars($activity['description']); ?></div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="padding: 40px; text-align: center; background: white; border-radius: 12px; color: #94a3b8;">
                    <p style="font-size: 16px; margin-bottom: 8px;">Belum ada aktivitas</p>
                    <p style="font-size: 14px;">Mulai gunakan Usahain untuk merencanakan bisnis Anda</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- TAB: SETTINGS -->
        <div id="settings" class="tab-content">
            <h2 style="margin-bottom: 24px; font-size: 20px; color: #1e293b;">Pengaturan Akun</h2>
            
            <div class="btn-group">
                <a href="<?= site_url('user/edit/' . $user['id_user']); ?>" class="btn btn-primary">
                    <span>Edit Profil</span>
                </a>
                <?php if ($user['oauth_provider'] === 'local'): ?>
                <a href="<?= site_url('user/change_password'); ?>" class="btn btn-secondary">
                    <i data-lucide="key"></i>
                    <span>Ubah Password</span>
                </a>
                <?php endif; ?>
            </div>

            <div id="data-bisnis-section" class="settings-business-card">
                <h3 style="color: #1e293b; margin-bottom: 8px; font-size: 16px;">Data Bisnis</h3>
                <p class="settings-note">Data ini dipakai otomatis oleh AI Advisor saat Anda membuka halaman advisor berikutnya.</p>

                <form method="post" action="<?= site_url('user/update_business_profile'); ?>">
                    <div class="settings-form-grid">
                        <div class="settings-form-group">
                            <label class="settings-label" for="advisor_modal">Modal (Rp)</label>
                            <input
                                id="advisor_modal"
                                type="number"
                                min="1"
                                step="1000"
                                name="advisor_modal"
                                class="settings-input"
                                value="<?= htmlspecialchars((string) ($user['advisor_modal'] ?? '')); ?>"
                                required
                            >
                        </div>
                        <div class="settings-form-group">
                            <label class="settings-label" for="advisor_minat">Minat</label>
                            <input
                                id="advisor_minat"
                                type="text"
                                name="advisor_minat"
                                class="settings-input"
                                maxlength="100"
                                value="<?= htmlspecialchars((string) ($user['advisor_minat'] ?? '')); ?>"
                                required
                            >
                        </div>
                        <div class="settings-form-group">
                            <label class="settings-label" for="advisor_lokasi">Lokasi</label>
                            <input
                                id="advisor_lokasi"
                                type="text"
                                name="advisor_lokasi"
                                class="settings-input"
                                maxlength="100"
                                value="<?= htmlspecialchars((string) ($user['advisor_lokasi'] ?? '')); ?>"
                                required
                            >
                        </div>
                        <div class="settings-form-group">
                            <label class="settings-label" for="advisor_tujuan">Tujuan</label>
                            <input
                                id="advisor_tujuan"
                                type="text"
                                name="advisor_tujuan"
                                class="settings-input"
                                maxlength="150"
                                value="<?= htmlspecialchars((string) ($user['advisor_tujuan'] ?? '')); ?>"
                                required
                            >
                        </div>
                    </div>

                    <div style="margin-top: 16px;">
                        <button type="submit" class="btn btn-primary">Simpan Data Bisnis</button>
                    </div>
                </form>
            </div>

            <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 24px;">
                <h3 style="color: #1e293b; margin-bottom: 16px; font-size: 16px;">Preferensi Keamanan</h3>
                
                <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e2e8f0;">
                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 8px;">Verifikasi Email</div>
                    <div style="font-size: 14px; color: #64748b; margin-bottom: 12px;">
                        Email Anda: <strong><?= htmlspecialchars($user['email'] ?? '-'); ?></strong>
                    </div>
                    <div style="font-size: 13px; color: #10b981; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="badge-check" style="width: 14px; height: 14px;"></i>
                        <span>Terverifikasi</span>
                    </div>
                </div>

                <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e2e8f0;">
                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 8px;">Metode Autentikasi</div>
                    <div style="font-size: 14px; color: #64748b;">
                        <?php 
                        $auth_method = $user['oauth_provider'] === 'google' ? 'Google OAuth' : 'Email & Password';
                        echo $auth_method;
                        ?>
                    </div>
                </div>

                <div>
                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 8px;">Aktivitas Login</div>
                    <div style="font-size: 14px; color: #64748b;">
                        Terakhir login: <strong><?= date('d M Y H:i', strtotime($user['updated_at'])); ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-logout">
            <a href="<?= site_url('auth/logout'); ?>" class="btn btn-logout-outline" onclick="return confirm('Yakin ingin logout?');">
                <i data-lucide="log-out"></i>
                <span>Log out</span>
            </a>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"></script>
    <script>
        if (window.lucide) {
            window.lucide.createIcons();
        }

        function showTab(tabName, tabButton) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all nav tabs
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked nav tab
            tabButton.classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab');
            if (!tab) {
                return;
            }

            const tabButton = document.querySelector(`.nav-tab[onclick*="'${tab}'"]`);
            const tabContent = document.getElementById(tab);
            if (tabButton && tabContent) {
                showTab(tab, tabButton);
            }
        });
    </script>
</body>
</html>
