<script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/helpers/validation.js') }}"></script>
<script src="{{ asset('assets/js/helpers/response.js') }}"></script>
@isset($script)
    {{ $script }}
@endisset
