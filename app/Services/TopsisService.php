<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\AssessmentScore;
use App\Models\Kriteria;
use App\Models\Topsis_Result;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TopsisService
{
    private $assessment;
    private $criteria;
    private $scores;
    private $suppliers;

    public function calculate($assessmentId)
    {
        try {
            DB::beginTransaction();

            // 1. Load data
            $this->loadData($assessmentId);

            if (empty($this->scores)) {
                throw new \Exception("Tidak ada data penilaian untuk assessment ini");
            }

            // 2. Buat matrix keputusan
            $decisionMatrix = $this->createDecisionMatrix();
            
            // 3. Normalisasi matrix
            $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);

            // 4. Terapkan bobot
            $weightedMatrix = $this->applyWeights($normalizedMatrix);

            // 5. Hitung solusi ideal
            $idealSolutions = $this->calculateIdealSolutions($weightedMatrix);

            // 6. Hitung jarak
            $distances = $this->calculateDistances($weightedMatrix, $idealSolutions);

            // 7. Hitung nilai preferensi
            $preferences = $this->calculatePreferences($distances);

            // 8. Ranking
            $rankings = $this->calculateRankings($preferences);

            // 9. Simpan hasil
            $results = $this->saveResults($preferences, $rankings, $assessmentId);

            DB::commit();

            return [
                'success' => true,
                'results' => $results,
                'total_suppliers' => count($this->suppliers),
                'total_criteria' => count($this->criteria)
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('TOPSIS Calculation Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function loadData($assessmentId)
    {
        // dd($assessmentId);
        $this->assessment = Assessment::with(['material'])
            ->findOrFail($assessmentId);
        
        $this->criteria = Kriteria::get();
        $this->scores = AssessmentScore::with(['supplier', 'kriteria'])
            ->where('assessment_id', $assessmentId)
            ->get();
            
        // dd($this->suppliers = $this->scores->pluck('supplier')->unique('id')->keyBy('id'));
        $this->suppliers = $this->scores->pluck('supplier')->unique('id')->keyBy('id');
    
        // Pengecekan keamanan
        if ($this->suppliers->isEmpty()) {
            throw new \Exception("Tidak ada supplier yang memiliki skor untuk assessment ini");
        }
    }

    private function createDecisionMatrix()
    {
        $matrix = [];
        $suppliers = $this->suppliers;
        $criteria = $this->criteria;
        // dd($criteria);

        foreach ($suppliers as $supplierIndex => $supplier) {
            foreach ($criteria as $criteriaIndex => $criterion) {
                $score = $this->scores
                    ->where('supplier_id', $supplier->id)
                    ->where('kriteria_id', $criterion->id)
                    ->first();

                // Gunakan nilai default 0 jika tidak ada score
                $matrix[$supplierIndex][$criteriaIndex] = $score ? (float) $score->score : 0.0;
            }
        }

        return $matrix;
    }

    private function normalizeMatrix($matrix)
    {
        $normalized = [];
        $criteriaCount = count($this->criteria);

        if ($criteriaCount === 0) {
            return $normalized;
        }

        // Hitung akar kuadrat dari jumlah kuadrat setiap kolom
        $columnSums = [];
        for ($j = 0; $j < $criteriaCount; $j++) {
            $sumOfSquares = 0;
            foreach ($matrix as $row) {
                $sumOfSquares += pow($row[$j], 2);
            }
            $columnSums[$j] = sqrt($sumOfSquares);
        }

        // Normalisasi setiap elemen
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $value) {
                $normalized[$i][$j] = $columnSums[$j] != 0 ? $value / $columnSums[$j] : 0;
            }
        }

        return $normalized;
    }

    private function applyWeights($normalizedMatrix)
    {
        $weighted = [];
        $criteria = $this->criteria;

        foreach ($normalizedMatrix as $i => $row) {
            foreach ($row as $j => $value) {
                $weight = (float) $criteria[$j]->bobot;
                $weighted[$i][$j] = $value * $weight;
            }
        }

        return $weighted;
    }

    private function calculateIdealSolutions($weightedMatrix)
    {
        $idealPositive = [];
        $idealNegative = [];
        $criteria = $this->criteria;

        for ($j = 0; $j < count($criteria); $j++) {
            $columnValues = array_column($weightedMatrix, $j);
            
            if ($criteria[$j]->type == 'benefit') { // Perbaikan: 'type' bukan 'jenis'
                $idealPositive[$j] = max($columnValues);
                $idealNegative[$j] = min($columnValues);
            } else { // cost
                $idealPositive[$j] = min($columnValues);
                $idealNegative[$j] = max($columnValues);
            }
        }

        return [
            'positive' => $idealPositive,
            'negative' => $idealNegative
        ];
    }

    private function calculateDistances($weightedMatrix, $idealSolutions)
    {
        $distances = [];
        // dd($weightedMatrix);
        foreach ($weightedMatrix as $i => $row) {
            $distancePositive = 0;
            $distanceNegative = 0;

            foreach ($row as $j => $value) {
                $distancePositive += pow($value - $idealSolutions['positive'][$j], 2);
                $distanceNegative += pow($value - $idealSolutions['negative'][$j], 2);
            }

            $distances[$i] = [
                'positive' => sqrt($distancePositive),
                'negative' => sqrt($distanceNegative)
            ];
        }

        return $distances;
    }

    private function calculatePreferences($distances)
    {
        $preferences = [];

        foreach ($distances as $i => $distance) {
            $totalDistance = $distance['positive'] + $distance['negative'];
            $preferences[$i] = $totalDistance != 0 ? $distance['negative'] / $totalDistance : 0;
        }

        return $preferences;
    }

    private function calculateRankings($preferences)
    {
        // Urutkan descending dan beri rank
        arsort($preferences);
        $rankings = [];
        $rank = 1;

        foreach ($preferences as $i => $value) {
            $rankings[$i] = $rank++;
        }

        return $rankings;
    }

    private function saveResults($preferences, $rankings, $assessmentId)
    {
        // Hapus hasil sebelumnya
        Topsis_Result::where('assessment_id', $assessmentId)->delete();

        $suppliers = $this->suppliers;
        $results = [];

        foreach ($preferences as $supplierIndex => $preference) {
            $supplier = $suppliers[$supplierIndex];

            $result = Topsis_Result::create([
                'assessment_id' => $assessmentId,
                'supplier_id' => $supplier->id,
                'preference_score' => $preference,
                'rank' => $rankings[$supplierIndex],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $results[] = $result->load('supplier');
        }

        return $results;
    }

    // Method untuk mendapatkan hasil TOPSIS
    public function getResults($assessmentId)
    {
        return Topsis_Result::with('supplier')
            ->where('assessment_id', $assessmentId)
            ->orderBy('rank')
            ->get();
    }

    // Method untuk debugging
    public function getCalculationSteps($assessmentId)
    {
        $this->loadData($assessmentId);
        
        $steps = [];
        $steps['criteria'] = $this->criteria;
        $steps['suppliers'] = $this->suppliers;
        $steps['decision_matrix'] = $this->createDecisionMatrix();
        $steps['normalized_matrix'] = $this->normalizeMatrix($steps['decision_matrix']);
        $steps['weighted_matrix'] = $this->applyWeights($steps['normalized_matrix']);
        $steps['ideal_solutions'] = $this->calculateIdealSolutions($steps['weighted_matrix']);
        $steps['distances'] = $this->calculateDistances($steps['weighted_matrix'], $steps['ideal_solutions']);
        $steps['preferences'] = $this->calculatePreferences($steps['distances']);
        $steps['rankings'] = $this->calculateRankings($steps['preferences']);

        return $steps;
    }
}