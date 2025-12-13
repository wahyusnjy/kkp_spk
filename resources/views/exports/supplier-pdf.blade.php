<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Supplier</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #1e40af;
        }
        
        .header h1 {
            color: #1e40af;
            margin-bottom: 5px;
            font-size: 24px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .summary h2 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        
        .summary-item {
            padding: 12px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .summary-item .label {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .summary-item .value {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
        }
        
        .summary-item .value.active { color: #059669; }
        .summary-item .value.inactive { color: #dc2626; }
        .summary-item .value.category { color: #7c3aed; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th {
            background-color: #1e40af;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #1e40af;
        }
        
        table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            font-size: 11px;
            vertical-align: top;
        }
        
        table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            min-width: 70px;
            text-align: center;
        }
        
        .status.aktif {
            background-color: #d1fae5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        
        .status.non-aktif {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .filter-info {
            margin-bottom: 20px;
            padding: 12px;
            background-color: #f0f9ff;
            border-radius: 6px;
            border: 1px solid #bae6fd;
            font-size: 11px;
        }
        
        .filter-info h3 {
            color: #0369a1;
            margin-bottom: 5px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo img {
            height: 60px;
        }
        
        .company-info {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .company-info h2 {
            color: #1e40af;
            margin: 5px 0;
            font-size: 18px;
        }
        
        .company-info p {
            color: #666;
            font-size: 12px;
            margin: 2px 0;
        }
        
        /* Print optimization */
        @media print {
            .summary-item {
                page-break-inside: avoid;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            thead {
                display: table-header-group;
            }
            
            tfoot {
                display: table-footer-group;
            }
        }
    </style>
</head>
<body>
    <!-- Logo and Company Info -->
    <div class="logo">
        <!-- Add your logo here if needed -->
        <div style="height: 40px;"></div>
    </div>
    
    <div class="company-info">
        <h2>LAPORAN SUPPLIER</h2>
        <p>Periode: {{ date('d/m/Y', strtotime($filter['start_date'] ?? 'now')) }} - {{ date('d/m/Y', strtotime($filter['end_date'] ?? 'now')) }}</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    @if($includeSummary)
    <div class="summary">
        <h2>Ringkasan Data</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">Total Supplier</div>
                <div class="value">{{ $summary['total_supplier'] }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Supplier Aktif</div>
                <div class="value active">{{ $summary['active_supplier'] }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Supplier Non-Aktif</div>
                <div class="value inactive">{{ $summary['inactive_supplier'] }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Kategori Material</div>
                <div class="value category">{{ $summary['total_category'] }}</div>
            </div>
        </div>
    </div>
    @endif
    
    @if(!empty(array_filter($filter)))
    <div class="filter-info">
        <h3>Filter yang diterapkan:</h3>
        <div>
            @if(!empty($filter['status']))
                <strong>Status:</strong> {{ implode(', ', $filter['status']) }} | 
            @endif
            @if($filter['start_date'] && $filter['end_date'])
                <strong>Periode:</strong> {{ date('d/m/Y', strtotime($filter['start_date'])) }} - {{ date('d/m/Y', strtotime($filter['end_date'])) }} | 
            @endif
            @if($filter['kategori_material'])
                <strong>Kategori:</strong> {{ $filter['kategori_material'] }}
            @endif
        </div>
    </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>Kategori</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Status</th>
                <th>Bergabung</th>
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
                    @else
                        -
                    @endif
                    @if($supplier->email)
                        <br><small>{{ $supplier->email }}</small>
                    @endif
                </td>
                <td>
                    <span class="status {{ $supplier->status == 'aktif' ? 'aktif' : 'non-aktif' }}">
                        {{ $supplier->status == 'aktif' ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($supplier->created_at)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #64748b; font-style: italic;">
                    Tidak ada data supplier ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Laporan ini dibuat secara otomatis oleh sistem pada {{ date('d/m/Y H:i:s') }}<br>
        Halaman {{ $suppliers->count() > 0 ? '1 dari 1' : '1' }}
    </div>
</body>
</html>