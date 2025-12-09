<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\AssessmentScore;
use App\Models\Kriteria;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assessments = Assessment::all();
        $suppliers = Supplier::all();
        $kriterias = Kriteria::all();
        
        foreach ($assessments as $assessment) {
            // Ambil 3-4 supplier random
            $selectedSuppliers = $suppliers->random(rand(3, 4));
            
            foreach ($selectedSuppliers as $supplier) {
                // Beri nilai untuk SETIAP kriteria
                foreach ($kriterias as $kriteria) {
                    AssessmentScore::create([
                        'assessment_id' => $assessment->id,
                        'supplier_id' => $supplier->id,
                        'kriteria_id' => $kriteria->id,
                        'score' => rand(60, 95), // Nilai sederhana
                    ]);
                }
            }
        }
    }
}
