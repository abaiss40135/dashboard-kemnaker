@extends('templates.admin-lte.sislap', [
    'title'          => 'Laporan Harian Rutin TPPO Polda',
    'route_template' => route('laphar-tppo.template-excel'),
    'route_import'   => route('laphar-tppo.import-excel'),
    'route_export'   => route('laphar-tppo.export-excel'),
    'route_store'    => route('laphar-tppo.store'),
    'route_search'   => route('laphar-tppo.search'),
    'route_destroy'  => route('laphar-tppo.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
    'cite'           => ''
])

@push('styles')
    <style>
        .cell-category {
            width: 460px;
        }
    </style>
@endpush
@section('table_preview')
    <table class="table table-hover table-bordered">
        <thead class="text-center bg-primary">
            <tr>
                <th style="width: 60px">NO</th>
                <th>POLDA</th>
                <th>POLRES</th>
                <th>SOSIALISASI / HIMBAUAN / EDUKASI (TATAP MUKA)</th>
                <th>PASANG STIKER / SPANDUK / LEAFLET</th>
                <th>SOSIALISASI / HIMBAUAN / EDUKASI DI MEDSOS</th>
                <th>BINLUH PLK / BLK</th>
                <th>KOORDINASI P3MI</th>
                <th>KOORDINASI STAKE HOLDER / DINAS / INSTANSI</th>
                <th>WORKSHOP / FGD</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($laporan))
            @foreach($laporan[0] as $key => $item)
            @if($key > 0)
            <tr>
                <th class="text-center">{{ $item[0] }}</th>
                <td>
                    <input type="text" name="laporan[{{ $key }}][polda]"
                           class="form-control" value="{{ $item[1] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][polres]"
                           class="form-control" value="{{ $item[2] }}" required>
                </td>
                <td>
                    <input type="tatap_muka" name="laporan[{{$key}}][tatap_muka]"
                           class="form-control" value="{{ $item[3] ?? 0 }}"required>
                <td>
                    <input type="media_cetak" name="laporan[{{$key}}][media_cetak]"
                           class="form-control" value="{{ $item[4] ?? 0 }}"required>
                <td>
                    <input type="media_sosial" name="laporan[{{$key}}][media_sosial]"
                           class="form-control" value="{{ $item[5] ?? 0 }}"required>
                <td>
                    <input type="binluh" name="laporan[{{$key}}][binluh]"
                           class="form-control" value="{{ $item[6] ?? 0 }}"required>
                <td>
                    <input type="koordinasi_p3mi" name="laporan[{{$key}}][koordinasi_p3mi]"
                           class="form-control" value="{{ $item[7] ?? 0 }}"required>
                <td>
                    <input type="koordinasi_dinas" name="laporan[{{$key}}][koordinasi_dinas]"
                           class="form-control" value="{{ $item[8] ?? 0 }}"required>
                <td>
                    <input type="workshop" name="laporan[{{$key}}][workshop]"
                           class="form-control" value="{{ $item[9] ?? 0 }}"required>
                </td>
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
                <th class="align-middle text-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                        <label class="form-check-label" for="check-all"></label>
                    </div>
                </th>
                @endcan
                <th class="align-middle">NO</th>
                <th>POLDA</th>
                <th>POLRES</th>
                <th>SOSIALISASI / HIMBAUAN / EDUKASI (TATAP MUKA)</th>
                <th>PASANG STIKER / SPANDUK / LEAFLET</th>
                <th>SOSIALISASI / HIMBAUAN / EDUKASI DI MEDSOS</th>
                <th>BINLUH PLK / BLK</th>
                <th>KOORDINASI P3MI</th>
                <th>KOORDINASI STAKE HOLDER / DINAS / INSTANSI</th>
                <th>WORKSHOP / FGD</th>
                <th>JUMLAH</th>
                <th class="align-middle">TANGGAL LAPORAN</th>
                @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                <th class="align-middle">AKSI</th>
                @endcanany
            </tr>
        </thead>
        <tbody id="content-wrapper"></tbody>
    </table>
@endsection
@section('form_edit')
    <div class="row w-100">
        <div class="form-group col-sm-6">
            <label for="polda" class="form-label">POLDA</label>
            <input type="text" name="polda" id="polda"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="polres" class="form-label">POLRES</label>
            <input type="text" name="polres" id="polres"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="tatap_muka" class="form-label">SOSIALISASI / HIMBAUAN / EDUKASI (TATAP MUKA)</label>
            <input type="number" name="tatap_muka" id="tatap_muka"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="media_cetak" class="form-label">PASANG STIKER / SPANDUK / LEAFLET</label>
            <input type="number" name="media_cetak" id="media_cetak"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="media_sosial" class="form-label">SOSIALISASI / HIMBAUAN / EDUKASI DI MEDSOS</label>
            <input type="number" name="media_sosial" id="media_sosial"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="binluh" class="form-label">BINLUH PLK / BLK</label>
            <input type="number" name="binluh" id="binluh"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="koordinasi_p3mi" class="form-label">KOORDINASI P3MI</label>
            <input type="number" name="koordinasi_p3mi" id="koordinasi_p3mina_desa"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="koordinasi_dinas" class="form-label">KOORDINASI STAKE HOLDER / DINAS / INSTANSI</label>
            <input type="number" name="koordinasi_dinas" id="koordinasi_dinas"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="workshop" class="form-label">WORKSHOP / FGD</label>
            <input type="number" name="workshop" id="workshop"
                   class="form-control" required>
        </div>
    </div>
@endsection
@section('row_table')
    <script>
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
                    <td class="text-center">${item.polda}</td>
                    <td class="text-center">${item.polres}</td>
                    <td class="text-center">${item.tatap_muka}</td>
                    <td class="text-center">${item.media_cetak}</td>
                    <td class="text-center">${item.media_sosial}</td>
                    <td class="text-center">${item.binluh}</td>
                    <td class="text-center">${item.koordinasi_p3mi}</td>
                    <td class="text-center">${item.koordinasi_dinas}</td>
                    <td class="text-center">${item.workshop}</td>
                    <td class="text-center">${item.tatap_muka
                                            + item.media_cetak
                                            + item.media_sosial
                                            + item.binluh
                                            + item.koordinasi_p3mi
                                            + item.koordinasi_dinas
                                            + item.workshop}</td>
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
                                    onclick="insertValueToFormEdit('${route('laphar-tppo.update', item.id)}', {
                                        polda : '${item.polda}',
                                        polres : '${item.polres}',
                                        tatap_muka : '${item.tatap_muka}',
                                        media_cetak : '${item.media_cetak}',
                                        media_sosial : '${item.media_sosial}',
                                        binluh : '${item.binluh}',
                                        koordinasi_p3mi : '${item.koordinasi_p3mi}',
                                        koordinasi_dinas : '${item.koordinasi_dinas}',
                                        workshop : '${item.workshop}'
                                    })">
                                <i class="fa fa-edit"></i>
                            </button> ` }
                        @endcan
                        @can('lapsubjar_destroy')
                        ${ !haveApprovals || !item.approval.is_approve ? `
                        <form action="${ route('laphar-tppo.destroy', item.id) }" method="post" id="${ item.id }">
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
                table += listRiwayatApproval(item.approvals, 14);
            }
            return table;
        }
    </script>
@endsection
