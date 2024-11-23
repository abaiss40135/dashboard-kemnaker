@extends('templates.admin-lte.admin', ['title' => 'Bhabinkamtibmas on the Hotspot'])
@section('customcss')
    @include('assets.css.datatables')
    @include('assets.css.select2')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="#" method="post" id="form-search">
                <div class="alert alert-gray">
                    <h5><i class="icon fas fa-filter"></i> Filter</h5><hr>
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label for="search">Pencarian Umum</label>
                            <input type="search" name="search" id="search" class="form-control"
                                   placeholder="cari berdasarkan judul, deskripsi, atau nama bhabinkamtibmas">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="select-provinsi">Provinsi</label>
                            <select name="provinsi" id="select-provinsi" class="form-control select2">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="select-kota">Kota</label>
                            <select name="kota" id="select-kota" class="form-control select2">
                                <option value="">Pilih provinsi terlebih dahulu</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="tanggal">Periode Pencarian</label>
                            <input type="text" class="form-control" id="tanggal">
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-warning" type="reset" onclick="resetForm()">Reset</button>
                            <button class="ml-2 btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>&nbsp;Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="datatable">
                    <thead class="text-center">
                        <tr style="background-color: #1E4588">
                            <th class="align-middle text-white">No</th>
                            <th class="align-middle text-white">Video</th>
                            <th class="align-middle text-white">Judul</th>
                            <th class="align-middle text-white">Deskripsi</th>
                            <th class="align-middle text-white">Bhabinkamtibmas</th>
                            <th class="align-middle text-white">Lokasi Penugasan</th>
                            <th class="align-middle text-white">Tanggal Unggah</th>
                            <th class="align-middle text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.datatables')
    @include('assets.js.select2')
    @include('assets.js.lazy-load')
    @include('assets.js.datetimepicker')
    <script>
        const dateData = {
            start_date: null,
            end_date: null
        }
        
        buildSelect2Search({
            placeholder: '-- Pilih Provinsi --',
            url: route('provinsi.select2'),
            minimumInputLength: 0,
            selector: [{ id: $('#select-provinsi') }],
            query: function (params) {
                return {
                    name: params.term,
                    text: 'name'
                }
            }
        });

        function buildSelect2Kota(provinsi_code) {
            buildSelect2Search({
                placeholder: '-- Pilih Kota --',
                url: route('kota.select2'),
                minimumInputLength: 0,
                selector: [{ id: $('#select-kota') } ],
                query: function (params) {
                    return {
                        name: params.term,
                        province_code: provinsi_code
                    }
                }
            });
        }

        $('#select-provinsi').on('select2:select', function (e) {
            let data = e.params.data;
            buildSelect2Kota(data.id);
        });

        document.querySelector('#form-search').addEventListener('submit', (evt) => {
            evt.preventDefault();

            bothTable();
        });

        let datatable = $('#datatable');

        function bothTable () {
            generateDataTable({
                dom: 'rtip',
                selector: datatable,
                url: route('both.datatable'),
                order: [[6, 'desc']],
                data: function (d) {
                    d.search   = $('#form-search input[name=search]').val();
                    d.provinsi = $('#form-search select[name=provinsi]').val();
                    d.kota     = $('#form-search select[name=kota]').val();
                    d.start_date = dateData.start_date;
                    d.end_date   = dateData.end_date;
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        width: '5%',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'url_file',
                        sortable: false,
                        searchable: false,
                        width: '28%',
                        render: function (data, type, row, meta) {
                            return `<video width="100%" height="100%" controls preload="metadata">
                                <source src="${data}" type="video/mp4">
                            </video>`;
                        }
                    }, {
                        data: 'judul',
                        name: 'judul',
                    }, {
                        data: 'caption',
                        name: 'caption',
                    }, {
                        data: 'penulis',
                        name: 'penulis',
                    }, {
                        data: 'lokasi_tugas',
                        searchable: false,
                        sortable: false,
                        render: function(data, type, row, meta) {
                            return data ? data.lokasi : ''
                        }
                    }, {
                        data: 'created_at',
                        name: 'created_at',
                        render: function (data, type, row, meta) {
                            return new Date(data).toLocaleString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            })
                        }
                    }, {
                        data: 'action',
                        sortable: false,
                        searchable: false,
                    }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: [0, 1, -2, -1] }
                ]
            })
        }
        bothTable()

        datatable.on('click', '.btn-delete', function() {
            let id = $(this).data('id')

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Setelah dihapus, data berikut tidak dapat dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: route('both.destroy', id),
                        success: function (data) {
                            bothTable();
                            Swal.fire('Sukses', data.message, 'success')
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                   Swal.fire('Dibatalkan','Data tidak dihapus','warning')
                }
            })
        })

        function resetForm() {
            $("#provinsi").val('').trigger('change')
        }

        $(function() {
            $("#tanggal").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2015,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            })

            $('#tanggal').daterangepicker(datetimeSetup, function (start, end, label) {
                Object.assign(dateData, {
                    start_date: start.format('YYYY-MM-DD' + ' 00:00:00'),
                    end_date: end.format('YYYY-MM-DD' + ' 23:59:59')
                });
            });
        })
    </script>
@endsection
