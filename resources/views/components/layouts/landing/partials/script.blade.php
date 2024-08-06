<script src="assets/js/oneui.app.min.js"></script>
<script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-cookie/jquery.cookie.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/helpers/mode.js') }}"></script>
<script src="{{ asset('assets/js/helpers/validator.js') }}"></script>
<script src="{{ asset('assets/js/helpers/response.js') }}"></script>
<script>
    @if (session('flash_message'))
        One.helpers("jq-notify", {
            type: "info",
            icon: "fa fa-info-circle me-1",
            align: "right",
            message: "{{ session('flash_message') }}",
        });
    @endif
</script>
@isset($script)
    {{ $script }}
@endisset
