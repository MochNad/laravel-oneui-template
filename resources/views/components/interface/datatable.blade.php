<div class="block" bis_skin_checked="1">
    <div class="block-header block-header-default" bis_skin_checked="1">
        <h3 class="block-title">
            DataTable <small>{{ ucwords(str_replace('-', ' ', $description ?? '')) }}</small>
        </h3>
        <div class="block-options d-flex justify-content-center align-items-center gap-2" bis_skin_checked="1">
            @isset($filters)
                @foreach ($filters as $filter)
                    <select id="{{ $filter['id'] ?? '' }}-filter" name="{{ $filter['name'] ?? '' }}"
                        class="js-select2 form-select" data-placeholder="{{ $filter['placeholder'] }}"
                        data-allow-clear="{{ $filter['allowClear'] ?? false }}"
                        data-reference="{{ $filter['reference'] ?? '' }}" data-table="{{ $filter['table'] }}"
                        data-action-filter>
                        @if ($filter['allowClear'])
                            <option></option>
                        @endif
                        @isset($filter['value'])
                            <option value="{{ $filter['value']['id'] }}" selected>
                                {{ $filter['value']['text'] }}
                            </option>
                        @endisset
                    </select>
                @endforeach
            @endisset
            <x-interface.action name="{{ strtolower($description ?? '') }}" :create="$create" />
        </div>
    </div>
    <div class="block-content block-content-full overflow-x-auto" bis_skin_checked="1">
        {{ $dataTable ?? '' }}
    </div>
</div>
