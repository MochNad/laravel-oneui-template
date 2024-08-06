<x-layouts.dashboard.app>
    <x-slot name="content">
        <x-interface.datatable description="{{ $helpers['breadcrumb']['second_last'] }}" :dataTable="$dataTable->table()"
            :create="[
                'routeCreate' => route('authorizations.permission.store'),
            ]" />
        @can($globalModule['create'])
            <x-interface.modal :options="[
                'id' => 'permission',
                'visible' => 'create',
                'fields' => [
                    [
                        'id' => 'name',
                        'label' => 'name',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'enter name',
                        'value' => '',
                        'validation' => 'min:3|only_lowercase|allow:.',
                        'attribute' => 'required',
                    ],
                    [
                        'label' => 'access',
                        'type' => 'checkbox',
                        'options' => [
                            [
                                'id' => 'create',
                                'label' => 'create',
                                'value' => true,
                                'name' => 'create',
                                'checked' => 'checked',
                            ],
                            [
                                'id' => 'read',
                                'label' => 'read',
                                'value' => true,
                                'name' => 'read',
                                'checked' => 'checked',
                            ],
                            [
                                'id' => 'update',
                                'label' => 'update',
                                'value' => true,
                                'name' => 'update',
                                'checked' => 'checked',
                            ],
                            [
                                'id' => 'delete',
                                'label' => 'delete',
                                'value' => true,
                                'name' => 'delete',
                                'checked' => 'checked',
                            ],
                        ],
                    ],
                ],
            ]" />
        @endcan
        @can($globalModule['update'])
            <x-interface.modal :options="[
                'id' => 'permission',
                'visible' => 'edit',
                'fields' => [
                    [
                        'id' => 'name',
                        'label' => 'name',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'enter name',
                        'value' => '',
                        'validation' => 'min:3|only_lowercase|allow:.',
                        'attribute' => 'required',
                    ],
                    [
                        'label' => 'access',
                        'type' => 'checkbox',
                        'options' => [
                            [
                                'id' => 'create',
                                'label' => 'create',
                                'value' => true,
                                'name' => 'create',
                                'checked' => 'checked',
                            ],
                            [
                                'id' => 'read',
                                'label' => 'read',
                                'value' => true,
                                'name' => 'read',
                                'checked' => 'checked',
                            ],
                            [
                                'id' => 'update',
                                'label' => 'update',
                                'value' => true,
                                'name' => 'update',
                                'checked' => 'checked',
                            ],
                            [
                                'id' => 'delete',
                                'label' => 'delete',
                                'value' => true,
                                'name' => 'delete',
                                'checked' => 'checked',
                            ],
                        ],
                    ],
                ],
            ]" />
        @endcan
    </x-slot>
    <x-slot name="script">
        {{ $dataTable->scripts() }}
    </x-slot>
</x-layouts.dashboard.app>
