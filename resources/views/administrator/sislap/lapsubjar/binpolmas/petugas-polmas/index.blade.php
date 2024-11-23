@extends('templates.admin-lte.sislap-non-harian', [
    'title'          => 'Data Petugas Polmas Model Wilayah (Polisi RW/Dusun/Sejenisnya) dan Model Kawasan',
    'route_template' => route('petugas-polmas-kawasan-wilayah.template-excel'),
    'route_import'   => route('petugas-polmas-kawasan-wilayah.import-excel'),
    'route_export'   => route('petugas-polmas-kawasan-wilayah.export-excel'),
    'route_store'    => route('petugas-polmas-kawasan-wilayah.store'),
    'route_search'   => route('petugas-polmas-kawasan-wilayah.search'),
    'route_destroy'  => route('petugas-polmas-kawasan-wilayah.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
])
@section("create_button")
    <a href="{{ route('petugas-polmas-kawasan-wilayah.create') }}" class="btn btn-info">
        Tambah Data
    </a>
@endsection
@section('table_preview')
    <div class="table-responsive">
    <table class="table table-hover table-bordered">
            <thead class="text-center bg-primary">
            <tr>
                <th  style="width: 10%" class="align-middle" rowspan="2" >No</th>
                <th  style="width: 20%" class="align-middle" rowspan="2">Polda</th>
                <th  style="width: 20%" class="align-middle" rowspan="2">Polres</th>
                <th class="align-middle text-center">Jumlah RW/Dusun/Sejenisnya</th>
                <th class="align-middle text-center">Jumlah Petugas Polmas Model Wilayah</th>
                <th class="align-middle text-center">Jumlah Petugas Polmas Model Kawasan</th>
                <th class="align-middle text-center">Jumlah Petugas Polmas Yang Sudah Mengikuti Pelatihan</th>
                <th class="align-middle text-center">Lampiran File</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($laporan))
                @foreach ($laporan[0] as $key => $item)
                    @if($key >= 1)
                        <tr>
                            <th class="text-center">{{ $item[0] }}</th>
                            <td>
                                <input style="width: 200px;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][polda]"
                                       value="{{ $item[1] }}" required readonly>
                            </td>
                            <td>
                                <input style="width: 200px;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][polres]"
                                       value="{{ $item[2] }}" required readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control"
                                       name="laporan[{{ $key }}][jumlah_rw]"
                                       value="{{ $item[3] }}" required>
                            </td>
                            <td>
                                <input style="width: 150px;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][jumlah_petugas_wilayah]"
                                       value="{{ $item[5] }}" required>
                            </td>
                            <td>
                                <input style="width: 150px;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][jumlah_petugas_kawasan]"
                                       value="{{ $item[4] }}" required>
                            </td>
                            <td>
                                <input style="width: 150px;" type="number" class="form-control"
                                       name="laporan[{{ $key }}][jumlah_sdh_pelatihan_polmas]"
                                       value="{{ $item[4] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="file" class="form-control"
                                       name="laporan[{{ $key }}][lampiran_file]"
                                       required>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
@section('table_data')
    <table class="table table-hover table-bordered">
        <thead class="bg-primary text-white text-center">
        <tr>
            @if(can('sislap_approval_create') && !role('operator_bagopsnalev_mabes'))
                <th style="width: 3%" class="align-middle" rowspan="2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                        <label class="form-check-label" for="check-all"></label>
                    </div>
                </th>
            @endif
            <th class="align-middle">No</th>
            <th class="align-middle text-center">Polda</th>
            <th class="align-middle text-center">Polres</th>
            <th class="align-middle text-center">Jumlah RW/Dusun/Sejenisnya</th>
            <th class="align-middle text-center">Jumlah Petugas Polmas Model Wilayah (Polisi RW/Dusun/Sejenisnya)</th>
            <th class="align-middle text-center">Jumlah Petugas Polmas Model Kawasan</th>
            <th class="align-middle text-center">Jumlah Petugas Polmas Yang Sudah Mengikuti Pelatihan</th>
            <th class="align-middle text-center">Lampiran File</th>
            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                <th class="align-middle" width="4%" rowspan="2" >Aksi</th>
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
        <label for="jumlah_rw" class="form-label">Jumlah RW</label>
        <input class="form-control" type="text" name="jumlah_rw" id="jumlah_rw" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="jumlah_petugas_wilayah" class="form-label">Jumlah Petugas Wilayah</label>
        <input class="form-control" type="text" name="jumlah_petugas_wilayah" id="jumlah_petugas_wilayah" required>
    </div>
    <div class="form-group col-sm-6">
        <br>
        <label for="jumlah_petugas_kawasan" class="form-label">Jumlah Petugas Kawasan</label>
        <input class="form-control" type="text" name="jumlah_petugas_kawasan" id="jumlah_petugas_kawasan" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="jumlah_sdh_pelatihan_polmas" class="form-label">Jumlah Petugas Polmas Yang Sudah Mengikuti Pelatihan</label>
        <input class="form-control" type="text" name="jumlah_sdh_pelatihan_polmas" id="jumlah_sdh_pelatihan_polmas" required>
    </div>
    <div class="form-group col-sm-12">
        <label for="lampiran_file" class="form-label">Lampiran File Terbaru (Jika ada)</label>
        <input class="form-control" type="file" name="lampiran_file" id="lampiran_file">
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
                    <tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"': ''} ${ haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : '' } class="text-center">
                        @if(can('sislap_approval_create') && !role('operator_bagopsnalev_mabes'))
            <th class="align-middle text-center">
${ checklistApproval }
                            </th>
                        @endif
                        <th class="align-middle">${ rowNumber }</th>
                        <td class="align-middle">${ item.polda ?? '-' }</td>
                        <td class="align-middle">${ item.polres ?? '-' }</td>
                        <td class="align-middle">${ item.jumlah_rw }</td>
                        <td class="align-middle">${ item.jumlah_petugas_wilayah }</td>
                        <td class="align-middle">${ item.jumlah_petugas_kawasan }</td>
                        <td class="align-middle">${ item.jumlah_sdh_pelatihan_polmas }</td>
                        <td class="align-middle">
                            <a target="_blank" href="${ item.lampiran_file }">Lihat Lampiran</a>
                        </td>
                        @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                            <td class="align-middle text-center">
                            @if (can('sislap_approval_decline') || roles(['administrator']))
                                ${ !haveApprovals || item.approval.is_approve === null || item.approval.is_approve ? `
                                    <button class="btn btn-decline btn-danger mb-1"
                                            onclick="decline(${item.id})">
                                            <i class="fa fa-question"></i>
                                    </button>
                                ` : ``}
                                @endif
                                @can('lapsubjar_edit')
                                ${ `
                                <button class="btn btn-edit btn-warning mb-1"
                                        data-toggle="modal" data-target="#modalEdit"
                                        onclick="insertValueToFormEdit('${ route('petugas-polmas-kawasan-wilayah.update', item.id) }', {
                                            polda               : '${item.polda}',
                                            polres              : '${item.polres}',
                                            jumlah_rw           : '${item.jumlah_rw}',
                                            jumlah_petugas_kawasan           : '${item.jumlah_petugas_kawasan}',
                                            jumlah_petugas_wilayah           : '${item.jumlah_petugas_wilayah}',
                                            jumlah_sdh_pelatihan_polmas           : '${item.jumlah_sdh_pelatihan_polmas}',
                                            lampiran_file           : '${item.lampiran_file}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
            @can('lapsubjar_destroy')
            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('petugas-polmas-kawasan-wilayah.destroy', item.id) }" method="post" id="${ item.id }">
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
