<?php

namespace App\Exports;

use App\Models\Assessment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AsessmentReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithEvents
{
    protected $assessments;
    protected $summary;
    protected $includeSummary;
    
    public function __construct($assessments, $summary, $includeSummary = true)
    {
        $this->assessments = $assessments;
        $this->summary = $summary;
        $this->includeSummary = $includeSummary;
    }
    
    public function collection()
    {
        return $this->assessments;
    }
    
    public function headings(): array
    {
        return [
            'ID Assessment',
            'Material',
            'Tahun',
            'Deskripsi',
            'Jumlah Supplier',
            'Status',
            'Pemenang',
            'Score Pemenang',
            'Tanggal Dibuat',
        ];
    }
    
    public function map($assessment): array
    {
        $winner = $assessment->topsisResults()->orderBy('rank')->first();
        $status = $assessment->status;
        
        if ($status === 'completed') {
            $statusText = 'Selesai';
        } elseif ($status === 'scoring') {
            $statusText = 'Scoring';
        } else {
            $statusText = 'Draft';
        }
        
        return [
            $assessment->id,
            $assessment->material->nama_material ?? '-',
            $assessment->tahun,
            $assessment->deskripsi ?? '-',
            $assessment->supplier_count,
            $statusText,
            $winner ? $winner->supplier->nama_supplier : '-',
            $winner ? number_format($winner->preference_score * 100, 2) . '%' : '-',
            \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y H:i'),
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->assessments->count() + 1; // +1 for header
        
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
        return 'Laporan Assessment';
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
        $sheet->setCellValue('A1', 'LAPORAN ASSESSMENT');
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
        
        $sheet->setCellValue('A5', 'Total Assessment');
        $sheet->setCellValue('B5', $this->summary['total_assessment']);
        
        $sheet->setCellValue('A6', 'Assessment Selesai');
        $sheet->setCellValue('B6', $this->summary['completed_assessment']);
        
        $sheet->setCellValue('A7', 'Assessment Dalam Proses');
        $sheet->setCellValue('B7', $this->summary['in_progress_assessment']);
        
        $sheet->setCellValue('A8', 'Total Supplier Dinilai');
        $sheet->setCellValue('B8', $this->summary['total_suppliers_assessed']);
        
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
            array_merge([$this->headings()], $this->assessments->map(function($item) {
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
