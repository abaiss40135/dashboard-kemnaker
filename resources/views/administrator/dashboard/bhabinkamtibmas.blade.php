@extends('templates.admin-lte.admin')
@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/administrator/dashboard.css') }}">
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.datetimepicker')
    <style>
        .box-search-result > p {
            margin-bottom: 0.2em;
        }
        .popular-keyword:hover {
            color: royalblue;
        }
        mark {
            background-color: yellow;
        }
    </style>
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
            <form id="form-search" action="#" method="POST" onsubmit="disableSubmitButtonTemporarily(this)">
                @csrf
                <div class="row">
                    <div class="col-12 col-sm-8 col-xl-9">
                        <div class="form-group">
                            <label for="search">Kejadian Kamtibmas:</label>
                            <input type="search" id="search" name="search" aria-label="global-search" placeholder="Cari kata kunci kejadian, nama atau nrp personel" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 col-lg-3">
                        <div class="form-group">
                            <label for="tanggal-laporan">Tanggal:</label>
                            <input type="text" id="tanggal-laporan" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 d-xl-none"></div>
                    <div class="col-sm-6 col-xl-3 d-flex justify-content-center mt-3 mb-xl-3" style="column-gap: 7.5px">
                        <button type="reset" class="btn w-100 btn-warning">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="button" id="previous-filter-button" class="btn w-100 btn-success">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                        <button type="button" id="btn-search" class="btn w-100 btn-primary">
                            <i class="fa fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @component('components.dashboard.bhabinkamtibmas.chart')@endcomponent

    {{-- search dan calendar --}}
    {{--<div class="row">
        --}}{{-- search --}}{{--
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="header">Cari Kejadian Kamtibmas</div>
                <div class="card-body">
                    <form action="#" id="form-pencarian-keyword">
                        <div class="input-group mb-2 mr-sm-2">
                            <input name="search" class="form-control border"
                                    placeholder="Kata Kunci Kejadian, Nama Orang" style="border-right: none;"
                                    value="@isset($search){{ $search }}@endisset">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-blue" id="btn-search-laporan-keyword">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        --}}{{-- calendar --}}{{--
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="header">Waktu Kejadian</div>
                <div class="card-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="tanggal">
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

    <section id="trending-keyword">
        <div class="row">
            <x-dashboard.bhabinkamtibmas.trending-netizen></x-dashboard.bhabinkamtibmas.trending-netizen>
            <x-dashboard.bhabinkamtibmas.trending-sosmed></x-dashboard.bhabinkamtibmas.trending-sosmed>
        </div>
    </section>

    <!-- History Filter -->
    <div class="row">
        <div class="col">
            <button type="button" id="previous-filter-button" class="btn btn-primary d-none">Filter Sebelumnya</button>
        </div>
    </div>
    @if(can('dashboard_map_access'))
    @component('components.dashboard.bhabinkamtibmas.peta-sebaran') @endcomponent
    @endif

    <!-- Chart Pendapat Warga -->
    <div class="row mt-3 d-none" id="parent-chart-pendapat-warga">
        <div class="col-12">
            <div class="card">
                <div class="header">
                    Perbandingan Keluhan dan Harapan Warga Per-Provinsi
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                onclick="angleIcon(this)">
                            <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body text-center" id="wrapper-chart-pendapat-warga">
                    <canvas id="chart-pendapat-warga" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    {{-- loader --}}
    <div class="loader">
        @component('components.shimmer.laporan') @endcomponent
    </div>

    {{-- laporan list --}}
    <div class="page-content hide" id="laporan-list">
        <div class="row mt-3">
        </div>
    </div>

    {{-- pagination --}}
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <ul id="pagination-laporan" class="pagination"></ul>
        </div>
    </div>
@endsection
@section('customjs')
    <script src="{{ asset('vendor/axios/axios.js') }}"></script>
    @include('assets.js.admin.dashboard')
    @include('assets.js.twbs-pagination')
    @include('assets.js.datetimepicker')
    <script>
        // Mode
        const MODE_PENCARIAN_KEYWORD    = 'pencarian-laporan-keyword';
        const MODE_PENCARIAN_TRENDING   = 'pencarian-laporan-trending';
        const MODE_PENCARIAN_POPULAR    = 'pencarian-laporan-popular';
        const MODE_PENCARIAN_REGION     = 'pencarian-laporan-region';
        const MODE_PENCARIAN_PROVINSI   = 'pencarian-laporan-provinsi';
        const MODE_PENCARIAN_POPULAR_KEYWORD   = 'pencarian-popular-keyword';

        // URL
        const URL_FILTER_DASHBOARD      = route('dashboard.dashboard-bhabinkamtibmas.filter');
        // Selector
        const SELECTOR_PENCARIAN_KEYWORD   = $('#form-pencarian-keyword');
        const SELECTOR_PENCARIAN_KEYWORD_POPULAR   = $('#trending-keyword');
        const SELECTOR_PENCARIAN_TRENDING  = '';
        const SELECTOR_PENCARIAN_POPULAR   = $('.popular-keyword');
        const SELECTOR_PENCARIAN_REGION    = '';

        SELECTOR_PENCARIAN_KEYWORD.submit(function(event){
            event.preventDefault();

            if(fillAtLeastOne({
                selector: $(this),
                excepts: ['method'],
            })) {
                let data = SEARCH_STATE.data;
                let formData = $(this).serializeArray()[0];

                Object.assign(data, {
                    search: keyword = formData['value']
                });
                filterDashboard(Object.assign(SEARCH_STATE, {
                    url: URL_FILTER_DASHBOARD,
                    data: data,
                    type: 'filter-search'
                }));
                $('#pagination-laporan').twbsPagination('destroy');
            } else {
                swalSetup('Anda belum memasukan kata kunci apapun!', 'Silahkan isi <i>field</i> kata kunci yang tersedia..','warning');
            }
            scrollDownTo('maps');
        });

        let getHightlightMap = (request) => {
            $.ajax({
                url: route('dashboard.dashboard-bhabinkamtibmas.tagged-map'),
                type: 'POST',
                data: request,
                success: function (highlightPath) {
                    initMap(highlightPath);
                }
            });
        }

        let filterDashboard = (options, saveHistory = true) => {
            if (options.type !== 'paging'){
                delete options.data.page;
                @if(can('dashboard_map_access'))
                getHightlightMap(options.data);
                @endif
                $('#pagination-laporan').twbsPagination('destroy');
            }
            showLoader();
            $.ajax({
                url: options.url,
                type: 'POST',
                data: options.data,
                success: function (response) {
                    if (saveHistory){
                        saveHistoryFilter(options);
                    }
                    hideLoader();
                    generateListLaporan(response);
                    initPaginate(response);
                },
                complete: function (data){
                    showOrHidePreviousHistoryButton();
                }
            });
        }

        function saveHistoryFilter(filterRequest) {
            let isFilter =  JSON.parse(localStorage.getItem('_DashboardFilter'));
            let filter   = [];
            if (!isEmpty(isFilter)){
                isFilter.map((item) => {
                    filter.push(item)
                });
            }
            filter.push(filterRequest)
            localStorage.setItem('_DashboardFilter', JSON.stringify(filter))
        }

        function getPreviousHistoryFilter(){
            let history = JSON.parse(localStorage.getItem('_DashboardFilter'));
            let previous= history.splice(-2)[0];
            localStorage.setItem('_DashboardFilter', JSON.stringify(history));
            return previous;
        }

        document.getElementById('previous-filter-button').addEventListener('click', function () {
            filterDashboard(getPreviousHistoryFilter(), false);
            showOrHidePreviousHistoryButton();
        });

        function showOrHidePreviousHistoryButton(){
            let checkHistory = JSON.parse(localStorage.getItem('_DashboardFilter'));
            if (checkHistory != null && checkHistory.length > 1){
                document.getElementById('previous-filter-button').classList.remove('d-none')
            } else {
                document.getElementById('previous-filter-button').classList.add('d-none')
            }
        }

        $(function () {
            initPencarianPopular();
            hideLoader();
            showOrHidePreviousHistoryButton();

            $("#tanggal").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2015,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            })
            $('#tanggal').daterangepicker(datetimeSetup, function (start, end, label) {
                let data = SEARCH_STATE.data;
                keyword += ' ' + label;
                Object.assign(data, {
                    start_date: start.format('YYYY-MM-DD' + ' 00:00:00'),
                    end_date: end.format('YYYY-MM-DD' + ' 23:59:59')
                });
                filterDashboard(Object.assign(SEARCH_STATE, {
                    url: URL_FILTER_DASHBOARD,
                    data: data,
                    type: 'filter-tanggal'
                }));
                getPopularKeywordLaporan();
            });
        })
    </script>
@endsection
