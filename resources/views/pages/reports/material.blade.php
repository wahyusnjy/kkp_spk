<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-3">
                    <i class="fas fa-boxes text-blue-400 mr-3"></i>
                    Laporan Material Lengkap
                </h1>
                <p class="text-gray-400 text-lg">Download laporan detail semua material dengan statistik harga dan supplier</p>
            </div>

            {{-- Export Options Card --}}
            <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-900/50 mb-4 border border-blue-700/30">
                            <i class="fas fa-file-download text-blue-400 text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-semibold text-white mb-2">Pilih Format Export</h2>
                        <p class="text-gray-600 dark:text-gray-400">Pilih format file yang diinginkan untuk download laporan</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- PDF Export --}}
                        <a href="{{ route('reports.material', ['format' => 'pdf']) }}" 
                           class="group relative bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-xl p-8 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                            <div class="text-center">
                                <div class="flex justify-center mb-4">
                                    <i class="fas fa-file-pdf text-6xl text-white group-hover:scale-110 transition-transform"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">Export PDF</h3>
                                <p class="text-red-100 text-sm mb-4">Format dokumen untuk presentasi dan pencetakan</p>
                                <div class="flex items-center justify-center gap-2 text-white font-semibold">
                                    <span>Download PDF</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </a>

                        {{-- Excel Export --}}
                        <a href="{{ route('reports.material', ['format' => 'excel']) }}" 
                           class="group relative bg-gradient-to-br from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-xl p-8 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                            <div class="text-center">
                                <div class="flex justify-center mb-4">
                                    <i class="fas fa-file-excel text-6xl text-white group-hover:scale-110 transition-transform"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">Export Excel</h3>
                                <p class="text-green-100 text-sm mb-4">Format spreadsheet untuk analisis data</p>
                                <div class="flex items-center justify-center gap-2 text-white font-semibold">
                                    <span>Download Excel</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Info Section --}}
                    <div class="mt-8 p-6 bg-blue-900/20 border border-blue-700/30 rounded-xl">
                        <h4 class="text-blue-400 font-semibold mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Informasi Laporan
                        </h4>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-400 mt-1"></i>
                                <span>Detail lengkap semua material (nama, supplier, jenis logam, grade, spesifikasi, harga)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-400 mt-1"></i>
                                <span>Statistik harga tertinggi dan terendah per jenis logam</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-400 mt-1"></i>
                                <span>Total material dan jumlah jenis logam</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-400 mt-1"></i>
                                <span>Ringkasan supplier dan kategori material</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Template Import Section --}}
                    <div class="mt-6 p-6 bg-purple-900/20 border border-purple-700/30 rounded-xl">
                        <h4 class="text-purple-400 font-semibold mb-3 flex items-center gap-2">
                            <i class="fas fa-file-import"></i>
                            Template Import Material
                        </h4>
                        <p class="text-gray-300 text-sm mb-4">Download template Excel untuk import data material secara batch</p>
                        <a href="{{ route('reports.materials.template') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                            <i class="fas fa-download"></i>
                            <span>Download Template Import</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="mt-8 text-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
