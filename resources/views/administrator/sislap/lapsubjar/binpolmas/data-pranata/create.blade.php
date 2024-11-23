@extends('templates.admin-lte.admin', [
    'title' => 'Laporan Data Pranata Adat/Kearifan Lokal'
])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('data-pranata.store') }}"
                method="POST"
                id="form-pranata"
                onsubmit="disableSubmitButtonTemporarily(this)">
                @csrf
                @include('administrator.sislap.lapsubjar.binpolmas.data-pranata.form', [
                    'route_store' => 'data-pranata.store',
                    'route_index' => 'data-pranata.index',
                ])
            </form>
        </div>
    </div>
@endsection
