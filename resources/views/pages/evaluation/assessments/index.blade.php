<x-layouts.app :title="__('Assessments')">
    <style>
        /* Force dark mode styles */
        .assessments-container * {
            color-scheme: dark !important;
        }
        
        /* Dark mode scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1f2937;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
        
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        /* Tooltip styles */
        .custom-tooltip {
            position: relative;
        }
        
        .custom-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #111827;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            border: 1px solid #374151;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        /* Hover effects */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
    
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl assessments-container">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white flex items-center gap-3">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 w-12 h-12 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    Assessments
                </h1>
                <p class="text-gray-300 mt-2">Kelola penilaian dan perbandingan multi-supplier</p>
            </div>
            <a href="{{ route('assessments.create') }}" 
               class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-3 rounded-xl transition-all duration-300 flex items-center gap-2 group hover-lift">
                <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="font-medium">Tambah Assessment</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 fade-in">
            @php
                $completedAssessments = $assessments->where('topsisResults.count', '>', 0)->count();
                $pendingAssessments = $assessments->where('scores.count', '>', 0)->where('topsisResults.count', 0)->count();
                $totalSuppliers = $assessments->sum(function($assessment) { 
                    return $assessment->scores->groupBy('supplier_id')->count(); 
                });
                $totalScore = $assessments->sum('total_score');
            @endphp
            
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 p-4 hover-lift">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-800/40 to-blue-900/60 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-list text-blue-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Assessments</p>
                        <p class="text-white font-bold text-xl">{{ $assessments->total() ?? 0 }}</p>
                        <div class="w-full bg-gray-700 rounded-full h-1.5 mt-2">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 p-4 hover-lift">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-800/40 to-emerald-900/60 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Selesai TOPSIS</p>
                        <p class="text-white font-bold text-xl">{{ $completedAssessments ?? 0 }}</p>
                        <div class="w-full bg-gray-700 rounded-full h-1.5 mt-2">
                            <div class="bg-emerald-500 h-1.5 rounded-full" 
                                 style="width: {{ $assessments->total() > 0 ? ($completedAssessments / $assessments->total() * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 p-4 hover-lift">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-800/40 to-amber-900/60 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-spinner text-amber-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Belum Diproses</p>
                        <p class="text-white font-bold text-xl">{{ $pendingAssessments ?? 0 }}</p>
                        <div class="w-full bg-gray-700 rounded-full h-1.5 mt-2">
                            <div class="bg-amber-500 h-1.5 rounded-full" 
                                 style="width: {{ $assessments->total() > 0 ? ($pendingAssessments / $assessments->total() * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 p-4 hover-lift">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-800/40 to-purple-900/60 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-purple-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Supplier</p>
                        <p class="text-white font-bold text-xl">{{ $totalSuppliers ?? 0 }}</p>
                        <div class="w-full bg-gray-700 rounded-full h-1.5 mt-2">
                            <div class="bg-purple-500 h-1.5 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 p-4 hover-lift">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-800/40 to-cyan-900/60 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calculator text-cyan-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Nilai</p>
                        <p class="text-white font-bold text-xl">{{ number_format($totalScore ?? 0) }}</p>
                        <div class="w-full bg-gray-700 rounded-full h-1.5 mt-2">
                            <div class="bg-cyan-500 h-1.5 rounded-full" style="width: 40%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 p-5 fade-in">
            <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
                <div class="flex flex-wrap gap-3">
                    <div class="relative">
                        <select id="statusFilter" class="bg-gray-900/50 border border-gray-600 rounded-lg pl-10 pr-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-full min-w-[180px]">
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="input">Input Nilai</option>
                            <option value="topsis">Proses TOPSIS</option>
                            <option value="completed">Selesai</option>
                        </select>
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-filter text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select id="materialFilter" class="bg-gray-900/50 border border-gray-600 rounded-lg pl-10 pr-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-full min-w-[180px]">
                            <option value="">Semua Material</option>
                            @foreach($materials ?? [] as $material)
                                <option value="{{ $material->id }}">{{ $material->nama_material }}</option>
                            @endforeach
                        </select>
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-cube text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select id="yearFilter" class="bg-gray-900/50 border border-gray-600 rounded-lg pl-10 pr-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-full min-w-[180px]">
                            <option value="">Semua Tahun</option>
                            @php
                                $years = $assessments->pluck('tahun')->unique()->sortDesc();
                            @endphp
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="far fa-calendar text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="relative w-full lg:w-64">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari assessment..." 
                           class="w-full bg-gray-900/50 border border-gray-600 rounded-lg pl-12 pr-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-arrow-right text-blue-400 text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-gray-900/80 border-b border-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-hashtag text-blue-400"></i>
                                    <span>Assessment</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cube text-purple-400"></i>
                                    Material & Tahun
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-users text-emerald-400"></i>
                                    Jumlah Supplier
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tasks text-amber-400"></i>
                                    Status
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-clock text-gray-400"></i>
                                    Tanggal
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cog text-cyan-400"></i>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700" id="assessmentTable">
                        @forelse($assessments as $assessment)
                            <tr class="hover:bg-gray-800/50 transition-colors duration-200 group assessment-row"
                                data-status="{{ $assessment->topsisResults->count() > 0 ? 'completed' : ($assessment->scores->count() > 0 ? 'input' : 'draft') }}"
                                data-material="{{ $assessment->material_id }}"
                                data-year="{{ $assessment->tahun }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg
                                            {{ $assessment->topsisResults->count() > 0 ? 'bg-gradient-to-br from-emerald-600 to-emerald-800' : 
                                               ($assessment->scores->count() > 0 ? 'bg-gradient-to-br from-amber-600 to-amber-800' : 
                                               'bg-gradient-to-br from-blue-600 to-blue-800') }}">
                                            @if($assessment->topsisResults->count() > 0)
                                                <i class="fas fa-trophy text-white text-base"></i>
                                            @elseif($assessment->scores->count() > 0)
                                                <i class="fas fa-spinner text-white text-base"></i>
                                            @else
                                                <i class="fas fa-clipboard text-white text-base"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-white font-semibold text-lg">#{{ $assessment->id }}</div>
                                            @if($assessment->deskripsi)
                                                <div class="text-gray-400 text-sm truncate max-w-xs">{{ Str::limit($assessment->deskripsi, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600/20 to-purple-800/10 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-cube text-purple-400"></i>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ $assessment->material->nama_material ?? 'N/A' }}</div>
                                            <div class="text-gray-400 text-sm flex items-center gap-1">
                                                <i class="far fa-calendar text-xs"></i>
                                                {{ $assessment->tahun }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-600/20 to-emerald-800/10 rounded-full flex items-center justify-center">
                                                <i class="fas fa-users text-emerald-400 text-xs"></i>
                                            </div>
                                            <div>
                                                <span class="text-white font-medium">{{ $assessment->scores->groupBy('supplier_id')->count() }}</span>
                                                <span class="text-gray-400 text-sm"> supplier</span>
                                            </div>
                                        </div>
                                        @if($assessment->topsisResults->count() > 0)
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 bg-gradient-to-br from-purple-600/20 to-purple-800/10 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-trophy text-purple-400 text-xs"></i>
                                                </div>
                                                <div>
                                                    <span class="text-white font-medium">#{{ $assessment->topsisResults->where('rank', 1)->first()->rank ?? '?' }}</span>
                                                    <span class="text-gray-400 text-sm"> rank</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $status = $assessment->topsisResults->count() > 0 ? 'completed' : 
                                                 ($assessment->scores->count() > 0 ? 'input' : 'draft');
                                        $statusConfig = [
                                            'draft' => [
                                                'gradient' => 'bg-gradient-to-r from-gray-600 to-gray-700',
                                                'icon' => 'fa-edit',
                                                'text' => 'Draft',
                                                'description' => 'Belum ada nilai',
                                                'dot' => 'bg-gray-500'
                                            ],
                                            'input' => [
                                                'gradient' => 'bg-gradient-to-r from-amber-600 to-amber-700',
                                                'icon' => 'fa-star',
                                                'text' => 'Input Nilai',
                                                'description' => 'Sudah input nilai',
                                                'dot' => 'bg-amber-500'
                                            ],
                                            'completed' => [
                                                'gradient' => 'bg-gradient-to-r from-emerald-600 to-emerald-700',
                                                'icon' => 'fa-check-circle',
                                                'text' => 'Selesai',
                                                'description' => 'Hasil TOPSIS tersedia',
                                                'dot' => 'bg-emerald-500 animate-pulse'
                                            ]
                                        ];
                                        $config = $statusConfig[$status];
                                    @endphp
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full {{ $config['dot'] }}"></div>
                                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold {{ $config['gradient'] }} text-white w-fit">
                                                <i class="fas {{ $config['icon'] }} text-xs"></i>
                                                {{ $config['text'] }}
                                            </span>
                                        </div>
                                        <span class="text-gray-400 text-xs">{{ $config['description'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-white text-sm font-medium">{{ $assessment->created_at->format('d M Y') }}</div>
                                    <div class="text-gray-400 text-xs">{{ $assessment->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2 opacity-80 group-hover:opacity-100 transition-opacity duration-200">
                                        <!-- View Details Button -->
                                        <a href="{{ route('assessments.show', $assessment->id) }}" 
                                           class="bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 custom-tooltip hover-lift"
                                           data-tooltip="Detail">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        
                                        @if($assessment->topsisResults->count() > 0)
                                            <!-- View TOPSIS Results Button -->
                                            <a href="{{ route('results.show', $assessment->id) }}" 
                                               class="bg-gradient-to-br from-emerald-600 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 custom-tooltip hover-lift"
                                               data-tooltip="Hasil TOPSIS">
                                                <i class="fas fa-chart-bar text-sm"></i>
                                            </a>
                                        @elseif($assessment->scores->count() > 0)
                                            <!-- Process TOPSIS Button -->
                                            <button class="calculate-topsis bg-gradient-to-br from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 custom-tooltip hover-lift"
                                               data-tooltip="Proses TOPSIS" 
                                               data-id="{{ $assessment->id }}"
                                               data-url="{{ route('assessments.calculate', $assessment->id) }}">
                                                <i class="fas fa-calculator text-sm"></i>
                                            </button>
                                            
                                            <!-- Edit Scores Button -->
                                            <a href="#" 
                                               class="bg-gradient-to-br from-amber-600 to-amber-800 hover:from-amber-700 hover:to-amber-900 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 custom-tooltip hover-lift"
                                               data-tooltip="Edit Nilai">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                        @else
                                            <!-- Add Scores Button -->
                                            <a href="#" 
                                               class="bg-gradient-to-br from-amber-600 to-amber-800 hover:from-amber-700 hover:to-amber-900 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 custom-tooltip hover-lift"
                                               data-tooltip="Input Nilai">
                                                <i class="fas fa-plus text-sm"></i>
                                            </a>
                                        @endif
                                        
                                        <!-- Edit Assessment Button -->
                                        <a href="{{ route('assessments.edit', $assessment->id) }}" 
                                           class="bg-gradient-to-br from-cyan-600 to-cyan-800 hover:from-cyan-700 hover:to-cyan-900 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 custom-tooltip hover-lift"
                                           data-tooltip="Edit Assessment">
                                            <i class="fas fa-cog text-sm"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <button onclick="confirmDelete({{ $assessment->id }}, 'Assessment #{{ $assessment->id }}')"
                                                class="bg-gradient-to-br from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 custom-tooltip hover-lift"
                                                data-tooltip="Hapus">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-800 to-gray-900 rounded-full flex items-center justify-center mb-6 border-2 border-dashed border-gray-700">
                                            <i class="fas fa-clipboard-list text-4xl text-gray-600"></i>
                                        </div>
                                        <h3 class="text-xl font-semibold text-white mb-2">Belum Ada Assessment</h3>
                                        <p class="text-gray-400 mb-6">Mulai dengan membuat assessment pertama Anda</p>
                                        <a href="{{ route('assessments.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-3 rounded-xl transition-all duration-300 flex items-center gap-2 hover-lift">
                                            <i class="fas fa-plus"></i>
                                            <span class="font-medium">Buat Assessment Pertama</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($assessments->hasPages())
                <div class="px-6 py-4 border-t border-gray-700 bg-gray-900/50">
                    <div class="flex justify-between items-center">
                        <div class="text-gray-400 text-sm">
                            Menampilkan {{ $assessments->firstItem() ?? 0 }} - {{ $assessments->lastItem() ?? 0 }} dari {{ $assessments->total() }} assessment
                        </div>
                        <div class="flex space-x-2">
                            {{ $assessments->links('vendor.pagination.custom-dark') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Information Card -->
        <div class="bg-gradient-to-br from-blue-900/20 via-blue-900/10 to-blue-900/20 rounded-xl border border-blue-700/30 p-5 fade-in">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-white text-lg"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-semibold text-lg mb-3">Informasi Assessment</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-white font-medium">Assessment</span>
                                <span class="text-gray-300">adalah proses penilaian untuk membandingkan beberapa supplier</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                                <span class="text-white font-medium">Draft</span>
                                <span class="text-gray-300">: Assessment dibuat, belum ada nilai</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm">
                                <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                                <span class="text-white font-medium">Input Nilai</span>
                                <span class="text-gray-300">: Sudah input nilai, siap diproses TOPSIS</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                                <span class="text-white font-medium">Selesai</span>
                                <span class="text-gray-300">: Hasil TOPSIS sudah tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
        <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-2xl border border-gray-700 w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" 
             id="deleteModalContent">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-800 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-white">Konfirmasi Hapus</h3>
                        <p class="text-gray-300 mt-1" id="deleteMessage">Anda yakin ingin menghapus item ini?</p>
                    </div>
                </div>
                
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    
                    <div class="flex justify-end space-x-3 mt-6 pt-5 border-t border-gray-700/50">
                        <button type="button" 
                                onclick="closeDeleteModal()" 
                                class="px-5 py-2.5 text-gray-300 hover:text-white transition rounded-xl border border-gray-600 hover:bg-gray-800/50 font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl transition font-medium flex items-center gap-2 hover-lift">
                            <i class="fas fa-trash"></i>
                            <span>Hapus</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Force dark mode
    document.documentElement.classList.add('dark');
    document.documentElement.style.colorScheme = 'dark';
    
    // Filter functionality
    const statusFilter = document.getElementById('statusFilter');
    const materialFilter = document.getElementById('materialFilter');
    const yearFilter = document.getElementById('yearFilter');
    const searchInput = document.getElementById('searchInput');
    const assessmentRows = document.querySelectorAll('.assessment-row');
    const calculateTopsisButtons = document.querySelectorAll('.calculate-topsis');

    // Handle TOPSIS calculation
    calculateTopsisButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const assessmentId = this.getAttribute('data-id');
            const url = this.getAttribute('data-url');
            
            // Show loading state
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i>';
            this.disabled = true;
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.style.display = 'none';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            document.body.appendChild(form);
            form.submit();
        });
    });

    function filterTable() {
        const statusValue = statusFilter.value;
        const materialValue = materialFilter.value;
        const yearValue = yearFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        assessmentRows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            const rowMaterial = row.getAttribute('data-material');
            const rowYear = row.getAttribute('data-year');
            const rowText = row.textContent.toLowerCase();

            const statusMatch = !statusValue || rowStatus === statusValue;
            const materialMatch = !materialValue || rowMaterial === materialValue;
            const yearMatch = !yearValue || rowYear === yearValue;
            const searchMatch = !searchValue || rowText.includes(searchValue);

            if (statusMatch && materialMatch && yearMatch && searchMatch) {
                row.style.display = '';
                row.classList.add('fade-in');
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Event listeners for filters
    [statusFilter, materialFilter, yearFilter].forEach(filter => {
        filter.addEventListener('change', filterTable);
    });
    
    searchInput.addEventListener('input', filterTable);

    // Initialize tooltips
    initCustomTooltips();
});

function initCustomTooltips() {
    // Custom tooltips are handled by CSS
    console.log('Custom tooltips initialized');
}

function confirmDelete(id, name) {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');
    const form = document.getElementById('deleteForm');
    const message = document.getElementById('deleteMessage');
    
    message.textContent = `Anda yakin ingin menghapus "${name}"? Tindakan ini tidak dapat dikembalikan.`;
    form.action = "{{ route('assessments.destroy', ':id') }}";
    
    // Show modal with animation
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.style.transform = 'scale(1)';
        modalContent.style.opacity = '1';
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');
    
    modalContent.style.transform = 'scale(0.95)';
    modalContent.style.opacity = '0';
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>