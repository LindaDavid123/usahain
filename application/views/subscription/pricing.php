<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Langganan - Usahain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Midtrans Snap.js -->
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-DfXdVd5IoBrCwNT4"></script>
    <script>
    function choosePlan(plan) {
        const planPrices = {
            'starter': 0,
            'essential': 18000,
            'growth': 45000,
            'elite': 85000
        };
        if (plan === 'starter') {
            alert('Paket Starter gratis!');
            // Redirect or handle free plan logic here
            return;
        }
        if (confirm(`Anda memilih paket ${plan.toUpperCase()}\nHarga: Rp ${planPrices[plan].toLocaleString('id-ID')}\n\nLanjutkan ke pembayaran?`)) {
            // AJAX ke backend untuk dapatkan snapToken
            fetch('<?= site_url('subscription/get_snap_token'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ paket: plan })
            })
            .then(response => response.json())
            .then(data => {
                if (data.snapToken) {
                    window.snap.pay(data.snapToken, {
                        onSuccess: function(result){
                            alert('Pembayaran berhasil!');
                            window.location.reload();
                        },
                        onPending: function(result){
                            alert('Transaksi belum selesai. Silakan selesaikan pembayaran.');
                        },
                        onError: function(result){
                            alert('Pembayaran gagal. Silakan coba lagi.');
                        }
                    });
                } else {
                    alert('Gagal mendapatkan token pembayaran.');
                }
            })
            .catch(() => alert('Gagal menghubungi server pembayaran.'));
        }
    }
    </script>
    <style>
        .pricing-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1C6494;
            margin-bottom: 12px;
        }
        .pricing-header p { font-size: 1.1rem; color: #6b7280; }
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px; }
        .pricing-card { background: white; border-radius: 24px; padding: 36px 28px; box-shadow: 0 4px 20px rgba(28, 100, 148, 0.08); transition: all 0.3s ease; position: relative; border: 3px solid transparent; }
        .pricing-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(28, 100, 148, 0.15); }
        .pricing-card.starter { background: linear-gradient(135deg, #ffe4e8 0%, #ffd4db 100%); }
        .pricing-card.essential { background: linear-gradient(135deg, #cfe5f2 0%, #b8d9ed 100%); border-color: #1C6494; }
        .pricing-card.growth { background: linear-gradient(135deg, #e4d9f5 0%, #d4c5ed 100%); }
        .pricing-card.elite { background: linear-gradient(135deg, #fff4d9 0%, #ffe8b8 100%); }
        .badge-top { position: absolute; top: -12px; right: 20px; background: #FFD700; color: #1C6494; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4); }
        .badge-top.promo { background: #FFD700; }
        .badge-top.populer { background: #ff9800; color: white; }
        .badge-top.terbaik { background: #4CAF50; color: white; }
        .plan-name { font-size: 1.8rem; font-weight: 700; margin-bottom: 8px; }
        .starter .plan-name { color: #e74c3c; }
        .essential .plan-name { color: #1C6494; }
        .growth .plan-name { color: #9b59ff; }
        .elite .plan-name { color: #ff9800; }
        .plan-subtitle { font-size: 0.95rem; color: #6b7280; margin-bottom: 24px; font-style: italic; }
        .price-tag { font-size: 3rem; font-weight: 700; margin-bottom: 8px; line-height: 1; }
        .starter .price-tag { color: #e74c3c; }
        .essential .price-tag { color: #1C6494; }
        .growth .price-tag { color: #9b59ff; }
        .elite .price-tag { color: #ff9800; }
        .price-period { font-size: 0.95rem; color: #6b7280; margin-bottom: 24px; }
        .features-list { list-style: none; padding: 0; margin: 24px 0; }
        .features-list li { padding: 10px 0; color: #374151; display: flex; align-items: flex-start; gap: 8px; }
        .features-list li:before { content: "✓"; color: #27ae60; font-weight: bold; font-size: 1.2rem; }
        .btn-choose { width: 100%; padding: 14px; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .starter .btn-choose { background: #e74c3c; color: white; }
        .essential .btn-choose { background: #1C6494; color: white; }
        .growth .btn-choose { background: #9b59ff; color: white; }
        .elite .btn-choose { background: #ff9800; color: white; }
        .btn-choose:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); }
        .footer-note { text-align: center; margin-top: 40px; color: #6b7280; }
        .footer-note a { color: #1C6494; text-decoration: none; font-weight: 600; }
        @media (max-width: 768px) { .pricing-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="pricing-header">
            <h1>Pilih Paket yang Tepat untuk Bisnis Anda</h1>
            <p>Mulai gratis atau tingkatkan dengan fitur premium</p>
        </div>

        <div class="pricing-grid">
            <!-- Starter -->
            <div class="pricing-card starter">
                <div class="plan-name">Starter</div>
                <div class="plan-subtitle">Mulai Perjalanan</div>
                <div class="price-tag">Rp0</div>
                <div class="price-period">Gratis Selamanya</div>
                
                <ul class="features-list">
                    <li>3 AI Advisor/bulan</li>
                    <li>Max 20 transaksi</li>
                    <li>Dashboard dasar</li>
                </ul>

                <button class="btn-choose" onclick="choosePlan('starter')">Pilih Paket</button>
            </div>

            <!-- Essential -->
            <div class="pricing-card essential">
                <span class="badge-top promo">PROMO</span>
                <div class="plan-name">Essential</div>
                <div class="plan-subtitle">Otomatisasi Efisien</div>
                <div class="price-tag">Rp18K</div>
                <div class="price-period">per bulan</div>
                
                <ul class="features-list">
                    <li>10 AI Advisor/bulan</li>
                    <li>Unlimited pencatatan</li>
                    <li>Export PDF</li>
                </ul>

                <button class="btn-choose" onclick="choosePlan('essential')">Pilih Paket</button>
            </div>

            <!-- Growth -->
            <div class="pricing-card growth">
                <span class="badge-top populer">POPULER</span>
                <div class="plan-name">Growth</div>
                <div class="plan-subtitle">Kembangkan Bisnis</div>
                <div class="price-tag">Rp45K</div>
                <div class="price-period">per bulan</div>
                
                <ul class="features-list">
                    <li>Unlimited AI Advisor</li>
                    <li>5 Analisis kompetitor</li>
                    <li>Smart Alert</li>
                </ul>

                <button class="btn-choose" onclick="choosePlan('growth')">Pilih Paket</button>
            </div>

            <!-- Elite -->
            <div class="pricing-card elite">
                <span class="badge-top terbaik">TERBAIK</span>
                <div class="plan-name">Elite</div>
                <div class="plan-subtitle">Pendampingan Personal</div>
                <div class="price-tag">Rp85K</div>
                <div class="price-period">per bulan</div>
                
                <ul class="features-list">
                    <li>2 sesi konsultasi 1-on-1</li>
                    <li>Unlimited analisis</li>
                    <li>Priority Support</li>
                </ul>

                <button class="btn-choose" onclick="choosePlan('elite')">Pilih Paket</button>
            </div>
        </div>

        <div class="footer-note">
            <p>💡 <strong>Detail lengkap fitur dan perbandingan tersedia di</strong> <a href="<?= site_url('subscription/compare'); ?>">halaman langganan</a></p>
        </div>
    </div>

    <script>
        function choosePlan(plan) {
            const planPrices = {
                'starter': 0,
                'essential': 18000,
                'growth': 45000,
                'elite': 85000
            };

            if (confirm(`Anda memilih paket ${plan.toUpperCase()}.\n\nHarga: Rp ${planPrices[plan].toLocaleString('id-ID')}\n\nLanjutkan ke pembayaran?`)) {
                window.location.href = '<?= site_url("subscription/checkout/"); ?>' + plan;
            }
        }
    </script>
</body>
</html>
