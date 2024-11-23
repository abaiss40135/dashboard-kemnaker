@extends('templates.admin-lte.admin', ['title' => 'Dashboard Kriminal'])
@section('customcss')
    @include('assets.css.shimmer')
@endsection
@section('content')
<section id="dashboard-kriminal">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-4"><b>POLDA METRO JAYA</b></h3>
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h4><b>9</b></h4>
                            <p>Total Indikasi Individu</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h4><b>2</b></h4>
                            <p>Total Pelaku Individu</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h4><b>5</b></h4>
                            <p>Total Indikasi Kelompok</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h4><b>0</b></h4>
                            <p>Total Pelaku Kelompok</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="btn-group btn-group-toggle" data-toggle="buttons" style="min-width: 18vw">
                    <label class="btn btn-outline-primary active">
                        <input type="radio" name="options" id="opt-stats" checked> Statistik
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="options" id="opt-summ"> Rangkuman
                    </label>
                </div>
                <div style="min-width: 18vw">
                    <select name="polres_polsek" id="polres_polsek" class="form-control">
                        <option value="">-- Pilih Polres/Polsek --</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="p-2 py-1 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><b>Pekerjaan Individu</b></h5>
                        <div style="min-width: 8vw">
                            <div class="d-flex justify-content-end">
                                <select name="filter_pekerjaan" id="filter_pekerjaan" class="form-control">
                                    <option value="">-- Filter --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="pekerjaan-individu" style="height: 400px"></canvas>
                </div>
            </div>
        </div>
        <div class="p-2 py-1 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><b>Statistik Alat</b></h5>
                        <div style="min-width: 8vw">
                            <div class="d-flex justify-content-end">
                                <select name="filter_alat" id="filter_alat" class="form-control">
                                    <option value="">-- Filter --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="statistik-alat" style="height: 400px"></canvas>
                </div>
            </div>
        </div>
        <div class="p-2 py-1 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><b>Statistik Sarana</b></h5>
                        <div style="min-width: 8vw">
                            <div class="d-flex justify-content-end">
                                <select name="filter_sarana" id="filter_sarana" class="form-control">
                                    <option value="">-- Filter --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="statistik-sarana" style="height: 400px"></canvas>
                </div>
            </div>
        </div>
        <div class="p-2 py-1 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><b>Pola Waktu</b></h5>
                        <div style="min-width: 8vw">
                            <div class="d-flex justify-content-end">
                                <select name="filter_waktu" id="filter_waktu" class="form-control">
                                    <option value="">-- Filter --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="pola-waktu"></canvas>
                </div>
            </div>
        </div>
        <div class="p-2 py-1 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><b>Statistik Usia</b></h5>
                        <div style="min-width: 8vw">
                            <div class="d-flex justify-content-end">
                                <select name="filter_usia" id="filter_usia" class="form-control">
                                    <option value="">-- Filter --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="statistik-usia"></canvas>
                </div>
            </div>
        </div>
        <div class="p-2 py-1 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><b>Statistik Miras</b></h5>
                        <div style="min-width: 8vw">
                            <div class="d-flex justify-content-end">
                                <select name="filter_miras" id="filter_miras" class="form-control">
                                    <option value="">-- Filter --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="statistik-miras"></canvas>
                </div>
            </div>
        </div>
        <div class="p-2 py-1 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><b>Statistik Narkoba</b></h5>
                        <div style="min-width: 8vw">
                            <div class="d-flex justify-content-end">
                                <select name="filter_narkoba" id="filter_narkoba" class="form-control">
                                    <option value="">-- Filter --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="statistik-narkoba"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="dashboard-pol-rw">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-4" style="column-gap: 1vw">
                <div style="min-width: 18vw">
                    <input type="date" name="daterange" id="daterange" class="form-control">
                </div>
                <div style="min-width: 18vw">
                    <select name="polda" class="form-control">
                        <option value="">-- Pilih Polda --</option>
                        <option value="metro jaya">POLDA METRO JAYA</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p>Total Polisi RW</p>
                                    <h4><b>14</b></h4>
                                </div>
                                <i class="fa fa-users fa-3x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p>Kegiatan (DD MM YY - DD MM YY)</p>
                                    <h4><b>36</b></h4>
                                </div>
                                <i class="fa fa-calendar-check fa-3x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p>Index (30 Hari)</p>
                                    <h4><b>2,93</b></h4>
                                </div>
                                <i class="fa fa-list-ul fa-3x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p>Konsistensi Polda (DD MM YY - DD MM YY)</p>
                                    <h4><b>71, 43%</b></h4>
                                </div>
                                <i class="fa fa-th-list fa-3x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><b>Persentase Konsistensi (<span class="adjustable-date">DD MM YY - DD MM YY</span>)</b></h4>
                <div class="d-flex" style="column-gap: 1vw">
                    <div style="min-width: 18vw">
                        <select name="polda" class="form-control">
                            <option value="">-- Pilih Polda --</option>
                            <option value="metro jaya">POLDA METRO JAYA</option>
                        </select>
                    </div>
                    <button class="btn btn-outline-secondary">
                        <svg fill="#000000" width="22px" height="22px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.1 14.313V5.396L24.158 8.34c-2.33-2.325-5.033-3.503-8.11-3.503C9.902 4.837 4.901 9.847 4.899 16c.001 6.152 5.003 11.158 11.15 11.16 4.276 0 9.369-2.227 10.836-8.478l.028-.122h-3.23l-.022.068c-1.078 3.242-4.138 5.421-7.613 5.421a8 8 0 0 1-5.691-2.359A7.993 7.993 0 0 1 8 16.001c0-4.438 3.611-8.049 8.05-8.049 2.069 0 3.638.58 5.924 2.573l-3.792 3.789H27.1z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <canvas id="persentase-konsistensi" style="height: 400px"></canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><b>Statistik Kegiatan (<span class="adjustable-date">DD MM YY - DD MM YY</span>)</b></h4>
                <div class="d-flex" style="column-gap: 1vw">
                    <div style="min-width: 18vw">
                        <select name="polda" class="form-control">
                            <option value="">-- Pilih Polda --</option>
                            <option value="metro jaya">POLDA METRO JAYA</option>
                        </select>
                    </div>
                    <div style="min-width: 18vw">
                        <select name="kegiatan" class="form-control">
                            <option value="">-- Pilih kegiatan --</option>
                        </select>
                    </div>
                    <button class="btn btn-outline-secondary">
                        <svg fill="#000000" width="22px" height="22px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.1 14.313V5.396L24.158 8.34c-2.33-2.325-5.033-3.503-8.11-3.503C9.902 4.837 4.901 9.847 4.899 16c.001 6.152 5.003 11.158 11.15 11.16 4.276 0 9.369-2.227 10.836-8.478l.028-.122h-3.23l-.022.068c-1.078 3.242-4.138 5.421-7.613 5.421a8 8 0 0 1-5.691-2.359A7.993 7.993 0 0 1 8 16.001c0-4.438 3.611-8.049 8.05-8.049 2.069 0 3.638.58 5.924 2.573l-3.792 3.789H27.1z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <canvas id="statistik-kegiatan" style="height: 400px"></canvas>
        </div>
        <div class="card-footer">
            <span><b>Rata-Rata Harian: 6</b></span>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><b>Kategori Kerawanan Kamtibmas (<span class="adjustable-date">DD MM YY - DD MM YY</span>)</b></h4>
                <div class="d-flex" style="column-gap: 1vw">
                    <div style="min-width: 18vw">
                        <select name="polda" class="form-control">
                            <option value="">-- Pilih Polda --</option>
                            <option value="metro jaya">POLDA METRO JAYA</option>
                        </select>
                    </div>
                    <button class="btn btn-outline-secondary">
                        <svg fill="#000000" width="22px" height="22px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.1 14.313V5.396L24.158 8.34c-2.33-2.325-5.033-3.503-8.11-3.503C9.902 4.837 4.901 9.847 4.899 16c.001 6.152 5.003 11.158 11.15 11.16 4.276 0 9.369-2.227 10.836-8.478l.028-.122h-3.23l-.022.068c-1.078 3.242-4.138 5.421-7.613 5.421a8 8 0 0 1-5.691-2.359A7.993 7.993 0 0 1 8 16.001c0-4.438 3.611-8.049 8.05-8.049 2.069 0 3.638.58 5.924 2.573l-3.792 3.789H27.1z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <canvas id="kategori-kerawanan" style="height: 400px"></canvas>
        </div>
        <div class="card-footer">
            <span><b>Rata-Rata Harian: 2.83</b></span>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><b>Kegiatan Berdasarkan Jam (<span class="adjustable-date">DD MM YY - DD MM YY</span>)</b></h4>
                <div class="d-flex" style="column-gap: 1vw">
                    <div style="min-width: 18vw">
                        <select name="polda" class="form-control">
                            <option value="">-- Pilih Polda --</option>
                            <option value="metro jaya">POLDA METRO JAYA</option>
                        </select>
                    </div>
                    <button class="btn btn-outline-secondary">
                        <svg fill="#000000" width="22px" height="22px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.1 14.313V5.396L24.158 8.34c-2.33-2.325-5.033-3.503-8.11-3.503C9.902 4.837 4.901 9.847 4.899 16c.001 6.152 5.003 11.158 11.15 11.16 4.276 0 9.369-2.227 10.836-8.478l.028-.122h-3.23l-.022.068c-1.078 3.242-4.138 5.421-7.613 5.421a8 8 0 0 1-5.691-2.359A7.993 7.993 0 0 1 8 16.001c0-4.438 3.611-8.049 8.05-8.049 2.069 0 3.638.58 5.924 2.573l-3.792 3.789H27.1z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <canvas id="kegiatan-by-hour" style="height: 400px"></canvas>
        </div>
    </div>
