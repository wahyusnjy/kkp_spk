<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExecutiveSummaryExport implements WithMultipleSheets
{
    protected $summary;

    public function __construct($summary)
    {
        $this->summary = $summary;
    }

    public function sheets(): array
    {
        return [
            new ExecutiveSummaryOverviewSheet($this->summary),
            new RecentAssessmentsSheet($this->summary['recent_assessments']),
            new RecentWinnersSheet($this->summary['recent_winners']),
        ];
    }
}

// Sheet 1: Overview
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExecutiveSummaryOverviewSheet implements FromCollection, WithTitle, WithEvents
{
    protected $summary;

    public function __construct($summary)
    {
        $this->summary = $summary;
    }

    public function collection()
    {
        return collect([
            ['EXECUTIVE SUMMARY', '', '', ''],
            [],
            ['STATISTIK ASSESSMENT', '', '', ''],
            ['Total Assessment', $this->summary['total_assessments'], 'Supplier Aktif', $this->summary['active_suppliers']],
            ['Selesai', $this->summary['completed_assessments'], 'Total Supplier', $this->summary['total_suppliers']],
            ['Dalam Proses', $this->summary['in_progress_assessments'], 'Total Kriteria', $this->summary['total_kriteria']],
            ['Draft', $this->summary['draft_assessments'], 'Total Material', $this->summary['total_materials']],
            [],
            ['KRITERIA', '', '', ''],
            ['Benefit', $this->summary['benefit_kriteria'], 'Cost', $this->summary['cost_kriteria']],
            [],
            $this->summary['top_supplier'] ? [
                'SUPPLIER TERBAIK',
                $this->summary['top_supplier']['supplier']->nama_supplier,
                'Menang',
                $this->summary['top_supplier']['win_count'] . ' kali',
            ] : [],
        ]);
    }

    public function title(): string
    {
        return 'Overview';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Title
                $event->sheet->getDelegate()->mergeCells('A1:D1');
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E40AF']],
                    'alignment' => ['horizontal' => 'center'],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
                ]);

                // Section headers
                $event->sheet->getDelegate()->mergeCells('A3:D3');
                $event->sheet->getDelegate()->mergeCells('A9:D9');
                
                $event->sheet->getDelegate()->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']],
                    'font' => ['color' => ['rgb' => 'FFFFFF']],
                ]);
                
                $event->sheet->getDelegate()->getStyle('A9')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']],
                    'font' => ['color' => ['rgb' => 'FFFFFF']],
                ]);

                // Auto-size
                foreach(range('A', 'D') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}

// Sheet 2: Recent Assessments
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RecentAssessmentsSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $assessments;

    public function __construct($assessments)
    {
        $this->assessments = $assessments;
    }

    public function collection()
    {
        return $this->assessments->map(function($assessment, $index) {
            $status = 'Draft';
            if ($assessment->topsisResults->count() > 0) {
                $status = 'Selesai';
            } elseif ($assessment->scores->count() > 0) {
                $status = 'Dalam Proses';
            }

            return [
                $index + 1,
                $assessment->id,
                $assessment->material->nama_material,
                $assessment->tahun,
                $status,
                \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'ID', 'Material', 'Tahun', 'Status', 'Tanggal Dibuat'];
    }

    public function title(): string
    {
        return 'Assessment Terbaru';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
            ],
        ];
    }
}

// Sheet 3: Recent Winners
class RecentWinnersSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $winners;

    public function __construct($winners)
    {
        $this->winners = $winners;
    }

    public function collection()
    {
        return $this->winners->map(function($winner, $index) {
            return [
                $index + 1,
                $winner->supplier->nama_supplier,
                $winner->supplier->kode_supplier,
                $winner->assessment_id,
                $winner->assessment->material->nama_material,
                number_format($winner->preference_score, 6),
                number_format($winner->preference_score * 100, 2) . '%',
                \Carbon\Carbon::parse($winner->created_at)->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Supplier', 'Kode', 'Assessment ID', 'Material', 'Preference Score', 'Persentase', 'Tanggal'];
    }

    public function title(): string
    {
        return 'Pemenang Terbaru';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']],
            ],
        ];
    }
}
