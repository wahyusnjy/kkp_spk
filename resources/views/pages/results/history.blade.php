<x-layouts.app :title="__('Hasil Assessment')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <x-title-header :title="__('Hasil Assessment')"  :base="__('Analysis Result')"/>
            <div class="flex items-center gap-4">
                <!-- Assessment Selection Dropdown -->
                <div class="relative">
                    <select id="assessmentSelect" class="bg-dark-400 border border-dark-200 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none pr-10">
                        <option value="">Pilih Assessment</option>
                        @foreach($assessments as $assessmentItem)
                            <option value="{{ $assessmentItem->id }}" {{ isset($assessment_id) && $assessment_id == $assessmentItem->id ? 'selected' : '' }}>
                                Assessment {{ $loop->iteration }} - {{  $assessmentItem->created_at ? \Carbon\Carbon::parse($assessmentItem->created_at)->format('d M Y'): '' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
        </div>

        @if($assessment && $results)
            <!-- Assessment Info -->
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-semibold text-white mb-2">Hasil Assessment</h2>
                        <p class="text-gray-400">Tanggal: {{ $assessment->created_at ? \Carbon\Carbon::parse($assessment->created_at)->format('d M Y, H:i') : '' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400">Total Supplier: {{ $results->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Results Table -->
            <div class="mt-4 bg-dark-300 rounded-xl border border-dark-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-dark-400 border-b border-dark-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Peringkat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Supplier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nilai Preferensi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-200">
                            @forelse($results as $result)
                                <tr class="hover:bg-dark-400 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white text-sm font-medium">
                                            {{ $result->rank }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">
                                        {{ $result->supplier->nama_supplier ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">
                                        {{ number_format($result->preference_score, 4) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-400">
                                        Tidak ada hasil untuk ditampilkan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center text-center py-12">
                <div class="w-24 h-24 rounded-full bg-dark-400 flex items-center justify-center mb-6">
                    <i class="fas fa-chart-bar text-3xl text-gray-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">
                    @if(isset($assessment_id))
                        Assessment Tidak Ditemukan
                    @else
                        Belum Ada Hasil Assessment
                    @endif
                </h3>
                <p class="text-gray-400 max-w-md mb-6">
                    @if(isset($assessment_id))
                        Assessment dengan ID {{ $assessment_id }} tidak ditemukan. Silakan pilih assessment lain.
                    @else
                        Pilih assessment dari dropdown di atas untuk melihat hasil perankingan supplier.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-dark-300 rounded-xl p-6 flex flex-col items-center">
            <i class="fas fa-spinner fa-spin text-3xl text-blue-500 mb-4"></i>
            <p class="text-white">Memuat hasil assessments...</p>
        </div>
    </div>
</x-layouts.app>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const assessmentSelect = document.getElementById('assessmentSelect');
        const loadingSpinner = document.getElementById('loadingSpinner');
        
        assessmentSelect.addEventListener('change', function() {
            if (this.value) {
                // Show loading spinner
                loadingSpinner.classList.remove('hidden');
                
                // Redirect to the selected assessment
                window.location.href = "{{ route('results.history') }}" + "/" + this.value;
            } else {
                // Redirect to base history page if no assessment selected
                window.location.href = "{{ route('results.history') }}";
            }
        });
        
        // Hide loading spinner if page is fully loaded
        window.addEventListener('load', function() {
            loadingSpinner.classList.add('hidden');
        });
    });
</script>