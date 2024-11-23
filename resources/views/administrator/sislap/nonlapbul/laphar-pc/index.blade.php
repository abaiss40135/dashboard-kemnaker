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
            @slot('title', 'Laporan Harian Pc Pen')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('laphar-pc.template-excel'))
                        @slot('import_excel', route('laphar-pc.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Pc Pen</b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('laphar-pc.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                                <tr class="text-center bg-primary">
                                                    <th class="align-middle" rowspan="2">No</th>
                                                    <th class="align-middle" rowspan="2">Satker</th>
                                                    <th class="align-middle" colspan="8">Lokasi</th>
                                                </tr>
                                                <tr class="bg-primary">
                                                    <td>Perbelanjaan (Mall, Pasar Tradisional, Pasar Modern)</td>
                                                    <td>Perkantoran (Kantor Pemerintah, Kantor Swasta)</td>
                                                    <td>Pemukiman</td>
                                                    <td>Kawasan</td>
                                                    <td>Transportasi Publik</td>
                                                    <td>Tempat Wisata</td>
                                                    <td>Komunitas Hobby (Pencinta Burung, Gowes, dll)</td>
                                                    <td>Jumlah Komunitas yang Telibat</td>
                                                </tr>
                                              @foreach ($laporan[0] as $key => $item)
                                                  @if($key > 1)
                                                    <tr>
                                                        <th class="text-center">{{ $item[0] }}</th>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][satker]"
                                                                    id="laporan[{{ $key }}][satker]" rows="4" maxlength="30">{{ $item[1] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][perbelanjaan]"
                                                                    id="laporan[{{ $key }}][perbelanjaan]" rows="4">{{ $item[2] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][perkantoran]"
                                                                    id="laporan[{{ $key }}][perkantoran]" rows="4" maxlength="100">{{ $item[3] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][pemukiman]"
                                                                    id="laporan[{{ $key }}][pemukiman]" rows="4" maxlength="255">{{ $item[4] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][kawasan]"
                                                                    id="laporan[{{ $key }}][kawasan]" rows="4" maxlength="100">{{ $item[5] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][transportasi_publik]"
                                                                    id="laporan[{{ $key }}][transportasi_publik]" rows="4" maxlength="100">{{ $item[6] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][tempat_wisata]"
                                                                    id="laporan[{{ $key }}][tempat_wisata]" rows="4" maxlength="100">{{ $item[7] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][komunitas_hobi]"
                                                                    id="laporan[{{ $key }}][komunitas_hobi]" rows="4" maxlength="100">{{ $item[8] ?? '-' }}</textarea></td>
                                                        <td><textarea class="form-control" name="laporan[{{ $key }}][jumlah_komunitas]"
                                                                    id="laporan[{{ $key }}][jumlah_komunitas]" rows="4" maxlength="100">{{ $item[9] ?? '-' }}</textarea></td>
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
                            <h2 class="h4 text-center"><b>Laporan Harian Pc Pen</b></h2>
                            <form action="{{ route('laphar-pc.export-excel') }}"
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
                                @slot('route', route('laphar-pc.export-excel'))
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
                                            <th class="align-middle" rowspan="2">Satker</th>
                                            <th class="align-middle" colspan="8">Lokasi</th>
                                            <th class="align-middle" width="10" rowspan="2">Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle" width="4%" rowspan="2" >Aksi</th>
                                            @endcanany
                                        </tr>
                                        <tr class="bg-primary">
                                            <td>Perbelanjaan (Mall, Pasar Tradisional, Pasar Modern)</td>
                                            <td>Perkantoran (Kantor Pemerintah, Kantor Swasta)</td>
                                            <td>Pemukiman</td>
                                            <td>Kawasan</td>
                                            <td>Transportasi Publik</td>
                                            <td>Tempat Wisata</td>
                                            <td>Komunitas Hobby (Pencinta Burung, Gowes, dll)</td>
                                            <td>Jumlah Komunitas yang Telibat</td>
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
                            <label for="satker">Satker</label>
                            <input type="text" name="satker" id="satker" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="perbelanjaan">Perbelanjaan (Mall, Pasar Tradisional, Pasar Modern)</label>
                            <input type="text" name="perbelanjaan" id="perbelanjaan" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="perkantoran">Perkantoran (Kantor Pemerintah, Kantor Swasta)</label>
                            <input type="text" name="perkantoran" id="perkantoran" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pemukiman">Pemukiman</label>
                            <input type="text" name="pemukiman" id="pemukiman" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kawasan">Kawasan</label>
                            <input type="text" name="kawasan" id="kawasan" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="transportasi_publik">Transportasi Publik</label>
                            <input type="text" name="transportasi_publik" id="transportasi_publik" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tempat_wisata">Tempat Wisata</label>
                            <input type="text" name="tempat_wisata" id="tempat_wisata" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="komunitas_hobi">Komunitas Hobby (Pencinta Burung, Gowes, dll)</label>
                            <input type="text" name="komunitas_hobi" id="komunitas_hobi" rows="4" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jumlah_komunitas">Jumlah Komunitas yang Telibat</label>
                            <input type="text" name="jumlah_komunitas" id="jumlah_komunitas" rows="4" class="form-control">
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
                url: route('laphar-pc.search'),
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
                        <td class="align-middle">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.satker }</td>
                        <td class="align-middle ">${ item.perbelanjaan }</td>
                        <td class="align-middle ">${ item.perkantoran }</td>
                        <td class="align-middle ">${ item.pemukiman }</td>
                        <td class="align-middle ">${ item.kawasan }</td>
                        <td class="align-middle ">${ item.transportasi_publik }</td>
                        <td class="align-middle ">${ item.tempat_wisata }</td>
                        <td class="align-middle ">${ item.komunitas_hobi }</td>
                        <td class="align-middle ">${ item.jumlah_komunitas }</td>
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
                                            satker: '${item.satker}',
                                            perbelanjaan: '${item.perbelanjaan}',
                                            perkantoran: '${item.perkantoran}',
                                            pemukiman: '${item.pemukiman}',
                                            kawasan: '${item.kawasan}',
                                            transportasi_publik: '${item.transportasi_publik}',
                                            tempat_wisata: '${item.tempat_wisata}',
                                            komunitas_hobi: '${item.komunitas_hobi}',
                                            jumlah_komunitas: '${item.jumlah_komunitas}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('laphar-pc.destroy', item.id) }" method="post" id="${ item.id }">
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
                    table += listRiwayatApproval(item.approvals, 13);
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
            id, satker, perbelanjaan, perkantoran, pemukiman, kawasan,
            transportasi_publik, tempat_wisata, komunitas_hobi, jumlah_komunitas
        }) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('laphar-pc.update', id))
            elFormEdit.querySelector('input[name="satker"]').value           = satker
            elFormEdit.querySelector('input[name="perbelanjaan"]').value     = perbelanjaan
            elFormEdit.querySelector('input[name="perkantoran"]').value      = perkantoran
            elFormEdit.querySelector('input[name="pemukiman"]').value        = pemukiman
            elFormEdit.querySelector('input[name="kawasan"]').value          = kawasan
            elFormEdit.querySelector('input[name="transportasi_publik"]').value = transportasi_publik
            elFormEdit.querySelector('input[name="tempat_wisata"]').value    = tempat_wisata
            elFormEdit.querySelector('input[name="komunitas_hobi"]').value   = komunitas_hobi
            elFormEdit.querySelector('input[name="jumlah_komunitas"]').value = jumlah_komunitas
        }
    </script>
@endsection
