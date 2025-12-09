<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentScore;
use App\Models\Supplier;
use App\Models\Material;
use App\Models\Kriteria;
use App\Models\Topsis_Result;
use App\Services\TopsisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class AssessmentController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assessments = Assessment::with(['material', 'topsisResults'])
            ->withCount(['scores', 'topsisResults'])
            ->withCount(['scores as unique_suppliers_count' => function($query) {
                $query->select(DB::raw('COUNT(DISTINCT supplier_id)'));
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.evaluation.assessments.index', compact('assessments'));
    }

    /**
     * Show the form for creating a new assessment
     */
    public function create()
    {
        $materials = Material::all();
        $suppliers = Supplier::all();
        $kriterias = Kriteria::all();

        return view('pages.evaluation.assessments.create', compact('materials', 'suppliers', 'kriterias'));
    }

    /**
     * Store a newly created assessment
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materials,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'deskripsi' => 'nullable|string|max:500',
            'is_draft' => 'sometimes|in:0,1',
            'scores' => 'required|array|min:1',
            'scores.*.supplier_id' => 'required|exists:suppliers,id',
            'scores.*.scores' => 'required|array|min:1',
            'scores.*.scores.*' => 'required|numeric|min:0|max:100'
        ], [
            'scores.*.supplier_id.required' => 'Supplier harus dipilih',
            'scores.*.supplier_id.exists' => 'Supplier tidak valid',
            'scores.*.scores.required' => 'Nilai untuk supplier harus diisi',
            'scores.*.scores.min' => 'Minimal ada 1 nilai untuk setiap supplier',
            'scores.*.scores.*.required' => 'Nilai kriteria harus diisi',
            'scores.*.scores.*.numeric' => 'Nilai harus berupa angka',
            'scores.*.scores.*.min' => 'Nilai minimal adalah 0',
            'scores.*.scores.*.max' => 'Nilai maksimal adalah 100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Create assessment
            $assessment = Assessment::create([
                'material_id' => $request->material_id,
                'tahun' => $request->tahun,
                'deskripsi' => $request->deskripsi,
                'metadata' => [
                    'is_draft' => $request->is_draft == '1',
                    'supplier_count' => count($request->scores),
                    'created_by' => auth()->id(),
                    'created_at' => now()->toDateTimeString()
                ]
            ]);

            // Prepare scores data
            $scoreData = [];

            foreach ($request->scores as $supplierScore) {
                $supplierId = $supplierScore['supplier_id'];
                
                foreach ($supplierScore['scores'] as $kriteriaId => $scoreValue) {
                    // Validasi kriteria_id exists
                    if (!Kriteria::where('id', $kriteriaId)->exists()) {
                        throw new \Exception("Kriteria ID {$kriteriaId} tidak ditemukan");
                    }

                    $scoreData[] = [
                        'assessment_id' => $assessment->id,
                        'supplier_id' => $supplierId,
                        'kriteria_id' => $kriteriaId,
                        'score' => $scoreValue,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Bulk insert scores
            AssessmentScore::insert($scoreData);

            DB::commit();

            // Set success message based on draft status
            $message = $request->is_draft == '1' 
                ? 'Assessment draft berhasil disimpan.' 
                : 'Assessment berhasil dibuat dan nilai telah disimpan.';

            // Jika bukan draft, redirect ke show page
            if ($request->is_draft != '1') {
                return redirect()->route('assessments.show', $assessment->id)
                    ->with('success', $message);
            }

            // Jika draft, redirect ke index atau edit page
            return redirect()->route('assessments.edit', $assessment->id)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Assessment store error: ', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal membuat assessment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified assessment
     */
    public function show($id)
    {
        $assessment = Assessment::with([
                'material',
                'scores.supplier',
                'scores.kriteria',
                'topsisResults.supplier'
            ])
            ->findOrFail($id);

        // Group scores by supplier
        $scoresBySupplier = $assessment->scores->groupBy('supplier_id');

        return view('pages.evaluation.assessments.show', compact('assessment', 'scoresBySupplier'));
    }

    /**
     * Show the form for editing the specified assessment
     */
    public function edit($id)
    {
        $assessment = Assessment::with(['scores.supplier', 'scores.kriteria'])->findOrFail($id);
        $materials = Material::all();
        $suppliers = Supplier::all();
        $kriterias = Kriteria::all();

        // Format existing scores untuk form
        $existingScores = [];
        $supplierIds = [];
        
        foreach ($assessment->scores as $score) {
            $supplierId = $score->supplier_id;
            $kriteriaId = $score->kriteria_id;
            
            if (!isset($existingScores[$supplierId])) {
                $existingScores[$supplierId] = [
                    'supplier_id' => $supplierId,
                    'supplier_name' => $score->supplier->nama_supplier,
                    'scores' => []
                ];
                $supplierIds[] = $supplierId;
            }
            
            $existingScores[$supplierId]['scores'][$kriteriaId] = $score->score;
        }

        return view('pages.evaluation.assessments.edit', compact(
            'assessment', 
            'materials', 
            'suppliers', 
            'kriterias', 
            'existingScores',
            'supplierIds'
        ));
    }

    public function update(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materials,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'deskripsi' => 'nullable|string|max:500',
            'is_draft' => 'sometimes|in:0,1',
            'scores' => 'sometimes|array|min:1',
            'scores.*.supplier_id' => 'sometimes|required_with:scores|exists:suppliers,id',
            'scores.*.scores' => 'sometimes|required_with:scores|array|min:1',
            'scores.*.scores.*' => 'sometimes|required_with:scores.*.scores|numeric|min:0|max:100'
        ], [
            'scores.*.supplier_id.required' => 'Supplier harus dipilih',
            'scores.*.supplier_id.exists' => 'Supplier tidak valid',
            'scores.*.scores.required' => 'Nilai untuk supplier harus diisi',
            'scores.*.scores.min' => 'Minimal ada 1 nilai untuk setiap supplier',
            'scores.*.scores.*.required' => 'Nilai kriteria harus diisi',
            'scores.*.scores.*.numeric' => 'Nilai harus berupa angka',
            'scores.*.scores.*.min' => 'Nilai minimal adalah 0',
            'scores.*.scores.*.max' => 'Nilai maksimal adalah 100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Update assessment basic info
            $assessment->update([
                'material_id' => $request->material_id,
                'tahun' => $request->tahun,
                'deskripsi' => $request->deskripsi,
            ]);

            // Update metadata if needed
            $currentMetadata = $assessment->metadata ?? [];
            $assessment->update([
                'metadata' => array_merge($currentMetadata, [
                    'is_draft' => $request->is_draft == '1',
                    'updated_by' => auth()->id(),
                    'updated_at' => now()->toDateTimeString()
                ])
            ]);

            // Jika ada update scores, proses update
            if ($request->has('scores') && !empty($request->scores)) {
                // Delete existing scores untuk assessment ini
                AssessmentScore::where('assessment_id', $assessment->id)->delete();
                
                // Prepare new scores data
                $scoreData = [];

                foreach ($request->scores as $supplierScore) {
                    $supplierId = $supplierScore['supplier_id'];
                    
                    foreach ($supplierScore['scores'] as $kriteriaId => $scoreValue) {
                        // Validasi kriteria_id exists
                        if (!Kriteria::where('id', $kriteriaId)->exists()) {
                            throw new \Exception("Kriteria ID {$kriteriaId} tidak ditemukan");
                        }

                        $scoreData[] = [
                            'assessment_id' => $assessment->id,
                            'supplier_id' => $supplierId,
                            'kriteria_id' => $kriteriaId,
                            'score' => $scoreValue,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                // Bulk insert scores baru
                if (!empty($scoreData)) {
                    AssessmentScore::insert($scoreData);
                }
                
                // Jika ada TOPSIS results, hapus juga karena data sudah berubah
                Topsis_Result::where('assessment_id', $assessment->id)->delete();
            }

            DB::commit();

            // Set success message based on draft status
            $message = $request->is_draft == '1' 
                ? 'Assessment draft berhasil diperbarui.' 
                : 'Assessment berhasil diperbarui.';

            return redirect()->route('assessments.show', $assessment->id)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Assessment update error: ', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui assessment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified assessment
     */
    public function destroy($id)
    {
        $assessment = Assessment::findOrFail($id);

        DB::beginTransaction();

        try {
            $assessment->scores()->delete();
            $assessment->topsisResults()->delete();
            $assessment->delete();

            DB::commit();

            return redirect()->route('assessments.index')
                ->with('success', 'Assessment berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('assessments.index')
                ->with('error', 'Gagal menghapus assessment: ' . $e->getMessage());
        }
    }

    /**
     * Show form for inputting scores
     */
    public function scores($id)
    {
        $assessment = Assessment::with(['material'])->findOrFail($id);
        $suppliers = Supplier::all();
        $kriterias = Kriteria::all();

        // Load existing scores if any
        $existingScores = [];
        $scores = $assessment->scores;
        foreach ($scores as $score) {
            $existingScores[$score->supplier_id][$score->kriteria_id] = $score->score;
        }

        return view('pages.evaluation.assessments.scores', compact(
            'assessment', 'suppliers', 'kriterias', 'existingScores'
        ));
    }

    /**
     * Save scores for assessment
     */
    public function saveScores(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'supplier_ids' => 'required|array|min:2',
            'supplier_ids.*' => 'exists:suppliers,id',
            'scores' => 'required|array',
            'scores.*' => 'required|array',
            'scores.*.*' => 'required|numeric|min:0|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Delete old scores
            AssessmentScore::where('assessment_id', $assessment->id)->delete();

            // Prepare new scores
            $scoreData = [];
            $kriteriaIds = Kriteria::pluck('id')->toArray();

            foreach ($request->supplier_ids as $supplierId) {
                foreach ($kriteriaIds as $kriteriaId) {
                    $score = $request->scores[$supplierId][$kriteriaId] ?? 0;
                    
                    $scoreData[] = [
                        'assessment_id' => $assessment->id,
                        'supplier_id' => $supplierId,
                        'kriteria_id' => $kriteriaId,
                        'score' => $score,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Insert new scores
            AssessmentScore::insert($scoreData);

            // Delete old TOPSIS results
            $assessment->topsisResults()->delete();

            DB::commit();

            return redirect()->route('assessments.show', $assessment->id)
                ->with('success', 'Nilai berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal menyimpan nilai: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Calculate TOPSIS for assessment
     */
    public function calculate($id)
    {
        $assessment = Assessment::findOrFail($id);

        // Check if assessment has scores
        if (!$assessment->scores()->exists()) {
            return redirect()->route('assessments.index', $assessment->id)
                ->with('error', 'Assessment belum memiliki nilai. Silakan input nilai terlebih dahulu.');
        }

        // Calculate TOPSIS using service
        $result = $this->topsisService->calculate($id);

        if (!$result['success']) {
            return redirect()->route('assessments.show', $assessment->id)
                ->with('error', 'Gagal menghitung TOPSIS: ' . $result['error']);
        }

        return redirect()->route('results.show', $assessment->id)
            ->with('success', 'Perhitungan TOPSIS berhasil! Hasil dapat dilihat di halaman Ranking Supplier.');
    }
}