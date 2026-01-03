# Usahain - Aplikasi Manajemen UMKM

Aplikasi berbasis CodeIgniter 3 untuk membantu pengelolaan UMKM dengan fitur analisis produk, subscription, pencatatan keuangan, dan advisory dari AI.

## Setup & Instalasi

### 1. Persiapan Database

Import file `database/schema.sql` ke MySQL:

```bash
# Menggunakan mysql CLI (XAMPP)
C:\xampp\mysql\bin\mysql.exe -u root -p < "C:\xampp\htdocs\usahain\database\schema.sql"
```

Atau manual di phpMyAdmin:
- Buka `http://localhost/phpmyadmin`
- Tab "Import"
- Pilih `C:\xampp\htdocs\usahain\database\schema.sql`
- Klik "Go"

### 2. Konfigurasi Database

Edit `application/config/database.php`:

```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',        // ubah sesuai setup Anda
    'password' => '',            // ubah jika ada password
    'database' => 'usahain_db',
    'dbdriver' => 'mysqli',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    // ... setting lainnya sudah dikonfigurasi
);
```

### 3. Setup URL Clean (Menghapus index.php)

#### Opsi A: Gunakan .htaccess (Recommended)

File `.htaccess` sudah ada di root. Pastikan mod_rewrite aktif di Apache:

1. Buka `C:\xampp\apache\conf\httpd.conf`
2. Cari baris: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Hapus `#` di awal (uncomment)
4. Restart Apache (XAMPP Control Panel → Restart Apache)

Akses: `http://localhost/usahain/auth/login`

#### Opsi B: Gunakan URL dengan index.php (Jika mod_rewrite tidak bekerja)

Edit `application/config/config.php`:
```php
$config['index_page'] = 'index.php';
```

Akses: `http://localhost/usahain/index.php/auth/login`

### 4. Troubleshooting Error 500

**Jika melihat error 500 Internal Server Error:**

1. **Cek database connection:**
   - Pastikan MySQL sudah running di XAMPP
   - Pastikan database `usahain_db` sudah dibuat
   - Cek kredensial di `application/config/database.php`

2. **Cek error log:**
   - `C:\xampp\apache\logs\error.log` — untuk error Apache
   - `C:\xampp\php\logs` — untuk error PHP
   - `application/logs/` — untuk error CodeIgniter

3. **Enable debug mode:**
   - Edit `index.php`, ubah `'development'` → `'production'` untuk melihat error detail
   - Atau cek log di `application/logs/`

4. **Pastikan file CRUD view ada:**
   - `application/views/auth/`
   - `application/views/user/`
   - `application/views/subscription/`
   - `application/views/analisis/`

---

## Cara Menggunakan Aplikasi

### 1. Register (Buat Akun)

```
http://localhost/usahain/auth/register
```

Isi form dengan:
- Nama lengkap
- Email
- Nama usaha (optional)
- Password (min 6 karakter)
- Konfirmasi password

### 2. Login

```
http://localhost/usahain/auth/login
```

Masukkan email dan password yang sudah didaftar.

### 3. Dashboard

Setelah login berhasil, Anda akan diarahkan ke dashboard yang menampilkan menu utama:

```
http://localhost/usahain/auth/dashboard
```

Menu tersedia:
- **👥 Kelola User** — Admin only
- **📋 Subscription** — Kelola subscription user
- **📊 Analisis Produk** — Analisis dan kelola produk
- **⚠️ Manajemen Risiko** — (coming soon)
- **💰 Pencatatan Keuangan** — (coming soon)
- **🧮 Kalkulator HPP** — (coming soon)

### 4. Kelola User (Admin)

```
http://localhost/usahain/user
```

CRUD operations:
- **List:** Lihat semua user
- **View:** Lihat detail user
- **Create:** Tambah user baru (link: `/user/create`)
- **Edit:** Ubah data user (link: `/user/edit/{id}`)
- **Delete:** Hapus user (link: `/user/delete/{id}`)

### 5. Kelola Subscription

```
http://localhost/usahain/subscription
```

Kelola subscription user dengan fitur:
- Pilihan paket: Basic, Pro, Enterprise
- Status: Active, Inactive, Expired
- Tanggal aktif & kadaluarsa

