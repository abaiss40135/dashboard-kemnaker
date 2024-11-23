@extends('templates.admin-lte.admin', ['title' => 'Dashboard Laporan Bhabinkamtibmas'])
@section('customcss')
<link rel="stylesheet" href="{{ asset('css/administrator/dashboard.css') }}">
@include('assets.css.shimmer')
@include('assets.css.pagination-responsive')
@include('assets.css.datetimepicker')
@include('assets.css.select2')
@include('assets.css.datatables')
@include('assets.css.jqvmap')
<style>
    .word {
        display: inline-block;
        margin: 2px;
        font-size: 1em;
    }

    .card-popular-keyword {
        padding-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #popular-keyword {
        max-height: 75vh;
        overflow-y: scroll;
    }

    .box-search-result>p {
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
        <form id="form-search" action="#" method="POST">
            @csrf
            <input type="hidden" name="start_date" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}">
            <div class="row">
                <div class="col-12 col-sm-4 col-lg-3">
                    <div class="form-group">
                        <label for="select-jenis-laporan">Jenis Laporan:</label>
                        <select id="select-jenis-laporan" name="jenis" class="select2 w-100">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-lg-3">
                    <div class="form-group">
                        <label for="select-bidang-informasi">Bidang Informasi:</label>
                        <select id="select-bidang-informasi" name="bidang" class="select2 w-100">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-lg-3">
                    <div class="form-group">
                        <label for="select-polda">Polda</label>
                        <select name="polda" id="select-polda" class="form-control select2"></select>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-lg-3">
                    <div class="form-group">
                        <label for="tanggal-laporan">Tanggal:</label>
                        <input type="text" id="tanggal-laporan" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-8 col-xl-9">
                    <div class="form-group">
                        <label for="search">Lain-lain:</label>
                        <input type="search" id="search" name="search" aria-label="global-search" placeholder="Cari kata kunci kejadian, nama atau nrp personel" class="form-control">
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
                    <button type="submit" id="btn-search" class="btn w-100 btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row" id="cardRow">
    @if(can('dashboard_map_access'))
    <div class="col-md-9">
        <div class="card">
            <div class="header">
                <h3 class="card-title">Peta Sebaran</h3>
            </div>
            <div class="card-body">
                <div class="text-center description-block mb-4">
                    <h2 class="description-header">{{ Carbon\Carbon::now()->translatedFormat(config('app.long_date_format')) }}</h2>
                </div>
                <div class="d-md-flex">
                    <div class="p-1 flex-fill text-center" style="overflow: hidden">
                        <div id="vmap-wrapper" style="height: 500px; overflow: hidden" class="mapael">
                            <div id="vmap"></div>
                        </div>
                    </div>
                    <div class="card-pane-right pt-2 pb-2 pl-4 pr-4">
                        <div id="div-bidang">
                            <div class="info-box mb-2 bg-light h-100">
                                <div class="info-box-content">
                                    <span class="info-box-text">EKONOMI</span>
                                    <span class="info-box-number">1122</span>
                                </div>
                            </div>
                            <div class="info-box mb-2 bg-light h-100">
                                <div class="info-box-content">
                                    <span class="info-box-text">KEAMANAN</span>
                                    <span class="info-box-number">2440</span>
                                </div>
                            </div>
                            <div class="info-box mb-2 bg-light h-100">
                                <div class="info-box-content">
                                    <span class="info-box-text">POLITIK</span>
                                    <span class="info-box-number">1093</span>
                                </div>
                            </div>
                            <div class="info-box mb-2 bg-light h-100">
                                <div class="info-box-content">
                                    <span class="info-box-text">SOSBUD</span>
                                    <span class="info-box-number">2521</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <h5 class="description-header" id="count-total">1373</h5>
                            <span class="description-text">LAPORAN</span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <h5 class="description-header" id="count-dds">1306</h5>
                            <span class="description-text">DDS</span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <h5 class="description-header" id="count-dd">64</h5>
                            <span class="description-text">Deteksi Dini</span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                            <h5 class="description-header" id="count-ps">3</h5>
                            <span class="description-text">Problem Solving</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="header">
                <h3 class="card-title">Laporan Infomasi Terbaru</h3>
            </div>
            <div class="card-body">
                <div class="box-profile" style="font-size: smaller" id="box-profile">
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <div class="description-block">
                            <a href="#" class="btn btn-success btn-block" id="wa-personel"><b>
                                    WhatsApp</b></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="description-block">
                            <a href="#" class="btn btn-secondary btn-block" id="contact-personel"><b> <i class="fa fa-phone mr-2"></i>
                                    Telepon</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="row" id="row-trends">
    <div class="col-md-6 mt-3">
        <div class="card">
            <div class="header card-header card-title">
                Trending Keyword
            </div>
            <div class="card-body card-popular-keyword">
                <div id="popular-keyword" class="w-100 text-center"></div>
            </div>
        </div>
    </div>
    <x-dashboard.bhabinkamtibmas.trending-sosmed></x-dashboard.bhabinkamtibmas.trending-sosmed>
