<x-layouts.app :title="__('Dashboard Manager')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Welcome Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Dashboard Manager</h1>
                <p class="text-gray-400">Selamat datang, {{ Auth::user()->name }}! Pantau hasil penilaian supplier.</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400">{{ now()->format('l, d F Y') }}</p>
                <p class="text-sm text-gray-500">Terakhir login: {{ Auth::user()->last_login_at?->format('d M Y H:i') ?? 'Pertama kali' }}</p>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Top Performing Supplier -->
            <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-xl p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-200 text-sm font-medium">Supplier Terbaik</p>
                        <h3 class="text-xl font-bold mt-2 truncate">{{ $topSupplier->supplier->nama_supplier ?? 'N/A' }}</h3>
                        <p class="text-green-200 text-sm mt-2">Nilai: {{ number_format($topSupplier->preferensi ?? 0, 4) }}</p>
                    </div>
                    <div class="bg-green-500 p-3 rounded-lg">
                        <i class="fas fa-trophy text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Recent Assessment -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-200 text-sm font-medium">Assessment Terakhir</p>
                        <h3 class="text-xl font-bold mt-2">{{ $latestAssessment ? '#' . $latestAssessment->id : 'N/A' }}</h3>
                        <p class="text-blue-200 text-sm mt-2">{{ $latestAssessment ? \Carbon\Carbon::parse($latestAssessment->created_at)->format('d M Y') : 'Belum ada' }}</p>
                    </div>
                    <div class="bg-blue-500 p-3 rounded-lg">
                        <i class="fas fa-clipboard-check text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Rated Suppliers -->
            <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-purple-200 text-sm font-medium">Supplier Dinilai</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalRatedSuppliers ?? 0 }}</h3>
                        <p class="text-purple-200 text-sm mt-2">Total penilaian</p>
                    </div>
                    <div class="bg-purple-500 p-3 rounded-lg">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Results -->
            <div class="lg:col-span-2 bg-dark-300 rounded-xl border border-dark-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-white">Hasil Assessment Terbaru</h2>
                    <a href="{{ route('results.history') }}" class="text-blue-400 hover:text-blue-300 text-sm">Lihat Semua</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-dark-400 border-b border-dark-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Peringkat</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Supplier</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nilai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Assessment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-200">
                            @forelse($recentResults ?? [] as $result)
                                <tr class="hover:bg-dark-400 transition">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                            {{ $result->rank == 1 ? 'bg-yellow-600' : 
                                               ($result->rank == 2 ? 'bg-gray-600' : 
                                               ($result->rank == 3 ? 'bg-orange-600' : 'bg-blue-600')) }} 
                                            text-white text-sm font-medium">
                                            {{ $result->rank }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-white">
                                        {{ $result->supplier->nama_supplier ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-white">
                                        {{ number_format($result->preference_score, 4) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-400 text-sm">
                                        #{{ $result->assessment_id }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                        <i class="fas fa-chart-bar text-3xl mb-2"></i>
                                        <p>Belum ada hasil assessment</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Access & Stats -->
            <div class="space-y-6">
                <!-- Quick Access -->
                <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Akses Cepat</h2>
                    <div class="space-y-3">
                        <a href="{{ route('results.history') }}" class="flex items-center gap-3 p-3 bg-dark-400 hover:bg-dark-200 rounded-lg transition border border-dark-200 hover:border-blue-500">
                            <div class="bg-blue-600 p-2 rounded-lg">
                                <i class="fas fa-chart-bar text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-white">Lihat Hasil</h3>
                                <p class="text-sm text-gray-400">Semua assessment</p>
                            </div>
                        </a>

                        <a href="{{ route('supplier.index') }}" class="flex items-center gap-3 p-3 bg-dark-400 hover:bg-dark-200 rounded-lg transition border border-dark-200 hover:border-green-500">
                            <div class="bg-green-600 p-2 rounded-lg">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-white">Data Supplier</h3>
                                <p class="text-sm text-gray-400">Lihat supplier</p>
                            </div>
                        </a>

                        <a href="{{ route('assessments.create') }}" class="flex items-center gap-3 p-3 bg-dark-400 hover:bg-dark-200 rounded-lg transition border border-dark-200 hover:border-purple-500">
                            <div class="bg-purple-600 p-2 rounded-lg">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-white">Assessment Baru</h3>
                                <p class="text-sm text-gray-400">Buat penilaian</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Performance Summary -->
                <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Ringkasan</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Assessment Bulan Ini</span>
                            <span class="text-white font-medium">{{ $monthlyAssessments ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Rata-rata Nilai</span>
                            <span class="text-white font-medium">{{ number_format($averageScore ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Supplier Aktif</span>
                            <span class="text-white font-medium">{{ $activeSuppliers ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>