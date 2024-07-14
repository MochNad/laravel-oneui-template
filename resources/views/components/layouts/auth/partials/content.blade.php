<div class="block-content">
    <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
        <h1 class="h2 mb-1">{{ $headerTitle }}</h1>
        <p class="fw-medium text-muted">
            {{ $headerSubTitle }}
        </p>
        <form method="POST" action="{{ $formAction }}">
            @csrf
            <div class="py-3">
                @isset($inputs)
                    @foreach ($inputs as $input)
                        <div class="mb-4">
                            @if (
                                $input['type'] === 'email' ||
                                    $input['type'] === 'password' ||
                                    $input['type'] === 'text' ||
                                    $input['type'] === 'hidden')
                                <input type="{{ $input['type'] }}" class="form-control form-control-alt form-control-lg"
                                    id="{{ $input['id'] }}" name="{{ $input['name'] }}" type="{{ $input['type'] }}"
                                    placeholder="{{ $input['placeholder'] ?? '' }}" value="{{ $input['value'] ?? '' }}"
                                    data-input-validation="{{ $input['validation'] ?? '' }}" {{ $input['attribute'] ?? '' }}>
                            @elseif ($input['type'] === 'checkbox')
                                <input class="form-check-input" type="{{ $input['type'] }}" value="true"
                                    id="{{ $input['id'] }}" name="{{ $input['name'] }}"
                                    data-input-validation="{{ $input['validation'] }}"
                                    {{ old($input['name']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $input['id'] }}">
                                    {{ $input['placeholder'] }}
                                </label>
                            @endif
                        </div>
                    @endforeach
                @endisset
            </div>
            <div class="row mb-4">
                <div class="col-md-6 col-xl-5">
                    <button type="submit" class="btn w-100 btn-alt-primary">
                        <i class="fa fa-fw {{ $buttonIcon }} me-1 opacity-50"></i> {{ $buttonText }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
