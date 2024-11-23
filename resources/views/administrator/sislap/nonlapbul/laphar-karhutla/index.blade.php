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
            @slot('title', 'Laporan Harian Karhutla')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('laphar-karhutla.template-excel'))
                        @slot('import_excel', route('laphar-karhutla.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Harian Karhutla</b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('laphar-karhutla.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                                <tr class="text-center bg-primary">
                                                    <th class="align-middle" rowspan="2">No</th>
                                                    <th class="align-middle" rowspan="2">Lokasi/Polres</th>
                                                    <th class="align-middle" colspan="3">Sosialisasi</th>
                                                </tr>
                                                <tr class="bg-primary text-center">
                                                    <td>Himbauan</td>
                                                    <td>FGD</td>
                                                    <td>Maklumat Kapolda</td>
                                                </tr>
                                              @foreach ($laporan[0] as $key => $item)
                                                  @if($key > 1)
                                                    <tr>
                                                        <th class="text-center">{{ $item[0] }}</th>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][polres]"
                                                                      id="laporan[{{ $key }}][polres]" rows="4" maxlength="30">{{ $item[1] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][himbauan]"
                                                                      id="laporan[{{ $key }}][himbauan]" rows="4">{{ $item[2] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][fgd]"
                                                                      id="laporan[{{ $key }}][fgd]" rows="4" maxlength="100">{{ $item[3] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][maklumat_kapolda]"
                                                                      id="laporan[{{ $key }}][maklumat_kapolda]" rows="4" maxlength="255">{{ $item[4] ?? '-' }}</textarea></td>
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
                            <h2 class="h4 text-center"><b>Laporan Harian Karhutla</b></h2>
                            <form action="{{ route('laphar-karhutla.export-excel') }}"
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
                                @slot('route', route('laphar-karhutla.export-excel'))
                                @slot('className', 'd-none')
                            @endcomponent
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            @can('sislap_approval_create')
                                            <th class="align-middle text-center" width="4%" rowspan="2" >
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                                                    <label class="form-check-label" for="check-all"></label>
                                                </div>
                                            </th>
                                            @endcan
                                            <th class="align-middle" rowspan="2">No</th>
                                            <th class="align-middle" rowspan="2">Lokasi/Polres</th>
                                            <th class="align-middle" colspan="3">Sosialisasi</th>
                                            <th class="align-middle" width="10" rowspan="2" >Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle" width="4%" rowspan="2" >Aksi</th>
                                            @endcanany
                                        </tr>
                                        <tr class="bg-primary text-center">
                                            <td>Himbauan</td>
                                            <td>FGD</td>
                                            <td>Maklumat Kapolda</td>
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
                    <form action="#" method="post" id="form-edit">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="polres">Lokasi/Polres</label>
                            <input type="text" name="polres" id="polres" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="himbauan">Himbauan</label>
                            <input type="text" name="himbauan" id="himbauan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="fgd">FGD</label>
                            <input type="text" name="fgd" id="fgd" rows="4" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="maklumat_kapolda">Maklumat Polda</label>
                            <input type="text" name="maklumat_kapolda" id="maklumat_kapolda" rows="4" class="form-control">
                        </div>
                        <div class="d-flex justify-content-end">
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
                url: route('laphar-karhutla.search'),
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
                        <td class="align-middle ">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.polres }</td>
                        <td class="align-middle ">${ item.himbauan }</td>
                        <td class="align-middle ">${ item.fgd }</td>
                        <td class="align-middle ">${ item.maklumat_kapolda }</td>
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
                                            polres: '${item.polres}',
                                            himbauan: '${item.himbauan}',
                                            fgd: '${item.fgd}',
                                            maklumat_kapolda: '${item.maklumat_kapolda}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('laphar-karhutla.destroy', item.id) }" method="post" id="${ item.id }">
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
                    table += listRiwayatApproval(item.approvals, 9);
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

        const insertValueToFormEdit = ({id, polres, himbauan, fgd, maklumat_kapolda}) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('laphar-karhutla.update', id))
            elFormEdit.querySelector('input[name="polres"]').value   = polres
            elFormEdit.querySelector('input[name="himbauan"]').value = himbauan
            elFormEdit.querySelector('input[name="fgd"]').value      = fgd
            elFormEdit.querySelector('input[name="maklumat_kapolda"]').value = maklumat_kapolda
        }
    </script>
@endsection
