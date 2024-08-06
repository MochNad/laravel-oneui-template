<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ $title ?? '' }}</h3>
        <div class="block-options">
            <button type="submit" class="btn btn-sm btn-primary" id="{{ $id ?? '' }}-submit">
                Submit
            </button>
            <button type="reset" class="btn btn-sm btn-alt-primary" id="{{ $id ?? '' }}-reset">
                Reset
            </button>
        </div>
    </div>
    <div class="block-content">
        <div class="row justify-content-center py-sm-3 py-md-5">
            <div class="col-sm-10 col-md-8">
                <form class="dropzone d-flex justify-content-center align-items-center" action="{{ $action ?? '' }}"
                    data-dropzone-option="{{ $option ?? '' }}" id="{{ $id ?? '' }}">
                    @csrf
                    @if ($put ?? false)
                        @method('PUT')
                    @endif
                    <div class="dz-default dz-message">
                        <button class="dz-button" type="button">{{ $message ?? '' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
