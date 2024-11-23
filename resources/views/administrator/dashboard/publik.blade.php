@extends('templates.admin-lte.admin')
@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/administrator/dashboard.css') }}">
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.jqvmap')
    @include('assets.css.datetimepicker')
    <style>
        .box-search-result > p {
            margin-bottom: 0.2em;
        }

        .popular-keyword:hover {
            color: royalblue;
        }

        .mark, mark {
            background-color: yellow;
        }

        .word {
            display: inline-block;
            margin: 2px;
            font-size:1em;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        @if(can('chart_laporan_bhabinkamtibmas_access'))
            {{-- chart laporan --}}
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="header">
                        Laporan Publik
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    onclick="angleIcon(this)">
                                <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body text-center" id="wrapper-chart-laporan">
                        <canvas id="laporan-publik"
                                style="min-height: 250px;  max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        @endif
        {{-- chart bidang-informasi--}}
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="header">
                    Rekap Bidang Informasi
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                onclick="angleIcon(this)">
                            <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body text-center" id="wrapper-chart-informasi">
                    <canvas id="rekap-bidang-informasi"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

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

    {{-- trending keyword --}}
    <section id="trending-keyword">
        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="card ">
                    <div class="header card-title">Trending Keyword Populer Citizen Hari Ini</div>
                    <div class="card-body text-center" style="padding-bottom:30px" id="popular-keyword">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="header">Trending Netizen Hari Ini</div>
                    <div class="card-body">
{{--                        <div id="twitter-trend" class="text-center"></div>--}}
                        <div id="google-trend" class="text-center">
                            <iframe id="trends-widget-3" title="trends-widget-3" src="https://trends.google.com/trends/embed/dailytrends?forceMobileMode=false&amp;isPreviewMode=true&amp;hl=in&geo=ID" width="100%" frameborder="0" scrolling="0" style="border-radius: 2px; box-shadow: rgba(0, 0, 0, 0.12) 0px 0px 2px 0px, rgba(0, 0, 0, 0.24) 0px 2px 2px 0px; height: 75vh;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3 d-none">
                <div class="card">
                    <div class="header card-title">Trending Hari ini</div>
                    <div class="card-body" id="trending-today">
                        <ul class="kejadian_baru"></ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Filter -->
    <div class="row">
        <div class="col">
            <button type="button" id="previous-filter-button" class="btn btn-primary d-none">Filter Sebelumnya</button>
        </div>
    </div>

    {{-- map  --}}
    <div class="row mt-3" id="maps">
        <div class="col-12">
            <div class="card">
                <div class="header">Peta</div>
                <div class="card-body" id="vmap-wrapper">
                    <div id="vmap" style="height: 550px;" class="text-center">
                    </div>
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
    @include('assets.js.jqvmap')
    @include('assets.js.jqvmap-identifier')
    @include('assets.js.twbs-pagination')
    @include('assets.js.datetimepicker')
    <script>
        // Script fetch trending twitter
        var words = [];

        // A $( document ).ready() block.
        $(document).ready(function() {
            $("#twitter-trend").html(preloader);
            $("#popular-keyword").html(preloader);

            let url = '{{ route('get-twitter.indonesia-trends') }}';
            @if(role('operator_bhabinkamtibmas_polda'))
                url = '{{ route('get-twitter.indonesia-trends', ['polda' => auth()->user()->personel->polda]) }}'
            @endif

            axios.get(url, {

            }).then(function (response) {
                words = response.data[0].trends.map(function (value, index, array) {
                    return {"name": value.name, "url": value.url};
                });
                placeWordsOnMap();
            }).catch(function (error) {
                console.log(error);
            })

            axios.get('{{ route('popular-keyword-dashboard') }}', {
                params: {
                    today: true,
                    jenis_laporan: 'Laporan Publik'
                }
            }).then(function (response) {
                generateKeywordPopularList(response.data);
            }).catch(function (error) {
                console.log(error);
            })

            // stylizeWords();
        });

        function placeWordsOnMap() {
            var htmlOutput = [];
            let fontSize = [36, 30, 30,30, 24, 24, 24, 20, 20, 20];
            let fontColor = ['danger', 'primary', 'primary', 'primary','warning', 'warning', 'warning', 'success', 'success', 'success'];
            for (var wordsI = 0; wordsI < words.length; wordsI++) {
                var word = words[wordsI];
                var randomInt = randomIntFromInterval(1, 10);
                htmlOutput[wordsI] = '<a class="word text-'+(fontColor[wordsI] ?? 'success')+'" href="' + word.url + '" style="font-size: ' + fontSize[wordsI] + 'px" target="_blank" data-count="' +
                    randomInt +
                    '">' +
                    word.name +
                    "</a>";
            }
            $("#twitter-trend").html(htmlOutput.sort(() => Math.random() - 0.5).join(""));
        }

        function stylizeWords() {
            var maxSize = 3;
            var minSize = 1;
            var wordsInListing = $("#twitter-trend").find("div.word");
            var maxWordCount = 0;

            // first get the max word count
            wordsInListing.each(function() {
                var count = $(this).data("count");
                if (count > maxWordCount) {
                    maxWordCount = count;
                }
            });

            wordsInListing.each(function() {
                var count = $(this).data("count");
                var ratioForStyle = round(maxSize * count / maxWordCount, 2);
                $(this).css("font-size", ratioForStyle + "em");
            });
        }
    </script>
    <script>
        function fillAtLeastOne(options){
            let errors = [];
            const data = [...options.selector.serializeArray()];
            data?.map((item)=>{
                if(!((item.value) && options.excepts.includes(item.name)) && (item.value)){
                    errors.push(item.name);
                }
            })
            return errors.length > 0;
        }

        function destroyMap() {
            // This is a hack, as the .empty() did not do the work
            $('#vmap').remove();

            // we recreate (after removing it) the container div, to reset all the data of the map
            $('#vmap-wrapper').append('<div id="vmap" class="text-center" style="height:550px;">'+preloader+'</div>');
        }

        function initMap(taggedMap = []){
            const CancelToken = axios.CancelToken;
            let cancel;

            $('#vmap').html('');
            $('#vmap').vectorMap({
                map: 'indonesia_id',
                enableZoom: true,
                showTooltip: true,
                backgroundColor: null,
                color: '#ddd',
                hoverOpacity: 0.7,
                selectedColor: '#c10606',
                values: generateObjectRandomData(),
                scaleColors: ['#2e6322', '#519931'],
                onLabelShow: function (event, label, code) {
                    let province = label[0].innerHTML;
                    label[0].innerHTML = 'Memproses statistik Polda ' + province + ', mohon menunggu...';
                    axios.post(route('dashboard.get-province-statistics'), {
                        provinsi: province,
                        jenis_laporan: "Laporan Publik"
                    }, {
                        cancelToken: new CancelToken(function executor(c) {
                            // An executor function receives a cancel function as a parameter
                            cancel = c;
                        })
                    })
                        .then(function (response) {
                            let html = `
                    <table>
                        <tr>
                            <td>Provinsi</td>
                            <td>: <strong>${ province }</strong></td>
                        </tr>
                        <tr>
                            <td>Jumlah laporan <strong>${ keyword }</strong> hari ini</td>
                            <td>: <strong>${response.data.totalToday}</strong> Laporan</td>
                        </tr>
                        <tr>
                            <td>Jumlah keseluruhan laporan <strong>${ keyword }</strong></td>
                            <td>: <strong>${response.data.total}</strong> Laporan</td>
                        </tr>
                    </table>`;
                            label[0].innerHTML = html;
                        })
                        .catch(function (error) {
                            if (axios.isCancel(error)) {
                                //console.log('Request canceled', error.message);
                            } else {
                                console.log(error)
                            }
                        });
                },
                onRegionOut: function(event, code, region){
                    cancel();
                },
                onRegionClick: function (event, code, region) {
                    @if(role('operator_bhabinkamtibmas_polda'))
                    if ("{{ \App\Helpers\Constants::MAP_PATH[\Illuminate\Support\Str::between(auth()->user()->personel->satuan1, 'POLDA ', '-')] }}" != code){
                        swalWarning('Anda tidak memiliki hak akses untuk permintaan ini')
                        event.preventDefault();
                    }
                    @endif
                    window.localStorage.setItem('selected-region', region);
                    flagRegionSelected = true;
                },
                onRegionSelect: function () {
                    if (flagRegionSelected){
                        let region = window.localStorage.getItem('selected-region')
                        let data = SEARCH_STATE.data;
                        Object.assign(data, {
                            provinsi: keyword = region
                        });
                        filterDashboard(Object.assign(SEARCH_STATE, {
                            url: URL_FILTER_DASHBOARD,
                            data: data,
                            type: 'filter-provinsi'
                        }));

                        scrollDownTo('trending-keyword');
                    }
                },
                onRegionDeselect: function (event, code, region) {
                    hideLaporanList();
                    delete SEARCH_STATE.data.provinsi;

                    filterDashboard(SEARCH_STATE);

                    $('#pagination-laporan').twbsPagination('destroy');
                },
                selectedRegions: Object.values(taggedMap)
            });
        }

        let keyword = '{{ role('operator_bhabinkamtibmas_polda') ? \Illuminate\Support\Str::between(auth()->user()->personel->polda, 'POLDA ', '-')  : "" }}';

        let flagRegionSelected = false;
        function toggleFlagRegionSelected() {
            flagRegionSelected = !flagRegionSelected;
        }

        // Search Query
        const SEARCH_STATE = {
            url     : null,
            data    : {
                jenis_laporan: 'Laporan Publik'
            },
            type    : null,
            selector: null
        }

        function initPencarianPopular(){
            $('.popular-keyword').click(function (event) {
                destroyMap();

                let data = SEARCH_STATE.data;
                Object.assign(data, {
                    keyword: keyword = $(this).html().trimLeft()
                });
                filterDashboard(Object.assign(SEARCH_STATE, {
                    url: URL_FILTER_DASHBOARD,
                    data: data,
                    type: 'filter-keyword'
                }));

                $('#pagination-laporan').twbsPagination('destroy');
                scrollDownTo('maps');
            });
        }

        function generateKeywordPopularList(data) {
            let popular = $('#popular-keyword');
            popular.html("");
            let htmlOutput = [];

            if (data.length > 0) {
                let keywords = data;
                let fontSize = [36, 30, 30,30, 24, 24, 24, 20, 20, 20];
                let fontColor = ['danger', 'primary', 'primary', 'primary','warning', 'warning', 'warning', 'success', 'success', 'success'];
                for (let index = 0; index < keywords.length; index++) {
                    let keyword = keywords[index];
                    htmlOutput[index] = `<a class="btn p-0 ml-2 popular-keyword text-${fontColor[index] ?? 'success'}" style="font-size: ${fontSize[index]}px !important" data-count="${keyword.jumlah}"> ${keyword.keyword}</a>`;
                }
                popular.html(htmlOutput.sort(() => Math.random() - 0.5).join(""));
                /*data.map((item) => {
                    if ((item.jumlah / 100) >= 7) {
                        popular.append(`<a class="btn p-0 ml-2 popular-keyword text-danger" style="font-size: 32px !important"> ${item.keyword}</a>`);
                    } else if ((item.jumlah / 100) >= 5) {
                        popular.append(`<a class="btn p-0 ml-2 popular-keyword text-warning" style="font-size: 20px !important"> ${item.keyword}</a>`);
                    } else if ((item.jumlah / 100) >= 3) {
                        popular.append(`<a class="btn p-0 ml-2 popular-keyword text-primary" style="font-size: 20px !important"> ${item.keyword}</a>`);
                    } else {
                        popular.append(`<a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: 16px !important"> ${item.keyword}</a>`);
                    }
                });*/
                initPencarianPopular();
            } else {
                popular.append('Keyword populer tidak ditemukan');
            }
        }

        function generateKeywordTrendingHariIni(data){

            let trending = $('#trending-today');
            trending.html('<ul class="kejadian_baru"></ul>');
            if (data.length > 0){
                data.map((item, key) => {
                    trending.children().last().append(`<li style="list-style : none"> ${key + 1} .  ${item.keyword}</li>`);
                });
            } else {
                trending.children().last().append(`<li style="list-style : none"> Trending hari ini tidak ditemukan. </li>`);
            }

        }

        function initPaginate(data){
            const selector = $('#pagination-laporan');
            const totalPages = data.last_page;
            const defaultOpts = {
                totalPages: totalPages,
                first: '<i class="fa fa-angle-double-left"></i> Pertama',
                last: 'Terakhir <i class="fa fa-angle-double-right"></i> ',
                prev: '<i class="fa fa-angle-left"></i> Sebelumnya',
                next: 'Selanjutnya <i class="fa fa-angle-right"></i> ',
            }
            const currentPage = selector.twbsPagination('getCurrentPage');
            selector.twbsPagination(defaultOpts);
            selector.twbsPagination('destroy');
            selector.twbsPagination($.extend({}, defaultOpts, {
                startPage: currentPage,
                totalPages: totalPages
            }));
            selector.on('page', function (evt, page) {
                let data = SEARCH_STATE.data;
                Object.assign(data , {
                    page: page,
                });

                filterDashboard(Object.assign(SEARCH_STATE, {
                    url: URL_FILTER_DASHBOARD,
                    data: data,
                    type: 'paging'
                }));
            });
        }

        function generateListLaporan(data){
            const searchLaporanList = $('#laporan-list');
            searchLaporanList.html('<div class="row mt-3"></div>');
            searchLaporanList.prepend('<p class="pl-1 pb-1 pt-2" style="text-transform: capitalize;"><b>'+addCommas(data.total)+'</b> laporan ditemukan'+'</p>');
            data.data?.map((item)=>{
                searchLaporanList.children().last().append(generateCardPencarianLaporan(item));
            });
        }

        function generateCardPencarianLaporan(laporan) {
            let keywords = laporan.keywords.map((val, index) => {
                let elem = val.keyword.includes(keyword) ? 'mark' : 'span';
                return `<${elem}>${val.keyword}</${elem}>`;
            }).join(',')

            const showDetail = (laporan.jenis === 'DDS Warga')
                ? `<a class="btn btn-primary" title="lihat detail laporan"
                    href="${route('detail-dds-warga', laporan.form.id)}">
                    <i class="fa fa-eye"></i> Lihat Detail
                </a>`
                : ''
            const showTelepon = (laporan.handphone.toString().length > 0) ? `
                <a href="tel:${laporan.handphone}" class="btn btn-success ${laporan.handphone ? '': 'disabled'}">
                    <i class="fa fa-phone"></i> ${laporan.handphone}
                </a>` : ''

            return `
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                             ${laporan.jenis}
                        </div>
                        <div class="card-body">
                            <div class="row title">
                                <span class="col-6">${keywords}</span>
                                <span class="col-6">${titleCase(laporan.polda)}</span>
                            </div>
                            <div class="row title">
                                <span class="col-6">${laporan.tanggal}</span>
                                <span class="col-6">${laporan.penulis}</span>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="card-body">
                            <p>${laporan.uraian}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <p class="text-muted">Laporan diperbarui pada: ${ moment(laporan.updated_at).locale('id').format('DD-MM-YYYY') }</p>
                            <div class="ml-auto mr-0">
                                ${showDetail} &nbsp;
                                ${showTelepon}
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        function rollbackTitlePopularCard()
        {
            SELECTOR_PENCARIAN_KEYWORD_POPULAR.find('.card-title:first').html('Trending Keyword Populer Citizen');
            SELECTOR_PENCARIAN_KEYWORD_POPULAR.find('.card-title:last').html('Trending Hari ini');
        }

        function showLoader(){
            $('.loader').show();
            hideLaporanList();
        }

        function hideLoader(){
            $('.loader').hide();
            showLaporanList();
        }

        function showLaporanList() {
            $('#laporan-list').show();
        }

        function hideLaporanList() {
            $('#laporan-list').hide();
        }

        function scrollDownTo(href){
            $('html, body').animate({
                scrollTop: $('#'+href+'').offset().top + "px"
            }, 700);
        }
    </script>
    <script>
        (function () {
            const donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            $.ajax({
                url: route('dashboard.publik.chart-jenis-pengguna'),
                type: 'get',
                beforeSend: function () {
                    $('#wrapper-chart-laporan').html(preloader);
                },
                success: function (response, status, xhr) {
                    $('#wrapper-chart-laporan').html(`<canvas id="laporan-publik"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>`);

                    let data = response;

                    const laporan = $('#laporan-publik').get(0).getContext('2d')
                    const laporanData = {
                        labels: Object.keys(data),
                        datasets: [
                            {
                                data: Object.values(data),
                                backgroundColor: ['#f56954', '#00a65a', '#f39c12',],
                            }
                        ]
                    }
                    let chartRekapLaporan = new Chart(laporan, {
                        type: 'doughnut',
                        data: laporanData,
                        options: Object.assign(donutOptions, {
                            onClick: event => {
                                /* checking where the click actually happens */
                                let box = chartRekapLaporan.boxes[0];
                                if((box.position === "top" && event.clientY >= box.height) || (box.position === "right" && event.clientX <= box.left)) {
                                    if (chartRekapLaporan.getElementsAtEvent(event).length  > 0){
                                        const model = chartRekapLaporan.getElementsAtEvent(event)[0]._model;

                                        let data = SEARCH_STATE.data;
                                        Object.assign(data, {
                                            jenis_publik: keyword = model.label
                                        })
                                        filterDashboard(Object.assign(SEARCH_STATE, {
                                            url: URL_FILTER_DASHBOARD,
                                            data: data,
                                            type: 'filter-jenis'
                                        }));

                                        scrollDownTo('trending-keyword');
                                    }
                                }
                            },
                            legend: {
                                position: 'top',
                                onClick: function (event, elem) {
                                    let index = elem.index;
                                    let ci = this.chart;
                                    let alreadyHidden = (ci.getDatasetMeta(index).hidden === null) ? false : ci.getDatasetMeta(index).hidden;

                                    ci.data.datasets.forEach(function(e, i) {
                                        let meta = ci.getDatasetMeta(i);

                                        if (i !== index) {
                                            if (!alreadyHidden) {
                                                meta.hidden = meta.hidden === null ? !meta.hidden : null;
                                            } else if (meta.hidden === null) {
                                                meta.hidden = true;
                                            }
                                        } else if (i === index) {
                                            meta.hidden = null;
                                        }
                                    });
                                    ci.update();

                                    let data = SEARCH_STATE.data;
                                    Object.assign(data, {
                                        jenis_laporan: keyword = elem.text
                                    })
                                    filterDashboard(Object.assign(SEARCH_STATE, {
                                        url: URL_FILTER_DASHBOARD,
                                        data: data,
                                        type: 'filter-jenis'
                                    }));

                                    scrollDownTo('trending-keyword');
                                }
                            }
                        }),
                    })
                }
            });

            $.ajax({
                url: route('dashboard.publik.chart-bidang-informasi', {
                    jenis_laporan: 'Laporan Publik'
                }),
                type: 'get',
                beforeSend: function () {
                    $('#wrapper-chart-informasi').html(preloader);
                },
                success: function (response, status, xhr) {
                    $('#wrapper-chart-informasi').html(`<canvas id="rekap-bidang-informasi"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>`);

                    let data = response;

                    const rekap = $('#rekap-bidang-informasi').get(0).getContext('2d')
                    const rekapData = {
                        labels: Object.keys(data),
                        datasets: [
                            {
                                data: Object.values(data),
                                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#3C8DBC'],
                            }
                        ]
                    }
                    let chartRekapLaporanInformasi = new Chart(rekap, {
                        type: 'doughnut',
                        data: rekapData,
                        options: Object.assign(donutOptions, {
                            onClick: event => {
                                /* checking where the click actually happens */
                                let box = chartRekapLaporanInformasi.boxes[0];
                                if((box.position === "top" && event.clientY >= box.height) || (box.position === "right" && event.clientX <= box.left)) {
                                    if (chartRekapLaporanInformasi.getElementsAtEvent(event).length  > 0){
                                        const model = chartRekapLaporanInformasi.getElementsAtEvent(event)[0]._model;

                                        let data = SEARCH_STATE.data;
                                        Object.assign(data, {
                                            bidang: keyword = model.label
                                        })
                                        filterDashboard(Object.assign(SEARCH_STATE, {
                                            url: URL_FILTER_DASHBOARD,
                                            data: data,
                                            type: 'filter-bidang'
                                        }));
                                        scrollDownTo('trending-keyword');
                                    }
                                }
                            },
                            legend: {
                                position: 'top',
                                onClick: function (event, elem) {
                                    let index = elem.index;
                                    let ci = this.chart;
                                    let alreadyHidden = (ci.getDatasetMeta(index).hidden === null) ? false : ci.getDatasetMeta(index).hidden;

                                    ci.data.datasets.forEach(function(e, i) {
                                        let meta = ci.getDatasetMeta(i);

                                        if (i !== index) {
                                            if (!alreadyHidden) {
                                                meta.hidden = meta.hidden === null ? !meta.hidden : null;
                                            } else if (meta.hidden === null) {
                                                meta.hidden = true;
                                            }
                                        } else if (i === index) {
                                            meta.hidden = null;
                                        }
                                    });
                                    ci.update();

                                    let data = SEARCH_STATE.data;
                                    Object.assign(data, {
                                        bidang: keyword = elem.text
                                    })
                                    filterDashboard(Object.assign(SEARCH_STATE, {
                                        url: URL_FILTER_DASHBOARD,
                                        data: data,
                                        type: 'filter-bidang'
                                    }));
                                    scrollDownTo('trending-keyword');
                                }
                            }
                        }),
                    })
                }
            });
        })()
    </script>

    <script>
        // Mode
        const MODE_PENCARIAN_KEYWORD    = 'pencarian-laporan-keyword';
        const MODE_PENCARIAN_TRENDING   = 'pencarian-laporan-trending';
        const MODE_PENCARIAN_POPULAR    = 'pencarian-laporan-popular';
        const MODE_PENCARIAN_REGION     = 'pencarian-laporan-region';
        const MODE_PENCARIAN_PROVINSI   = 'pencarian-laporan-provinsi';
        const MODE_PENCARIAN_POPULAR_KEYWORD   = 'pencarian-popular-keyword';

        // URL
        const URL_FILTER_DASHBOARD      = route('filter-dashboard-bhabinkamtibmas');
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
                destroyMap();
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

        let filterDashboard = (options, saveHistory = true) => {
            let rowTrendingKeyword = $('#trending-keyword');
            let wrapperPopular = $('#popular-keyword');
            let wrapperTrending = $('#trending-today');
            if (options.type !== 'paging'){
                delete options.data.page;
                rollbackTitlePopularCard();
                destroyMap();
                $('#pagination-laporan').twbsPagination('destroy');
                wrapperPopular.html(preloader);
            }
            showLoader();
            $.ajax({
                url: options.url,
                type: 'POST',
                data: options.data,
                success: function (result) {
                    if (saveHistory){
                        saveHistoryFilter(options);
                    }
                    if (options.type !== 'paging'){
                        wrapperPopular.html("");
                        wrapperTrending.html("");
                        rowTrendingKeyword.find('.card-title:first').html('Trending Keyword Populer Citizen di ' + keyword);
                        rowTrendingKeyword.find('.card-title:last').html('Trending Hari ini di ' + keyword);
                        flagRegionSelected = false;

                        generateKeywordPopularList(result.keyword);
                        // generateKeywordTrendingHariIni(result.keywordfilter(keyword => keyword.tanggal === formatDate(new Date(), 'm-d-Y')));
                        initMap(result.polda);
                    }

                    hideLoader();
                    generateListLaporan(result.laporan);
                    initPaginate(result.laporan);
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
            initMap();
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
                    start_date: start.format('YYYY-MM-DD'),
                    end_date: end.format('YYYY-MM-DD')
                });
                filterDashboard(Object.assign(SEARCH_STATE, {
                    url: URL_FILTER_DASHBOARD,
                    data: data,
                    type: 'filter-tanggal'
                }));
            });
        })
    </script>
@endsection
