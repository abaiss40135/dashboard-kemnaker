@php
    $configData = \App\Helpers\AppHelper::applClasses();
    $detect = new \Detection\MobileDetect();
@endphp
<!doctype html>
<html lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.long_name') }}</title>
    @laravelPWA

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"
          crossorigin="anonymous">
    <link rel="icon" href="{{asset('img/bhabin/binmas.svg')}}" sizes="144x144" type="image/svg">

    <link rel="stylesheet" href="{{ asset('css/pace/pace-white-flash.css') }}">

    <!-- md bootstrap -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="{{asset('css/tampilan-baru-bhabin/footer.css')}}">

    @include('assets.css.sweetalert2')
    <style>
        .img-profile {
            width: 43px !important;
            height: 43px !important;
            object-fit: cover;
            object-position: center;
        }

        .img-splash {
            width: 80px !important;
            height: 80px !important;
            object-fit: cover;
            object-position: center;
        }

        video + div {
            padding: 0.5em 1em 0.75em;
        }

        video + div p {
            margin-bottom: 0.135em;
        }

        .bg-primary {
            background-color: #274c77!important;
        }

        /* Search Bar    */
        .overlay {
            height: 100%;
            width: 100%;
            display: none;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .overlay-content {
            position: relative;
            margin-left: 5%;
            margin-right: 5%;
            top: 40%;
            width: 90%;
            text-align: center;
        }

        .overlay .closebtn {
            position: absolute;
            top: 20px;
            right: 45px;
            font-size: 60px;
            cursor: pointer;
            color: white;
        }

        .overlay .closebtn:hover {
            color: #ccc;
        }

        .overlay input[type=text] {
            padding: 15px;
            font-size: 17px;
            border: none;
            float: left;
            width: 80%;
            background: white;
        }

        .overlay input[type=text]:hover {
            background: #f1f1f1;
        }

        .overlay button {
            float: left;
            width: 20%;
            padding: 15px;
            background: #ddd;
            font-size: 17px;
            border: none;
            cursor: pointer;
        }

        .overlay button:hover {
            background: #bbb;
        }

        #pencarian-umum::placeholder {
            color: #fff;
            text-align: center;
        }

        .hamburger .menu, .profile .menu {
            list-style-type: none;
            padding: 0;
            position: absolute;
            top: 0;
            flex-direction: column;
            width: 20%;
            background-color: @if(role('bhabinkamtibmas')) #1E4588 @else #292929 @endif;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 90px;
        }

        .hamburger .menu {
            margin-left: 10px;
            left: 0;
        }

        .profile .menu {
            right: 50px;
        }

        .menu > li {
            overflow: hidden;

            display: flex;
            justify-content: center;
            align-items: center;


            width: 90%;
            background-color: @if(role('bhabinkamtibmas')) #ffffff @else #4C4C4C  @endif;

            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            border-radius: 4px;
        }

        .menu > li > a {
            color: @if(role('bhabinkamtibmas')) #1E4588 @else #FFE600 @endif;
        }

        .hamburger .menu > li:first-child {
            background-color: #970000;
        }

        .hamburger .menu-button-container {
            display: flex;
            height: 100%;
            width: 30px;
            cursor: pointer;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hamburger #menu-toggle {
            display: none;
        }

        #profile-toggle {
            opacity: 0;
            position: absolute;
            top: 20px;
            cursor: pointer;
            width: 80px;
            height: 40px;
        }

        .hamburger .menu-button,
        .hamburger .menu-button::before,
        .hamburger .menu-button::after {
            display: block;
            background-color: #fff;
            position: absolute;
            height: 4px;
            width: 30px;
            transition: transform 400ms cubic-bezier(0.23, 1, 0.32, 1);
            border-radius: 2px;
            margin-right: 100px;
        }

        .hamburger .menu-button::before {
            content: "";
            margin-top: -8px;
        }

        .hamburger .menu-button::after {
            content: "";
            margin-top: 8px;
        }

        .hamburger #menu-toggle:checked + .hamburger .menu-button-container .hamburger .menu-button::before {
            margin-top: 0px;
            transform: rotate(405deg);
        }

        .hamburger #menu-toggle:checked + .hamburger .menu-button-container .hamburger .menu-button {
            background: rgba(255, 255, 255, 0);
        }

        .hamburger #menu-toggle:checked + .hamburger .menu-button-container .hamburger .menu-button::after {
            margin-top: 0px;
            transform: rotate(-405deg);
        }

        #menu-toggle ~ .menu li,
        #profile-toggle ~ .menu li {
            height: 0;
            margin: 0;
            padding: 0;
            border: 0;
            transition: height 400ms cubic-bezier(0.23, 1, 0.32, 1);
        }

        #menu-toggle:checked ~ .menu li,
        #profile-toggle:checked ~ .menu li {
            border: 1px solid #333;
            height: 2.5em;
            margin: 10px;
            padding: 20px;
            transition: height 400ms cubic-bezier(0.23, 1, 0.32, 1);
        }

        .card-pusat-informasi {
            background-color: @if(role('bhabinkamtibmas')) #BADAFF @else #969696 @endif;
            padding: 10px 30px 15px 30px;
            border-radius: 20px;
            border: 3px solid @if(role('bhabinkamtibmas')) #1E4588 @else #000000 @endif;
        }

        .uu-container {
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            border: 2px solid @if(role('bhabinkamtibmas')) #0B3377 @else #000000 @endif;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .logout-button:hover {
            background: transparent;
        }
    </style>
    @yield('customcss')
    @stack('styles')
    @routes
