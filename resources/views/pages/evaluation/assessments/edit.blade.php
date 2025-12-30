<x-layouts.app :title="__('Edit Assessment')">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <style>
        /* Select2 Dark Mode Styling */
        .select2-container--bootstrap-5 .select2-selection {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #ffffff !important;
            min-height: 48px;
        }
        
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            color: #ffffff !important;
            line-height: 48px;
            padding-left: 12px;
        }
        
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        
        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        
        .select2-dropdown {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .select2-container--bootstrap-5 .select2-dropdown .select2-search__field {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #ffffff !important;
        }
        
        .select2-container--bootstrap-5 .select2-results__option {
            color: #d1d5db !important;
            padding: 8px 12px;
        }
        
        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        
        .select2-container--bootstrap-5 .select2-results__option--selected {
            background-color: #374151 !important;
        }
        
        .select2-container--bootstrap-5 .select2-results__option--disabled {
            color: #6b7280 !important;
            background-color: #1f2937 !important;
        }
        
        .select2-container--bootstrap-5 .select2-selection__placeholder {
            color: #9ca3af !important;
        }
    </style>
    
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Edit Assessment #{{ $assessment->id }}</h1>
                <p class="text-gray-400 mt-1">Ubah penilaian supplier</p>
            </div>
            <a href="{{ route('assessments.show', $assessment->id) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Detail</span>
            </a>
        </div>

        <!-- Form Section -->
        <div class="bg-dark-300 rounded-xl border border-dark-200 overflow-hidden">
            <form action="{{ route('assessments.update', $assessment->id) }}" method="POST" id="assessmentForm">
            @csrf
                <!-- Progress Steps -->
                <div class="px-6 py-4 border-b border-dark-200">
                    <div class="flex items-center justify-between max-w-2xl mx-auto">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-clipboard text-white"></i>
                            </div>
                            <span class="text-white text-sm font-medium">Detail Assessment</span>
                        </div>
                        <div class="flex-1 h-1 bg-blue-600 mx-4"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-star text-white"></i>
                            </div>
                            <span class="text-white text-sm font-medium">Input Nilai Supplier</span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
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

                    <!-- Warning Card jika sudah ada TOPSIS -->
                    @if($assessment->topsisResults->count() > 0)
                    <div class="mb-6 bg-yellow-600/10 border border-yellow-600/30 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-yellow-600 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-medium mb-2">Perhatian!</h4>
                                <p class="text-gray-300 text-sm">
                                    Assessment ini sudah memiliki hasil TOPSIS. 
                                    Jika Anda mengubah nilai supplier, hasil TOPSIS sebelumnya akan dihapus 
                                    dan perlu dihitung ulang.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Information Card -->
                    <div class="mb-6 bg-blue-600/10 border border-blue-600/30 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-medium mb-2">Informasi Penting</h4>
                                <p class="text-gray-300 text-sm">
                                    Anda dapat mengubah informasi assessment dan nilai supplier.
                                    Pastikan semua data sudah benar sebelum menyimpan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Assessment Details -->
                    <div id="step1" class="space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column - Basic Information -->
                            <div class="space-y-6">
                                <!-- Material Selection -->
                                <div class="space-y-3">
                                    <label class="block text-white font-medium">
                                        <i class="fas fa-cube mr-2 text-blue-400"></i>
                                        Material *
                                    </label>
                                    <select name="material_id" required
                                            class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="">Pilih Material</option>
                                        @foreach($materials as $material)
                                            <option value="{{ $material->id }}" {{ old('material_id', $assessment->material_id) == $material->id ? 'selected' : '' }}>
                                                {{ $material->nama_material }} 
                                                @if($material->kode_material)
                                                    ({{ $material->kode_material }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-gray-400 text-sm">Pilih material yang akan dinilai</p>
                                </div>

                                <!-- Year -->
                                <div class="space-y-3">
                                    <label class="block text-white font-medium">
                                        <i class="fas fa-calendar-alt mr-2 text-yellow-400"></i>
                                        Tahun Penilaian *
                                    </label>
                                    <input type="number" 
                                           name="tahun" 
                                           min="2000" 
                                           max="{{ date('Y') + 1 }}" 
                                           value="{{ old('tahun', $assessment->tahun) }}" 
                                           required
                                           class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <p class="text-gray-400 text-sm">Tahun penilaian assessment (maks: {{ date('Y') + 1 }})</p>
                                </div>
                            </div>

                            <!-- Right Column - Additional Information -->
                            <div class="space-y-6">
                                <!-- Deskripsi -->
                                <div class="space-y-3">
                                    <label class="block text-white font-medium">
                                        <i class="fas fa-align-left mr-2 text-green-400"></i>
                                        Deskripsi (Opsional)
                                    </label>
                                    <textarea name="deskripsi" 
                                              rows="4"
                                              class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                              placeholder="Masukkan deskripsi assessment...">{{ old('deskripsi', $assessment->deskripsi) }}</textarea>
                                    <p class="text-gray-400 text-sm">Deskripsi atau catatan tentang assessment ini</p>
                                </div>

                                <!-- Status Info -->
                                <div class="space-y-3">
                                    <label class="block text-white font-medium">
                                        <i class="fas fa-info-circle mr-2 text-cyan-400"></i>
                                        Status Assessment
                                    </label>
                                    <div class="bg-dark-400 rounded-lg p-4">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $status = $assessment->topsisResults->count() > 0 ? 'completed' : 
                                                         ($assessment->scores->count() > 0 ? 'input' : 'draft');
                                                $statusConfig = [
                                                    'draft' => ['color' => 'bg-gray-600', 'icon' => 'fa-edit', 'text' => 'Draft'],
                                                    'input' => ['color' => 'bg-yellow-600', 'icon' => 'fa-star', 'text' => 'Input Nilai'],
                                                    'completed' => ['color' => 'bg-green-600', 'icon' => 'fa-check-circle', 'text' => 'TOPSIS Selesai']
                                                ];
                                                $config = $statusConfig[$status];
                                            @endphp
                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg {{ $config['color'] }} text-white">
                                                <i class="fas {{ $config['icon'] }}"></i>
                                                <span class="font-medium">{{ $config['text'] }}</span>
                                            </span>
                                            <span class="text-gray-400 text-sm">
                                                {{ $assessment->scores->count() }} supplier, 
                                                {{ $assessment->scores->groupBy('kriteria_id')->count() }} kriteria
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-end mt-8 pt-6 border-t border-dark-200">
                            <button type="button" 
                                    onclick="nextStep()"
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                                <span>Lanjutkan ke Input Nilai</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Supplier Scores -->
                    <div id="step2" class="space-y-6 hidden">
                        <!-- Supplier Selection -->
                        <div class="space-y-3">
                            <label class="block text-white font-medium">
                                <i class="fas fa-truck mr-2 text-green-400"></i>
                                Pilih Supplier *
                            </label>
                            <div class="bg-dark-400 border border-dark-200 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h4 class="text-white font-medium">Supplier yang Dinilai</h4>
                                        <p class="text-gray-400 text-sm">Pilih supplier dan input nilai untuk setiap kriteria</p>
                                    </div>
                                    <button type="button" 
                                            onclick="addSupplier()"
                                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        <span>Tambah Supplier</span>
                                    </button>
                                </div>

                                <!-- Supplier Container -->
                                <div id="supplierContainer" class="space-y-4">
                                    @php
                                        $supplierIndex = 0;
                                        $existingSupplierIds = $supplierIds ?? [];
                                    @endphp
                                    
                                    @if(count($existingScores) > 0)
                                        @foreach($existingScores as $supplierId => $supplierData)
                                            <div class="supplier-card p-4 bg-dark-300 rounded-lg border border-dark-200">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h5 class="text-white font-medium">Supplier {{ $loop->iteration }}</h5>
                                                    <button type="button" 
                                                            onclick="removeSupplier(this)"
                                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm">
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </div>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label class="block text-gray-300 text-sm mb-2">Supplier *</label>
                                                        <select name="scores[{{ $supplierIndex }}][supplier_id]" required
                                                                class="supplier-select w-full bg-dark-500 border border-dark-200 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                                            <option value="">Pilih Supplier</option>
                                                            @foreach($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}" {{ $supplierId == $supplier->id ? 'selected' : '' }}>
                                                                    {{ $supplier->nama_supplier }}
                                                                    @if($supplier->kode_supplier)
                                                                        ({{ $supplier->kode_supplier }})
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Kriteria Scores -->
                                                <div class="space-y-3">
                                                    <label class="block text-gray-300 text-sm font-medium">Input Nilai Kriteria (0-100)</label>
                                                    <div class="bg-dark-500 rounded-lg p-3">
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto pr-2">
                                                            @foreach($kriterias as $kriteria)
                                                            <div class="space-y-2">
                                                                <div class="flex justify-between items-center">
                                                                    <label class="text-gray-300 text-sm">
                                                                        {{ $kriteria->nama_kriteria }}
                                                                        <span class="text-xs px-2 py-1 ml-2 rounded {{ $kriteria->jenis == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                                                                            {{ $kriteria->jenis == 'benefit' ? 'B' : 'C' }}
                                                                        </span>
                                                                    </label>
                                                                    <span class="text-gray-400 text-xs">Bobot: {{ $kriteria->bobot }}</span>
                                                                </div>
                                                                <div class="flex items-center gap-2">
                                                                    <input type="number" 
                                                                           name="scores[{{ $supplierIndex }}][scores][{{ $kriteria->id }}]"
                                                                           min="0"
                                                                           max="100"
                                                                           step="0.1"
                                                                           value="{{ $supplierData['scores'][$kriteria->id] ?? 0 }}"
                                                                           required
                                                                           class="score-input w-full bg-dark-600 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                                                           placeholder="0-100"
                                                                           data-kriteria-id="{{ $kriteria->id }}">
                                                                    <span class="text-gray-400 text-sm w-10">/100</span>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php $supplierIndex++; @endphp
                                        @endforeach
                                    @else
                                        <!-- Template awal jika tidak ada data -->
                                        <div class="supplier-card p-4 bg-dark-300 rounded-lg border border-dark-200">
                                            <div class="flex justify-between items-center mb-4">
                                                <h5 class="text-white font-medium">Supplier 1</h5>
                                                <button type="button" 
                                                        onclick="removeSupplier(this)"
                                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm">
                                                    <i class="fas fa-trash"></i>
                                                    Hapus
                                                </button>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label class="block text-gray-300 text-sm mb-2">Supplier *</label>
                                                    <select name="scores[0][supplier_id]" required
                                                            class="supplier-select w-full bg-dark-500 border border-dark-200 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                                        <option value="">Pilih Supplier</option>
                                                        @foreach($suppliers as $supplier)
                                                            <option value="{{ $supplier->id }}">
                                                                {{ $supplier->nama_supplier }}
                                                                @if($supplier->kode_supplier)
                                                                    ({{ $supplier->kode_supplier }})
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Kriteria Scores -->
                                            <div class="space-y-3">
                                                <label class="block text-gray-300 text-sm font-medium">Input Nilai Kriteria (0-100)</label>
                                                <div class="bg-dark-500 rounded-lg p-3">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto pr-2">
                                                        @foreach($kriterias as $index => $kriteria)
                                                        <div class="space-y-2">
                                                            <div class="flex justify-between items-center">
                                                                <label class="text-gray-300 text-sm">
                                                                    {{ $kriteria->nama_kriteria }}
                                                                    <span class="text-xs px-2 py-1 ml-2 rounded {{ $kriteria->jenis == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                                                                        {{ $kriteria->jenis == 'benefit' ? 'B' : 'C' }}
                                                                    </span>
                                                                </label>
                                                                <span class="text-gray-400 text-xs">Bobot: {{ $kriteria->bobot }}</span>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <input type="number" 
                                                                       name="scores[0][scores][{{ $kriteria->id }}]"
                                                                       min="0"
                                                                       max="100"
                                                                       step="0.1"
                                                                       value="0"
                                                                       required
                                                                       class="score-input w-full bg-dark-600 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                                                       placeholder="0-100"
                                                                       data-kriteria-id="{{ $kriteria->id }}">
                                                                <span class="text-gray-400 text-sm w-10">/100</span>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-4 text-xs text-gray-400">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Minimal 1 supplier harus dipilih. Nilai harus antara 0-100.
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between mt-8 pt-6 border-t border-dark-200">
                            <button type="button" 
                                    onclick="prevStep()"
                                    class="px-6 py-3 text-gray-300 hover:text-white transition rounded-lg border border-dark-200 hover:bg-dark-400 flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali</span>
                            </button>
                            <div class="flex gap-3">
                                <button type="button" 
                                        onclick="saveAsDraft()"
                                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition flex items-center gap-2">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan sebagai Draft</span>
                                </button>
                                <button type="submit" 
                                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                                    <i class="fas fa-check"></i>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden input for draft status -->
                    <input type="hidden" name="is_draft" id="isDraft" value="0">
                    
                    <!-- Hidden input untuk melacak supplier yang dihapus -->
                    <input type="hidden" name="deleted_suppliers" id="deletedSuppliers" value="">
                </div>
            </form>
        </div>

        <!-- Tips Card -->
        <div class="bg-green-600/10 border border-green-600/30 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                    <i class="fas fa-lightbulb text-white"></i>
                </div>
                <div>
                    <h4 class="text-white font-medium mb-2">Tips Pengisian Nilai</h4>
                    <ul class="text-gray-300 text-sm space-y-1">
                        <li>• <span class="text-green-400">Benefit (B):</span> Semakin tinggi nilai semakin baik</li>
                        <li>• <span class="text-red-400">Cost (C):</span> Semakin rendah nilai semakin baik</li>
                        <li>• Anda dapat menambah atau menghapus supplier</li>
                        <li>• Pastikan semua nilai telah diisi sebelum menyimpan</li>
                        <li>• Simpan sebagai Draft untuk melanjutkan nanti</li>
                        @if($assessment->topsisResults->count() > 0)
                        <li class="text-yellow-400">• Perubahan nilai akan menghapus hasil TOPSIS sebelumnya</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        let supplierCounter = {{ count($existingScores) > 0 ? count($existingScores) : 1 }};
        const kriteriaData = @json($kriterias);
        let deletedSupplierIds = [];

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-fill current year jika kosong
            const yearInput = document.querySelector('input[name="tahun"]');
            if (yearInput && !yearInput.value) {
                yearInput.value = new Date().getFullYear();
            }

            // Initialize validation
            initializeValidation();
            
            // Set supplier counter berdasarkan jumlah supplier yang ada
            const supplierCards = document.querySelectorAll('.supplier-card');
            supplierCounter = supplierCards.length;
            
            // Update nomor supplier
            updateSupplierNumbers();
        });

        function nextStep() {
            // Validate step 1
            const step1Inputs = document.querySelectorAll('#step1 [required]');
            let isValid = true;
            
            step1Inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                showAlert('Harap isi semua field yang wajib diisi', 'error');
                return;
            }

            // Move to step 2
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            
            // Update progress bar
            document.querySelectorAll('.flex-1.h-1').forEach(el => {
                el.classList.add('bg-blue-600');
            });
        }

        function prevStep() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
        }

        function addSupplier() {
            const container = document.getElementById('supplierContainer');
            const newIndex = supplierCounter;
            
            // Create supplier card HTML
            const supplierCard = document.createElement('div');
            supplierCard.className = 'supplier-card p-4 bg-dark-300 rounded-lg border border-dark-200';
            supplierCard.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-white font-medium">Supplier ${newIndex + 1}</h5>
                    <button type="button" 
                            onclick="removeSupplier(this)"
                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-300 text-sm mb-2">Supplier *</label>
                        <select name="scores[${newIndex}][supplier_id]" required
                                class="supplier-select w-full bg-dark-500 border border-dark-200 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Pilih Supplier</option>
                            ${getSupplierOptions()}
                        </select>
                    </div>
                </div>

                <!-- Kriteria Scores -->
                <div class="space-y-3">
                    <label class="block text-gray-300 text-sm font-medium">Input Nilai Kriteria (0-100)</label>
                    <div class="bg-dark-500 rounded-lg p-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto pr-2">
                            ${getKriteriaInputs(newIndex)}
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(supplierCard);
            supplierCounter++;
            
            // Initialize validation for new inputs
            initializeValidationForElement(supplierCard);
            
            // Initialize Select2 for the new supplier select
            const newSelect = supplierCard.querySelector('.supplier-select');
            $(newSelect).select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Supplier',
                allowClear: true,
                width: '100%'
            });
            
            // Add change event listener
            $(newSelect).on('change', function() {
                updateSupplierOptions();
            });
            
            // Update all supplier options
            updateSupplierOptions();
        }

        function removeSupplier(button) {
            const card = button.closest('.supplier-card');
            const select = card.querySelector('.supplier-select');
            const supplierId = select ? select.value : null;
            
            // Jika ada supplier ID (supplier yang sudah ada sebelumnya)
            if (supplierId && supplierId !== "") {
                // Tambahkan ke daftar deleted suppliers
                if (!deletedSupplierIds.includes(supplierId)) {
                    deletedSupplierIds.push(supplierId);
                    document.getElementById('deletedSuppliers').value = JSON.stringify(deletedSupplierIds);
                }
            }
            
            if (document.querySelectorAll('.supplier-card').length > 1) {
                // Destroy Select2 before removing
                if ($(select).data('select2')) {
                    $(select).select2('destroy');
                }
                
                card.remove();
                updateSupplierNumbers();
                
                // Update options after removal
                updateSupplierOptions();
            } else {
                showAlert('Minimal harus ada 1 supplier', 'warning');
            }
        }

        function updateSupplierNumbers() {
            const cards = document.querySelectorAll('.supplier-card');
            cards.forEach((card, index) => {
                card.querySelector('h5').textContent = `Supplier ${index + 1}`;
                
                // Update input names
                const inputs = card.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/\[\d+\]/, `[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
            supplierCounter = cards.length;
        }

        function getSupplierOptions() {
            return @json($suppliers).map(supplier => 
                `<option value="${supplier.id}">${supplier.nama_supplier}${supplier.kode_supplier ? ` (${supplier.kode_supplier})` : ''}</option>`
            ).join('');
        }

        function getKriteriaInputs(supplierIndex) {
            return kriteriaData.map(kriteria => `
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-gray-300 text-sm">
                            ${kriteria.nama_kriteria}
                            <span class="text-xs px-2 py-1 ml-2 rounded ${kriteria.jenis == 'benefit' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400'}">
                                ${kriteria.jenis == 'benefit' ? 'B' : 'C'}
                            </span>
                        </label>
                        <span class="text-gray-400 text-xs">Bobot: ${kriteria.bobot}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="number" 
                               name="scores[${supplierIndex}][scores][${kriteria.id}]"
                               min="0"
                               max="100"
                               step="0.1"
                               value="0"
                               required
                               class="score-input w-full bg-dark-600 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                               placeholder="0-100"
                               data-kriteria-id="${kriteria.id}">
                        <span class="text-gray-400 text-sm w-10">/100</span>
                    </div>
                </div>
            `).join('');
        }

        function saveAsDraft() {
            document.getElementById('isDraft').value = '1';
            document.getElementById('assessmentForm').submit();
        }

        function validateForm() {
            let isValid = true;
            
            // Reset all errors
            document.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
            
            // Validate step 1
            const step1Inputs = document.querySelectorAll('#step1 [required]');
            step1Inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    isValid = false;
                }
            });
            
            // Validate suppliers
            const supplierSelects = document.querySelectorAll('.supplier-select');
            supplierSelects.forEach(select => {
                if (!select.value) {
                    select.classList.add('border-red-500');
                    isValid = false;
                }
            });
            
            // Validate scores
            const scoreInputs = document.querySelectorAll('.score-input');
            scoreInputs.forEach(input => {
                const value = parseFloat(input.value);
                if (isNaN(value) || value < 0 || value > 100) {
                    input.classList.add('border-red-500');
                    isValid = false;
                }
            });
            
            return isValid;
        }

        function showAlert(message, type = 'error') {
            // Remove existing alerts
            const existingAlert = document.querySelector('.custom-alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            const alertDiv = document.createElement('div');
            alertDiv.className = `custom-alert mb-6 p-4 ${type === 'error' ? 'bg-red-600/20 border-red-600' : 'bg-yellow-600/20 border-yellow-600'} border rounded-lg`;
            alertDiv.innerHTML = `
                <div class="flex items-center gap-3">
                    <i class="fas ${type === 'error' ? 'fa-exclamation-circle text-red-400' : 'fa-exclamation-triangle text-yellow-400'}"></i>
                    <p class="${type === 'error' ? 'text-red-300' : 'text-yellow-300'} text-sm">${message}</p>
                </div>
            `;
            
            document.querySelector('.p-6').prepend(alertDiv);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        function initializeValidation() {
            const form = document.getElementById('assessmentForm');
            
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    showAlert('Harap isi semua field dengan benar. Periksa nilai yang berwarna merah.', 'error');
                }
            });
            
            // Real-time validation
            document.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                });
            });
        }

        function initializeValidationForElement(element) {
            element.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                });
            });
        }
        
        // Get selected supplier IDs
        function getSelectedSupplierIds() {
            const selectedIds = [];
            document.querySelectorAll('.supplier-select').forEach(select => {
                if (select.value) {
                    selectedIds.push(select.value);
                }
            });
            return selectedIds;
        }
        
        // Update supplier options to disable selected ones
        function updateSupplierOptions() {
            const selectedIds = getSelectedSupplierIds();
            
            document.querySelectorAll('.supplier-select').forEach(select => {
                const currentValue = select.value;
                
                // Destroy Select2 before updating options
                if ($(select).data('select2')) {
                    $(select).select2('destroy');
                }
                
                // Update options
                $(select).find('option').each(function() {
                    const optionValue = $(this).val();
                    if (optionValue && optionValue !== currentValue && selectedIds.includes(optionValue)) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                });
                
                // Reinitialize Select2
                $(select).select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Pilih Supplier',
                    allowClear: true,
                    width: '100%'
                });
            });
        }
        
        // Initialize Select2 for all supplier selects
        function initializeSelect2() {
            // Initialize Material Select  
            $('select[name="material_id"]').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Material',
                allowClear: true,
                width: '100%'
            });
            
            // Initialize all supplier selects
            $('.supplier-select').each(function() {
                $(this).select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Pilih Supplier',
                    allowClear: true,
                    width: '100%'
                });
                
                // Add change event listener
                $(this).on('change', function() {
                    updateSupplierOptions();
                });
            });
        }
    </script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 on page load
            initializeSelect2();
        });
    </script>

    <style>
        /* Custom scrollbar */
        .max-h-60::-webkit-scrollbar {
            width: 6px;
        }

        .max-h-60::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 3px;
        }

        .max-h-60::-webkit-scrollbar-thumb {
            background: #6B7280;
            border-radius: 3px;
        }

        .max-h-60::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }

        /* Smooth transitions */
        .transition {
            transition: all 0.2s ease-in-out;
        }

        /* Input focus effects */
        input:focus, select:focus, textarea:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .hidden {
            display: none !important;
        }
    </style>
</x-layouts.app>