# 🔐 Google OAuth 2.0 Integration

Fitur autentikasi login menggunakan akun Google dengan metode OAuth 2.0 untuk mempermudah proses login tanpa registrasi manual.

## ✨ Features

- ✅ **Login dengan Google** - One-click login menggunakan akun Google
- ✅ **Auto Registration** - Otomatis buat akun untuk user baru
- ✅ **Account Linking** - Link akun Google ke existing email
- ✅ **Avatar Sync** - Sinkronisasi foto profil dari Google
- ✅ **CSRF Protection** - Menggunakan state parameter untuk keamanan
- ✅ **Error Handling** - Handling untuk berbagai error scenarios
- ✅ **Session Management** - Persistent login dengan session
- ✅ **Logout Support** - Revoke Google token saat logout

## 📦 Files Created/Modified

### New Files:
```
application/
├── config/
│   └── google_oauth.php           # OAuth configuration
├── controllers/
│   └── Googleauth.php             # OAuth flow controller
└── helpers/
    └── oauth_helper.php           # Helper functions

database/
├── oauth_migration.sql            # Database migration
└── schema.sql (updated)           # Updated schema

OAUTH_SETUP.md                     # Setup documentation
TESTING_OAUTH.md                   # Testing guide
.env (updated)                     # Environment variables
```

### Modified Files:
```
application/
├── models/
│   └── Auth_model.php             # Added OAuth methods
└── views/
    └── auth/
        └── login.php              # Added Google login button

composer.json                      # Added google/apiclient
.gitignore                         # Added .env exclusion
```

## 🚀 Quick Start

### 1. Install Dependencies
```bash
cd d:\XAMPP\htdocs\usahain
composer install
```

### 2. Run Database Migration
```bash
# Via phpMyAdmin: Import database/oauth_migration.sql
# Or via MySQL CLI:
mysql -u root -p usahain_db < database/oauth_migration.sql
```

### 3. Get Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com)
2. Create new project
3. Enable Google+ API
4. Create OAuth 2.0 Client ID
5. Add redirect URI:
   ```
   http://localhost/usahain/googleauth/callback
   ```
6. Copy Client ID & Secret

### 4. Configure Environment

Edit `.env`:
```env
GOOGLE_CLIENT_ID=your-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret
```

### 5. Test!

1. Open: `http://localhost/usahain/auth/login`
2. Click "Lanjutkan dengan Google"
3. Login dengan akun Google
4. Enjoy! 🎉

## 🔧 Configuration

### OAuth Config (`application/config/google_oauth.php`)

```php
$config['google_client_id'] = getenv('GOOGLE_CLIENT_ID');
$config['google_client_secret'] = getenv('GOOGLE_CLIENT_SECRET');
$config['google_redirect_uri'] = base_url('googleauth/callback');
$config['google_scopes'] = [
    'https://www.googleapis.com/auth/userinfo.profile',
    'https://www.googleapis.com/auth/userinfo.email'
];
```

### Database Schema

```sql
ALTER TABLE `user` 
  ADD COLUMN `google_id` VARCHAR(255) UNIQUE,
  ADD COLUMN `oauth_provider` ENUM('local', 'google') DEFAULT 'local',
  ADD COLUMN `avatar_url` VARCHAR(500),
  MODIFY `password` VARCHAR(255) NULL;
```

## 📖 Usage Examples

### Check if User is OAuth User

```php
$this->load->helper('oauth');

if (is_oauth_user()) {
    echo "User logged in via OAuth";
}
```

### Get User Avatar

```php
$avatar = get_user_avatar();
echo "<img src='{$avatar}' alt='Avatar'>";
```

### Check OAuth Configuration

```php
if (is_oauth_configured()) {
    // Show Google login button
} else {
    // Hide Google login option
}
```

## 🔐 Security Features

1. **CSRF Protection** - State parameter validates request origin
2. **Token Validation** - Verifies access token from Google
3. **Secure Storage** - Client Secret dalam environment variable
4. **SQL Injection Prevention** - Prepared statements di model
5. **Session Security** - Proper session management
6. **Error Logging** - Comprehensive error logging

## 🌐 OAuth Flow

```
┌─────────┐
│  User   │
└────┬────┘
     │ 1. Click "Login with Google"
     ↓
┌─────────────────┐
│   Googleauth    │
│   /login        │
└────┬────────────┘
     │ 2. Redirect to Google
     ↓
┌──────────────────┐
│  Google OAuth    │
│  Consent Screen  │
└────┬─────────────┘
     │ 3. User grants permission
     ↓
┌─────────────────┐
│   Googleauth    │
│   /callback     │
└────┬────────────┘
     │ 4. Exchange code for token
     │ 5. Get user profile
     │ 6. Create/update user in DB
     │ 7. Set session
     ↓
┌─────────────────┐
│   Dashboard     │
└─────────────────┘
```

## 🐛 Troubleshooting

### Problem: "redirect_uri_mismatch"
**Solution:** Pastikan redirect URI di Google Console sama persis dengan yang di config

### Problem: "Class 'Google_Client' not found"
**Solution:** Run `composer install` atau `composer dump-autoload`

### Problem: "invalid_client"
**Solution:** Check Client ID dan Secret di `.env` file

### Problem: User data tidak tersimpan
**Solution:** Run database migration (`oauth_migration.sql`)

## 📊 Database Structure

### User Table (After Migration)

| Column | Type | Description |
|--------|------|-------------|
| id_user | INT(8) | Primary key |
| google_id | VARCHAR(255) | Google user ID (unique) |
| oauth_provider | ENUM | 'local' or 'google' |
| avatar_url | VARCHAR(500) | Google profile picture URL |
| nama | VARCHAR(200) | User's full name |
| email | VARCHAR(250) | Email address |
| password | VARCHAR(255) | Hashed password (NULL for OAuth) |
| role | ENUM | 'user' or 'admin' |
| created_at | DATETIME | Registration timestamp |

## 🔗 URLs & Endpoints

| URL | Description |
|-----|-------------|
| `/googleauth/login` | Initiate OAuth flow |
| `/googleauth/callback` | OAuth callback handler |
| `/googleauth/logout` | Logout & revoke token |
| `/auth/login` | Login page (with Google button) |

## 📚 Documentation

- [Full Setup Guide](OAUTH_SETUP.md) - Detailed setup instructions
- [Testing Guide](TESTING_OAUTH.md) - Testing checklist & scenarios
- [Google OAuth Docs](https://developers.google.com/identity/protocols/oauth2) - Official documentation

## 🎯 Future Enhancements

- [ ] Facebook Login integration
- [ ] Microsoft/Azure AD Login
- [ ] GitHub Login
- [ ] Profile management for OAuth users
- [ ] Disconnect OAuth account
- [ ] Multiple OAuth providers per user

## 👤 Usage Statistics

After implementation, you can track:
- % of users using Google login vs manual registration
- OAuth login success/failure rates
- Most popular authentication method

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Check log files: `application/logs/`
2. Review [TESTING_OAUTH.md](TESTING_OAUTH.md)
3. Check [OAUTH_SETUP.md](OAUTH_SETUP.md)

---

**Built with ❤️ for Usahain App**
