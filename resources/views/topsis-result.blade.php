<x-layouts.app :title="__('Rangking Supplier')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <x-title-header :title="__('Rangking Supplier')" :base="__('Analysis Result')"/>
        </div>
        
        <div class="mt-4">
             <x-table-list 
                :data="$results"
                :columns="[
                    'rank' => [
                        'label' => 'Ranking',
                        'sortable' => true,
                        'format' => 'rank-badge',
                        'align' => 'left'
                    ],
                    'supplier.nama_supplier' => [
                        'label' => 'Supplier',
                        'sortable' => true,
                        'subtitle' => 'supplier.alamat',
                        'icon' => 'warehouse'
                    ],
                    'preference_score' => [
                        'label' => 'Nilai Preferensi',
                        'sortable' => true,
                        'format' => 'progress-bar',
                        'align' => 'center'
                    ]
                ]"
                emptyMessage="Tidak ada data rank ditemukan"
                :emptyAction="[
                    'url' => route('assessments.create'),
                    'text' => 'Buat Assessment Baru',
                    'icon' => 'plus'
                ]"
            />
        </div>
    </div>
</x-layouts.app>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
