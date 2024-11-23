<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h3 class="card-title">Peta Sebaran Operator Binpolmas yang sudah Login</h3>
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
                </div>
                <div class="text-center">
                    <h6 class="h6 font-weight-bold container-text-presentase-polda d-none">Presentase Operator Polda Binpolmas seluruh Indonesia yang sudah Login: <span class="d-none presentase-operator-polda"></span></h6>
                    <div class="d-block m-auto w-100">
                        <div class="d-flex justify-content-center align-items-center">
                            <div style="width: 5%;" class="d-block p-3 bg-success"></div>
                            <p class="mt-2 mx-2 font-weight-bold">:</p>
                            <p class="mt-2 font-weight-bold">Sudah Login</p>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div style="width: 5%;" class="d-block p-3 bg-danger"></div>
                            <p class="mt-2 mx-2 font-weight-bold">:</p>
                            <p class="mt-2 font-weight-bold">Belum Login</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 d-none container-data-operator-binpolmas">
        <div class="card">
            <div class="header">
                <h3 class="card-title">Data Operator Binpolmas</h3>
            </div>
            <div class="card-body">
                <div class="box-profile" style="font-size: smaller" id="box-profile">
{{--                    loading gif --}}
                    <div class="text-center">
                        <img class="img-fluid img-preloader d-none" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
                    </div>

                    <div class="container-data-polres d-none">
                        <div class="container-fluid mb-4">
                            <h4 class="h4 text-center null-operator-polda d-none">Wilayah Ini tidak memiliki Operator Polda Binpolmas Aktif</h4>

                            <div class="operator-polda-exist">
                                <h5 class="h5">Operator Binpolmas Polda: &nbsp;&nbsp; <span class="font-weight-bold nama-operator-polda"></span></h5>
                                <h5 class="h5">Pangkat/NRP: &nbsp;&nbsp; <span class="font-weight-bold pangkat-nrp-operator-polda"></span></h5>
                                <h5 class="h5">No. Handphone: &nbsp;&nbsp; <span class="font-weight-bold no-hp-operator-polda"></span></h5>
                                <h5 class="h5">Jabatan Personel: &nbsp;&nbsp; <span class="font-weight-bold jabatan-operator-polda"></span></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="h6 text-center">Presentase Ketercapaian Login Operator Binpolmas tingkat Polres wilayah <span class="nama-polda-presentase"></span>: <span class="badge total-presentase-login"></span></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NRP</th>
                                            <th>Nama Polres</th>
                                            <th>No. Handphone</th>
                                            <th>Status Login</th>
                                            <th>Login Terakhir</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody-operator-polres-binpolmas">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('customjs')
    @include('assets.js.select2')
    @include('assets.js.jqvmap')
    @include('assets.js.jqvmap-identifier')
    @include('assets.js.datetimepicker')

    <script>
        let taggedMapGlobal = [];
        const imgPreloader = document.querySelector('.img-preloader');
        const containerDataPolres = document.querySelector('.container-data-polres');

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

        function initSelectedMap(taggedMap = []) {
            destroyMap();
            const CancelToken = axios.CancelToken;
            let cancel;

            $('#vmap').html('');
            $('#vmap').vectorMap({
                map: 'indonesia_id'
                , enableZoom: true
                // , showTooltip: true
                , backgroundColor: null
                , color: '#ddd'
                , hoverOpacity: 0.7
                // , selectedColor: '#c10606'
                , selectedColor: '#0741ae'
                , values: generateObjectRandomData()
                , scaleColors: ['#c10606', '#ce3939']
                , selectedRegions: Object.values(taggedMap)
                , onRegionClick: async function (event, code, region) {
                    initSelectedMap([code])

                    if (cancel) {
                        cancel();
                    }

                    await fetchDataOperator(region);
                    initMap(taggedMapGlobal)
                }
                ,
            });
        }

        function initMap(taggedMap = []) {
            destroyMap();
            const CancelToken = axios.CancelToken;
            let cancel;

            $('#vmap').html('');
            $('#vmap').vectorMap({
                map: 'indonesia_id'
                , enableZoom: true
                // , showTooltip: true
                , backgroundColor: null
                , color: '#ddd'
                , hoverOpacity: 0.7
                // , selectedColor: '#c10606'
                , selectedColor: '#519931'
                , values: generateObjectRandomData()
                , scaleColors: ['#c10606', '#ce3939']
                , selectedRegions: Object.values(taggedMap)
                , onRegionClick: async function (event, code, region) {
                    initSelectedMap([code])

                    if (cancel) {
                        cancel();
                    }

                    await fetchDataOperator(region);
                    initMap(taggedMapGlobal)
                }
                ,
            });
        }

        function destroyMap() {
            // This is a hack, as the .empty() did not do the work
            $('#vmap').remove();

            // we recreate (after removing it) the container div, to reset all the data of the map
            $('#vmap-wrapper').append('<div id="vmap" class="text-center" style="height:550px;">' + preloader + '</div>');
        }

        async function fetchDataOperator(region) {
            const polda = getPolda(region);

            $('.container-data-operator-binpolmas').removeClass('d-none');
            imgPreloader.classList.remove('d-none');
            containerDataPolres.classList.add('d-none');

            const response = await fetch(route('chart-binpolmas.data-operator-binpolmas-polres-login', polda))
            const data = await response.json()

            if(data.data_operator_polda.hasOwnProperty('nama')) {
                $('.null-operator-polda').addClass('d-none');
                $('.nama-operator-polda').text(data.data_operator_polda.nama);
                $('.pangkat-nrp-operator-polda').text(data.data_operator_polda.pangkat + ' / ' + data.data_operator_polda.nrp);
                $('.no-hp-operator-polda').text(data.data_operator_polda.no_hp);
                $('.jabatan-operator-polda').text(data.data_operator_polda.jabatan);
            } else {
                $('.null-operator-polda').removeClass('d-none');
                $('.operator-polda-exist').addClass('d-none');
            }

            $('.nama-polda-presentase').text('POLDA ' + polda);
            $('.total-presentase-login').text(data.presentase_login_operator_polres + '%');
            if(data.presentase_login_operator_polres < 45) {
                $('.total-presentase-login').addClass('badge-danger');
                // remove class else
                $('.total-presentase-login').removeClass('badge-warning');
                $('.total-presentase-login').removeClass('badge-success');
            } else if(data.presentase_login_operator_polres < 80) {
                $('.total-presentase-login').addClass('badge-warning');
                // remove class else
                $('.total-presentase-login').removeClass('badge-danger');
                $('.total-presentase-login').removeClass('badge-success');
            } else {
                $('.total-presentase-login').addClass('badge-success');
                // remove class else
                $('.total-presentase-login').removeClass('badge-danger');
                $('.total-presentase-login').removeClass('badge-warning');
            }


            let tbodyOperatorPolresBinpolmas = '';
            if(data.list_operator.length > 0) {
                tbodyOperatorPolresBinpolmas = data.list_operator.map((operator, index) => {
                    return `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${operator.nama}</td>
                        <td>${operator.nrp}</td>
                        <td>${operator.polres}</td>
                        <td>${operator.no_hp}</td>
                        <td>${operator.status_login ? `<span class="badge badge-success">Sudah Login</span>` : `<span class="badge badge-warning">Belum Login</span>`}</td>
                        <td>${operator.last_login_at ?? '-'}</td>
                    </tr>
                `
                }).join('');
            } else {
                tbodyOperatorPolresBinpolmas = `
                    <tr>
                        <td colspan="7" class="text-center">Data Operator Polres Binpolmas tidak ditemukan</td>
                    </tr>
                `
            }

            $('#tbody-operator-polres-binpolmas').html(tbodyOperatorPolresBinpolmas);

            imgPreloader.classList.add('d-none');
            containerDataPolres.classList.remove('d-none');
        }

        (async function() {
            const response = await fetch(route('chart-binpolmas.tagged-map-login'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            const taggedMap = await response.json()
            const {highlight_path, presentase_operator_polda_login} = taggedMap.data;

            initMap(highlight_path);
            taggedMapGlobal = highlight_path;

            $('.container-text-presentase-polda').removeClass('d-none');
            const presentaseValue = $('.presentase-operator-polda')
            presentaseValue.text(presentase_operator_polda_login + '%');
            presentaseValue.removeClass('d-none');
            presentaseValue.addClass('badge');

            if(presentase_operator_polda_login < 45) {
                presentaseValue.addClass('badge-danger');
                // remove class else
                presentaseValue.removeClass('badge-warning');
                presentaseValue.removeClass('badge-success');
            } else if(presentase_operator_polda_login < 80) {
                presentaseValue.addClass('badge-warning');
                // remove class else
                presentaseValue.removeClass('badge-danger');
                presentaseValue.removeClass('badge-success');
            } else {
                presentaseValue.addClass('badge-success');
                // remove class else
                presentaseValue.removeClass('badge-danger');
                presentaseValue.removeClass('badge-warning');
            }
        })();
    </script>

@endsection
