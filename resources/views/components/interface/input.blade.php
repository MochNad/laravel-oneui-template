<form action="{{ $action ?? '' }}" method="POST" class="block" bis_skin_checked="1">
    @csrf
    @if ($put ?? false)
        @method('PUT')
    @endif
    <div class="block-header block-header-default" bis_skin_checked="1">
        <h3 class="block-title">{{ $title ?? '' }}</h3>
        <div class="block-options" bis_skin_checked="1">
            <button type="submit" class="btn btn-sm btn-primary">
                Submit
            </button>
            <button type="reset" class="btn btn-sm btn-alt-primary">
                Reset
            </button>
        </div>
    </div>
    <div class="block-content" bis_skin_checked="1">
        <div class="row justify-content-center py-sm-3 py-md-5" bis_skin_checked="1">
            <div class="col-sm-10 col-md-8" bis_skin_checked="1">
                @foreach ($inputs as $input)
                    @if ($input['type'] == 'select2')
                        <div class="mb-4" bis_skin_checked="1">
                            <label class="form-label"
                                for="{{ $input['id'] ?? '' }}-field">{{ $input['label'] ?? '' }}</label>
                            <select id="{{ $input['id'] ?? '' }}-field" class="js-select2 form-select"
                                data-placeholder="{{ $input['placeholder'] ?? '' }}"
                                data-allow-clear="{{ $input['allowClear'] ?? false }}"
                                data-reference="{{ $input['reference'] ?? '' }}" data-icon="true">
                                @if ($input['allowClear'] ?? false)
                                    <option></option>
                                @endif
                                @isset($input['value'])
                                    <option value="{{ $input['value']['id'] }}" selected>
                                        {{ $input['value']['text'] }}
                                    </option>
                                @endisset
                            </select>
                        </div>
                    @else
                        <div class="mb-4" bis_skin_checked="1">
                            <label class="form-label"
                                for="{{ $input['id'] ?? '' }}-field">{{ $input['label'] ?? '' }}</label>
                            <input type="{{ $input['type'] ?? '' }}" class="form-control form-control-alt"
                                id="{{ $input['id'] ?? '' }}-field" name="{{ $input['name'] ?? '' }}"
                                placeholder="{{ $input['placeholder'] ?? '' }}" value="{{ $input['value'] ?? '' }}"
                                data-input-validation="{{ $input['validation'] ?? '' }}"
                                {{ $input['attribute'] ?? '' }}>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</form>
