@extends('templates.admin-lte.sislap-non-harian', [
    'title'          => 'Pembina Polmas',
    'route_template' => route('pembina-polmas.template-excel'),
    'route_import'   => route('pembina-polmas.import-excel'),
    'route_export'   => route('pembina-polmas.export-excel'),
    'route_store'    => route('pembina-polmas.store'),
    'route_search'   => route('pembina-polmas.search'),
    'route_destroy'  => route('pembina-polmas.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
])
@section("create_button")
<a class="btn btn-info" href="{{ route("pembina-polmas.create") }}">Tambah Laporan</a>
@endsection
@section('table_preview')
    <div class="table-responsive">
        <table class="table table-hover table-bordered" style="table-layout: fixed;">
            <thead class="text-center bg-primary">
            <tr>
                <th style="width: 10%" class="align-middle" rowspan="2" >No</th>
                <th style="width: 20%" class="align-middle" rowspan="2">Polda</th>
                <th style="width: 20%" class="align-middle" rowspan="2">Polres</th>
                <th class="align-middle text-center">Jumlah Pembina Polda</th>
                <th class="align-middle text-center">Jumlah Pembina Polres</th>
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
                    <input type="text" class="form-control"
                        name="laporan[{{ $key }}][polda]"
                        value="{{ $item[1] }}" required readonly>
                </td>
                <td>
                    <input type="text" class="form-control"
                        name="laporan[{{ $key }}][polres]"
                        value="{{ $item[2] }}" required readonly>
                </td>
                <td>
                    <input type="text" class="form-control"
                        name="laporan[{{ $key }}][jumlah_pembina_polda]"
                        value="{{ $item[3] }}" required>
                </td>
                <td>
                    <input type="text" class="form-control"
                        name="laporan[{{ $key }}][jumlah_pembina_polres]"
                        value="{{ $item[4] }}" required>
                </td>
                <td>
                    <input type="file" class="form-control"
                        name="laporan[{{ $key }}][lampiran_file]"
                        accept="application/pdf,docx,doc,xlsx,xls" required>
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
            <th class="align-middle text-center">Jumlah Pembina Polda</th>
            <th class="align-middle text-center">Jumlah Pembina Polres</th>
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
        <input
            class="form-control"
            type="text"
            name="polda"
            id="polda" readonly required>
    </div>
    <div class="form-group col-sm-6">
        <label for="polres" class="form-label">Polres</label>
        <input
            class="form-control"
            type="text"
            name="polres"
            id="polres" readonly required>
    </div>
    <div class="form-group col-sm-6">
        <label for="jumlah_pembina_polda" class="form-label">Jumlah Pembina Polda</label>
        <input
            class="form-control"
            type="text"
            name="jumlah_pembina_polda"
            id="jumlah_pembina_polda" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="jumlah_pembina_polres" class="form-label">Jumlah Pembina Polres</label>
        <input
            class="form-control"
            type="text"
            name="jumlah_pembina_polres"
            id="jumlah_pembina_polres" required>
    </div>
    <div class="form-group col-sm-12">
        <label for="lampiran_file" class="form-label">Lampiran File Terbaru (Jika ada)</label>
        <input
            class="form-control col"
            type="file"
            name="lampiran_file"
            id="lampiran_file"
            accept="application/pdf,docx,doc,xlsx,xls">
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
                    <th class="align-middle text-center">${ checklistApproval }</th>
                    @endif
                    <th class="align-middle">${ rowNumber }</th>
                    <td class="align-middle">${ item.polda ?? '-' }</td>
                    <td class="align-middle">${ item.polres ?? '-' }</td>
                    <td class="align-middle">${ item.jumlah_pembina_polda }</td>
                    <td class="align-middle">${ item.jumlah_pembina_polres }</td>
                    <td class="align-middle"><a href="${ item.lampiran_file }" target="_blank">Lihat Lampiran</a></td>
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
                            onclick="insertValueToFormEdit('${ route('pembina-polmas.update', item.id) }', {
                                polda  : '${item.polda}',
                                polres : '${item.polres}',
                                jumlah_pembina_polda  : '${item.jumlah_pembina_polda}',
                                jumlah_pembina_polres : '${item.jumlah_pembina_polres}',
                            })">
                            <i class="fa fa-edit"></i>
                        </button> ` }
                        @endcan
                        @can('lapsubjar_destroy')
                        ${ !haveApprovals || !item.approval.is_approve ? `
                        <form action="${ route('pembina-polmas.destroy', item.id) }" method="post" id="${ item.id }">
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
                table += listRiwayatApproval(item.approvals, 10);
            }
            return table;
        }
    </script>
@endsection
