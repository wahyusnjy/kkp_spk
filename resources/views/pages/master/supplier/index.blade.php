<x-layouts.app :title="__('Supplier')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center gap-4">
            <x-title-header :title="__('Supplier')" :base="__('Masters')"/>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <form action="{{ route('supplier.index') }}" method="GET" id="searchForm">
                        <input type="text" 
                            id="searchSupplier"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari supplier..." 
                            class="w-full bg-dark-400 border border-dark-200 rounded-lg pl-10 pr-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    </form>
                </div>
                <a href="{{ route('supplier.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Supplier</span>
                </a>
                <button type="button" 
                    data-modal-target="importModal" 
                    class="open-modal bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-file-import"></i>
                    <span>Import Supplier</span>
                </button>
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

    <div id="importModal" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Tambahkan animasi subtle scale -->
            <div class="relative bg-white border border-gray-200 rounded-2xl shadow-xl p-6 md:p-8 transform transition-all duration-300">
                <!-- Header dengan background gradient -->
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">
                            Import Data Supplier
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Upload file Excel untuk menambahkan data supplier</p>
                    </div>
                    <button type="button" 
                            class="close-modal text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors duration-200" 
                            data-modal="importModal">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <form action="{{ route('supplier.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="space-y-6 py-2">
                        <!-- Upload area dengan style modern -->
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center bg-gradient-to-br from-gray-50 to-white hover:from-gray-50 hover:to-gray-50 transition-all duration-300 cursor-pointer group"
                            onclick="document.querySelector('#importForm input[type=file]').click()"
                            id="dropZone">
                            <div class="mb-4">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 text-green-600 mb-3 group-hover:bg-green-100 transition-colors duration-300">
                                    <i class="fas fa-file-excel text-2xl"></i>
                                </div>
                            </div>
                            <p class="text-gray-800 font-medium text-lg mb-2">Upload File Excel</p>
                            <p class="text-gray-500 mb-4">Format yang didukung: .xlsx, .xls</p>
                            
                            <div class="px-6 py-3 bg-white border border-gray-300 rounded-lg inline-block hover:border-green-500 transition-colors duration-300">
                                <span class="text-green-600 font-medium">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i>
                                    Pilih File
                                </span>
                            </div>
                            
                            <input type="file" 
                                name="file" 
                                id="fileInput"
                                accept=".xlsx,.xls"
                                required 
                                class="hidden"
                                onchange="updateFileName(this)">
                            
                            <div id="fileName" class="mt-4 text-sm font-medium"></div>
                            
                            <p class="text-xs text-gray-400 mt-3">
                                Drag & drop file di sini atau klik untuk memilih
                            </p>
                        </div>

                        <!-- Info template -->
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-500 text-lg mt-0.5"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-800">
                                        <span class="font-medium">Perhatian:</span> Pastikan format file sesuai dengan template yang disediakan.
                                    </p>
                                    <p class="text-sm text-blue-700 mt-1">
                                        <i class="fas fa-download mr-1"></i>
                                        Unduh 
                                        <a href="{{ route('supplier.download-template') }}" 
                                        class="font-semibold text-blue-600 hover:text-blue-800 underline">
                                            template Excel
                                        </a> 
                                        untuk format yang benar.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action buttons -->
                    <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-100">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Data Anda aman dan terenkripsi
                        </div>
                        <div class="flex items-center space-x-3">
                            <button type="button" 
                                    class="close-modal px-5 py-2.5 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 hover:border-gray-400 rounded-lg font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-transparent" 
                                    data-modal="importModal">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <i class="fas fa-upload mr-2"></i> 
                                Proses Import
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden"></div>

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

            // Modal listener

            if (e.target.closest('.open-modal')) {
                const button = e.target.closest('.open-modal');
                const modalId = button.getAttribute('data-modal-target') || 'importModal';
                openModal(modalId);
            }
            
            // Tombol untuk menutup modal
            if (e.target.closest('.close-modal')) {
                const button = e.target.closest('.close-modal');
                const modalId = button.getAttribute('data-modal') || 'importModal';
                closeModal(modalId);
            }
            
            // Tutup modal saat klik overlay
            if (e.target.id === 'modalOverlay') {
                const openModals = document.querySelectorAll('.fixed:not(.hidden)');
                openModals.forEach(modal => {
                    if (modal.id !== 'modalOverlay') {
                        closeModal(modal.id);
                    }
                });
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.fixed:not(.hidden)');
                openModals.forEach(modal => {
                    if (modal.id !== 'modalOverlay') {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // Drag And drop Import File:

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        
        if (dropZone && fileInput) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            // Highlight effect
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropZone.classList.add('border-green-400', 'bg-green-50/50', 'scale-[1.02]');
                dropZone.classList.remove('border-gray-200');
                dropZone.querySelector('i.fa-file-excel').parentElement.classList.add('bg-green-100');
            }
            
            function unhighlight() {
                dropZone.classList.remove('border-green-400', 'bg-green-50/50', 'scale-[1.02]');
                dropZone.classList.add('border-gray-200');
                dropZone.querySelector('i.fa-file-excel').parentElement.classList.remove('bg-green-100');
            }
            
            // Handle drop
            dropZone.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    fileInput.files = files;
                    updateFileName(fileInput);
                }
            }
        }
        
        const searchInput = document.getElementById('searchKriteria');
        searchInput.addEventListener('keypress', function(e) {
            if(e.key === 'Enter') {
                document.getElementById('searchForm').submit();
            }
        });

        // Debug: Log semua edit buttons
        console.log('Edit buttons found:', document.querySelectorAll('.modal-toggle-import').length);
        console.log('Edit buttons found:', document.querySelectorAll('.edit-item-btn').length);
        console.log('Delete buttons found:', document.querySelectorAll('.delete-item-btn').length);
    });

     function updateFileName(input) {
            const fileNameDisplay = document.getElementById('fileName');
            const dropZone = document.getElementById('dropZone');
            
            if (input.files.length > 0) {
                const file = input.files[0];
                const fileSize = (file.size / (1024*1024)).toFixed(2); // MB
                
                fileNameDisplay.innerHTML = `
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-file-excel text-green-500"></i>
                        <span class="text-green-600 font-medium">${file.name}</span>
                        <span class="text-gray-500 text-xs bg-gray-100 px-2 py-1 rounded">${fileSize} MB</span>
                    </div>
                `;
                
                // Tambahkan efek visual
                dropZone.classList.add('border-green-400', 'bg-green-50/50');
                dropZone.classList.remove('border-gray-200');
            } else {
                fileNameDisplay.innerHTML = '';
                dropZone.classList.remove('border-green-400', 'bg-green-50/50');
                dropZone.classList.add('border-gray-200');
            }
        }

        // Fungsi untuk membuka modal
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const overlay = document.getElementById('modalOverlay');
            
            if (modal) {
                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden'; // Mencegah scroll background
            }
        }

        // Fungsi untuk menutup modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const overlay = document.getElementById('modalOverlay');
            
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                overlay.classList.add('hidden');
                document.body.style.overflow = ''; // Kembalikan scroll
                
                // Reset form
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                    document.getElementById('fileName').textContent = '';
                }
            }
        }
        
        
</script>

<style>
    /* Animasi untuk modal */
    .fixed {
        transition: opacity 0.3s ease;
    }

    /* Untuk smooth opening */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { 
            opacity: 0;
            transform: translateY(-20px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }

    .max-h-full {
        animation: slideIn 0.3s ease-out;
    }

    #modalOverlay {
        animation: fadeIn 0.3s ease-out;
    }
</style>