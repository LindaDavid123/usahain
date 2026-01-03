# Google OAuth 2.0 Setup Guide

## 📋 Prerequisites
- Google Account
- Composer installed
- XAMPP/Web server running

## 🔧 Setup Steps

### 1. Google Cloud Console Configuration

1. **Buka Google Cloud Console**
   - Go to: https://console.cloud.google.com
   - Login dengan akun Google Anda

2. **Buat Project Baru** (atau gunakan existing project)
   - Klik dropdown project di top bar
   - Click "New Project"
   - Nama project: `Usahain App` (atau nama lain)
   - Klik "Create"

3. **Enable Google+ API**
   - Di dashboard, klik "Enable APIs and Services"
   - Search: "Google+ API" atau "Google OAuth2 API"
   - Klik dan Enable

4. **Create OAuth 2.0 Credentials**
   - Sidebar → Credentials
   - Click "Create Credentials" → "OAuth client ID"
   - Application type: "Web application"
   - Name: "Usahain Web Client"
   
   **Authorized JavaScript origins:**
   ```
   http://localhost
   ```
   
   **Authorized redirect URIs:**
   ```
   http://localhost/usahain/googleauth/callback
   http://localhost:8080/usahain/googleauth/callback
   ```
   
   - Click "Create"
   - **SAVE** Client ID dan Client Secret

### 2. Application Configuration

1. **Set Environment Variables**
   
   Edit file `.env` di root project:
   ```env
   GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=your-client-secret-here
   ```

2. **Run Database Migration**
   
   Import file `database/oauth_migration.sql`:
   ```bash
   # Via phpMyAdmin
   # - Buka phpMyAdmin
   # - Pilih database usahain_db
   # - Tab Import
   # - Choose file: database/oauth_migration.sql
   # - Click Go
   ```
   
   Or via MySQL CLI:
   ```bash
   mysql -u root -p usahain_db < database/oauth_migration.sql
   ```

3. **Install Dependencies**
   
   ```bash
   cd d:\XAMPP\htdocs\usahain
   composer install
   ```

### 3. Testing

1. **Start Apache & MySQL** via XAMPP Control Panel

2. **Open Browser**
   ```
   http://localhost/usahain/auth/login
   ```

3. **Click "Lanjutkan dengan Google"**
   - Will redirect to Google login
   - Pilih akun Google
   - Allow permissions
   - Akan redirect kembali ke aplikasi
   - User otomatis login!

### 4. Verify Database

Check table `user`:
```sql
SELECT id_user, nama, email, google_id, oauth_provider, avatar_url 
FROM user 
WHERE oauth_provider = 'google';
```

## 🔒 Security Notes

1. **NEVER commit** `.env` file dengan credentials ke Git
2. **Add to .gitignore:**
   ```
   .env
   vendor/
   ```

3. **Production Setup:**
   - Gunakan HTTPS (SSL Certificate)
   - Update Authorized redirect URIs di Google Console:
     ```
     https://yourdomain.com/googleauth/callback
     ```
   - Update `$config['google_redirect_uri']` di config file

## 📝 Flow Diagram

```
User → Click "Login with Google" 
     → Redirect to Google OAuth
     → User grants permission
     → Google redirects to /googleauth/callback
     → Exchange code for access token
     → Get user profile (email, name, picture)
     → Check if user exists (by google_id or email)
     → Create new user OR link existing account
     → Set session
     → Redirect to dashboard
```

## ❌ Troubleshooting

### Error: "redirect_uri_mismatch"
- **Fix:** Pastikan redirect URI di Google Console **exact match** dengan `$config['google_redirect_uri']`
- Check: http vs https, trailing slash, port number

### Error: "invalid_client"
- **Fix:** Client ID atau Secret salah
- Check: `.env` file, copy paste ulang dari Google Console

### Error: "Access blocked: This app's request is invalid"
- **Fix:** Google+ API belum di-enable
- Go to: APIs & Services → Enable Google+ API

### Composer install failed
- **Fix:** Enable zip extension di php.ini
- Edit: `D:\XAMPP\php\php.ini`
- Uncomment: `extension=zip`
- Restart Apache

## 🎯 Features Included

- ✅ Login with Google account
- ✅ Auto create user di database
- ✅ Link Google account ke existing email
- ✅ Save user avatar from Google
- ✅ Session management
- ✅ CSRF protection with state parameter
- ✅ Error handling & logging

## 📚 Additional Resources

- [Google OAuth 2.0 Documentation](https://developers.google.com/identity/protocols/oauth2)
- [PHP Google API Client](https://github.com/googleapis/google-api-php-client)
