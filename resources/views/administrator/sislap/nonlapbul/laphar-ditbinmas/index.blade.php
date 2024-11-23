@extends('templates.admin-lte.sislap', [
    'title'          => 'Laporan Harian Rutin Ditbinmas Polda',
    'route_template' => route('laphar-ditbinmas.template-excel'),
    'route_import'   => route('laphar-ditbinmas.import-excel'),
    'route_export'   => route('laphar-ditbinmas.export-excel'),
    'route_store'    => route('laphar-ditbinmas.store'),
    'route_search'   => route('laphar-ditbinmas.search'),
    'route_destroy'  => route('laphar-ditbinmas.destroy', 'id'),
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
                <th>SATKER</th>
                <th>BINLUH/CERAMAH</th>
                <th>DDS/SAMBANG/KUNJUNGAN</th>
                <th>GIAT MOBIL/SPM/PENMAS/IMBAUAN</th>
                <th>PROBLEM SOLVING</th>
                <th>PENDAMPINGAN DANA DESA</th>
                <th>PEMBUATAN LI BHABINKAMTIBMAS</th>
                <th>KEGIATAN KEAGAMAAN</th>
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
                    <input type="text" name="laporan[{{ $key }}][satker]"
                           class="form-control" value="{{ $item[2] }}" required>
                </td>
                <td>
                    <input type="number" name="laporan[{{$key}}][binluh]"
                           class="form-control" value="{{ $item[3] ?? 0 }}"required>
                <td>
                    <input type="number" name="laporan[{{$key}}][sambang]"
                           class="form-control" value="{{ $item[4] ?? 0 }}"required>
                <td>
                    <input type="number" name="laporan[{{$key}}][penmas]"
                           class="form-control" value="{{ $item[5] ?? 0 }}"required>
                <td>
                    <input type="number" name="laporan[{{$key}}][ps]"
                           class="form-control" value="{{ $item[6] ?? 0 }}"required>
                <td>
                    <input type="number" name="laporan[{{$key}}][pendampingan_dana_desa]"
                           class="form-control" value="{{ $item[7] ?? 0 }}"required>
                <td>
                    <input type="number" name="laporan[{{$key}}][pembuatan_li]"
                           class="form-control" value="{{ $item[8] ?? 0 }}"required>
                <td>
                    <input type="number" name="laporan[{{$key}}][keagamaan]"
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
                <th>SATKER</th>
                <th>BINLUH/CERAMAH</th>
                <th>DDS/SAMBANG/KUNJUNGAN</th>
                <th>GIAT MOBIL/SPM/PENMAS/IMBAUAN</th>
                <th>PROBLEM SOLVING</th>
                <th>PENDAMPINGAN DANA DESA</th>
                <th>PEMBUATAN LI BHABINKAMTIBMAS</th>
                <th>KEGIATAN KEAGAMAAN</th>
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
            <input type="number" name="polda" id="polda"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="satker" class="form-label">SATKER</label>
            <input type="number" name="satker" id="satker"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="binluh" class="form-label">BINLUH/CERAMAH</label>
            <input type="number" name="binluh" id="binluh"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="sambang" class="form-label">DDS/SAMBANG/KUNJUNGAN</label>
            <input type="number" name="sambang" id="sambang"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="penmas" class="form-label">GIAT MOBIL/SPM/PENMAS/IMBAUAN</label>
            <input type="number" name="penmas" id="penmas"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="ps" class="form-label">PROBLEM SOLVING</label>
            <input type="number" name="ps" id="ps"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="pendampingan_dana_desa" class="form-label">PENDAMPINGAN DANA DESA</label>
            <input type="number" name="pendampingan_dana_desa" id="pendampingan_dana_desa"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="pembuatan_li" class="form-label">PEMBUATAN LI BHABINKAMTIBMAS</label>
            <input type="number" name="pembuatan_li" id="pembuatan_li"
                   class="form-control" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="keagamaan" class="form-label">KEGIATAN KEAGAMAAN</label>
            <input type="number" name="keagamaan" id="keagamaan"
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
                    <td class="text-center">${item.satker}</td>
                    <td class="text-center">${item.binluh}</td>
                    <td class="text-center">${item.sambang}</td>
                    <td class="text-center">${item.penmas}</td>
                    <td class="text-center">${item.ps}</td>
                    <td class="text-center">${item.pendampingan_dana_desa}</td>
                    <td class="text-center">${item.pembuatan_li}</td>
                    <td class="text-center">${item.keagamaan}</td>
                    <td class="text-center">${item.binluh + item.sambang + item.penmas + item.ps + item.pendampingan_dana_desa + item.pembuatan_li + item.keagamaan}</td>
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
                                    onclick="insertValueToFormEdit('${route('laphar-ditbinmas.update', item.id)}', {
                                        polda   : '${item.polda}'
                                        satker  : '${item.satker}'
                                        binluh  : '${item.binluh}'
                                        sambang : '${item.sambang}'
                                        penmas  : '${item.penmas}'
                                        ps      : '${item.ps}'
                                        pendampingan_dana_desa : '${item.pendampingan_dana_desa}'
                                        pembuatan_li : '${item.pembuatan_li}'
                                        keagamaan : '${item.keagamaan}'
                                    })">
                                <i class="fa fa-edit"></i>
                            </button> ` }
                        @endcan
                        @can('lapsubjar_destroy')
                        ${ !haveApprovals || !item.approval.is_approve ? `
                        <form action="${ route('laphar-ditbinmas.destroy', item.id) }" method="post" id="${ item.id }">
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
