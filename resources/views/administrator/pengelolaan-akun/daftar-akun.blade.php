@extends('templates.admin-lte.admin', ['title' => 'Daftar Akun'])
@section('customcss')
    @include('assets.css.datetimepicker')
    @include('assets.css.select2')
    @include('assets.css.datatables')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            @if(session("message"))
                <div class="alert alert-danger" role="alert">
                    {{ session("message") }}
                </div>
            @endif
            <form id="form-search" action="{{ route('user.export') }}" method="POST"
                  onsubmit="disableSubmitButtonTemporarily(this)" >
                @csrf
                <input type="hidden" name="start_date">
                <input type="hidden" name="end_date">
                <div class="alert alert-gray">
                    <h5><i class="icon fas fa-filter"></i> Filter</h5>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label for="last-login">NRP/Email:</label>
                            <input type="text" id="username" name="username"
                                    aria-label="global-search"
                                    placeholder="NRP/Email"
                                    class="form-control">
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="select-hak-akses">Hak Akses:</label>
                                <select id="select-hak-akses" name="role"
                                        class="select2 w-100">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="select-status">Status:</label>
                                <select id="select-status" name="is_aktif"
                                        class="select2 w-100">
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Nonaktif (Mutasi/Pensiun)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="last-login">Login Terakhir:</label>
                                <input type="text" id="last-login"
                                        class="form-control">
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-end justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-file"></i> Ekspor
                                </button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <button type="button" id="btn-search" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover table-bordered w-100" id="table-user">
                    <thead>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>NRP/Email</th>
                        <th>Pangkat</th>
                        <th>Satuan</th>
                        <th>Jabatan</th>
                        <th>Login Terakhir</th>
                        <th>Hak Akses</th>
                        <th>Action</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.datetimepicker')
    @include('assets.js.select2')
    @include('assets.js.datatables')
    <script>
        const formFilter = $('#form-search');

        $('#last-login').daterangepicker(datetimeSetup, function (start, end) {
            formFilter.find('input[name="start_date"]').val(start.format('YYYY-MM-DD'));
            formFilter.find('input[name="end_date"]').val(end.format('YYYY-MM-DD'));
        });

        formFilter.on('reset', function () {
            formFilter.find("input[name='start_date'], input[name='end_date']").val('');
            formFilter.find("input[type=text], textarea, input[type=number], input[type=password], input[type=file]").val('');
            formFilter.find(".select2").val(null).trigger('change');
        });

        function userTable() {
            generateDataTable({
                dom: 'lrtip',
                selector: $('#table-user'),
                url: route('user.datatable'),
                data: function (data) {
                    formFilter.serializeArray().map((item) => {
                        data[item.name] = item.value;
                    })
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        width: '4%'
                    },
                    {
                        data: 'nama',
                        searchable: false,
                    },
                    {
                        data: 'username',
                        searchable: false,
                    },
                    {
                        data: 'pangkat',
                        searchable: false,
                    },
                    {
                        data: 'polda',
                        searchable: false,
                    },
                    {
                        data: 'jabatan',
                        searchable: false,
                    },
                    {
                        data: 'last_login',
                        searchable: false
                    },
                    {
                        data: 'hak_akses',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '14%',
                        sortable: false,
                        searchable: false,
                    }
                ],
                columnDefs: [
                    {className: 'text-center', targets: [0, -1, -2]},
                    {responsivePriority: 1, targets: 1},
                    {responsivePriority: 2, targets: -1},
                ],
                initComplete: function (settings, json) {

                }
            })
        }

        document.getElementById('btn-search').addEventListener('click', function () {
            userTable();
        });

        (function () {
            buildSelect2Search({
                placeholder: '-- Pilih Hak Akses --',
                url: route('role.select2'),
                minimumInputLength: 0,
                selector: [
                    {
                        id: $('#select-hak-akses')
                    }
                ],
                query: function (params) {
                    return {
                        id: 'name',
                        alias: params.term
                    }
                }
            });

            $('#select-status').select2({
                theme: 'bootstrap-5',
                minimumResultsForSearch: Infinity,
            });

            userTable();
        })();
    </script>
@endsection
