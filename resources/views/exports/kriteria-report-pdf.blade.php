<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kriteria</title>
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
        
        /* Tabel di tengah dengan 2 kolom */
        .criteria-table-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin: 20px 0 40px 0;
        }
        
        .criteria-table {
            width: 80%; /* Kurangi lebar agar tidak full width */
            border-collapse: collapse;
            margin: 0 auto;
        }
        
        .criteria-table th {
            border: 2px solid #000;
            padding: 10px;
            text-align: center; /* Tengahkan teks di header */
            font-weight: bold;
            font-size: 12px;
            background-color: #f0f0f0;
            width: 50%; /* Setiap kolom 50% lebar */
        }
        
        .criteria-table td {
            border: 2px solid #000;
            padding: 8px;
            font-size: 11px;
            vertical-align: middle;
            text-align: center; /* Tengahkan teks di sel */
            width: 50%; /* Setiap kolom 50% lebar */
        }
        
        .criteria-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Container pembungkus agar float tidak berantakan ke elemen bawahnya */
        .signature-wrapper {
            float: right;
            width: 250px; /* Atur lebar sesuai kebutuhan */
            text-align: center;
        }

        /* Override gaya lama */
        .location-date {
            text-align: center;
            margin-bottom: 5px;
            width: 100%;
        }

        .signature-section {
            margin-top: 10px; /* Kurangi margin karena sudah ada wrapper */
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

        /* Tambahkan clear fix setelah separator jika diperlukan */
        .separator {
            border-top: 1px solid #000;
            margin: 20px 0;
            width: 100%;
            clear: both;
        }
        
        /* Print optimization */
        @media print {
            body {
                padding: 15px;
            }
            
            .criteria-table {
                page-break-inside: avoid;
            }
            
            .signature-section {
                page-break-inside: avoid;
            }
            
            .page-info {
                position: fixed;
                bottom: 15px;
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
        <h1>LAPORAN DATA KRITERIA</h1>
    </div>
    
    <!-- Info tanggal -->
    <div class="date-info">
        <p>Dicetak pada: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>
    
    <!-- Tabel Kriteria di tengah -->
    <div class="criteria-table-container">
        <table class="criteria-table">
            <thead>
                <tr>
                    <th>ID KRITERIA</th>
                    <th>NAMA KRITERIA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriterias as $index => $kriteria)
                <tr>
                    <td><strong>{{ $kriteria->kode_kriteria ?? 'K' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $kriteria->nama_kriteria }}</td>
                </tr>
                @endforeach
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