@extends('templates.admin-lte.admin', ['title' => 'Laporan Harian (Atensi Pimpinan)'])
@section('content')
    <div class="row">
        <div class="col-sm-4 col-md-3">
            <a href="{{ route('cartenz.pi-ajar.index') }}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                        <h4 class="text-bold">Pi Ajar</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4 col-md-3">
            <a href="{{ route('cartenz.koteka.index') }}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                        <h4 class="text-bold">Koteka</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4 col-md-3">
            <a href="{{ route('cartenz.keladi-sagu.index') }}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                        <h4 class="text-bold">Keladi Sagu</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4 col-md-3">
            <a href="{{ route('cartenz.kasuari.index') }}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                        <h4 class="text-bold">Kasuari</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
