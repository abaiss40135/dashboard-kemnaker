<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{ config('app.long_name') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/pace/themes/blue/pace-theme-flash.css') }}">

    <link rel="icon" href="{{ asset('img/bhabin/binmas.svg')}}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="{{ asset('vendor/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <style>
        body {
            background-image: url("{{ asset('img/login-bg.jpg') }}") !important;
            background-repeat: repeat;
            background-size: contain;
        }

        @media screen and ( max-width: 412px) {
            body {
                background-size: cover;
            }
        }

        .bg-primary {
            background-color: #274C77 !important;
            color: #fff !important;
        }
    </style>

    @routes
    @include('assets.css.sweetalert2')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="loader-rotate-container">
        <div class="loader-rotate"></div>
    </div>
    <div class="wrapper">
        <button class="btn btn-primary rounded-0" onclick="javascript:window.history.back()">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </button>
        <section class="content-header">
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center mb-4 mt-2" style="gap: 0.8rem">
                <div class="d-sm-flex d-none" style="gap: 0.8rem">
                    <img src="{{ asset('images/icons/baharkam.png') }}" alt="baharkam" style="height: 100px; width: 86px">
                    <img src="{{ asset('images/icons/korbinmas.png') }}" alt="korbinmas" style="height: 100px; width: 86px">
                </div>
                <div class="text-center">
                    <h1 class="text-warning font-weight-bold" style="-webkit-text-stroke: 1.5px #121; font-size: 2.5em; letter-spacing: -1.3px">Dashboard Publik Binmas Online System</h1>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container">
                @include('administrator.sislap.lapsubjar.binkamsa.chart-master-data-satpam')
                @include('administrator.sislap.lapsubjar.binpolmas.chart-binpolmas')
                @include('administrator.sislap.lapsubjar.si-polsus.chart-rekap-diklat-sipolsus')
            </div>
        </section>
    </div>

    <script src="{{ asset('vendor/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/pace/pace.min.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="{{ asset('vendor/admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
        $('[data-toggle="popover"]').popover({
            trigger: 'hover',
            placement: 'right'
        });
    </script>
    @include('assets.js.flash-swal')
    @include('assets.js.axios')
    <script src="{{ asset('js/bos/bosv2.js') }}"></script>
    @stack('scripts')
</body>
</html>
