<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Assessment;
use App\Models\TopsisResult;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Laporan Supplier
    public function suppliers()
    {
        $suppliers = Supplier::with('materials')->latest()->get();
        return view('reports.suppliers', compact('suppliers'));
    }

    // Laporan Assessments
    public function assessments()
    {
        $assessments = Assessment::with(['topsisResults.supplier'])
            ->where('status', 'completed')
            ->latest()
            ->get();
        return view('reports.assessments', compact('assessments'));
    }

    // Export PDF Supplier
    public function exportSuppliersPDF()
    {
        $suppliers = Supplier::with('materials')->latest()->get();
        $pdf = PDF::loadView('reports.exports.suppliers-pdf', compact('suppliers'));
        return $pdf->download('laporan-supplier-' . date('Y-m-d') . '.pdf');
    }

    // Export Excel Supplier  
    public function exportSuppliersExcel()
    {
        // Implement Excel export
        return redirect()->back()->with('info', 'Export Excel dalam pengembangan');
    }

    // Export PDF Results
    public function exportResultsPDF($id)
    {
        $assessment = Assessment::with(['topsisResults.supplier'])->findOrFail($id);
        $results = TopsisResult::with('supplier')
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
}