@extends('templates.admin-lte.admin', ['title' => $title])
@section('customcss')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.select2')
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <div class="d-flex" style="column-gap: 1rem">
                <a href="{{ $route_template }}" class="btn btn-success">Unduh Format Laporan</a>
                @if(!empty(auth()->user()->personel->kode_satuan) && can('lapsubjar_create'))
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_upload">Unggah Laporan</button>
                @endif
                @yield('custom_button')
            </div>
        </div>
        <div class="card-body">
            @if($laporan_exist)
            <h2 class="h4 text-center mb-3"><b>Preview {{ $title }}</b></h2>
            <div class="table-responsive">
                <form action="{{ $route_store }}" method="POST" onclick="disableSubmitButtonTemporarily()"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="table-responsive">
                        @yield('table_preview')
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <cite>{!! $cite ?? '' !!}</cite>
                        <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                    </div>
                </form>
            </div>
            @else
            <h2 class="h4 text-center mb-3"><b>{{ $title }}</b></h2>
            <form action="{{ $route_export }}" method="POST">
                @csrf
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
            @if(roles(['operator_bagopsnalev_polda']))
            <button type="button" class="btn btn-primary"
                    data-toggle="modal" data-target="#modal_submit_approval">Ajukan Approval ke Mabes Polri</button>
            <hr>
            @elseif(roles(['operator_bagopsnalev_polres']))
            <button type="button" class="btn btn-primary" id="btn-ajukan-approval">Ajukan Approval ke Polda</button>
            <hr>
            @endif
            <div class="table-responsive">
                @yield('table_data')
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
            @endif
        </div>
    </div>
    <div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ $route_import }}" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Unggah Laporan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="custom-file">
                                @csrf
                                <input type="file" class="custom-file-input" required
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                    name="file-laporan" id="file-laporan" onchange="setFileLabel(this)">
                                <label for="file-laporan" class="custom-file-label form-control">Pastikan file excel sesuai dengan template</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary" type="submit">Unggah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form-edit" class="row" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @yield('form_edit')
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <div>
                                <button type="reset" class="btn btn-warning" data-toggle="modal" data-target="#modal_edit">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_submit_approval" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih @if(isset($range) && $range == 'monthly') Bulan @else Tanggal @endif Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formSubmitApproval">
                        <div class="form-group">
                            @if(isset($range) && $range == 'monthly')
                            <input type="month" id="date_approval" class="form-control" required>
                            @else
                            <input type="date" id="date_approval" class="form-control" required>
                            @endif
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
@endpush
@section('customjs')
    @include('assets.js.twbs-pagination')
    @include('assets.js.select2')
    <script src="{{ asset('js/component-with-pagination.js') }}"></script>
    @yield('row_table')
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

        document.querySelector('#btn-ajukan-approval')?.addEventListener('click', function () {
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
                @if(isset($range) && $range == 'monthly')
                range: 'monthly',
                @endif
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

        let sendApproval = (approvalRequestId, approval = null, keterangan = null) => {
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
                console.error(error);
            });
        }

        @can('sislap_approval_edit')
            document.getElementById('btn-approve-approval')?.addEventListener('click', function () {
                sendApproval(getSelectedChecklist(), true)
            })
        @endcan

        let listLaporan = new ComponentWithPagination({
                contentWrapper: '#content-wrapper',
                messageWrapper: '#message-wrapper',
                paginator: '#paginator-wrapper',
                loader: '#shimmer-wrapper',
                searchState: {
                    url: '{{ $route_search }}',
                    data: {}
                },
                content: (item, rowNumber) => createTableRow(item, rowNumber),
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

        // let listRiwayatApproval = (approvals, colspan) => {
        //     let body = '';
        //     approvals.forEach((approval, key) => {
        //         body += `<tr class="text-center${approval.is_approve == null
        //                     ? ' bg-yellow'
        //                     : (approval.is_approve ? ' bg-success' : ' bg-danger')}">
        //             <td>${key + 1}</td>
        //             <td>${approval.is_approve == null
        //                     ? 'Diajukan'
        //                     : (approval.is_approve ? 'Diterima' : 'Ditolak')}</td>
        //             <td>${approval.keterangan}</td>
        //             <td>${approval.personel ? approval.personel.nama + ' (' + approval.level.toUpperCase() + ')' : ''}</td>
        //             <td>${approval.waktu}</td>
        //         </tr>`;
        //     })

        //     return `<tr class="expandable-body d-none">
        //             <td colspan="${colspan}">
        //                 <table class="w-100 table-bordered table-striped mt-1 mb-3">
        //                     <thead>
        //                         <tr class="text-center bg-dark text-white">
        //                             <td width="5%">No</td>
        //                             <td width="10%">Status</td>
        //                             <td width="40%">Keterangan</td>
        //                             <td width="25%">Approver</td>
        //                             <td width="20%">Tanggal</td>
        //                         </tr>
        //                     </thead>
        //                     <tbody>${body}</tbody>
        //                 </table>
        //             </td>
        //         </tr>`;
        // }

        document.getElementById('btn-search')?.addEventListener('click', (event) => {
            event.preventDefault()

            let polda = document.getElementById('select-polda');
            if (polda) listLaporan.updateState('polda', polda.value);
            listLaporan.updateState('search', document.querySelector('input[name=search]').value)
            listLaporan.updateState('start_date', document.querySelector('input[name=start_date]').value)
            listLaporan.updateState('end_date', document.querySelector('input[name=end_date]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })

        const insertValueToFormEdit = (route, fields) => {
            const form = document.getElementById('form-edit')
            const btnReset = form.querySelector('button[type="reset"]')

            btnReset.dispatchEvent(new Event('click'))
            form.action = route

            for(let item in fields) {
                let el = form.querySelector(`[name="${item}"]`)
                if (el) el.value = fields[item]
            }

            form.setAttribute('action', route)
        }
    </script>
@endsection
