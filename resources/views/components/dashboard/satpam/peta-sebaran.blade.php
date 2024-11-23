@push('styles')
    @include('assets.css.jqvmap')
@endpush
{{-- map  --}}
<div class="row mt-3" id="maps">
    {{-- maps --}}
    <div class="col-12">
        <div class="card">
            <div class="header">
                Peta
            </div>
            <div class="card-body" id="vmap-wrapper">
                <div id="vmap" style="height: 550px;" class="text-center">
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    @include('assets.js.jqvmap')
    @include('assets.js.jqvmap-identifier')
    <script>
        let flagRegionSelected = false;
        function toggleFlagRegionSelected() {
            flagRegionSelected = !flagRegionSelected;
        }

        function initMap(taggedMap = []){
            destroyMap();

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

                    /*let data = SEARCH_STATE.data;
                    Object.assign(data, {
                        province: province
                    });*/

                    label[0].innerHTML = 'Memproses statistik Polda ' + province + ', mohon menunggu...';
                    axios.post(route('dashboard.satpam.get-province-statistics'), {
                        province: province
                    }, {
                        cancelToken: new CancelToken(function executor(c) {
                            // An executor function receives a cancel function as a parameter
                            cancel = c;
                        })
                    })
                        .then(function (response) {
                            label[0].innerHTML = `
                    <table id="tooltips-map">
                        <tr>
                            <td>Provinsi</td>
                            <td>: <strong>${province}</strong></td>
                        </tr>
                        <tr>
                            <td>Jumlah laporan <strong>${keyword}</strong> hari ini</td>
                            <td>: <strong>${response.data.totalToday}</strong> Laporan</td>
                        </tr>
                        <tr>
                            <td>Jumlah keseluruhan laporan <strong>${keyword}</strong></td>
                            <td>: <strong>${response.data.total}</strong> Laporan</td>
                        </tr>
                    </table>`;
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
                            province: keyword = region
                        });
                        filterDashboard(Object.assign(SEARCH_STATE, {
                            url: URL_FILTER_DASHBOARD,
                            data: data,
                            type: 'filter-polda'
                        }));
                        getPopularKeywordLaporan();
                        scrollDownTo('laporan-list');
                    }
                },
                onRegionDeselect: function (event, code, region) {
                    hideLaporanList();
                    delete SEARCH_STATE.data.province;

                    filterDashboard(SEARCH_STATE);

                    $('#pagination-laporan').twbsPagination('destroy');
                },
                selectedRegions: Object.values(taggedMap)
            });
        }

        function destroyMap() {
            // This is a hack, as the .empty() did not do the work
            $('#vmap').remove();

            // we recreate (after removing it) the container div, to reset all the data of the map
            $('#vmap-wrapper').append('<div id="vmap" class="text-center" style="height:550px;">' + preloader + '</div>');
        }
        (function (){
            initMap();
        })();
    </script>
@endpush
