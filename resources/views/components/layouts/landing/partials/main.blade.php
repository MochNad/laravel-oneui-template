<main id="main-container">
    <div class="bg-image" style="background-image: url('assets/media/photos/photo36@2x.jpg');">
        <div class="bg-primary-dark-op py-9 overflow-hidden">
            <div class="content content-full text-center">
                <h1 class="display-4 fw-semibold text-white">
                    {{ $mainHeroTitle ?? '' }}
                </h1>
                <p class="fs-4 fw-normal text-white-50 mb-5">
                    {{ $mainHeroSubtitle ?? '' }}
                </p>
            </div>
        </div>
    </div>
    @isset($mainContent)
        @foreach ($mainContent as $content)
            <div class="{{ $content->itteration % 2 == 0 ? 'bg-body-extra-light' : 'bg-body-light' }}">
                <div class="content content-full">
                    {{ $content['slot'] ?? '' }}
                </div>
            </div>
        @endforeach
    @endisset
</main>
