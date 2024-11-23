@extends('templates.admin-lte.admin', [
    'title' => 'Dashboard Perhitungan Suara Capres 2024'
])
@section('customcss')
    @include('assets.css.select2')
    <link rel="stylesheet" href="{{ asset('css/administrator/dashboard.css') }}">
@endsection
@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title"><i class="icon fas fa-filter"></i> Filter</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="form-search" onsubmit="submitFormSearch(this)">
                <div class="row justify-content-end">
                    <div class="form-group col-6 col-md-3">
                        <label for="province" class="form-label">Provinsi</label>
                        <select id="province" name="province" class="form-control select2"></select>
                    </div>
                    <div class="form-group col-6 col-md-3">
                        <label for="city" class="form-label">Kota/Kabupaten</label>
                        <select id="city" name="city" class="form-control select2"></select>
                    </div>
                    <div class="form-group col-6 col-md-3">
                        <label for="district" class="form-label">Kecamatan</label>
                        <select id="district" name="district" class="form-control select2"></select>
                    </div>
                    <div class="form-group col-6 col-md-3">
                        <label for="village" class="form-label">Desa</label>
                        <select id="village" name="village" class="form-control select2"></select>
                    </div>
                    <div class="col-sm-6 col-xl-9 mt-3 mb-xl-3">
                        <a id="btn-export" class="btn w-25 btn-success" target="_blank" href="{{route('dashboard-pemungutan-suara-capres2024.export-nasional')}}">
                            Export Excel - Data Nasional
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-3 d-flex justify-content-end mt-3 mb-xl-3" style="column-gap: 7.5px">
{{--                        <button type="reset" class="btn w-100 btn-warning">--}}
{{--                            <i class="fas fa-undo"></i> Reset--}}
{{--                        </button>--}}
{{--                        <button type="button" id="previous-filter-button" class="btn w-100 btn-success">--}}
{{--                            <i class="fas fa-arrow-left"></i> Back--}}
{{--                        </button>--}}
                        <button type="button" id="btn-search" class="btn w-50 btn-primary">
                            <i class="fa fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('administrator.dashboard-suara-capres2024.chart-perhitungan-suara-capres')
    @include('administrator.dashboard-suara-capres2024.stacked-bar-chart-perhitungan-suara-capres-per-provinsi')
    @include('administrator.dashboard-suara-capres2024.table-informasi-laporan-perhitungan-suara-capres')
@endsection
@push('scripts')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/i18n/id.js') }}"></script>
    <script src="{{ asset('js/select2/select2-custom-function.js') }}"></script>
    <script>
        let selectProvinsi  = $('#province');
        let selectKota      = $('#city');
        let selectKecamatan = $('#district');
        let selectDesa      = $('#village');

        function initSelect2Provinsi () {
            buildSelect2Search({
                placeholder: '-- Pilih Provinsi --',
                url: route('provinsi.select2'),
                minimumInputLength: 0,
                selector: [{id: selectProvinsi}],
                query: function (params) {
                    return {
                        name: params.term,
                        text: 'name'
                    }
                }
            });
        }

        function initSelect2Kota (province_code) {
            buildSelect2Search({
                placeholder: '-- Pilih Kota/Kabupaten --',
                url: route('kota.select2'),
                minimumInputLength: 0,
                selector: [{id: selectKota}],
                query: function (params) {
                    return {
                        name: params.term,
                        province_code: province_code
                    }
                }
            });
        }

        function initSelect2Kecamatan (city_code) {
            buildSelect2Search({
                placeholder: '-- Pilih Kecamatan --',
                url: route('kecamatan.select2'),
                minimumInputLength: 0,
                selector: [{id: selectKecamatan}],
                query: function (params) {
                    return {
                        name: params.term,
                        city_code: city_code,
                    }
                }
            });
        }

        function initSelect2Desa (district_code) {
            buildSelect2Search({
                placeholder: '-- Pilih Desa --',
                url: route('desa.select2'),
                minimumInputLength: 0,
                selector: [{id: selectDesa}],
                query: function (params) {
                    return {
                        name: params.term,
                        district_code: district_code,
                    }
                }
            });
        }

        selectProvinsi.on('select2:select', function (e) {
            initSelect2Kota(e.params.data.id);
        })

        selectKota.on('select2:select', function (e) {
            initSelect2Kecamatan(e.params.data.id);
        })

        selectKecamatan.on('select2:select', function (e) {
            initSelect2Desa(e.params.data.id);
        })

        initSelect2Provinsi()
        initSelect2Kota()
        initSelect2Kecamatan()
        initSelect2Desa()


        const submitFormSearch = e => {
            e.preventDefault()
        }
    </script>
@endpush
