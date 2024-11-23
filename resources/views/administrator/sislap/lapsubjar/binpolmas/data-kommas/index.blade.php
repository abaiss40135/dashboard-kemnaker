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
            @slot('title', 'Laporan Data Komunitas Masyarakat')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('data-kommas.template-excel'))
                        @slot('import_excel', route('data-kommas.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Data Komunitas Masyarakat</b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('data-kommas.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                                <tr class="text-center bg-primary">
                                                    <th class="align-middle">No</th>
                                                    <th class="align-middle text-center">Nama Ormas</th>
                                                    <th class="align-middle text-center">Badan Hukum</th>
                                                    <th class="align-middle text-center">Akta Notaris</th>
                                                    <th class="align-middle text-center">Pengesehan</th>
                                                    <th class="align-middle text-center">NPWP</th>
                                                    <th class="align-middle text-center">Duk Pembina</th>
                                                    <th class="align-middle text-center">Pengurus</th>
                                                    <th class="align-middle text-center">Jenis Komunitas</th>
                                                    <th class="align-middle text-center">Kebijakan Komunitas</th>
                                                    <th class="align-middle text-center">Jumlah Anggota</th>
                                                    <th class="align-middle text-center">Keterangan</th>
                                                </tr>
                                              @foreach ($laporan[0] as $key => $item)
                                                    @if($key  !== 0)
                                                        <tr>
                                                            <th class="text-center">{{ $item[0] }}</th>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][nama_kommas]"
                                                                        id="laporan[{{ $key }}][nama_kommas]" rows="4" maxlength="30">{{ $item[1] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][badan_hukum]"
                                                                        id="laporan[{{ $key }}][badan_hukum]" rows="4">{{ $item[2] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][akta_notaris]"
                                                                        id="laporan[{{ $key }}][akta_notaris]" rows="4" maxlength="100">{{ $item[3] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][pengesahan]"
                                                                        id="laporan[{{ $key }}][pengesahan]" rows="4" maxlength="255">{{ $item[4] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][npwp]"
                                                                        id="laporan[{{ $key }}][npwp]" rows="4" maxlength="255">{{ $item[5] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][duk_pembina]"
                                                                        id="laporan[{{ $key }}][duk_pembina]" rows="4" maxlength="255">{{ $item[6] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][pengurus]"
                                                                        id="laporan[{{ $key }}][pengurus]" rows="4" maxlength="255">{{ $item[7] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][jenis_komunitas]"
                                                                        id="laporan[{{ $key }}][jenis_komunitas]" rows="4" maxlength="255">{{ $item[8] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][kebijakan_komunitas]"
                                                                        id="laporan[{{ $key }}][kebijakan_komunitas]" rows="4" maxlength="255">{{ $item[9] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][jumlah_anggota]"
                                                                        id="laporan[{{ $key }}][jumlah_anggota]" rows="4" maxlength="255">{{ $item[10] ?? '-' }}</textarea></td>
                                                            <td><textarea class="form-control" name="laporan[{{ $key }}][keterangan]"
                                                                        id="laporan[{{ $key }}][keterangan]" rows="4" maxlength="255">{{ $item[11] ?? '-' }}</textarea></td>
                                                        </tr>
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
                            <h2 class="h4 text-center"><b>Laporan Data Komunitas Masyarakat</b></h2>
                            <form action="{{ route('data-kommas.export-excel') }}"
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
                                @slot('route', route('data-kommas.export-excel'))
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
                                            <th class="align-middle">No</th>
                                            <th class="align-middle text-center">Nama Ormas</th>
                                            <th class="align-middle text-center">Badan Hukum</th>
                                            <th class="align-middle text-center">Akta Notaris</th>
                                            <th class="align-middle text-center">Pengesehan</th>
                                            <th class="align-middle text-center">NPWP</th>
                                            <th class="align-middle text-center">Duk Pembina</th>
                                            <th class="align-middle text-center">Pengurus</th>
                                            <th class="align-middle text-center">Jenis Komunitas</th>
                                            <th class="align-middle text-center">Kebijakan Komunitas</th>
                                            <th class="align-middle text-center">Jumlah Anggota</th>
                                            <th class="align-middle text-center">Keterangan</th>
                                            <th class="align-middle" width="10" rowspan="2">Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle" width="4%" rowspan="2">Aksi</th>
                                            @endcanany
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
                            <label for="nama_kommas">Nama Organisasi Masyarakat</label>
                            <input type="text" id="nama_kommas" name="nama_kommas"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="badan_hukum">Badan Hukum</label>
                            <input type="text" id="badan_hukum" name="badan_hukum"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="akta_notaris">Akta Notaris</label>
                            <input type="text" id="akta_notaris" name="akta_notaris"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pengesahan">Pengesahan</label>
                            <input type="text" id="pengesahan" name="pengesahan"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="npwp">NPWP</label>
                            <input type="text" id="npwp" name="npwp"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="duk_pembina">DUK Pembina</label>
                            <input type="text" id="duk_pembina" name="duk_pembina"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pengurus">Pengurus</label>
                            <input type="text" id="pengurus" name="pengurus"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jenis_komunitas">Jenis Komunitas</label>
                            <input type="text" id="jenis_komunitas" name="jenis_komunitas"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kebijakan_komunitas">Kebijakan Komunitas</label>
                            <input type="text" id="kebijakan_komunitas" name="kebijakan_komunitas"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jumlah_anggota">Jumlah Anggota</label>
                            <input type="text" id="jumlah_anggota" name="jumlah_anggota"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan"
                                   class="form-control">
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
                url: route('data-kommas.search'),
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
                        <td class="align-middle">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.nama_kommas }</td>
                        <td class="align-middle text-center">${ item.badan_hukum }</td>
                        <td class="align-middle text-center">${ item.akta_notaris }</td>
                        <td class="align-middle text-center">${ item.pengesahan }</td>
                        <td class="align-middle text-center">${ item.npwp }</td>
                        <td class="align-middle text-center">${ item.duk_pembina }</td>
                        <td class="align-middle text-center">${ item.pengurus }</td>
                        <td class="align-middle text-center">${ item.jenis_komunitas }</td>
                        <td class="align-middle text-center">${ item.kebijakan_komunitas }</td>
                        <td class="align-middle text-center">${ item.jumlah_anggota }</td>
                        <td class="align-middle text-center">${ item.keterangan }</td>
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
                                            nama_kommas: '${item.nama_kommas}',
                                            badan_hukum: '${item.badan_hukum}',
                                            akta_notaris: '${item.akta_notaris}',
                                            pengesahan: '${item.pengesahan}',
                                            npwp: '${item.npwp}',
                                            duk_pembina: '${item.duk_pembina}',
                                            pengurus: '${item.pengurus}',
                                            jenis_komunitas: '${item.jenis_komunitas}',
                                            kebijakan_komunitas: '${item.kebijakan_komunitas}',
                                            jumlah_anggota: '${item.jumlah_anggota}',
                                            keterangan: '${item.keterangan}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('data-kommas.destroy', item.id) }" method="post" id="${ item.id }">
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
                id, nama_kommas, badan_hukum, akta_notaris, pengesahan, npwp,
                duk_pembina, pengurus, jenis_komunitas, kebijakan_komunitas,
                jumlah_anggota, keterangan
            }) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('data-kommas.update', id))
            elFormEdit.querySelector('input[name="nama_kommas"]').value     = nama_kommas
            elFormEdit.querySelector('input[name="badan_hukum"]').value     = badan_hukum
            elFormEdit.querySelector('input[name="akta_notaris"]').value    = akta_notaris
            elFormEdit.querySelector('input[name="pengesahan"]').value      = pengesahan
            elFormEdit.querySelector('input[name="npwp"]').value            = npwp
            elFormEdit.querySelector('input[name="duk_pembina"]').value     = duk_pembina
            elFormEdit.querySelector('input[name="pengurus"]').value        = pengurus
            elFormEdit.querySelector('input[name="jenis_komunitas"]').value = jenis_komunitas
            elFormEdit.querySelector('input[name="kebijakan_komunitas"]').value = kebijakan_komunitas
            elFormEdit.querySelector('input[name="jumlah_anggota"]').value  = jumlah_anggota
            elFormEdit.querySelector('input[name="keterangan"]').value      = keterangan
        }
    </script>
@endsection
