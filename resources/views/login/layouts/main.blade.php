<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Antik Sumut</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.jpg') }}" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/assets/modules/fontawesome/css/all.min.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/components.css')}}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>

    {{-- @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9']) --}}
    @include('sweetalert::alert')
    @yield('body')



    <!-- General JS Scripts -->
    <script src="{{ asset('dashboard/assets/modules/jquery.min.js')}}"></script>
    <script src="{{ asset('dashboard/assets/modules/popper.js')}}"></script>
    <script src="{{ asset('dashboard/assets/modules/tooltip.js')}}"></script>
    <script src="{{ asset('dashboard/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('dashboard/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{ asset('dashboard/assets/modules/moment.min.js')}}"></script>
    <script src="{{ asset('dashboard/assets/js/stisla.js')}}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('dashboard/assets/js/scripts.js')}}"></script>
    <script src="{{ asset('dashboard/assets/js/custom.js')}}"></script>
</body>

</html>
