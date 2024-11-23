@extends('templates.admin-lte.admin', ['title' => 'Laporan Harian Rutin Kegiatan Cegah Tindak Pidana Dan Gangguan Kamtibmas'])
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
                    <a href="{{ route('laphar-kegiatan-kamtibmas.create') }}" class="btn btn-success">Tambah Laporan</a>
                </div>
                {{-- <div class="pr-3">
                    <a href="{{ route('laphar-kegiatan-kamtibmas.template') }}" class="btn btn-success">Unduh Format Laporan</a>
                </div>
                <div>
                    @if(!empty(auth()->user()->personel->kode_satuan) && can('lapsubjar_create'))
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_upload">Unggah Laporan</button>
                    @endif
                </div> --}}
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('laphar-kegiatan-kamtibmas.export') }}" method="POST">
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
                        @endif
                        <div class="form-group {{ roles(['administrator', 'operator_bagopsnalev_mabes']) ? 'col-md-3' : 'col-md-6' }}">
                            <label for="start_date">Tanggal Kegiatan</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group {{ roles(['administrator', 'operator_bagopsnalev_mabes']) ? 'col-md-3' : 'col-md-6' }}">
                            <label for="end_date">Sampai Tanggal</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-12 form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="search">Pencarian</label>
                                    <input type="search" id="search" name="search" class="form-control form-search"
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
                <hr>
            </form>
            @can('sislap_approval_create')
            @if(roles(['operator_bagopsnalev_polda']))
                <button type="button" class="btn btn-primary"
                        data-toggle="modal" data-target="#modal_submit_approval">Ajukan Approval ke Mabes Polri</button>
            @elseif(roles(['operator_bagopsnalev_polres']))
                <button type="button" class="btn btn-primary" id="btn-ajukan-approval">Ajukan Approval ke Polda</button>
            @endif
            @endcan
            <hr>
            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered">
                    <colgroup>
                        <col span="1" style="visibility: {{ roles(['operator_bagopsnalev_polda']) ? 'collapse' : 'visible' }};">
                    </colgroup>
                    <thead class="text-center bg-primary">
                    <tr>
                        @can('sislap_approval_create')
                        <th class="align-middle text-center" rowspan="2">
                            @if( roles(['operator_bagopsnalev_polres']))
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                                <label class="form-check-label" for="check-all"></label>
                            </div>
                            @endif
                        </th>
                        @endcan
                        <th class="align-middle" style="width: 5%;">No</th>
                        <th class="align-middle" style="width: 30%;">Polda</th>
                        <th class="align-middle" style="width: 30%;">Polres</th>
                        <th class="align-middle" style="width: 10%;">Total Kegiatan</th>
                        <th class="align-middle">Tanggal Laporan</th>
                        @canany(['nonlapbul_edit', 'nonlapbul_destroy'])
                        <th class="align-middle">Aksi</th>
                        @endcanany
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
@push('modals')
<div class="modal fade" id="modalRiwayatApproval" tabindex="-1" aria-labelledby="modalRiwayatApprovalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRiwayatApprovalLabel">Riwayat Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@if(roles(['operator_bagopsnalev_polda']))
<div class="modal fade" id="modal_submit_approval" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Tanggal Laporan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formSubmitApproval">
                    <div class="form-group">
                        <input type="date" id="date_approval" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div>
                            <button class="btn btn-warning" data-dismiss="modal" id="formSubmitApprovalDismiss">Batal</button>
                            <button type="submit" class="btn btn-primary">Pilih</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endpush
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
            document.getElementById('check-all')?.addEventListener('change', function () {
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

        document.getElementById('btn-ajukan-approval')?.addEventListener('click', function () {
            let data = getSelectedChecklist()
            if (data) {
                sendApproval(data)
            }
        })

        const formSubmitApproval = document.querySelector('#formSubmitApproval');
        const btnSubmit = formSubmitApproval?.querySelector('button[type="submit"]')
        document?.querySelector('button[data-target="#modal_submit_approval"]')
                ?.addEventListener('click', () => {
            btnSubmit.removeAttribute('disabled')
        })

        formSubmitApproval?.addEventListener('submit', (e) => {
            e.preventDefault()
            btnSubmit.setAttribute('disabled', 'disabled')

            axios.post("{{ $route_list ?? '' }}" || route('approval-laporan.list-polres'), {
                date: formSubmitApproval.querySelector('#date_approval').value,
                model: '{{ $model }}'
            })
            .then((response) => response.data)
            .then((data) => {
                formSubmitApproval
                    .querySelector('#formSubmitApprovalDismiss')
                    .dispatchEvent(new Event('click', { bubbles: true }))
                Swal.fire({
                    title: 'Pengajuan Approval',
                    html: `<ul class="text-left">${data.status_lapor.map((polres) => {
                                return '<li><span class="d-flex justify-content-between"><span>' + polres.nama_satuan + '</span>'
                                + (polres.status
                                    ? '<i class="fa fa-check-circle text-success" title="sudah lapor"></i>'
                                    : '<i class="fa fa-times-circle text-danger" title="belum melapor"></i>')
                                + '</span></li>'
                            }).join('')}</ul>`,
                    showCancelButton: true,
                    reverseButtons: true,
                    icon: 'warning',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ajukan Approval'
                })
                .then((res) => {
                    if (res.isConfirmed) {
                        if (data.can_send_approval) { sendApproval(data.laporan_ids) }
                        else {
                            swalError('',
                                `<p>Kami menemukan bahwa salah satu polres di polda anda belum mengirimkan laporan</p>
                                 <p>Anda hanya dapat mangajukan approval setelah laporan dari seluruh polres lengkap.</p>
                                 <p>Mohon cek kembali laporan dan pastikan menggunakan format yang terbaru</p>`
                            );
                        }
                    }
                })
            })
        })
        @endcan

        let checkApproval = (laporanID) => {
            event.preventDefault();
            axios({
                method: 'get',
                    url: route('laphar-kegiatan-kamtibmas.show', laporanID)
            }).then((response) => {
                $('#modalRiwayatApproval .modal-body').html('');
                $('#modalRiwayatApproval .modal-body').append(`<div class="table-responsive"><table class="table table-bordered"><tbody>`+ listRiwayatApproval(response.data.approvals, 0) +`</tbody></table></div>`);
                $('#modalRiwayatApproval .expandable-body').removeClass('d-none');
                $('#modalRiwayatApproval').modal();
            });
        }

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
                url: route('laphar-kegiatan-kamtibmas.search'),
                data: {
                    start_date: document.querySelector('input[name=start_date]').value,
                    end_date: document.querySelector('input[name=end_date]').value
                }
            },
            content: (item, rowNumber) => {
                let haveApprovals       = item.approvals.length > 0;
                let checklistApproval   = item.need_approve ? `<div class="form-check">
                                                                <input type="checkbox" class="form-check-input checklist-approval" name="check_approval[${item.id}]" data-id="${ item.id }" aria-label="check-row">
                                                            </div>` : '';
                let table = `
                    <tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"': ''} data-widget="expandable-table" aria-expanded="false">
                        @can('sislap_approval_create')
                        <th class="align-middle text-center">
                        ${ checklistApproval }
                        </th>
                        @endcan
                        <th class="align-middle text-center">${ rowNumber }</th>
                        <td class="align-middle">${ item.polda }</td>
                        <td class="align-middle">${ item.polres }</td>
                        <td class="align-middle text-center">${ item.total_kegiatan }</td>
                        <td class="align-middle">${ item.tanggal }</td>
                        @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                        <td class="align-middle text-center">
                            <span style="display:grid;grid-template-columns: auto auto;">
                            ${haveApprovals ? `
                                <button class="btn btn-check btn-info m-1"
                                        onclick="checkApproval([${item.id}], true)">
                                        <i class="fas fa-info-circle"></i>
                                </button>` : ''}
                            @can('sislap_approval_decline')
                                ${ !haveApprovals || item.approval.is_approve === null || item.approval.is_approve ? `
                                    <button class="btn btn-decline btn-danger m-1"
                                            onclick="decline(${item.id})">
                                            <i class="fas fa-times-circle"></i>
                                    </button>
                                ` : ``}
                            @endcan
                            @can('lapsubjar_edit')
                                ${ haveApprovals && !item.need_approve ? `` : `
                                    <a href="${ route('laphar-kegiatan-kamtibmas.edit', item.id) }"
                                        class="btn btn-edit btn-warning m-1">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                ` }
                            @endcan
                            @can('lapsubjar_destroy')
                                ${ !haveApprovals || !item.approval.is_approve ? `
                                <form action="${ route('laphar-kegiatan-kamtibmas.destroy', item.id) }" method="post" id="${ item.id }">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-delete m-1" type="submit" onclick="event.preventDefault(); deleteConfirm(${ item.id })">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>` : ``}
                            @endcan
                            </span>
                        </td>
                        @endcanany
                </tr>`;

                let listKegiatan = "";
                item.kegiatans.forEach((kegiatan, index) => {
                    listKegiatan += `<tr>
                                        <td class="text-center">${ ++index }</td>
                                        <td >${ kegiatan.nama }</td>
                                        <td class="text-center">${ kegiatan.pivot.jumlah }</td>
                                    </tr>`;
                });

                table += `
                    <tr class="expandable-body d-none">
                        <td colspan="14">
                            <table class="w-100 table-bordered table-striped mt-1 mb-3" style="">
                                <thead>
                                <tr class="text-center bg-dark text-white">
                                    <td width="11%">No</td>
                                    <td width="67%">Kegiatan</td>
                                    <td width="13%">Jumlah</td>
                                </tr>
                                </thead>
                                <tbody>
                                    `+ listKegiatan +`
                                </tbody>
                            </table>
                        </td>
                    </tr>`;
                return table;
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
                    return {
                        polda: params.term,
                    }
                }
            });
        }
        initSelectPolda()

        document.getElementById('btn-search').addEventListener('click', (event) => {
            event.preventDefault()
            listLaporan.updateState('search', document.querySelector('input[name=search]').value)
            listLaporan.updateState('polda', document.querySelector('select[name=polda]')?.value)
            // listLaporan.updateState('polres', document.querySelector('select[name=polres]').value)
            listLaporan.updateState('start_date', document.querySelector('input[name=start_date]').value)
            listLaporan.updateState('end_date', document.querySelector('input[name=end_date]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })

        document.getElementById('btn-reset').addEventListener('click', (event) => {
            $('#select-polda').val(null).trigger("change")
            // $('#select-polres').val(null).trigger("change")
        })
    </script>
@endsection
