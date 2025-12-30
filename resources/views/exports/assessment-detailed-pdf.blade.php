<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Detail Assessment #{{ $assessment->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            padding: 15px;
        }
        
        /* Header dengan logo dan informasi perusahaan */
        .company-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        
        .logo-container {
            width: 100%;
            margin-bottom: 10px;
            position: relative;
        }
        
        .logo-left {
            position: absolute;
            left: 0;
            top: 0;
            width: 30%;
            text-align: left;
        }
        
        .logo-center {
            width: 100%;
            text-align: center;
        }
        
        .company-logo {
            font-family: Arial, sans-serif;
            font-weight: bold;
            color: #000;
            text-align: center;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 5px 0;
            letter-spacing: 1px;
        }
        
        .company-address {
            font-size: 10px;
            margin: 5px 0;
            line-height: 1.3;
        }
        
        /* Judul Laporan */
        .report-title {
            text-align: center;
            margin: 20px 0 15px 0;
            padding-bottom: 5px;
        }
        
        .report-title h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-decoration: underline;
            text-transform: uppercase;
        }
        
        .report-title h2 {
            font-size: 14px;
            font-weight: normal;
            margin: 3px 0;
            color: #333;
        }
        
        .date-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        /* Section Title */
        .section-title {
            background-color: #f0f0f0;
            color: #000;
            padding: 8px 10px;
            margin: 20px 0 10px 0;
            font-size: 12px;
            font-weight: bold;
            border: 1px solid #000;
            border-left: 4px solid #000;
        }
        
        /* Informasi Assessment */
        .info-grid {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #000;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #000;
        }
        
        .info-value {
            flex: 1;
        }
        
        /* Tabel */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 25px 0;
        }
        
        .data-table th {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            background-color: #f0f0f0;
        }
        
        .data-table td {
            border: 2px solid #000;
            padding: 6px;
            font-size: 10px;
            vertical-align: middle;
            text-align: center;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Status dan Badge */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 2px;
        }
        
        .badge-benefit {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .badge-cost {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .rank-badge {
            display: inline-block;
            padding: 3px 8px;
            font-weight: bold;
            font-size: 10px;
            border: 1px solid #000;
        }
        
        .rank-1 {
            background-color: #fff3cd;
            color: #000;
            font-weight: bold;
        }
        
        .rank-2 {
            background-color: #e9ecef;
            color: #000;
        }
        
        .rank-3 {
            background-color: #d1d5db;
            color: #000;
        }
        
        .rank-other {
            background-color: #f8f9fa;
            color: #000;
        }
        
        /* Hasil Pemenang */
        .winner-box {
            background-color: #fff3cd;
            border: 2px solid #000;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        
        .winner-title {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }
        
        .winner-info {
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .winner-score {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            margin-top: 10px;
        }
        
        /* Signature Section */
        .signature-wrapper {
            float: right;
            width: 250px;
            text-align: center;
            margin-top: 30px;
        }
        
        .location-date {
            text-align: center;
            margin-bottom: 5px;
            width: 100%;
        }
        
        .signature-line {
            display: inline-block;
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 11px;
        }
        
        .separator {
            border-top: 1px solid #000;
            margin: 20px 0;
            width: 100%;
            clear: both;
        }
        
        /* Highlight dan Formula */
        .highlight {
            background-color: #f8f9fa;
            padding: 2px 5px;
            border: 1px solid #dee2e6;
        }
        
        .formula {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            background-color: #f8f9fa;
            padding: 5px;
            border: 1px solid #dee2e6;
            margin: 5px 0;
        }
        
        /* Statistik Box */
        .stats-grid {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }
        
        .stat-box {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: 2px solid #000;
            margin: 0 5px;
            background-color: #fff;
        }
        
        .stat-label {
            font-size: 9px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }
        
        /* Page Break */
        .page-break {
            page-break-before: always;
        }
        
        /* Clear fix */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        
        /* Print optimization */
        @media print {
            body {
                padding: 10px;
            }
            
            .data-table {
                page-break-inside: avoid;
            }
            
            .signature-wrapper {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <!-- Header dengan logo dan informasi perusahaan -->
    <div class="company-header">
        <div class="logo-container">
            <div class="logo-left">
                <!-- Logo perusahaan -->
                <div class="company-logo">
                    <img src="{{ public_path('assets/logoamesu.png') }}" height="100" alt="">
                </div>
            </div>
            
            <div class="logo-center">
                <!-- Nama perusahaan di tengah -->
                <div class="company-name">PT AMESU UTAMA</div>
                <div class="company-address">
                    Jl. Benda No.88, RT.001/RW.003, Cikiwul,<br> 
                    Kec. Bantar Gebang, Kota Bks, <br>
                    Jawa Barat 17152
                </div>
            </div>
        </div>
    </div>
    
    <!-- Judul laporan -->
    <div class="report-title">
        <h1>LAPORAN DETAIL ASSESSMENT</h1>
        <h2>Assessment #{{ $assessment->id }} - {{ $assessment->material->nama_material }}</h2>
    </div>
    
    <div class="date-info">
        <p>Dicetak pada: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>
    
    <!-- Informasi Assessment -->
    <div class="section-title">INFORMASI ASSESSMENT</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">ID Assessment:</div>
            <div class="info-value">#{{ $assessment->id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Material:</div>
            <div class="info-value">{{ $assessment->material->nama_material }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tahun:</div>
            <div class="info-value">{{ $assessment->tahun }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Dibuat:</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y H:i') }}</div>
        </div>
        @if($assessment->deskripsi)
        <div class="info-row">
            <div class="info-label">Deskripsi:</div>
            <div class="info-value">{{ $assessment->deskripsi }}</div>
        </div>
        @endif
    </div>
    
    <!-- Statistik -->
    <div class="section-title">STATISTIK</div>
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
    
    <!-- Detail Penilaian Supplier -->
    <div class="section-title">DETAIL PENILAIAN SUPPLIER</div>
    @foreach($scoresBySupplier as $supplierId => $scores)
        @php
            $supplier = $scores->first()->supplier;
            $totalScore = $scores->sum('score');
            $avgScore = $scores->avg('score');
        @endphp
        <table class="data-table">
            <thead>
                <tr>
                    <th colspan="4" style="font-size: 11px; background-color: #e9ecef;">
                        {{ $supplier->nama_supplier }} 
                        (Kode: {{ $supplier->kode_supplier }}) - 
                        Total: {{ number_format($totalScore, 1) }} | 
                        Rata-rata: {{ number_format($avgScore, 1) }}
                    </th>
                </tr>
                <tr>
                    <th style="width: 40%;">KRITERIA</th>
                    <th style="width: 15%;">TIPE</th>
                    <th style="width: 15%;">BOBOT</th>
                    <th style="width: 30%;">NILAI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scores as $score)
                <tr>
                    <td>{{ $score->kriteria->nama_kriteria }}</td>
                    <td>
                        <span class="badge {{ $score->kriteria->type == 'benefit' ? 'badge-benefit' : 'badge-cost' }}">
                            {{ $score->kriteria->type == 'benefit' ? 'Benefit' : 'Cost' }}
                        </span>
                    </td>
                    <td>{{ $score->kriteria->bobot }}</td>
                    <td><strong>{{ number_format($score->score, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
    
    <!-- HASIL RANKING -->
    <div class="section-title">HASIL RANKING</div>
    
    @php
        // Ambil hasil TOPSIS untuk ranking
        $topsisResults = $assessment->topsisResults()->orderBy('rank')->get();
    @endphp
    
    @if($topsisResults->count() > 0)
        <!-- Box Pemenang -->
        @php
            $winner = $topsisResults->first();
        @endphp
        <div class="winner-box">
            <div class="winner-title">PEMENANG ASSESSMENT</div>
            <div class="winner-info">
                <strong>{{ $winner->supplier->nama_supplier }}</strong><br>
                Kode: {{ $winner->supplier->kode_supplier }}
            </div>
            <div class="winner-score">
                Score: {{ number_format($winner->preference_score * 100, 2) }}%
            </div>
        </div>
        
        <!-- Tabel Ranking Lengkap -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 10%;">RANK</th>
                    <th style="width: 25%;">SUPPLIER</th>
                    <th style="width: 15%;">KODE</th>
                    <th style="width: 20%;">SCORE TOPSIS</th>
                    <th style="width: 15%;">PERSENTASE</th>
                    <th style="width: 15%;">TOTAL NILAI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topsisResults as $result)
                <tr>
                    <td>
                        <span class="rank-badge {{ $result->rank == 1 ? 'rank-1' : ($result->rank == 2 ? 'rank-2' : ($result->rank == 3 ? 'rank-3' : 'rank-other')) }}">
                            #{{ $result->rank }}
                        </span>
                    </td>
                    <td><strong>{{ $result->supplier->nama_supplier }}</strong></td>
                    <td>{{ $result->supplier->kode_supplier }}</td>
                    <td>{{ number_format($result->preference_score, 4) }}</td>
                    <td><strong>{{ number_format($result->preference_score * 100, 2) }}%</strong></td>
                    <td>
                        @php
                            $supplierScores = $scoresBySupplier[$result->supplier_id] ?? collect();
                            $totalScore = $supplierScores->sum('score');
                        @endphp
                        {{ number_format($totalScore, 1) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 20px; border: 2px solid #000; margin: 20px 0;">
            <p><strong>Belum ada hasil ranking TOPSIS</strong></p>
            <p>Assessment ini belum diproses dengan metode TOPSIS.</p>
        </div>
    @endif
    
    <!-- Separator -->
    <div class="separator"></div>
    
    <!-- Tanda tangan -->
    <div class="signature-wrapper">
        <div class="location-date">
            <p>Bekasi, {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            Head QC
        </div>
        
        <div class="signature-section">
            <div class="signature-block">
                <div class="signature-placeholder"></div>
                
                <div style="margin-top: 50px;">
                    <div class="signature-line">
                        (Wahyu Hidayat)
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
</body>
</html>