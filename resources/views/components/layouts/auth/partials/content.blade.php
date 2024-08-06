<div class="block-content">
    <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
        <a class="h2 text-dark mb-1" href="{{ route('landing.index') }}">{{ config('app.name') }}</a>
        <p class="fw-medium text-muted">
            {{ $contentHeaderSubTitle ?? '' }}
        </p>
        <form method="POST" action="{{ $contentFormAction ?? '' }}">
            @csrf
            <div class="py-3">
                @isset($contentInputs)
                    @foreach ($contentInputs as $input)
                        <div class="mb-4">
                            @if ($input['type'] === 'checkbox')
                                <input class="form-check-input" type="{{ $input['type'] }}" value="true"
                                    id="{{ $input['id'] }}" name="{{ $input['name'] }}"
                                    data-input-validation="{{ $input['validation'] ?? '' }}"
                                    {{ old($input['name']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $input['id'] }}">
                                    {{ $input['placeholder'] }}
                                </label>
                            @else
                                <input type="{{ $input['type'] }}" class="form-control form-control-alt form-control-lg"
                                    id="{{ $input['id'] }}" name="{{ $input['name'] }}" type="{{ $input['type'] }}"
                                    placeholder="{{ $input['placeholder'] ?? '' }}" value="{{ $input['value'] ?? '' }}"
                                    data-input-validation="{{ $input['validation'] ?? '' }}"
                                    {{ $input['attribute'] ?? '' }}>
                            @endif
                        </div>
                    @endforeach
                @endisset
            </div>
            <div class="row mb-4">
                <div class="col-md-6 col-xl-5">
                    <button type="submit" class="btn w-100 btn-alt-primary">
                        <i class="fa fa-fw {{ $contentButtonSubmitIcon ?? '' }} me-1 opacity-50"></i>
                        {{ $contentButtonSubmitText ?? '' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
