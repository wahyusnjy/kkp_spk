# SPK TOPSIS - Sistem Pendukung Keputusan Pemilihan Supplier

## Gambaran Umum

Sistem pendukung keputusan berbasis web yang mengimplementasikan metode TOPSIS untuk pemilihan dan perankingan supplier.

## Fitur Utama

 Manajemen Data Supplier - CRUD untuk data supplier

 Manajemen Kriteria - Parameter penilaian dengan bobot

 Manajemen Material - Data material untuk penilaian

 Sistem Assessment - Buat dan kelola penilaian supplier

 Perhitungan TOPSIS - Perankingan otomatis menggunakan algoritma TOPSIS

 Visualisasi Hasil - Langkah perhitungan detail dan hasil

 Generate Laporan - Export ke Excel dan PDF

 Manajemen Pengguna - Sistem multi-user dengan autentikasi

 Dashboard - Ringkasan statistik sistem

## Instalasi Cepat

### Prasyarat

 PHP 8.1+

 Composer

 MySQL 5.7+

 Node.js 16+

### Langkah Instalasi

1. Clone repository

2. Install dependencies dengan Composer dan NPM

3. Konfigurasi environment

4. Setup database di file .env

5. Jalankan migrasi database

6. Start server development

### Kredensial Default

 Email: admin@example.com

 Password: password

## Skema Database

### Tabel Utama

 users - Pengguna sistem

 kriteria - Kriteria penilaian

 suppliers - Data supplier

 materials - Data material

 assessments - Header penilaian

 assessment_scores - Nilai per kriteria

 topsis_results - Hasil perhitungan TOPSIS

## Alur Aplikasi

### 1. Fase Setup

1. Tambah kriteria dengan bobot dan jenis (benefit/cost)

2. Daftarkan supplier dengan informasi kontak

3. Definisikan material untuk evaluasi

### 2. Fase Assessment

1. Buat assessment baru untuk material tertentu

2. Pilih supplier untuk dinilai

3. Input nilai untuk setiap kriteria (0-100)

4. Simpan atau submit assessment

### 3. Fase Perhitungan

1. Jalankan perhitungan TOPSIS dari detail assessment

2. Sistem memproses:

 Pembuatan matriks keputusan

 Normalisasi

 Normalisasi terbobot

 Penentuan solusi ideal

 Perhitungan jarak

 Perhitungan nilai preferensi

3. Lihat hasil ranking

### 4. Fase Analisis

1. Review ranking supplier

2. Lihat detail langkah perhitungan

3. Export hasil ke Excel/PDF

4. Buat keputusan pengadaan

## Endpoint API

### Autentikasi & Manajemen User

 /dashboard - Dashboard

 /settings/profile - Profil user

 /settings/password - Ganti password

 /settings/two-factor - Pengaturan 2FA

### Manajemen Data Master

**Kriteria:**

 GET /kriteria - List kriteria

 POST /kriteria/store - Simpan kriteria

 DELETE /kriteria/delete/{id} - Hapus kriteria

**Supplier:**

 GET /suppliers - List supplier

 POST /suppliers/store - Simpan supplier

 DELETE /suppliers/delete/{id} - Hapus supplier

**Material:**

 GET /materials - List material

 POST /materials/store - Simpan material

 DELETE /materials/delete/{id} - Hapus material

**Users:**

 GET /users - List users

 POST /users/store - Simpan user

 DELETE /users/delete/{id} - Hapus user

### Sistem Assessment

**Assessments:**

 GET /assessments - List assessments

 POST /assessments/store - Simpan assessment

 GET /assessments/{id} - Show assessment

 POST /assessments/update/{id} - Update assessment

**Score Management:**

 GET /assessments/{id}/scores - Form input nilai

 POST /assessments/{id}/scores/save - Simpan nilai

**TOPSIS Calculation:**

 POST /assessments/{id}/calculate - Jalankan perhitungan TOPSIS

### Results & Reports

**TOPSIS Results:**

 GET /results - Semua hasil

 GET /results/{id} - Hasil spesifik

 GET /results/{id}/export - Export hasil

**Detailed Calculations:**

 GET /results/{id}/supplier/{supplier}/calculation - Perhitungan per supplier

**Reports:**

 GET /reports/suppliers - Laporan supplier

 GET /reports/assessments - Laporan assessments

 GET /reports/export/suppliers-pdf - Export suppliers PDF

 GET /reports/export/suppliers-excel - Export suppliers Excel

**History:**

 GET /history/{assessment_id?} - Histori analisis

## Algoritma TOPSIS

### Langkah Perhitungan

1. Matriks Keputusan (X)

X = \[x_ij\] dimana i = supplier, j = kriteria

2. Matriks Ternormalisasi (R)

r_ij = x_ij / sqrt(∑(x_ij)²)

3. Matriks Ternormalisasi Terbobot (V)

v_ij = w_j * r_ij

dimana w_j = bobot kriteria

4. Solusi Ideal

A+ = {max(v_ij) jika benefit, min(v_ij) jika cost}

A- = {min(v_ij) jika benefit, max(v_ij) jika cost}

