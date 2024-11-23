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
    <x-dashboard.satpam.chart></x-dashboard.satpam.chart>
    {{-- search dan calendar --}}
    <div class="row">
        {{-- search --}}
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
        {{-- calendar --}}
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
    </div>
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
        <x-dashboard.satpam.peta-sebaran></x-dashboard.satpam.peta-sebaran>
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
    <div class="loader d-none">
        <x-shimmer.laporan></x-shimmer.laporan>
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
        // URL
        const URL_FILTER_DASHBOARD      = route('dashboard.satpam.filter');

        $('#form-pencarian-keyword').submit(function(event){
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
            scrollDownTo('laporan-list');
        });

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

        let getHightlightMap = (request) => {
            $.ajax({
                url: route('dashboard.satpam.tagged-map'),
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
                    generateListLaporanSatpam(response);
                    initPaginate(response);
                },
                complete: function (data){
                    showOrHidePreviousHistoryButton();
                }
            });
        }

        let showOrHidePreviousHistoryButton = () => {
            let checkHistory = JSON.parse(localStorage.getItem('_DashboardFilter'));
            if (checkHistory != null && checkHistory.length > 1){
                document.getElementById('previous-filter-button').classList.remove('d-none')
            } else {
                document.getElementById('previous-filter-button').classList.add('d-none')
            }
        }

        function generateListLaporanSatpam(data){
            const searchLaporanList = $('#laporan-list');
            searchLaporanList.html('<div class="row mt-3"></div>');
            searchLaporanList.prepend('<p class="pl-1 pb-1 pt-2" style="text-transform: capitalize;"><b>'+addCommas(data.total)+'</b> laporan ditemukan'+'</p>');
            data.data?.map((item)=>{
                searchLaporanList.children().last().append(renderCard(item));
            });
        }

        function renderCard(laporan) {
            let keywords = laporan.tags.split(',').map((val, index) => {
                let elem = val.includes(keyword) ? 'mark' : 'span';
                return `<${elem}>${val}</${elem}>`;
            }).join(',')

            const showTelepon = (laporan.handphone.toString().length > 0) ? `
                <a href="tel:${laporan.handphone}" class="btn btn-success ${laporan.handphone ? '': 'disabled'}">
                    <i class="fa fa-phone"></i> ${laporan.handphone}
                </a>` : ''

            return `
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header header">
                             ${laporan.jenis_laporan}
                        </div>
                        <div class="card-body">
                            <h5>Pelapor</h5>
                            <div class="row">
                                <label class="col-sm-2">Nama</label>
                                <div class="col-sm-8">
                                    <p>${laporan.nama}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2">Alamat</label>
                                <div class="col-sm-8">
                                    <p>${laporan.alamat_satpam}</p>
                                </div>
                            </div>
                            <hr class="mt-0">
                            <h5>Narasumber</h5>
                            <div class="row">
                                <label class="col-sm-2">Nama</label>
                                <div class="col-sm-8">
                                    <p>${laporan.narasumber}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2">Alamat</label>
                                <div class="col-sm-8">
                                    <p>${laporan.alamat}</p>
                                </div>
                            </div>
                            <hr class="mt-0">
                            <h5>Informasi</h5>
                            <div class="row">
                                <div class="col-sm-10">
                                    <p>${keywords}</p>
                                </div>
                                <div class="col-sm-2 d-flex justify-content-end">
                                    <p>${laporan.tanggal_laporan}</p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">${laporan.uraian_informasi}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <p class="text-muted">Laporan diperbarui pada: ${ moment(laporan.updated_at).locale('id').format('DD-MM-YYYY') }</p>
                            <div class="ml-auto mr-0">
                                ${showTelepon}
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        $(function () {
            showOrHidePreviousHistoryButton();

            $("#tanggal").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2019,
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
