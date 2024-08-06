<x-layouts.dashboard.app>
    <x-slot name="content">
        <x-interface.datatable description="menu-{{ $helpers['breadcrumb']['second_last'] }}" :dataTable="$dataTable->table()"
            :create="[
                'routeCreate' => route('menus.' . $type . '.store'),
            ]" />
        @can($globalModule['create'])
            <x-interface.modal :options="[
                'id' => 'menu-' . $type,
                'visible' => 'create',
                'fields' => [
                    [
                        'id' => 'title',
                        'label' => 'title',
                        'type' => 'text',
                        'name' => 'title',
                        'placeholder' => 'enter title',
                        'validation' => 'min:3|only_lowercase|allow: |empty:parent_id',
                    ],
                    [
                        'id' => 'name',
                        'label' => 'name',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'enter name',
                        'validation' => 'min:3|only_lowercase|allow: ',
                        'attribute' => 'required',
                    ],
                    [
                        'id' => 'icon',
                        'label' => 'icon',
                        'type' => 'select2',
                        'name' => 'icon',
                        'placeholder' => 'select icon',
                        'reference' => route('reference.icon'),
                        'icon' => true,
                        'allowClear' => true,
                        'validation' => 'optional',
                    ],
                    [
                        'id' => 'parent_id',
                        'label' => 'parent',
                        'type' => 'select2',
                        'name' => 'parent_id',
                        'placeholder' => 'select parent',
                        'reference' => route('reference.menu'),
                        'icon' => false,
                        'validation' => 'empty:title',
                        'allowClear' => true,
                    ],
                ],
            ]" />
        @endcan
        @can($globalModule['update'])
            <x-interface.modal :options="[
                'id' => 'menu-' . $type,
                'visible' => 'edit',
                'fields' => [
                    [
                        'id' => 'title',
                        'label' => 'title',
                        'type' => 'text',
                        'name' => 'title',
                        'placeholder' => 'enter title',
                        'validation' => 'min:3|only_lowercase|allow: |empty:parent_id',
                    ],
                    [
                        'id' => 'name',
                        'label' => 'name',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'enter name',
                        'validation' => 'min:3|only_lowercase|allow: ',
                        'attribute' => 'required',
                    ],
                    [
                        'id' => 'icon',
                        'label' => 'icon',
                        'type' => 'select2',
                        'name' => 'icon',
                        'placeholder' => 'select icon',
                        'reference' => route('reference.icon'),
                        'icon' => true,
                        'allowClear' => true,
                        'validation' => 'optional',
                    ],
                    [
                        'id' => 'parent_id',
                        'label' => 'parent',
                        'type' => 'select2',
                        'name' => 'parent_id',
                        'placeholder' => 'select parent',
                        'reference' => route('reference.menu'),
                        'icon' => false,
                        'validation' => 'empty:title,icon',
                        'allowClear' => true,
                    ],
                ],
            ]" />
        @endcan
    </x-slot>
    <x-slot name="script">
        {{ $dataTable->scripts() }}
    </x-slot>
</x-layouts.dashboard.app>
