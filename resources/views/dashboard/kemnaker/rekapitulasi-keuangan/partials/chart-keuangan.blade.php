<div class="box rounded-2xl">
    <div class="box-header flex b-0 justify-start items-center">
        <h2 class="mt-0">Chart Dashboard Rekapitulasi Data Kementerian Ketenagakerjaan</h2>
    </div>
    <div class="box-body pt-0 summery-box">
        <h5 class="text-center font-bold text-lg chart-title">Realisasi Anggaran Per Jenis Belanja</h5>

        <div class="flex justify-between">
            <button disabled id="reset-chart-btn"
                class="mt-2 mb-4 btn btn-warning hidden bg-yellow-500 text-white py-2 px-4 rounded">
                Kembali ke Tampilan Awal
            </button>
        </div>

        <canvas id="chart-rekap-keuangan" class="max-h-[450px]"></canvas>

        <div class="text-center preloader" id="keuangan-chart-preloader">
            <img class="mx-auto max-w-full" alt="img-preloader" src="{{ asset('img/ellipsis-preloader.gif') }}">
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        const chartRekapKeuangan = document.querySelector('#chart-rekap-keuangan')
        const resetChartbtn = document.querySelector('#reset-chart-btn')
        const preLoader = document.querySelector('#keuangan-chart-preloader')

        const financeChart = chartRekapKeuangan.getContext('2d')
        const initFinanceChart = (data, labels, label, useLabel = true) => {
            let dataset = [{
                label: label,
                data: data,
                borderWidth: 1,
            }]

            const plugins = useLabel ? [ChartDataLabels, 'datalabels'] : ['datalabels']

            const chart = new Chart(financeChart, {
                type: 'bar',
                data: data,
                format: 'idr',
                plugins: plugins,
                options: {
                    layout: {
                        padding: 40,
                    },
                    spanGaps: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            clip: {
                                left: false,
                                right: false,
                            },
                        },
                        x: {
                            stacked: false,
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    color: 'black',
                                    size: '14px'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        datalabels: {
                            display: true,
                            color: 'black',
                            anchor: 'end',
                            align: 'top',
                            font: {
                                weight: 'bold',
                            },
                            formatter: (value, context) => value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&.'),
                            color: function(context) {

                                return context.hovered ? "red" : "black";
                            },
                        },

                    }
                }
            });

            const clickBarChart = click => {
                const slice = chart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true)

                if (slice.length) {
                    const index = slice[0].index
                    const type = slice[0].element.$context.dataset.label

                    if (index === 1 && (type === 'Pagu' || type === 'Realisasi')) {
                        resetChartbtn.removeAttribute('disabled')
                        chart.destroy()

                        initSecondLevelChart();
                    } else if (index === 3 && (type === 'Barang Pagu' || type === 'Barang Real')) {
                        resetChartbtn.removeAttribute('disabled')
                        chart.destroy()

                        initThirdLevelChart();
                    }
                }
            }

            chartRekapKeuangan.onclick = clickBarChart
            resetChartbtn.onclick = resetChart
        }

        const initFirstLevelChart = () => {
            preLoader.classList.remove('hidden')
            resetChartbtn.classList.add('hidden')

            const chartData = {
                labels: [
                    "Belanja Modal",
                    "Belanja Barang",
                    "Belanja Pegawai",
                    "Total"
                ],
                datasets: [{
                        label: 'Pagu',
                        data: [561127207000, 5008447739000, 542227019000, 6111801965000],
                        backgroundColor: '#4d7cff',
                    },
                    {
                        label: 'Realisasi',
                        data: [305458697388, 3597292773088, 422660951037, 4325412421513],
                        backgroundColor: '#51ce8a',
                    }
                ]
            };


            preLoader.classList.add('hidden')
            resetChartbtn.classList.remove('hidden')

            resetChartbtn.setAttribute('disabled', false)
            initFinanceChart(chartData, chartData.labels, 'Realisasi Anggaran Per Jenis Belanja')
        }

        const initSecondLevelChart = () => {
            preLoader.classList.remove('hidden')
            resetChartbtn.classList.add('hidden')

            const chartData = {
                labels: ['SETJEN', 'ITJEN', 'DITJEN BINAPENTA & PKK', 'DITJEN PHI & JAMSOS TK',
                    'DITJEN BINWASNAKER', 'BARENBANG', 'DITJEN BINAVALOTAS'
                ],
                datasets: [{
                        label: 'Barang Pagu',
                        data: [452076287000, 68470374000, 843107967000, 1546283680000, 359380068000, 221424430000, 2621059159000],
                        backgroundColor: '#4d7cff',
                    },
                    {
                        label: 'Barang Real',
                        data: [348551526059, 51924409288, 664942247838, 1208166698059, 264800558854, 146989288930, 1647912198626],
                        backgroundColor: '#51ce8a',
                    }
                ]
            };

            preLoader.classList.add('hidden')
            resetChartbtn.classList.remove('hidden')

            $('.chart-title').html('Perbandingan Pagu dan Realisasi Barang Per Eselon 1')

            initFinanceChart(chartData, chartData.labels, 'Perbandingan Pagu dan Realisasi Barang Per Eselon 1')
        }

        const initThirdLevelChart = (polda, indexChartPolda) => {
            preLoader.classList.remove('hidden')
            resetChartbtn.classList.add('hidden')

            const chartData = {
                labels: ['DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Yogyakarta', 'Jawa Timur', 'NAD',
                    'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 'Sumatera Selatan', 'Lampung',
                    'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur',
                    'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Maluku',
                    'Bali', 'NTB', 'NTT', 'Papua', 'Bengkulu', 'Maluku Utara', 'Banten', 'Bangka Belitung',
                    'Gorontalo', 'Kepulauan Riau', 'Papua Barat', 'Sulawesi Barat', 'Kalimantan Utara'
                ],
                datasets: [{
                        label: 'Pagu',
                        data: [1138173000, 755290000, 413124000, 680297000, 438385000, 444387000, 386790000,
                            1046086000, 329968000, 392958000, 346814000, 383913000, 332957000, 336278000,
                            327065000, 1182294000, 1283375000, 459827000, 1234974000, 454962000, 375207000,
                            1082335000, 385542000, 520285000, 513383000, 299981000, 355684000, 1030898000,
                            364516000, 309460000, 304678000, 526420000, 434031000, 310364000
                        ],
                        backgroundColor: '#4d7cff',
                    },
                    {
                        label: 'Realisasi',
                        data: [486495104, 597837460, 289181471, 547900847, 244034807, 316217325, 15648810,
                            835883020, 229637344, 248712240, 196890423, 237656069, 143156300, 229985201,
                            140116038, 259366300, 835929000, 313289000, 1017207931, 338221900, 237472320,
                            665370404, 243152805, 357348482, 335436000, 215818100, 134754000, 605581880,
                            198640765, 222352000, 156417434, 289775870, 192355645, 165732200
                        ],
                        backgroundColor: '#51ce8a',
                    }
                ]
            };


            preLoader.classList.add('hidden')
            resetChartbtn.classList.remove('hidden')

            $('.chart-title').html('Perbandingan Pagu dan Realisasi Per Disnakertrans Provinsi')
            initFinanceChart(chartData, chartData.labels, 'Perbandingan Pagu dan Realisasi Per Disnakertrans Provinsi', false)
        }

        const resetChart = () => {
            Chart.getChart("chart-rekap-keuangan").destroy()

            initFirstLevelChart()
        }

        initFirstLevelChart()
    </script>
@endpush
