<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $helpers['breadcrumb']['last'] ?? '' }} | {{ config('app.name') }}</title>
    <x-layouts.auth.partials.meta />
    <x-layouts.auth.partials.style :style="$style ?? ''" />
</head>

<body>
    <div id="page-container" class="{{ $helpers['mode']['auth'] ?? '' }}">
        <main id="main-container">
            <div class="hero-static d-flex align-items-center">
                <div class="content">
                    <div class="row justify-content-center push">
                        <div class="col-md-8 col-lg-6 col-xl-4">
                            <div class="block block-rounded mb-0">
                                <x-layouts.auth.partials.header :headerBlockTitle="$headerBlockTitle ?? ''" :headerHrefOptionForm=" $headerHrefOptionForm ?? false" :headerHrefOptionText="$headerHrefOptionText ?? ''"
                                    :headerOptionText="$headerOptionText ?? ''" :headerHrefOptionIcon="$headerHrefOptionIcon ?? ''" :headerOptionIcon="$headerOptionIcon ?? ''" :headerTitleOptionIcon="$headerTitleOptionIcon ?? ''"
                                    :headerTitleModal="$headerTitleModal ?? ''" :headerTerms="$headerTerms ?? []" :headerAggreeText="$headerAggreeText ?? ''" />
                                <x-layouts.auth.partials.content :contentHeaderSubTitle="$contentHeaderSubTitle ?? ''" :contentFormAction="$contentFormAction ?? ''"
                                    :contentInputs="$contentInputs ?? []" :contentButtonSubmitIcon="$contentButtonSubmitIcon ?? ''" :contentButtonSubmitText="$contentButtonSubmitText ?? ''" />
                            </div>
                        </div>
                    </div>
                    <div class="fs-sm text-muted text-center">
                        <x-layouts.auth.partials.copyright />
                    </div>
                </div>
            </div>
        </main>
    </div>
    <x-layouts.auth.partials.script :script="$script ?? ''" />
</body>

</html>
