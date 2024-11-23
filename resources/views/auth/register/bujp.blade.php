@extends('templates.core.main')
@section('customcss')
<link rel="stylesheet" href="{{ asset('css/bhabin/laporan/dds/dds-form.css') }}">
<style>
    form {
        padding-inline: 0.5rem !important
    }
    .form-group {
        margin-top: 1.25rem
    }
    input[type=password] {
        padding: 0.375rem 0.75rem;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }
</style>
@endsection
@section('mainComponent')
<main class="my-sm-3 p-0 container bg-white">
    <h4
        class="text-center py-3 py-sm-2 text-white"
        style="background-color: #1E4588">Registrasi Akun BUJP</h4>
    <h4 class="text-center mt-5"><b>Profil Badan Usaha</b></h4>
    <div class="form-group px-3">
        <form
            action="#"
            method="get"
            id="form-search-nib">
            <label for="search-nib" class="form-label">NIB</label>
            <div class="input-group">
                <input
                    name="search-nib"
                    maxlength="13"
                    class="form-control"
                    id="search-nib"
                    placeholder="Nomor Induk Berusaha"
                    value="@if (session('nib')){{ session('nib') }}@endif">
                <button
                    type="submit"
                    class="input-group-text btn-primary"
                    style="width: fit-content"
                    id="btn-search-nib">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
    <form
        action="{{ route('register-bujp.store') }}"
        method="post"
        enctype="multipart/form-data"
        class="row mx-1"
        id="form-bujp">
        @csrf
        <div class="form-group col-md-6">
            <label for="nama_bujp" class="form-label">Nama Badan Usaha</label>
            <input
                type="text"
                class="form-control"
                id="nama_bujp"
                name="nama_badan_usaha"
                readonly>
        </div>
        <input
            type="text"
            class="form-control d-none"
            name="nib"
            required
            readonly>
        <div class="form-group col-md-6">
            <label for="tipe_bujp" class="form-label">Tipe Badan Usaha</label>
            <input
                type="text"
                name="tipe_badan_usaha"
                id="tipe_bujp"
                class="form-control"
                readonly>
        </div>
        <div class="form-group">
            <label for="detail_alamat" class="form-label">Detail Alamat</label>
            <textarea
                name="detail_alamat"
                id="detail_alamat"
                rows="3"
                class="form-control"
                readonly></textarea>
        </div>
        <div class="mx-auto px-1 row">
            <div class="form-group col-md-6 col-lg-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input
                    type="text"
                    name="provinsi"
                    id="provinsi"
                    class="form-control"
                    readonly>
            </div>
            <div class="form-group col-md-6 col-lg-3">
                <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                <input
                    type="text"
                    name="kabupaten"
                    id="kota"
                    class="form-control"
                    readonly>
            </div>
            <div class="form-group col-md-6 col-lg-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input
                    type="text"
                    name="kecamatan"
                    id="kecamatan"
                    class="form-control"
                    readonly>
            </div>
            <div
                class="form-group col-md-6 col-lg-3">
                <label for="desa" class="form-label">Kelurahan/Desa</label>
                <input
                    type="text"
                    name="desa"
                    id="desa"
                    class="form-control"
                    readonly>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="kode_pos_bujp" class="form-label">Kode Pos</label>
            <input
                type="text"
                name="kode_pos"
                id="kode_pos_bujp"
                class="form-control"
                readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="no_tel_bujp" class="form-label">Nomor Telepon</label>
            <input
                type="tel"
                id="no_tel_bujp"
                class="form-control"
                name="nomor_telepon"
                maxlength="15"
                readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="npwp_bujp" class="form-label">No. NPWP</label>
            <input
                type="text"
                id="npwp_bujp"
                class="form-control"
                name="npwp_badan_usaha"
                maxlength="20"
                readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="website" class="form-label">Website</label>
            <input
                type="text"
                id="website"
                placeholder="https://namasitus.com"
                class="form-control"
                name="website_badan_usaha">
        </div>
        <div class="col-12 pb-4 mt-4 bg-danger">
            <div class="row">
                <div class="form-group col-md">
                    <label
                        for="email"
                        class="form-label text-white">
                        <b>Email <sup>* digunakan sebagai username saat login</sup></b>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        readonly
                        class="form-control">
                </div>
                <div class="form-group col-md">
                    <label
                        for="password_bujp"
                        class="form-label text-white">
                        <b>Password <sup>* digunakan untuk login</sup></b>
                    </label>
                    <input
                        type="password"
                        class="form-control assign-manual"
                        minlength="4"
                        id="password_bujp"
                        name="password"
                        placeholder="masukkan password anda">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="logo_bujp">Logo
                <sup>* PNG/JPEG, maksimal 2MB</sup>
            </label>
            <input
                type="file"
                class="form-control assign-manual"
                accept="image/jpg,image/png"
                id="logo_bujp"
                name="logo_badan_usaha">
        </div>
        <div class="form-group">
            <label class="form-label">Bidang Usaha</label>
            <div>
                <input
                    type="checkbox"
                    value="Usaha jasa konsultasi keamanan"
                    name="bidang_usaha[]"
                    id="konsultasi-keamanan">
                <label for="konsultasi-keamanan">
                    Usaha jasa konsultasi keamanan (<i>Security Consultancy</i>)
                </label>
            </div>
            <div class="mt-3">
                <input
                    type="checkbox"
                    value="Usaha jasa penerapan peralatan keamanan"
                    name="bidang_usaha[]"
                    id="peralatan-keamanan">
                <label for="peralatan-keamanan">
                    Usaha jasa penerapan peralatan keamanan (<i>Security Devices</i>)
                </label>
            </div>
            <div class="mt-3">
                <input
                    type="checkbox"
                    value="Usaha jasa pelatihan keamanan"
                    name="bidang_usaha[]"
                    id="pelatihan-keamanan">
                <label for="pelatihan-keamanan">
                    Usaha jasa pelatihan keamanan (<i>Security Training</i>)
                </label>
            </div>
            <div class="mt-3">
                <input
                    type="checkbox"
                    value="Usaha jasa kawal angkut uang dan barang berharga"
                    name="bidang_usaha[]"
                    id="pengawalan">
                <label for="pengawalan">
                    Usaha jasa kawal angkut uang dan barang berharga (<i>Valuables Security Transport</i>)
                </label>
            </div>
            <div class="mt-3">
                <input
                    type="checkbox"
                    value="Usaha jasa penyediaan tenaga pengamanan"
                    name="bidang_usaha[]"
                    id="tenaga-pengamanan">
                <label for="tenaga-pengamanan">
                    Usaha jasa penyediaan tenaga pengamanan (<i>Guard Services</i>)
                </label>
            </div>
            <div class="mt-3">
                <input
                    type="checkbox"
                    value="Usaha jasa penyediaan satwa"
                    name="bidang_usaha[]"
                    id="penyediaan-satwa">
                <label for="penyediaan-satwa">
                    Usaha jasa penyediaan satwa (<i>K9 Services</i>)
                </label>
            </div>
        </div>
        <h4 class="col-12 text-center mt-5"><b>Profil Penanggung Jawab</b></h4>
        <div class="form-group col-md-8">
            <label for="nama_pj" class="form-label">Nama Lengkap</label>
            <select
                name="nama_penanggung_jawab"
                id="nama_pj"
                class="form-select">
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="jabatan_pj" class="form-label">Jabatan</label>
            <input
                type="text"
                name="jabatan_penanggung_jawab"
                id="jabatan_pj"
                class="form-control"
                readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="no_tel_pj" class="form-label">No. Telepon</label>
            <input
                type="text"
                id="no_tel_pj"
                class="form-control"
                name="nomor_telepon_penanggung_jawab"
                readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="no_ktp_pj" class="form-label">No. KTP</label>
            <input
                type="text"
                id="no_ktp_pj"
                class="form-control"
                name="nomor_ktp_penanggung_jawab"
                readonly>
        </div>
        <div class="form-group col-md-6">
            <label
                class="form-label"
                for="foto">Pas Foto
                <sup>* resolusi 3x4 - PNG/JPEG, maksimal 2MB</sup>
            </label>
            <input
                type="file"
                name="foto_penanggung_jawab"
                id="foto"
                class="form-control assign-manual"
                accept="image/jpg,image/png">
        </div>
        <div
            class="form-group col-md-6">
            <label
                class="form-label"
                for="foto_ktp_pj">File KTP
                <sup>* PNG/JPEG, maksimal 2MB</sup>
            </label>
            <input
                type="file"
                name="foto_ktp_penanggung_jawab"
                id="foto_ktp_pj"
                class="form-control assign-manual"
                accept="image/jpg,image/png">
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
        <div class="my-4 d-flex justify-content-between justify-content-lg-end">
            <button
                type="button"
                class="btn btn-danger"
                onclick="document.history.bakc()">Batal</button>
            <button
                type="submit"
                style="background: #A0B8E0; color: #1E4588">Simpan</button>
        </div>
    </form>
