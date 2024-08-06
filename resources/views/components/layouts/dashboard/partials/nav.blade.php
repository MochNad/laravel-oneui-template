<nav id="sidebar" aria-label="Main Navigation">
    <div class="content-header">
        <a class="fw-semibold text-dual" href="{{ route('landing.index') }}">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-5 tracking-wider">{{ config('app.name') }}</span>
        </a>
        <div>
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                data-action="dark_mode_toggle">
                <i class="far fa-moon"></i>
            </button>
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
        </div>
    </div>

    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                @if (!empty($helpers['menus']['dashboard']))
                    @php
                        $displayedTitles = [];
                    @endphp
                    @foreach ($helpers['menus']['dashboard'] as $title => $menus)
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

                                @if (!empty($title) && !in_array($title, $displayedTitles))
                                    <li class="nav-main-heading">{{ $title }}</li>
                                    @php
                                        $displayedTitles[] = $title;
                                    @endphp
                                @endif

                                @if ($accessibleChildrenCount > 0)
                                    <li class="nav-main-item{{ request()->is($menu['slug'] . '/*') ? ' open' : '' }}">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                            aria-haspopup="true" aria-expanded="false"
                                            href="{{ $menu['url'] ? url($menu['url']) : 'javascript:void(0)' }}">
                                            <i class="nav-main-link-icon {{ $menu['icon'] }}"></i>
                                            <span class="nav-main-link-name">{{ ucwords($menu['name']) }}</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            @foreach ($menu['childrens'] as $children)
                                                @can($children['module'])
                                                    <li class="nav-main-item">
                                                        <a class="nav-main-link{{ request()->is($children['url']) ? ' active' : '' }}"
                                                            href="{{ url($children['url']) }}">
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
                                        <a class="nav-main-link{{ request()->is($menu['url']) ? ' active' : '' }}"
                                            href="{{ url($menu['url']) }}">
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
    </div>
</nav>
