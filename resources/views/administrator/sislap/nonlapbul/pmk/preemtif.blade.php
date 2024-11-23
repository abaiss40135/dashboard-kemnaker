@extends('templates.admin-lte.sislap', [
    'title'          => 'Laporan Giat Preemtif Penanganan PMK',
    'route_template' => route('preemtif-pmk.template-excel'),
    'route_import'   => route('preemtif-pmk.import-excel'),
    'route_export'   => route('preemtif-pmk.export-excel'),
    'route_store'    => route('preemtif-pmk.store'),
    'route_search'   => route('preemtif-pmk.search'),
    'route_destroy'  => route('preemtif-pmk.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
    'cite'           => 'Jumlah harus diisi dengan angka dan tidak boleh kosong. Apabila tidak ada kejadian, silahkan isikan dengan <b>angka 0</b>'
])
@section('table_preview')
    <table class="table table-hover table-bordered" style="table-layout: fixed;">
        <thead class="text-center bg-primary">
            <tr>
                <th style="width: 50px;">No</th>
                <th>Polda</th>
                <th>Polres</th>
                <th class="align-middle">Giat Sosialisasi dan Edukasi</th>
                <th class="align-middle">Giat Pengobatan & Vaksinasi Hewan Dengan Instansi Terkait</th>
                <th class="align-middle">Giat Dekontaminasi dan Disinveksi Kandang</th>
                <th class="align-middle">Giat Amplifikasi Meme dan Penanganan Penyebaran PMK</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($laporan))
            @foreach ($laporan[0] as $key => $item)
            @if($key > 0)
            <tr>
                <th class="text-center">{{ $item[0] }}</th>
                <td>
                    <input type="text" class="form-control"
                            name="laporan[{{ $key }}][polda]"
                            value="{{ $item[1] }}" required readonly>
                </td>
                <td>
                    <input type="text" class="form-control"
                            name="laporan[{{ $key }}][polres]"
                            value="{{ $item[2] }}" required readonly>
                </td>
                @php
                    $begin = 3;
                @endphp
                @foreach($columns as $column)
                    <td>
                        <input type="number" step="1" class="form-control"
                                name="laporan[{{ $key }}][{{$column}}]"
                                value="{{ $item[$begin++] }}" required>
                    </td>
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
                <th style="width: 3%" class="align-middle">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                        <label class="form-check-label" for="check-all"></label>
                    </div>
                </th>
                @endcan
                <th style="width: 3%" class="align-middle">No</th>
                <th style="width: 12%" class="align-middle">Polda</th>
                <th style="width: 14%" class="align-middle">Polres</th>
                <th class="align-middle">Giat Sosialisasi dan Edukasi</th>
                <th class="align-middle">Giat Pengobatan & Vaksinasi Hewan Dengan Instansi Terkait</th>
                <th class="align-middle">Giat Dekontaminasi dan Disinveksi Kandang</th>
                <th class="align-middle">Giat Amplifikasi Meme dan Penanganan Penyebaran PMK</th>
                <th class="align-middle">Tanggal Laporan</th>
                @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                <th class="align-middle">Aksi</th>
                @endcanany
            </tr>
        </thead>
        <tbody id="content-wrapper"></tbody>
        {{-- TODO Generate sum content from sums return data --}}
        <tfoot id="sum-content"></tfoot>
    </table>
@endsection
@section('form_edit')
    <div class="form-group col-sm-6">
        <label for="polda" class="form-label">Polda</label>
        <input class="form-control" type="text" name="polda" id="polda" readonly required>
    </div>
    <div class="form-group col-sm-6">
        <label for="polres" class="form-label">Polres</label>
        <input class="form-control" type="text" name="polres" id="polres" readonly required>
    </div>
    <div class="form-group col-sm-6">
        <label for="sosialisasi" class="form-label">Sosialisasi</label>
        <input class="form-control" type="text" name="sosialisasi" id="sosialisasi" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="pengobatan" class="form-label">Pengobatan</label>
        <input class="form-control" type="text" name="pengobatan" id="pengobatan" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="dekontaminasi" class="form-label">Dekontaminasi</label>
        <input class="form-control" type="text" name="dekontaminasi" id="dekontaminasi" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="amplifikasi_meme" class="form-label">Amplifikasi Meme</label>
        <input class="form-control" type="text" name="amplifikasi_meme" id="amplifikasi_meme" required>
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
                    <tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"': ''} ${ haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : '' }>
                        @can('sislap_approval_create')
                            <th class="align-middle text-center">
                                ${ checklistApproval }
                            </th>
                        @endcan
                        <th class="text-center">${ rowNumber }</th>
                        <td class="text-center">${ item.polda ?? '-' }</td>
                        <td class="text-center">${ item.polres ?? '-' }</td>
                        <td class="text-center">${ item.sosialisasi }</td>
                        <td class="text-center">${ item.pengobatan }</td>
                        <td class="text-center">${ item.dekontaminasi }</td>
                        <td class="text-center">${ item.amplifikasi_meme }</td>
                        <td class="text-center">${ formatDate(item.created_at) }</td>
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
                                        onclick="insertValueToFormEdit('${ route('preemtif-pmk.update', item.id) }', {
                                            polda            : '${item.polda}',
                                            polres           : '${item.polres}',
                                            sosialisasi      : '${item.sosialisasi}',
                                            pengobatan       : '${item.pengobatan}',
                                            dekontaminasi    : '${item.dekontaminasi}',
                                            amplifikasi_meme : '${item.amplifikasi_meme}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('preemtif-pmk.destroy', item.id) }" method="post" id="${ item.id }">
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
                    table += listRiwayatApproval(item.approvals, 10);
                }
                return table;
            }
    </script>
@endsection
