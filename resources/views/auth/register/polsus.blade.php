@can('register_polsus_create')

@extends('templates.admin-lte.admin', ['title' => 'Mendaftarkan Akun SIPOLSUS'])
@section('customcss')
    @include('assets.css.select2')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <style>
        .indent {
            border-left: 0.2rem solid hsl(218, 64%, 33%)
        }

        .filepond--credits {
            display: none;
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
    <div class="card">
{{--        import button and download template excel--}}
        <div class="card-header p-4">
            <div class="d-md-flex justify-content-between">
                <div class="d-md-flex justify-content-stretch justify-content-sm-start">
                    <div class="pr-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#formatRegistrasiPolsusModal">
                            Unduh Format Excel Registrasi Polsus
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalUpload">Import Excel</button>
                        <div class="modal fade" id="modalUpload" tabindex="-1"
                             role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="{{ route('register-polsus.import-excel') }}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Import Excel</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="select-role-import">Profil</label>
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
                                                           placeholder="*.xls, *.xlsx" aria-label="excel file"
                                                           aria-describedby="basic-addon2" onchange="inputValue(this)">
                                                    <label for="file-laporan" class="inputLabel">Pilih File</label>
                                                    <input type="file" class="custom-file-input" required
                                                           name="file-laporan" id="file-laporan"
                                                           accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                           onchange="inputValue(this)">
                                                </div>
                                            </div>

                                            @if($isAdmin)
                                            <div class="text-muted mt-3">
                                                Mohon isi laporan dengan benar dan sesuai format!
                                            </div>
                                            @elseif($operatorPolda)
                                                <div class="text-muted mt-3">
                                                    <ul>
                                                        <li>Mohon isi laporan dengan benar dan sesuai format!</li>
                                                        <li>Untuk Kolom Provinsi tidak perlu diisi!</li>
                                                        <li>Provinsi Polsus: {{ucwords(getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda))}}</li>
                                                    </ul>
                                                </div>
                                            @else
                                                <div class="text-muted mt-3">
                                                    <ul>
                                                        <li>Mohon isi laporan dengan benar dan sesuai format!</li>
                                                        <li>Untuk Kolom Instansi dan Jenis Polsus tidak perlu diisi!</li>
                                                        <li>Instansi Polsus: {{auth()->user()->polsus->instansi->instansi}}</li>
                                                        <li>Jenis Polsus: {{ucwords( implode(' ', explode('_', auth()->user()->polsus->jenis_polsus)) )}}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button class="btn btn-primary" type="submit">Unggah</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-info" data-toggle="modal"
                            data-target="#modalUpdatePolsus">Update Data Anggota Polsus</button>
                    <div class="modal fade" id="modalUpdatePolsus" tabindex="-1"
                         role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('register-polsus.update-data-polsus') }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Import Excel Untuk Update Data Anggota Polsus!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="" class="form-label">Pilih File Import</label>
                                            <div class="d-flex align-items-center" style="height: fit-content">
                                                <input type="text" readonly class="form-control"
                                                       style="width: 100%; background:none;"
                                                       placeholder="*.xls, *.xlsx" aria-label="excel file"
                                                       aria-describedby="basic-addon2" onchange="inputValue(this)">
                                                <label for="polsus-update-file" class="inputLabel">Pilih File</label>
                                                <input type="file" class="custom-file-input" required
                                                       name="polsus-update-file" id="polsus-update-file"
                                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                       onchange="inputValue(this)">
                                            </div>
                                        </div>

                                        <ul>
                                            <li>Format yang dipakai sama seperti format registrasi Data Polsus</li>
                                            <li>Harap mengisi No NIP dengan seksama!</li>
                                            <li>Update Data berdasarkan No NIP yang dimiliki oleh Polsus</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button class="btn btn-primary" type="submit">Unggah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <form action="{{ route('register-polsus.store') }}"
              method="post" enctype="multipart/form-data" class="card-body">
            @csrf
            <div class="row form-group">
                <div class="col-lg-2">Profil</div>
                <div class="col-lg-10">
                    <select name="role_id[]" id="select-role" multiple="multiple"
                            class="form-control select2 w-100  @error('role_id') is-invalid @enderror">
                        <option></option>
                    </select>
                    @error('role_id')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Foto Polsus</div>
                <div class="col-lg-10">
                    <input required type="file" name="foto_profile" id="photo" class="filepond"
                            data-allow-reorder="true"
                            data-max-file-size="3MB">
                </div>
            </div>
            <div class="row form-group form-group-email">
                <div class="col-lg-2">Email</div>
                <div class="col-lg-10">
                    <input type="email" name="email" id="email"
                           class="form-control" value="{{old('email')}}">
                    <small class="text-danger">email digunakan untuk login</small>
                </div>
            </div>
            <div class="row form-group form-group-password">
                <div class="col-lg-2">Password</div>
                <div class="col-lg-10" style="position: relative">
                    <input type="password" name="password" id="password"
                           class="form-control" value="{{old('password')}}"
                           placeholder="********">
                    <i class="fas fa-eye-slash"
                       style="position: absolute; right: 1.2rem; top: 0.8rem;" onclick="hide_password()"></i>
                    <i class="far fa-eye show_password d-none"
                       style="position: absolute; right: 1.2rem; top: 0.8rem;" onclick="show_password()"></i>
                    <small class="text-danger">password digunakan untuk login</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Nama</div>
                <div class="col-lg-10">
                    <input type="text" name="nama" id="nama"
                           class="form-control" value="{{old('nama')}}" required>
                    <small class="text-muted">nama lengkap anggota polsus</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Tempat Lahir</div>
                <div class="col-lg-10">
                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                           class="form-control" value="{{ old('tempat_lahir') }}" required>
                    <small class="text-muted">tempat lahir anggota polsus; contoh: Surabaya, Jawa Timur</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Tanggal Lahir</div>
                <div class="col-lg-10">
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                           class="form-control" value="{{ old('tanggal_lahir') }}"
                           required>
                    <small class="text-muted">tanggal lahir anggota polsus</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Golongan</div>
                <div class="col-lg-10">
                    <select required class="form-control" name="golongan" id="golongan">
                        <option value="">Pilih salah satu golongan di bawah</option>
                        <option value="1"
                                @if(old('golongan') == "1") selected @endif>Golongan I</option>
                        <option value="2"
                                @if(old('golongan') == "2") selected @endif>Golongan II</option>
                        <option value="3"
                                @if(old('golongan') == "3") selected @endif>Golongan III</option>
                        <option value="4"
                                @if(old('golongan') == "4") selected @endif>Golongan IV</option>
                    </select>
                    <small class="text-muted">golongan  anggota polsus</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Pangkat</div>
                <div class="col-lg-10">
                    <select required class="form-control" name="pangkat" id="pangkat">
                        <option value="">Silahkan pilih golongan terlebih dahulu</option>
                    </select>
                    <small class="text-muted">pangkat anggota polsus</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Ruang</div>
                <div class="col-lg-10">
                    <input readonly required type="text" name="ruang" id="ruaang"
                           class="form-control" value="{{old('ruang') ?? '-'}}">
                    <small class="text-muted">ruang akan otomatis terisi setelah memilih pangkat</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">NIP</div>
                <div class="col-lg-10">
                    <input required type="text" name="no_nip" id="no_nip"
                           class="form-control" value="{{old('no_nip')}}">
                    <small class="text-muted">NIP anggota polsus</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">No Handphone Aktif</div>
                <div class="col-lg-10">
                    <input required type="number" name="no_hp" id="no_hp"
                           class="form-control" value="{{old('no_hp')}}">
                    <small class="text-muted">nomor handphone anggota polsus yang masih aktif</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Jabatan</div>
                <div class="col-lg-10">
                    <input type="text" name="jabatan" id="jabatan" class="form-control"
                           value="{{old('jabatan')}}" required>
                    <small class="text-muted">jabatan anggota polsus</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Instansi</div>
                <div class="col-lg-10">
                    @if($isAdmin || $operatorPolda)
                        <select required class="form-control" name="instansi_id" id="instansi">
                            <option value="">Pilih salah satu instansi di bawah</option>
                            @foreach($instansis as $instansi)
                                <option value="{{$instansi->id}}"
                                        @if(old('instansi_id') == $instansi->id) selected @endif>{{$instansi->instansi}}</option>
                            @endforeach
                        </select>
                    @else
                        <select required class="form-control" name="instansi_id" id="instansi" readonly>
                            <option value="{{auth()->user()?->polsus->instansi_id}}">{{auth()->user()?->polsus?->instansi?->instansi}}</option>
                        </select>
                    @endif
                    <small class="text-muted">instansi anggota polsus ditugaskan</small>
                </div>
            </div>
            <div class="row form-group @if($isAdmin || $operatorPolda) d-none jenis_polsus_berdasarkan_instansi @endif">
                <div class="col-lg-2">Jenis Polsus</div>
                <div class="col-lg-10">
                    @if($isAdmin || $operatorPolda)
                        <select required class="form-control" name="jenis_polsus" id="jenis_polsus">
                        <option value="polsus_karantina_ikan"
                            @if(old('jenis_polsus') == "polsus_karantina_ikan") selected @endif>Polsus Karantina Ikan</option>
                        <option value="polsus_pwp3k"
                            @if(old('jenis_polsus') == "polsus_pwp3k") selected @endif>Polsus PWP3K</option>
                        <option value="polhut_lhk"
                            @if(old('jenis_polsus') == "polhut_lhk") selected @endif>Polhut LHK</option>
                        <option value="polsuspas"
                            @if(old('jenis_polsus') == "polsuspas") selected @endif>Polsuspas</option>
                        <option value="polsus_cagar_budaya"
                            @if(old('jenis_polsus') == "polsus_cagar_budaya") selected @endif>Polsus Cagar Budaya</option>
                        <option value="polsus_barantan"
                            @if(old('jenis_polsus') == "polsus_barantan") selected @endif>Polsus Barantan</option>
                        <option value="polsus_barantin"
                            @if(old('jenis_polsus') == "polsus_barantin") selected @endif>Polsus Barantin</option>
                        <option value="polsus_dishubdar"
                            @if(old('jenis_polsus') == "polsus_dishubdar") selected @endif>Polsus Dishubdar</option>
                        <option value="polhut_perhutani"
                            @if(old('jenis_polsus') == "polhut_perhutani") selected @endif>Polhut Perhutani</option>
                        <option value="polsuska"
                            @if(old('jenis_polsus') == "polsuska") selected @endif>PolsusKa</option>
                        <option value="polsus_satpol_pp"
                            @if(old('jenis_polsus') == "polsus_satpol_pp") selected @endif>Polsus Satpol PP</option>
                    </select>
                    @else
                        @if(auth()->user()->polsus->instansi_id == '5')
                            <select required class="form-control" name="jenis_polsus" id="jenis_polsus">
                                <option value="polsus_barantin">Polsus Barantin</option>
                                <option value="polsus_barantan">Polsus Barantan</option>
                            </select>
                        @else
                            <select required class="form-control" name="jenis_polsus" id="jenis_polsus" readonly>
                                <option value="{{auth()->user()?->polsus->jenis_polsus}}">{{ucwords(implode(' ', explode('_', auth()->user()?->polsus->jenis_polsus)))}}</option>
                            </select>
                        @endif
                    @endif
                    <small class="text-muted">jenis polsus anggota</small>
                </div>
            </div>
            @if($isAdmin || $operatorPolda)
                <div class="row form-group d-none kategori-polsus">
                    <div class="col-lg-2 nama-kategori"></div>
                    <div class="col-lg-10">
                        <input type="text" name="kategori" id="kategori" class="form-control"
                               value="{{old('kategori')}}">
                        <small class="text-muted kategori-polsus-small-text"></small>
                    </div>
                </div>
            @else
                @if(auth()->user()->polsus->instansi_id == "2")
                    <div class="row form-group">
                        <div class="col-lg-2">Nama Balai</div>
                        <div class="col-lg-10">
                            <input type="text" name="kategori" id="kategori" class="form-control"
                                   value="{{old('kategori')}}">
                            <small class="text-muted kategori-polsus-small-text">Nama Balai Kerja Polsus</small>
                        </div>
                    </div>
                @elseif(auth()->user()->polsus->instansi_id == "3")
                    <div class="row form-group">
                        <div class="col-lg-2">Nama Lapas</div>
                        <div class="col-lg-10">
                            <input type="text" name="kategori" id="kategori" class="form-control"
                                   value="{{old('kategori')}}">
                            <small class="text-muted kategori-polsus-small-text">Nama Lapas Kerja Polsus</small>
                        </div>
                    </div>
                @elseif(auth()->user()->polsus->instansi_id == "7")
                    <div class="row form-group">
                        <div class="col-lg-2">Nama Divisi Regional</div>
                        <div class="col-lg-10">
                            <input type="text" name="kategori" id="kategori" class="form-control"
                                   value="{{old('kategori')}}">
                            <small class="text-muted kategori-polsus-small-text">Nama Kesatuan Pemangkuan Hutan Kerja Polsus</small>
                        </div>
                    </div>
                @elseif(auth()->user()->polsus->instansi_id == "8")
                    <div class="row form-group">
                        <div class="col-lg-2">Nama Daerah Operasi</div>
                        <div class="col-lg-10">
                            <input type="text" name="kategori" id="kategori" class="form-control"
                                   value="{{old('kategori')}}">
                            <small class="text-muted kategori-polsus-small-text">Nama Daerah Operasi Kerja Polsus</small>
                        </div>
                    </div>
                @endif
            @endif
            <div class="form-group">Alamat Instansi</div>
            <div class="indent pl-3">
                <div class="row form-group">
                    <div class="col-lg-2">Provinsi</div>
                    <div class="col-lg-10">
                        <select name="provinsi" id="provinsi" class="form-control"
                                value="{{old('provinsi')}}" required>
                            <option value="">pilih provinsi</option>
                            @foreach($province as $id =>$name)
                                <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
{{--                        jika admin / kl pusat bisa memilih provinsi --}}
{{--                        @if(!$idProv)--}}
{{--                            <select name="provinsi" id="provinsi" class="form-control"--}}
{{--                                    value="{{old('provinsi')}}" required>--}}
{{--                                <option value="">pilih provinsi</option>--}}
{{--                                @foreach($province as $id =>$name)--}}
{{--                                    <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        @else--}}
{{--                            <select name="provinsi" id="provinsi" class="form-control" required readonly>--}}
{{--                                <option value="{{$idProv['name']}}" id="{{$idProv['id']}}">--}}
{{--                                    {{ $idProv['name'] }}--}}
{{--                                </option>--}}
{{--                            </select>--}}
{{--                        @endif--}}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">Kota/Kabupaten</div>
                    <div class="col-lg-10">
                        <select name="kabupaten" id="kabupaten" class="form-control"
                                value="{{old('kabupaten')}}" required>
                            <option value="" selected>pilih kota/kabupaten</option>
                            <option value="" disabled>pilih provinsi terlebih dahulu</option>
                        </select>
{{--                        @if(!$idKabupaten)--}}
{{--                            <select name="kabupaten" id="kabupaten" class="form-control"--}}
{{--                                    value="{{old('kabupaten')}}" required>--}}
{{--                                <option value="" selected>pilih kota/kabupaten</option>--}}
{{--                                <option value="" disabled>pilih provinsi terlebih dahulu</option>--}}
{{--                            </select>--}}
{{--                        @else--}}
{{--                            <select name="kabupaten" id="kabupaten" class="form-control" required readonly>--}}
{{--                                <option value="{{$idKabupaten['name']}}" id="{{$idKabupaten['id']}}">--}}
{{--                                    {{ $idKabupaten['name'] }}--}}
{{--                                </option>--}}
{{--                            </select>--}}
{{--                        @endif--}}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">Kecamatan</div>
                    <div class="col-lg-10">
                        <select name="kecamatan" id="kecamatan" class="form-control"
                                value="{{old('kecamatan')}}" required>
                            <option value="" selected>pilih kecamatan</option>
                            <option value="" disabled>pilih kota/kabupaten terlebih dahulu</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">Kelurahan/Desa</div>
                    <div class="col-lg-10">
                        <select name="desa" id="desa" class="form-control"
                                value="{{old('desa')}}" required>
                            <option value="" selected>pilih kelurahan/desa</option>
                            <option value="" disabled>pilih kecamatan terlebih dahulu</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">Detail Alamat</div>
                    <div class="col-lg-10">
                        <input type="text" name="detail_alamat" id="detail_alamat"
                               class="form-control" value="{{old('detail_alamat')}}" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">RT</div>
                    <div class="col-lg-10">
                        <input type="number" name="rt" id="rt" class="form-control"
                               value="{{old('rt')}}" placeholder="contoh: 004 | (Opsional)"
                               maxlength="3">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">RW</div>
                    <div class="col-lg-10">
                        <input type="number" name="rw" id="rw" class="form-control"
                               value="{{old('rw')}}" placeholder="contoh: 004 | (Opsional)"
                               maxlength="3">
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Jenjang Diklat Polsus</div>
                <div class="col-lg-10">
                    <select name="jenjang_diklat" id="jenjang_diklat" class="form-control"
                            value="{{old('jenjang_diklat')}}" required>
                        <option value=''>Pilih salah satu dari opsi di bawah</option>
                        <option @if(old('jenjang_diklat') == 'reguler') selected @endif
                                value="reguler">Diklat Reguler</option>
                        <option @if(old('jenjang_diklat') == 'khusus_tni_polri') selected @endif
                                value="khusus_tni_polri">Diklat Khusus Pensiunan TNI/POLRI</option>
                        <option @if(old('jenjang_diklat') == 'khusus_pejabat_kl') selected @endif
                                value="khusus_pejabat_kl">Diklat Khusus Pejabat di Lingkungan K/L</option>
                        <option @if(old('jenjang_diklat') == 'belum') selected @endif
                                value="belum">Belum mengikuti Diklat Polsus</option>
                    </select>
                    <small class="text-muted">jenjang diklat anggota polsus</small>
                </div>
            </div>
            <div class="d-none form-lengkap-ijazah">
                <div class="indent pl-3">
                    <div class="row form-group">
                        <div class="col-lg-2">No Ijazah</div>
                        <div class="col-lg-10">
                            <input type="text" name="no_ijazah" id="no_ijazah"
                                   class="form-control" value="{{old('no_ijazah')}}">
                            <small class="text-muted">nomor ijazah anggota polsus</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">Tempat Dikeluarkan Ijazah</div>
                        <div class="col-lg-10">
                            <input type="text" name="tempat_dikeluarkan_ijazah"
                                   id="tempat_dikeluarkan_ijazah" class="form-control"
                                   value="{{old('tempat_dikeluarkan_ijazah')}}">
                            <small class="text-muted">tempat ijazah anggota ijazah dikeluarkan</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">Tanggal Dikeluarkannya Ijazah</div>
                        <div class="col-lg-10">
                            <input type="date" name="tanggal_dikeluarkan_ijazah"
                                   id="tanggal_dikeluarkan_ijazah" class="form-control"
                                   value="{{old('tanggal_dikeluarkan_ijazah')}}">
                            <small class="text-muted">tanggal ijazah anggota ijazah dikeluarkan</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Apakah memiliki KTA</div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input value="{{old("kepemilikan_kta") ?? 1}}" type="radio"
                                   name="kepemilikan_kta" id="punya_kta"
                                   class="form-check-input">
                            <label class="form-check-label" for="punya_kta">Iya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input value="{{old("kepemilikan_kta") ?? 0}}" type="radio"
                                   name="kepemilikan_kta" id="tidak_punya"
                                   class="form-check-input">
                            <label class="form-check-label" for="tidak_punya">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none form-lengkap-kta">
                <div class="indent pl-3">
                    <div class="row form-group">
                        <div class="col-lg-2">No. SKEP Pengangkat Anggota Polsus</div>
                        <div class="col-lg-10">
                            <input type="text" name="no_skep" id="no_skep"
                                   class="form-control" value="{{old('no_skep')}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">No KTA Polsus</div>
                        <div class="col-lg-10">
                            <input type="text" name="no_kta" id="no_kta"
                                   class="form-control" value="{{old('no_kta')}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">Pejabat yang Mengeluarkan KTA</div>
                        <div class="col-lg-10">
                            <input type="text"
                                   id="pejabat_yang_mengeluarkan_kta"
                                   name="pejabat_yang_mengeluarkan_kta"
                                   class="form-control"
                                   value="{{old('pejabat_yang_mengeluarkan_kta')}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">KTA berlaku hingga</div>
                        <div class="col-lg-10">
                            <input type="date" name="expired_kta"
                                   id="expired_kta" class="form-control"
                                   value="{{ old('expired_kta') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">Memiliki izin pegang Senpi dan Amunisi</div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input value="{{old("memiliki_izin_senpi_amunisi") ?? 1}}" type="radio"
                                   name="memiliki_izin_senpi_amunisi" id="punya_izin_senpi"
                                   class="form-check-input">
                            <label class="form-check-label" for="punya_izin_senpi">Iya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input value="{{old("memiliki_izin_senpi_amunisi") ?? 0}}" type="radio"
                                   name="memiliki_izin_senpi_amunisi" id="tidak_punya_izin_senpi"
                                   class="form-check-input">
                            <label class="form-check-label" for="tidak_punya_izin_senpi">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none form-lengkap-izin-senpi-amunisi">
                <div class="indent pl-3">
                    <div class="row form-group">
                        <div class="col-lg-2">No. Izin pegang Senpi dan Amunisi</div>
                        <div class="col-lg-10">
                            <input type="text"
                                name="no_izin_pegang_senpi"
                                id="no_izin_pegang_senpi"
                                class="form-control"
                                value="{{ old('no_izin_pegang_senpi') }}">
                            <small class="text-muted">nomor izin pegang senjata api dan amunisi yang dimiliki anggota polsus (jika punya)</small>
                        </div>
                        </div>
                    <div class="row form-group">
                        <div class="col-lg-2">Pejabat yang Mengeluarkan Izin Pegang Senpi dan Amunisi</div>
                        <div class="col-lg-10">
                            <input type="text"
                                name="pejabat_yang_mengeluarkan_izin_pegang_senpi"
                                id="pejabat_yang_mengeluarkan_izin_pegang_senpi"
                                class="form-control"
                                value="{{ old('pejabat_yang_mengeluarkan_izin_pegang_senpi') }}">
                            <small class="text-muted">pejabat yang mengeluarkan izin pegang senjata api</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">Masa Belaku Izin Pegang Senpi dan Amunisi</div>
                        <div class="col-lg-10">
                            <input type="date" name="expired_izin_pegang"
                                id="expired_izin_pegang" class="form-control"
                                value="{{old('expired_izin_pegang')}}">
                            <small class="text-muted">masa berlaku izin senjata api dan amunisi yang dimiliki anggota polsus (jika punya)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-2">Kelengkapan Perorangan</div>
                <div class="col-lg-10">
                    <textarea name="kelengkapan_perorangan"
                            id="kelengkapan_perorangan"
                            class="form-control"
                            cols="30"
                            rows="6"
                            placeholder="Isi dengan '-' jika tidak ada kelengkapan tambahan"
                            required>{{old("kelengkapan_perorangan")}}</textarea>
                </div>
            </div>
            <div class="mt-4 form-group d-flex justify-content-between justify-content-md-end">
                <button class="btn btn-danger mx-md-2" onclick="window.history.back()">Batal</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formatRegistrasiPolsusModal" tabindex="-1" role="dialog" aria-labelledby="formatRegistrasiPolsusModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unduh Format Registrasi Polsus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <a class="btn btn-secondary text-white" href="{{route('register-polsus.template-excel', 'anggota')}}">
                            Format Anggota Polsus
                        </a>
                    </div>
                    <div>
                        <a class="btn btn-info text-white" href="{{route('register-polsus.template-excel', 'operator')}}">
                            Format Operator Polsus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.select2')
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script src="{{asset('js/admin/sislap/lapsubjar/sipolsus/data-polsus.js')}}"></script>
    <script>
        const password = document.querySelector("#password");
        const eyeOpen = document.querySelector(".fa-eye");
        const eyeClose = document.querySelector(".fa-eye-slash");

        const hide_password = () => {
            password.type = "text";
            eyeOpen.classList.remove('d-none')
            eyeClose.classList.add('d-none')
        };

        const show_password = () => {
            password.type = "password";
            eyeOpen.classList.add('d-none')
            eyeClose.classList.remove('d-none')
        };


        FilePond.parse(document.body);
        const pond = FilePond.create(
            document.querySelector('#photo'),
            {
                labelIdle: `Upload foto polsus: <span class="filepond--label-action">cari file</span>`,
                storeAsFile: true
            }
        );

        $(document).ready(function() {
            $(window).keydown(function(event) {
                if(event.keyCode == 13) event.preventDefault();
            });
        });

        buildSelect2Search({
            placeholder: 'pilih profil sebagai',
            url: route('role.select2', {'type-page-request' : 'tambah-polsus-page'}),
            minimumInputLength: 0,
            selector: [
                { id: $('#select-role') },
                { id: $('#select-role-import') }
            ],
            query: function (params) {
                return { alias: params.term }
            }
        });

        const provinsi  = $('#provinsi')
        const kabupaten = $('#kabupaten')
        const kecamatan = $('#kecamatan')
        const desa      = $('#desa')

        provinsi.on('change', () => {
            setOptionAlamat(provinsi, route('alamat-kota'), kabupaten, 'kota/kabupaten')
        })

        kabupaten.on('change', () => {
            setOptionAlamat(kabupaten, route('alamat-kecamatan'), kecamatan, 'kecamatan')
        })

        kecamatan.on('change', () => {
            setOptionAlamat(kecamatan, route('alamat-desa'), desa, 'kelurahan/desa')
        })

        $('input[name="kepemilikan_kta"]').on('change', function(el) {
            const form_lengkap_kta = document.querySelector('.form-lengkap-kta')
            if(el.target.value == 1) {
                form_lengkap_kta.classList.remove('d-none');
            } else {
                form_lengkap_kta.classList.add('d-none');
            }
        })

        document.querySelector('select[name="instansi_id"]')
        .addEventListener('change', function(el) {
            const instansi = el.target.value
            if (instansi == "") return;

            document.querySelector('.jenis_polsus_berdasarkan_instansi').classList.remove('d-none')

            for (let el of document.querySelector('select[name="jenis_polsus"]').children) {
                el.classList.add('d-none');
                el.removeAttribute('selected');
            }

            for (let polsus of mapInstansiPolsus[instansi]) {
                document.querySelector(`option[value="${polsus}"]`).classList.remove('d-none');
                document.querySelector(`option[value="${polsus}"]`).setAttribute('selected', true)
            }

            const kategori_polsus = document.querySelector('.kategori-polsus')
            const nama_kategori = document.querySelector('.nama-kategori')
            const small_text_kategori = document.querySelector('.kategori-polsus-small-text')
            if( mapNamaKategoriPolsus[instansi] ) {
                kategori_polsus.classList.remove('d-none')
                nama_kategori.innerHTML = mapNamaKategoriPolsus[instansi]
                small_text_kategori.innerHTML = `${mapNamaKategoriPolsus[instansi]} Kerja Polsus`
            } else {
                kategori_polsus.classList.add('d-none')
            }
        })
        $('input[name="memiliki_izin_senpi_amunisi"]').on('click', function(el) {
            const form_lengkap_izin_pegang = document.querySelector('.form-lengkap-izin-senpi-amunisi')
            if(el.target.value == 1) {
                form_lengkap_izin_pegang.classList.remove('d-none');
            } else {
                form_lengkap_izin_pegang.classList.add('d-none');
            }
        })

        $('select[name="jenjang_diklat"]').on('change', el => {
            const form_lengkap_ijazah = document.querySelector('.form-lengkap-ijazah')
            if(el.target.value != 'belum') {
                form_lengkap_ijazah.classList.remove('d-none');
            } else {
                form_lengkap_ijazah.classList.add('d-none');
            }
        })

        $('select[name="golongan"]').on('change', el => {
            $('input[name="ruang"]').val('-')
            const pangkatForm = document.querySelector('#pangkat')

            const pangkat = {
                '1': [
                    {
                        'pangkat': 'Juru Tingkat I',
                        'ruang': 'D'
                    },
                    {
                        'pangkat': 'Juru',
                        'ruang': 'C'
                    },
                    {
                        'pangkat': 'Juru Muda Tingkat I',
                        'ruang': 'B'
                    },
                    {
                        'pangkat': 'Juru Muda',
                        'ruang': 'A'
                    }
                ],
                '2': [
                    {
                        'pangkat': 'Pengatur Tingkat I',
                        'ruang': 'D'
                    },
                    {
                        'pangkat': 'Pengatur',
                        'ruang': 'C'
                    },
                    {
                        'pangkat': 'Pengatur Muda Tingkat I',
                        'ruang': 'B'
                    },
                    {
                        'pangkat': 'Pengatur Muda',
                        'ruang': 'A'
                    }
                ],
                '3': [
                    {
                        'pangkat': 'Penata Tingkat I',
                        'ruang': 'D'
                    },
                    {
                        'pangkat': 'Penata',
                        'ruang': 'C'
                    },
                    {
                        'pangkat': 'Penata Muda Tingkat I',
                        'ruang': 'B'
                    },
                    {
                        'pangkat': 'Penata Muda',
                        'ruang': 'A'
                    }
                ],
                '4': [
                    {
                        'pangkat': 'Pembina Utama',
                        'ruang': 'E'
                    },
                    {
                        'pangkat': 'Pembina Utama Muda',
                        'ruang': 'C'
                    },
                    {
                        'pangkat': 'Pembina Tingkat I',
                        'ruang': 'B'
                    },
                    {
                        'pangkat': 'Pembina',
                        'ruang': 'A'
                    }
                ],
            }

            if(el.target.value) {
                $(pangkatForm).html(`
                    <option value="">Silahkan pilih pangkat di bawah</option>
                `)
                pangkat[el.target.value].forEach(arr => {
                    $(pangkatForm).append(`
                        <option value="${arr['pangkat']}_${arr['ruang']}"
                        @if(old('pangkat') == "1") selected @endif>${arr['pangkat']}</option>
                    `)
                })
            } else {
                $(pangkatForm).html(`
                    <option value="">Silahkan pilih golongan terlebih dahulu</option>
                `)
            }
        })

        $('#pangkat').on('change', el => {
            $('input[name="ruang"]').val(el.target.value.split('_')[1])
        })

        const trigerKabupaten = () => {
            setOptionAlamat(provinsi, route('alamat-kota'), kabupaten, 'kota/kabupaten')
        }

        const trigerKecamatan = () => {
            setOptionAlamat(kabupaten, route('alamat-kecamatan'), kecamatan, 'kecamatan')
        }

        $(document).ready(function() {
            @if($klProvinsi || $operatorPolda) trigerKabupaten() @endif
            @if($klKabupaten) trigerKecamatan() @endif
        })

    </script>
@endsection
@endcan
