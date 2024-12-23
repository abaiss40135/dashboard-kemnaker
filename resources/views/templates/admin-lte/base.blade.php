<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="732390917608-9r9gi63glh7sa2s967v58977kprk01cj.apps.googleusercontent.com">

    <title>{{ config('app.long_name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/crmhq/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/skin_color.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/tailwind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/vendors_css.css') }}">

    <link rel="icon" href="{{ asset('img/logo_kemnaker_saja_biru.png') }}?v=2">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="{{ asset('vendor/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    @routes

    @include('assets.css.sweetalert2')

    @yield('headUtils')

    @stack('styles')
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed-manu">
    <div class="wrapper">
        <div id="loader"></div>

        @yield('navUtils')

        <div class="content-wrapper ">
            <div class="">
                <section class="content">
                    @if (!empty($title))
                        <h1 class="mt-0 mb-20 text-3xl">{!! $title ?? '' !!}</h1>
                    @endif
                    @yield('content')
                </section>
            </div>
        </div>

        <footer class="main-footer bt-1"></footer>
        <div class="control-sidebar-bg"></div>
    </div>

    @stack('modals')

    <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>

	<script src="{{ asset('js/crmhq/vendors.min.js') }}"></script>
	<script src="{{ asset('assets/icons/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/Flot/jquery.flot.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/Flot/jquery.flot.resize.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/Flot/jquery.flot.pie.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/Flot/jquery.flot.categories.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/echarts/dist/echarts-en.min.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>

	<script src="{{ asset('js/crmhq/tailwind.min.js') }}"></script>
	<script src="{{ asset('js/crmhq/demo.js') }}"></script>
	<script src="{{ asset('js/crmhq/template.js') }}"></script>

    @include('assets.js.flash-swal')

    @yield('bodyUtils')

    @include('assets.js.select2')

    @stack('scripts')
</body>

</html>
