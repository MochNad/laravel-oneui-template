<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title ?? '' }} | {{ config('app.name') }}</title>
    <x-layouts.auth.partials.meta :description="$description ?? ''" :author="$author ?? ''" :ogTitle="$ogTitle ?? ''" :ogSiteName="$ogSiteName ?? ''"
        :ogDescription="$ogDescription ?? ''" :ogUrl="$ogUrl ?? ''" :ogImage="$ogImage ?? ''" />
    <x-layouts.auth.partials.style :style="$style ?? ''" />
</head>

<body>
    <div id="page-container">
        <main id="main-container">
            <div class="hero-static d-flex align-items-center">
                <div class="content">
                    <div class="row justify-content-center push">
                        <div class="col-md-8 col-lg-6 col-xl-4">
                            <div class="block block-rounded mb-0">
                                <x-layouts.auth.partials.header :blockTitle="$blockTitle ?? ''" :hrefOptionText="$hrefOptionText ?? ''" :optionText="$optionText ?? ''"
                                    :hrefOptionIcon="$hrefOptionIcon ?? ''" :titleOptionIcon="$titleOptionIcon ?? ''" :optionIcon="$optionIcon ?? ''" :titleModal="$titleModal ?? ''"
                                    :terms="$terms ?? []" :aggreeText="$aggreeText ?? ''" :hrefOptionForm="$hrefOptionForm ?? ''" />
                                <x-layouts.auth.partials.content :headerTitle="$headerTitle ?? ''" :headerSubTitle="$headerSubTitle ?? ''"
                                    :formClass="$formClass ?? ''" :formAction="$formAction ?? ''" :inputs="$inputs ?? []" :checkbox="$checkbox ?? false"
                                    :buttonIcon="$buttonIcon ?? ''" :buttonText="$buttonText ?? ''" />
                            </div>
                        </div>
                    </div>
                    <div class="fs-sm text-muted text-center">
                        <x-layouts.auth.partials.copyright :copyrightText="$copyrightText ?? ''" />
                    </div>
                </div>
            </div>
        </main>
    </div>
    <x-layouts.auth.partials.script :script="$script ?? ''" />
</body>

</html>
