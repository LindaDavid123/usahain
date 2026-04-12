#!/bin/bash
# ===========================================
# Usahain Velora - Setup Script
# ===========================================
# Jalankan setelah clone: bash setup.sh
# ===========================================

set -e

echo "=========================================="
echo "  Usahain Velora - Setup"
echo "=========================================="
echo ""

# ----- 1. Composer Install -----
echo "[1/4] Installing Composer dependencies..."
if command -v composer &> /dev/null; then
    composer install
    echo "  ✔ Composer dependencies installed"
else
    echo "  ✘ Composer not found! Install from https://getcomposer.org"
    echo "    Lalu jalankan: composer install"
fi
echo ""

# ----- 2. Copy .env -----
echo "[2/4] Setting up .env file..."
if [ -f .env ]; then
    echo "  ✔ .env already exists, skipping"
else
    cp .env.example .env
    echo "  ✔ .env created from .env.example"
    echo "  ⚠ Edit .env dan isi credentials kamu:"
    echo "    - GOOGLE_CLIENT_ID"
    echo "    - GOOGLE_CLIENT_SECRET"
    echo "    - GEMINI_API_KEY"
fi
echo ""

# ----- 3. Copy config files -----
echo "[3/4] Setting up config files..."

CONFIG_DIR="application/config"

if [ -f "$CONFIG_DIR/database.php" ]; then
    echo "  ✔ database.php already exists"
else
    cp "$CONFIG_DIR/database_sample.php" "$CONFIG_DIR/database.php"
    echo "  ✔ database.php created from database_sample.php"
    echo "  ⚠ Edit database.php → sesuaikan username, password, database"
fi

if [ -f "$CONFIG_DIR/midtrans.php" ]; then
    echo "  ✔ midtrans.php already exists"
else
    cp "$CONFIG_DIR/midtrans_sample.php" "$CONFIG_DIR/midtrans.php"
    echo "  ✔ midtrans.php created from midtrans_sample.php"
    echo "  ⚠ Edit midtrans.php → isi server_key dan client_key dari Midtrans Dashboard"
fi

if [ -f "$CONFIG_DIR/google_oauth.php" ]; then
    echo "  ✔ google_oauth.php already exists"
else
    cp "$CONFIG_DIR/google_oauth_sample.php" "$CONFIG_DIR/google_oauth.php"
    echo "  ✔ google_oauth.php created from google_oauth_sample.php"
    echo "  ⚠ Credentials dibaca dari .env (GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET)"
fi

if [ -f "$CONFIG_DIR/gemini.php" ]; then
    echo "  ✔ gemini.php already exists"
else
    cp "$CONFIG_DIR/gemini_sample.php" "$CONFIG_DIR/gemini.php"
    echo "  ✔ gemini.php created from gemini_sample.php"
    echo "  ⚠ API key dibaca dari .env (GEMINI_API_KEY)"
fi
echo ""

# ----- 4. Database -----
echo "[4/4] Database setup..."
echo "  Import database secara manual:"
echo "    1. Buat database 'usahain_db' di phpMyAdmin"
echo "    2. Import file: usahain_db_complete.sql"
echo "       Atau via terminal:"
echo "       mysql -u root -p usahain_db < usahain_db_complete.sql"
echo ""

echo "=========================================="
echo "  Setup selesai!"
echo "=========================================="
echo ""
echo "Checklist:"
echo "  [ ] Edit .env → isi semua API keys"
echo "  [ ] Edit application/config/database.php → sesuaikan DB credentials"
echo "  [ ] Edit application/config/midtrans.php → isi Midtrans keys"
echo "  [ ] Import usahain_db_complete.sql ke MySQL"
echo "  [ ] Pastikan Apache & MySQL sudah running di XAMPP"
echo ""
echo "Akses: http://localhost/usahain_velora/"
echo ""
