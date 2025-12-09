<x-layouts.app :title="__('Edit Kriteria')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Edit Kriteria "{{ $criterion->nama_kriteria }}"</h1>
                <p class="text-gray-400 mt-1">Edit kriteria penilaian untuk sistem evaluasi supplier</p>
            </div>
            <a href="{{ route('kriteria.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>

        <!-- Form Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Container -->
            <div class="lg:col-span-2">
                <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus-circle text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Detail Kriteria</h3>
                            <p class="text-gray-400 text-sm">Isi form berikut untuk menambahkan kriteria baru</p>
                        </div>
                    </div>
                    
                    <form id="kriteriaFormCreate" method="POST" action="{{ route('kriteria.post',$criterion->id) }}">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Nama Kriteria -->
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="nama_kriteria" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-tag text-blue-400 text-xs"></i>
                                    Nama Kriteria *
                                </label>
                                <input type="text" id="nama_kriteria" name="nama_kriteria" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('nama_kriteria') border-red-500 @enderror"
                                    placeholder="Contoh: Kualitas Produk, Harga, Pengiriman"
                                    value="{{ $criterion->nama_kriteria }}">
                                @error('nama_kriteria')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="keterangan" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-align-left text-green-400 text-xs"></i>
                                    Deskripsi Kriteria
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="3"
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition resize-none"
                                        placeholder="Jelaskan detail kriteria penilaian...">{{ $criterion->keterangan }}</textarea>
                                <p class="text-gray-400 text-xs mt-2">Opsional: Tambahkan penjelasan untuk kriteria ini</p>
                            </div>

                            <!-- Bobot & Jenis dalam Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Bobot -->
                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="bobot" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-weight-hanging text-yellow-400 text-xs"></i>
                                        Bobot Kriteria *
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="bobot" name="bobot" step="0.1" min="0.1" max="5" required
                                            class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 pr-10 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('bobot') border-red-500 @enderror"
                                            placeholder="0.0 - 5.0"
                                            value="{{ number_format($criterion->bobot,2) }}">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-400 text-sm">/5.0</span>
                                        </div>
                                    </div>
                                    @error('bobot')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                    <div class="flex justify-between text-xs text-gray-400 mt-2">
                                        <span>Rendah</span>
                                        <span>Tinggi</span>
                                    </div>
                                </div>

                                <!-- Jenis Kriteria -->
                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="type" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-sliders-h text-purple-400 text-xs"></i>
                                        Jenis Kriteria *
                                    </label>
                                    <select id="type" name="type" required
                                            class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('type') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Kriteria</option>
                                        <option value="benefit" {{ $criterion->type == 'benefit' ? 'selected' : '' }}>Benefit (Semakin Besar Semakin Baik)</option>
                                        <option value="cost" {{ $criterion->type == 'cost' ? 'selected' : '' }}>Cost (Semakin Kecil Semakin Baik)</option>
                                    </select>
                                    @error('type')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Preview Card -->
                            <div class="bg-blue-600/10 border border-blue-500/20 rounded-lg p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-eye text-blue-400"></i>
                                    <span class="text-blue-400 font-medium">Preview Kriteria</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-400">Nama:</span>
                                        <span id="previewNama" class="text-white ml-2">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400">Bobot:</span>
                                        <span id="previewBobot" class="text-white ml-2">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400">Jenis:</span>
                                        <span id="previewJenis" class="text-white ml-2">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400">Deskripsi:</span>
                                        <span id="previewDeskripsi" class="text-white ml-2">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-dark-200">
                            <div class="text-gray-400 text-sm">
                                <i class="fas fa-info-circle mr-2"></i>
                                Field bertanda * wajib diisi
                            </div>
                            <div class="flex gap-3 w-full sm:w-auto">
                                <a href="{{ route('kriteria.index') }}" class="flex-1 sm:flex-none px-6 py-3 text-gray-300 hover:text-white transition rounded-lg border border-dark-200 hover:bg-dark-400 text-center">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </a>
                                <button type="submit" id="submitBtnCreate" class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition flex items-center justify-center gap-2 group">
                                    <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
                                    <span>Simpan Kriteria</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-dark-300 rounded-xl border border-dark-200 p-6 sticky top-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-400"></i>
                        Panduan Kriteria
                    </h4>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-600/10 rounded-lg p-3 border border-blue-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-weight-hanging text-blue-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Bobot Kriteria</span>
                            </div>
                            <p class="text-gray-400 text-xs">Nilai 0.1 - 5.0 yang menunjukkan tingkat pentingnya kriteria</p>
                        </div>

                        <div class="bg-green-600/10 rounded-lg p-3 border border-green-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-chart-line text-green-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Benefit</span>
                            </div>
                            <p class="text-gray-400 text-xs">Nilai semakin besar semakin baik (contoh: kualitas, layanan)</p>
                        </div>

                        <div class="bg-red-600/10 rounded-lg p-3 border border-red-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-chart-line text-red-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Cost</span>
                            </div>
                            <p class="text-gray-400 text-xs">Nilai semakin kecil semakin baik (contoh: harga, waktu pengiriman)</p>
                        </div>

                        <div class="bg-purple-600/10 rounded-lg p-3 border border-purple-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-lightbulb text-purple-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Tips</span>
                            </div>
                            <ul class="text-gray-400 text-xs space-y-1">
                                <li>• Gunakan nama yang jelas dan deskriptif</li>
                                <li>• Atur bobot sesuai prioritas bisnis</li>
                                <li>• Pilih jenis kriteria dengan tepat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('kriteriaFormCreate');
        const submitBtn = document.getElementById('submitBtnCreate');
        
        // Real-time preview
        const namaInput = document.getElementById('nama_kriteria');
        const bobotInput = document.getElementById('bobot');
        const jenisSelect = document.getElementById('type');
        const deskripsiTextarea = document.getElementById('keterangan');
        
        const previewNama = document.getElementById('previewNama');
        const previewBobot = document.getElementById('previewBobot');
        const previewJenis = document.getElementById('previewJenis');
        const previewDeskripsi = document.getElementById('previewDeskripsi');
        
        function updatePreview() {
            previewNama.textContent = namaInput.value || '-';
            previewBobot.textContent = bobotInput.value ? bobotInput.value + '/5.0' : '-';
            previewJenis.textContent = jenisSelect.value ? 
                (jenisSelect.value === 'benefit' ? 'Benefit' : 'Cost') : '-';
            previewDeskripsi.textContent = deskripsiTextarea.value || '-';
        }
        
        // Event listeners for real-time preview
        namaInput.addEventListener('input', updatePreview);
        bobotInput.addEventListener('input', updatePreview);
        jenisSelect.addEventListener('change', updatePreview);
        deskripsiTextarea.addEventListener('input', updatePreview);
        
        // Initial preview
        updatePreview();
        
        // Form submission with loading state
        form.addEventListener('submit', function(e) {
            // Add loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        });
        
        function showNotification(message, type = 'info') {
            // Simple notification implementation
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg border ${
                type === 'error' ? 'bg-red-600/90 border-red-500' : 'bg-blue-600/90 border-blue-500'
            } text-white z-50 max-w-sm`;
            notification.innerHTML = `
                <div class="flex items-center gap-3">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
        
        // Auto-format bobot input
        bobotInput.addEventListener('blur', function() {
            if (this.value) {
                let value = parseFloat(this.value);
                if (value < 0.1) value = 0.1;
                if (value > 5) value = 5;
                this.value = value.toFixed(1);
            }
        });
    });
</script>

<style>
    /* Custom styling for better form appearance */
    input:focus, select:focus, textarea:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }
    
    /* Smooth transitions for all interactive elements */
    .transition {
        transition: all 0.2s ease-in-out;
    }
    
    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #374151;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #6B7280;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #9CA3AF;
    }
</style>