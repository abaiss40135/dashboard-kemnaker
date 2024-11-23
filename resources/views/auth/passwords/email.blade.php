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

            <form class="form p-4" method="POST" action="{{ route('password.email') }}"
                  onsubmit="submitFormLoader()">
                @csrf
                <p class="text-center" style="color: #1E4588; font-size: 15px; font-weight: 700;">KORBINMAS BAHARKAM
                    POLRI</p>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            <!-- input -->
                <div class="form-group username w-100 align-items-center">
                    <input type="text" id="email " class="@error('email') is-invalid @enderror"
                           value="{{ old('email') }}" name="email" placeholder="Email/NRP/NIB" autocomplete="off">
                </div>
                @error('email')
                <div class="invalid-feedback mx-auto" style="display: block; width:90%;">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <br>
                <div class="form-group button w-100" style="border: 0 !important; background: none !important;">
                    <button type="submit" class="btn btn-primary border-dark w-100">
                        Kirim Email Reset Password
                    </button>
                </div>
                <div class="w-100 mt-2 d-flex justify-content-end">
                    <a href="{{ route('login') }}">Sudah punya akun? Masuk</a>
                </div>
            </form>
        </div>
    </div>
@endsection
