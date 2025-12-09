<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Topsis_Result;
use Illuminate\Http\Request;
use App\Services\TopsisService;
use App\Models\Assessment;
use Barryvdh\DomPDF\Facade\Pdf;

class TopsisResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $assessmentFilter = $request->get('assessment_id');
        
        $query = Topsis_Result::with(['assessment', 'supplier'])
            ->join('assessments', 'topsis_results.assessment_id', '=', 'assessments.id')
            ->join('suppliers', 'topsis_results.supplier_id', '=', 'suppliers.id')
            ->select('topsis_results.*', 'suppliers.nama_supplier', 'suppliers.alamat');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('suppliers.nama_supplier', 'like', "%{$search}%")
                ->orWhere('assessments.nama', 'like', "%{$search}%");
            });
        }
        
        if ($assessmentFilter) {
            $query->where('topsis_results.assessment_id', $assessmentFilter);
        }

        
        $results = $query->orderBy('assessments.created_at', 'desc')
            ->orderBy('topsis_results.rank')
            ->paginate(10);

        
        $assessments = Assessment::orderBy('created_at')->get();
        
        return view('topsis-result', compact('results', 'assessments', 'search', 'assessmentFilter'));
    }

    public function show($id, TopsisService $topsisService)
    {
        $assessments = Assessment::get();
        $assessment = Assessment::with(['scores.supplier', 'topsisResults.supplier'])->findOrFail($id);
        // Get calculation steps for detail view
        $steps = $topsisService->getCalculationSteps($id);
        
        $results = Topsis_Result::with('supplier')
            ->where('assessment_id', $id)
            ->orderBy('rank')
            ->get();
        
        // Group scores by supplier for display
        $scoresBySupplier = $assessment->scores->groupBy('supplier_id');

        return view('pages.results.show', compact(
            'assessment', 
            'assessments', 
            'results', 
            'steps',
            'scoresBySupplier'
        ));
    }

    public function supplierCalculation($id, $supplier, TopsisService $topsisService)
    {
        if ($supplier === 'all') {
            $steps = $topsisService->getCalculationSteps($id);
            return response()->json([
                'steps' => $steps
            ]);
        }
        
        // Jika supplier = "steps", juga kembalikan semua steps (untuk kompatibilitas)
        if ($supplier === 'steps') {
            $steps = $topsisService->getCalculationSteps($id);
            return response()->json([
                'steps' => $steps
            ]);
        }
        $assessment = Assessment::with(['scores' => function($query) use ($supplier) {
            $query->where('supplier_id', $supplier);
        }, 'scores.kriteria', 'topsisResults' => function($query) use ($supplier) {
            $query->where('supplier_id', $supplier);
        }])->findOrFail($id);
        
        $supplierModel = Supplier::findOrFail($supplier);
        
        // Get full calculation steps
        $stepsData = $topsisService->getCalculationSteps($id);
        
        // Get specific supplier index
        $supplierIndex = null;
        foreach ($stepsData['suppliers'] as $index => $s) {
            if ($s->id == $supplier) {
                $supplierIndex = $index;
                break;
            }
        }
        
        if ($supplierIndex === null) {
            return response()->json([
                'error' => 'Supplier tidak ditemukan dalam assessment'
            ], 404);
        }
        
        // Get the result for this supplier
        $result = $assessment->topsisResults->where('supplier_id', $supplier)->first();
        // Prepare specific supplier data
        $supplierSteps = [
            'supplier' => $supplierModel,
            'ranking' => $result ? $result->rank : 0,
            'steps' => [
                'decision_matrix' => $stepsData['decision_matrix'][$supplierIndex],
                'normalized_matrix' => $stepsData['normalized_matrix'][$supplierIndex],
                'weighted_matrix' => $stepsData['weighted_matrix'][$supplierIndex],
                'criteria' => $stepsData['criteria'],
                'ideal_solutions' => $stepsData['ideal_solutions'],
                'positive_distance' => $stepsData['distances'][intval($supplier)]['positive'],
                'negative_distance' => $stepsData['distances'][intval($supplier)]['negative'],
                'distance_calculations' => [
                    'positive' => $this->calculateIndividualDistances(
                        $stepsData['weighted_matrix'][$supplierIndex],
                        $stepsData['ideal_solutions']['positive']
                    ),
                    'negative' => $this->calculateIndividualDistances(
                        $stepsData['weighted_matrix'][$supplierIndex],
                        $stepsData['ideal_solutions']['negative']
                    )
                ],
                'preference_score' => $stepsData['preferences'][$supplierIndex]
            ]
        ];
        
        return response()->json($supplierSteps);
        
    }

    private function calculateIndividualDistances($weightedRow, $idealSolution)
    {
        $distances = [];
        foreach ($weightedRow as $index => $value) {
            $distances[] = pow($value - $idealSolution[$index], 2);
        }
        return $distances;
    }

    public function history($assessment_id = null)
    {
        $assessments = Assessment::orderBy('created_at', 'desc')->get();

        if ($assessment_id) {
            $assessment = Assessment::with(['topsisResults.supplier'])->findOrFail($assessment_id);
            $results = Topsis_Result::with('supplier')
                ->where('assessment_id', $assessment_id)
                ->orderBy('rank')
                ->get();
        } else {
            $assessment = null;
            $results = null;
        }

        return view('pages.result.history', compact('assessments', 'assessment', 'results', 'assessment_id'));
    }

    public function exportPDF($id)
    {
        $assessment = Assessment::with(['topsisResults.supplier'])->findOrFail($id);
        $results = Topsis_Result::with('supplier')
            ->where('assessment_id', $id)
            ->orderBy('rank')
            ->get();

        $pdf = Pdf::loadView('results.export-pdf', compact('assessment', 'results'));
        return $pdf->download("hasil-topsis-{$assessment->nama_penilaian}.pdf");
    }


    public function exportExcel($id)
    {
        // Implement Excel export using Maatwebsite/Laravel-Excel
        return redirect()->back()->with('info', 'Fitur export Excel dalam pengembangan');
    }
}
