<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Material</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px; 
            color: #000;
            background: white;
            padding: 20px;
            line-height: 1.4;
        }
        
        /* Header dengan logo dan informasi perusahaan */
        .company-header {
            text-align: center;
            margin-bottom: 30px;
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
            font-size: 11px;
            margin: 5px 0;
            line-height: 1.3;
        }
        
        .report-title {
            text-align: center;
            margin: 30px 0;
            padding: 10px 0;
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
            margin-bottom: 25px;
            font-size: 11px;
        }
        
        /* Tabel di tengah */
        .material-table-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin: 20px 0 40px 0;
        }
        
        .material-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        
        .material-table th {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            background-color: #f0f0f0;
        }
        
        .material-table td {
            border: 2px solid #000;
            padding: 6px;
            font-size: 10px;
            vertical-align: middle;
            text-align: center;
        }
        
        .material-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Container pembungkus agar float tidak berantakan ke elemen bawahnya */
        .signature-wrapper {
            float: right;
            width: 250px;
            text-align: center;
        }

        .location-date {
            text-align: center;
            margin-bottom: 5px;
            width: 100%;
        }

        .signature-section {
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
        
        .signature-line {
            display: inline-block;
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 11px;
        }

        .separator {
            border-top: 1px solid #000;
            margin: 20px 0;
            width: 100%;
            clear: both;
        }
        
        /* Filter Info */
        .filter-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 10px;
        }
        
        .filter-info h3 {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        /* Print optimization */
        @media print {
            body {
                padding: 15px;
            }
            
            .material-table {
                page-break-inside: avoid;
            }
            
            .signature-section {
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
        <h1>LAPORAN DATA MATERIAL</h1>
    </div>
    
    <!-- Info tanggal -->
    <div class="date-info">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        @if(isset($filter['start_date']) && isset($filter['end_date']))
        <p>Periode: {{ date('d/m/Y', strtotime($filter['start_date'])) }} - {{ date('d/m/Y', strtotime($filter['end_date'])) }}</p>
        @endif
    </div>
    
    
    <!-- Tabel Material -->
    <div class="material-table-container">
        <table class="material-table">
            <thead>
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th style="width: 20%;">NAMA MATERIAL</th>
                    <th style="width: 20%;">SUPPLIER</th>
                    <th style="width: 12%;">JENIS LOGAM</th>
                    <th style="width: 10%;">GRADE</th>
                    <th style="width: 18%;">SPESIFIKASI TEKNIS</th>
                    <th style="width: 15%;">HARGA PER KG</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $index => $material)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td>{{ $material->nama_material }}</td>
                    <td>{{ $material->supplier ? $material->supplier->nama_supplier : '-' }}</td>
                    <td>{{ $material->jenis_logam ?? '-' }}</td>
                    <td>{{ $material->grade ?? '-' }}</td>
                    <td>{{ $material->spesifikasi_teknis ?? '-' }}</td>
                    <td>Rp {{ number_format($material->harga_per_kg ?? 0, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #6c757d; font-style: italic;">
                        Tidak ada data material ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="separator"></div>

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

    <div style="clear: both;"></div>
    
</body>
</html>
