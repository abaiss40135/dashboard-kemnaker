<div class="card">
    <div class="header">Rekapitulasi Operator Binpolmas Sudah Login Perdaerah
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
        <canvas id="chart-rekapitulasi-1" style="max-height: 450px"></canvas>
        <canvas id="chart-rekapitulasi-2" style="max-height: 450px"></canvas>
        <div class="text-center preloader">
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
        function initBarChart(rekapitulasi, listPolda, charElement) {
            new Chart(charElement.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: listPolda,
                    datasets: [
                        {
                            label: 'jumlah operator binpolmas',
                            data: rekapitulasi[0],
                            backgroundColor: "hsl(0, 10%, 10%)",
                        }, {
                            label: 'operator binpolmas sudah login',
                            data: rekapitulasi[1],
                            backgroundColor: "hsl(0, 75%, 50%)",
                        }
                    ]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    onClick: function(e) {
                        const canvasPosition = Chart.helpers.getRelativePosition(e, this);

                        // Mendapatkan data point yang diklik
                        const dataPoint = this.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);

                        if (dataPoint.length) {
                            const index = dataPoint[0].index;
                            const datasetIndex = dataPoint[0].datasetIndex;

                            // Misalnya, menampilkan alert dengan info dari data point yang diklik
                            const label = this.data.labels[index];

                            // redirect
                            window.location.href = route('perubahan-jumlah-bhabinkamtibmas.admin-view', { polda: label });
                        }
                    }
                },
            })
        }

        function initChartOperatorBinpolmas(data) {
            const chartEl1 = document.querySelector('#chart-rekapitulasi-1')
            const chartEl2 = document.querySelector('#chart-rekapitulasi-2')

            initBarChart(data.rekapitulasi[0], data.listPolda.slice(0, 17), chartEl1)
            initBarChart(data.rekapitulasi[1], data.listPolda.slice(17), chartEl2)
        }
    </script>
@endpush
