<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        // Return sample data
        return [
            [
                'Baja Karbon Rendah',
                'PT. Supplier Contoh',
                'Baja',
                'C1020',
                'Baja karbon rendah dengan kadar karbon 0.18-0.23%',
                '15000',
            ],
            [
                'Aluminium Paduan',
                'PT. Supplier Contoh',
                'Aluminium',
                'Al-6061',
                'Aluminium paduan dengan kekuatan tinggi',
                '45000',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'nama_material',
            'supplier',
            'jenis_logam',
            'grade',
            'spesifikasi_teknis',
            'harga_per_kg',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header row
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Auto-size columns
        foreach(range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Add comment to supplier column
        $sheet->getComment('B1')->getText()->createTextRun('Isi dengan nama supplier yang sudah terdaftar di sistem');
        
        return [];
    }
}
