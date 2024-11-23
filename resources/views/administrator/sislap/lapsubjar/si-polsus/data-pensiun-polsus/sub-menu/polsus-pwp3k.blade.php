@extends('templates.admin-lte.admin', ['title' => 'Data Anggota Aktif dan Pensiun Polsus PWP3K'])

@php
    $province = \App\Models\Provinsi::orderBy("code")->pluck('name', 'code');
    $klProvinsi = auth()->user()->haveRole('operator_polsus_kl_provinsi');
    $klKotaKab = auth()->user()->haveRole('operator_polsus_kl_kota_kabupaten');
@endphp

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
            <h2 class="h4 text-center"><b>Data Anggota Aktif dan Pensiun Polsus PWP3K</b></h2>
        </div>
        <div class="card-body">
            <form action="{{ route('data-pensiun-polsus.polsus-pwp3k.export-excel') }}" class="form" method="post">
                @csrf
                <div class="alert alert-gray">
                    <h5><i class="icon fas fa-filter"></i> Filter</h5>
                    <hr>
                    <div class="form-group w-100">
                        <label for="search">Pencarian umum</label>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mt-lg-0 mt-3">
                                <select name="provinsi" id="provinsi" class="form-control"
                                        value="{{old('provinsi')}}">
                                    <option value="">pilih provinsi</option>
                                    @foreach($province as $id =>$name)
                                        <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
{{--                                @if($klProvinsi || $klKotaKab)--}}
{{--                                    <select name="provinsi" id="provinsi" class="form-control"--}}
{{--                                            value="{{old('provinsi')}}" readonly>--}}
{{--                                        <option value="{{auth()->user()->polsus->provinsi}}"--}}
{{--                                                id="{{App\Models\Provinsi::getCodeOfProvince(auth()->user()->polsus->provinsi)}}"--}}
{{--                                        >{{auth()->user()->polsus->provinsi}}</option>--}}
{{--                                    </select>--}}
{{--                                @else--}}
{{--                                    <select name="provinsi" id="provinsi" class="form-control"--}}
{{--                                            value="{{old('provinsi')}}">--}}
{{--                                        <option value="">pilih provinsi</option>--}}
{{--                                        @foreach($province as $id =>$name)--}}
{{--                                            <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                @endif--}}
                            </div>
                            <div class="col-lg-6 col-md-6 mt-lg-0 mt-3">
                                <select name="kabupaten" id="kabupaten" class="form-control"
                                        value="{{old('kabupaten')}}">
                                    <option value="" selected>pilih kabupaten atau kota</option>
                                    <option value="" disabled>pilih provinsi terlebih dahulu</option>
                                </select>
{{--                                @if($klKotaKab)--}}
{{--                                    <select name="kabupaten" id="kabupaten" class="form-control"--}}
{{--                                            value="{{old('kabupaten')}}" readonly>--}}
{{--                                        <option value="{{auth()->user()->polsus->kabupaten}}"--}}
{{--                                                id="{{App\Models\Kota::getCodeOfKota(auth()->user()->polsus->kabupaten)}}"--}}
{{--                                        >{{auth()->user()->polsus->kabupaten}}</option>--}}
{{--                                    </select>--}}
{{--                                @else--}}
{{--                                    <select name="kabupaten" id="kabupaten" class="form-control"--}}
{{--                                            value="{{old('kabupaten')}}">--}}
{{--                                        <option value="" selected>pilih kabupaten atau kota</option>--}}
{{--                                        <option value="" disabled>pilih provinsi terlebih dahulu</option>--}}
{{--                                    </select>--}}
{{--                                @endif--}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group w-100">
                        <div class="d-flex justify-content-end">
                            {{--                            <button class="mr-2 btn btn-success" type="submit">--}}
{{--                                <i class="fa fa-file-alt"></i>&ensp;Ekspor Excel--}}
{{--                            </button>--}}
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
                        <th class="align-middle" >No</th>
                        <th class="align-middle" >Provinsi</th>
                        <th class="align-middle" >Kabupaten/Kota</th>
                        <th class="align-middle" >Polsus Aktif</th>
                        <th class="align-middle" >Polsus Pensiun</th>
                        <th class="align-middle" >Jumlah</th>
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

    @include('administrator.sislap.lapsubjar.si-polsus.data-pensiun-polsus.sub-menu.modal.modal-data-pensiun-polsus', ['route' => 'data-pensiun-polsus.polsus-pwp3k.data-polsus-pensiun'])

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
                url: route('data-pensiun-polsus.polsus-pwp3k.search'),
                data: {}
            },
            content: (item, rowNumber) => {
                let table = `
                    <tr>
                        <th class="align-middle text-center border border-bottom" >${ rowNumber }</th>
                        <td class="align-middle" >${item.provinsi}</td>
                        <td class="align-middle" >${ item.kabupaten }</td>
                        <td class="align-middle" >${ item.polsus_aktif }</td>
                        <td class="align-middle" >${ item.polsus_pensiun } ${item.polsus_pensiun ? `<i onclick="tampilkanDataPolsus('${item.kabupaten}')" data-toggle="modal" data-target="#dataPensiunModal" class="fa fa-info text-warning ml-2" style="cursor: pointer">` : ''} </td>
                        <td class="align-middle" >${ item.jml }</td>
                </tr>
`;
                return table;
            }
        })

        document.getElementById('btn-search').addEventListener('click', (event) => {
            event.preventDefault()
            listLaporan.updateState('provinsi', document.querySelector('select[name=provinsi]').value)
            listLaporan.updateState('kabupaten', document.querySelector('select[name=kabupaten]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })

        const provinsi = $('#provinsi')
        const kabupaten = $('#kabupaten')

        provinsi.on('change', () => {
            setOptionAlamat(provinsi, route('alamat-kota'), kabupaten, 'kota/kabupaten')
        });

        const trigerKabupaten = () => {
            setOptionAlamat(provinsi, route('alamat-kota'), kabupaten, 'kota/kabupaten')
        }

        $(document).ready(function() {
            @if($klProvinsi) trigerKabupaten() @endif
        })
    </script>
@endsection