</div>
{{-- loader --}}
<div class="shimmer">
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
@include('assets.js.select2')
@include('assets.js.datatables')
@include('assets.js.jqvmap')
@include('assets.js.jqvmap-identifier')
@include('assets.js.datetimepicker')
@include('assets.js.twbs-pagination')
{{-- Filter Script --}}
<script>
    const formFilter = $('#form-search');

    buildSelect2({
        placeholder: '-- Pilih Jenis Laporan --'
        , minimumInputLength: 0
        , minimumResultsForSearch: Infinity
        , selector: [{
            id: $('#select-jenis-laporan')
        }]
        , data: [{
                id: 'dds'
                , text: 'DDS Warga'
            }
            , {
                id: 'deteksi_dini'
                , text: 'Deteksi Dini'
            }
            , {
                id: 'problem_solving'
                , text: 'Problem Solving'
            }
        ]
    });
    buildSelect2({
        placeholder: '-- Pilih Bidang Informasi --'
        , minimumInputLength: 0
        , minimumResultsForSearch: Infinity
        , selector: [{
            id: $('#select-bidang-informasi')
        }]
        , data: [{
                id: 'ekonomi'
                , text: 'Ekonomi'
            }
            , {
                id: 'keamanan'
                , text: 'Kemanan'
            }
            , {
                id: 'politik'
                , text: 'Politik'
            }
            , {
                id: 'sosbud'
                , text: 'Sosial Budaya'
            }
        ]
    });
    buildSelect2Search({
        placeholder: '-- Pilih Polda --'
        , url: route('polda.select2')
        , minimumInputLength: 0
        , selector: [{
            id: $('#select-polda')
        }]
        , query: function(params) {
            return {
                polda: params.term
            , }
        }
    });
    $('#tanggal-laporan').daterangepicker({
        ...datetimeSetup
        , startDate: "{{ date('d/m/Y') }}"
    }, function(start, end) {
        formFilter.find('input[name="start_date"]').val(start.format('YYYY-MM-DD'));
        formFilter.find('input[name="end_date"]').val(end.format('YYYY-MM-DD'));
    });

    formFilter.on('reset', function() {
        formFilter.find("input[name='start_date'], input[name='end_date']").val('');
        formFilter.find("input[type=text], textarea, input[type=number], input[type=password], input[type=file]").val('');
        formFilter.find(".select2").val(null).trigger('change');
    });

    formFilter.on('submit', function(event) {
        event.preventDefault();
        disableSubmitButtonTemporarily(event.target);
    });

    formFilter.on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target); // Create a FormData object from the form

        // Convert FormData to a plain JavaScript object
        const data = {};
        formData.forEach((value, key) => {
            if (value !== "") {
                data[key] = value;
            }
        });

        fetchAll(data);

        setTimeout(() => {
            enableSubmitButton(event.target)
        }, 5000);
    });

    let fetchAll = (request) => {
        fetchDataJenisLaporan(request);
        fetchDataBidangLaporan(request);
        fetchLatestLaporanInformasi(request);
        getPopularKeywordLaporan(request);
        getListLaporan(request);
        getHightlightMap(request)
    }

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

    let fetchDataJenisLaporan = (request) => {
        axios({
            method: 'post'
            , url: route('api.dashboard.count-jenis')
            , data: request
        }).then((res) => {
            populateSummaryJenis(res.data);
        }).catch((er) => {
            console.log(er)
        })
    }

    let fetchDataBidangLaporan = (request) => {
        axios({
            method: 'post'
            , url: route('api.dashboard.bidang')
            , data: request
        }).then((res) => {
            populateSummaryBidang(res.data);
        }).catch((er) => {
            console.log(er)
        })
    }

    function populateInformasi(data) {
        const boxProfile = document.getElementById('box-profile');
        document.getElementById('wa-personel').setAttribute('href', 'https://wa.me/' + data.no_hp.replace(/^08/, '628'));
        document.getElementById('contact-personel').setAttribute('href', 'tel:' + data.no_hp);
        // Insert the HTML code into the "box-profile" div
        boxProfile.innerHTML = `
                <div class="row">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="${data.foto}"
                                alt="personel profile picture">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3 class="profile-username text-center">${data.personel}</h3>
                        <p class="text-center">${data.jabatan}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Narasumber</strong>
                        <p class="">
                            ${data.narasumber}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <strong>Pekerjaan</strong>
                        <p class="">
                            ${data.pekerjaan}
                        </p>
                    </div>
                </div>

                <strong>Alamat</strong>
                <p class="">${data.alamat}</p>
                <hr>
                <strong>Uraian</strong>
                <p class="text-justify">${data.uraian}</p>
                <p class="">
                    <span class="tag tag-danger">Kata Kunci: ${data.keyword.join(", ")}</span>
                </p>
            `;
    }

    let fetchLatestLaporanInformasi = (request) => {
        // loader
        const boxProfile = document.getElementById('box-profile');
        boxProfile.innerHTML = '';
        boxProfile.innerHTML += '<div class="text-center">' + preloader + '</div>';

        axios({
            method: 'post'
            , url: route('api.laporan.dd.latest')
            , data: request
        }).then((res) => {
            populateInformasi(res.data);
        }).finally(() => {
            setCardHeights(document.getElementById('cardRow'));
        }).catch((er) => {
            console.log(er)
        })
    }

    let populateSummaryJenis = (dataLaporan) => {
        let description = document.querySelector('.description-header')
        if (description) {
            description.textContent = dataLaporan.from === dataLaporan.to ?
                dataLaporan.from :
                `${dataLaporan.from} - ${dataLaporan.to}`;
        }

        document.getElementById('count-total').textContent = dataLaporan.total;
        document.getElementById('count-dds').textContent = dataLaporan.detail.dds;
        document.getElementById('count-dd').textContent = dataLaporan.detail.dd;
        document.getElementById('count-ps').textContent = dataLaporan.detail.ps;
    }

    let populateSummaryBidang = (data) => {
        let parent = document.getElementById('div-bidang');
        parent.innerHTML = "";
        if (parent) {
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    const value = data[key];
                    const infoBox = document.createElement("div");
                    infoBox.classList.add("info-box", "mb-2", "bg-light", "h-100");
                    infoBox.innerHTML = `
                            <div class="info-box-content">
                                <span class="info-box-text">${key.toUpperCase()}</span>
                                <span class="info-box-number">${value}</span>
                            </div>
                        `;
                    parent.appendChild(infoBox);
                }
            }
        }
    }

    function setCardHeights(parentElement) {
        const cards = parentElement.querySelectorAll('.card');
        let maxHeight = 0;

        cards.forEach(card => {
            const cardHeight = card.clientHeight;
            maxHeight = Math.max(maxHeight, cardHeight);
        });

        cards.forEach(card => {
            card.style.height = maxHeight + 'px';
        });
    }

    const interval = setInterval(fetchLatestLaporanInformasi, 60000); // 60,000 milliseconds = 1 minute

    window.onload = (event) => {
        formFilter.submit();
    };

