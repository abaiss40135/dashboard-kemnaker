@php
    $u = explode(',', $bujp->bidang_usaha);
@endphp
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
    </style>
@endsection
@section('mainComponent')
    <main class="my-sm-3 p-0 container bg-white">
        <h4 class="text-center py-3 py-sm-2 text-white"
            style="background-color: #1E4588">Registrasi Akun BUJP</h4>
        {{-- <||<=< PROFIL BADAN USAHA >=>||> --}}
        <div class="row text-center mt-5">
            <div class="col-md-2"></div>
            <div class="col-md-8 d-flex justify-content-center align-items-center">
                <h4 class="mb-md-0">
                    <b>Profil Badan Usaha</b>
                </h4>
            </div>
            <div class="col-md-2">
                <div>
                    <button type="button" onclick="getDataByNIB('{{ $bujp->nib }}')"
                            class="btn-info py-2 px-3" title="perbarui data dari OSS">
                        <i class="fa fa-sync"></i>&nbsp;Perbarui
                    </button>
                </div>
            </div>
        </div>
        {{--|> form <|--}}
        <form action="{{ route('register-bujp.update', $bujp->id) }}" method="post"
              enctype="multipart/form-data" class="row mx-1" id="form-bujp">
            @csrf
            @method('patch')
            {{-- nama BUJP --}}
            <div class="form-group col-md-12">
                <label for="select-email">Email</label>
                <select class="form-control form-select" name="email" id="select-email">
                    <option value="{{ auth()->user()->email }}" selected>{{ auth()->user()->email }}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="nama_bujp" class="form-label">Nama Badan Usaha</label>
                <input type="text" class="form-control" id="nama_bujp"
                       name="nama_badan_usaha" value="{{ $bujp->nama_badan_usaha }}"
                       readonly>
            </div>
            {{-- tipe BUJP --}}
            <div class="form-group col-md-6">
                <label for="tipe_bujp" class="form-label">Tipe Badan Usaha</label>
                <input type="text" name="tipe_badan_usaha" id="tipe_bujp"
                       class="form-control" value="{{ $bujp->tipe_badan_usaha}}" readonly>
            </div>
            {{-- detail alamat --}}
            <div class="form-group">
                <label for="detail_alamat" class="form-label">Detail Alamat</label>
                <textarea name="detail_alamat" id="detail_alamat" rows="3"
                          class="form-control" readonly>{{ $bujp->detail_alamat }}</textarea>
            </div>
            {{-- provinsi, kota/kabupaten, kecamatan, kelurahan/kabupaten --}}
            <div class="mx-auto px-1 row">
                <div class="form-group col-md-6 col-lg-3">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <input type="text" name="provinsi" id="provinsi"
                           class="form-control" value="{{ $bujp->provinsi }}" readonly>
                </div>
                <div class="form-group col-md-6 col-lg-3">
                    <label for="kota" class="form-label">Kabupaten/Kota</label>
                    <input type="text" name="kabupaten" id="kota"
                           class="form-control" value="{{ $bujp->kabupaten }}" readonly>
                </div>
                <div class="form-group col-md-6 col-lg-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan"
                           class="form-control" value="{{ $bujp->kecamatan }}" readonly>
                </div>
                <div class="form-group col-md-6 col-lg-3">
                    <label for="desa" class="form-label">Kelurahan/Desa</label>
                    <input type="text" name="desa" id="desa"
                           class="form-control" value="{{ $bujp->desa }}" readonly>
                </div>
            </div>
            {{-- kode pos --}}
            <div class="form-group col-md-6">
                <label for="kode_pos_bujp" class="form-label">Kode Pos</label>
                <input type="text" name="kode_pos" id="kode_pos_bujp"
                       class="form-control" value="{{ $bujp->kode_pos }}" readonly>
            </div>
            {{-- no_tel --}}
            <div class="form-group col-md-6">
                <label for="no_tel_bujp" class="form-label">Nomor Telepon</label>
                <input type="tel" id="no_tel_bujp" class="form-control" maxlength="15"
                       name="nomor_telepon" value="{{ $bujp->nomor_telepon }}" readonly>
            </div>
            {{-- NPWP --}}
            <div class="form-group col-md-6">
                <label for="npwp_bujp" class="form-label">No. NPWP</label>
                <input type="text" id="npwp_bujp" class="form-control" maxlength="20"
                       name="npwp_badan_usaha" value="{{ $bujp->npwp_badan_usaha }}" readonly>
            </div>
            {{-- website --}}
            <div class="form-group col-md-6">
                <label for="website" class="form-label">Website</label>
                <input type="text" id="website" placeholder="https://namasitus.com"
                       class="form-control" value="{{ $bujp->website_badan_usaha}}"
                       name="website_badan_usaha">
            </div>
            {{-- logo BUJP --}}
            <div class="form-group">
                <label class="form-label" for="logo_bujp">Logo
                    <sup class="text-danger">* PNG/JPEG, maksimal 2MB</sup>
                </label>
                <a href="{{ $bujp->url_logo_badan_usaha }}" target="_blank" class="d-block">
                    <img src="{{ $bujp->url_logo_badan_usaha }}" width="256px"
                         alt="logo {{ strtolower($bujp->nama_badan_usaha)}}"
                         style="background-color: #f1f1f7" class="p-2">
                </a>
                <input type="file" class="form-control" id="logo_bujp" name="logo_badan_usaha">
            </div>
            {{-- bidang usaha BUJP --}}
            <div class="form-group">
                <label class="form-label">Bidang Usaha</label>
                <div>
                    <input type="checkbox" value="Usaha jasa konsultasi keamanan"
                           name="bidang_usaha[]" id="konsultasi-keamanan"
                           @if(in_array('Usaha jasa konsultasi keamanan', $u)) checked @endif>
                    <label for="konsultasi-keamanan">
                        Usaha jasa konsultasi keamanan (<i>Security Consultancy</i>)
                    </label>
                </div>
                <div class="mt-3">
                    <input type="checkbox" value="Usaha jasa penerapan peralatan keamanan"
                           name="bidang_usaha[]" id="peralatan-keamanan"
                           @if(in_array('Usaha jasa penerapan peralatan keamanan', $u)) checked @endif>
                    <label for="peralatan-keamanan">
                        Usaha jasa penerapan peralatan keamanan (<i>Security Devices</i>)
                    </label>
                </div>
                <div class="mt-3">
                    <input type="checkbox" value="Usaha jasa pelatihan keamanan"
                           name="bidang_usaha[]" id="pelatihan-keamanan"
                           @if(in_array('Usaha jasa pelatihan keamanan', $u)) checked @endif>
                    <label for="pelatihan-keamanan">
                        Usaha jasa pelatihan keamanan (<i>Security Training</i>)
                    </label>
                </div>
                <div class="mt-3">
                    <input type="checkbox" value="Usaha jasa kawal angkut uang dan barang berharga"
                           name="bidang_usaha[]" id="pengawalan"
                           @if(in_array('Usaha jasa kawal angkut uang dan barang berharga', $u)) checked @endif>
                    <label for="pengawalan">
                        Usaha jasa kawal angkut uang dan barang berharga (<i>Valuables Security Transport</i>)
                    </label>
                </div>
                <div class="mt-3">
                    <input type="checkbox" value="Usaha jasa penyediaan tenaga pengamanan"
                           name="bidang_usaha[]" id="tenaga-pengamanan"
                           @if(in_array('Usaha jasa penyediaan tenaga pengamanan', $u)) checked @endif>
                    <label for="tenaga-pengamanan">
                        Usaha jasa penyediaan tenaga pengamanan (<i>Guard Services</i>)
                    </label>
                </div>
                <div class="mt-3">
                    <input type="checkbox" value="Usaha jasa penyediaan satwa"
                           name="bidang_usaha[]" id="penyediaan-satwa"
                           @if(in_array('Usaha jasa penyediaan satwa', $u)) checked @endif>
                    <label for="penyediaan-satwa">
                        Usaha jasa penyediaan satwa (<i>K9 Services</i>)
                    </label>
                </div>
            </div>
            {{-- <||<=< PROFIL PENANGGUNG JAWAB >=>||> --}}
            <h4 class="col-12 text-center mt-5"><b>Profil Penanggung Jawab</b></h4>
            {{-- nama penanggung jawab --}}
            <div class="form-group col-md-8">
                <label for="nama_pj" class="form-label">Nama Lengkap</label>
                <select name="nama_penanggung_jawab" id="nama_pj" class="form-select">
                    <option value="{{ $bujp->nama_penanggung_jawab }}">{{ $bujp->nama_penanggung_jawab }}</option>
                </select>
            </div>
            {{-- jabatan penganggung jawab --}}
            <div class="form-group col-md-4">
                <label for="jabatan_pj" class="form-label">Jabatan</label>
                <input type="text" name="jabatan_penanggung_jawab" id="jabatan_pj"
                       class="form-control" value="{{ $bujp->jabatan_penanggung_jawab }}" readonly>
            </div>
            {{-- no_tel penanggung jawab --}}
            <div class="form-group col-md-6">
                <label for="no_tel_pj" class="form-label">No. Telepon</label>
                <input type="text" id="no_tel_pj" class="form-control"
                       name="nomor_telepon_penanggung_jawab" readonly
                       value="{{ $bujp->nomor_telepon_penanggung_jawab }}">
            </div>
            {{-- no_ktp penanggung jawab --}}
            <div class="form-group col-md-6">
                <label for="no_ktp_pj" class="form-label">No. KTP</label>
                <input type="text" id="no_ktp_pj" class="form-control"
                       name="nomor_ktp_penanggung_jawab" readonly
                       value="{{ $bujp->nomor_ktp_penanggung_jawab}}">
            </div>
            {{-- foto penanggung jawab --}}
            <div class="form-group col-md-6">
                <label class="form-label" for="foto">Pas Foto
                    <sup class="text-danger">
                        * resolusi 3x4 - PNG/JPEG, maksimal 2MB
                    </sup>
                </label>
                <a href="{{ $bujp->url_foto_penanggung_jawab }}" target="_blank" class="d-block">
                    <img src="{{ $bujp->url_foto_penanggung_jawab }}" width="186px"
                         alt="foto {{ strtolower($bujp->nama_penanggung_jawab)}}"
                         style="background-color: #f1f1f7" class="p-2">
                </a>
                <input type="file" id="foto" class="form-control" name="foto_penanggung_jawab">
            </div>
            {{-- foto ktp penanggung jawab --}}
            <div class="form-group col-md-6">
                <label class="form-label" for="foto_ktp_pj">File KTP
                    <sup class="text-danger">
                        * PNG/JPEG, maksimal 2MB
                    </sup>
                </label>
                <a href="{{ $bujp->url_foto_ktp_penanggung_jawab }}" target="_blank" class="d-block">
                    <img src="{{ $bujp->url_foto_ktp_penanggung_jawab }}" width="186px"
                         alt="foto ktp {{ strtolower($bujp->nama_penanggung_jawab)}}"
                         style="background-color: #f1f1f7" class="p-2">
                </a>
                <input type="file" id="foto_ktp_pj" class="form-control"
                       name="foto_ktp_penanggung_jawab">
            </div>
            {{-- button --}}
            <div class="mt-5 d-flex justify-content-between justify-content-lg-end">
                <button class="btn btn-danger" onclick="redirectBack()" type="reset">Batal</button>
                <button style="background: #A0B8E0; color: #1E4588" type="submit">Simpan</button>
            </div>
        </form>
    </main>
