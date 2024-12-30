<div class="box rounded-2xl">
    <div class="box-header flex b-0 justify-start items-center">
        <h2 class="mt-0">Rekap Permasalahan Kepangkatan</h2>
    </div>
    <div class="box-body pt-0 summery-box">
        <h5 class="text-center font-bold text-lg chart-title">Permasalahan Kepangkatan</h5>
        <div id="rank-chart"></div>
    </div>

    <hr>

    <div class="box-body summery-box">
        <div class="overflow-x-auto">
            <table class="table table-striped b-1 border-dark table-bordered w-full">
                <thead class="text-base uppercase bg-dark">
                    <tr>
                        <th scope="col">Permasalahan Kepangkatan</th>
                        <th scope="col">Jumlah</th>
                    </tr>
                </thead>
                <tbody id="rank-table">
                    <tr>
                        <td>Kepangkatan Maksimal</td>
                        <td class="text-center">60</td>
                    </tr>
                    <tr>
                        <td>Permasalahan Angka Kredit pada Pejabat Fungsional</td>
                        <td class="text-center">50</td>
                    </tr>
                    <tr>
                        <td>Formasi Jabatan</td>
                        <td class="text-center">55</td>
                    </tr>
                    <tr>
                        <td>Kelulusan Uji Kompetensi Jabatan</td>
                        <td class="text-center">45</td>
                    </tr>
                    <tr>
                        <td>Lain-lain</td>
                        <td class="text-center">65</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <script>
        const rankChartOptions = {
            chart: {
                height: 350,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    distributed: true,
                    borderRadius: 12,
                    borderRadiusApplication: 'end',
                },
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            series: [{
                data: [60, 50, 55, 45, 65]
            }],
            xaxis: {
                categories: [
                    'Kepangkatan Maksimal',
                    'Permasalahan Angka Kredit pada Pejabat Fungsional',
                    'Formasi Jabatan',
                    'Kelulusan Uji Kompetensi Jabatan',
                    'Lain-lain',
                ],
            },
            colors: [ '#a5e4e4', '#7fd4d2', '#77c4e6', '#5a8fcb', '#355383'],
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: () => ''
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
                position: 'right',
                horizontalAlign: 'left',
            }
        }

        const rankChart = new ApexCharts(
            document.querySelector('#rank-chart'),
            rankChartOptions
        );

        rankChart.render();

    </script>
@endpush
