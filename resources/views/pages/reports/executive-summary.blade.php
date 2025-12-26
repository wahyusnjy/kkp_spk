<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-3">
                    <i class="fas fa-chart-line text-blue-400 mr-3"></i>
                    Executive Summary
                </h1>
                <p class="text-gray-300 text-lg">Laporan ringkasan eksekutif untuk management overview</p>
            </div>

            {{-- Export Options Card --}}
            <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 mb-4 shadow-lg">
                            <i class="fas fa-briefcase text-white text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-semibold text-white mb-2">Pilih Format Export</h2>
                        <p class="text-gray-600 dark:text-gray-400">Download laporan ringkasan lengkap sistem</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- PDF Export --}}
                        <a href="{{ route('reports.executive-summary', ['format' => 'pdf']) }}" 
                           class="group relative bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-xl p-8 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                            <div class="text-center">
                                <div class="flex justify-center mb-4">
                                    <i class="fas fa-file-pdf text-6xl text-white group-hover:scale-110 transition-transform"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">Export PDF</h3>
                                <p class="text-red-100 text-sm mb-4">Format presentasi untuk management</p>
                                <div class="flex items-center justify-center gap-2 text-white font-semibold">
                                    <span>Download PDF</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </a>

                        {{-- Excel Export --}}
                        <a href="{{ route('reports.executive-summary', ['format' => 'excel']) }}" 
                           class="group relative bg-gradient-to-br from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-xl p-8 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                            <div class="text-center">
                                <div class="flex justify-center mb-4">
                                    <i class="fas fa-file-excel text-6xl text-white group-hover:scale-110 transition-transform"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">Export Excel</h3>
                                <p class="text-green-100 text-sm mb-4">Multi-sheet dengan data detail</p>
                                <div class="flex items-center justify-center gap-2 text-white font-semibold">
                                    <span>Download Excel</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Info Section --}}
                    <div class="mt-8 p-6 bg-gradient-to-r from-purple-900/20 to-blue-900/20 border border-purple-700/30 rounded-xl">
                        <h4 class="text-purple-400 font-semibold mb-3 flex items-center gap-2">
                            <i class="fas fa-chart-pie"></i>
                            Konten Laporan
                        </h4>
                        <div class="grid md:grid-cols-2 gap-4 text-gray-300 text-sm">
                            <div>
                                <h5 class="text-white font-semibold mb-2">Statistik Utama:</h5>
                                <ul class="space-y-1">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-400 mt-1 text-xs"></i>
                                        <span>Total assessment (selesai, proses, draft)</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-400 mt-1 text-xs"></i>
                                        <span>Statistik supplier & kriteria</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-400 mt-1 text-xs"></i>
                                        <span>Material yang telah dinilai</span>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h5 class="text-white font-semibold mb-2">Aktivitas Terbaru:</h5>
                                <ul class="space-y-1">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-400 mt-1 text-xs"></i>
                                        <span>5 Assessment terbaru</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-400 mt-1 text-xs"></i>
                                        <span>5 Pemenang terbaru</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-400 mt-1 text-xs"></i>
                                        <span>Supplier terbaik (win rate)</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
