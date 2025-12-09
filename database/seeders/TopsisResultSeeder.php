<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Topsis_Result;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopsisResultSeeder extends Seeder
{
     public function run(): void
    {
        $this->command->info('Starting TOPSIS Results Seeder...');
        
        // Skip if already has data
        if (Topsis_Result::count() > 0) {
            $this->command->info('TOPSIS results already exist. Skipping...');
            return;
        }
        
        // Method 1: Try to find assessment with raw SQL
        $assessment = $this->findAssessmentWithMultipleSuppliers();
        
        if (!$assessment) {
            $this->command->warn('No suitable assessment found. Creating dummy data...');
            $this->createDummyTopsisResults();
            return;
        }
        
        $this->createTopsisResultsForAssessment($assessment);
    }
    
    /**
     * Find assessment with at least 2 suppliers using raw SQL
     */
    private function findAssessmentWithMultipleSuppliers()
    {
        $sql = "
            SELECT a.id, COUNT(DISTINCT as2.supplier_id) as supplier_count
            FROM assessments a
            JOIN assessment_scores as2 ON a.id = as2.assessment_id
            GROUP BY a.id
            HAVING COUNT(DISTINCT as2.supplier_id) >= 2
            LIMIT 1
        ";
        
        $result = \DB::select($sql);
        
        if (empty($result)) {
            return null;
        }
        
        return Assessment::find($result[0]->id);
    }
    
    /**
     * Create TOPSIS results for a specific assessment
     */
    private function createTopsisResultsForAssessment($assessment)
    {
        $this->command->info("Creating TOPSIS results for assessment #{$assessment->id}");
        
        // Get unique suppliers
        $supplierIds = \DB::table('assessment_scores')
            ->where('assessment_id', $assessment->id)
            ->select('supplier_id')
            ->distinct()
            ->pluck('supplier_id');
        
        // Generate preference scores (higher average score = higher preference)
        $results = [];
        
        foreach ($supplierIds as $supplierId) {
            $avgScore = \DB::table('assessment_scores')
                ->where('assessment_id', $assessment->id)
                ->where('supplier_id', $supplierId)
                ->avg('score');
            
            // Convert to preference score (0.2 - 0.9)
            $preferenceScore = 0.2 + (($avgScore / 100) * 0.7);
            $preferenceScore = round(min(0.9, max(0.2, $preferenceScore)), 6);
            
            $results[] = [
                'supplier_id' => $supplierId,
                'score' => $preferenceScore,
                'avg_original' => $avgScore,
            ];
        }
        
        // Sort by score descending
        usort($results, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Save with rank
        foreach ($results as $index => $result) {
            Topsis_Result::create([
                'assessment_id' => $assessment->id,
                'supplier_id' => $result['supplier_id'],
                'preference_score' => $result['score'],
                'rank' => $index + 1,
                'calculation_details' => json_encode([
                    'generated_from_avg' => $result['avg_original'],
                    'method' => 'average_score_based',
                    'note' => 'Seeder generated - for testing',
                ]),
                'created_at' => $assessment->created_at ?? now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info("Created " . count($results) . " TOPSIS results.");
    }
    
    /**
     * Create dummy TOPSIS results if no real data exists
     */
    private function createDummyTopsisResults()
    {
        // Find any assessment
        $assessment = Assessment::first();
        
        if (!$assessment) {
            $this->command->error('No assessments found at all!');
            return;
        }
        
        // Find any suppliers
        $suppliers = \DB::table('suppliers')->limit(3)->get();
        
        if ($suppliers->count() < 2) {
            $this->command->error('Need at least 2 suppliers to create TOPSIS results.');
            return;
        }
        
        // Create dummy rank
        $rank = 1;
        foreach ($suppliers as $supplier) {
            $preferenceScore = 0.9 - (($rank - 1) * 0.2);
            $preferenceScore = round(max(0.1, $preferenceScore), 6);
            
            Topsis_Result::create([
                'assessment_id' => $assessment->id,
                'supplier_id' => $supplier->id,
                'preference_score' => $preferenceScore,
                'rank' => $rank,
                'calculation_details' => json_encode([
                    'note' => 'Dummy data - no real scores available',
                    'type' => 'placeholder',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->command->info("Created dummy TOPSIS result for supplier #{$supplier->id} (rank {$rank})");
            $rank++;
        }
    }
}
