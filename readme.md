# 📊 SPK TOPSIS - Sistem Pendukung Keputusan Pemilihan Supplier

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue?logo=php)
![License](https://img.shields.io/badge/License-MIT-green)
![Status](https://img.shields.io/badge/Status-Production%20Ready-success)

## 🎯 Gambaran Umum

Sistem Pendukung Keputusan berbasis web yang mengimplementasikan **metode TOPSIS** (Technique for Order of Preference by Similarity to Ideal Solution) untuk pemilihan dan perankingan supplier secara objektif dan sistematis.

Aplikasi ini dirancang untuk membantu perusahaan dalam mengambil keputusan pemilihan supplier berdasarkan multiple criteria dengan perhitungan matematis yang akurat.

---

## ✨ Fitur Utama

### 📋 Master Data Management
- **Manajemen Kriteria** - Parameter penilaian dengan bobot & tipe (Benefit/Cost)
- **Manajemen Supplier** - CRUD data supplier dengan import Excel
- **Manajemen Material** - Data material/produk untuk penilaian
- **Manajemen User** - Multi-user dengan role-based access (Admin & Manager)

### 🔍 Assessment & Evaluation
- **Sistem Assessment** - Buat dan kelola penilaian supplier
- **Input Nilai Dinamis** - Form interaktif untuk input nilai per kriteria
- **Multi-Supplier Evaluation** - Nilai multiple supplier dalam satu assessment
- **Auto-save Draft** - Simpan progress secara otomatis

### 🧮 TOPSIS Calculation
- **Perhitungan Otomatis** - 7 langkah TOPSIS calculation
- **Detail Calculation Steps** - Tampilkan semua matriks perantara
- **Real-time Ranking** - Update ranking supplier secara otomatis
- **Validation & Error Handling** - Validasi input & error messages yang jelas

### 📈 Reports & Analytics
- **Supplier Reports** - Laporan comprehensive data supplier
- **Assessment Reports** - Filter & export hasil penilaian
- **Detail Assessment Report** - Laporan lengkap dengan perhitungan TOPSIS (PDF & Excel)
- **Kriteria Report** - Statistik penggunaan kriteria
- **Executive Summary** - Dashboard-style report untuk management
- **Multiple Export Formats** - PDF (landscape/portrait) & Excel (multi-sheet)

### 👥 User Management & Access Control
- **Role-Based Access** - Admin (Full Access) & Manager (Read-Only + Reports)
- **Custom Dashboard** - Dashboard berbeda untuk setiap role
- **Menu Restrictions** - Menu dinamis berdasarkan role
- **Secure Authentication** - Laravel Fortify dengan 2FA support

### 🎨 User Interface
- **Modern Dark Theme** - Professional dark UI dengan gradients
- **Responsive Design** - Mobile-friendly interface
- **Interactive Components** - Dynamic forms, modals, tooltips
- **Real-time Search** - Server-side search di semua master data
- **Loading States** - Skeleton loaders & progress indicators
- **Toast Notifications** - SweetAlert2 untuk feedback

---

## 🚀 Instalasi Cepat

### Prasyarat

Pastikan sistem Anda memiliki:
- **PHP** 8.1 atau lebih tinggi
- **Composer** 2.x
- **MySQL** 5.7+ atau MariaDB
- **Node.js** 16+ & NPM
- **Git**

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/wahyusnjy/kkp_spk.git
cd kkp_spk

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure database di file .env
# Edit DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 7. Run migrations & seeders
php artisan migrate --seed

# 8. Create storage link
php artisan storage:link

# 9. Build assets
npm run build

# 10. Start development server
php artisan serve
# Dan di terminal terpisah:
npm run dev
```

### 🔐 Kredensial Default

Setelah seeding, gunakan kredensial berikut:

#### Admin Account:
- **Email:** `admin@example.com`
- **Password:** `password`
- **Role:** Admin (Full Access)

#### Manager Account:
- **Email:** `manager@example.com`
- **Password:** `password`
- **Role:** Manager (Read-Only + Reports)

> ⚠️ **PENTING:** Ubah password default setelah login pertama!

---

## 📊 Alur Kerja Aplikasi

### 1️⃣ Setup Awal (Admin Only)

```
┌─────────────────┐
│  Setup Kriteria │ → Tambah kriteria penilaian dengan:
└─────────────────┘   • Nama kriteria
                       • Bobot (total harus 1.0)
                       • Tipe (Benefit/Cost)
                       • Keterangan

┌─────────────────┐
│  Setup Supplier │ → Daftarkan supplier dengan:
└─────────────────┘   • Kode & nama supplier
                       • Alamat & kontak
                       • Kategori material
                       • Status (Aktif/Nonaktif)

┌─────────────────┐
│ Setup Material  │ → Definisikan material:
└─────────────────┘   • Nama material
                       • Jenis logam & grade
                       • Spesifikasi teknis
                       • Harga per kg
```

### 2️⃣ Proses Assessment (Admin Only)

```
┌────────────────────┐
│ Buat Assessment    │ → Pilih material & tahun
└────────────────────┘   Tambahkan deskripsi

┌────────────────────┐
│ Pilih Supplier     │ → Tentukan supplier yang akan dinilai
└────────────────────┘   (minimal 2 supplier)

┌────────────────────┐
│ Input Nilai        │ → Beri nilai untuk setiap kriteria
└────────────────────┘   Scale: 0-100

┌────────────────────┐
│ Hitung TOPSIS      │ → Jalankan perhitungan otomatis
└────────────────────┘   Lihat ranking hasil
```

### 3️⃣ Analisis & Reporting (Admin & Manager)

```
┌────────────────────┐
│ Lihat Hasil        │ → Review ranking supplier
└────────────────────┘   Lihat detail perhitungan

┌────────────────────┐
│ Export Report      │ → Download laporan:
└────────────────────┘   • Detailed Assessment (PDF/Excel)
                          • Executive Summary
                          • Kriteria Report
                          • Supplier Report
```

---

## 🧮 Metode TOPSIS

### Langkah Perhitungan

Sistem mengimplementasikan 7 langkah TOPSIS:

#### 1️⃣ Matriks Keputusan (Decision Matrix)
```
X = [xᵢⱼ] dimana i = supplier, j = kriteria
```
Matriks nilai asli dari assessment.

#### 2️⃣ Matriks Ternormalisasi (Normalized Matrix)
```
rᵢⱼ = xᵢⱼ / √(Σxᵢⱼ²)
```
Normalisasi menggunakan metode Euclidean.

#### 3️⃣ Matriks Ternormalisasi Terbobot (Weighted Matrix)
```
vᵢⱼ = wⱼ × rᵢⱼ
```
Dimana `wⱼ` adalah bobot kriteria.

#### 4️⃣ Solusi Ideal Positif & Negatif
```
A⁺ = {max(vᵢⱼ) jika Benefit, min(vᵢⱼ) jika Cost}
A⁻ = {min(vᵢⱼ) jika Benefit, max(vᵢⱼ) jika Cost}
```

#### 5️⃣ Perhitungan Jarak
```
D⁺ᵢ = √[Σ(vᵢⱼ - A⁺ⱼ)²]
D⁻ᵢ = √[Σ(vᵢⱼ - A⁻ⱼ)²]
```

#### 6️⃣ Nilai Preferensi (Preference Score)
```
Vᵢ = D⁻ᵢ / (D⁺ᵢ + D⁻ᵢ)
```
Range: 0-1 (semakin tinggi semakin baik)

#### 7️⃣ Ranking Final
Supplier diurutkan berdasarkan nilai preferensi `Vᵢ` tertinggi.

---

## 🗂️ Struktur Database

### Skema Utama

```sql
users
├── id
├── name
├── email
├── password
└── role (admin/manager)

kriteria
├── id
├── nama_kriteria
├── bobot
├── type (benefit/cost)
└── keterangan

suppliers
├── id
├── kode_supplier
├── nama_supplier
├── alamat
├── kontak
├── kategori_material
└── status

materials
├── id
├── supplier_id
├── nama_material
├── jenis_logam
├── grade
├── spesifikasi_teknis
└── harga_per_kg

assessments
├── id
├── material_id
├── tahun
├── deskripsi
└── timestamps

assessment_scores
├── id
├── assessment_id
├── supplier_id
├── kriteria_id
└── score

topsis_results
├── id
├── assessment_id
├── supplier_id
├── preference_score
├── rank
└── timestamps
```

---

## 🛣️ API Routes

### Authentication
```
GET  /           → Redirect to login
GET  /login      → Login page
POST /login      → Process login
POST /logout     → Logout
GET  /register   → Register page (optional)
```

### Dashboard
```
GET  /dashboard  → Role-based dashboard
                   - Admin: Full statistics
                   - Manager: Monitoring dashboard
```

### Master Data (Admin Only)
```
Kriteria:
  GET    /kriteria              → List kriteria
  GET    /kriteria/create       → Create form
  POST   /kriteria/store        → Save kriteria
  GET    /kriteria/edit/{id}    → Edit form
  POST   /kriteria/update/{id}  → Update kriteria
  DELETE /kriteria/delete/{id}  → Delete kriteria

Supplier:
  GET    /suppliers             → List supplier
  POST   /suppliers/store       → Save supplier
  POST   /suppliers/import      → Import Excel
  GET    /suppliers/download-template → Template Excel
  DELETE /suppliers/delete/{id} → Delete supplier

Material:
  GET    /materials             → List material
  POST   /materials/store       → Save material
  DELETE /materials/delete/{id} → Delete material

Users:
  GET    /users                 → List users
  POST   /users/store           → Create user
  DELETE /users/delete/{id}     → Delete user
```

### Assessment System (Admin Only)
```
GET  /assessments              → List assessments
GET  /assessments/create       → Create assessment
POST /assessments/store        → Save assessment
GET  /assessments/{id}         → View assessment detail
GET  /assessments/{id}/scores  → Input scores form
POST /assessments/{id}/scores/save → Save scores
POST /assessments/{id}/calculate   → Run TOPSIS calculation
```

### Reports (Admin & Manager)
```
GET /reports/suppliers         → Supplier report
GET /reports/assessments       → Assessment report
GET /reports/kriteria          → Kriteria report
GET /reports/executive-summary → Executive summary

Export:
GET /reports/assessments/{id}/export-detailed?format=pdf|excel
GET /reports/kriteria?format=pdf|excel
GET /reports/executive-summary?format=pdf|excel
GET /reports/export/suppliers-pdf
GET /reports/export/suppliers-excel
```

---

## 🎨 Tech Stack

### Backend
- **Framework:** Laravel 11.x
- **Language:** PHP 8.1+
- **Database:** MySQL 5.7+ / MariaDB
- **Authentication:** Laravel Fortify

### Frontend
- **Template Engine:** Blade
- **CSS Framework:** Tailwind CSS 3.x
- **UI Components:** Flux UI
- **JavaScript:** Vanilla JS + Alpine.js
- **Icons:** FontAwesome 6
- **Notifications:** SweetAlert2

### Libraries & Packages
- **PDF Generation:** barryvdh/laravel-dompdf
- **Excel Export:** maatwebsite/laravel-excel
- **Livewire:** Laravel Livewire 3.x

---

## 🔒 Keamanan

### Implementasi Keamanan

✅ **Authentication & Authorization**
- Laravel Fortify untuk autentikasi
- Role-based access control (Admin/Manager)
- Route middleware protection
- Session management yang aman

✅ **Input Security**
- CSRF token protection
- Input validation & sanitization
- XSS prevention via Blade templates
- SQL injection prevention via Eloquent ORM

✅ **Data Protection**
- Password hashing dengan bcrypt
- Secure session handling
- Environment variable untuk credentials
- File upload security

✅ **Route Protection**
```php
// Admin-only routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('suppliers', SupplierController::class);
    // ...
});

