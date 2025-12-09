<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            // Supplier 1 - PT. Logam Jaya Abadi
            [
                'supplier_id' => 1,
                'nama_material' => 'Baja Karbon Plate A36',
                'jenis_logam' => 'baja',
                'grade' => 'A36',
                'spesifikasi_teknis' => 'Tebal: 10-50mm, Yield Strength: 250 MPa, Tensile Strength: 400-550 MPa',
                'harga_per_kg' => 12500.00
            ],
            [
                'supplier_id' => 1,
                'nama_material' => 'Stainless Steel Sheet 304',
                'jenis_logam' => 'stainless_steel',
                'grade' => '304',
                'spesifikasi_teknis' => 'Tebal: 0.5-3mm, Finish: 2B, Corrosion Resistance: Excellent',
                'harga_per_kg' => 45000.00
            ],
            [
                'supplier_id' => 1,
                'nama_material' => 'Baja Structural Beam',
                'jenis_logam' => 'baja',
                'grade' => 'A992',
                'spesifikasi_teknis' => 'Profile: H-Beam, Size: 100x100mm to 400x400mm',
                'harga_per_kg' => 13500.00
            ],

            // Supplier 2 - CV. Aluminium Prima
            [
                'supplier_id' => 2,
                'nama_material' => 'Aluminium Sheet 6061',
                'jenis_logam' => 'aluminium',
                'grade' => '6061-T6',
                'spesifikasi_teknis' => 'Tebal: 1-12mm, Temper: T6, Anodized Finish',
                'harga_per_kg' => 38000.00
            ],
            [
                'supplier_id' => 2,
                'nama_material' => 'Aluminium Extrusion Profile',
                'jenis_logam' => 'aluminium',
                'grade' => '6063-T5',
                'spesifikasi_teknis' => 'Profile: Various shapes, Surface: Mill finish',
                'harga_per_kg' => 35000.00
            ],
            [
                'supplier_id' => 2,
                'nama_material' => 'Kuningan Sheet C2600',
                'jenis_logam' => 'kuningan',
                'grade' => 'C2600',
                'spesifikasi_teknis' => 'Tebal: 0.3-2mm, Excellent machinability',
                'harga_per_kg' => 85000.00
            ],

            // Supplier 3 - PT. Tembaga Mulia
            [
                'supplier_id' => 3,
                'nama_material' => 'Tembaga Pipe ASTM B88',
                'jenis_logam' => 'tembaga',
                'grade' => 'C12200',
                'spesifikasi_teknis' => 'Diameter: 15-100mm, Type: K/L/M, For plumbing applications',
                'harga_per_kg' => 120000.00
            ],
            [
                'supplier_id' => 3,
                'nama_material' => 'Tembaga Busbar',
                'jenis_logam' => 'tembaga',
                'grade' => 'C11000',
                'spesifikasi_teknis' => 'Size: 3mm x 25mm to 10mm x 100mm, High conductivity',
                'harga_per_kg' => 115000.00
            ],
            [
                'supplier_id' => 3,
                'nama_material' => 'Kuningan Rod C3604',
                'jenis_logam' => 'kuningan',
                'grade' => 'C3604',
                'spesifikasi_teknis' => 'Diameter: 5-50mm, Free cutting brass',
                'harga_per_kg' => 92000.00
            ],

            // Supplier 4 - UD. Besi Kuat
            [
                'supplier_id' => 4,
                'nama_material' => 'Besi Beton Polos',
                'jenis_logam' => 'besi',
                'grade' => 'BJTP 24',
                'spesifikasi_teknis' => 'Diameter: 6-32mm, Yield Strength: 240 MPa',
                'harga_per_kg' => 10500.00
            ],
            [
                'supplier_id' => 4,
                'nama_material' => 'Besi Beton Ulir',
                'jenis_logam' => 'besi',
                'grade' => 'BJTS 40',
                'spesifikasi_teknis' => 'Diameter: 10-32mm, Yield Strength: 400 MPa',
                'harga_per_kg' => 11200.00
            ],

            // Supplier 5 - PT. Stainless Steel Indonesia
            [
                'supplier_id' => 5,
                'nama_material' => 'Stainless Steel 316L',
                'jenis_logam' => 'stainless_steel',
                'grade' => '316L',
                'spesifikasi_teknis' => 'Excellent corrosion resistance, Marine grade',
                'harga_per_kg' => 68000.00
            ],
            [
                'supplier_id' => 5,
                'nama_material' => 'Stainless Steel 430',
                'jenis_logam' => 'stainless_steel',
                'grade' => '430',
                'spesifikasi_teknis' => 'Magnetic, Good corrosion resistance, Cost effective',
                'harga_per_kg' => 38000.00
            ],

            // Supplier 6 - CV. Magnesium Teknik
            [
                'supplier_id' => 6,
                'nama_material' => 'Magnesium Alloy AZ91D',
                'jenis_logam' => 'magnesium',
                'grade' => 'AZ91D',
                'spesifikasi_teknis' => 'Die casting alloy, Good corrosion resistance',
                'harga_per_kg' => 95000.00
            ],

            // Supplier 7 - PT. Titanium Nusantara
            [
                'supplier_id' => 7,
                'nama_material' => 'Titanium Grade 2',
                'jenis_logam' => 'titanium',
                'grade' => 'Grade 2',
                'spesifikasi_teknis' => 'Commercial pure titanium, Excellent corrosion resistance',
                'harga_per_kg' => 450000.00
            ],
            [
                'supplier_id' => 7,
                'nama_material' => 'Titanium Grade 5',
                'jenis_logam' => 'titanium',
                'grade' => 'Grade 5 (6Al-4V)',
                'spesifikasi_teknis' => 'Aerospace grade, High strength-to-weight ratio',
                'harga_per_kg' => 680000.00
            ]
        ];

        DB::table('materials')->insert($materials);

        $this->command->info('Data materials berhasil ditambahkan!');
    }
}
