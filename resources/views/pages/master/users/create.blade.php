<x-layouts.app :title="__('Tambah users')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Tambah Users</h1>
                <p class="text-gray-400 mt-1">Buat Users baru</p>
            </div>
            <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>

        <!-- Form Section -->
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
            <!-- Form Container -->
            <div class="lg:col-span-2">
                <div class="bg-dark-300 rounded-xl border border-dark-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus-circle text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Detail users</h3>
                            <p class="text-gray-400 text-sm">Isi form berikut untuk menambahkan users baru</p>
                        </div>
                    </div>
                    <form id="usersFormCreate" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="space-y-6">
                            <!-- Nama users -->
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="name" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-tag text-blue-400 text-xs"></i>
                                    Nama users *
                                </label>
                                <input type="text" id="name" name="name" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                                    placeholder="Contoh: John Doe"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="email" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-tag text-blue-400 text-xs"></i>
                                    Email *
                                </label>
                                <input type="email" id="email" name="email" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                                    placeholder="Contoh: john@gmail.com"
                                    value="{{ old('email') ? old('email') : '' }}">
                                @error('email')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="password" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-tag text-blue-400 text-xs"></i>
                                    Password *
                                </label>
                                <input type="password" id="password" name="password" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                                    placeholder="Must At least 8 characters"
                                    value="{{ old('password') ? old('email') : '' }}">
                                @error('password')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Jenis users -->
                            <div class="bg-dark-400/50 rounded-lg p-4 border border-dark-200">
                                <label for="role" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                                    <i class="fas fa-sliders-h text-purple-400 text-xs"></i>
                                    Jenis users *
                                </label>
                                <select id="role" name="role" required
                                        class="w-full bg-dark-400 border border-dark-200 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('role') border-red-500 @enderror">
                                    <option value="">Pilih Jenis users</option>
                                    <option value="admin" {{ old('role') == 'manager' ? 'selected' : '' }}>Admin (Mengelola segala data dan perhitungan)</option>
                                    <option value="manager" {{ old('role') == 'admin' ? 'selected' : '' }}>Manager (Cuma Bisa liat hasil perhitungan)</option>
                                </select>
                                @error('role')
                                    <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Preview Card -->
                        <div class="bg-blue-600/10 border border-blue-500/20 rounded-lg p-4 mt-4">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-eye text-blue-400"></i>
                                <span class="text-blue-400 font-medium">Preview users</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-400">Nama:</span>
                                    <span id="previewNama" class="text-white ml-2">-</span>
                                </div>
                                <div>
                                    <span class="text-gray-400">Email:</span>
                                    <span id="previewEmail" class="text-white ml-2">-</span>
                                </div>
                                <div>
                                    <span class="text-gray-400">Role:</span>
                                    <span id="previewRole" class="text-white ml-2">-</span>
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
                            <a href="{{ route('users.index') }}" class="flex-1 sm:flex-none px-6 py-3 text-gray-300 hover:text-white transition rounded-lg border border-dark-200 hover:bg-dark-400 text-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" id="submitBtnCreate" class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition flex items-center justify-center gap-2 group">
                                <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
                                <span>Simpan users</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('usersFormCreate');
            const submitBtn = document.getElementById('submitBtnCreate');
            
            // Real-time preview
            const namaInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const roleSelect = document.getElementById('role');
            
            const previewNama = document.getElementById('previewNama');
            const previewEmail = document.getElementById('previewEmail');
            const previewRole = document.getElementById('previewRole');
            
            function updatePreview() {
                previewNama.textContent = namaInput.value || '-';
                previewEmail.textContent = emailInput.value ? emailInput.value : '-';
                previewRole.textContent = roleSelect.value ? 
                    (roleSelect.value === 'admin' ? 'Admin' : 'Manager') : '-';
            }
            
            // Event listeners for real-time preview
            namaInput.addEventListener('input', updatePreview);
            emailInput.addEventListener('input', updatePreview);
            roleSelect.addEventListener('change', updatePreview);
            
            // Initial preview
            updatePreview();
            
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