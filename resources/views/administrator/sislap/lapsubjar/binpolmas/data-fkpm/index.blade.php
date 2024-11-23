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
            @slot('title', 'Laporan Data FKPM')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('data-fkpm.template-excel'))
                        @slot('import_excel', route('data-fkpm.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Data FKPM</b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('data-fkpm.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                              @foreach ($laporan[0] as $key => $item)
                                                  @if($key > 1)
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
                                                            <label for="laporan[{{ $key }}][nama_fkpm]">Nama FKPM</label>
                                                            <input type="text" name="laporan[{{ $key }}][nama_fkpm]"
                                                                id="laporan[{{ $key }}][nama_fkpm]"
                                                                class="form-control" value="{{ $item[1] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][nama_anggota_fkpm]">Nama Anggota FKPM</label>
                                                            <input type="text" name="laporan[{{ $key }}][nama_anggota_fkpm]"
                                                                id="laporan[{{ $key }}][nama_anggota_fkpm]"
                                                                class="form-control" value="{{ $item[2] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][model_kawasan]">Model Kawasan<br>
                                                                (Perdagangan/Perkantoran/Industri/Pergudangan/Pelabuhan/Pendidikan atau yang Lainnya)</label>
                                                            <input type="text" name="laporan[{{ $key }}][model_kawasan]"
                                                                id="laporan[{{ $key }}][model_kawasan]"
                                                                class="form-control" value="{{ $item[3] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][model_wilayah]">Model Wilayah<br>
                                                                (Rw/Dusun/Desa/Pranata Adat/Kearifan Lokal)</label>
                                                            <input type="text" name="laporan[{{ $key }}][model_wilayah]"
                                                                id="laporan[{{ $key }}][model_wilayah]"
                                                                class="form-control" value="{{ $item[4] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][bkpm]">BKPM (Sudah/Belum)</label>
                                                            <input type="text" name="laporan[{{ $key }}][bkpm]"
                                                                id="laporan[{{ $key }}][bkpm]"
                                                                class="form-control" value="{{ $item[5] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][desa_kel]">Desa/Kel</label>
                                                            <input type="text" name="laporan[{{ $key }}][desa_kel]"
                                                                id="laporan[{{ $key }}][desa_kel]"
                                                                class="form-control" value="{{ $item[6] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][kecamatan]">Kecamatan</label>
                                                            <input type="text" name="laporan[{{ $key }}][kecamatan]"
                                                                id="laporan[{{ $key }}][kecamatan]"
                                                                class="form-control" value="{{ $item[7] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][kab_kota]">Kabupaten/Kota</label>
                                                            <input type="text" name="laporan[{{ $key }}][kab_kota]"
                                                                id="laporan[{{ $key }}][kab_kota]"
                                                                class="form-control" value="{{ $item[8] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][provinsi]">Provinsi</label>
                                                            <input type="text" name="laporan[{{ $key }}][provinsi]"
                                                                id="laporan[{{ $key }}][provinsi]"
                                                                class="form-control" value="{{ $item[9] }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="laporan[{{ $key }}][keterangan]">Keterangan</label>
                                                            <input type="text" name="laporan[{{ $key }}][keterangan]"
                                                                id="laporan[{{ $key }}][keterangan]"
                                                                class="form-control" value="{{ $item[10] }}">
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
                            <h2 class="h4 text-center"><b>Laporan Data FKPM</b></h2>
                            <form action="{{ route('data-fkpm.export-excel') }}"
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
                                @slot('route', route('data-fkpm.export-excel'))
                                @slot('className', 'd-none')
                            @endcomponent
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            @can('sislap_approval_create')
                                            <th class="align-middle text-center" width="4%" rowspan="2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                                                    <label class="form-check-label" for="check-all"></label>
                                                </div>
                                            </th>
                                            @endcan
                                            <th class="align-middle" rowspan="2">No</th>
                                            <th class="align-middle" rowspan="2">Nama FKPM</th>
                                            <th class="align-middle" rowspan="2">Nama Anggota FKPM</th>
                                            <th class="align-middle" rowspan="2">Model Kawasan<br>(Perdagangan/Perkantoran/Industri/Pergudangan/Pelabuhan/Pendidikan atau yang Lainnya)</th>
                                            <th class="align-middle" rowspan="2">Model Wilayah<br>(Rw/Dusun/Desa/Pranata Adat/Kearifan Lokal)</th>
                                            <th class="align-middle" rowspan="2">BKPM (Sudah/Belum)</th>
                                            <th class="align-middle" colspan="5">Alamat FKPM</th>
                                            <th class="align-middle" width="10" rowspan="2">Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle" width="4%" rowspan="2" >Aksi</th>
                                            @endcanany
                                            <tr class="bg-primary text-center">
                                              <td>Desa/Kel</td>
                                              <td>Kec</td>
                                              <td>Kab/Kota</td>
                                              <td>Prov</td>
                                              <td>Keterangan</td>
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
                            <label for="nama_fkpm">Nama FKPM</label>
                            <input type="text" name="nama_fkpm" id="nama_fkpm" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama_anggota_fkpm">Nama Anggota FKPM</label>
                            <input type="text" name="nama_anggota_fkpm" id="nama_anggota_fkpm" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model_kawasan">Model Kawasan</label>
                            <input type="text" name="model_kawasan" id="model_kawasan" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model_wilayah">Model Wilayah</label>
                            <input type="text" name="model_wilayah" id="model_wilayah" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="bkpm">BPKM(Sudah/Belum)</label>
                            <input type="text" name="bkpm" id="bkpm" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="desa_kel">Desa/Kel</label>
                            <input type="text" name="desa_kel" id="desa_kel" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kab_kota">Kab/Kota</label>
                            <input type="text" name="kab_kota" id="kab_kota" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="provinsi">Provinsi</label>
                            <input type="text" name="provinsi" id="provinsi" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" rows="4" class="form-control">
                        </div>
                        <div class="col-md-12">

                            <div class="d-flex justify-content-end">
                                <div>
                                    <button type="reset" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
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
                url: route('data-fkpm.search'),
                data: {}
            },
            content: (item, rowNumber) => {
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
                        <td class="align-middle">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.nama_fkpm }</td>
                        <td class="align-middle">${ item.nama_anggota_fkpm }</td>
                        <td class="align-middle">${ item.model_kawasan }</td>
                        <td class="align-middle">${ item.model_wilayah }</td>
                        <td class="align-middle">${ item.bkpm }</td>
                        <td class="align-middle">${ item.desa_kel }</td>
                        <td class="align-middle">${ item.kecamatan }</td>
                        <td class="align-middle">${ item.kab_kota }</td>
                        <td class="align-middle">${ item.provinsi }</td>
                        <td class="align-middle">${ item.keterangan }</td>
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
                            @if (can('sislap_approval_decline') || roles(['administrator']))
                            ${ !haveApprovals || item.approval.is_approve === null || item.approval.is_approve ? `
                                <button class="btn btn-decline btn-danger mb-1"
                                        onclick="decline(${item.id})">
                                        <i class="fa fa-question"></i>
                                </button>
                            ` : ``}
                            @endif
                            @can('lapsubjar_edit')
                            ${ haveApprovals && !item.need_approve ? `` : `
                                <button class="btn btn-edit btn-warning mb-1"
                                        data-toggle="modal" data-target="#modalEdit"
                                        onclick="insertValueToFormEdit({
                                            id: '${item.id}',
                                            nama_fkpm: '${item.nama_fkpm}',
                                            nama_anggota_fkpm: '${item.nama_anggota_fkpm}',
                                            model_kawasan: '${item.model_kawasan}',
                                            model_wilayah: '${item.model_wilayah}',
                                            bkpm: '${item.bkpm}',
                                            desa_kel: '${item.desa_kel}',
                                            kecamatan: '${item.kecamatan}',
                                            kab_kota: '${item.kab_kota}',
                                            provinsi: '${item.provinsi}',
                                            keterangan: '${item.keterangan}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('data-fkpm.destroy', item.id) }" method="post" id="${ item.id }">
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
                    table += listRiwayatApproval(item.approvals, 14);
                }
                return table;
            },
            @can('sislap_approval_create')
            completeEvent: initListenerApprovalAll()
            @endcan
        })

        document.getElementById('btn-search').addEventListener('click', (event) => {
            event.preventDefault()
            listLaporan.updateState('search', document.querySelector('input[name=search]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
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

        const insertValueToFormEdit = ({
            id, nama_fkpm, nama_anggota_fkpm, model_kawasan, model_wilayah,
            bkpm, desa_kel, kecamatan, kab_kota, provinsi, keterangan,
            instansi_terlibat
        }) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('data-fkpm.update', id))
            elFormEdit.querySelector('input[name="nama_fkpm"]').value   = nama_fkpm
            elFormEdit.querySelector('input[name="nama_anggota_fkpm"]').value   = nama_anggota_fkpm
            elFormEdit.querySelector('input[name="model_kawasan"]').value   = model_kawasan
            elFormEdit.querySelector('input[name="model_wilayah"]').value   = model_wilayah
            elFormEdit.querySelector('input[name="bkpm"]').value        = bkpm
            elFormEdit.querySelector('input[name="desa_kel"]').value    = desa_kel
            elFormEdit.querySelector('input[name="kecamatan"]').value   = kecamatan
            elFormEdit.querySelector('input[name="kab_kota"]').value    = kab_kota
            elFormEdit.querySelector('input[name="provinsi"]').value    = provinsi
            elFormEdit.querySelector('input[name="keterangan"]').value  = keterangan
        }
    </script>
@endsection
