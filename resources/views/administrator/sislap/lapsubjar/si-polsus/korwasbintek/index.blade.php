@extends('templates.admin.main')
@section('mainComponent')
    <div class="wrapper">
        <div class="content-wrapper">
            @component('components.admin.content-header')
                @slot('title', 'Laporan Kegiatan Korwasbintek Polsus')
            @endcomponent
            <section class="content">
                <div class="container-fluid row mx-0 justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{route('korwasbintek.koordinasi.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4 class="mt-2"><b>Koordinasi</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{route('korwasbintek.pengawasan.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4 class="mt-2"><b>Pengawasan</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{route('korwasbintek.pembinaan-teknis.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4 class="mt-2"><b>Pembinaan Teknis</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
