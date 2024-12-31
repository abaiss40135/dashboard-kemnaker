@extends('templates.dashboard.admin')

@section('content')
    <div class="box rounded-2xl">
        <div class="box-header flex b-0 justify-start items-center">
            <h2 class="mt-0">Rekapitulasi Penduduk yang Bekerja</h2>
        </div>
        <div class="box-body pt-0 summery-box">
            <h5 class="text-center font-bold text-lg">
                Jumlah Penduduk yang Bekerja berdasarkan Jenis Kelamin Per Provinsi
            </h5>

            <div id="genderChart"></div>
        </div>

        <hr>

        <div class="box-body summery-box">
            <h5 class="text-center font-bold text-lg">
                Jumlah Penduduk yang Bekerja berdasarkan Klasifikasi Pendidikan Terakhir Per Provinsi
            </h5>

            <div id="educationChart"></div>
        </div>
        
        <hr>

        <div class="box-body summery-box">
            <h5 class="text-center font-bold text-lg">
                Jumlah Penduduk yang Bekerja berdasarkan Klasifikasi Tempat Kerja Per Provinsi
            </h5>

            <div id="regionChart"></div>
        </div>

        <hr>

        <div class="box-body summery-box">
            <h5 class="text-center font-bold text-lg">
                Jumlah Penduduk yang Bekerja berdasarkan Riwayat Pelatihan atau Kursus
            </h5>

            <div id="trainingChart"></div>
        </div>
    </div>
    <div class="box rounded-2xl">
        <div class="box-body summery-box">
            <div class="overflow-x-auto">
                <table class="table table-striped b-1 border-dark table-bordered w-full" id="table-pekerja">
                    <thead class="text-base uppercase bg-dark">
                        <tr>
                            <th scope="col" rowspan="2">Provinsi</th>
                            <th scope="col" colspan="3">Jenis Jelamin</th>
                            <th scope="col" colspan="3">Klasifikasi Perkotaan/Perdesaan</th>
                            <th scope="col" colspan="7">Pendidikan tertinggi yang ditamatkan hasil perbaikan</th>
                            <th scope="col" colspan="4">Pernah ikut pelatihan atau kursus dan mendapatkan sertifikat</th>
                        </tr>
                        <tr>
                            <th scope="col">Laki-Laki</th>
                            <th scope="col">Perempuan</th>
                            <th scope="col">Total</th>
                            <th scope="col">Perkotaan</th>
                            <th scope="col">Perdesaan</th>
                            <th scope="col">Total</th>
                            <th scope="col"><= SD</th>
                            <th scope="col">SMP</th>
                            <th scope="col">SMU</th>
                            <th scope="col">SMK</th>
                            <th scope="col">Diploma I/II/III</th>
                            <th scope="col">Universitas (DIV/S1/S2/S3)</th>
                            <th scope="col">Total</th>
                            <th scope="col">pernah dan mendapatkan sertifikat</th>
                            <th scope="col">pernah tetapi tidak mendapatkan sertifikat</th>
                            <th scope="col">tidak pernah</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody id="table-pekerja-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <script>
        const data = [{
                id: 11,
                name: "Aceh",
                gender: { male: 1555763, female: 899624 },
                education: { sd: 640943, smp: 468723, smu: 844587, smk: 87219, diploma: 82653, sarjana: 331262 },
                region: { urban: 889495, rural: 1565892 },
                training: { gotCert: 313378, didNotGetCert: 123412, never: 2018597 },
            },
            {
                id: 12,
                name: "Sumatera Utara",
                gender: { male: 4497717, female: 3094561 },
                education: { sd: 1971733, smp: 1454693, smu: 2147545, smk: 1005958, diploma: 193503, sarjana: 818846 },
                region: { urban: 4174242, rural: 3418036 },
                training: { gotCert: 1134237, didNotGetCert: 476452, never: 5981589 },
            },
            {
                id: 13,
                name: "Sumatera Barat",
                gender: { male: 1721203, female: 1186249 },
                education: { sd: 857562, smp: 512103, smu: 716151, smk: 312775, diploma: 84916, sarjana: 423945 },
                region: { urban: 1450377, rural: 1457075 },
                training: { gotCert: 527499, didNotGetCert: 158234, never: 2221719 },
            },
            {
                id: 14,
                name: "Riau",
                gender: { male: 2041371, female: 1057386 },
                education: { sd: 928548, smp: 565802, smu: 843972, smk: 311755, diploma: 78002, sarjana: 370678 },
                region: { urban: 1265418, rural: 1833339 },
                training: { gotCert: 571893, didNotGetCert: 150406, never: 2376458 },
            },
            {
                id: 15,
                name: "Jambi",
                gender: { male: 1144470, female: 629066 },
                education: { sd: 651427, smp: 302806, smu: 464654, smk: 119280, diploma: 43485, sarjana: 191884 },
                region: { urban: 616319, rural: 1157217 },
                training: { gotCert: 244043, didNotGetCert: 59102, never: 1470391 },
            },
            {
                id: 16,
                name: "Sumatera Selatan",
                gender: { male: 2716371, female: 1659076 },
                education: { sd: 1805242, smp: 770102, smu: 1037085, smk: 302910, diploma: 89148, sarjana: 370960 },
                region: { urban: 1605917, rural: 2769530 },
                training: { gotCert: 524781, didNotGetCert: 180727, never: 3669939 },
            },
            {
                id: 17,
                name: "Bengkulu",
                gender: { male: 669605, female: 411139 },
                education: { sd: 372785, smp: 182934, smu: 258641, smk: 93924, diploma: 30183, sarjana: 142277 },
                region: { urban: 373111, rural: 707633 },
                training: { gotCert: 197255, didNotGetCert: 59259, never: 824230 },
            },
            {
                id: 18,
                name: "Lampung",
                gender: { male: 3047155, female: 1789179 },
                education: { sd: 1790734, smp: 1276043, smu: 901327, smk: 448957, diploma: 85043, sarjana: 334230 },
                region: { urban: 1645595, rural: 3190739 },
                training: { gotCert: 554619, didNotGetCert: 173990, never: 4107725 },
            },
            {
                id: 19,
                name: "Bangka-Belitung",
                gender: { male: 509520, female: 277620 },
                education: { sd: 321032, smp: 109688, smu: 156894, smk: 93272, diploma: 22737, sarjana: 83517 },
                region: { urban: 465873, rural: 321267 },
                training: { gotCert: 144768, didNotGetCert: 30872, never: 611500 },
            },
            {
                id: 21,
                name: "Kepulauan Riau",
                gender: { male: 635417, female: 367976 },
                education: { sd: 205815, smp: 89433, smu: 313127, smk: 190796, diploma: 43213, sarjana: 161009 },
                region: { urban: 908440, rural: 94953 },
                training: { gotCert: 202125, didNotGetCert: 34318, never: 766950 },
            },
            {
                id: 31,
                name: "DKI Jakarta",
                gender: { male: 3095741, female: 2011041 },
                education: { sd: 601913, smp: 696297, smu: 1343088, smk: 1204239, diploma: 213380, sarjana: 1047865 },
                region: { urban: 5106782, rural: 0},
                training: { gotCert: 1604950, didNotGetCert: 429052, never: 3072780 },
            },
            {
                id: 32,
                name: "Jawa Barat",
                gender: { male: 15265074, female: 8821511 },
                education: { sd: 8552974, smp: 4486822, smu: 4466374, smk: 3735627, diploma: 641496, sarjana: 2203292 },
                region: { urban: 18848511, rural: 5238074 },
                training: { gotCert: 3711871, didNotGetCert:  1193722, never: 19180992 },
            },
            {
                id: 33,
                name: "Jawa Tengah",
                gender: { male: 11828462, female: 8580762 },
                education: { sd: 8564634, smp: 4327817, smu: 2925981, smk: 2758628, diploma: 414549, sarjana: 1417615 },
                region: { urban: 10848127, rural: 9561097 },
                training: { gotCert: 2897464, didNotGetCert:  1212779, never: 16298981 },
            },
            {
                id: 34,
                name: "D I Yogyakarta",
                gender: { male: 1191421, female: 942188 },
                education: { sd: 573076, smp: 380654, smu: 315961, smk: 513838, diploma: 59172, sarjana: 290908 },
                region: { urban: 1559064, rural: 574545 },
                training: { gotCert: 565197, didNotGetCert: 152409, never: 1416003 },
            },
            {
                id: 35,
                name: "Jawa Timur",
                gender: { male: 13452034, female: 9784044 },
                education: { sd: 9893338, smp: 4378927, smu: 4009049, smk: 2741899, diploma: 350394, sarjana: 1862471 },
                region: { urban: 12919728, rural: 10316350 },
                training: { gotCert: 2837804, didNotGetCert: 655427, never: 19742847 },
            },
            {
                id: 36,
                name: "Banten",
                gender: { male: 3599160, female: 2026175 },
                education: { sd: 2015556, smp: 962721, smu: 1153832, smk: 762590, diploma: 88075, sarjana: 642561 },
                region: { urban: 4292925, rural: 1332410 },
                training: { gotCert: 783434, didNotGetCert: 102354, never: 4739547 },
            },
            {
                id: 51,
                name: "Bali",
                gender: { male: 1445878, female: 1216924 },
                education: { sd: 798526, smp: 357238, smu: 608552, smk: 382806, diploma: 158575, sarjana: 357105 },
                region: { urban: 1813130, rural: 849672 },
                training: { gotCert: 772572, didNotGetCert: 103509, never: 1786721 },
            },
            {
                id: 52,
                name: "Nusa Tenggara Barat",
                gender: { male: 1660984, female: 1269329 },
                education: { sd: 1331760, smp: 422177, smu: 639181, smk: 190681, diploma: 59043, sarjana: 287471 },
                region: { urban: 1500314, rural: 1429999 },
                training: { gotCert: 461548, didNotGetCert: 188900, never: 2279865 },
            },
            {
                id: 53,
                name: "Nusa Tenggara Timur",
                gender: { male: 1580222, female: 1383556 },
                education: { sd: 1328148, smp: 382896, smu: 621580, smk: 184185, diploma: 85247, sarjana: 361722 },
                region: { urban: 736013, rural: 2227765 },
                training: { gotCert: 335502, didNotGetCert: 119147, never: 2509129 },
            },
            {
                id: 61,
                name: "Kalimantan Barat",
                gender: { male: 1701731, female: 1055187 },
                education: { sd: 1173026, smp: 461124, smu: 603880, smk: 183745, diploma: 61652, sarjana: 273491 },
                region: { urban: 942441, rural: 1814477 },
                training: { gotCert: 354080, didNotGetCert: 116551, never: 2286287 },
            },
            {
                id: 62,
                name: "Kalimantan Tengah",
                gender: { male: 904220, female: 475612 },
                education: { sd: 496664, smp: 250141, smu: 350199, smk: 102255, diploma: 26051, sarjana: 154522 },
                region: { urban: 618180, rural: 761652 },
                training: { gotCert: 185590, didNotGetCert: 47837, never: 1146405 },
            },
            {
                id: 63,
                name: "Kalimantan Selatan",
                gender: { male: 1268355, female: 830033 },
                education: { sd: 841918, smp: 336495, smu: 476360, smk: 157760, diploma: 43714, sarjana: 242141 },
                region: { urban: 1022904, rural: 1075484 },
                training: { gotCert: 455964, didNotGetCert: 98580, never: 1543844 },
            },
            {
                id: 64,
                name: "Kalimantan Timur",
                gender: { male: 1248655, female: 645339 },
                education: { sd: 509270, smp: 284484, smu: 473122, smk: 302984, diploma: 62485, sarjana: 261649 },
                region: { urban: 1340257, rural: 553737 },
                training: { gotCert: 539685, didNotGetCert: 57079, never: 1297230 },
            },
            {
                id: 65,
                name: "Kalimantan Utara",
                gender: { male: 227441, female: 116623 },
                education: { sd: 110857, smp: 48624, smu: 79768, smk: 30317, diploma: 14463, sarjana: 60035 },
                region: { urban: 207566, rural: 136498 },
                training: { gotCert: 95290, didNotGetCert: 10386, never: 238388 },
            },
            {
                id: 71,
                name: "Sulawesi Utara",
                gender: { male: 813122, female: 444066 },
                education: { sd: 344720, smp: 249226, smu: 311841, smk: 146113, diploma: 33411, sarjana: 171877 },
                region: { urban: 712660, rural: 544528 },
                training: { gotCert: 230036, didNotGetCert: 68531, never: 958621 },
            },
            {
                id: 72,
                name: "Sulawesi Tengah",
                gender: { male: 992688, female: 532970, },
                education: { sd: 611199, smp: 269597, smu: 347076, smk: 96474, diploma: 27501, sarjana: 173811 },
                region: { urban: 526262, rural: 999396 },
                training: { gotCert: 173169, didNotGetCert: 54236, never: 1298253 },
            },
            {
                id: 73,
                name: "Sulawesi Selatan",
                gender: { male: 2738251, female: 1739050 },
                education: { sd: 1523873, smp: 671970, smu: 1112662, smk: 337500, diploma: 130477, sarjana: 700819 },
                region: { urban: 1988193, rural: 2489108 },
                training: { gotCert: 884584, didNotGetCert: 206654, never: 3386063 },
            },
            {
                id: 74,
                name: "Sulawesi Tenggara",
                gender: { male: 817012, female: 538002, },
                education: { sd: 422063, smp: 237048, smu: 361193, smk: 69393, diploma: 37678, sarjana: 227639 },
                region: { urban: 487965, rural: 867049 },
                training: { gotCert: 229207, didNotGetCert: 68035, never: 1057772 },
            },
            {
                id: 75,
                name: "Gorontalo",
                gender: { male: 393273, female: 240190, },
                education: { sd: 292246, smp: 73685, smu: 121919, smk: 57923, diploma: 16072, sarjana: 71618 },
                region: { urban: 291170, rural: 342293 },
                training: { gotCert: 120891, didNotGetCert: 31158, never: 481414 },
            },
            {
                id: 76,
                name: "Sulawesi Barat",
                gender: { male: 457113, female: 292791, },
                education: { sd: 348447, smp: 111341, smu: 132822, smk: 51018, diploma: 15348, sarjana: 90928 },
                region: { urban: 162256, rural: 587648 },
                training: { gotCert: 112970, didNotGetCert: 22824, never: 614110 },
            },
            {
                id: 81,
                name: "Maluku",
                gender: { male: 529400, female: 363147, },
                education: { sd: 239870, smp: 122705, smu: 297811, smk: 51982, diploma: 26013, sarjana: 154166 },
                region: { urban: 352337, rural: 540210 },
                training: { gotCert: 129694, didNotGetCert: 33644, never: 729209 },
            },
            {
                id: 82,
                name: "Maluku Utara",
                gender: { male: 393959, female: 248088, },
                education: { sd: 206869, smp: 112825, smu: 189271, smk: 24553, diploma: 20528, sarjana: 88001 },
                region: { urban: 180606, rural: 461441 },
                training: { gotCert: 79906, didNotGetCert: 29168, never: 532973 },
            },
            {
                id: 91,
                name: "Papua Barat",
                gender: { male: 183254, female: 121213, },
                education: { sd: 103331, smp: 52989, smu: 80022, smk: 20337, diploma: 11357, sarjana: 36431 },
                region: { urban: 88391, rural: 216076 },
                training: { gotCert: 51536, didNotGetCert: 11031, never: 241900 },
            },
            {
                id: 92,
                name: "Papua Barat Daya",
                gender: { male: 189218, female: 106058, },
                education: { sd: 83826, smp: 44080, smu: 84771, smk: 26800, diploma: 7241, sarjana: 48558 },
                region: { urban: 152569, rural: 142707 },
                training: { gotCert: 57035, didNotGetCert: 20437, never: 217804 },
            },
            {
                id: 94,
                name: "Papua",
                gender: { male: 289798, female: 190583, },
                education: { sd: 119346, smp: 75750, smu: 168627, smk: 37239, diploma: 13371, sarjana: 66048 },
                region: { urban: 302488, rural: 177893 },
                training: { gotCert: 115812, didNotGetCert: 24815, never: 339754 },
            },
            {
                id: 95,
                name: "Papua Selatan",
                gender: { male: 132999, female: 77290, },
                education: { sd: 78411, smp: 29540, smu: 45175, smk: 14660, diploma: 8886, sarjana: 33617 },
                region: { urban: 85419, rural: 124870 },
                training: { gotCert: 26197, didNotGetCert: 7197, never: 176895 },
            },
            {
                id: 96,
                name: "Papua Tengah",
                gender: { male: 479497, female: 339816, },
                education: { sd: 463527, smp: 164623, smu: 118889, smk: 28453, diploma: 9531, sarjana: 34290 },
                region: { urban: 149642, rural: 669671 },
                training: { gotCert: 30149, didNotGetCert: 3332, never: 785832 },
            },
            {
                id: 97,
                name: "Papua Pegunungan",
                gender: { male: 548868, female: 449160, },
                education: { sd: 778012, smp: 84166, smu: 97296, smk: 4611, diploma: 6973, sarjana: 26970 },
                region: { urban: 76986, rural: 921042 },
                training: { gotCert: 18360, didNotGetCert: 5260, never: 974408 },
            },
        ]

        const commonOptions = {
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
            xaxis: {
                categories: data.map((province) => province.name),
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        if (value >= 1000000) return (value / 1000000).toFixed(1) + 'jt'
                        if (value >= 1000) return (value / 1000).toFixed(1) + 'rb'

                        return value;
                    }
                },
            },
            fill: {
                opacity: 1
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                itemMargin: {
                    horizontal: 12,
                    vertical: 0
                }
            },
        }

        const genderChart = new ApexCharts(
            document.querySelector('#genderChart'),
            {
                ...commonOptions,
                series: [
                    { name: 'Laki-laki', data: data.map((province) => province.gender.male)},
                    { name: 'Perempuan', data: data.map((province) => province.gender.female) }
                ],
                colors: ['#4d7cff', '#51ce8a'],
            }
        )
        genderChart.render()

        const educationChart = new ApexCharts(
            document.querySelector('#educationChart'),
            {
                ...commonOptions,
                stroke: {
                    width: 0,
                },
                series: [
                    { name: 'SD', data: data.map((province) => province.education.sd) },
                    { name: 'SMP', data: data.map((province) => province.education.smp) },
                    { name: 'SMU', data: data.map((province) => province.education.smu) },
                    { name: 'SMK', data: data.map((province) => province.education.smk) },
                    { name: 'Diploma I/II/III', data: data.map((province) => province.education.diploma) },
                    { name: 'Universitas (DIV/S1/S2/S3)', data: data.map((province) => province.education.sarjana) },
                ],
                colors: ['#4d7cff', '#51ce8a', '#733aeb', '#f2426d', '#fec801', '#ffB84d'],
            }
        )
        educationChart.render()

        const regionChart = new ApexCharts(
            document.querySelector('#regionChart'),
            {
                ...commonOptions,
                series: [
                    { name: 'Perkotaan', data: data.map((province) => province.region.urban) },
                    { name: 'Perdesaan', data: data.map((province) => province.region.rural) }
                ],
                colors: ['#51ce8a', '#733aeb'],
            }
        );
        regionChart.render();

        const trainingChart = new ApexCharts(
            document.querySelector('#trainingChart'),
            {
                ...commonOptions,
                series: [
                    { name: 'Pernah dan Mendapat Sertifikat', data: data.map((province) => province.training.gotCert) },
                    { name: 'Pernah tetapi Tidak Mendapatkan Sertifikat', data: data.map((province) => province.training.didNotGetCert) },
                    { name: 'Tidak Pernah ', data: data.map((province) => province.training.never) }
                ],
                colors: ['#51ce8a', '#733aeb'],
            }
        );
        trainingChart.render();

        const number2Indonesian = (number) => new Intl.NumberFormat('id-ID').format(number)

        const tableContainer = document.querySelector('#table-pekerja-body')

        const acc = {
            id: 99,
            name: "Total (Indonesia)",
            gender: { male: 0, female: 0, total: 0 },
            education: { sd: 0, smp: 0, smu: 0, smk: 0, diploma: 0, sarjana: 0, total: 0 },
            region: { urban: 0, rural: 0, total: 0 },
            training: { gotCert: 0, didNotGetCert: 0, never: 0, total: 0 },
        }

        const updateAcc = (key, values) => {
            Object.keys(values).forEach(subKey => {
                acc[key][subKey] += values[subKey]
            })
        }

        const appendRow = (data, isDark = false) => {
            const row = document.createElement('tr')

            if (isDark) {
                row.classList.add('bg-dark')
            }

            row.innerHTML = `
                <td class="text-center">${data.name}</td>
                <td class="text-center">${number2Indonesian(data.gender.male)}</td>
                <td class="text-center">${number2Indonesian(data.gender.female)}</td>
                <td class="text-center">${number2Indonesian(data.gender.total)}</td>
                <td class="text-center">${number2Indonesian(data.education.sd)}</td>
                <td class="text-center">${number2Indonesian(data.education.smp)}</td>
                <td class="text-center">${number2Indonesian(data.education.smu)}</td>
                <td class="text-center">${number2Indonesian(data.education.smk)}</td>
                <td class="text-center">${number2Indonesian(data.education.diploma)}</td>
                <td class="text-center">${number2Indonesian(data.education.sarjana)}</td>
                <td class="text-center">${number2Indonesian(data.education.total)}</td>
                <td class="text-center">${number2Indonesian(data.region.urban)}</td>
                <td class="text-center">${number2Indonesian(data.region.rural)}</td>
                <td class="text-center">${number2Indonesian(data.region.total)}</td>
                <td class="text-center">${number2Indonesian(data.training.gotCert)}</td>
                <td class="text-center">${number2Indonesian(data.training.didNotGetCert)}</td>
                <td class="text-center">${number2Indonesian(data.training.never)}</td>
                <td class="text-center">${number2Indonesian(data.training.total)}</td>
            `

            tableContainer.append(row)
        }

        data.forEach(provinsi => {
            provinsi.gender.total = provinsi.gender.male + provinsi.gender.female
            provinsi.education.total = Object.values(provinsi.education).slice(0, 6).reduce((sum, value) => sum + value, 0)
            provinsi.region.total = provinsi.region.urban + provinsi.region.rural
            provinsi.training.total = Object.values(provinsi.training).slice(0, 3).reduce((sum, value) => sum + value, 0)

            updateAcc('gender', provinsi.gender)
            updateAcc('education', provinsi.education)
            updateAcc('region', provinsi.region)
            updateAcc('training', provinsi.training)

            appendRow(provinsi)
        })

        appendRow(acc, true)
    </script>
@endsection
