@extends('templates.admin.main')

@section('customcss')
    @include('assets.css.datatables')
    @include('assets.css.select2')
    <style>
        .loader-container {
            background-color: rgb(170, 170, 170);
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 5;
            opacity: .5;
            display: none;
        }

        .spinner-grow {
            position: fixed;
            top: 50%;
            left: 50%;
            z-index: 10;
        }

        /* input label */
        .inputLabel {
            background: #30589A;
            color: #fff;
            height: fit-content;
            width: fit-content;
            padding: 6px 20px;
            white-space: nowrap;
            margin-bottom: 0;
        }

        input[type='file'] {
            display: none;
        }

        /* no data */
        #no_data {
            font-weight: 500;
            font-size: 23px;
            color: rgb(185, 185, 185)
        }
    </style>
@endsection

@section('loader')
    <div class="spinner-container text-primary d-none" id="loader">
        <div class="spinner-grow" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@endsection

@section('mainComponent')

    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @component('components.admin.content-header')
                @slot('title', 'Kata Kunci Informasi')
            @endcomponent
            <section class="content">
                <div class="container-fluid">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="table-keyword-laporan">
                                    <thead class="text-center">
                                    <tr style="background: #1E4588; color:#fff">
                                        <th>No</th>
                                        <th>Keyword</th>
                                        <th>Jumlah Digunakan</th>
                                        <th>Validasi</th>
                                        <th>{{ __('locale.Action') }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>


@endsection

@section('customjs')
    @include('assets.js.datatables')
    @include('assets.js.select2')
    @include('assets.js.lazy-load')
    <script>
        let table = $('#table-keyword-laporan');

        const validateData = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Setelah divalidkan, keyword berikut akan ditampilkan kembali di pilihan kata kunci dan trending dashboard kamtibmas",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        data: {
                            is_valid: 1,
                            _method: "PATCH"
                        },
                        url: route('dashboard.keyword-laporan.update', {
                            keyword_laporan: id
                        }),
                        success: function (data) {
                            tableKeywordLaporan();
                            swalSuccess(data.message)
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalCancel('Data anda aman, proses valiasi dibatalkan');
                }
            })
        }

        const deleteData = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Setelah ditandai tidak valid, keyword berikut tidak akan ditampilkan di pilihan kata kunci dan trending dashboard kamtibmas",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        data: {
                            is_valid: 0,
                            _method: "PATCH"
                        },
                        url: route('dashboard.keyword-laporan.update', {
                            keyword_laporan: id
                        }),
                        success: function (data) {
                            tableKeywordLaporan();
                            swalSuccess(data.message)
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalCancel('Data anda aman, proses hapus dibatalkan');
                }
            })
        }

        function tableKeywordLaporan() {
            generateDataTable({
                selector: table,
                url: route('dashboard.keyword-laporan.datatable'),
                columns: [
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        width: '3%',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'keyword',
                        name: 'keyword'
                    },
                    {
                        data: 'jumlah',
                        searchable: 'false'
                    },
                    {
                        data: 'is_valid',
                        width: '15%',
                        sortable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        sortable: false,
                        searchable: false,
                        width: '6%'
                    }
                ],
                columnDefs: [
                    {className: 'text-center', targets: [0, -2, -1]},
                    {responsivePriority: 1, targets: 1},
                    {responsivePriority: 2, targets: -1},
                ],
                initComplete: function (settings, json) {

                }
            });
        }

        $(function () {
            tableKeywordLaporan();
            table.on('click', '.btn-validasi', function () {
                validateData(this.dataset.id)
            })
            table.on('click', '.btn-delete', function () {
                deleteData(this.dataset.id)
            })
        })
    </script>
@endsection
