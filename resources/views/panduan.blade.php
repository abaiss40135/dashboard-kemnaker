@extends('templates.core.main')
@section('customcss')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url("{{ asset('img/login-bg.jpg') }}");
            background-repeat: repeat;
        }

        .bg-primary {
            background-color: hsl(218, 64%, 90%) !important;
        }

        .bg-primary:focus,
        .bg-primary:hover {
            background-color: hsl(218, 64%, 80%) !important;
        }

        ul > li:not(:first-child) {
            margin-top: 6px;
        }

        li {
            list-style: square;
        }

        main > section:not(:first-child) {
            margin-top: 12px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/fontawesome-free/css/all.min.css') }}">
@endsection
@section('mainComponent')
    <!-- login -->
    <main class="mt-sm-3 p-0 container bg-white">
        <div class="box shadow border-0" style="overflow: unset">
            <div class="header" style="background-color: #1E4588">
                <div class="d-flex align-items-center w-100">
                    <a href="{{ route('login') }}">
                        <h4 class="ms-3"><i class="fas fa-arrow-left text-white"></i></h4>
                    </a>
                    <h4 class="py-3 py-sm-2 text-white text-center w-100">Panduan Penggunaan Aplikasi</h4>
                </div>
            </div>
            <div class="p-2">
                @foreach($panduans as $key => $panduan)
                    <section id="panduan-{{$key}}">
                        <button
                            class="d-flex justify-content-between align-items-center btn btn-block w-100 p-3 rounded bg-primary"
                            data-bs-target="#collapse-{{$key}}"
                            aria-controls="collapse-{{$key}}"
                            data-bs-toggle="collapse"
                            aria-expanded="false" onclick="angleIcon(this)">
                            <h5 class="mb-0 text-uppercase fw-bold">{{$panduan->title}}</h5>
                            <i class="fas fa-angle-down d-flex"></i>
                        </button>
                        <div id="collapse-{{ $key }}" class="collapse show my-3">
                            <div id="parentlist-{{$key}}">
                                @foreach($panduan->children as $key => $sub)
                                    <div class="ms-3">
                                        <i class="fas fa-file me-3"></i>
                                        <span><a target="_blank"
                                                 href="{{ $sub->file }}">{{ $loop->iteration }}. {{ $sub->title }}</a></span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bos/bosv2.js') }}"></script>
@endsection
@section('customjs')
@endsection
