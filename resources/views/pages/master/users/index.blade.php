<x-layouts.app :title="__('Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <x-title-header :title="__('Users')" :base="__('Masters')"/>
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
