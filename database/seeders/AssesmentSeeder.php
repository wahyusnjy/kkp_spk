<?php

namespace Database\Seeders;

use App\Models\Assessment;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssesmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assessments = [
            [
                'material_id' => 1, // Baja Ringan
                'tahun' => 2024,
                'deskripsi' => 'Penilaian supplier baja ringan untuk proyek Q4 2024',
                'metadata' => json_encode([
                    'proyek' => 'Gedung Perkantoran Sudirman',
                    'volume' => '5000 kg',
                    'periode' => 'Oktober - Desember 2024',
                    'penanggung_jawab' => 'Manager Procurement',
                ]),
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'material_id' => 2, // Baja Profil H
                'tahun' => 2024,
                'deskripsi' => 'Evaluasi supplier profil H untuk konstruksi pabrik',
                'metadata' => json_encode([
                    'proyek' => 'Pabrik Baru Cikarang',
                    'volume' => '200 batang',
                    'periode' => 'November 2024',
                    'penanggung_jawab' => 'Project Manager',
                ]),
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'material_id' => 3, // Besi Beton
                'tahun' => 2023,
                'deskripsi' => 'Assesment supplier besi beton tahunan 2023',
                'metadata' => json_encode([
                    'proyek' => 'Renovasi Gedung Utama',
                    'volume' => '1000 batang',
                    'periode' => 'Tahun Kalender 2023',
                    'penanggung_jawab' => 'Head of Procurement',
                ]),
                'created_at' => Carbon::now()->subMonths(6),
            ],
            [
                'material_id' => 1, // Baja Ringan
                'tahun' => 2023,
                'deskripsi' => 'Penilaian supplier baja ringan proyek tahun 2023',
                'metadata' => json_encode([
                    'proyek' => 'Apartemen Green Park',
                    'volume' => '3000 kg',
                    'periode' => 'Q2 2023',
                    'penanggung_jawab' => 'Procurement Staff',
                ]),
                'created_at' => Carbon::now()->subMonths(9),
            ],
        ];

        foreach ($assessments as $assessment) {
            Assessment::create($assessment);
        }
        
        $this->command->info('Assessments seeded successfully!');
    }
}
