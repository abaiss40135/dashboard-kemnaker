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
            @slot('title', 'Laporan Harian Minyak Goreng')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('neo-laphar-minyak-goreng.template-excel'))
                        @slot('other', route('neo-laphar-minyak-goreng.template-data'))
                        @slot('other_text', 'Unduh Data Pasar Nasional')
                        @slot('import_excel', route('neo-laphar-minyak-goreng.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-4"><b>Preview Laporan Harian Minyak Goreng</b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('neo-laphar-minyak-goreng.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                              @foreach ($laporan[0] as $key => $item)
                                                    @if($key > 0)
                                                        <div class="mb-3">
                                                            <span class="d-flex justify-content-between align-items-center bg-olive text-white p-3"
                                                                data-target="#collapse{{ $key }}"
                                                                aria-controls="collapse{{ $key }}" data-toggle="collapse"
                                                                aria-expanded="false" type="button" onclick="angleIcon(this)">
                                                                <h5 class="mb-0">{{ $item[0] }}</h5>
                                                                <i class="fas fa-angle-right d-flex"></i>
                                                            </span>
                                                            <div id="collapse{{ $key }}" class="row mt-3 collapse show">
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{ $key }}][kab_kota]">Kabupaten/Kota</label>
                                                                    <input type="text" name="laporan[{{ $key }}][kab_kota]"
                                                                        id="laporan[{{ $key }}][kab_kota]"
                                                                        class="form-control" value="{{ $item[1] }}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][kelurahan]">Kelurahan</label>
                                                                    <input type="text" name="laporan[{{$key}}][kelurahan]"
                                                                           id="laporan[{{$key}}][kelurahan]"
                                                                           class="form-control" value="{{$item[2]}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][nama_pasar]">Nama Pasar</label>
                                                                    <input type="text" name="laporan[{{$key}}][nama_pasar]"
                                                                           id="laporan[{{$key}}][nama_pasar]"
                                                                           class="form-control" value="{{$item[3]}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][alamat_pasar]">Alamat Pasar</label>
                                                                    <input type="text" name="laporan[{{$key}}][alamat_pasar]"
                                                                           id="laporan[{{$key}}][alamat_pasar]"
                                                                           class="form-control" value="{{$item[4]}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][ketersediaan]">Ketersediaan Minyak Curah (Kosong/Langka/Cukup/Lebih)</label>
                                                                    <input type="text" name="laporan[{{$key}}][ketersediaan]"
                                                                           id="laporan[{{$key}}][ketersediaan]"
                                                                           class="form-control" value="{{$item[5]}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][kebutuhan]">Kebutuhan Minyak Curah (Liter/Kg)</label>
                                                                    <input type="text" name="laporan[{{$key}}][kebutuhan]"
                                                                           id="laporan[{{$key}}][kebutuhan]"
                                                                           class="form-control" value="{{$item[6]}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][pola_pengiriman]">Pola Pengiriman (Berapa Kali Sehari)</label>
                                                                    <input type="text" name="laporan[{{$key}}][pola_pengiriman]"
                                                                           id="laporan[{{$key}}][pola_pengiriman]"
                                                                           class="form-control" value="{{$item[7]}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][harga_tertinggi]">Harga TERTINGGI Curah (Rp)</label>
                                                                    <input type="input" name="laporan[{{$key}}][harga_tertinggi]"
                                                                           id="laporan[{{$key}}][harga_tertinggi]"
                                                                           class="form-control" value="{{$item[8]}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][harga_terendah]">Harga TERENDAH Curah (Rp)</label>
                                                                    <input type="input" name="laporan[{{$key}}][harga_terendah]"
                                                                           id="laporan[{{$key}}][harga_terendah]"
                                                                           class="form-control" value="{{$item[9]}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="laporan[{{$key}}][harga_rerata]">Harga RATA-RATA (Rp)</label>
                                                                    <input type="input" name="laporan[{{$key}}][harga_rerata]"
                                                                           id="laporan[{{$key}}][harga_rerata]"
                                                                           class="form-control" value="{{$item[10]}}">
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
                            <h2 class="h4 text-center"><b>Laporan Harian Minyak Goreng</b></h2>
                            <form action="{{ route('neo-laphar-minyak-goreng.export-excel') }}"
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
                                @slot('route', route('neo-laphar-minyak-goreng.export-excel'))
                                @slot('className', 'd-none')
                            @endcomponent
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            @can('sislap_approval_create')
                                            <th class="align-middle text-center" width="4%">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                                                    <label class="form-check-label" for="check-all"></label>
                                                </div>
                                            </th>
                                            @endcan
                                            <th class="align-middle text-center">No</th>
                                            <th class="align-middle text-center">Kabupaten/Kota</th>
                                            <th class="align-middle text-center">Kelurahan</th>
                                            <th class="align-middle text-center">Nama Pasar</th>
                                            <th class="align-middle text-center">Alamat Pasar</th>
                                            <th class="align-middle text-center">Ketersediaan Minyak Curah (Kosong/Langka/Cukup/Lebih)</th>
                                            <th class="align-middle text-center">Kebutuhan Minyak Curah (Liter/Kg)</th>
                                            <th class="align-middle text-center">Pola Pengiriman (Berapa Kali Sehari)</th>
                                            <th class="align-middle text-center">Harga Tertinggi Curah (Rp)</th>
                                            <th class="align-middle text-center">Harga Terendah Curah (Rp)</th>
                                            <th class="align-middle text-center">Harga Rata-rata (Rp)</th>
                                            <th class="align-middle">Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle" width="4%">Aksi</th>
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
                    <form action="#" method="post" id="form-edit">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="kab_kota">Kabupaten/Kota</label>
                                <input type="text" name="kab_kota" id="kab_kota" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kelurahan">Kelurahan</label>
                                <input type="text" name="kelurahan" id="kelurahan" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nama_pasar">Nama Pasar</label>
                                <input type="text" name="nama_pasar" id="nama_pasar" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="alamat_pasar">Alamat Pasar</label>
                                <input type="text" name="alamat_pasar" id="alamat_pasar" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ketersediaan">Ketersediaan Minyak Curah (Kosong/Langka/Cukup/Lebih)</label>
                                <input type="text" name="ketersediaan" id="ketersediaan" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kebutuhan">Kebutuhan Minyak Curah (Liter/Kg)</label>
                                <input type="text" name="kebutuhan" id="kebutuhan" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="pola_pengiriman">Pola Pengiriman (Berapa Kali Sehari)</label>
                                <input type="text" name="pola_pengiriman" id="pola_pengiriman" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="harga_tertinggi">Harga TERTINGGI Curah (Rp)</label>
                                <input type="number" name="harga_tertinggi" id="harga_tertinggi" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="harga_terendah">Harga TERENDAH Curah (Rp)</label>
                                <input type="number" name="harga_terendah" id="harga_terendah" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="harga_rerata">Harga RATA-RATA (Rp)</label>
                                <input type="number" name="harga_rerata" id="harga_rerata" class="form-control">
                            </div>
                            <div class="d-flex justify-content-end col-12">
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
                url: route('neo-laphar-minyak-goreng.search'),
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
                        <td class="align-middle">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.kab_kota }</td>
                        <td class="align-middle">${ item.kelurahan }</td>
                        <td class="align-middle">${ item.nama_pasar }</td>
                        <td class="align-middle">${ item.alamat_pasar }</td>
                        <td class="align-middle">${ item.ketersediaan }</td>
                        <td class="align-middle">${ item.kebutuhan }</td>
                        <td class="align-middle">${ item.pola_pengiriman }</td>
                        <td class="align-middle">${ item.harga_tertinggi }</td>
                        <td class="align-middle">${ item.harga_terendah }</td>
                        <td class="align-middle">${ item.harga_rerata }</td>
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
                                            id              : '${item.id}',
                                            kab_kota        : '${item.kab_kota}',
                                            kelurahan       : '${item.kelurahan}',
                                            nama_pasar      : '${item.nama_pasar}',
                                            alamat_pasar    : '${item.alamat_pasar}',
                                            ketersediaan    : '${item.ketersediaan}',
                                            kebutuhan       : '${item.kebutuhan}',
                                            pola_pengiriman : '${item.pola_pengiriman}',
                                            harga_tertinggi : '${item.harga_tertinggi}',
                                            harga_terendah  : '${item.harga_terendah}',
                                            harga_rerata    : '${item.harga_rerata}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('neo-laphar-minyak-goreng.destroy', item.id) }" method="post" id="${ item.id }">
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
                id, kab_kota, kelurahan, nama_pasar, alamat_pasar, ketersediaan,
                kebutuhan, pola_pengiriman, harga_tertinggi, harga_terendah, harga_rerata
            }) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('neo-laphar-minyak-goreng.update', id))
            elFormEdit.querySelector('input[name=kab_kota]').value        = kab_kota
            elFormEdit.querySelector('input[name=kelurahan]').value       = kelurahan
            elFormEdit.querySelector('input[name=nama_pasar]').value      = nama_pasar
            elFormEdit.querySelector('input[name=alamat_pasar]').value    = alamat_pasar
            elFormEdit.querySelector('input[name=ketersediaan]').value    = ketersediaan
            elFormEdit.querySelector('input[name=kebutuhan]').value       = kebutuhan
            elFormEdit.querySelector('input[name=pola_pengiriman]').value = pola_pengiriman
            elFormEdit.querySelector('input[name=harga_tertinggi]').value = harga_tertinggi
            elFormEdit.querySelector('input[name=harga_terendah]').value  = harga_terendah
            elFormEdit.querySelector('input[name=harga_rerata]').value    = harga_rerata
        }
    </script>
@endsection
