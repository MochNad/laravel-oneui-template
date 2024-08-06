<script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-cookie/jquery.cookie.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/helpers/mode.js') }}"></script>
<script src="{{ asset('assets/js/helpers/validator.js') }}"></script>
<script src="{{ asset('assets/js/helpers/response.js') }}"></script>
<script src="{{ asset('assets/js/helpers/dropzone.js') }}"></script>
<script src="{{ asset('assets/js/helpers/select2.js') }}"></script>
<script>
    One.helpersOnLoad(['jq-select2']);
</script>
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
