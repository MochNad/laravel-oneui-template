<!doctype html>
<html lang="en">

<head>
    <title>
        {{ $helpers['breadcrumb']['first'] !== '' ? $helpers['breadcrumb']['first'] . ' | ' . config('app.name') : config('app.name') }}
    </title>
    <x-layouts.landing.partials.meta />
    <x-layouts.landing.partials.style :style="$style ?? ''" />
</head>

<body>
    <div id="page-container" class="side-scroll page-header-fixed main-content-boxed {{ $helpers['mode']['dashboard'] }}">
        <x-layouts.landing.partials.nav />
        <x-layouts.landing.partials.header />
        <x-layouts.landing.partials.main :mainHeroTitle="$mainHeroTitle ?? ''" :mainHeroSubtitle="$mainHeroSubtitle ?? ''" :mainContent="$mainContent ?? []" />
        <x-layouts.landing.partials.footer />
    </div>
    <x-layouts.landing.partials.script :script="$script ?? ''" />
</body>

</html>
