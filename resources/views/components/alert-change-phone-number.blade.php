@php
    $user_last_handphone_update = auth()->user()->personel->last_handphone_update;
@endphp
@if (
    role('bhabinkamtibmas')
    && auth()->user()->lokasiPenugasans()->count()
    && (auth()->user()->personel->satuan_kerja !== null)
    && (
        $user_last_handphone_update == null
        || (\Carbon\Carbon::parse($user_last_handphone_update)->diffInDays(now()) > 30)
    )
)
    <div
        class="modal fade show"
        id="alertUpdateHandphoneNumber"
        tabindex="-1"
        aria-hidden="true"
        aria-labelledby="alertUpdateHandphoneNumberLabel"
        style="background-color: #63616188; display: block">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-4 pt-5">
                    <div class="d-flex justify-content-center mb-4">
                        <i class="fas fa-exclamation-triangle text-danger fa-4x"></i>
                    </div>
                    <h3 class="text-center"><b>Perbarui nomor handphone</b></h3>
                    <p class="mt-4">Apakah nomor handphone anda masih <b>{{ auth()->user()->personel->handphone }}</b> ?</p>
                    <div class="d-flex justify-content-end mt-4">
                        <button
                            class="btn btn-default"
                            onclick="dismissAlertUpdateHandphoneNumber()"
                            >Iya</button>
                        <a href="/profile" class="btn btn-danger ml-2">Perbarui</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const dismissAlertUpdateHandphoneNumber = () => {
                document.querySelector('#alertUpdateHandphoneNumber').style.display = 'none'
                axios({
                    method: 'post',
                    url: route('update-phone-number'),
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    console.log(response.data)
                })
                .catch(error => {
                    console.error(error.response.data)
                })
            }
        </script>
    @endpush
@endif