@extends('templates.admin-lte.sislap', [
    'title'          => 'Laporan Monitoring PMK',
    'route_template' => route('penyakit-mulut-kuku.template-excel'),
    'route_import'   => route('penyakit-mulut-kuku.import-excel'),
    'route_export'   => route('penyakit-mulut-kuku.export-excel'),
    'route_store'    => route('penyakit-mulut-kuku.store'),
    'route_search'   => route('penyakit-mulut-kuku.search'),
    'route_destroy'  => route('penyakit-mulut-kuku.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
    'cite'           => 'Jumlah harus diisi dengan angka dan tidak boleh kosong. Apabila tidak ada kejadian, silahkan isikan dengan <b>angka 0</b>'
])
@push('styles')
    <style>
        .cell-category {
            width: 460px;
        }
    </style>
@endpush
@section('table_preview')
    <table class="table table-hover table-bordered" style="table-layout: fixed;">
        <thead class="text-center bg-primary">
            <tr>
                <th rowspan="2" style="width: 50px;">NO</th>
                <th rowspan="2" style="width: 150px;">POLDA</th>
                <th rowspan="2" style="width: 200px;">POLRES</th>
                <th class="cell-category" colspan="{{ count($tipe) }}">JUMLAH POPULASI</th>
                <th class="cell-category" colspan="{{ count($tipe) }}">JUMLAH KANDANG</th>
                <th class="cell-category" colspan="{{ count($tipe) }}">JUMLAH HEWAN TERINFEKSI</th>
                <th class="cell-category" colspan="{{ count($tipe) }}">JUMLAH HEWAN YANG MATI</th>
                <th class="cell-category" colspan="{{ count($tipe) }}">JUMLAH HEWAN YANG DIPOTONG PAKSA (BERSYARAT)</th>
                <th class="cell-category" colspan="{{ count($tipe) }}">JUMLAH HEWAN YANG SEMBUH</th>
                <th class="cell-category" colspan="{{ count($tipe) }}">JUMLAH HEWAN SUDAH DIVAKSIN</th>
            </tr>
            <tr>
                @for($j = 0; $j < 7; $j++)
                    @for($i = 0; $i < count($tipe); $i++)
                        <th>{{ strtoupper($tipe[$i]) }}</th>
                    @endfor
                @endfor
            </tr>
        </thead>
        <tbody>
            @if(isset($laporan))
                @foreach($laporan[0] as $key => $item)
                    @if($key > 1)
                    <tr>
                        <th class="text-center">{{ $item[0] }}</th>
                        <td>
                            <input type="text" step="1" class="form-control"
                                name="laporan[{{ $key }}][polda]"
                                value="{{ $item[1] }}" required readonly>
                        </td>
                        <td>
                            <input type="text" step="1" class="form-control"
                                name="laporan[{{ $key }}][polres]"
                                value="{{ $item[2] }}" required readonly>
                        </td>
                        @php
                            $begin = 3;
                        @endphp
                        @foreach($kategori as $cat)
                            @foreach($tipe as $hewan)
                                <td>
                                    <input type="number" step="1" class="form-control"
                                        name="laporan[{{ $key }}][{{$cat}}_{{$hewan}}]"
                                        value="{{ $item[$begin++] }}" required>
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
@section('table_data')
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
                <th class="align-middle position-sticky" rowspan="2">NO</th>
                <th class="align-middle position-sticky" rowspan="2">POLDA</th>
                <th class="align-middle position-sticky" rowspan="2">POLRES</th>
                <th class="align-middle" colspan="{{ count($tipe) }}">JUMLAH POPULASI</th>
                <th class="align-middle" colspan="{{ count($tipe) }}">JUMLAH KANDANG</th>
                <th class="align-middle" colspan="{{ count($tipe) }}">JUMLAH HEWAN TERINFEKSI</th>
                <th class="align-middle" colspan="{{ count($tipe) }}">JUMLAH HEWAN YANG MATI</th>
                <th class="align-middle" colspan="{{ count($tipe) }}">JUMLAH HEWAN YANG DIPOTONG PAKSA (BERSYARAT)</th>
                <th class="align-middle" colspan="{{ count($tipe) }}">JUMLAH HEWAN YANG SEMBUH</th>
                <th class="align-middle" colspan="{{ count($tipe) }}">JUMLAH HEWAN SUDAH DIVAKSIN</th>
                <th class="align-middle" rowspan="2">Tanggal Laporan</th>
                @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                <th class="align-middle" rowspan="2">Aksi</th>
                @endcanany
            </tr>
            <tr>
                @for($j = 0; $j < 7; $j++)
                    @for($i = 0; $i < count($tipe); $i++)
                        <td>{{ strtoupper($tipe[$i]) }}</td>
                    @endfor
                @endfor
            </tr>
        </thead>
        <tbody id="content-wrapper"></tbody>
            {{-- TODO Generate sum content from sums return data --}}
        <tfoot id="sum-content"></tfoot>
    </table>
@endsection
@section('form_edit')
    <div class="row w-100">
        <div class="form-group col-sm-6">
            <label for="polda" class="form-label">Polda</label>
            <input type="text" name="polda" id="polda"
                    step="1" required readonly>
        </div>
        <div class="form-group col-sm-6">
            <label for="polres" class="form-label">Polres</label>
            <input type="text" name="polres" id="polres"
                    step="1" required readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">Jumlah Populasi</div>
        <div class="form-group col-sm-2">
            <label for="hewan_sapi" class="form-label">Sapi</label>
            <input type="number" name="hewan_sapi" id="hewan_sapi"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="hewan_kerbau" class="form-label">Kerbau</label>
            <input type="number" name="hewan_kerbau" id="hewan_kerbau"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="hewan_kambing" class="form-label">Kambing</label>
            <input type="number" name="hewan_kambing" id="hewan_kambing"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="hewan_domba" class="form-label">Domba</label>
            <input type="number" name="hewan_domba" id="hewan_kambing"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="hewan_babi" class="form-label">Babi</label>
            <input type="number" name="hewan_babi" id="hewan_babi"
                    step="1" required>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">Jumlah Kandang</div>
        <div class="form-group col-sm-2">
            <label for="kandang_sapi" class="form-label">Sapi</label>
            <input type="number" name="kandang_sapi" id="kandang_sapi"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="kandang_kerbau" class="form-label">Kerbau</label>
            <input type="number" name="kandang_kerbau" id="kandang_kerbau"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="kandang_kambing" class="form-label">Kambing</label>
            <input type="number" name="kandang_kambing" id="kandang_kambing"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="kandang_domba" class="form-label">Domba</label>
            <input type="number" name="kandang_domba" id="kandang_domba"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="kandang_babi" class="form-label">Babi</label>
            <input type="number" name="kandang_babi" id="kandang_babi"
                    step="1" required>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">Jumlah Hewan Yang Terinfeksi</div>
        <div class="form-group col-sm-2">
            <label for="terinfeksi_sapi" class="form-label">Sapi</label>
            <input type="number" name="terinfeksi_sapi" id="terinfeksi_sapi"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="terinfeksi_kerbau" class="form-label">Kerbau</label>
            <input type="number" name="terinfeksi_kerbau" id="terinfeksi_kerbau"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="terinfeksi_kambing" class="form-label">Kambing</label>
            <input type="number" name="terinfeksi_kambing" id="terinfeksi_kambing"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="terinfeksi_domba" class="form-label">Domba</label>
            <input type="number" name="terinfeksi_domba" id="terinfeksi_domba"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="terinfeksi_babi" class="form-label">Babi</label>
            <input type="number" name="terinfeksi_babi" id="terinfeksi_babi"
                    step="1" required>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">Jumlah Hewan Yang Mati</div>
        <div class="form-group col-sm-2">
            <label for="mati_sapi" class="form-label">Sapi</label>
            <input type="number" name="mati_sapi" id="mati_sapi"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="mati_kerbau" class="form-label">Kerbau</label>
            <input type="number" name="mati_kerbau" id="mati_kerbau"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="mati_kambing" class="form-label">Kambing</label>
            <input type="number" name="mati_kambing" id="mati_kambing"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="mati_domba" class="form-label">Domba</label>
            <input type="number" name="mati_domba" id="mati_domba"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="mati_babi" class="form-label">Babi</label>
            <input type="number" name="mati_babi" id="mati_babi"
                    step="1" required>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">Jumlah Hewan Yang Dipotong Paksa (Bersyarat)</div>
        <div class="form-group col-sm-2">
            <label for="potong_sapi" class="form-label">Sapi</label>
            <input type="number" name="potong_sapi" id="potong_sapi"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="potong_kerbau" class="form-label">Kerbau</label>
            <input type="number" name="potong_kerbau" id="potong_kerbau"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="potong_kambing" class="form-label">Kambing</label>
            <input type="number" name="potong_kambing" id="potong_kambing"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="potong_domba" class="form-label">Domba</label>
            <input type="number" name="potong_domba" id="potong_domba"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="potong_babi" class="form-label">Babi</label>
            <input type="number" name="potong_babi" id="potong_babi"
                    step="1" required>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">Jumlah Hewan Yang Sembuh</div>
        <div class="form-group col-sm-2">
            <label for="sembuh_sapi" class="form-label">Sapi</label>
            <input type="number" name="sembuh_sapi" id="sembuh_sapi"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="sembuh_kerbau" class="form-label">Kerbau</label>
            <input type="number" name="sembuh_kerbau" id="sembuh_kerbau"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="sembuh_kambing" class="form-label">Kambing</label>
            <input type="number" name="sembuh_kambing" id="sembuh_kambing"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="sembuh_domba" class="form-label">Domba</label>
            <input type="number" name="sembuh_domba" id="sembuh_domba"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="sembuh_babi" class="form-label">Babi</label>
            <input type="number" name="sembuh_babi" id="sembuh_babi"
                    step="1" required>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">Jumlah Hewan Sudah Divaksin</div>
        <div class="form-group col-sm-2">
            <label for="vaksin_sapi" class="form-label">Sapi</label>
            <input type="number" name="vaksin_sapi" id="vaksin_sapi"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="vaksin_kerbau" class="form-label">Kerbau</label>
            <input type="number" name="vaksin_kerbau" id="vaksin_kerbau"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="vaksin_kambing" class="form-label">Kambing</label>
            <input type="number" name="vaksin_kambing" id="vaksin_kambing"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="vaksin_domba" class="form-label">Domba</label>
            <input type="number" name="vaksin_domba" id="vaksin_domba"
                    step="1" required>
        </div>
        <div class="form-group col-sm-2">
            <label for="vaksin_Babi" class="form-label">Babi</label>
            <input type="number" name="vaksin_babi" id="vaksin_babi"
                    step="1" required>
        </div>
    </div>
@endsection
@section('row_table')
    <script>
        // must create function createTableRow
        function createTableRow(item, rowNumber) {
            let haveApprovals       = item.approvals.length > 0;
            let checklistApproval   = item.need_approve ? `
                <div class="form-check">
                    <input type="checkbox" class="form-check-input checklist-approval"
                           name="check_approval[${item.id}]" data-id="${ item.id }"
                           aria-label="check-row">
                </div>` : '';

            let table = `
                <tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"': ''}
                    ${ haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : '' }>
                    @can('sislap_approval_create')
                        <th class="align-middle text-center">
                            ${ checklistApproval }
                        </th>
                    @endcan
                    <th class="text-center">${ rowNumber }</th>
                    <td class="text-center">${ item.polda ?? '-' }</td>
                    <td class="text-center">${ item.polres ?? '-' }</td>
                    <td class="text-center">${ item.hewan_sapi }</td>
                    <td class="text-center">${ item.hewan_kerbau }</td>
                    <td class="text-center">${ item.hewan_kambing }</td>
                    <td class="text-center">${ item.hewan_domba }</td>
                    <td class="text-center">${ item.hewan_babi }</td>
                    <td class="text-center">${ item.kandang_sapi }</td>
                    <td class="text-center">${ item.kandang_kerbau }</td>
                    <td class="text-center">${ item.kandang_kambing }</td>
                    <td class="text-center">${ item.kandang_domba }</td>
                    <td class="text-center">${ item.kandang_babi }</td>
                    <td class="text-center">${ item.terinfeksi_sapi }</td>
                    <td class="text-center">${ item.terinfeksi_kerbau }</td>
                    <td class="text-center">${ item.terinfeksi_kambing }</td>
                    <td class="text-center">${ item.terinfeksi_domba }</td>
                    <td class="text-center">${ item.terinfeksi_babi }</td>
                    <td class="text-center">${ item.mati_sapi }</td>
                    <td class="text-center">${ item.mati_kerbau }</td>
                    <td class="text-center">${ item.mati_kambing }</td>
                    <td class="text-center">${ item.mati_domba }</td>
                    <td class="text-center">${ item.mati_babi }</td>
                    <td class="text-center">${ item.potong_sapi }</td>
                    <td class="text-center">${ item.potong_kerbau }</td>
                    <td class="text-center">${ item.potong_kambing }</td>
                    <td class="text-center">${ item.potong_domba }</td>
                    <td class="text-center">${ item.potong_babi }</td>
                    <td class="text-center">${ item.sembuh_sapi }</td>
                    <td class="text-center">${ item.sembuh_kerbau }</td>
                    <td class="text-center">${ item.sembuh_kambing }</td>
                    <td class="text-center">${ item.sembuh_domba }</td>
                    <td class="text-center">${ item.sembuh_babi }</td>
                    <td class="text-center">${ item.vaksin_sapi }</td>
                    <td class="text-center">${ item.vaksin_kerbau }</td>
                    <td class="text-center">${ item.vaksin_kambing }</td>
                    <td class="text-center">${ item.vaksin_domba }</td>
                    <td class="text-center">${ item.vaksin_babi }</td>
                    <td class="text-center">${ item.tanggal }</td>
                    @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                    <td class="align-middle text-center">
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
                                    onclick="insertValueToFormEdit('${route('penyakit-mulut-kuku.update', item.id)}', {
                                        polda              : '${item.polda}',
                                        polres             : '${item.polres}',
                                        hewan_sapi         : '${item.hewan_sapi}',
                                        hewan_kerbau       : '${item.hewan_kerbau}',
                                        hewan_kambing      : '${item.hewan_kambing}',
                                        hewan_domba        : '${item.hewan_domba}',
                                        hewan_babi         : '${item.hewan_babi}',
                                        kandang_sapi       : '${item.kandang_sapi}',
                                        kandang_kerbau     : '${item.kandang_kerbau}',
                                        kandang_kambing    : '${item.kandang_kambing}',
                                        kandang_domba      : '${item.kandang_domba}',
                                        kandang_babi       : '${item.kandang_babi}',
                                        terinfeksi_sapi    : '${item.terinfeksi_sapi}',
                                        terinfeksi_kerbau  : '${item.terinfeksi_kerbau}',
                                        terinfeksi_kambing : '${item.terinfeksi_kambing}',
                                        terinfeksi_domba   : '${item.terinfeksi_domba}',
                                        terinfeksi_babi    : '${item.terinfeksi_babi}',
                                        mati_sapi          : '${item.mati_sapi}',
                                        mati_kerbau        : '${item.mati_kerbau}',
                                        mati_kambing       : '${item.mati_kambing}',
                                        mati_domba         : '${item.mati_domba}',
                                        mati_babi          : '${item.mati_babi}',
                                        potong_sapi        : '${item.potong_sapi}',
                                        potong_kerbau      : '${item.potong_kerbau}',
                                        potong_kambing     : '${item.potong_kambing}',
                                        potong_domba       : '${item.potong_domba}',
                                        potong_babi        : '${item.potong_babi}',
                                        sembuh_sapi        : '${item.sembuh_sapi}',
                                        sembuh_kerbau      : '${item.sembuh_kerbau}',
                                        sembuh_kambing     : '${item.sembuh_kambing}',
                                        sembuh_domba       : '${item.sembuh_domba}',
                                        sembuh_babi        : '${item.sembuh_babi}',
                                        vaksin_sapi        : '${item.vaksin_sapi}',
                                        vaksin_kerbau      : '${item.vaksin_kerbau}',
                                        vaksin_kambing     : '${item.vaksin_kambing}',
                                        vaksin_domba       : '${item.vaksin_domba}',
                                        vaksin_babi        : '${item.vaksin_babi}',
                                    })">
                                <i class="fa fa-edit"></i>
                            </button> ` }
                        @endcan
                        @can('lapsubjar_destroy')
                        ${ !haveApprovals || !item.approval.is_approve ? `
                        <form action="${ route('penyakit-mulut-kuku.destroy', item.id) }" method="post" id="${ item.id }">
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
            if (haveApprovals) {
                // listRiwayatApproval(approvals, colspan)
                table += listRiwayatApproval(item.approvals, 40);
            }
            return table;
        }

        (function () {
            if(!localStorage.getItem('isViewNewFormatPMK')) {
                Swal.fire({
                    title: '<strong>Pemberitahuan</strong>',
                    icon: 'info',
                    html: 'Pertanggal 30 Juni 2022, terdapat update format pelaporan PMK pada Sislap-BOS v2' + '<br>'
                    + ' Silahkan unduh format terbaru melalui tombol di bawah ini',
                    focusConfirm: true,
                    confirmButtonText:
                        '<a href="'+route('penyakit-mulut-kuku.template-excel')+'" class="text-white">Unduh Format Terbaru</a>',
                    confirmButtonAriaLabel: 'Unduh Format Terbaru',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        localStorage.setItem('isViewNewFormatPMK', true)
                    }
                })
            }
        })();
    </script>
@endsection
