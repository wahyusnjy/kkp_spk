<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SupplierReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithEvents
{
    protected $suppliers;
    protected $summary;
    protected $includeSummary;
    
    public function __construct($suppliers, $summary, $includeSummary = true)
    {
        $this->suppliers = $suppliers;
        $this->summary = $summary;
        $this->includeSummary = $includeSummary;
    }
    
    public function collection()
    {
        return $this->suppliers;
    }
    
    public function headings(): array
    {
        return [
            'Kode Supplier',
            'Nama Supplier',
            'Kategori Material',
            'Alamat',
            'Telepon',
            'Email',
            'Status',
            'Tanggal Bergabung',
            'Keterangan',
        ];
    }
    
    public function map($supplier): array
    {
        return [
            $supplier->kode_supplier,
            $supplier->nama_supplier,
            $supplier->kategori_material ?? 'Umum',
            $supplier->alamat ?? '-',
            $supplier->kontak ?? '-',
            $supplier->email ?? '-',
            $supplier->status == 'aktif' ? 'Aktif' : 'Non-Aktif',
            \Carbon\Carbon::parse($supplier->created_at)->format('d/m/Y'),
            $supplier->keterangan ?? '-',
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->suppliers->count() + 1; // +1 for header
        
        // Apply styles to header
        $sheet->getStyle('A1:I1')->applyFromArray([
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
        $sheet->getStyle('A1:I' . $rowCount)->applyFromArray([
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
        foreach(range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Apply alternate row colors
        for ($i = 2; $i <= $rowCount; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle('A' . $i . ':I' . $i)->applyFromArray([
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
        return 'Laporan Supplier';
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
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'LAPORAN SUPPLIER');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Add date
        $sheet->mergeCells('A2:I2');
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
        
        $sheet->setCellValue('A5', 'Total Supplier');
        $sheet->setCellValue('B5', $this->summary['total_supplier']);
        
        $sheet->setCellValue('A6', 'Supplier Aktif');
        $sheet->setCellValue('B6', $this->summary['active_supplier']);
        
        $sheet->setCellValue('A7', 'Supplier Non-Aktif');
        $sheet->setCellValue('B7', $this->summary['inactive_supplier']);
        
        $sheet->setCellValue('A8', 'Total Kategori');
        $sheet->setCellValue('B8', $this->summary['total_category']);
        
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
            array_merge([$this->headings()], $this->suppliers->map(function($item) {
                return $this->map($item);
            })->toArray()),
            null,
            'A10',
            true
        );
        
        // Adjust column widths after adding summary
        foreach(range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }
}