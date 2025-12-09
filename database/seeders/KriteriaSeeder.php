<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriterias = [
            [
                'nama_kriteria' => 'Harga Material',
                'type' => 'cost',
                'bobot' => 0.2500,
                'keterangan' => 'Harga per kg material, semakin murah semakin baik'
            ],
            [
                'nama_kriteria' => 'Kualitas Material',
                'type' => 'benefit',
                'bobot' => 0.3000,
                'keterangan' => 'Tingkat kualitas material berdasarkan standar industri'
            ],
            [
                'nama_kriteria' => 'Waktu Pengiriman',
                'type' => 'cost',
                'bobot' => 0.2000,
                'keterangan' => 'Rata-rata waktu pengiriman dalam hari, semakin cepat semakin baik'
            ],
            [
                'nama_kriteria' => 'Fleksibilitas Pesanan',
                'type' => 'benefit',
                'bobot' => 0.1500,
                'keterangan' => 'Kemampuan memenuhi pesanan khusus dan perubahan order'
            ],
            [
                'nama_kriteria' => 'Reputasi Supplier',
                'type' => 'benefit',
                'bobot' => 0.1000,
                'keterangan' => 'Track record dan pengalaman supplier di industri'
            ]
        ];

        DB::table('kriterias')->insert($kriterias);

        $this->command->info('Data kriterias berhasil ditambahkan!');
    }
}
