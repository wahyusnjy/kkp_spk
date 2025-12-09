`   🚀 Aplikasi Sistem Pendukung Keputusan (SPK) - Metode TOPSIS📋 Tentang AplikasiAplikasi Sistem Pendukung Keputusan (SPK) berbasis web yang mengimplementasikan metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution). Aplikasi ini dirancang untuk membantu proses seleksi dan perankingan supplier secara objektif dan terstruktur. Dibangun menggunakan Laravel dan menampilkan antarmuka pengguna yang modern dan fungsional.🎯 Fitur Utama1. ⚙️ Manajemen Data MasterKriteria: Mengelola parameter penilaian supplier, termasuk penentuan jenis (benefit/cost) dan bobot kriteria.Supplier: Manajemen data dasar dari semua supplier yang akan dievaluasi.Material: Pengelolaan data material atau barang yang menjadi fokus penilaian.Pengguna: Manajemen user lengkap dengan sistem autentikasi dan role-based access.2. 📝 Proses Assessment (Penilaian)Buat Assessment: Pembuatan sesi penilaian baru untuk material atau periode tertentu.Input Nilai: Memungkinkan penginputan nilai supplier untuk setiap kriteria.Multi-Supplier: Fitur untuk memasukkan nilai untuk banyak supplier sekaligus.Edit Assessment: Perubahan data dan nilai pada penilaian yang sudah ada.Save as Draft: Menyimpan penilaian sementara sebelum proses perhitungan lengkap.3. 📊 Perhitungan TOPSISProses Otomatis: Perhitungan ranking supplier dilakukan secara otomatis menggunakan algoritma TOPSIS.Detail Perhitungan: Menampilkan langkah-demi-langkah perhitungan TOPSIS untuk transparansi.Visualisasi: Penggunaan grafik dan progress bar untuk memvisualisasikan hasil perhitungan.Analisis Per Supplier: Detail perhitungan spesifik untuk setiap supplier.4. 📄 Laporan & ExportHasil Ranking: Tampilan ringkas dari hasil perankingan supplier berdasarkan nilai preferensi (Ci).Export Excel: Mengizinkan ekspor data hasil dan riwayat ke format Microsoft Excel.Export PDF: Membuat laporan hasil perankingan dalam format PDF.Histori Analisis: Menyimpan dan menampilkan riwayat dari semua perhitungan TOPSIS yang pernah dilakukan.5. 🛡️ Keamanan & ManajemenAutentikasi: Sistem login yang aman menggunakan Laravel Fortify.Multi-User: Mendukung banyak pengguna dengan level akses yang berbeda (Admin, Manager, User).Manajemen Profil: Pengguna dapat memperbarui informasi profil dan kata sandi.Two-Factor Auth: Opsi autentikasi dua faktor untuk keamanan tambahan.🏗️ Arsitektur TeknisTech StackBackend: Laravel 12, PHP 8.2+Frontend: Blade Templates, Tailwind CSS, JavaScriptDatabase: MySQL / MariaDBAutentikasi: Laravel FortifyUI Components: Font AwesomeStruktur Database (Tabel Utama)users (Pengguna sistem)kriteria (Parameter penilaian)suppliers (Data supplier)materials (Data material)assessments (Header penilaian)assessment_scores (Nilai per kriteria)topsis_results (Hasil perhitungan TOPSIS)🚀 Instalasi & KonfigurasiPrasyaratPHP 8.1 atau lebih tinggiComposerMySQL 5.7+ / MariaDB 10.3+Node.js & NPM (untuk kompilasi aset frontend)Langkah InstalasiClone Repository: Gunakan perintah git clone [repository-url] diikuti dengan cd spk-topsis.Install Dependencies: Jalankan composer install dan npm install. Setelah itu, kompilasi aset frontend dengan npm run build.Konfigurasi Environment: Salin file konfigurasi dengan cp .env.example .env, lalu buat application key dengan php artisan key:generate.Konfigurasi Database: Edit file .env untuk mengatur koneksi database Anda, termasuk DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, dan DB_PASSWORD.Migrasi Database: Jalankan migrasi database dan seeder awal dengan php artisan migrate --seed.Jalankan Aplikasi: Mulai development server dengan php artisan serve.📊 Flow Penggunaan1. Setup AwalLogin sebagai Admin.Setup kriteria penilaian (jenis kriteria, bobot).Input data supplier.Input data material.2. Proses AssessmentBuat assessment baru untuk material tertentu.Pilih supplier yang akan dinilai.Input nilai untuk setiap kriteria.Simpan assessment.3. Proses TOPSISPilih assessment yang sudah lengkap.Klik "Proses TOPSIS".Sistem akan menghitung ranking secara otomatis.Lihat hasil perankingan.4. Analisis HasilReview ranking supplier.Lihat detail perhitungan.Export hasil ke Excel/PDF.Buat keputusan berdasarkan hasil analisis.🔧 API Endpoints (Gambaran Umum)Manajemen DataKriteria: Endpoint untuk List, Tambah, Edit, Update, dan Hapus kriteria (/kriteria).Supplier: Endpoint untuk List, Tambah, Edit, Update, dan Hapus data supplier (/suppliers).Material: Endpoint untuk List, Tambah, Edit, Update, dan Hapus data material (/materials).Users: Endpoint untuk List, Tambah, Edit, Update, dan Hapus pengguna sistem (/users).Assessment & TOPSISAssessments: Endpoint untuk List, Buat, Detail, Edit, Update, dan Hapus assessment (/assessments).Input Nilai: Endpoint untuk Form input nilai dan Simpan nilai (/assessments/{id}/scores).Proses TOPSIS: Endpoint untuk menjalankan perhitungan TOPSIS (/assessments/{id}/calculate).Results & ReportsResults: Endpoint untuk List hasil, Detail hasil perankingan, Detail perhitungan per supplier, dan Export hasil (/results).Reports: Endpoint untuk Laporan supplier, Laporan assessment, dan Export PDF/Excel hasil laporan (/reports).History: Endpoint untuk melihat Histori analisis (/history).User ManagementSettings: Endpoint untuk Edit profil, Ganti password, Pengaturan tampilan, dan Two-factor authentication (/settings).📁 Struktur Proyek (Ringkasan)spk-topsis/app/: Berisi logika utama aplikasi:Http/Controllers/: Pengendali untuk Assessment, Dashboard, Kriteria, Material, Report, Supplier, TopsisResult, dan User.Http/Services/: Logika perhitungan inti TOPSIS (TopsisService.php).Models/: Model Eloquent untuk Assessment, AssessmentScore, Kriteria, Material, Supplier, Topsis_Result, dan User.View/Components/database/: File migrasi dan seeder.resources/: File view (Blade Templates), CSS, dan JavaScript.routes/: Definisi rute web (web.php).public/: File publik yang dapat diakses.config/: File konfigurasi.🔐 KeamananFitur KeamananAutentikasi Lengkap: Disediakan oleh Laravel Fortify.Password Hashing: Menggunakan Bcrypt untuk keamanan kata sandi.CSRF Protection: Perlindungan dari Cross-Site Request Forgery.XSS Protection: Input sanitization dan output escaping.SQL Injection Protection: Penggunaan Eloquent ORM dengan parameter binding.Session Management: Penanganan sesi yang aman.Role & Permission (Hak Akses)Admin: Akses penuh ke semua fitur dan manajemen data.Manager: Akses untuk proses assessment dan pembuatan laporan.User: Akses terbatas, umumnya hanya untuk melihat hasil dan riwayat.📈 Metode TOPSIS (Detail Perhitungan)Langkah PerhitunganMatriks Keputusan: Kumpulkan nilai untuk setiap supplier pada setiap kriteria.Normalisasi: Normalisasi matriks keputusan.Pembobotan: Kalikan matriks ternormalisasi dengan bobot kriteria.Solusi Ideal: Tentukan solusi ideal positif ($A^+$) dan negatif ($A^-$).Jarak Euclidean: Hitung jarak Euclidean ke solusi ideal positif ($D^+$) dan negatif ($D^-$).Nilai Preferensi: Hitung nilai preferensi ($C_i$) untuk setiap alternatif.Ranking: Urutkan supplier berdasarkan nilai preferensi ($C_i$) tertinggi.Rumus Utama (Notasi Matematis)Normalisasi: $r_{ij} = x_{ij} / \sqrt{\sum x_{ij}^2}$Pembobotan: $v_{ij} = w_j \times r_{ij}$Solusi Ideal:$A^+ = (\max v_{ij} \text{ jika benefit, } \min v_{ij} \text{ jika cost})$$A^- = (\min v_{ij} \text{ jika benefit, } \max v_{ij} \text{ jika cost})$Jarak Euclidean:$D^+ = \sqrt{\sum(v_{ij} - A^+)^2}$$D^- = \sqrt{\sum(v_{ij} - A^-)^2}$Nilai Preferensi: $C_i = D^- / (D^+ + D^-)$🎨 UI/UX FeaturesDashboardStatistik ringkasan penting.Quick actions untuk navigasi cepat.Informasi aktivitas terbaru (recent activities).Form InputMulti-step forms untuk proses panjang.Validasi real-time.Fitur auto-save draft.Indikator progres (progress indicators).Visualisasi DataProgress bars untuk menunjukkan nilai/skor.Charts untuk perbandingan hasil.Status yang diberi kode warna (color-coded status).Tabel yang responsif (responsive tables).Modal & PopupsMenampilkan detail perhitungan TOPSIS.Konfirmasi sebelum tindakan penting (actions).Pesan error/success yang informatif.🛠️ DevelopmentLocal DevelopmentDevelopment server: php artisan serveWatch assets (Tailwind/JS): npm run devRun tests: php artisan testClear cache: php artisan optimize:clearProduction DeploymentOptimize untuk production: php artisan config:cache, php artisan route:cache, php artisan view:cacheCompile assets: npm run buildRun migrations: php artisan migrate --forceEnvironment Variables Penting (Contoh)APP_NAME="SPK TOPSIS"APP_ENV=productionAPP_DEBUG=falseAPP_URL=https://your-domain.comKonfigurasi Database (DB_CONNECTION, DB_HOST, DB_DATABASE, dll.).Konfigurasi Email SMTP (MAIL_MAILER, MAIL_HOST, MAIL_USERNAME, dll.).📝 TestingTest CoverageUnit tests untuk models.Feature tests untuk controllers.Browser tests untuk UI.API tests untuk endpoints.Running TestsRun all tests: php artisan testRun specific test: php artisan test --filter AssessmentTestTest with coverage report: php artisan test --coverage🤝 KontribusiGuidelinesFork repository.Buat feature branch baru.Commit perubahan dengan pesan yang deskriptif.Push ke branch Anda.Buat Pull Request (PR).Coding StandardsMengikuti standar PSR-12.Menulis pesan commit yang jelas.Menambahkan komentar untuk logika yang kompleks.Memperbarui dokumentasi jika diperlukan.📄 LicenseAplikasi ini dilisensikan di bawah MIT License.📞 SupportUntuk dukungan teknis atau pertanyaan:Email: support@your-domain.comIssue Tracker: GitHub IssuesDocumentation: Wiki🙏 CreditsFramework: LaravelUI Framework: Tailwind CSSIcons: Font AwesomeCharts: Chart.js (opsional)Development Team: [Nama Tim]Versi: 1.0.0Terakhir Diperbarui: 2024Status: Production Ready   `

