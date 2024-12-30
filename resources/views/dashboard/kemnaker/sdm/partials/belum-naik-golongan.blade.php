<div class="box rounded-2xl">
    <div class="box-header flex b-0 justify-start items-center">
        <h2 class="mt-0">Rekap Tingkat Kehadiran ASN</h2>
    </div>
    <div class="box-body pt-0 summery-box">
        <h5 class="text-center font-bold text-lg chart-title">Tingkat Kehadiran ASN Kemenaker - Minggu II November 2024</h5>
        <div id="not-yet-promoted-chart"></div>
    </div>

    <hr>

    <div class="box-body summery-box">
        <div class="overflow-x-auto">
            <table class="table table-striped b-1 border-dark table-bordered w-full">
                <thead class="text-base uppercase bg-dark">
                    <tr>
                        <th scope="col" rowspan="2">Unit Kerja</th>
                        <th scope="col" colspan="5">Golongan IV</th>
                        <th scope="col" colspan="4">Golongan III</th>
                        <th scope="col" colspan="4">Golongan II</th>
                        <th scope="col" colspan="4">Golongan I</th>
                        <th scope="col" rowspan="2">Total</th>
                        <th scope="col" rowspan="2">Total Pegawai</th>
                        <th scope="col" rowspan="2">Persentase</th>
                    </tr>
                    <tr>
                        <th scope="col">IV/E</th>
                        <th scope="col">IV/D</th>
                        <th scope="col">IV/C</th>
                        <th scope="col">IV/B</th>
                        <th scope="col">IV/A</th>
                        <th scope="col">III/D</th>
                        <th scope="col">III/C</th>
                        <th scope="col">III/B</th>
                        <th scope="col">III/A</th>
                        <th scope="col">II/D</th>
                        <th scope="col">II/C</th>
                        <th scope="col">II/B</th>
                        <th scope="col">II/A</th>
                        <th scope="col">I/D</th>
                        <th scope="col">I/C</th>
                        <th scope="col">I/B</th>
                        <th scope="col">I/A</th>
                    </tr>
                </thead>
                <tbody id="not-yet-promoted-table">
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <script>
        const notYetPromoted = [
            {
                id: 1,
                name: 'Sekretariat Jenderal',
                iv: { e: 2, d: 0, c: 2, b: 5, a: 9 },
                iii: { d: 23, c: 8, b: 14, a: 2 },
                ii: { d: 2, c: 2, b: 0, a: 1 },
                i: { d: 0, c: 0, b: 0, a: 0 },
                number: { notYetPromoted: 70, employees: 397, percentage: 17.63 }
            }, {
                id: 2,
                name: 'Ditjen Binalavotas',
                iv: { e: 0, d: 0, c: 1, b: 12, a: 50 },
                iii: { d: 91, c: 41, b: 48, a: 80 },
                ii: { d: 7, c: 2, b: 1, a: 2 },
                i: { d: 0, c: 0, b: 0, a: 0 },
                number: { notYetPromoted: 335, employees: 1656, percentage: 20.23 }
            }, {
                id: 3,
                name: 'Ditjen Binapenta dan PKK',
                iv: { e: 1, d: 0, c: 0, b: 6, a: 0 },
                iii: { d: 18, c: 3, b: 2, a: 2 },
                ii: { d: 0, c: 2, b: 0, a: 0 },
                i: { d: 0, c: 0, b: 0, a: 0 },
                number: { notYetPromoted: 34, employees: 280, percentage: 12.14 }
            }, {
                id: 4,
                name: 'Ditjen PHI dan Jamsos Tenaga Kerja',
                iv: { e: 0, d: 0, c: 0, b: 2, a: 1 },
                iii: { d: 2, c: 8, b: 5, a: 0 },
                ii: { d: 0, c: 0, b: 0, a: 0 },
                i: { d: 0, c: 0, b: 0, a: 0 },
                number: { notYetPromoted: 18, employees: 162, percentage: 11.11 }
            }, {
                id: 5,
                name: 'Ditken Binwasnaker dan K3',
                iv: { e: 0, d: 0, c: 3, b: 5, a: 4 },
                iii: { d: 15, c: 17, b: 20, a: 8 },
                ii: { d: 1, c: 0, b: 0, a: 0 },
                i: { d: 0, c: 0, b: 0, a: 0 },
                number: { notYetPromoted: 73, employees: 388, percentage: 18.81 }
            }, {
                id: 6,
                name: 'Inspektorat Jenderal',
                iv: { e: 0, d: 0, c: 0, b: 2, a: 1 },
                iii: { d: 2, c: 2, b: 3, a: 0 },
                ii: { d: 0, c: 0, b: 0, a: 0 },
                i: { d: 0, c: 0, b: 0, a: 0 },
                number: { notYetPromoted: 10, employees: 115, percentage: 8.70 }
            }, {
                id: 7,
                name: 'Barenbang Ketenagakerjaan',
                iv: { e: 0, d: 1, c: 0, b: 6, a: 4 },
                iii: { d: 5, c: 3, b: 6, a: 0 },
                ii: { d: 0, c: 0, b: 0, a: 0 },
                i: { d: 0, c: 0, b: 0, a: 0 },
                number: { notYetPromoted: 25, employees: 127, percentage: 19.69 }
            },
            {
                id: 8,
                name: 'Penugasan',
                iv: { e: 0, d: 0, c: 0, b: 0, a: 1 },
                iii: { d: 2, c: 0, b: 3, a: 0 },
                ii: { d: 1, c: 2, b: 0, a: 0 },
                i: { d: 0, c: 1, b: 0, a: 0 },
                number: { notYetPromoted: 10, employees: 72, percentage: 13.89 }
            }
        ]

        const notYetPromotedChartOptions = {
            chart: {
                height: 450,
                type: 'bar',
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
                    name: 'Belum/Tidak Naik Pangkat',
                    data: notYetPromoted.map((unit) => unit.number.notYetPromoted)
                },
                {
                    name: 'Pegawai Total',
                    data: notYetPromoted.map((unit) => unit.number.employees)
                }
            ],
            xaxis: {
                categories: notYetPromoted.map((unit) => unit.name),
            },
            yaxis: {
                title: {
                    text: 'Jumlah Pegawai'
                },
            },
            colors: [
                'rgba(81, 206, 138, 0.8)',
                'rgba(88, 77, 99, 0.4)',
            ],
            tooltip: {},
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
        const notYetPromotedChart = new ApexCharts(
            document.querySelector('#not-yet-promoted-chart'),
            notYetPromotedChartOptions
        );

        notYetPromotedChart.render();

        const notYetPromotedTableContainer = document.querySelector('#not-yet-promoted-table')

        const notYetPromotedAcc = {
            id: 99,
            name: "Total PNS",
            iv: { e: 0, d: 0, c: 0, b: 0, a: 0 },
            iii: { d: 0, c: 0, b: 0, a: 0 },
            ii: { d: 0, c: 0, b: 0, a: 0 },
            i: { d: 0, c: 0, b: 0, a: 0 },
            number: { notYetPromoted: 0, employees: 0, percentage: 0 }
        }

        const notYetPromotedAppendRow = (table, data, isDark) => {
            const row = document.createElement('tr')

            if (isDark) {
                row.classList.add('bg-dark')
            }

            row.innerHTML = `
                <td>${data.name}</td>
                <td class="text-center">${data.iv.e}</td>
                <td class="text-center">${data.iv.d}</td>
                <td class="text-center">${data.iv.c}</td>
                <td class="text-center">${data.iv.b}</td>
                <td class="text-center">${data.iv.a}</td>
                <td class="text-center">${data.iii.d}</td>
                <td class="text-center">${data.iii.c}</td>
                <td class="text-center">${data.iii.b}</td>
                <td class="text-center">${data.iii.a}</td>
                <td class="text-center">${data.ii.d}</td>
                <td class="text-center">${data.ii.c}</td>
                <td class="text-center">${data.ii.b}</td>
                <td class="text-center">${data.ii.a}</td>
                <td class="text-center">${data.i.d}</td>
                <td class="text-center">${data.i.c}</td>
                <td class="text-center">${data.i.b}</td>
                <td class="text-center">${data.i.a}</td>
                <td class="text-center">${data.number.notYetPromoted}</td>
                <td class="text-center">${data.number.employees}</td>
                <td class="text-center">${data.number.percentage}%</td>
            `

            table.append(row)
        }

        const updateNotYetPromotedAcc = (key, values) => {
            Object.keys(values).forEach(subKey => {
                notYetPromotedAcc[key][subKey] += values[subKey]
            })
        }

        notYetPromoted.forEach((unit) => {
            updateNotYetPromotedAcc('iv', unit.iv)
            updateNotYetPromotedAcc('iii', unit.iii)
            updateNotYetPromotedAcc('ii', unit.ii)
            updateNotYetPromotedAcc('i', unit.i)
            updateNotYetPromotedAcc('number', unit.number)

            notYetPromotedAppendRow(notYetPromotedTableContainer, unit)
        })

        notYetPromotedAcc.number.percentage =  (notYetPromotedAcc.number.percentage / notYetPromoted.length).toFixed(2)

        notYetPromotedAppendRow(notYetPromotedTableContainer, notYetPromotedAcc, true)
    </script>
@endpush
