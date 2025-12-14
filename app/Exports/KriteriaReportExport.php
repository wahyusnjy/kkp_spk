<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KriteriaReportExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithEvents
{
    protected $kriterias;
    protected $summary;

    public function __construct($kriterias, $summary)
    {
        $this->kriterias = $kriterias;
        $this->summary = $summary;
    }

    public function collection()
    {
        return $this->kriterias->map(function($kriteria, $index) {
            return [
                $index + 1,
                $kriteria->nama_kriteria,
                $kriteria->type == 'benefit' ? 'Benefit' : 'Cost',
                $kriteria->bobot,
                $kriteria->usage_count,
                number_format($kriteria->avg_score, 2),
                number_format($kriteria->max_score, 2),
                number_format($kriteria->min_score, 2),
                $kriteria->keterangan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kriteria',
            'Tipe',
            'Bobot',
            'Digunakan (Assessment)',
            'Rata-rata Score',
            'Max Score',
            'Min Score',
            'Keterangan',
        ];
    }

    public function title(): string
    {
        return 'Laporan Kriteria';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns
                foreach(range('A', 'I') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }

                // Add summary at top
                $event->sheet->getDelegate()->insertNewRowBefore(1, 5);
                
                $event->sheet->getDelegate()->setCellValue('A1', 'LAPORAN KRITERIA LENGKAP');
                $event->sheet->getDelegate()->mergeCells('A1:I1');
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E40AF']],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Summary row
                $event->sheet->getDelegate()->setCellValue('A3', 'Total Kriteria: ' . $this->summary['total_kriteria']);
                $event->sheet->getDelegate()->setCellValue('C3', 'Benefit: ' . $this->summary['benefit_count']);
                $event->sheet->getDelegate()->setCellValue('E3', 'Cost: ' . $this->summary['cost_count']);
                $event->sheet->getDelegate()->setCellValue('G3', 'Total Bobot: ' . number_format($this->summary['total_weight'], 1));
                
                $event->sheet->getDelegate()->getStyle('A3:I3')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFF6FF']],
                ]);

                // Header row (now at row 6)
                $event->sheet->getDelegate()->getStyle('A6:I6')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Alternate row colors
                $lastRow = $event->sheet->getDelegate()->getHighestRow();
                for ($row = 7; $row <= $lastRow; $row++) {
                    if ($row % 2 == 0) {
                        $event->sheet->getDelegate()->getStyle("A{$row}:I{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8FAFC']],
                        ]);
                    }
                }
            },
        ];
    }
}
