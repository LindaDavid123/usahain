<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($advisor) ? 'Edit Konsultasi' : 'AI Business Advisor'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#f1f8fb;--card:#FFFFFF;--accent1:#0b6ea8;--accent2:#27b0e3;--cta:#18A0FB;--success:#10b981;--warning:#f59e0b;--info:#3b82f6;--light-gray:#f8fafc;--border:#e2e8f0}
        *{box-sizing:border-box}
        body{margin:0;background:linear-gradient(135deg, #ecf9ff 0%, #dff4fb 50%, #d0ecf8 100%);font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto;color:#0f1724;padding:20px;min-height:100vh}
        .container{max-width:900px;margin:0 auto}
        .card{background:var(--card);border-radius:24px;padding:40px 36px;box-shadow:0 20px 60px rgba(2,6,23,0.12);backdrop-filter:blur(10px)}

        .header{text-align:center;margin-bottom:32px;padding-bottom:20px;border-bottom:2px solid var(--light-gray)}
        .header-icon{font-size:56px;margin-bottom:16px;animation:float 3s ease-in-out infinite;display:inline-block}
        .heading{font-size:24px;font-weight:700;margin-bottom:8px;color:#0f1724}
        .sub{font-size:15px;color:#64748b;line-height:1.6}

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .form-wrapper{display:grid;grid-template-columns:repeat(2, 1fr);gap:18px}
        
        .form-section{background:var(--light-gray);border-radius:16px;padding:28px;border:2px solid var(--border);transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);position:relative}
        .form-section::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg, var(--accent1), var(--accent2));border-radius:16px 16px 0 0;opacity:0;transition:opacity 0.3s ease}
        .form-section:focus-within::before{opacity:1}
        .form-section:hover{border-color:var(--accent2);background:#ffffff;box-shadow:0 8px 24px rgba(0,136,194,0.08)}

        .form-group{margin:0;position:relative}
        .label-wrapper{display:flex;align-items:flex-start;gap:10px;margin-bottom:10px}
        label{display:block;font-size:13px;color:#1e293b;font-weight:700;letter-spacing:0.2px;line-height:1.3}
        .label-desc{font-size:11px;color:#94a3b8;font-weight:400;margin-top:3px;display:block;line-height:1.3}
        
        select{width:100%;padding:12px 14px;border-radius:12px;border:2px solid var(--border);background:#ffffff;font-size:13px;font-family:Inter;cursor:pointer;appearance:none;padding-right:36px;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;background-size:18px;background-color:#ffffff;transition:all 0.3s ease;font-weight:500;color:#0f1724}
        select:hover{border-color:var(--accent2);box-shadow:0 4px 12px rgba(0,136,194,0.1)}
        select:focus{outline:none;border-color:var(--accent2);box-shadow:0 0 0 4px rgba(0,136,194,0.15);background-color:#ffffff}
        select option{padding:12px;background:#ffffff;color:#0f1724}
        select.hidden{display:none}

        .input-text{width:100%;padding:12px 14px;border-radius:12px;border:2px solid var(--border);background:#ffffff;font-size:13px;font-family:Inter;transition:all 0.3s ease;color:#0f1724;font-weight:500}
        .input-text::placeholder{color:#94a3b8;font-weight:400}
        .input-text:hover{border-color:var(--accent2);box-shadow:0 4px 12px rgba(0,136,194,0.1)}
        .input-text:focus{outline:none;border-color:var(--accent2);box-shadow:0 0 0 4px rgba(0,136,194,0.15);background-color:#fafbfc}
        .input-wrapper{display:none}
        .input-wrapper.show{display:block}

        .radio-group, .checkbox-group{display:flex;flex-direction:column;gap:10px;margin-top:10px}
        .radio-group.compact{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px}
        .radio-group.compact .radio-item{padding:9px 10px;gap:8px}
        .radio-group.compact .radio-label{font-size:12px}
        .radio-item, .checkbox-item{display:flex;align-items:center;gap:10px;padding:11px 12px;border-radius:10px;border:2px solid var(--border);background:#ffffff;cursor:pointer;transition:all 0.3s ease}
        .radio-item:hover, .checkbox-item:hover{border-color:var(--accent2);background:#f0f9fc;transform:translateX(3px)}
        .radio-input, .checkbox-input{width:18px;height:18px;cursor:pointer;accent-color:var(--accent2);flex-shrink:0;margin-top:0px}
        .radio-label, .checkbox-label{font-size:13px;color:#334155;font-weight:500;cursor:pointer;flex:1;margin:0;line-height:1.3}
        .radio-input:checked ~ .radio-label, .checkbox-input:checked ~ .checkbox-label{color:var(--accent1);font-weight:600}

        .summary-section{background:linear-gradient(135deg, #ecf9ff 0%, #e8f4f8 100%);border-radius:16px;padding:20px;margin-bottom:0;border:2px solid #b3dff5;margin-top:4px;grid-column:1 / -1}
        .summary-title{font-size:14px;font-weight:700;color:#0f1724;margin-bottom:12px;display:flex;align-items:center;gap:6px}
        .summary-content{background:#ffffff;border-radius:12px;padding:14px;font-size:12px;line-height:1.6;color:#475569;box-shadow:0 2px 8px rgba(0,0,0,0.04)}
        .summary-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);align-items:center}
        .summary-row:last-child{border-bottom:none}
        .summary-label{font-weight:600;color:#0f1724;font-size:12px}
        .summary-value{color:#64748b;font-size:12px;text-align:right;max-width:45%;word-wrap:break-word}

        .btn-group{margin-top:24px;display:flex;gap:12px;grid-column:1 / -1}
        .btn{padding:14px 24px;border:none;border-radius:12px;cursor:pointer;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:14px;gap:8px;flex:1;transition:all 0.3s ease;box-shadow:0 4px 15px rgba(0,0,0,0.1);letter-spacing:0.2px}
        .btn:active{transform:scale(0.97)}
        .btn:disabled{opacity:0.6;cursor:not-allowed}
        .btn-primary{background:linear-gradient(135deg, var(--accent1), var(--accent2));color:white;font-weight:700}
        .btn-primary:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(0,88,194,0.3)}
        .btn-secondary{background:#f1f5f9;color:#334155;border:2px solid var(--border);font-weight:600}
        .btn-secondary:hover{background:#e8eef7;border-color:var(--accent2);color:var(--accent2);transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,136,194,0.15)}

        .error{color:#dc2626;font-size:12px;margin-top:10px;display:flex;align-items:center;gap:6px;animation:slideIn 0.3s ease;background:#fef2f2;padding:10px 12px;border-radius:8px;border-left:3px solid #dc2626}
        .error::before{content:'⚠'}

        @keyframes slideIn {
            from { opacity:0; transform: translateY(-8px); }
            to { opacity:1; transform: translateY(0); }
        }

        @media (max-width:768px){
            .container{max-width:100%}
            .card{padding:28px 20px}
            .header{margin-bottom:24px;padding-bottom:16px}
            .header-icon{font-size:48px}
            .heading{font-size:22px;margin-bottom:6px}
            .sub{font-size:14px}
            .form-wrapper{grid-template-columns:1fr;gap:14px}
            .form-section{padding:16px}
            .form-section.full-width{grid-column:1}
            .btn-group{gap:10px;grid-column:1}
            .btn{padding:12px 20px;font-size:13px}
            select{padding:10px 12px;padding-right:32px;background-size:16px;font-size:12px}
            .radio-group, .checkbox-group{gap:8px;margin-top:8px}
            .radio-item, .checkbox-item{padding:10px 10px;gap:8px}
            .summary-section{padding:16px}
            .summary-title{font-size:13px;margin-bottom:10px}
            .summary-content{padding:12px;font-size:11px}
            .summary-row{padding:6px 0}
            .summary-value{max-width:50%}
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="header">
                <div class="header-icon">🤖</div>
                <div class="heading">AI Business Advisor</div>
                <div class="sub">Dapatkan rekomendasi bisnis yang tepat untuk Anda</div>
            </div>

            <form method="post" action="<?= site_url('advisor/create'); ?>">
                <div class="form-wrapper">
                    <!-- Row 1: Modal & Minat -->
                    <div class="form-section">
                        <div class="form-group">
                            <label for="modal">Modal <span style="color:#ef4444">*</span></label>
                            <div class="label-desc">Range modal</div>
                            <select id="modal" name="modal" required onchange="updateSummary(); toggleModalInput()">
                                <option value="">Pilih</option>
                                <option value="1000000" <?= (isset($advisor) && $advisor->modal == 1000000) ? 'selected' : ''; ?>>< 1 Juta</option>
                                <option value="5000000" <?= (isset($advisor) && $advisor->modal == 5000000) ? 'selected' : ''; ?>>1 - 5 Juta</option>
                                <option value="10000000" <?= (isset($advisor) && $advisor->modal == 10000000) ? 'selected' : ''; ?>>5 - 10 Juta</option>
                                <option value="50000000" <?= (isset($advisor) && $advisor->modal == 50000000) ? 'selected' : ''; ?>>10 - 50 Juta</option>
                                <option value="100000000" <?= (isset($advisor) && $advisor->modal == 100000000) ? 'selected' : ''; ?>>50 - 100 Juta</option>
                                <option value="500000000" <?= (isset($advisor) && $advisor->modal == 500000000) ? 'selected' : ''; ?>>100 - 500 Juta</option>
                                <option value="1000000000" <?= (isset($advisor) && $advisor->modal == 1000000000) ? 'selected' : ''; ?>>500 Juta+</option>
                                <option value="lainnya" <?= (isset($advisor) && $advisor->modal == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                            <div class="input-wrapper" id="modalInput">
                                <input type="text" class="input-text" id="modalCustom" name="modal_custom" placeholder="Ketik range modal Anda" onchange="updateSummary()" onkeyup="updateSummary()">
                            </div>
                            <?= form_error('modal', '<div class="error">', '</div>'); ?>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-group">
                            <label for="minat">Minat <span style="color:#ef4444">*</span></label>
                            <div class="label-desc">Bidang keahlian</div>
                            <select id="minat" name="minat" required onchange="updateSummary(); toggleMinatInput()">
                                <option value="">Pilih</option>
                                <option value="kuliner" <?= (isset($advisor) && $advisor->minat == 'kuliner') ? 'selected' : ''; ?>>Kuliner</option>
                                <option value="fashion" <?= (isset($advisor) && $advisor->minat == 'fashion') ? 'selected' : ''; ?>>Fashion</option>
                                <option value="teknologi" <?= (isset($advisor) && $advisor->minat == 'teknologi') ? 'selected' : ''; ?>>Teknologi</option>
                                <option value="jasa" <?= (isset($advisor) && $advisor->minat == 'jasa') ? 'selected' : ''; ?>>Jasa</option>
                                <option value="pertanian" <?= (isset($advisor) && $advisor->minat == 'pertanian') ? 'selected' : ''; ?>>Pertanian</option>
                                <option value="pendidikan" <?= (isset($advisor) && $advisor->minat == 'pendidikan') ? 'selected' : ''; ?>>Pendidikan</option>
                                <option value="pariwisata" <?= (isset($advisor) && $advisor->minat == 'pariwisata') ? 'selected' : ''; ?>>Pariwisata</option>
                                <option value="lainnya" <?= (isset($advisor) && $advisor->minat == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                            <div class="input-wrapper" id="minatInput">
                                <input type="text" class="input-text" id="minatCustom" name="minat_custom" placeholder="Ketik bidang minat Anda" onchange="updateSummary()" onkeyup="updateSummary()">
                            </div>
                            <?= form_error('minat', '<div class="error">', '</div>'); ?>
                        </div>
                    </div>

                    <!-- Row 2: Lokasi & Tujuan -->
                    <div class="form-section">
                        <div class="form-group">
                            <label for="lokasi">Lokasi <span style="color:#ef4444">*</span></label>
                            <div class="label-desc">Pilih lokasi</div>
                            <select id="lokasi" name="lokasi" required onchange="updateSummary(); toggleLokasiInput()">
                                <option value="">Pilih</option>
                                <option value="jakarta" <?= (isset($advisor) && $advisor->lokasi == 'jakarta') ? 'selected' : ''; ?>>Jakarta</option>
                                <option value="bandung" <?= (isset($advisor) && $advisor->lokasi == 'bandung') ? 'selected' : ''; ?>>Bandung</option>
                                <option value="surabaya" <?= (isset($advisor) && $advisor->lokasi == 'surabaya') ? 'selected' : ''; ?>>Surabaya</option>
                                <option value="medan" <?= (isset($advisor) && $advisor->lokasi == 'medan') ? 'selected' : ''; ?>>Medan</option>
                                <option value="yogyakarta" <?= (isset($advisor) && $advisor->lokasi == 'yogyakarta') ? 'selected' : ''; ?>>Yogyakarta</option>
                                <option value="semarang" <?= (isset($advisor) && $advisor->lokasi == 'semarang') ? 'selected' : ''; ?>>Semarang</option>
                                <option value="makassar" <?= (isset($advisor) && $advisor->lokasi == 'makassar') ? 'selected' : ''; ?>>Makassar</option>
                                <option value="lainnya" <?= (isset($advisor) && $advisor->lokasi == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                            <div class="input-wrapper" id="lokasiInput">
                                <input type="text" class="input-text" id="lokasiCustom" name="lokasi_custom" placeholder="Ketik lokasi Anda" onchange="updateSummary()" onkeyup="updateSummary()">
                            </div>
                            <?= form_error('lokasi', '<div class="error">', '</div>'); ?>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-group">
                            <label for="tujuan">Tujuan <span style="color:#ef4444">*</span></label>
                            <div class="label-desc">Tujuan bisnis</div>
                            <select id="tujuan" name="tujuan" required onchange="updateSummary(); toggleTujuanInput()">
                                <option value="">Pilih</option>
                                <option value="ide" <?= (isset($advisor) && $advisor->tujuan == 'ide') ? 'selected' : ''; ?>>Cari ide bisnis</option>
                                <option value="mengembangkan" <?= (isset($advisor) && $advisor->tujuan == 'mengembangkan') ? 'selected' : ''; ?>>Kembangkan bisnis</option>
                                <option value="sampingan" <?= (isset($advisor) && $advisor->tujuan == 'sampingan') ? 'selected' : ''; ?>>Bisnis sampingan</option>
                                <option value="fulltime" <?= (isset($advisor) && $advisor->tujuan == 'fulltime') ? 'selected' : ''; ?>>Full-time</option>
                                <option value="lainnya" <?= (isset($advisor) && $advisor->tujuan == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                            <div class="input-wrapper" id="tujuanInput">
                                <input type="text" class="input-text" id="tujuanCustom" name="tujuan_custom" placeholder="Ketik tujuan bisnis Anda" onchange="updateSummary()" onkeyup="updateSummary()">
                            </div>
                            <?= form_error('tujuan', '<div class="error">', '</div>'); ?>
                        </div>
                    </div>

                    <!-- Summary Section (Full Width) -->
                    <div class="summary-section full-width">
                        <div class="summary-title">📋 Ringkasan Data Anda</div>
                        <div class="summary-content">
                            <div class="summary-row">
                                <span class="summary-label">Modal:</span>
                                <span class="summary-value">Menunggu input</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Minat:</span>
                                <span class="summary-value">Menunggu input</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Lokasi:</span>
                                <span class="summary-value">Menunggu input</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Tujuan:</span>
                                <span class="summary-value">Menunggu input</span>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <span>📊</span>
                        Analisis & Rekomendasi
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= site_url('dashboard'); ?>'">Tutup</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Data mapping untuk ringkasan
        const optionLabels = {
            modal: {
                '1000000': '< 1 Juta',
                '5000000': '1 - 5 Juta',
                '10000000': '5 - 10 Juta',
                '50000000': '10 - 50 Juta',
                '100000000': '50 - 100 Juta',
                '500000000': '100 - 500 Juta',
                '1000000000': '500 Juta+',
                'lainnya': ''
            },
            minat: {
                'kuliner': 'Kuliner',
                'fashion': 'Fashion',
                'teknologi': 'Teknologi',
                'jasa': 'Jasa',
                'pertanian': 'Pertanian',
                'pendidikan': 'Pendidikan',
                'pariwisata': 'Pariwisata',
                'lainnya': ''
            },
            lokasi: {
                'jakarta': 'Jakarta',
                'bandung': 'Bandung',
                'surabaya': 'Surabaya',
                'medan': 'Medan',
                'yogyakarta': 'Yogyakarta',
                'semarang': 'Semarang',
                'makassar': 'Makassar',
                'lainnya': ''
            },
            tujuan: {
                'ide': 'Cari ide bisnis',
                'mengembangkan': 'Kembangkan bisnis',
                'sampingan': 'Bisnis sampingan',
                'fulltime': 'Full-time',
                'lainnya': ''
            }
        };

        function toggleModalInput() {
            const select = document.getElementById('modal');
            const input = document.getElementById('modalInput');
            const customInput = document.getElementById('modalCustom');
            const isLainnya = select.value === 'lainnya';
            input.classList.toggle('show', isLainnya);
            select.classList.toggle('hidden', isLainnya);
            if (isLainnya) {
                customInput.value = '';
                setTimeout(() => customInput.focus(), 100);
            }
        }

        function toggleMinatInput() {
            const select = document.getElementById('minat');
            const input = document.getElementById('minatInput');
            const customInput = document.getElementById('minatCustom');
            const isLainnya = select.value === 'lainnya';
            input.classList.toggle('show', isLainnya);
            select.classList.toggle('hidden', isLainnya);
            if (isLainnya) {
                customInput.value = '';
                setTimeout(() => customInput.focus(), 100);
            }
        }

        function toggleLokasiInput() {
            const select = document.getElementById('lokasi');
            const input = document.getElementById('lokasiInput');
            const customInput = document.getElementById('lokasiCustom');
            const isLainnya = select.value === 'lainnya';
            input.classList.toggle('show', isLainnya);
            select.classList.toggle('hidden', isLainnya);
            if (isLainnya) {
                customInput.value = '';
                setTimeout(() => customInput.focus(), 100);
            }
        }

        function toggleTujuanInput() {
            const select = document.getElementById('tujuan');
            const input = document.getElementById('tujuanInput');
            const customInput = document.getElementById('tujuanCustom');
            const isLainnya = select.value === 'lainnya';
            input.classList.toggle('show', isLainnya);
            select.classList.toggle('hidden', isLainnya);
            if (isLainnya) {
                customInput.value = '';
                setTimeout(() => customInput.focus(), 100);
            }
        }

        function updateSummary() {
            // Get selected values
            const modal = document.getElementById('modal').value;
            const minat = document.getElementById('minat').value;
            const lokasi = document.getElementById('lokasi').value;
            const tujuan = document.getElementById('tujuan').value;

            // Get custom input values if "Lainnya" selected
            const modalValue = modal === 'lainnya' ? document.getElementById('modalCustom').value : optionLabels.modal[modal];
            const minatValue = minat === 'lainnya' ? document.getElementById('minatCustom').value : optionLabels.minat[minat];
            const lokasiValue = lokasi === 'lainnya' ? document.getElementById('lokasiCustom').value : optionLabels.lokasi[lokasi];
            const tujuanValue = tujuan === 'lainnya' ? document.getElementById('tujuanCustom').value : optionLabels.tujuan[tujuan];

            // Update summary rows
            document.querySelectorAll('.summary-row')[0].innerHTML = `<span class="summary-label">Modal:</span><span class="summary-value">${modalValue || 'Menunggu input'}</span>`;
            document.querySelectorAll('.summary-row')[1].innerHTML = `<span class="summary-label">Minat:</span><span class="summary-value">${minatValue || 'Menunggu input'}</span>`;
            document.querySelectorAll('.summary-row')[2].innerHTML = `<span class="summary-label">Lokasi:</span><span class="summary-value">${lokasiValue || 'Menunggu input'}</span>`;
            document.querySelectorAll('.summary-row')[3].innerHTML = `<span class="summary-label">Tujuan:</span><span class="summary-value">${tujuanValue || 'Menunggu input'}</span>`;
        }

        // Validate form before submission
        function validateForm() {
            const modal = document.getElementById('modal').value;
            const minat = document.getElementById('minat').value;
            const lokasi = document.getElementById('lokasi').value;
            const tujuan = document.getElementById('tujuan').value;

            if (!modal || !minat || !lokasi || !tujuan) {
                alert('❌ Mohon lengkapi semua field yang wajib diisi');
                return false;
            }

            // Validate custom inputs if "Lainnya" selected
            if (modal === 'lainnya' && !document.getElementById('modalCustom').value.trim()) {
                alert('❌ Mohon masukkan range modal Anda');
                document.getElementById('modalCustom').focus();
                return false;
            }
            if (minat === 'lainnya' && !document.getElementById('minatCustom').value.trim()) {
                alert('❌ Mohon masukkan bidang minat Anda');
                document.getElementById('minatCustom').focus();
                return false;
            }
            if (lokasi === 'lainnya' && !document.getElementById('lokasiCustom').value.trim()) {
                alert('❌ Mohon masukkan lokasi Anda');
                document.getElementById('lokasiCustom').focus();
                return false;
            }
            if (tujuan === 'lainnya' && !document.getElementById('tujuanCustom').value.trim()) {
                alert('❌ Mohon masukkan tujuan bisnis Anda');
                document.getElementById('tujuanCustom').focus();
                return false;
            }

            return true;
        }

        // Attach validation to form submit
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                    }
                });
            }

            // Add event listeners to custom inputs for real-time validation feedback
            const customInputs = [
                document.getElementById('modalCustom'),
                document.getElementById('minatCustom'),
                document.getElementById('lokasiCustom'),
                document.getElementById('tujuanCustom')
            ];

            customInputs.forEach(input => {
                if (input) {
                    input.addEventListener('input', function() {
                        updateSummary();
                    });
                }
            });

            // Initialize visibility and summary
            toggleModalInput();
            toggleMinatInput();
            toggleLokasiInput();
            toggleTujuanInput();
            updateSummary();
        });
    </script>
</body>
</html>
