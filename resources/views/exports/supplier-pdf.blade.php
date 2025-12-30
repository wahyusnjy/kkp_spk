<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Supplier</title>
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
        .supplier-table-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin: 20px 0 40px 0;
        }
        
        .supplier-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        
        .supplier-table th {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            background-color: #f0f0f0;
        }
        
        .supplier-table td {
            border: 2px solid #000;
            padding: 6px;
            font-size: 10px;
            vertical-align: middle;
            text-align: center;
        }
        
        .supplier-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Status Styling */
        .status {
            display: inline-block;
            padding: 3px 8px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 3px;
        }
        
        .status.active {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status.inactive {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            
            .supplier-table {
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
        <h1>LAPORAN DATA SUPPLIER</h1>
    </div>
    
    <!-- Info tanggal -->
    <div class="date-info">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        <p>Periode: {{ date('d/m/Y', strtotime($filter['start_date'] ?? 'now')) }} - {{ date('d/m/Y', strtotime($filter['end_date'] ?? 'now')) }}</p>
    </div>
    
    <!-- Filter Info -->
    @if(!empty(array_filter($filter)))
    <div class="filter-info">
        <h3>Filter yang diterapkan:</h3>
        <div>
            @if(!empty($filter['status']))
                <strong>Status:</strong> {{ implode(', ', $filter['status']) }}
                @if($filter['kategori_material'] || ($filter['start_date'] && $filter['end_date'])) | @endif
            @endif
            @if($filter['kategori_material'])
                <strong>Kategori:</strong> {{ $filter['kategori_material'] }}
                @if($filter['start_date'] && $filter['end_date']) | @endif
            @endif
            @if($filter['start_date'] && $filter['end_date'])
                <strong>Periode:</strong> {{ date('d/m/Y', strtotime($filter['start_date'])) }} - {{ date('d/m/Y', strtotime($filter['end_date'])) }}
            @endif
        </div>
    </div>
    @endif
    
    <!-- Tabel Supplier -->
    <div class="supplier-table-container">
        <table class="supplier-table">
            <thead>
                <tr>
                    <th style="width: 12%;">KODE SUPPLIER</th>
                    <th style="width: 20%;">NAMA SUPPLIER</th>
                    <th style="width: 15%;">KATEGORI</th>
                    <th style="width: 20%;">ALAMAT</th>
                    <th style="width: 15%;">KONTAK</th>
                    <th style="width: 8%;">STATUS</th>
                    <th style="width: 10%;">BERGABUNG</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td><strong>{{ $supplier->kode_supplier }}</strong></td>
                    <td>{{ $supplier->nama_supplier }}</td>
                    <td>{{ $supplier->kategori_material ?? 'Umum' }}</td>
                    <td>{{ $supplier->alamat ?? '-' }}</td>
                    <td>
                        @if($supplier->telepon)
                            {{ $supplier->telepon }}
                        @elseif($supplier->email)
                            <br><small>{{ $supplier->email }}</small>
                        @elseif($supplier->kontak)
                            <br><small>{{ $supplier->kontak }}</small>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @php
                            $statusClass = $supplier->status == 'active' ? 'active' : 'inactive';
                            $statusText = $supplier->status == 'active' ? 'Active' : 'Non Active';
                        @endphp
                        <span class="status {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($supplier->created_at)->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #6c757d; font-style: italic;">
                        Tidak ada data supplier ditemukan
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