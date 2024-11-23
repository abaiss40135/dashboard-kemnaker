<div class="card mt-4">
    <div class="header">Tabel Perolehan Suara Realtime Per Desa/Kelurahan
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                    onclick="angleIcon(this)">
                <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        {{--<form action="#" class="form row" id="filter-pemanfaatan">
            @csrf
            <h5 class="col-12">Cari Berdasarkan:</h5>
            <div class="form-group col-sm-6">
                <label for="nrp-p">NRP atau Nama Bhabin</label>
                <input type="text" id="nrp-p" name="nrp" class="form-control">
            </div>
            <div class="form-group col-sm-6">
                <label for="date">Alamat TPS (Provinsi/Kabupaten,Kota/Kecamatan/Kelurahan,Desa</label>
                <input type="text" name="date" id="date" class="form-control">
            </div>
            <div class="col-12 form-group w-100 d-flex justify-content-center justify-content-sm-end">
                <div>
--}}{{--                    <button class="btn btn-success btn-export-excel">--}}{{--
--}}{{--                        <i class="fa fa-file-alt"></i>&ensp;Ekspor Excel--}}{{--
--}}{{--                    </button>--}}{{--
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <hr>--}}
        <table class="table table-hover table-bordered text-center w-100" id="table-pemanfaatan">
            <thead>
            <tr style="background-color: #1E4588">
                <th class="align-middle text-white" rowspan="2">No</th>
                <th class="align-middle text-white" colspan="2">Lokasi Pemungutan Suara</th>
                <th class="align-middle text-white" rowspan="2">Suara Pasangan 01</th>
                <th class="align-middle text-white" rowspan="2">Suara Pasangan 02</th>
                <th class="align-middle text-white" rowspan="2">Suara Pasangan 03</th>
                <th class="align-middle text-white" rowspan="2">Suara Tidak Sah</th>
                <th class="align-middle text-white" rowspan="2">Tanggal Laporan Terbaru</th>
            </tr>
            <tr style="background-color: #1E4588">
                <th class="align-middle text-white">Kecamatan</th>
                <th class="align-middle text-white">Desa/Kelurahan</th>
            </tr>
            </thead>
            <tbody id="table-pemanfaatan-body">
{{--                <tr>--}}
{{--                    <td colspan="7">Belum ada Data untuk saat Ini</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>1.</td>--}}
{{--                    <td>Tlogosari Kulon</td>--}}
{{--                    <td>Kalicari</td>--}}
{{--                    <td>150</td>--}}
{{--                    <td>250</td>--}}
{{--                    <td>800</td>--}}
{{--                    <td>50</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>2.</td>--}}
{{--                    <td>Gayamsari</td>--}}
{{--                    <td>Kalicari</td>--}}
{{--                    <td>100</td>--}}
{{--                    <td>300</td>--}}
{{--                    <td>1050</td>--}}
{{--                    <td>10</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>3.</td>--}}
{{--                    <td>Palebon</td>--}}
{{--                    <td>Kalicari</td>--}}
{{--                    <td>50</td>--}}
{{--                    <td>350</td>--}}
{{--                    <td>700</td>--}}
{{--                    <td>14</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>4.</td>--}}
{{--                    <td>Pedurungan Tengah</td>--}}
{{--                    <td>Pedurungan</td>--}}
{{--                    <td>200</td>--}}
{{--                    <td>500</td>--}}
{{--                    <td>600</td>--}}
{{--                    <td>24</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>5.</td>--}}
{{--                    <td>Tlogomulyo</td>--}}
{{--                    <td>Pedurungan</td>--}}
{{--                    <td>89</td>--}}
{{--                    <td>137</td>--}}
{{--                    <td>741</td>--}}
{{--                    <td>60</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>6.</td>--}}
{{--                    <td>Cabean</td>--}}
{{--                    <td>Semarang Barat</td>--}}
{{--                    <td>60</td>--}}
{{--                    <td>340</td>--}}
{{--                    <td>872</td>--}}
{{--                    <td>51</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>7.</td>--}}
{{--                    <td>Bongsari</td>--}}
{{--                    <td>Semarang Barat</td>--}}
{{--                    <td>82</td>--}}
{{--                    <td>327</td>--}}
{{--                    <td>641</td>--}}
{{--                    <td>20</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>8.</td>--}}
{{--                    <td>Krapyak</td>--}}
{{--                    <td>Semarang Barat</td>--}}
{{--                    <td>230</td>--}}
{{--                    <td>410</td>--}}
{{--                    <td>541</td>--}}
{{--                    <td>13</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>9.</td>--}}
{{--                    <td>Tawang Mas</td>--}}
{{--                    <td>Semarang Barat</td>--}}
{{--                    <td>121</td>--}}
{{--                    <td>58</td>--}}
{{--                    <td>549</td>--}}
{{--                    <td>20</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>10.</td>--}}
{{--                    <td>Rejosari</td>--}}
{{--                    <td>Semarang Timur</td>--}}
{{--                    <td>100</td>--}}
{{--                    <td>83</td>--}}
{{--                    <td>431</td>--}}
{{--                    <td>19</td>--}}
{{--                    <td>14 Februari 2024, 13:25</td>--}}
{{--                </tr>--}}
            </tbody>
        </table>
    </div>
</div>

@push('modals')
    <div class="modal fade" id="pemanfaatanInformasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Daftar Pemanfaatan Informasi Kamtibmas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 80vh; overflow-y: scroll">
                    <div class="text-center" id="pemanfaatanInformasiLoader">
                        <img class="img-fluid" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
                    </div>
                    <div id="pemanfaatanInformasiWrapper"></div>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    @include('assets.js.select2')
    @include('assets.js.datatables')
    @include('assets.js.datetimepicker')
    <script>
        const kabupaten = $('#city')
        const kecamatan = $('#district')
        const desa = $('#village')

        function pemanfaatanInformasiTable () {
            if(kabupaten.val() !== null) {
                generateDataTable({
                    dom: 'rtip',
                    selector: $('#table-pemanfaatan'),
                    url: route('dashboard-pemungutan-suara-capres2024.datatable', {
                        kabupaten: kabupaten.val(),
                        kecamatan: kecamatan.val(),
                        desa: desa.val()
                    }),
                    order: [[6, 'desc']],
                    columns: [
                        {
                            data: null,
                            sortable: false,
                            searchable: false,
                            width: '5%',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1
                            }
                        }, {
                            data: 'kecamatan',
                            name: 'kecamatan',
                            font: {
                                textTransform: 'capitalize'
                            },
                            render: function (data, type, row, meta) {
                                return data.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                    return letter.toUpperCase()
                                })
                            }
                        }, {
                            data: 'kelurahan',
                            name: 'kelurahan',
                        }, {
                            data: 'suara_capres_1',
                            name: 'suara_capres_1',
                            render: function (data, type, row, meta) {
                                const presentaseSuaraCapres1 = Math.round((data / (row.suara_capres_1 + row.suara_capres_2 + row.suara_capres_3 + row.suara_tidak_sah)) * 100)
                                return data.toLocaleString('id-ID') + ' Suara (' + presentaseSuaraCapres1 + '%)'
                            }
                        }, {
                            data: 'suara_capres_2',
                            name: 'suara_capres_2',
                            render: function (data, type, row, meta) {
                                const presentaseSuaraCapres2 = Math.round((data / (row.suara_capres_1 + row.suara_capres_2 + row.suara_capres_3 + row.suara_tidak_sah)) * 100)
                                return data.toLocaleString('id-ID') + ' Suara (' + presentaseSuaraCapres2 + '%)'
                            }
                        }, {
                            data: 'suara_capres_3',
                            name: 'suara_capres_3',
                            render: function (data, type, row, meta) {
                                const presentaseSuaraCapres3 = Math.round((data / (row.suara_capres_1 + row.suara_capres_2 + row.suara_capres_3 + row.suara_tidak_sah)) * 100)
                                return data.toLocaleString('id-ID') + ' Suara (' + presentaseSuaraCapres3 + '%)'
                            }
                        }, {
                            data: 'suara_tidak_sah',
                            name: 'suara_tidak_sah',
                            render: function (data, type, row, meta) {
                                const presentaseSuaraTidakSah = Math.round((data / (row.suara_capres_1 + row.suara_capres_2 + row.suara_capres_3 + row.suara_tidak_sah)) * 100)
                                return data.toLocaleString('id-ID') + ' Suara (' + presentaseSuaraTidakSah + '%)'
                            }
                        }, {
                            data: 'updated_at',
                            name: 'updated_at',
                            render: function (data, type, row, meta) {
                                return new Date(data).toLocaleString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })
                            }
                        }
                    ],
                })
            } else {
                $('#table-pemanfaatan-body').html(`
                <tr>
                    <td colspan="8">Belum ada Data untuk saat Ini</td>
                </tr>
                `)
            }
        }

        $('#btn-search').on('click', function() {
            pemanfaatanInformasiTable()
        })
    </script>
@endpush
