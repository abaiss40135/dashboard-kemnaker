@extends('templates.admin.main')
@section('mainComponent')
    <div class="wrapper">
        <div class="content-wrapper">
            @component('components.admin.content-header')
                @slot('title', 'Laporan 3T')
            @endcomponent
            <section class="content">
                <div class="container-fluid row mx-0">
                    <div class="col-md-4">
                        <a href="#" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4><b>Laporan Harian Testing</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{route('laphar-tracing.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4><b>Laporan Harian Tracing</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4><b>Laporan Harian Treatment</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
