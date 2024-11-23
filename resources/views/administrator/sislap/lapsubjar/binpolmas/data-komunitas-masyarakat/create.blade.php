@extends('templates.admin-lte.admin', [
    'title' => 'Data Komunitas Masyarakat Binaan Polri'
])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('data-komunitas-masyarakat.store') }}"
                method="POST"
                id="form-ormas"
                onsubmit="disableSubmitButtonTemporarily(this)">
                @csrf
                @include('administrator.sislap.lapsubjar.binpolmas.data-komunitas-masyarakat.form', [
                    'type' => 'berbadan_hukum',
                    'route_store' => 'data-komunitas-masyarakat.store',
                    'route_index' => 'data-komunitas-masyarakat.index',
                ])
            </form>
        </div>
    </div>
@endsection
