@extends('templates.admin-lte.sislap-non-harian', [
    'title'          => 'Data Orsosmas Binaan Polri',
    'route_template' => route('data-orsosmas.template-excel'),
    'route_import'   => route('data-orsosmas.import-excel'),
    'route_export'   => route('data-orsosmas.export-excel'),
    'route_store'    => route('data-orsosmas.store'),
    'route_search'   => route('data-orsosmas.search'),
    'route_destroy'  => route('data-orsosmas.destroy', 'id'),
    'laporan_exist'  => isset($laporan),
    'model'          => $model,
    'cite'           => '',
])
@section("create_button")
    <a href="{{ route('data-orsosmas.create') }}" class="btn btn-info">
        Tambah Data
    </a>
@endsection
@section('table_preview')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="text-center bg-primary">
            <tr>
                <th rowspan="2" style="width: 10%" style="width: 50px;">No</th>
                <th rowspan="2" style="width: 20%" class="align-middle">Polda</th>
                <th rowspan="2" style="width: 20%" class="align-middle">Polres</th>
                <th rowspan="2" class="align-middle">Nama Orsosmas</th>
                <th rowspan="2" class="align-middle">Dasar Hukum</th>
                <th rowspan="2" class="align-middle">Tanggal Dasar Hukum</th>
                <th rowspan="2" class="align-middle">Nomor Akta Notaris</th>
                <th rowspan="2" class="align-middle">Tanggal Akta Notaris</th>
                <th rowspan="2" class="align-middle">NPWP</th>
                <th colspan="7" class="align-middle">Alamat</th>
                <th rowspan="2" class="align-middle">Sumber Dana</th>
                <th rowspan="2" class="align-middle">Bidang Kegiatan</th>
                <th rowspan="2" class="align-middle">Jumlah Anggota</th>
                <th rowspan="2" class="align-middle">Nama Ketua</th>
                <th rowspan="2" class="align-middle">Nomor HP Ketua</th>
            </tr>
            <tr>
                <th class="align-middle">RW</th>
                <th class="align-middle">RT</th>
                <th class="align-middle">Kelurahan/Desa</th>
                <th class="align-middle">Kecamatan</th>
                <th class="align-middle">Kota/Kabupaten</th>
                <th class="align-middle">Provinsi</th>
                <th class="align-middle">Detail Alamat</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($laporan))
                @foreach ($laporan[0] as $key => $item)
                    @if($key >= 2)
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
                                <input style="width: 250px;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][nama_orsosmas]"
                                       value="{{ $item[3] }}" required>
                            </td>
                            <td>
                                <input style="width: 150px;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][type]"
                                       value="{{ $item[4] }}" required>
                            </td>
                            <td>
                                @php
                                    try {
                                        $date = DateTime::createFromFormat('d/m/Y', str_replace(["\n", "\r", "\x1a"], '', $item[5]));
                                        if(!is_bool($date)) {
                                            $date = $date->format('Y-m-d');
                                        } else {
                                            $date = date('Y-m-d', mktime(0, 0, 0, 1, $item[5] - 1, 1900));
                                        }
                                @endphp
                                <input style="width: 150px;" type="date" class="form-control"
                                       name="laporan[{{ $key }}][tanggal_dasar_hukum]"
                                       value="{{$date}}" required>
                                @php
                                    } catch(\Throwable $e) {
                                @endphp
                                ">
                                <script>window.location.href = '{{route('data-orsosmas.error-date', 'Dasar Hukum')}}';</script>
                                @php
                                    }
                                @endphp
                            </td>
                            <td>
                                <input style="width: 150px;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][akta_notaris]"
                                       value="{{ $item[6] }}" required>
                            </td>
                            <td>
                                @php
                                    try {
                                        $date = DateTime::createFromFormat('d/m/Y', str_replace(["\n", "\r", "\x1a"], '', $item[7]));
                                        if(!is_bool($date)) {
                                            $date = $date->format('Y-m-d');
                                        } else {
                                            $date = date('Y-m-d', mktime(0, 0, 0, 1, $item[7] - 1, 1900));
                                        }
                                @endphp
                                <input style="width: 150px;" type="date" class="form-control"
                                       name="laporan[{{ $key }}][tanggal_akta_notaris]"
                                       value="{{$date}}" required>
                                @php
                                    } catch(\Throwable $e) {
                                @endphp
                                ">
                                <script>window.location.href = '{{route('data-orsosmas.error-date', 'Akta Notaris')}}';</script>
                                @php
                                    }
                                @endphp
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][npwp]" value="{{$item[8]}}"
                                       required>
                            </td>
                            <td>
                                <input style="width: 50px; display: block;" type="number" class="form-control"
                                       name="laporan[{{ $key }}][rw]"
                                       value="{{ $item[9] }}" required>
                            </td>
                            <td>
                                <input style="width: 50px; display: block;" type="number" class="form-control"
                                       name="laporan[{{ $key }}][rt]"
                                       value="{{ $item[10] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][desa]"
                                       value="{{ $item[11] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][kecamatan]"
                                       value="{{ $item[12] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][kabupaten]"
                                       value="{{ $item[13] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][provinsi]"
                                       value="{{ $item[14] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][jalan]"
                                       value="{{ $item[15] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][sumber_dana]"
                                        value="{{ $item[16] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][bidang_kegiatan]"
                                       value="{{ $item[17] }}" required>
                            </td>
                            <td>
                                <input style="width: 75px; display: block;" type="number" class="form-control"
                                       name="laporan[{{ $key }}][jml_anggota]"
                                       value="{{ $item[18] }}" required>
                            </td>
                            <td>
                                <input style="width: 250px; display: block;" type="text" class="form-control"
                                       name="laporan[{{ $key }}][nama_ketua]"
                                       value="{{ $item[19] }}" required>
                            </td>
                            <td>
                                <input style="width: 200px; display: block;" type="number" class="form-control"
                                       name="laporan[{{ $key }}][no_hp_ketua]"
                                       value="{{ $item[20] }}" required>
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
            @can('sislap_approval_create')
                <th style="width: 3%" class="align-middle" rowspan="2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                        <label class="form-check-label" for="check-all"></label>
                    </div>
                </th>
            @endcan
            <th  style="width: 3%" class="align-middle" rowspan="2" >No</th>
            <th  style="width: 8%" class="align-middle" rowspan="2">Polda</th>
            <th  style="width: 8%" class="align-middle" rowspan="2">Polres</th>
            <th rowspan="2" class="align-middle">Nama Orsosmas</th>
            <th rowspan="2" class="align-middle">Dasar Hukum</th>
            <th rowspan="2" class="align-middle">Akta Notaris</th>
            <th rowspan="2" class="align-middle">NPWP</th>
            <th colspan="7" class="align-middle">Alamat</th>
            <th rowspan="2" class="align-middle">Sumber Dana</th>
            <th rowspan="2" class="align-middle">Bidang Kegiatan</th>
            <th rowspan="2" class="align-middle">Jumlah Anggota</th>
            <th rowspan="2" class="align-middle">Ketua Ormas</th>
            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                <th class="align-middle" rowspan="2" >Tanggal Laporan</th>
                <th class="align-middle" width="4%" rowspan="2" >Aksi</th>
            @endcanany
        <tr class="bg-primary text-center">
            <td class="align-middle" >RW</td>
            <td class="align-middle" >RT</td>
            <td class="align-middle" >Desa/Kelurahan</td>
            <td class="align-middle" >Kecamatan</td>
            <td class="align-middle" >Kab/Kota</td>
            <td class="align-middle" >Provinsi</td>
            <td style="width: 350px; display: block" class="align-middle" >Detail Alamat</td>
        </tr>
        </tr>
        </thead>
        <tbody id="content-wrapper"></tbody>
        {{-- TODO Generate sum content from sums return data --}}
        <tfoot id="sum-content"></tfoot>
    </table>
