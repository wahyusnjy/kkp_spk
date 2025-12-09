<x-layouts.app :title="__('Tambah Supplier')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Tambah Supplier Baru</h1>
                <p class="text-gray-400 mt-1">Tambahkan data supplier baru ke sistem</p>
            </div>
            <a href="{{ route('supplier.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-truck text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Detail Supplier</h3>
                            <p class="text-gray-400 text-sm">Isi form berikut untuk menambahkan supplier baru</p>
                        </div>
                    </div>
                    {{-- Ganti rute ke supplier.store --}}
                    <form id="supplierFormCreate" method="POST" action="{{ route('supplier.store') }}">
                        @csrf
                        <div class="space-y-6">
                            
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="nama_supplier" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-building text-blue-400 text-xs"></i>
                                    Nama Supplier *
                                </label>
                                <input type="text" id="nama_supplier" name="nama_supplier" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('nama_supplier') border-red-500 @enderror"
                                    placeholder="Contoh: PT Baja Jaya Abadi"
                                    value="{{ old('nama_supplier') }}">
                                @error('nama_supplier')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="kode_supplier" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-hashtag text-yellow-400 text-xs"></i>
                                        Kode Supplier *
                                        <p class="text-xs text-gray-400">(Kode ini sudah otomatis terisi)</p>
                                    </label>
                                    <input type="text" id="kode_supplier" name="kode_supplier" readonly required
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('kode_supplier') border-red-500 @enderror"
                                        placeholder="Generate dari id + 1"
                                        value="{{ old('kode_supplier') ? old('kode_supplier') : 'SUP-' . $nextId }}">
                                    @error('kode_supplier')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="kontak" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-phone text-purple-400 text-xs"></i>
                                        Kontak (No. Telepon/HP)
                                    </label>
                                    <input type="text" id="kontak" name="kontak"
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('kontak') border-red-500 @enderror"
                                        placeholder="Contoh: 08123456789"
                                        value="{{ old('kontak') }}">
                                    @error('kontak')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="kategori_material" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-boxes text-red-400 text-xs"></i>
                                        Kategori Material *
                                    </label>
                                    <input type="text" id="kategori_material" name="kategori_material" required
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('kategori_material') border-red-500 @enderror"
                                        placeholder="Contoh: Baja Karbon, Stainless Steel, Non-Ferro"
                                        value="{{ old('kategori_material') }}">
                                    @error('kategori_material')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="status" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-power-off text-green-400 text-xs"></i>
                                        Status *
                                    </label>
                                    <select id="status" name="status" required
                                            class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('status') border-red-500 @enderror">
                                        <option value="">Pilih Status</option>
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="alamat" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-cyan-400 text-xs"></i>
                                    Alamat *
                                </label>
                                <textarea id="alamat" name="alamat" rows="3" required
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition resize-none @error('alamat') border-red-500 @enderror"
                                        placeholder="Masukkan alamat lengkap supplier...">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-dark-200">
                            <div class="text-gray-400 text-sm">
                                <i class="fas fa-info-circle mr-2"></i>
                                Field bertanda * wajib diisi
                            </div>
                            <div class="flex gap-3 w-full sm:w-auto">
                                <a href="{{ route('supplier.index') }}" class="flex-1 sm:flex-none px-6 py-3 text-gray-300 hover:text-white transition rounded-lg border border-dark-200 hover:bg-dark-400 text-center">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </a>
                                <button type="submit" id="submitBtnCreate" class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition flex items-center justify-center gap-2 group">
                                    <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
                                    <span>Simpan Supplier</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-dark-300 rounded-xl border border-dark-200 p-6 sticky top-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-400"></i>
                        Panduan Data Supplier
                    </h4>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-600/10 rounded-lg p-3 border border-blue-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-hashtag text-blue-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Kode Supplier</span>
                            </div>
                            <p class="text-gray-400 text-xs">Pastikan kode bersifat unik dan mudah diidentifikasi (e.g., berdasarkan wilayah atau kategori material).</p>
                        </div>

                        <div class="bg-red-600/10 rounded-lg p-3 border border-red-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-boxes text-red-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Kategori Material</span>
                            </div>
                            <p class="text-gray-400 text-xs">Klasifikasikan material utama yang disuplai (e.g., logam, plastik, kimia). Ini penting untuk evaluasi.</p>
                        </div>

                        <div class="bg-green-600/10 rounded-lg p-3 border border-green-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-power-off text-green-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Status</span>
                            </div>
                            <p class="text-gray-400 text-xs">Pilih 'Aktif' untuk supplier yang masih beroperasi/digunakan dan 'Nonaktif' untuk supplier yang dihentikan.</p>
                        </div>

                        <div class="bg-purple-600/10 rounded-lg p-3 border border-purple-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-lightbulb text-purple-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Tips Pengisian</span>
                            </div>
                            <ul class="text-gray-400 text-xs space-y-1">
                                <li>• Gunakan alamat dan kontak yang valid untuk korespondensi.</li>
                                <li>• Seluruh field bertanda (*) wajib diisi.</li>
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
        const form = document.getElementById('supplierFormCreate');
        const submitBtn = document.getElementById('submitBtnCreate');
        
        // Hapus semua logika preview kriteria (bobot, jenis, nama kriteria)
        
        form.addEventListener('submit', function(e) {
            // Add loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        });

        // Hapus logika auto-format bobot
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