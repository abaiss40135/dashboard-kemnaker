@if(auth()->check() && ( role('bhabinkamtibmas') || role('bhabinkamtibmas_pensiun') ))
    @push('scripts')
        <script>
            // jika user baru login maka splash screen ditampilkan
            if (localStorage.getItem('login') == 'false' && "{{ auth()->user()->lokasiPenugasans()->count() > 0 }}") {
                const body = document.querySelector('body')
                body.innerHTML += `
                    <div class="splash">
                        <div class="card">
                            <div class="card-header {{ $configData['navbarColor'] }}">
                                <i class="fas fa-times close" onclick="closeSplash()"></i>
                                <h6 class="text-center text-white text-uppercase">selamat datang</h6>
                            </div>
                            <div class="card-body">
                                <div class="wave1">
                                    <div class="wave2">
                                        <div class="wave3 d-flex justify-content-center align-items-center">
                                            <div class="wave4">
                                                <img src="{{ $personel['foto'] ?? \App\Helpers\Constants::PLACEHOLDER_IMG }}" width="auto" alt="foto-user" srcset="" class="rounded-circle img-splash">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-center mt-3" style=" font-weight: bold; color: #1E4588;">{{ $personel['nama'] ?? '' }} </h6>
                                <p style="font-size: 14px; text-align: center; color: #1E4588;">
                                    {{ $personel['instansi'] ?? "" }}/{{ $personel['nomor'] ?? "" }}
                                </p>
                                <p style="font-size: 14px; text-align: center; color: #1E4588;">
                                    Tanggal Lahir: {{ $personel['tanggal_lahir'] ?? "" }}<br>
                                            No Telepon: {{ $personel['no_hp'] ?? "" }}</p>
                                        <p style="font-size: 14px; text-align: center; font-weight: 500; color: #1E4588;">
                                            {{ auth()->user()->lokasiPenugasans()->first()->lokasi ?? $personel['instansi'] }}
                                </p>
                                <br class="d-none d-md-block">
                            </div>
                        </div>
                    </div>
                    <!-- penghalang -->
                    <div class="penghalang">
                    </div>`
            }
                // jika sudah login 1 kali maka set Item localstorage 'login'  menjadi true
                localStorage.setItem('login', true)
        </script>
        <!-- end splash -->
    @endpush

@elseif(auth()->check() && role('satpam'))
    @push('scripts')
         <script>
            // jika user baru login maka splash screen ditampilkan
            if (localStorage.getItem('login') == 'false') {
                const body = document.querySelector('body')
                body.innerHTML += `
                    <div class="splash " style="width:45%">
                        <div class="card ">
                            <div class="card-header {{ $configData['navbarColor'] }}">
                                <i class="fas fa-times close" onclick="closeSplash()"></i>
                                <h6 class="text-center text-white text-uppercase">selamat datang</h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="wave1">
                                    <div class="wave3 d-flex justify-content-center align-items-center">
                                        <div class="wave4">
                                            <img src="{{ $personel['foto'] }}" width="auto" alt="foto-user" srcset="" class="rounded-circle img-splash">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="mt-3" style="color: #1E4588;"><b>{{ $personel['nama'] }}</b></h6>

                                <p style="font-size: 14px; color: #1E4588;">{{ $personel['instansi'] ?? "" }}</p>
                                <p>{{ $personel['nomor'] ?? "" }}</p>

                                <p style="font-size: 14px; color: #1E4588;">Tanggal Lahir: {{ $personel['tanggal_lahir'] ?? "" }}</p>
                                <p>No Telepon: {{ $personel['no_hp'] ?? "" }}</p>

                                <p style="font-size: 14px; font-weight: 500; color: #1E4588;"
                                >{{ auth()->user()->lokasiPenugasans()->first()->lokasi ?? $personel['lokasi'] }}</p>

                                <br class="d-none d-md-block">
                            </div>
                        </div>
                    </div>
                    <!-- penghalang -->
                    <div class="penghalang">
                </div>`
            }
                // jika sudah login 1 kali maka set Item localstorage 'login'  menjadi true
                localStorage.setItem('login', true)
        </script>
    @endpush


@endif