@endsection
@section('form_edit')
    <input type="text" name="provinsi_code" class="d-none">
    <input type="text" name="kabupaten_code" class="d-none">
    <input type="text" name="kecamatan_code" class="d-none">
    <input type="text" name="desa_code" class="d-none">
    <div class="form-group col-sm-6">
        <label for="polda" class="form-label">Polda</label>
        <input class="form-control" type="text" name="polda" id="polda" readonly required>
    </div>
    <div class="form-group col-sm-6">
        <label for="polres" class="form-label">Polres</label>
        <input class="form-control" type="text" name="polres" id="polres" readonly required>
    </div>
    <div class="form-group col-sm-6">
        <label for="nama_orsosmas" class="form-label">Nama Orsosmas</label>
        <input class="form-control" type="text" name="nama_orsosmas" id="nama_orsosmas" required>
    </div>
    <div class="form-group col-sm-6">
        <label class="form-label" for="polres">Tipe Dasar Hukum</label>
        <div class="form-group">
            <input type="radio"
                   name="type"
                   id="type_ahu"
                   class="form-radio-label"
                   value="AHU">
            <label for="type">AHU Kemenkumham</label>
            <br>
            <input type="radio"
                   name="type"
                   id="type_skt"
                   class="form-radio-label"
                   value="SKT">
            <label for="type">SKT Kemendagri</label>
        </div>
    </div>
    <div class="form-group col-sm-6">
        <label for="dasar_hukum" class="form-label">Nomor Dasar Hukum</label>
        <input class="form-control" type="text" name="dasar_hukum" id="dasar_hukum" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="tanggal_dasar_hukum" class="form-label">Tanggal Dasar Hukum</label>
        <input class="form-control" type="date" name="tanggal_dasar_hukum" id="tanggal_dasar_hukum" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="akta_notaris" class="form-label">Akta Notaris</label>
        <input class="form-control" type="text" name="akta_notaris" id="akta_notaris" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="tanggal_akta_notaris" class="form-label">Tanggal Akta Notaris</label>
        <input class="form-control" type="date" name="tanggal_akta_notaris" id="tanggal_akta_notaris" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="npwp" class="form-label">NPWP</label>
        <input class="form-control" type="text" name="npwp" id="npwp" required>
    </div>
    <div class="form-group col-sm-6">
        <div class="row">
            <label class="form-label" for="provinsi">Provinsi</label>
            <select name="provinsi"
                    id="provinsi"
                    class="form-control"
                    required>
                <option value="">pilih provinsi</option>
            </select>
        </div>
    </div>
    <div class="form-group col-sm-6">
        <label class="form-label" for="kabupaten">Kota/Kabupaten</label>
        <select name="kabupaten"
                id="kabupaten"
                class="form-control"
                required>
            <option value="">pilih provinsi terlebih dahulu</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label class="form-label" for="kecamatan">Kecamatan</label>
        <select name="kecamatan"
                id="kecamatan"
                class="form-control"
                required>
            <option value="">pilih kota/kabupaten terlebih dahulu</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label class="form-label" for="desa">Desa</label>
        <select name="desa"
                id="desa"
                class="form-control"
                required>
            <option value="">pilih kecamatan terlebih dahulu</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label for="jalan" class="form-label">Detail Alamat</label>
        <input class="form-control" type="text" name="jalan" id="jalan" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="rw" class="form-label">RW</label>
        <input class="form-control" type="text" name="rw" id="rw" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="rt" class="form-label">RT</label>
        <input class="form-control" type="text" name="rt" id="rt" required>
    </div>
    <div class="form-group col-sm-12">
        <label class="form-label d-block mb-2" for="sumber_dana">Sumber Dana</label>
        <div class="row">
            <div class="col-md-12">
                @php $sumber_dana = \App\Models\Sislap\Lapsubjar\Binpolmas\DataOrsosmas::SUMBER_DANA; @endphp
                @foreach ($sumber_dana as $key => $value)
                    <input
                            type="checkbox"
                            name="sumber_dana"
                            id="sumber_dana_{{ $key }}"
                            value="{{ $value }}">
                    <label for="sumber_dana_{{ $key }}" class="form-check-label">{{ $value }}</label>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
    <div class="form-group col-sm-6">
        <label for="bidang_kegiatan" class="form-label">Bidang Kegiatan</label>
        <input class="form-control" type="text" name="bidang_kegiatan" id="bidang_kegiatan" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="jml_anggota" class="form-label">Jumlah Anggota</label>
        <input class="form-control" type="text" name="jml_anggota" id="jml_anggota" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="nama_ketua" class="form-label">Nama Ketua</label>
        <input class="form-control" type="text" name="nama_ketua" id="nama_ketua" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="no_hp_ketua" class="form-label">Nomor Handphone Ketua</label>
        <input class="form-control" type="text" name="no_hp_ketua" id="no_hp_ketua" required>
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
                        <td class="align-middle text-center">${ item.polda ?? '-' }</td>
                        <td class="align-middle text-center">${ item.polres ?? '-' }</td>
                        <td class="align-middle text-center">${ item.nama_orsosmas }</td>
                        <td class="align-middle text-center">${ item.type}, ${item.tanggal_dasar_hukum}</td>
                        <td class="align-middle text-center">${ item.akta_notaris}, ${item.tanggal_akta_notaris}</td>
                        <td class="align-middle text-center">${ item.npwp }</td>
                        <td class="align-middle text-center">${ item.rw }</td>
                        <td class="align-middle text-center">${ item.rt }</td>
                        <td class="align-middle text-center">${ item.desa }</td>
                        <td class="align-middle text-center">${ item.kecamatan }</td>
                        <td class="align-middle text-center">${ item.kabupaten }</td>
                        <td class="align-middle text-center">${ item.provinsi }</td>
                        <td class="align-middle text-center">${ item.jalan }</td>
                        <td class="align-middle text-center">${ item.sumber_dana }</td>
                        <td class="align-middle text-center">${ item.bidang_kegiatan }</td>
                        <td class="align-middle text-center">${ item.jml_anggota }</td>
                        <td class="align-middle text-center">${ item.nama_ketua }, ${item.no_hp_ketua}</td>
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
                                        onclick="insertValueToFormEdit('${ route('data-orsosmas.update', item.id) }', {
                                            polda               : '${item.polda}',
                                            polres              : '${item.polres}',
                                            nama_orsosmas       : '${item.nama_orsosmas}',
                                            type                : '${item.type}',
                                            dasar_hukum : '${item.dasar_hukum}',
                                            tanggal_dasar_hukum : '${item.tanggal_dasar_hukum}',
                                            akta_notaris        : '${item.akta_notaris}',
                                            tanggal_akta_notaris: '${item.tanggal_akta_notaris}',
                                            npwp                : '${item.npwp}',
                                            jalan               : '${item.jalan}',
                                            rw                  : '${item.rw}',
                                            rt               : '${item.rt}',
                                            desa            : '${item.desa}',
                                            kecamatan            : '${item.kecamatan}',
                                            kabupaten            : '${item.kabupaten}',
                                            provinsi            : '${item.provinsi}',
                                            desa_code            : '${item.desa_code}',
                                            kecamatan_code            : '${item.kecamatan_code}',
                                            kabupaten_code            : '${item.kabupaten_code}',
                                            provinsi_code            : '${item.provinsi_code}',
                                            sumber_dana            : '${item.sumber_dana}',
                                            bidang_kegiatan            : '${item.bidang_kegiatan}',
                                            jml_anggota            : '${item.jml_anggota}',
                                            nama_ketua            : '${item.nama_ketua}',
                                            no_hp_ketua            : '${item.no_hp_ketua}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('data-orsosmas.destroy', item.id) }" method="post" id="${ item.id }">
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
                    table += listRiwayatApproval(item.approvals, 21);
                }
                return table;
            }
            function insertValueToFormEditOrsosmas (r, fields) {
            const form = document.getElementById('form-edit')
            const btnReset = form.querySelector('button[type="reset"]')

            btnReset.dispatchEvent(new Event('click'))

            for (let item in fields) {
                let el = form.querySelector(`[name="${item}"]`)

                if (!el) continue

                if (el.type === 'checkbox') {
                    const checkboxes = form.querySelectorAll(`[name="${item}"]`)
                    const values = fields[item].split(', ')

                    checkboxes.forEach((checkbox) => { checkbox.checked = false })
                    checkboxes.forEach((checkbox) => {
                        if (values.includes(checkbox.value)) checkbox.checked = true
                    })
                } else if (el.type === 'radio') {
                    const radios = form.querySelectorAll(`[name="${item}"]`)

                    radios.forEach((radio) => { radio.checked = false })

                    if (fields[item]) {
                        const radio = form.querySelector(`[name="${item}"][value="${fields[item]}"]`)
                        if (radio) radio.checked = true
                    }
                } else if (el.tagName === 'SELECT') {
                    for (let opt of el.options) { opt.remove() }

                    let option = document.createElement('option')
                    option.value = fields[`${item}_code`]
                    option.text = fields[item]
                    option.id = fields[`${item}_code`]
                    el.appendChild(option)
                } else {
                    el.value = fields[item]
                }
            }

            fetchProvinsi(false, fields['provinsi_code'])
            fetchKabupaten(false, fields['kabupaten_code'])
            fetchKecamatan(false, fields['kecamatan_code'])
            fetchDesa(false, fields['desa_code'])

            form.setAttribute('action', r)
        }
        document.getElementById('form-edit').addEventListener('submit', function () {
            event.preventDefault()
            const form = this
            const formData = new FormData(form)
            const url = form.getAttribute('action')

            submitBtn = form.querySelector('button[type="submit"]')
            submitBtn.setAttribute('disabled', true)
            setTimeout(() => {
                submitBtn.removeAttribute('disabled')
            }, 5000);


            const sumber_dana = [...form.querySelectorAll('input[name="sumber_dana"]:checked')]
                .map((el) => el.value)
                .join(', ')

            formData.delete('sumber_dana')
            formData.append('sumber_dana', sumber_dana)

            axios.post(url, formData)
                .then((res) => {
                    if (res.data.status) {
                        listLaporan.fetchData()
                        $('#modalEdit').modal('hide')
                        form.reset()
                    }

                    swalSuccess(res.data.message)

                    listLaporan.fetchData()
                })
                .catch((error) => {
                    swalError(error.response.data.message)
                })
        })

        let provinsi  = $('#provinsi');
        let kabupaten = $('#kabupaten');
        let kecamatan = $('#kecamatan');
        let desa      = $('#desa');

        async function fetchProvinsi(clear = true, selected = null) {
            const res = await fetch(route('alamat-provinsi'))
            const data = await res.json()

            if (clear) {
                provinsi.empty()
                provinsi.append(`<option value="" selected disabled>pilih provinsi</option>`)
            }

            for (let id in data) {
                if (selected == id) continue
                else provinsi.append(`<option value="${data[id]}" id="${id}">${data[id]}</option>`)
            }
        }

        async function fetchKabupaten(clear = true, selected = null) {
            const res = await fetch(route('alamat-kota'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({ id: provinsi.val() })
            })
            const data = await res.json()

            if (clear) {
                kabupaten.empty()
                kabupaten.append(`<option value="" selected disabled>pilih kota/kabupaten</option>`)
            }

            for (let id in data) {
                if (selected == id) continue
                else kabupaten.append(`<option value="${data[id]}" id="${id}">${data[id]}</option>`)
            }
        }

        async function fetchKecamatan(clear = true, selected = null) {
            const res = await fetch(route('alamat-kecamatan'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({ id: kabupaten.val() })
            })
            const data = await res.json()

            if (clear) {
                kecamatan.empty()
                kecamatan.append(`<option value="" selected disabled>pilih kecamatan</option>`)
            }

            for (let id in data) {
                if (selected == id) continue
                else kecamatan.append(`<option value="${data[id]}" id="${id}">${data[id]}</option>`)
            }
        }

        async function fetchDesa(clear = true, selected = null) {
            const res = await fetch(route('alamat-desa'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({ id: kecamatan.val() })
            })
            const data = await res.json()

            if (clear) {
                desa.empty()
                desa.append(`<option value="" selected disabled>pilih kelurahan/desa</option>`)
            }

            for (let id in data) {
                if (selected == id) continue
                else desa.append(`<option value="${data[id]}" id="${id}">${data[id]}</option>`)
            }
        }

        provinsi.on('change', () => {
            setOptionAlamat(
                provinsi,
                route('alamat-kota'),
                kabupaten,
                'kota/kabupaten'
            )
            const provinsi_code = provinsi.find('option:selected').attr('id')
            document.querySelector('[name="provinsi_code"]').value = provinsi_code
        })

        kabupaten.on('change', () => {
            setOptionAlamat(
                kabupaten,
                route('alamat-kecamatan'),
                kecamatan,
                'kecamatan'
            )

            const kabupaten_code = kabupaten.find('option:selected').attr('id')
            document.querySelector('[name="kabupaten_code"]').value = kabupaten_code
        })

        kecamatan.on('change', () => {
            setOptionAlamat(
                kecamatan,
                route('alamat-desa'),
                desa,
                'kelurahan/desa'
            )

            const kecamatan_code = kecamatan.find('option:selected').attr('id')
            document.querySelector('[name="kecamatan_code"]').value = kecamatan_code
        })

        desa.on('change', () => {
            const desa_code = desa.find('option:selected').attr('id')
            document.querySelector('[name="desa_code"]').value = desa_code
        })
    </script>
@endsection
