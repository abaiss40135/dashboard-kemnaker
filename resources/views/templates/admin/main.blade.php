<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="732390917608-9r9gi63glh7sa2s967v58977kprk01cj.apps.googleusercontent.com">
    @yield('meta-tag')
    <title>{{ config('app.long_name') }}</title>

    <link rel="icon" href="{{ asset('img/bhabin/binmas.svg')}}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/admin/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/summernote/summernote-bs4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/pace/themes/blue/pace-theme-flash.css') }}">

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="{{ asset('vendor/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <style>
        body {
            overflow: auto;
        }
        .bg-primary {
            background-color: #274C77 !important;
            color: #fff !important;
        }

        .alert-gray {
            color: #fff;
            background-color: slategray;
            border-color: slategray;
        }

        .table-primary thead th {
            background: #1E4588;
            border-color: inherit;
            color: #fff;
            text-align: center;
        }

        .table-primary {
            background-color: unset;
        }

        .table-primary td {
            border: 1px solid #dee2e6;
        }
    </style>
    @routes
    @include('assets.css.sweetalert2')
    @yield('customcss')
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @yield('loader')
    <div class="loader-rotate-container">
        <div class="loader-rotate"></div>
    </div>

    <div class="loader-container">

    </div>
    @include('sweetalert::alert')
    {{-- navbar --}}
    @if (roles(array_merge(['administrator', 'pimpinan_polri', 'operator_polda', 'operator_mabes', 'operator_mabes_2', 'operator_divhumas', 'operator_konten'], \App\Helpers\Constants::OPERATOR_BHABINKAMTIBMAS, \App\Helpers\Constants::OPERATOR_BAGOPSNALEV)))
    @include('templates.admin.navbar-admin')
    @endif
    {{-- sidebar --}}
    @include('templates.admin.sidebar-binmas')
    @yield('mainComponent')
    @stack('modals')
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- PACE -->
    <script src="{{ asset('vendor/pace/pace.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('vendor/admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('vendor/admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('vendor/admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('vendor/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('vendor/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('vendor/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/admin/dist/js/adminlte.js') }}"></script>
     <!-- Navbar -->
    <script src="{{ asset('vendor/admin/script/navbar.js') }}"></script>
    @include('assets.js.flash-swal')
    @include('assets.js.axios')
    <script src="{{ asset('js/bos/bosv2.js') }}"></script>
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
        placement: 'right'
    });
    // $(function (){
    //     $("body").overlayScrollbars({ });
    // });
    </script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script type="module" src="{{asset("js/fcm_laravel/init_fcm.js")}}"></script>
    @yield('customjs')
    @stack('scripts')
    <!--internal script-->
</body>

</html>
