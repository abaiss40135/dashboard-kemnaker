@extends('templates.admin-lte.admin', ['title' => 'Kegiatan Cegah Tindak Pidana Dan Gangguan Kamtibmas'])
@section('customcss')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.select2')
@endsection
@section('content')
<div class="card">
    <div class="card-header py-3">
        <h3 class="card-title">FORMAT LAPORAN</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('laphar-kegiatan-kamtibmas.store') }}" method="POST">
            @csrf
            @include('administrator.sislap.nonlapbul.laphar-kegiatan-kamtibmas._form')
            <button type="submit" class="btn btn-success float-right">Simpan</button>
        </form>
    </div>
</div>
@endsection
@section('customjs')

@endsection
