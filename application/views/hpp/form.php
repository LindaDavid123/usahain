<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Kalkulator HPP</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            :root{ --brand-a:#0d6efd; --brand-b:#38bdf8; --muted:#f1f6fb }
            body{font-family:Inter,system-ui,Arial,sans-serif;background:var(--muted);}
            .hero-card{max-width:920px;margin:28px auto;padding:28px;border-radius:12px;background:linear-gradient(180deg,#ffffff,rgba(255,255,255,0.9));box-shadow:0 10px 30px rgba(13,59,102,0.06)}
            .hpp-header{display:flex;align-items:center;gap:18px;margin-bottom:22px}
            .hpp-badge{width:56px;height:56px;border-radius:10px;background:linear-gradient(180deg,var(--brand-b),var(--brand-a));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;box-shadow:0 8px 20px rgba(13,59,102,0.08)}
            .hpp-title{font-size:20px;font-weight:700}
            .hpp-sub{color:#64748b}
            .form-control{border-radius:8px;padding:12px 14px}
            .calc-btn{background:linear-gradient(90deg,var(--brand-a),#0ea5e9);color:#fff;border-radius:12px;padding:12px 22px;border:none}
            .close-btn{background:#d1d5db;border-radius:12px;padding:12px 22px;border:none}
            .result-box{border-radius:10px;padding:14px;background:#fff;border:1px solid #e6f5ff;margin-top:12px}
            @media(max-width:720px){ .hpp-header{flex-direction:column;align-items:flex-start}.hpp-badge{width:48px;height:48px} }
        </style>
</head>
<body>
    <div class="container">
        <div class="hero-card">
            <div class="hpp-header">
                <div class="hpp-badge" aria-hidden="true">🧮</div>
                <div>
                    <div class="hpp-title">Kalkulator HPP</div>
                    <div class="hpp-sub">Hitung Harga Pokok Produksi dan tentukan harga jual</div>
                </div>
            </div>

            <form id="hppForm" onsubmit="return false;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bahan Baku (Rp)</label>
                        <input type="number" id="bahan" class="form-control" placeholder="50000" value="<?= isset($hpp) ? $hpp->bahan : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tenaga Kerja (Rp)</label>
                        <input type="number" id="tenaga" class="form-control" placeholder="25000" value="<?= isset($hpp) ? $hpp->tenaga_kerja : '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Overhead (Rp)</label>
                        <input type="number" id="overhead" class="form-control" placeholder="15000" value="">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Produk</label>
                        <input type="number" id="jumlah" class="form-control" placeholder="10" value="1" min="1">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Target Profit (%)</label>
                        <input type="number" id="profit" class="form-control" placeholder="30" value="30" min="0">
                    </div>

                    <div class="col-12 d-flex align-items-center gap-3 mt-2">
                        <button id="calculateBtn" class="calc-btn">📊 Hitung HPP</button>
                        <a href="<?= site_url('hpp'); ?>" class="close-btn">Tutup</a>
                        <div id="result" class="ms-auto text-end" style="min-width:220px"></div>
                    </div>

                    <div class="col-12">
                        <div id="resultBox" class="result-box" style="display:none">
                            <div><strong>Harga Jual / Unit</strong></div>
                            <div id="hargaOutput" style="font-size:20px;font-weight:700;color:#0d3b66">Rp 0</div>
                            <div id="detailOutput" style="color:#6b7280;font-size:13px;margin-top:6px"></div>
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
            const hargaJual = biayaPerUnit * (1 + profit/100);

            document.getElementById('hargaOutput').textContent = formatRupiah(Math.round(hargaJual));
            document.getElementById('detailOutput').textContent = 'Total Biaya: '+formatRupiah(totalBiaya)+" • Biaya/Unit: "+formatRupiah(Math.round(biayaPerUnit))+' • Profit: '+profit+'%';
            document.getElementById('resultBox').style.display = 'block';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
