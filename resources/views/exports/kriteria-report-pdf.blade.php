<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kriteria Lengkap</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2563eb;
        }
        .header h1 { font-size: 20px; color: #1e40af; margin-bottom: 5px; }
        .header p { font-size: 10px; color: #666; }
        
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 15px;
            background: #eff6ff;
            border: 2px solid #bfdbfe;
            width: 25%;
        }
        .summary-label {
            font-size: 9px;
            color: #1e40af;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 18px;
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
            padding: 8px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #1e3a8a;
        }
        table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        table tr:nth-child(even) { background: #f8fafc; }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-benefit { background: #d1fae5; color: #065f46; }
        .badge-cost { background: #fee2e2; color: #991b1b; }
        
        .section-title {
            background: #3b82f6;
            color: white;
            padding: 8px 10px;
            margin: 15px 0 10px 0;
            font-size: 12px;
            font-weight: bold;
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
        
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KRITERIA LENGKAP</h1>
        <p>Dicetak pada: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>

    <div class="section-title">📊 RINGKASAN KRITERIA</div>
    <div class="summary-grid">
        <div class="summary-item">
            <div class="summary-label">Total Kriteria</div>
            <div class="summary-value">{{ $summary['total_kriteria'] }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Benefit</div>
            <div class="summary-value">{{ $summary['benefit_count'] }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Cost</div>
            <div class="summary-value">{{ $summary['cost_count'] }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Total Bobot</div>
            <div class="summary-value">{{ number_format($summary['total_weight'], 1) }}</div>
        </div>
    </div>

    <div class="section-title">📋 DETAIL KRITERIA</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Kriteria</th>
                <th style="width: 10%;">Tipe</th>
                <th style="width: 10%;">Bobot</th>
                <th style="width: 10%;">Digunakan</th>
                <th style="width: 13%;">Avg Score</th>
                <th style="width: 13%;">Max Score</th>
                <th style="width: 14%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kriterias as $index => $kriteria)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $kriteria->nama_kriteria }}</strong></td>
                <td class="text-center">
                    <span class="badge {{ $kriteria->type == 'benefit' ? 'badge-benefit' : 'badge-cost' }}">
                        {{ $kriteria->type == 'benefit' ? 'Benefit' : 'Cost' }}
                    </span>
                </td>
                <td class="text-center"><strong>{{ $kriteria->bobot }}</strong></td>
                <td class="text-center">{{ $kriteria->usage_count }} assessment</td>
                <td class="text-center">{{ number_format($kriteria->avg_score, 2) }}</td>
                <td class="text-center">{{ number_format($kriteria->max_score, 2) }}</td>
                <td>{{ $kriteria->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($summary['most_used'])
    <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 10px; margin: 15px 0;">
        <strong style="color: #92400e;">Kriteria Paling Sering Digunakan:</strong><br>
        <span style="font-size: 12px;">{{ $summary['most_used']->nama_kriteria }}</span> - 
        Digunakan dalam <strong>{{ $summary['most_used']->usage_count }}</strong> assessment
    </div>
    @endif

    <div class="footer">
        <p>Sistem Pendukung Keputusan Pemilihan Supplier - Laporan Kriteria Lengkap</p>
        <p>Dicetak: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