### Default Credentials

*   **Email**: admin@example.com
    
*   **Password**: password
    

📊 Database Schema
------------------

### Main Tables

```text
users                # System users  kriteria             # Evaluation criteria  suppliers            # Supplier data  materials            # Material data  assessments          # Assessment headers  assessment_scores    # Scores for each criteria  topsis_results       # TOPSIS calculation results   
```

### Relationships

*   Assessment has many AssessmentScore
    
*   Assessment has many Topsis\_Result
    
*   Supplier has many AssessmentScore
    
*   Kriteria has many AssessmentScore
    

🛣️ Application Flow
--------------------

### 1\. Setup Phase

1.  Add criteria with weights and types (benefit/cost)
    
2.  Register suppliers with contact information
    
3.  Define materials for evaluation
    

### 2\. Assessment Phase

1.  Create new assessment for specific material
    
2.  Select suppliers to evaluate
    
3.  Input scores for each criteria (0-100)
    
4.  Save or submit assessment
    

### 3\. Calculation Phase

1.  Run TOPSIS calculation from assessment detail
    
2.  System processes:
    
    *   Decision matrix creation
        
    *   Normalization
        
    *   Weighted normalization
        
    *   Ideal solution determination
        
    *   Distance calculation
        
    *   Preference score calculation
        
