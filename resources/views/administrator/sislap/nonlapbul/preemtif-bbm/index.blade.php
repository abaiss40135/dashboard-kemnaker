@extends('templates.admin-lte.sislap', [
    'title'          => 'Laporan Giat Preemtif Pengalihan Subsidi BBM',
    'route_template' => route('preemtif-bbm.template-excel'),
    'route_import'   => route('preemtif-bbm.import-excel'),
    'route_export'   => route('preemtif-bbm.export-excel'),
    'route_store'    => route('preemtif-bbm.store'),
    'route_search'   => route('preemtif-bbm.search'),
    'route_destroy'  => route('preemtif-bbm.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
    'cite'           => 'Tekan terus tombol <code>ctrl</code> dan klik beberapa berkas dokumentasi untuk memilih lebih dari satu berkas'
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
                <th style="width: 60px">NO</th>
                <th>POLDA</th>
                <th>POLRES</th>
                <th>JENIS KEGIATAN PREEMTIF</th>
                <th>JUMLAH MASYARAKAT YANG DILIBATKAN</th>
                <th>DOKUMENTASI</th>
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
                           class="form-control" value="{{ $item[1] }}" required readonly>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][polres]"
                           class="form-control" value="{{ $item[2] }}" required readonly>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][jenis_giat_preemtif]"
                           class="form-control" value="{{ $item[3] }}" required>
                </td>
                <td>
                    <input type="text" name="laporan[{{ $key }}][jml_masyarakat_dilibatkan]"
                           class="form-control" value="{{ $item[4] }}" required>
                </td>
                <td>
                    <input type="file" name="laporan[{{ $key }}][dokumentasi][]"
                           accept="image/*" class="form-control" required multiple>
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
                <th class="align-middle">POLDA</th>
                <th class="align-middle">POLRES</th>
                <th class="align-middle">JENIS KEGIATAN PREEMTIF</th>
                <th class="align-middle">JUMLAH MASYARAKAT YANG DILIBATKAN</th>
                <th class="align-middle">DOKUMENTASI</th>
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
            <label for="polda" class="form-label">Polda</label>
            <input type="text" name="polda" id="polda"
                   step="1" required class="form-control">
        </div>
        <div class="form-group col-sm-6">
            <label for="polres" class="form-label">Polres</label>
            <input type="text" name="polres" id="polres"
                   step="1" required class="form-control">
        </div>
    </div>
    <div class="row w-100">
        <div class="form-group col-sm-6">
            <label for="jenis_giat_preemtif" class="form-label">Jenis Kegiatan Preemtif</label>
            <input type="text" name="jenis_giat_preemtif" id="jenis_giat_preemtif"
                   step="1" required class="form-control">
        </div>
        <div class="form-group col-sm-6">
            <label for="jml_masyarakat_dilibatkan" class="form-label">Jumlah Masyarakat yang Dilibatkan</label>
            <input type="text" name="jml_masyarakat_dilibatkan" id="jml_masyarakat_dilibatkan"
                   step="1" required class="form-control">
        </div>
    </div>
    <div class="row w-100">
        <div class="form-group col-sm-12">
            <label for="dokumentasi" class="form-label">Dokumentasi</label>
            <input accept="image/*" type="file" name="dokumentasi[]" id="dokumentasi"
                   class="form-control" multiple>
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

            let dokumentasis = [`<ul>`];
            for (dokumentasi of item.dokumentasi) {
                dokumentasis.push(`\
                    <li><a href="${dokumentasi.file_uri}" target="_blank">${dokumentasi.file.split('/').pop()}</a></li>
                `)
            }
            dokumentasis.push(`</ul>`)

            let table = `
                <tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"': ''}
                    ${ haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : '' }>
                    @can('sislap_approval_create')
                        <th class="align-middle text-center">
                            ${ checklistApproval }
                        </th>
                    @endcan
                    <th class="text-center">${ rowNumber }</th>
                    <td>${ item.polda }</td>
                    <td>${ item.polres }</td>
                    <td>${ item.jenis_giat_preemtif }</td>
                    <td>${ item.jml_masyarakat_dilibatkan }</td>
                    <td>${ dokumentasis.join('') }</td>
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
                                    onclick="insertValueToFormEdit('${route('preemtif-bbm.update', item.id)}', {
                                        polda                       : '${item.polda}',
                                        polres                      : '${item.polres}',
                                        jenis_giat_preemtif         : '${item.jenis_giat_preemtif}',
                                        jml_masyarakat_dilibatkan   : '${item.jml_masyarakat_dilibatkan}',
                                    })">
                                <i class="fa fa-edit"></i>
                            </button> ` }
                        @endcan
                        @can('lapsubjar_destroy')
                        ${ !haveApprovals || !item.approval.is_approve ? `
                        <form action="${ route('preemtif-bbm.destroy', item.id) }" method="post" id="${ item.id }">
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
