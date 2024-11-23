@extends('templates.admin-lte.admin', ['title' => 'Laporan Subdit Binpolmas'])
@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/administrator/dashboard.css') }}">
@endsection
@section('content')
{{--    if role administrator --}}
    @if(role('administrator'))
        @include('administrator.sislap.lapsubjar.binpolmas.map-login-operator-binpolmas')
    @endif

    <div class="row justify-content-center" style="row-gap: 1rem">
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-fkpm-kawasan.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>1. Laporan Data FKPM (Kawasan)</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-fkpm-wilayah.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>2. Laporan Data FKPM (Wilayah)</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-pranata.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>3. Data Pranata Adat/Kearifan Lokal</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-orsosmas.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>4. Data Orsosmas Binaan Polri</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('data-komunitas-masyarakat.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>5. Data Komunitas Masyarakat Binaan Polri</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('petugas-polmas-kawasan-wilayah.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>6. Data Petugas Polmas Model Wilayah Dan Model Kawasan</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('supervisor-polmas.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>7. Supervisor Polmas</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('pembina-polmas.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>8. Pembina Polmas</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('kegiatan-petugas-polmas.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>9. Data Kegiatan Petugas Polmas</b></h4>
                </div>
            </a>
        </div>


        {{-- ini adalah view menu dari binpolmas lama
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-fkpm.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data FKPM</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('data-ormas.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Ormas (Binaan Polda)</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('data-dai.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Da'i Kamtibmas</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('data-kommas.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Kommas (Binaan Polda)</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('data-pokdarkamtibmas.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Pokdarkamtibmas</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('data-senkom.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Senkom Mitra Polri</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{route('kbpp-polri.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data KBPP Polri</b></h4>
                </div>
            </a>
        </div> --}}
    </div>
@endsection