@endsection
@section('customjs')
    <script src="{{ asset('js/bhabin/laporan/dds/dds-form.js') }}"></script>
    <script>
        const redirectBack = () => document.location.href = "{{ url('/login') }}"
        const getEl = (element) => document.querySelector(element)
        const isBUJP = (badanUsaha) => badanUsaha.some((proyek) => proyek.kbli == 80100)
        const nibInput = getEl('#search-nib')

        const Alamat = {
            init(code) {
                this.prov(code.substr(0, 2))
                this.kota(code.substr(0, 4))
                this.kecamatan(code.substr(0, 6))
                this.desa(code)
            },

            async apply(url, code, element) {
                const res = await axios.post(url, {code})
                const resData = await res.data
                getEl(element).value = (typeof await resData === 'string') ? await resData : '-'
            },

            async prov(province_code) {
                await this.apply('{{route('provinsi.name')}}', Number(province_code), '#provinsi')
            },

            async kota(city_code) {
                await this.apply('{{route('kota.name')}}', Number(city_code), '#kota')
            },

            async kecamatan(district_code) {
                await this.apply('{{route('kecamatan.name')}}', Number(district_code), '#kecamatan')
            },

            async desa(village_code) {
                await this.apply('{{route('desa.name')}}', Number(village_code), '#desa')
            }
        }

        const ProfileBUJP = {
            init(bujp) {
                this._bujp = bujp
                this.apply()
            },

            bidangSpesifik(data_checklist) {
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

            apply() {
                getEl("input[name='nama_badan_usaha']").value = this._bujp.nama_perseroan
                getEl("textarea[name='detail_alamat']").value = this._bujp.alamat_perseroan
                getEl("input[name='kode_pos']").value = this._bujp.kode_pos_perseroan
                getEl("input[name='npwp_badan_usaha']").value = this._bujp.npwp_perseroan
                getEl("input[name='nomor_telepon']").value = this._bujp.nomor_telpon_perseroan
                getEl("input[name='tipe_badan_usaha']").value = "Perusahaan Terbatas (PT)"
                this.bidangSpesifik(this._bujp.data_checklist)
                Alamat.init(this._bujp.perseroan_daerah_id)
                ProfilePJ.init(this._bujp.penanggung_jwb)

                //pilihan email perusahaan atau email user proses
                if (this._bujp.email_perusahaan !== "{{ auth()->user()->email }}") {
                    $('select#select-email').append(appendSelectOption(this._bujp.email_perusahaan, this._bujp.email_perusahaan, false));
                } else if (this._bujp.email_user_proses !== "{{ auth()->user()->email }}"){
                    $('select#select-email').append(appendSelectOption(this._bujp.email_user_proses, this._bujp.email_user_proses, false));
                }
            }
        }

        const ProfilePJ = {
            async init(data) {
                this._data = await this.filter(data)
                this._index = 0
                this.nama()
                this.attr()
            },

            filter(data) {
                return data.filter((pj) => pj.jabatan_penanggung_jwb !== 'BADAN HUKUM')
            },

            set index(value) {
                this._index = value
                this.attr(this._index)
            },

            nama() {
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

            attr(i = 0) {
                getEl("#jabatan_pj").value = this._data[i]['jabatan_penanggung_jwb']
                getEl("#no_tel_pj").value = this._data[i]['no_telp_penanggung_jwb']
                getEl("#no_ktp_pj").value = this._data[i]['no_identitas_penanggung_jwb']
            }
        }

        const getDataByNIB = (nib) => {
            if (String(nib).length !== 13) {
                return swalWarning('Nomor Induk Berusaha wajib diisi serta berjumlah 13 digit')
            }

            const url = "{{ route('oss.inquery-nib', ':nib') }}"
            xhr.open('GET', url.replace(':nib', nib), true)
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

        // func trigger
        getEl('#nama_pj').addEventListener('change', (e) => {
            ProfilePJ.index = e.target.options[e.target.selectedIndex].getAttribute('id')
        })
        getEl('#select-email').addEventListener('change', (e) => {
            if (e.target.value !== "{{ auth()->user()->email }}") {
                $('#select-email').parent().append(`<div class="alert alert-warning" role="alert">Apakah anda yakin ingin melakukan perubahan email? <span style="color: darkblue;cursor: pointer;" onclick="sendRequestChangeEmail()"> Klik disini </span>untuk merubah</div>`)
            } else {
                e.target.parentElement.lastChild.remove();
            }
        })
        const sendRequestChangeEmail = async () => {
            // axios post request with headers
            submitFormLoader();
            const url = "{{ route('auth.email-change') }}"
            await axios.post(url, {email: $('#select-email').val()}, {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(res => {
                hideFormLoader();
                if (res.data.status === 'success') {
                    swalSuccess(res.data.message)
                } else {
                    swalWarning(res.data.message)
                }
            }).catch(err => {
                hideFormLoader();
                swalWarning(err.response.data.message)
            })
        }
    </script>
@endsection
