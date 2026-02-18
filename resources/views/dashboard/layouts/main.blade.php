<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Jamu Niswah Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset("img/logo.png")}}">
    <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/prism/prism.css') }}">

  <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/select2/dist/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/jquery-selectric/selectric.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}"/>


  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/components.css') }}">


<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>

<!-- /END GA --></head>

<body>
  {{-- @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"]) --}}
  @include('sweetalert::alert')
  @include('dashboard/layouts/header')
  @include('dashboard/layouts/sidebar')
  @yield('body')
  @include('dashboard/layouts/footer')


  <!-- General JS Scripts -->
  <script src="{{ asset('dashboard/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/popper.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('dashboard/assets/modules/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/chart.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/prism/prism.js') }}"></script>

  <script src="{{ asset('dashboard/assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>


  <!-- Page Specific JS File -->
  <script src="{{ asset('dashboard/assets/js/page/index.js ')}}"></script>
  <script src="{{ asset('dashboard/assets/js/page/modules-datatables.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/page/modules-sweetalert.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/page/bootstrap-modal.js') }}"></script>

  <script src="{{ asset('dashboard/assets/js/page/forms-advanced-forms.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('dashboard/assets/js/scripts.js')}}"></script>
  <script src="{{ asset('dashboard/assets/js/custom.js')}}"></script>

  <script type="text/javascript">

    $('.show_confirm').click(function(event) {
         var form =  $(this).closest("form");
         var name = $(this).data("name");
         event.preventDefault();
         swal({
             title: `Are you sure you want to delete this data?`,
             text: "If you delete this, it will be gone forever.",
             icon: "warning",
             buttons: true,
             dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
             form.submit();
           }
         });
     });

</script>
</body>
</html>
