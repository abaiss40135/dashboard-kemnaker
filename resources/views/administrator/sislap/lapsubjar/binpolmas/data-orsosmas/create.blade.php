@extends('templates.admin-lte.admin', [
    'title' => 'Laporan Data Orsosmas Binaan Polri'
])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('data-orsosmas.store') }}"
                method="POST"
                id="form-ormas"
                onsubmit="disableSubmitButtonTemporarily(this)">
                @csrf
                @include('administrator.sislap.lapsubjar.binpolmas.data-orsosmas.form', [
                    'type' => 'berbadan_hukum',
                    'route_store' => 'data-orsosmas.store',
                    'route_index' => 'data-orsosmas.index',
                ])
            </form>
        </div>
    </div>
@endsection
