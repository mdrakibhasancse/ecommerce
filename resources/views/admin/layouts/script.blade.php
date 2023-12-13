{{-- @vite('resources/js/app.js') --}}
<!-- jQuery -->
<script src="{{asset("/admin/plugins/jquery/jquery.min.js")}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset("/admin/plugins/jquery-ui/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset("/admin/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- ChartJS -->
<script src="{{asset("/admin/plugins/chart.js/Chart.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{asset("/admin/plugins/sparklines/sparkline.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset("/admin/plugins/jquery-knob/jquery.knob.min.js")}}"></script>
<!-- daterangepicker -->
<script src="{{asset("/admin/plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("/admin/plugins/daterangepicker/daterangepicker.js")}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset("/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}"></script>
<!-- Summernote -->
<script src="{{asset("/admin/plugins/summernote/summernote-bs4.min.js")}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset("/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset("/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("/admin/dist/js/adminlte.js")}}"></script>

<!-- jquery-validation -->
<script src="{{asset("/admin/plugins/jquery-validation/jquery.validate.min.js")}}"></script>
<script src="{{asset("/admin/plugins/jquery-validation/additional-methods.min.js")}}"></script>

<!-- Select2 -->
<script src="{{asset("/admin/plugins/select2/js/select2.full.min.js")}}"></script>

<!-- DataTables -->
<script src="http://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
{{-- toggle.js --}}
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
{{-- toastr.js --}}
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready( function () {
      $('#myTable').DataTable();
      $('#category_id').select2();
      $('#product_id').select2();
  });
</script>

<script>
  $(function () {
    $('#summernote').summernote()
  })
</script>

<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
</script>
