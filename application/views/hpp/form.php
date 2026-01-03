<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Kalkulator HPP</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            :root{ --brand-a:#1C6494; --brand-b:#38bdf8; --muted:#f1f6fb }
            body{font-family:Inter,system-ui,Arial,sans-serif;background:#f0f4f8;margin:0;padding:20px 0;}
            .hero-card{max-width:700px;margin:28px auto;padding:32px;border-radius:16px;background:#ffffff;box-shadow:0 4px 12px rgba(0,0,0,0.08)}
            .hpp-header{display:flex;align-items:center;gap:16px;margin-bottom:24px}
            .hpp-icon{width:54px;height:54px;border-radius:12px;background:linear-gradient(135deg,#60a5fa,var(--brand-a));display:flex;align-items:center;justify-content:center;font-size:26px;box-shadow:0 4px 12px rgba(28,100,148,0.2)}
            .hpp-title-wrap h2{font-size:22px;font-weight:700;color:#1e293b;margin:0 0 4px 0}
            .hpp-title-wrap p{color:#64748b;margin:0;font-size:14px}
            .info-box{background:#eff6ff;border-left:4px solid #3b82f6;padding:14px 16px;border-radius:8px;margin-bottom:24px}
            .info-box p{margin:0;color:#1e40af;font-size:13px;line-height:1.5}
            .form-label{font-weight:600;color:#334155;margin-bottom:8px;font-size:14px}
            .form-control{border-radius:8px;padding:11px 14px;border:1px solid #d1d5db;transition:all 0.2s}
            .form-control:focus{border-color:var(--brand-a);box-shadow:0 0 0 3px rgba(28,100,148,0.1);outline:none}
            .btn-calculate{background:linear-gradient(90deg,var(--brand-a),#0ea5e9);color:#fff;border-radius:10px;padding:12px 24px;border:none;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:transform 0.2s}
            .btn-calculate:hover{transform:translateY(-2px)}
            .btn-back{background:#e5e7eb;color:#374151;border-radius:10px;padding:12px 20px;border:none;font-weight:600;transition:all 0.2s}
            .btn-back:hover{background:#d1d5db}
            .result-card{background:#fff;border:2px solid #e0f2fe;border-radius:12px;padding:20px;margin-top:24px;box-shadow:0 2px 8px rgba(0,0,0,0.04)}
            .result-main{text-align:center;margin-bottom:20px}
            .result-label{color:#64748b;font-size:13px;margin-bottom:8px;display:flex;align-items:center;justify-content:center;gap:6px}
            .result-value{font-size:36px;font-weight:700;color:var(--brand-a);margin:0}
            .result-details{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:16px;padding-top:16px;border-top:1px solid #e5e7eb}
            .result-item h6{font-size:12px;color:#64748b;margin:0 0 6px 0;font-weight:500}
            .result-item p{font-size:15px;font-weight:600;color:#1e293b;margin:0}
            @media(max-width:720px){ .hpp-header{flex-direction:column;align-items:flex-start}.result-details{grid-template-columns:1fr} }
        </style>
</head>
<body>
    <div class="container">
        <div class="hero-card">
            <div class="hpp-header">
                <div class="hpp-icon">🧮</div>
                <div class="hpp-title-wrap">
                    <h2>Kalkulator HPP</h2>
                    <p>Hitung Harga Pokok Produksi dan tentukan harga jual yang menguntungkan</p>
                </div>
            </div>

            <div class="info-box">
                <p>💡 <strong>Tips:</strong> HPP (Harga Pokok Produksi) adalah total biaya yang dikeluarkan untuk memproduksi satu produk. Gunakan kalkulator ini untuk menentukan harga jual yang tepat dengan margin keuntungan yang Anda inginkan.</p>
            </div>

            <form id="hppForm" onsubmit="return false;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bahan Baku (Rp)</label>
                        <input type="number" id="bahan" class="form-control" placeholder="300000" value="<?= isset($hpp) ? $hpp->bahan : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tenaga Kerja (Rp)</label>
                        <input type="number" id="tenaga" class="form-control" placeholder="500000" value="<?= isset($hpp) ? $hpp->tenaga_kerja : '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Overhead (Rp)</label>
                        <input type="number" id="overhead" class="form-control" placeholder="15000" value="">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Produk</label>
                        <input type="number" id="jumlah" class="form-control" placeholder="1" value="1" min="1">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Target Profit (%)</label>
                        <input type="number" id="profit" class="form-control" placeholder="30" value="30" min="0">
                    </div>

                    <div class="col-12 d-flex align-items-center gap-3 mt-4">
                        <button id="calculateBtn" class="btn-calculate">🧮 Hitung HPP</button>
                        <a href="<?= site_url('hpp'); ?>" class="btn-back">← Kembali</a>
                    </div>

                    <div class="col-12">
                        <div id="resultBox" class="result-card" style="display:none">
                            <div class="result-main">
                                <div class="result-label">
                                    💰 Harga Jual yang Disarankan
                                </div>
                                <h1 id="hargaOutput" class="result-value">Rp 0</h1>
                            </div>
                            <div class="result-details">
                                <div class="result-item">
                                    <h6>Total Biaya Produksi</h6>
                                    <p id="totalBiayaOutput">Rp 0</p>
                                </div>
                                <div class="result-item">
                                    <h6>Biaya per Unit</h6>
                                    <p id="biayaUnitOutput">Rp 0</p>
                                </div>
                                <div class="result-item">
                                    <h6>Margin Profit</h6>
                                    <p id="profitOutput">0%</p>
                                </div>
                                <div class="result-item">
                                    <h6>Jumlah Produk</h6>
                                    <p id="jumlahOutput">0 unit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function formatRupiah(n){ return 'Rp '+Number(n).toLocaleString('id-ID'); }
        document.getElementById('calculateBtn').addEventListener('click', function(e){
            e.preventDefault();
            const bahan = parseFloat(document.getElementById('bahan').value) || 0;
            const tenaga = parseFloat(document.getElementById('tenaga').value) || 0;
            const overhead = parseFloat(document.getElementById('overhead').value) || 0;
            const jumlah = parseFloat(document.getElementById('jumlah').value) || 1;
            const profit = parseFloat(document.getElementById('profit').value) || 0;

            const totalBiaya = bahan + tenaga + overhead;
            const biayaPerUnit = totalBiaya / (jumlah || 1);
            const marginProfit = biayaPerUnit * (profit/100);
            const hargaJual = biayaPerUnit + marginProfit;

            document.getElementById('hargaOutput').textContent = formatRupiah(Math.round(hargaJual));
            document.getElementById('totalBiayaOutput').textContent = formatRupiah(totalBiaya);
            document.getElementById('biayaUnitOutput').textContent = formatRupiah(Math.round(biayaPerUnit));
            document.getElementById('profitOutput').textContent = profit+'% ('+formatRupiah(Math.round(marginProfit))+')';
            document.getElementById('jumlahOutput').textContent = jumlah + ' unit';
            document.getElementById('resultBox').style.display = 'block';
            
            // Smooth scroll to result
            document.getElementById('resultBox').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
