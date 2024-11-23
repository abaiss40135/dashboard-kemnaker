@extends('templates.core.main')
@section('customcss')
    @include('assets.css.select2')
    <link rel="stylesheet" href="{{ asset('css/bhabin/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bhabin/laporan/dds/dds-form.css') }}">
    <style>
        form {
            padding-inline: 0.5rem !important
        }
        .form-group {
            margin-top: 1.25rem
        }
    </style>
@endsection
@section('mainComponent')
    <main class="my-sm-3 p-0 container bg-white">
        <h4 class="text-center py-3 py-sm-2 text-white bg-dark">Form Laporan Masyarakat</h4>
        <div class="px-3" style="min-height: 60vh">
            <form action="{{ route('laporan-publik.store') }}" method="post">
                @csrf
                <input type="hidden" name="province_code">
                <input type="hidden" name="city_code">
                <input type="hidden" name="district_code">
                <input type="hidden" name="village_code">
                <span
                    class="d-flex justify-content-between align-items-center bg-primary text-white p-3 fw-bold mb-4"
                    data-bs-target="#collapse1"
                    aria-controls="collapse1"
                    data-bs-toggle="collapse"
                    aria-expanded="false"
                    type="button"
                    onclick="angleIcon(this)">
                    Waktu dan Lokasi Mendapatkan Informasi
                    <i class="fas fa-angle-right d-flex"></i>
                </span>
                <div id="collapse1" class="collapse mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="provinsi" class="form-label fw-bold">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-select">
                                <option value="">-- pilih provinsi --</option>
                                @if (old('provinsi'))
                                <option value="{{ old('provinsi') }}" selected>{{ old('provinsi') }}</option>
                                @endif
                                @foreach($provinces as $id => $name)
                                <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('provinsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="kabupaten" class="form-label fw-bold">Kota/Kabupaten</label>
                            <select name="kabupaten" id="kabupaten" class="form-select">
                                <option value="">-- pilih kota/kabupaten --</option>
                                @if (old('kabupaten'))
                                    <option value="{{ old('kabupaten') }}" selected>{{ old('kabupaten') }}</option>
                                @endif
                            </select>
                            @error('kabupaten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label fw-bold">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-select">
                                <option value="" selected>-- pilih kecamatan --</option>
                                @if (old('kecamatan'))
                                    <option value="{{ old('kecamatan') }}" selected>{{ old('kecamatan') }}</option>
                                @endif
                            </select>
                            @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="desa" class="form-label fw-bold">Kelurahan/Desa</label>
                            <select name="desa" id="desa" class="form-select">
                                <option value="" selected>-- pilih kelurahan/desa --</option>
                                @if (old('desa'))
                                    <option value="{{ old('desa') }}" selected>{{ old('desa') }}</option>
                                @endif
                            </select>
                            @error('desa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <br>
                        </div>
                        <div class="col-6 col-md-3">
                            <label for="rt" class="form-label fw-bold">RT</label>
                            <input
                                type="number"
                                id="rt"
                                name="rt"
                                class="form-control"
                                placeholder="masukkan RT"
                                value="{{ old('rt') ?? '-'}}"
                                maxlength="3">
                            @error('rt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <br>
                        </div>
                        <div class="col-6 col-md-3">
                            <label for="rw" class="form-label fw-bold">RW</label>
                            <input
                                type="number"
                                name="rw"
                                id="rw"
                                class="form-control"
                                placeholder="masukkan RW"
                                value="{{ old('rw') ?? '-' }}"
                                maxlength="3">
                            @error('rw')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-bold">Tanggal Mendapatkan Informasi</label>
                            <input
                                type="date"
                                name="tanggal"
                                id="tanggal"
                                class="form-control @error('tanggal') is-invalid @enderror"
                                value="{{ old('tanggal') }}"
                                required>
                            @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <span
                    class="d-flex justify-content-between align-items-center bg-primary text-white fw-bold p-3"
                    data-bs-target="#collapse2"
                    aria-controls="collapse2"
                    data-bs-toggle="collapse"
                    aria-expanded="false"
                    type="button"
                    onclick="angleIcon(this)">
                    Detail Informasi
                    <i class="fas fa-angle-right d-flex"></i>
                </span>
                <div id="collapse2" class="collapse mb-4">
                     <div class="form-group">
                        <label class="form-label">Bidang Informasi</label><br>
                        <div
                            class="d-flex justify-content-between mb-3 mt-2"
                            style="max-width: 800px">
                            <div>
                                <input
                                    type="radio"
                                    name="laporan_informasi[bidang]"
                                    class="form-check-input"
                                    value="politik"
                                    {{ old('laporan_informasi.bidang') == 'politik' ? 'checked' : '' }}
                                    required
                                >
                                <label
                                    for="politik"
                                    class="form-check-label"
                                    style="margin-left: 10px"
                                >Politik</label>
                            </div>
                            <div>
                                <input
                                    type="radio"
                                    name="laporan_informasi[bidang]"
                                    class="form-check-input"
                                    value="ekonomi"
                                    {{ old('laporan_informasi.bidang') == 'ekonomi' ? 'checked' : ''  }}
                                    style="margin-left: 10px"
                                >
                                <label
                                    for="ekonomi"
                                    class="form-check-label"
                                    style="margin-left: 10px"
                                >Ekonomi</label>
                            </div>
                            <div>
                                <input
                                    type="radio"
                                    name="laporan_informasi[bidang]"
                                    class="form-check-input"
                                    value="sosbud"
                                    {{ old('laporan_informasi.bidang') == 'sosbud' ? 'checked' : ''  }}
                                    style="margin-left: 10px"
                                >
                                <label
                                    for="sosbud"
                                    class="form-check-label"
                                    style="margin-left: 10px"
                                >Sosbud</label>
                            </div>
                            <div>
                                <input
                                    type="radio"
                                    name="laporan_informasi[bidang]"
                                    class="form-check-input"
                                    value="keamanan"
                                    {{ old('laporan_informasi.bidang') == 'keamanan' ? 'checked' : ''  }}
                                    style="margin-left: 10px">
                                <label
                                    for="keamanan"
                                    class="form-check-label"
                                    style="margin-left: 10px"
                                >Keamanan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            for="uraian"
                            class="form-label fw-bold">Uraian Laporan Masyarakat</label>
                        <button
                            type="button"
                            class="btn btn-default btn-sm px-0 mx-0"
                            data-bs-toggle="modal"
                            data-bs-target="#uraianHelper"
                            style="width: fit-content"
                        >
                            <i class="far fa-question-circle text-secondary h5"></i>
                        </button>
                        <textarea
                            name="laporan_informasi[uraian]"
                            required
                            class="form-control"
                            placeholder="masukkan laporan Masyarakat"
                            id="uraian"
                            cols="30"
                            rows="10"
                            onclick="uraianInformasi.step()"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold" for="keyword">Keyword</label>
                        <button
                            type="button"
                            class="btn btn-default btn-sm px-0 mx-0"
                            data-bs-toggle="modal"
                            data-bs-target="#keywordHelper"
                            style="width: fit-content"
                        >
                            <i class="far fa-question-circle text-secondary h5"></i>
                        </button>
                        <select
                            required
                            multiple
                            type="text"
                            id="keyword"
                            name="laporan_informasi[keyword][]"
                            class="form-control"
                        ></select>
                    </div>
                </div>

                <div class="button mt-4 d-flex justify-content-between justify-content-md-end">
                    <a
                        href="{{ route('laporan-publik.index') }}"
                        class="btn btn-danger"
                    >Batal</a>
                    <button style="background: #A0B8E0; color: #1E4588">Simpan</button>
                </div>
            </form>
        </div>
    </main>

    @include('components.pop-up.question-uraian')
    @include('components.pop-up.uraian')
    @include('components.pop-up.keyword')
@endsection

@section('customjs')
@include('assets.js.select2')
    <script>
        document.addEventListener('change', function (event) {
            if (event.target && event.target.matches("input[name='laporan_informasi[bidang]']:checked")) {
                $('#keyword').val('');
                if (event.target.value === 'politik') {
                    document.querySelector('#keyword').innerHTML = `
                        <option value="Kader Parpol Provokatif"> Kader Parpol Provokatif</option>
                        <option value="Isu Agama dalam Berpolitik"> Isu Agama dalam Berpolitik</option>
                        <option value="Tim Sukses yang Transaksional"> Tim Sukses yang Transaksional</option>
                        <option value="Isu Proses Pemilihan Memihak"> Isu Proses Pemilihan Memihak</option>
                        <option value="Kelompok Masyarakat Fanatik Parpol"> Kelompok Masyarakat Fanatik Parpol</option>
                        <option value="Politik Praktis Aparat Pemerintah"> Politik Praktis Aparat Pemerintah</option>
                        <option value="Perbedaan Pandangan Politik Memicu Konflik"> Perbedaan Pandangan Politik Memicu Konflik</option>
                        <option value="Kelompok Masyarakat Afiliasi Partai Oposisi"> Kelompok Masyarakat Afiliasi Partai Oposisi</option>
                        <option value="Penolakan Partai Koalisi"> Penolakan Partai Koalisi</option>`
                }
                if (event.target.value === 'ekonomi') {
                    document.querySelector('#keyword').innerHTML = `
                        <option value="Minyak Goreng Tidak Tersedia">Minyak Goreng Tidak Tersedia</option>
                        <option value="Harga Minyak Goreng Tidak Sesuai">Harga Minyak Goreng Tidak Sesuai</option>
                        <option value="Warga Terkena PHK">Warga Terkena PHK</option>
                        <option value="Warga Berpenghasilan Rendah">Warga Berpenghasilan Rendah</option>
                        <option value="Kesenjangan Sosial di Masyarakat">Kesenjangan Sosial di Masyarakat</option>
                        <option value="Harga Kebutuhan Pokok Tinggi">Harga Kebutuhan Pokok Tinggi</option>
                        <option value="Pertumbuhan Ekonomi Tidak Merata">Pertumbuhan Ekonomi Tidak Merata</option>
                        <option value="Tingkat Pengangguran Tinggi">Tingkat Pengangguran Tinggi</option>
                        <option value="Sulit Mendapatkan Bantuan Usaha">Sulit Mendapatkan Bantuan Usaha</option>
                        <option value="Perizinan Usaha Sulit">Perizinan Usaha Sulit</option>
                        <option value="Meningkatnya Kebutuhan Ekonomi">Meningkatnya Kebutuhan Ekonomi</option>`
                }
                if (event.target.value === 'sosbud') {
                    document.querySelector('#keyword').innerHTML = `
                        <option value="Kegiatan Adat yang Bertentangan dengan KUHP">Kegiatan Adat yang Bertentangan dengan KUHP</option>
                        <option value="Kebiasaan Adat yang Melanggar Hukum">Kebiasaan Adat yang Melanggar Hukum</option>
                        <option value="Akulturasi Budaya Barat">Akulturasi Budaya Barat</option>
                        <option value="Penyebaran Budaya Melalui Medsos">Penyebaran Budaya Melalui Medsos</option>
                        <option value="Sukuisme Fanatik">Sukuisme Fanatik</option>
                        <option value="Pernikahan Usia Muda">Pernikahan Usia Muda</option>
                        <option value="Lingkungan Sosial Kurang Tertib">Lingkungan Sosial Kurang Tertib</option>
                        <option value="Kebiasaan Kumpul Pengangguran">Kebiasaan Kumpul Pengangguran</option>
                        <option value="Warga Putus Sekolah Terlantar">Warga Putus Sekolah Terlantar</option>
                        <option value="Anak Keluarga Broken Home">Anak Keluarga Broken Home</option>
                        <option value="Kebiasaan Hedonisme/Konsumtif">Kebiasaan Hedonisme/Konsumtif</option>
                        <option value="Warga Depresi">Warga Depresi</option>
                        <option value="Residivis di Lingkungan Sekitar">Residivis di Lingkungan Sekitar</option>
                        <option value="Interaksi antara Residivis dan Kelompok Pemuda">Interaksi antara Residivis dan Kelompok Pemuda</option>
                        <option value="Penolakan Kegiatan Anak Muda Pengangguran">Penolakan Kegiatan Anak Muda Pengangguran</option>`
                }

                $('#keyword').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'pilih keyword, atau input manual keyword yang sesuai',
                    width: 'auto',
                    tags: true,
                    minimumInputLength: 0,
                });
            }
        });

        const provinsi = $('#provinsi')
        const kabupaten = $('#kabupaten')
        const kecamatan = $('#kecamatan')
        const desa = $('#desa')

        provinsi.on('change', (e) => {
            const target = e.target
            const targetId = target.options[target.selectedIndex].id
            document.querySelector('input[name="province_code"]').value = targetId

            setOptionAlamat(provinsi, route('alamat-kota'), kabupaten, 'kota/kabupaten')
        })

        kabupaten.on('change', (e) => {
            const target = e.target
            const targetId = target.options[target.selectedIndex].id
            document.querySelector('input[name="city_code"]').value = targetId

            setOptionAlamat(kabupaten, route('alamat-kecamatan'), kecamatan, 'kecamatan')
        })

        kecamatan.on('change', (e) => {
            const target = e.target
            const targetId = target.options[target.selectedIndex].id
            document.querySelector('input[name="district_code"]').value = targetId

            setOptionAlamat(kecamatan, route('alamat-desa'), desa, 'kelurahan/desa')
        })

        desa.on('change', (e) => {
            const target = e.target
            const targetId = target.options[target.selectedIndex].id
            document.querySelector('input[name="village_code"]').value = targetId
        })
    </script>
@endsection
