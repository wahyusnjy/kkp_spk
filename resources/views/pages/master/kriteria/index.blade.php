<x-layouts.app :title="__('Kriteria')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center gap-4">
            <x-title-header :title="__('Kriteria')" :base="__('Masters')"/>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <form action="{{ route('kriteria.index') }}" method="GET" id="searchForm">
                        <input type="text" 
                            id="searchKriteria"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari kriteria..." 
                            class="w-full bg-white dark:bg-dark-400 border border-gray-300 dark:border-dark-200 rounded-lg pl-10 pr-4 py-2.5 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    </form>
                </div>
                <a href="{{ route('kriteria.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Kriteria</span>
                </a>
                <button type="button" 
                    data-modal-target="importModal" 
                    class="open-modal bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-file-import"></i>
                    <span>Import Supplier</span>
                </button>
            </div>
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
        const modal = document.querySelector('.kriteriaModal');
        const createBtn = document.querySelector('.createKriteriaBtn');
        let deleteBtn = document.querySelector('.delete-item-btn');
        const deleteForm = document.getElementById('deleteForm');

        // Edit buttons - PERBAIKAN: ganti selector ke edit-item-btn
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-item-btn') || e.target.closest('.edit-item-btn')) {
                const btn = e.target.classList.contains('edit-item-btn') ? e.target : e.target.closest('.edit-item-btn');
                
                if(btn.dataset.id) {
                    window.location.href = `/kriteria/edit/${btn.dataset.id}`;
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
                    text: `Kriteria ID ${btn.dataset.id} akan dihapus permanen!`, // Tambahkan ID untuk debugging
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: localStorage.getItem('theme') === 'dark' ? '#1f2937' : '#ffffff',
                    color: localStorage.getItem('theme') === 'dark' ? '#fff' : '#000'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gunakan variabel 'btn' yang sudah ditangkap
                        deleteForm.action = `/kriteria/delete/${btn.dataset.id}`; 
                        deleteForm.submit();
                    }
                });
            }
        });
        // Debug: Log semua edit buttons

        // Search functionality
        const searchInput = document.getElementById('searchKriteria');
        searchInput.addEventListener('keypress', function(e) {
            if(e.key === 'Enter') {
                document.getElementById('searchForm').submit();
            }
        });
        console.log('Delete buttons found:', document.querySelectorAll('.delete-item-btn').length);
    });
</script>