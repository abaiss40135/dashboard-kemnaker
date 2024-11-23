@extends('templates.admin.main')
@section('mainComponent')
<div class="wrapper">
    <div class="content-wrapper">
        @component('components.admin.content-header')
                @slot('title', 'Laporan PMK')
                @endcomponent
            <section class="content">
                <div class="container-fluid row mx-0">
                    <div class="col-sm-6">
                        <a href="{{route('penyakit-mulut-kuku.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4><b>Laporan Monitoring Penyakit Mulut dan Kuku (PMK)</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{route('preemtif-pmk.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3">
                                    <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                                    <h4><b>Laporan Kegiatan Preemtif Penanganan PMK</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
