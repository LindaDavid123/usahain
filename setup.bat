@echo off
REM ===========================================
REM  Usahain Velora - Setup Script (Windows)
REM ===========================================
REM  Jalankan setelah clone: setup.bat
REM ===========================================

echo ==========================================
echo   Usahain Velora - Setup
echo ==========================================
echo.

REM ----- 1. Composer Install -----
echo [1/4] Installing Composer dependencies...
where composer >nul 2>nul
if %ERRORLEVEL%==0 (
    composer install
    echo   [OK] Composer dependencies installed
) else (
    echo   [!] Composer not found! Install from https://getcomposer.org
    echo       Lalu jalankan: composer install
)
echo.

REM ----- 2. Copy .env -----
echo [2/4] Setting up .env file...
if exist .env (
    echo   [OK] .env already exists, skipping
) else (
    copy .env.example .env >nul
    echo   [OK] .env created from .env.example
    echo   [!] Edit .env dan isi credentials kamu:
    echo       - GOOGLE_CLIENT_ID
    echo       - GOOGLE_CLIENT_SECRET
    echo       - GEMINI_API_KEY
)
echo.

REM ----- 3. Copy config files -----
echo [3/4] Setting up config files...

set CONFIG_DIR=application\config

if exist "%CONFIG_DIR%\database.php" (
    echo   [OK] database.php already exists
) else (
    copy "%CONFIG_DIR%\database_sample.php" "%CONFIG_DIR%\database.php" >nul
    echo   [OK] database.php created from database_sample.php
    echo   [!] Edit database.php - sesuaikan username, password, database
)

if exist "%CONFIG_DIR%\midtrans.php" (
    echo   [OK] midtrans.php already exists
) else (
    copy "%CONFIG_DIR%\midtrans_sample.php" "%CONFIG_DIR%\midtrans.php" >nul
    echo   [OK] midtrans.php created from midtrans_sample.php
    echo   [!] Edit midtrans.php - isi server_key dan client_key dari Midtrans Dashboard
)

if exist "%CONFIG_DIR%\google_oauth.php" (
    echo   [OK] google_oauth.php already exists
) else (
    copy "%CONFIG_DIR%\google_oauth_sample.php" "%CONFIG_DIR%\google_oauth.php" >nul
    echo   [OK] google_oauth.php created from google_oauth_sample.php
    echo   [!] Credentials dibaca dari .env (GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET)
)

if exist "%CONFIG_DIR%\gemini.php" (
    echo   [OK] gemini.php already exists
) else (
    copy "%CONFIG_DIR%\gemini_sample.php" "%CONFIG_DIR%\gemini.php" >nul
    echo   [OK] gemini.php created from gemini_sample.php
    echo   [!] API key dibaca dari .env (GEMINI_API_KEY)
)
echo.

REM ----- 4. Database -----
echo [4/4] Database setup...
echo   Import database secara manual:
echo     1. Buat database 'usahain_db' di phpMyAdmin
echo     2. Import file: usahain_db_complete.sql
echo.

echo ==========================================
echo   Setup selesai!
echo ==========================================
echo.
echo Checklist:
echo   [ ] Edit .env - isi semua API keys
echo   [ ] Edit application\config\database.php - sesuaikan DB credentials
echo   [ ] Edit application\config\midtrans.php - isi Midtrans keys
echo   [ ] Import usahain_db_complete.sql ke MySQL
echo   [ ] Pastikan Apache ^& MySQL sudah running di XAMPP
echo.
echo Akses: http://localhost/usahain_velora/
echo.
pause
