    <?php

    use App\Http\Controllers\AssessmentController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\KriteriaController;
    use App\Http\Controllers\MaterialController;
    use App\Http\Controllers\ReportController;
    use App\Http\Controllers\SupplierController;
    use App\Http\Controllers\TopsisResultController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;
    use Laravel\Fortify\Features;
    use Livewire\Volt\Volt;
    // Redirect root to login
    Route::get('/', function () {
        return redirect()->route('login');
    })->name('home');

    // Dashboard - Different for Admin vs Manager
    Route::get('/dashboard',[DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    // 👤 MASTER DATA (Admin Only)
    Route::prefix('kriteria')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/', [KriteriaController::class, 'index'])->name('kriteria.index');
        Route::get('/create', [KriteriaController::class, 'create'])->name('kriteria.create');
        Route::post('/store', [KriteriaController::class, 'store'])->name('kriteria.store');
        Route::get('/edit/{id}', [KriteriaController::class, 'edit'])->name('kriteria.edit');
        Route::post('/update/{id}', [KriteriaController::class, 'update'])->name('kriteria.post');
        Route::delete('/delete/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');
    });

    Route::prefix('suppliers')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.index')->middleware(['auth', 'verified']);
        Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create')->middleware(['auth', 'verified']);
        Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store')->middleware(['auth', 'verified']);
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit')->middleware(['auth', 'verified']);
        Route::post('/update/{id}', [SupplierController::class, 'update'])->name('supplier.update')->middleware(['auth', 'verified']);
        Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy')->middleware(['auth', 'verified']);
        Route::get('/download-template', [SupplierController::class,'downloadTemplateImport'])->name('supplier.download-template')->middleware(['auth', 'index']);
        Route::post('/import', [SupplierController::class,'import'])->name('supplier.import')->middleware(['auth', 'verified']);
    });


    Route::prefix('materials')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('material.index')->middleware(['auth', 'verified']);
        Route::get('/create', [MaterialController::class, 'create'])->name('material.create')->middleware(['auth', 'verified']);
        Route::post('/store', [MaterialController::class, 'store'])->name('material.store')->middleware(['auth', 'verified']);
        Route::get('/edit/{id}', [MaterialController::class, 'edit'])->name('material.edit')->middleware(['auth', 'verified']);
        Route::post('/update/{id}', [MaterialController::class, 'update'])->name('material.update')->middleware(['auth', 'verified']);
        Route::delete('/delete/{id}', [MaterialController::class, 'destroy'])->name('material.destroy')->middleware(['auth', 'verified']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware(['auth', 'verified']);
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->middleware(['auth', 'verified']);
        Route::post('/store', [UserController::class, 'store'])->name('users.store')->middleware(['auth', 'verified']);
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit')->middleware(['auth', 'verified']);
        Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update')->middleware(['auth', 'verified']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(['auth', 'verified']);
    });


    Route::prefix('assessments')->group(function () {
        Route::get('/', [AssessmentController::class, 'index'])->name('assessments.index')->middleware(['auth', 'verified']);
        Route::get('/create', [AssessmentController::class, 'create'])->name('assessments.create')->middleware(['auth', 'verified']);
        Route::post('/store', [AssessmentController::class, 'store'])->name('assessments.store')->middleware(['auth', 'verified']);
        Route::get('/edit/{id}', [AssessmentController::class, 'edit'])->name('assessments.edit')->middleware(['auth', 'verified']);
        Route::post('/update/{id}', [AssessmentController::class, 'post'])->name('assessments.update')->middleware(['auth', 'verified']);
        Route::post('/delete/{id}', [AssessmentController::class, 'destroy'])->name('assessments.destroy')->middleware(['auth', 'verified']);
        // Detail assessment
        Route::get('/{id}', [AssessmentController::class, 'show'])->name('assessments.show')->middleware(['auth', 'verified']);
        
        // Input penilaian Supplier (sesuai dengan yang sudah ada)
        Route::get('/{id}/scores', [AssessmentController::class, 'scores'])->name('assessments.scores')->middleware(['auth', 'verified']);
        Route::post('/{id}/scores/save', [AssessmentController::class, 'saveScores'])->name('assessments.scores.save')->middleware(['auth', 'verified']);
        
        // Proses Topsis (sesuai dengan yang sudah ada)
        Route::post('/{id}/calculate', [AssessmentController::class, 'calculate'])->name('assessments.calculate')->middleware(['auth', 'verified']);

    });

    // End Supplier Rating

    // Ranking Supplier (sesuai dengan yang sudah ada)
    Route::prefix('results')->group(function () {
        Route::get('/', [TopsisResultController::class, 'index'])->name('results.index')->middleware(['auth', 'verified']);
        // Detail Perhitungan
        Route::get('/{id?}', [TopsisResultController::class, 'show'])->name('results.show')->middleware(['auth', 'verified']);
        Route::get('{id?}/supplier/{supplier?}/calculation', [TopsisResultController::class, 'supplierCalculation'])->name('results.supplier-calculation');

        Route::get('/{id}/export', [TopsisResultController::class, 'export'])->name('results.export')->middleware(['auth', 'verified']);
    });

    // Histori Analisis
    Route::get('/history/{assessment_id?}', [TopsisResultController::class, 'history'])->name('results.history')->middleware(['auth', 'verified']);


    // 📋 LAPORAN (Admin & Manager)
    Route::prefix('reports')->group(function () {
        // Laporan Supplier
        Route::prefix('suppliers')->group(function () {
            Route::get('/', [ReportController::class, 'suppliers'])->name('reports.suppliers');
            Route::get('/filter', [ReportController::class,'supplier_filter'])->name('reports.suppliers.filter');
            Route::get('/export', [ReportController::class, 'exportSuppliers'])->name('reports.export.suppliers');
        });
        
        
        // Laporan Assessment
        Route::prefix('assessments')->group(function () {
            Route::get('/', [ReportController::class, 'assessments'])->name('reports.assessments');
            Route::get('/filter', [ReportController::class,'assessments_filter'])->name('reports.assessments.filter');
            Route::get('/export', [ReportController::class, 'exportAssessments'])->name('reports.export.assessments');
            Route::get('/{assessmentId}/export-detailed', [ReportController::class, 'exportDetailedAssessment'])->name('reports.export.assessment.detailed');
        });
        
        // Laporan Kriteria
        Route::get('/kriteria', [ReportController::class, 'kriteriaReport'])->name('reports.kriteria');
        
        // Executive Summary
        Route::get('/executive-summary', [ReportController::class, 'executiveSummary'])->name('reports.executive-summary');
        
        // Export Excel/PDF
        Route::get('/export/suppliers-pdf', [ReportController::class, 'exportSuppliersPDF'])->name('reports.export.suppliers-pdf');
        Route::get('/export/suppliers-excel', [ReportController::class, 'exportSuppliersExcel'])->name('reports.export.suppliers-excel');
        Route::get('/export/results-pdf/{id}', [ReportController::class, 'exportResultsPDF'])->name('reports.export.results-pdf');
        Route::get('/export/results-excel/{id}', [ReportController::class, 'exportResultsExcel'])->name('reports.export.results-excel');
    })->middleware(['auth', 'verified']);

    Route::middleware(['auth'])->group(function () {
        Route::redirect('settings', 'settings/profile');



        Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
        Volt::route('settings/password', 'settings.password')->name('user-password.edit');
        Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');


        Volt::route('settings/two-factor', 'settings.two-factor')
            ->middleware(
                when(
                    Features::canManageTwoFactorAuthentication()
                        && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                    ['password.confirm'],
                    [],
                ),
            )
            ->name('two-factor.show');
    });