</section>
@endsection
@section('customjs')
    <script>
        const pekerjaan = $('#pekerjaan-individu');
        const bar_chart_pekerjaan = new Chart(pekerjaan.get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Buruh', 'PNS', 'Pelajar', 'Juru Parkir'],
                datasets: [
                    {
                        data: [12, 19, 3, 5],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299',
                            '#f1f2f4'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        display: true,
                        labels: {
                            generateLabels: function(chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        var ds = data.datasets[0];
                                        var meta = chart.getDatasetMeta(0);
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        var fill = custom.backgroundColor ? custom.backgroundColor : ds.backgroundColor[i];
                                        var stroke = custom.borderColor ? custom.borderColor : 'rgba(0,0,0,0)';
                                        var bw = custom.borderWidth ? custom.borderWidth : ds.borderWidth[i];

                                        var legendItem = {
                                            text: label,
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: !chart.isDatasetVisible(0),
                                            index: i
                                        };

                                        return legendItem;
                                    });
                                }

                                return [];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false,
                        ticks: { beginAtZero: true }
                    }
                },
            }
        })

        const alat = $('#statistik-alat');
        const bar_chart_alat = new Chart(alat.get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Petasan', 'Air Soft Gun', 'Panah', 'Tidak Menggunakan Alat', 'Senapan Angin', 'Senjata Tajam'],
                datasets: [
                    {
                        data: [2, 5, 1, 6, 1, 1],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299',
                            '#f1f2f4',
                            '#93d8d8',
                            '#c2d6e1'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        display: true,
                        labels: {
                            generateLabels: function(chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        var ds = data.datasets[0];
                                        var meta = chart.getDatasetMeta(0);
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        var fill = custom.backgroundColor ? custom.backgroundColor : ds.backgroundColor[i];
                                        var stroke = custom.borderColor ? custom.borderColor : 'rgba(0,0,0,0)';
                                        var bw = custom.borderWidth ? custom.borderWidth : ds.borderWidth[i];

                                        var legendItem = {
                                            text: label,
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: !chart.isDatasetVisible(0),
                                            index: i
                                        };

                                        return legendItem;
                                    });
                                }

                                return [];
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: false,
                        ticks: { beginAtZero: true }
                    }
                },
            }
        })

        const sarana = $('#statistik-sarana');
        const bar_chart_sarana = new Chart(sarana.get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Roda 2 Sah', 'Tidak Menggunakan Sarana', 'Roda 3 Tidak Memiliki Surat Sah', 'Roda 3 Sah', 'Roda 2 Tidak Memiliki Surat Sah'],
                datasets: [
                    {
                        data: [3, 5, 6, 1, 1],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299',
                            '#f1f2f4',
                            '#93d8d8',
                            '#c2d6e1'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        display: true,
                        labels: {
                            generateLabels: function(chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        var ds = data.datasets[0];
                                        var meta = chart.getDatasetMeta(0);
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        var fill = custom.backgroundColor ? custom.backgroundColor : ds.backgroundColor[i];
                                        var stroke = custom.borderColor ? custom.borderColor : 'rgba(0,0,0,0)';
                                        var bw = custom.borderWidth ? custom.borderWidth : ds.borderWidth[i];

                                        var legendItem = {
                                            text: label,
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: !chart.isDatasetVisible(0),
                                            index: i
                                        };

                                        return legendItem;
                                    });
                                }

                                return [];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: false,
                        ticks: { beginAtZero: true }
                    }
                },
            }
        })

        const pola_waktu = $('#pola-waktu');
        const doughnut_chart_waktu = new Chart(pola_waktu.get(0).getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['12:00 - 14:00', '00:00 - 02:00', '16:00 - 18:00', '08:00 - 10:00', '14:00 - 16:00', '18:00 - 20:00', '06:00 - 08:00', '10:00 - 12:00'],
                datasets: [
                    {
                        data: [2, 5, 1, 3, 2, 1, 1, 1],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299',
                            '#f1f2f4',
                            '#93d8d8',
                            '#c2d6e1',
                            '#d4b5b0',
                            '#c2d6e1'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                    },
                },
            }
        })

        const statistik_usia = $('#statistik-usia');
        const doughnut_chart_usia = new Chart(statistik_usia.get(0).getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['<= 10', '11 - 15', '16 - 20', '21 - 25', '26 - 30', '31+'],
                datasets: [
                    {
                        data: [3, 1, 1, 1, 2, 5],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299',
                            '#f1f2f4',
                            '#93d8d8',
                            '#c2d6e1'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                    },
                },
            }
        })

        const statistik_miras = $('#statistik-miras');
        const doughnut_chart_miras = new Chart(statistik_miras.get(0).getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Tidak Menggunakan Miras', 'Menggunakan Miras'],
                datasets: [
                    {
                        data: [9, 7],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                    },
                },
            }
        })

        const statistik_narkoba = $('#statistik-narkoba');
        const doughnut_chart_narkoba = new Chart(statistik_narkoba.get(0).getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Tidak Menggunakan Narkoba', 'Menggunakan Narkoba'],
                datasets: [
                    {
                        data: [16, 7],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                    },
                },
            }
        })

        const persentase_konsistensi = $('#persentase-konsistensi');
        const bar_chart_konsistensi = new Chart(persentase_konsistensi.get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['POLSEK PANCORAN MAS', 'POLSEK BEJI', 'POLSEK SUKMAJAYA'],
                datasets: [
                    {
                        data: [80, 0, 20],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            generateLabels: function(chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        var ds = data.datasets[0];
                                        var meta = chart.getDatasetMeta(0);
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        var fill = custom.backgroundColor ? custom.backgroundColor : ds.backgroundColor[i];
                                        var stroke = custom.borderColor ? custom.borderColor : 'rgba(0,0,0,0)';
                                        var bw = custom.borderWidth ? custom.borderWidth : ds.borderWidth[i];

                                        var legendItem = {
                                            text: label,
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: !chart.isDatasetVisible(0),
                                            index: i
                                        };

                                        return legendItem;
                                    });
                                }

                                return [];
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return value + '%';
                            }
                        },
                    }
                }
            }
        })

        const statistik_kegiatan = $('#statistik-kegiatan');
        const bar_chart_kegiatan = new Chart(statistik_kegiatan.get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['POLSEK BABELAN', 'POLSEK CENGKARENG', 'POLSEK PANCORAN MAS', 'POLSEK CAKUNG', 'POLSEK BATUCEPER', 'POLSEK JATINEGARA', 'POLSEK TAMBORA'],
                datasets: [
                    {
                        data: [4, 4, 16, 4, 2, 3, 3],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299',
                            '#f1f2f4',
                            '#93d8d8',
                            '#c2d6e1',
                            '#f1f2f4'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            generateLabels: function(chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        var ds = data.datasets[0];
                                        var meta = chart.getDatasetMeta(0);
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        var fill = custom.backgroundColor ? custom.backgroundColor : ds.backgroundColor[i];
                                        var stroke = custom.borderColor ? custom.borderColor : 'rgba(0,0,0,0)';
                                        var bw = custom.borderWidth ? custom.borderWidth : ds.borderWidth[i];

                                        var legendItem = {
                                            text: label,
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: !chart.isDatasetVisible(0),
                                            index: i
                                        };

                                        return legendItem;
                                    });
                                }

                                return [];
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: true,
                        ticks: {
                            beginAtZero: true,
                        },
                    }
                }
            }
        })

        const kategori_kerawanan = $('#kategori-kerawanan');
        const bar_chart_kerawanan = new Chart(kategori_kerawanan.get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Kebakaran', 'Pencurian', 'Kecelakaan Lalin', 'Balapan Liar', 'Narkoba', 'Kekerasan', 'KDRT'],
                datasets: [
                    {
                        data: [4, 4, 2, 3, 1, 2, 1],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299',
                            '#f1f2f4',
                            '#93d8d8',
                            '#c2d6e1',
                            '#f1f2f4'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            generateLabels: function(chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        var ds = data.datasets[0];
                                        var meta = chart.getDatasetMeta(0);
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        var fill = custom.backgroundColor ? custom.backgroundColor : ds.backgroundColor[i];
                                        var stroke = custom.borderColor ? custom.borderColor : 'rgba(0,0,0,0)';
                                        var bw = custom.borderWidth ? custom.borderWidth : ds.borderWidth[i];

                                        var legendItem = {
                                            text: label,
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: !chart.isDatasetVisible(0),
                                            index: i
                                        };

                                        return legendItem;
                                    });
                                }

                                return [];
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: true,
                        ticks: {
                            beginAtZero: true,
                        },
                    }
                }
            }
        })

        const kegiatan_by_hour = $('#kegiatan-by-hour');
        const bar_chart_kegiatan_by_hour = new Chart(kegiatan_by_hour.get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['09:00', '07:00', '11:00', '06:00', '12:00', '10:00', '05:00', '04:00', '13:00', '08:00', '18:00', '03:00', '15:00', '21:00', '17:00', '16:00'],
                datasets: [
                    {
                        data: [2, 1, 9, 3, 8, 1, 2, 1, 1, 1, 1, 1, 1, 1, 2, 1],
                        backgroundColor: [
                            '#fea1b4',
                            '#85c8f2',
                            '#fee299',
                            '#f1f2f4',
                            '#93d8d8',
                            '#c2d6e1',
                            '#eaeaea',
                            '#fb9093',
                            '#8cd8da',
                            '#fed29d',
                            '#bec5d1',
                            '#9498a1',
                            '#b37674',
                            '#cbc4c9',
                            '#6b6cca',
                            '#b8d290',
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            generateLabels: function(chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        var ds = data.datasets[0];
                                        var meta = chart.getDatasetMeta(0);
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        var fill = custom.backgroundColor ? custom.backgroundColor : ds.backgroundColor[i];
                                        var stroke = custom.borderColor ? custom.borderColor : 'rgba(0,0,0,0)';
                                        var bw = custom.borderWidth ? custom.borderWidth : ds.borderWidth[i];

                                        var legendItem = {
                                            text: label,
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: !chart.isDatasetVisible(0),
                                            index: i
                                        };

                                        return legendItem;
                                    });
                                }

                                return [];
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: true,
                        ticks: {
                            beginAtZero: true,
                        },
                    }
                }
            }
        })
    </script>
@endsection