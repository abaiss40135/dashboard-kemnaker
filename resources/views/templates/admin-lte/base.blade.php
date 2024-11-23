<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="732390917608-9r9gi63glh7sa2s967v58977kprk01cj.apps.googleusercontent.com">

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

        .table-primary {
            background-color: unset;
        }

        .table-primary thead th {
            background: #1E4588;
            border-color: inherit;
            color: #fff;
            text-align: center;
        }

        .table-primary td {
            border: 1px solid #dee2e6;
        }
    </style>

    @routes
    @include('assets.css.sweetalert2')
    @yield('headUtils')
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="loader-rotate-container">
        <div class="loader-rotate"></div>
    </div>
    <div class="wrapper">
        @yield('navUtils')
        <div class="content-wrapper">
            @if (!empty($title))
            <section class="content-header">
                <div class="container-fluid d-flex align-items-center justify-content-between">
                    <h1 class="mb-0 p-2 h3">{!! $title ?? '' !!}</h1>
                    <ol class="breadcrumb float-sm-right d-none d-md-flex align-items-center justify-content-end mb-0 p-2 bg-none">
                        <li class="breadcrumb-item-none">
                            <i class="fas fa-home mr-2"></i>
                        </li>
                    </ol>
                </div>
            </section>
            @endif
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
            @stack('modals')
        </div>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
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
    <script src="{{ asset('vendor/admin/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('vendor/admin/script/navbar.js') }}"></script>
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
    @yield('bodyUtils')
    @stack('scripts')
</body>
</html>
