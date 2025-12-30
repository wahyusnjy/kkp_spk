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
        [
            'supplier_id' => 24,
            'nama_material' => 'S45C DIA 6.3',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => '172200-61220(PIN, GOVERNOR WEIGHT)',
            'harga_per_kg' => 1758.0
        ],
        [
            'supplier_id' => 24,
            'nama_material' => 'S45C DIA 6.3',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => '174100-61220(PIN, GOVERNOR WEIGHT)',
            'harga_per_kg' => 2063.0
        ],
        [
            'supplier_id' => 8,
            'nama_material' => 'S45C DIA 10.15',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'GOV.LVR.SHAFT 55/65',
            'harga_per_kg' => 10169.0
        ],
        [
            'supplier_id' => 8,
            'nama_material' => 'S45C DIA 10.15',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'GOV.LVR.SHAFT 75/155',
            'harga_per_kg' => 9930.0
        ],
        [
            'supplier_id' => 8,
            'nama_material' => 'S45C DIA 10.15',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'GOV.LVR.SHAFT270/300',
            'harga_per_kg' => 11195.0
        ],
        [
            'supplier_id' => 8,
            'nama_material' => 'S45C DIA 10.15',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'SHAFT,LEVER 55/65',
            'harga_per_kg' => 5738.0
        ],
        [
            'supplier_id' => 8,
            'nama_material' => 'S45C DIA 10.15',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'PIN,STR.SHAFT270/300',
            'harga_per_kg' => 9039.0
        ],
        [
            'supplier_id' => 8,
            'nama_material' => 'S45C DIA 10.15',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'F.O LIMITER TF120I',
            'harga_per_kg' => 4254.0
        ],
        [
            'supplier_id' => 1,
            'nama_material' => 'S45C DIA 36',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'IDLE SHAFT 75/155',
            'harga_per_kg' => 22982.0
        ],
        [
            'supplier_id' => 1,
            'nama_material' => 'S45C DIA 36',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'IDLE SHAFT 70/105LY',
            'harga_per_kg' => 23859.0
        ],
        [
            'supplier_id' => 1,
            'nama_material' => 'PLAT S45C',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'WASHER NUT M10 ALT 1',
            'harga_per_kg' => 6899.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 8',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'ST.BOLT, AC M8 TF85',
            'harga_per_kg' => 4303.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 8',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'BOLT, AIR CLEANER <105/120NL>',
            'harga_per_kg' => 5297.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 10',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'COLLAR, FO TANK (40)\'',
            'harga_per_kg' => 1537.0
        ],
        [
            'supplier_id' => 8,
            'nama_material' => 'ST41 DIA 10',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'STUD BOLT M10X1.5',
            'harga_per_kg' => 2117.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 12',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'COLLAR, SPACER',
            'harga_per_kg' => 2220.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 12',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'GUIDE(A,DIPSTICK',
            'harga_per_kg' => 3116.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST 41 DIA 12',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'PIPE KNOCK 300',
            'harga_per_kg' => 7647.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 16',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'COLLAR, FO TANK (50)\'',
            'harga_per_kg' => 3087.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 30',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => '104300-76460(NUT, START GEAR)',
            'harga_per_kg' => 5461.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 35',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => '10395G-28450(WASHER, GEAR)',
            'harga_per_kg' => 3117.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 58',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'NUT CAM SHAFT TF300',
            'harga_per_kg' => 9476.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'HEXA 10',
            'jenis_logam' => 'baja',
            'grade' => 'HEXA 10',
            'spesifikasi_teknis' => '105212-01910(BOLT, SPACER)',
            'harga_per_kg' => 3762.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'HEXA 17',
            'jenis_logam' => 'baja',
            'grade' => 'HEXA 17',
            'spesifikasi_teknis' => 'CAP,NUT 10 (LIMITER)',
            'harga_per_kg' => 3020.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'HEXA 17',
            'jenis_logam' => 'baja',
            'grade' => 'HEXA 17',
            'spesifikasi_teknis' => 'NUT,ENG LIFT 105/115',
            'harga_per_kg' => 5019.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'HEXA 19',
            'jenis_logam' => 'baja',
            'grade' => 'HEXA 19',
            'spesifikasi_teknis' => 'NUT, ENG. LIFT 135/155',
            'harga_per_kg' => 6063.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'HEXA 19',
            'jenis_logam' => 'baja',
            'grade' => 'HEXA 19',
            'spesifikasi_teknis' => 'BOLT, LIFTING',
            'harga_per_kg' => 9240.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'HEXA 22',
            'jenis_logam' => 'baja',
            'grade' => 'HEXA 22',
            'spesifikasi_teknis' => 'NUT,ENG LIFT TS230R',
            'harga_per_kg' => 18943.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'PIPA SCH 80 DIA 1 INCH',
            'jenis_logam' => 'besi',
            'grade' => '-',
            'spesifikasi_teknis' => 'SPAC.CAM SHAFT135/155',
            'harga_per_kg' => 5204.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'PIPA SCH 80 DIA 1 INCH',
            'jenis_logam' => 'besi',
            'grade' => '-',
            'spesifikasi_teknis' => 'SPACER CAM SHAFT LY',
            'harga_per_kg' => 6723.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'PIPA SCH 80 DIA 1 1/4 INCH',
            'jenis_logam' => 'besi',
            'grade' => '-',
            'spesifikasi_teknis' => 'SPACER CAM SHAFT 300',
            'harga_per_kg' => 6405.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'PIPA SCH 80 DIA 1 1/4 INCH',
            'jenis_logam' => 'besi',
            'grade' => '-',
            'spesifikasi_teknis' => 'SPACER ST.SHAFT 300',
            'harga_per_kg' => 12065.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'DAR YANMAR',
            'jenis_logam' => 'baja',
            'grade' => '-',
            'spesifikasi_teknis' => 'CYL.REAR COVER TF300',
            'harga_per_kg' => 3692.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 17',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'SPEED SET BOLT(NO.2)',
            'harga_per_kg' => 12981.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 8',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => '',
            'harga_per_kg' => 0.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'PIPA STKM 11A DIA 19 TEBAL 0,8',
            'jenis_logam' => 'baja',
            'grade' => 'STKM',
            'spesifikasi_teknis' => 'GRIP',
            'harga_per_kg' => 0.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 16 (BESI BETON)',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'SHAFT',
            'harga_per_kg' => 0.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'ST41 DIA 17',
            'jenis_logam' => 'baja',
            'grade' => 'ST41',
            'spesifikasi_teknis' => 'RING',
            'harga_per_kg' => 0.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'PO DI KERJAKAN DI GAP',
            'jenis_logam' => 'baja',
            'grade' => '-',
            'spesifikasi_teknis' => 'SLEEVE, GOVERNOR',
            'harga_per_kg' => 10635.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'PO DI KERJAKAN DI GAP',
            'jenis_logam' => 'baja',
            'grade' => '-',
            'spesifikasi_teknis' => 'PIN, PISTON',
            'harga_per_kg' => 13846.0
        ],
        [
            'supplier_id' => 30,
            'nama_material' => 'PLAT S45C',
            'jenis_logam' => 'baja',
            'grade' => 'S45C',
            'spesifikasi_teknis' => 'WASHER NUT M10 ALT 1',
            'harga_per_kg' => 6899.0
        ],
    ];
        DB::table('materials')->insert($materials);

        $this->command->info('Data materials berhasil ditambahkan!');
    }
}
