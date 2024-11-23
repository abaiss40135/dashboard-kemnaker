@extends('templates.admin-lte.sislap', [
    'title'          => 'LAPORAN HASIL KEGIATAN OPERASI KOTEKA',
    'route_template' => route('cartenz.koteka.template-excel'),
    'route_import'   => route('cartenz.koteka.import-excel'),
    'route_export'   => route('cartenz.koteka.export-excel'),
    'route_store'    => route('cartenz.koteka.store'),
    'route_search'   => route('cartenz.koteka.search'),
    'route_destroy'  => route('cartenz.koteka.destroy', 'id'),
    'route_list'     => route('approval-laporan.list-cartenz'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
    'cite'           => ''
])
@section('table_preview')
    <table class="table table-hover table-bordered" style="table-layout: fixed;">
        <thead class="text-center bg-primary">
            <tr>
                <th style="width: 60px">NO</th>
                <th>POSKO</th>
                <th>SATGAS</th>
                <th>JAM</th>
                <th>KUAT PERS</th>
                <th>LOKASI KEGIATAN</th>
                <th>KEGIATAN</th>
                <th>HASIL CAPAIAN</th>
                <th>KET</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($laporan))
            @foreach($laporan[0] as $key => $item)
            @if($key > 0)
            <tr>
                <th class="text-center">{{ $item[0] }}</th>
                <td>
                    <input type="text" name="laporan[{{ $key }}][daops]"
                           class="form-control" value="{{ $item[1] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][satgas]"
                           class="form-control" value="{{ $item[2] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][jam]"
                           class="form-control" value="{{ $item[3] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][kuat_pers]"
                           class="form-control" value="{{ $item[4] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][lokasi]"
                           class="form-control" value="{{ $item[5] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][kegiatan]"
                           class="form-control" value="{{ $item[6] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][hasil]"
                           class="form-control" value="{{ $item[7] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][keterangan]"
                           class="form-control" value="{{ $item[8] }}" required>
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
                <th class="align-middle">No</th>
                <th class="align-middle">POSKO</th>
                <th class="align-middle">SATGAS</th>
                <th class="align-middle">JAM</th>
                <th class="align-middle">KUAT PERS</th>
                <th class="align-middle">LOKASI KEGIATAN</th>
                <th class="align-middle">KEGIATAN</th>
                <th class="align-middle">HASIL CAPAIAN</th>
                <th class="align-middle">KET</th>
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
            <label for="daops" class="form-label">POSKO</label>
            <input type="text" name="daops" id="daops"
                   required class="form-control">
        </div>
        <div class="form-group col-sm-6">
            <label for="satgas" class="form-label">SATGAS</label>
            <input type="text" name="satgas" id="satgas"
                   required class="form-control">
        </div>
    </div>
    <div class="row w-100">
        <div class="form-group col-sm-6">
            <label for="jam" class="form-label">JAM</label>
            <input type="text" name="jam" id="jam"
                   required class="form-control">
        </div>
        <div class="form-group col-sm-6">
            <label for="kuat_pers" class="form-label">KUAT PERS</label>
            <input type="text" name="kuat_pers" id="kuat_pers"
                   required class="form-control">
        </div>
    </div>
    <div class="row w-100">
        <div class="form-group col-sm-6">
            <label for="lokasi" class="form-label">LOKASI KEGIATAN</label>
            <input type="text" name="lokasi" id="lokasi"
                   required class="form-control">
        </div>
        <div class="form-group col-sm-6">
            <label for="kegiatan" class="form-label">KEGIATAN</label>
            <input type="text" name="kegiatan" id="kegiatan"
                   required class="form-control">
        </div>
    </div>
    <div class="row w-100">
        <div class="form-group col-sm-6">
            <label for="hasil" class="form-label">HASIL CAPAIAN</label>
            <input type="text" name="hasil" id="hasil"
                   required class="form-control">
        </div>
        <div class="form-group col-sm-6">
            <label for="keterangan" class="form-label">KETERANGAN</label>
            <input type="text" name="keterangan" id="keterangan"
                   required class="form-control">
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
                    <td>${ item.daops }</td>
                    <td>${ item.satgas }</td>
                    <td>${ item.jam }</td>
                    <td>${ item.kuat_pers }</td>
                    <td>${ item.lokasi }</td>
                    <td>${ item.kegiatan }</td>
                    <td>${ item.hasil }</td>
                    <td>${ item.keterangan }</td>
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
                                    onclick="insertValueToFormEdit('${route('cartenz.koteka.update', item.id)}', {
                                        daops      : '${item.daops}',
                                        satgas     : '${item.satgas}',
                                        jam        : '${item.jam}',
                                        kuat_pers  : '${item.kuat_pers}',
                                        lokasi     : '${item.lokasi}',
                                        kegiatan   : '${item.kegiatan}',
                                        hasil      : '${item.hasil}',
                                        keterangan : '${item.keterangan}',
                                    })">
                                <i class="fa fa-edit"></i>
                            </button> ` }
                        @endcan
                        @can('lapsubjar_destroy')
                        ${ !haveApprovals || !item.approval.is_approve ? `
                        <form action="${ route('cartenz.koteka.destroy', item.id) }" method="post" id="${ item.id }">
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
            if (haveApprovals) table += listRiwayatApproval(item.approvals, 12);
            return table;
        }
    </script>
@endsection
