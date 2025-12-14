<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 p-6">
        <div class="max-w-7xl mx-auto">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">
                    <i class="fas fa-chart-line text-blue-400 mr-3"></i>
                    Manager Dashboard
                </h1>
                <p class="text-gray-400">Selamat datang, <span class="text-white">{{ auth()->user()->name }}</span> - Monitoring & Reporting Overview</p>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @php
                    $totalAssessments = \App\Models\Assessment::count();
                    $completedAssessments = \App\Models\Assessment::whereHas('topsisResults')->count();
                    $totalSuppliers = \App\Models\Supplier::count();
                    $totalMaterials = \App\Models\Material::count();
                @endphp

                {{-- Total Assessments --}}
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-900/50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-blue-400 text-xl"></i>
                        </div>
                        <span class="text-xs bg-blue-900/30 text-blue-400 px-2 py-1 rounded">Total</span>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $totalAssessments }}</h3>
                    <p class="text-gray-400 text-sm">Total Assessments</p>
                </div>

                {{-- Completed --}}
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-900/50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-400 text-xl"></i>
                        </div>
                        <span class="text-xs bg-green-900/30 text-green-400 px-2 py-1 rounded">Selesai</span>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $completedAssessments }}</h3>
                    <p class="text-gray-400 text-sm">Completed</p>
                </div>

                {{-- Total Suppliers --}}
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-900/50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-purple-400 text-xl"></i>
                        </div>
                        <span class="text-xs bg-purple-900/30 text-purple-400 px-2 py-1 rounded">Active</span>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $totalSuppliers }}</h3>
                    <p class="text-gray-400 text-sm">Total Suppliers</p>
                </div>

                {{-- Total Materials --}}
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-900/50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cubes text-orange-400 text-xl"></i>
                        </div>
                        <span class="text-xs bg-orange-900/30 text-orange-400 px-2 py-1 rounded">Items</span>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $totalMaterials }}</h3>
                    <p class="text-gray-400 text-sm">Total Materials</p>
                </div>
            </div>

            {{-- Quick Access Reports --}}
            <div class="bg-gray-800 rounded-xl border border-gray-700 shadow-xl p-6 mb-8">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-download text-blue-400"></i>
                    Quick Access Reports
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('reports.assessments') }}" class="group bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg p-4 transition-all transform hover:scale-105">
                        <i class="fas fa-clipboard-list text-white text-3xl mb-3"></i>
                        <h3 class="text-white font-semibold">Assessment Reports</h3>
                        <p class="text-blue-100 text-xs mt-1">View all assessments</p>
                    </a>

                    <a href="{{ route('reports.suppliers') }}" class="group bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg p-4 transition-all transform hover:scale-105">
                        <i class="fas fa-building text-white text-3xl mb-3"></i>
                        <h3 class="text-white font-semibold">Supplier Reports</h3>
                        <p class="text-purple-100 text-xs mt-1">Supplier statistics</p>
                    </a>

                    <a href="{{ route('reports.kriteria') }}" class="group bg-gradient-to-br from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-lg p-4 transition-all transform hover:scale-105">
                        <i class="fas fa-list-check text-white text-3xl mb-3"></i>
                        <h3 class="text-white font-semibold">Kriteria Report</h3>
                        <p class="text-green-100 text-xs mt-1">Criteria details</p>
                    </a>

                    <a href="{{ route('reports.executive-summary') }}" class="group bg-gradient-to-br from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 rounded-lg p-4 transition-all transform hover:scale-105">
                        <i class="fas fa-chart-pie text-white text-3xl mb-3"></i>
                        <h3 class="text-white font-semibold">Executive Summary</h3>
                        <p class="text-orange-100 text-xs mt-1">Overview report</p>
                    </a>
                </div>
            </div>

            {{-- Recent Assessments --}}
            <div class="bg-gray-800 rounded-xl border border-gray-700 shadow-xl p-6">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-clock text-blue-400"></i>
                    Recent Assessments
                </h2>
                @php
                    $recentAssessments = \App\Models\Assessment::with(['material', 'topsisResults.supplier'])
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400">Material</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400">Tahun</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400">Winner</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @forelse($recentAssessments as $assessment)
                            <tr class="hover:bg-gray-700/50">
                                <td class="px-4 py-3 text-white">#{{ $assessment->id }}</td>
                                <td class="px-4 py-3 text-white">{{ $assessment->material->nama_material }}</td>
                                <td class="px-4 py-3 text-gray-400">{{ $assessment->tahun }}</td>
                                <td class="px-4 py-3">
                                    @if($assessment->topsisResults->count() > 0)
                                        <span class="px-2 py-1 text-xs rounded bg-green-900/30 text-green-400 border border-green-700/30">Completed</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-yellow-900/30 text-yellow-400 border border-yellow-700/30">Processing</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $winner = $assessment->topsisResults()->orderBy('rank')->first();
                                    @endphp
                                    @if($winner)
                                        <span class="text-white">{{ $winner->supplier->nama_supplier }}</span>
                                    @else
                                        <span class="text-gray-500 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-400 text-sm">
                                    {{ \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No recent assessments</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('assessments.index') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition">
                        <span>View All Assessments</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
