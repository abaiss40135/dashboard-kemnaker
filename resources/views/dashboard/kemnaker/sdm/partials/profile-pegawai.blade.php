<div class="box rounded-2xl">
    <div class="box-header flex b-0 justify-start items-center">
        <h2 class="mt-0">Rekap Profil Pegawai</h2>
    </div>
    <div class="box-body pt-0 summery-box">
        <h5 class="text-center font-bold text-lg chart-title">Jumlah Pegawai Kemnaker Berdasarkan Unit Kerja</h5>
        <div id="pegawai-chart"></div>
    </div>

    <hr>

    <div class="box-body summery-box">
        <div class="overflow-x-auto">
            <table class="table table-striped b-1 border-dark table-bordered w-full">
                <thead class="text-base uppercase bg-dark">
                    <tr>
                        <th scope="col" rowspan="2">Unit Kerja</th>
                        <th scope="col" colspan="3">Jabatan</th>
                        <th scope="col" colspan="4">Golongan</th>
                        <th scope="col" colspan="2">Jenis Kelamin</th>
                        <th scope="col" colspan="10">Pendidikan</th>
                        <th scope="col" rowspan="2">Total</th>
                    </tr>
                    <tr>
                        <th scope="col">Struktural</th>
                        <th scope="col">Fungsional Tertentu</th>
                        <th scope="col">Fungsional Umum</th>
                        <th scope="col">IV</th>
                        <th scope="col">III</th>
                        <th scope="col">II</th>
                        <th scope="col">I</th>
                        <th scope="col">Laki-laki</th>
                        <th scope="col">Perempuan</th>
                        <th scope="col">SD</th>
                        <th scope="col">SLTP</th>
                        <th scope="col">SLTA</th>
                        <th scope="col">D1</th>
                        <th scope="col">D2</th>
                        <th scope="col">D3</th>
                        <th scope="col">D4</th>
                        <th scope="col">S1</th>
                        <th scope="col">S2</th>
                        <th scope="col">S3</th>
                    </tr>
                </thead>
                <tbody id="pegawai-table-1">
                </tbody>
            </table>
        </div>
    </div>

    <hr>

    <div class="box-body summery-box">
        <div class="overflow-x-auto">
            <table class="table table-striped b-1 border-dark table-bordered w-full">
                <thead class="text-base uppercase bg-dark">
                    <tr>
                        <th scope="col" rowspan="2">Unit Kerja</th>
                        <th scope="col" colspan="5">Agama</th>
                        <th scope="col" colspan="10">Usia</th>
                        <th scope="col" rowspan="2">Total</th>
                    </tr>
                    <tr>
                        <th scope="col">Islam</th>
                        <th scope="col">Kristen</th>
                        <th scope="col">Katholik</th>
                        <th scope="col">Hindu</th>
                        <th scope="col">Budha</th>
                        <th scope="col">< 20</th>
                        <th scope="col">20-24</th>
                        <th scope="col">25-30</th>
                        <th scope="col">31-35</th>
                        <th scope="col">36-40</th>
                        <th scope="col">41-45</th>
                        <th scope="col">46-50</th>
                        <th scope="col">51-55</th>
                        <th scope="col">56-60</th>
                        <th scope="col">> 60</th>
                    </tr>
                </thead>
                <tbody id="pegawai-table-2">
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <script>
        const pegawai = [
            {
                id: 1,
                name: 'Sekretariat Jenderal',
                position: { structural: 32, functionalSpecific: 210, functionalGeneral: 155 },
                class: { iv: 82, iii: 294, ii: 21, i: 0},
                gender: { male: 209, female: 188 },
                education: { sd: 1, sltp: 2, slta: 19, d1: 1, d2: 0, d3: 29, d4: 7, s1: 193, s2: 139, s3: 6},
                religion: { islam: 357, kristen: 35, katholik: 3, hindu: 2, budha: 0 },
                age: { lessThan20: 0, between20And24: 7, between25And30: 44, between30And35: 57, between36And40: 96, between41And45: 73, between46And50: 46, between51And55: 42, between56And60: 27, moreThan60: 5 }
            },
            {
                id: 2,
                name: 'Ditjen Binalavotas',
                position: { structural: 56, functionalSpecific: 1202, functionalGeneral: 398 },
                class: { iv: 241, iii: 1315, ii: 99, i: 1 },
                gender: { male: 985, female: 671 },
                education: { sd: 2, sltp: 8, slta: 61, d1: 1, d2: 2, d3: 164, d4: 73, s1: 1048, s2: 293, s3: 4 },
                religion: { islam: 1396, kristen: 202, katholik: 52, hindu: 4, budha: 2 },
                age: { lessThan20: 0, between20And24: 0, between25And30: 217, between30And35: 322, between36And40: 414, between41And45: 343, between46And50: 181, between51And55: 109, between56And60: 70, moreThan60: 0 }
            },
            {
                id: 3,
                name: 'Ditjen Binapenta dan PKK',
                position: { structural: 19, functionalSpecific: 198, functionalGeneral: 63 },
                class: { iv: 70, iii: 200, ii: 10, i: 0 },
                gender: { male: 144, female: 136 },
                education: { sd: 0, sltp: 0, slta: 4, d1: 1, d2: 0, d3: 12, d4: 0, s1: 154, s2: 103, s3: 6 },
                religion: { islam: 247, kristen: 23, katholik: 9, hindu: 1, budha: 0 },
                age: { lessThan20: 0, between20And24: 0, between25And30: 21, between30And35: 26, between36And40: 77, between41And45: 74, between46And50: 38, between51And55: 32, between56And60: 11, moreThan60: 1 }
            },
            {
                id: 4,
                name: 'Ditjen PHI dan Jamsos Tenaga Kerja',
                position: { structural: 14, functionalSpecific: 124, functionalGeneral: 24 },
                class: { iv: 43, iii: 118, ii: 1, i: 0 },
                gender: { male: 90, female: 72 },
                education: { sd: 0, sltp: 0, slta: 1, d1: 0, d2: 0, d3: 2, d4: 0, s1: 101, s2: 57, s3: 1 },
                religion: { islam: 131, kristen: 24, katholik: 6, hindu: 1, budha: 0 },
                age: { lessThan20: 0, between20And24: 0, between25And30: 8, between30And35: 21, between36And40: 53, between41And45: 33, between46And50: 24, between51And55: 13, between56And60: 10, moreThan60: 0 }
            },
            {
                id: 5,
                name: 'Ditken Binwasnaker dan K3',
                position: { structural: 22, functionalSpecific: 293, functionalGeneral: 73 },
                class: { iv: 108, iii: 271, ii: 8, i: 1 },
                gender: { male: 183, female: 205 },
                education: { sd: 1, sltp: 0, slta: 14, d1: 0, d2: 0, d3: 19, d4: 0, s1: 209, s2: 141, s3: 4 },
                religion: { islam: 327, kristen: 47, katholik: 11, hindu: 3, budha: 0 },
                age: { lessThan20: 0, between20And24: 0, between25And30: 17, between30And35: 66, between36And40: 84, between41And45: 89, between46And50: 58, between51And55: 40, between56And60: 32, moreThan60: 2 }
            },
            {
                id: 6,
                name: 'Inspektorat Jenderal',
                position: { structural: 12, functionalSpecific: 78, functionalGeneral: 25 },
                class: { iv: 31, iii: 81, ii: 3, i: 0 },
                gender: { male: 66, female: 49 },
                education: { sd: 0, sltp: 0, slta: 3, d1: 0, d2: 0, d3: 7, d4: 0, s1: 62, s2: 39, s3: 4 },
                religion: { islam: 106, kristen: 8, katholik: 1, hindu: 0, budha: 0 },
                age: { lessThan20: 0, between20And24: 1, between25And30: 12, between30And35: 10, between36And40: 34, between41And45: 31, between46And50: 11, between51And55: 9, between56And60: 6, moreThan60: 1 }
            },
            {
                id: 7,
                name: 'Barenbang Ketenagakerjaan',
                position: { structural: 10, functionalSpecific: 88, functionalGeneral: 29 },
                class: { iv: 30, iii: 94, ii: 3, i: 0 },
                gender: { male: 66, female: 61 },
                education: { sd: 0, sltp: 0, slta: 1, d1: 1, d2: 0, d3: 7, d4: 1, s1: 73, s2: 42, s3: 2 },
                religion: { islam: 113, kristen: 7, katholik: 5, hindu: 2, budha: 0 },
                age: { lessThan20: 0, between20And24: 0, between25And30: 16, between30And35: 30, between36And40: 25, between41And45: 21, between46And50: 8, between51And55: 11, between56And60: 16, moreThan60: 0 }
            },
            {
                id: 8,
                name: 'Penugasan Luar Kemnaker',
                position: { structural: 0, functionalSpecific: 11, functionalGeneral: 61 },
                class: { iv: 8, iii: 27, ii: 35, i: 2 },
                gender: { male: 66, female: 6 },
                education: { sd: 4, sltp: 7, slta: 41, d1: 0, d2: 0, d3: 0, d4: 0, s1: 10, s2: 10, s3: 0 },
                religion: { islam: 60, kristen: 8, katholik: 4, hindu: 0, budha: 0 },
                age: { lessThan20: 0, between20And24: 0, between25And30: 0, between30And35: 0, between36And40: 7, between41And45: 16, between46And50: 26, between51And55: 13, between56And60: 10, moreThan60: 0 }
            },
        ]

        const pegawaiChartOptions = {
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
                    name: 'Total Pegawai',
                    data: pegawai.map((unit) => unit.gender.male + unit.gender.female)
                }
            ],
            xaxis: {
                categories: pegawai.map((unit) => unit.name),
            },
            yaxis: {
                title: {
                    text: 'Total Pegawai'
                },
            },
            colors: ['rgba(77, 124, 255, 0.8)'],
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
            },
        }
        const pegawaiChart = new ApexCharts(
            document.querySelector('#pegawai-chart'),
            pegawaiChartOptions
        );

        pegawaiChart.render();

        const pegawaiTableContainer1 = document.querySelector('#pegawai-table-1')
        const pegawaiTableContainer2 = document.querySelector('#pegawai-table-2')

        const pegawaiAcc = {
            id: 8,
            name: 'Total PNS',
            position: { structural: 0, functionalSpecific: 0, functionalGeneral: 0 },
            class: { iv: 0, iii: 0, ii: 0, i: 0 },
            gender: { male: 0, female: 0 },
            education: { sd: 0, sltp: 0, slta: 0, d1: 0, d2: 0, d3: 0, d4: 0, s1: 0, s2: 0, s3: 0 },
            religion: { islam: 0, kristen: 0, katholik: 0, hindu: 0, budha: 0 },
            age: { lessThan20: 0, between20And24: 0, between25And30: 0, between30And35: 0, between36And40: 0, between41And45: 0, between46And50: 0, between51And55: 0, between56And60: 0, moreThan60: 0 },
            total: 0
        }

        const updatePegawaiAcc = (key, values) => {
            if (typeof values === 'object') {
                Object.keys(values).forEach(subKey => {
                    pegawaiAcc[key][subKey] += values[subKey]
                })

                return
            }

            pegawaiAcc[key] += values
        }

        const pegawaiAppendRow = (table, data, isDark) => {
            const row = document.createElement('tr')

            if (isDark) {
                row.classList.add('bg-dark')
            }

            if (table == pegawaiTableContainer1) {
                row.innerHTML = `
                    <td>${data.name}</td>
                    <td class="text-center">${data.position.structural}</td>
                    <td class="text-center">${data.position.functionalSpecific}</td>
                    <td class="text-center">${data.position.functionalGeneral}</td>
                    <td class="text-center">${data.class.iv}</td>
                    <td class="text-center">${data.class.iii}</td>
                    <td class="text-center">${data.class.ii}</td>
                    <td class="text-center">${data.class.i}</td>
                    <td class="text-center">${data.gender.male}</td>
                    <td class="text-center">${data.gender.female}</td>
                    <td class="text-center">${data.education.sd}</td>
                    <td class="text-center">${data.education.sltp}</td>
                    <td class="text-center">${data.education.slta}</td>
                    <td class="text-center">${data.education.d1}</td>
                    <td class="text-center">${data.education.d2}</td>
                    <td class="text-center">${data.education.d3}</td>
                    <td class="text-center">${data.education.d4}</td>
                    <td class="text-center">${data.education.s1}</td>
                    <td class="text-center">${data.education.s2}</td>
                    <td class="text-center">${data.education.s3}</td>
                    <td class="text-center">${data.total}</td>
                `
            } else if (table == pegawaiTableContainer2) {
                row.innerHTML = `
                    <td>${data.name}</td>
                    <td class="text-center">${data.religion.islam}</td>
                    <td class="text-center">${data.religion.kristen}</td>
                    <td class="text-center">${data.religion.katholik}</td>
                    <td class="text-center">${data.religion.hindu}</td>
                    <td class="text-center">${data.religion.budha}</td>
                    <td class="text-center">${data.age.lessThan20}</td>
                    <td class="text-center">${data.age.between20And24}</td>
                    <td class="text-center">${data.age.between25And30}</td>
                    <td class="text-center">${data.age.between30And35}</td>
                    <td class="text-center">${data.age.between36And40}</td>
                    <td class="text-center">${data.age.between41And45}</td>
                    <td class="text-center">${data.age.between46And50}</td>
                    <td class="text-center">${data.age.between51And55}</td>
                    <td class="text-center">${data.age.between56And60}</td>
                    <td class="text-center">${data.age.moreThan60}</td>
                    <td class="text-center">${data.total}</td>
                `
            }

            table.append(row)
        }

        pegawai.forEach((unit) => {
            unit.total = unit.gender.male + unit.gender.female

            updatePegawaiAcc('position', unit.position)
            updatePegawaiAcc('class', unit.class)
            updatePegawaiAcc('gender', unit.gender)
            updatePegawaiAcc('education', unit.education)
            updatePegawaiAcc('religion', unit.religion)
            updatePegawaiAcc('age', unit.age)
            updatePegawaiAcc('total', unit.total)

            pegawaiAppendRow(pegawaiTableContainer1, unit)
            pegawaiAppendRow(pegawaiTableContainer2, unit)
        })

        pegawaiAppendRow(pegawaiTableContainer1, pegawaiAcc, true)
        pegawaiAppendRow(pegawaiTableContainer2, pegawaiAcc, true)
    </script>
@endpush
