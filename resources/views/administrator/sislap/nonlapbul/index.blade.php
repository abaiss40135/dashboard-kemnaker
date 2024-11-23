@extends('templates.admin-lte.admin', ['title' => 'Laporan Harian (Atensi Pimpinan)'])
@section('content')
    <div class="row" style="row-gap: 1rem">
        <div class="col-sm-6 col-md-4">
            <a href="{{  route('laphar-tppo.index') }}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Laphar TPPO</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{  route('laphar-kegiatan-kamtibmas.index') }}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Kegiatan Cegah Tindak Pidana Dan Gangguan Kamtibmas</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('cartenz.index') }}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Laphar Ops Damai Cartenz 2023</b></h4>
                </div>
            </a>
        </div>
        {{-- <div class="col-sm-6 col-md-4">
            <a href="{{ route('laphar-ditbinmas.index') }}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Laphar Rutin Ditbinmas Polda</b></h4>
                </div>
            </a>
        </div> --}}
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('laphar-pasca-gempa-cianjur.index') }}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Kegiatan Penanganan Pasca Gempa Cianjur</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('laphar-pc.index')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>PC Pen</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('laphar-karhutla.index')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Karhutla</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('laporan3t')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>3T</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('laphar-vaksinasi.index')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Vaksinasi</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('neo-laphar-minyak-goreng.index')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Monitoring Minyak Goreng</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('laphar-demo-hari-buruh.index')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Demo Hari Buruh</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('pmk')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>PMK</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('laphar-pelatihan-faba.index')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Pelatihan FABA (Fly Ash Bottom Ash)</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('bansos.index')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Bansos</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-4">
            <a href="{{route('preemtif-bbm.index')}}"  class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Giat Preemtif Pengalihan Subsidi BBM</b></h4>
                </div>
            </a>
        </div>
    </div>
@endsection
