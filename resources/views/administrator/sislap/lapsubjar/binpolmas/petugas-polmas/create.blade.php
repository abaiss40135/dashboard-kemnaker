@extends('templates.admin-lte.admin', [
    'title' => 'Laporan Data Petugas Polmas Model Wilayah (Polisi RW/Dusun/Sejenisnya) dan Model Kawasan'
])
@section('content')
    <div class="card">
        <form action="{{ route('petugas-polmas-kawasan-wilayah.store-form') }}"
            method="POST"
            id="form-pranata"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="polda">Polda</label>
                        <div class="col-lg-10">
                            <input type="text"
                                   name="polda"
                                   id="polda"
                                   class="form-control"
                                   required
                                   maxlength="255"
                                   placeholder="Contoh: POLDA JATENG"
                                   value="{{ auth()->user()?->personel?->polda }}"
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
                                   maxlength="255"
                                   placeholder="Contoh: POLRESTA SEMARANG"
                                   value="{{ auth()->user()?->personel?->polres }}"
                                   @if(auth()->user()?->personel?->polres) readonly @endif
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="jumlah_rw">Jumlah RW/Dusun/Sejenisnya</label>
                        <div class="col-lg-10">
                            <input type="number"
                                   name="jumlah_rw"
                                   id="jumlah_rw"
                                   class="form-control"
                                   required
                                   maxlength="255">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="jumlah_petugas_wilayah">Jumlah Petugas Polmas Model Wilayah <br>(Polisi RW/Dusun/Sejenisnya)</label>
                        <div class="col-lg-10">
                            <input type="number"
                                   name="jumlah_petugas_wilayah"
                                   id="jumlah_petugas_wilayah"
                                   class="form-control"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="jumlah_petugas_kawasan">Jumlah Petugas Polmas Model Kawasan</label>
                        <div class="col-lg-10">
                            <input type="number"
                                   name="jumlah_petugas_kawasan"
                                   id="jumlah_petugas_kawasan"
                                   class="form-control"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="jumlah_sdh_pelatihan_polmas">Jumlah Petugas Polmas Yang Sudah Mengikuti Pelatihan</label>
                        <div class="col-lg-10">
                            <input type="number"
                                   name="jumlah_sdh_pelatihan_polmas"
                                   id="jumlah_sdh_pelatihan_polmas"
                                   class="form-control"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="lampiran_file">Lampiran File<br><small>*Input file asli sprin Word/PDF (bukan scan dari sprin)</small></label>
                        <div class="col-lg-10">
                            <input type="file"
                                   name="lampiran_file"
                                   id="lampiran_file"
                                   required
                                   value="{{old('lampiran_file')}}"
                                   accept="application/pdf,docx,doc,xlsx,xls"
                            >
                        </div>
                    </div>
                </div>
                <div class="flex-row d-flex justify-content-end">
                    <button type="submit"
                            class="btn btn-success"
                            id="submit"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>

@endsection
