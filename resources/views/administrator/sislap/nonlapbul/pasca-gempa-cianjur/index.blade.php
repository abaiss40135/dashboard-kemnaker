@extends('templates.admin-lte.admin', ['title' => 'Laporan Harian (Atensi Pimpinan)'])
@section('content')
    <div class="row">
        <div class="col-sm-4">
            <a href="{{ route('penanganan-pasca-gempa-cianjur.index') }}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                        <h4 class="text-bold">Kegiatan Penanganan Pasca Gempa Cianjur<br/>(Di Wilayah Kab. Cianjur)</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('bantuan-pasca-gempa-cianjur.index') }}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                        <h4 class="text-bold">Kegiatan Bantuan Pasca Bencana Cianjur<br/>(Di Luar Wilayah Kab. Cianjur)</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('rekap-laphar-pasca-gempa-cianjur.index') }}" class="card">
                <div class="text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column p-3">
                        <i class="fas fa-book-reader mb-3" style="font-size: 100px"></i>
                        <h4 class="text-bold">Rekap Laporan Giat</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
