@extends('templates.admin.main')
@section('mainComponent')
    <div class="wrapper">
        <div class="content-wrapper">
            @component('components.admin.content-header')
                @slot('title', 'Laporan Polsus Diklat Khusus')
            @endcomponent
            <section class="content">
                <div class="container-fluid row mx-0 justify-content-center">
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-diklat-khusus.pensiunan-tni-polri.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4><b>Data Polsus Diklat Khusus Pensiunan TNI/Polri</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-diklat-khusus.pejabat-lingkungan-kl.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4><b>Data Polsus Diklat Khusus Pejabat di Lingkungan K/L</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection