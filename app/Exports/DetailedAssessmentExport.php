<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailedAssessmentExport implements WithMultipleSheets
{
    protected $assessment;
    protected $scoresBySupplier;
    protected $statistics;
    protected $calculationSteps;

    public function __construct($assessment, $scoresBySupplier, $statistics, $calculationSteps = null)
    {
        $this->assessment = $assessment;
        $this->scoresBySupplier = $scoresBySupplier;
        $this->statistics = $statistics;
        $this->calculationSteps = $calculationSteps;
    }

    public function sheets(): array
    {
        $sheets = [
            new AssessmentInfoSheet($this->assessment, $this->statistics),
            new SupplierScoresSheet($this->assessment, $this->scoresBySupplier),
        ];

        if ($this->calculationSteps) {
            $sheets[] = new DecisionMatrixSheet($this->calculationSteps);
            $sheets[] = new NormalizedMatrixSheet($this->calculationSteps);
            $sheets[] = new WeightedMatrixSheet($this->calculationSteps);
            $sheets[] = new IdealSolutionsSheet($this->calculationSteps);
            $sheets[] = new DistancesSheet($this->calculationSteps);
            $sheets[] = new RankingSheet($this->calculationSteps);
        }

        return $sheets;
    }
}

// Sheet 1: Assessment Info
class AssessmentInfoSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, WithEvents
{
    protected $assessment;
    protected $statistics;

    public function __construct($assessment, $statistics)
    {
        $this->assessment = $assessment;
        $this->statistics = $statistics;
    }

    public function collection()
    {
        return collect([
            [
                'ID', $this->assessment->id,
                'Material', $this->assessment->material->nama_material,
            ],
            [
                'Tahun', $this->assessment->tahun,
                'Tanggal', \Carbon\Carbon::parse($this->assessment->created_at)->format('d/m/Y H:i'),
            ],
            [
                'Deskripsi', $this->assessment->deskripsi ?? '-',
                '', '',
            ],
            [], // Empty row
            ['STATISTIK', '', '', ''],
            [
                'Total Supplier', $this->statistics['total_suppliers'],
                'Total Kriteria', $this->statistics['total_criteria'],
            ],
            [
                'Total Nilai', $this->statistics['total_score'],
                'Rata-rata', number_format($this->statistics['average_score'], 2),
            ],
            [
                'Nilai Tertinggi', $this->statistics['max_score'],
                'Nilai Terendah', $this->statistics['min_score'],
            ],
        ]);
    }

    public function headings(): array
    {
        return ['INFORMASI ASSESSMENT #' . $this->assessment->id, '', '', ''];
    }

    public function title(): string
    {
        return 'Info Assessment';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']]],
            5 => ['font' => ['bold' => true, 'size' => 12], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
            },
        ];
    }
}

// Sheet 2: Supplier Scores
class SupplierScoresSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $assessment;
    protected $scoresBySupplier;

    public function __construct($assessment, $scoresBySupplier)
    {
        $this->assessment = $assessment;
        $this->scoresBySupplier = $scoresBySupplier;
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->scoresBySupplier as $supplierId => $scores) {
            $supplier = $scores->first()->supplier;
            $totalScore = $scores->sum('score');
            $avgScore = $scores->avg('score');

            // Supplier header
            $rows->push([
                'Supplier: ' . $supplier->nama_supplier,
                'Kode: ' . $supplier->kode_supplier,
                'Total: ' . number_format($totalScore, 2),
                'Rata-rata: ' . number_format($avgScore, 2),
            ]);

            // Scores
            foreach ($scores as $score) {
                $rows->push([
                    $score->kriteria->nama_kriteria,
                    $score->kriteria->type,
                    $score->kriteria->bobot,
                    $score->score,
                ]);
            }

            $rows->push([]); // Empty row between suppliers
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Kriteria', 'Tipe', 'Bobot', 'Nilai'];
    }

    public function title(): string
    {
        return 'Penilaian Supplier';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}

// Sheet 3: Decision Matrix
class DecisionMatrixSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $calculationSteps;

    public function __construct($calculationSteps)
    {
        $this->calculationSteps = $calculationSteps;
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->calculationSteps['suppliers'] as $index => $supplier) {
            $row = [$supplier->nama_supplier];
            foreach ($this->calculationSteps['decision_matrix'][$index] as $value) {
                $row[] = number_format($value, 2);
            }
            $rows->push($row);
        }

        return $rows;
    }

    public function headings(): array
    {
        $headers = ['Supplier'];
        foreach ($this->calculationSteps['criteria'] as $criterion) {
            $headers[] = $criterion->nama_kriteria;
        }
        return $headers;
    }

    public function title(): string
    {
        return '1. Matriks Keputusan';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}

