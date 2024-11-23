@extends('templates.admin-lte.admin', ['title' => 'Kegiatan Bantuan Pasca Gempa Cianjur'])
@section('customcss')
    @include('assets.css.select2')
    @include('assets.css.datetimepicker')
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <h3 class="card-title">FORMAT KEGIATAN BANTUAN PASCA BENCANA CIANJUR</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('bantuan-pasca-gempa-cianjur.store') }}" method="POST" id="form-bantuan-pasca-gempa">
                @csrf
                <x-sislap.nonlapbul.laphar-bantuan-gempa-cianjur.form/>
            </form>
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.select2')
    @include('assets.js.datetimepicker')
@endsection
