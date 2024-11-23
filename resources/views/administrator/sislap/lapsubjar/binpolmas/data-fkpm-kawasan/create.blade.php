@extends('templates.admin-lte.admin', [
    'title' => 'Laporan Data FKPM (Kawasan)',
])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('data-fkpm-kawasan.store') }}"
                  method="POST"
                  id="form-fkpm"
                  onsubmit="disableSubmitButtonTemporarily(this)">
                @csrf
                @include('administrator.sislap.lapsubjar.binpolmas.data-fkpm.form', [
                    'type' => 'kawasan',
                    'route_store' => 'data-fkpm-kawasan.store',
                    'route_index' => 'data-fkpm-kawasan.index',
                ])
            </form>
        </div>
    </div>
@endsection
