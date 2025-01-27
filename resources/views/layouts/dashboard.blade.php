<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <title>@yield('title')</title>
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('coreui/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('coreui/css/vendors/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('coreui/css/style.css') }}" rel="stylesheet">
    <!-- Local Styles -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div id="preloader">
        <div id="loader"></div>
    </div>
    @include('partials.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">
        @include('partials.navbar')


        <div class="body flex-grow-1">
            {{-- The container-lg class was removed --}}
            <div class="px-4 pb-4">
                @yield('content')
            </div>
        </div>
        <footer class="footer px-4">
            <div class="ms-auto">UGEL ASUNCIÓN - 2025</div>
        </footer>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('coreui/vendors/simplebar/js/simplebar.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('coreui/vendors/@coreui/utils/js/index.js') }}"></script>
    <script src="{{ asset('coreui/js/colors.js') }}"></script>
    <script src="{{ asset('coreui/js/config.js') }}"></script>
    <script src="{{ asset('coreui/js/color-modes.js') }}"></script>
    <!-- Local scripts-->
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>

    <!-- Section to include additional scripts -->
    @yield('js')
</body>

</html>
