@extends('templates.admin-lte.admin', ['title' => 'Laporan Kegiatan Petugas Polmas'])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kegiatan-petugas-polmas.store-form') }}"
                method="POST"
                enctype="multipart/form-data"
                onsubmit="disableSubmitButtonTemporarily(this)">
                @csrf
                <a href="{{ route('kegiatan-petugas-polmas.template-lampiran') }}" class="btn btn-warning">Unduh Template Lampiran</a>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="polda">Polda</label>
                        <div class="col-lg-10">
                            <input type="text"
                                name="polda"
                                id="polda"
                                class="form-control"
                                required
                                value="{{old('polda') ?? auth()->user()?->personel?->polda }}"
                                maxlength="255"
                                placeholder="Contoh: POLDA JATENG"
                                @if(auth()->user()?->personel?->polda) readonly @endif
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="polres">Polres</label>
                        <div class="col-lg-10">
                            <input type="text"
                                name="polres"
                                id="polres"
                                class="form-control"
                                required
                                value="{{old('polres') ?? auth()->user()?->personel?->polres }}"
                                maxlength="255"
                                placeholder="Contoh: POLRESTA SEMARANG"
                                @if(auth()->user()?->personel?->polres) readonly @endif
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="sambang">Jumlah Sambang/Kunjungan</label>
                        <div class="col-lg-10">
                            <input type="number"
                                name="sambang"
                                id="sambang"
                                class="form-control"
                                required
                                value="{{old('sambang')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="pemecahan_masalah">Pemecahan Masalah Sosial</label>
                        <div class="col-lg-10">
                            <input type="number"
                                name="pemecahan_masalah"
                                id="pemecahan_masalah"
                                class="form-control"
                                required
                                value="{{old('pemecahan_masalah')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="laporan_informasi">Jumlah Laporan Informasi</label>
                        <div class="col-lg-10">
                            <input type="number"
                                name="laporan_informasi"
                                id="laporan_informasi"
                                class="form-control"
                                required
                                value="{{old('laporan_informasi')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="penanganan_perkara_ringan">Jumlah Penanganan Perkara Ringan</label>
                        <div class="col-lg-10">
                            <input type="number"
                                name="penanganan_perkara_ringan"
                                id="penanganan_perkara_ringan"
                                class="form-control"
                                required
                                value="{{old('penanganan_perkara_ringan')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="lampiran">Berkas Lampiran<br><small>*Unduh template diatas</small></label>
                        <div class="col-lg-10">
                            <input type="file"
                                name="lampiran"
                                id="lampiran"
                                required
                                value="{{old('lampiran')}}"
                                accept="application/pdf,docx,doc,xlsx,xls">
                        </div>
                    </div>
                </div>
                <div class="d-flex w-100 justify-content-end">
                    <button type="submit"
                        class="btn btn-success"
                        id="submit"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
