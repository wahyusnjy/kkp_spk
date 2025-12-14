<x-layouts.app :title="__('Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <x-title-header :title="__('Users')" :base="__('Masters')"/>
        </div>
        
        <!-- Search Section -->
        <div class="flex justify-end items-center mt-4">
            <div class="relative w-full sm:w-80">
                <input type="text" 
                       id="searchUsers"
                       placeholder="Cari user..." 
                       class="w-full bg-dark-400 border border-dark-200 rounded-lg pl-10 pr-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
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
                    ]
                ]"
                :actions="['view', 'edit', 'delete']"
                emptyMessage="Tidak ada data material ditemukan"
            />
        </div>
    </div>
</x-layouts.app>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
