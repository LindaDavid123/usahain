# Google OAuth 2.0 - Quick Test Checklist

## ✅ Pre-Testing Checklist

### 1. Composer Dependencies
```bash
cd d:\XAMPP\htdocs\usahain
composer install  # Already done!
```
✅ Google API Client installed: `vendor/google/apiclient`

### 2. Database Migration
```sql
-- Run di phpMyAdmin atau MySQL CLI
SOURCE d:/XAMPP/htdocs/usahain/database/oauth_migration.sql;
```

Verify:
```sql
DESCRIBE user;
-- Should show: google_id, oauth_provider, avatar_url columns
```

### 3. Environment Configuration
Edit `.env`:
```env
GOOGLE_CLIENT_ID=YOUR_CLIENT_ID_HERE
GOOGLE_CLIENT_SECRET=YOUR_CLIENT_SECRET_HERE
```

**Get credentials from:** https://console.cloud.google.com

## 🧪 Testing Steps

### Step 1: Google Cloud Console Setup (5 minutes)

1. Go to: https://console.cloud.google.com
2. Create project: "Usahain App"
3. Enable API: "Google+ API" or "Google OAuth2 API"
4. Create credentials: OAuth 2.0 Client ID
   - Type: Web application
   - Authorized redirect URIs:
     ```
     http://localhost/usahain/googleauth/callback
     ```
5. Copy Client ID & Secret to `.env`

### Step 2: Test OAuth Flow

1. **Start XAMPP**
   - Apache: ✅ Running
   - MySQL: ✅ Running

2. **Open Login Page**
   ```
   http://localhost/usahain/auth/login
   ```
   
3. **Click "Lanjutkan dengan Google"**
   - Should redirect to Google login
   - URL should be: `https://accounts.google.com/o/oauth2/auth?...`

4. **Select Google Account**
   - Choose your Google account
   - Click "Allow" for permissions

5. **Check Redirect**
   - Should redirect to: `http://localhost/usahain/googleauth/callback?code=...`
   - Then auto redirect to dashboard

6. **Verify Login**
   - Check session: User should be logged in
   - Check database:
     ```sql
     SELECT id_user, nama, email, google_id, oauth_provider, avatar_url 
     FROM user 
     WHERE oauth_provider = 'google';
     ```

### Step 3: Test Scenarios

#### ✅ Scenario 1: New Google User
- Use email yang belum pernah register
- Expected: Auto create user baru
- Verify: Check database, user baru muncul

#### ✅ Scenario 2: Existing Email (Local Account)
- Register manual dulu dengan email@example.com
- Login dengan Google using email@example.com
- Expected: Link Google account ke existing user
- Verify: User yang sama sekarang punya `google_id`

#### ✅ Scenario 3: Returning Google User
- Logout
- Login lagi dengan Google
- Expected: Direct login, no new user created
- Verify: Same user_id, updated avatar

#### ✅ Scenario 4: Error Handling
- Click "Cancel" di Google consent screen
- Expected: Redirect ke login dengan error message
- Verify: Flash message muncul

## 🐛 Common Issues & Fixes

### Error: "redirect_uri_mismatch"
**Fix:**
```
Google Console → Credentials → Edit OAuth Client
Authorized redirect URIs:
  http://localhost/usahain/googleauth/callback  ← Must match exactly!
```

### Error: "Class 'Google_Client' not found"
**Fix:**
```bash
composer install  # Run again
composer dump-autoload  # Regenerate autoloader
```

### Error: "The requested scope cannot be accessed"
**Fix:** Enable Google+ API di Google Cloud Console

### Error: "invalid_client"
**Fix:** Check `.env` file - Client ID atau Secret salah

## 📊 Expected Database State

After successful Google login:

```sql
+--------+-----------+-----------+-------------------------+--------+
| id_user| google_id | oauth_prov| email                   | nama   |
+--------+-----------+-----------+-------------------------+--------+
| 1      | 10964... | google    | user@gmail.com          | John D |
| 2      | NULL     | local     | local@example.com       | Local  |
| 3      | 10845... | google    | another@gmail.com       | Jane S |
+--------+-----------+-----------+-------------------------+--------+
```

## 🎯 Success Criteria

- ✅ User can click "Login with Google" button
- ✅ Redirects to Google OAuth consent screen
- ✅ User grants permission
- ✅ Redirects back to application
- ✅ User data saved to database
- ✅ Session created, user logged in
- ✅ Avatar from Google displayed
- ✅ Repeat login works without creating duplicate users
- ✅ Error handling works (cancel, network error, etc.)

## 🔐 Security Checklist

- ✅ State parameter prevents CSRF
- ✅ .env file NOT committed to Git
- ✅ Client Secret stored securely
- ✅ HTTPS recommended for production
- ✅ Token validation in callback
- ✅ SQL injection prevention (prepared statements)

## 📝 Next Steps (Optional Enhancements)

1. **Add more OAuth providers:**
   - Facebook Login
   - Microsoft/Azure AD
   - GitHub Login

2. **Profile Management:**
   - Allow users to disconnect OAuth
   - Manage multiple OAuth providers
   - Add local password to OAuth account

3. **Security Enhancements:**
   - 2FA for local accounts
   - Email verification
   - Session timeout

4. **UX Improvements:**
   - Remember last login method
   - Show OAuth provider on profile
   - One-click login if already authenticated

---

## 📞 Support

If you encounter issues:

1. Check `application/logs/log-YYYY-MM-DD.php` for errors
2. Enable PHP error display:
   ```php
   // In index.php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```
3. Check browser console for JavaScript errors
4. Verify Google Console → Credentials → OAuth consent screen is configured

Good luck! 🚀
