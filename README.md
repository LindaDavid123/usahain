# Usahain

## Dashboard Endpoint (Official)

Per April 2026, endpoint dashboard resmi hanya:

- `auth/dashboard`

Endpoint lama seperti di bawah ini sudah tidak digunakan dan dapat menghasilkan 404:

- `dashboard`
- `dashboard/operasional`
- `dashboard/perencanaan`
- `auth/dashboard_operasional`
- `auth/dashboard_selection`
- `auth/dashboard_planning`
- `auth/change_dashboard`
- `auth/set_dashboard_type/*`

### Catatan untuk Tim

- Gunakan hanya `site_url('auth/dashboard')` untuk link "Kembali ke Dashboard" di seluruh view.
- Untuk redirect setelah login atau selesai aksi fitur, arahkan ke `auth/dashboard`.

## Changelog

Gunakan format berikut untuk update berikutnya:

- `Added`: fitur baru atau file baru.
- `Changed`: perubahan perilaku, refactor, atau penyesuaian alur.
- `Removed`: endpoint, file, atau fitur yang dihapus.

### 2026-04-14

#### Added

- Dokumentasi endpoint dashboard resmi di README.

#### Changed

- Menyatukan akses dashboard ke satu endpoint resmi: `auth/dashboard`.
- Menormalkan tautan dashboard di view ke `site_url('auth/dashboard')`.

#### Removed

- Endpoint legacy dashboard dari controller dan route agar URL lama tidak dipakai.
- View dashboard lama yang tidak terpakai (`dashboard_planning` dan `dashboard_selection`).
