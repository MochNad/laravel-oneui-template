<x-layouts.dashboard.app>
    <x-slot name="content">
        <x-interface.datatable description="{{ $helpers['breadcrumb']['second_last'] }}" :dataTable="$dataTable->table()"
            :create="[
                'routeCreate' => route('user.store'),
            ]" />
        @can($globalModule['create'])
            <x-interface.modal :options="[
                'id' => 'user',
                'visible' => 'create',
                'fields' => [
                    [
                        'id' => 'name',
                        'label' => 'name',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'enter name',
                        'validation' => 'min:3|only_letters|allow: ',
                        'attribute' => 'required',
                    ],
                    [
                        'id' => 'email',
                        'label' => 'email',
                        'type' => 'email',
                        'name' => 'email',
                        'placeholder' => 'enter email',
                        'validation' => 'email',
                        'attribute' => 'required',
                    ],
                    [
                        'id' => 'role_id',
                        'label' => 'role',
                        'type' => 'select2',
                        'name' => 'role_id',
                        'placeholder' => 'select role',
                        'reference' => route('reference.role'),
                        'icon' => false,
                        'allowClear' => false,
                        'attribute' => 'required',
                    ],
                ],
            ]" />
        @endcan
        @can($globalModule['update'])
            <x-interface.modal :options="[
                'id' => 'user',
                'visible' => 'edit',
                'fields' => [
                    [
                        'id' => 'name',
                        'label' => 'name',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'enter name',
                        'validation' => 'min:3|only_letters|allow: ',
                        'attribute' => 'required',
                    ],
                    [
                        'id' => 'email',
                        'label' => 'email',
                        'type' => 'email',
                        'name' => 'email',
                        'placeholder' => 'enter email',
                        'validation' => 'email',
                        'attribute' => 'required',
                    ],
                    [
                        'id' => 'role_id',
                        'label' => 'role',
                        'type' => 'select2',
                        'name' => 'role_id',
                        'placeholder' => 'select role',
                        'reference' => route('reference.role'),
                        'icon' => false,
                        'allowClear' => false,
                        'attribute' => 'required',
                    ],
                ],
            ]" />
        @endcan
    </x-slot>
    <x-slot name="script">
        {{ $dataTable->scripts() }}
    </x-slot>
</x-layouts.dashboard.app>