3.  View ranking results
    

### 4\. Analysis Phase

1.  Review supplier rankings
    
2.  View detailed calculation steps
    
3.  Export results to Excel/PDF
    
4.  Make procurement decisions
    

🔌 API Endpoints
----------------

### Authentication & User Management

text

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   GET     /dashboard                     # Dashboard  GET     /settings/profile              # User profile  GET     /settings/password             # Change password  GET     /settings/two-factor           # 2FA settings   `

### Master Data Management

text

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   # Kriteria  GET     /kriteria                      # List criteria  GET     /kriteria/create               # Create form  POST    /kriteria/store                # Store criteria  GET     /kriteria/edit/{id}            # Edit form  POST    /kriteria/update/{id}          # Update criteria  DELETE  /kriteria/delete/{id}          # Delete criteria  # Suppliers  GET     /suppliers                     # List suppliers  GET     /suppliers/create              # Create form  POST    /suppliers/store               # Store supplier  GET     /suppliers/edit/{id}           # Edit form  POST    /suppliers/update/{id}         # Update supplier  DELETE  /suppliers/delete/{id}         # Delete supplier  # Materials  GET     /materials                     # List materials  GET     /materials/create              # Create form  POST    /materials/store               # Store material  GET     /materials/edit/{id}           # Edit form  POST    /materials/update/{id}         # Update material  DELETE  /materials/delete/{id}         # Delete material  # Users  GET     /users                         # List users  GET     /users/create                  # Create form  POST    /users/store                   # Store user  GET     /users/edit/{id}               # Edit form  POST    /users/update/{id}             # Update user  DELETE  /users/delete/{id}             # Delete user   `

