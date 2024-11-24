<div class="card">
    <div class="card-header bg-primary">
        Chart Dashboard Rekapitulasi Data Kementerian Ketenagakerjaan
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                    onclick="angleIcon(this)">
                <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
            </button>
        </div>
    </div>
    <div class="card-body py-4">
        <h5 class="text-center font-weight-bold chart-title">Realisasi Anggaran Per Jenis Belanja</h5>
        <div class="d-flex justify-content-between">
            <button disabled id="reset-chart-btn" class="mt-2 mb-4 btn btn-warning d-none">Kembali ke Tampilan Awal</button>
        </div>

        <canvas id="chart-rekap-binpolmas" style="max-height: 450px"></canvas>
        <canvas id="chart-prov-2" class="d-none" style="max-height: 450px"></canvas>
        <div class="text-center preloader" id="binpolmas-chart-preloader">
            <img class="img-fluid" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
        </div>
    </div>
</div>

<div id="modalExportRekapLaporanBinpolmas" class="modal fade" tabindex="-1"
     role="dialog" data-backdrop="static"
     aria-labelledby="modalExportRekapLaporanBinpolmasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-center" id="modalExportRekapLaporanBinpolmasLabel">Pilih Periode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="export-form" action="#"
                      class="form" id="formFilterLaporanBhabinkamtibmas"
                      method="POST" target="_blank">
                    @csrf

                    <input type="hidden" name="start_date">
                    <input type="hidden" name="end_date">
                    <div class="form-group">
                        <label for="tanggal">Tanggal:</label>
                        <input type="text" id="tanggal" class="form-control">
                    </div>
{{--                    list polda --}}
                    <div class="form-group">
                        <label for="polda">Polda:</label>
                        <select name="satuan" id="satuan" class="form-control select2">
                            <option selected>Mabes Polri</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Ekspor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    @include('assets.js.datetimepicker')
    @include('assets.js.select2')

    <script>
        const chartRekapBinpolmas = document.querySelector('#chart-rekap-binpolmas')
        const resetChartbtn = document.querySelector('#reset-chart-btn')
        const preLoader = document.querySelector('#binpolmas-chart-preloader')
        const exportForm = document.querySelector('#export-form');

        $('#tanggal').daterangepicker(datetimeSetup, function (start, end) {
            const exportForm = $('#export-form');

            exportForm.find('input[name="start_date"]').val(start.format('YYYY-MM-DD'));
            exportForm.find('input[name="end_date"]').val(end.format('YYYY-MM-DD'));
        });

        let binpolmasType;

        const indexBinpolmas = [
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

        const barChartRekapBinpolmas = chartRekapBinpolmas.getContext('2d')
        const initChartRekapBinpolmas = (data, labels, label, dataPetugasPolmas = null, chartColors = null, useLabel = true) => {
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
            if(Array.isArray(data[0]) && binpolmasType === 'supervisor_polmas') {
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
            else if(binpolmasType === 'pembina_polmas' && label.includes('Per Polda')) {
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
            else { // special case when dataPetugasPolmas is true and only run when binpolmasType is petugas polmas wilayah
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
            const chart = new Chart(barChartRekapBinpolmas, {
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

                                    if(binpolmasType === undefined || (binpolmasType !== indexBinpolmas[index] && type === 'Rekapitulasi Data Laporan Subdit Binpolmas')) {
                                        binpolmasType = indexBinpolmas[index]
                                    }

                                    if(type.includes('Rekapitulasi Data Laporan Subdit Binpolmas'))
                                    {
                                        @if(empty(auth()->user()) || (auth()->user()->haveRoleID(\App\Models\User::BAGOPSNALEV_MABES) || auth()->user()->haveRoleID(\App\Models\User::ADMIN)))
                                        resetChartbtn.removeAttribute('disabled')
                                        chart.destroy()

                                        initChartPolda(binpolmasType);
                                        @elseif(auth()->user() && auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA))
                                        resetChartbtn.removeAttribute('disabled')
                                        chart.destroy()

                                        initChartPolres(binpolmasType, '{{auth()->user()->personel->polda}}', index);
                                        @else
                                        // jika user adalah operator bagopsnavel polres, maka akan langsung diarahkan ke sub menu, namun jika mengklik bar yang memiliki sub menu
                                        {{--if(['data_fkpm', 'petugas_polmas', 'supervisor_polmas', 'pembina_polmas', 'kegiatan_petugas_polmas'].find((item) => item === binpolmasType)) {--}}
                                        {{--    resetChartbtn.removeAttribute('disabled')--}}
                                        {{--    chart.destroy()--}}

                                        {{--    initChartSubData(binpolmasType, '{{auth()->user()->personel->polres}}');--}}
                                        {{--}--}}
                                        @endif
                                    }
                                    else if(type.toLowerCase().includes('polda'))
                                    {
                                        resetChartbtn.removeAttribute('disabled')
                                        chart.destroy()

                                        const polda = Object.keys(context.dataset.data)[index]
                                        initChartPolres(binpolmasType, polda, index);
                                    }
                                },
                                enter: function(context, event) {
                                    // Receives `enter` events for any labels of any dataset. Indices of the
                                    // clicked label are: `context.datasetIndex` and `context.dataIndex`.
                                    // For example, we can modify keep track of the hovered state and
                                    // return `true` to update the label and re-render the chart.
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

                        initChartPolda(binpolmasType);
                    }
                    else if(index === 3 && (type === 'Barang Pagu' || type === 'Barang Real')) // index 2 => chart sub pertama, ditjen PHI
                    {
                        resetChartbtn.removeAttribute('disabled')
                        chart.destroy()

                        initChartPolres(binpolmasType);
                    }
                    // else if(
                    //     type === 'Rekapitulasi Data Binpolmas Per Polres' &&
                    //     ['data_fkpm', 'petugas_polmas', 'supervisor_polmas', 'pembina_polmas', 'kegiatan_petugas_polmas'].find((item) => item === binpolmasType)
                    // )
                    // {
                    //     resetChartbtn.removeAttribute('disabled')
                    //     chart.destroy()
                    //
                    //     const polres = Object.keys(slice[0].element.$context.dataset.data)[index]
                    //     initChartSubData(binpolmasType, polres);
                    // }
                }
            }

            chartRekapBinpolmas.onclick = clickBarChart
            resetChartbtn.onclick = resetChart
        }

        const initChartFirstTime = () => {
            preLoader.classList.remove('d-none')
            resetChartbtn.classList.add('d-none')
            exportForm.classList.add('d-none')

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


            preLoader.classList.add('d-none')
            resetChartbtn.classList.remove('d-none')
            exportForm.classList.remove('d-none')
            resetChartbtn.setAttribute('disabled', 'true')

            resetChartbtn.setAttribute('disabled', false)
            initChartRekapBinpolmas(chartData, chartData.labels, 'Realisasi Anggaran Per Jenis Belanja')
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
            preLoader.classList.remove('d-none')
            resetChartbtn.classList.add('d-none')
            exportForm.classList.add('d-none')

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

            preLoader.classList.add('d-none')
            resetChartbtn.classList.remove('d-none')
            exportForm.classList.remove('d-none')

            $('.chart-title').html('Perbandingan Pagu dan Realisasi Barang Per Eselon 1')

            initChartRekapBinpolmas(chartData, chartData.labels, 'Perbandingan Pagu dan Realisasi Barang Per Eselon 1')
        }

        const initChartPolres = (binpolmasType, polda, indexChartPolda) => {
            preLoader.classList.remove('d-none')
            resetChartbtn.classList.add('d-none')
            exportForm.classList.add('d-none')

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


            preLoader.classList.add('d-none')
            resetChartbtn.classList.remove('d-none')
            exportForm.classList.remove('d-none')

            $('.chart-title').html('Perbandingan Pagu dan Realisasi Per Disnakertrans Provinsi')
            initChartRekapBinpolmas(chartData, chartData.labels, 'Perbandingan Pagu dan Realisasi Per Disnakertrans Provinsi', null, null, false)
        }

        const initChartSubData = (binpolmasType, polres) => {
            preLoader.classList.remove('d-none')
            resetChartbtn.classList.add('d-none')
            exportForm.classList.add('d-none')

            axios.get(route('chart-binpolmas.tahap4', {
                type: binpolmasType,
                polres: polres
            }))
                .then(res => res.data)
                .then(result => {
                    preLoader.classList.add('d-none')
                    resetChartbtn.classList.remove('d-none')
                    exportForm.classList.remove('d-none')

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

                    initChartRekapBinpolmas(values, labels, 'Rekapitulasi Data Binpolmas - Sub Menu')
                })
        }



        const resetChart = () => {
            let chart = Chart.getChart("chart-rekap-binpolmas");

            chart.destroy()
            binpolmasType = null
            initChartFirstTime()
        }

        initChartFirstTime()


    </script>
@endpush
