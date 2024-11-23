@extends('templates.admin-lte.admin', [
    'title' => 'Laporan Data FKPM (Wilayah)'
])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('data-fkpm-wilayah.store') }}"
                  method="POST"
                  id="form-fkpm"
                  onsubmit="disableSubmitButtonTemporarily(this)">
                @csrf
                @include('administrator.sislap.lapsubjar.binpolmas.data-fkpm.form', [
                    'type' => 'wilayah',
                    'route_store' => 'data-fkpm-wilayah.store',
                    'route_index' => 'data-fkpm-wilayah.index',
                ])
            </form>
        </div>
    </div>
@endsection