### Assessment System

text

`   # Assessments  GET     /assessments                   # List assessments  GET     /assessments/create            # Create form  POST    /assessments/store             # Store assessment  GET     /assessments/{id}              # Show assessment  GET     /assessments/edit/{id}         # Edit form  POST    /assessments/update/{id}       # Update assessment  POST    /assessments/delete/{id}       # Delete assessment  # Score Management  GET     /assessments/{id}/scores       # Input scores form  POST    /assessments/{id}/scores/save  # Save scores  # TOPSIS Calculation  POST    /assessments/{id}/calculate    # Run TOPSIS calculation   `

### Results & Reports

`   # TOPSIS Results  GET     /results                       # All results  GET     /results/{id}                  # Specific result  GET     /results/{id}/export           # Export result  # Detailed Calculations  GET     /results/{id}/supplier/{supplier}/calculation  # Per-supplier calculation  # Reports  GET     /reports/suppliers             # Supplier reports  GET     /reports/assessments           # Assessment reports  GET     /reports/export/suppliers-pdf  # Export suppliers PDF  GET     /reports/export/suppliers-excel # Export suppliers Excel  GET     /reports/export/results-pdf/{id} # Export results PDF  GET     /reports/export/results-excel/{id} # Export results Excel  # History  GET     /history/{assessment_id?}      # Analysis history   `

🧮 TOPSIS Algorithm
-------------------

### Step-by-Step Calculation

1.  textX = \[x\_ij\] where i = supplier, j = criteria
    
2.  textr\_ij = x\_ij / sqrt(∑(x\_ij)²)
    
3.  textv\_ij = w\_j \* r\_ijwhere w\_j = criteria weight
    
4.  textA+ = {max(v\_ij) if benefit, min(v\_ij) if cost}A- = {min(v\_ij) if benefit, max(v\_ij) if cost}
    
5.  textD+\_i = sqrt(∑(v\_ij - A+\_j)²)D- \_i = sqrt(∑(v\_ij - A-\_j)²)
    
6.  textC\_i = D-\_i / (D+\_i + D-\_i)
    
7.  textRank suppliers by C\_i (higher is better)
    

🎨 UI Components
----------------

### Form Features

*   **Multi-step forms** for assessment creation
    
*   **Real-time validation** with visual feedback
    
*   **Auto-save draft** functionality
    
*   **Dynamic field addition/removal**
    
*   **Progress indicators**
    

### Data Display

*   **Responsive tables** with sorting
    
*   **Progress bars** for scores
    
*   **Color-coded status badges**
    
*   **Interactive charts** (if implemented)
    
*   **Modal windows** for details
    

### User Interface

*   **Dark theme** by default
    
*   **Card-based layout**
    
*   **Sidebar navigation**
    
*   **Toast notifications**
    
*   **Loading states**
    

🔐 Security Features
--------------------

### Authentication

*   Laravel Fortify implementation
    
*   Email/password authentication
    
*   Optional two-factor authentication
    
*   Password confirmation for sensitive actions
    

### Authorization

*   Middleware protection on routes
    
*   CSRF token protection
    
*   XSS prevention through Blade templating
    
