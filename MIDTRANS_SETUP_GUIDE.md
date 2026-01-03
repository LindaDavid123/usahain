# 🔐 Setup Midtrans Payment Gateway - Panduan Lengkap

## 📋 Daftar Isi
1. [Registrasi Akun Midtrans](#1-registrasi-akun-midtrans)
2. [Dapatkan API Keys](#2-dapatkan-api-keys)
3. [Konfigurasi di CodeIgniter](#3-konfigurasi-di-codeigniter)
4. [Testing dengan Sandbox](#4-testing-dengan-sandbox)
5. [Go Live (Production)](#5-go-live-production)

---

## 1️⃣ Registrasi Akun Midtrans

### Langkah-langkah:

1. **Buka Website Midtrans**
   ```
   https://midtrans.com/
   ```

2. **Klik "Daftar Sekarang" atau "Sign Up"**

3. **Pilih Tipe Akun:**
   - **Sandbox** (untuk testing) - GRATIS
   - **Production** (untuk bisnis nyata)

4. **Isi Form Registrasi:**
   - Email bisnis Anda
   - Password
   - Nama bisnis
   - Nomor telepon

5. **Verifikasi Email**
   - Cek inbox email Anda
   - Klik link verifikasi

---

## 2️⃣ Dapatkan API Keys

### SANDBOX (untuk Testing):

1. Login ke dashboard sandbox:
   ```
   https://dashboard.sandbox.midtrans.com/
   ```

2. Masuk ke **Settings** > **Access Keys**

3. Copy credential berikut:
   ```
   ✅ Server Key: SB-Mid-server-xxxxxxxxxxxxxx
   ✅ Client Key: SB-Mid-client-xxxxxxxxxxxxxx
   ✅ Merchant ID: Gxxxxxxxx
   ```

### PRODUCTION (untuk Live):

1. Login ke dashboard production:
   ```
   https://dashboard.midtrans.com/
   ```

2. Lengkapi data bisnis & dokumen (KTP, NPWP, dll)

3. Tunggu approval (biasanya 1-3 hari kerja)

4. Setelah approved, get Production Keys di **Settings** > **Access Keys**

---

## 3️⃣ Konfigurasi di CodeIgniter

### Step 1: Edit File Konfigurasi

Buka file: `application/config/midtrans.php`

```php
<?php
// Set FALSE untuk Sandbox (testing)
// Set TRUE untuk Production (live)
$config['midtrans_is_production'] = false;

// Paste Server Key dari Midtrans Dashboard
$config['midtrans_server_key'] = 'SB-Mid-server-PASTE-KEY-DISINI';

// Paste Client Key dari Midtrans Dashboard
$config['midtrans_client_key'] = 'SB-Mid-client-PASTE-KEY-DISINI';

// Merchant ID (optional)
$config['midtrans_merchant_id'] = 'Gxxxxxxxx';
?>
```

### Step 2: Test Konfigurasi

Test apakah library bisa diload:

```php
// Test di controller
$this->load->library('midtrans_lib');
$client_key = $this->midtrans_lib->get_client_key();
echo "Client Key: " . $client_key; // Harus tampil key Anda
```

---

## 4️⃣ Testing dengan Sandbox

### Test Credit Card

Gunakan data kartu test berikut:

| Field | Value |
|-------|-------|
| **Card Number** | `4811 1111 1111 1114` |
| **CVV** | `123` |
| **Exp Month** | `01` (atau bulan apa saja) |
| **Exp Year** | `2025` (atau tahun di masa depan) |
| **3DS Password** | `112233` |

### Test E-Wallet

**GoPay:**
- Pilih GoPay di payment page
- Akan muncul QR Code simulation
- Klik "Confirm Payment" untuk simulate sukses

**ShopeePay:**
- Sama seperti GoPay
- Gunakan deeplink simulation

### Test Bank Transfer

**BCA Virtual Account:**
- VA Number akan di-generate otomatis
- Copy VA number
- Gunakan simulator di dashboard Midtrans:
  1. Go to **Sandbox** > **Simulator**
  2. Paste VA number
  3. Klik "Pay"

### Test Status Transaksi

Di Sandbox Dashboard, Anda bisa:
- ✅ Set transaction ke **settlement** (success)
- ⏳ Set transaction ke **pending**
- ❌ Set transaction ke **cancel**
- 🔄 Set transaction ke **expire**

---

## 5️⃣ Go Live (Production)

### Checklist Sebelum Go Live:

- [ ] Akun Midtrans sudah **approved**
- [ ] Dokumen bisnis sudah **lengkap**
- [ ] Testing di Sandbox sudah **berhasil** semua
- [ ] Webhook notification sudah **tested**
- [ ] Error handling sudah **proper**

### Langkah Go Live:

**1. Update Konfigurasi**

Edit `application/config/midtrans.php`:

```php
// UBAH dari false ke true
$config['midtrans_is_production'] = true;

// GANTI dengan Production Keys
$config['midtrans_server_key'] = 'Mid-server-PRODUCTION-KEY';
$config['midtrans_client_key'] = 'Mid-client-PRODUCTION-KEY';
```

**2. Setup Notification URL di Midtrans Dashboard**

1. Login ke Production Dashboard
2. Go to **Settings** > **Configuration**
3. Set **Payment Notification URL**:
   ```
   https://yourdomain.com/subscription/midtrans_notification
   ```

4. Set **Finish Redirect URL**:
   ```
   https://yourdomain.com/subscription/payment_finish
   ```

5. Set **Error Redirect URL**:
   ```
   https://yourdomain.com/subscription/payment_error
   ```

**3. Test di Production**

- Gunakan kartu kredit REAL Anda (nominal kecil dulu)
- Test semua payment methods yang akan Anda gunakan
- Verify notification working
- Check database apakah subscription tersimpan dengan benar

**4. Monitor Transaksi**

Dashboard Production Midtrans menampilkan:
- Real-time transactions
- Success rate
- Failed transactions
- Settlement reports

---

## 🧪 Quick Test Flow

### Test Complete Flow:

1. **Buka Form Subscription**
   ```
   http://localhost/usahain/subscription/create
   ```

2. **Isi Form:**
   - Nama: Test User
   - Paket: Growth (Rp 45.000)
   - Tanggal aktif: Hari ini
   - Metode: E-Wallet

3. **Klik "Bayar Rp 49.950"**
   - Akan redirect ke halaman payment
   - Klik "Bayar Sekarang"
   - Popup Midtrans muncul

4. **Pilih Payment Method:**
   - Credit Card: Gunakan test card `4811 1111 1111 1114`
   - GoPay: Klik "Confirm Payment" di simulator
   - BCA VA: Copy VA number, bayar di simulator

5. **Verify Result:**
   - Success: Redirect ke payment_finish
   - Database: subscription tersimpan dengan status 'active'
   - Order ID: Tercatat di database

---

## 🔒 Security Best Practices

### 1. Protect Server Key

**JANGAN:**
```php
// ❌ JANGAN hardcode di controller
$server_key = 'Mid-server-xxxxxxxxx';
```

**LAKUKAN:**
```php
// ✅ Simpan di config file
$this->config->item('midtrans_server_key');

// ✅ Atau gunakan .env file
$server_key = getenv('MIDTRANS_SERVER_KEY');
```

### 2. Verify Webhook Signature

Sudah implemented di `Midtrans_lib`:

```php
if (!$this->midtrans_lib->verify_signature($notification)) {
    // Invalid signature = possible fraud
    http_response_code(403);
    return;
}
```

### 3. Use HTTPS in Production

Midtrans **REQUIRES** HTTPS untuk production webhook.

### 4. Sanitize Input

Sudah implemented dengan `$this->input->post('field', TRUE)`

---

## 📊 Payment Methods Available

| Method | Sandbox | Production | Fee |
|--------|---------|------------|-----|
| **Credit Card** | ✅ | ✅ | ~2.9% |
| **GoPay** | ✅ | ✅ | 2% |
| **ShopeePay** | ✅ | ✅ | 2% |
| **QRIS** | ✅ | ✅ | 0.7% |
| **BCA VA** | ✅ | ✅ | Rp 4.000 |
| **BNI VA** | ✅ | ✅ | Rp 4.000 |
| **BRI VA** | ✅ | ✅ | Rp 4.000 |
| **Permata VA** | ✅ | ✅ | Rp 4.000 |
| **Mandiri Bill** | ✅ | ✅ | Rp 4.000 |
| **Indomaret** | ✅ | ✅ | Rp 5.000 |
| **Alfamart** | ✅ | ✅ | Rp 5.000 |

---

## 🐛 Troubleshooting

### Error: "Midtrans library not found"

**Solution:**
```bash
cd d:\XAMPP\htdocs\usahain
composer require midtrans/midtrans-php
```

### Error: "Invalid Server Key"

**Solution:**
- Double check Server Key di `application/config/midtrans.php`
- Pastikan tidak ada spasi di awal/akhir key
- Pastikan menggunakan key yang sesuai (Sandbox vs Production)

### Error: "Snap Token creation failed"

**Solution:**
- Cek log error: `application/logs/`
- Pastikan total_pembayaran > 0
- Verify format data transaction_details benar

### Notification tidak masuk

**Solution:**
- Pastikan URL notification sudah di-set di Midtrans Dashboard
- Test dengan tools seperti Postman
- Check webhook logs di Midtrans Dashboard > Developers > API Logs

### Transaksi sukses tapi database tidak update

**Solution:**
- Check method `midtrans_notification()` di Controller
- Verify signature validation working
- Check error log untuk clues

---

## 📞 Support & Resources

**Midtrans Documentation:**
- Snap Integration: https://snap-docs.midtrans.com/
- API Reference: https://api-docs.midtrans.com/
- PHP Library: https://github.com/Midtrans/midtrans-php

**Midtrans Support:**
- Email: support@midtrans.com
- Phone: +62 21 8064 0222
- Live Chat: Available di Dashboard

**Test Environment:**
- Sandbox Dashboard: https://dashboard.sandbox.midtrans.com/
- Sandbox Simulator: https://simulator.sandbox.midtrans.com/

---

## ✅ Checklist Implementasi

- [x] Install Midtrans PHP SDK via Composer
- [x] Create config file `midtrans.php`
- [x] Create library `Midtrans_lib.php`
- [x] Update Subscription Controller
- [x] Create payment view
- [x] Create payment result view
- [x] Add database columns (order_id, payment_type, etc)
- [ ] Register Midtrans account (Anda)
- [ ] Get Sandbox API Keys (Anda)
- [ ] Configure API Keys di config (Anda)
- [ ] Test complete payment flow (Anda)
- [ ] Setup webhook notification URL (Anda)
- [ ] Test all payment methods (Anda)
- [ ] Go live with Production keys (Anda)

---

**File Locations:**
- Config: `application/config/midtrans.php`
- Library: `application/libraries/Midtrans_lib.php`
- Controller: `application/controllers/Subscription.php`
- Views: `application/views/subscription/payment.php`, `payment_result.php`
- Migration: `database/midtrans_integration.sql`

**Date**: 22 December 2025  
**Status**: ✅ READY FOR TESTING
