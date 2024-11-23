@extends('templates.core.main')
@section('customcss')
<link rel="stylesheet" href="{{ asset('css/bhabin/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/bhabin/laporan/laporan.css') }}">
<style>
    .icon-box{
        color: aliceblue;
        font-size: 58px;
    }
</style>
@endsection
@section('mainComponent')
    <br class="d-none d-md-block">
    <br class="d-none d-md-block">
    <main class="my-5">
        <div class="container">
            <div class="row mx-1 mb-5 mt-2 container-grid-1">
                <div class="col-md sm-12 mt-4">
                    <a href="{{ route('satpam.laporan-informasi.index') }}">
                        <div class="box mx-auto" style="width: fit-content">
                            <div class="header text-center bg-dark " style="width: 303px; cursor: pointer;">
                                <i class="fas fa-info-circle icon-box" ></i>
                                <h5 class="mt-3 text-white">Laporan Informasi</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md sm-12 mt-4">
                    <a href="{{ route('satpam.laporan-kejadian.index') }}">
                        <div class="box mx-auto" style="width:fit-content; cursor: pointer;">
                            <div class="header text-center bg-dark" style="width: 303px">
                                <i class="fas fa-book icon-box"></i>
                                <h5 class="mt-3 text-white">Laporan Kejadian</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
