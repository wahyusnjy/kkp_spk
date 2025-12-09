<x-layouts.app :title="__('Dashboard Admin')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Welcome Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Dashboard Admin</h1>
                <p class="text-gray-400">Selamat datang, {{ Auth::user()->name }}! Kelola sistem penilaian supplier.</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400">{{ now()->format('l, d F Y') }}</p>
                <p class="text-sm text-gray-500">Terakhir login: {{ Auth::user()->last_login_at?->format('d M Y H:i') ?? 'Pertama kali' }}</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Assessments Card -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-200 text-sm font-medium">Total Assessment</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalAssessments ?? 0 }}</h3>
                        <p class="text-blue-200 text-sm mt-2">Assessment dilakukan</p>
                    </div>
                    <div class="bg-blue-500 p-3 rounded-lg">
                        <i class="fas fa-clipboard-list text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Suppliers Card -->
            <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-xl p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-200 text-sm font-medium">Total Supplier</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalSuppliers ?? 0 }}</h3>
                        <p class="text-green-200 text-sm mt-2">Supplier terdaftar</p>
                    </div>
                    <div class="bg-green-500 p-3 rounded-lg">
                        <i class="fas fa-truck text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Criteria Card -->
            <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-purple-200 text-sm font-medium">Kriteria</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalCriteria ?? 0 }}</h3>
                        <p class="text-purple-200 text-sm mt-2">Kriteria penilaian</p>
                    </div>
                    <div class="bg-purple-500 p-3 rounded-lg">
                        <i class="fas fa-list-alt text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Users Card -->
            <div class="bg-gradient-to-br from-orange-600 to-orange-800 rounded-xl p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-orange-200 text-sm font-medium">Pengguna Aktif</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $activeUsers ?? 0 }}</h3>
                        <p class="text-orange-200 text-sm mt-2">User terdaftar</p>
                    </div>
                    <div class="bg-orange-500 p-3 rounded-lg">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <div class="lg:col-span-2 bg-dark-300 rounded-xl border border-dark-200 p-6 bg-gradient-to-br from-dark-200 to-blue-800">
                <h2 class="text-xl font-semibold text-white mb-6">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('supplier.index') }}" class="bg-dark-400 hover:bg-dark-200 rounded-lg p-4 transition border border-dark-200 hover:border-blue-500 bg-gradient-to-br from-dark-200 to-dark-800">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-600 p-2 rounded-lg">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-white">Kelola Supplier</h3>
                                <p class="text-sm text-gray-400">Tambah/edit supplier</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('kriteria.index') }}" class="bg-dark-400 hover:bg-dark-200 rounded-lg p-4 transition border border-dark-200 hover:border-purple-500">
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-600 p-2 rounded-lg">
                                <i class="fas fa-list-alt text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-white">Kelola Kriteria</h3>
                                <p class="text-sm text-gray-400">Atur kriteria penilaian</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('assessments.create') }}" class="bg-dark-400 hover:bg-dark-200 rounded-lg p-4 transition border border-dark-200 hover:border-green-500">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-600 p-2 rounded-lg">
                                <i class="fas fa-clipboard-check text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-white">Buat Assessment</h3>
                                <p class="text-sm text-gray-400">Mulai penilaian baru</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('results.history') }}" class="bg-dark-400 hover:bg-dark-200 rounded-lg p-4 transition border border-dark-200 hover:border-orange-500">
                        <div class="flex items-center gap-3">
                            <div class="bg-orange-600 p-2 rounded-lg">
                                <i class="fas fa-chart-bar text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-white">Lihat Hasil</h3>
                                <p class="text-sm text-gray-400">Riwayat assessment</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Assessments -->
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-white">Assessment Terbaru</h2>
                    <a href="{{ route('results.history') }}" class="text-blue-400 hover:text-blue-300 text-sm">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentAssessments ?? [] as $assessment)
                        <div class="bg-dark-400 rounded-lg p-4 border border-dark-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-white">Assessment #{{ $assessment->id }}</h3>
                                    <p class="text-sm text-gray-400">{{ $assessment->created_at ? \Carbon\Carbon::parse($assessment->created_at)->format('d M Y') : 'Created date 404' }}</p>
                                </div>
                                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $assessment->topsisResults->count() }} Supplier
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list text-3xl text-gray-600 mb-2"></i>
                            <p class="text-gray-400">Belum ada assessment</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- System Overview -->
        <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">System Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-blue-600 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-database text-white"></i>
                    </div>
                    <h3 class="text-white font-medium">Database</h3>
                    <p class="text-gray-400 text-sm">Status: <span class="text-green-400">Normal</span></p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-600 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-server text-white"></i>
                    </div>
                    <h3 class="text-white font-medium">Server</h3>
                    <p class="text-gray-400 text-sm">Status: <span class="text-green-400">Online</span></p>
                </div>
                
                <div class="text-center">
                    <div class="bg-purple-600 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    <h3 class="text-white font-medium">Security</h3>
                    <p class="text-gray-400 text-sm">Status: <span class="text-green-400">Aman</span></p>
                </div>
                
                <div class="text-center">
                    <div class="bg-orange-600 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-sync-alt text-white"></i>
                    </div>
                    <h3 class="text-white font-medium">Backup</h3>
                    <p class="text-gray-400 text-sm">Terakhir: {{ now()->subDay()->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>