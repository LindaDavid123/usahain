# ✅ Testing Checklist - Dashboard Usahain

## 1️⃣ SETUP & PREREQUISITES

### Database Setup
- [ ] Database `usahain_db` sudah created
- [ ] Tables sudah di-import dari schema.sql
- [ ] Verify: Gunakan `SHOW TABLES;` di phpMyAdmin

### Configuration
- [ ] Config database.php benar (hostname, username, password, database)
- [ ] Config session sudah aktif di config.php
- [ ] Verify: Login ke localhost berhasil tanpa error

### File Structure
- [ ] application/controllers/Auth.php ada
- [ ] application/models/Dashboard_model.php ada
- [ ] application/views/auth/dashboard_operasional.php ada
- [ ] application/views/auth/dashboard_planning.php ada
- [ ] application/views/auth/dashboard_selection.php ada

---

## 2️⃣ AUTHENTICATION TESTS

### Login Functionality
- [ ] Login page load tanpa error
- [ ] Input validation works (empty email, invalid email)
- [ ] Login dengan email yang tidak terdaftar → error message
- [ ] Login dengan password salah → error message
- [ ] Login dengan email & password benar → redirect ke dashboard_selection
- [ ] Session data tersimpan dengan baik

### Register Functionality
- [ ] Register page load tanpa error
- [ ] Input validation works (empty fields, email exists, password mismatch)
- [ ] Register user baru → success message
- [ ] Redirect ke login page setelah register
- [ ] User baru bisa login dengan credential baru

### Logout Functionality
- [ ] Logout button visible di header
- [ ] Click logout → session destroyed
- [ ] Redirect ke login page
- [ ] Verify: User tidak bisa akses dashboard tanpa login

---

## 3️⃣ DASHBOARD SELECTION TEST

### Page Load
- [ ] Dashboard selection page load dengan baik
- [ ] Header title: "Pilih Dashboard Anda"
- [ ] 2 cards visible: "Sudah Memiliki Usaha" dan "Belum Memiliki Usaha"
- [ ] Both buttons clickable

### Operasional Card
- [ ] Icon 🚀 visible
- [ ] Title "Sudah Memiliki Usaha" visible
- [ ] Subtitle "Dashboard Operasional" visible
- [ ] 4 feature items visible
- [ ] Button "Pilih Dashboard Ini" working
- [ ] Click button → set_dashboard_type('operational') called
- [ ] Redirect ke dashboard_operasional

### Planning Card
- [ ] Icon 💡 visible
- [ ] Title "Belum Memiliki Usaha" visible
- [ ] Subtitle "Dashboard Perencanaan" visible
- [ ] 4 feature items visible
- [ ] Button "Pilih Dashboard Ini" working
- [ ] Click button → set_dashboard_type('planning') called
- [ ] Redirect ke dashboard_planning

---

## 4️⃣ DASHBOARD OPERASIONAL TESTS

### Page Layout
- [ ] Navbar visible dengan proper styling
- [ ] "Dashboard Operasional" title visible
- [ ] "Kelola Bisnis yang Sudah Berjalan" subtitle visible
- [ ] Business card (Bisnis section) visible
- [ ] No layout errors atau overlapping elements
- [ ] Footer visible at bottom

### Navigation
- [ ] "Dashboard Perencanaan" button visible
- [ ] Click button → redirect ke dashboard_selection
- [ ] Avatar initial (first letter of user name) visible
- [ ] Logout button visible
- [ ] Click logout → logout works

### Business Card Section
- [ ] Business name displayed (from session)
- [ ] "UMKM" tag visible
- [ ] "Aktif Beroperasi" tag visible
- [ ] Today profit displayed (format: Rp X.XXX.XXX)
- [ ] "Laba Bersih" label visible

### Quick Actions Section
- [ ] "⚡ Aksi Cepat" section title visible
- [ ] 4 buttons visible: Catat Penjualan, Catat Pengeluaran, Kalkulator HPP, Manajemen Risiko
- [ ] Buttons have proper icons and styling

### Summary Cards
- [ ] 3 summary cards visible: Penjualan, Pengeluaran, Laba Bersih
- [ ] Values displayed in Rupiah format
- [ ] Colors: Green (sales), Red (expense), Blue (profit)
- [ ] Transaction count displayed

