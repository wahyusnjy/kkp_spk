<x-layouts.app :title="__('Kriteria')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <x-title-header :title="__('Kriteria')" :base="__('Masters')"/>
            <button id="createKriteriaBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Kriteria</span>
            </button>
        </div>

        <!-- Table Section -->
        <div class="mt-4">
            <x-table-list 
                :data="$kriterias"
                :columns="[
                    'nama_kriteria' => [
                        'label' => 'Kriteria',
                        'sortable' => true
                    ],
                    'bobot' => [
                        'label' => 'Bobot',
                        'sortable' => true,
                        'subtitle' => 'bobot'
                    ],
                    'type' => [
                        'label' => 'Jenis',
                        'sortable' => true
                    ],
                    'keterangan' => [
                        'label' => 'Deskripsi',
                        'sortable' => true
                    ]
                ]"
                :actions="['edit', 'delete']"
                emptyMessage="Tidak ada data material ditemukan"
            />
        </div>
    </div>

    <!-- Modal Form Create/Edit -->
    <div id="kriteriaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-dark-300 rounded-xl border border-dark-200 w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 id="modalTitle" class="text-lg font-semibold text-white">Tambah Kriteria</h3>
                    <button type="button" id="closeModal" class="text-gray-400 hover:text-white transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="kriteriaForm" method="POST" action="{{ route('kriteria.store') }}">
                    @csrf
                    <input type="hidden" id="kriteria_id" name="id">
                    
                    <div class="space-y-4">

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-300 mb-2">Nama Kriteria *</label>
                            <input type="text" id="nama" name="nama_kriteria" required
                                class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nama kriteria">
                        </div>
                        
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                            <textarea id="deskripsi" name="keterangan" rows="3"
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Deskripsi optional kriteria"></textarea>
                        </div>
                        
                        <div>
                            <label for="bobot" class="block text-sm font-medium text-gray-300 mb-2">Bobot Kriteria *</label>
                            <input type="number" id="bobot" name="bobot" step="0.1" min="0" max="5" required
                                class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="0.0 - 5.0">
                        </div>

                        <div>
                            <label for="jenis" class="block text-sm font-medium text-gray-300 mb-2">Jenis Kriteria *</label>
                            <select id="jenis" name="type" required
                                    class="w-full bg-dark-400 border border-dark-200 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Jenis</option>
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
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
        const modal = document.getElementById('kriteriaModal');
        const createBtn = document.getElementById('createKriteriaBtn');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('kriteriaForm');
        const submitBtn = document.getElementById('submitBtn');

        // Open Modal for Create
        createBtn.addEventListener('click', function() {
            modalTitle.textContent = 'Tambah Kriteria';
            form.reset();
            form.action = "{{ route('kriteria.store') }}";
            form.method = 'POST';
            
            // Remove method PUT if exists
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
            
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

        // Edit buttons - PERBAIKAN: ganti selector ke edit-item-btn
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-item-btn') || e.target.closest('.edit-item-btn')) {
                const btn = e.target.classList.contains('edit-item-btn') ? e.target : e.target.closest('.edit-item-btn');
                console.log('Edit button clicked:', btn.dataset);
                
                modalTitle.textContent = 'Edit Kriteria';
                
                // Fill form with data - SESUAIKAN DENGAN DATA ATTRIBUTES
                document.getElementById('kriteria_id').value = btn.dataset.id;
                document.getElementById('nama').value = btn.dataset.nama_kriteria || '';
                document.getElementById('deskripsi').value = btn.dataset.keterangan || '';
                document.getElementById('bobot').value = btn.dataset.bobot || '';
                document.getElementById('jenis').value = btn.dataset.type || '';
                
                form.action = `/kriteria/update/${btn.dataset.id}`;
                form.method = 'POST';
                
                // Remove old method input if exists
                const oldMethodInput = form.querySelector('input[name="_method"]');
                if (oldMethodInput) {
                    oldMethodInput.remove();
                }
                
                // Add PUT method
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                form.appendChild(methodInput);
                
                modal.classList.remove('hidden');
            }
        });

        // Form submission with loading state
        form.addEventListener('submit', function(e) {
            // Client-side validation
            const nama = document.getElementById('nama').value.trim();
            const bobot = document.getElementById('bobot').value;
            const jenis = document.getElementById('jenis').value;

            if (!nama || !bobot || !jenis) {
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

        // Delete functionality - PERBAIKAN: ganti selector ke delete-item-btn
        const deleteForm = document.getElementById('deleteForm');
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-item-btn') || e.target.closest('.delete-item-btn')) {
                const btn = e.target.classList.contains('delete-item-btn') ? e.target : e.target.closest('.delete-item-btn');
                const kriteriaName = btn.dataset.name;
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Kriteria "${kriteriaName}" akan dihapus permanen!`,
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
                        deleteForm.action = `/kriteria/delete/${btn.dataset.id}`;
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