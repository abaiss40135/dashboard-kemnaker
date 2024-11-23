<div class="row">
    @if(can('chart_laporan_bhabinkamtibmas_access'))
        {{-- chart laporan --}}
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="header">
                    Laporan Satpam
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                onclick="angleIcon(this)">
                            <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body text-center" id="wrapper-chart-laporan">
                    <canvas id="laporan-satpam"
                            style="min-height: 250px;  max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    @endif
    {{-- chart bidang-informasi--}}
    <div class="col-md-6 mt-3">
        <div class="card">
            <div class="header">
                Rekap Bidang Laporan
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                            onclick="angleIcon(this)">
                        <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
                    </button>
                </div>
            </div>
            <div class="card-body text-center" id="wrapper-chart-informasi">
                <canvas id="rekap-bidang-laporan"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@push('scripts')
    <script>
        (function () {
            const donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            $.ajax({
                url: route('dashboard.satpam.get-rekap-laporan-satpam'),
                type: 'get',
                beforeSend: function () {
                    $('#wrapper-chart-laporan').html(preloader);
                },
                success: function (response, status, xhr) {
                    $('#wrapper-chart-laporan').html(`<canvas id="chart-laporan-satpam"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>`);

                    let data = response;

                    @if(can('chart_laporan_bhabinkamtibmas_access'))
                    const laporan = $('#chart-laporan-satpam').get(0).getContext('2d');
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
                                if ((box.position === "top" && event.clientY >= box.height) || (box.position === "right" && event.clientX <= box.left)) {
                                    if (chartRekapLaporan.getElementsAtEvent(event).length > 0) {
                                        const model = chartRekapLaporan.getElementsAtEvent(event)[0]._model;

                                        let data = SEARCH_STATE.data;
                                        Object.assign(data, {
                                            jenis_laporan: keyword = model.label
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

                                    ci.data.datasets.forEach(function (e, i) {
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
                    @endif
                }
            });

            $.ajax({
                url: route('dashboard.satpam.get-rekap-bidang-laporan'),
                type: 'get',
                beforeSend: function () {
                    $('#wrapper-chart-informasi').html(preloader);
                },
                success: function (response, status, xhr) {
                    $('#wrapper-chart-informasi').html(`<canvas id="rekap-bidang-laporan"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>`);

                    let data = response;

                    const rekap = $('#rekap-bidang-laporan').get(0).getContext('2d');
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
                                if ((box.position === "top" && event.clientY >= box.height) || (box.position === "right" && event.clientX <= box.left)) {
                                    if (chartRekapLaporanInformasi.getElementsAtEvent(event).length > 0) {
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

                                    ci.data.datasets.forEach(function (e, i) {
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
@endpush
