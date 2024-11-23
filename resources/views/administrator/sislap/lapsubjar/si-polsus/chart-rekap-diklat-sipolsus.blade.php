<div id="polsus-chart" class="card">
    <div class="card-header bg-primary">
        @if(auth()->user() && auth()->user()->haveRole('operator_polsus_polda') && !getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda))
            Anda Belum Tercantum pada Polda manapun!
        @else
            Chart Rekapitulasi Data Polsus
            @if(auth()->user() && auth()->user()->haveRole('operator_polsus_kl_provinsi'))
                Pada Provinsi {{auth()->user()->polsus->provinsi}} Polsus {{ucwords( implode(' ', explode('_', auth()->user()->polsus->jenis_polsus)) )}}
            @elseif(auth()->user() && auth()->user()->haveRole('operator_polsus_kl_kota_kabupaten'))
                Pada {{auth()->user()->polsus->kabupaten}} Polsus {{ucwords( implode(' ', explode('_', auth()->user()->polsus->jenis_polsus)) )}}
            @elseif(auth()->user() && auth()->user()->haveRole('operator_polsus_polda') && getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda))
                 Pada Provinsi {{ucwords(getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda))}}
            @endif
        @endif
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                    onclick="angleIcon(this)">
                <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
            </button>
        </div>
    </div>
    <div class="card-body py-4">
        <button disabled class="mt-2 mb-4 btn btn-warning d-none reset-chart-btn">Kembali ke Tampilan Awal</button>

        <canvas id="chart-rekap-sipolsus" style="max-height: 450px"></canvas>
        <canvas id="chart-prov-2" class="d-none" style="max-height: 450px"></canvas>
        <div class="text-center preloader">
            <img class="img-fluid" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
        </div>
    </div>
</div>


