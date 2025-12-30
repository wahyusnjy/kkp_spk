<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Executive Summary</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px; 
            color: #000;
            padding: 15px;
            line-height: 1.4;
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
        
        /* Statistik Grid */
        .stats-grid {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }
        
        .stat-box {
            flex: 1;
            text-align: center;
            padding: 12px;
            border: 2px solid #000;
            margin: 0 5px;
            background-color: #fff;
        }
        
        .stat-label {
            font-size: 9px;
            font-weight: bold;
            color: #000;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #000;
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
        
        /* Highlight Box */
        .highlight-box {
            background-color: #fff3cd;
            border: 2px solid #000;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
        }
        
        .highlight-title {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin-bottom: 8px;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #000;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #000;
        }
        
        .status-in-progress {
            background-color: #e9ecef;
            color: #000;
        }
        
        .status-draft {
            background-color: #f8f9fa;
            color: #000;
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
        <h1>EXECUTIVE SUMMARY</h1>
    </div>
    
    <div class="date-info">
        <p>Sistem Pendukung Keputusan Pemilihan Supplier</p>
        <p>Dicetak pada: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>
    
    <!-- Statistik Assessment -->
    <div class="section-title">STATISTIK ASSESSMENT</div>
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label">Total Assessment</div>
            <div class="stat-value">{{ $summary['total_assessments'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Selesai</div>
            <div class="stat-value">{{ $summary['completed_assessments'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Dalam Proses</div>
            <div class="stat-value">{{ $summary['in_progress_assessments'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Draft</div>
            <div class="stat-value">{{ $summary['draft_assessments'] }}</div>
        </div>
    </div>
    
    <!-- Supplier & Kriteria -->
    <div class="section-title">SUPPLIER & KRITERIA</div>
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label">Total Supplier</div>
            <div class="stat-value">{{ $summary['total_suppliers'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Supplier Aktif</div>
            <div class="stat-value">{{ $summary['active_suppliers'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Kriteria</div>
            <div class="stat-value">{{ $summary['total_kriteria'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Material</div>
            <div class="stat-value">{{ $summary['total_materials'] }}</div>
        </div>
    </div>
    
    <!-- Top Supplier -->
    @if($summary['top_supplier'])
    <div class="highlight-box">
        <div class="highlight-title">SUPPLIER TERBAIK</div>
        <p style="font-size: 12px; margin-bottom: 5px;">
            <strong>{{ $summary['top_supplier']['supplier']->nama_supplier }}</strong>
        </p>
        <p style="font-size: 10px; margin-bottom: 3px;">
            Kode: {{ $summary['top_supplier']['supplier']->kode_supplier }}
        </p>
        <p style="font-size: 10px;">
            Memenangkan <strong>{{ $summary['top_supplier']['win_count'] }}</strong> assessment
        </p>
    </div>
    @endif
    
    <!-- Assessment Terbaru -->
    <div class="section-title">ASSESSMENT TERBARU</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th style="width: 40%;">MATERIAL</th>
                <th style="width: 15%;">TAHUN</th>
                <th style="width: 15%;">STATUS</th>
                <th style="width: 20%;">TANGGAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summary['recent_assessments'] as $assessment)
            <tr>
                <td>#{{ $assessment->id }}</td>
                <td>{{ $assessment->material->nama_material }}</td>
                <td>{{ $assessment->tahun }}</td>
                <td>
                    @if($assessment->topsisResults->count() > 0)
                        <span class="status-badge status-completed">Selesai</span>
                    @elseif($assessment->scores->count() > 0)
                        <span class="status-badge status-in-progress">Proses</span>
                    @else
                        <span class="status-badge status-draft">Draft</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Pemenang Terbaru -->
    <div class="section-title">PEMENANG TERBARU</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30%;">SUPPLIER</th>
                <th style="width: 10%;">ASSESSMENT</th>
                <th style="width: 30%;">MATERIAL</th>
                <th style="width: 15%;">SCORE</th>
                <th style="width: 15%;">TANGGAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summary['recent_winners'] as $winner)
            <tr>
                <td><strong>{{ $winner->supplier->nama_supplier }}</strong></td>
                <td>#{{ $winner->assessment_id }}</td>
                <td>{{ $winner->assessment->material->nama_material }}</td>
                <td><strong>{{ number_format($winner->preference_score * 100, 2) }}%</strong></td>
                <td>{{ \Carbon\Carbon::parse($winner->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
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