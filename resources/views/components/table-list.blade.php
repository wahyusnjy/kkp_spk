@props([
    'data' => [],
    'columns' => [],
    'primaryKey' => 'id',
    'withNumber' => true,
    'withActions' => true,
    'actions' => ['edit', 'delete'], // edit, view, delete, custom
    'emptyMessage' => 'Tidak ada data yang ditemukan',
    'perPage' => 10
])

@php
    // Default columns jika tidak disediakan
    $defaultColumns = [];
    
    // Jika columns kosong, buat dari data pertama
    if(empty($columns) && count($data) > 0) {
        $firstItem = $data->first() ?? collect($data)->first();
        if($firstItem) {
            foreach($firstItem->getAttributes() as $key => $value) {
                $defaultColumns[$key] = [
                    'label' => ucwords(str_replace('_', ' ', $key)),
                    'sortable' => true
                ];
            }
        }
    }
    
    $tableColumns = !empty($columns) ? $columns : $defaultColumns;
    // dd(in_array('edit', $actions));
@endphp

<div class="dark:bg-zinc-900 rounded-xl border border-zinc-700 overflow-hidden shadow-lg fade-in">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-700">
            <thead class="bg-zinc-800">
                <tr>
                    @if($withNumber)
                    <th scope="col" class="px-4 md:px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        <div class="flex items-center gap-1">
                            <span>No</span>
                        </div>
                    </th>
                    @endif

                    @foreach($tableColumns as $columnKey => $columnConfig)
                        @php
                            $label = is_array($columnConfig) ? ($columnConfig['label'] ?? ucwords(str_replace('_', ' ', $columnKey))) : $columnConfig;
                            $sortable = is_array($columnConfig) ? ($columnConfig['sortable'] ?? true) : true;
                            $width = is_array($columnConfig) ? ($columnConfig['width'] ?? 'auto') : 'auto';
                            $align = is_array($columnConfig) ? ($columnConfig['align'] ?? 'left') : 'left';
                        @endphp
                        
                        <th scope="col" 
                            class="px-4 md:px-6 py-4 text-{{ $align }} text-xs font-medium text-gray-400 uppercase tracking-wider {{ $sortable ? 'cursor-pointer hover:text-white transition group' : '' }}"
                            style="width: {{ $width }}"
                            @if($sortable) onclick="sortTable('{{ $columnKey }}')" @endif>
                            <div class="flex items-center gap-1 {{ $align === 'right' ? 'justify-end' : '' }}">
                                <span>{{ $label }}</span>
                                @if($sortable)
                                <i class="fas fa-sort text-gray-500 group-hover:text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                    @endforeach

                    @if($withActions)
                    <th scope="col" class="px-4 md:px-6 py-4 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Action
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
                @forelse($data as $index => $item)
                <tr class="hover:bg-zinc-800/50 transition-colors duration-200">
                    @if($withNumber)
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-white">
                            @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $index + 1 + (($data->currentPage() - 1) * $data->perPage()) }}
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                    </td>
                    @endif

                    @foreach($tableColumns as $columnKey => $columnConfig)
                        @php
                            if (str_contains($columnKey, '.')) {
                                $value = data_get($item, $columnKey);
                            } else {
                                $value = $item->$columnKey ?? '';
                            }
                            $format = is_array($columnConfig) ? ($columnConfig['format'] ?? 'text') : 'text';
                            $align = is_array($columnConfig) ? ($columnConfig['align'] ?? 'left') : 'left';
                            $customView = is_array($columnConfig) ? ($columnConfig['view'] ?? null) : null;
                        @endphp

                        <td class="px-4 md:px-6 py-4 text-{{ $align }} text-sm">
                            @if($customView)
                                {{-- Custom view untuk kolom --}}
                                @include($customView, ['item' => $item, 'value' => $value])
                            @else
                                {{-- Format default --}}
                                @switch($format)
                                    @case('currency')
                                        <div class="text-white font-semibold">
                                            Rp {{ number_format($value, 0, ',', '.') }}
                                        </div>
                                        @break
                                    
                                    @case('number')
                                        <div class="text-white">
                                            {{ number_format($value) }}
                                        </div>
                                        @break
                                    
                                    @case('percentage')
                                        <div class="flex items-center">
                                            <span class="text-white font-semibold mr-2">{{ $value }}%</span>
                                            <div class="w-16 bg-zinc-600 rounded-full h-2">
                                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $value }}%"></div>
                                            </div>
                                        </div>
                                        @break
                                    
                                    @case('status')
                                        @php
                                            $statusConfig = is_array($columnConfig) ? ($columnConfig['statusConfig'] ?? []) : [];
                                            $statusColors = [
                                                'active' => 'bg-emerald-900/30 text-emerald-400 border-emerald-800/50',
                                                'inactive' => 'bg-amber-900/30 text-amber-400 border-amber-800/50',
                                                'pending' => 'bg-blue-900/30 text-blue-400 border-blue-800/50',
                                                'rejected' => 'bg-red-900/30 text-red-400 border-red-800/50'
                                            ];
                                            $statusColor = $statusColors[$value] ?? $statusColors['pending'];
                                        @endphp
                                        <span class="px-2.5 py-1 text-xs font-medium {{ $statusColor }} rounded-full border">
                                            {{ ucfirst($value) }}
                                        </span>
                                        @break
                                    
                                    @case('badge')
                                        @php
                                            $badgeConfig = is_array($columnConfig) ? ($columnConfig['badgeConfig'] ?? []) : [];
                                            $badgeColor = $badgeConfig[$value] ?? 'bg-blue-900/30 text-blue-400 border-blue-800/50';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }} border">
                                            {{ $value }}
                                        </span>
                                        @break
                                    
                                    @case('date')
                                        <div class="text-white">
                                            {{ \Carbon\Carbon::parse($value)->format('d M Y') }}
                                        </div>
                                        @break
                                    
                                    @case('datetime')
                                        <div class="text-white">
                                            {{ \Carbon\Carbon::parse($value)->format('d M Y H:i') }}
                                        </div>
                                        @break
                                    
                                    @default
                                        <div class="text-white">{{ $value }}</div>
                                        @if(is_array($columnConfig) && isset($columnConfig['subtitle']))
                                            <div class="text-xs text-gray-400 mt-1">
                                                {{ $item->{$columnConfig['subtitle']} ?? '' }}
                                            </div>
                                        @endif
                                @endswitch
                            @endif
                        </td>
                    @endforeach

                    @if($withActions)
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            @if(in_array('view', $actions))
                                <button class="view-item-btn text-zinc-400 hover:text-zinc-300 transition p-1.5 rounded-lg hover:bg-zinc-900/20"
                                        data-id="{{ $item->$primaryKey }}"
                                        @foreach($tableColumns as $colKey => $colConfig)
                                            data-{{ $colKey }}="{{ $colKey }}"
                                        @endforeach>
                                    Show
                                </button>
                            @endif

                            @if(in_array('edit', $actions))
                            <button class="edit-item-btn text-blue-400 hover:text-blue-300 transition p-1.5 rounded-lg hover:bg-blue-900/20"
                                    data-id="{{ $item->$primaryKey }}"
                                    @foreach($tableColumns as $colKey => $colConfig)
                                        data-{{ $colKey }}="{{ $item->$colKey }}"
                                    @endforeach>
                                Edit
                            </button>
                            @endif

                            @if(in_array('delete', $actions))
                            <button class="delete-item-btn text-red-400 hover:text-red-300 transition p-1.5 rounded-lg hover:bg-red-900/20"
                                    data-id="{{ $item->$primaryKey }}"
                                    data-name="{{ $item->nama ?? $item->name ?? 'Item' }}">
                                Delete
                            </button>
                            @endif

                            {{-- Custom actions --}}
                            @foreach($actions as $action)
                                @if(is_array($action) && isset($action['type']))
                                    <button class="{{ $action['class'] ?? 'text-gray-400 hover:text-gray-300' }} transition p-1.5 rounded-lg hover:bg-gray-900/20"
                                            data-id="{{ $item->$primaryKey }}"
                                            title="{{ $action['title'] ?? '' }}">
                                        <i class="{{ $action['icon'] ?? 'fas fa-cog' }}"></i>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($tableColumns) + ($withNumber ? 1 : 0) + ($withActions ? 1 : 0) }}" 
                        class="px-4 md:px-6 py-8 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p class="text-lg font-medium">{{ $emptyMessage }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator && $data->hasPages())
    <div class="px-4 md:px-6 py-4 border-t border-zinc-700 bg-zinc-800">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <div class="text-sm text-gray-400">
                Menampilkan <span class="font-medium text-white">{{ $data->firstItem() }} - {{ $data->lastItem() }}</span> dari 
                <span class="font-medium text-white">{{ $data->total() }}</span> data
            </div>
            
            <div class="flex items-center space-x-1">
            </div>
            
            <div class="flex items-center space-x-2 text-sm text-gray-400">
                {{ $data->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function sortTable(column) {
    const url = new URL(window.location.href);
    const currentSort = url.searchParams.get('sort');
    const currentOrder = url.searchParams.get('order');
    
    let newOrder = 'asc';
    if (currentSort === column && currentOrder === 'asc') {
        newOrder = 'desc';
    }
    
    url.searchParams.set('sort', column);
    url.searchParams.set('order', newOrder);
    window.location.href = url.toString();
}

document.addEventListener('DOMContentLoaded', function() {
    // Items per page change
    document.querySelectorAll('.per-page-selector').forEach(select => {
        select.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            window.location.href = url.toString();
        });
    });
    
    // Delete button handler
    document.querySelectorAll('.delete-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.id;
            const itemName = this.dataset.name;
            
            Swal.fire({
                title: 'Hapus Data?',
                text: `Apakah Anda yakin ingin menghapus "${itemName}"?`,
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
                    // Submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ request()->path() }}/${itemId}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush