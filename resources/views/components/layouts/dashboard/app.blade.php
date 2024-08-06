<!doctype html>
<html lang="en">

<head>
    <title>{{ $helpers['breadcrumb']['last'] }} | {{ config('app.name') }}</title>
    <x-layouts.dashboard.partials.meta />
    <x-layouts.dashboard.partials.style :style="$style ?? ''" />
</head>

<body>
    <div id="page-container"
        class="sidebar-o sidebar-mini enable-page-overlay side-scroll page-header-fixed main-content-boxed side-trans-enabled {{ $helpers['mode']['dashboard'] }}">
        <x-layouts.dashboard.partials.nav />
        <x-layouts.dashboard.partials.header />
        <x-layouts.dashboard.partials.main :content="$content ?? ''" />
        <x-layouts.dashboard.partials.footer />
    </div>
    <x-layouts.dashboard.partials.script :script="$script ?? ''" />
</body>

</html>
