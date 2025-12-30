<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        {
            // Validasi kolom wajib
            if (!isset($row['nama_material'])) {
                dd('Nama Material Tidak Boleh Kosong: ' . json_encode($row));
                continue; 
            }

            // Cari supplier berdasarkan nama
            $supplier = null;
            if (isset($row['supplier'])) {
                $supplier = Supplier::where('nama_supplier', $row['supplier'])->first();
            }

            // Cek apakah material sudah ada berdasarkan nama material
            $existingMaterial = Material::where('nama_material', $row['nama_material'])
                ->where('supplier_id', $supplier ? $supplier->id : null)
                ->first();

            if (!$existingMaterial) {
                // Buat material baru
                Material::create([
                    'nama_material' => $row['nama_material'],
                    'supplier_id' => $supplier ? $supplier->id : null,
                    'jenis_logam' => $row['jenis_logam'] ?? null,
                    'grade' => $row['grade'] ?? null,
                    'spesifikasi_teknis' => $row['spesifikasi_teknis'] ?? null,
                    'harga_per_kg' => isset($row['harga_per_kg']) ? (float) str_replace(['.', ','], ['', '.'], $row['harga_per_kg']) : 0,
                ]);
            } else {
                dd('Material Sudah Ada: ' . $row['nama_material'] . ' dari Supplier: ' . ($supplier ? $supplier->nama_supplier : 'Tidak ada'));
                continue;
            }
        }
    }
}
