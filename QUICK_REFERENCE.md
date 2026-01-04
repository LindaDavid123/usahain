# 🚀 Quick Reference - Dashboard Usahain

## 📋 Checklist Setup

- [ ] Database sudah di-import (`usahain_db`)
- [ ] User table sudah ada
- [ ] pencatatan_keuangan table sudah ada
- [ ] Config database.php sudah benar
- [ ] Session library sudah aktif di CI
- [ ] Routes sudah configured

---

## 🌐 URL Mapping

```
LOGIN
GET  /auth/login                    → Login form
POST /auth/login                    → Process login

REGISTER
GET  /auth/register                 → Register form
POST /auth/register                 → Process register

DASHBOARD
GET  /auth/dashboard                → Redirect ke dashboard (based on session)
GET  /auth/dashboard_selection      → Pilih dashboard
POST /auth/set_dashboard_type/:type → Set dashboard type (planning/operational)
GET  /auth/change_dashboard         → Switch dashboard

LOGOUT
GET  /auth/logout                   → Logout
```

---

## 💾 Database Schema Quick Reference

```sql
-- User Table
id_user (PK), nama, email, password, nama_usaha, role, 
google_id, oauth_provider, avatar_url, created_at

-- Pencatatan Keuangan Table
id_transaksi (PK), id_user (FK), kategori, jenis (pemasukan/pengeluaran),
nominal, tanggal, catatan, created_at
```

---

## 🎯 Key Functions

### Dashboard_model.php
```php
// Get summary keuangan dengan filter periode
$summary = $this->Dashboard_model->getSummary($id_user, 'hari');
// Returns: [today_sales, today_expense, today_profit, margin]

// Get recent transactions
$transactions = $this->Dashboard_model->getTransactions($id_user, 10);

// Get chart data
$chart_data = $this->Dashboard_model->getChartData($id_user, 7);
```

### Auth.php
```php
// Session data yang tersedia
$this->session->userdata('id_user');      // User ID
$this->session->userdata('nama');         // User name
$this->session->userdata('email');        // User email
$this->session->userdata('role');         // User role
$this->session->userdata('usaha');        // Business name
$this->session->userdata('dashboard_type'); // 'planning' or 'operational'
```

---

## 🎨 CSS Variables

```css
:root {
    --primary-color: #4A90E2;
    --primary-dark: #357ABD;
    --secondary-color: #7EC8E3;
    --success: #52D79A;
    --warning: #FFA76C;
    --danger: #F57C7C;
    --background: #F5F8FA;
    --card-bg: #FFFFFF;
    --text-primary: #2D3748;
    --text-secondary: #718096;
}
```

---

## 📱 Responsive Breakpoints

```css
Desktop:    > 1200px
Laptop:     992px - 1199px
Tablet:     768px - 991px
Mobile:     576px - 767px
Small:      < 575px
```

---

## 🔍 Debugging Tips

### Check Session
```php
echo json_encode($this->session->userdata());
```

### Check Database Connection
```php
if ($this->db->conn_id) {
    echo "DB Connected";
} else {
    echo "DB Error";
}
```

### Check Table Data
```php
$count = $this->db->get('pencatatan_keuangan')->num_rows();
echo "Total transactions: " . $count;
```

### Browser Console Debug
```javascript
console.log('Data Keuangan:', dataKeuangan);
```

---

## 📊 Modal Functions (JavaScript)

```javascript
// Open/Close Penjualan Modal
openModalPenjualan();
closeModalPenjualan();

// Open/Close Pengeluaran Modal
openModalPengeluaran();
closeModalPengeluaran();

// Open/Close Risiko Modal
openModalRisiko();
closeModalRisiko();
calculateRiskScore(); // Calculate risk assessment
```

---

## 🎯 Common Customizations

### Change Primary Color
Update di `:root` CSS variables (line ~30 dashboard_operasional.php)

### Change Periode Options
Edit filter buttons di dashboard_operasional.php (line ~1100)

### Add New Tool Box
Copy-paste tool-box div dan update link + icon

### Customize Summary Cards
Edit summary section styling (line ~850)

---

## 🚨 Common Issues & Solutions

### Issue: Dashboard blank after login
**Solution**: Check if `dashboard_type` is set in session
```php
echo $this->session->userdata('dashboard_type');
```

### Issue: Transactions not showing
**Solution**: Check if user has transactions in database
```sql
SELECT * FROM pencatatan_keuangan WHERE id_user = 1;
```

### Issue: Charts not loading
**Solution**: Check if Chart.js library is loaded
```javascript
console.log(typeof Chart);
```

### Issue: Modal not appearing
**Solution**: Check if modal-overlay is not hidden by CSS
```css
.modal-overlay.active { display: flex; }
```

---

## 📈 Performance Tips

1. Cache Dashboard Model queries for frequently accessed users
2. Use pagination for large transaction lists
3. Lazy load charts only when section is visible
4. Minify CSS/JS for production

---

## 🔐 Security Checklist

- [ ] Validate all user inputs
- [ ] Use prepared statements (CodeIgniter query builder)
- [ ] Check session before accessing protected pages
- [ ] Hash passwords with bcrypt
- [ ] Validate user role/permission
- [ ] CSRF token enabled
- [ ] Escape output with htmlspecialchars()

---

## 📞 Controller Files Reference

| Controller | Purpose | Key Methods |
|-----------|---------|------------|
| Auth.php | Authentication | login, register, logout, dashboard, set_dashboard_type |
| Keuangan.php | Financial Management | index, create, edit, delete |
| Hpp.php | HPP Calculator | index |
| Risiko.php | Risk Management | index |
| Analisis.php | Product Analysis | index |
| Advisor.php | AI Advisor | index |

---

## 🎓 Learning Resources

- CodeIgniter 3 Documentation: https://codeigniter.com/user_guide/
- Chart.js Documentation: https://www.chartjs.org/docs/latest/
- CSS Gradient: https://cssgradient.io/
- Responsive Design: https://developer.mozilla.org/en-US/docs/Learn/CSS/CSS_layout/Responsive_Design

---

**Created**: January 4, 2026
**Version**: 1.0
