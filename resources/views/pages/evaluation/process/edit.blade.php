<x-layouts.app :title="__('Input Nilai Assessment')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Input Nilai Assessment</h1>
                <p class="text-gray-400 mt-1">Assessment #{{ $assessment->id }} - {{ $assessment->material->nama_material ?? 'N/A' }}</p>
                <div class="flex items-center gap-3 mt-2">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                        <span class="text-sm text-gray-300">Supplier: {{ $assessment->supplier->nama_supplier ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                        <span class="text-sm text-gray-300">Tahun: {{ $assessment->tahun }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('assessments.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('assessments.edit', $assessment->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    <span>Edit Assessment</span>
                </a>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
            <div class="flex items-center justify-between max-w-3xl mx-auto">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <span class="text-white text-sm font-medium">Detail Assessment</span>
                </div>
                <div class="flex-1 h-2 bg-green-600 mx-4"></div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-star text-white"></i>
                    </div>
                    <span class="text-white text-sm font-medium">Input Nilai</span>
                </div>
                <div class="flex-1 h-2 bg-dark-200 mx-4"></div>
                <div class="flex flex-col items-center opacity-50">
                    <div class="w-12 h-12 bg-dark-400 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-calculator text-gray-400"></i>
                    </div>
                    <span class="text-gray-400 text-sm">Hasil TOPSIS</span>
                </div>
            </div>
        </div>

        <!-- Score Form -->
        <div class="bg-dark-300 rounded-xl border border-dark-200 overflow-hidden">
            <form action="{{ route('assessments.scores.save', $assessment->id) }}" method="POST" id="scoreForm">
                @csrf
                
                <div class="p-6">
                    <!-- Instructions -->
                    <div class="mb-6 p-4 bg-blue-600/10 border border-blue-600/30 rounded-lg">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium mb-2">Petunjuk Pengisian</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-300">
                                    <div>
                                        <p class="font-medium text-white mb-1">Skala Penilaian:</p>
                                        <ul class="space-y-1">
                                            <li>• 1 = Sangat Buruk / Tidak Memenuhi</li>
                                            <li>• 2 = Buruk / Kurang Memenuhi</li>
                                            <li>• 3 = Cukup / Memenuhi Standar Minimum</li>
                                            <li>• 4 = Baik / Melebihi Standar</li>
                                            <li>• 5 = Sangat Baik / Sangat Melebihi Standar</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <p class="font-medium text-white mb-1">Jenis Kriteria:</p>
                                        <ul class="space-y-1">
                                            <li><span class="text-green-400">Benefit</span>: Semakin tinggi semakin baik</li>
                                            <li><span class="text-red-400">Cost</span>: Semakin rendah semakin baik</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Scores Warning -->
                    @if($existingScores->count() > 0)
                        <div class="mb-6 p-4 bg-yellow-600/10 border border-yellow-600/30 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                <span class="text-yellow-300">Nilai sudah pernah diinput. Input baru akan menggantikan nilai yang ada.</span>
                            </div>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-600/20 border border-red-600 rounded-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                                <h3 class="text-white font-semibold">Terjadi Kesalahan</h3>
                            </div>
                            <ul class="text-red-300 text-sm list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-600/20 border border-green-600 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-400"></i>
                                <span class="text-green-300">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Criteria Scores -->
                    <div class="space-y-4">
                        @foreach($kriterias as $kriteria)
                            @php
                                $existingScore = $existingScores->where('kriteria_id', $kriteria->id)->first();
                                $currentValue = $existingScore ? $existingScore->nilai : old('scores.' . $kriteria->id, '');
                            @endphp
                            
                            <div class="bg-dark-400 border border-dark-200 rounded-lg p-4 hover:border-blue-500/50 transition" 
                                 data-criteria-type="{{ $kriteria->jenis }}">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-white font-semibold">{{ $kriteria->nama_kriteria }}</h3>
                                            <span class="text-xs px-2 py-1 rounded-full {{ $kriteria->jenis == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                                                {{ strtoupper($kriteria->jenis) }}
                                            </span>
                                            @if($kriteria->bobot)
                                                <span class="text-xs px-2 py-1 bg-blue-600/20 text-blue-400 rounded-full">
                                                    Bobot: {{ $kriteria->bobot }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($kriteria->deskripsi)
                                            <p class="text-gray-400 text-sm">{{ $kriteria->deskripsi }}</p>
                                        @endif
                                    </div>
                                    @if($existingScore)
                                        <div class="text-sm text-yellow-400 flex items-center gap-1">
                                            <i class="fas fa-history"></i>
                                            <span>Nilai tersimpan: {{ $existingScore->nilai }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Score Input -->
                                <div class="space-y-3">
                                    <label class="block text-gray-300">
                                        Beri nilai dari 1-5:
                                        <span class="text-xs text-gray-400 ml-2">({{ $kriteria->jenis == 'benefit' ? 'Semakin tinggi semakin baik' : 'Semakin rendah semakin baik' }})</span>
                                    </label>
                                    
                                    <!-- Number Input -->
                                    <input type="number" 
                                           name="scores[{{ $kriteria->id }}]"
                                           min="1"
                                           max="5"
                                           step="0.01"
                                           value="{{ $currentValue }}"
                                           required
                                           class="score-input w-32 bg-dark-300 border border-dark-200 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="1-5"
                                           data-kriteria-id="{{ $kriteria->id }}">
                                    
                                    <!-- Rating Stars -->
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" 
                                                    class="star-rating w-10 h-10 rounded-lg flex items-center justify-center transition {{ $currentValue >= $i ? 'bg-yellow-600/20 text-yellow-400' : 'bg-dark-200 text-gray-500 hover:bg-dark-100' }}"
                                                    data-value="{{ $i }}"
                                                    data-for="{{ $kriteria->id }}"
                                                    onclick="setRating({{ $i }}, {{ $kriteria->id }})">
                                                {{ $i }}
                                            </button>
                                        @endfor
                                        <span class="ml-3 text-sm text-gray-400">Klik angka untuk memilih</span>
                                    </div>

                                    <!-- Score Indicators -->
                                    <div class="flex justify-between text-xs text-gray-400 pt-2 border-t border-dark-200">
                                        <span>1 = Sangat Buruk</span>
                                        <span>2 = Buruk</span>
                                        <span>3 = Cukup</span>
                                        <span>4 = Baik</span>
                                        <span>5 = Sangat Baik</span>
                                    </div>
                                </div>

                                <!-- Keterangan Input -->
                                <div class="mt-4">
                                    <label class="block text-gray-300 text-sm mb-2">Keterangan (Opsional):</label>
                                    <textarea name="keterangan[{{ $kriteria->id }}]"
                                              rows="2"
                                              class="w-full bg-dark-300 border border-dark-200 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                              placeholder="Tambahkan catatan untuk nilai ini">{{ $existingScore ? $existingScore->keterangan : old('keterangan.' . $kriteria->id) }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-dark-200">
                        <div class="text-gray-400 text-sm">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Pastikan semua nilai telah diisi sebelum menyimpan
                        </div>
                        <div class="flex gap-3">
                            <button type="button" 
                                    onclick="resetForm()"
                                    class="px-6 py-3 text-gray-300 hover:text-white transition rounded-lg border border-dark-200 hover:bg-dark-400 flex items-center gap-2">
                                <i class="fas fa-redo"></i>
                                <span>Reset</span>
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center gap-2">
                                <i class="fas fa-save"></i>
                                <span>Simpan Nilai</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calculator text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Proses TOPSIS</p>
                        <p class="text-gray-400 text-sm">Hitung rank supplier</p>
                    </div>
                    @if($existingScores->count() == $kriterias->count())
                        <a href="{{ route('assessments.calculate', $assessment->id) }}"
                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition text-sm flex items-center gap-2">
                            <i class="fas fa-play"></i>
                            <span>Proses</span>
                        </a>
                    @else
                        <button disabled
                                class="bg-gray-700 text-gray-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 cursor-not-allowed"
                                title="Isi semua nilai terlebih dahulu">
                            <i class="fas fa-lock"></i>
                            <span>Terkunci</span>
                        </button>
                    @endif
                </div>
            </div>
            
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Riwayat Nilai</p>
                        <p class="text-gray-400 text-sm">{{ $existingScores->count() }}/{{ $kriterias->count() }} kriteria terisi</p>
                    </div>
                    @if($existingScores->count() > 0)
                        <button onclick="showHistory()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm flex items-center gap-2">
                            <i class="fas fa-eye"></i>
                            <span>Lihat</span>
                        </button>
                    @endif
                </div>
            </div>
            
            <div class="bg-dark-300 rounded-xl border border-dark-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Progress</p>
                        <div class="w-full bg-dark-400 rounded-full h-2 mt-2">
                            <div class="bg-yellow-600 h-2 rounded-full" 
                                 style="width: {{ $kriterias->count() > 0 ? ($existingScores->count() / $kriterias->count()) * 100 : 0 }}%"></div>
                        </div>
                        <p class="text-gray-400 text-sm mt-1">{{ $existingScores->count() }}/{{ $kriterias->count() }} kriteria</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-dark-300 rounded-xl border border-dark-200 w-full max-w-2xl mx-4 max-h-[80vh] overflow-hidden">
            <div class="p-6 border-b border-dark-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Riwayat Nilai</h3>
                        <p class="text-gray-400 text-sm">Assessment #{{ $assessment->id }}</p>
                    </div>
                    <button onclick="closeHistoryModal()" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div class="space-y-4">
                    @foreach($existingScores as $score)
                        <div class="bg-dark-400 border border-dark-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-white font-medium">{{ $score->kriteria->nama_kriteria ?? 'N/A' }}</h4>
                                <span class="text-lg font-bold text-yellow-400">{{ $score->nilai }}</span>
                            </div>
                            <div class="text-sm text-gray-400 mb-2">
                                <span class="{{ $score->kriteria->jenis == 'benefit' ? 'text-green-400' : 'text-red-400' }}">
                                    {{ strtoupper($score->kriteria->jenis ?? '') }}
                                </span>
                                • Diperbarui: {{ $score->updated_at->format('d M Y H:i') }}
                            </div>
                            @if($score->keterangan)
                                <p class="text-gray-300 text-sm italic">"{{ $score->keterangan }}"</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all score inputs
            const scoreInputs = document.querySelectorAll('.score-input');
            scoreInputs.forEach(input => {
                updateRatingDisplay(input.value, input.dataset.kriteriaId);
            });

            // Validate form before submit
            const form = document.getElementById('scoreForm');
            form.addEventListener('submit', function(e) {
                const emptyInputs = [];
                scoreInputs.forEach(input => {
                    if (!input.value || input.value < 1 || input.value > 5) {
                        emptyInputs.push(input);
                        input.classList.add('border-red-500');
                    }
                });

                if (emptyInputs.length > 0) {
                    e.preventDefault();
                    showError('Harap isi semua nilai dengan angka antara 1-5');
                    
                    // Scroll to first empty input
                    emptyInputs[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });

            // Real-time validation
            scoreInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const value = parseFloat(this.value);
                    if (value >= 1 && value <= 5) {
                        this.classList.remove('border-red-500');
                        updateRatingDisplay(value, this.dataset.kriteriaId);
                        hideError();
                    } else if (this.value) {
                        this.classList.add('border-red-500');
                    }
                });
            });
        });

        function setRating(value, kriteriaId) {
            const input = document.querySelector(`input[data-kriteria-id="${kriteriaId}"]`);
            if (input) {
                input.value = value;
                updateRatingDisplay(value, kriteriaId);
                input.classList.remove('border-red-500');
                hideError();
            }
        }

        function updateRatingDisplay(value, kriteriaId) {
            const stars = document.querySelectorAll(`button[data-for="${kriteriaId}"]`);
            stars.forEach(star => {
                const starValue = parseInt(star.dataset.value);
                if (starValue <= value) {
                    star.classList.remove('bg-dark-200', 'text-gray-500');
                    star.classList.add('bg-yellow-600/20', 'text-yellow-400');
                } else {
                    star.classList.remove('bg-yellow-600/20', 'text-yellow-400');
                    star.classList.add('bg-dark-200', 'text-gray-500');
                }
            });
        }

        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mereset semua nilai? Tindakan ini tidak dapat dibatalkan.')) {
                document.querySelectorAll('.score-input').forEach(input => {
                    input.value = '';
                });
                document.querySelectorAll('.star-rating').forEach(star => {}