<?php
$user = array_merge([
    'nama'  => 'User',
    'email' => '-',
    'role'  => '-',
    'usaha' => 'Bisnis Anda',
    'type'  => 'UMKM'
], $user ?? []);

$summary = array_merge([
    'today_sales'   => 0,
    'today_expense' => 0,
    'today_profit'  => 0
], $summary ?? []);

$transactions = $transactions ?? [];
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard <?= htmlspecialchars($user['nama']); ?></title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI, Roboto, Arial, sans-serif;background:#e8f0f3;color:#222}
        .header{background:linear-gradient(90deg,#2b7ec9,#4fa3d6);color:#fff;padding:18px 24px;display:flex;justify-content:space-between;align-items:center}
        .header-left h6{font-size:20px;margin:0;font-weight:700}
        .header-left p{margin-top:4px;font-size:13px;opacity:.95}
        .avatar{width:44px;height:44px;border-radius:50%;background:#fff;color:#2b7ec9;display:flex;align-items:center;justify-content:center;font-weight:700}
        .container{max-width:1100px;margin:20px auto;padding:18px}

        .bisnis-card{background:linear-gradient(135deg,#5dd85d 0%,#2fb12f 100%);color:#fff;border-radius:16px;padding:26px;display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
        .bisnis-left{display:flex;gap:16px;align-items:center}
        .store-icon{font-size:48px;width:72px;height:72px;display:flex;align-items:center;justify-content:center}
        .bisnis-info h3{margin:0;font-size:20px;font-weight:700}
        .bisnis-info p{margin:4px 0;font-size:14px}
        .bisnis-badge{background:rgba(255,255,255,0.25);border-radius:6px;padding:6px 10px;font-size:12px;font-weight:600;margin-top:6px}
        .bisnis-right{text-align:right}
        .bisnis-right .label{font-size:13px;opacity:0.95}
        .bisnis-right .amount{font-size:26px;font-weight:700;margin-top:4px}

        .section-title{font-size:16px;font-weight:700;margin:18px 0 10px;display:flex;align-items:center;gap:8px}
        .quick-actions{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px}
        .action-btn{border-radius:12px;padding:16px;text-align:center;text-decoration:none;color:#fff;font-weight:700;display:flex;flex-direction:column;align-items:center;gap:8px}
        .action-btn.orange{background:#2fb12f}
        .action-btn.red{background:#e74c3c}
        .action-btn.blue{background:#5565ff}
        .action-btn.purple{background:#9b59ff}
        .action-btn-icon{font-size:22px}

        .summary{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:18px}
        .summary-item{background:#fff;border-radius:12px;padding:16px}
        .summary-label{font-size:13px;color:#666}
        .summary-value{font-size:20px;font-weight:700}
        .summary-value.green{color:#2fb12f}
        .summary-value.red{color:#e74c3c}
        .summary-value.blue{color:#2b7ec9}
        .summary-sub{font-size:12px;color:#999;margin-top:6px}

        .month-cards{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:18px}
        .month-card{background:#fff;border-radius:12px;padding:16px;border:2px solid transparent}
        .month-card.active{border-color:#5565ff}
        .month-header{display:flex;justify-content:space-between;align-items:center}
        .month-label{font-size:13px;color:#666}
        .month-value{font-size:20px;font-weight:700;margin-top:8px}

        .transaksi-section{background:#fff;border-radius:12px;padding:16px;margin-bottom:18px}
        .transaksi-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
        .transaksi-header h6{margin:0;font-weight:700}
        .transaksi-time{font-size:12px;color:#999}
        .transaksi-item{display:flex;gap:12px;padding:12px;background:#f7f9fb;border-radius:8px;margin-bottom:10px;align-items:center}
        .transaksi-icon{font-size:26px;width:44px;height:44px;display:flex;align-items:center;justify-content:center;border-radius:8px}
        .transaksi-icon.pengeluaran{background:#ffecec}
        .transaksi-icon.penjualan{background:#e9f9ee}
        .transaksi-detail{flex:1}
        .transaksi-title{font-weight:700}
        .transaksi-meta{font-size:13px;color:#888;margin-top:4px}
        .transaksi-amount{text-align:right;font-weight:700}
        .transaksi-amount.minus{color:#e74c3c}
        .transaksi-amount.plus{color:#2fb12f}

        .tools-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
        .tool-box{background:#fff;border-radius:12px;padding:16px;text-align:center}
        .tool-icon{font-size:28px;margin-bottom:8px}
        .tool-title{font-weight:700}
        .tool-desc{font-size:13px;color:#777;margin-top:6px}

        @media(max-width:992px){.quick-actions,.tools-grid{grid-template-columns:repeat(2,1fr)}.month-cards{grid-template-columns:1fr}}

        /* ===== MODAL STYLES ===== */
        .modal-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:999;align-items:center;justify-content:center}
        .modal-overlay.active{display:flex}
        .modal-container{background:#fff;border-radius:20px;width:90%;max-width:480px;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:modalSlideIn 0.3s ease-out}
        @keyframes modalSlideIn{from{opacity:0;transform:translateY(-30px)}to{opacity:1;transform:translateY(0)}}
        .modal-header{padding:24px 24px 16px;border-bottom:1px solid #e9ecef}
        .modal-title{font-size:22px;font-weight:700;color:#222;margin:0}
        .modal-subtitle{font-size:14px;color:#6c757d;margin:6px 0 0}
        .modal-body{padding:24px}
        .modal-form-group{margin-bottom:20px}
        .modal-label{display:block;font-size:14px;font-weight:600;color:#333;margin-bottom:8px}
        .modal-input{width:100%;padding:12px 16px;border:2px solid #e0e4e8;border-radius:10px;font-size:15px;transition:border-color 0.2s;font-family:inherit}
        .modal-input:focus{outline:none;border-color:#2fb12f}
        .modal-input::placeholder{color:#adb5bd}
        .modal-select{width:100%;padding:12px 16px;border:2px solid #e0e4e8;border-radius:10px;font-size:15px;background:#fff;cursor:pointer;transition:border-color 0.2s}
        .modal-select:focus{outline:none;border-color:#2fb12f}
        .modal-textarea{width:100%;padding:12px 16px;border:2px solid #e0e4e8;border-radius:10px;font-size:15px;font-family:inherit;resize:vertical;min-height:80px;transition:border-color 0.2s}
        .modal-textarea:focus{outline:none;border-color:#2fb12f}
        .modal-footer{padding:16px 24px 24px;display:flex;gap:12px;justify-content:flex-end}
        .modal-btn{padding:12px 24px;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;transition:all 0.2s}
        .modal-btn-primary{background:#2fb12f;color:#fff}
        .modal-btn-primary:hover{background:#27a127;transform:translateY(-1px);box-shadow:0 4px 12px rgba(47,177,47,0.3)}
        .modal-btn-secondary{background:#e9ecef;color:#495057}
        .modal-btn-secondary:hover{background:#dee2e6}
        @media(max-width:576px){.modal-container{width:95%;border-radius:16px}.modal-header,.modal-body,.modal-footer{padding:16px}.modal-title{font-size:20px}}
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <h6>Dashboard <?= htmlspecialchars($user['nama']); ?></h6>
            <p>Kelola <?= htmlspecialchars($user['usaha']); ?></p>
        </div>
        <div class="avatar"><?= strtoupper(substr($user['nama'],0,1)); ?></div>
    </div>

    <div class="container">

        <div class="bisnis-card">
            <div class="bisnis-left">
                <div class="store-icon">🏬</div>
                <div class="bisnis-info">
                    <h3><?= htmlspecialchars($user['usaha']); ?></h3>
                    <p><?= htmlspecialchars($user['type'] ?? 'UMKM'); ?></p>
                    <div class="bisnis-badge">Aktif Beroperasi</div>
                </div>
            </div>
            <div class="bisnis-right">
                <div class="label">Hari Ini</div>
                <div class="amount" id="labaBersihHeader">Rp <?= number_format($summary['today_profit'],0,',','.'); ?></div>
                <div class="label">Laba Bersih</div>
            </div>
        </div>

        <div class="section-title">⚡ Aksi Cepat</div>
        <div class="quick-actions">
            <a class="action-btn orange" href="#" onclick="openModalPenjualan(); return false;"><div class="action-btn-icon">💰</div>Catat Penjualan</a>
            <a class="action-btn red" href="#"><div class="action-btn-icon">🧾</div>Catat Pengeluaran</a>
            <a class="action-btn blue" href="#"><div class="action-btn-icon">📦</div>Catat Persediaan</a>
            <a class="action-btn purple" href="#"><div class="action-btn-icon">📊</div>Laporan</a>
        </div>

        <div class="section-title">💰 Ringkasan Keuangan</div>
        <div style="font-size:13px;color:#777;margin-bottom:8px">Hari ini</div>
        <div class="summary">
            <div class="summary-item">
                <div class="summary-label">Pendapatan</div>
                <div class="summary-value green" id="totalPenjualan">Rp <?= number_format($summary['today_sales'],0,',','.'); ?></div>
                <div class="summary-sub" id="jumlahPenjualan">1 transaksi</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Pengeluaran</div>
                <div class="summary-value red" id="totalPengeluaran">Rp <?= number_format($summary['today_expense'],0,',','.'); ?></div>
                <div class="summary-sub" id="jumlahPengeluaran">1 transaksi</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Laba Bersih</div>
                <div class="summary-value blue" id="labaBersih">Rp <?= number_format($summary['today_profit'],0,',','.'); ?></div>
                <div class="summary-sub" id="marginProfit">Margin: <?= ($summary['today_sales']>0)?round(($summary['today_profit']/$summary['today_sales'])*100,1):0; ?>%</div>
            </div>
        </div>

        <div style="font-size:13px;color:#777;margin:16px 0 8px">Bulan ini</div>
        <div class="month-cards">
            <div class="month-card active">
                <div class="month-header"><div class="month-label">Pendapatan</div><div>📈</div></div>
                <div class="month-value">Rp <?= number_format($summary['today_sales'],0,',','.'); ?></div>
            </div>
            <div class="month-card">
                <div class="month-header"><div class="month-label">Pengeluaran</div><div>📉</div></div>
                <div class="month-value">Rp <?= number_format($summary['today_expense'],0,',','.'); ?></div>
            </div>
        </div>

        <div class="transaksi-section">
            <div class="transaksi-header"><h6>📋 Transaksi Terbaru</h6><span class="transaksi-time" id="jumlahTransaksi"><?= count($transactions); ?> transaksi</span></div>

            <div id="transaksiList">
            <?php if (!empty($transactions)): ?>
                <?php foreach($transactions as $tx): $isNeg = ($tx['amount']<0); ?>
                    <div class="transaksi-item">
                        <div class="transaksi-icon <?= $isNeg? 'pengeluaran':'penjualan'; ?>"><?= $isNeg? '🛒':'💰'; ?></div>
                        <div class="transaksi-detail">
                            <div class="transaksi-title"><?= htmlspecialchars($tx['title']); ?></div>
                            <div class="transaksi-meta"><?= htmlspecialchars($tx['time']); ?> • <?= htmlspecialchars($tx['type']); ?></div>
                        </div>
                        <div class="transaksi-amount <?= $isNeg? 'minus':'plus'; ?>"><?= ($isNeg?'-Rp ':'+Rp ') . number_format(abs($tx['amount']),0,',','.'); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-muted">Belum ada transaksi.</div>
            <?php endif; ?>
            </div>

        </div>

        <div class="section-title">🔧 Tools Bisnis Lainnya</div>
        <div class="tools-grid">
            <div class="tool-box"><div class="tool-icon">🤖</div><div class="tool-title">AI Advisor</div><div class="tool-desc">Konsultasi strategis bisnis</div></div>
            <div class="tool-box"><div class="tool-icon">💡</div><div class="tool-title">Rekomendasi Informasi Bisnis</div><div class="tool-desc">Tips & tren UMKM terkini</div></div>
            <div class="tool-box"><div class="tool-icon">🛡️</div><div class="tool-title">Manajemen Risiko</div><div class="tool-desc">Kelola resiko operasional</div></div>
            <div class="tool-box"><div class="tool-icon">🎯</div><div class="tool-title">Subscription</div><div class="tool-desc">Dapatkan akses premium</div></div>
        </div>

    </div>

    <!-- MODAL CATAT PENJUALAN -->
    <div class="modal-overlay" id="modalPenjualan" onclick="if(event.target===this) closeModalPenjualan()">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">💰 Catat Penjualan</h3>
                <p class="modal-subtitle">Masukkan detail penjualan Anda</p>
            </div>
            <form id="formPenjualan" onsubmit="submitPenjualan(event)">
                <div class="modal-body">
                    <div class="modal-form-group">
                        <label class="modal-label" for="inputJumlah">Jumlah (Rp)</label>
                        <input 
                            type="text" 
                            id="inputJumlah" 
                            class="modal-input" 
                            placeholder="150.000"
                            oninput="formatRupiah(this)"
                            required
                        >
                    </div>
                    <div class="modal-form-group">
                        <label class="modal-label" for="inputKategori">Kategori</label>
                        <select id="inputKategori" class="modal-select" required>
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="Makanan & Minuman">Makanan & Minuman</option>
                            <option value="Produk">Produk</option>
                            <option value="Jasa">Jasa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="modal-form-group">
                        <label class="modal-label" for="inputDeskripsi">Deskripsi</label>
                        <textarea 
                            id="inputDeskripsi" 
                            class="modal-textarea" 
                            placeholder="Penjualan nasi ayam 10 porsi"
                            required
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModalPenjualan()">Batal</button>
                    <button type="submit" class="modal-btn modal-btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Data tracking
        let dataKeuangan = {
            penjualan: <?= $summary['today_sales']; ?>,
            pengeluaran: <?= $summary['today_expense']; ?>,
            jumlahTransaksiPenjualan: 1,
            jumlahTransaksiPengeluaran: 1,
            totalTransaksi: <?= count($transactions); ?>
        };

        // Format number to Rupiah
        function formatRupiahDisplay(number) {
            return 'Rp ' + parseInt(number).toLocaleString('id-ID');
        }

        // Update all displays
        function updateDisplay() {
            const labaBersih = dataKeuangan.penjualan - dataKeuangan.pengeluaran;
            const margin = dataKeuangan.penjualan > 0 ? ((labaBersih / dataKeuangan.penjualan) * 100).toFixed(1) : 0;

            console.log('Updating displays...');
            console.log('Penjualan:', dataKeuangan.penjualan);
            console.log('Pengeluaran:', dataKeuangan.pengeluaran);
            console.log('Laba Bersih:', labaBersih);

            // Update header
            const headerEl = document.getElementById('labaBersihHeader');
            if (headerEl) {
                headerEl.textContent = formatRupiahDisplay(labaBersih);
                console.log('✓ Header updated');
            } else {
                console.error('✗ Element labaBersihHeader not found');
            }

            // Update summary cards
            const penjualanEl = document.getElementById('totalPenjualan');
            if (penjualanEl) {
                penjualanEl.textContent = formatRupiahDisplay(dataKeuangan.penjualan);
                console.log('✓ Penjualan updated');
            } else {
                console.error('✗ Element totalPenjualan not found');
            }

            const pengeluaranEl = document.getElementById('totalPengeluaran');
            if (pengeluaranEl) {
                pengeluaranEl.textContent = formatRupiahDisplay(dataKeuangan.pengeluaran);
                console.log('✓ Pengeluaran updated');
            } else {
                console.error('✗ Element totalPengeluaran not found');
            }

            const labaBersihEl = document.getElementById('labaBersih');
            if (labaBersihEl) {
                labaBersihEl.textContent = formatRupiahDisplay(labaBersih);
                console.log('✓ Laba Bersih updated');
            } else {
                console.error('✗ Element labaBersih not found');
            }
            
            const jumlahPenjualanEl = document.getElementById('jumlahPenjualan');
            if (jumlahPenjualanEl) {
                jumlahPenjualanEl.textContent = dataKeuangan.jumlahTransaksiPenjualan + ' transaksi';
                console.log('✓ Jumlah Penjualan updated');
            }
            
            const jumlahPengeluaranEl = document.getElementById('jumlahPengeluaran');
            if (jumlahPengeluaranEl) {
                jumlahPengeluaranEl.textContent = dataKeuangan.jumlahTransaksiPengeluaran + ' transaksi';
                console.log('✓ Jumlah Pengeluaran updated');
            }
            
            const marginEl = document.getElementById('marginProfit');
            if (marginEl) {
                marginEl.textContent = 'Margin: ' + margin + '%';
                console.log('✓ Margin updated');
            }
            
            // Update total transaksi
            const totalTxEl = document.getElementById('jumlahTransaksi');
            if (totalTxEl) {
                totalTxEl.textContent = dataKeuangan.totalTransaksi + ' transaksi';
                console.log('✓ Total transaksi updated');
            }

            console.log('All displays updated successfully!');
        }

        // Add transaction to list
        function addTransactionToList(title, kategori, amount) {
            const transaksiList = document.getElementById('transaksiList');
            
            // Remove "belum ada transaksi" message if exists
            const emptyMsg = transaksiList.querySelector('.text-muted');
            if (emptyMsg) {
                emptyMsg.remove();
            }

            // Create new transaction element
            const newTx = document.createElement('div');
            newTx.className = 'transaksi-item';
            newTx.style.animation = 'slideIn 0.3s ease-out';
            newTx.innerHTML = `
                <div class="transaksi-icon penjualan">💰</div>
                <div class="transaksi-detail">
                    <div class="transaksi-title">${title}</div>
                    <div class="transaksi-meta">Baru saja • ${kategori}</div>
                </div>
                <div class="transaksi-amount plus">+Rp ${parseInt(amount).toLocaleString('id-ID')}</div>
            `;

            // Add to top of list
            transaksiList.insertBefore(newTx, transaksiList.firstChild);
        }

        // Open Modal
        function openModalPenjualan() {
            document.getElementById('modalPenjualan').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close Modal
        function closeModalPenjualan() {
            document.getElementById('modalPenjualan').classList.remove('active');
            document.body.style.overflow = '';
            document.getElementById('formPenjualan').reset();
        }

        // Format Rupiah
        function formatRupiah(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
            }
            input.value = value;
        }

        // Submit Form (UI only - no backend)
        function submitPenjualan(e) {
            e.preventDefault();
            
            const jumlahRaw = document.getElementById('inputJumlah').value.replace(/[^0-9]/g, '');
            const jumlah = parseInt(jumlahRaw);
            const kategori = document.getElementById('inputKategori').value;
            const deskripsi = document.getElementById('inputDeskripsi').value;
            
            // Debug log
            console.log('=== SUBMIT PENJUALAN ===');
            console.log('Jumlah:', jumlah);
            console.log('Kategori:', kategori);
            console.log('Deskripsi:', deskripsi);
            console.log('Data sebelum:', dataKeuangan);
            
            // Validasi input
            if (!jumlah || isNaN(jumlah) || jumlah <= 0) {
                alert('⚠️ Masukkan jumlah yang valid!');
                return;
            }
            
            if (!kategori) {
                alert('⚠️ Pilih kategori terlebih dahulu!');
                return;
            }
            
            if (!deskripsi) {
                alert('⚠️ Masukkan deskripsi!');
                return;
            }
            
            // Update data keuangan
            dataKeuangan.penjualan += jumlah;
            dataKeuangan.jumlahTransaksiPenjualan++;
            dataKeuangan.totalTransaksi++;
            
            console.log('Data setelah:', dataKeuangan);
            
            // Add to transaction list
            addTransactionToList(deskripsi, kategori, jumlah);
            
            // Update all displays
            updateDisplay();
            
            console.log('=== UPDATE SELESAI ===');
            
            // Show success notification
            showNotification('✅ Penjualan berhasil dicatat! Rp ' + parseInt(jumlah).toLocaleString('id-ID'), 'success');
            
            closeModalPenjualan();
        }

        // Show notification
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#2fb12f' : '#e74c3c'};
                color: white;
                padding: 16px 24px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                animation: slideInRight 0.3s ease-out;
                font-weight: 600;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalPenjualan();
            }
        });

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { opacity: 0; transform: translateX(-20px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes slideInRight {
                from { opacity: 0; transform: translateX(100px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes slideOutRight {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(100px); }
            }
        `;
        document.head.appendChild(style);
    </script>

</body>
</html>
