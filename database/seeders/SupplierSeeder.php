<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'kode_supplier' => 'SUP001',
                'nama_supplier' => 'PT. Logam Jaya Abadi',
                'alamat' => 'Jl. Industri Raya No. 123, Jakarta Utara',
                'kontak' => '021-1234567',
                'kategori_material' => 'baja,stainless_steel',
                'status' => 'active'
            ],
            [
                'kode_supplier' => 'SUP002',
                'nama_supplier' => 'CV. Aluminium Prima',
                'alamat' => 'Jl. Teknologi No. 45, Tangerang',
                'kontak' => '021-7654321',
                'kategori_material' => 'aluminium,kuningan',
                'status' => 'active'
            ],
            [
                'kode_supplier' => 'SUP003',
                'nama_supplier' => 'PT. Tembaga Mulia',
                'alamat' => 'Jl. Logam Mulia No. 67, Bekasi',
                'kontak' => '021-8901234',
                'kategori_material' => 'tembaga,kuningan',
                'status' => 'active'
            ],
            [
                'kode_supplier' => 'SUP004',
                'nama_supplier' => 'UD. Besi Kuat',
                'alamat' => 'Jl. Pahlawan No. 89, Cikarang',
                'kontak' => '021-5678901',
                'kategori_material' => 'besi,baja',
                'status' => 'active'
            ],
            [
                'kode_supplier' => 'SUP005',
                'nama_supplier' => 'PT. Stainless Steel Indonesia',
                'alamat' => 'Jl. Modern No. 234, Karawang',
                'kontak' => '021-2345678',
                'kategori_material' => 'stainless_steel',
                'status' => 'active'
            ],
            [
                'kode_supplier' => 'SUP006',
                'nama_supplier' => 'CV. Magnesium Teknik',
                'alamat' => 'Jl. Inovasi No. 56, Bogor',
                'kontak' => '0251-345678',
                'kategori_material' => 'magnesium,aluminium',
                'status' => 'active'
            ],
            [
                'kode_supplier' => 'SUP007',
                'nama_supplier' => 'PT. Titanium Nusantara',
                'alamat' => 'Jl. High Tech No. 78, Serpong',
                'kontak' => '021-4567890',
                'kategori_material' => 'titanium',
                'status' => 'active'
            ]
        ];

        DB::table('suppliers')->insert($suppliers);

        $this->command->info('Data suppliers berhasil ditambahkan!');
    }
}
