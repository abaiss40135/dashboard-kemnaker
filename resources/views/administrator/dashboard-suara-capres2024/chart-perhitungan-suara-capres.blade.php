@can('master_bhabin_chart_access')
    <div class="card">
        <div class="header"><span class="tambahan-header-filter-based">Chart Akumulasi Suara Realtime Pilpres 2024 </span>
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
            <div class="container-chart-pie">
                <canvas id="chart-pie" style="max-height: 620px"></canvas>
            </div>
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
            const chartBhabinLogin = document.querySelector('#chart-pie')

            async function requestDataChart() {
                const dataToSend = {
                    provinsi: $('#province').val(),
                    kota: $('#city').val(),
                    kecamatan: $('#district').val(),
                    desa: $('#village').val()
                }
                const queryString = new URLSearchParams(dataToSend).toString();

                const url = route('dashboard-pemungutan-suara-capres2024.akumulasi-nasional') + '?' + queryString;

                const request = await fetch(url)
                const data = await request.json()

                return data
            }

            async function initChartLogin(data) {
                new Chart($('#chart-pie').get(0).getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Pasangan 01 (Anies - Muhaimin)','Pasangan 02 (Prabowo - Gibran)', 'Pasangan 03 (Ganjar - Mahfud)', 'Suara Tidak Sah'],
                        datasets: [{
                            data: [data.total_suara_01, data.total_suara_02, data.total_suara_03, data.total_suara_tidak_sah],
                            backgroundColor: ['#292964', '#fccf00', '#d82028', 'gray'],
                        }]
                    },
                    plugins: [ChartDataLabels],
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        let label = data.labels[tooltipItem.index] || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                        value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Mengganti koma dengan titik
                                        label += value;
                                        return label;
                                    }
                                }
                            },
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
                                textAlign: 'center',
                                formatter: function(value, context) {
                                    if(value === 0) return ''
                                    const argument = (context.dataIndex + 1) === 4 ? 'tidak_sah' : '0' + (context.dataIndex + 1)
                                    return value.toLocaleString('id-ID') + ' Suara\n' + `(${data['persentase_suara_' + argument].slice(0,4)}%)`;
                                },
                                font: {
                                    weight: 'bold',
                                },
                                color: 'white',
                            },
                        }
                    }
                })
            }

            function initTextInfo(data) {
                const jumlahBhabin = document.createElement('div')
                jumlahBhabin.classList.add('mt-3', 'text-bold', 'text-center')
                jumlahBhabin.innerHTML = (
                    `<p class="mb-0">Jumlah Total Suara: ${data.total_semua_suara.toLocaleString('id-ID')} Suara</p>
                    <p class="mb-0" style="color: #292964">
                        Pasangan 01 (Anies Baswedan & Muhaimin Iskandar): ${data.total_suara_01.toLocaleString('id-ID')} Suara (${data.persentase_suara_01}%)
                    </p>
                    <p class="mb-0" style="color: #fccf00">
                        Pasangan 02 (Prabowo Subianto & Gibran Rakabuming Raka): ${data.total_suara_02.toLocaleString('id-ID')} Suara (${data.persentase_suara_02}%)
                    </p>
                    <p class="mb-0" style="color: #d82028">
                        Pasangan 03 (Ganjar Pranowo & Mahfud MD): ${data.total_suara_03.toLocaleString('id-ID')} Suara (${data.persentase_suara_03}%)
                    </p>
                    <p class="mb-0" style="color: gray">
                        Suara Tidak Sah: ${data.total_suara_tidak_sah.toLocaleString('id-ID')} Suara (${data.persentase_suara_tidak_sah}%)
                    </p>
                `
                )
                // chartBhabinLogin.parentNode.insertBefore(jumlahBhabin, chartBhabinLogin.nextSibling)
                document.querySelector('.container-chart-pie').appendChild(jumlahBhabin)
            };


            document.addEventListener('DOMContentLoaded', async () => {
                const data = await requestDataChart()
                document.querySelector('.preloader').classList.add('d-none')

                initChartLogin(data)
                initTextInfo(data)

            })

            const initChart = () => {
                const newCanvas = document.createElement('canvas')
                newCanvas.id = 'chart-pie'
                newCanvas.style.maxHeight = '620px'
                document.querySelector('.container-chart-pie').appendChild(newCanvas)
            }

            const changeHeader = () => {
                $('.tambahan-header-filter-based').empty()
                const province = $('#province').val()
                const city = $('#city').val()
                const district = $('#district').val()
                const village = $('#village').val()

                const provinceName = $('#province option:selected').text()
                const cityName = $('#city option:selected').text()
                const districtName = $('#district option:selected').text()
                const villageName = $('#village option:selected').text()

                if(village) {
                    $('.tambahan-header-filter-based').append(`Chart Akumulasi Suara Realtime Pilpres 2024 - Provinsi: ${provinceName}, Kota/Kabupaten: ${cityName}, Kecamatan: ${districtName}, Desa: ${villageName}`)
                }else if(district) {
                    $('.tambahan-header-filter-based').append(`Chart Akumulasi Suara Realtime Pilpres 2024 - Provinsi: ${provinceName}, Kota/Kabupaten: ${cityName}, Kecamatan: ${districtName}`)
                } else if(city) {
                    $('.tambahan-header-filter-based').append(`Chart Akumulasi Suara Realtime Pilpres 2024 - Provinsi: ${provinceName}, Kota/Kabupaten: ${cityName}`)
                } else if(province) {
                    $('.tambahan-header-filter-based').append(`Chart Akumulasi Suara Realtime Pilpres 2024 - Provinsi: ${provinceName}`)
                }
            }

            $('#btn-search').on('click', async function() {
                // destroy chart
                $('.container-chart-pie').empty()
                initChart()
                changeHeader()

                document.querySelector('.preloader').classList.remove('d-none')

                const data = await requestDataChart()

                document.querySelector('.preloader').classList.add('d-none')
                initChartLogin(data)
                initTextInfo(data)
            })
        </script>
    @endpush
@endcan
