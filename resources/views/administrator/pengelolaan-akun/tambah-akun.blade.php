@extends('templates.admin-lte.admin', ['title' => 'Tambah Akun'])
@section('customcss')
    @include('assets.css.select2')
    <style>
        .card .header {
            background: #30589A;
            font-weight: 500 !important;
        }

        .btn-primary {
            background: #30589A;
            color: #fff;
        }

        .card button {
            padding: 8px 20px;
            width: fit-content;
            border: none;
            border-radius: 5px;
        }

        .inputLabel {
            background: #babec5;
            color: rgb(34, 30, 30);
            height: fit-content;
            width: fit-content;
            padding: 6px 20px;
            white-space: nowrap;
            margin-bottom: 0;
        }

        input[type='file'] {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header" style="background-color: #274C77;">
                    <h6 class="card-title" style="color: white">Tambah Akun</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tambah-akun.store') }}" method="POST"
                            onsubmit="disableSubmitButtonTemporarily(this)">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="select-role">Hak Akses <small>(User Bhabinkamtibmas wajib
                                    mengisi nrp)</small></label>
                            <select name="role_id[]" id="select-role" multiple="multiple"
                                    class="form-control select2 w-100  @error('role_id') is-invalid @enderror">
                                <option></option>
                            </select>
                            @error('role_id')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nrp">NRP <small>*optional</small></label>
                            <div class="input-group">
                                <input type="text" name="nrp" id="nrp" value="{{ old('nrp') }}"
                                       class="form-control @error('nrp') is-invalid @enderror">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-success" id="search-personel">Cari</button>
                                </span>
                                @error('nrp')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                    class="form-control  @error('email') is-invalid @enderror">
                            @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password"
                                    class="form-control  @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation"
                                    type="password"
                                    class="form-control  @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group float-right">
                            <button type="button" class="btn btn-success" id="btn-import"
                                    data-toggle="modal" data-target="#modalImportExcel">
                                Import Excel
                            </button>
                            <button type="submit"
                                    class="btn btn-primary">{{ __('locale.Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="wrapper-informasi-personel" class="col-md-6 d-none">
            <div class="card">
                <div class="card-header" style="background-color: #274C77;">
                    <h6 class="card-title" style="color: white">Informasi Personel</h6>
                </div>
                <div class="card-body">
                    <div class="text-center img-preloader">
                        <img class="img-fluid" alt="img-preloader"
                                src="{{asset('img/ellipsis-preloader.gif')}}">
                    </div>
                    <div id="box-profile" class="d-none">
                        <div class="box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid" id="personel_foto"
                                     src="{{ \App\Helpers\Constants::PLACEHOLDER_IMG }}"
                                     alt="personel picture">
                            </div>
                            <h3 class="profile-username text-center" id="header_nama">Nama</h3>
                            <p class="text-center mb-0">
                                <span id="header_pangkat">Pangkat</span> /
                                <span id="header_nrp">NRP</span>
                            </p>
                            <p class="text-center mb-0" id="header_jabatan">Jabatan</p>
                        </div>
                        <hr>
                        <div class="horizontal">
                            <div class="row">
                                <label class="col-sm-4">TMT Jabatan</label>
                                <p class="col-sm-8" id="personel_tmt_jabatan">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Lama Jabatan</label>
                                <p class="col-sm-8" id="personel_lama_jabatan">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Satuan</label>
                                <p class="col-sm-8" id="personel_satuan">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Satuan I</label>
                                <p class="col-sm-8" id="personel_satuan1">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Satuan II</label>
                                <p class="col-sm-8" id="personel_satuan2">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Email</label>
                                <p class="col-sm-8" id="personel_email">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Email Dinas</label>
                                <p class="col-sm-8" id="personel_email_dinas">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Tanggal Lahir</label>
                                <p class="col-sm-8" id="personel_tanggal_lahir">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Jenis Kelamin</label>
                                <p class="col-sm-8" id="personel_jenis_kelamin">: &emsp;-</p>
                            </div>
                            <div class="row">
                                <label class="col-sm-4">Nomor Handphone</label>
                                <p class="col-sm-8" id="personel_handphone">: &emsp;-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalImportExcel" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modalImportExcelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalImportExcelLabel">Import Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah-akun.import-excel') }}" method="POST" enctype="multipart/form-data" id="form-import-excel">
                        @csrf
                        <div class="form-group">
                            <label for="select-role-import">Hak Akses</label>
                            <select id="select-role-import" name="hak_akses[]" required multiple="multiple"
                                    class="form-control select2 w-100  @error('hak_akses') is-invalid @enderror">
                                <option></option>
                            </select>
                            @error('hak_akses')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Pilih File Import</label>
                            <div class="d-flex align-items-center" style="height: fit-content">
                                <input type="text" readonly class="form-control"
                                       style="width: 100%; background:none;"
                                       placeholder="*.xls, *.xlsx" aria-label="excel file" required
                                       aria-describedby="basic-addon2" onchange="inputValue(this)">
                                <label for="bhabin_file" class="inputLabel">Pilih File</label>
                                <input type="file" onchange="inputValue(this)" name="file"
                                       id="bhabin_file">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('download', ['url' => 'import/excel/user/1624503360_bm-format-excel-import-data-bhabinkamtibmas.xlsx']) }}"
                       class="btn btn-success">{{ __('locale.Download') }} Template</a>
                    <button type="submit" onclick="$('#form-import-excel').submit()" class="btn btn-primary">Import</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.select2')
    <script>
        const loader = document.querySelector('.img-preloader')
        const boxProfile = document.getElementById('box-profile');

        const showLoader = () => {
            loader.classList.add('d-block')
            loader.classList.remove('d-none')
            boxProfile.classList.add('d-none');
        }

        const hideLoader = () => {
            loader.classList.remove('d-block')
            loader.classList.add('d-none')
            boxProfile.classList.remove('d-none');
        }

        document.getElementById('search-personel').addEventListener('click', function (e) {
            let elBtn = this;

            Pace.stop();
            Pace.bar.render();
            showLoader();
            elBtn.setAttribute('disabled', true);

            let nrp = this.parentNode.parentNode.querySelector('input').value.trim() ?? "";
            if (nrp.length !== 8 || isNaN(nrp)) {
                swalWarning('NRP harus berupa angka dengan jumlah 8 karakter');
                elBtn.removeAttribute('disabled');
                return;
            }
            axios.post(route("tambah-akun.search-personel"), {
                nrp: nrp,
            }).then(function (response) {
                if (response.status === 200) {
                    if (response.data.length === 0) {
                        swalWarning('Data personel dengan nrp ' + nrp + ' tidak ditemukan');
                        return;
                    }
                    fillBoxProfileData(response.data)
                }
                Pace.stop();
                hideLoader();
                elBtn.removeAttribute('disabled');
            }).catch(function (error) {
                Pace.stop();
                hideLoader();
                elBtn.removeAttribute('disabled');
                elBtn.parentElement.parentElement.querySelector('input').value = "";
                document.getElementById('wrapper-informasi-personel').classList.add('d-none');
                swalError(error.response.data.message)
            });
        });

        function fillBoxProfileData(personelData) {
            Object.keys(personelData).forEach(function (key) {
                let element = document.getElementById('personel_' + key);
                if (element != null) {
                    element.innerHTML = ':&emsp;' + (personelData[key] === null ? '-' : personelData[key]);
                }
            })
            document.getElementById('personel_foto').setAttribute('src', personelData['foto_file']);
            document.getElementById('header_nama').innerHTML = personelData['nama']
            document.getElementById('header_nrp').innerHTML = personelData['nrp']
            document.getElementById('header_pangkat').innerHTML = personelData['pangkat']
            document.getElementById('header_jabatan').innerHTML = personelData['jabatan']
            document.getElementById('email').value = personelData['email'];
            document.getElementById('wrapper-informasi-personel').classList.remove('d-none');
        }

        $(function () {
            buildSelect2Search({
                placeholder: '-- Pilih Hak Akses --',
                url: route('role.select2', {'type-page-request' : 'tambah-akun-page'}),
                minimumInputLength: 0,
                selector: [
                    { id: $('#select-role') },
                    { id: $('#select-role-import') }
                ],
                query: function (params) {
                    return {
                        alias: params.term,
                    }
                }
            });
        });
    </script>
@endsection