</main>
@endsection
@section('customjs')
{!! ReCaptcha::htmlScriptTagJsApi() !!}
<script>
    const isBUJP = (res) => res.some((proyek) => proyek.kbli == 80100)
    const getEl  = (el) => document.querySelector(el)
    const nibInput = getEl('#search-nib')

    const Alamat = {
        init(code) {
            this.prov(code.substr(0,2))
            this.kota(code.substr(0,4))
            this.kecamatan(code.substr(0,6))
            this.desa(code)
        },

        async apply (url, code, element) {
            const res = await axios.post(url, {code})
            const resData = await res.data
            getEl(element).value = (typeof await resData === 'string') ? await resData : '-'
        },

        async prov (province_code) {
            await this.apply(route('provinsi.name'), Number(province_code), '#provinsi')
        },

        async kota (city_code) {
            await this.apply(route('kota.name'), Number(city_code), '#kota')
        },

        async kecamatan (district_code) {
            await this.apply(route('kecamatan.name'), Number(district_code), '#kecamatan')
        },

        async desa (village_code) {
            await this.apply(route('desa.name'), Number(village_code), '#desa')
        }
    }

    const ProfileBUJP = {
        init (bujp) {
            this._bujp = bujp
            this.apply()
        },

        bidangSpesifik (data_checklist) {
            data_checklist.forEach(item => {
                if (item.id_bidang_spesifik === 982)
                    getEl('input[id="penyediaan-satwa"]').setAttribute('checked', true)
                if (item.id_bidang_spesifik === 983)
                    getEl('input[id="tenaga-pengamanan"]').setAttribute('checked', true)
                if (item.id_bidang_spesifik === 984)
                    getEl('input[id="pengawalan"]').setAttribute('checked', true)
                if (item.id_bidang_spesifik === 985)
                    getEl('input[id="pelatihan-keamanan"]').setAttribute('checked', true)
                if (item.id_bidang_spesifik === 986)
                    getEl('input[id="konsultasi-keamanan"]').setAttribute('checked', true)
                if (item.id_bidang_spesifik === 987)
                    getEl('input[id="peralatan-keamanan"]').setAttribute('checked', true)
            })
        },

        apply () {
            getEl("input[name='nama_badan_usaha']").value = this._bujp.nama_perseroan
            getEl("input[name='nib']").value = this._bujp.nib
            getEl("textarea[name='detail_alamat']").value = this._bujp.alamat_perseroan
            getEl("input[name='email']").value = this._bujp.email_perusahaan === '-'
                ? this._bujp.email_user_proses
                : this._bujp.email_perusahaan
            getEl("input[name='kode_pos']").value = this._bujp.kode_pos_perseroan
            getEl("input[name='npwp_badan_usaha']").value = this._bujp.npwp_perseroan
            getEl("input[name='nomor_telepon']").value = this._bujp.nomor_telpon_perseroan
            getEl("input[name='tipe_badan_usaha']").value = "Perusahaan Terbatas (PT)"
            this.bidangSpesifik(this._bujp.data_checklist)
            Alamat.init(this._bujp.perseroan_daerah_id)
            ProfilePJ.init(this._bujp.penanggung_jwb)
        }
    }

    const ProfilePJ = {
        async init (data) {
            this._data = await this.filter(data)
            this._index = 0
            this.nama()
            this.attr()
        },

        filter (data) {
            return data.filter((pj) => pj.jabatan_penanggung_jwb !== 'BADAN HUKUM')
        },

        set index (value) {
            this._index = value
            this.attr(this._index)
        },

        nama () {
            const nama_pj = getEl('#nama_pj')
            nama_pj.innerHTML = ''
            this._data.forEach((value, index) => {
                const option = document.createElement('option')
                option.textContent = value.nama_penanggung_jwb
                option.value = value.nama_penanggung_jwb
                option.setAttribute('id', index)
                nama_pj.appendChild(option)
            })
        },

        attr (i = 0) {
            getEl("#jabatan_pj").value = this._data[i]['jabatan_penanggung_jwb']
            getEl("#no_tel_pj").value = this._data[i]['no_telp_penanggung_jwb']
            getEl("#no_ktp_pj").value = this._data[i]['no_identitas_penanggung_jwb']
        }
    }

    const getDataByNIB = (nib) => {
        if (nib.length !== 13) {
            swalWarning('Nomor Induk Berusaha wajib diisi serta berjumlah 13 digit')
            return
        }

        const url = "{{ route('oss.inquery-nib', ':nib') }}"
        xhr.open('GET', url.replace(':nib', nib.trim()), true)
        xhr.onload = function () {
            const res = JSON.parse(this.response)
            if (!(res.code >= 200 && res.code < 400))
                return swalWarning('NIB tidak ditemukan')
            if (res.data.jenis_pelaku_usaha !== "11" || res.data.jenis_perseroan !== "01")
                return swalWarning('Maaf, pelaku perusahaan tidak boleh perseorangan')
            if (!isBUJP(res.data.data_proyek))
                return swalWarning('Maaf, perusahaan anda bukan BUJP. Anda tidak memiliki data proyek dengan KBLI 80100 (Aktivitas Keamanan Swasta)')
            ProfileBUJP.init(res.data)
        }
        xhr.send()
    }

    getEl('#form-search-nib').addEventListener('submit', (e) => {
        e.preventDefault()
        getDataByNIB(nibInput.value)
    })

    @if (session('nib'))
        getDataByNIB("{{ session('nib') }}")
    @endif

    getEl('#nama_pj').addEventListener('change', (e) => {
        ProfilePJ.index = e.target.options[e.target.selectedIndex].getAttribute('id')
    })

    getEl('#form-bujp').addEventListener('submit', (e) => {
        document.querySelectorAll('.assign-manual').forEach((el) => {
            if (el.value === null || el.value === undefined || el.value === '') {
                swalWarning(`${el.name.split('_').join(' ')} wajib diisi`)
                e.preventDefault()

                hideFormLoader()
                return;
            }
        })
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
