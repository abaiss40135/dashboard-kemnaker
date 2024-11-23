@extends('templates.admin.main')

@php
    $province = \App\Models\Provinsi::orderBy("code")->pluck('name', 'code');
    $klProvinsi = auth()->user()->haveRole('operator_polsus_kl_provinsi');
    $klKotaKab = auth()->user()->haveRole('operator_polsus_kl_kota_kabupaten');
@endphp

@section('customcss')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.select2')
@endsection
@section('mainComponent')
<div class="wrapper">
    <div class="content-wrapper">
        @component('components.admin.content-header')
            @slot('title', 'Laporan Data Polsus Berdasarkan Diklat Reguler')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h2 class="h4 text-center"><b>Data Polsus Berdasarkan Diklat Reguler</b></h2>
                            <form action="{{ route('data-diklat-reguler.export-excel') }}"
                                  class="form" method="post">
                                @csrf
                                <hr>
                                <div class="alert alert-gray">
                                    <h5><i class="icon fas fa-filter"></i> Filter</h5>
                                    <hr>
                                    <div class="form-group w-100">
                                        <label for="search">Pencarian umum</label>
                                        <div class="row">
                                            <div class="col-md search-form-detail-polsus d-none">
                                                <input type="search" id="search" name="search"
                                                       placeholder="Cari berdasarkan nama, pangkat, jabatan, nomor nip, alamat instansi, atau nama balai, daop, unit dan lapas"
                                                       class="form-control">
                                            </div>
                                            <div class="col-md mt-lg-0 mt-3 search-form-general">
                                            @if(!$klProvinsi && !$klKotaKab)
                                                <select name="filter_kl" id="filter_kl" class="form-control"
                                                        value="{{old('filter_kl')}}">
                                                    <option value="">filter berdasarkan K/L</option>
                                                    @foreach($instansis as $instansi)
                                                        <option value="{{ $instansi->id }}">{{ $instansi->instansi }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                            </div>
                                            <div class="col-md mt-lg-0 mt-3 search-form-general">
                                                <select name="provinsi" id="provinsi" class="form-control"
                                                        value="{{old('provinsi')}}">
                                                    <option value="">pilih provinsi</option>
                                                    @foreach($province as $id =>$name)
                                                        <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
{{--                                                @if($klProvinsi || $klKotaKab)--}}
{{--                                                    <select name="provinsi" id="provinsi" class="form-control"--}}
{{--                                                            value="{{old('provinsi')}}" readonly>--}}
{{--                                                        <option value="{{auth()->user()->polsus->provinsi}}"--}}
{{--                                                                id="{{App\Models\Provinsi::getCodeOfProvince(auth()->user()->polsus->provinsi)}}"--}}
{{--                                                        >{{auth()->user()->polsus->provinsi}}</option>--}}
{{--                                                    </select>--}}
{{--                                                @else--}}
{{--                                                    <select name="provinsi" id="provinsi" class="form-control"--}}
{{--                                                            value="{{old('provinsi')}}">--}}
{{--                                                        <option value="">pilih provinsi</option>--}}
{{--                                                        @foreach($province as $id =>$name)--}}
{{--                                                            <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                @endif--}}
                                            </div>
                                            <div class="col-md mt-lg-0 mt-3 search-form-general">
                                                <select name="kabupaten" id="kabupaten" class="form-control"
                                                        value="{{old('kabupaten')}}">
                                                    <option value="" selected>pilih kabupaten atau kota</option>
                                                    <option value="" disabled>pilih provinsi terlebih dahulu</option>
                                                </select>
{{--                                                    @if($klKotaKab)--}}
{{--                                                        <select name="kabupaten" id="kabupaten" class="form-control"--}}
{{--                                                                value="{{old('kabupaten')}}" readonly>--}}
{{--                                                            <option value="{{auth()->user()->polsus->kabupaten}}"--}}
{{--                                                                    id="{{App\Models\Kota::getCodeOfKota(auth()->user()->polsus->kabupaten)}}"--}}
{{--                                                            >{{auth()->user()->polsus->kabupaten}}</option>--}}
{{--                                                        </select>--}}
{{--                                                    @else--}}
{{--                                                        <select name="kabupaten" id="kabupaten" class="form-control"--}}
{{--                                                                value="{{old('kabupaten')}}">--}}
{{--                                                            <option value="" selected>pilih kabupaten atau kota</option>--}}
{{--                                                            <option value="" disabled>pilih provinsi terlebih dahulu</option>--}}
{{--                                                        </select>--}}
{{--                                                    @endif--}}
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group w-100">
                                        <div class="d-flex justify-content-end">
{{--                                            <button class="mr-2 btn btn-success" type="submit">--}}
{{--                                                <i class="fa fa-file-alt"></i>&ensp;Ekspor Excel--}}
{{--                                            </button>--}}
                                            <button type="reset" class="mr-2 btn btn-warning">Reset</button>
                                            <button class="mr-2 btn btn-primary" id="btn-search">Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </form>
                            @component('components.sislap.form-search')
                                @slot('route', route('data-diklat-reguler.export-excel'))
                                @slot('className', 'd-none')
                            @endcomponent

                            <button type="button" onclick="initView(this)" class="btn btn-success d-none init-view-btn mb-2">Kembali ke Tampilan Awal</button>
                            <div class="table-data-polsus">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="bg-primary text-white text-center">
                                                <th class="align-middle" rowspan="2">No</th>
                                                <th class="align-middle" rowspan="2">Provinsi</th>
                                                <th class="align-middle" rowspan="2">Kabupaten/Kota</th>
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

                            <div class="table-detail-polsus d-none">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr class="bg-primary text-white text-center">
                                            <th class="align-middle" rowspan="2">No</th>
                                            <th class="align-middle" rowspan="2">Nama</th>
                                            <th class="align-middle" rowspan="2">Instansi</th>

                                            <th class="align-middle kategori-polsus-head d-none" rowspan="2"></th>

                                            <th class="align-middle" rowspan="2">Pangkat</th>
                                            <th class="align-middle" rowspan="2">Golongan</th>
                                            <th class="align-middle" rowspan="2">Jabatan</th>
                                            <th class="align-middle" rowspan="2">No NIP</th>
                                            <th class="align-middle" rowspan="2">No KTA</th>
                                            <th class="align-middle" rowspan="2">Alamat Instansi</th>
                                        </tr>
                                        </thead>
                                        <tbody id="content-wrapper-detail-polsus"></tbody>
                                    </table>
                                </div>
                                <div id="shimmer-wrapper-detail-polsus">
                                    <table class="table table-hover text-center">
                                        @component('components.shimmer.table-shimmer') @endcomponent
                                    </table>
                                </div>
                                <div id="message-wrapper-detail-polsus"></div>
                                <div class="col-md-12 d-flex justify-content-center">
                                    <ul id="paginator-wrapper-detail-polsus" class="my-0"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>

@include('assets.js.twbs-pagination')
@endsection
@section('customjs')
    @include('assets.js.twbs-pagination')
    @include('assets.js.select2')
    <script src="{{ asset('js/component-with-pagination.js') }}"></script>
    <script src="{{ asset('js/admin/sislap/lapsubjar/sipolsus/data-polsus.js') }}"></script>
    <script src="{{ asset('js/admin/sislap/lapsubjar/sipolsus/helper_function_data_detail_polsus.js') }}"></script>
    <script>
        const listLaporan = new ComponentWithPagination({
            contentWrapper: '#content-wrapper',
            messageWrapper: '#message-wrapper',
            paginator: '#paginator-wrapper',
            loader: '#shimmer-wrapper',
            searchState: {
                url: route('data-diklat-reguler.search'),
                data: {}
            },
            content: (item, rowNumber) => {
                const searchFilterKl = document.querySelector('select[name="filter_kl"]').value;
                if (searchFilterKl) {
                    let html = `<tr>
                        <td>${rowNumber}</td>
                        <td>${item.provinsi}</td>
                        <td>${item.kotakab}</td>`

                    mapInstansiPolsus[searchFilterKl].forEach(jenis_polsus => {
                        html += `
                        @forEach($attributes as $attribute)
                            <td class="align-middle">
                                ${ item[`${jenis_polsus}{{'_' . $attribute}}`] && '{{$attribute}}' != 'jml' ?
                                `<div class="d-flex justify-content-center" style="width: max-content">
                                        <span>${ item[`${jenis_polsus}{{'_' . $attribute}}`] }<span> ${`<button type="button" class="btn btn-info btn-sm" onclick="detailPolsus(this)" data-polsuswilayah="${jenis_polsus},{{$attribute}},${item.provinsi},${item.kotakab},reguler" class="btn btn-sm btn-info"><i class="fas fa-info-circle"></i></button>`}
                                    </div>`
                                : `${ item[`${jenis_polsus}{{'_' . $attribute}}`] }` }
                            </td>
                        @endforeach
                        `
                    })
                    html += `</tr>`
                    return html
                }

                return `
                    <tr>
                        <th class="align-middle text-center">${ rowNumber }</th>
                        <td class="align-middle">${item.provinsi}</td>
                        <td class="align-middle">${ item.kotakab }</td>
                        @foreach($polices as $police)
                            @foreach($attributes as $attribute)
                                <td class="align-middle">
                                    ${ {{"item.{$police}_{$attribute}"}} > 0 && '{{$attribute}}' != 'jml' ?
                                    `<div class="d-flex justify-content-center" style="width: max-content">
                                                                <span class="mr-3">${ {{"item.{$police}_{$attribute}"}} }<span> ${ `<button type="button" class="btn btn-info btn-sm" onclick="detailPolsus(this)" data-polsuswilayah="{{$police}},{{$attribute}},${item.provinsi},${item.kotakab},reguler" class="btn btn-sm btn-info"><i class="fas fa-info-circle"></i></button>` }
                                                            </div>`
                                    : `${ {{"item.{$police}_{$attribute}"}} }` }
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                `;
            },
            completeEvent: () => {
                const searchFilterKl = document.querySelector('select[name="filter_kl"]').value;
                if(searchFilterKl) {
                    $('.table-data-polsus thead').html(`
                        <tr class="bg-primary text-white text-center">
                            <th class="align-middle" rowspan="2">No</th>
                            <th class="align-middle" rowspan="2">Provinsi</th>
                            <th class="align-middle" rowspan="2">Kabupaten/Kota</th>
                            ${mapInstansiPolsus[searchFilterKl].map((item) => {
                                return `<th class="align-middle" colspan="3">${item.split('_').join(' ').toUpperCase()}</th>`
                            }).join('')}
                        </tr>
                        <tr class="bg-primary text-white text-center">
                            ${
                                mapInstansiPolsus[searchFilterKl].map(() => {
                                    return `
                                                @foreach($attributes as $attribute)
                                    <td>{{strtoupper($attribute)}}</td>
                                                @endforeach
                                    `
                                }).join('')
                            }
                        </tr>
                    `)
                } else {
                    $('.table-data-polsus thead').html(`
                        <tr class="bg-primary text-white text-center">
                            <th class="align-middle" rowspan="2">No</th>
                            <th class="align-middle" rowspan="2">Provinsi</th>
                            <th class="align-middle" rowspan="2">Kabupaten/Kota</th>
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
                    `)
                }
            }
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
