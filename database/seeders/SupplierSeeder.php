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
            'nama_supplier' => 'Bpk. Suyadi',
            'alamat' => 'No Rek: 7064702887 A/N MUFTIKHAH',
            'kontak' => '0817742732',
            'kategori_material' => 'JASA, CUTTING, HEXAGONAL & ST41 DIA BESAR',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP002',
            'nama_supplier' => 'CV. Bilah Jaya Mandiri',
            'alamat' => 'BCA, A/N Siti Halimah: 5680711854',
            'kontak' => '08211113115',
            'kategori_material' => 'JASA, PLATTING, BOLT LIFTING, CAP NUT',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP003',
            'nama_supplier' => 'CV. Java Coat Sedulur',
            'alamat' => 'Mandiri, a/n: CV. Java Coat S: 156 00 12478519',
            'kontak' => '081383315930',
            'kategori_material' => 'JASA, PAINTING, STARTING HANDLE',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP004',
            'nama_supplier' => 'CV. KREASINDO BERKAH MANDIRI',
            'alamat' => 'BCA A.N MUHAMAD KOHARUDIN 5681053141',
            'kontak' => '081317790407',
            'kategori_material' => 'JASA, MACHINING, SPACER CAMSHAFT',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP005',
            'nama_supplier' => 'CV. Masa Baru',
            'alamat' => 'BCA, A/N Lusi Triwulansari: 5220411887',
            'kontak' => '085691372337',
            'kategori_material' => 'JASA, PLATTING, ALL',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP006',
            'nama_supplier' => 'CV. Putra Primatama',
            'alamat' => 'Mandiri, a/n: Putra Primatama: 133.00 11907136',
            'kontak' => '085782851532',
            'kategori_material' => 'JASA, MACHINING, CUTTING STARTING HANDLE, NUTSTAR GEAR, SPACER CAMSHAFT',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP007',
            'nama_supplier' => 'CV. Sinar Sinergi Sejahtera',
            'alamat' => 'Mandiri, a/n: Karta Raharja: 166-00-0121177-0',
            'kontak' => null,
            'kategori_material' => 'JASA, PLATTING, ALL',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP008',
            'nama_supplier' => 'CV. TIARA TEKNIK TRANSPORTASI',
            'alamat' => 'BCA A.N TIARA TEKNIK T: 5521337337',
            'kontak' => '081212850447',
            'kategori_material' => 'MATERIAL, S45C DIS 10.15, GLS & SLR',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP009',
            'nama_supplier' => 'JMC Serviceport',
            'alamat' => 'BCA, a/n Joko Maryanto: 6430018254',
            'kontak' => '081389512801',
            'kategori_material' => 'JASA, MAINTENANCE, CNC',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP010',
            'nama_supplier' => 'MITRA TEKNINDO',
            'alamat' => 'BCA A.N ABDUL HARIS BUDIYΑΝΤΟ 7390692123',
            'kontak' => '081319926252',
            'kategori_material' => 'JASA, MILLING, GLS',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP011',
            'nama_supplier' => 'MIUGIONO',
            'alamat' => null,
            'kontak' => null,
            'kategori_material' => null,
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP012',
            'nama_supplier' => 'MT ELECTRICT',
            'alamat' => 'BCA 8420822490 SAEPUL ANWAR',
            'kontak' => null,
            'kategori_material' => 'JASA, MAINTENANCE, ALL MACHINE',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP013',
            'nama_supplier' => 'MUARA TEKNIK',
            'alamat' => null,
            'kontak' => null,
            'kategori_material' => 'JASA, MAINTENANCE, ALL MACHINE',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP014',
            'nama_supplier' => 'Pak Sumarno',
            'alamat' => 'Permata: 1222963539 A/N Sumarno',
            'kontak' => '081223337789',
            'kategori_material' => 'JASA, MACHINING, PIN GW, COLLAR DAN GLS',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP015',
            'nama_supplier' => 'PT. ADI PERTIWI',
            'alamat' => 'BRIA.N PT.ADI PERTIWI 041601001246303',
            'kontak' => null,
            'kategori_material' => 'JASA, MAINTENANCE, ALL MACHINE',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP016',
            'nama_supplier' => 'PT. ASSA KITA BERSAMA',
            'alamat' => 'MANDIRI A.N PT.ASSA KIBE: 1240010900000',
            'kontak' => '081256546356',
            'kategori_material' => 'MATERIAL, PIPA SCH, SPACER CAMSHAFT',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP017',
            'nama_supplier' => 'PT. Buana Reka Arka',
            'alamat' => 'BCA A.N PT. BUANA REKA ARKA 5221428880',
            'kontak' => '085782827675',
            'kategori_material' => 'JASA, MACHINING, IDLE SHAFT',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP018',
            'nama_supplier' => 'PT. DUTA LUBRINDO BERJAYA',
            'alamat' => 'BCA, A/N PT DUTA LUBRINDO BERJAYA: 2873100338',
            'kontak' => '0817163337',
            'kategori_material' => 'MATERIAL, LUBRICATION, DRUMUS, ANTI KARAT',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP019',
            'nama_supplier' => 'PT. FANFEIF',
            'alamat' => 'PIC: KHOSMA',
            'kontak' => null,
            'kategori_material' => 'MATERIAL, KARDUS',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP020',
            'nama_supplier' => 'PT. Fuji Tanindo',
            'alamat' => 'Mandiri, a/n: PT. Fuji Tanindo Jaya: 133-00-1259167-3',
            'kontak' => '081212183333',
            'kategori_material' => 'JASA, MACHINING, NUT START GEAR',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP021',
            'nama_supplier' => 'PT. Galih Ayom Paramesti',
            'alamat' => 'Permata 0395146009 A/N PT Galih Ayom Paramesti',
            'kontak' => '08119757888',
            'kategori_material' => 'JASA, MACHINING, ISG, PIN PISTON',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP022',
            'nama_supplier' => 'PT. HUTAMA MAJU SUKSES',
            'alamat' => 'BCA, A/N PT HUTAMA MAJU SUKSES: 7010680888',
            'kontak' => '083874172481',
            'kategori_material' => 'MATERIAL, PIPA SCH, ST41, HEXAGONAL, ALL',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP023',
            'nama_supplier' => 'PT. KMPD HEAT TECH',
            'alamat' => 'BCA, A/N PT KMPD HEAT TECH:481 206 8168',
            'kontak' => '081315141357',
            'kategori_material' => 'JASA, INDUCTION, HEAT TREATMENT, GLS, ISG, PIN PISTON',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP024',
            'nama_supplier' => 'PT. Multi Steel Diluch',
            'alamat' => 'BCA, A/N PT. MULTI STELL DILUCH 7130302968',
            'kontak' => '082221119594',
            'kategori_material' => 'MATERIAL, S45C DIS 10.15 DAN 6.3, PIN GW, GLS',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP025',
            'nama_supplier' => 'PT. PRESISI METALINDO EKATAMA',
            'alamat' => 'CIMB, A/N PT. Presisi Metalindo Ekatama: 800087294100',
            'kontak' => '081317226537',
            'kategori_material' => 'JASA, MACHINING, ISG',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP026',
            'nama_supplier' => 'PT. SOLUSI BAJA INDONESIA',
            'alamat' => 'BCA A.N SOLUSI BAJA INDONESIA 3722177077',
            'kontak' => '0818622535',
            'kategori_material' => 'MATERIAL, SS400',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP027',
            'nama_supplier' => 'SUMBER BAJA',
            'alamat' => 'BCA AN SUMBER BAJA 7380779000',
            'kontak' => '087874152109',
            'kategori_material' => 'MATERIAL, BESI BETON, STARTING HANDLE',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP028',
            'nama_supplier' => 'UD. Cantenan',
            'alamat' => null,
            'kontak' => '08122789560',
            'kategori_material' => 'JASA, MACHINING, SPACER BAN',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP029',
            'nama_supplier' => 'UD. HEDINDO',
            'alamat' => 'BCA A.N EMMY NATALIA ROSDIANA 241.007.3806',
            'kontak' => null,
            'kategori_material' => 'MATERIAL, PIPA STKM, STARTING HANDLE',
            'status' => 'active'
        ],
        [
            'kode_supplier' => 'SUP030',
            'nama_supplier' => 'YANMAR',
            'alamat' => '-',
            'kontak' => null,
            'kategori_material' => 'MATERIAL, PIPA STKM, STARTING HANDLE, ALL MACHINE',
            'status' => 'active'
        ]
    ];

        DB::table('suppliers')->insert($suppliers);

        $this->command->info('Data suppliers berhasil ditambahkan!');
    }
}
