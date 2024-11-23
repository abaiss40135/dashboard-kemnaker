@extends('templates.admin-lte.sislap-non-harian', [
    'title'          => 'Data Petugas Polmas, Supervisor Polmas, dan Pembina Polmas',
    'route_template' => '#',
    'route_import'   => '#',
    'route_export'   => '#',
    'route_store'    => route('data-petugas-polmas.store'),
    'route_search'   => route('pembina-polmas.search'),
    'route_destroy'  => route('data-petugas-polmas.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
])
@section('table_preview')
    <table class="table table-hover table-bordered table-responsive" style="table-layout: fixed;">
        <thead class="text-center bg-primary">
        <tr>
            <th style="width: 50px;">No</th>
            <th class="align-middle">Nama</th>
            <th class="align-middle">Pangkat</th>
            <th class="align-middle">Polda</th>
            <th class="align-middle">Polres</th>
            <th class="align-middle">Polsek</th>
            <th class="align-middle">Jabatan</th>
            <th class="align-middle">Tamat Jabatan</th>
            <th class="align-middle">Kode Satuan</th>
            <th class="align-middle">Handphone</th>
            <th class="align-middle">Jenis Kelamin</th>
            <th class="align-middle">Tanggal Lahir</th>
            <th class="align-middle">Lokasi Penugasan</th>
        </tr>
        </thead>
        <tbody>
        @php
            // menghilangkan key polda dan polres
            array_splice($columns, 0, 2);
        @endphp
        @if(isset($laporan))
            @foreach ($laporan[0] as $key => $item)
                @if($key > 0)
                    <tr>
                        <th class="text-center">{{ $item[0] }}</th>
                        <td>
                            <input type="text" class="form-control" style="width: min-content"
                                   name="laporan[{{ $key }}][polda]"
                                   value="{{ $item[1] }}" required readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control" style="width: min-content"
                                   name="laporan[{{ $key }}][polres]"
                                   value="{{ $item[2] }}" required readonly>
                        </td>
                        @php
                            $begin = 3;
                        @endphp
                        @foreach($columns as $column)
                            <td>
                                @if($column == "sumber_dana")
                                    @php
                                        $valueSumberDana = $item[$begin++];
                                    @endphp
                                    <select style="width: 420px;" class="form-control" name="laporan[{{ $key }}][sumber_dana]"
                                            id="sumber_dana">
                                        <option selected value="">Pilih salah satu pilihan dibawah!</option>
                                        <option
                                                @if(str_contains(trim(strtolower($valueSumberDana)), 'apbn/apbd') || str_contains(trim(strtolower($valueSumberDana)), 'apbn') || str_contains(trim(strtolower($valueSumberDana)), 'apbd'))
                                                    selected
                                                @endif
                                                value="APBN/APBD">
                                            APBN/APBD
                                        </option>
                                        <option
                                                @if(str_contains(strtolower($valueSumberDana), 'iuran anggota'))
                                                    selected
                                                @endif
                                                value="Iuran Anggota">
                                            Iuran
                                        </option>
                                        <option
                                                @if(str_contains(strtolower($valueSumberDana), 'asing') || str_contains(strtolower($valueSumberDana), 'masyarakat'))
                                                    selected
                                                @endif
                                                value="Bantuan/Sumbangan Masyarakat/Asing/Lembaga Asing">
                                            Bantuan/Sumbangan Masyarakat/Asing/Lembaga Asing
                                        </option>
                                        <option
                                                @if(str_contains(strtolower($valueSumberDana), 'hasil usaha kommas') || str_contains(strtolower($valueSumberDana), 'komunitas masyarakat')) selected
                                                @endif
                                                value="Hasil Usaha Kommas">
                                            Hasil Usaha Kommas
                                        </option>
                                    </select>
                                @else
                                    <input type="text" class="form-control" style="width: min-content"
                                           name="laporan[{{ $key }}][{{$column}}]"
                                           value="{{ $item[$begin++] }}" required>
                                @endif
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
{{--            @can('sislap_approval_create')--}}
{{--                <th style="width: 3%" class="align-middle">--}}
{{--                    <div class="form-check">--}}
{{--                        <input type="checkbox" class="form-check-input" name="check_all" id="check-all">--}}
{{--                        <label class="form-check-label" for="check-all"></label>--}}
{{--                    </div>--}}
{{--                </th>--}}
{{--            @endcan--}}
            <th style="width: 3%" class="align-middle">No</th>
            <th class="align-middle">Nama</th>
            <th class="align-middle">Pangkat</th>
            <th style="width: 12%" class="align-middle">Polda</th>
            <th style="width: 14%" class="align-middle">Polres</th>
            <th style="width: 14%" class="align-middle">Polsek</th>
            <th class="align-middle">Jabatan</th>
            <th class="align-middle">Tamat Jabatan</th>
            <th class="align-middle">Kode Satuan</th>
            <th class="align-middle">Handphone</th>
            <th class="align-middle">Jenis Kelamin</th>
            <th class="align-middle">Tanggal Lahir</th>
            <th class="align-middle">Lokasi Penugasan</th>
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
        <label for="nama_kommas" class="form-label">Nama Kommas</label>
        <input class="form-control" type="text" name="nama_kommas" id="nama_kommas" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="akta_notaris" class="form-label">Akta Notaris</label>
        <input class="form-control" type="text" name="akta_notaris" id="akta_notaris" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="npwp" class="form-label">NPWP</label>
        <input class="form-control" type="number" name="npwp" id="npwp" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="sumber_dana" class="form-label">Sumber Dana</label>
        <select class="form-control" name="sumber_dana" id="sumber_dana">
            <option value="Iuran Anggora">Iuran Anggora</option>
            <option value="Bantuan/Sumbangan Masyarakat/Asing/Lembaga Asing">Bantuan/Sumbangan Masyarakat/Asing/Lembaga
                Asing
            </option>
            <option value="Hasil Usaha Kommas">Hasil Usaha Kommas</option>
            <option value="APBN/APBD">APBN/APBD</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label for="bidang_kegiatan" class="form-label">Bidang Kegiatan</label>
        <input class="form-control" type="text" name="bidang_kegiatan" id="bidang_kegiatan" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="jml_anggota" class="form-label">Jumlah Anggota</label>
        <input class="form-control" type="number" name="jml_anggota" id="jml_anggota" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="alamat" class="form-label">Alamat</label>
        <input class="form-control" type="text" name="alamat" id="alamat" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="nama_ketua" class="form-label">Nama Ketua</label>
        <input class="form-control" type="text" name="nama_ketua" id="nama_ketua" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="no_hp" class="form-label">No. Handphone</label>
        <input class="form-control" type="number" name="no_hp" id="no_hp" required>
    </div>
@endsection
@section('row_table')
    <script>
        // must create function createTableRow
        function createTableRow(item, rowNumber) {
            let table = `
                    <tr ${haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"' : ''} ${haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : ''}>
                        @can('sislap_approval_create')
            <th class="align-middle text-center">
${checklistApproval}
                            </th>
                        @endcan
            <th class="text-center">${rowNumber}</th>
                            <td class="text-center">${item.nama}</td>
                            <td class="text-center">${item.pangkat}</td>
                            <td class="text-center">${item.polda ?? '-'}</td>
                            <td class="text-center">${item.polres ?? '-'}</td>
                            <td class="text-center">${item.polsek ?? '-'}</td>
                            <td class="text-center">${item.jabatan}</td>
                            <td class="text-center">${item.tamat_jabatan}</td>
                            <td class="text-center">${item.kode_satuan}</td>
                            <td class="text-center">${item.handphone}</td>
                            <td class="text-center">${item.jenis_kelamin}</td>
                            <td class="text-center">${item.tanggal_lahir}</td>
                            <td class="text-center">${item.lokasi_penugasan}</td>
                        @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
            <td class="align-middle text-center">
@can('sislap_approval_decline')
            ${!haveApprovals || item.approval.is_approve === null || item.approval.is_approve ? `
                                    <button class="btn btn-decline btn-danger mb-1"
                                            onclick="decline(${item.id})">
                                            <i class="fas fa-times-circle"></i>
                                    </button>
                                ` : ``}
                            @endcan
            @can('lapsubjar_edit')
            ${haveApprovals && !item.need_approve ? `` : `
                                <button class="btn btn-edit btn-warning mb-1"
                                        data-toggle="modal" data-target="#modalEdit"
                                        onclick="insertValueToFormEdit('${route('data-petugas-polmas.update', item.id)}', {
                                            polda            : '${item.polda}',
                                            polres           : '${item.polres}',
                                            nama_kommas           : '${item.nama_kommas}',
                                            akta_notaris           : '${item.akta_notaris}',
                                            npwp           : '${item.npwp}',
                                            sumber_dana           : '${item.sumber_dana}',
                                            bidang_kegiatan           : '${item.bidang_kegiatan}',
                                            jml_anggota           : '${item.jml_anggota}',
                                            alamat           : '${item.alamat}',
                                            nama_ketua           : '${item.nama_ketua}',
                                            no_hp           : '${item.no_hp}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> `}
                            @endcan
            @can('lapsubjar_destroy')
            ${!haveApprovals || !item.approval.is_approve ? `
                            <form action="${route('data-petugas-polmas.destroy', item.id)}" method="post" id="${item.id}">
                                @method('delete')
            @csrf
            <button class="btn btn-danger btn-delete" type="submit" onclick="event.preventDefault(); deleteConfirm(${item.id})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>` : ``}
                            @endcan
            </td>
@endcanany
            </tr>`;
            let haveApprovals = item.approvals.length > 0;
            let checklistApproval = item.need_approve ? `
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input checklist-approval"
                               name="check_approval[${item.id}]" data-id="${item.id}"
                               aria-label="check-row">
                    </div>` : '';
            if (haveApprovals) {
                table += listRiwayatApproval(item.approvals, 16);
            }
            return table;
        }
    </script>
@endsection
