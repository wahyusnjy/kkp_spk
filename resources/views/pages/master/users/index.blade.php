<x-layouts.app :title="__('Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center gap-4">
            <x-title-header :title="__('Users')" :base="__('Masters')"/>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <form action="{{ route('users.index') }}" method="GET" id="searchForm">
                        <input type="text" 
                            id="searchUsers"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari User..." 
                            class="w-full bg-dark-400 border border-dark-200 rounded-lg pl-10 pr-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    </form>
                </div>
                <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah users</span>
                </a>
            </div>
        </div>
        
         <div class="mt-4">
            <x-table-list 
                :data="$users"
                :columns="[
                    'name' => [
                        'label' => 'Name',
                        'sortable' => true
                    ],
                    'email' => [
                        'label' => 'Email',
                        'sortable' => true
                    ],
                    'role' => [
                        'label' => 'Role',
                        'sortable' => true
                    ],
                ]"
                :actions="['edit', 'delete']"
                emptyMessage="Tidak ada data material ditemukan"
            />
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</x-layouts.app>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let deleteBtn = document.querySelector('.delete-item-btn');
    const deleteForm = document.getElementById('deleteForm');

    // Edit buttons - PERBAIKAN: ganti selector ke edit-item-btn
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-item-btn') || e.target.closest('.edit-item-btn')) {
            const btn = e.target.classList.contains('edit-item-btn') ? e.target : e.target.closest('.edit-item-btn');
            
            if(btn.dataset.id) {
                window.location.href = `/users/edit/${btn.dataset.id}`;
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
                text: `users ID ${btn.dataset.id} akan dihapus permanen!`, // Tambahkan ID untuk debugging
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
                    deleteForm.action = `/users/delete/${btn.dataset.id}`; 
                    deleteForm.submit();
                }
            });
        }
    });

    // Search functionality
    const searchInput = document.getElementById('searchUsers');
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
});
</script>
