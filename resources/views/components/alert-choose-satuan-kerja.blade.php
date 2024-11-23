@if (
    role('bhabinkamtibmas')
    && auth()->user()->lokasiPenugasans()->count()
    && (auth()->user()->personel->satuan_kerja_id == null)
)
    @push('styles')
        @include('assets.css.select2')
    @endpush

    <div
        class="modal fade show"
        id="alertChooseSatuanKerja"
        tabindex="-1"
        aria-hidden="true"
        aria-labelledby="alertChooseSatuanKerjaLabel"
        style="background-color: #63616188; display: block">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-4 pt-5">
                    <div class="d-flex justify-content-center mb-4">
                        <i class="fas fa-exclamation-triangle text-danger fa-4x"></i>
                    </div>
                    <h3 class="text-center"><b>Pilih Satuan Kerja</b></h3>
                    <p class="mt-4">Masukkan Satuan Kerja Anda</p>
                    <form
                        action="{{ route('update-satuan-kerja') }}"
                        method="post"
                        id="formChooseSatuanKerja">
                        @csrf
                        <select
                            name="satuan_kerja_id"
                            id="satuan_kerja_id"
                            class="form-control select2"
                        ></select>
                        @error('satuan_kerja_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @include('assets.js.select2')
        <script>
            buildSelect2Search({
                placeholder: '-- Pilih Satuan Kerja --',
                url: route('satuan-kerja-select2'),
                minimumInputLength: 0,
                selector: [{ id: $('#satuan_kerja_id') }],
                query: function (params) {
                    return {
                        term: params.term,
                    }
                }
            });

            const dismissAlertChooseSatuanKerja = () => {
                document.querySelector('#alertChooseSatuanKerja').style.display = 'none'
            }
        </script>
    @endpush
@endif