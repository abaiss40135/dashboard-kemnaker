@extends('templates.admin.main')
@section('customcss')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.select2')
@endsection
@section('mainComponent')
<div class="wrapper">
    <div class="content-wrapper">
        @component('components.admin.content-header')
            @slot('title', 'Laporan Harian Tracing dan Kontak Erat')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('laphar-tracing.template-excel'))
                        @slot('import_excel', route('laphar-tracing.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Hasil Pelaksanaan Tracing Pasien Covid-19 dan Kontak Erat </b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('laphar-tracing.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                              @foreach ($laporan[0] as $key => $item)
                                                    @if($key > 2)
                                                        <div class="mb-3">
                                                            <span class="d-flex justify-content-between align-items-center bg-olive text-white p-3"
                                                                data-target="#collapse{{ $key }}"
                                                                aria-controls="collapse{{ $key }}" data-toggle="collapse"
                                                                aria-expanded="false" type="button" onclick="angleIcon(this)">
                                                                <h5 class="mb-0">{{ $item[0] }}</h5>
                                                                <i class="fas fa-angle-right d-flex"></i>
                                                            </span>
                                                            <div id="collapse{{ $key }}" class="row mt-3 collapse show">
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][nama_polres]">Nama Polres</label>
                                                                    <input type="text" name="laporan[{{ $key }}][nama_polres]"
                                                                        id="laporan[{{ $key }}][nama_polres]"
                                                                        class="form-control" value="{{ $item[1] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][jumlah_pasien]">Jumlah Pasien</label>
                                                                    <input type="text" name="laporan[{{ $key }}][jumlah_pasien]"
                                                                        id="laporan[{{ $key }}][jumlah_pasien]"
                                                                        class="form-control" value="{{ $item[2] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_pasien_sudah_sembuh]">Tracing Pasien Sudah Sembuh</label>
                                                                    <input type="text" name="laporan[{{ $key }}][tracing_pasien_sudah_sembuh]"
                                                                        id="laporan[{{ $key }}][tracing_pasien_sudah_sembuh]"
                                                                        class="form-control" value="{{ $item[3] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_pasien_sudah_md]">Tracing Pasien Sudah MD</label>
                                                                    <input type="text" name="laporan[{{ $key }}][tracing_pasien_sudah_md]"
                                                                        id="laporan[{{ $key }}][tracing_pasien_sudah_md]"
                                                                        class="form-control" value="{{ $item[4] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_pasien_tanpa_alamat]">Tracing Pasien Tanpa Alamat dan No Telpon</label>
                                                                    <input type="text" name="laporan[{{ $key }}][tracing_pasien_tanpa_alamat]"
                                                                        id="laporan[{{ $key }}][tracing_pasien_tanpa_alamat]"
                                                                        class="form-control" value="{{ $item[5] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_pasien_domisi_luar_daerah]">Tracing Pasien Domisi Luar Daerah</label>
                                                                    <input type="text" name="laporan[{{ $key }}][tracing_pasien_domisi_luar_daerah]"
                                                                    id="laporan[{{ $key }}][tracing_pasien_domisi_luar_daerah]"
                                                                    class="form-control" value="{{ $item[6] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_pasien_isoman]">Tracing Pasien Isoman</label>
                                                                    <input type="text" name="laporan[{{ $key }}][tracing_pasien_isoman]"
                                                                        id="laporan[{{ $key }}][tracing_pasien_isoman]"
                                                                        class="form-control" value="{{ $item[7] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_pasien_isoter]">Tracing Pasien Isoter</label>
                                                                    <input type="text" name="laporan[{{ $key }}][tracing_pasien_isoter]"
                                                                        id="laporan[{{ $key }}][tracing_pasien_isoter]"
                                                                        class="form-control" value="{{ $item[8] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_pasien_rawat_inap]">Tracing Pasien Rawat Inap</label>
                                                                    <input type="text" name="laporan[{{ $key }}][tracing_pasien_rawat_inap]"
                                                                    id="laporan[{{ $key }}][tracing_pasien_rawat_inap]"
                                                                    class="form-control" value="{{ $item[9] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][jumlah_kontak_erat]">Jumlah Kontak Erat Pasien yang Bisa Di Tracing</label>
                                                                    <input type="text" name="laporan[{{ $key }}][jumlah_kontak_erat]"
                                                                    id="laporan[{{ $key }}][jumlah_kontak_erat]"
                                                                    class="form-control" value="{{ $item[10] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_kontak_erat_sehat]">Tracing Kontak Erat Sehat</label>
                                                                    <input type="number" name="laporan[{{ $key }}][tracing_kontak_erat_sehat]"
                                                                    id="laporan[{{ $key }}][tracing_kontak_erat_sehat]"
                                                                    class="form-control" value="{{ $item[11] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_kontak_erat_isoman]">Tracing Kontak Erat Sehat Isoman</label>
                                                                    <input type="number" name="laporan[{{ $key }}][tracing_kontak_erat_isoman]"
                                                                    id="laporan[{{ $key }}][tracing_kontak_erat_isoman]"
                                                                    class="form-control" value="{{ $item[12] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_kontak_erat_isoter]">Tracing Kontak Erat Isoter</label>
                                                                    <input type="number" name="laporan[{{ $key }}][tracing_kontak_erat_isoter]"
                                                                    id="laporan[{{ $key }}][tracing_kontak_erat_isoter]"
                                                                    class="form-control" value="{{ $item[13] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_kontak_erat_dirawat]">Tracing Kontak Erat Di Rawat Inap di Rumah Sakit</label>
                                                                    <input type="number" name="laporan[{{ $key }}][tracing_kontak_erat_dirawat]"
                                                                    id="laporan[{{ $key }}][tracing_kontak_erat_dirawat]"
                                                                    class="form-control" value="{{ $item[14] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_kontak_erat_tanpa_alamat]">Tracing Kontak Erat Tanpa Alamat dan No Telpon</label>
                                                                    <input type="number" name="laporan[{{ $key }}][tracing_kontak_erat_tanpa_alamat]"
                                                                    id="laporan[{{ $key }}][tracing_kontak_erat_tanpa_alamat]"
                                                                    class="form-control" value="{{ $item[15] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][tracing_kontak_erat_domisili_luar_daerah]">Tracing Kontak Erat Domisi Diluar Daerah</label>
                                                                    <input type="number" name="laporan[{{ $key }}][tracing_kontak_erat_domisili_luar_daerah]"
                                                                    id="laporan[{{ $key }}][tracing_kontak_erat_domisili_luar_daerah]"
                                                                    class="form-control" value="{{ $item[16] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][dll]">DLL</label>
                                                                    <input type="number" name="laporan[{{ $key }}][dll]"
                                                                    id="laporan[{{ $key }}][dll]"
                                                                    class="form-control" value="{{ $item[17] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][keterangan]">Keterangan</label>
                                                                    <input type="text" name="laporan[{{ $key }}][keterangan]"
                                                                        id="laporan[{{ $key }}][keterangan]"
                                                                        class="form-control" value="{{ $item[18] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                              @endforeach
                                          </tbody>
                                      </table>
                                    @can('lapsubjar_create')
                                      <div class="d-flex justify-content-center justify-content-md-end mb-3">
                                          <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                                      </div>
                                    @endcan
                                </form>
                            </div>
                        </div>
                        @else
                        <div>
                            <h2 class="h4 text-center"><b>Laporan Hasil Pelaksanaan Tracing Pasien Covid-19 dan Kontak Erat </b></h2>
                            <form action="{{ route('laphar-tracing.export-excel') }}"
                                  class="form" method="post">
                                @csrf
                                <hr>
                                <div class="alert alert-gray">
                                    <h5><i class="icon fas fa-filter"></i> Filter</h5>
                                    <div class="row">
                                        @if(roles(['administrator', 'operator_bagopsnalev_mabes']))
                                        <div class="form-group col-sm-4">
                                            <label for="select-polda">Satuan Polda</label>
                                            <select name="polda" id="select-polda" class="form-control select2">
                                                <option></option>
                                            </select>
                                        </div>
                                        @endif
                                        <div class="form-group col-sm-4">
                                            <label for="search">Pencarian umum</label>
                                            <input type="text" id="search" name="search" class="form-control"
                                                    placeholder="Cari berdasarkan kolom-kolom di tabel">
                                        </div>
                                        <div class="form-group col">
                                            <label for="start_date">Mulai Tanggal</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control">
                                        </div>
                                        <div class="form-group col">
                                            <label for="end_date">Sampai Tanggal</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control">
                                        </div>
                                        <div class="col-12 form-group w-100 d-flex justify-content-center justify-content-sm-end">
                                            <div>
                                                <button class="btn btn-success" type="submit">
                                                    <i class="fa fa-file-alt"></i>&ensp;Ekspor Excel
                                                </button>
                                                <button type="reset" class="btn btn-warning">Reset</button>
                                                <button class="btn btn-primary" id="btn-search">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </form>
                            @component('components.sislap.form-search')
                                @slot('route', route('laphar-tracing.export-excel'))
                                @slot('className', 'd-none')
                            @endcomponent
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            @can('sislap_approval_create')
                                            <th class="align-middle text-center" width="4%" rowspan="3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                                                    <label class="form-check-label" for="check-all"></label>
                                                </div>
                                            </th>
                                            @endcan
                                            <th class="align-middle" rowspan="3">No</th>
                                            <th class="align-middle" rowspan="3">Nama Polres</th>
                                            <th class="align-middle" rowspan="3">Jumlah Pasien</th>
                                            <th class="align-middle" colspan="7">Hasil Tracing Pasien</th>
                                            <th class="align-middle" rowspan="3">Jumlah Kontak Erat Pasien yang Bisa Di Tracing</th>
                                            <th class="align-middle" colspan="7">Hasil Tracing Kontak Erat</th>
                                            <th class="align-middle" rowspan="3">Keterangan</th>
                                            <th class="align-middle" width="10" rowspan="3">Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle" width="4%" rowspan="3">Aksi</th>
                                            @endcanany
                                        </tr>
                                        <tr class="bg-primary text-center text-white">
                                            <td colspan="4">Tidak Bisa Di Tracing</td>
                                            <td colspan="3">Bisa Di Tracing</td>
                                            <td colspan="4">Bisa Di Tracing</td>
                                            <td colspan="3">Tidak Bisa Di Tracing</td>

                                        </tr>
                                        <tr class="bg-primary text-center text-white">
                                            <td class="align-middle">Sudah Sembuh</td>
                                            <td class="align-middle">Sudah MD</td>
                                            <td class="align-middle">Tanpa Alamat & No Telpon</td>
                                            <td class="align-middle">Domisili Di Luar Daerah</td>
                                            <td class="align-middle">Isoman</td>
                                            <td class="align-middle">Isoter</td>
                                            <td class="align-middle">Rawat Inap</td>
                                            <td class="align-middle">Sehat</td>
                                            <td class="align-middle">Isoman</td>
                                            <td class="align-middle">Isoter</td>
                                            <td class="align-middle">Di Rawat Di Rs</td>
                                            <td class="align-middle">Tanpa Alamat & No Telpon</td>
                                            <td class="align-middle">Domisili Di Luar Daerah</td>
                                            <td class="align-middle">DLL</td>

                                        </tr>
                                    </thead>
                                    <tbody id="content-wrapper"></tbody>
                                </table>
                            </div>
                            <div id="shimmer-wrapper">
                                <table class="table table-hover text-center">
                                    @component('components.shimmer.table-shimmer') @endcomponent
                                </table>
                            </div>
                            <div id="message-wrapper"></div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <ul id="paginator-wrapper" class="my-0"></ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<div class="modal fade" id="modalEdit" tabindex="-1"
         aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Laporan</h5>
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form-edit" class="form row">
                        @csrf
                        @method('PATCH')
                        <div class="form-group col-md-6">
                            <label for="nama_polres">Nama Polres</label>
                            <input type="text" name="nama_polres" id="nama_polres" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jumlah_pasien">Jumlah Jumlah Pasien</label>
                            <input type="text" name="jumlah_pasien" id="jumlah_pasien" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_pasien_sudah_sembuh">Tracing Pasien Sudah Sembuh</label>
                            <input type="text" name="tracing_pasien_sudah_sembuh" id="tracing_pasien_sudah_sembuh" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_pasien_sudah_md">Tracing Pasien Sudah MD</label>
                            <input type="text" name="tracing_pasien_sudah_md" id="tracing_pasien_sudah_md" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_pasien_tanpa_alamat">Tracing Pasien Tanpa Alamat dan No Telpon</label>
                            <input type="text" name="tracing_pasien_tanpa_alamat" id="tracing_pasien_tanpa_alamat" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_pasien_domisi_luar_daerah">Tracing Pasien Domisi Luar Daerah</label>
                            <input type="text" name="tracing_pasien_domisi_luar_daerah" id="tracing_pasien_domisi_luar_daerah" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_pasien_isoman">Tracing Pasien Isoman</label>
                            <input type="text" name="tracing_pasien_isoman" id="tracing_pasien_isoman" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_pasien_isoter">Tracing Pasien Isoter</label>
                            <input type="text" name="tracing_pasien_isoter" id="tracing_pasien_isoter" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_pasien_rawat_inap">Tracing Pasien Rawat Inap</label>
                            <input type="text" name="tracing_pasien_rawat_inap" id="tracing_pasien_rawat_inap" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jumlah_kontak_erat">Jumlah Kontak Erat Pasien</label>
                            <input type="text" name="jumlah_kontak_erat" id="jumlah_kontak_erat" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_kontak_erat_sehat">Tracing Kontak Erat Sehat</label>
                            <input type="text" name="tracing_kontak_erat_sehat" id="tracing_kontak_erat_sehat" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_kontak_erat_isoman">Tracing Kontak Erat Sehat Isoman</label>
                            <input type="text" name="tracing_kontak_erat_isoman" id="tracing_kontak_erat_isoman" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_kontak_erat_isoter">Tracing Kontak Erat Isoter</label>
                            <input type="text" name="tracing_kontak_erat_isoter" id="tracing_kontak_erat_isoter" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_kontak_erat_dirawat">Tracing Kontak Erat Di Rawat Inap di Rumah Sakit</label>
                            <input type="text" name="tracing_kontak_erat_dirawat" id="tracing_kontak_erat_dirawat" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_kontak_erat_tanpa_alamat">Tracing Kontak Erat Tanpa Alamat dan No Telpon</label>
                            <input type="text" name="tracing_kontak_erat_tanpa_alamat" id="tracing_kontak_erat_tanpa_alamat" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracing_kontak_erat_domisili_luar_daerah">Tracing Kontak Erat Domisi Diluar Daerah</label>
                            <input type="text" name="tracing_kontak_erat_domisili_luar_daerah" id="tracing_kontak_erat_domisili_luar_daerah" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dll">DLL</label>
                            <input type="text" name="dll" id="dll" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                        </div>

                        <div class="d-flex justify-content-end col-12">
                            <div>
                                <button type="reset" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@include('assets.js.twbs-pagination')
@endsection
@section('customjs')
    @include('assets.js.twbs-pagination')
    @include('assets.js.select2')
    <script src="{{ asset('js/component-with-pagination.js') }}"></script>
    <script>
        const getSelectedChecklist = () => {
            let selected = document.querySelectorAll('.checklist-approval:checked');
            if (selected.length === 0) {
                swalWarning('Anda belum memilih data laporan. Mohon pilih terlebih dahulu')
                return false;
            }
            let approvalRequestId = [];
            selected.forEach((item) => { approvalRequestId.push(item.dataset.id) });
            return approvalRequestId
        }
        const decline = (laporan_id) => {
            if (laporan_id != null) {
                Swal.fire({
                    input: 'textarea',
                    inputLabel: 'Catatan',
                    inputPlaceholder: 'Input catatan tidak valid...',
                    inputAttributes: {
                        autocapitalize: 'off',
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: function (message) {
                        sendApproval([laporan_id], false, message)
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    console.log(result)
                })
            }
        }

        @can('sislap_approval_create')
        const initListenerApprovalAll = () => {
            document.getElementById('check-all').addEventListener('change', function () {
                if (this.checked) {
                    document.querySelectorAll(".checklist-approval").forEach((checkbox) => {checkbox.setAttribute('checked', 'checked')})
                } else {
                    document.querySelectorAll(".checklist-approval").forEach((checkbox) => {checkbox.removeAttribute('checked')})
                }
            })
        }

        document.getElementById('btn-ajukan-approval').addEventListener('click', function () {
            let data = getSelectedChecklist()
            if (data) {
                sendApproval(data)
            }
        })
        @endcan

        let sendApproval = (approvalRequestId,
                            approval    = null,
                            keterangan  = null) => {
            axios.post(route('approval-laporan.store'), {
                approvable_id: approvalRequestId,
                approvable_type: "{{ $model }}",
                is_approve: approval,
                keterangan: keterangan
            })
            .then(function (response) {
                if (response.status === 200){
                    swalSuccess(response.data.message)
                    listLaporan.updateState('page', 1)
                    listLaporan.fetchData()
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        @can('sislap_approval_edit')
            document.getElementById('btn-approve-approval').addEventListener('click', function () {
                sendApproval(getSelectedChecklist(), true)
            })
        @endcan

        const listLaporan = new ComponentWithPagination({
            contentWrapper: '#content-wrapper',
            messageWrapper: '#message-wrapper',
            paginator: '#paginator-wrapper',
            loader: '#shimmer-wrapper',
            searchState: {
                url: route('laphar-tracing.search'),
                data: {}
            },
            content: (item, rowNumber) => {
                console.log(item)
                let haveApprovals       = item.approvals.length > 0;
                let checklistApproval   = item.need_approve ? `<div class="form-check">
                                                                <input type="checkbox" class="form-check-input checklist-approval" name="check_approval[${item.id}]" data-id="${ item.id }" aria-label="check-row">
                                                            </div>` : '';
                let table = `
                    <tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"': ''} ${ haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : '' }>
                        @can('sislap_approval_create')
                            <th class="align-middle text-center">
                                ${ checklistApproval }
                            </th>
                        @endcan
                        <th class="align-middle text-center">${ rowNumber }</th>
                        <td class="align-middle ">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.nama_polres }</td>
                        <td class="align-middle ">${ item.jumlah_pasien }</td>
                        <td class="align-middle ">${ item.tracing_pasien_sudah_sembuh }</td>
                        <td class="align-middle ">${ item.tracing_pasien_sudah_md }</td>
                        <td class="align-middle ">${ item.tracing_pasien_tanpa_alamat }</td>
                        <td class="align-middle ">${ item.tracing_pasien_domisi_luar_daerah }</td>
                        <td class="align-middle ">${ item.tracing_pasien_isoman }</td>
                        <td class="align-middle ">${ item.tracing_pasien_isoter }</td>
                        <td class="align-middle ">${ item.tracing_pasien_rawat_inap }</td>
                        <td class="align-middle ">${ item.jumlah_kontak_erat }</td>
                        <td class="align-middle ">${ item.tracing_kontak_erat_sehat }</td>
                        <td class="align-middle ">${ item.tracing_kontak_erat_isoman }</td>
                        <td class="align-middle ">${ item.tracing_kontak_erat_isoter }</td>
                        <td class="align-middle ">${ item.tracing_kontak_erat_dirawat }</td>
                        <td class="align-middle ">${ item.tracing_kontak_erat_tanpa_alamat }</td>
                        <td class="align-middle ">${ item.tracing_kontak_erat_domisili_luar_daerah }</td>
                        <td class="align-middle ">${ item.dll }</td>
                        <td class="align-middle ">${ item.keterangan }</td>
                        <td class="align-middle text-center">${ formatDate(item.created_at) }</td>
                        @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                        <td class="align-middle text-center">
                        @can('sislap_approval_approve')
                            ${ !item.need_approve ? `` : `
                                <button class="btn btn-approve btn-success mb-1"
                                        onclick="sendApproval([${item.id}], true)">
                                        <i class="fas fa-check-circle"></i>
                                </button>`}
                            @endcan
                            @can('sislap_approval_decline')
                            ${ !haveApprovals || item.approval.is_approve === null || item.approval.is_approve ? `
                                <button class="btn btn-decline btn-danger mb-1"
                                        onclick="decline(${item.id})">
                                        <i class="fas fa-times-circle"></i>
                                </button>
                            ` : ``}
                            @endcan
                            @can('lapsubjar_edit')
                            ${ haveApprovals && !item.need_approve ? `` : `
                                <button class="btn btn-edit btn-warning mb-1"
                                        data-toggle="modal" data-target="#modalEdit"
                                        onclick="insertValueToFormEdit({
                                            id: '${item.id}',
                                            nama_polres:        '${item.nama_polres}',
                                            jumlah_pasien:      '${item.jumlah_pasien}',
                                            tracing_pasien_sudah_sembuh:    '${item.tracing_pasien_sudah_sembuh}',
                                            tracing_pasien_sudah_md:    '${item.tracing_pasien_sudah_md}',
                                            tracing_pasien_tanpa_alamat:    '${item.tracing_pasien_tanpa_alamat}',
                                            tracing_pasien_domisi_luar_daerah:  '${item.tracing_pasien_domisi_luar_daerah}',
                                            tracing_pasien_isoman:   '${item.tracing_pasien_isoman}',
                                            tracing_pasien_isoter:   '${item.tracing_pasien_isoter}',
                                            tracing_pasien_rawat_inap:   '${item.tracing_pasien_rawat_inap}',
                                            jumlah_kontak_erat: '${item.jumlah_kontak_erat}',
                                            tracing_kontak_erat_sehat:  '${item.tracing_kontak_erat_sehat}',
                                            tracing_kontak_erat_isoman:  '${item.tracing_kontak_erat_isoman}',
                                            tracing_kontak_erat_isoter:  '${item.tracing_kontak_erat_isoter}',
                                            tracing_kontak_erat_dirawat:'${item.tracing_kontak_erat_dirawat}',
                                            tracing_kontak_erat_tanpa_alamat: '${item.tracing_kontak_erat_tanpa_alamat}',
                                            tracing_kontak_erat_domisili_luar_daerah: '${item.tracing_kontak_erat_domisili_luar_daerah}',
                                            dll: '${item.dll}',
                                            keterangan: '${item.keterangan}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('laphar-tracing.destroy', item.id) }" method="post" id="${ item.id }">
                                @method('delete')
                            @csrf
                            <button class="btn btn-danger btn-delete" type="submit" onclick="event.preventDefault(); deleteConfirm(${ item.id })">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>` : ``}
                            @endcan
                        </td>
                        @endcanany
                    </tr>`;
                if (haveApprovals){
                    table += listRiwayatApproval(item.approvals, 22);
                }
                return table;
            },
            @can('sislap_approval_create')
            completeEvent: initListenerApprovalAll()
            @endcan
        })

        const initSelectPolda = (el = $('#select-polda')) => {
            buildSelect2Search({
                placeholder: '-- Pilih Polda --',
                url: '{{ route('polda.select2') }}',
                minimumInputLength: 0,
                selector: [{ id: el }],
                query: function (params) {
                    return {
                        polda: params.term,
                    }
                }
            });
        }
        initSelectPolda();

        document.getElementById('btn-search').addEventListener('click', (event) => {
            event.preventDefault()
            listLaporan.updateState('search', document.querySelector('input[name=search]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })

        const insertValueToFormEdit = ({
                id, nama_polres, jumlah_pasien, tracing_pasien_sudah_sembuh,
                tracing_pasien_sudah_md, tracing_pasien_tanpa_alamat,
                tracing_pasien_domisi_luar_daerah, tracing_pasien_isoman,
                tracing_pasien_isoter, tracing_pasien_rawat_inap,
                jumlah_kontak_erat, tracing_kontak_erat_sehat,
                tracing_kontak_erat_isoman, tracing_kontak_erat_isoter,
                tracing_kontak_erat_dirawat, tracing_kontak_erat_tanpa_alamat,
                tracing_kontak_erat_domisili_luar_daerah, dll, keterangan
            }) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('laphar-tracing.update', id))
            elFormEdit.querySelector('input[name="nama_polres"]').value          = nama_polres
            elFormEdit.querySelector('input[name="jumlah_pasien"]').value        = jumlah_pasien
            elFormEdit.querySelector('input[name="tracing_pasien_sudah_sembuh"]').value      = tracing_pasien_sudah_sembuh
            elFormEdit.querySelector('input[name="tracing_pasien_sudah_md"]').value          = tracing_pasien_sudah_md
            elFormEdit.querySelector('input[name="tracing_pasien_tanpa_alamat"]').value      = tracing_pasien_tanpa_alamat
            elFormEdit.querySelector('input[name="tracing_pasien_domisi_luar_daerah"]').value= tracing_pasien_domisi_luar_daerah
            elFormEdit.querySelector('input[name="tracing_pasien_isoman"]').value            = tracing_pasien_isoman
            elFormEdit.querySelector('input[name="tracing_pasien_isoter"]').value            = tracing_pasien_isoter
            elFormEdit.querySelector('input[name="tracing_pasien_rawat_inap"]').value        = tracing_pasien_rawat_inap
            elFormEdit.querySelector('input[name="jumlah_kontak_erat"]').value               = jumlah_kontak_erat
            elFormEdit.querySelector('input[name="tracing_kontak_erat_sehat"]').value        = tracing_kontak_erat_sehat
            elFormEdit.querySelector('input[name="tracing_kontak_erat_isoman"]').value       = tracing_kontak_erat_isoman
            elFormEdit.querySelector('input[name="tracing_kontak_erat_isoter"]').value       = tracing_kontak_erat_isoter
            elFormEdit.querySelector('input[name="tracing_kontak_erat_dirawat"]').value      = tracing_kontak_erat_dirawat
            elFormEdit.querySelector('input[name="tracing_kontak_erat_tanpa_alamat"]').value = tracing_kontak_erat_tanpa_alamat
            elFormEdit.querySelector('input[name="tracing_kontak_erat_domisili_luar_daerah"]').value = tracing_kontak_erat_domisili_luar_daerah
            elFormEdit.querySelector('input[name="dll"]').value                              = dll
            elFormEdit.querySelector('input[name="keterangan"]').value                       = keterangan
        }
    </script>
@endsection
