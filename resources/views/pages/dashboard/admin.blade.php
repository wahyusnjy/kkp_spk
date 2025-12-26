<x-layouts.app :title="__('Dashboard Admin')">
    <style>
        /* Force dark mode override */
        .dashboard-container * {
            color-scheme: dark !important;
        }
        
        /* Fix untuk elemen yang mungkin terpengaruh light mode */
        .dark-override {
            @apply bg-dark-800 text-white;
        }
        
        /* Pastikan semua teks readable di dark mode */
        .text-dark-gray {
            @apply text-gray-300;
        }
        
        .text-light-gray {
            @apply text-gray-400;
        }
    </style>
    
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl dashboard-container">
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">Dashboard Admin</h1>
                <p class="text-gray-300 mt-1">Selamat datang, {{ Auth::user()->name }}! Kelola sistem penilaian supplier.</p>
            </div>
            <div class="text-left md:text-right bg-dark-700/50 rounded-lg p-4 border border-dark-600 w-full md:w-auto">
                <p class="text-gray-300 font-medium">{{ now()->format('l, d F Y') }}</p>
                <p class="text-sm text-gray-400 mt-1">Terakhir login: {{ Auth::user()->last_login_at?->format('d M Y H:i') ?? 'Pertama kali' }}</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Assessments Card -->
            <div class="bg-gradient-to-br from-blue-700 via-blue-800 to-blue-900 rounded-xl p-6 text-white shadow-lg border border-blue-600/30">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-200 text-sm font-medium">Total Assessment</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalAssessments ?? 0 }}</h3>
                        <p class="text-blue-200/80 text-sm mt-2">Assessment dilakukan</p>
                    </div>
                    <div class="bg-blue-600/80 p-3 rounded-xl shadow-md">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-blue-500/30">
                    <div class="flex items-center text-blue-200 text-sm">
                        <i class="fas fa-arrow-up mr-2 text-green-400"></i>
                        <span>+12% dari bulan lalu</span>
                    </div>
                </div>
            </div>

            <!-- Total Suppliers Card -->
            <div class="bg-gradient-to-br from-emerald-700 via-emerald-800 to-emerald-900 rounded-xl p-6 text-white shadow-lg border border-emerald-600/30">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-emerald-200 text-sm font-medium">Total Supplier</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalSuppliers ?? 0 }}</h3>
                        <p class="text-emerald-200/80 text-sm mt-2">Supplier terdaftar</p>
                    </div>
                    <div class="bg-emerald-600/80 p-3 rounded-xl shadow-md">
                        <i class="fas fa-truck text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-emerald-500/30">
                    <div class="flex items-center text-emerald-200 text-sm">
                        <i class="fas fa-check-circle mr-2 text-green-400"></i>
                        <span>{{ $activeSuppliers ?? 0 }} aktif</span>
                    </div>
                </div>
            </div>

            <!-- Total Criteria Card -->
            <div class="bg-gradient-to-br from-violet-700 via-violet-800 to-violet-900 rounded-xl p-6 text-white shadow-lg border border-violet-600/30">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-violet-200 text-sm font-medium">Kriteria</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalCriteria ?? 0 }}</h3>
                        <p class="text-violet-200/80 text-sm mt-2">Kriteria penilaian</p>
                    </div>
                    <div class="bg-violet-600/80 p-3 rounded-xl shadow-md">
                        <i class="fas fa-list-alt text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-violet-500/30">
                    <div class="flex items-center text-violet-200 text-sm">
                        <i class="fas fa-cog mr-2 text-blue-400"></i>
                        <span>Konfigurasi tersedia</span>
                    </div>
                </div>
            </div>

            <!-- Active Users Card -->
            <div class="bg-gradient-to-br from-amber-700 via-amber-800 to-amber-900 rounded-xl p-6 text-white shadow-lg border border-amber-600/30">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-amber-200 text-sm font-medium">Pengguna Aktif</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $activeUsers ?? 0 }}</h3>
                        <p class="text-amber-200/80 text-sm mt-2">User terdaftar</p>
                    </div>
                    <div class="bg-amber-600/80 p-3 rounded-xl shadow-md">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-amber-500/30">
                    <div class="flex items-center text-amber-200 text-sm">
                        <i class="fas fa-user-check mr-2 text-green-400"></i>
                        <span>{{ $onlineUsers ?? 0 }} online</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <div class="lg:col-span-2 bg-gradient-to-br from-dark-800 via-dark-900 to-blue-900/30 rounded-xl border border-dark-600 p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-white">Quick Actions</h2>
                    <span class="bg-blue-600/20 text-blue-300 text-xs px-3 py-1 rounded-full border border-blue-500/30">
                        Akses Cepat
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('supplier.index') }}" class="group bg-gradient-to-br from-dark-700 via-dark-800 to-blue-900/30 hover:from-blue-900/40 hover:to-blue-800/30 rounded-xl p-5 transition-all duration-300 border border-dark-600 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-truck text-white text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-white group-hover:text-blue-300">Kelola Supplier</h3>
                                <p class="text-sm text-gray-400 group-hover:text-gray-300 mt-1">Tambah, edit, atau hapus data supplier</p>
                            </div>
                            <div class="text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('kriteria.index') }}" class="group bg-gradient-to-br from-dark-700 via-dark-800 to-purple-900/30 hover:from-purple-900/40 hover:to-purple-800/30 rounded-xl p-5 transition-all duration-300 border border-dark-600 hover:border-purple-500/50 hover:shadow-lg hover:shadow-purple-500/10">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-br from-purple-600 to-purple-800 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-list-alt text-white text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-white group-hover:text-purple-300">Kelola Kriteria</h3>
                                <p class="text-sm text-gray-400 group-hover:text-gray-300 mt-1">Atur kriteria dan bobot penilaian</p>
                            </div>
                            <div class="text-purple-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('assessments.create') }}" class="group bg-gradient-to-br from-dark-700 via-dark-800 to-emerald-900/30 hover:from-emerald-900/40 hover:to-emerald-800/30 rounded-xl p-5 transition-all duration-300 border border-dark-600 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/10">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clipboard-check text-white text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-white group-hover:text-emerald-300">Buat Assessment</h3>
                                <p class="text-sm text-gray-400 group-hover:text-gray-300 mt-1">Mulai proses penilaian supplier baru</p>
                            </div>
                            <div class="text-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('results.history') }}" class="group bg-gradient-to-br from-dark-700 via-dark-800 to-amber-900/30 hover:from-amber-900/40 hover:to-amber-800/30 rounded-xl p-5 transition-all duration-300 border border-dark-600 hover:border-amber-500/50 hover:shadow-lg hover:shadow-amber-500/10">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-br from-amber-600 to-amber-800 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-chart-bar text-white text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-white group-hover:text-amber-300">Lihat Hasil</h3>
                                <p class="text-sm text-gray-400 group-hover:text-gray-300 mt-1">Analisis dan riwayat assessment</p>
                            </div>
                            <div class="text-amber-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Assessments -->
            <div class="bg-gradient-to-br from-dark-800 via-dark-900 to-dark-950 rounded-xl border border-dark-600 p-6 shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-white">Assessment Terbaru</h2>
                        <p class="text-sm text-gray-400 mt-1">5 aktivitas terakhir</p>
                    </div>
                    <a href="{{ route('results.history') }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium flex items-center gap-1">
                        Lihat Semua <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($recentAssessments ?? [] as $assessment)
                        <div class="bg-gradient-to-r from-dark-700/80 to-dark-800/50 hover:from-dark-700 hover:to-dark-800 rounded-lg p-4 border border-dark-600 hover:border-blue-500/30 transition-all duration-300 group">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-semibold text-white group-hover:text-blue-300">Assessment #{{ $assessment->id }}</h3>
                                        @if($assessment->status === 'completed')
                                            <span class="bg-emerald-900/30 text-emerald-300 text-[10px] px-2 py-0.5 rounded-full border border-emerald-700/50">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="bg-amber-900/30 text-amber-300 text-[10px] px-2 py-0.5 rounded-full border border-amber-700/50">
                                                Proses
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-400">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $assessment->created_at ? \Carbon\Carbon::parse($assessment->created_at)->format('d M Y H:i') : 'Tanggal tidak tersedia' }}
                                    </p>
                                </div>
                                <span class="bg-gradient-to-r from-blue-600 to-blue-800 text-white text-xs px-3 py-1.5 rounded-full font-medium shadow-md">
                                    {{ $assessment->topsisResults->count() }} Supplier
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 border-2 border-dashed border-dark-600 rounded-xl bg-dark-800/30">
                            <div class="bg-dark-700/50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clipboard-list text-2xl text-gray-500"></i>
                            </div>
                            <p class="text-gray-400 font-medium">Belum ada assessment</p>
                            <p class="text-gray-500 text-sm mt-1">Mulai assessment pertama Anda</p>
                            <a href="{{ route('assessments.create') }}" class="inline-block mt-4 text-blue-400 hover:text-blue-300 text-sm">
                                Buat Assessment <i class="fas fa-plus ml-1"></i>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- System Overview -->
        <div class="bg-gradient-to-br from-dark-800 via-dark-900 to-dark-950 rounded-xl border border-dark-600 p-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-white">System Overview</h2>
                <span class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-blue-300 text-xs px-3 py-1 rounded-full border border-blue-500/30">
                    Real-time Status
                </span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-dark-700/50 to-dark-800/30 rounded-xl p-6 border border-dark-600 hover:border-blue-500/50 transition-colors duration-300 text-center">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-database text-2xl text-white"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Database</h3>
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <p class="text-sm text-gray-400">Status: <span class="text-green-400 font-medium">Normal</span></p>
                    </div>
                    <p class="text-xs text-gray-500">Response time: 12ms</p>
                </div>
                
                <div class="bg-gradient-to-br from-dark-700/50 to-dark-800/30 rounded-xl p-6 border border-dark-600 hover:border-emerald-500/50 transition-colors duration-300 text-center">
                    <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-server text-2xl text-white"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Server</h3>
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <p class="text-sm text-gray-400">Status: <span class="text-green-400 font-medium">Online</span></p>
                    </div>
                    <p class="text-xs text-gray-500">Uptime: 99.8%</p>
                </div>
                
                <div class="bg-gradient-to-br from-dark-700/50 to-dark-800/30 rounded-xl p-6 border border-dark-600 hover:border-violet-500/50 transition-colors duration-300 text-center">
                    <div class="bg-gradient-to-br from-violet-600 to-violet-800 w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Security</h3>
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <p class="text-sm text-gray-400">Status: <span class="text-green-400 font-medium">Aman</span></p>
                    </div>
                    <p class="text-xs text-gray-500">Last scan: 2 jam lalu</p>
                </div>
                
                <div class="bg-gradient-to-br from-dark-700/50 to-dark-800/30 rounded-xl p-6 border border-dark-600 hover:border-amber-500/50 transition-colors duration-300 text-center">
                    <div class="bg-gradient-to-br from-amber-600 to-amber-800 w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-sync-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Backup</h3>
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <p class="text-sm text-gray-400">Status: <span class="text-green-400 font-medium">Updated</span></p>
                    </div>
                    <p class="text-xs text-gray-500">Terakhir: {{ now()->subDay()->format('d M Y') }}</p>
                </div>
            </div>
            
            <!-- System Footer -->
            <div class="mt-8 pt-6 border-t border-dark-600/50">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                            <span class="text-sm text-gray-300">Semua sistem berjalan normal</span>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="far fa-clock mr-1"></i>
                        Terakhir diperbarui: {{ now()->format('H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Force Dark Mode Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Force dark mode pada html element
            document.documentElement.classList.add('dark');
            document.documentElement.style.colorScheme = 'dark';
            
            // Force dark mode pada body
            document.body.classList.add('dark', 'bg-dark-900');
            document.body.style.backgroundColor = '#0f172a';
            
            // Remove any light mode classes
            document.documentElement.classList.remove('light');
            document.body.classList.remove('light', 'bg-white');
            
            // Set theme in localStorage
            localStorage.setItem('theme', 'dark');
            
            // Override any system preference
            const metaTheme = document.createElement('meta');
            metaTheme.name = 'color-scheme';
            metaTheme.content = 'dark';
            document.head.appendChild(metaTheme);
        });
    </script>
</x-layouts.app>