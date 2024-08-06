<div class="modal fade" id="{{ $options['visible'] ?? '' }}-{{ $options['id'] ?? '' }}-modal" tabindex="-1" role="dialog"
    aria-labelledby="{{ $options['visible'] ?? '' }}-{{ $options['id'] ?? '' }}-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form>
                    @csrf
                    @if ($options['visible'] === 'edit' || $options['visible'] === 'edit-permission')
                        @method('PUT')
                    @endif
                    <div class="block-content fs-sm">
                        @if ($options['visible'] === 'read')
                            @can($globalModule['read'])
                                <div class="row">
                                    @foreach ($options['fields'] as $field)
                                        <div class="col-4">
                                            <p class="fw-bolder">
                                                {{ ucwords(str_replace('_', ' ', $field)) }}</p>
                                        </div>
                                        <div class="col-1">
                                            <p class="fw-semibold text-center">:</p>
                                        </div>
                                        <div class="col-7">
                                            <p class="fw-light"
                                                id="{{ $options['visible'] ?? '' }}-{{ $options['id'] ?? '' }}-modal-{{ $field }}">
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endcan
                        @endif
                        @if ($options['visible'] === 'create' || $options['visible'] === 'edit')
                            <div class="row">
                                @foreach ($options['fields'] as $field)
                                    @if ($field['type'] == 'select2')
                                        <div class="mb-4" bis_skin_checked="1">
                                            <label class="form-label"
                                                for="{{ $field['id'] ?? '' }}-field">{{ ucwords($field['label'] ?? '') }}</label>
                                            <select id="{{ $field['id'] ?? '' }}-field"
                                                name="{{ $field['name'] ?? '' }}" class="js-select2 form-select"
                                                data-placeholder="{{ ucwords($field['placeholder']) }}"
                                                data-allow-clear="{{ $field['allowClear'] ?? false }}"
                                                data-reference="{{ $field['reference'] ?? '' }}"
                                                data-icon="{{ $field['icon'] ?? false }}"
                                                data-input-validation="{{ $field['validation'] ?? '' }}"
                                                {{ $field['attribute'] ?? '' }}>
                                                @if ($field['allowClear'])
                                                    <option></option>
                                                @endif
                                                @isset($field['value'])
                                                    <option value="{{ $field['value']['id'] }}" selected>
                                                        {{ $field['value']['text'] }}
                                                    </option>
                                                @endisset
                                            </select>
                                        </div>
                                    @elseif ($field['type'] == 'checkbox')
                                        <div class="mb-4">
                                            <label class="form-label">{{ ucwords($field['label'] ?? '') }}</label>
                                            <div class="space-x-2">
                                                @foreach ($field['options'] as $option)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $option['value'] }}"
                                                            id="{{ $option['id'] }}-field"
                                                            name="{{ $option['name'] }}"
                                                            {{ $option['checked'] ?? '' }}>
                                                        <label class="form-check-label"
                                                            for="{{ $option['id'] }}-field">
                                                            {{ ucwords($option['label']) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-4" bis_skin_checked="1">
                                            <label class="form-label"
                                                for="{{ $field['id'] ?? '' }}-field">{{ ucwords($field['label'] ?? '') }}</label>
                                            <input type="{{ $field['type'] ?? '' }}"
                                                class="form-control form-control-alt"
                                                id="{{ $field['id'] ?? '' }}-field" name="{{ $field['name'] ?? '' }}"
                                                placeholder="{{ ucwords($field['placeholder']) }}"
                                                value="{{ $field['value'] ?? '' }}"
                                                data-input-validation="{{ $field['validation'] ?? '' }}"
                                                {{ $field['attribute'] ?? '' }}>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        @if ($options['visible'] === 'create' || $options['visible'] === 'edit' || $options['visible'] === 'edit-permission')
                            <button type="submit" class="btn btn-sm btn-primary">
                                Submit
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