// Sheet 4: Normalized Matrix
class NormalizedMatrixSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $calculationSteps;

    public function __construct($calculationSteps)
    {
        $this->calculationSteps = $calculationSteps;
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->calculationSteps['suppliers'] as $index => $supplier) {
            $row = [$supplier->nama_supplier];
            foreach ($this->calculationSteps['normalized_matrix'][$index] as $value) {
                $row[] = number_format($value, 6);
            }
            $rows->push($row);
        }

        return $rows;
    }

    public function headings(): array
    {
        $headers = ['Supplier'];
        foreach ($this->calculationSteps['criteria'] as $criterion) {
            $headers[] = $criterion->nama_kriteria;
        }
        return $headers;
    }

    public function title(): string
    {
        return '2. Matriks Ternormalisasi';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0891B2']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}

// Sheet 5: Weighted Matrix
class WeightedMatrixSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $calculationSteps;

    public function __construct($calculationSteps)
    {
        $this->calculationSteps = $calculationSteps;
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->calculationSteps['suppliers'] as $index => $supplier) {
            $row = [$supplier->nama_supplier];
            foreach ($this->calculationSteps['weighted_matrix'][$index] as $value) {
                $row[] = number_format($value, 6);
            }
            $rows->push($row);
        }

        return $rows;
    }

    public function headings(): array
    {
        $headers = ['Supplier'];
        foreach ($this->calculationSteps['criteria'] as $criterion) {
            $headers[] = $criterion->nama_kriteria . ' (W:' . $criterion->bobot . ')';
        }
        return $headers;
    }

    public function title(): string
    {
        return '3. Matriks Terbobot';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '7C3AED']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}

// Sheet 6: Ideal Solutions
class IdealSolutionsSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $calculationSteps;

    public function __construct($calculationSteps)
    {
        $this->calculationSteps = $calculationSteps;
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->calculationSteps['criteria'] as $index => $criterion) {
            $rows->push([
                $criterion->nama_kriteria,
                $criterion->type,
                number_format($this->calculationSteps['ideal_solutions']['positive'][$index], 6),
                number_format($this->calculationSteps['ideal_solutions']['negative'][$index], 6),
            ]);
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Kriteria', 'Tipe', 'Ideal Positif (A+)', 'Ideal Negatif (A-)'];
    }

    public function title(): string
    {
        return '4. Solusi Ideal';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F59E0B']], 'font' => ['color' => ['rgb' => '000000']]],
        ];
    }
}

// Sheet 7: Distances
class DistancesSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $calculationSteps;

    public function __construct($calculationSteps)
    {
        $this->calculationSteps = $calculationSteps;
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->calculationSteps['suppliers'] as $index => $supplier) {
            $rows->push([
                $supplier->nama_supplier,
                number_format($this->calculationSteps['distances'][$index]['positive'], 6),
                number_format($this->calculationSteps['distances'][$index]['negative'], 6),
            ]);
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Supplier', 'Jarak dari Ideal Positif (D+)', 'Jarak dari Ideal Negatif (D-)'];
    }

    public function title(): string
    {
        return '5. Perhitungan Jarak';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EC4899']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}

// Sheet 8: Final Ranking
class RankingSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $calculationSteps;

    public function __construct($calculationSteps)
    {
        $this->calculationSteps = $calculationSteps;
    }

    public function collection()
    {
        $rows = collect();

        // Create sorted collection
        $sortedData = collect($this->calculationSteps['suppliers'])
            ->map(function($supplier, $index) {
                return [
                    'supplier' => $supplier,
                    'preference' => $this->calculationSteps['preferences'][$index],
                    'rank' => $this->calculationSteps['rankings'][$index],
                    'd_plus' => $this->calculationSteps['distances'][$index]['positive'],
                    'd_minus' => $this->calculationSteps['distances'][$index]['negative'],
                ];
            })
            ->sortBy('rank');

        foreach ($sortedData as $item) {
            $rows->push([
                $item['rank'],
                $item['supplier']->nama_supplier,
                $item['supplier']->kode_supplier,
                number_format($item['d_plus'], 6),
                number_format($item['d_minus'], 6),
                number_format($item['preference'], 6),
                number_format($item['preference'] * 100, 2) . '%',
            ]);
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Rank', 'Supplier', 'Kode', 'D+', 'D-', 'Preference Score', 'Persentase'];
    }

    public function title(): string
    {
        return '6. HASIL RANKING';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
