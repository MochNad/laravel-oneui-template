<div class="block-header block-header-default">
    <h3 class="block-title">{{ $headerBlockTitle }}</h3>
    <div class="block-options">
        @if (!$headerHrefOptionForm)
            @if ($headerHrefOptionText !== '')
                <a class="btn-block-option fs-sm" href="{{ $headerHrefOptionText }}"
                    @if ($headerHrefOptionText === 'javascript:void(0)') data-bs-toggle="modal" data-bs-target="#one-signup-terms" @endif>
                    {{ $headerOptionText }}
                </a>
            @endif
            <a class="btn-block-option" href="{{ $headerHrefOptionIcon }}" data-bs-toggle="tooltip" data-bs-placement="left"
                title="{{ $headerTitleOptionIcon }}">
                <i class="fa {{ $headerOptionIcon }}"></i>
            </a>
        @else
            <form method="POST" action="{{ $headerHrefOptionIcon }}">
                @csrf
                <button type="submit" class="btn-block-option" data-bs-toggle="tooltip" data-bs-placement="left"
                    title="{{ $headerTitleOptionIcon }}">
                    <i class="fa {{ $headerOptionIcon }}"></i>
                </button>
            </form>
        @endif
    </div>
</div>

@if ($headerHrefOptionText === 'javascript:void(0)')
    <div class="modal fade" id="one-signup-terms" tabindex="-1" role="dialog" aria-labelledby="one-signup-terms"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ $headerTitleModal }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        @foreach ($headerTerms as $term)
                            <p>{{ $term['content'] }}</p>
                        @endforeach
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-primary"
                            data-bs-dismiss="modal">{{ $headerAggreeText }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