5. Ukuran Pemisahan

D+_i = sqrt(∑(v_ij - A+_j)²)

D-_i = sqrt(∑(v_ij - A-_j)²)

6. Kedekatan Relatif

C_i = D-_i / (D+_i + D-_i)

7. Ranking

Ranking supplier berdasarkan C_i (lebih tinggi lebih baik)

## Komponen UI

### Fitur Form

 Form multi-step untuk pembuatan assessment

 Validasi real-time dengan feedback visual

 Fungsi auto-save draft

 Penambahan/penghapusan field dinamis

 Indikator progress

### Display Data

 Tabel responsif dengan sorting

 Progress bars untuk nilai

 Badge status dengan warna

 Modal windows untuk detail

### User Interface

 Tema dark secara default

 Layout berbasis card

 Navigasi sidebar

 Notifikasi toast

 Loading states

## Fitur Keamanan

### Autentikasi

 Implementasi Laravel Fortify

 Autentikasi email/password

 Opsional two-factor authentication

 Konfirmasi password untuk aksi sensitif

### Authorisasi

 Proteksi middleware pada routes

 Proteksi CSRF token

 Pencegahan XSS melalui Blade templating

 Pencegahan SQL injection via Eloquent ORM

### Proteksi Data

 Hashing password dengan bcrypt

 Manajemen session yang aman

 Validasi dan sanitasi input

 Keamanan file upload

## Struktur Proyek

```
spk-topsis/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # All controllers
│   │   │   ├── AssessmentController.php
│   │   │   ├── KriteriaController.php
│   │   │   ├── SupplierController.php
│   │   │   ├── MaterialController.php
│   │   │   ├── TopsisResultController.php
│   │   │   ├── UserController.php
│   │   │   ├── ReportController.php
│   │   │   └── DashboardController.php
│   │   └── Services/
│   │       └── TopsisService.php # TOPSIS calculation service
│   ├── Models/                   # Eloquent models
│   │   ├── User.php
│   │   ├── Kriteria.php
│   │   ├── Supplier.php
│   │   ├── Material.php
│   │   ├── Assessment.php
│   │   ├── AssessmentScore.php
│   │   └── Topsis_Result.php
│   └── View/Components/          # Blade components
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── resources/
│   ├── views/                    # Blade templates
│   │   ├── layouts/              # Layout files
│   │   ├── assessments/          # Assessment views
│   │   ├── kriteria/             # Criteria views
│   │   ├── suppliers/            # Supplier views
│   │   ├── materials/            # Material views
│   │   ├── pages/                # Page views
│   │   ├── users/                # User views
│   │   └── components/           # Reusable components
│   └── css/                      # Custom CSS
├── routes/
│   └── web.php                   # Application routes
├── public/                       # Public assets
├── config/                       # Configuration files
├── storage/                      # Storage directory
└── tests/                        # Test files
```

## Testing

### Menjalankan Test
```
 php artisan test - Jalankan semua test

 php artisan test --filter AssessmentTest - Test spesifik

 php artisan test --coverage-html coverage/ - Dengan coverage
```

### Jenis Test
```
 Unit Tests - Test model dan service

 Feature Tests - Test controller dan route

 Browser Tests - Test interaksi UI
 ```

## Deployment

### Checklist Production

```
1. Update file .env untuk production

2. Set APP_DEBUG=false

3. Konfigurasi kredensial database yang benar

4. Setup konfigurasi email

5. Konfigurasi storage links
```


### Perintah Optimasi

```
 php artisan config:cache - Cache konfigurasi

 php artisan route:cache - Cache routes

 php artisan view:cache - Cache views

 php artisan optimize:clear - Clear semua cache

 npm run build - Compile assets untuk production
```


### Environment Variables
```
APP_NAME="SPK TOPSIS"

APP_ENV=production

APP_DEBUG=false

APP_URL=https://yourdomain.com

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=spk_topsis

DB_USERNAME=username

DB_PASSWORD=securepassword
```

## Troubleshooting

### Masalah Umum
```
1. Error Migrasi

php artisan migrate:refresh --seed

2. Masalah Permission

chmod -R 755 storage bootstrap/cache

3. Kompilasi Asset

npm install && npm run build

4. Masalah Cache

php artisan cache:clear

php artisan config:clear

php artisan route:clear

php artisan view:clear
```

### Debug Mode

```
Untuk development, enable debug mode:

APP_DEBUG=true

```
## Kontribusi

### Workflow Development
```
1. Fork repository

2. Buat feature branch

3. Buat perubahan

4. Tulis/update tests

5. Submit pull request
```
### Standar Kode
```
 Ikuti standar koding PSR-12

 Tulis commit message yang jelas

 Tambahkan komentar untuk logika kompleks

 Update dokumentasi jika diperlukan
```
## License
```
MIT License - Lihat file LICENSE untuk detail.
```
## Support
 Issues: GitHub Issues tracker

 Email: support@yourdomain.com

 Dokumentasi: Project Wiki

Versi: 1.0.0

Terakhir Diupdate: 2024

Status: Production Ready