// Both admin & manager
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/reports/*', [ReportController::class]);
});
```

---

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter AssessmentTest

# With coverage
php artisan test --coverage
```

### Test Types
- **Unit Tests** - Model & Service logic
- **Feature Tests** - Controllers & Routes
- **Browser Tests** - UI interactions (Dusk)

---

## 🚢 Deployment

### Production Checklist

```bash
# 1. Update environment
cp .env.example .env
# Edit .env dengan kredensial production

# 2. Set production mode
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# 3. Install dependencies
composer install --optimize-autoloader --no-dev
npm install --production

# 4. Generate key
php artisan key:generate

# 5. Run migrations
php artisan migrate --force

# 6. Build assets
npm run build

# 7. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 8. Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Environment Variables (Production)
```env
APP_NAME="SPK TOPSIS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=secure_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
```

---

## 🐛 Troubleshooting

### Common Issues

**❌ Migration Error**
```bash
php artisan migrate:fresh --seed
```

**❌ Permission Denied**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**❌ Assets Not Loading**
```bash
npm install
npm run build
php artisan optimize:clear
```

**❌ Cache Issues**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

**❌ Storage Link Missing**
```bash
php artisan storage:link
```

---

## 📖 Documentation

### Additional Resources
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [TOPSIS Method](https://en.wikipedia.org/wiki/TOPSIS)

---

## 👨‍💻 Development

### Workflow
1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Write clear commit messages
- Add comments for complex logic
- Update documentation as needed
- Write tests for new features

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 🤝 Support

- **Issues:** [GitHub Issues](https://github.com/wahyusnjy/kkp_spk/issues)
- **Email:** support@yourdomain.com
- **Documentation:** [Project Wiki](https://github.com/wahyusnjy/kkp_spk/wiki)

---

## 📊 Version History

- **v1.0.0** (2024) - Initial Release
  - Core TOPSIS calculation
  - Master data management
  - Assessment system
  - Basic reporting

- **v1.1.0** (2025) - Feature Updates
  - Role-based access control
  - Enhanced reporting (5 report types)
  - Modern login UI
  - Executive summary
  - Kriteria report
  - Detail assessment export
  - Manager dashboard

---

## ✨ Credits

Developed with ❤️ for KKP (Kerja Praktik Kuliah)

**Developer:** Wahyusnjy  
**Repository:** [github.com/wahyusnjy/kkp_spk](https://github.com/wahyusnjy/kkp_spk)  
**Year:** 2024-2025

---

<div align="center">

**⭐ Star this repo if you find it useful!**

Made with [Laravel](https://laravel.com) & [Tailwind CSS](https://tailwindcss.com)

</div>
