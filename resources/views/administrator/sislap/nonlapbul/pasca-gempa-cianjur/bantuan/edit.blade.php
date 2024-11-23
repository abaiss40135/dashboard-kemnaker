@extends('templates.admin-lte.admin', ['title' => 'Kegiatan Penanganan Pasca Gempa Cianjur'])
@section('customcss')
    @include('assets.css.select2')
    @include('assets.css.datetimepicker')
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <h3 class="card-title">EDIT LAPORAN KEGIATAN BANTUAN PASCA BENCANA CIANJUR</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('bantuan-pasca-gempa-cianjur.update', $laporan->id) }}" method="POST"
                  id="form-bantuan-pasca-gempa" onclick="disableSubmitButtonTemporarily()">
                @method('PATCH')
                @csrf
                <input type="hidden" name="jenis_kegiatan_text" value="{{ $laporan->jenis_kegiatan->nama }}">
                <input type="hidden" name="tanggal" id="waktu-kegiatan" value="{{ $laporan->tanggal }}">
                <div class="form-group">
                    <label for="select-petugas">Nama Petugas</label>
                    <select type="text" class="form-control select2" id="select-petugas" name="personel_id">
                        <option></option>
                        <option value="{{ $laporan->personel_id }}" selected>{{ "{$laporan->personel->pangkat} {$laporan->personel->nama}" }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan Petugas</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan"
                           value="{{ $laporan->personel->jabatan }}" readonly>
                </div>
                <div class="form-group">
                    <label for="kesatuan">Kesatuan Petugas</label>
                    <input type="text" class="form-control" id="kesatuan" name="kesatuan" placeholder="Satuan tugas" value="{{ $laporan->personel->polres }}"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="kesatuan">Lokasi Kegiatan</label>
                    <div class="form-row">
                        <div class="col-4">
                            <input type="text" name="lokasi" id="lokasi" class="form-control text-uppercase"
                                   placeholder="contoh: Balai Desa, Pengungsian" value="{{ $laporan->lokasi_kegiatan }}">
                        </div>
                        <div class="col-8">
                            <select class="form-control form-select select2" id="select-lokasi" name="district_code">
                                <option></option>
                                <option value="{{ $laporan->district_code }}" selected>{{ $laporan->kecamatan->long_location_name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tanggal">Waktu Kegiatan</label>
                    <input type="text" class="form-control" id="tanggal" placeholder="Waktu Kegiatan" value="{{ $laporan->tanggal }}">
                </div>
                <div class="form-group">
                    <label for="select-jenis-kegiatan">Jenis Kegiatan</label>
                    <select class="form-control form-select text-uppercase select2" id="select-jenis-kegiatan"
                            name="jenis_kegiatan">
                        <option></option>
                        <option value="{{ $laporan->jenis_kegiatan->slug }}" selected>{{ $laporan->jenis_kegiatan->nama }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="uraian_kegiatan">Uraian Kegiatan</label>
                    <textarea id="uraian_kegiatan" name="uraian_kegiatan"
                              class="form-control text-uppercase">{{ $laporan->uraian_kegiatan }}</textarea>
                </div>
                <div class="flex-row d-flex justify-content-end">
                    <button type="submit" class="btn btn-success" id="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.select2')
    @include('assets.js.datetimepicker')
    <script>
        const initSelectPetugas = (el) => {
            buildSelect2Search({
                placeholder: '-- Cari NRP atau Nama Petugas --',
                url: route('personel.select2'),
                minimumInputLength: 0,
                selector: [{id: $(el)}],
                query: function (params) {
                    return {
                        q: params.term,
                        withPangkat: true
                    }
                }
            });

        }

        const initSelectJenisKegiatan = (el) => {
            buildSelect2Search({
                placeholder: '-- Pilih Jenis Kegiatan --',
                url: route('nonlapbul.jenis-kegiatan.select2'),
                minimumInputLength: 0,
                selector: [{id: $(el)}],
                tags: true,
                createTag: (params) => {
                    let term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    //axios post to create new tag
                    axios.post(route('jenis-kegiatan.store'), {
                        nama: term.toUpperCase(),
                        slug: slugify(term),
                        jenis_laporan: "PENANGANAN"
                    }).then(res => res.data);

                    return {
                        id: slugify(term),
                        text: term.toUpperCase(),
                        newTag: true // add additional parameters
                    }
                },
                query: function (params) {
                    return {
                        q: params.term,
                        jenis_laporan: 'PENANGANAN'
                    }
                }
            });
        }

        const initSelectLokasi = (el) => {
            buildSelect2Search({
                placeholder: '-- Cari Kecamatan/Kabupaten --',
                url: route('lokasi.select2'),
                selector: [{id: $(el)}],
                query: function (params) {
                    return {
                        q: params.term
                    }
                }
            });
        }

        const initDateTimePicker = (el, format) => {
            $(el).daterangepicker(Object.assign(datetimeSetup, {
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2022,
                maxYear: parseInt(moment().format('YYYY'), 10),
                locale: {
                    format: format
                },
                startDate: moment("{{ $laporan->tanggal }}").format(format)
            }), function (start, end, label) {
                $('#waktu-kegiatan').val(start.format('YYYY-MM-DD'));
            });
        }

        window.addEventListener("DOMContentLoaded", ignite);

        function ignite(){
            initSelectPetugas('#select-petugas');
            initSelectJenisKegiatan('#select-jenis-kegiatan');
            initSelectLokasi('#select-lokasi');
            initDateTimePicker('#tanggal', 'dddd, DD-MM-YYYY');

            $('#select-jenis-kegiatan').on('select2:select', function (e) {
                const data = e.params.data;
                $(this).closest('.card-body').find('[name="jenis_kegiatan_text"]').val(data.text);
            });
        }

    </script>
@endsection
