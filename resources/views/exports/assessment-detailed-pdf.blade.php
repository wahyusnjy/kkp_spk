<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail Assessment #{{ $assessment->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2563eb;
        }
        
        .header h1 {
            font-size: 18px;
            color: #1e40af;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 14px;
            color: #3b82f6;
            margin-bottom: 3px;
        }
        
        .header p {
            font-size: 9px;
            color: #666;
        }
        
        .info-section {
            background: #f8fafc;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #e2e8f0;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 25%;
            padding: 3px 5px;
            color: #1e40af;
        }
        
        .info-value {
            display: table-cell;
            padding: 3px 5px;
            width: 25%;
        }
        
        .section-title {
            background: #3b82f6;
            color: white;
            padding: 8px 10px;
            margin: 15px 0 10px 0;
            font-size: 12px;
            font-weight: bold;
            border-radius: 3px;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .stat-box {
            display: table-cell;
            text-align: center;
            padding: 8px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            margin: 0 5px;
        }
        
        .stat-label {
            font-size: 8px;
            color: #1e40af;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table th {
            background: #1e40af;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #1e3a8a;
        }
        
        table td {
            padding: 5px;
            border: 1px solid #ddd;
            font-size: 9px;
        }
        
        table tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .matrix-table th {
            background: #059669;
            border-color: #047857;
        }
        
        .matrix-table td {
            text-align: center;
            font-size: 8px;
        }
        
        .calculation-step {
            background: #fef3c7;
            border-left: 3px solid #f59e0b;
            padding: 8px;
            margin: 10px 0;
        }
        
        .calculation-step h4 {
            color: #92400e;
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .formula {
            background: white;
            padding: 5px;
            margin: 5px 0;
            border: 1px dashed #d97706;
            font-family: 'Courier New', monospace;
            font-size: 9px;
            color: #92400e;
        }
        
        .result-box {
            background: #d1fae5;
            border: 2px solid #10b981;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        
        .result-box h4 {
            color: #065f46;
            font-size: 12px;
            margin-bottom: 8px;
        }
        
        .rank-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }
        
        .rank-1 {
            background: #fbbf24;
            color: #78350f;
        }
        
        .rank-2 {
            background: #d1d5db;
            color: #374151;
        }
        
        .rank-3 {
            background: #f87171;
            color: #7f1d1d;
        }
        
        .rank-other {
            background: #e5e7eb;
            color: #6b7280;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .badge-benefit {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-cost {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #666;
            padding: 5px;
            border-top: 1px solid #ddd;
        }
        
        .highlight {
            background: #fef3c7;
            padding: 2px 4px;
            border-radius: 2px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .mb-10 {
            margin-bottom: 10px;
        }
        
        .mt-10 {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>LAPORAN DETAIL ASSESSMENT</h1>
        <h2>Assessment #{{ $assessment->id }} - {{ $assessment->material->nama_material }}</h2>
        <p>Dicetak pada: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>

    {{-- Assessment Information --}}
    <div class="section-title">📋 INFORMASI ASSESSMENT</div>
    <div class="info-section">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">ID Assessment:</div>
                <div class="info-value">#{{ $assessment->id }}</div>
                <div class="info-label">Tahun:</div>
                <div class="info-value">{{ $assessment->tahun }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Material:</div>
                <div class="info-value">{{ $assessment->material->nama_material }}</div>
                <div class="info-label">Tanggal Dibuat:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y H:i') }}</div>
            </div>
            @if($assessment->deskripsi)
            <div class="info-row">
                <div class="info-label">Deskripsi:</div>
                <div class="info-value" colspan="3">{{ $assessment->deskripsi }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Statistics --}}
    <div class="section-title">📊 STATISTIK</div>
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label">Total Supplier</div>
            <div class="stat-value">{{ $statistics['total_suppliers'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Kriteria</div>
            <div class="stat-value">{{ $statistics['total_criteria'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Nilai</div>
            <div class="stat-value">{{ number_format($statistics['total_score'], 0) }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Rata-rata</div>
            <div class="stat-value">{{ number_format($statistics['average_score'], 1) }}</div>
        </div>
    </div>

    {{-- Supplier Scores --}}
    <div class="section-title">⭐ DETAIL PENILAIAN SUPPLIER</div>
    @foreach($scoresBySupplier as $supplierId => $scores)
        @php
            $supplier = $scores->first()->supplier;
            $totalScore = $scores->sum('score');
            $avgScore = $scores->avg('score');
        @endphp
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background: #0369a1; font-size: 10px;">
                        {{ $supplier->nama_supplier }} 
                        (Kode: {{ $supplier->kode_supplier }}) - 
                        Total: {{ number_format($totalScore, 1) }} | 
                        Rata-rata: {{ number_format($avgScore, 1) }}
                    </th>
                </tr>
                <tr>
                    <th style="width: 40%;">Kriteria</th>
                    <th style="width: 15%;">Tipe</th>
                    <th style="width: 15%;">Bobot</th>
                    <th style="width: 30%;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scores as $score)
                <tr>
                    <td>{{ $score->kriteria->nama_kriteria }}</td>
                    <td class="text-center">
                        <span class="badge {{ $score->kriteria->type == 'benefit' ? 'badge-benefit' : 'badge-cost' }}">
                            {{ $score->kriteria->type == 'benefit' ? 'Benefit' : 'Cost' }}
                        </span>
                    </td>
                    <td class="text-center">{{ $score->kriteria->bobot }}</td>
                    <td class="text-center"><strong>{{ number_format($score->score, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    @if($calculationSteps)
    <div class="page-break"></div>
    
    {{-- TOPSIS Calculation Steps --}}
    <div class="section-title">🔬 PERHITUNGAN TOPSIS LENGKAP</div>
    
    {{-- Step 1: Decision Matrix --}}
    <div class="calculation-step">
        <h4>LANGKAH 1: Matriks Keputusan (Decision Matrix)</h4>
        <p>Matriks yang berisi nilai penilaian setiap supplier terhadap setiap kriteria.</p>
    </div>
    
    <table class="matrix-table">
        <thead>
            <tr>
                <th>Supplier</th>
                @foreach($calculationSteps['criteria'] as $criterion)
                <th style="font-size: 7px;">{{ $criterion->nama_kriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($calculationSteps['suppliers'] as $index => $supplier)
            <tr>
                <td style="text-align: left; font-size: 8px;"><strong>{{ $supplier->nama_supplier }}</strong></td>
                @foreach($calculationSteps['decision_matrix'][$index] as $value)
                <td>{{ number_format($value, 2) }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Step 2: Normalized Matrix --}}
    <div class="calculation-step">
        <h4>LANGKAH 2: Matriks Ternormalisasi (Normalized Matrix)</h4>
        <p>Normalisasi menggunakan rumus:</p>
        <div class="formula">
            r<sub>ij</sub> = x<sub>ij</sub> / √(Σx<sub>ij</sub>²)
        </div>
        <p>Dimana r<sub>ij</sub> adalah nilai ternormalisasi, x<sub>ij</sub> adalah nilai asli pada matriks keputusan.</p>
    </div>
    
    <table class="matrix-table">
        <thead>
            <tr>
                <th>Supplier</th>
                @foreach($calculationSteps['criteria'] as $criterion)
                <th style="font-size: 7px;">{{ $criterion->nama_kriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($calculationSteps['suppliers'] as $index => $supplier)
            <tr>
                <td style="text-align: left; font-size: 8px;"><strong>{{ $supplier->nama_supplier }}</strong></td>
                @foreach($calculationSteps['normalized_matrix'][$index] as $value)
                <td>{{ number_format($value, 4) }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    {{-- Step 3: Weighted Normalized Matrix --}}
    <div class="calculation-step">
        <h4>LANGKAH 3: Matriks Ternormalisasi Terbobot (Weighted Normalized Matrix)</h4>
        <p>Mengalikan matriks ternormalisasi dengan bobot kriteria:</p>
        <div class="formula">
            v<sub>ij</sub> = w<sub>j</sub> × r<sub>ij</sub>
        </div>
        <p>Dimana w<sub>j</sub> adalah bobot kriteria ke-j.</p>
        <p><strong>Bobot Kriteria:</strong></p>
        <div style="margin: 5px 0; background: white; padding: 5px; border: 1px solid #d97706;">
            @foreach($calculationSteps['criteria'] as $criterion)
                <span style="margin-right: 10px;">{{ $criterion->nama_kriteria }}: <strong>{{ $criterion->bobot }}</strong></span>
            @endforeach
        </div>
    </div>
    
    <table class="matrix-table">
        <thead>
            <tr>
                <th>Supplier</th>
                @foreach($calculationSteps['criteria'] as $criterion)
                <th style="font-size: 7px;">{{ $criterion->nama_kriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($calculationSteps['suppliers'] as $index => $supplier)
            <tr>
                <td style="text-align: left; font-size: 8px;"><strong>{{ $supplier->nama_supplier }}</strong></td>
                @foreach($calculationSteps['weighted_matrix'][$index] as $value)
                <td>{{ number_format($value, 4) }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Step 4: Ideal Solutions --}}
    <div class="calculation-step">
        <h4>LANGKAH 4: Solusi Ideal Positif dan Negatif</h4>
        <p>Menentukan solusi ideal positif (A+) dan solusi ideal negatif (A-):</p>
        <div class="formula">
            • Untuk kriteria Benefit: A+ = max(v<sub>ij</sub>), A- = min(v<sub>ij</sub>)<br>
            • Untuk kriteria Cost: A+ = min(v<sub>ij</sub>), A- = max(v<sub>ij</sub>)
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Tipe</th>
                <th>Solusi Ideal Positif (A+)</th>
                <th>Solusi Ideal Negatif (A-)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calculationSteps['criteria'] as $index => $criterion)
            <tr>
                <td>{{ $criterion->nama_kriteria }}</td>
                <td class="text-center">
                    <span class="badge {{ $criterion->type == 'benefit' ? 'badge-benefit' : 'badge-cost' }}">
                        {{ $criterion->type == 'benefit' ? 'Benefit' : 'Cost' }}
                    </span>
                </td>
                <td class="text-center"><strong>{{ number_format($calculationSteps['ideal_solutions']['positive'][$index], 4) }}</strong></td>
                <td class="text-center">{{ number_format($calculationSteps['ideal_solutions']['negative'][$index], 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    {{-- Step 5: Distance Calculations --}}
    <div class="calculation-step">
        <h4>LANGKAH 5: Perhitungan Jarak dari Solusi Ideal</h4>
        <p>Menghitung jarak setiap alternatif dari solusi ideal positif (D+) dan negatif (D-):</p>
        <div class="formula">
            D<sub>i</sub><sup>+</sup> = √(Σ(v<sub>ij</sub> - A<sub>j</sub><sup>+</sup>)²)<br>
            D<sub>i</sub><sup>-</sup> = √(Σ(v<sub>ij</sub> - A<sub>j</sub><sup>-</sup>)²)
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Supplier</th>
                <th>Jarak dari Ideal Positif (D+)</th>
                <th>Jarak dari Ideal Negatif (D-)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calculationSteps['suppliers'] as $index => $supplier)
            <tr>
                <td>{{ $supplier->nama_supplier }}</td>
                <td class="text-center">{{ number_format($calculationSteps['distances'][$index]['positive'], 6) }}</td>
                <td class="text-center">{{ number_format($calculationSteps['distances'][$index]['negative'], 6) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Step 6: Preference Score --}}
    <div class="calculation-step">
        <h4>LANGKAH 6: Nilai Preferensi (Preference Score)</h4>
        <p>Menghitung nilai preferensi untuk setiap alternatif:</p>
        <div class="formula">
            V<sub>i</sub> = D<sub>i</sub><sup>-</sup> / (D<sub>i</sub><sup>+</sup> + D<sub>i</sub><sup>-</sup>)
        </div>
        <p>Nilai preferensi berkisar antara 0 sampai 1. Semakin mendekati 1, semakin baik alternatif tersebut.</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Supplier</th>
                <th>D+</th>
                <th>D-</th>
                <th>Preference Score</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calculationSteps['suppliers'] as $index => $supplier)
            <tr>
                <td>{{ $supplier->nama_supplier }}</td>
                <td class="text-center">{{ number_format($calculationSteps['distances'][$index]['positive'], 6) }}</td>
                <td class="text-center">{{ number_format($calculationSteps['distances'][$index]['negative'], 6) }}</td>
                <td class="text-center"><strong>{{ number_format($calculationSteps['preferences'][$index], 6) }}</strong></td>
                <td class="text-center"><span class="highlight">{{ number_format($calculationSteps['preferences'][$index] * 100, 2) }}%</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Step 7: Ranking --}}
    <div class="result-box">
        <h4>🏆 LANGKAH 7: HASIL RANKING FINAL</h4>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Supplier</th>
                    <th>Kode</th>
                    <th>Preference Score</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sortedSuppliers = collect($calculationSteps['suppliers'])
                        ->map(function($supplier, $index) use ($calculationSteps) {
                            return [
                                'supplier' => $supplier,
                                'preference' => $calculationSteps['preferences'][$index],
                                'rank' => $calculationSteps['rankings'][$index]
                            ];
                        })
                        ->sortBy('rank');
                @endphp
                @foreach($sortedSuppliers as $item)
                <tr>
                    <td class="text-center">
                        <span class="rank-badge {{ $item['rank'] == 1 ? 'rank-1' : ($item['rank'] == 2 ? 'rank-2' : ($item['rank'] == 3 ? 'rank-3' : 'rank-other')) }}">
                            {{ $item['rank'] == 1 ? '🥇' : ($item['rank'] == 2 ? '🥈' : ($item['rank'] == 3 ? '🥉' : '')) }}
                            #{{ $item['rank'] }}
                        </span>
                    </td>
                    <td><strong>{{ $item['supplier']->nama_supplier }}</strong></td>
                    <td class="text-center">{{ $item['supplier']->kode_supplier }}</td>
                    <td class="text-center">{{ number_format($item['preference'], 6) }}</td>
                    <td class="text-center"><strong style="font-size: 11px;">{{ number_format($item['preference'] * 100, 2) }}%</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else
    <div class="section-title">⚠️ PERHITUNGAN TOPSIS</div>
    <div style="text-align: center; padding: 30px; background: #fef3c7; border: 2px dashed #f59e0b; border-radius: 5px;">
        <h4 style="color: #92400e; margin-bottom: 10px;">Perhitungan TOPSIS Belum Tersedia</h4>
        <p style="color: #78350f;">Assessment ini belum diproses dengan metode TOPSIS. Silakan lakukan proses perhitungan terlebih dahulu untuk melihat hasil ranking.</p>
    </div>
    @endif

    <div class="footer">
        <p>Sistem Pendukung Keputusan Pemilihan Supplier - Laporan Detail Assessment #{{ $assessment->id }}</p>
        <p>Dicetak: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