</head>
<body class="{{ ($configData['theme'] === 'light') ? 'light' : $configData['layoutTheme'] }}" data-menu="horizontal-menu" data-open="hover" data-layout="{{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}" style="{{ $configData['bodyStyle'] }}" data-framework="laravel" data-asset-path="{{ asset('/')}}">
    @include('sweetalert::alert')
    @if(!isset($exception))
        @if(auth()->check() && auth()->user()->haveRole(['satpam', 'bhabinkamtibmas', 'administrator', 'bhabinkamtibmas_pensiun', 'polsus']))
            @if(!$detect->isMobile() && !$detect->isTablet())
                @component('templates.bhabin-baru.navbar') @endcomponent
            @else
                @component('templates.bhabin.navbar') @endcomponent
            @endif
        @elseif(role('publik'))
            @if(!Str::contains(url()->current(), 'create'))
                @component('components.navbar.navbar-publik') @endcomponent
            @endif
        @endif
    @endif
    @if(auth()->check() && ($detect->isMobile() || $detect->isTablet()))
        @include('components.navbar.mobile-menu')
    @endif
    <div class="loader-rotate-container">
        <div class="loader-rotate"></div>
    </div>
    @yield('mainComponent')
    @if(auth()->check() && !isset($exception))
        @if($detect->isMobile() || $detect->isTablet())
            <footer class="footer {{ $configData['footerColor'] }}">
                <div style="background: #091833;" class="p-1"></div>
                <div style="background: #1E4588; white-space: normal;" class="text-center text-white footer-alamat p-3 pb-1">
                    <h5>KORBINMAS BAHARKAM POLRI</h5>
                    <p>Jl. Trunojoyo No. 3, Kebayoran Baru, Jakarta Selatan, DKI Jakarta. 12110 (021) 7218141</p>
                </div>
                <div class="signature" style="background:#091833;">
                    <p class="text-center" style="color: #A7BEE5; font-size: 10px;">
                        Copyright © {{ date('Y') }} Kepolisian Negara Republik Indonesia
                    </p>
                </div>
                <div class="py-4"></div>
                <div class="py-3"></div>
                <div class="py-2"></div>
            </footer>
        @else
            @component('templates.bhabin.tampilan-baru.footer') @endcomponent
        @endif
    @endif
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendor/pace/pace.min.js') }}"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @include('assets.js.flash-swal')
    <script src="{{ asset('js/bos/bosv2.js') }}"></script>
    <script>
        function openSearchHero() {
            document.getElementById("FullScreenOverlay").style.display = "block";
        }

        function closeSearchHero() {
            document.getElementById("FullScreenOverlay").style.display = "none";
        }

        @if (role('bhabinkamtibmas'))
        if (window.location.href == route('bhabinkamtibmas') && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                $.ajax({
                    url: route('location.store'),
                    type: "POST",
                    data: {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response?.message);
                    }
                });
            });
        }
        @endif
    </script>

    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    @include('components.firebase.config', ['firebaseConfig' => config('fcm.config')])

    @yield('customjs')
    @stack('scripts')
</body>
</html>
