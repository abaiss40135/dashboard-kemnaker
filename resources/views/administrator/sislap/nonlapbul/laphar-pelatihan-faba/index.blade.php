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
            @slot('title', 'Laporan Harian Pelatihan FABA (Fly Ash Bottom Ash)')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('laphar-pelatihan-faba.template-excel'))
                        @slot('import_excel', route('laphar-pelatihan-faba.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Pelatihan FABA (Fly Ash Bottom Ash)</b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('laphar-pelatihan-faba.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <div class="table-responsive">
                                          <table class="table table-hover table-bordered">
                                              <thead class="text-center bg-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Polda</th>
                                                    <th>Lokasi Pelatihan</th>
                                                    <th>Nama Trainer</th>
                                                    <th>Jumlah Peserta</th>
                                                  </tr>
                                              </thead>
                                                <tbody>
                                                    @foreach ($laporan[0] as $key => $item)
                                                        @if($key !== 0)
                                                        <tr>
                                                            <th class="text-center">{{ $item[0] }}</th>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                       name="laporan[{{ $key }}][polda]"
                                                                       id="laporan[{{ $key }}][polda]"
                                                                       value="{{ $item[1] ?? "-" }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                       name="laporan[{{ $key }}][lokasi_pelatihan]"
                                                                       id="laporan[{{ $key }}][lokasi_pelatihan]"
                                                                       value="{{ $item[2] ?? "-" }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                       name="laporan[{{ $key }}][nama_trainer]"
                                                                       id="laporan[{{ $key }}][nama_trainer]"
                                                                       value="{{ $item[3] ?? 0 }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                       name="laporan[{{ $key }}][jumlah_peserta]"
                                                                       id="laporan[{{ $key }}][jumlah_peserta]"
                                                                       value="{{ $item[4] ?? 0 }}">
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                          </table>
                                      </div>
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
                            <h2 class="h4 text-center"><b>Pelatihan FABA (Fly Ash Bottom Ash)</b></h2>
                            <form action="{{ route('laphar-pelatihan-faba.export-excel') }}"
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
                                @slot('route', route('laphar-pelatihan-faba.export-excel'))
                                @slot('className', 'd-none')
                            @endcomponent
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="bg-primary text-white text-center">
                                        <tr>
                                            @can('sislap_approval_create')
                                            <th class="align-middle text-center" rowspan="2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                                                    <label class="form-check-label" for="check-all"></label>
                                                </div>
                                            </th>
                                            @endcan
                                            <th class="align-middle" >No</th>
                                            <th class="align-middle" >Polda</th>
                                            <th class="align-middle" >Lokasi Pelatihan</th>
                                            <th class="align-middle" >Nama Trainer</th>
                                            <th class="align-middle" >Jumlah Peserta</th>
                                            <th class="align-middle">Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle">Aksi</th>
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
                    <form action="#" method="post" id="form-edit" class="row">
                        @csrf
                        @method('PATCH')
                        <div class="form-group col-sm-6">
                            <label for="polda">polda</label>
                            <input type="text" name="polda"
                                   id="polda" class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="lokasi_pelatihan">Lokasi Pelatihan</label>
                            <input type="text" name="lokasi_pelatihan"
                                   id="lokasi_pelatihan" class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="nama_trainer">Nama Trainer</label>
                            <input type="text" name="nama_trainer"
                                   id="nama_trainer" class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="jumlah_peserta">Jumlah Peserta</label>
                            <input type="text" name="jumlah_peserta"
                                   id="jumlah_peserta" class="form-control">
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-2">
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
                    document.querySelectorAll(".checklist-approval").forEach(
                        (checkbox) => {checkbox.setAttribute('checked', 'checked')
                    })
                } else {
                    document.querySelectorAll(".checklist-approval").forEach(
                        (checkbox) => {checkbox.removeAttribute('checked')
                    })
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
                url: route('laphar-pelatihan-faba.search'),
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
                        <td class="align-middle">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.polda }</td>
                        <td class="align-middle">${ item.lokasi_pelatihan }</td>
                        <td class="align-middle">${ item.nama_trainer }</td>
                        <td class="align-middle">${ item.jumlah_peserta }</td>
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
                                            lokasi_pelatihan: '${item.lokasi_pelatihan}',
                                            polda: '${item.polda}',
                                            nama_trainer: '${item.nama_trainer}',
                                            jumlah_peserta: '${item.jumlah_peserta}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('laphar-pelatihan-faba.destroy', item.id) }" method="post" id="${ item.id }">
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
                    table += listRiwayatApproval(item.approvals, 8);
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

            let polda = document.getElementById('select-polda');
            if (polda) listLaporan.updateState('polda', polda.value);
            listLaporan.updateState('search', document.querySelector('input[name=search]').value)
            listLaporan.updateState('start_date', document.querySelector('input[name=start_date]').value)
            listLaporan.updateState('end_date', document.querySelector('input[name=end_date]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })

        const insertValueToFormEdit = ({
            id, polda, lokasi_pelatihan, nama_trainer, jumlah_peserta
        }) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('laphar-pelatihan-faba.update',  id))
            elFormEdit.querySelector('input[name="polda"]').value               = polda
            elFormEdit.querySelector('input[name="lokasi_pelatihan"]').value = lokasi_pelatihan
            elFormEdit.querySelector('input[name="nama_trainer"]').value         = nama_trainer
            elFormEdit.querySelector('input[name="jumlah_peserta"]').value  = jumlah_peserta
        }
    </script>
@endsection
