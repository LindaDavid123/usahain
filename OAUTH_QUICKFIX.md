# Setup Google OAuth - Quick Guide

## ⚠️ Error: "Missing required parameter: client_id"

Ini berarti Google OAuth credentials belum di-setup. Ikuti langkah berikut:

## 🔧 Quick Fix (5 menit)

### Step 1: Dapatkan Google OAuth Credentials

1. **Buka Google Cloud Console:**
   ```
   https://console.cloud.google.com
   ```

2. **Login & Create Project:**
   - Klik dropdown "Select a project" di top bar
   - Klik "NEW PROJECT"
   - Nama project: `Usahain App`
   - Klik "Create"

3. **Enable Google+ API:**
   - Menu sidebar → "APIs & Services" → "Library"
   - Search: "Google+ API" atau "People API"
   - Klik dan tekan "Enable"

4. **Create OAuth 2.0 Client:**
   - Sidebar → "Credentials"
   - Klik "Create Credentials" → "OAuth client ID"
   - Jika diminta, configure consent screen dulu:
     - User type: External
     - App name: Usahain
     - User support email: your email
     - Developer contact: your email
     - Save and Continue
   - Application type: **Web application**
   - Name: `Usahain Web Client`
   
   **Authorized redirect URIs - PENTING!**
   ```
   http://localhost/usahain/googleauth/callback
   ```
   
   - Klik "Create"
   - **COPY** Client ID dan Client Secret (akan muncul di popup)

### Step 2: Update .env File

1. **Buka file `.env`** di root project:
   ```
   d:\XAMPP\htdocs\usahain\.env
   ```

2. **Edit dan tambahkan credentials:**
   ```env
   GEMINI_API_KEY=AIzaSyAcszB8hqeyB1bmnk-z5oTN5LVEuRP_gIo

   # Google OAuth 2.0 Credentials
   GOOGLE_CLIENT_ID=123456789-abcdefghijklmnop.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=GOCSPX-abcd1234efgh5678ijkl
   ```

3. **Save file**

### Step 3: Restart Apache

1. Buka XAMPP Control Panel
2. Stop Apache
3. Start Apache lagi

### Step 4: Test!

1. Buka browser:
   ```
   http://localhost/usahain/auth/login
   ```

2. Klik **"Lanjutkan dengan Google"**

3. Pilih akun Google Anda

4. Done! ✨

---

## 🔍 Verify Setup

Check apakah credentials sudah terbaca:

```php
// Buat file test: d:\XAMPP\htdocs\usahain\test_oauth_config.php

<?php
putenv('GOOGLE_CLIENT_ID=' . 'YOUR_CLIENT_ID');
putenv('GOOGLE_CLIENT_SECRET=' . 'YOUR_SECRET');

echo "Client ID: " . (getenv('GOOGLE_CLIENT_ID') ?: 'NOT SET') . "\n";
echo "Client Secret: " . (getenv('GOOGLE_CLIENT_SECRET') ?: 'NOT SET') . "\n";
?>
```

Jalankan:
```bash
php test_oauth_config.php
```

---

## ❌ Common Mistakes

### 1. Salah menempatkan redirect URI
**❌ SALAH:**
```
http://localhost/googleauth/callback
```

**✅ BENAR:**
```
http://localhost/usahain/googleauth/callback
```

### 2. Lupa restart Apache setelah edit .env
**FIX:** Restart Apache di XAMPP

### 3. Typo di .env file
**FIX:** Pastikan:
- No spaces before/after `=`
- No quotes around values (kecuali ada special chars)
- Exact match dengan yang di Google Console

---

## 📝 Example .env Content

```env
# Gemini AI
GEMINI_API_KEY=AIzaSyAcszB8hqeyB1bmnk-z5oTN5LVEuRP_gIo

# Google OAuth 2.0
# Get from: https://console.cloud.google.com
GOOGLE_CLIENT_ID=123456789012-abc123def456ghi789jkl012mno345pq.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-1a2b3c4d5e6f7g8h9i0j1k2l
```

---

## 🎯 Still Not Working?

### Check 1: Verify .env is loaded
Add this to `index.php` temporarily:
```php
// After the .env loading code
var_dump(getenv('GOOGLE_CLIENT_ID'));
die();
```

Should output your Client ID, not `false`.

### Check 2: Check logs
```
d:\XAMPP\htdocs\usahain\application\logs\log-2025-12-17.php
```

Look for: `Google OAuth credentials not configured`

### Check 3: Manual config (temporary)
Edit `application/config/google_oauth.php`:
```php
// Replace these lines:
$config['google_client_id'] = getenv('GOOGLE_CLIENT_ID') ?: '';
$config['google_client_secret'] = getenv('GOOGLE_CLIENT_SECRET') ?: '';

// With hardcoded values (FOR TESTING ONLY):
$config['google_client_id'] = 'your-client-id.apps.googleusercontent.com';
$config['google_client_secret'] = 'your-secret-here';
```

**⚠️ WARNING:** Don't commit hardcoded credentials to Git!

---

## 📞 Need Help?

1. Screenshot error di browser
2. Check `application/logs/` untuk error messages
3. Verify credentials di Google Cloud Console
4. Make sure redirect URI exact match

Good luck! 🚀
