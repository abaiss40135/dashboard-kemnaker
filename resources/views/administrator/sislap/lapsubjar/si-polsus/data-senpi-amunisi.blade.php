@extends('templates.admin-lte.admin', ['title' => 'Data Senpi Polsus'])
@section('customcss')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.select2')

    <style>
        .bg-senpi {
            background-color: hsl(20.9, 67.3%, 80.8%);
        }
        .bg-amunisi {
            background-color: hsl(200, 67.3%, 80.8%);
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="h4 text-center"><b>Data Senpi dan Amunisi yang dimiliki Polsus</b></h2>
            @can('sipolsus_create')
                <div style="position: absolute; right: 0.8rem; top: 0.8rem;">
                    <a href="{{ route('input-data-senpi-amunisi.index') }}">
                        <button class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Tambah Laporan
                        </button>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <form action="{{ route('data-senpi-amunisi.export-excel') }}" class="form" method="post">
                @csrf
                <div class="alert alert-gray">
                    <h5><i class="icon fas fa-filter"></i> Filter</h5>
                    <hr>
                    <div class="form-group w-100">
                        <label for="search">Pencarian umum</label>
                        <input type="text" id="search" name="search" class="form-control"
                               placeholder="Cari data berdasarkan Provinsi dan Kabupaten/Kota">
                    </div>
                    <div class="form-group w-100">
                        <div class="d-flex justify-content-end">
                            <button class="mr-2 btn btn-success" type="submit">
                                <i class="fa fa-file-alt"></i>&ensp;Ekspor Excel
                            </button>
                            <button type="reset" class="mr-2 btn btn-warning">Reset</button>
                            <button class="mr-2 btn btn-primary" id="btn-search">Cari</button>
                        </div>
                    </div>
                </div>
                <hr>
            </form>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr class="bg-primary text-white text-center">
                        <th class="align-middle" rowspan="2">No</th>
                        <th class="align-middle" rowspan="2">Provinsi</th>
                        <th class="align-middle" rowspan="2">Kabupaten/Kota</th>
                        <th class="align-middle" rowspan="2">Jenis</th>
                        @foreach($polices as $police)
                            <th class="align-middle" colspan="3">{{strtoupper( str_replace("_", " ", $police) )}}</th>
                        @endforeach
                    </tr>
                    <tr class="bg-primary text-white text-center">
                        @for($i=1;$i<=10;$i++)
                            @foreach($attributes as $attribute)
                                <td>{{strtoupper($attribute)}}</td>
                            @endforeach
                        @endfor
                    </tr>
                    </thead>
                    <tbody id="content-wrapper"></tbody>
                </table>
            </div>
            <div id="shimmer-wrapper">
                <table class="table table-hover text-center">
                    @component('components.shimmer.table-shimmer') @endcomponent
                </table>
            </div>
            <div id="message-wrapper"></div>
            <div class="col-md-12 d-flex justify-content-center">
                <ul id="paginator-wrapper" class="my-0"></ul>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.twbs-pagination')
    @include('assets.js.select2')
    <script src="{{ asset('js/component-with-pagination.js') }}"></script>
    <script>
        const listLaporan = new ComponentWithPagination({
            contentWrapper: '#content-wrapper',
            messageWrapper: '#message-wrapper',
            paginator: '#paginator-wrapper',
            loader: '#shimmer-wrapper',
            searchState: {
                url: route('data-senpi-amunisi.search'),
                data: {}
            },
            content: (item, rowNumber) => {
                let table = `
                    <tr>
                        <th class="align-middle text-center border border-bottom" rowspan="2">${ rowNumber }</th>
                        <td class="align-middle" rowspan="2">${item.provinsi}</td>
                        <td class="align-middle" rowspan="2">${ item.kabupaten }</td>
                        <td class="align-middle bg-senpi">Senpi</td>
                        @foreach($polices as $police)
                @foreach($attributes as $attribute)
                <td class="align-middle bg-senpi">${ {{"item.senpi.{$police}_{$attribute}"}} }</td>
                            @endforeach
                @endforeach
                </tr>
                <tr>
                    <td class="align-middle bg-amunisi">Amunisi</td>
@foreach($polices as $police)
                @foreach($attributes as $attribute)
                <td class="align-middle bg-amunisi">${ {{"item.amunisi.{$police}_{$attribute}"}} }</td>
                            @endforeach
                @endforeach
                </tr>
`;
                return table;
            }
        })

        document.getElementById('btn-search').addEventListener('click', (event) => {
            event.preventDefault()
            listLaporan.updateState('search', document.querySelector('input[name=search]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })
    </script>
@endsection
