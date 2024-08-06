<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    @if (isset($helpers['breadcrumb']['first']))
                        <h1 class="h3 fw-bold mb-1">
                            {{ $helpers['breadcrumb']['first'] }}
                        </h1>
                    @endif
                    @if (isset($helpers['breadcrumb']['second_last']))
                        <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                            {{ $helpers['breadcrumb']['second_last'] }}
                        </h2>
                    @endif
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        @foreach ($helpers['breadcrumb']['all'] as $breadcrumb)
                            @if ($loop->first || $loop->last)
                                <li class="breadcrumb-item" arial-current="page">
                                    {{ $breadcrumb['name'] }}
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    <a class="link-fx" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        {{ $content }}
    </div>
</main>
