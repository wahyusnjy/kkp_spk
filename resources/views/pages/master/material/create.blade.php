<x-layouts.app :title="__('Tambah Material')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Tambah Material Baru</h1>
                <p class="text-gray-400 mt-1">Tambahkan detail bahan material baru ke sistem</p>
            </div>
            <a href="{{ route('material.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus-circle text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Detail Material</h3>
                            <p class="text-gray-400 text-sm">Isi form berikut untuk menambahkan material baru</p>
                        </div>
                    </div>
                    <form id="materialFormCreate" method="POST" action="{{ route('material.store') }}">
                        @csrf
                        <div class="space-y-6">
                             {{-- Supplier --}}
                             <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="supplier_id" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-truck text-purple-400 text-xs"></i>
                                    Supplier *
                                </label>
                                <select id="supplier_id" name="supplier_id" required
                                            class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('supplier_id') border-red-500 @enderror">
                                        <option value="">Pilih Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->nama_supplier }}</option>
                                        @endforeach
                                    </select>
                                @error('supplier_id')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            {{-- Nama Material --}}
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="nama_material" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-box-open text-blue-400 text-xs"></i>
                                    Nama Material *
                                </label>
                                <input type="text" id="nama_material" name="nama_material" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('nama_material') border-red-500 @enderror"
                                    placeholder="Contoh: Logam Besi, Baja Karbon"
                                    value="{{ old('nama_material') }}">
                                @error('nama_material')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            {{-- Jenis Logam --}}
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="jenis_logam" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-truck text-purple-400 text-xs"></i>
                                    Jenis Logam *
                                </label>
                                <select id="jenis_logam" name="jenis_logam" required
                                            class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('jenis_logam') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Logam</option>
                                        @foreach ($enum_list_jenis_logam as $jenis_logam)
                                           
                                            <option value="{{ $jenis_logam }}" {{ old('jenis_logam') == $jenis_logam ? 'selected' : '' }}>{{ ucfirst($jenis_logam) }}</option>
                                        @endforeach
                                    </select>
                                @error('jenis_logam')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Grade --}}
                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="grade" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-star text-blue-400 text-xs"></i>
                                        Grade *
                                    </label>
                                    <input type="text" id="grade" name="grade" required
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('grade') border-red-500 @enderror"
                                        placeholder="Contoh: A36, SS400, 304"
                                        value="{{ old('grade') }}">
                                    @error('grade')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                {{-- Spesifikasi --}}
                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="spesifikasi_teknis" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-ruler-combined text-blue-400 text-xs"></i>
                                        Spesifikasi Teknis *
                                    </label>
                                    <input type="text" id="spesifikasi_teknis" name="spesifikasi_teknis" required
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('spesifikasi_teknis') border-red-500 @enderror"
                                        placeholder="Contoh: Tebal 10mm, Bentuk Plat, Diameter 5cm"
                                        value="{{ old('spesifikasi_teknis') }}">
                                    @error('spesifikasi_teknis')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                {{-- Harga / KG --}}
                                <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                    <label for="harga" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                        <i class="fas fa-dollar-sign text-blue-400 text-xs"></i>
                                        Harga / KG *
                                    </label>
                                    <input type="number" id="harga" name="harga" required step="0.01" min="0"
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('harga') border-red-500 @enderror"
                                        placeholder="Contoh: 15500.50 (gunakan titik untuk desimal)"
                                        value="{{ old('harga') }}">
                                    @error('harga')
                                        <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-dark-200">
                            <div class="text-gray-400 text-sm">
                                <i class="fas fa-info-circle mr-2"></i>
                                Field bertanda * wajib diisi
                            </div>
                            <div class="flex gap-3 w-full sm:w-auto">
                                <a href="{{ route('material.index') }}" class="flex-1 sm:flex-none px-6 py-3 text-gray-300 hover:text-white transition rounded-lg border border-dark-200 hover:bg-dark-400 text-center">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </a>
                                <button type="submit" id="submitBtnCreate" class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition flex items-center justify-center gap-2 group">
                                    <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
                                    <span>Simpan Material</span>
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
                        Panduan Pengisian Material
                    </h4>

                    <div class="space-y-4">
                        <div class="bg-purple-600/10 rounded-lg p-3 border border-purple-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-truck text-purple-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Supplier</span>
                            </div>
                            <p class="text-gray-400 text-xs">Pilih supplier yang menyediakan material ini dari daftar yang tersedia.</p>
                        </div>

                        <div class="bg-blue-600/10 rounded-lg p-3 border border-blue-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-flask text-blue-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Jenis Logam & Grade</span>
                            </div>
                            <p class="text-gray-400 text-xs">Isi dengan nama material dan standar spesifik (seperti jenis baja, grade, atau alloy) untuk identifikasi yang akurat.</p>
                        </div>

                        <div class="bg-green-600/10 rounded-lg p-3 border border-green-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-dollar-sign text-green-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Harga</span>
                            </div>
                            <p class="text-gray-400 text-xs">Masukkan harga material per kilogram (KG) menggunakan format desimal (gunakan titik), contoh: 15500.50.</p>
                        </div>

                        <div class="bg-red-600/10 rounded-lg p-3 border border-red-500/20">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-lightbulb text-red-400 text-sm"></i>
                                <span class="text-white font-medium text-sm">Tips Pengisian</span>
                            </div>
                            <ul class="text-gray-400 text-xs space-y-1">
                                <li>• Gunakan detail **Spesifikasi** yang lengkap untuk membedakan antar material yang mirip.</li>
                                <li>• Pastikan **Supplier** sudah terdaftar sebelum menambahkan material.</li>
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
        const form = document.getElementById('materialFormCreate');
        const submitBtn = document.getElementById('submitBtnCreate');

        // Mengatur agar Harga hanya menerima angka (number type)
        const hargaInput = document.getElementById('harga');
        if (hargaInput) {
            hargaInput.addEventListener('keypress', function(e) {
                // Hanya izinkan angka, titik, dan backspace/delete
                if (!/[0-9.]/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
                    e.preventDefault();
                }
            });
            // Mencegah lebih dari satu titik desimal
            hargaInput.addEventListener('input', function() {
                if ((this.value.match(/\./g) || []).length > 1) {
                    this.value = this.value.substring(0, this.value.lastIndexOf('.'));
                }
            });
        }
        
        form.addEventListener('submit', function(e) {
            // Menambahkan state loading saat form disubmit
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        });

        // Hapus fungsi showNotification dan Auto-format bobot input yang tidak lagi relevan
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

    /* Custom scrollbar for textarea (meski sudah tidak ada textarea, tetap dipertahankan jika sewaktu-waktu ditambahkan) */
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