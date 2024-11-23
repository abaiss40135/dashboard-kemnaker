@can('master_bhabin_chart_access')
    <div class="card">
        <div class="header"><span class="header-title">Chart Akumulasi Suara Pilpres 2024 Per Provinsi</span>
            <div class="card-tools">
                <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="collapse"
                    onclick="angleIcon(this)"
                >
                    <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <button class="btn btn-primary d-none" id="refresh-stacked-chart" onclick="defaultStackedChart()">
                Kembali ke Bagian Provinsi
            </button>
            <br><br>
            <div class="container-stacked-bar-chart">
                <canvas id="stacked-bar-chart" class="d-none" style="max-height: 1200px !important; height: 700px !important;"></canvas>
            </div>
{{--            <canvas id="stacked-bar-chart-2" class="d-none" style="max-height: 325px"></canvas>--}}
            <div class="text-center preloader-provinsi">
                <img
                    class="img-fluid"
                    alt="img-preloader"
                    src="{{asset('img/ellipsis-preloader.gif')}}"
                >
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            async function requestDataStackedChart(type = 'provinsi', wilayah = null, provinsi = null, kota = null) {
                let data;
                if(type === 'provinsi') {
                    const request = await fetch(route('dashboard-pemungutan-suara-capres2024.akumulasi-per-provinsi'))
                    data = await request.json()
                } else if(type === 'kabupaten') {
                    const request = await fetch(route('dashboard-pemungutan-suara-capres2024.akumulasi-per-kabupaten', wilayah))
                    data = await request.json()
                } else if(type === 'kecamatan') {
                    const request = await fetch(route('dashboard-pemungutan-suara-capres2024.akumulasi-per-kecamatan', {
                        wilayah: wilayah,
                        provinsi: provinsi,
                    }))
                    data = await request.json()
                } else if(type === 'kelurahan') {
                    const request = await fetch(route('dashboard-pemungutan-suara-capres2024.akumulasi-per-kelurahan', {
                        provinsi: provinsi,
                        kota: kota,
                        wilayah: wilayah
                    }))
                    data = await request.json()
                }

                return data
            }

            let provinsiSubChart = null
            let kotaSubChart = null
            let kecamatanSubChart = null
            async function initSubChart(wilayah) {
                const headerTitle = document.querySelector('.header-title')
                let wilayahType = null

                if(headerTitle.innerHTML.includes('Kelurahan/Desa')) {
                    return
                }

                if(headerTitle.innerHTML.includes('Kecamatan')) {
                    kecamatanSubChart = wilayah
                    wilayahType = 'Kelurahan/Desa'
                } else if (headerTitle.innerHTML.includes('Kota')) {
                    kotaSubChart = wilayah
                    kecamatanSubChart = null
                    wilayahType = 'Kecamatan'
                } else if(headerTitle.innerHTML.includes('Provinsi')) {
                    provinsiSubChart = wilayah
                    kotaSubChart = null
                    kecamatanSubChart = null
                    wilayahType = 'Kabupaten/Kota'
                }

                $('#refresh-stacked-chart').removeClass('d-none')
                $('.container-stacked-bar-chart').empty()

                changeStackedBarHeader(`Per ${wilayahType} di ${wilayah}`)
                refreshStackedChart()

                document.querySelector('.preloader-provinsi').classList.remove('d-none')

                const data = await requestDataStackedChart(wilayahType.split('/')[0].toLowerCase(), wilayah, provinsiSubChart, kotaSubChart, kecamatanSubChart)

                await initStackedChart(data, wilayahType.split('/')[0].toLowerCase())
                document.querySelector('.preloader-provinsi').classList.add('d-none')
            }

            async function initStackedChart(data, wilayah = 'provinsi') {
                if(typeof data === 'object' && wilayah !== 'provinsi') {
                    data = Object.values(data).sort((a, b) => b.total_seluruh_suara - a.total_seluruh_suara)
                }
                const arrLength = data.length
                const lengthArr1 = arrLength - (Math.round(arrLength / 2))

                // let data1 = data
                // let data2 = []
                // if(arrLength > 20) {
                //     data1 = data.slice(0, lengthArr1)
                //     data2 = data.slice(lengthArr1)
                // }

                const stackedBarChart = document.querySelector('#stacked-bar-chart')
                stackedBarChart.classList.remove('d-none')

                const chart = new Chart(stackedBarChart.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: data.map(item => item[wilayah] + ` - (${item[`persentase_total_suara_${wilayah}`]}%)`),
                        // labels: data.map(item => '<a href="https://www.youtube.com" target="_blank">' + item.provinsi + ` - (${item.persentase_total_suara_provinsi}%)` + '</a>'),
                        datasets: [
                            {
                                label: 'Pasangan 01 (Anies - Muhaimin)',
                                data: data.map(item => item.total_suara_01),
                                backgroundColor: '#292964',
                            },
                            {
                                label: 'Pasangan 02 (Prabowo - Gibran)',
                                data: data.map(item => item.total_suara_02),
                                backgroundColor: '#fccf00',
                            },
                            {
                                label: 'Pasangan 03 (Ganjar - Mahfud)',
                                data: data.map(item => item.total_suara_03),
                                backgroundColor: '#d82028',
                            },
                            {
                                label: 'Suara Tidak Sah',
                                data: data.map(item => item.total_suara_tidak_sah),
                                backgroundColor: 'gray',
                            }
                        ]
                    },
                    responsive: true,
                    plugins: [ChartDataLabels],
                    options: {
                        tooltips: {
                            enable: true, // Ensure tooltips are enabled
                        },
                        events: ['mousemove', 'click', 'touchstart', 'touchmove'],
                        onClick: (e) => {
                            const position = chart.getElementsAtEventForMode(e, 'nearest', {intersect: true}, true);
                            if (position.length) {
                                const index = position[0].index;
                                const label = chart.data.labels[index];
                                const data = chart.data.datasets.map(dataset => dataset.data[index]);

                                const wilayah = label.split(' - ')[0]
                                const presentase = label.split(' - ')[1].replace('%)', '').replace('(', '')

                                if(presentase == 0) return

                                initSubChart(wilayah)
                            }
                        },
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true,
                            }
                        },
                        plugins: {
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        return 'testing'
                                    }
                                },
                                enabled: true,
                                intersect: false,
                            },
                            datalabels: {
                                anchor: 'center',
                                align: function(context) {
                                    return context.datasetIndex + 1 === 1 && (context.dataIndex + 1) % 2 ? 'end' : 'center'
                                },
                                textAlign: 'center',
                                formatter: function(value, context) {
                                    if(value === 0) return ''
                                    const argument = (context.datasetIndex + 1) === 4 ? 'tidak_sah' : '0' + (context.datasetIndex + 1)
                                    return `${data[context.dataIndex]['persentase_suara_' + argument].toString().slice(0,4)}%`;
                                },
                                font: {
                                    weight: 'bold',
                                    size: 10,
                                },
                                color: function(context) {
                                    return context.datasetIndex + 1 === 1 ? 'red' : 'black'
                                },
                            }
                        }
                    }
                })
            }

            document.addEventListener('DOMContentLoaded', async () => {
                const data = await requestDataStackedChart()

                initStackedChart(data)
                document.querySelector('.preloader-provinsi').classList.add('d-none')
            })

            const refreshStackedChart = () => {
                const newCanvas = document.createElement('canvas')
                newCanvas.id = 'stacked-bar-chart'
                newCanvas.style.maxHeight = '1200px'
                newCanvas.style.height = '700px'
                newCanvas.classList.add('d-none')
                document.querySelector('.container-stacked-bar-chart').appendChild(newCanvas)
            }

            const changeStackedBarHeader = (arg) => {
                const headerTitle = document.querySelector('.header-title')
                headerTitle.innerHTML = 'Chart Akumulasi Suara Pilpres 2024 ' + arg
            }

            const defaultStackedChart = async () => {
                $('.container-stacked-bar-chart').empty()
                refreshStackedChart()

                changeStackedBarHeader('Per Provinsi')
                document.querySelector('.preloader-provinsi').classList.remove('d-none')
                $('#refresh-stacked-chart').addClass('d-none')

                const data = await requestDataStackedChart()
                await initStackedChart(data)
                document.querySelector('.preloader-provinsi').classList.add('d-none')
            }
        </script>
    @endpush
@endcan
