
@extends('templates.core.main')
@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/bhabin/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bhabin/laporan/dds/dds-form.css') }}">
@endsection
@section('mainComponent')

<br>
<br>
<br>
<br>

<main class="mb-3 mt-2">
    <div class="container">
        <div class="header p-2 text-white rounded" style="background-color: #1E4588">
            <h5 class="m-0">
                Update Akun Satpam
            </h5>
        </div>

        @foreach($errors->all() as $message)
            <div class="bg-danger text-white p-2">
                {{ $message }}
            </div>
        @endforeach

        <form action="{{ $isFromBujp ? route('transaksi-satpam.update-satpam', $satpam->id) : route('master-satpam.update', $satpam->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row">
                {{-- nama --}}
                <div class="col-md-6 mt-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                        id="nama" name="nama" value="{{ old('nama') ?? $satpam->nama }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- jenis kelamin --}}
                <div class="col-md-6 mt-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                            id="laki_laki" value="laki-laki"
                            {{($satpam->jenis_kelamin === 'laki-laki') ? 'checked' : ''}}>
                        <label class="form-check-label" for="laki_laki">Laki - Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                            id="perempuan" value="perempuan"
                            {{($satpam->jenis_kelamin === 'perempuan') ? 'checked' : ''}}>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                </div>
                {{-- nomor KTP --}}
                <div class="col-md-6 mt-3">
                    <label for="no_ktp" class="form-label">No KTP</label>
                    <input type="text" id="no_ktp" name="no_ktp" maxlength="16"
                        value="{{old('no_ktp') ?? $satpam->no_ktp}}"
                        class="form-control @error('no_ktp') is-invalid @enderror">
                    @error('no_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- nomor hp --}}
                <div class="col-md-6 mt-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                        maxlength="15" id="no_hp" name="no_hp"
                        value="{{ old('no_hp') ?? $satpam->no_hp}}">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- tempat lahir --}}
                <div class="col-md-6 mt-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input name="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                        id="tempat_lahir" value="{{ old('tempat_lahir') ?? $satpam->tempat_lahir }}">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- tanggal lahir --}}
                <div class="col-md-6 mt-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        name="tanggal_lahir" id="tanggal_lahir" value="{{old('tanggal_lahir') ?? $satpam->tanggal_lahir}}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- agama --}}
                <div class="col-md-6 mt-3">
                    <label for="agama" class="form-label">Agama</label>
                    <div>
                        <select class="form-select" onchange="lainnya(this , 'agama')"
                            id="agama" name="agama">
                            <option value="" selected disabled> -- Pilih Agama -- </option>
                            <option value="Islam" {{($satpam->agama === 'Islam') ? 'selected' : ''}}>Islam</option>
                            <option value="Kristen" {{($satpam->agama === 'Kristen') ? 'selected' : ''}}>Kristen</option>
                            <option value="Hindu" {{($satpam->agama === 'Hindu') ? 'selected' : ''}}>Hindu</option>
                            <option value="Budha" {{($satpam->agama === 'Budha') ? 'selected' : ''}}>Budha</option>
                            <option value="Katholik" {{($satpam->agama === 'Katholik') ? 'selected' : ''}}>Katholik</option>
                            <option value="Konghucu" {{($satpam->agama === 'Konghucu') ? 'selected' : ''}}>Konghucu</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                {{-- provinsi --}}
                <div class="col-md-3 mt-3">
                    <label class="form-label">Provinsi *</label>
                    <select name="provinsi" id="provinsi" class="form-select @error('provinsi') is-invalid @enderror " style="width:100%;">
                        <option selected value="{{$satpam->provinsi}}">{{$satpam->provinsi}}</option>
                        @foreach($province as $id => $name)
                            <option value="{{ $name }}" id="{{ $id }}" {{(old('provinsi') == $name) ? ' selected': ''}}> {{ $name }} </option>
                        @endforeach
                    </select>
                    @error('provinsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- kabupaten/kota --}}
                <div class="col-md-3 mt-3">
                    <label class="form-label">Kabupaten/Kota *</label>
                    <select name="kabupaten" id="kabupaten" class="form-select @error('kabupaten') is-invalid @enderror " style="width:100%" >
                        <option selected value="{{$satpam->kabupaten}}">{{$satpam->kabupaten}}</option>
                    </select>
                    @error('kabupaten')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- kecamatan --}}
                <div class="col-md-3 mt-3">
                    <label class="form-label">Kecamatan *</label>
                    <select name="kecamatan" id="kecamatan" class="form-select  @error('kecamatan') is-invalid @enderror" style="width:100%" >
                        <option selected value="{{$satpam->kecamatan}}">{{$satpam->kecamatan}}</option>
                    </select>
                    @error('kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- desa/kelurahan --}}
                <div class="col-md-3 mt-3">
                    <label class="form-label">Desa/Kelurahan *</label>
                    <select name="desa" id="desa" class="form-select @error('desa') is-invalid @enderror">
                        <option selected value="{{$satpam->desa}}">{{$satpam->desa}}</option>
                    </select>
                    @error('desa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- detail alamat --}}
                <div class="col-md-6 mt-3">
                    <label for="detail_alamat" class="form-label">Detail Alamat</label>
                    <input type="text" class="form-control @error('detail_alamat') is-invalid @enderror"
                        id="detail_alamat" name="detail_alamat"
                        value="{{ old('detail_alamat') ?? $satpam->detail_alamat}}">
                    @error('detail_alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- rt --}}
                <div class="col-md-3 col-6 mt-3">
                    <label for="rt" class="form-label">RT </label>
                    <input type="text" class="form-control @error('rt') is-invalid @enderror"
                        id="rt" name="rt" maxlength="3" value="{{ old('rt') ?? $satpam->rt }}">
                    @error('rt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- rw --}}
                <div class="col-md-3 col-6 mt-3">
                    <label for="rw" class="form-label">RW</label>
                    <input type="text" class="form-control @error('rw') is-invalid @enderror"
                        id="rw" name="rw" maxlength="3" value="{{ old('rw') ?? $satpam->rw }}">
                    @error('rw')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- bujp --}}
                <div class="col-md-6 mt-3">
                    <label for="bujp_id" class="form-label">BUJP</label>
                    <select name="bujp_id" id="bujp_id" class="form-select">
                        @foreach ($bujps as $id => $nama_badan_usaha)
                            <option value="{{$id}}"
                                {{($satpam->bujp_id === $id) ? 'selected' : ''}}>
                                {{ $nama_badan_usaha }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- tempat_tugas --}}
                <div class="col-md-6 mt-3">
                    <label for="tempat_tugas" class="form-label">Tempat Tugas</label>
                    <input type="text" class="form-control @error('tempat_tugas') is-invalid @enderror"
                        id="tempat_tugas" name="tempat_tugas"
                        value="{{ old('tempat_tugas') ?? $satpam->tempat_tugas}}">
                    @error('tempat_tugas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- nomor registrasi KTA --}}
                <div class="col-md-6 mt-3">
                    <label for="no_kta" class="form-label">No Registrasi KTA Satpam</label>
                    <input type="text" name="no_kta" id="no_kta"
                        class="form-control @error('no_kta') is-invalid @enderror"
                        value="{{ old('no_kta') ?? $satpam->no_kta}}">
                    @error('no_kta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- tanggal terbit KTA --}}
                <div class="col-md-6 mt-3">
                    <label for="tanggal_terbit_kta" class="form-label">Tanggal Terbit KTA</label>
                    <input type="date" class="form-control @error('tanggal_terbit_kta') is-invalid @enderror"
                        id="tanggal_terbit_kta" name="tanggal_terbit_kta"
                        value="{{ old('tanggal_terbit_kta') ?? $satpam->tanggal_terbit_kta}}">
                    @error('tanggal_terbit_kta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- foto Profile --}}
                <div class="col-md-6 mt-3">
                    <label class="form-label">Foto Profil Satpam</label>
                    <input type="file" name="foto_kta" id="foto_kta" class="form-control">
                </div>
                <div class="mt-4 d-flex justify-content-between justify-content-md-end">
                    <button style="background: #F92B13; color: #fff;" onclick="redirect()">Batal</button>
                    <button style="background: #A0B8E0; color: #1E4588;" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
@section('customjs')
<script src="{{ asset('js/bhabin/laporan/dds/dds-form.js') }}"></script>

<script>
    const redirect = () => {
        event.preventDefault()
        window.history.back();
    }

    $(function(){
        $('#provinsi').on('change' , function(){
            axios.post("{{ route('alamat-kota') }}" , { id : $(this).children(':selected').attr('id') } )
            .then( function(response){
                $('#kabupaten').empty()
                $.each(response.data, function (id, name) {
                    $('#kabupaten').append(`<option value='${name}' id='${id}'> ${name} </option> `)
                })
            })
        })

        $('#kabupaten').on('change' , function(){
            axios.post("{{ route('alamat-kecamatan') }}" , { id : $(this).children(':selected').attr('id') } )
            .then( function(response){
                $('#kecamatan').empty();
                $.each(response.data, function (id, name) {
                    $('#kecamatan').append(`<option value='${name}' id='${id}'> ${name} </option>`)
                })
            })
        })

        $('#kecamatan').on('change' , function(){
            axios.post("{{ route('alamat-desa') }}" , { id : $(this).children(':selected').attr('id') } )
            .then( function(response){
                $('#desa').empty();
                $.each(response.data, function (id, name) {
                    $('#desa').append(`<option value='${name}' id='${id}'> ${name} </option>`)
                })
            })
        })
    })
</script>
@endsection