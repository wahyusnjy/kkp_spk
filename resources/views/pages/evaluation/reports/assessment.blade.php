<x-layouts.app :title="__('Laporan Assessment')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <x-title-header :title="__('Laporan Assessment')" :base="__('Laporan')"/>

            <div class="flex items-center gap-4">
                <!-- Filter Button -->
                <button type="button" 
                    data-modal-target="filterModal" 
                    class="open-modal bg-gray-800 hover:bg-gray-700 text-gray-200 px-4 py-2 rounded-lg transition flex items-center gap-2 border border-gray-700">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>

                <!-- Export Button -->
                <button type="button" 
                    data-modal-target="exportModal" 
                    class="open-modal bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-file-export"></i>
                    <span>Export Data</span>
                </button>

                <!-- Print Button -->
                <button type="button" 
                    onclick="window.print()"
                    class="bg-blue-700 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-print"></i>
                    <span>Cetak</span>
                </button>
            </div>
        </div>
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gray-800 rounded-xl p-4 shadow border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Total Assessment</p>
                        <p class="text-2xl font-bold text-white">{{ $summary['total_assessment'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-900/50 p-3 rounded-full border border-blue-700/30">
                        <i class="fas fa-clipboard-list text-blue-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700">
                    <div class="flex items-center text-xs text-gray-400">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ now()->format('M Y') }}
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-4 shadow border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Assessment Selesai</p>
                        <p class="text-2xl font-bold text-green-400">{{ $summary['completed_assessment'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-900/50 p-3 rounded-full border border-green-700/30">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700">
                    <div class="flex items-center text-xs text-gray-400">
                        <i class="fas fa-chart-line mr-2"></i>
                        {{ $summary['total_assessment'] > 0 ? round(($summary['completed_assessment'] / $summary['total_assessment']) * 100, 1) : 0 }}%
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-4 shadow border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Dalam Proses</p>
                        <p class="text-2xl font-bold text-yellow-400">{{ $summary['in_progress_assessment'] ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-900/50 p-3 rounded-full border border-yellow-700/30">
                        <i class="fas fa-hourglass-half text-yellow-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700">
                    <div class="flex items-center text-xs text-gray-400">
                        <i class="fas fa-chart-line mr-2"></i>
                        {{ $summary['total_assessment'] > 0 ? round(($summary['in_progress_assessment'] / $summary['total_assessment']) * 100, 1) : 0 }}%
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-4 shadow border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Total Supplier Dinilai</p>
                        <p class="text-2xl font-bold text-purple-400">{{ $summary['total_suppliers_assessed'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-900/50 p-3 rounded-full border border-purple-700/30">
                        <i class="fas fa-users text-purple-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700">
                    <div class="flex items-center text-xs text-gray-400">
                        <i class="fas fa-building mr-2"></i>
                        Supplier unik
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="mt-4 bg-gray-800 rounded-xl shadow border border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Data Assessment</h3>
                        <p class="text-sm text-gray-400 mt-1">Data lengkap assessment berdasarkan filter yang dipilih</p>
                    </div>
                    <div class="text-sm text-gray-400">
                        <i class="fas fa-database mr-2"></i>
                        {{ $assessments->total() }} total data
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Jumlah Supplier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pemenang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($assessments as $assessment)
                        <tr class="hover:bg-gray-700/50 transition duration-150" data-assessment-id="{{ $assessment->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-900/50 flex items-center justify-center mr-3 border border-blue-700/30">
                                        <i class="fas fa-hashtag text-blue-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-white">#{{ $assessment->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white">{{ $assessment->material->nama_material ?? '-' }}</div>
                                @if($assessment->deskripsi)
                                <div class="text-xs text-gray-400 mt-1">{{ Str::limit($assessment->deskripsi, 40) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-xs rounded-full bg-gray-700 text-gray-300 border border-gray-600">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $assessment->tahun }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-white flex items-center">
                                    <i class="fas fa-building mr-2 text-gray-400"></i>
                                    {{ $assessment->supplier_count }} Supplier
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($assessment->status == 'completed')
                                    <span class="px-3 py-1.5 text-xs rounded-full bg-green-900/30 text-green-400 font-medium border border-green-700/30">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Selesai
                                    </span>
                                @elseif($assessment->status == 'scoring')
                                    <span class="px-3 py-1.5 text-xs rounded-full bg-yellow-900/30 text-yellow-400 font-medium border border-yellow-700/30">
                                        <i class="fas fa-hourglass-half mr-1"></i>
                                        Scoring
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 text-xs rounded-full bg-gray-700 text-gray-400 font-medium border border-gray-600">
                                        <i class="fas fa-file mr-1"></i>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $winner = $assessment->topsisResults()->orderBy('rank')->first();
                                @endphp
                                @if($winner)
                                <div class="text-sm font-medium text-white flex items-center">
                                    <i class="fas fa-trophy text-yellow-400 mr-2"></i>
                                    {{ $winner->supplier->nama_supplier ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    Score: {{ number_format($winner->preference_score * 100, 2) }}%
                                </div>
                                @else
                                    <span class="text-sm text-gray-500 italic">Belum ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-white">
                                    {{ \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($assessment->created_at)->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="toggleDetail({{ $assessment->id }})" 
                                        class="text-blue-400 hover:text-blue-300 transition">
                                    <i class="fas fa-chevron-down toggle-icon" id="icon-{{ $assessment->id }}"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Detail Row -->
                        <tr class="detail-row hidden" id="detail-{{ $assessment->id }}">
                            <td colspan="8" class="px-0 py-0">
                                <div class="bg-gray-900/50 p-6 border-t border-gray-700">
                                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
                                        <!-- Basic Info -->
                                        <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
                                            <h4 class="text-white font-semibold mb-3 flex items-center gap-2">
                                                <i class="fas fa-info-circle text-blue-400"></i>
                                                Informasi
                                            </h4>
                                            <div class="space-y-2 text-sm">
                                                <div>
                                                    <span class="text-gray-400">Material:</span>
                                                    <span class="text-white ml-2">{{ $assessment->material->nama_material }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-400">Tahun:</span>
                                                    <span class="text-white ml-2">{{ $assessment->tahun }}</span>
                                                </div>
                                                @if($assessment->deskripsi)
                                                <div>
                                                    <span class="text-gray-400">Deskripsi:</span>
                                                    <p class="text-gray-300 mt-1 text-xs">{{ $assessment->deskripsi }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Statistics -->
                                        <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
                                            <h4 class="text-white font-semibold mb-3 flex items-center gap-2">
                                                <i class="fas fa-chart-bar text-green-400"></i>
                                                Statistik
                                            </h4>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="bg-gray-700/50 rounded p-2">
                                                    <div class="text-xs text-gray-400">Supplier</div>
                                                    <div class="text-lg font-bold text-white">{{ $assessment->supplier_count }}</div>
                                                </div>
                                                <div class="bg-gray-700/50 rounded p-2">
                                                    <div class="text-xs text-gray-400">Kriteria</div>
                                                    <div class="text-lg font-bold text-white">{{ $assessment->scores->groupBy('kriteria_id')->count() }}</div>
                                                </div>
                                                <div class="bg-gray-700/50 rounded p-2">
                                                    <div class="text-xs text-gray-400">Total Nilai</div>
                                                    <div class="text-lg font-bold text-white">{{ number_format($assessment->scores->sum('score'), 0) }}</div>
                                                </div>
                                                <div class="bg-gray-700/50 rounded p-2">
                                                    <div class="text-xs text-gray-400">Rata-rata</div>
                                                    <div class="text-lg font-bold text-white">{{ number_format($assessment->scores->avg('score') ?? 0, 1) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- TOPSIS Results (if any) -->
                                        @if($assessment->topsisResults->count() > 0)
                                        <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 lg:col-span-2">
                                            <h4 class="text-white font-semibold mb-3 flex items-center gap-2">
                                                <i class="fas fa-trophy text-yellow-400"></i>
                                                Top 3 Hasil TOPSIS
                                            </h4>
                                            <div class="space-y-2">
                                                @foreach($assessment->topsisResults()->orderBy('rank')->take(3)->get() as $result)
                                                <div class="flex items-center justify-between bg-gray-700/50 rounded p-2">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 {{ $result->rank == 1 ? 'bg-yellow-600' : 'bg-gray-600' }} rounded-lg flex items-center justify-center">
                                                            <span class="text-white font-bold text-sm">#{{ $result->rank }}</span>
                                                        </div>
                                                        <div>
                                                            <div class="text-white font-medium text-sm">{{ $result->supplier->nama_supplier }}</div>
                                                            <div class="text-xs text-gray-400">{{ number_format($result->preference_score * 100, 2) }}%</div>
                                                        </div>
                                                    </div>
                                                    <div class="w-24 bg-gray-600 rounded-full h-2">
                                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $result->preference_score * 100 }}%"></div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @else
                                        <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 lg:col-span-2">
                                            <div class="text-center py-4">
                                                <i class="fas fa-calculator text-gray-600 text-3xl mb-2"></i>
                                                <p class="text-gray-400 text-sm">Belum ada hasil TOPSIS</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Export Detailed Report Button -->
                                    <div class="bg-gradient-to-r from-green-900/30 to-blue-900/30 rounded-xl p-4 border border-green-700/30 mb-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-file-download text-white text-xl"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-white font-semibold">Export Laporan Detail</h4>
                                                    <p class="text-gray-400 text-xs">Download laporan lengkap dengan perhitungan TOPSIS</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button onclick="exportDetailed({{ $assessment->id }}, 'pdf')" 
                                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span class="text-sm">PDF</span>
                                                </button>
                                                <button onclick="exportDetailed({{ $assessment->id }}, 'excel')" 
                                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                                                    <i class="fas fa-file-excel"></i>
                                                    <span class="text-sm">Excel</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Supplier Scores Details -->
                                    @if($assessment->scores->count() > 0)
                                    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                                        <div class="px-4 py-3 bg-gray-700/50 border-b border-gray-700">
                                            <h4 class="text-white font-semibold flex items-center gap-2">
                                                <i class="fas fa-users text-purple-400"></i>
                                                Detail Penilaian Supplier
                                            </h4>
                                        </div>
                                        <div class="p-4 max-h-96 overflow-y-auto">
                                            @php
                                                $scoresBySupplier = $assessment->scores->groupBy('supplier_id');
                                            @endphp
                                            <div class="space-y-4">
                                                @foreach($scoresBySupplier as $supplierId => $scores)
                                                @php
                                                    $supplier = $scores->first()->supplier;
                                                    $totalScore = $scores->sum('score');
                                                    $averageScore = $scores->avg('score');
                                                @endphp
                                                <div class="bg-gray-700/30 rounded-lg border border-gray-700 overflow-hidden">
                                                    <div class="px-4 py-2 bg-gray-700/50 flex justify-between items-center">
                                                        <div class="flex items-center gap-2">
                                                            <i class="fas fa-building text-blue-400"></i>
                                                            <span class="text-white font-medium">{{ $supplier->nama_supplier }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-4 text-sm">
                                                            <div>
                                                                <span class="text-gray-400">Total:</span>
                                                                <span class="text-white font-semibold">{{ number_format($totalScore, 1) }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="text-gray-400">Avg:</span>
                                                                <span class="text-white font-semibold">{{ number_format($averageScore, 1) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-3">
                                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                                                            @foreach($scores as $score)
                                                            <div class="bg-gray-800 rounded p-2 border border-gray-600">
                                                                <div class="text-xs text-gray-400 mb-1">{{ $score->kriteria->nama_kriteria }}</div>
                                                                <div class="flex items-center justify-between">
                                                                    <span class="text-white font-semibold">{{ number_format($score->score, 1) }}</span>
                                                                    <span class="text-xs px-2 py-0.5 rounded {{ $score->kriteria->type == 'benefit' ? 'bg-green-900/30 text-green-400' : 'bg-red-900/30 text-red-400' }}">
                                                                        {{ $score->kriteria->type == 'benefit' ? 'B' : 'C' }}
                                                                    </span>
                                                                </div>
                                                                <div class="w-full bg-gray-600 rounded-full h-1 mt-1">
                                                                    <div class="bg-blue-500 h-1 rounded-full" style="width: {{ $score->score }}%"></div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="bg-gray-800 rounded-xl border border-gray-700 p-8 text-center">
                                        <i class="fas fa-star text-gray-600 text-4xl mb-3"></i>
                                        <p class="text-gray-400">Belum ada penilaian untuk assessment ini</p>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-900 flex items-center justify-center mb-4 border border-gray-700">
                                        <i class="fas fa-inbox text-gray-500 text-2xl"></i>
                                    </div>
                                    <p class="text-lg font-medium text-gray-400">Tidak ada data assessment</p>
                                    <p class="text-sm text-gray-500 mt-2">Data akan muncul setelah ada assessment yang terdaftar</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($assessments->hasPages())
            <div class="px-6 py-4 border-t border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-400">
                        Menampilkan {{ $assessments->firstItem() ?? 0 }} - {{ $assessments->lastItem() ?? 0 }} dari {{ $assessments->total() }} data
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $assessments->links('vendor.pagination.tailwind-dark') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-gray-800 border border-gray-700 rounded-2xl shadow-xl p-6 md:p-8 transform transition-all duration-300">
                <!-- Header -->
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-700">
                    <div>
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-filter mr-2 text-blue-400"></i>
                            Filter Laporan
                        </h3>
                        <p class="text-sm text-gray-400 mt-1">Sesuaikan filter untuk data laporan assessment</p>
                    </div>
                    <button type="button" 
                            class="close-modal text-gray-400 hover:text-white hover:bg-gray-700 rounded-full p-2 transition-colors duration-200" 
                            data-modal="filterModal">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <form action="{{ route('reports.assessments.filter') }}" method="GET" id="filterForm">
                    <div class="space-y-6 py-2">
                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-3">Status Assessment</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <div class="relative">
                                        <input type="checkbox" name="status[]" value="completed" class="sr-only peer">
                                        <div class="w-5 h-5 rounded border border-gray-600 peer-checked:border-green-500 peer-checked:bg-green-900/30 flex items-center justify-center group-hover:border-gray-500 transition">
                                            <i class="fas fa-check text-green-400 text-xs opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                        <span class="text-sm text-gray-300 group-hover:text-white">Selesai</span>
                                    </div>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <div class="relative">
                                        <input type="checkbox" name="status[]" value="scoring" class="sr-only peer">
                                        <div class="w-5 h-5 rounded border border-gray-600 peer-checked:border-yellow-500 peer-checked:bg-yellow-900/30 flex items-center justify-center group-hover:border-gray-500 transition">
                                            <i class="fas fa-check text-yellow-400 text-xs opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></div>
                                        <span class="text-sm text-gray-300 group-hover:text-white">Proses</span>
                                    </div>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <div class="relative">
                                        <input type="checkbox" name="status[]" value="draft" class="sr-only peer">
                                        <div class="w-5 h-5 rounded border border-gray-600 peer-checked:border-gray-500 peer-checked:bg-gray-700 flex items-center justify-center group-hover:border-gray-500 transition">
                                            <i class="fas fa-check text-gray-400 text-xs opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-gray-500 mr-2"></div>
                                        <span class="text-sm text-gray-300 group-hover:text-white">Draft</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Year Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Tahun</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-500"></i>
                                    </div>
                                    <select name="tahun" 
                                           class="w-full pl-10 pr-3 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                        <option value="" class="bg-gray-800">Semua Tahun</option>
                                        @foreach($yearList as $year)
                                        <option value="{{ $year }}" class="bg-gray-800">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Material</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-box text-gray-500"></i>
                                    </div>
                                    <select name="material_id" 
                                           class="w-full pl-10 pr-3 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                        <option value="" class="bg-gray-800">Semua Material</option>
                                        @foreach($materialList as $material)
                                        <option value="{{ $material->id }}" class="bg-gray-800">{{ $material->nama_material }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Date Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Dari Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-500"></i>
                                    </div>
                                    <input type="date" name="start_date" 
                                           class="w-full pl-10 pr-3 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Sampai Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-500"></i>
                                    </div>
                                    <input type="date" name="end_date" 
                                           class="w-full pl-10 pr-3 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action buttons -->
                    <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-700">
                        <button type="button" 
                                onclick="document.getElementById('filterForm').reset()"
                                class="px-5 py-2.5 text-gray-300 bg-gray-700 border border-gray-600 hover:bg-gray-600 hover:border-gray-500 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-redo mr-2"></i>
                            Reset Filter
                        </button>
                        <div class="flex items-center space-x-3">
                            <button type="button" 
                                    class="close-modal px-5 py-2.5 text-gray-300 bg-gray-700 border border-gray-600 hover:bg-gray-600 hover:border-gray-500 rounded-lg font-medium transition-colors duration-200" 
                                    data-modal="filterModal">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                <i class="fas fa-filter mr-2"></i> 
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="exportModal" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-gray-800 border border-gray-700 rounded-2xl shadow-xl p-6 md:p-8 transform transition-all duration-300">
                <!-- Header -->
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-700">
                    <div>
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-file-export mr-2 text-green-400"></i>
                            Export Data
                        </h3>
                        <p class="text-sm text-gray-400 mt-1">Pilih format untuk export data assessment</p>
                    </div>
                    <button type="button" 
                            class="close-modal text-gray-400 hover:text-white hover:bg-gray-700 rounded-full p-2 transition-colors duration-200" 
                            data-modal="exportModal">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <form action="{{ route('reports.export.assessments') }}" method="GET" id="exportForm">
                    <div class="space-y-6 py-2">
                        <!-- Format Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-4">Pilih Format Export</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="format" value="excel" checked class="sr-only peer">
                                    <div class="flex flex-col items-center justify-center p-4 border-2 border-gray-700 rounded-xl group-hover:border-green-500 peer-checked:border-green-500 peer-checked:bg-green-900/20 transition-all duration-200">
                                        <div class="mb-2">
                                            <div class="w-12 h-12 rounded-lg bg-green-900/30 flex items-center justify-center border border-green-700/30">
                                                <i class="fas fa-file-excel text-green-400 text-2xl"></i>
                                            </div>
                                        </div>
                                        <span class="font-medium text-white">Excel</span>
                                        <span class="text-xs text-gray-400">.xlsx</span>
                                    </div>
                                    <div class="absolute top-2 right-2 w-4 h-4 border-2 border-gray-600 rounded-full peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                        <i class="fas fa-check text-white text-[8px] opacity-0 peer-checked:opacity-100"></i>
                                    </div>
                                </label>
                                
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="format" value="pdf" class="sr-only peer">
                                    <div class="flex flex-col items-center justify-center p-4 border-2 border-gray-700 rounded-xl group-hover:border-red-500 peer-checked:border-red-500 peer-checked:bg-red-900/20 transition-all duration-200">
                                        <div class="mb-2">
                                            <div class="w-12 h-12 rounded-lg bg-red-900/30 flex items-center justify-center border border-red-700/30">
                                                <i class="fas fa-file-pdf text-red-400 text-2xl"></i>
                                            </div>
                                        </div>
                                        <span class="font-medium text-white">PDF</span>
                                        <span class="text-xs text-gray-400">.pdf</span>
                                    </div>
                                    <div class="absolute top-2 right-2 w-4 h-4 border-2 border-gray-600 rounded-full peer-checked:border-red-500 peer-checked:bg-red-500 flex items-center justify-center">
                                        <i class="fas fa-check text-white text-[8px] opacity-0 peer-checked:opacity-100"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Export Options -->
                        <div class="bg-gray-900/50 rounded-xl p-4 border border-gray-700">
                            <label class="flex items-start space-x-3 cursor-pointer group">
                                <div class="relative mt-0.5">
                                    <input type="checkbox" name="include_summary" checked class="sr-only peer">
                                    <div class="w-5 h-5 rounded border border-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-900/30 flex items-center justify-center group-hover:border-gray-500 transition">
                                        <i class="fas fa-check text-blue-400 text-xs opacity-0 peer-checked:opacity-100"></i>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-white group-hover:text-blue-300">Sertakan Ringkasan</span>
                                    <p class="text-xs text-gray-400 mt-1">Tambahkan data ringkasan di halaman awal export</p>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Quick Export -->
                        <div class="bg-gray-900/50 rounded-xl p-4 border border-gray-700">
                            <p class="text-sm font-medium text-white mb-2">Export Cepat</p>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" 
                                        onclick="quickExport('excel')"
                                        class="px-3 py-1.5 text-xs bg-green-900/30 text-green-400 hover:bg-green-800 rounded-lg border border-green-700/30 transition">
                                    <i class="fas fa-file-excel mr-1"></i> Excel Tahun Ini
                                </button>
                                <button type="button" 
                                        onclick="quickExport('pdf')"
                                        class="px-3 py-1.5 text-xs bg-red-900/30 text-red-400 hover:bg-red-800 rounded-lg border border-red-700/30 transition">
                                    <i class="fas fa-file-pdf mr-1"></i> PDF Tahun Ini
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action buttons -->
                    <div class="flex items-center justify-end pt-6 mt-6 border-t border-gray-700 space-x-3">
                        <button type="button" 
                                class="close-modal px-5 py-2.5 text-gray-300 bg-gray-700 border border-gray-600 hover:bg-gray-600 hover:border-gray-500 rounded-lg font-medium transition-colors duration-200" 
                                data-modal="exportModal">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                            <i class="fas fa-download mr-2"></i> 
                            Download
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalOverlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 hidden"></div>
</x-layouts.app>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal listener
        document.addEventListener('click', function(e) {
            if (e.target.closest('.open-modal')) {
                const button = e.target.closest('.open-modal');
                const modalId = button.getAttribute('data-modal-target');
                openModal(modalId);
            }
            
            if (e.target.closest('.close-modal')) {
                const button = e.target.closest('.close-modal');
                const modalId = button.getAttribute('data-modal');
                closeModal(modalId);
            }
            
            if (e.target.id === 'modalOverlay') {
                const openModals = document.querySelectorAll('.fixed:not(.hidden)');
                openModals.forEach(modal => {
                    if (modal.id !== 'modalOverlay') {
                        closeModal(modal.id);
                    }
                });
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.fixed:not(.hidden)');
                openModals.forEach(modal => {
                    if (modal.id !== 'modalOverlay') {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.3)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById('modalOverlay');
        
        if (modal) {
            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById('modalOverlay');
        
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
    
    function quickExport(format) {
        const currentYear = new Date().getFullYear();
        
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = "{{ route('reports.export.assessments') }}";
        form.style.display = 'none';
        
        const formatInput = document.createElement('input');
        formatInput.type = 'hidden';
        formatInput.name = 'format';
        formatInput.value = format;
        form.appendChild(formatInput);
        
        const yearInput = document.createElement('input');
        yearInput.type = 'hidden';
        yearInput.name = 'tahun';
        yearInput.value = currentYear;
        form.appendChild(yearInput);
        
        const summaryInput = document.createElement('input');
        summaryInput.type = 'hidden';
        summaryInput.name = 'include_summary';
        summaryInput.value = 'on';
        form.appendChild(summaryInput);
        
        document.body.appendChild(form);
        
        Swal.fire({
            title: 'Sedang Menyiapkan File',
            text: `Meng-generate file ${format.toUpperCase()} untuk tahun ${currentYear}...`,
            allowOutsideClick: false,
            showConfirmButton: false,
            background: '#1f2937',
            color: '#fff',
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        form.submit();
    }
    
    document.getElementById('exportForm')?.addEventListener('submit', function(e) {
        const format = document.querySelector('input[name="format"]:checked').value;
        Swal.fire({
            title: 'Sedang Menyiapkan File',
            text: `Meng-generate file ${format.toUpperCase()}...`,
            allowOutsideClick: false,
            showConfirmButton: false,
            background: '#1f2937',
            color: '#fff',
            willOpen: () => {
                Swal.showLoading();
            }
        });
    });
    
    // Toggle detail function
    function toggleDetail(assessmentId) {
        const detailRow = document.getElementById(`detail-${assessmentId}`);
        const icon = document.getElementById(`icon-${assessmentId}`);
        
        if (detailRow.classList.contains('hidden')) {
            detailRow.classList.remove('hidden');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
            // Smooth scroll to detail
            setTimeout(() => {
                detailRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        } else {
            detailRow.classList.add('hidden');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
    
    // Export detailed assessment function
    function exportDetailed(assessmentId, format) {
        Swal.fire({
            title: 'Menyiapkan Laporan Detail',
            text: `Membuat file ${format.toUpperCase()} dengan perhitungan TOPSIS lengkap...`,
            allowOutsideClick: false,
            showConfirmButton: false,
            background: '#1f2937',
            color: '#fff',
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Redirect to export URL
        window.location.href = `/reports/assessments/${assessmentId}/export-detailed?format=${format}`;
        
        // Close after a delay
        setTimeout(() => {
            Swal.close();
        }, 2000);
    }
</script>

<style>
    /* Dark Mode Scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }
    
    ::-webkit-scrollbar-track {
        background: #374151;
        border-radius: 5px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #4B5563;
        border-radius: 5px;
        border: 2px solid #374151;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #6B7280;
    }
    
    /* Table hover effects */
    tbody tr {
        transition: all 0.2s ease;
        position: relative;
    }
    
    tbody tr:hover {
        z-index: 10;
    }
    
    /* Detail row animation */
    .detail-row td > div {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .toggle-icon {
        transition: transform 0.3s ease;
    }
    
    /* Print Styles */
    @media print {
        body {
            background: white !important;
            color: black !important;
        }
        
        .no-print, button, .open-modal, .close-modal {
            display: none !important;
        }
        
        .bg-gray-800, .bg-gray-900 {
            background: white !important;
            color: black !important;
        }
        
        .border-gray-700, .border-gray-600 {
            border-color: #ddd !important;
        }
        
        .text-white, .text-gray-300 {
            color: black !important;
        }
        
        table th {
            background-color: #f5f5f5 !important;
            color: black !important;
        }
    }
    
    /* Modal Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { 
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to { 
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .max-h-full {
        animation: slideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #modalOverlay {
        animation: fadeIn 0.3s ease-out;
    }
</style>
