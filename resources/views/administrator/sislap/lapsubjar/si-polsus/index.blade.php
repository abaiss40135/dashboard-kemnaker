@extends('templates.admin-lte.admin', ['title' => 'SI-POLSUS (Bergabung dengan Grup Telegram <a href="https://t.me/sipolsus" target="_blank">https://t.me/sipolsus</a>)'])
@section('content')
    {{-- Variabel untuk menampilkan menu lama SI-POLSUS --}}
    @php
        $tampilkanData = 0;
    @endphp

    {{-- codingan tentang menu binanevpolsus --}}
    {{-- tidak digunakan lagi karena sudah digantikan oleh si-polsus --}}
    {{-- <div class="container-fluid row">
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-kejadian.index')}}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                        <h4><b>Data Kejadian yang Ditangani Polsus</b></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-senpi.index')}}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                        <h4><b>Data Senpi dan Amunisi Polsus</b></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-polsus-kl.index')}}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                        <h4><b>Data Anggota Polsus</b></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-katpuan-polsus.index')}}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                        <h4><b>Data Katpuan Polsus</b></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-diklat-polsus.index')}}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                        <h4><b>Data Diklat Polsus</b></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-giat-korwas.index')}}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                        <h4><b>Data Giat Korwas Polsus</b></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <a href="{{ route('data-kerjasama.index')}}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                        <h4><b>Data Kerjasama Antara Polri Dengan Instansi yang Memiliki Polsus </b></h4>
                    </div>
                </div>
            </a>
        </div>
    </div> --}}


    @if (roles([
        'administrator',
        'operator_polsus_kl',
        'operator_polsus_polda',
        'operator_polsus_kl_provinsi'
    ]))
        @include('administrator.sislap.lapsubjar.si-polsus.chart-rekap-diklat-sipolsus')
    @endif
    <div class="row justify-content-center" style="row-gap: 1rem">
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-diklat-reguler.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Polsus Diklat Reguler</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-diklat-khusus.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Polsus Diklat Khusus</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-kepemilikan-kta.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Polsus Kepemilikan KTA</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-senpi-amunisi.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Senpi Dan Amunisi Polsus</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-pensiun-polsus.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Pensiunan Anggota Polsus</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('korwasbintek.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Laporan Kegiatan Korwasbintek Polsus</b></h4>
                </div>
            </a>
        </div>
        {{-- <div class="col-sm-6 col-md-4">
            <a href="{{ route('data-amunisi.index')}}" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Data Amunisi Polsus</b></h4>
                </div>
            </a>
        </div> --}}
    </div>
@endsection