</script>
<script>
    /**
     * Disabled on/off previous filter by user
     * check from localStorage _DashboardFilter
     */
    let togglePreviousFilterButton = () => {
        let checkHistory = JSON.parse(localStorage.getItem('_DashboardFilter'));
        document.getElementById('previous-filter-button').disabled = !(checkHistory != null && checkHistory.length > 1)
    }

    (function() {
        togglePreviousFilterButton();
    })();

</script>
<script>
    function getPolda(province) {
        let datasets = {
            "ACEH": "ACEH"
            , "SUMATERA UTARA": "SUMUT"
            , "SUMATERA BARAT": "SUMBAR"
            , "RIAU": "RIAU"
            , "JAMBI": "JAMBI"
            , "SUMATERA SELATAN": "SUMSEL"
            , "BENGKULU": "BENGKULU"
            , "LAMPUNG": "LAMPUNG"
            , "KEP. BANGKA BELITUNG": "KEP. BABEL"
            , "KEPULAUAN BANGKA BELITUNG": "KEP. BABEL"
            , "KEPULAUAN RIAU": "KEPRI"
            , "KEP. RIAU": "KEPRI"
            , "DKI JAKARTA": "METRO JAYA"
            , "JAWA BARAT": "JABAR"
            , "JAWA TENGAH": "JATENG"
            , "BANTEN": "BANTEN"
            , "JAWA TIMUR": "JATIM"
            , "YOGYAKARTA": "DIY"
            , "DAERAH ISTIMEWA YOGYAKARTA": "DIY"
            , "BALI": "BALI"
            , "NUSA TENGGARA BARAT": "NTB"
            , "NUSA TENGGARA TIMUR": "NTT"
            , "KALIMANTAN BARAT": "KALBAR"
            , "KALIMANTAN TENGAH": "KALTENG"
            , "KALIMANTAN SELATAN": "KALSEL"
            , "KALIMANTAN TIMUR": "KALTIM"
            , "KALIMANTAN UTARA": "KALTARA"
            , "SULAWESI UTARA": "SULUT"
            , "SULAWESI TENGAH": "SULTENG"
            , "SULAWESI SELATAN": "SULSEL"
            , "SULAWESI TENGGARA": "SULTRA"
            , "GORONTALO": "GORONTALO"
            , "SULAWESI BARAT": "SULBAR"
            , "MALUKU": "MALUKU"
            , "MALUKU UTARA": "MALUT"
            , "PAPUA": "PAPUA"
            , "PAPUA BARAT": "PAPUA BARAT"
        }
        return datasets[province.toUpperCase()];
    }
    let flagRegionSelected = false;

    function toggleFlagRegionSelected() {
        flagRegionSelected = !flagRegionSelected;
    }

    function initMap(taggedMap = []) {
        destroyMap();

        const CancelToken = axios.CancelToken;
        let cancel;

        $('#vmap').html('');
        $('#vmap').vectorMap({
            map: 'indonesia_id'
            , enableZoom: true
            , showTooltip: true
            , backgroundColor: null
            , color: '#ddd'
            , hoverOpacity: 0.7
            , selectedColor: '#c10606'
            , values: generateObjectRandomData()
            , scaleColors: ['#2e6322', '#519931']
            , selectedRegions: Object.values(taggedMap)
        });
    }

    function destroyMap() {
        // This is a hack, as the .empty() did not do the work
        $('#vmap').remove();

        // we recreate (after removing it) the container div, to reset all the data of the map
        $('#vmap-wrapper').append('<div id="vmap" class="text-center" style="height:550px;">' + preloader + '</div>');
    }

    (function() {
        initMap();
    })();

