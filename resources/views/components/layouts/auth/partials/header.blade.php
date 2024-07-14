<div class="block-header block-header-default">
    <h3 class="block-title">{{ $blockTitle }}</h3>
    <div class="block-options">
        @if (!$hrefOptionForm)
            <a class="btn-block-option fs-sm" href="{{ $hrefOptionText }}"
                @if ($hrefOptionText === 'javascript:void(0)') data-bs-toggle="modal" data-bs-target="#one-signup-terms" @endif>
                {{ $optionText }}
            </a>
            <a class="btn-block-option" href="{{ $hrefOptionIcon }}" data-bs-toggle="tooltip" data-bs-placement="left"
                title="{{ $titleOptionIcon }}">
                <i class="fa {{ $optionIcon }}"></i>
            </a>
        @else
            <form method="POST" action="{{ $hrefOptionIcon }}">
                @csrf
                <button type="submit" class="btn-block-option" data-bs-toggle="tooltip" data-bs-placement="left"
                    title="{{ $titleOptionIcon }}">
                    <i class="fa {{ $optionIcon }}"></i>
                </button>
            </form>
        @endif
    </div>
</div>

@if ($hrefOptionText === 'javascript:void(0)')
    <div class="modal fade" id="one-signup-terms" tabindex="-1" role="dialog" aria-labelledby="one-signup-terms"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ $titleModal }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        @foreach ($terms as $term)
                            <p>{{ $term['content'] }}</p>
                        @endforeach
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-primary"
                            data-bs-dismiss="modal">{{ $aggreeText }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
