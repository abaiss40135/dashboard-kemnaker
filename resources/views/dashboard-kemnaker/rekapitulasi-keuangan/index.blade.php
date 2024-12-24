@extends('templates.dashboard.admin', [
    'title' => 'Selamat datang di Dashboard Kementerian Ketenagakerjaan Republik Indonesia'
])

@section('customcss')
    @include('assets.css.select2')
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-x-5">
        <div class="box">
            <div class="box-header items-center border-0">
                <h2 class="mt-0">
                    Sistem pencatatan dan monitoring capaian atas pelaksanaan program dan kegiatan Kementerian Ketenagakerjaan
                </h2>
            </div>
        </div>

        @include('dashboard-kemnaker.rekapitulasi-keuangan.partials.recap-links')
        @include('dashboard-kemnaker.rekapitulasi-keuangan.partials.filters')
        @include('dashboard-kemnaker.rekapitulasi-keuangan.partials.recaps')
        @include('dashboard-kemnaker.rekapitulasi-keuangan.partials.chart-keuangan')
        @include('dashboard-kemnaker.rekapitulasi-keuangan.partials.realisasi-anggaran')
        @include('dashboard-kemnaker.rekapitulasi-keuangan.partials.pelaksanaan-anggaran')
        @include('dashboard-kemnaker.rekapitulasi-keuangan.partials.realisasi-pengadaan')
    </div>
@endsection
