@extends('templates.core.main')
@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/login/index.css') }}">
    <style>
        body {
            background-image: url("{{ asset('img/bg-kemnaker.png') }}") !important;
            background-size: cover;
            /*background-position: 350px 130px;*/
            /*background-repeat: repeat;*/
            /*background-size: 150px;*/
            /*background-color: rgba(255,255,255,0.8);*/
            /*background-blend-mode: lighten;*/

            /*background-origin: content-box;*/
        }

        .username::after {
            content: '';
            background-image: url("{{ asset('img/bhabin/icon/login/msg.svg') }}");

        }

        .password::after {
            content: '';
            background-image: url("{{ asset('img/bhabin/icon/login/lock.svg') }}");
        }


        @media screen and ( max-width: 412px) {
            body {
                background-repeat: no-repeat
            }

            .logo-image1 {
                display: none;
            }

            .logo-image2 {
                display: block !important;
            }
        }

    </style>
@endsection
@section('mainComponent')
<div class="container">
    <div class="box shadow p-1 border-0" style="overflow: unset">
        <div class="header d-flex align-items-center justify-content-center">
            <img
                src="{{ asset('img/logo-kemnaker.png') }}"
                class="mr-2 mx-auto logo-image1"
                width="300px"
                alt="">
        </div>

        <div
            class="form p-4 d-flex flex-column"
            style="row-gap: 1rem"
        >
            @csrf
            <h1
                class="text-center fw-bold h5"
                style="color: #1E4588">FORM LOGIN - DASHBOARD KETENAGAKERJAAN</h1>

            <div class="form-group username w-100 align-items-center">
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="@error('email') is-invalid @enderror @error('nrp') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="Username"
                    autocomplete="off">
            </div>
            @error('email')
            <div
                class="invalid-feedback mx-auto d-block"
                style="width: 90%; margin-top: -1rem">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            @error('nrp')
            <div
                class="invalid-feedback mx-auto d-block"
                style="width: 90%; margin-top: -1rem">
                <strong>{{ $message }}</strong>
            </div>
            @enderror

            <div class="form-group password w-100">
                <input
                    type="password"
                    id="password"
                    placeholder="Password"
                    name="password">
                <i
                    class="fas fa-eye-slash"
                    onclick="hide_password()"
                    style="display: none; position: absolute; right: 5%; top: 50%; transform: translateY(-50%); cursor: pointer"></i>

                <i
                    class="far fa-eye show_password"
                    onclick="show_password()"
                    style="position: absolute; right: 5%; top: 50%; transform: translateY(-50%); cursor: pointer"></i>
            </div>
            @error('password')
            <div
                class="invalid-feedback mx-auto d-block"
                style="width: 90%; margin-top: -1rem">
                <strong>{{ $message }}</strong>
            </div>
            @enderror

            <div
                class="d-flex flex-column flex-sm-row"
                style="row-gap: 0.6rem; column-gap: 1rem">
                <div
                    id="chaptcha-img"
                    class="d-flex justify-content-center justify-content-sm-start align-items-center"
                    style="column-gap: 1rem">
                    <img
                        src=""
                        alt="chaptcha image"
                        width="150px"
                        height="50px"
                        class="mb-0"
                        style="border: 1px solid #1E4588">
                    <a
                        href="javascript:void(0)"
                        onclick="refreshCaptcha()"
                        class="btn btn-sm btn-primary"
                        title="Refresh Captcha">
                        <i class="fas fa-sync"></i>
                    </a>
                </div>
                <input
                    type="text"
                    name="captcha"
                    id="captcha"
                    class="form-control form-group"
                    placeholder="Masukkan angka yang muncul, di sini"
                    autocomplete="off">
            </div>

            <div
                class="form-group button w-100 border-0 mt-2"
                style="background: none !important; column-gap: 1rem">
                <button
                    class="mt-0 w-100 fw-bold"
                    style="background: #1E4588; border-radius: 7px; color: white"
                    onclick="submitForm()"
                >
                    Masuk
                </button>
                <div
                    class="w-100 dropdown">
                    <button
                        type="button"
                        id="dropdownRegister"
                        style="width: 100%; border-radius: 7px; background: #a9c0e9; color: #333"
                        class="mt-0 dropdown-toggle"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">Daftar</button>
                </div>
            </div>

            @if (Route::has('password.request'))
            <div
                class="w-100 d-flex justify-content-center"
                style="column-gap: 0.6rem">
                <a
                    href="{{ route('password.request') }}"
                    class="fw-bold">Lupa Password?</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('customjs')
    <script src="{{ asset('js/login/index.js') }}"></script>

    <script>
        const screen = window.innerWidth
        const logoImage1 = document.querySelector('.logo-image1')
        const logoImage2 = document.querySelector('.logo-image2')

        if (screen <= 412) {
            logoImage1.style.display = 'none'
            logoImage2.style.display = 'block'
        }

        function submitForm(el)
        {
            submitFormLoader()
            setTimeout(() => {
                window.location.href = '/administrator';
            }, 300)
        }

        async function getCaptcha() {
            try {
                const response = await fetch(route('captcha'))
                const blob = await response.blob()

                hideFormLoader()

                const url = URL.createObjectURL(blob)

                const captchaImage = document.querySelector('#chaptcha-img img')
                captchaImage.src = url
            } catch (error) {
                console.log(error)
            }
        }
        getCaptcha()

        function refreshCaptcha() {
            getCaptcha()

            const captchaInput = document.querySelector('#captcha')
            captchaInput.value = ''
        }
    </script>
@endsection
