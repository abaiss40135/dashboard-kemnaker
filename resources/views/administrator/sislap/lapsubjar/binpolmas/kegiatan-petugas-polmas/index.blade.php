@extends('templates.admin-lte.sislap-non-harian', [
    'title'          => 'DATA KEGIATAN PETUGAS POLMAS',
    'route_template' => route('kegiatan-petugas-polmas.template-excel'),
    'route_import'   => route('kegiatan-petugas-polmas.import-excel'),
    'route_export'   => route('kegiatan-petugas-polmas.export-excel'),
    'route_store'    => route('kegiatan-petugas-polmas.store'),
    'route_search'   => route('kegiatan-petugas-polmas.search'),
    'route_destroy'  => route('kegiatan-petugas-polmas.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
    'range'          => 'monthly',
    'cite'           => ''
])
@section('create_button')
    @if(!empty(auth()->user()->personel->kode_satuan) && can('lapsubjar_create'))
        <a href="{{ route('kegiatan-petugas-polmas.template-lampiran') }}" class="btn btn-warning">Unduh Template Lampiran</a>
        <a class="btn btn-info" href="{{ route("kegiatan-petugas-polmas.create") }}">Tambah Laporan</a>
    @endif
@endsection
@section('table_preview')
    <table class="table table-hover table-bordered" style="table-layout: fixed;">
        <thead class="text-center bg-primary">
            <tr>
                <th style="width: 60px">NO</th>
                <th>POLDA</th>
                <th>POLRES</th>
                <th>JUMLAH SAMBANG/KUNJUNGAN</th>
                <th>JUMLAH PEMECAHAN MASALAH SOSIAL</th>
                <th>JUMLAH LAPORAN INFORMASI</th>
                <th>JUMLAH PENANGANAN PERKARA RINGAN</th>
                <th>LAMPIRAN</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($laporan))
                @foreach($laporan[0] as $key => $item)
                    @if($key > 0)
                        <tr>
                            <th class="text-center">{{ $item[0] }}</th>
                            <td>
                                <input
                                    type="text"
                                    name="data[{{ $key }}][polda]"
                                    class="form-control"
                                    value="{{ $item[1] }}" required readonly>
                            </td>
                            <td>
                                <input
                                    type="text"
                                    name="data[{{ $key }}][polres]"
                                    class="form-control"
                                    value="{{ $item[2] }}" required>
                            </td>
                            <td>
                                <input
                                    type="number"
                                    name="data[{{ $key }}][sambang]"
                                    class="form-control"
                                    value="{{ $item[3] }}" required>
                            </td>
                            <td>
                                <input
                                    type="number"
                                    name="data[{{ $key }}][pemecahan_masalah]"
                                    class="form-control"
                                    value="{{ $item[4] }}" required>
                            </td>
                            <td>
                                <input
                                    type="number"
                                    name="data[{{ $key }}][laporan_informasi]"
                                    class="form-control"
                                    value="{{ $item[5] }}" required>
                            </td>
                            <td>
                                <input
                                    type="number"
                                    name="data[{{ $key }}][penanganan_perkara_ringan]"
                                    class="form-control"
                                    value="{{ $item[6] }}" required>
                            </td>
                            <td>
                                <input
                                    type="file"
                                    name="data[{{ $key }}][lampiran]"
                                    accept="application/pdf,docx,doc,xlsx,xls" required>
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
                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="check_all"
                            id="check-all">
                        <label class="form-check-label" for="check-all"></label>
                    </div>
                </th>
                @endcan
                <th class="align-middle">NO</th>
                <th class="align-middle">POLDA</th>
                <th class="align-middle">POLRES</th>
                <th class="align-middle">JUMLAH SAMBANG/KUNJUNGAN</th>
                <th class="align-middle">JUMLAH PEMECAHAN MASALAH SOSIAL</th>
                <th class="align-middle">JUMLAH LAPORAN INFORMASI</th>
                <th class="align-middle">JUMLAH PENANGANAN PERKARA RINGAN</th>
                <th class="align-middle">LAMPIRAN</th>
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
            <input
                type="text"
                name="polda"
                id="polda"
                class="form-control"
                required>
        </div>
        <div class="form-group col-sm-6">
            <label for="polres" class="form-label">Polres</label>
            <input
                type="text"
                name="polres"
                id="polres"
                class="form-control"
                required>
        </div>
        <div class="form-group col-sm-6">
            <label for="sambang" class="form-label">Jumlah Sambang/Kunjungan</label>
            <input
                type="text"
                name="sambang"
                id="sambang"
                class="form-control"
                required>
        </div>
        <div class="form-group col-sm-6">
            <label for="pemecahan_masalah" class="form-label">Jumlah Pemecahan Masalah Sosial</label>
            <input
                type="text"
                name="pemecahan_masalah"
                id="pemecahan_masalah"
                class="form-control"
                required>
        </div>
        <div class="form-group col-sm-6">
            <label for="laporan_informasi" class="form-label">Jumlah Laporan Informasi</label>
            <input
                type="text"
                name="laporan_informasi"
                id="laporan_informasi"
                class="form-control"
                required>
        </div>
        <div class="form-group col-sm-6">
            <label for="penanganan_perkara_ringan" class="form-label">Jumlah Penanganan Perkara Ringan</label>
            <input
                type="text"
                name="penanganan_perkara_ringan"
                id="penanganan_perkara_ringan"
                class="form-control"
                required>
        </div>
        <div class="form-group col-sm-12">
            <label for="lampiran_file" class="form-label">Lampiran File Terbaru (Jika ada)</label>
            <input class="form-control"
                   type="file"
                   name="lampiran"
                   id="lampiran"
                   accept="application/pdf,docx,doc,xlsx,xls">
        </div>
    </div>
@endsection
@section('row_table')
    <script>
        let start_date = moment().startOf('month').format('YYYY-MM-DD');
        let end_date   = moment().endOf('month').format('YYYY-MM-DD');

        $('#start_date').val(start_date);
        $('#end_date').val(end_date);

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
                    <td>${ item.polda }</td>
                    <td>${ item.polres }</td>
                    <td>${ item.sambang }</td>
                    <td>${ item.pemecahan_masalah }</td>
                    <td>${ item.laporan_informasi }</td>
                    <td>${ item.penanganan_perkara_ringan }</td>
                    <td><a href="${ item.lampiran_url }" target="_blank">Lihat Lampiran</a></td>
                    <td class="text-center">${ formatDate(item.created_at) }</td>
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
                                onclick="insertValueToFormEdit('${route('kegiatan-petugas-polmas.update', item.id)}', {
                                    polda: '${item.polda}',
                                    polres: '${item.polres}',
                                    sambang: '${item.sambang}',
                                    pemecahan_masalah: '${item.pemecahan_masalah}',
                                    laporan_informasi: '${item.laporan_informasi}',
                                    penanganan_perkara_ringan: '${item.penanganan_perkara_ringan}',
                                })">
                                <i class="fa fa-edit"></i>
                            </button> ` }
                        @endcan
                        @can('lapsubjar_destroy')
                        ${ !haveApprovals || !item.approval.is_approve ? `
                        <form action="${ route('kegiatan-petugas-polmas.destroy', item.id) }" method="post" id="${ item.id }">
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
                table += listRiwayatApproval(item.approvals, 11);
            }
            return table;
        }
    </script>
@endsection
