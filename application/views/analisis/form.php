<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($produk) ? 'Edit Analisis' : 'Tambah Analisis'; ?> - Usahain</title>
    <style>
        :root {
            --primary: #1C6494;
            --primary-dark: #144d73;
            --success: #2ecc71;
            --danger: #e74c3c;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            color: var(--primary);
            font-size: 24px;
            font-weight: 600;
        }

        .navbar a {
            color: var(--primary);
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .navbar a:hover {
            background: var(--primary);
            color: white;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .form-header-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .form-header h2 {
            color: var(--primary-dark);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--text-light);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: var(--text);
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        label span.required {
            color: var(--danger);
            margin-left: 3px;
        }

        input, textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-light);
            transition: all 0.3s ease;
            color: var(--text);
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(28, 100, 148, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 140px;
            line-height: 1.6;
        }

        .input-group {
            position: relative;
        }

        .input-prefix {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-weight: 600;
        }

        .input-group input {
            padding-left: 45px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 35px;
        }

        .btn {
            flex: 1;
            padding: 16px 32px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(28, 100, 148, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--text);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg-light);
            transform: translateY(-2px);
        }

        .validation-errors {
            background: linear-gradient(135deg, #ffe3e3 0%, #ffcdd2 100%);
            color: #b71c1c;
            padding: 18px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            border-left: 5px solid var(--danger);
            animation: slideIn 0.3s ease;
        }

        .success-message {
            background: linear-gradient(135deg, #e3ffe3 0%, #c8e6c9 100%);
            color: #1b5e20;
            padding: 18px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            border-left: 5px solid var(--success);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-tip {
            background: var(--bg-light);
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
            margin-bottom: 25px;
            font-size: 13px;
            color: var(--text-light);
            display: flex;
            gap: 10px;
            align-items: start;
        }

        .form-tip::before {
            content: '💡';
            font-size: 18px;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .container {
                padding: 25px 20px;
            }

            .form-header h2 {
                font-size: 22px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2><?php echo isset($produk) ? '✏️ Edit Analisis' : '➕ Tambah Analisis'; ?></h2>
        <a href="<?php echo site_url('analisis'); ?>">← Kembali ke Daftar</a>
    </div>

    <div class="container">
        <div class="form-header">
            <div class="form-header-icon"><?php echo isset($produk) ? '📝' : '🆕'; ?></div>
            <h2><?php echo isset($produk) ? 'Edit Analisis Produk' : 'Tambah Analisis Produk Baru'; ?></h2>
            <p><?php echo isset($produk) ? 'Perbarui data analisis produk Anda' : 'Isi form di bawah untuk menambahkan analisis produk'; ?></p>
        </div>

        <?php if (validation_errors()): ?>
            <div class="validation-errors">
                <strong>⚠️ Terjadi Kesalahan:</strong><br>
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <div class="success-message">
                <strong>✓ Berhasil!</strong><br>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <div class="form-tip">
            <div>Pastikan data yang Anda masukkan akurat untuk mendapatkan analisis yang tepat. Data penjualan dan biaya produksi akan digunakan untuk menghitung margin keuntungan.</div>
        </div>

        <form method="post" autocomplete="off">
            <div class="form-group">
                <label for="nama_produk">
                    Nama Produk
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="nama_produk" 
                    name="nama_produk" 
                    placeholder="Contoh: Nasi Goreng Special" 
                    value="<?php echo isset($produk) ? htmlspecialchars($produk->nama_produk) : set_value('nama_produk'); ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="penjualan">
                    Penjualan (Rp)
                    <span class="required">*</span>
                </label>
                <div class="input-group">
                    <span class="input-prefix">Rp</span>
                    <input 
                        type="number" 
                        id="penjualan" 
                        name="penjualan" 
                        step="1" 
                        min="0" 
                        placeholder="50000" 
                        value="<?php echo isset($produk) ? $produk->penjualan : set_value('penjualan'); ?>" 
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="biaya_produksi">
                    Biaya Produksi (Rp)
                    <span class="required">*</span>
                </label>
                <div class="input-group">
                    <span class="input-prefix">Rp</span>
                    <input 
                        type="number" 
                        id="biaya_produksi" 
                        name="biaya_produksi" 
                        step="1" 
                        min="0" 
                        placeholder="25000" 
                        value="<?php echo isset($produk) ? $produk->biaya_produksi : set_value('biaya_produksi'); ?>" 
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="analisis">
                    Analisis Produk
                    <span class="required">*</span>
                </label>
                <textarea 
                    id="analisis" 
                    name="analisis" 
                    placeholder="Tulis analisis lengkap tentang produk ini, seperti keunggulan, kelemahan, peluang pasar, dan strategi pengembangan..." 
                    required
                ><?php echo isset($produk) ? htmlspecialchars($produk->analisis) : set_value('analisis'); ?></textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">