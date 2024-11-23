@extends('templates.admin-lte.sislap-non-harian', [
    'title'          => 'Laporan Data FKPM (Wilayah)',
    'route_template' => route('data-fkpm-wilayah.template-excel'),
    'route_import'   => route('data-fkpm-wilayah.import-excel'),
    'route_export'   => route('data-fkpm-wilayah.export-excel'),
    'route_store'    => route('data-fkpm-wilayah.store'),
    'route_search'   => route('data-fkpm-wilayah.search'),
    'route_destroy'  => route('data-fkpm-wilayah.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
    'cite'           => ' ',
])
@section("create_button")
    <a class="btn btn-info" href="{{route("data-fkpm-wilayah.create")}}">Tambah Laporan</a>
@endsection
@section('table_preview')
    <table class="table table-hover table-bordered">
        <thead class="bg-primary text-white text-center">
            <tr>
                <th  style="width: 3%" class="align-middle" rowspan="2" >No</th>
                <th  style="width: 8%" class="align-middle" rowspan="2">Polda</th>
                <th  style="width: 8%" class="align-middle" rowspan="2">Polres</th>
                <th class="align-middle" rowspan="2">Nama FKPM</th>
                <th class="align-middle" rowspan="2"> Nama Petugas Polmas</th>
                <th class="align-middle" rowspan="2"> Pangkat Petugas Polmas</th>
                <th class="align-middle" rowspan="2"> No HP/Whatsapp Petugas Polmas</th>
                <th class="align-middle" rowspan="2">Jumlah Anggota FKPM</th>
                <th class="align-middle" rowspan="2">Model Wilayah (pilih salah satu : RW/Dusun/Sejenisnya, Desa/Kelurahan)</th>
                <th style="width: 10%" class="align-middle" rowspan="2">BKPM (Balai Kemitraan Polisi Masyarakat)</th>
                <th class="align-middle" colspan="7">Alamat FKPM/BKPM</th>
                <tr class="bg-primary text-white text-center">
                    <td class="align-middle">Rw</td>
                    <td class="align-middle">Dusun</td>
                    <td class="align-middle">Desa/Kel</td>
                    <td class="align-middle">Kecamatan</td>
                    <td class="align-middle">Kab/Kota</td>
                    <td class="align-middle">Provinsi</td>
                    <td class="align-middle">Keterangan</td>
                </tr>
            </tr>
        </thead>
        <tbody>
            @if(isset($laporan))
            @foreach ($laporan[0] as $key => $item)
            @if($key > 1)
            <tr>
                <th class="text-center">{{ $item[0] }}</th>
                <td>
                    <input type="text" class="form-control" style="width :200px"
                            name="laporan[{{ $key }}][polda]"
                            value="{{ $item[1] }}" required readonly>
                </td>
                <td>
                    <input type="text" class="form-control" style="width :200px"
                            name="laporan[{{ $key }}][polres]"
                            value="{{ $item[2] }}" required readonly>
                </td>
                <td>
                    <input type="text" class="form-control" style="width :150px"
                            name="laporan[{{ $key }}][nama_fkpm]"
                            value="{{ $item[3] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :100px"
                            name="laporan[{{ $key }}][nama_petugas_polmas]"
                            value="{{ $item[4] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :100px"
                            name="laporan[{{ $key }}][pangkat_petugas_polmas]"
                            value="{{ $item[5] }}">
                </td>
                <td>
                    <input type="number" class="form-control" style="width :100px"
                            name="laporan[{{ $key }}][no_hp_petugas_polmas]"
                            value="{{ $item[6] }}">
                </td>
                <td>
                    <input type="number" class="form-control" style="width :60px"
                            name="laporan[{{ $key }}][jumlah_anggota_fkpm]"
                            value="{{ $item[7] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :150px"
                            name="laporan[{{ $key }}][wilayah]"
                            value="{{ $item[8] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :100px"
                            name="laporan[{{ $key }}][bkpm]"
                            value="{{ $item[9] }}">
                </td>
                <td>
                    <input type="number" class="form-control" style="width :80px"
                            name="laporan[{{ $key }}][rw]"
                            value="{{ $item[10] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :100px"
                            name="laporan[{{ $key }}][dusun]"
                            value="{{ $item[11] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :200px"
                            name="laporan[{{ $key }}][desa_kel]"
                            value="{{ $item[12] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :100px"
                            name="laporan[{{ $key }}][kecamatan]"
                            value="{{ $item[13] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :100px"
                            name="laporan[{{ $key }}][kab_kota]"
                            value="{{ $item[14] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :150px"
                            name="laporan[{{ $key }}][provinsi]"
                            value="{{ $item[15] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width :200px"
                            name="laporan[{{ $key }}][keterangan]"
                            value="{{ $item[16] }}">
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
                <th style="width: 3%" class="align-middle" rowspan="2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                        <label class="form-check-label" for="check-all"></label>
                    </div>
                </th>
                @endcan
                <th style="width: 3%" class="align-middle"rowspan="2">No</th>
                <th style="width: 10%" class="align-middle"rowspan="2">Polda</th>
                <th style="width: 10%" class="align-middle"rowspan="2">Polres</th>
                <th class="align-middle" rowspan="2">Nama FKPM</th>
                <th class="align-middle" rowspan="2">Petugas Polmas (Nama, Pangkat No HP/Whatsapp)</th>
                <th class="align-middle" rowspan="2">Jumlah Anggota FKPM</th>
                <th class="align-middle" rowspan="2">Model Wilayah (pilih salah satu : RW, Dusun, Desa/Kelurahan)</th>
                <th class="align-middle" rowspan="2">BKPM (ada/tidak ada)</th>
                <th class="align-middle" colspan="7">Alamat FKPM/BKPM</th>
                @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                <th class="align-middle" width="4%" rowspan="2" >Tanggal Laporan</th>
                <th class="align-middle" width="4%" rowspan="2" >Aksi</th>
                @endcanany
                <tr class="bg-primary text-center">
                    <td>Rw</td>
                    <td>Dusun</td>
                    <td>Desa/Kel</td>
                    <td>Kec</td>
                    <td>Kab/Kota</td>
                    <td>Provinsi</td>
                    <td>Keterangan(Alamat Diisi Lengkap)</td>
                </tr>
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
        <label for="nama_fkpm" class="form-label">Nama FKPM</label>
        <input class="form-control" type="text" name="nama_fkpm" id="nama_fkpm" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="nama_petugas_polmas" class="form-label">Nama Petugas Polmas</label>
        <input class="form-control" type="text" name="nama_petugas_polmas" id="nama_petugas_polmas" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="pangkat_petugas_polmas" class="form-label">Pangkat Petugas Polmas</label>
        <input class="form-control" type="text" name="pangkat_petugas_polmas" id="pangkat_petugas_polmas" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="no_hp_petugas_polmas" class="form-label">No HP/Whatsapp Petugas Polmas</label>
        <input class="form-control" type="text" name="no_hp_petugas_polmas" id="no_hp_petugas_polmas" required>
    </div>
    <div class="form-group col-sm-6">
        <br>
        <label for="jumlah_anggota_fkpm" class="form-label">Jumlah Anggota FKPM</label>
        <input class="form-control" type="number" name="jumlah_anggota_fkpm" id="jumlah_anggota_fkpm" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="wilayah" class="form-label">Model Wilayah (pilih salah satu : RW, Dusun, Desa/Kel)</label>
        <input class="form-control" type="text" name="wilayah" id="wilayah" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="bkpm" class="form-label">BKPM (Balai Kemitraan Polisi Masyarakat) (Pilih salah satu : ada/tidak ada)</label>
        <input class="form-control" type="text" name="bkpm" id="bkpm" required>
    </div>
    <div class="form-group col-sm-6">
        <br>
        <label for="rw" class="form-label">Rw</label>
        <input class="form-control" type="number" name="rw" id="rw" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="dusun" class="form-label">Dusun</label>
        <input class="form-control" type="text" name="dusun" id="dusun" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="desa_kel" class="form-label">Desa/Kelurahan</label>
        <input class="form-control" type="text" name="desa_kel" id="desa_kel" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="kecamatan" class="form-label">Kecamatan</label>
        <input class="form-control" type="text" name="kecamatan" id="kecamatan" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="kab_kota" class="form-label">Kabupaten/Kota</label>
        <input class="form-control" type="text" name="kab_kota" id="kab_kota" required>
    </div>
    <div class="form-group col-sm-12">
        <label for="provinsi" class="form-label">Provinsi</label>
        <input class="form-control" type="text" name="provinsi" id="provinsi" required>
    </div>
    <div class="form-group col-sm-12">
        <label for="keterangan" class="form-label">Keterangan(Alamat Lengkap)</label>
        <input class="form-control" type="text" name="keterangan" id="keterangan" required>
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
                        <th class="align-middle">${ rowNumber }</th>
                        <td class="align-middle">${ item.polda ?? '-' }</td>
                        <td class="align-middle">${ item.polres ?? '-' }</td>
                        <td class="align-middle">${ item.nama_fkpm }</td>
                        <td class="align-middle">${ item.nama_petugas_polmas}, ${item.pangkat_petugas_polmas},${item.no_hp_petugas_polmas} </td>
                        <td class="align-middle">${ item.jumlah_anggota_fkpm }</td>
                        <td class="align-middle">${ item.wilayah }</td>
                        <td class="align-middle">${ item.bkpm}</td>
                        <td class="align-middle">${ item.rw }</td>
                        <td class="align-middle">${ item.dusun }</td>
                        <td class="align-middle">${ item.desa_kel }</td>
                        <td class="align-middle">${ item.kecamatan }</td>
                        <td class="align-middle">${ item.kab_kota }</td>
                        <td class="align-middle">${ item.provinsi }</td>
                        <td class="align-middle">${ item.keterangan }</td>
                        <td class="align-middle">${ formatDate(item.created_at) }</td>
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
                                        onclick="insertValueToFormEdit('${ route('data-fkpm-wilayah.update', item.id) }', {
                                            polda               : '${item.polda}',
                                            polres              : '${item.polres}',
                                            nama_fkpm           : '${item.nama_fkpm}',
                                            nama_petugas_polmas   : '${item.nama_petugas_polmas}',
                                            pangkat_petugas_polmas   : '${item.pangkat_petugas_polmas}',
                                            no_hp_petugas_polmas   : '${item.no_hp_petugas_polmas}',
                                            jumlah_anggota_fkpm   : '${item.jumlah_anggota_fkpm}',
                                            wilayah       : '${item.wilayah}',
                                            bkpm                : '${item.bkpm}',
                                            rw                  : '${item.rw}',
                                            dusun               : '${item.dusun}',
                                            desa_kel            : '${item.desa_kel}',
                                            kecamatan            : '${item.kecamatan}',
                                            kab_kota            : '${item.kab_kota}',
                                            provinsi            : '${item.provinsi}',
                                            keterangan          : '${item.keterangan}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan

                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('data-fkpm-wilayah.destroy', item.id) }" method="post" id="${ item.id }">
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
                    table += listRiwayatApproval(item.approvals, 18);
                }
                return table;
            }
    </script>
@endsection
