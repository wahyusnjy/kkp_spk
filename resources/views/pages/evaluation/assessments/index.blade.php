<x-layouts.app :title="__('Assessments')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Assessments</h1>
                <p class="text-gray-400 mt-1">Kelola penilaian dan perbandingan multi-supplier</p>
            </div>
            <a href="{{ route('assessments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 group">
                <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform"></i>
                <span>Tambah Assessment</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600/20 p-3 rounded-lg">
                        <i class="fas fa-clipboard-list text-blue-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Assessments</p>
                        <p class="text-white font-semibold text-xl">{{ $assessments->total() ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-green-600/20 p-3 rounded-lg">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Selesai TOPSIS</p>
                        <p class="text-white font-semibold text-xl">{{ $completedAssessments ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-600/20 p-3 rounded-lg">
                        <i class="fas fa-spinner text-yellow-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Belum Diproses</p>
                        <p class="text-white font-semibold text-xl">{{ $pendingAssessments ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-600/20 p-3 rounded-lg">
                        <i class="fas fa-users text-purple-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Supplier</p>
                        <p class="text-white font-semibold text-xl">{{ $assessments->sum(function($assessment) { return $assessment->scores->count(); }) ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-cyan-600/20 p-3 rounded-lg">
                        <i class="fas fa-calculator text-cyan-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Nilai</p>
                        <p class="text-white font-semibold text-xl">{{ $assessments->sum('total_score') ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
            <div class="flex flex-wrap gap-3">
                <select id="statusFilter" class="bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="input">Input Nilai</option>
                    <option value="topsis">Proses TOPSIS</option>
                    <option value="completed">Selesai</option>
                </select>
                
                <select id="materialFilter" class="bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Material</option>
                    @foreach($materials ?? [] as $material)
                        <option value="{{ $material->id }}">{{ $material->nama_material }}</option>
                    @endforeach
                </select>
                
                <select id="yearFilter" class="bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Tahun</option>
                    @php
                        $years = $assessments->pluck('tahun')->unique()->sortDesc();
                    @endphp
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="relative w-full sm:w-64">
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari assessment..." 
                       class="w-full bg-dark-400 border border-dark-200 rounded-lg pl-10 pr-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-dark-300 rounded-xl border border-dark-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-400 border-b border-dark-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <span>Assessment</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">
                                Material & Tahun
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">
                                Jumlah Supplier
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-200" id="assessmentTable">
                        @forelse($assessments as $assessment)
                            <tr class="hover:bg-dark-400/50 transition group assessment-row"
                                data-status="{{ $assessment->topsisResults->count() > 0 ? 'completed' : ($assessment->scores->count() > 0 ? 'input' : 'draft') }}"
                                data-material="{{ $assessment->material_id }}"
                                data-year="{{ $assessment->tahun }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                            {{ $assessment->topsisResults->count() > 0 ? 'bg-green-600' : 
                                               ($assessment->scores->count() > 0 ? 'bg-yellow-600' : 'bg-blue-600') }}">
                                            @if($assessment->topsisResults->count() > 0)
                                                <i class="fas fa-trophy text-white text-sm"></i>
                                            @elseif($assessment->scores->count() > 0)
                                                <i class="fas fa-spinner text-white text-sm"></i>
                                            @else
                                                <i class="fas fa-clipboard text-white text-sm"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-white font-semibold">Assessment #{{ $assessment->id }}</div>
                                            @if($assessment->deskripsi)
                                                <div class="text-gray-400 text-sm truncate max-w-xs">{{ Str::limit($assessment->deskripsi, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-white font-medium">{{ $assessment->material->nama_material ?? 'N/A' }}</div>
                                    <div class="text-gray-400 text-sm flex items-center gap-1">
                                        <i class="fas fa-calendar text-xs"></i>
                                        {{ $assessment->tahun }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-green-600/20 rounded-full flex items-center justify-center">
                                                <i class="fas fa-users text-green-400 text-xs"></i>
                                            </div>
                                            <div>
                                                <span class="text-white font-medium">{{ $assessment->scores->groupBy('supplier_id')->count() }}</span>
                                                <span class="text-gray-400 text-sm"> supplier</span>
                                            </div>
                                        </div>
                                        @if($assessment->topsisResults->count() > 0)
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 bg-purple-600/20 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-trophy text-purple-400 text-xs"></i>
                                                </div>
                                                <div>
                                                    <span class="text-white font-medium">#{{ $assessment->topsisResults->where('rank', 1)->first()->rank ?? '?' }}</span>
                                                    <span class="text-gray-400 text-sm"> rank</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $status = $assessment->topsisResults->count() > 0 ? 'completed' : 
                                                 ($assessment->scores->count() > 0 ? 'input' : 'draft');
                                        $statusConfig = [
                                            'draft' => [
                                                'color' => 'bg-gray-600 text-gray-100',
                                                'icon' => 'fa-edit',
                                                'text' => 'Draft',
                                                'description' => 'Belum ada nilai'
                                            ],
                                            'input' => [
                                                'color' => 'bg-yellow-600 text-yellow-100',
                                                'icon' => 'fa-star',
                                                'text' => 'Input Nilai',
                                                'description' => 'Sudah input nilai'
                                            ],
                                            'completed' => [
                                                'color' => 'bg-green-600 text-green-100',
                                                'icon' => 'fa-check-circle',
                                                'text' => 'Selesai',
                                                'description' => 'Hasil TOPSIS tersedia'
                                            ]
                                        ];
                                        $config = $statusConfig[$status];
                                    @endphp
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $config['color'] }} w-fit">
                                            <i class="fas {{ $config['icon'] }} text-xs"></i>
                                            {{ $config['text'] }}
                                        </span>
                                        <span class="text-gray-400 text-xs">{{ $config['description'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-white text-sm">{{ $assessment->created_at->format('d M Y') }}</div>
                                    <div class="text-gray-400 text-xs">{{ $assessment->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1 opacity-0 group-hover:opacity-100 transition">
                                        <!-- View Details Button -->
                                        <a href="{{ route('assessments.show', $assessment->id) }}" 
                                           class="bg-blue-600 hover:bg-blue-500 text-white p-2 rounded-lg transition tooltip"
                                           data-tooltip="Detail">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        
                                        @if($assessment->topsisResults->count() > 0)
                                            <!-- View TOPSIS Results Button -->
                                            <a href="{{ route('results.show', $assessment->id) }}" 
                                               class="bg-green-600 hover:bg-green-500 text-white p-2 rounded-lg transition tooltip"
                                               data-tooltip="Hasil TOPSIS">
                                                <i class="fas fa-chart-bar text-sm"></i>
                                            </a>
                                        @elseif($assessment->scores->count() > 0)
                                            <!-- Process TOPSIS Button -->
                                            <button class="calculate-topsis bg-purple-600 hover:bg-purple-500 text-white p-2 rounded-lg transition tooltip"
                                               data-tooltip="Proses TOPSIS" data-id="{{ $assessment->id }}">
                                                <i class="fas fa-calculator text-sm"></i>
                                            </button>
                                            
                                            <!-- Edit Scores Button -->
                                            <a href="#" 
                                               class="bg-yellow-600 hover:bg-yellow-500 text-white p-2 rounded-lg transition tooltip"
                                               data-tooltip="Edit Nilai">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                        @else
                                            <!-- Add Scores Button -->
                                            <a href="#" 
                                               class="bg-yellow-600 hover:bg-yellow-500 text-white p-2 rounded-lg transition tooltip"
                                               data-tooltip="Input Nilai">
                                                <i class="fas fa-plus text-sm"></i>
                                            </a>
                                        @endif
                                        
                                        <!-- Edit Assessment Button -->
                                        <a href="{{ route('assessments.edit', $assessment->id) }}" 
                                           class="bg-cyan-600 hover:bg-cyan-500 text-white p-2 rounded-lg transition tooltip"
                                           data-tooltip="Edit Assessment">
                                            <i class="fas fa-cog text-sm"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <button onclick="confirmDelete({{ $assessment->id }}, 'Assessment #{{ $assessment->id }}')"
                                                class="bg-red-600 hover:bg-red-500 text-white p-2 rounded-lg transition tooltip"
                                                data-tooltip="Hapus">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-clipboard-list text-4xl mb-4 text-gray-600"></i>
                                        <p class="text-lg font-medium text-white mb-2">Belum Ada Assessment</p>
                                        <p class="text-sm mb-4">Mulai dengan membuat assessment pertama Anda</p>
                                        <a href="{{ route('assessments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                                            <i class="fas fa-plus"></i>
                                            <span>Buat Assessment Pertama</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($assessments->hasPages())
                <div class="px-6 py-4 border-t border-dark-200">
                    {{ $assessments->links() }}
                </div>
            @endif
        </div>
        
        <!-- Information Card -->
        <div class="bg-blue-600/10 border border-blue-600/30 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                    <i class="fas fa-info-circle text-white"></i>
                </div>
                <div>
                    <h4 class="text-white font-medium mb-2">Informasi Assessment</h4>
                    <ul class="text-gray-300 text-sm space-y-1">
                        <li>• <span class="text-blue-400">Assessment</span> adalah proses penilaian untuk membandingkan beberapa supplier</li>
                        <li>• <span class="text-yellow-400">Draft</span>: Assessment dibuat, belum ada nilai</li>
                        <li>• <span class="text-yellow-400">Input Nilai</span>: Sudah input nilai, siap diproses TOPSIS</li>
                        <li>• <span class="text-green-400">Selesai</span>: Hasil TOPSIS sudah tersedia</li>
                        <li>• Sistem akan menentukan supplier terbaik berdasarkan perhitungan TOPSIS</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-dark-300 rounded-xl border border-dark-200 w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Konfirmasi Hapus</h3>
                        <p class="text-gray-400 text-sm" id="deleteMessage">Anda yakin ingin menghapus item ini?</p>
                    </div>
                </div>
                
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-gray-300 hover:text-white transition rounded-lg border border-dark-200 hover:bg-dark-400">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center gap-2">
                            <i class="fas fa-trash"></i>
                            <span>Hapus</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                
    <form id="topsisForm" method="POST" action="">
        @csrf
        
        <div class="flex justify-end space-x-3 mt-6">
        </div>
    </form>

    
</x-layouts.app>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const statusFilter = document.getElementById('statusFilter');
    const materialFilter = document.getElementById('materialFilter');
    const yearFilter = document.getElementById('yearFilter');
    const searchInput = document.getElementById('searchInput');
    const assessmentRows = document.querySelectorAll('.assessment-row');
    const calculateTopsisButtons = document.querySelectorAll('.calculate-topsis');
    // 2. Ambil form yang akan digunakan untuk submit
    const topsisForm = document.getElementById('topsisForm');

    // Pastikan form ditemukan
    if (topsisForm) {
        calculateTopsisButtons.forEach(button => {
            // Pasang listener pada *masing-masing* tombol
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Ambil ID dari tombol yang diklik
                const assessmentId = this.getAttribute('data-id'); 
                
                // Tentukan URL/Action yang benar menggunakan ID
                // Sesuaikan '/assessments/' dengan base URL yang Anda gunakan
                const url = `/assessments/${assessmentId}/calculate`;
                console.log(url);
                
                // 1. Set action form dengan URL yang telah disiapkan
                topsisForm.action = url;
                
                // 2. Submit form
                topsisForm.submit();
            });
        });
    } else {
        console.error('Form dengan ID "topsisForm" tidak ditemukan.');
    }

    function filterTable() {
        const statusValue = statusFilter.value;
        const materialValue = materialFilter.value;
        const yearValue = yearFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        assessmentRows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            const rowMaterial = row.getAttribute('data-material');
            const rowYear = row.getAttribute('data-year');
            const rowText = row.textContent.toLowerCase();

            const statusMatch = !statusValue || rowStatus === statusValue;
            const materialMatch = !materialValue || rowMaterial === materialValue;
            const yearMatch = !yearValue || rowYear === yearValue;
            const searchMatch = !searchValue || rowText.includes(searchValue);

            if (statusMatch && materialMatch && yearMatch && searchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Event listeners for filters
    [statusFilter, materialFilter, yearFilter, searchInput].forEach(filter => {
        filter.addEventListener('change', filterTable);
    });
    
    searchInput.addEventListener('input', filterTable);

    // Tooltip functionality
    const tooltips = document.querySelectorAll('.tooltip');
    tooltips.forEach(tooltip => {
        const text = tooltip.getAttribute('data-tooltip');
        tooltip.addEventListener('mouseenter', function(e) {
            const tooltipEl = document.createElement('div');
            tooltipEl.className = 'fixed bg-gray-900 text-white text-xs px-2 py-1 rounded-lg shadow-lg z-50';
            tooltipEl.textContent = text;
            tooltipEl.style.top = (e.clientY - 30) + 'px';
            tooltipEl.style.left = (e.clientX) + 'px';
            tooltipEl.id = 'current-tooltip';
            document.body.appendChild(tooltipEl);
        });
        
        tooltip.addEventListener('mouseleave', function() {
            const currentTooltip = document.getElementById('current-tooltip');
            if (currentTooltip) {
                currentTooltip.remove();
            }
        });
    });

    
});

function confirmDelete(id, name) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const message = document.getElementById('deleteMessage');
    
    message.textContent = `Anda yakin ingin menghapus "${name}"? Tindakan ini akan menghapus semua data terkait termasuk nilai dan hasil TOPSIS.`;
    form.action = `/assessments/delete/${id}`;
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});




</script>

<style>
.tooltip {
    position: relative;
}

.transition {
    transition: all 0.2s ease-in-out;
}

.group:hover .group-hover\:opacity-100 {
    opacity: 1;
}

.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #374151;
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #6B7280;
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #9CA3AF;
}

/* Status badge styles */
.bg-gray-600 { background-color: #4B5563; }
.bg-yellow-600 { background-color: #D97706; }
.bg-green-600 { background-color: #059669; }
.text-gray-100 { color: #F3F4F6; }
.text-yellow-100 { color: #FEF3C7; }
.text-green-100 { color: #D1FAE5; }
</style>