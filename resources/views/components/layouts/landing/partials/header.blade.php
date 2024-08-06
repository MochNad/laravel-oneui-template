<header id="page-header">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <a class="fw-semibold fs-5 tracking-wider text-dual me-3" href="{{ route('landing.index') }}">
                {{ config('app.name') }}
            </a>
        </div>
        <div class="d-flex align-items-center">
            <div class="d-none d-lg-block">
                <ul class="nav-main nav-main-horizontal nav-main-hover">
                    @if (!empty($helpers['menus']['landing']))
                        @foreach ($helpers['menus']['landing'] as $title => $menus)
                            @foreach ($menus as $menu)
                                @can($menu['module'])
                                    @php
                                        $accessibleChildrenCount = !empty($menu['childrens'])
                                            ? collect($menu['childrens'])
                                                ->filter(function ($child) {
                                                    return auth()
                                                        ->user()
                                                        ->can($child['module']);
                                                })
                                                ->count()
                                            : 0;
                                    @endphp
                                    @if ($accessibleChildrenCount > 0)
                                        <li class="nav-main-item">
                                            <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="true" href="#">
                                                <i class="nav-main-link-icon {{ $menu['icon'] }}"></i>
                                                <span class="nav-main-link-name">{{ ucwords($menu['name']) }}</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                @foreach ($menu['childrens'] as $children)
                                                    @can($children['module'])
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link active"
                                                                href="{{ $children['url'] ? url($children['url']) : 'javascript:void(0)' }}">
                                                                <span
                                                                    class="nav-main-link-name">{{ ucwords($children['name']) }}</span>
                                                            </a>
                                                        </li>
                                                    @endcan
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li class="nav-main-item">
                                            <a class="nav-main-link active"
                                                href="{{ $menu['url'] ? url($menu['url']) : 'javascript:void(0)' }}">
                                                <i class="nav-main-link-icon {{ $menu['icon'] }}"></i>
                                                <span class="nav-main-link-name">{{ ucwords($menu['name']) }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endcan
                            @endforeach
                        @endforeach
                    @endif
                </ul>
            </div>
            @if (auth()->check())
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                        id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <img class="rounded-circle"
                            src="{{ getFileStorageUrl(auth()->user()->profile?->picture, 'assets/media/avatars/avatar10.jpg') }}"
                            alt="Header Avatar" style="width: 21px;">
                        <span class="d-none d-sm-inline-block ms-2">{{ auth()->user()->name }}</span>
                        <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                        aria-labelledby="page-header-user-dropdown">
                        <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                            <img class="img-avatar img-avatar48 img-avatar-thumb"
                                src="{{ getFileStorageUrl(auth()->user()->profile?->picture, 'assets/media/avatars/avatar10.jpg') }}"
                                alt="">
                            <p class="mt-2 mb-0 fw-medium">{{ auth()->user()->name }}</p>
                            <p class="mb-0 text-muted fs-sm fw-medium">{{ auth()->user()->getRoleNames()->first() }}
                            </p>
                        </div>
                        @can('dashboard')
                            <div class="p-2">
                                <a class="dropdown-item d-flex align-items-center justify-content-between"
                                    href="{{ route('dashboard.index') }}">
                                    <span class="fs-sm fw-medium">Dashboard</span>
                                </a>
                            </div>
                        @endcan
                        <div role="separator" class="dropdown-divider m-0"></div>
                        <div class="p-2">
                            @if (auth()->user()->isImpersonated())
                                <form method="POST" action="{{ route('leave-impersonation') }}">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center justify-content-between">
                                        <span class="fs-sm fw-medium">Leave Impersonation</span>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center justify-content-between">
                                        <span class="fs-sm fw-medium">Log Out</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-alt-secondary">
                    <i class="fa fa-fw fa-sign-in-alt"></i>
                    <span class="d-none d-sm-inline-block ms-1">Sign In</span>
                </a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-alt-secondary ms-1">
                    <i class="fa fa-fw fa-user-plus"></i>
                    <span class="d-none d-sm-inline-block ms-1">Sign Up</span>
                </a>
            @endif
            <button type="button" class="btn btn-sm btn-alt-secondary ms-1" data-toggle="layout"
                data-action="dark_mode_toggle">
                <i class="far fa-moon"></i>
            </button>
            <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none ms-1" data-toggle="layout"
                data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
    </div>
    <div id="page-header-search" class="overlay-header bg-body-extra-light">
        <div class="content-header">
            <form class="w-100" method="POST">
                <div class="input-group input-group-sm">
                    <button type="button" class="btn btn-alt-danger" data-toggle="layout"
                        data-action="header_search_off">
                        <i class="fa fa-fw fa-times-circle"></i>
                    </button>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.."
                        id="page-header-search-input" name="page-header-search-input">
                </div>
            </form>
        </div>
    </div>
    <div id="page-header-loader" class="overlay-header bg-primary-lighter">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
            </div>
        </div>
    </div>
</header>
