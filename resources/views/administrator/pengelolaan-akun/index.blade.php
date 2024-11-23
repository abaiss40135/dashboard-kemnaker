@extends('templates.admin-lte.admin', ['title' => 'Pengelolaan Akun'])
@section('customcss')
    <style>
        .card-header > i {
            font-size: 100px;
        }

        .card-link {
            display: block
        }

        .card-link:hover {
            transition: .3s ease-in-out;
        }
    </style>
@endsection
@section('content')
    <div class=" d-flex flex-column flex-md-row" style="column-gap: 1rem">
        @if(role('administrator'))
        <div class="w-100">
            <a href="{{route('user.index')}}" class="card-link h-100">
                <div class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Daftar Akun</b></h4>
                    </div>
                </div>
            </a>
        </div>
        @endif
        @can('pengelolaan_akun_create')
        <div class="w-100">
            <a href="{{route('tambah-akun.index')}}" class="card-link h-100">
                <div class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Tambah Akun</b></h4>
                    </div>
                </div>
            </a>
        </div>
        @endcan
        @can('register_polsus_create')
        <div class="w-100">
            <a href="{{route('register-polsus.index')}}" class="card-link h-100">
                <div class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Tambah Akun SIPOLSUS</b></h4>
                    </div>
                </div>
            </a>
        </div>
        @endcan
        @can('pengelolaan_akun_edit')
        <div class="w-100">
            <a href="{{route('ubah-role.index')}}" class="card-link h-100">
                <div class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fa fa-sync"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Ubah Hak Akses</b></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="w-100">
            <a href="{{ route('akun.password-reset') }}" class="card-link h-100">
                <div class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fa fa-key"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Ganti Password</b></h4>
                    </div>
                </div>
            </a>
        </div>
        @endcan
    </div>
@endsection