</script>
<script>
    // Script fetch trending twitter
    var words = [];

    const getListLaporan = (request) => {
        axios({
            method: 'post'
            , url: route('api.laporan.get')
            , data: request
        }).then((res) => {
            populateListLaporan(res.data);
            initPaginate(res.data);
        }).finally(() => {
            $('.shimmer').hide();
            $('#laporan-list').show();
            setCardHeights(document.getElementById('laporan-list'))
        }).catch((er) => {
            console.log(er)
        })
    }

    function initPencarianPopular() {
        $('.popular-keyword').click(function(event) {
            $('.shimmer').show();
            $('#laporan-list').hide();
            const formSearch = document.getElementById('form-search');
            let formData = new FormData(formSearch);
            formData.append('keyword_id', $(this).data('id'));

            const data = {};
            formData.forEach((value, key) => {
                if (value !== "") {
                    data[key] = value;
                }
            });
            getListLaporan(data)
        });
    }

    function generateKeywordPopularList(data) {
        let popular = $('#popular-keyword');
        popular.html("");
        let htmlOutput = [];

        if (data.length > 0) {
            let keywords = data;
            let fontSize = [36, 30, 30, 30, 24, 24, 24, 20, 20, 20];
            let fontColor = ['danger', 'primary', 'primary', 'primary', 'warning', 'warning', 'warning', 'success', 'success', 'success'];
            for (let index = 0; index < keywords.length; index++) {
                let keyword = keywords[index];
                htmlOutput[index] = `<a class="btn p-0 ml-2 popular-keyword text-${fontColor[index] ?? 'success'}" style="font-size: ${fontSize[index]}px !important" data-count="${keyword.count}" data-id="${keyword.keyword_id}"> ${keyword.keyword}</a>`;
            }
            popular.html(htmlOutput.sort(() => Math.random() - 0.5).join(""));
            initPencarianPopular();
        } else {
            popular.append('Keyword populer tidak ditemukan');
        }
    }

    function getPopularKeywordLaporan(request) {
        let wrapperPopular = $('#popular-keyword');
        wrapperPopular.html(preloader);

        axios({
            method: 'post'
            , url: route('api.dashboard.keyword')
            , data: request
        }).then((res) => {
            generateKeywordPopularList(res.data);
        }).catch((er) => {
            console.log(er)
        })
    }

