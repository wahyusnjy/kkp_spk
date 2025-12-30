<?php

namespace App\Http\Controllers;

use App\Exports\SupplierReportExport;
use App\Exports\MaterialReportExport;
use App\Exports\MaterialTemplateExport;
use App\Imports\MaterialImport;
use App\Models\Kriteria;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\Assessment;
use App\Models\Topsis_Result;
use App\Models\TopsisResult;
use DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // =========================== Supplier Section Report  =========================== 
    // Laporan Supplier
    public function suppliers(Request $request)
    {
        $status = $request->input('status', []);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kategori = $request->input('kategori_material');
        
        // Start query
        $query = Supplier::query();
        
        // Apply status filter
        if (!empty($status)) {
            $query->whereIn('status', $status);
        }
        
        // Apply date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        // Apply kategori filter
        if ($kategori) {
            $query->where('kategori_material', $kategori);
        }
        
        // Get suppliers with pagination
        $suppliers = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get summary data
        $summary = [
            'total_supplier' => Supplier::count(),
            'active_supplier' => Supplier::where('status', 'active')->count(),
            'inactive_supplier' => Supplier::where('status', 'non-active')->orWhere('status', 'inactive')->count(),
            'total_category' => Supplier::distinct('kategori_material')->count('kategori_material'),
        ];
        
        // Get all categories for filter dropdown
        $kategoriList = Supplier::select('kategori_material')
            ->whereNotNull('kategori_material')
            ->distinct()
            ->pluck('kategori_material')
            ->filter()
            ->values()
            ->toArray();
            
        return view('pages.evaluation.reports.supplier', compact('suppliers', 'summary', 'kategoriList'));
    }

    public function supplier_filter(Request $request)
    {
        // Build query string from request
        $queryParams = [];
        
        if ($request->has('status') && is_array($request->status)) {
            foreach ($request->status as $status) {
                $queryParams[] = 'status[]=' . urlencode($status);
            }
        }
        
        if ($request->has('start_date')) {
            $queryParams[] = 'start_date=' . urlencode($request->start_date);
        }
        
        if ($request->has('end_date')) {
            $queryParams[] = 'end_date=' . urlencode($request->end_date);
        }
        
        if ($request->has('kategori_material')) {
            $queryParams[] = 'kategori_material=' . urlencode($request->kategori_material);
        }
        
        $queryString = !empty($queryParams) ? '?' . implode('&', $queryParams) : '';
        
        return redirect()->route('reports.suppliers') . $queryString;
    }

    public function exportSuppliers(Request $request) {
        $format = $request->input('format', 'excel');
        $includeSummary = $request->has('include_summary');
        
        // Get filtered data (same logic as index)
        $status = $request->input('status', []);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kategori = $request->input('kategori_material');
        
        $query = Supplier::query();
        
        if (!empty($status)) {
            $query->whereIn('status', $status);
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        if ($kategori) {
            $query->where('kategori_material', $kategori);
        }
        
        $suppliers = $query->orderBy('created_at', 'desc')->get();
        
        // Get summary for export
        $summary = [
            'total_supplier' => Supplier::count(),
            'active_supplier' => Supplier::where('status', 'aktif')->count(),
            'inactive_supplier' => Supplier::where('status', 'non-aktif')->orWhere('status', 'tidak aktif')->count(),
            'total_category' => Supplier::distinct('kategori_material')->count('kategori_material'),
        ];
        
        // Generate filename
        $filename = 'laporan-supplier-' . date('Y-m-d-His');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            
            $data = [
                'suppliers' => $suppliers,
                'summary' => $summary,
                'includeSummary' => $includeSummary,
                'filter' => [
                    'status' => $status,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'kategori_material' => $kategori,
                ],
            ];
            
            $pdf = PDF::loadView('exports.supplier-pdf', $data);
            return $pdf->download($filename);
            
        } else {
            $filename .= '.xlsx';
            
            return Excel::download(new SupplierReportExport($suppliers, $summary, $includeSummary), $filename);
        }
    }

    public function supplier_stats()
    {
        // Get monthly statistics
        $monthlyStats = Supplier::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "aktif" THEN 1 ELSE 0 END) as active'),
                DB::raw('SUM(CASE WHEN status = "non-aktif" OR status = "tidak aktif" THEN 1 ELSE 0 END) as inactive')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();
        
        // Get statistics by category
        $categoryStats = Supplier::select(
                'kategori_material',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "aktif" THEN 1 ELSE 0 END) as active')
            )
            ->whereNotNull('kategori_material')
            ->groupBy('kategori_material')
            ->orderBy('total', 'desc')
            ->get();
        
        return response()->json([
            'monthly_stats' => $monthlyStats,
            'category_stats' => $categoryStats,
        ]);
        
    }

    // =========================== End Supplier Section Report  =========================== 

    // =========================== Assessment Section Report  =========================== 
    
    public function assessments(Request $request)
    {
        $status = $request->input('status', []);
        $tahun = $request->input('tahun');
        $materialId = $request->input('material_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Start query
        $query = Assessment::with(['material', 'scores', 'topsisResults.supplier']);
        
        // Apply status filter
        if (!empty($status)) {
            $query->where(function($q) use ($status) {
                foreach ($status as $s) {
                    if ($s === 'completed') {
                        $q->orWhereHas('topsisResults');
                    } elseif ($s === 'scoring') {
                        $q->orWhere(function($subQ) {
                            $subQ->whereHas('scores')
                                ->whereDoesntHave('topsisResults');
                        });
                    } elseif ($s === 'draft') {
                        $q->orWhereDoesntHave('scores');
                    }
                }
            });
        }
        
        // Apply year filter
        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        
        // Apply material filter
        if ($materialId) {
            $query->where('material_id', $materialId);
        }
        
        // Apply date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        // Get assessments with pagination
        $assessments = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get summary data
        $summary = [
            'total_assessment' => Assessment::count(),
            'completed_assessment' => Assessment::whereHas('topsisResults')->count(),
            'in_progress_assessment' => Assessment::whereHas('scores')
                ->whereDoesntHave('topsisResults')->count(),
            'total_suppliers_assessed' => DB::table('assessment_scores')
                ->distinct('supplier_id')
                ->count('supplier_id'),
        ];
        
        // Get year list for filter
        $yearList = Assessment::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
        
        // Get material list for filter
        $materialList = \App\Models\Material::orderBy('nama_material')->get();
        
        return view('pages.evaluation.reports.assessment', compact('assessments', 'summary', 'yearList', 'materialList'));
    }
     

    public function assessments_filter(Request $request)
    {
        // Build query string from request
        $queryParams = [];
        
        if ($request->has('status') && is_array($request->status)) {
            foreach ($request->status as $status) {
                $queryParams[] = 'status[]=' . urlencode($status);
            }
        }
        
        if ($request->has('tahun')) {
            $queryParams[] = 'tahun=' . urlencode($request->tahun);
        }
        
        if ($request->has('material_id')) {
            $queryParams[] = 'material_id=' . urlencode($request->material_id);
        }
        
        if ($request->has('start_date')) {
            $queryParams[] = 'start_date=' . urlencode($request->start_date);
        }
        
        if ($request->has('end_date')) {
            $queryParams[] = 'end_date=' . urlencode($request->end_date);
        }
        
        $queryString = !empty($queryParams) ? '?' . implode('&', $queryParams) : '';
        
        return redirect()->route('reports.assessments', $queryString);
    }

    public function exportAssessments(Request $request)
    {
        $format = $request->input('format', 'excel');
        $includeSummary = $request->has('include_summary');
        
        // Get filtered data (same logic as index)
        $status = $request->input('status', []);
        $tahun = $request->input('tahun');
        $materialId = $request->input('material_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = Assessment::with(['material', 'scores.supplier', 'scores.kriteria', 'topsisResults.supplier']);
        
        // Apply filters
        if (!empty($status)) {
            $query->where(function($q) use ($status) {
                foreach ($status as $s) {
                    if ($s === 'completed') {
                        $q->orWhereHas('topsisResults');
                    } elseif ($s === 'scoring') {
                        $q->orWhere(function($subQ) {
                            $subQ->whereHas('scores')
                                ->whereDoesntHave('topsisResults');
                        });
                    } elseif ($s === 'draft') {
                        $q->orWhereDoesntHave('scores');
                    }
                }
            });
        }
        
        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        
        if ($materialId) {
            $query->where('material_id', $materialId);
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        $assessments = $query->orderBy('created_at', 'desc')->get();
        
        // Get summary for export
        $summary = [
            'total_assessment' => Assessment::count(),
            'completed_assessment' => Assessment::whereHas('topsisResults')->count(),
            'in_progress_assessment' => Assessment::whereHas('scores')
                ->whereDoesntHave('topsisResults')->count(),
            'total_suppliers_assessed' => DB::table('assessment_scores')
                ->distinct('supplier_id')
                ->count('supplier_id'),
        ];
        
        // Generate filename
        $filename = 'laporan-assessment-' . date('Y-m-d-His');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            
            $data = [
                'assessments' => $assessments,
                'summary' => $summary,
                'includeSummary' => $includeSummary,
                'filter' => [
                    'status' => $status,
                    'tahun' => $tahun,
                    'material_id' => $materialId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ],
            ];
            
            $pdf = PDF::loadView('exports.assessment-pdf', $data);
            return $pdf->download($filename);
            
        } else {
            $filename .= '.xlsx';
            
            return Excel::download(new \App\Exports\AsessmentReportExport($assessments, $summary, $includeSummary), $filename);
        }
    }

    // ================== END Assessment Section Report ==================
    
    /**
     * Export detailed assessment report with TOPSIS calculations
     */
    public function exportDetailedAssessment(Request $request, $assessmentId)
    {
        $format = $request->input('format', 'pdf');
        
        // Load assessment with all relationships
        $assessment = Assessment::with([
            'material',
            'scores.supplier',
            'scores.kriteria',
            'topsisResults.supplier'
        ])->findOrFail($assessmentId);
        
        // Get TOPSIS calculation steps if completed
        $calculationSteps = null;
        if ($assessment->topsisResults->count() > 0) {
            $topsisService = new \App\Services\TopsisService();
            $calculationSteps = $topsisService->getCalculationSteps($assessmentId);
        }
        
        // Group scores by supplier
        $scoresBySupplier = $assessment->scores->groupBy('supplier_id');
        
        // Statistics
        $statistics = [
            'total_suppliers' => $scoresBySupplier->count(),
            'total_criteria' => $assessment->scores->groupBy('kriteria_id')->count(),
            'total_score' => $assessment->scores->sum('score'),
            'average_score' => $assessment->scores->avg('score') ?? 0,
            'max_score' => $assessment->scores->max('score') ?? 0,
            'min_score' => $assessment->scores->min('score') ?? 0,
        ];
        
        $filename = 'laporan-detail-assessment-' . $assessment->id . '-' . date('Y-m-d-His');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            
            $data = [
                'assessment' => $assessment,
                'scoresBySupplier' => $scoresBySupplier,
                'statistics' => $statistics,
                'calculationSteps' => $calculationSteps,
                'exportDate' => now(),
            ];
            
            $pdf = PDF::loadView('exports.assessment-detailed-pdf', $data)
                ->setPaper('a4', 'landscape');
            
            return $pdf->download($filename);
            
        } else {
            $filename .= '.xlsx';
            
            return Excel::download(
                new \App\Exports\DetailedAssessmentExport(
                    $assessment,
                    $scoresBySupplier,
                    $statistics,
                    $calculationSteps
                ),
                $filename
            );
        }
    }


    // Export PDF Results
    public function exportResultsPDF($id)
    {
        $assessment = Assessment::with(['topsisResults.supplier'])->findOrFail($id);
        $results = Topsis_Result::with('supplier')
            ->where('assessment_id', $id)
            ->orderBy('rank')
            ->get();

        $pdf = PDF::loadView('reports.exports.results-pdf', compact('assessment', 'results'));
        return $pdf->download("hasil-topsis-{$assessment->nama_penilaian}.pdf");
    }

    // Export Excel Results
    public function exportResultsExcel($id)
    {
        // Implement Excel export
        return redirect()->back()->with('info', 'Export Excel dalam pengembangan');
    }
    
    /**
     * Laporan Kriteria Lengkap
     */
    public function kriteriaReport(Request $request)
    {
        $format = $request->input('format');
        
        // If no format, show the page
        if (!$format) {
            return view('pages.reports.kriteria');
        }
        
        // Get all criteria with usage statistics
        $kriterias = Kriteria::all()->map(function($kriteria) {
            // Count usage in assessments
            $usageCount = DB::table('assessment_scores')
                ->where('kriteria_id', $kriteria->id)
                ->distinct('assessment_id')
                ->count('assessment_id');
            
            // Get average score
            $avgScore = DB::table('assessment_scores')
                ->where('kriteria_id', $kriteria->id)
                ->avg('score');
            
            // Get score range
            $maxScore = DB::table('assessment_scores')
                ->where('kriteria_id', $kriteria->id)
                ->max('score');
            
            $minScore = DB::table('assessment_scores')
                ->where('kriteria_id', $kriteria->id)
                ->min('score');
            
            $kriteria->usage_count = $usageCount;
            $kriteria->avg_score = $avgScore ?? 0;
            $kriteria->max_score = $maxScore ?? 0;
            $kriteria->min_score = $minScore ?? 0;
            
            return $kriteria;
        });
        
        // Summary statistics
        $summary = [
            'total_kriteria' => $kriterias->count(),
            'benefit_count' => $kriterias->where('type', 'benefit')->count(),
            'cost_count' => $kriterias->where('type', 'cost')->count(),
            'total_weight' => $kriterias->sum('bobot'),
            'avg_weight' => $kriterias->avg('bobot'),
            'most_used' => $kriterias->sortByDesc('usage_count')->first(),
        ];
        
        $filename = 'laporan-kriteria-' . date('Y-m-d-His');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            
            $data = [
                'kriterias' => $kriterias,
                'summary' => $summary,
                'exportDate' => now(),
            ];
            
            $pdf = PDF::loadView('exports.kriteria-report-pdf', $data);
            return $pdf->download($filename);
            
        } else {
            $filename .= '.xlsx';
            
            return Excel::download(
                new \App\Exports\KriteriaReportExport($kriterias, $summary),
                $filename
            );
        }
    }
    
    /**
     * Laporan Material Lengkap (Simple Page)
     */
    public function materialReport(Request $request)
    {
        $format = $request->input('format');
        
        // If no format, show the page
        if (!$format) {
            return view('pages.reports.material');
        }
        
        // Get all materials with relationships
        $materials = Material::with('supplier')->get();
        
        // Summary statistics
        $summary = [
            'total_material' => $materials->count(),
            'total_jenis_logam' => $materials->whereNotNull('jenis_logam')->unique('jenis_logam')->count(),
            'harga_tertinggi' => $materials->max('harga_per_kg') ?? 0,
            'harga_terendah' => $materials->min('harga_per_kg') ?? 0,
            'total_suppliers' => $materials->whereNotNull('supplier_id')->unique('supplier_id')->count(),
        ];
        
        $filename = 'laporan-material-lengkap-' . date('Y-m-d-His');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            
            $data = [
                'materials' => $materials,
                'summary' => $summary,
                'includeSummary' => true,
                'filter' => [],
                'exportDate' => now(),
            ];
            
            $pdf = PDF::loadView('exports.material-pdf', $data);
            return $pdf->download($filename);
            
        } else {
            $filename .= '.xlsx';
            
            return Excel::download(
                new \App\Exports\MaterialReportExport($materials, $summary, true),
                $filename
            );
        }
    }
    
    /**
     * Executive Summary Report
     */
    public function executiveSummary(Request $request)
    {
        $format = $request->input('format');
        
        // If no format, show the page
        if (!$format) {
            return view('pages.reports.executive-summary');
        }
        
        // Collect comprehensive statistics
        $summary = [
            // Assessment stats
            'total_assessments' => Assessment::count(),
            'completed_assessments' => Assessment::whereHas('topsisResults')->count(),
            'in_progress_assessments' => Assessment::whereHas('scores')
                ->whereDoesntHave('topsisResults')->count(),
            'draft_assessments' => Assessment::whereDoesntHave('scores')->count(),
            
            // Supplier stats
            'total_suppliers' => Supplier::count(),
            'active_suppliers' => DB::table('assessment_scores')
                ->distinct('supplier_id')
                ->count('supplier_id'),
            'top_supplier' => $this->getTopSupplier(),
            
            // Kriteria stats
            'total_kriteria' => Kriteria::count(),
            'benefit_kriteria' => Kriteria::where('type', 'benefit')->count(),
            'cost_kriteria' => Kriteria::where('type', 'cost')->count(),
            
            // Material stats
            'total_materials' => Material::count(),
            'materials_assessed' => DB::table('assessments')
                ->distinct('material_id')
                ->count('material_id'),
            
            // Recent activity
            'recent_assessments' => Assessment::with(['material', 'topsisResults.supplier'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            
            'recent_winners' => Topsis_Result::with(['supplier', 'assessment.material'])
                ->where('rank', 1)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
        ];
        
        $filename = 'executive-summary-' . date('Y-m-d-His');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            
            $data = [
                'summary' => $summary,
                'exportDate' => now(),
            ];
            
            $pdf = PDF::loadView('exports.executive-summary-pdf', $data);
            return $pdf->download($filename);
            
        } else {
            $filename .= '.xlsx';
            
            return Excel::download(
                new \App\Exports\ExecutiveSummaryExport($summary),
                $filename
            );
        }
    }
    
    // =========================== Material Section Report  =========================== 
    // Laporan Material
    public function materials(Request $request)
    {
        $jenisLogam = $request->input('jenis_logam');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $supplierId = $request->input('supplier_id');
        
        // Start query
        $query = Material::with('supplier');
        
        // Apply jenis logam filter
        if ($jenisLogam) {
            $query->where('jenis_logam', $jenisLogam);
        }
        
        // Apply supplier filter
        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }
        
        // Apply date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        // Get materials with pagination
        $materials = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get summary data
        $summary = [
            'total_material' => Material::count(),
            'total_jenis_logam' => Material::distinct('jenis_logam')->count('jenis_logam'),
            'harga_tertinggi' => Material::max('harga_per_kg') ?? 0,
            'harga_terendah' => Material::min('harga_per_kg') ?? 0,
        ];
        
        // Get jenis logam list for filter dropdown
        $jenisLogamList = Material::select('jenis_logam')
            ->whereNotNull('jenis_logam')
            ->distinct()
            ->pluck('jenis_logam')
            ->filter()
            ->values()
            ->toArray();
        
        // Get supplier list for filter dropdown
        $supplierList = Supplier::orderBy('nama_supplier')->get();
            
        return view('pages.evaluation.reports.material', compact('materials', 'summary', 'jenisLogamList', 'supplierList'));
    }

    public function material_filter(Request $request)
    {
        // Build query string from request
        $queryParams = [];
        
        if ($request->has('jenis_logam')) {
            $queryParams[] = 'jenis_logam=' . urlencode($request->jenis_logam);
        }
        
        if ($request->has('supplier_id')) {
            $queryParams[] = 'supplier_id=' . urlencode($request->supplier_id);
        }
        
        if ($request->has('start_date')) {
            $queryParams[] = 'start_date=' . urlencode($request->start_date);
        }
        
        if ($request->has('end_date')) {
            $queryParams[] = 'end_date=' . urlencode($request->end_date);
        }
        
        $queryString = !empty($queryParams) ? '?' . implode('&', $queryParams) : '';
        
        return redirect()->route('reports.materials') . $queryString;
    }

    public function exportMaterials(Request $request) {
        $format = $request->input('format', 'excel');
        $includeSummary = $request->has('include_summary');
        
        // Get filtered data (same logic as index)
        $jenisLogam = $request->input('jenis_logam');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $supplierId = $request->input('supplier_id');
        
        $query = Material::with('supplier');
        
        if ($jenisLogam) {
            $query->where('jenis_logam', $jenisLogam);
        }
        
        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        $materials = $query->orderBy('created_at', 'desc')->get();
        
        // Get summary for export
        $summary = [
            'total_material' => Material::count(),
            'total_jenis_logam' => Material::distinct('jenis_logam')->count('jenis_logam'),
            'harga_tertinggi' => Material::max('harga_per_kg') ?? 0,
            'harga_terendah' => Material::min('harga_per_kg') ?? 0,
        ];
        
        // Generate filename
        $filename = 'laporan-material-' . date('Y-m-d-His');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            
            $data = [
                'materials' => $materials,
                'summary' => $summary,
                'includeSummary' => $includeSummary,
                'filter' => [
                    'jenis_logam' => $jenisLogam,
                    'supplier_id' => $supplierId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ],
            ];
            
            $pdf = PDF::loadView('exports.material-pdf', $data);
            return $pdf->download($filename);
            
        } else {
            $filename .= '.xlsx';
            
            return Excel::download(new MaterialReportExport($materials, $summary, $includeSummary), $filename);
        }
    }

    public function importMaterials(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new MaterialImport, $request->file('file'));
            
            return redirect()->back()->with('success', 'Data material berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function downloadMaterialTemplate()
    {
        $filename = 'template-import-material-' . date('Y-m-d') . '.xlsx';
        return Excel::download(new MaterialTemplateExport, $filename);
    }

    public function material_stats()
    {
        // Get monthly statistics
        $monthlyStats = Material::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(harga_per_kg) as avg_price')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();
        
        // Get statistics by jenis logam
        $jenisLogamStats = Material::select(
                'jenis_logam',
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(harga_per_kg) as avg_price')
            )
            ->whereNotNull('jenis_logam')
            ->groupBy('jenis_logam')
            ->orderBy('total', 'desc')
            ->get();
        
        return response()->json([
            'monthly_stats' => $monthlyStats,
            'jenis_logam_stats' => $jenisLogamStats,
        ]);
    }

    // =========================== End Material Section Report  =========================== 
    
    private function getTopSupplier()
    {
        $topSupplier = Topsis_Result::select('supplier_id', DB::raw('COUNT(*) as win_count'))
            ->where('rank', 1)
            ->groupBy('supplier_id')
            ->orderByDesc('win_count')
            ->first();
        
        if ($topSupplier) {
            $supplier = Supplier::find($topSupplier->supplier_id);
            return [
                'supplier' => $supplier,
                'win_count' => $topSupplier->win_count,
            ];
        }
        
        return null;
    }
}