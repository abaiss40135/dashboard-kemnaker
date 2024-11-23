<div>
    <div class="row">
        <div class="col-sm-12 col-md-5 border-right mb-3">
            <div id="box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid" id="personel_foto"
                         src="{{ $personel['foto_file'] }}"
                         alt="personel picture">
                </div>
                <h3 class="profile-username text-center text-bold" id="header_nama">{{ $personel['nama'] }}</h3>
                <p class="text-center mb-0">
                    <span id="header_pangkat">{{ $personel['pangkat'] }}</span> /
                    <span id="header_nrp">{{ $personel['nrp'] }}</span>
                </p>
                <p class="text-center mb-0" id="header_jabatan">{{ $personel['jabatan'] }}</p>
            </div>
            <hr/>
            <div class="mt-2">
                <div class="text-center">
                    <h3 class="profile-username text-center text-bold">Hak Akses</h3>
                    <div>
                        {!! $hakAkses->join(' ')  !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="horizontal">
                <div class="row">
                    <label class="col-sm-4">Status</label>
                    <div class="col-sm-8">
                        <span class="badge {{ $aktif === 'AKTIF' ? 'badge-success' : 'badge-danger' }}">{{ $aktif }}</span>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-4">TMT Jabatan</label>
                    <p class="col-sm-8" id="personel_tmt_jabatan">: {{ $personel['tmt_jabatan'] }}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Lama Jabatan</label>
                    <p class="col-sm-8" id="personel_lama_jabatan">: {{ $personel['lama_jabatan'] }}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Satuan</label>
                    <p class="col-sm-8" id="personel_satuan">: {{ $personel['satuan'] }}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Satuan I</label>
                    <p class="col-sm-8" id="personel_satuan1">: {{ \Illuminate\Support\Str::beforeLast($personel['satuan1'], '-') }}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Satuan II</label>
                    <p class="col-sm-8" id="personel_satuan2">: {{ \Illuminate\Support\Str::beforeLast($personel['satuan2'], '-') }}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Email</label>
                    <p class="col-sm-8" id="personel_email">: {{ $personel['email']}}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Email Dinas</label>
                    <p class="col-sm-8" id="personel_email_dinas">: {{ $personel['email_dinas'] }}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Tanggal Lahir</label>
                    <p class="col-sm-8" id="personel_tanggal_lahir">: {{ $personel['tanggal_lahir'] }}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Jenis Kelamin</label>
                    <p class="col-sm-8" id="personel_jenis_kelamin">: {{ $personel['jenis_kelamin'] }}</p>
                </div>
                <div class="row">
                    <label class="col-sm-4">Nomor Handphone</label>
                    <p class="col-sm-8" id="personel_handphone">: {{ $personel['handphone'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
