@extends('templates.core.main')

@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/bhabin/index.css') }}">
    @include('assets.css.datatables')
@endsection

@section('mainComponent')
    <main class="bg-white container p-4" style="margin-top: 6rem; margin-bottom: 1rem;">
        <div class="@if($countLaporan <= 0 ) d-none @endif">
            <h4 class="text-center">Riwayat Pelaksanaan Laporan Masyarakat</h4>
            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered text-center" id="table-laporan-publik" style="border-color: #1E4588">
                    <thead style="background-color: #1E4588; color: white;">
                        <tr>
                            <th>No</th>
                            <th>Provinsi</th>
                            <th>Tanggal Mendapatkan Informasi</th>
                            <th>Uraian</th>
                             <th>Keyword</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="my-5 text-center @if(!$countLaporan <= 0 ) d-none @endif">
                <h5 style="color: #aaa">Belum pernah menambahkan Laporan Masyarakat<br>Klik tombol<b> + Tambah Laporan</b> untuk menambahkan laporan</h5>
                <div class="mt-5">
                    <a href="{{ route('laporan-publik.create') }}" class="btn btn-sm text-white ml-auto"
                        style="background-color:#1E4588; width: fit-content; margin-left: auto">
                        <i class="fa fa-plus"></i> Buat Laporan
                    </a>
                </div>
        </div>
    </main>
@endsection
@section('customjs')
    @include('assets.js.datatables')
    <script>
        $(function () {
            let selectorTable = $('#table-laporan-publik');
            selectorTable.on('click', '.btn-delete', function () {
                let deteksiDiniId = $(this).data("id");
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
                            data : {
                                '_token' : '{{ csrf_token() }}'
                            },
                            url: route('laporan-publik.destroy', deteksiDiniId),
                            success: function (data) {
                                location.reload()
                            },
                            fail: function(data){
                                location.reload()
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalCancel('Data anda aman, proses hapus dibatalkan');
                    }
                })
            });

            tableDeteksiDini();
            function tableDeteksiDini() {
                generateDataTable({
                    selector: selectorTable,
                    url: route('laporan-publik.datatable'),
                    columns: [
                        {
                            data: null,
                            sortable: false,
                            searchable: false,
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'provinsi',
                            name: 'provinsi',
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal',
                        },
                        {
                            width: '40%',
                            data: 'laporan_informasi.uraian',
                            name: 'laporan_informasi.uraian',
                        },
                        {
                            data: 'keyword',
                            name: 'keyword',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            sortable: false,
                            searchable: false,
                        }
                    ],
                    columnDefs: [
                        {className: 'text-center', targets: [0, -1]},
                        { responsivePriority: 1, targets: 1 },
                        { responsivePriority: 2, targets: -1 },
                    ],
                    initComplete: function( settings, json ) {
                        let selector = $('.dataTables_length');

                        selector.html(`<a href="{{ route('laporan-publik.create') }}" class="btn btn-sm btn-primary text-white">
                            Tambah Laporan</a>`);

                        $('.dataTables_filter').addClass('mt-2 mt-md-0')
                    }
                });
            }
        });
    </script>
@endsection
