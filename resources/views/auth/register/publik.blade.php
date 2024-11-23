@extends('templates.core.main')
@section('customcss')
<link rel="stylesheet" href="{{ asset('css/bhabin/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/bhabin/laporan/dds/dds-form.css') }}">
@endsection
@section('mainComponent')
<main class="mb-3 mt-2">
    <div class="container mt-2 mt-md-5">
        <div
            class="header p-2 text-white rounded"
            style="background-color: #1E4588">
            <h5 class="m-0">Registrasi Akun Publik</h5>
        </div>
        <form
            action="{{ route('register-publik.store' ) }}"
            method="post">
            @csrf
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label
                        for="name"
                        class="form-label">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="masukan nama anda"
                        value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label
                        for="email"
                        class="form-label">Email
                        <sup class="text-danger">*digunakan untuk login</sup>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="masukan email"
                        value="{{old('email')}}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mt-3">
                    <label
                        for="type"
                        class="form-label @error('type') is-invalid @enderror">Jenis</label>
                    <select
                        name="type"
                        id="type"
                        class="form-select">
                        <option selected disabled>-- Pilih Jenis Pengguna --</option>
                        <option
                            value="publik"
                            @if (old('type') == 'publik') selected @endif>Publik</option>
                        <option
                            value="pokdar_kamtibmas"
                            @if (old('type') == 'pokdar_kamtibmas') selected @endif>Pokdar Kamtibmas</option>
                        <option
                            value="polisi_khusus"
                            @if (old('type') == 'polisi_khusus') selected @endif>Polisi Khusus</option>
                        <option
                            value="senkom_mitra_polri"
                            @if (old('type') == 'senkom_mitra_polri') selected @endif>Senkom Mitra Polri</option>
                        <option
                            value="apdesi"
                            @if (old('type') == 'apdesi') selected @endif>APDESI</option>
                    </select>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label
                        for="password"
                        class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder="masukan password"
                        minlength="8"
                        value="{{old('password')}}">
                    <div class="form-text">Password minimal 8 karakter.</div>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label
                        for="password_confirm"
                        class="form-label">Konfirmasi Password</label>
                    <input
                        type="password"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        id="password_confirm"
                        name="password_confirmation"
                        minlength="8"
                        placeholder="Konfirmasi Password">
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mt-3">
                    <label
                        for="alamat"
                        class="form-label">Alamat Tinggal</label>
                    <textarea
                        name="alamat" type=text
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Dsn. Kaliwungu RT.01 RW.03, Kelurahan Kaliwungu, Kecamatan Kaliwungu, Kabupaten Semarang, Provinsi Jawa Tengah"
                        id="alamat"
                        rows="2">{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label
                        for="pekerjaan"
                        class="form-label">Pekerjaan</label>
                    <input
                        type="text"
                        class="form-control @error('pekerjaan') is-invalid @enderror"
                        placeholder="Contoh: Karyawan Swasta"
                        name="pekerjaan"
                        id="pekerjaan"
                        value="{{old('pekerjaan')}}">
                    @error('pekerjaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label
                        for="lokasi_bekerja"
                        class="form-label">Lokasi Bekerja</label>
                    <input
                        type="text"
                        class="form-control @error('lokasi_bekerja') is-invalid @enderror"
                        id="lokasi_bekerja"
                        name="lokasi_bekerja"
                        value="{{ old('lokasi_bekerja') }}"
                        placeholder="Contoh: Nama Perusahaan, Nama Lembaga Pendidikan, dll">
                    @error('lokasi_bekerja')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                <div class="mt-4 d-flex justify-content-between justify-content-md-end">
                    <button
                        style="background: #F92B13; color: #fff;"
                        onclick="window.history.back()"
                        type="reset">Batal</button>
                    <button
                        style="background: #A0B8E0; color: #1E4588;"
                        type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
@section('customjs')
<script src="{{ asset('js/bhabin/laporan/dds/dds-form.js') }}"></script>
<script>
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
