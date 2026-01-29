<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Langganan - Usahain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Midtrans Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo isset($midtrans_client_key) ? $midtrans_client_key : 'SB-Mid-client-PsNdWysSRWU44dJt'; ?>"></script>
    <script>
    function choosePlan(plan) {
        const planPrices = {
            'starter': 0,
            'essential': 18000,
            'growth': 45000,
            'elite': 85000
        };

        // Cek login dengan PHP (inject variable dari backend)
        var isLoggedIn = <?php echo json_encode($this->session->userdata('id_user') ? true : false); ?>;
        if (!isLoggedIn) {
            Swal.fire({
                icon: 'info',
                title: 'Login Diperlukan',
                text: 'Silakan login terlebih dahulu untuk memilih paket langganan.',
                confirmButtonColor: '#1F6B99',
                confirmButtonText: 'Login'
            }).then(() => {
                window.location.href = '<?php echo site_url('auth/login'); ?>';
            });
            return;
        }
        if (plan === 'starter') {
            Swal.fire({
                icon: 'info',
                title: 'Paket Gratis',
                text: 'Paket Starter gratis! Anda dapat langsung menggunakannya.',
                confirmButtonColor: '#1F6B99',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '<?php echo site_url('user'); ?>';
            });
            return;
        }

        // Debug log
        console.log('Fetching snap token for plan:', plan);
        console.log('Endpoint:', '<?php echo site_url('subscription/get_snap_token'); ?>');

        // Show loading
        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Langsung fetch snapToken tanpa confirm
        fetch('<?php echo site_url('subscription/get_snap_token'); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ paket: plan })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            Swal.close();

            if (data.snapToken) {
                console.log('Opening Snap popup with token:', data.snapToken);
                window.snap.pay(data.snapToken, {
                    onSuccess: function(result){
                        console.log('Payment success:', result);

                        // Show processing
                        Swal.fire({
                            title: 'Mengaktifkan Langganan...',
                            text: 'Mohon tunggu',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Save subscription to database
                        fetch('<?php echo site_url('subscription/payment_success'); ?>', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                order_id: result.order_id,
                                paket: plan,
                                transaction_id: result.transaction_id,
                                payment_type: result.payment_type
                            })
                        })
                        .then(response => response.json())
                        .then(saveResult => {
                            console.log('Save result:', saveResult);
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil!',
                                text: 'Langganan Anda telah diaktifkan.',
                                confirmButtonColor: '#1F6B99',
                                confirmButtonText: 'Lanjut ke Dashboard'
                            }).then(() => {
                                window.location.href = '<?php echo site_url('auth/dashboard_operasional'); ?>';
                            });
                        })
                        .catch(err => {
                            console.error('Save error:', err);
                            Swal.fire({
                                icon: 'warning',
                                title: 'Pembayaran Berhasil',
                                text: 'Pembayaran berhasil, tetapi terjadi kesalahan saat mengaktifkan langganan. Silakan hubungi admin.',
                                confirmButtonColor: '#1F6B99'
                            }).then(() => {
                                window.location.href = '<?php echo site_url('subscription'); ?>';
                            });
                        });
                    },
                    onPending: function(result){
                        Swal.fire({
                            icon: 'info',
                            title: 'Transaksi Tertunda',
                            text: 'Silakan selesaikan pembayaran Anda.',
                            confirmButtonColor: '#1F6B99'
                        });
                        console.log(result);
                    },
                    onError: function(result){
                        Swal.fire({
                            icon: 'error',
                            title: 'Pembayaran Gagal',
                            text: 'Silakan coba lagi.',
                            confirmButtonColor: '#1F6B99'
                        });
                        console.log(result);
                    },
                    onClose: function(){
                        console.log('Popup pembayaran ditutup tanpa menyelesaikan transaksi');
                    }
                });
            } else if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error,
                    confirmButtonColor: '#1F6B99'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal mendapatkan token pembayaran.',
                    confirmButtonColor: '#1F6B99'
                });
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Koneksi',
                text: 'Gagal menghubungi server pembayaran.',
                confirmButtonColor: '#1F6B99'
            });
        });
    }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f0f8fc 100%);
            min-height: 100vh;
            padding: 60px 20px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* === CLOSE BUTTON === */
        .close-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 44px;
            height: 44px;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #64748b;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 0;
            line-height: 1;
        }

        .close-btn:hover {
            background: #f8fafc;
            border-color: #1f6b99;
            color: #1f6b99;
            box-shadow: 0 4px 12px rgba(31, 107, 153, 0.2);
            transform: rotate(90deg);
        }

        /* === PRICING HEADER === */
        .pricing-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .pricing-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .pricing-header p {
            font-size: 1.1rem;
            color: #64748b;
        }

        /* === TABS === */
        .pricing-tabs {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 60px;
        }

        .tab-btn {
            padding: 12px 32px;
            border: 2px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .tab-btn:hover {
            border-color: #1f6b99;
            color: #1f6b99;
            background: #f0f6fb;
        }

        .tab-btn.active {
            background: #1f6b99;
            color: white;
            border-color: #1f6b99;
            box-shadow: 0 4px 12px rgba(31, 107, 153, 0.3);
        }

        /* === PRICING GRID === */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 60px;
        }

        /* === PRICING CARD === */
        .pricing-card {
            border-radius: 16px;
            padding: 32px 24px;
            border: 2px solid #e2e8f0;
            position: relative;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Starter - Pink */
        .pricing-card:nth-child(1) {
            background: #FCE4E6;
            border-top: 4px solid #E74C3C;
        }

        /* Essential - Blue */
        .pricing-card:nth-child(2) {
            background: #E3F2FD;
            border-top: 4px solid #1F6B99;
        }

        /* Growth - Purple */
        .pricing-card:nth-child(3) {
            background: #EDE9FE;
            border-top: 4px solid #7C3AED;
        }

        /* Elite - Yellow/Orange */
        .pricing-card:nth-child(4) {
            background: #FEF3E2;
            border-top: 4px solid #F59E0B;
        }

        .pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(31, 107, 153, 0.12);
        }

        /* Highlighted card untuk Growth/Populer */
        .pricing-card.highlighted {
            border-color: #7C3AED;
            transform: scale(1.02);
        }

        /* === BADGE === */
        .badge-popular {
            position: absolute;
            top: -12px;
            right: 20px;
            background: linear-gradient(135deg, #1f6b99 0%, #154a6f 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(31, 107, 153, 0.3);
        }

        /* === PLAN NAME === */
        .plan-name {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .plan-subtitle {
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 16px;
            font-weight: 500;
        }

        /* === PRICE === */
        .price-section {
            margin-bottom: 4px;
        }

        .price-tag {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1f6b99;
            letter-spacing: -0.5px;
        }

        .price-period {
            font-size: 0.95rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 24px;
            display: block;
        }

        .plan-description {
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 24px;
            min-height: 20px;
        }

        /* === FEATURES LIST === */
        .features-list {
            list-style: none;
            margin: 0 0 32px 0;
            flex-grow: 1;
        }

        .features-list li {
            padding: 12px 0;
            color: #475569;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 0.95rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .features-list li::before {
            content: "✓";
            color: #1f6b99;
            font-weight: 800;
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* === BUTTON === */
        .btn-choose {
            width: 100%;
            padding: 14px 24px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-transform: capitalize;
            margin-top: auto;
            color: white;
        }

        .pricing-card:nth-child(1) .btn-choose {
            background: #E74C3C;
        }

        .pricing-card:nth-child(1) .btn-choose:hover {
            background: #C0392B;
        }

        .pricing-card:nth-child(2) .btn-choose {
            background: #1F6B99;
        }

        .pricing-card:nth-child(2) .btn-choose:hover {
            background: #154A6F;
        }

        .pricing-card:nth-child(3) .btn-choose {
            background: #7C3AED;
        }

        .pricing-card:nth-child(3) .btn-choose:hover {
            background: #6D28D9;
        }

        .pricing-card:nth-child(4) .btn-choose {
            background: #F59E0B;
        }

        .pricing-card:nth-child(4) .btn-choose:hover {
            background: #D97706;
        }

        .btn-choose:active {
            transform: translateY(0);
        }

        /* === FOOTER NOTE === */
        .footer-note {
            text-align: center;
            margin-top: 60px;
            padding: 32px;
            background: white;
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            color: #64748b;
            font-size: 0.95rem;
        }

        .footer-note a {
            color: #1f6b99;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .footer-note a:hover {
            color: #154a6f;
            text-decoration: underline;
        }

        /* === RESPONSIVE === */
        @media (max-width: 1200px) {
            .pricing-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .pricing-header h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .pricing-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .pricing-header h1 {
                font-size: 1.75rem;
            }

            .pricing-card {
                padding: 28px 24px;
            }

            .pricing-card.highlighted {
                transform: scale(1);
            }

            .pricing-card.highlighted:hover {
                transform: translateY(-8px) scale(1);
            }

            .price-tag {
                font-size: 2rem;
            }

            .features-list li {
                font-size: 0.9rem;
                padding: 10px 0;
            }
        }

        @media (max-width: 576px) {
            .pricing-header {
                margin-bottom: 40px;
            }

            .pricing-header h1 {
                font-size: 1.5rem;
            }

            .pricing-header p {
                font-size: 0.95rem;
            }

            .plan-name {
                font-size: 1.35rem;
            }

            .price-tag {
                font-size: 1.75rem;
            }

            .btn-choose {
                padding: 12px 20px;
                font-size: 0.95rem;
            }

            .features-list li {
                font-size: 0.85rem;
                padding: 8px 0;
            }

            .pricing-card {
                padding: 24px;
            }

            .badge-popular {
                padding: 5px 12px;
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <!-- Close Button -->
    <button class="close-btn" onclick="window.location.href='<?= site_url('auth/dashboard_operasional'); ?>'" title="Kembali ke Dashboard">×</button>

    <div class="container">
        <!-- Header -->
        <div class="pricing-header">
            <h1>Pilih Paket yang Tepat untuk Bisnis Anda</h1>
            <p>Mulai gratis atau tingkatkan dengan fitur premium</p>
        </div>

        <!-- Tabs -->
        <div class="pricing-tabs">
            <button class="tab-btn active" onclick="switchTab('bulan')">Bulan</button>
            <button class="tab-btn" onclick="switchTab('pertahun')">Pertahun</button>
        </div>

        <!-- Pricing Grid -->
        <div class="pricing-grid" id="pricingGrid">
        </div>

        <!-- Footer Note -->
        <div class="footer-note">
            <p><strong>Need more capabilities for your business?</strong><br>See <a href="#">Enterprise</a></p>
        </div>
    </div>

    <script>
        const pricingData = {
            bulan: [
                {
                    name: 'Starter',
                    subtitle: 'Mulai Perjalanan',
                    price: 'Rp0',
                    period: 'Gratis Selamanya',
                    badge: '',
                    features: ['3 AI Advisor/bulan', 'Max 20 transaksi', 'Dashboard dasar'],
                    plan: 'starter'
                },
                {
                    name: 'Essential',
                    subtitle: 'Otomatisasi Efisien',
                    price: 'Rp18K',
                    period: 'per bulan',
                    badge: 'PROMO',
                    features: ['10 AI Advisor/bulan', 'Unlimited pencatatan', 'Export PDF'],
                    plan: 'essential'
                },
                {
                    name: 'Growth',
                    subtitle: 'Kembangkan Bisnis',
                    price: 'Rp45K',
                    period: 'per bulan',
                    badge: 'POPULER',
                    features: ['Unlimited AI Advisor', '5 Analisis kompetitor', 'Smart Alert'],
                    plan: 'growth',
                    highlighted: true
                },
                {
                    name: 'Elite',
                    subtitle: 'Pendampingan Personal',
                    price: 'Rp85K',
                    period: 'per bulan',
                    badge: 'TERBAIK',
                    features: ['2 sesi konsultasi 1-on-1', 'Unlimited analisis', 'Priority Support'],
                    plan: 'elite'
                }
            ],
            pertahun: [
                {
                    name: 'Starter',
                    subtitle: 'Mulai Perjalanan',
                    price: 'Rp0',
                    period: 'Gratis Selamanya',
                    badge: '',
                    features: ['3 AI Advisor/bulan', 'Max 20 transaksi', 'Dashboard dasar'],
                    plan: 'starter'
                },
                {
                    name: 'Essential',
                    subtitle: 'Otomatisasi Efisien',
                    price: 'Rp180K',
                    period: 'per tahun',
                    badge: 'PROMO',
                    features: ['10 AI Advisor/bulan', 'Unlimited pencatatan', 'Export PDF'],
                    plan: 'essential'
                },
                {
                    name: 'Growth',
                    subtitle: 'Kembangkan Bisnis',
                    price: 'Rp450K',
                    period: 'per tahun',
                    badge: 'POPULER',
                    features: ['Unlimited AI Advisor', '5 Analisis kompetitor', 'Smart Alert'],
                    plan: 'growth',
                    highlighted: true
                },
                {
                    name: 'Elite',
                    subtitle: 'Pendampingan Personal',
                    price: 'Rp850K',
                    period: 'per tahun',
                    badge: 'TERBAIK',
                    features: ['2 sesi konsultasi 1-on-1', 'Unlimited analisis', 'Priority Support'],
                    plan: 'elite'
                }
            ]
        };

        function switchTab(tab) {
            // Update active tab
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');

            // Render pricing cards
            renderPricingCards(tab);
        }

        function renderPricingCards(tab) {
            const grid = document.getElementById('pricingGrid');
            const data = pricingData[tab];

            grid.innerHTML = data.map(card => `
                <div class="pricing-card ${card.highlighted ? 'highlighted' : ''}">
                    ${card.badge ? `<span class="badge-popular">${card.badge}</span>` : ''}
                    <div class="plan-name">${card.name}</div>
                    <div class="plan-subtitle">${card.subtitle}</div>
                    <div class="price-section">
                        <span class="price-tag">${card.price}</span>
                    </div>
                    <span class="price-period">${card.period}</span>
                    <div class="plan-description"></div>

                    <ul class="features-list">
                        ${card.features.map(feature => `<li>${feature}</li>`).join('')}
                    </ul>

                    <button class="btn-choose" onclick="choosePlan('${card.plan}')">Pilih Paket</button>
                </div>
            `).join('');
        }

        // Initialize with bulan
        renderPricingCards('bulan');
    </script>
