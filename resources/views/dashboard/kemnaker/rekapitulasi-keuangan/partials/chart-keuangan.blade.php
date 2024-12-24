<div class="box rounded-2xl">
    <div class="box-header flex b-0 justify-start items-center">
        <h2 class="mt-0">Chart Dashboard Rekapitulasi Data Kementerian Ketenagakerjaan</h2>
    </div>
    <div class="box-body pt-0 summery-box">
        <h5 class="text-center font-bold text-lg chart-title">Realisasi Anggaran Per Jenis Belanja</h5>

        <div class="flex justify-between">
            <button disabled id="reset-chart-btn" class="mt-2 mb-4 btn btn-warning hidden bg-yellow-500 text-white py-2 px-4 rounded">
                Kembali ke Tampilan Awal
            </button>
        </div>

        <canvas id="chart-rekap-keuangan" class="max-h-[450px]"></canvas>
        <canvas id="chart-prov-2" class="hidden max-h-[450px]"></canvas>

        <div class="text-center preloader" id="keuangan-chart-preloader">
            <img class="mx-auto max-w-full" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
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

        let keuanganType;

        const indexKeuangan = [
            'data_fkpm_kawasan',
            'data_fkpm_wilayah',
            'data_pranata',
            'data_orsosmas',
            'data_komunitas_masyarakat',
            'petugas_polmas_kawasan',
            'petugas_polmas_wilayah',
            'supervisor_polmas',
            'pembina_polmas',
            'kegiatan_petugas_polmas_sambang',
            'kegiatan_petugas_polmas_pemecahan_masalah_sosial',
            'kegiatan_petugas_polmas_laporan_informasi',
            'kegiatan_petugas_polmas_penaganan_perkara_ringan'
        ];

        function randomHSL() {
            const h = Math.floor(Math.random() * 360); // Hue: 0-359
            const s = Math.floor(Math.random() * 30) + 70; // Saturation: 0-100
            const l = Math.floor(Math.random() * 51) + 50; // Lightness: 0-100

            const randomHue = Math.floor(Math.random() * 360); // Hue baru acak

            return {
                backgroundColor: `hsla(${h},${s}%,${l}%,0.4)`,
                borderColor: `hsl(${randomHue},${s}%,${l}%)`
            };
        }

        function generateRandomColor(length) {
            const backgroundColors = []
            const borderColors = []
            for(let i = 0; i < length; i++) {
                const color = randomHSL()

                backgroundColors.push(color.backgroundColor)
                borderColors.push(color.borderColor)
            }

            return {
                backgroundColors,
                borderColors
            }
        }

        const barChartRekapKeuangan = chartRekapKeuangan.getContext('2d')
        const initChartRekapKeuangan = (data, labels, label, dataPetugasPolmas = null, chartColors = null, useLabel = true) => {
            const colors = chartColors ?? generateRandomColor(labels.length)

            const twinColors = {
                backgroundColors: colors.backgroundColors.map(c => {
                    let [h, s, l, a] = c.slice(5, -1).split(','); // Mengambil komponen h, s, l, dan a dari string hsla
                    return `hsla(${h},${s},${l},0.4)`;
                }),
                borderColors: colors.borderColors.map(c => {
                    let [h, s, l] = c.slice(4, -1).split(','); // Mengambil komponen h, s, dan l dari string hsl
                    return `hsl(${h},${s},${l})`;
                })
            }

            let dataset = [];
            // special case supervisor_polmas, there data has data types array.
            if(Array.isArray(data[0]) && keuanganType === 'supervisor_polmas') {
                const polsek = data.map(num => num[0]);
                const polres = data.map(num => num[1]);

                dataset = [
                    {
                        label: 'Rekapitulasi Data Supervisor Polsek',
                        data: polsek,
                        backgroundColor: colors.backgroundColors,
                        borderColor: colors.borderColors,
                        borderWidth: 1,
                    },
                    {
                        label: "Rekapitulasi Data Supervisor Polres",
                        data: polres,
                        backgroundColor: twinColors.backgroundColors,
                        borderColor: twinColors.borderColors,
                        borderWidth: 1,
                    }
                ]
            }
            else if(keuanganType === 'pembina_polmas' && label.includes('Per Polda')) {
                let chart1 = {}
                let chart2 = {}

                let dataChart1 = Object.values(data).map(num => num[0]);
                let dataChart2 = Object.values(data).map(num => num[1]);

                Object.keys(data).forEach((k, index) => {
                    chart2[k] = dataChart2[index]
                })

                chart1 = dataChart1

                dataset = [
                    {
                        label: `Rekapitulasi Data Pembina Polmas ${label.includes('Per Polda') ? 'Polda' : 'Polres'}`,
                        data: chart1,
                        backgroundColor: colors.backgroundColors,
                        borderColor: colors.borderColors,
                        borderWidth: 1,
                    },
                    {
                        label: `Rekapitulasi Data Pembina Polmas Total Polda-Polres`,
                        data: chart2,
                        backgroundColor: twinColors.backgroundColors,
                        borderColor: twinColors.borderColors,
                        borderWidth: 1,
                    }
                ]
            }
            else if(dataPetugasPolmas === null) { // this is default dataset, and running when dataPetugasPolmas is null
                dataset = [{
                    label: label,
                    data: data,
                    backgroundColor: colors.backgroundColors,
                    borderColor: colors.borderColors,
                    borderWidth: 1,
                }]
            }
            else { // special case when dataPetugasPolmas is true and only run when keuanganType is petugas polmas wilayah
                dataset = [
                    {
                        label: 'Jumlah RW Polmas Wilayah',
                        data: dataPetugasPolmas,
                        backgroundColor: twinColors.backgroundColors,
                        borderColor: twinColors.borderColors,
                        borderWidth: 1,
                        skipNull: true,
                    },
                    {
                        label: label,
                        data: data,
                        backgroundColor: colors.backgroundColors,
                        borderColor: colors.borderColors,
                        borderWidth: 1,
                        skipNull: true,
                    }
                ]
            }

            const plugins = useLabel ? [
                ChartDataLabels,
                'datalabels'
            ] : ['datalabels'];
            const chart = new Chart(barChartRekapKeuangan, {
                type: 'bar',
                data: data,
                format: 'idr',
                plugins: plugins,
                options: {
                    layout: {
                        padding: 40,
                    },
                    spanGaps: true,
                    // This chart will not respond to mousemove, etc
                    scales: {
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            clip: {
                                left: false, // Menonaktifkan potongan pada sisi kiri sumbu Y
                                right: false, // Menonaktifkan potongan pada sisi kanan sumbu Y
                            },
                        },
                        x: {
                            stacked: false,
                            ticks: {
                                font: {
                                    weight: 'bold', // Membuat teks label x-axis menjadi tebal (bold)
                                    color: 'black',
                                    size: '14px'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true
                        },
                        datalabels: {
                            display: true, // Menampilkan label data
                            color: 'black', // Warna teks label
                            anchor: 'end', // Posisi label (misal: 'end', 'start', 'center')
                            align: 'top', // Penyusunan label (misal: 'top', 'bottom', 'middle')
                            font: {
                                weight: 'bold', // Ketebalan teks labelm
                            },
                            formatter: (value, context) => value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&.'),
                            listeners: {
                                click: function(context, event) {
                                    // Receives `click` events only for labels of the first dataset.
                                    // The clicked label index is available in `context.dataIndex`.

                                    const index = context.dataIndex
                                    const type = context.dataset.label

                                    console.log(context.dataset.data)

                                    // ketika data chart adalah nol, maka tidak terjadi action apapun
                                    if(context.dataset.data[index] === 0) return

                                    if(keuanganType === undefined || (keuanganType !== indexKeuangan[index] && type === 'Rekapitulasi Data Laporan Subdit Keuangan')) {
                                        keuanganType = indexKeuangan[index]
                                    }

                                    if(type.includes('Rekapitulasi Data Laporan Subdit Keuangan'))
                                    {
                                        @if(empty(auth()->user()) || (auth()->user()->haveRoleID(\App\Models\User::BAGOPSNALEV_MABES) || auth()->user()->haveRoleID(\App\Models\User::ADMIN)))
                                        resetChartbtn.removeAttribute('disabled')
                                        chart.destroy()

                                        initChartPolda(keuanganType);
                                        @elseif(auth()->user() && auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA))
                                        resetChartbtn.removeAttribute('disabled')
                                        chart.destroy()

                                        initChartPolres(keuanganType, '{{auth()->user()->personel->polda}}', index);
                                        @endif
                                    }
                                    else if(type.toLowerCase().includes('polda'))
                                    {
                                        resetChartbtn.removeAttribute('disabled')
                                        chart.destroy()

                                        const polda = Object.keys(context.dataset.data)[index]
                                        initChartPolres(keuanganType, polda, index);
                                    }
                                },
                                enter: function(context, event) {
                                    context.hovered = true;
                                    return true;
                                },
                                leave: function(context, event) {
                                    // Receives `leave` events for any labels of any dataset.
                                    context.hovered = false;
                                    return true;
                                }
                            },
                            color: function(context) {
                                // Change the label text color based on our new `hovered` context value.
                                return context.hovered ? "red" : "black";
                            },
                        },

                    }
                }
            });

            const clickBarChart = click => {
                const slice = chart.getElementsAtEventForMode(click, 'nearest', {intersect:true}, true)

                // if slice has length (length > 0), is mean users click one of the bar
                if(slice.length) {
                    const index = slice[0].index
                    const type = slice[0].element.$context.dataset.label

                    console.log(index, type)
                    if(index === 1 && (type === 'Pagu' || type === 'Realisasi')) // index 1 => chart pertama kali, belanja barang
                    {
                        resetChartbtn.removeAttribute('disabled')
                        chart.destroy()

                        initChartPolda(keuanganType);
                    }
                    else if(index === 3 && (type === 'Barang Pagu' || type === 'Barang Real')) // index 2 => chart sub pertama, ditjen PHI
                    {
                        resetChartbtn.removeAttribute('disabled')
                        chart.destroy()

                        initChartPolres(keuanganType);
                    }
                }
            }

            chartRekapKeuangan.onclick = clickBarChart
            resetChartbtn.onclick = resetChart
        }

        const initChartFirstTime = () => {
            preLoader.classList.remove('hidden')
            resetChartbtn.classList.add('hidden')

            const chartData = {
                labels: [
                    "Belanja Modal",
                    "Belanja Barang",
                    "Belanja Pegawai",
                    "Total"
                ],
                datasets: [
                    {
                        label: 'Pagu',
                        data: [561127207000, 5008447739000, 542227019000, 6111801965000],
                        backgroundColor: '#2D75B6',
                    },
                    {
                        label: 'Realisasi',
                        data: [305458697388, 3597292773088, 422660951037, 4325412421513],
                        backgroundColor: '#F9AE39',
                    }
                ]
            };


            preLoader.classList.add('hidden')
            resetChartbtn.classList.remove('hidden')
            resetChartbtn.setAttribute('disabled', 'true')

            resetChartbtn.setAttribute('disabled', false)
            initChartRekapKeuangan(chartData, chartData.labels, 'Realisasi Anggaran Per Jenis Belanja')
        }

        const chartPoldaBgColors = [
            "hsla(46, 70%, 45%, 0.7)",
            "hsla(12, 65%, 50%, 0.7)",
            "hsla(292, 65%, 55%, 0.7)",
            "hsla(180, 45%, 50%, 0.7)",
            "hsla(340, 60%, 45%, 0.7)",
            "hsla(260, 45%, 55%, 0.7)",
            "hsla(220, 60%, 45%, 0.7)",
            "hsla(200, 55%, 50%, 0.7)",
            "hsla(150, 45%, 50%, 0.7)",
            "hsla(100, 50%, 45%, 0.7)",
            "hsla(60, 65%, 55%, 0.7)",
            "hsla(30, 70%, 45%, 0.7)",
            "hsla(15, 65%, 50%, 0.7)",
            "hsla(5, 60%, 55%, 0.7)",
            "hsla(350, 55%, 45%, 0.7)",
            "hsla(315, 70%, 45%, 0.7)",
            "hsla(285, 75%, 50%, 0.7)",
            "hsla(255, 80%, 45%, 0.7)",
            "hsla(225, 85%, 50%, 0.7)",
            "hsla(195, 60%, 55%, 0.7)",
            "hsla(165, 65%, 45%, 0.7)",
            "hsla(135, 70%, 50%, 0.7)",
            "hsla(105, 75%, 55%, 0.7)",
            "hsla(75, 80%, 45%, 0.7)",
            "hsla(45, 85%, 50%, 0.7)",
            "hsla(15, 50%, 55%, 0.7)",
            "hsla(345, 55%, 45%, 0.7)",
            "hsla(310, 60%, 55%, 0.7)",
            "hsla(280, 65%, 45%, 0.7)",
            "hsla(250, 70%, 50%, 0.7)",
            "hsla(220, 75%, 55%, 0.7)",
            "hsla(190, 80%, 45%, 0.7)",
            "hsla(160, 85%, 50%, 0.7)",
            "hsla(130, 60%, 55%, 0.7)",
            "hsla(100, 65%, 45%, 0.7)",
            "hsla(70, 70%, 50%, 0.7)",
            "hsla(40, 75%, 55%, 0.7)",
            "hsla(10, 80%, 45%, 0.7)",
            "hsla(355, 85%, 50%, 0.7)",
            "hsla(325, 60%, 55%, 0.7)"
        ]
        const chartPoldaColors = {
            backgroundColors: chartPoldaBgColors,
            borderColors: chartPoldaBgColors.map(index => index.replace(', 0.7)', ')'))
        };

        const initChartPolda = () => {
            preLoader.classList.remove('hidden')
            resetChartbtn.classList.add('hidden')

            const chartData = {
                labels: ['SETJEN', 'ITJEN', 'DITJEN BINAPENTA & PKK', 'DITJEN PHI & JAMSOS TK', 'DITJEN BINWASNAKER', 'BARENBANG', 'DITJEN BINAVALOTAS'],
                datasets: [
                    {
                        label: 'Barang Pagu',
                        data: [452076287000, 68470374000, 843107967000, 1546283680000, 359380068000, 221424430000, 2621059159000], // Pagu
                        backgroundColor: '#2D75B6',
                    },
                    {
                        label: 'Barang Real',
                        data: [348551526059, 51924409288, 664942247838, 1208166698059, 264800558854, 146989288930, 1647912198626], // Real
                        backgroundColor: '#F9AE39',
                    }
                ]
            };

            preLoader.classList.add('hidden')
            resetChartbtn.classList.remove('hidden')

            $('.chart-title').html('Perbandingan Pagu dan Realisasi Barang Per Eselon 1')

            initChartRekapKeuangan(chartData, chartData.labels, 'Perbandingan Pagu dan Realisasi Barang Per Eselon 1')
        }

        const initChartPolres = (keuanganType, polda, indexChartPolda) => {
            preLoader.classList.remove('hidden')
            resetChartbtn.classList.add('hidden')

            const chartPolresColors = {
                backgroundColors: [chartPoldaColors.backgroundColors[indexChartPolda]],
                borderColors: [chartPoldaColors.borderColors[indexChartPolda]],
            }

            const chartData = {
                labels: ['DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Yogyakarta', 'Jawa Timur', 'NAD', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 'Sumatera Selatan', 'Lampung', 'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Maluku', 'Bali', 'NTB', 'NTT', 'Papua', 'Bengkulu', 'Maluku Utara', 'Banten', 'Bangka Belitung', 'Gorontalo', 'Kepulauan Riau', 'Papua Barat', 'Sulawesi Barat', 'Kalimantan Utara'],
                datasets: [
                    {
                        label: 'Pagu',
                        data: [1138173000, 755290000, 413124000, 680297000, 438385000, 444387000, 386790000, 1046086000, 329968000, 392958000, 346814000, 383913000, 332957000, 336278000, 327065000, 1182294000, 1283375000, 459827000, 1234974000, 454962000, 375207000, 1082335000, 385542000, 520285000, 513383000, 299981000, 355684000, 1030898000, 364516000, 309460000, 304678000, 526420000, 434031000, 310364000],
                        backgroundColor: '#2D75B6',
                    },
                    {
                        label: 'Realisasi',
                        data: [486495104, 597837460, 289181471, 547900847, 244034807, 316217325, 15648810, 835883020, 229637344, 248712240, 196890423, 237656069, 143156300, 229985201, 140116038, 259366300, 835929000, 313289000, 1017207931, 338221900, 237472320, 665370404, 243152805, 357348482, 335436000, 215818100, 134754000, 605581880, 198640765, 222352000, 156417434, 289775870, 192355645, 165732200],
                        backgroundColor: '#F9AE39',
                    }
                ]
            };


            preLoader.classList.add('hidden')
            resetChartbtn.classList.remove('hidden')

            $('.chart-title').html('Perbandingan Pagu dan Realisasi Per Disnakertrans Provinsi')
            initChartRekapKeuangan(chartData, chartData.labels, 'Perbandingan Pagu dan Realisasi Per Disnakertrans Provinsi', null, null, false)
        }

        const initChartSubData = (keuanganType, polres) => {
            preLoader.classList.remove('hidden')
            resetChartbtn.classList.add('hidden')

            axios.get(route('chart-keuangan.tahap4', {
                type: keuanganType,
                polres: polres
            }))
                .then(res => res.data)
                .then(result => {
                    preLoader.classList.add('hidden')
                    resetChartbtn.classList.remove('hidden')

                    const data = result.data
                    let labels = []
                    let values = []

                    // process labels with foreach, for labels chart
                    Object.keys(data).forEach(item => {
                        labels.push(item.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' '))
                    })

                    // wrapping values
                    Object.values(data).forEach(value => {
                        values.push(value)
                    })

                    initChartRekapKeuangan(values, labels, 'Rekapitulasi Data Keuangan - Sub Menu')
                })
        }



        const resetChart = () => {
            let chart = Chart.getChart("chart-rekap-keuangan");

            chart.destroy()
            keuanganType = null
            initChartFirstTime()
        }

        initChartFirstTime()


    </script>
@endpush
