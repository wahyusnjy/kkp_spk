<x-layouts.app>
    <style>
        /* Force dark mode styles */
        .dashboard-manager * {
            color-scheme: dark !important;
        }
        
        .dark-gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        
        .card-hover-effect {
            transition: all 0.3s ease;
        }
        
        .card-hover-effect:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .status-pulse {
            position: relative;
        }
        
        .status-pulse::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            right: 10px;
            top: 10px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7); }
            70% { box-shadow: 0 0 0 6px rgba(74, 222, 128, 0); }
            100% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); }
        }
    </style>
    
    <div class="max-w-9xl mx-auto px-4 py-6 sm:px-6 lg:px-8 dashboard-manager">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">
                        <i class="fas fa-chart-line text-blue-400 mr-3"></i>
                        Manager Dashboard
                    </h1>
                    <p class="text-gray-300">Selamat datang, <span class="text-white font-semibold">{{ auth()->user()->name }}</span> - Monitoring & Reporting Overview</p>
                </div>
                <div class="bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3">
                    <p class="text-gray-300 text-sm">
                        <i class="far fa-calendar-alt mr-2 text-blue-400"></i>
                        {{ now()->format('l, d F Y') }}
                    </p>
                    <p class="text-gray-400 text-xs mt-1">
                        <i class="far fa-clock mr-2"></i>
                        {{ now()->format('H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @php
                $totalAssessments = \App\Models\Assessment::count();
                $completedAssessments = \App\Models\Assessment::whereHas('topsisResults')->count();
                $totalSuppliers = \App\Models\Supplier::count();
                $totalMaterials = \App\Models\Material::count();
                $completionRate = $totalAssessments > 0 ? round(($completedAssessments / $totalAssessments) * 100) : 0;
            @endphp

            {{-- Total Assessments Card --}}
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl p-6 border border-gray-700 shadow-xl card-hover-effect status-pulse">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-800/30 to-blue-900/50 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-check text-blue-400 text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center justify-end gap-2 mb-1">
                            <span class="text-xs bg-blue-900/40 text-blue-300 px-3 py-1 rounded-full border border-blue-700/30">
                                Total
                            </span>
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                        </div>
                        <div class="text-2xl font-bold text-white">{{ $totalAssessments }}</div>
                    </div>
                </div>
                <p class="text-gray-400 text-sm mb-3">Total Assessments</p>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: {{ min($completionRate, 100) }}%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>Completion</span>
                    <span class="text-blue-300">{{ $completionRate }}%</span>
                </div>
            </div>

            {{-- Completed Assessments Card --}}
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl p-6 border border-gray-700 shadow-xl card-hover-effect">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-800/30 to-emerald-900/50 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-emerald-400 text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <span class="text-xs bg-emerald-900/40 text-emerald-300 px-3 py-1 rounded-full border border-emerald-700/30 block mb-1">
                            Selesai
                        </span>
                        <div class="text-2xl font-bold text-white">{{ $completedAssessments }}</div>
                    </div>
                </div>
                <p class="text-gray-400 text-sm mb-3">Completed</p>
                <div class="flex items-center text-emerald-400 text-sm">
                    <i class="fas fa-arrow-up mr-2 text-emerald-400"></i>
                    <span>{{ $completedAssessments > 0 ? 'Active' : 'No data' }}</span>
                </div>
            </div>

            {{-- Total Suppliers Card --}}
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl p-6 border border-gray-700 shadow-xl card-hover-effect">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-800/30 to-purple-900/50 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-building text-purple-400 text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <span class="text-xs bg-purple-900/40 text-purple-300 px-3 py-1 rounded-full border border-purple-700/30 block mb-1">
                            Active
                        </span>
                        <div class="text-2xl font-bold text-white">{{ $totalSuppliers }}</div>
                    </div>
                </div>
                <p class="text-gray-400 text-sm mb-3">Total Suppliers</p>
                <div class="flex items-center text-purple-400 text-sm">
                    <i class="fas fa-users mr-2"></i>
                    <span>{{ $totalSuppliers }} registered</span>
                </div>
            </div>

            {{-- Total Materials Card --}}
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl p-6 border border-gray-700 shadow-xl card-hover-effect">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-800/30 to-amber-900/50 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-cubes text-amber-400 text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <span class="text-xs bg-amber-900/40 text-amber-300 px-3 py-1 rounded-full border border-amber-700/30 block mb-1">
                            Items
                        </span>
                        <div class="text-2xl font-bold text-white">{{ $totalMaterials }}</div>
                    </div>
                </div>
                <p class="text-gray-400 text-sm mb-3">Total Materials</p>
                <div class="flex items-center text-amber-400 text-sm">
                    <i class="fas fa-boxes mr-2"></i>
                    <span>Material types</span>
                </div>
            </div>
        </div>

        {{-- Quick Access Reports --}}
        <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 shadow-xl p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-download text-white"></i>
                    </div>
                    Quick Access Reports
                </h2>
                <span class="text-xs bg-gray-700/50 text-gray-300 px-3 py-1 rounded-full border border-gray-600">
                    Fast Navigation
                </span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('reports.assessments') }}" class="group bg-gradient-to-br from-blue-800/30 to-blue-900/20 hover:from-blue-800/50 hover:to-blue-900/40 rounded-xl p-5 transition-all duration-300 border border-blue-700/30 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-blue-600 to-blue-800 w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-clipboard-list text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-white font-semibold group-hover:text-blue-300">Assessment Reports</h3>
                            <p class="text-blue-100/70 text-xs mt-1">View all assessments</p>
                        </div>
                        <div class="text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('reports.suppliers') }}" class="group bg-gradient-to-br from-purple-800/30 to-purple-900/20 hover:from-purple-800/50 hover:to-purple-900/40 rounded-xl p-5 transition-all duration-300 border border-purple-700/30 hover:border-purple-500/50 hover:shadow-lg hover:shadow-purple-500/10">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-purple-600 to-purple-800 w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-building text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-white font-semibold group-hover:text-purple-300">Supplier Reports</h3>
                            <p class="text-purple-100/70 text-xs mt-1">Supplier statistics</p>
                        </div>
                        <div class="text-purple-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('reports.kriteria') }}" class="group bg-gradient-to-br from-emerald-800/30 to-emerald-900/20 hover:from-emerald-800/50 hover:to-emerald-900/40 rounded-xl p-5 transition-all duration-300 border border-emerald-700/30 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/10">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-list-check text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-white font-semibold group-hover:text-emerald-300">Kriteria Report</h3>
                            <p class="text-emerald-100/70 text-xs mt-1">Criteria details</p>
                        </div>
                        <div class="text-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('reports.executive-summary') }}" class="group bg-gradient-to-br from-amber-800/30 to-amber-900/20 hover:from-amber-800/50 hover:to-amber-900/40 rounded-xl p-5 transition-all duration-300 border border-amber-700/30 hover:border-amber-500/50 hover:shadow-lg hover:shadow-amber-500/10">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-amber-600 to-amber-800 w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-chart-pie text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-white font-semibold group-hover:text-amber-300">Executive Summary</h3>
                            <p class="text-amber-100/70 text-xs mt-1">Overview report</p>
                        </div>
                        <div class="text-amber-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Recent Assessments Table --}}
        <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-xl border border-gray-700 shadow-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    Recent Assessments
                </h2>
                <div class="flex items-center gap-3">
                    <span class="text-xs bg-gray-700/50 text-gray-300 px-3 py-1 rounded-full border border-gray-600">
                        Latest 5 Records
                    </span>
                    <a href="{{ route('assessments.create') }}" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-full border border-blue-500 transition-colors">
                        <i class="fas fa-plus mr-1"></i> New
                    </a>
                </div>
            </div>
            
            @php
                $recentAssessments = \App\Models\Assessment::with(['material', 'topsisResults.supplier'])
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp

            <div class="overflow-x-auto rounded-xl border border-gray-700">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-hashtag text-blue-400"></i>
                                    ID
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cube text-purple-400"></i>
                                    Material
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-calendar text-emerald-400"></i>
                                    Tahun
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tasks text-amber-400"></i>
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-trophy text-yellow-400"></i>
                                    Winner
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-clock text-gray-400"></i>
                                    Date
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800/30 divide-y divide-gray-700">
                        @forelse($recentAssessments as $assessment)
                        <tr class="hover:bg-gray-700/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-blue-300 font-semibold text-sm">#{{ $assessment->id }}</span>
                                    </div>
                                    <div class="text-sm">
                                        <div class="font-medium text-white">Assessment</div>
                                        <div class="text-gray-400 text-xs">ID: {{ $assessment->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-900/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-cube text-purple-400"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-white">{{ $assessment->material->nama_material ?? 'N/A' }}</div>
                                        <div class="text-gray-400 text-xs">Material</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="bg-gray-800/50 rounded-lg px-3 py-2 inline-block">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-emerald-400">{{ $assessment->tahun }}</div>
                                        <div class="text-gray-400 text-xs">Year</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($assessment->topsisResults->count() > 0)
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></div>
                                        <span class="px-3 py-1.5 text-xs rounded-full bg-emerald-900/30 text-emerald-300 border border-emerald-700/30">
                                            <i class="fas fa-check-circle mr-1"></i> Completed
                                        </span>
                                    </div>
                                    <div class="text-gray-400 text-xs mt-1">
                                        {{ $assessment->topsisResults->count() }} results
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-amber-500 rounded-full mr-2"></div>
                                        <span class="px-3 py-1.5 text-xs rounded-full bg-amber-900/30 text-amber-300 border border-amber-700/30">
                                            <i class="fas fa-spinner fa-spin mr-1"></i> Processing
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $winner = $assessment->topsisResults()->orderBy('rank')->first();
                                @endphp
                                @if($winner)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-trophy text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">{{ $winner->supplier->nama_supplier }}</div>
                                            <div class="text-gray-400 text-xs">Rank: {{ $winner->rank }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-gray-500 italic flex items-center">
                                        <i class="fas fa-minus-circle mr-2"></i>
                                        No winner yet
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-300">
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-gray-400 text-xs">
                                        {{ \Carbon\Carbon::parse($assessment->created_at)->format('H:i') }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <div class="w-20 h-20 bg-gray-800/50 rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-gray-700">
                                        <i class="fas fa-clipboard-list text-3xl text-gray-600"></i>
                                    </div>
                                    <h3 class="text-gray-400 font-medium mb-2">No assessments found</h3>
                                    <p class="text-gray-500 text-sm mb-4">Start your first assessment</p>
                                    <a href="{{ route('assessments.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm transition-all">
                                        <i class="fas fa-plus mr-2"></i> Create Assessment
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-700 flex justify-between items-center">
                <div class="text-gray-400 text-sm">
                    Showing {{ min(5, $recentAssessments->count()) }} of {{ $totalAssessments }} assessments
                </div>
                <a href="{{ route('assessments.index') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition group">
                    <span>View All Assessments</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        {{-- System Status Footer --}}
        <div class="mt-8 pt-6 border-t border-gray-700/50">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></div>
                        <span class="text-sm text-gray-300">All systems operational</span>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-server mr-2 text-blue-400"></i>
                    Last updated: {{ now()->format('H:i:s') }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Force Dark Mode Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Force dark mode on html element
            document.documentElement.classList.add('dark');
            document.documentElement.style.colorScheme = 'dark';
            
            // Force dark mode on body
            document.body.classList.add('dark', 'bg-gray-900');
            document.body.style.backgroundColor = '#0f172a';
            
            // Remove any light mode classes
            document.documentElement.classList.remove('light');
            document.body.classList.remove('light', 'bg-white');
            
            // Set theme in localStorage
            localStorage.setItem('theme', 'dark');
            
            // Add meta tag for color scheme
            if (!document.querySelector('meta[name="color-scheme"]')) {
                const metaTheme = document.createElement('meta');
                metaTheme.name = 'color-scheme';
                metaTheme.content = 'dark';
                document.head.appendChild(metaTheme);
            }
        });
    </script>
</x-layouts.app>