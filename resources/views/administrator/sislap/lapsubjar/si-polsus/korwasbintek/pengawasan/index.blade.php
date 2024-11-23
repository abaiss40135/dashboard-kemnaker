@extends('templates.admin-lte.sislap-non-harian', [
    'title'           => 'LAPORAN KEGIATAN KORWASBINTEK PENGAWASAN POLSUS',
    'route_template'  => route('korwasbintek.pengawasan.template-excel'),
    'route_import'    => route('korwasbintek.pengawasan.import-excel'),
    'route_export'    => route('korwasbintek.pengawasan.export-excel'),
    'route_store'     => route('korwasbintek.pengawasan.store'),
    'route_search'    => route('korwasbintek.pengawasan.search'),
    'route_destroy'   => route('korwasbintek.pengawasan.destroy', 'id'),
    'laporan_exist'   => isset($laporan),
    'model'           => $model,
    'approval_button' => false
])
@section('table_preview')
    <table class="table table-hover table-bordered table-responsive" style="table-layout: fixed;">
        <thead class="text-center bg-primary">
        <tr>
            <th style="width: 50px;">No</th>
            <th class="align-middle">Polda</th>
            <th class="align-middle">Polres</th>
            <th class="align-middle">Bentuk Kegiatan</th>
            <th class="align-middle">Jumlah Kegiatan</th>
            <th class="align-middle">Jumlah Pelaksana</th>
            <th class="align-middle">Hasil</th>
            <th class="align-middle">Kendala</th>
            <th class="align-middle">Solusi</th>
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
                           value="{{ $item[1] }}" required>
                </td>
                <td>
                    <input type="text" class="form-control"
                           name="laporan[{{ $key }}][polres]"
                           value="{{ $item[2] }}" required>
                </td>
                <td>
                    <input type="text" class="form-control"
                           name="laporan[{{ $key }}][bentuk_kegiatan]"
                           value="{{ $item[3] }}" required>
                </td>
                <td>
                    <input type="text" class="form-control"
                           name="laporan[{{ $key }}][jml_kegiatan]"
                           value="{{ $item[4] }}" required>
                </td>
                <td>
                    <input type="text" class="form-control"
                           name="laporan[{{ $key }}][jml_pelaksana]"
                           value="{{ $item[5] }}" required>
                </td>
                <td>
                    <input type="text" class="form-control"
                           name="laporan[{{ $key }}][hasil]"
                           value="{{ $item[6] }}" required>
                </td>
                <td>
                    <input type="text" class="form-control"
                           name="laporan[{{ $key }}][kendala]"
                           value="{{ $item[7] }}" required>
                </td>
                <td>
                    <input type="text" class="form-control"
                           name="laporan[{{ $key }}][solusi]"
                           value="{{ $item[8] }}" required>
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
            <th style="width: 3%" class="align-middle">No</th>
            <th style="width: 12%" class="align-middle">Polda</th>
            <th style="width: 14%" class="align-middle">Polres</th>
            <th class="align-middle">Bentuk Kegiatan</th>
            <th class="align-middle">Jumlah Kegiatan</th>
            <th class="align-middle">Jumlah Pelaksana</th>
            <th class="align-middle">Hasil</th>
            <th class="align-middle">Kendala</th>
            <th class="align-middle">Solusi</th>
            <th class="align-middle">Tanggal Laporan</th>
            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
            <th class="align-middle">Aksi</th>
            @endcanany
        </tr>
        </thead>
        <tbody id="content-wrapper"></tbody>
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
        <label for="nama" class="form-label">Bentuk Kegiatan</label>
        <input class="form-control" type="text" name="bentuk_kegiatan" id="bentuk_kegiatan" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="pangkat" class="form-label">Jumlah Kegiatan</label>
        <input class="form-control" type="text" name="jml_kegiatan" id="jml_kegiatan" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="nrp" class="form-label">Jumlah Pelaksana</label>
        <input class="form-control" type="text" name="jml_pelaksana" id="jml_pelaksana" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="jabatan" class="form-label">Hasil</label>
        <input class="form-control" type="text" name="hasil" id="hasil" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="kesatuan" class="form-label">Kendala</label>
        <input class="form-control" type="text" name="kendala" id="kendala" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="perorangan_kelompok" class="form-label">Solusi</label>
        <input class="form-control" type="text" name="solusi" id="solusi" required>
    </div>
@endsection
@section('row_table')
    <script>
        function createTableRow(item, rowNumber) {
            let haveApprovals = item.approvals.length > 0;
            let table = `
            <tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"' : ''}
                ${ haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : '' }>
                <th class="text-center">${ rowNumber }</th>
                <td class="text-center">${ item.polda ?? '-' }</td>
                <td class="text-center">${ item.polres ?? '-' }</td>
                <td class="text-center">${ item.bentuk_kegiatan }</td>
                <td class="text-center">${ item.jml_kegiatan }</td>
                <td class="text-center">${ item.jml_pelaksana }</td>
                <td class="text-center">${ item.hasil }</td>
                <td class="text-center">${ item.kendala }</td>
                <td class="text-center">${ item.solusi }</td>
                <td class="text-center">${ formatDate(item.created_at) }</td>
                @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                <td class="align-middle text-center">
                    @can('lapsubjar_edit')
                    ${ haveApprovals && !item.need_approve ? `` : `
                    <button class="btn btn-edit btn-warning mb-1"
                            data-toggle="modal" data-target="#modalEdit"
                            onclick="insertValueToFormEdit('${ route('korwasbintek.pengawasan.update', item.id) }', {
                                polda          : '${item.polda}',
                                polres         : '${item.polres}',
                                bentuk_kegiatan: '${item.bentuk_kegiatan}',
                                jml_kegiatan   : '${item.jml_kegiatan}',
                                jml_pelaksana  : '${item.jml_pelaksana}',
                                hasil          : '${item.hasil}',
                                kendala        : '${item.kendala}',
                                solusi         : '${item.solusi}',
                            })">
                        <i class="fa fa-edit"></i>
                    </button> ` }
                    @endcan
                    @can('lapsubjar_destroy')
                    ${ !haveApprovals || !item.approval.is_approve ? `
                    <form action="${ route('korwasbintek.pengawasan.destroy', item.id) }" method="post" id="${ item.id }">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger btn-delete"
                                type="submit"
                                onclick="event.preventDefault(); deleteConfirm(${ item.id })">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>` : ``}
                    @endcan
                </td>
                @endcanany
            </tr>`;
            if (haveApprovals) table += listRiwayatApproval(item.approvals, 11)
            return table;
        }
    </script>
@endsection