### Filter Periode
- [ ] 4 filter buttons visible: Hari Ini, Minggu Ini, Bulan Ini, Tahun Ini
- [ ] "Hari Ini" active by default
- [ ] Click filters → button styling changes
- [ ] Chart title updates based on filter

### Chart Section
- [ ] Chart canvas visible
- [ ] Legend visible (3 items: Penjualan, Pengeluaran, Laba)
- [ ] Line chart renders without errors
- [ ] Chart responsive on mobile

### Insight Section
- [ ] Insight box visible with gradient background
- [ ] 3 insight items visible
- [ ] Text readable

### Recent Transactions
- [ ] "Transaksi Terbaru" section visible
- [ ] Transaction list displays (if any)
- [ ] Format: icon | title | type | amount
- [ ] Transactions styled with border-left color

### Tools Grid
- [ ] 6 tool boxes visible
- [ ] Each tool has: icon, title, description, link
- [ ] Tools: Kalkulator HPP, Pencatatan Keuangan, Manajemen Risiko, Analisis Produk, Info & Konsultasi, AI Business Advisor
- [ ] Links point to correct URLs

---

## 5️⃣ MODAL TESTS

### Catat Penjualan Modal
- [ ] Click "Catat Penjualan" button → modal appears
- [ ] Modal has dark overlay
- [ ] Modal centered on screen
- [ ] Close button (X) works
- [ ] Input fields: Jumlah, Kategori, Deskripsi
- [ ] Submit button styled correctly
- [ ] Input validation works (empty jumlah)
- [ ] Format Rupiah function works
- [ ] Submit → success notification
- [ ] Summary cards update
- [ ] Transaction list updates

### Catat Pengeluaran Modal
- [ ] Click "Catat Pengeluaran" button → modal appears
- [ ] Modal properly styled (yellow/red theme)
- [ ] Input fields: Jumlah, Kategori, Deskripsi
- [ ] Kategori options: Bahan Baku, Operasional, Gaji, Utilitas, Transport, Lainnya
- [ ] Submit → expense recorded
- [ ] Summary cards update (total expense increases)
- [ ] Transaction displays as "minus" style

### Manajemen Risiko Modal
- [ ] Click "Manajemen Risiko" button → modal appears
- [ ] Modal title: "⚠️ Manajemen Risiko Bisnis"
- [ ] Risk score section visible (0% initially)
- [ ] 4 risk cards visible: Tinggi, Sedang, Mitigasi, Kontinjensi
- [ ] Each card has checkboxes
- [ ] Checking boxes → risk score updates
- [ ] Score bar animates
- [ ] Color changes based on score (red < orange < yellow < green)
- [ ] Submit button works

---

## 6️⃣ RESPONSIVE DESIGN TESTS

### Desktop (1400px+)
- [ ] All elements visible and properly spaced
- [ ] No horizontal scrollbar
- [ ] Layout full-width but respects max-width

### Tablet (768px - 1200px)
- [ ] Tools grid changes to 2 columns
- [ ] Summary cards stack appropriately
- [ ] Font sizes readable
- [ ] Buttons have adequate touch target (44px+)

### Mobile (375px)
- [ ] Navbar stacks properly
- [ ] Header readable
- [ ] Business card displays well
- [ ] Buttons full-width or appropriate size
- [ ] No text overflow
- [ ] Chart visible and scrollable
- [ ] Modals responsive

---

## 7️⃣ DASHBOARD PLANNING TESTS

### Page Layout
- [ ] Header with proper styling (orange/warning color)
- [ ] Icon 🚀 visible
- [ ] Title: "Dashboard Perencanaan" visible
- [ ] Subtitle: "Mulai perjalanan bisnis Anda" visible
- [ ] No layout errors

### Navigation
- [ ] "Dashboard Operasional" button visible
- [ ] Click button → redirect ke dashboard_selection
- [ ] Avatar and logout buttons visible

### Welcome Banner
- [ ] Greeting: "Selamat datang, [Nama User]!" visible
- [ ] Subtitle text visible
- [ ] Gradient background styling correct

### Progress Card
- [ ] Progress header visible
- [ ] Progress bar shows 25% (visual)
- [ ] 4 progress steps visible
- [ ] Step styling: completed (green), active (blue), pending (gray)

