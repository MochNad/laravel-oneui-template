<div class="btn-group" bis-skin-checked="1">
    @isset($create)
        @can($globalModule['create'])
            <button type="button" class="btn btn-sm btn-success js-bs-tooltip-enabled" data-bs-toggle="tooltip"
                aria-label="Create {{ ucwords(str_replace('-', ' ', $name)) }}" data-bs-original-title="Create {{ ucwords(str_replace('-', ' ', $name)) }}" data-action-create
                data-route="{{ $create['routeCreate'] }}" data-modal="#create-{{ $name }}-modal">
                <i class="fa fa-fw fa-plus"></i>
            </button>
        @endcan
    @endisset
    @isset($read)
        @can($globalModule['read'])
            <button type="button" class="btn btn-sm btn-info js-bs-tooltip-enabled" data-bs-toggle="tooltip"
                aria-label="Detail {{ ucwords(str_replace('-', ' ', $name)) }}" data-bs-original-title="Detail {{ ucwords(str_replace('-', ' ', $name)) }}" data-action-read
                data-route="{{ $read['routeRead'] }}" data-modal="#read-{{ $name }}-modal"
                data-column="{{ $column }}">
                <i class="fa fa-fw fa-eye"></i>
            </button>
        @endcan
    @endisset
    @isset($update)
        @can($globalModule['update'])
            <button type="button" class="btn btn-sm btn-warning js-bs-tooltip-enabled" data-bs-toggle="tooltip"
                aria-label="Edit {{ ucwords(str_replace('-', ' ', $name)) }}" data-bs-original-title="Edit {{ ucwords(str_replace('-', ' ', $name)) }}" data-action-edit
                data-route-edit="{{ $update['routeEdit'] }}" data-route-update="{{ $update['routeUpdate'] }}"
                data-modal="#edit-{{ $name }}-modal" data-column="{{ $column }}">
                <i class="fa fa-fw fa-pencil-alt"></i>
            </button>
        @endcan
    @endisset
    @isset($delete)
        @can($globalModule['delete'])
            <button type="button" class="btn btn-sm btn-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip"
                aria-label="Delete {{ ucwords(str_replace('-', ' ', $name)) }}" data-bs-original-title="Delete {{ ucwords(str_replace('-', ' ', $name)) }}"
                data-action-delete data-route="{{ $delete['routeDelete'] }}" data-column="{{ $column }}"
                data-name="{{ $delete['name'] }}">
                <i class="fa fa-fw fa-trash-alt"></i>
            </button>
        @endcan
    @endisset
    @isset($menu)
        @can($globalModule['update'])
            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa fa-fw fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-dropright-primary" bis_skin_checked="1">
                @if ($menu['order'] > 1 && !$menu['is_parent'])
                    <button class="dropdown-item" data-action-menu data-route="{{ $menu['routeOrder'] }}" data-move="up"><i
                            class="fa fa-fw fa-arrow-up me-2"></i>Move Up</button>
                @endif
                @if ($menu['order'] < $menu['count_parent'] && !$menu['is_parent'])
                    <button class="dropdown-item" data-action-menu data-route="{{ $menu['routeOrder'] }}" data-move="down"><i
                            class="fa fa-fw fa-arrow-down me-2"></i>Move Down</button>
                @endif
                @if ($menu['order'] > 1 && $menu['is_parent'])
                    <button class="dropdown-item" data-action-menu data-route="{{ $menu['routeOrder'] }}" data-move="up"><i
                            class="fa fa-fw fa-arrow-up me-2"></i>Move Up</button>
                @endif
                @if ($menu['order'] < $menu['count_child'] && $menu['is_parent'])
                    <button class="dropdown-item" data-action-menu data-route="{{ $menu['routeOrder'] }}" data-move="down"><i
                            class="fa fa-fw fa-arrow-down me-2"></i>Move Down</button>
                @endif
            </div>
        @endcan
    @endisset
    @isset($user)
        @can($globalModule['update'])
            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa fa-fw fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-dropright-primary" bis_skin_checked="1">
                <button class="dropdown-item" data-action-user data-route="{{ $user['routeReset'] }}"><i
                        class="fa fa-fw fa-key me-2"></i>Reset Password</button>
                <button class="dropdown-item" data-action-user data-route="{{ $user['routeImpersonate'] }}"><i
                        class="fa fa-fw fa-user me-2"></i>Impersonate</button>
            </div>
        @endcan
    @endisset
    @isset($role)
        @can($globalModule['update'])
            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa fa-fw fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-dropright-primary" bis_skin_checked="1">
                <button class="dropdown-item" data-action-role data-route-edit="{{ $role['routeEdit'] }}"
                    data-route-update="{{ $role['routeUpdate'] }}" data-modal="#edit-permission-{{ $name }}-modal"
                    data-bs-original-title="Permission {{ ucwords(str_replace('-', ' ', $name)) }}"><i
                        class="fa fa-fw fa-key me-2"></i>Permission</button>
            </div>
        @endcan
    @endisset
</div>
