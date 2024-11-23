@extends('templates.admin-lte.admin', ['title' => 'Kegiatan Bantuan Pasca Gempa Cianjur'])
@section('customcss')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.select2')
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <div class="d-flex justify-content-stretch justify-content-sm-start">
                <div class="pr-3">
                    <a href="{{ route('bantuan-pasca-gempa-cianjur.create') }}" class="btn btn-success">Tambah Laporan</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="filter" action="" method="POST">
                @csrf
                <div class="alert alert-gray">
                    <h5><i class="icon fas fa-filter"></i> Filter</h5>
                    <hr/>
                    <div class="row">
                        @if(roles(['administrator', 'operator_bagopsnalev_mabes']))
                            <div class="form-group col-md-6">
                                <label for="select-polda">Polda</label>
                                <select name="polda" id="select-polda" class="form-control select2">
                                    <option></option>
                                </select>
                            </div>
{{--                            <div class="form-group col-md-6">--}}
{{--                                <label for="select-polres">Polres</label>--}}
{{--                                <select name="polres" id="select-polres" class="form-control select2">--}}
{{--                                    <option></option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
                        @endif
                        <div class="form-group {{ roles(['administrator', 'operator_bagopsnalev_mabes']) ? 'col-md-3' : 'col-md-6' }}">
                            <label for="start_date">Tanggal Mulai Kegiatan</label>
                            <input type="date" id="start_date" name="start_date" class="form-control">
                        </div>
                        <div class="form-group {{ roles(['administrator', 'operator_bagopsnalev_mabes']) ? 'col-md-3' : 'col-md-6' }}">
                            <label for="end_date">Sampai Tanggal</label>
                            <input type="date" id="end_date" name="end_date" class="form-control">
                        </div>
                        <div class="col-12 form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="search">Pencarian umum</label>
                                    <input type="text" id="search" name="search" class="form-control"
                                           placeholder="Cari berdasarkan kolom-kolom di tabel">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="col-12 d-flex align-items-end" style="column-gap: .4rem">
                                        <button class="btn btn-block btn-success" type="submit">Ekspor</button>
                                        <button type="reset" id="btn-reset" class="btn btn-block btn-warning">Reset</button>
                                        <button class="btn btn-block btn-primary" id="btn-search">
                                            <i class="fa fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr>

            @can('sislap_approval_create')
            <button type="button" class="btn btn-primary" id="btn-ajukan-approval">
                @if(role('operator_bagopsnalev_mabes')) Approve Laporan
                @else Ajukan Approval
                @endif

                @if(role('operator_bagopsnalev_polres')) ke Polda @endif
                @if(role('operator_bagopsnalev_polda')) ke Mabes Polri @endif
            </button>
            @endcan

            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered">
                    <thead class="text-center bg-primary">
                    <tr>
                        @can('sislap_approval_create')
                        <th class="align-middle text-center" rowspan="2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                                <label class="form-check-label" for="check-all"></label>
                            </div>
                        </th>
                        @endcan
                        <th class="align-middle" rowspan="2" style="width: 50px">NO</th>
                        <th class="align-middle" colspan="3" style="width: 750px">PETUGAS</th>
                        <th class="align-middle" rowspan="2" style="width: 250px">LOKASI KEGIATAN</th>
                        <th class="align-middle" rowspan="2" style="width: 100px">WAKTU KEGIATAN</th>
                        <th class="align-middle" rowspan="2" style="width: 100px">JENIS KEGIATAN</th>
                        <th class="align-middle" rowspan="2" style="width: 500px">URAIAN KEGIATAN</th>
                        <th class="align-middle" rowspan="2">Tanggal Laporan</th>
                        @canany(['nonlapbul_edit', 'nonlapbul_destroy'])
                        <th class="align-middle" rowspan="2">Aksi</th>
                        @endcanany
                    </tr>
                    <tr>
                        <th style="width: 250px">NAMA</th>
                        <th style="width: 250px">JABATAN</th>
                        <th style="width: 250px">KESATUAN</th>
                    </tr>
                    </thead>
                    <tbody id="content-wrapper"></tbody>
                </table>
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
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.twbs-pagination')
    @include('assets.js.select2')
    <script src="{{ asset('js/component-with-pagination.js') }}"></script>
    <script>
        const getSelectedChecklist = () => {
            let selected = document.querySelectorAll('.checklist-approval:checked')

            if (selected.length === 0) {
                swalWarning('Anda belum memilih data laporan. Mohon pilih terlebih dahulu')
                return false
            }

            let approvalRequestId = []
            selected.forEach((item) => { approvalRequestId.push(item.dataset.id) })

            return approvalRequestId
        }

        const decline = (laporan_id) => {
            if (!laporan_id) return false;

            Swal.fire({
                input: 'textarea',
                inputLabel: 'Catatan',
                inputPlaceholder: 'Input catatan tidak valid...',
                inputAttributes: { autocapitalize: 'off' },
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: (message) => { sendApproval([laporan_id], false, message) },
                allowOutsideClick: () => !Swal.isLoading()
            })
            .then((result) => { console.log(result) })
        }

        @can('sislap_approval_create')
        const initListenerApprovalAll = () => {
            document.getElementById('check-all')
            .addEventListener('change', function () {
                if (this.checked)
                    document.querySelectorAll(".checklist-approval")
                    .forEach((checkbox) => { checkbox.setAttribute('checked', 'checked') })
                else
                    document.querySelectorAll(".checklist-approval")
                    .forEach((checkbox) => { checkbox.removeAttribute('checked') })
            })
        }

        document.getElementById('btn-ajukan-approval')
        .addEventListener('click', () => {
            let data = getSelectedChecklist()
            if (data) sendApproval(data)
        })
        @endcan

        let sendApproval = (approvalRequestId, approval = null, keterangan = null) => {
            axios.post(route('approval-laporan.store'), {
                approvable_id: approvalRequestId,
                approvable_type: "{{ $model }}",
                is_approve: approval,
                keterangan: keterangan
            })
            .then((response) => {
                if (response.status === 200) {
                    swalSuccess(response.data.message)
                    listLaporan.updateState('page', 1)
                    listLaporan.fetchData()
                }
            })
            .catch((error) => {
                console.log(error)
            })
        }

        @can('sislap_approval_edit')
        document.getElementById('btn-approve-approval')
        .addEventListener('click', () => {
            sendApproval(getSelectedChecklist(), true)
        })
        @endcan

        const listLaporan = new ComponentWithPagination({
            contentWrapper: '#content-wrapper',
            messageWrapper: '#message-wrapper',
            paginator: '#paginator-wrapper',
            loader: '#shimmer-wrapper',
            searchState: {
                url: route('bantuan-pasca-gempa-cianjur.search'),
                data: {}
            },
            content: (item, rowNumber) => {
                let haveApprovals       = item.approvals.length > 0
                let checklistApproval   = item.need_approve
                    ? `<div class="form-check">
                          <input type="checkbox" class="form-check-input
                                 checklist-approval" name="check_approval[${item.id}]"
                                 data-id="${ item.id }" aria-label="check-row">
                      </div>`
                    : ''
                let table = (
                    `<tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"': ''}
                         ${ haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : '' }>
                        @can('sislap_approval_create')
                        <th class="align-middle text-center">${ checklistApproval }</th>
                        @endcan
                        <th class="align-middle text-center">${ rowNumber }</th>
                        <td class="align-middle">${ item.nama_petugas }</td>
                        <td class="align-middle">${ item.jabatan_petugas }</td>
                        <td class="align-middle">${ item.kesatuan_petugas }</td>
                        <td class="align-middle">${ item.lokasi_kegiatan }</td>
                        <td class="align-middle">${ item.waktu_kegiatan }</td>
                        <td class="align-middle">${ item.jenis_kegiatan }</td>
                        <td class="align-middle">${ item.uraian_kegiatan }</td>
                        <td class="align-middle">${ item.tanggal_laporan }</td>
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
                                <a href="${ route('bantuan-pasca-gempa-cianjur.edit', item.id) }"
                                    class="btn btn-edit btn-warning mb-1">
                                    <i class="fa fa-edit"></i>
                                </a>
                            ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('bantuan-pasca-gempa-cianjur.destroy', item.id) }"
                                  method="post"
                                  id="${ item.id }">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger btn-delete" type="submit"
                                        onclick="event.preventDefault(); deleteConfirm(${ item.id })">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>` : ``}
                            @endcan
                        </td>
                        @endcanany
                    </tr>`
                )

                if (haveApprovals) table += listRiwayatApproval(item.approvals, 11)

                return table
            },
            @can('sislap_approval_create')
            completeEvent: initListenerApprovalAll()
            @endcan
        })

        const initSelectPolda = (el = $('#select-polda')) => {
            buildSelect2Search({
                placeholder: '-- Pilih Polda --',
                url: route('polda.select2'),
                minimumInputLength: 0,
                selector: [{ id: el }],
                query: function (params) {
                    return { polda: params.term }
                }
            })
        }
        initSelectPolda()

        document.getElementById('btn-search').addEventListener('click', (event) => {
            event.preventDefault()
            let filter = document.querySelector('form#filter')

            listLaporan.updateState('search', filter.querySelector('input[name=search]').value)
            listLaporan.updateState('polda', filter.querySelector('select[name=polda]')?.value)
            // listLaporan.updateState('polres', filter.querySelector('select[name=polres]').value)
            listLaporan.updateState('start_date', filter.querySelector('input[name=start_date]').value)
            listLaporan.updateState('end_date', filter.querySelector('input[name=end_date]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })

        document.getElementById('btn-reset').addEventListener('click', (event) => {
            $('#select-polda').val(null).trigger("change")
            $('#select-polres').val(null).trigger("change")
        })
    </script>
@endsection
