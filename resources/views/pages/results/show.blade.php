<x-layouts.app :title="__('Hasil TOPSIS')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Hasil TOPSIS - Assessment #{{ $assessment->id }}</h1>
                <p class="text-gray-400 mt-1">Ranking supplier berdasarkan perhitungan TOPSIS</p>
            </div>
            <div class="flex gap-3">
                <button onclick="showCalculationSteps()" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-calculator"></i>
                    <span>Lihat Kalkulasi TOPSIS</span>
                </button>
                <a href="{{ route('assessments.show', $assessment->id) }}" 
                   class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Assessment</span>
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('error'))
            <div class="bg-red-600/20 border border-red-600 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                    <div>
                        <h4 class="font-medium text-white">Error!</h4>
                        <p class="text-red-300 text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @elseif(session('success'))
            <div class="bg-green-600/20 border border-green-600 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-400 text-lg"></i>
                    <div>
                        <h4 class="font-medium text-white">Success!</h4>
                        <p class="text-green-300 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Assessment Info Card -->
        <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Informasi Assessment</h3>
                        <p class="text-gray-400">{{ $assessment->material->nama_material }} - {{ $assessment->tahun }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('assessments.edit', $assessment->id) }}" 
                       class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        <span>Edit Assessment</span>
                    </a>
                    <a href="{{ route('results.export', $assessment->id) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-file-export"></i>
                        <span>Export Hasil</span>
                    </a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-dark-400 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-600/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Jumlah Supplier</p>
                            <p class="text-white font-bold text-xl">{{ $results->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-dark-400 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list-check text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Jumlah Kriteria</p>
                            <p class="text-white font-bold text-xl">{{ $assessment->scores->groupBy('kriteria_id')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-dark-400 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-600/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-yellow-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Tahun</p>
                            <p class="text-white font-bold text-xl">{{ $assessment->tahun }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-dark-400 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-600/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calculator text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Status</p>
                            <p class="text-white font-bold text-xl">TOPSIS Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking Results -->
        <div class="bg-dark-300 rounded-xl border border-dark-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-dark-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-white">Hasil Ranking Supplier</h3>
                    <p class="text-gray-400 text-sm">Urutan supplier berdasarkan nilai preferensi TOPSIS</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-300 text-sm">
                        {{ $results->count() }} supplier
                    </span>
                    <button onclick="showCalculationSteps()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2 ml-2">
                        <i class="fas fa-calculator"></i>
                        <span class="hidden md:inline">Detail Perhitungan</span>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                @if($results->count() > 0)
                    <!-- Top 3 Winners -->
                    @if($results->count() >= 3)
                    <div class="mb-8">
                        <h4 class="text-white font-bold mb-4">Top 3 Supplier Terbaik</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($results->take(3) as $result)
                            <div class="relative bg-gradient-to-br from-dark-400 to-dark-500 rounded-xl p-6 border border-{{ $loop->iteration == 1 ? 'yellow-600' : ($loop->iteration == 2 ? 'gray-600' : 'orange-600' )}} hover:border-{{ $loop->iteration == 1 ? 'yellow-500' : ($loop->iteration == 2 ? 'gray-500' : 'orange-500' )}} transition">
                                <div class="absolute -top-3 -left-3 w-12 h-12 {{ $loop->iteration == 1 ? 'bg-yellow-600' : ($loop->iteration == 2 ? 'bg-gray-600' : 'bg-orange-600' )}} rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    #{{ $result->rank }}
                                </div>
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-14 h-14 bg-green-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-trophy text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-white font-bold text-lg">{{ $result->supplier->nama_supplier }}</h5>
                                        <p class="text-gray-400">Supplier #{{ $result->supplier->kode_supplier ?? $result->supplier_id }}</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-3">
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-gray-400 text-sm">Nilai Preferensi</span>
                                            <span class="text-white font-bold">{{ number_format($result->preference_score, 4) }}</span>
                                        </div>
                                        <div class="w-full bg-dark-600 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full" 
                                                 style="width: {{ $result->preference_score * 100 }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="text-center p-2 bg-dark-600 rounded-lg">
                                            <p class="text-gray-400 text-xs">Jarak Positif</p>
                                            <p class="text-white font-medium">{{ number_format($steps['distances'][$result->supplier_id]['positive'], 4) }}</p>
                                        </div>
                                        <div class="text-center p-2 bg-dark-600 rounded-lg">
                                            <p class="text-gray-400 text-xs">Jarak Negatif</p>
                                            <p class="text-white font-medium">{{ number_format($steps['distances'][$result->supplier_id]['negative'], 4) }}</p>
                                        </div>
                                    </div>
                                    
                                    <button onclick="showSupplierCalculation({{ $result->supplier_id }})" 
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition flex items-center justify-center gap-2 mt-3">
                                        <i class="fas fa-calculator"></i>
                                        <span>Lihat Detail Perhitungan</span>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- All Results Table -->
                    <div class="bg-dark-400 rounded-xl p-4">
                        <h4 class="text-white font-bold mb-4">Semua Hasil Ranking</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-dark-200">
                                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Rank</th>
                                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Supplier</th>
                                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Nilai Preferensi</th>
                                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Jarak Positif</th>
                                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Jarak Negatif</th>
                                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Status</th>
                                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                    <tr class="border-b border-dark-200 hover:bg-dark-500 transition">
                                        <td class="py-3 px-4">
                                            <div class="flex items-center">
                                                <span class="w-8 h-8 {{ $result->rank <= 3 ? 'bg-yellow-600' : 'bg-gray-600' }} rounded-full flex items-center justify-center text-white font-bold">
                                                    {{ $result->rank }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-green-600/20 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-truck text-green-400"></i>
                                                </div>
                                                <div>
                                                    <p class="text-white font-medium">{{ $result->supplier->nama_supplier }}</p>
                                                    @if($result->supplier->kode_supplier)
                                                        <p class="text-gray-400 text-sm">{{ $result->supplier->kode_supplier }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div>
                                                <p class="text-white font-bold">{{ number_format($result->preference_score, 4) }}</p>
                                                <div class="w-32 bg-dark-600 rounded-full h-2 mt-1">
                                                    <div class="bg-green-600 h-2 rounded-full" 
                                                         style="width: {{ $result->preference_score * 100 }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <p class="text-white">{{ number_format($steps['distances'][$result->supplier_id]['positive'], 4) }}</p>
                                        </td>
                                        <td class="py-3 px-4">
                                            <p class="text-white">{{ number_format($steps['distances'][$result->supplier_id]['negative'], 4) }}</p>
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $statusClass = $result->rank == 1 ? 'bg-green-600' : 
                                                             ($result->rank <= 3 ? 'bg-yellow-600' : 'bg-blue-600');
                                                $statusText = $result->rank == 1 ? 'Rekomendasi' : 
                                                            ($result->rank <= 3 ? 'Alternatif' : 'Standar');
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }} text-white">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex gap-2">
                                                <button onclick="showSupplierCalculation({{ $result->supplier_id }})" 
                                                        class="text-blue-400 hover:text-blue-300 transition px-3 py-1 bg-blue-600/20 rounded-lg text-sm">
                                                    <i class="fas fa-calculator mr-1"></i> Detail
                                                </button>
                                                <a href="{{ route('results.supplier-calculation', ['assessment' => $assessment->id, 'supplier' => $result->supplier_id]) }}" 
                                                   class="text-green-400 hover:text-green-300 transition px-3 py-1 bg-green-600/20 rounded-lg text-sm">
                                                    <i class="fas fa-chart-line mr-1"></i> Nilai
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chart-line text-gray-400 text-2xl"></i>
                        </div>
                        <h4 class="text-white font-medium text-lg mb-2">Belum Ada Hasil TOPSIS</h4>
                        <p class="text-gray-400 mb-6">Assessment ini belum diproses dengan metode TOPSIS.</p>
                        <a href="{{ route('assessments.calculate', $assessment->id) }}" 
                           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg transition inline-flex items-center gap-2">
                            <i class="fas fa-calculator"></i>
                            <span>Proses TOPSIS</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kriteria dan Bobot -->
        @if(isset($steps['criteria']) && count($steps['criteria']) > 0)
        <div class="bg-dark-300 rounded-xl border border-dark-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-dark-200">
                <h3 class="text-lg font-bold text-white">Kriteria dan Bobot</h3>
                <p class="text-gray-400 text-sm">Parameter yang digunakan dalam perhitungan TOPSIS</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($steps['criteria'] as $kriteria)
                    <div class="bg-dark-400 rounded-lg p-4 border border-dark-200 hover:border-blue-500/30 transition">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h5 class="text-white font-medium">{{ $kriteria->nama_kriteria }}</h5>
                                @if($kriteria->kode_kriteria)
                                    <p class="text-gray-400 text-sm">{{ $kriteria->kode_kriteria }}</p>
                                @endif
                            </div>
                            <span class="text-xs px-2 py-1 rounded {{ $kriteria->type == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                                {{ $kriteria->type }}
                            </span>
                        </div>
                        
                        <div class="space-y-2">
                            <div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Bobot</span>
                                    <span class="text-white font-medium">{{ $kriteria->bobot }}%</span>
                                </div>
                                <div class="w-full bg-dark-200 rounded-full h-2 mt-1">
                                    <div class="bg-blue-600 h-2 rounded-full" 
                                         style="width: {{ $kriteria->bobot }}%"></div>
                                </div>
                            </div>
                            
                            @if($kriteria->satuan)
                            <div class="pt-2 border-t border-dark-200">
                                <p class="text-gray-400 text-sm">Satuan</p>
                                <p class="text-white font-medium">{{ $kriteria->satuan }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 bg-dark-400 rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-dark-500 rounded-lg">
                            <p class="text-green-400 font-bold text-lg">
                                {{ $steps['criteria']->where('type', 'benefit')->count() }}
                            </p>
                            <p class="text-gray-400 text-sm mt-1">Kriteria Benefit</p>
                        </div>
                        <div class="text-center p-3 bg-dark-500 rounded-lg">
                            <p class="text-red-400 font-bold text-lg">
                                {{ $steps['criteria']->where('type', 'cost')->count() }}
                            </p>
                            <p class="text-gray-400 text-sm mt-1">Kriteria Cost</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Modal untuk Detail Perhitungan TOPSIS -->
    <div id="calculationModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-dark-300 rounded-xl border border-dark-200 w-full max-w-6xl max-h-[90vh] overflow-hidden">
            <div class="px-6 py-4 border-b border-dark-200 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-white">Detail Perhitungan TOPSIS</h3>
                    <p class="text-gray-400 text-sm">Langkah-langkah perhitungan metode TOPSIS</p>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                <div id="calculationContent">
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-spinner fa-spin text-blue-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">Memuat data perhitungan...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Perhitungan Supplier Spesifik -->
    <div id="supplierModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-dark-300 rounded-xl border border-dark-200 w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <div class="px-6 py-4 border-b border-dark-200 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-white" id="supplierModalTitle">Perhitungan Supplier</h3>
                    <p class="text-gray-400 text-sm">Detail perhitungan untuk supplier spesifik</p>
                </div>
                <button onclick="closeSupplierModal()" class="text-gray-400 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                <div id="supplierCalculationContent">
                    <!-- Konten akan dimuat via AJAX -->
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    // Data untuk perhitungan
    let calculationData = null;
    let isLoading = false;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');


    // Fungsi untuk menampilkan modal perhitungan
    function showCalculationSteps() {
        const modal = document.getElementById('calculationModal');
        modal.classList.remove('hidden');
        loadCalculationData();
    }

    // Fungsi untuk menampilkan perhitungan supplier spesifik
    function showSupplierCalculation(supplierId) {
        const modal = document.getElementById('supplierModal');
        document.getElementById('supplierModalTitle').textContent = 'Perhitungan Supplier #' + supplierId;
        modal.classList.remove('hidden');
        loadSupplierCalculation(supplierId);
    }

    function closeModal() {
        document.getElementById('calculationModal').classList.add('hidden');
    }

    function closeSupplierModal() {
        document.getElementById('supplierModal').classList.add('hidden');
    }

    // Load data perhitungan via AJAX
    async function loadCalculationData() {
    if (isLoading) return;
    
    const content = document.getElementById('calculationContent');
        content.innerHTML = `
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-spinner fa-spin text-blue-400 text-2xl"></i>
                </div>
                <p class="text-gray-400">Memuat data perhitungan...</p>
            </div>
        `;
        
        isLoading = true;
        
        try {
            // Untuk mengambil semua steps, kita perlu endpoint khusus
            // Atau kita bisa render dari data yang sudah ada di PHP
            @if(isset($steps) && !empty($steps))
                calculationData = { steps: @json($steps) };
                renderCalculationSteps(calculationData);
            @else
                // Buat endpoint khusus untuk mengambil steps jika tidak ada di PHP
                const url = '{{ route("results.supplier-calculation", ["id" => $assessment->id, "supplier" => "all"]) }}';
                console.log('Fetching calculation steps from:', url);
                
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    throw new Error("Response bukan JSON");
                }
                
                const data = await response.json();
                calculationData = data;
                renderCalculationSteps(data);
            @endif
        } catch (error) {
            console.error('Error loading calculation data:', error);
            content.innerHTML = `
                <div class="bg-red-600/20 border border-red-600 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                        <div>
                            <p class="text-red-300">Gagal memuat data perhitungan.</p>
                            <p class="text-red-300 text-sm mt-1">${error.message}</p>
                            <p class="text-gray-400 text-xs mt-2">Data akan ditampilkan dari cache jika tersedia.</p>
                        </div>
                    </div>
                </div>
            `;
        } finally {
            isLoading = false;
        }
    }

    // Load perhitungan supplier spesifik
    async function loadSupplierCalculation(supplierId) {
        const content = document.getElementById('supplierCalculationContent');
        content.innerHTML = `
            <div class="text-center py-8">
                <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-spinner fa-spin text-blue-400 text-xl"></i>
                </div>
                <p class="text-gray-400">Memuat perhitungan supplier...</p>
            </div>
        `;
        
        try {
            // Perbaiki route - gunakan parameter yang benar
            const url = '{{ route("results.supplier-calculation", ["id" => $assessment->id, "supplier" => "__SUPPLIER_ID__"]) }}'.replace('__SUPPLIER_ID__', supplierId);
            
            console.log('Fetching URL:', url); // Untuk debugging
            
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken || '' 
                },
                credentials: 'same-origin' // Kirim cookies/session
            });
            
            // Cek status response
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            // Cek content type
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Response bukan JSON");
            }
            
            const data = await response.json();
            renderSupplierCalculation(data, supplierId);
        } catch (error) {
            console.error('Error loading supplier calculation:', error);
            content.innerHTML = `
                <div class="bg-red-600/20 border border-red-600 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                        <div>
                            <p class="text-red-300">Gagal memuat perhitungan supplier.</p>
                            <p class="text-red-300 text-sm mt-1">${error.message}</p>
                            <p class="text-gray-400 text-xs mt-2">Pastikan Anda sudah login dan memiliki akses.</p>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // Render langkah-langkah perhitungan
    function renderCalculationSteps(data) {
        const content = document.getElementById('calculationContent');
        
        if (!data || !data.steps) {
            content.innerHTML = '<p class="text-gray-400">Data perhitungan tidak tersedia</p>';
            return;
        }
        
        const steps = data.steps;
        
        // Pastikan semua data ada
        if (!steps.criteria || !steps.suppliers || !steps.decision_matrix) {
            content.innerHTML = '<p class="text-gray-400">Data perhitungan tidak lengkap</p>';
            return;
        }
        
        let html = `
            <div class="space-y-6">
                <!-- Step 1: Kriteria -->
                <div class="bg-dark-400 rounded-xl p-4">
                    <h4 class="text-white font-bold mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">1</span>
                        Kriteria Penilaian
                    </h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-dark-200">
                                    <th class="text-left py-2 text-gray-400">Kriteria</th>
                                    <th class="text-left py-2 text-gray-400">Jenis</th>
                                    <th class="text-left py-2 text-gray-400">Bobot</th>
                                </tr>
                            </thead>
                            <tbody>
        `;
        
        steps.criteria.forEach(criteria => {
            html += `
                <tr class="border-b border-dark-200">
                    <td class="py-2 text-white">${criteria.nama_kriteria}</td>
                    <td class="py-2">
                        <span class="px-2 py-1 rounded ${criteria.type == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400'}">
                            ${criteria.type}
                        </span>
                    </td>
                    <td class="py-2 text-white">${criteria.bobot}%</td>
                </tr>
            `;
        });
        
        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
        `;
        
        // Hanya render step-step berikutnya jika data tersedia
        if (steps.decision_matrix && steps.decision_matrix.length > 0) {
            html += `
                <!-- Step 2: Matriks Keputusan -->
                <div class="bg-dark-400 rounded-xl p-4">
                    <h4 class="text-white font-bold mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">2</span>
                        Matriks Keputusan
                    </h4>
                    <p class="text-gray-400 text-sm mb-3">Nilai awal dari setiap supplier untuk setiap kriteria</p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-dark-200">
                                    <th class="text-left py-2 text-gray-400">Supplier</th>
            `;
            
            steps.criteria.forEach(criteria => {
                html += `<th class="text-left py-2 text-gray-400">${criteria.nama_kriteria}</th>`;
            });
            
            html += `
                                </tr>
                            </thead>
                            <tbody>
            `;
            
            steps.decision_matrix.forEach((row, idx) => {
                html += `<tr class="border-b border-dark-200">`;
                html += `<td class="py-2 text-white">${steps.suppliers[idx]?.nama_supplier || 'Supplier ' + (idx + 1)}</td>`;
                row.forEach(cell => {
                    html += `<td class="py-2 text-white text-center">${cell}</td>`;
                });
                html += `</tr>`;
            });
            
            html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }
        
        // Render hasil akhir jika tersedia
        if (steps.preferences && steps.rankings) {
            html += `
                <!-- Step 6 & 7: Jarak dan Preferensi -->
                <div class="bg-dark-400 rounded-xl p-4">
                    <h4 class="text-white font-bold mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">2</span>
                        Hasil Perhitungan Jarak dan Nilai Preferensi
                    </h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-dark-200">
                                    <th class="text-left py-2 text-gray-400">Rank</th>
                                    <th class="text-left py-2 text-gray-400">Supplier</th>
                                    <th class="text-left py-2 text-gray-400">D+ (Positif)</th>
                                    <th class="text-left py-2 text-gray-400">D- (Negatif)</th>
                                    <th class="text-left py-2 text-gray-400">Preferensi</th>
                                    <th class="text-left py-2 text-gray-400">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
            `;
            
            // Gabungkan data distances, preferences, dan rankings
            const supplierArray = Object.values(steps.suppliers);
            const suppliersWithData = supplierArray.map((supplier, idx) => {
                // console.log("Current Index (idx):", steps); 

                return ({
                    supplier,
                    positive_distance: steps.distances?.[supplier.id]?.positive || 0,
                    negative_distance: steps.distances?.[supplier.id]?.negative || 0,
                    preference: steps.preferences?.[supplier.id] || 0,
                    rank: steps.rankings?.[supplier.id] || (supplier.id + 1)
                });
            }).sort((a, b) => a.rank - b.rank);
            // console.log(suppliersWithData);
            suppliersWithData.forEach(item => {
                html += `
                    <tr class="border-b border-dark-200">
                        <td class="py-2">
                            <span class="w-6 h-6 ${item.rank <= 3 ? 'bg-yellow-600' : 'bg-gray-600'} rounded-full flex items-center justify-center text-white text-xs">
                                ${item.rank}
                            </span>
                        </td>
                        <td class="py-2 text-white">${item.supplier?.nama_supplier || 'Supplier ' + item.rank}</td>
                        <td class="py-2 text-white text-center">${item.positive_distance.toFixed(4)}</td>
                        <td class="py-2 text-white text-center">${item.negative_distance.toFixed(4)}</td>
                        <td class="py-2 text-white text-center font-medium">${item.preference.toFixed(4)}</td>
                        <td class="py-2 text-center">
                            <button onclick="showSupplierCalculation(${item.supplier?.id || item.rank})" 
                                    class="text-blue-400 hover:text-blue-300 transition px-3 py-1 bg-blue-600/20 rounded-lg text-xs">
                                <i class="fas fa-calculator mr-1"></i> Detail
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }
        
        html += `</div>`;
        content.innerHTML = html;
    }

    // Render perhitungan supplier spesifik
    function renderSupplierCalculation(data, supplierId) {
        const content = document.getElementById('supplierCalculationContent');
        
        if (!data || !data.supplier) {
            content.innerHTML = '<p class="text-gray-400">Data perhitungan tidak tersedia</p>';
            return;
        }
        
        const supplier = data.supplier;
        const steps = data.steps;
        
        let html = `
            <div class="space-y-6">
                <!-- Header Supplier -->
                <div class="bg-dark-400 rounded-xl p-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-truck text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg">${supplier.nama_supplier}</h4>
                            <p class="text-gray-400">Ranking: <span class="text-yellow-400 font-bold">#${data.ranking}</span></p>
                        </div>
                    </div>
                </div>
        `;
        
        // Cek apakah ada data steps yang lengkap
        if (steps && steps.criteria && steps.decision_matrix) {
            // Step 1: Nilai Awal (Decision Matrix)
            html += `
                <!-- Step 1: Nilai Awal -->
                <div class="bg-dark-400 rounded-xl p-4">
                    <h5 class="text-white font-bold mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">1</span>
                        Nilai Awal (Decision Matrix)
                    </h5>
                    <p class="text-gray-400 text-sm mb-3">Nilai asli dari supplier untuk setiap kriteria</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            `;
            
            steps.decision_matrix.forEach((value, idx) => {
                const kriteria = steps.criteria[idx];
                if (!kriteria) return;
                
                html += `
                    <div class="bg-dark-500 rounded-lg p-3">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h6 class="text-white font-medium">${kriteria.nama_kriteria}</h6>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs px-2 py-1 rounded ${kriteria.type == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400'}">
                                        ${kriteria.type}
                                    </span>
                                    <span class="text-xs text-gray-400">Bobot: ${kriteria.bobot}%</span>
                                </div>
                            </div>
                            <span class="text-white font-bold">${value}</span>
                        </div>
                        <div class="text-xs text-gray-400 mt-2">
                            <div class="flex justify-between">
                                <span>Nilai Asli (X<sub>${idx+1}</sub>):</span>
                                <span class="font-mono">${value}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += `
                    </div>
                </div>
            `;
            
            // Step 2: Normalisasi
            html += `
                <!-- Step 2: Normalisasi -->
                <div class="bg-dark-400 rounded-xl p-4">
                    <h5 class="text-white font-bold mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">2</span>
                        Normalisasi Matriks
                    </h5>
                    <p class="text-gray-400 text-sm mb-3">Rumus normalisasi: r<sub>ij</sub> = x<sub>ij</sub> / √(Σx<sub>ij</sub>²)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            `;
            
            steps.decision_matrix.forEach((value, idx) => {
                const kriteria = steps.criteria[idx];
                const normalized = steps.normalized_matrix?.[idx] || 0;
                
                if (!kriteria) return;
                
                html += `
                    <div class="bg-dark-500 rounded-lg p-3">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h6 class="text-white font-medium">${kriteria.nama_kriteria}</h6>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs px-2 py-1 rounded ${kriteria.type == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400'}">
                                        ${kriteria.type}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs text-gray-400">
                            <div class="flex justify-between">
                                <span>Nilai Asli (x):</span>
                                <span class="font-mono">${value}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Hasil Normalisasi (r):</span>
                                <span class="font-mono text-white">${normalized.toFixed(4)}</span>
                            </div>
                            <div class="text-gray-500 text-xs mt-1">
                                r = ${value} / √(Σx² untuk kriteria ini)
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += `
                    </div>
                </div>
            `;
            
            // Step 3: Pembobotan
            html += `
                <!-- Step 3: Pembobotan -->
                <div class="bg-dark-400 rounded-xl p-4">
                    <h5 class="text-white font-bold mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">3</span>
                        Matriks Terbobot
                    </h5>
                    <p class="text-gray-400 text-sm mb-3">Rumus: v<sub>ij</sub> = w<sub>j</sub> × r<sub>ij</sub></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            `;
            
            steps.decision_matrix.forEach((_, idx) => {
                const kriteria = steps.criteria[idx];
                const normalized = steps.normalized_matrix?.[idx] || 0;
                const weighted = steps.weighted_matrix?.[idx] || 0;
                const bobot = kriteria?.bobot || 0;
                const bobotDesimal = bobot / 100;
                
                if (!kriteria) return;
                
                html += `
                    <div class="bg-dark-500 rounded-lg p-3">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h6 class="text-white font-medium">${kriteria.nama_kriteria}</h6>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-400">Bobot (w): ${bobot}% = ${bobotDesimal.toFixed(4)}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs text-gray-400">
                            <div class="flex justify-between">
                                <span>Nilai Normalisasi (r):</span>
                                <span class="font-mono">${normalized.toFixed(4)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Hasil Pembobotan (v):</span>
                                <span class="font-mono text-white">${weighted.toFixed(4)}</span>
                            </div>
                            <div class="text-gray-500 text-xs mt-1">
                                v = ${bobotDesimal.toFixed(4)} × ${normalized.toFixed(4)} = ${weighted.toFixed(4)}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += `
                    </div>
                </div>
            `;
            
            // Step 4: Solusi Ideal
            if (steps.ideal_solutions) {
                html += `
                    <!-- Step 4: Solusi Ideal -->
                    <div class="bg-dark-400 rounded-xl p-4">
                        <h5 class="text-white font-bold mb-3 flex items-center gap-2">
                            <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">4</span>
                            Solusi Ideal Positif (A+) dan Negatif (A-)
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Solusi Ideal Positif -->
                            <div>
                                <h6 class="text-green-400 font-medium mb-2">Solusi Ideal Positif (A+)</h6>
                                <p class="text-gray-400 text-sm mb-3">Nilai terbobot terbaik untuk setiap kriteria</p>
                                <div class="bg-dark-500 rounded-lg p-3 space-y-2">
                `;
                
                steps.ideal_solutions.positive.forEach((value, idx) => {
                    const kriteria = steps.criteria[idx];
                    if (!kriteria) return;
                    
                    html += `
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-300">${kriteria.nama_kriteria}:</span>
                            <code class="text-green-300 font-mono">${value.toFixed(4)}</code>
                        </div>
                    `;
                });
                
                html += `
                                </div>
                            </div>
                            
                            <!-- Solusi Ideal Negatif -->
                            <div>
                                <h6 class="text-red-400 font-medium mb-2">Solusi Ideal Negatif (A-)</h6>
                                <p class="text-gray-400 text-sm mb-3">Nilai terbobot terburuk untuk setiap kriteria</p>
                                <div class="bg-dark-500 rounded-lg p-3 space-y-2">
                `;
                
                steps.ideal_solutions.negative.forEach((value, idx) => {
                    const kriteria = steps.criteria[idx];
                    if (!kriteria) return;
                    
                    html += `
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-300">${kriteria.nama_kriteria}:</span>
                            <code class="text-red-300 font-mono">${value.toFixed(4)}</code>
                        </div>
                    `;
                });
                
                html += `
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-400">
                            <p>Kriteria Benefit: A+ = nilai maksimum, A- = nilai minimum</p>
                            <p>Kriteria Cost: A+ = nilai minimum, A- = nilai maksimum</p>
                        </div>
                    </div>
                `;
            }
            
            // Step 5: Perhitungan Jarak
            if (steps.distance_calculations) {
                html += `
                    <!-- Step 5: Perhitungan Jarak Euclidean -->
                    <div class="bg-dark-400 rounded-xl p-4">
                        <h5 class="text-white font-bold mb-3 flex items-center gap-2">
                            <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">5</span>
                            Perhitungan Jarak Euclidean
                        </h5>
                        <p class="text-gray-400 text-sm mb-3">Rumus: D = √[Σ(v<sub>ij</sub> - A<sup>±</sup>)²]</p>
                        
                        <!-- Jarak ke Solusi Ideal Positif -->
                        <div class="mb-6">
                            <h6 class="text-green-400 font-medium mb-3">Jarak ke Solusi Ideal Positif (D+)</h6>
                            <div class="bg-dark-500 rounded-lg p-4">
                                <div class="text-center mb-4">
                                    <div class="text-2xl font-bold text-white mb-2">D+ = ${steps.positive_distance.toFixed(4)}</div>
                                    <p class="text-gray-400 text-sm">D+ = √[Σ(v<sub>ij</sub> - A+)²]</p>
                                </div>
                                
                                <div class="space-y-2">
                `;
                
                steps.distance_calculations.positive.forEach((calc, idx) => {
                    const kriteria = steps.criteria[idx];
                    const weighted = steps.weighted_matrix?.[idx] || 0;
                    const idealPos = steps.ideal_solutions?.positive?.[idx] || 0;
                    
                    if (!kriteria) return;
                    
                    const selisih = (weighted - idealPos).toFixed(4);
                    const kuadrat = calc.toFixed(4);
                    
                    html += `
                        <div class="flex items-center justify-between text-sm">
                            <div class="text-gray-300 flex-1">${kriteria.nama_kriteria}:</div>
                            <div class="text-right">
                                <code class="text-blue-300 text-xs">
                                    (${weighted.toFixed(4)} - ${idealPos.toFixed(4)})² = ${kuadrat}
                                </code>
                                <div class="text-gray-500 text-xs mt-1">Selisih: ${selisih}</div>
                            </div>
                        </div>
                    `;
                });
                
                const sumPositive = steps.distance_calculations.positive.reduce((sum, val) => sum + val, 0);
                const sqrtPositive = Math.sqrt(sumPositive);
                
                html += `
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-dark-200">
                                    <div class="text-center">
                                        <p class="text-gray-400 text-sm mb-1">Total Σ(v - A+)² = ${sumPositive.toFixed(4)}</p>
                                        <p class="text-gray-400 text-sm">√(${sumPositive.toFixed(4)}) = ${sqrtPositive.toFixed(4)}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Jarak ke Solusi Ideal Negatif -->
                        <div>
                            <h6 class="text-red-400 font-medium mb-3">Jarak ke Solusi Ideal Negatif (D-)</h6>
                            <div class="bg-dark-500 rounded-lg p-4">
                                <div class="text-center mb-4">
                                    <div class="text-2xl font-bold text-white mb-2">D- = ${steps.negative_distance.toFixed(4)}</div>
                                    <p class="text-gray-400 text-sm">D- = √[Σ(v<sub>ij</sub> - A-)²]</p>
                                </div>
                                
                                <div class="space-y-2">
                `;
                
                steps.distance_calculations.negative.forEach((calc, idx) => {
                    const kriteria = steps.criteria[idx];
                    const weighted = steps.weighted_matrix?.[idx] || 0;
                    const idealNeg = steps.ideal_solutions?.negative?.[idx] || 0;
                    
                    if (!kriteria) return;
                    
                    const selisih = (weighted - idealNeg).toFixed(4);
                    const kuadrat = calc.toFixed(4);
                    
                    html += `
                        <div class="flex items-center justify-between text-sm">
                            <div class="text-gray-300 flex-1">${kriteria.nama_kriteria}:</div>
                            <div class="text-right">
                                <code class="text-blue-300 text-xs">
                                    (${weighted.toFixed(4)} - ${idealNeg.toFixed(4)})² = ${kuadrat}
                                </code>
                                <div class="text-gray-500 text-xs mt-1">Selisih: ${selisih}</div>
                            </div>
                        </div>
                    `;
                });
                
                const sumNegative = steps.distance_calculations.negative.reduce((sum, val) => sum + val, 0);
                const sqrtNegative = Math.sqrt(sumNegative);
                
                html += `
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-dark-200">
                                    <div class="text-center">
                                        <p class="text-gray-400 text-sm mb-1">Total Σ(v - A-)² = ${sumNegative.toFixed(4)}</p>
                                        <p class="text-gray-400 text-sm">√(${sumNegative.toFixed(4)}) = ${sqrtNegative.toFixed(4)}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            // Step 6: Nilai Preferensi
            if (steps.positive_distance !== undefined && steps.negative_distance !== undefined) {
                const dPlus = steps.positive_distance;
                const dMinus = steps.negative_distance;
                const total = dPlus + dMinus;
                const preference = steps.preference_score;
                
                html += `
                    <!-- Step 6: Nilai Preferensi -->
                    <div class="bg-dark-400 rounded-xl p-4">
                        <h5 class="text-white font-bold mb-3 flex items-center gap-2">
                            <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm">6</span>
                            Nilai Preferensi (Ci)
                        </h5>
                        <div class="bg-gradient-to-br from-dark-500 to-dark-600 rounded-xl p-6">
                            <div class="text-center mb-6">
                                <div class="text-4xl font-bold text-yellow-400 mb-2">Ci = ${preference.toFixed(4)}</div>
                                <p class="text-gray-300">Nilai Preferensi Akhir</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div class="text-center p-4 bg-dark-700 rounded-lg">
                                    <div class="text-green-400 font-bold text-2xl">D- = ${dMinus.toFixed(4)}</div>
                                    <p class="text-gray-400 text-sm mt-1">Jarak ke Solusi Ideal Negatif</p>
                                </div>
                                
                                <div class="text-center p-4 bg-dark-700 rounded-lg flex flex-col items-center justify-center">
                                    <div class="text-2xl font-bold text-white">÷</div>
                                    <p class="text-gray-400 text-sm mt-1">Dibagi</p>
                                </div>
                                
                                <div class="text-center p-4 bg-dark-700 rounded-lg">
                                    <div class="text-white font-bold text-2xl">${total.toFixed(4)}</div>
                                    <p class="text-gray-400 text-sm mt-1">(D+ + D-) = (${dPlus.toFixed(4)} + ${dMinus.toFixed(4)})</p>
                                </div>
                            </div>
                            
                            <div class="bg-dark-800 rounded-lg p-4">
                                <div class="text-center">
                                    <p class="text-gray-300 font-medium mb-2">Rumus Lengkap:</p>
                                    <code class="text-blue-300 text-lg font-mono">
                                        Ci = D- / (D+ + D-)
                                    </code>
                                    <div class="mt-3 text-gray-400 text-sm">
                                        <p>Ci = ${dMinus.toFixed(4)} / (${dPlus.toFixed(4)} + ${dMinus.toFixed(4)})</p>
                                        <p>Ci = ${dMinus.toFixed(4)} / ${total.toFixed(4)}</p>
                                        <p>Ci = ${preference.toFixed(4)}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-6 border-t border-dark-300">
                                <h6 class="text-white font-medium mb-3">Interpretasi Hasil:</h6>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="text-center p-3 ${preference >= 0.8 ? 'bg-green-600/20 border border-green-600' : 'bg-dark-700'} rounded-lg">
                                        <p class="text-sm font-medium ${preference >= 0.8 ? 'text-green-400' : 'text-gray-400'}">Sangat Baik</p>
                                        <p class="text-xs text-gray-400 mt-1">Ci ≥ 0.8</p>
                                    </div>
                                    <div class="text-center p-3 ${preference >= 0.6 && preference < 0.8 ? 'bg-yellow-600/20 border border-yellow-600' : 'bg-dark-700'} rounded-lg">
                                        <p class="text-sm font-medium ${preference >= 0.6 && preference < 0.8 ? 'text-yellow-400' : 'text-gray-400'}">Baik</p>
                                        <p class="text-xs text-gray-400 mt-1">0.6 ≤ Ci < 0.8</p>
                                    </div>
                                    <div class="text-center p-3 ${preference < 0.6 ? 'bg-red-600/20 border border-red-600' : 'bg-dark-700'} rounded-lg">
                                        <p class="text-sm font-medium ${preference < 0.6 ? 'text-red-400' : 'text-gray-400'}">Cukup</p>
                                        <p class="text-xs text-gray-400 mt-1">Ci < 0.6</p>
                                    </div>
                                </div>
                                <p class="text-gray-400 text-sm mt-3">
                                    Nilai Ci mendekati 1 menunjukkan supplier sangat mendekati solusi ideal positif 
                                    dan menjauhi solusi ideal negatif.
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
        
        html += `</div>`;
        content.innerHTML = html;
    }

    // Close modal dengan ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeSupplierModal();
        }
    });

    // Click outside modal to close
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('calculationModal');
        const supplierModal = document.getElementById('supplierModal');
        
        if (e.target === modal) {
            closeModal();
        }
        if (e.target === supplierModal) {
            closeSupplierModal();
        }
    });
</script>

    <style>
        .transition {
            transition: all 0.2s ease-in-out;
        }

        .bg-dark-300 { background-color: #1f2937; }
        .bg-dark-400 { background-color: #374151; }
        .bg-dark-500 { background-color: #4b5563; }
        .bg-dark-600 { background-color: #6b7280; }
        .border-dark-200 { border-color: #374151; }

        .max-h-\[calc\(90vh-80px\)\] {
            max-height: calc(90vh - 80px);
        }

        /* Scrollbar styling */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Animation for modal */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        #calculationModal > div,
        #supplierModal > div {
            animation: modalFadeIn 0.2s ease-out;
        }
    </style>