### Quick Start Cards
- [ ] 3 cards visible: Dapatkan Ide, Hitung Modal, Business Plan
- [ ] Each card has icon, title, description, button
- [ ] Icons: 🤖, 🧮, 📋
- [ ] Buttons clickable and link properly

### Tools Grid
- [ ] 8 tool boxes visible in grid layout
- [ ] Each tool has proper styling with gradient
- [ ] Tools: AI Advisor, Kalkulator Modal, Analisis Pasar, Manajemen Risiko, Template Dokumen, Panduan UMKM, Simulasi Pinjaman, Pelatihan Gratis
- [ ] Links point to correct URLs (or placeholder if not exist)

### Tips Section
- [ ] Tips container visible with yellow/warning theme
- [ ] Title: "💡 Tips Memulai Usaha" visible
- [ ] 5 tip items visible
- [ ] Each tip has proper styling with hover effect

---

## 8️⃣ DATA FLOW TESTS

### Transaction Recording
- [ ] Add penjualan via modal → Data saved to database
- [ ] Refresh page → Data persists
- [ ] Add pengeluaran via modal → Data saved to database
- [ ] Both show in transaction list

### Summary Calculation
- [ ] Summary cards calculate correctly from database
- [ ] Penjualan total = sum of all "pemasukan"
- [ ] Pengeluaran total = sum of all "pengeluaran"
- [ ] Laba = penjualan - pengeluaran
- [ ] Margin = (laba / penjualan) * 100

### Period Filtering
- [ ] Filter "Hari Ini" shows today's transactions only
- [ ] Filter "Minggu Ini" shows last 7 days
- [ ] Filter "Bulan Ini" shows current month
- [ ] Summary updates based on filter

---

## 9️⃣ BROWSER COMPATIBILITY

- [ ] Chrome (latest) ✅ or ❌
- [ ] Firefox (latest) ✅ or ❌
- [ ] Safari (latest) ✅ or ❌
- [ ] Edge (latest) ✅ or ❌
- [ ] Mobile Chrome ✅ or ❌
- [ ] Mobile Safari ✅ or ❌

---

## 🔟 PERFORMANCE TESTS

### Page Load Time
- [ ] Dashboard operasional loads < 2 seconds
- [ ] Dashboard planning loads < 2 seconds
- [ ] Charts render smoothly (no lag)

### Browser Console
- [ ] No JavaScript errors
- [ ] No CSS errors
- [ ] No 404 errors for resources

### Network Tab
- [ ] All images loaded
- [ ] All CSS files loaded
- [ ] All JS files loaded
- [ ] No failed requests

---

## 1️⃣1️⃣ SECURITY TESTS

- [ ] Cannot access dashboard without login
- [ ] Session expires on logout
- [ ] User ID taken from session (not URL)
- [ ] Cannot view other user's data
- [ ] Password field masked (type=password)
- [ ] No sensitive data in console

---

## 1️⃣2️⃣ EDGE CASES

### No Transaction Data
- [ ] Dashboard shows "Belum ada transaksi" message
- [ ] Summary shows 0 values
- [ ] Chart doesn't show errors

### Invalid Input
- [ ] Empty penjualan input → validation error
- [ ] Non-numeric amount → error handling
- [ ] Missing category → validation error

### Session Expiry
- [ ] If session expires → redirect to login
- [ ] Back button after logout → go to login

---

## FINAL CHECKLIST

- [ ] All tests passed
- [ ] No critical bugs
- [ ] Performance acceptable
- [ ] Documentation complete
- [ ] Code properly commented
- [ ] Ready for production

---

## 📝 Test Results Summary

| Category | Pass | Fail | Notes |
|----------|------|------|-------|
| Setup & Prerequisites | | | |
| Authentication | | | |
| Dashboard Selection | | | |
| Dashboard Operasional | | | |
| Modals | | | |
| Responsive Design | | | |
| Dashboard Planning | | | |
| Data Flow | | | |
| Browser Compatibility | | | |
| Performance | | | |
| Security | | | |
| Edge Cases | | | |

---

**Test Date**: _______________
**Tested By**: _______________
**Status**: ✅ PASSED / ❌ FAILED

**Notes**:
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