@push('scripts')
    <script>
        const chartRekapSipolsus = document.querySelector('#chart-rekap-sipolsus')
        const resetPolsusChartbtn = document.querySelector('#polsus-chart .reset-chart-btn')
        const polsusChartPreloader = document.querySelector('#polsus-chart .preloader')

        const barChartRekapSipolsus = chartRekapSipolsus.getContext('2d')
        const initChartRekapSipolsus = (data, labels, label) => {
            const chart = new Chart(barChartRekapSipolsus, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: "hsl(0, 10%, 10%)"
                    }]
                },
                options: {
                    // This chart will not respond to mousemove, etc
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            const clickBarChart = click => {
                const slice = chart.getElementsAtEventForMode(click, 'nearest', {intersect:true}, true)

                //if user click slice of bar then the length is 1
                if(slice.length) {
                    const index = slice[0].index
                    const type = slice[0].element.$context.dataset.label

                    // tahap 2 operator polsus polda dan admin, sedangkan tahap 3 hanya bisa diakses oleh admin
                    @if(empty(auth()->user()) || auth()->user()->haveRole('operator_polsus_polda') || auth()->user()->haveRole('administrator'))
                        // tahap 2
                        if(type.split(' ').includes('Rekapitulasi'))
                        {
                            resetPolsusChartbtn.removeAttribute('disabled')
                            chart.destroy()

                            if(index == 0) {
                                initDataChartJenisPolsus('reguler')
                            } else if(index == 1) {
                                initDataChartJenisPolsus('khusus-pejabat-kl')
                            } else if(index == 2) {
                                initDataChartJenisPolsus('khusus-tni-polri')
                            } else if(index == 3) {
                                initDataChartJenisPolsus('polsus-memiliki-kta')
                            } else if(index == 4) {
                                initDataChartJenisPolsus('belum')
                            } else if(index == 5) {
                                initDataChartJenisPolsus('polsus-pensiun')
                            }

                        }
                    @endif
                    @if(empty(auth()->user()) || auth()->user()->haveRole('administrator'))
                        // tahap 3
                        if(type.split(' ').includes('Jumlah'))
                        {
                            chart.destroy()

                            if(index == 0) {
                                initDataChartProvinsi(type, 'polsuspas')
                            } else if(index == 1) {
                                initDataChartProvinsi(type, 'polhut-lhk')
                            } else if(index == 2) {
                                initDataChartProvinsi(type, 'polhut-perhutani')
                            } else if(index == 3) {
                                initDataChartProvinsi(type, 'polsus-cagar-budaya')
                            } else if(index == 4) {
                                initDataChartProvinsi(type, 'polsuska')
                            } else if(index == 5) {
                                initDataChartProvinsi(type, 'polsus-pwp3k')
                            } else if(index == 6) {
                                initDataChartProvinsi(type, 'polsus-karantina-ikan')
                            } else if(index == 7) {
                                initDataChartProvinsi(type, 'polsus-barantan')
                            } else if(index == 8) {
                                initDataChartProvinsi(type, 'polsus-satpol-pp')
                            } else if(index == 9) {
                                initDataChartProvinsi(type, 'polsus-dishubdar')
                            }
                        }
                    @endif
                }
            }

            chartRekapSipolsus.onclick = clickBarChart
            resetPolsusChartbtn.onclick = resetPolsusChart
        }

        const initPolsusChartFirstTime = () => {
            polsusChartPreloader.classList.remove('d-none')
            resetPolsusChartbtn.classList.add('d-none')

            axios.get(route('chart-sipolsus.tahap1'))
                .then(res => res.data)
                .then(data => {
                    polsusChartPreloader.classList.add('d-none')
                    resetPolsusChartbtn.classList.remove('d-none')
                    resetPolsusChartbtn.setAttribute('disabled', 'true')

                    initChartRekapSipolsus([
                        data.reguler, data.khusus_pejabat_kl, data.khusus_pensiun_tni_polri, data.polsus_memiliki_kta,
                        data.polsus_belum_diklat, data.polsus_pensiun
                    ], [
                        'Total Polsus Diklat Reguler', 'Total Polsus Diklat Khusus Pejabat K/L', 'Total Polsus Diklat Khusus Pensiunan TNI/Polri',
                        'Total Polsus Yang Memiliki KTA', 'Total Polsus yang belum Diklat', 'Total Polsus Pensiun'
                    ], 'Rekapitulasi Data Polsus')
                })
        }

        const initDataChartJenisPolsus = type => {
            const arrPolsus = [
                'Polsuspas',
                'Polhut LHK',
                'Polhut Perhutani',
                'Polsus Cagar Budaya',
                'Polsuska',
                'Polsus PWP3K',
                'Polsus Karantina Ikan',
                'Polsus Barantan',
                // 'Polsus Satpol PP',
                // 'Polsus Dishubdar'
            ]

            polsusChartPreloader.classList.remove('d-none')
            resetPolsusChartbtn.classList.add('d-none')

            // lakukan pemanggilan ke server untuk mendapatkan data
            axios.get(route('chart-sipolsus.tahap2', type))
                .then(res => res.data)
                .then(data => {
                    polsusChartPreloader.classList.add('d-none')
                    resetPolsusChartbtn.classList.remove('d-none')

                    const dataPolsus = [
                        data.polsuspas,
                        data.polhut_lhk,
                        data.polhut_perhutani,
                        data.polsus_cagar_budaya,
                        data.polsuska,
                        data.polsus_pwp3k,
                        data.polsus_karantina_ikan,
                        data.polsus_barantan,
                        // data.polsus_satpol_pp,
                        // data.polsus_dishubdar
                    ]

                    let title;
                    switch (type) {
                        case 'reguler' :
                            title = 'Jumlah Polsus Diklat Reguler'
                            break;
                        case 'khusus-tni-polri' :
                            title = 'Jumlah Polsus Diklat Khusus Pensiunan TNI/Polri'
                            break;
                        case 'khusus-pejabat-kl' :
                            title = 'Jumlah Polsus Diklat Khusus Pejabat Lingkungan K/L'
                            break;
                        case 'polsus-memiliki-kta' :
                            title = 'Jumlah Polsus yang Memiliki KTA'
                            break;
                        case 'belum' :
                            title = 'Jumlah Polsus yang Belum Melakukan Diklat'
                            break;
                        case 'polsus-pensiun' :
                            title = 'Jumlah Polsus yang sudah Pensiun'
                            break;
                    }

                    initChartRekapSipolsus(
                        dataPolsus, arrPolsus, title
                    )
                })
        }

        const initDataChartProvinsi = (type, jenis_polsus) => {
            const arrExplodeType = type.split(' ')
            const polsus = jenis_polsus.split('-').map(word => word[0].toUpperCase() + word.substr(1)).join(' ')
            let label = ''
            let typeRequest = '' // typeRequest adalah jenjang diklat polsus atau polsus pensiun

            if(arrExplodeType.includes('Reguler')) {
                label = `Total ${polsus} Diklat Reguler pada Tingkat Provinsi`
                typeRequest = 'reguler'

            } else if(arrExplodeType.includes('TNI/Polri')) {
                label = `Total ${polsus} Diklat Khusus Pensiunan TNI/Polri pada Tingkat Provinsi`
                typeRequest = 'khusus-tni-polri'

            } else if(arrExplodeType.includes('K/L')) {
                label = `Total ${polsus} Diklat Khusus Lingkungan K/L pada Tingkat Provinsi`
                typeRequest = 'khusus-pejabat-kl'

            } else if(arrExplodeType.includes('KTA')) {
                label = `Total ${polsus} yang Sudah Memiliki KTA pada Tingkat Provinsi`
                typeRequest = 'polsus-memiliki-kta'

            } else if(arrExplodeType.includes('Belum')) {
                label = `Total ${polsus} yang belum Diklat pada Tingkat Provinsi`
                typeRequest = 'belum'

            } else if(arrExplodeType.includes('Pensiun')) {
                label = `Total ${polsus} yang sudah Pensiun pada Tingkat Provinsi`
                typeRequest = 'polsus-pensiun'
            }

            polsusChartPreloader.classList.remove('d-none')
            resetPolsusChartbtn.classList.add('d-none')

            axios.get(route('chart-sipolsus.tahap3', {
                        type: typeRequest,
                        jenis_polsus: jenis_polsus
                    })
                )
                .then(res => res.data)
                .then(data => {
                    polsusChartPreloader.classList.add('d-none')
                    resetPolsusChartbtn.classList.remove('d-none')

                    const dataPolsus = data.provinsi.map(prov => data['data_polsus'][prov])

                    initChartRekapSipolsus(dataPolsus, data.provinsi, label)
                })
        }

        const resetPolsusChart = () => {
            let chart = Chart.getChart("chart-rekap-sipolsus");

            chart.destroy()
            initPolsusChartFirstTime()
        }

        initPolsusChartFirstTime()
    </script>
@endpush
