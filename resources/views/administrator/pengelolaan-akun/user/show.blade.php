@extends('templates.admin-lte.admin', ['title' => 'Detail Akun'])
@section('customcss')
    @include('assets.css.pagination-responsive')
    @include('assets.css.datatables')
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Profil</h3>
            <div class="card-tools">
                <div class="btn-group">
                </div>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($user->nrp)
                <x-admin.pengelolaan-akun.profile.personel :user="$user" :hak-akses="$hak_akses"/>
            @elseif($user->haveRole('satpam'))
                @include('components.admin.pengelolaan-akun.profile.satpam')
            @elseif($user->haveRole('publik'))
                @include('components.admin.pengelolaan-akun.profile.publik')
            @elseif($user->haveRole('bujp'))
                @include('components.admin.pengelolaan-akun.profile.bujp')
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Login</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-hover table-bordered text-center w-100" id="log-login-table">
                            <thead>
                            <th>No</th>
                            <th>Perangkat</th>
                            <th>Browser</th>
                            <th>Hari, tanggal</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Perubahan</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-hover table-bordered text-center w-100" id="log-mutasi-table">
                            <thead>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Hari, tanggal</th>
                            <th>Pengubah</th>
                            <th>Status</th>
                            <th>Action</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('customjs')
    @include('assets.js.datatables')
    <script>
        const validasiMutasi = (id, isApprove, message = '') => {
            $.ajax({
                url: route('mutasi-user.update', {mutasi_user: id}),
                type: 'PATCH',
                data: {
                    is_approve: isApprove,
                    note: message,
                    approver: "{{ auth()->user()->id }}"
                },
                success: function (resp) {
                    if(resp.status === 'success') {
                        swalSuccess(resp.message);
                    } else {
                        swalError(resp.message);
                    }
                },
                error: function (err) {
                    swalError(err.responseJSON.message);
                },
                complete: function () {
                    tableMutasi();
                }
            })
            return false;
        }

        const tableMutasi = () => {
            generateDataTable({
                selector: $('#log-mutasi-table'),
                url: route('mutasi-user.index', {user_id: {{ $user->id }}}),
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
                        data: 'mutasi', name: 'mutasi', render: function (data) {
                            return data ? 'Mutasi' : 'Pembaruan Hak Akses';
                        }
                    },
                    {data: 'desc', searchable: false},
                    {data: 'created_at', searchable: false},
                    {data: 'pengubah', searchable: false},
                    {data: 'status', searchable: false},
                    {
                        data: 'action',
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
                    $("[data-toggle=popover]").popover();
                    $('.btn-reject').click(function () {
                        let id = $(this).data('id');
                        Swal.fire({
                            input: 'textarea',
                            inputLabel: 'Catatan',
                            inputPlaceholder: 'Masukkan catatan penolakan',
                            inputAttributes: {
                                autocapitalize: 'off',
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            showLoaderOnConfirm: true,
                            preConfirm: function (message) {
                                validasiMutasi(id, false, message);
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed) {

                            }
                        });
                    });
                    $('.btn-approve').click(function () {
                        let id = $(this).data('id');
                        //Swal.fire confirm
                        Swal.fire({
                            title: 'Apakah anda yakin?',
                            text: "Anda tidak akan bisa mengembalikan ini!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, simpan!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                validasiMutasi(id, true);
                            }
                        });
                    });
                }
            })
        }

        $(document).ready(function () {
            tableMutasi();
            generateDataTable({
                selector: $('#log-login-table'),
                url: route('riwayat-login.index', {user_id: {{ $user->id }}}),
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
                        data: 'platform',
                        name: 'platform',
                        width: '20%'
                    },
                    {
                        data: 'browser',
                        name: 'browser',
                        width: '20%'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        width: '20%'
                    },
                ],
                columnDefs: [
                    {className: 'text-center', targets: [0, -1, -2]},
                    {responsivePriority: 1, targets: 1},
                    {responsivePriority: 2, targets: -1},
                ]
            });
        });
    </script>
@endsection
