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
            @slot('title', 'Laporan Data Dai Kamtibmas')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('data-dai.template-excel'))
                        @slot('import_excel', route('data-dai.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Data Dai Kamtibmas</b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('data-dai.store') }}"
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
                                                                <label for="laporan[{{ $key }}][nama_dai]">Nama Da'i</label>
                                                                <input type="text" name="laporan[{{ $key }}][nama_dai]"
                                                                    id="laporan[{{ $key }}][nama_dai]"
                                                                    class="form-control" value="{{ $item[1] }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="laporan[{{ $key }}][perorangan_kelompok]">Perorangan/Kelompok</label>
                                                                <input type="text" name="laporan[{{ $key }}][perorangan_kelompok]"
                                                                    id="laporan[{{ $key }}][perorangan_kelompok]"
                                                                    class="form-control" value="{{ $item[2] }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="laporan[{{ $key }}][no_hp]">NO HP</label>
                                                                <input type="numeric" name="laporan[{{ $key }}][no_hp]"
                                                                    id="laporan[{{ $key }}][no_hp]"
                                                                    class="form-control" value="{{ $item[3] }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="laporan[{{ $key }}][rt_rw]">RT/RW</label>
                                                                <input type="text" name="laporan[{{ $key }}][rt_rw]"
                                                                    id="laporan[{{ $key }}][rt_rw]"
                                                                    class="form-control" value="{{ $item[4] }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="laporan[{{ $key }}][desa_kel]">Desa/Kelurahan</label>
                                                                <input type="text" name="laporan[{{ $key }}][desa_kel]"
                                                                    id="laporan[{{ $key }}][desa_kel]"
                                                                    class="form-control" value="{{ $item[5] }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="laporan[{{ $key }}][kecamatan]">Kecamatan</label>
                                                                <input type="text" name="laporan[{{ $key }}][kecamatan]"
                                                                    id="laporan[{{ $key }}][kecamatan]"
                                                                    class="form-control" value="{{ $item[6] }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="laporan[{{ $key }}][kab_kota]">Kabupaten/Kota</label>
                                                                <input type="text" name="laporan[{{ $key }}][kab_kota]"
                                                                    id="laporan[{{ $key }}][kab_kota]"
                                                                    class="form-control" value="{{ $item[7] }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="laporan[{{ $key }}][keterangan]">Keterangan</label>
                                                                <input type="text" name="laporan[{{ $key }}][keterangan]"
                                                                    id="laporan[{{ $key }}][keterangan]"
                                                                    class="form-control" value="{{ $item[8] }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                          </tbody>
                                      </table>
                                    @can('lapsubjar_create')
                                      <div class="d-flex justify-content-center justify-content-md-end">
                                          <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                                      </div>
                                    @endcan
                                </form>
                            </div>
                        </div>
                        @else
                        <div>
                            <h2 class="h4 text-center"><b>Laporan Data Dai Kamtibmas</b></h2>
                            <form action="{{ route('data-dai.export-excel') }}"
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
                                @slot('route', route('data-dai.export-excel'))
                                @slot('className', 'd-none')
                            @endcomponent
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="bg-primary text-white text-center">
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
                                            <th class="align-middle" rowspan="2">Nama Da'i</th>
                                            <th class="align-middle" rowspan="2">Perorangan/Kelompok</th>
                                            <th class="align-middle" rowspan="2">Nomor HP</th>
                                            <th class="align-middle" colspan="5">Alamat Da'i</th>
                                            <th class="align-middle" width="10" rowspan="2">Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle" width="4%" rowspan="2" >Aksi</th>
                                            @endcanany
                                        </tr>
                                        <tr class="bg-primary text-center">
                                            <td>Rt/Rw</td>
                                            <td>Desa/Kel</td>
                                            <td>Kec</td>
                                            <td>Kab/Kota</td>
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
                            <label for="nama_dai">Nama Da'i</label>
                            <input type="text" id="nama_dai" name="nama_dai" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="perorangan_kelompok">Perorangan/Kelompok</label>
                            <input type="text" id="perorangan_kelompok" name="perorangan_kelompok" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_hp">Nomor HP</label>
                            <input type="numeric" id="no_hp" name="no_hp" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rt_rw">RT/RW</label>
                            <input type="text" id="rt_rw" name="rt_rw" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="desa_kel">Desa/Kelurahan</label>
                            <input type="text" id="desa_kel" name="desa_kel" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" id="kecamatan" name="kecamatan" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kab_kota">Kabupaten/Kota</label>
                            <input type="text" id="kab_kota" name="kab_kota" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <div>
                                    <button type="reset" class="btn btn-warning" data-toggle="modal"
                                            data-target="#modalEdit">Batal</button>
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
                url: route('data-dai.search'),
                data: {}
            },
            content: (item, rowNumber) => {
                console.log(item.need_approve)
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
                        <td class="align-middle">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.nama_dai }</td>
                        <td class="align-middle text-center">${ item.perorangan_kelompok }</td>
                        <td class="align-middle text-center">${ item.no_hp }</td>
                        <td class="align-middle text-center">${ item.rt_rw }</td>
                        <td class="align-middle text-center">${ item.desa_kel }</td>
                        <td class="align-middle text-center">${ item.kecamatan }</td>
                        <td class="align-middle text-center">${ item.keterangan }</td>
                        <td class="align-middle text-center">${ item.kab_kota }</td>
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
                                            nama_dai: '${item.nama_dai}',
                                            perorangan_kelompok: '${item.perorangan_kelompok}',
                                            no_hp: '${item.no_hp}',
                                            rt_rw: '${item.rt_rw}',
                                            desa_kel: '${item.desa_kel}',
                                            kecamatan: '${item.kecamatan}',
                                            kab_kota: '${item.kab_kota}',
                                            keterangan: '${item.keterangan}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('data-dai.destroy', item.id) }" method="post" id="${ item.id }">
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
                    table += listRiwayatApproval(item.approvals, 15);
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
                id, nama_dai, perorangan_kelompok, no_hp, rt_rw, desa_kel,
                kecamatan, kab_kota, keterangan
            }) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('data-dai.update', id))
            elFormEdit.querySelector('input[name="nama_dai"]').value    = nama_dai
            elFormEdit.querySelector('input[name="perorangan_kelompok"]').value    = perorangan_kelompok
            elFormEdit.querySelector('input[name="no_hp"]').value   = no_hp
            elFormEdit.querySelector('input[name="rt_rw"]').value     = rt_rw
            elFormEdit.querySelector('input[name="desa_kel"]').value           = desa_kel
            elFormEdit.querySelector('input[name="kecamatan"]').value    = kecamatan
            elFormEdit.querySelector('input[name="kab_kota"]').value       = kab_kota
            elFormEdit.querySelector('input[name="keterangan"]').value     = keterangan

        }
    </script>
@endsection
