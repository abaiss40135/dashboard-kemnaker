<div class="box rounded-2xl">
    <div class="box-header flex b-0 justify-start items-center">
        <h2 class="mt-0">Rekap Tingkat Kehadiran ASN</h2>
    </div>
    <div class="box-body pt-0 summery-box">
        <h5 class="text-center font-bold text-lg chart-title">Tingkat Kehadiran ASN Kemenaker - Minggu II November 2024</h5>
        <div id="kehadiran-chart"></div>
    </div>

    <hr>

    <div class="box-body summery-box">
        <div class="overflow-x-auto">
            <table class="table table-striped b-1 border-dark table-bordered w-full">
                <thead class="text-base uppercase bg-dark">
                    <tr>
                        <th scope="col" rowspan="2">Unit Kerja Eselon 1</th>
                        <th scope="col" colspan="8">Presensi PNS</th>
                    </tr>
                    <tr>
                        <th scope="col">Jumlah</th>
                        <th scope="col">WFO (%)</th>
                        <th scope="col">WFH (%)</th>
                        <th scope="col">Cuti (%)</th>
                        <th scope="col">Tugas Belajar (%)</th>
                        <th scope="col">Dinas Luar (%)</th>
                        <th scope="col">Tanpa Keterangan (%)</th>
                        <th scope="col">Jumlah Presentase (%)</th>
                    </tr>
                </thead>
                <tbody id="kehadiran-table">
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <script>
        const kehadiran = [
            {
                id: 1,
                name: 'Sekretariat Jenderal',
                jumlah: 532,
                wfo: 63.5,
                wfh: 0,
                cuti: 3.7,
                tugasBelajar: 1.6,
                dinasLuar: 30.4,
                tanpaKeterangan: 0.8
            },
            {
                id: 2,
                name: 'Ditjen Binalavotas',
                jumlah: 1774,
                wfo: 66.6,
                wfh: 0,
                cuti: 4.6,
                tugasBelajar: 0.8,
                dinasLuar: 28,
                tanpaKeterangan: 0
            },
            {
                id: 3,
                name: 'Ditjen Binapenta dan PKK',
                jumlah: 325,
                wfo: 56.3,
                wfh: 0,
                cuti: 5.1,
                tugasBelajar: 0.6,
                dinasLuar: 37.4,
                tanpaKeterangan: 0.6
            },
            {
                id: 4,
                name: 'Ditjen PHI dan Jamsos Tenaga Kerja',
                jumlah: 193,
                wfo: 37.1,
                wfh: 0,
                cuti: 4.6,
                tugasBelajar: 0.8,
                dinasLuar: 57,
                tanpaKeterangan: 0.5
            },
            {
                id: 5,
                name: 'Ditken Binwasnaker dan K3',
                jumlah: 468,
                wfo: 54,
                wfh: 0,
                cuti: 6,
                tugasBelajar: 1,
                dinasLuar: 39,
                tanpaKeterangan: 0
            },
            {
                id: 6,
                name: 'Inspektorat Jenderal',
                jumlah: 121,
                wfo: 30,
                wfh: 0,
                cuti: 5,
                tugasBelajar: 0,
                dinasLuar: 65,
                tanpaKeterangan: 0
            },
            {
                id: 7,
                name: 'Barenbang Ketenagakerjaan',
                jumlah: 129,
                wfo: 44.0,
                wfh: 0,
                cuti: 4.2,
                tugasBelajar: 0,
                dinasLuar: 51.2,
                tanpaKeterangan: 0.4
            },
        ]

        const kehadiranChartOptions = {
            chart: {
                height: 450,
                type: 'bar',
                stacked: true,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                },
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            series: [
                {
                    name: 'WFO',
                    data: kehadiran.map((unit) => unit.wfo)
                }, {
                    name: 'WFH',
                    data: kehadiran.map((unit) => unit.wfh)
                }, {
                    name: 'Cuti',
                    data: kehadiran.map((unit) => unit.cuti)
                }, {
                    name: 'Tugas Belajar',
                    data: kehadiran.map((unit) => unit.tugasBelajar)
                }, {
                    name: 'Dinar Luar',
                    data: kehadiran.map((unit) => unit.dinasLuar)
                }, {
                    name: 'Tanpa Keterangan',
                    data: kehadiran.map((unit) => unit.tanpaKeterangan)
                }
            ],
            xaxis: {
                categories: kehadiran.map((unit) => unit.name),
            },
            yaxis: {
                title: {
                    text: 'Percentage (%)'
                },
                max: 100
            },
            colors: [
                'rgba(77, 124, 255, 0.8)',
                'rgba(81, 206, 138, 0.8)',
                'rgba(115, 58, 235, 0.8)',
                'rgba(242, 66, 109, 0.8)',
                'rgba(254, 200, 1, 0.8)',
                'rgba(255, 184, 77, 0.8)'
            ],
            tooltip: {
                y: {
                    formatter: (val) => `${val}%`
                }
            },
            fill: {
                opacity: 1
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'right',
                horizontalAlign: 'left',
            }
        }
        const kehadiranChart = new ApexCharts(
            document.querySelector('#kehadiran-chart'),
            kehadiranChartOptions
        );

        kehadiranChart.render();

        const kehadiranTableContainer = document.querySelector('#kehadiran-table')

        const kehadiranAcc = {
            id: 99,
            name: "Total",
            jumlah: 0,
            wfo: 0,
            wfh: 0,
            cuti: 0,
            tugasBelajar: 0,
            dinasLuar: 0,
            tanpaKeterangan: 0,
            total: 0
        }

        const kehadiranAppendRow = (table, data) => {
            const row = document.createElement('tr')

            row.innerHTML = `
                <td>${data.name}</td>
                <td class="text-center">${data.jumlah}</td>
                <td class="text-center">${data.wfo}%</td>
                <td class="text-center">${data.wfh}%</td>
                <td class="text-center">${data.cuti}%</td>
                <td class="text-center">${data.tugasBelajar}%</td>
                <td class="text-center">${data.dinasLuar}%</td>
                <td class="text-center">${data.tanpaKeterangan}%</td>
                <td class="text-center">${data.total}%</td>
            `

            table.append(row)
        }

        kehadiran.forEach((unit) => {
            unit.total = Math.ceil(unit.wfo + unit.wfh + unit.cuti + unit.tugasBelajar + unit.dinasLuar + unit.tanpaKeterangan)
            
            kehadiranAcc.jumlah += unit.jumlah
            kehadiranAcc.wfo += unit.wfo
            kehadiranAcc.wfh += unit.wfh
            kehadiranAcc.cuti += unit.cuti
            kehadiranAcc.tugasBelajar += unit.tugasBelajar
            kehadiranAcc.dinasLuar += unit.dinasLuar
            kehadiranAcc.tanpaKeterangan += unit.tanpaKeterangan
            kehadiranAcc.total += unit.total

            kehadiranAppendRow(kehadiranTableContainer, unit)
        })

        const countPercentage = (value) => (Math.ceil((value / kehadiran.length) * 10) / 10).toFixed(1)

        kehadiranAcc.wfo = countPercentage(kehadiranAcc.wfo)
        kehadiranAcc.wfh = countPercentage(kehadiranAcc.wfh)
        kehadiranAcc.cuti = countPercentage(kehadiranAcc.cuti)
        kehadiranAcc.tugasBelajar = countPercentage(kehadiranAcc.tugasBelajar)
        kehadiranAcc.dinasLuar = countPercentage(kehadiranAcc.dinasLuar)
        kehadiranAcc.tanpaKeterangan = countPercentage(kehadiranAcc.tanpaKeterangan)
        kehadiranAcc.total = countPercentage(kehadiranAcc.total)

        kehadiranAppendRow(kehadiranTableContainer, kehadiranAcc)
    </script>
@endpush
