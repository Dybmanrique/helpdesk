<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('coreui/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('coreui/css/vendors/simplebar.css') }}">
    <!-- DataTables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.min.css">
    <!-- FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Main styles for this application-->
    <link href="{{ asset('coreui/css/style.css') }}" rel="stylesheet">
    <!-- Local Styles -->
    <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">
    <!-- Livewire Styles -->
    @livewireStyles
    @yield('css')
    @stack('css')
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
    <!-- JQuery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Sweet Alert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>
    <!-- DataTables-->
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.min.js"></script>
    <!-- Local scripts-->
    <script>
        window.App = {
            permissions: @json(auth()->user()->getAllPermissions()->pluck('name'))
        };
    </script>
    <script src="{{ asset('js/helpers.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script type="module" src="{{ asset('js/Utils.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/admin/dashboard.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/admin/toast.js') }}?v={{ env('APP_VERSION') }}"></script>
    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Section to include additional scripts -->
    @yield('js')
    @stack('js')

</body>

</html>
