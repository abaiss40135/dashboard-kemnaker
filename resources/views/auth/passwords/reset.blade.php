@extends('templates.core.main')
@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/login/index.css') }}">
    <style>
        body {
            background-image: url("{{ asset('img/login-bg.jpg') }}") !important;
            background-position: 0 0;
            background-repeat: repeat;
            background-size: cover;
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
                <img src="{{ asset('img/bhabin/bos-logo-v2.webp') }}" class=" mr-2 mx-auto logo-image1"
                     width="300px"
                     alt="" srcset="">
                <img src="{{ asset('img/bhabin/bos-logo-v1.webp') }}" class=" mx-auto logo-image2 "
                     style="display: none"
                     width="120px" alt="" srcset="">
            </div>

            <form class="form p-4" method="POST" action="{{ route('password.update') }}" onsubmit="submitFormLoader()">
                @csrf
                <p class="text-center" style="color: #1E4588; font-size: 15px; font-weight: 700;">KORBINMAS BAHARKAM
                    POLRI</p>
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group username w-100 align-items-center">
                    <input type="email" id="email " class="@error('email') is-invalid @enderror"
                           value="{{ $email ?? old('email') }}" name="email" placeholder="Email" autocomplete="email"
                           readonly
                           autofocus>
                </div>
                @error('email')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror

                <div class="form-group password w-100 mt-3">
                    <input type="password" id="password" placeholder="Password baru" name="password" required
                           autocomplete="new-password">
                    <i class="fas fa-eye-slash" onclick="hide_password()"
                       style=" display: none; position: absolute; right: 5%; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    <i class="far fa-eye show_password" onclick="show_password()"
                       style="position: absolute; right: 5%; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
                @error('password')
                <div class="invalid-feedback mx-auto" style="display: block; width:90%;">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <div class="form-group password w-100 mt-3">
                    <input type="password" id="password-confirm" placeholder="Masukan kembali password"
                           name="password_confirmation" required autocomplete="new-password">
                    <i class="fas fa-eye-slash fa-eye-slash-confirm" onclick="hide_password_confirm()"
                       style=" display: none; position: absolute; right: 5%; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    <i class="far fa-eye fa-eye-confirm show_password" onclick="show_password_confirm()"
                       style="position: absolute; right: 5%; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
                @error('password')
                <div class="invalid-feedback mx-auto" style="display: block; width:90%;">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <br>
                <div class="button w-100">
                    <button type="submit" class="btn btn-primary border-dark w-100">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('customjs')
    <script src="{{ asset('js/login/index.js') }}"></script>
    <script>
        const password_confirm = document.querySelector("#password-confirm");
        const eyeOpenConfirm = document.querySelector(".fa-eye-confirm");
        const eyeCloseConfirm = document.querySelector(".fa-eye-slash-confirm");

        const show_password_confirm = () => {
            password_confirm.type = "text";
            eyeOpenConfirm.style.display = "none";
            eyeCloseConfirm.style.display = "block";
        };

        const hide_password_confirm = () => {
            password_confirm.type = "password";
            eyeOpenConfirm.style.display = "block";
            eyeCloseConfirm.style.display = "none";
        };
    </script>
@endsection
