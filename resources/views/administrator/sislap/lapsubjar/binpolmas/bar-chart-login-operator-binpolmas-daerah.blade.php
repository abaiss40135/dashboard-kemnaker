@can('master_bhabin_chart_access')
    <div class="card" id="jumlah-bhabin">
        <div class="header">Chart Jumlah Bhabinkamtibmas
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
            <button disabled class="mt-2 mb-4 btn btn-warning d-none reset-bhabin-chart-btn">Kembali ke Tampilan Awal</button>

            <canvas id="jumlah-bhabin-chart" style="max-height: 400px"></canvas>
            <div class="text-center loader">
                <img
                    class="img-fluid"
                    alt="img-preloader"
                    src="{{asset('img/ellipsis-preloader.gif')}}"
                >
            </div>
            @can('master_bhabin_chart_show')
            <section id="download-jumlah-bhabin" class="d-none pt-2">
                <div class="d-flex justify-content-center">
                    <a
                        href="{{ route('master-bhabin.excel-list-satuan') }}"
                        class="btn btn-primary"
                    >
                        Download Jumlah Bhabinkamtibmas Per Polres
                    </a>
                </div>
            </section>
            @endcan
        </div>
    </div>
    @push('scripts')
        <script>
            const chartSelector = document.querySelector('#jumlah-bhabin #jumlah-bhabin-chart')
            const jumlahBhabinChart = chartSelector.getContext('2d')
            const resetBhabinChartBtn = document.querySelector('#jumlah-bhabin .reset-bhabin-chart-btn')

            document.querySelector('#jumlah-bhabin #download-jumlah-bhabin')?.classList.remove('d-none')
            
            function hideJumlahBhabinChartLoader() {
                document.querySelector('#jumlah-bhabin .loader').classList.add('d-none')
            }

            function showJumlahBhabinChartLoader() {
                document.querySelector('#jumlah-bhabin .loader').classList.remove('d-none')
            }

            function hideResetBhabinChartBtn() {
                resetBhabinChartBtn.classList.add('d-none')
            }

            function disableResetBhabinChartBtn() {
                resetBhabinChartBtn.setAttribute('disabled', true)
            }

            function showResetBhabinChartBtn() {
                resetBhabinChartBtn.classList.remove('d-none')
            }

            function enableResetBhabinChartBtn() {
                resetBhabinChartBtn.removeAttribute('disabled')
            }
            
            function buildChart({data, labels, label}) {
                const biggest = Math.max(...data)
                const suggestedMax = biggest * 1.1

                const chart = new Chart(jumlahBhabinChart, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: label,
                                data: data,
                                backgroundColor: "hsl(0, 10%, 10%)",
                            }
                        ]
                    },
                    plugins: [ChartDataLabels],
                    options: {
                        scales: {
                            y: {
                                suggestedMax: suggestedMax
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                font: {
                                    weight: 'bold'
                                },
                            }
                        }
                    }
                })

                const clickBarChart = click => {
                    const slice = chart.getElementsAtEventForMode(click, 'nearest', {intersect:true}, true)
    
                    if (slice.length) {
                        const label = chart.data.labels[slice[0].index]
                        
                        if (label) {
                            chart.destroy()
                            showJumlahBhabinChartLoader()
                            
                            showResetBhabinChartBtn()
                            initChartJumlahBhabinPolda(label)
                        }
                    }
                }
    
                chartSelector.onclick = clickBarChart
                resetBhabinChartBtn.onclick = resetJumlahBhabinChart
            }

            function initChartJumlahBhabin() {
                axios.get(route('master-bhabin.chart-bhabin'))
                    .then(res => res.data)
                    .then(data => {
                        hideJumlahBhabinChartLoader()
                        buildChart({data: data.data, labels: data.labels, label: 'Jumlah Bhabinkamtibmas Per Polda'})
                    })
                    .catch(err => {
                        console.error(err)
                    })
            }

            function initChartJumlahBhabinPolda(polda) {
                axios.get(route('master-bhabin.chart-bhabin-polda', {polda}))
                    .then(res => res.data)
                    .then(data => {
                        hideJumlahBhabinChartLoader()
                        buildChart({data: data.data, labels: data.labels, label: 'Jumlah Bhabinkamtibmas Per Polres'})
                        enableResetBhabinChartBtn()
                    })
                    .catch(err => {
                        console.error(err)
                    })
            }

            function resetJumlahBhabinChart () {
                let chart = Chart.getChart("jumlah-bhabin-chart");

                chart.destroy()
                showJumlahBhabinChartLoader()
                initChartJumlahBhabin()

                hideResetBhabinChartBtn()
                disableResetBhabinChartBtn()
            }

            initChartJumlahBhabin()

        </script>
    @endpush
@endcan
