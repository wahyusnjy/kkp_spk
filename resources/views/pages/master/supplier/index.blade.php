<x-layouts.app :title="__('Supplier')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <x-title-header :title="__('Supplier')" :base="__('Masters')"/>
            <a href="{{ route('supplier.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Supplier</span>
            </a>
        </div>
        
        <div class="mt-4">
            <x-table-list 
                :data="$suppliers"
                :columns="[
                    'kode_supplier' => [
                        'label' => 'Kode Supplier',
                        'sortable' => true
                    ],
                    'nama_supplier' => [
                        'label' => 'Nama',
                        'sortable' => true
                    ],
                    'kategori_material' => [
                        'label' => 'Kategori',
                        'sortable' => true,
                        'subtitle' => 'kategori'
                    ],
                    'status' => [
                        'label' => 'Status',
                        'sortable' => true
                    ]
                ]"
                :actions="['edit', 'delete']"
                emptyMessage="Tidak ada data material ditemukan"
            />
        </div>
    </div>

    <!-- Modal Form Create/Edit -->
    <div id="supplierModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-dark-300 rounded-xl border border-dark-200 w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 id="modalTitle" class="text-lg font-semibold text-white">Tambah Supplier</h3>
                    <button type="button" id="closeModal" class="text-gray-400 hover:text-white transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="supplierForm" method="POST" action="{{ route('supplier.store') }}">
                    @csrf
                    <input type="hidden" id="supplier_id" name="id">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="nama_supplier" class="block text-sm font-medium text-gray-300 mb-2">Nama Supplier *</label>
                            <input type="text" id="nama_supplier" name="nama_supplier" required
                                class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nama supplier">
                        </div>
                        
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-300 mb-2">Alamat *</label>
                            <textarea id="alamat" name="alamat" rows="3" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan alamat supplier"></textarea>
                        </div>

                        <div>
                            <label for="telepon" class="block text-sm font-medium text-gray-300 mb-2">Telepon *</label>
                            <input type="text" id="telepon" name="telepon" required
                                class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nomor telepon">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan email supplier">
                        </div>

                        <div>
                            <label for="kategori_material" class="block text-sm font-medium text-gray-300 mb-2">Kategori Material *</label>
                            <input type="text" id="kategori_material" name="kategori_material" required
                                class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan kategori material">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status *</label>
                            <select id="status" name="status" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled selected>Pilih status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" id="cancelBtn" class="px-4 py-2 text-gray-300 hover:text-white transition rounded-lg border border-dark-200 hover:bg-dark-400">
                            Batal
                        </button>
                        <button type="submit" id="submitBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</x-layouts.app>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Elements
        const modal = document.getElementById('materialModal');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('materialForm');
        const submitBtn = document.getElementById('submitBtn');


        // Edit buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-item-btn') || e.target.closest('.edit-item-btn')) {
                const btn = e.target.classList.contains('edit-item-btn') ? e.target : e.target.closest('.edit-item-btn');
                
                if(btn.dataset.id) {
                    window.location.href = `/suppliers/edit/${btn.dataset.id}`;
                } else {
                    console.error('Data ID tidak ditemukan pada tombol edit.');
                }
            }
            const deleteBtnClicked = e.target.closest('.delete-item-btn');
            if (deleteBtnClicked) {
                
                // Variabel 'btn' sekarang terdefinisi di sini
                const btn = deleteBtnClicked; 

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Supplier ini akan dihapus permanen!`, // Tambahkan ID untuk debugging
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: '#1f2937',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gunakan variabel 'btn' yang sudah ditangkap
                        deleteForm.action = `/suppliers/delete/${btn.dataset.id}`; 
                        deleteForm.submit();
                    }
                });
            }
        });

        // Debug: Log semua edit buttons
        console.log('Edit buttons found:', document.querySelectorAll('.edit-item-btn').length);
        console.log('Delete buttons found:', document.querySelectorAll('.delete-item-btn').length);
    });
</script>