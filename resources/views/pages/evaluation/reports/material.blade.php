<x-layouts.app :title="__('Laporan Material')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <x-title-header :title="__('Laporan Material')" :base="__('Laporan')"/>

            <div class="flex items-center gap-4">
                <!-- Filter Button -->
                <button type="button" 
                    data-modal-target="filterModal" 
                    class="open-modal bg-gray-800 hover:bg-gray-700 text-gray-200 px-4 py-2 rounded-lg transition flex items-center gap-2 border border-gray-700">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>

                <!-- Import Button -->
                <button type="button" 
                    data-modal-target="importModal" 
                    class="open-modal bg-purple-700 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-file-import"></i>
                    <span>Import Data</span>
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
                        <p class="text-sm text-gray-400">Total Material</p>
                        <p class="text-2xl font-bold text-white">{{ $summary['total_material'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-900/50 p-3 rounded-full border border-blue-700/30">
                        <i class="fas fa-boxes text-blue-400 text-xl"></i>
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
                        <p class="text-sm text-gray-400">Jenis Logam</p>
                        <p class="text-2xl font-bold text-green-400">{{ $summary['total_jenis_logam'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-900/50 p-3 rounded-full border border-green-700/30">
                        <i class="fas fa-layer-group text-green-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700">
                    <div class="flex items-center text-xs text-gray-400">
                        <i class="fas fa-tags mr-2"></i>
                        Kategori unik
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-4 shadow border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Harga Tertinggi</p>
                        <p class="text-2xl font-bold text-yellow-400">{{ number_format($summary['harga_tertinggi'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-yellow-900/50 p-3 rounded-full border border-yellow-700/30">
                        <i class="fas fa-arrow-up text-yellow-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700">
                    <div class="flex items-center text-xs text-gray-400">
                        <i class="fas fa-coins mr-2"></i>
                        Per Kg (Rp)
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-4 shadow border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Harga Terendah</p>
                        <p class="text-2xl font-bold text-purple-400">{{ number_format($summary['harga_terendah'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-purple-900/50 p-3 rounded-full border border-purple-700/30">
                        <i class="fas fa-arrow-down text-purple-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700">
                    <div class="flex items-center text-xs text-gray-400">
                        <i class="fas fa-coins mr-2"></i>
                        Per Kg (Rp)
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="mt-4 bg-gray-800 rounded-xl shadow border border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Data Material</h3>
                        <p class="text-sm text-gray-400 mt-1">Data lengkap material berdasarkan filter yang dipilih</p>
                    </div>
                    <div class="text-sm text-gray-400">
                        <i class="fas fa-database mr-2"></i>
                        {{ $materials->total() }} total data
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Supplier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Jenis Logam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Spesifikasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Harga/Kg</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($materials as $index => $material)
                        <tr class="hover:bg-gray-700/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-white">{{ $materials->firstItem() + $index }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-900/50 flex items-center justify-center mr-3 border border-blue-700/30">
                                        <i class="fas fa-cube text-blue-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ $material->nama_material }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $material->supplier ? $material->supplier->nama_supplier : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-xs rounded-full bg-gray-700 text-gray-300 border border-gray-600">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $material->jenis_logam ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-white">{{ $material->grade ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300 max-w-xs truncate">{{ $material->spesifikasi_teknis ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-green-400">
                                    Rp {{ number_format($material->harga_per_kg ?? 0, 0, ',', '.') }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-900 flex items-center justify-center mb-4 border border-gray-700">
                                        <i class="fas fa-inbox text-gray-500 text-2xl"></i>
                                    </div>
                                    <p class="text-lg font-medium text-gray-400">Tidak ada data material</p>
                                    <p class="text-sm text-gray-500 mt-2">Data akan muncul setelah ada material yang terdaftar</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($materials->hasPages())
            <div class="px-6 py-4 border-t border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-400">
                        Menampilkan {{ $materials->firstItem() ?? 0 }} - {{ $materials->lastItem() ?? 0 }} dari {{ $materials->total() }} data
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $materials->links('vendor.pagination.tailwind-dark') }}
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
                        <p class="text-sm text-gray-400 mt-1">Sesuaikan filter untuk data laporan material</p>
                    </div>
                    <button type="button" 
                            class="close-modal text-gray-400 hover:text-white hover:bg-gray-700 rounded-full p-2 transition-colors duration-200" 
                            data-modal="filterModal">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <form action="{{ route('reports.materials.filter') }}" method="GET" id="filterForm">
                    <div class="space-y-6 py-2">
                        <!-- Jenis Logam Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Jenis Logam</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tags text-gray-500"></i>
                                </div>
                                <select name="jenis_logam" class="w-full pl-10 pr-3 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                    <option value="" class="bg-gray-800">Semua Jenis Logam</option>
                                    @foreach($jenisLogamList as $item)
                                    <option value="{{ $item }}" class="bg-gray-800">{{ $item }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Supplier Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Supplier</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-500"></i>
                                </div>
                                <select name="supplier_id" class="w-full pl-10 pr-3 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                    <option value="" class="bg-gray-800">Semua Supplier</option>
                                    @foreach($supplierList as $supplier)
                                    <option value="{{ $supplier->id }}" class="bg-gray-800">{{ $supplier->nama_supplier }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Date Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Dari Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-500"></i>
                                    </div>
                                    <input type="date" name="start_date" 
                                           class="w-full pl-10 pr-3 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Sampai Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-500"></i>
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
                        <p class="text-sm text-gray-400 mt-1">Pilih format untuk export data material</p>
                    </div>
                    <button type="button" 
                            class="close-modal text-gray-400 hover:text-white hover:bg-gray-700 rounded-full p-2 transition-colors duration-200" 
                            data-modal="exportModal">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <form action="{{ route('reports.materials.export') }}" method="GET" id="exportForm">
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
                                    <i class="fas fa-file-excel mr-1"></i> Excel Bulan Ini
                                </button>
                                <button type="button" 
                                        onclick="quickExport('pdf')"
                                        class="px-3 py-1.5 text-xs bg-red-900/30 text-red-400 hover:bg-red-800 rounded-lg border border-red-700/30 transition">
                                    <i class="fas fa-file-pdf mr-1"></i> PDF Bulan Ini
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

    <!-- Import Modal -->
    <div id="importModal" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-gray-800 border border-gray-700 rounded-2xl shadow-xl p-6 md:p-8 transform transition-all duration-300">
                <!-- Header -->
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-700">
                    <div>
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-file-import mr-2 text-purple-400"></i>
                            Import Data Material
                        </h3>
                        <p class="text-sm text-gray-400 mt-1">Upload file Excel untuk import data</p>
                    </div>
                    <button type="button" 
                            class="close-modal text-gray-400 hover:text-white hover:bg-gray-700 rounded-full p-2 transition-colors duration-200" 
                            data-modal="importModal">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <form action="{{ route('reports.materials.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="space-y-6 py-2">
                        <!-- File Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Pilih File Excel</label>
                            <div class="relative">
                                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                       class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-900/30 file:text-blue-400 hover:file:bg-blue-800 transition">
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Format: .xlsx, .xls, .csv (max 2MB)</p>
                        </div>
                        
                        <!-- Download Template -->
                        <div class="bg-blue-900/20 border border-blue-700/30 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-blue-400 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-300 mb-2">Belum punya template?</p>
                                    <a href="{{ route('reports.materials.template') }}" 
                                       class="inline-flex items-center text-sm text-blue-400 hover:text-blue-300 transition">
                                        <i class="fas fa-download mr-2"></i>
                                        Download Template Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action buttons -->
                    <div class="flex items-center justify-end pt-6 mt-6 border-t border-gray-700 space-x-3">
                        <button type="button" 
                                class="close-modal px-5 py-2.5 text-gray-300 bg-gray-700 border border-gray-600 hover:bg-gray-600 hover:border-gray-500 rounded-lg font-medium transition-colors duration-200" 
                                data-modal="importModal">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                            <i class="fas fa-upload mr-2"></i> 
                            Upload & Import
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
    
    // Quick export function
    function quickExport(format) {
        const today = new Date();
        const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        
        const startDate = firstDayOfMonth.toISOString().split('T')[0];
        const endDate = today.toISOString().split('T')[0];
        
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = "{{ route('reports.materials.export') }}";
        form.style.display = 'none';
        
        const formatInput = document.createElement('input');
        formatInput.type = 'hidden';
        formatInput.name = 'format';
        formatInput.value = format;
        form.appendChild(formatInput);
        
        const startDateInput = document.createElement('input');
        startDateInput.type = 'hidden';
        startDateInput.name = 'start_date';
        startDateInput.value = startDate;
        form.appendChild(startDateInput);
        
        const endDateInput = document.createElement('input');
        endDateInput.type = 'hidden';
        endDateInput.name = 'end_date';
        endDateInput.value = endDate;
        form.appendChild(endDateInput);
        
        const summaryInput = document.createElement('input');
        summaryInput.type = 'hidden';
        summaryInput.name = 'include_summary';
        summaryInput.value = 'on';
        form.appendChild(summaryInput);
        
        document.body.appendChild(form);
        
        Swal.fire({
            title: 'Sedang Menyiapkan File',
            text: `Meng-generate file ${format.toUpperCase()} untuk bulan ini...`,
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
    
    // Export form validation
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

    // Import form validation
    document.getElementById('importForm')?.addEventListener('submit', function(e) {
        const fileInput = document.querySelector('input[name="file"]');
        if (!fileInput.files.length) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'File Tidak Dipilih',
                text: 'Silakan pilih file Excel terlebih dahulu',
                background: '#1f2937',
                color: '#fff'
            });
            return;
        }
        
        Swal.fire({
            title: 'Sedang Mengimport Data',
            text: 'Mohon tunggu...',
            allowOutsideClick: false,
            showConfirmButton: false,
            background: '#1f2937',
            color: '#fff',
            willOpen: () => {
                Swal.showLoading();
            }
        });
    });
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
</style>