*   SQL injection prevention via Eloquent ORM
    

### Data Protection

*   Password hashing with bcrypt
    
*   Secure session management
    
*   Input validation and sanitization
    
*   File upload security
    

📁 Project Structure
--------------------
`   spk-topsis/  ├── app/  │   ├── Http/  │   │   ├── Controllers/          # All controllers  │   │   │   ├── AssessmentController.php  │   │   │   ├── KriteriaController.php  │   │   │   ├── SupplierController.php  │   │   │   ├── MaterialController.php  │   │   │   ├── TopsisResultController.php  │   │   │   ├── UserController.php  │   │   │   ├── ReportController.php  │   │   │   └── DashboardController.php  │   │   └── Services/  │   │       └── TopsisService.php # TOPSIS calculation service  │   ├── Models/                   # Eloquent models  │   │   ├── User.php  │   │   ├── Kriteria.php  │   │   ├── Supplier.php  │   │   ├── Material.php  │   │   ├── Assessment.php  │   │   ├── AssessmentScore.php  │   │   └── Topsis_Result.php  │   └── View/Components/          # Blade components  ├── database/  │   ├── migrations/               # Database migrations  │   └── seeders/                  # Database seeders  ├── resources/  │   ├── views/                    # Blade templates  │   │   ├── layouts/              # Layout files  │   │   ├── assessments/          # Assessment views  │   │   ├── kriteria/             # Criteria views  │   │   ├── suppliers/            # Supplier views  │   │   ├── materials/            # Material views  │   │   ├── pages/                # Page views  │   │   ├── users/                # User views  │   │   └── components/           # Reusable components  │   └── css/                      # Custom CSS  ├── routes/  │   └── web.php                   # Application routes  ├── public/                       # Public assets  ├── config/                       # Configuration files  ├── storage/                      # Storage directory  └── tests/                        # Test files   `

🧪 Testing
----------

### Running Tests

`   # Run all tests  php artisan test  # Run specific test file  php artisan test --filter AssessmentTest  # Run with coverage  php artisan test --coverage-html coverage/   `

### Test Types

*   **Unit Tests** - Model and service tests
    
*   **Feature Tests** - Controller and route tests
    
*   **Browser Tests** - UI interaction tests
    

📦 Deployment
-------------

### Production Checklist

1.  Update .env file for production
    
2.  Set APP\_DEBUG=false
    
3.  Configure proper database credentials
    
4.  Set up email configuration
    
5.  Configure proper storage links
    

### Optimization Commands

`   # Cache configurations  php artisan config:cache  # Cache routes  php artisan route:cache  # Cache views  php artisan view:cache  # Clear all caches  php artisan optimize:clear  # Compile assets for production  npm run build   `

### Environment Variables

env
`   APP_NAME="SPK TOPSIS"  APP_ENV=production  APP_DEBUG=false  APP_URL=https://yourdomain.com  DB_CONNECTION=mysql  DB_HOST=127.0.0.1  DB_PORT=3306  DB_DATABASE=spk_topsis  DB_USERNAME=username  DB_PASSWORD=securepassword  MAIL_MAILER=smtp  MAIL_HOST=smtp.gmail.com  MAIL_PORT=587  MAIL_USERNAME=email@gmail.com  MAIL_PASSWORD=password  MAIL_ENCRYPTION=tls   `

🐛 Troubleshooting
------------------

### Common Issues

1.  bashphp artisan migrate:refresh --seed
    
2.  bashchmod -R 755 storage bootstrap/cache
    
3.  bashnpm install && npm run build
    
4.  bashphp artisan cache:clearphp artisan config:clearphp artisan route:clearphp artisan view:clear
    

### Debug Mode

For development, enable debug mode:

env
`   APP_DEBUG=true   `

🤝 Contributing
---------------

### Development Workflow

1.  Fork the repository
    
2.  Create a feature branch
    
3.  Make your changes
    
4.  Write/update tests
    
5.  Submit a pull request
    

### Code Standards

*   Follow PSR-12 coding standards
    
*   Write clear commit messages
    
*   Add comments for complex logic
    
*   Update documentation as needed
    

📄 License
----------

MIT License - See LICENSE file for details.

📞 Support
----------

*   **Issues**: GitHub Issues tracker
    
*   **Email**: support@yourdomain.com
    
*   **Documentation**: Project Wiki
    

**Version**: 1.0.0**Last Updated**: 2024**Status**: Production Ready