</script>
<script>
    function populateListLaporan(data) {
        const searchLaporanList = $('#laporan-list');
        searchLaporanList.html('<div class="row mt-3"></div>');
        searchLaporanList.prepend('<p class="pl-1 pb-1 pt-2" style="text-transform: capitalize;"><b>' + addCommas(data.total) + '</b> laporan ditemukan' + '</p>');

        function generateCardPencarianLaporan(laporan) {
            let keywords = laporan.keyword.join(',')

            const showWA = (laporan.no_hp.toString().length > 0) ? `
                <a href="${'https://wa.me/' + laporan.no_hp.replace(/^08/, '628')}" class="btn btn-success ${laporan.no_hp ? '' : 'disabled'}">
                    WhatsApp
                </a>` : '';

            const showTelepon = (laporan.no_hp.toString().length > 0) ? `
                <a href="tel:${laporan.no_hp}" class="btn btn-secondary ${laporan.no_hp ? '' : 'disabled'}">
                    <i class="fa fa-phone"></i> Telepon
                </a>` : ''

            return `
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header header">
                                 ${laporan.jenis}
                            </div>
                            <div class="card-body">
                                <h5>Pelapor</h5>
                                <div class="row">
                                <label class="col-sm-2">Nama</label>
                                <div class="col-sm-8">
                                    <p>${laporan.personel}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2">Jabatan</label>
                                <div class="col-sm-8">
                                    <p>${laporan.jabatan}</p>
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
                                <div class="col-sm-9">
                                    <p>Kata Kunci: ${keywords}</p>
                                </div>
                                <div class="col-sm-3 d-flex justify-content-end">
                                    <p>${laporan.waktu}</p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">${laporan.uraian}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div class="ml-auto mr-0">
                                ${showWA} &nbsp;
                                ${showTelepon}
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        data.data?.map((item) => {
            searchLaporanList.children().last().append(generateCardPencarianLaporan(item));
        });
    }

    /* let getListLaporan = (request) => {
        axios({
            method: 'post'
            , url: route('api.laporan.get')
            , data: request
        }).then((res) => {
            populateListLaporan(res.data);
            initPaginate(res.data);
        }).finally(() => {
            $('.shimmer').hide();
            $('#laporan-list').show();
            setCardHeights(document.getElementById('laporan-list'))
        }).catch((er) => {
            console.log(er)
        })
    } */

    function initPaginate(data) {
        const selector = $('#pagination-laporan');
        const totalPages = data.last_page;
        const defaultOpts = {
            totalPages: totalPages
            , first: '<i class="fa fa-angle-double-left"></i> Pertama'
            , last: 'Terakhir <i class="fa fa-angle-double-right"></i> '
            , prev: '<i class="fa fa-angle-left"></i> Sebelumnya'
            , next: 'Selanjutnya <i class="fa fa-angle-right"></i> '
        , }
        // const currentPage = selector.twbsPagination('getCurrentPage');
        const currentPage = data.current_page;
        selector.twbsPagination(defaultOpts);
        selector.twbsPagination('destroy');
        selector.twbsPagination($.extend({}, defaultOpts, {
            startPage: currentPage
            , totalPages: totalPages
        }));
        selector.on('page', function(evt, page) {
            $('.shimmer').show();
            $('#laporan-list').hide();

            const formSearch = document.getElementById('form-search');
            let formData = new FormData(formSearch);
            formData.append('page', page);

            let data = {};
            formData.forEach((value, key) => {
                if (value !== "") {
                    data[key] = value;
                }
            });
            getListLaporan(data)
        });
    }

</script>
@endsection
