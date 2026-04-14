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
                                window.location.href = '<?php echo site_url('auth/dashboard'); ?>';
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
            display: inline-flex;
            justify-content: center;
            gap: 4px;
            background: #f3f4f6;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 60px;
            margin-left: auto;
            margin-right: auto;
        }

        .tab-btn {
            padding: 10px 24px;
            border: none;
            background: transparent;
            color: #374151;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .tab-btn:hover {
            color: #111827;
            background: #e5e7eb;
        }

        .tab-btn.active {
            background: #1c6494;
            color: white;
            box-shadow: none;
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
            padding: 24px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            position: relative;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 8px rgba(17, 24, 39, 0.05);
        }

        .pricing-card.plan-starter {
            background: #f8fafc;
        }

        .pricing-card.plan-essential {
            background: #f0f7ff;
        }

        .pricing-card.plan-growth {
            background: #f5f3ff;
        }

        .pricing-card.plan-elite {
            background: #fffbeb;
        }

        .pricing-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 20px rgba(17, 24, 39, 0.08);
        }

        .pricing-card.highlighted {
            border-color: #e5e7eb;
        }

        /* === BADGE === */
        .badge-popular {
            position: absolute;
            top: 16px;
            right: 16px;
            background: #1c6494;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.4;
        }

        /* === PLAN NAME === */
        .plan-name {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 8px;
        }

        .plan-subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 16px;
            font-weight: 400;
        }

        /* === PRICE === */
        .price-section {
            margin-bottom: 4px;
        }

        .price-tag {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            letter-spacing: 0;
        }

        .price-period {
            font-size: 12px;
            color: #6b7280;
            font-weight: 400;
            margin-bottom: 20px;
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
            margin: 0 0 24px 0;
            flex-grow: 1;
        }

        .features-list li {
            padding: 8px 0;
            color: #374151;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 13px;
        }

        .feature-check {
            width: 13px;
            height: 13px;
            color: #1c6494;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* === BUTTON === */
        .btn-choose {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #1c6494;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: capitalize;
            margin-top: auto;
            color: white;
            background: #1c6494;
        }

        .btn-choose:hover {
            background: #155379;
            border-color: #155379;
        }

        .pricing-card.plan-starter .btn-choose {
            background: transparent;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .pricing-card.plan-starter .btn-choose:hover {
            background: #f9fafb;
            border-color: #e5e7eb;
            color: #111827;
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
                padding: 24px;
            }

            .pricing-card.highlighted {
                transform: scale(1);
            }

            .pricing-card.highlighted:hover {
                transform: translateY(-8px) scale(1);
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

            .pricing-card {
                padding: 24px;
            }

            .btn-choose {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Close Button -->
    <button class="close-btn" onclick="window.location.href='<?= site_url('auth/dashboard'); ?>'" title="Kembali ke Dashboard">×</button>

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
            const checkIcon = '<svg class="feature-check" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

            grid.innerHTML = data.map(card => `
                <div class="pricing-card plan-${card.plan} ${card.highlighted ? 'highlighted' : ''}">
                    ${card.badge ? `<span class="badge-popular">${card.badge}</span>` : ''}
                    <div class="plan-name">${card.name}</div>
                    <div class="plan-subtitle">${card.subtitle}</div>
                    <div class="price-section">
                        <span class="price-tag">${card.price}</span>
                    </div>
                    <span class="price-period">${card.period}</span>
                    <div class="plan-description"></div>

                    <ul class="features-list">
                        ${card.features.map(feature => `<li>${checkIcon}<span>${feature}</span></li>`).join('')}
                    </ul>

                    <button class="btn-choose" onclick="choosePlan('${card.plan}')">Pilih Paket</button>
                </div>
            `).join('');
        }

        // Initialize with bulan
        renderPricingCards('bulan');
    </script>
