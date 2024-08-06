<x-layouts.dashboard.app>
    <x-slot name="content">
        <x-interface.datatable description="{{ $helpers['breadcrumb']['second_last'] }}" :dataTable="$dataTable->table()"
            :create="[
                'routeCreate' => route('authorizations.role.store'),
            ]" />
        @can($globalModule['create'])
            <x-interface.modal :options="[
                'id' => 'role',
                'visible' => 'create',
                'fields' => [
                    [
                        'id' => 'name',
                        'label' => 'name',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'enter name',
                        'value' => '',
                        'validation' => 'min:3|only_lowercase|allow:-',
                        'attribute' => 'required',
                    ],
                ],
            ]" />
        @endcan
        @can($globalModule['update'])
            <x-interface.modal :options="[
                'id' => 'role',
                'visible' => 'edit',
                'fields' => [
                    [
                        'id' => 'name',
                        'label' => 'name',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'enter name',
                        'value' => '',
                        'validation' => 'min:3|only_lowercase|allow:-',
                        'attribute' => 'required',
                    ],
                ],
            ]" />
        @endcan
        @can($globalModule['update'])
            <x-interface.modal :options="[
                'id' => 'role',
                'visible' => 'edit-permission',
            ]" />
        @endcan
    </x-slot>
    <x-slot name="script">
        {{ $dataTable->scripts() }}
    </x-slot>
</x-layouts.dashboard.app>
