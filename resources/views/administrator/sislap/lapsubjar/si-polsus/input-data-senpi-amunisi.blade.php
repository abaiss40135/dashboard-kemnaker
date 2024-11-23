@extends('templates.admin-lte.admin', ['title' => 'Input Data Senpi dan Amunisi'])
@section('customcss')
<style>
    .indent {
        border-left: 0.2rem solid hsl(218, 64%, 33%)
    }
    label {
        font-weight: normal !important;
    }
</style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">Form Input Data Senpi dan Amunisi {{ucwords(str_replace('_', ' ', $jenis_polsus))}}</div>
        <div class="card-body">
            <form action="{{ route('input-data-senpi-amunisi.store') }}" method="post">
                @csrf
                <div class="row form-group">
                    <div class="col-lg-2">
                        <label for="instansi">Instansi</label>
                    </div>
                    <div class="col-lg-10">
                        <select readonly required class="form-control" name="instansi_id" id="instansi">
                            <option selected value="{{$instansi->id}}">{{$instansi->instansi}}</option>
                        </select>
                        <small class="text-muted">instansi anggota polsus ditugaskan</small>
                    </div>
                </div>
                <div class="row form-group jenis_polsus_berdasarkan_instansi">
                    <div class="col-lg-2">
                        <label for="jenis_polsus">Jenis Polsus</label>
                    </div>
                    <div class="col-lg-10">
                        <select readonly required class="form-control" name="jenis_polsus" id="jenis_polsus">
                            <option selected value="{{$jenis_polsus}}">{{ucwords(str_replace('_', ' ', $jenis_polsus))}}</option>
                        </select>
                        <small class="text-muted">jenis polsus anggota</small>
                    </div>
                </div>

                @if($jenis_polsus == 'polsuska')
                <div class="row form-group kategori-sub-menu polsuska-daops">
                    <div class="col-lg-2">Daerah Operasi</div>
                    <div class="col-lg-10">
                        <input type="text" name="kategori_daops" id="daops" class="form-control"
                               value="{{old('kategori_daops')}}">
                    </div>
                </div>
                @elseif($jenis_polsus == 'polsuspas')
                <div class="row form-group kategori-sub-menu polsuspas-lapas">
                    <div class="col-lg-2">Nama Lapas</div>
                    <div class="col-lg-10">
                        <input type="text" name="kategori_lapas" id="lapas" class="form-control"
                               value="{{old('kategori_lapas')}}">
                    </div>
                </div>
                @elseif($jenis_polsus == 'polhut_lhk')
                <div class="row form-group kategori-sub-menu klhk-balai">
                    <div class="col-lg-2">Nama Balai</div>
                    <div class="col-lg-10">
                        <input type="text" name="kategori_balai" id="balai" class="form-control"
                               value="{{old('kategori_balai')}}">
                    </div>
                </div>
                @elseif($jenis_polsus == 'polhut_perhutani')
                <div class="row form-group kategori-sub-menu perhutani-unit">
                    <div class="col-lg-2">Nama Divisi Regional</div>
                    <div class="col-lg-10">
                        <input type="text" name="kategori_unit" id="unit" class="form-control"
                               value="{{old('kategori_unit')}}">
                    </div>
                </div>
                @endif

                <div class="form-group">Alamat Instansi</div>
                <div class="indent pl-3">
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label for="provinsi">Provinsi</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="provinsi" id="provinsi" class="form-control"
                                    value="{{old('provinsi')}}" required>
                                <option value="">pilih provinsi</option>
                                @foreach($province as $id =>$name)
                                    <option value="{{ $name }}" id="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label for="kabupaten">Kota/Kabupaten</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="kabupaten" id="kabupaten" class="form-control"
                                    value="{{old('kabupaten')}}" required>
                                <option value="" selected>pilih kota/kabupaten</option>
                                <option value="" disabled>pilih provinsi terlebih dahulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label for="kecamatan">Kecamatan</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="kecamatan" id="kecamatan" class="form-control"
                                    value="{{old('kecamatan')}}" required>
                                <option value="" selected>pilih kecamatan</option>
                                <option value="" disabled>pilih kota/kabupaten terlebih dahulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label for="desa">Kelurahan/Desa</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="desa" id="desa" class="form-control"
                                    value="{{old('desa')}}" required>
                                <option value="" selected>pilih kelurahan/desa</option>
                                <option value="" disabled>pilih kecamatan terlebih dahulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label for="detail_alamat">Detail Alamat</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="text" name="detail_alamat" id="detail_alamat"
                                   class="form-control" value="{{old('detail_alamat')}}" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label for="rt">RT</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="number" name="rt" id="rt" class="form-control"
                                   value="{{old('rt')}}" placeholder="contoh: 004"
                                   maxlength="3" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label for="rw">RW</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="number" name="rw" id="rw" class="form-control"
                                   value="{{old('rw')}}" placeholder="contoh: 004"
                                   maxlength="3" required>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-2">
                        <label for="senpi_genggam">Jumlah Senpi Genggam</label>
                    </div>
                    <div class="col-lg-10">
                        <input required type="number" name="senpi_genggam" id="senpi_genggam"
                               class="form-control" value="{{old('senpi_genggam')}}">
                        <small class="text-muted">jumlah senpi genggam dalam satuan pucuk</small>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">
                        <label for="senpi_panjang">Jumlah Senpi Panjang</label>
                    </div>
                    <div class="col-lg-10">
                        <input required type="number" name="senpi_panjang" id="senpi_panjang"
                               class="form-control" value="{{old('senpi_panjang')}}">
                        <small class="text-muted">jumlah senpi genggam dalam satuan pucuk</small>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">
                        <label for="amunisi_genggam">Jumlah Amunisi Genggam</label>
                    </div>
                    <div class="col-lg-10">
                        <input required type="number" name="amunisi_genggam" id="amunisi_genggam"
                               class="form-control" value="{{old('amunisi_genggam')}}">
                        <small class="text-muted">jumlah senpi genggam dalam satuan butir</small>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-2">
                        <label for="amunisi_panjang">Jumlah Amunisi Panjang</label>
                    </div>
                    <div class="col-lg-10">
                        <input required type="number" name="amunisi_panjang" id="amunisi_panjang"
                               class="form-control" value="{{old('amunisi_panjang')}}">
                        <small class="text-muted">jumlah senpi genggam dalam satuan butir</small>
                    </div>
                </div>
                <div class="mt-4 form-group d-flex justify-content-between justify-content-md-end">
                    <a href="{{route("data-senpi-amunisi." . str_replace("_", "-", $jenis_polsus) . ".index")}}" class="btn btn-danger mx-md-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('customjs')
    <script src="{{asset('js/admin/sislap/lapsubjar/sipolsus/data-polsus.js')}}"></script>
    <script>
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

        document.querySelector('select[name="instansi"]')
        $(document).ready(function() {
            $(window).keydown(function(event) {
                if(event.keyCode == 13) event.preventDefault();
            });
        });

        document.querySelector('select[id="instansi"]')
        .addEventListener('change', function(el) {
            const instansi = el.target.value
            if (instansi == "") return;

            document.querySelector('.jenis_polsus_berdasarkan_instansi').classList.remove('d-none')

            document.querySelectorAll('.kategori-sub-menu').forEach(kategori => {
                kategori.classList.add('d-none')
                $('.kategori-sub-menu').find('input').removeAttr('required')
                $('.kategori-sub-menu').find('input').val('')
            })

            if(instansi == '8') {
                document.querySelector('.polsuska-daops').classList.remove('d-none');
                document.querySelector('#daops').setAttribute('required', 'true')
            } else if(instansi == '7') {
                document.querySelector('.perhutani-unit').classList.remove('d-none');
                document.querySelector('#unit').setAttribute('required', 'true');
            } else if(instansi == '3') {
                document.querySelector('.polsuspas-lapas').classList.remove('d-none');
                document.querySelector('#lapas').setAttribute('required', 'true');
            } else if(instansi == '2') {
                document.querySelector('.klhk-balai').classList.remove('d-none');
                document.querySelector('#balai').setAttribute('required', 'true');
            }

            for (let el of document.querySelector('select[name="jenis_polsus"]').children) {
                el.setAttribute('disabled', 'true')
                el.removeAttribute('selected')
            }

            for (let polsus of mapInstansiPolsus[instansi]) {
                document.querySelector(`option[value="${polsus}"]`).removeAttribute('disabled')
                document.querySelector(`option[value="${polsus}"]`).setAttribute('selected', 'true')
            }
        })
    </script>
@endsection
