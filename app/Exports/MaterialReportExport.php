<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithEvents
{
    protected $materials;
    protected $summary;
    protected $includeSummary;
    
    public function __construct($materials, $summary, $includeSummary = true)
    {
        $this->materials = $materials;
        $this->summary = $summary;
        $this->includeSummary = $includeSummary;
    }
    
    public function collection()
    {
        return $this->materials;
    }
    
    public function headings(): array
    {
        return [
            'Nama Material',
            'Supplier',
            'Jenis Logam',
            'Grade',
            'Spesifikasi Teknis',
            'Harga per Kg (Rp)',
            'Tanggal Ditambahkan',
        ];
    }
    
    public function map($material): array
    {
        return [
            $material->nama_material,
            $material->supplier ? $material->supplier->nama_supplier : '-',
            $material->jenis_logam ?? '-',
            $material->grade ?? '-',
            $material->spesifikasi_teknis ?? '-',
            number_format($material->harga_per_kg ?? 0, 0, ',', '.'),
            \Carbon\Carbon::parse($material->created_at)->format('d/m/Y'),
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->materials->count() + 1; // +1 for header
        
        // Apply styles to header
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        
        // Apply borders to all data cells
        $sheet->getStyle('A1:G' . $rowCount)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        
        // Auto size columns
        foreach(range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Apply alternate row colors
        for ($i = 2; $i <= $rowCount; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle('A' . $i . ':G' . $i)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3F4F6']
                    ]
                ]);
            }
        }
        
        return [];
    }
    
    public function title(): string
    {
        return 'Laporan Material';
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                if ($this->includeSummary) {
                    $this->addSummarySheet($event);
                }
            },
        ];
    }
    
    private function addSummarySheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        
        // Add summary section at the top
        $sheet->insertNewRowBefore(1, 8);
        
        // Add title
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'LAPORAN MATERIAL');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Add date
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'Tanggal Export: ' . date('d/m/Y H:i:s'));
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Add summary section
        $sheet->setCellValue('A4', 'RINGKASAN');
        $sheet->getStyle('A4')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
        ]);
        
        $sheet->setCellValue('A5', 'Total Material');
        $sheet->setCellValue('B5', $this->summary['total_material']);
        
        $sheet->setCellValue('A6', 'Total Jenis Logam');
        $sheet->setCellValue('B6', $this->summary['total_jenis_logam']);
        
        $sheet->setCellValue('A7', 'Harga Tertinggi');
        $sheet->setCellValue('B7', 'Rp ' . number_format($this->summary['harga_tertinggi'], 0, ',', '.'));
        
        $sheet->setCellValue('A8', 'Harga Terendah');
        $sheet->setCellValue('B8', 'Rp ' . number_format($this->summary['harga_terendah'], 0, ',', '.'));
        
        // Style summary section
        $sheet->getStyle('A5:B8')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        
        // Move original data down
        $sheet->fromArray(
            array_merge([$this->headings()], $this->materials->map(function($item) {
                return $this->map($item);
            })->toArray()),
            null,
            'A10',
            true
        );
        
        // Adjust column widths after adding summary
        foreach(range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }
}
