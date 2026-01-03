<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Risiko - Usahain</title>
    <style>
        :root {
            --primary: #1C6494;
            --primary-dark: #144d73;
            --danger: #e74c3c;
            --warning: #f39c12;
            --success: #2ecc71;
            --info: #5dade2;
            --text: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
            --border: #e1e8ed;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-light);
            padding: 20px;
            color: var(--text);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .header-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 24px;
            color: var(--text);
            margin-bottom: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .header h1 .shield-icon {
            color: var(--primary);
            font-size: 28px;
        }

        .header p {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
        }

        /* Risk Grid */
        .risk-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .risk-card {
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .risk-card h3 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text);
        }

        .risk-card ul {
            list-style: none;
            padding: 0;
        }

        .risk-card li {
            font-size: 13px;
            line-height: 1.7;
            color: var(--text);
            padding-left: 18px;
            position: relative;
            margin-bottom: 6px;
        }

        .risk-card li::before {
            content: '•';
            position: absolute;
            left: 5px;
            font-weight: 700;
        }

        /* Card Colors */
        .risk-tinggi {
            background: linear-gradient(135deg, #ffe0e6 0%, #ffd4de 100%);
        }

        .risk-sedang {
            background: linear-gradient(135deg, #fff9e6 0%, #fff3cc 100%);
        }

        .mitigasi {
            background: linear-gradient(135deg, #e8f8f0 0%, #d4f1e3 100%);
        }

        .kontinjensi {
            background: linear-gradient(135deg, #e6f4fb 0%, #d4ebf7 100%);
        }

        /* Analisis Button */
        .analisis-button {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-bottom: 25px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(28, 100, 148, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .analisis-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(28, 100, 148, 0.4);
        }

        /* Score Section */
        .score-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .score-section h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 15px;
        }

        .score-input {
            width: 100%;
            padding: 15px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            resize: vertical;
            min-height: 100px;
            transition: all 0.3s;
            background: var(--bg-light);
        }

        .score-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(28, 100, 148, 0.1);
        }

        .score-hint {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 8px;
        }

        /* Save Button */
        .save-button {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--success) 0%, #27ae60 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .risk-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header,
        .risk-card,
        .analisis-button,
        .score-section {
            animation: fadeInUp 0.5s ease;
        }

        .risk-card:nth-child(1) { animation-delay: 0.1s; }
        .risk-card:nth-child(2) { animation-delay: 0.2s; }
        .risk-card:nth-child(3) { animation-delay: 0.3s; }
        .risk-card:nth-child(4) { animation-delay: 0.4s; }
        .analisis-button { animation-delay: 0.5s; }
        .score-section { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <span class="shield-icon">🛡️</span>
                Manajemen Risiko
            </h1>
            <p>Identifikasi dan kelola risiko bisnis Anda dengan checklist praktis</p>
        </div>

        <!-- Risk Grid -->
        <div class="risk-grid">
            <!-- Risiko Tinggi -->
            <div class="risk-card risk-tinggi">
                <h3>Risiko Tinggi</h3>
                <ul>
                    <li>Tidak ada asuransi bisnis</li>
                    <li>Bergantung pada 1 supplier</li>
                    <li>Tidak ada dana darurat</li>
                </ul>
            </div>

            <!-- Risiko Sedang -->
            <div class="risk-card risk-sedang">
                <h3>Risiko Sedang</h3>
                <ul>
                    <li>Kompetitor baru</li>
                    <li>Ketergantungan inventori</li>
                    <li>Fluktuasi harga bahan baku</li>
                </ul>
            </div>

            <!-- Mitigasi Risiko -->
            <div class="risk-card mitigasi">
                <h3>Mitigasi Risiko</h3>
                <ul>
                    <li>Buat kontrak dengan supplier</li>
                    <li>Siapkan dana darurat 6 bulan</li>
                    <li>Buat SOP untuk semua proses</li>
                </ul>
            </div>

            <!-- Rencana Kontinjensi -->
            <div class="risk-card kontinjensi">
                <h3>Rencana Kontinjensi</h3>
                <ul>
                    <li>Backup supplier alternatif</li>
                    <li>Sistem pembayaran digital</li>
                    <li>Asuransi properti & inventori</li>
                </ul>
            </div>
        </div>

        <!-- Analisis Risiko Button -->
        <button class="analisis-button" onclick="analyzeRisk()">
            <span>📊</span>
            <span>Analisis Risiko</span>
        </button>

        <!-- Score Section -->
        <div class="score-section">
            <h3>Skor Risiko Anda</h3>
            <textarea 
                class="score-input" 
                id="riskScore"
                placeholder="Risiko sedang - Perlu perhatian pada beberapa area. Fokus pada mitigasi risiko tinggi terlebih dahulu."
            ></textarea>
            <p class="score-hint">Catatan analisis risiko bisnis Anda akan muncul di sini</p>
        </div>

        <!-- Save Button -->
        <button class="save-button" onclick="saveRiskAssessment()">
            Simpan
        </button>

        <!-- Back Link -->
        <div class="back-link">
            <a href="<?= site_url('auth/dashboard'); ?>">← Kembali ke Dashboard</a>
        </div>
    </div>

    <script>
        function analyzeRisk() {
            const scoreInput = document.getElementById('riskScore');
            
            // Simulate risk analysis
            const analyses = [
                "Risiko sedang - Perlu perhatian pada beberapa area. Fokus pada mitigasi risiko tinggi terlebih dahulu.",
                "Risiko tinggi terdeteksi! Segera lakukan mitigasi untuk risiko tanpa asuransi bisnis dan ketergantungan supplier tunggal.",
                "Skor risiko Anda: SEDANG (60/100). Prioritaskan pembuatan dana darurat dan backup supplier.",
                "Status baik! Namun tetap waspada terhadap kompetitor baru dan fluktuasi harga bahan baku."
            ];
            
            const randomAnalysis = analyses[Math.floor(Math.random() * analyses.length)];
            scoreInput.value = randomAnalysis;
            
            // Animate
            scoreInput.style.border = '2px solid var(--primary)';
            setTimeout(() => {
                scoreInput.style.border = '2px solid var(--border)';
            }, 1000);
        }

        function saveRiskAssessment() {
            const scoreValue = document.getElementById('riskScore').value;
            
            if (!scoreValue.trim()) {
                alert('Silakan lakukan analisis risiko terlebih dahulu dengan klik tombol "Analisis Risiko"');
                return;
            }

            // Show loading state
            const saveBtn = document.querySelector('.save-button');
            const originalText = saveBtn.textContent;
            saveBtn.textContent = 'Menyimpan...';
            saveBtn.disabled = true;

            // Simulate save (replace with actual AJAX call)
            setTimeout(() => {
                alert('✅ Assessment risiko berhasil disimpan!');
                saveBtn.textContent = originalText;
                saveBtn.disabled = false;
                
                // Redirect to dashboard after 1 second
                setTimeout(() => {
                    window.location.href = '<?= site_url("auth/dashboard"); ?>';
                }, 1000);
            }, 1500);
        }

        // Auto-populate if coming back to edit
        window.addEventListener('DOMContentLoaded', () => {
            const savedScore = localStorage.getItem('riskScore');
            if (savedScore) {
                document.getElementById('riskScore').value = savedScore;
            }
        });
    </script>
</body>
</html>
