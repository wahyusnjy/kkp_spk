<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Executive Summary</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            border-radius: 8px;
        }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 11px; opacity: 0.9; }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .stat-row {
            display: table-row;
        }
        .stat-box {
            display: table-cell;
            text-align: center;
            padding: 15px;
            background: #eff6ff;
            border: 2px solid #bfdbfe;
            width: 25%;
        }
        .stat-label {
            font-size: 9px;
            color: #1e40af;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 22px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background: #3b82f6;
            color: white;
            padding: 8px 10px;
            margin: 10px 0;
            font-size: 12px;
            font-weight: bold;
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
        }
        table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        table tr:nth-child(even) { background: #f8fafc; }
        
        .highlight-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin: 10px 0;
        }
        .highlight-box h4 {
            color: #92400e;
            margin-bottom: 5px;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info { background: #e0e7ff; color: #3730a3; }
        
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
        <h1>📊 EXECUTIVE SUMMARY</h1>
        <p>Sistem Pendukung Keputusan Pemilihan Supplier</p>
        <p>Dicetak pada: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>

    {{-- Assessment Statistics --}}
    <div class="section-title">📋 STATISTIK ASSESSMENT</div>
    <div class="stats-grid">
        <div class="stat-row">
            <div class="stat-box">
                <div class="stat-label">Total Assessment</div>
                <div class="stat-value">{{ $summary['total_assessments'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Selesai</div>
                <div class="stat-value" style="color: #10b981;">{{ $summary['completed_assessments'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Dalam Proses</div>
                <div class="stat-value" style="color: #f59e0b;">{{ $summary['in_progress_assessments'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Draft</div>
                <div class="stat-value" style="color: #6b7280;">{{ $summary['draft_assessments'] }}</div>
            </div>
        </div>
    </div>

    {{-- Supplier & Kriteria Statistics --}}
    <div class="section-title">👥 SUPPLIER & KRITERIA</div>
    <div class="stats-grid">
        <div class="stat-row">
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
    </div>

    {{-- Top Supplier --}}
    @if($summary['top_supplier'])
    <div class="highlight-box">
        <h4>🏆 SUPPLIER TERBAIK</h4>
        <p style="font-size: 13px; margin-top: 5px;">
            <strong>{{ $summary['top_supplier']['supplier']->nama_supplier }}</strong> 
            ({{ $summary['top_supplier']['supplier']->kode_supplier }})
        </p>
        <p style="font-size: 10px; color: #666; margin-top: 3px;">
            Memenangkan <strong>{{ $summary['top_supplier']['win_count'] }}</strong> assessment
        </p>
    </div>
    @endif

    {{-- Recent Assessments --}}
    <div class="section-title">🕒 ASSESSMENT TERBARU</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Material</th>
                <th>Tahun</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summary['recent_assessments'] as $assessment)
            <tr>
                <td class="text-center">#{{ $assessment->id }}</td>
                <td>{{ $assessment->material->nama_material }}</td>
                <td class="text-center">{{ $assessment->tahun }}</td>
                <td class="text-center">
                    @if($assessment->topsisResults->count() > 0)
                        <span class="badge badge-success">Selesai</span>
                    @elseif($assessment->scores->count() > 0)
                        <span class="badge badge-warning">Proses</span>
                    @else
                        <span class="badge badge-info">Draft</span>
                    @endif
                </td>
                <td class="text-center">{{ \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Recent Winners --}}
    <div class="section-title">🎯 PEMENANG TERBARU</div>
    <table>
        <thead>
            <tr>
                <th>Supplier</th>
                <th>Assessment</th>
                <th>Material</th>
                <th>Preference Score</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summary['recent_winners'] as $winner)
            <tr>
                <td><strong>{{ $winner->supplier->nama_supplier }}</strong></td>
                <td class="text-center">#{{ $winner->assessment_id }}</td>
                <td>{{ $winner->assessment->material->nama_material }}</td>
                <td class="text-center"><strong>{{ number_format($winner->preference_score * 100, 2) }}%</strong></td>
                <td class="text-center">{{ \Carbon\Carbon::parse($winner->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistem Pendukung Keputusan Pemilihan Supplier - Executive Summary</p>
        <p>Dicetak: {{ $exportDate->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
