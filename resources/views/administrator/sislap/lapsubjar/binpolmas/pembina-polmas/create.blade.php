@extends('templates.admin-lte.admin', [
    'title' => 'Laporan Pembina Polmas'
])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pembina-polmas.store-form') }}"
                method="POST"
                enctype="multipart/form-data"
                onsubmit="disableSubmitButtonTemporarily(this)">
                @csrf
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
                        <label class="col-lg-2" for="jumlah_pembina_polda">Jumlah Pembina Polda</label>
                        <div class="col-lg-10">
                            <input type="number"
                                name="jumlah_pembina_polda"
                                id="jumlah_pembina_polda"
                                class="form-control"
                                required
                                value="{{old('jumlah_pembina_polda')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-lg-2" for="jumlah_pembina_polres">Jumlah Pembina Polres</label>
                        <div class="col-lg-10">
                            <input type="number"
                                name="jumlah_pembina_polres"
                                id="jumlah_pembina_polres"
                                class="form-control"
                                required
                                value="{{old('jumlah_pembina_polres')}}">
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
