<x-layouts.app :title="__('Detail Assessment')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Assessment #{{ $assessment->id }}</h1>
                <p class="text-gray-400 mt-1">Detail penilaian dan informasi assessment</p>
            </div>
            <a href="{{ route('assessments.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @elseif(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">Your submission was successful.</span>
        </div>
        @endif

        <!-- Assessment Info Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Basic Information -->
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Informasi Assessment</h3>
                        <p class="text-gray-400">Detail assessment</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-sm">Material</label>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-8 h-8 bg-blue-600/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cube text-blue-400"></i>
                            </div>
                            <span class="text-white font-medium">{{ $assessment->material->nama_material }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-gray-400 text-sm">Tahun Penilaian</label>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-8 h-8 bg-yellow-600/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-yellow-400"></i>
                            </div>
                            <span class="text-white font-medium">{{ $assessment->tahun }}</span>
                        </div>
                    </div>
                    
                    @if($assessment->deskripsi)
                    <div>
                        <label class="text-gray-400 text-sm">Deskripsi</label>
                        <p class="text-gray-300 mt-1 p-3 bg-dark-400 rounded-lg">{{ $assessment->deskripsi }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="text-gray-400 text-sm">Tanggal Dibuat</label>
                        <div class="text-gray-300 mt-1">
                            {{ $assessment->created_at->translatedFormat('d F Y') }} 
                            <span class="text-gray-400">• {{ $assessment->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Statistik</h3>
                        <p class="text-gray-400">Ringkasan data</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-dark-400 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Jumlah Supplier</p>
                                <p class="text-white font-bold text-xl">{{ $scoresBySupplier->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark-400 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-blue-600/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-star text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Total Nilai</p>
                                <p class="text-white font-bold text-xl">{{ number_format($assessment->scores->sum('score'), 0) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark-400 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-purple-600/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-list-check text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Kriteria</p>
                                <p class="text-white font-bold text-xl">{{ $assessment->scores->groupBy('kriteria_id')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark-400 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-yellow-600/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calculator text-yellow-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Rata-rata</p>
                                <p class="text-white font-bold text-xl">
                                    {{ number_format($assessment->scores->avg('score') ?? 0, 1) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="mt-6">
                    @php
                        $status = $assessment->topsisResults->count() > 0 ? 'completed' : 
                                 ($assessment->scores->count() > 0 ? 'input' : 'draft');
                        $statusConfig = [
                            'draft' => ['color' => 'bg-gray-600', 'icon' => 'fa-edit', 'text' => 'Draft'],
                            'input' => ['color' => 'bg-yellow-600', 'icon' => 'fa-star', 'text' => 'Input Nilai'],
                            'completed' => ['color' => 'bg-green-600', 'icon' => 'fa-check-circle', 'text' => 'Selesai']
                        ];
                        $config = $statusConfig[$status];
                    @endphp
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg {{ $config['color'] }} text-white">
                        <i class="fas {{ $config['icon'] }}"></i>
                        <span class="font-medium">{{ $config['text'] }}</span>
                    </span>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Aksi Cepat</h3>
                        <p class="text-gray-400">Operasi assessment</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    @if($assessment->scores->count() == 0)
                        <!-- Input Nilai -->
                        <a href="{{ route('assessments.scores', $assessment->id) }}" 
                           class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg transition flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-star text-white"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Input Nilai</span>
                                    <p class="text-yellow-100 text-sm">Mulai penilaian supplier</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    @elseif($assessment->topsisResults->count() == 0)
                        <!-- Proses TOPSIS -->
                        <a href="{{ route('assessments.calculate', $assessment->id) }}" 
                           class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg transition flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calculator text-white"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Proses TOPSIS</span>
                                    <p class="text-purple-100 text-sm">Hitung rank supplier</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        
                    @else
                        <!-- Lihat Hasil TOPSIS -->
                        <a href="{{ route('results.show', $assessment->id) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-trophy text-white"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Lihat Hasil</span>
                                    <p class="text-green-100 text-sm">Lihat rank supplier</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    @endif
                    
                    <!-- Edit Assessment -->
                    <a href="{{ route('assessments.edit', $assessment->id) }}" 
                       class="w-full bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-3 rounded-lg transition flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cog text-white"></i>
                            </div>
                            <div>
                                <span class="font-medium">Edit Assessment</span>
                                <p class="text-cyan-100 text-sm">Ubah informasi dasar</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Supplier Scores Section -->
        <div class="bg-dark-300 rounded-xl border border-dark-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-dark-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-white">Nilai Supplier</h3>
                    <p class="text-gray-400 text-sm">Detail penilaian untuk setiap supplier</p>
                </div>
                <span class="text-gray-300">
                    {{ $scoresBySupplier->count() }} supplier
                </span>
            </div>
            
            <div class="p-6">
                @if($scoresBySupplier->count() > 0)
                    <div class="space-y-6">
                        @foreach($scoresBySupplier as $supplierId => $scores)
                            @php
                                $supplier = $scores->first()->supplier;
                                $totalScore = $scores->sum('score');
                                $averageScore = $scores->avg('score');
                            @endphp
                            
                            <div class="bg-dark-400 rounded-xl border border-dark-200 overflow-hidden">
                                <div class="px-6 py-4 border-b border-dark-200 bg-dark-500/50">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-truck text-white"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-white font-bold">{{ $supplier->nama_supplier }}</h4>
                                                @if($supplier->kode_supplier)
                                                    <p class="text-gray-400 text-sm">{{ $supplier->kode_supplier }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="text-right">
                                                <p class="text-gray-400 text-sm">Total Nilai</p>
                                                <p class="text-white font-bold">{{ number_format($totalScore, 1) }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-gray-400 text-sm">Rata-rata</p>
                                                <p class="text-white font-bold">{{ number_format($averageScore, 1) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                        @foreach($scores as $score)
                                            <div class="bg-dark-300 rounded-lg p-4 border border-dark-200 hover:border-blue-500/30 transition">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div>
                                                        <h5 class="text-white font-medium">{{ $score->kriteria->nama_kriteria }}</h5>
                                                        <div class="flex items-center gap-2 mt-1">
                                                            <span class="text-xs px-2 py-1 rounded {{ $score->kriteria->jenis == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                                                                {{ $score->kriteria->jenis == 'benefit' ? 'Benefit' : 'Cost' }}
                                                            </span>
                                                            <span class="text-xs px-2 py-1 bg-blue-600/20 text-blue-400 rounded">
                                                                Bobot: {{ $score->kriteria->bobot }}%
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <span class="text-gray-400 text-sm">Nilai</span>
                                                        <span class="text-white font-bold">{{ number_format($score->score, 1) }}/100</span>
                                                    </div>
                                                    <div class="w-full bg-dark-200 rounded-full h-2">
                                                        <div class="bg-blue-600 h-2 rounded-full" 
                                                             style="width: {{ $score->score }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-star text-gray-400 text-2xl"></i>
                        </div>
                        <h4 class="text-white font-medium text-lg mb-2">Belum Ada Nilai</h4>
                        <p class="text-gray-400 mb-6">Assessment ini belum memiliki nilai untuk supplier.</p>
                        <a href="{{ route('assessments.scores', $assessment->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition inline-flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Input Nilai Supplier</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- TOPSIS Results Section (if any) -->
        @if($assessment->topsisResults->count() > 0)
            <div class="bg-dark-300 rounded-xl border border-dark-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-dark-200 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-white">Hasil TOPSIS</h3>
                        <p class="text-gray-400 text-sm">Ranking supplier berdasarkan perhitungan TOPSIS</p>
                    </div>
                    <a href="{{ route('results.show', $assessment->id) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Lihat Detail</span>
                    </a>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($assessment->topsisResults->take(3) as $result)
                            <div class="bg-dark-400 rounded-xl p-4 border border-dark-200 hover:border-green-500/30 transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 {{ $result->rank == 1 ? 'bg-yellow-600' : 'bg-gray-600' }} rounded-lg flex items-center justify-center">
                                            <span class="text-white font-bold">#{{ $result->rank }}</span>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-bold">{{ $result->supplier->nama_supplier }}</h4>
                                            <p class="text-gray-400 text-sm">Ranking {{ $result->rank }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-400">Nilai Preferensi</span>
                                            <span class="text-white font-medium">{{ number_format($result->preference_score, 4) }}</span>
                                        </div>
                                        <div class="w-full bg-dark-200 rounded-full h-2 mt-1">
                                            <div class="bg-green-600 h-2 rounded-full" 
                                                 style="width: {{ $result->preference_score * 100 }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="pt-2 border-t border-dark-200">
                                        <p class="text-gray-400 text-sm">Persentase</p>
                                        <p class="text-white font-bold text-xl">{{ number_format($result->preference_score * 100, 2) }}%</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>

<style>
.transition {
    transition: all 0.2s ease-in-out;
}

.bg-dark-300 { background-color: #1f2937; }
.bg-dark-400 { background-color: #374151; }
.bg-dark-500 { background-color: #4b5563; }
.border-dark-200 { border-color: #374151; }

.hover\:border-blue-500\/30:hover { border-color: rgba(59, 130, 246, 0.3); }
.hover\:border-green-500\/30:hover { border-color: rgba(34, 197, 94, 0.3); }
</style>