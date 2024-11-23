@extends('templates.core.main')
@section('customcss')
@include('assets.css.select2')
<link rel="stylesheet" href="{{ asset('css/bhabin/index.css') }}">
@endsection
@section('mainComponent')
<main class=" my-sm-3 p-0 container bg-white">
    <h4 class="text-center py-3 py-sm-2 text-white bg-primary">Registrasi Akun Satpam</h4>
    <form action="{{ $isFromBujp ? route('transaksi-satpam.store-satpam') : route('register-satpam.store') }}"
          method="post" enctype="multipart/form-data" class="p-3">
        @csrf
        <div class="col-12 py-4 px-3 mt-3 mb-2 border border-danger">
            <div class="row">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email&nbsp;<sup class="text-danger">*digunakan untuk login</sup></label>
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="contoh: email@email.com"
                           value="{{ old('email') }}"
                           required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mt-3 mb-2 mt-md-0">
                    <label for="password" class="form-label">Password&nbsp;<sup class="text-danger">*digunakan untuk login</sup></label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <span
            class="d-flex p-3 my-2 justify-content-between border border-danger"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#cProfil"
            aria-expanded="false"
            aria-controls="cProfil"
            onclick="angleIcon(this)">
            <h5 class="mb-0">Profil Satpam</h5>
            <i class="fas fa-angle-down d-flex align-items-center"></i>
        </span>
        <div class="collapse row" id="cProfil">
            <div class="col-md-6 mt-3 mb-2">
                <label for="nama" class="form-label">Nama</label>
                <input type="text"
                       name="nama"
                       id="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       placeholder="masukkan nama lengkap"
                       value="{{ old('nama') }}"
                       required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label class="form-label">Jenis Kelamin</label>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input type="radio"
                               name="jenis_kelamin"
                               id="laki_laki"
                               class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                               value="laki-laki"
                               @if (old('jenis_kelamin') == 'laki-laki') checked @endif
                               required>
                        <label class="form-check-label" for="laki_laki">Laki - Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio"
                               name="jenis_kelamin"
                               id="perempuan"
                               class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                               value="perempuan"
                               @if (old('jenis_kelamin') == 'perempuan') checked @endif>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="no_ktp" class="form-label">No KTP</label>
                <input type="text"
                       name="no_ktp"
                       id="no_ktp"
                       class="form-control @error('no_ktp') is-invalid @enderror"
                       placeholder="contoh: 33201101XXXXXXXX"
                       pattern="^\d{16}$"
                       minlength="16"
                       maxlength="16"
                       value="{{ old('no_ktp') }}"
                       required>
                @error('no_ktp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text"
                       name="no_hp"
                       id="no_hp"
                       class="form-control @error('no_hp') is-invalid @enderror"
                       placeholder="contoh: 0815XXXXXXXX"
                       pattern="^(08|62|\+62)[0-9]{9,}$"
                       maxlength="16"
                       value="{{ old('no_hp') }}"
                       required>
                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="no_kta" class="form-label">No KTA Satpam</label>
                <input type="text"
                       name="no_kta"
                       id="no_kta"
                       class="form-control @error('no_kta') is-invalid @enderror"
                       placeholder="contoh: 001/KTASATPAM/II/2020/DITBINMAS"
                       value="{{ old('no_kta') }}"
                       {{-- pattern="^[0-9]{1,5}\/KTASATPAM\/[IVXLC]{0,4}\/[0-9]{4}\/[A-Z]*$" --}}
                       required>
                @error('no_kta')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="no_reg" class="form-label">No Registrasi Satpam</label>
                <input type="text"
                       name="no_reg"
                       id="no_reg"
                       class="form-control @error('no_reg') is-invalid @enderror"
                       placeholder="contoh: 01.21.053892"
                       value="{{ old('no_reg') }}"
                       {{-- pattern="^\d{1,3}\.\d{1,3}\.\d{4,8}$" --}}
                       required>
                @error('no_reg')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="tanggal_terbit_kta" class="form-label">Tanggal Terbit KTA</label>
                <input type="date"
                       name="tanggal_terbit_kta"
                       id="tanggal_terbit_kta"
                       class="form-control @error('tanggal_terbit_kta') is-invalid @enderror"
                       value="{{ old('tanggal_terbit_kta') }}"
                       required>
                @error('tanggal_terbit_kta')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="masa_berlaku_kta" class="form-label">Masa Berlaku KTA</label>
                <input type="date"
                       name="masa_berlaku_kta"
                       id="masa_berlaku_kta"
                       class="form-control @error('masa_berlaku_kta') is-invalid @enderror"
                       value="{{ old('masa_berlaku_kta') }}"
                       required>
                @error('masa_berlaku_kta')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text"
                       name="tempat_lahir"
                       id="tempat_lahir"
                       class="form-control @error('tempat_lahir') is-invalid @enderror"
                       placeholder="contoh: Surabaya, Jawa Timur"
                       value="{{ old('tempat_lahir') }}"
                       required>
                @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date"
                       name="tanggal_lahir"
                       id="tanggal_lahir"
                       class="form-control @error('tanggal_lahir') is-invalid @enderror"
                       value="{{ old('tanggal_lahir') }}"
                       required>
                @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="suku" class="form-label">Suku</label>
                <div>
                    <select name="suku"
                            id="suku"
                            class="form-select @error('suku') is-invalid @enderror"
                            onchange="lainnya(this, 'suku', 'suku')">
                        <option value="">-</option>
                        <option value="Jawa" @if (old('suku') == 'Jawa') selected @endif>Jawa</option>
                        <option value="Batak" @if (old('suku') == 'Batak') selected @endif>Batak</option>
                        <option value="Dayak" @if (old('suku') == 'Dayak') selected @endif>Dayak</option>
                        <option value="Asmat" @if (old('suku') == 'Asmat') selected @endif>Asmat</option>
                        <option value="Minahasa" @if (old('suku') == 'Minahasa') selected @endif>Minahasa</option>
                        <option value="Melayu" @if (old('suku') == 'Melayu') selected @endif>Melayu</option>
                        <option value="Sunda" @if (old('suku') == 'Sunda') selected @endif>Sunda</option>
                        <option value="Madura" @if (old('suku') == 'Madura') selected @endif>Madura</option>
                        <option value="Betawi" @if (old('suku') == 'Betawi') selected @endif>Betawi</option>
                        <option value="Bugis" @if (old('suku') == 'Bugis') selected @endif>Bugis</option>
                        <option value="lainnya">Lainnya</option>
                        @if (old('suku') != 'Jawa'
                            && old('suku') != 'Batak'
                            && old('suku') != 'Dayak'
                            && old('suku') != 'Asmat'
                            && old('suku') != 'Minahasa'
                            && old('suku') != 'Melayu'
                            && old('suku') != 'Sunda'
                            && old('suku') != 'Madura'
                            && old('suku') != 'Betawi'
                            && old('suku') != 'Bugis'
                            && old('suku') != 'lainnya')
                            <option value="{{ old('suku') }}" selected>{{ old('suku') }}</option>
                        @endif
                    </select>
                </div>
                @error('suku')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="agama" class="form-label">Agama</label>
                <div>
                    <select name="agama"
                            id="agama"
                            class="form-select @error('agama') is-invalid @enderror"
                            onchange="lainnya(this, 'agama')"
                            required>
                        <option value="">-</option>
                        <option value="Islam" @if (old('agama') == 'Islam') selected @endif>Islam</option>
                        <option value="Kristen" @if (old('agama') == 'Kristen') selected @endif>Kristen</option>
                        <option value="Hindu" @if (old('agama') == 'Hindu') selected @endif>Hindu</option>
                        <option value="Budha" @if (old('agama') == 'Budha') selected @endif>Budha</option>
                        <option value="Katholik" @if (old('agama') == 'Katholik') selected @endif>Katholik</option>
                        <option value="Konghucu" @if (old('agama') == 'Konghucu') selected @endif>Konghucu</option>
                        <option value="lainnya">Lainnya</option>
                        @if (old('agama') != 'Islam'
                            && old('agama') != 'Kristen'
                            && old('agama') != 'Hindu'
                            && old('agama') != 'Budha'
                            && old('agama') != 'Katholik'
                            && old('agama') != 'Konghucu'
                            && old('agama') != 'lainnya')
                            <option value="{{ old('agama') }}" selected>{{ old('agama') }}</option>
                        @endif
                    </select>
                </div>
                @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <span
            class="d-flex p-3 my-2 justify-content-between border border-danger"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#cAlamat"
            aria-expanded="false"
            aria-controls="cAlamat"
            onclick="angleIcon(this)">
            <h5 class="mb-0">Alamat Tinggal Satpam</h5>
            <i class="fas fa-angle-down d-flex align-items-center"></i>
        </span>
        <div class="collapse row" id="cAlamat">
            <div class="col-md-6 col-lg-3 mt-3 mb-2">
                <label class="form-label" for="provinsi">Provinsi</label>
                <select name="provinsi"
                        id="provinsi"
                        class="form-select @error('provinsi') is-invalid @enderror"
                        required>
                    <option>-</option>
                    @foreach($province as $id =>$name)
                        <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('provinsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 col-lg-3 mt-3 mb-2">
                <label class="form-label" for="kabupaten">Kota/Kabupaten</label>
                <select name="kabupaten"
                        id="kabupaten"
                        class="form-select @error('kabupaten') is-invalid @enderror"
                        required>
                    <option value="" selected>-</option>
                    @if (old('kabupaten'))
                        <option value="{{ old('kabupaten') }}" selected>{{ old('kabupaten') }}</option>
                    @endif
                </select>
                @error('kabupaten')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 col-lg-3 mt-3 mb-2">
                <label class="form-label" for="kecamatan">Kecamatan</label>
                <select name="kecamatan"
                        id="kecamatan"
                        class="form-select @error('kecamatan') is-invalid @enderror"
                        required>
                    <option value="" selected>-</option>
                    @if (old('kecamatan'))
                        <option value="{{ old('kecamatan') }}" selected>{{ old('kecamatan') }}</option>
                    @endif
                </select>
                @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 col-lg-3 mt-3 mb-2">
                <label class="form-label" for="desa">Kelurahan/Desa</label>
                <select name="desa"
                        id="desa"
                        class="form-select @error('desa') is-invalid @enderror"
                        required>
                    <option value="" selected>-</option>
                    @if (old('desa'))
                        <option value="{{ old('desa') }}" selected>{{ old('desa') }}</option>
                    @endif
                </select>
                @error('desa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="detail_alamat" class="form-label">Detail Alamat</label>
                <input type="text"
                       name="detail_alamat"
                       id="detail_alamat"
                       class="form-control @error('detail_alamat') is-invalid @enderror"
                       placeholder="nama jalan, nama perumahan, dll"
                       value="{{ old('detail_alamat') }}"
                       required>
                @error('detail_alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-6 col-md-3 col-6 mt-3 mb-2">
                <label for="rt" class="form-label">RT</label>
                <input type="text"
                       name="rt"
                       id="rt"
                       class="form-control @error('rt') is-invalid @enderror"
                       placeholder="contoh: 004"
                       maxlength="3"
                       value="{{ old('rt') }}"
                       required>
                @error('rt')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-6 col-md-3 col-6 mt-3 mb-2">
                <label for="rw" class="form-label">RW</label>
                <input type="text"
                       name="rw"
                       id="rw"
                       class="form-control @error('rw') is-invalid @enderror"
                       placeholder="contoh: 004"
                       maxlength="3"
                       value="{{ old('rw') }}"
                       required>
                @error('rw')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <span
            class="d-flex p-3 my-2 justify-content-between border border-danger"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#cInfoTambahan"
            aria-expanded="false"
            aria-controls="cInfoTambahan"
            onclick="angleIcon(this)">
            <h5 class="mb-0">Informasi Tambahan</h5>
            <i class="fas fa-angle-down d-flex align-items-center"></i>
        </span>
        <div class="collapse row" id="cInfoTambahan">
            <div class="col-md-6 mt-3 mb-2">
                <label for="jenis_satpam" class="form-label">Jenis Satpam</label>
                <select name="jenis_satpam"
                        id="jenis_satpam"
                        class="form-select @error('jenis_satpam') is-invalid @enderror"
                        onchange="typeSatpam(this)"
                        required>
                    <option value="">-</option>
                    <option value="organik" @if(old('jenis_satpam') == 'organik') selected @endif>Organik</option>
                    <option value="outsourching" @if(old('jenis_satpam') == 'outsourching') selected @endif>Outsourching</option>
                </select>
                @error('jenis_satpam')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2 jenis_badan_usaha_container">
                <label for="bujp_id" class="form-label label-outsourching d-none">BUJP</label>
                <select name="bujp_id"
                        id="bujp_id"
                        class="form-select select-outsourching d-none @error('bujp_id') is-invalid @enderror">
                    <option></option>
                </select>
                @error('bujp_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 mt-3 mb-2">
                <label for="tempat_tugas" class="form-label">Tempat Tugas</label>
                <input type="text"
                       name="tempat_tugas"
                       id="tempat_tugas"
                       class="form-control @error('tempat_tugas') is-invalid @enderror"
                       placeholder="contoh: Gedung Bidakara, Jl. Gatot Subroto No. 71-73, Jakarta Selatan"
                       value="{{ old('tempat_tugas') }}"
                       required>
                @error('tempat_tugas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label for="jenjang_pelatihan" class="form-label">Jenjang Pelatihan Satpam</label>
                <select name="jenjang_pelatihan"
                        id="jenjang_pelatihan"
                        class="form-select @error('jenjang_pelatihan') is-invalid @enderror">
                    <option value="gada pratama" @if(old('jenjang_pelatihan') == 'gada pratama') selected @endif>Gada Pratama</option>
                    <option value="gada madya" @if(old('jenjang_pelatihan') == 'gada madya') selected @endif>Gada Madya</option>
                    <option value="gada utama" @if(old('jenjang_pelatihan') == 'gada utama') selected @endif>Gada Utama</option>
                </select>
                @error('jenjang_pelatihan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mt-3 mb-2">
                <label class="form-label">Foto Profil Satpam</label>
                <input type="file"
                       name="foto_kta"
                       id="foto_kta"
                       class="form-control @error('foto_kta') is-invalid @enderror"
                       accept="image/jpg,image/png"
                       required>
                @error('foto_kta')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div
            class="d-flex flex-column flex-sm-row mt-3"
            style="row-gap: 0.6rem; column-gap: 1rem">
            <div
                id="chaptcha-img"
                class="d-flex justify-content-center justify-content-sm-start align-items-center"
                style="column-gap: 1rem">
                <img
                    src=""
                    alt="chaptcha image"
                    width="150px"
                    height="50px"
                    class="mb-0"
                    style="border: 1px solid #1E4588">
                <a
                    href="javascript:void(0)"
                    onclick="refreshCaptcha()"
                    class="btn btn-sm btn-primary"
                    title="Refresh Captcha">
                    <i class="fas fa-sync"></i>
                </a>
            </div>
            <input
                type="text"
                name="captcha"
                id="captcha"
                class="form-control form-group"
                placeholder="Masukkan angka yang muncul, di sini"
                autocomplete="off"
                required>
        </div>
        <div class="mt-4 form-group d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-danger mx-2"
                onclick="window.history.back()">Batal</button>
            <button
                type="submit"
                class="btn btn-primary">Simpan</button>
        </div>
    </form>
</main>
@endsection
@section('customjs')
@include('assets.js.select2')
<script src="{{ asset('js/bhabin/laporan/dds/dds-form.js') }}"></script>
<script>
    const initSelectBujp = () => {
        buildSelect2Search({
            placeholder: '-- Pilih BUJP --',
            url: route('bujp.select2'),
            minimumInputLength: 3,
            selector: [{ id: $('#bujp_id') }],
            query: function (params) {
                return {
                    nama_badan_usaha: params.term,
                }
            }
        });
    }

    const destroySelectBujp = () => $('#bujp_id').select2('destroy');

    const typeSatpam = (el) => {
        const container = document.querySelector('.jenis_badan_usaha_container')
        if ( el.value === "organik") {
            destroySelectBujp();
            container.querySelector('.label-outsourching').classList.add('d-none')
            container.querySelector('.select-outsourching').classList.add('d-none')
        } else {
            container.querySelector('.label-outsourching').classList.remove('d-none')
            container.querySelector('.select-outsourching').classList.remove('d-none')
            initSelectBujp();
        }
    }

    const provinsi = $('#provinsi')
    const kabupaten = $('#kabupaten')
    const kecamatan = $('#kecamatan')
    const desa = $('#desa')

    provinsi.on('change', () => {
        setOptionAlamat(provinsi, route('alamat-kota'), kabupaten, 'kota/kabupaten')
    })

    kabupaten.on('change', () => {
        setOptionAlamat(kabupaten, route('alamat-kecamatan'), kecamatan, 'kecamatan')
    })

    kecamatan.on('change', () => {
        setOptionAlamat(kecamatan, route('alamat-desa'), desa, 'kelurahan/desa')
    })

    async function getCaptcha() {
        try {
            const response = await fetch(route('captcha'))
            const blob = await response.blob()

            hideFormLoader()

            const url = URL.createObjectURL(blob)

            const captchaImage = document.querySelector('#chaptcha-img img')
            captchaImage.src = url
        } catch (error) {
            console.log(error)
        }
    }
    getCaptcha()

    function refreshCaptcha() {
        getCaptcha()

        const captchaInput = document.querySelector('#captcha')
        captchaInput.value = ''
    }
</script>
@endsection
