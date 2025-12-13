<?php

namespace App\Imports;

use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        {
            // dd($row);
            if (!isset($row['nama_supplier']) || !isset($row['alamat_supplier']) || !isset($row['kontak'])) {
                dd('Nama Supplier, Alamat, Kontak Tidak Boleh Kosong'.$row['nama_supplier'].''.$row['alamat'].''.$row['kontak'].'');
                continue; 
            }

            $supplier = Supplier::where('nama_supplier', $row['nama_supplier'])
            ->where('alamat', $row['alamat_supplier'])
            ->where('kontak', $row['kontak'])->first();

            if (!$supplier) {
                $unique_code = 'SUP'. Carbon::now()->format('YmdHis') . rand(100,999);
                // Tentukan nilai status yang sesuai dengan constraint database Anda.
                // Asumsi: Database Anda hanya menerima 'Aktif' dengan A kapital.
                $status_input = trim($row['status']); 
                // Logika Normalisasi Status (Pilih salah satu):
                
                // Opsi A: Paksa Status menjadi 'Active' (Case-Sensitive, jika database Anda butuh ini)
                $normalized_status = ($status_input == 'Active' || $status_input == 'active') ? 'Active' : 'Nonactive'; 

                Supplier::create([
                    'nama_supplier' => $row['nama_supplier'],
                    'alamat' => $row['alamat_supplier'],
                    'kontak' => $row['kontak'],
                    'kategori_material' => $row['kategori_material'],
                    'status' => strtolower($normalized_status), 
                    'kode_supplier' => $unique_code,
                ]);
            }else {
                dd('Supplier Sudah Ada'.$row['nama_supplier'].''.$row['alamat_supplier'].''.$row['kontak'].'');
                continue;
            }
        }
    }
}
