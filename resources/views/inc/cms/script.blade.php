<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
{{-- Data Table --}}
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
{{-- Pace.js --}}
<script src="{{ asset('plugins/pace-progress/pace.min.js') }}"></script>
{{-- Init Pace --}}
<script>
  $(document).ajaxStart(function() {
    Pace.restart();
  });
</script>
{{-- Sweetalert --}}
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
{{-- Sweetalert Option --}}
<script src="{{ asset('js/cms/sweetalert/option.js') }}"></script>
{{-- Select2 --}}
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
{{-- Developed Script --}}
<script src="{{ asset('js/cms/developed.js') }}"></script>
{{-- Helper --}}
<script src="{{ asset('js/cms/helper.js') }}"></script>
{{-- Push some new script --}}
@stack('script')