### 6. Analisis Produk

```
http://localhost/usahain/analisis
```

Analisis produk dengan:
- Nama produk
- Penjualan (Rp)
- Biaya produksi (Rp)
- Deskripsi analisis
- Kalkulasi margin keuntungan otomatis

---

## Struktur Project

```
usahain/
├── application/
│   ├── config/
│   │   ├── database.php          (konfigurasi database)
│   │   ├── config.php            (base_url, index_page)
│   │   ├── routes.php            (friendly routes)
│   │   ├── autoload.php          (auto-load libraries & helpers)
│   │   └── ...
│   ├── controllers/
│   │   ├── Auth.php              (login, register, logout)
│   │   ├── User.php              (CRUD user)
│   │   ├── Subscription.php      (CRUD subscription)
│   │   ├── Analisis.php          (CRUD analisis produk)
│   │   ├── Dbcheck.php           (DB connection check)
│   │   └── ...
│   ├── models/
│   │   ├── Auth_model.php        (login/register logic)
│   │   ├── User_model.php        (user CRUD)
│   │   ├── Subscription_model.php
│   │   ├── Analisis_produk_model.php
│   │   └── ...
│   ├── views/
│   │   ├── auth/                 (login, register, dashboard)
│   │   ├── user/                 (user CRUD views)
│   │   ├── subscription/         (subscription CRUD views)
│   │   ├── analisis/             (analisis CRUD views)
│   │   └── ...
│   └── ...
├── database/
│   └── schema.sql                (database schema)
├── system/                        (CodeIgniter core - jangan diubah)
├── index.php                      (entry point)
├── .htaccess                      (URL rewrite rules)
├── composer.json                  (dependencies)
└── README.md                      (file ini)
```

---

## Users & Roles

### Default Admin User

Email: `admin@example.com`
Password: (ubah password ini setelah login pertama)

User dapat di-create melalui:
1. Register form — role default: 'user'
2. Admin panel — bisa set role 'user' atau 'admin'

---

## Database Schema

### Tabel `user`
- `id_user` (INT, Primary Key)
- `nama` (VARCHAR 200)
- `email` (VARCHAR 250, Unique)
- `password` (VARCHAR 255, hashed)
- `role` (ENUM: 'user', 'admin')
- `nama_usaha` (VARCHAR 255)
- `created_at` (DATETIME)

### Tabel `subscription`
- `id_subs` (INT, Primary Key)
- `id_user` (INT, Foreign Key)
- `paket` (VARCHAR 50)
- `status` (VARCHAR 50)
- `tgl_aktif` (DATE)
- `tgl_expired` (DATE)

### Tabel `analisis_produk`
- `id_produk` (INT, Primary Key)
- `id_user` (INT, Foreign Key)
- `nama_produk` (VARCHAR 250)
- `analisis` (TEXT)
- `penjualan` (DECIMAL)
- `biaya_produksi` (DECIMAL)
- `created_at` (DATETIME)

### Tabel Lainnya (coming soon)
- `manajemen_risiko`
- `pencatatan_keuangan`
- `kalkulator_hpp`
- `al_advisor`

---

## Testing Connection

Test database connection dengan endpoint khusus:

```
http://localhost/usahain/dbcheck
```

Output: `Database connection OK. Test value: 1`

---

## Fitur yang Sudah Diimplementasikan

✅ User Management (CRUD)
✅ Authentication (Register, Login, Logout)
✅ Session Management
✅ Subscription Management
✅ Product Analysis
✅ Form Validation
✅ User-specific Data Isolation
✅ Friendly URLs (dengan .htaccess)
✅ Password Hashing (bcrypt)

## Fitur yang Akan Datang

🔄 Manajemen Risiko (CRUD)
🔄 Pencatatan Keuangan (CRUD)
🔄 Kalkulator HPP
🔄 AI Advisor
🔄 Dashboard & Reporting
🔄 Export ke PDF/Excel
🔄 Multi-language Support

---

## Support & Dokumentasi

- CodeIgniter 3 Docs: https://codeigniter.com/userguide3/
- Database Schema: Lihat `database/schema.sql`
- Config Reference: `application/config/`

---

## License

MIT License — Bebas untuk digunakan & dimodifikasi.
