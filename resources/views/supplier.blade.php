<x-layouts.app :title="__('Supplier')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <x-title-header :title="__('Supplier')" :base="__('Masters')"/>
            <button id="createSupplierBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Supplier</span>
            </button>
        </div>
        
        <!-- Search Section -->
        <div class="flex justify-end items-center mt-4">
            <div class="relative w-full sm:w-80">
                <input type="text" 
                       id="searchSupplier"
                       placeholder="Cari supplier..." 
                       class="w-full bg-dark-400 border border-dark-200 rounded-lg pl-10 pr-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
            </div>
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
        const modal = document.getElementById('supplierModal');
        const createBtn = document.getElementById('createSupplierBtn');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('supplierForm');
        const submitBtn = document.getElementById('submitBtn');

        // Open Modal for Create
        createBtn.addEventListener('click', function() {
            modalTitle.textContent = 'Tambah Supplier';
            form.reset();
            form.action = "{{ route('supplier.store') }}";
            form.method = 'POST';
            
            // Remove method PUT if exists
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
            
            // Reset status selection
            document.getElementById('status').value = '';
            
            modal.classList.remove('hidden');
        });

        // Close Modal
        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Edit buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-item-btn') || e.target.closest('.edit-item-btn')) {
                const btn = e.target.classList.contains('edit-item-btn') ? e.target : e.target.closest('.edit-item-btn');
                console.log('Edit button clicked:', btn.dataset);
                
                modalTitle.textContent = 'Edit Supplier';
                
                // Fill form with data - SESUAIKAN DENGAN DATA ATTRIBUTES
                document.getElementById('supplier_id').value = btn.dataset.id;
                document.getElementById('nama_supplier').value = btn.dataset.namaSupplier || '';
                document.getElementById('alamat').value = btn.dataset.alamat || '';
                document.getElementById('telepon').value = btn.dataset.telepon || '';
                document.getElementById('email').value = btn.dataset.email || '';
                document.getElementById('kategori_material').value = btn.dataset.kategoriMaterial || '';
                document.getElementById('status').value = btn.dataset.status || '';
                
                // Set form action for update
                form.action = `/supplier/update/${btn.dataset.id}`;
                form.method = 'POST';
                
                // Remove old method input if exists
                const oldMethodInput = form.querySelector('input[name="_method"]');
                if (oldMethodInput) {
                    oldMethodInput.remove();
                }
                
                // Add PUT method for update
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
                
                modal.classList.remove('hidden');
            }
        });

        // Form submission with loading state
        form.addEventListener('submit', function(e) {
            // Client-side validation
            const namaSupplier = document.getElementById('nama_supplier').value.trim();
            const alamat = document.getElementById('alamat').value.trim();
            const telepon = document.getElementById('telepon').value.trim();
            const email = document.getElementById('email').value.trim();
            const kategoriMaterial = document.getElementById('kategori_material').value.trim();
            const status = document.getElementById('status').value;

            if (!namaSupplier || !alamat || !telepon || !email || !kategoriMaterial || !status) {
                e.preventDefault();
                Swal.fire({
                    title: 'Data tidak lengkap!',
                    text: 'Harap isi semua field yang wajib diisi.',
                    icon: 'warning',
                    background: '#1f2937',
                    color: '#fff'
                });
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                Swal.fire({
                    title: 'Email tidak valid!',
                    text: 'Harap masukkan format email yang benar.',
                    icon: 'warning',
                    background: '#1f2937',
                    color: '#fff'
                });
                return;
            }

            // Add loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        });

        function closeModal() {
            modal.classList.add('hidden');
            // Reset loading state jika modal ditutup
            submitBtn.innerHTML = 'Simpan';
            submitBtn.disabled = false;
        }

        // Delete functionality
        const deleteForm = document.getElementById('deleteForm');
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-item-btn') || e.target.closest('.delete-item-btn')) {
                const btn = e.target.classList.contains('delete-item-btn') ? e.target : e.target.closest('.delete-item-btn');
                const supplierName = btn.dataset.name;
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Supplier "${supplierName}" akan dihapus permanen!`,
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
                        deleteForm.action = `/supplier/delete/${btn.dataset.id}`;
                        deleteForm.submit();
                    }
                });
            }
        });

        // Search functionality
        const searchInput = document.getElementById('searchSupplier');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('table tbody tr');
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Debug: Log semua edit buttons
        console.log('Edit buttons found:', document.querySelectorAll('.edit-item-btn').length);
        console.log('Delete buttons found:', document.querySelectorAll('.delete-item-btn').length);
    });
</script>