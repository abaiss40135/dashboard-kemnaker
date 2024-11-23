@php
    $configData = \App\Helpers\AppHelper::applClasses();
@endphp
@push('styles')
    <style>
        .logout p:last-child {
            display: none;
        }

        .active {
            background: #7898CF;
        }

        div > p > a {
            text-decoration: none
        }

        .active p a {
            color: #fff !important;
        }

    </style>
@endpush
<footer class="{{ $configData['footerColor'] }}" style="background: #274C77; padding: 20px 0 0 0;">
    <div class="head">
        <div class="container-footer1">
            @if(!role('publik'))
                <div class="footer-item @if(Str::contains(url()->current(), ['laporan'])) active @endif">
                    <p style="margin-bottom: 0;">
                        <a href="{{ route('laporan.index') }}">Laporan Kegiatan</a>
                    </p>
                </div>
            @endif
            @if (role('publik'))
                <div class="footer-item @if(Str::contains(url()->current(), ['laporan-publik'])) active @endif">
                    <p style="margin-bottom: 0;">
                        <a href="{{ route('laporan-publik.index') }}">
                            Laporan {{ ucwords(auth()->user()->roles()->first(['name'])->name) }}</a>
                    </p>
                </div>
            @endif
            <div class="footer-item @if(Str::contains(url()->current(), ['pusat-informasi'])) active @endif">
                <p style="margin-bottom: 0;">
                    <a href="{{ url('pusat-informasi') }}">
                        Pusat
                        Informasi {{ role('bhabinkamtibmas_pensiun') ? 'bhabinkamtibmas' : ucwords(auth()->user()->roles()->first(['name'])->name) }}</a>
                </p>
            </div>
            @if(role('bhabinkamtibmas'))
                <div class="footer-item">
                    <p style="margin-bottom: 0;">
                        <a href="/pengembangan" style="color: #333;">Lokasi Bhabinkamtibmas</a>
                    </p>
                </div>
                <div class="footer-item">
                    <p style="margin-bottom: 0;">
                        <a href="/pengembangan" style="color: #333;">Kinerja Bhabinkamtibmas</a>
                    </p>
                </div>
                <div
                    class="footer-item d-none d-md-block @if(Str::contains(url()->current(), ['jukrah-bhabin'])) active @endif">
                    <p style="margin-bottom: 0;">
                        <a href="{{ route('jukrah-bhabin') }}">Petunjuk dan Arahan</a>
                    </p>
                </div>
            @endif
        </div>
        <div class="container-footer2">
            @if(role('bhabinkamtibmas'))
                <div
                    class="footer-item d-block d-md-none @if(Str::contains(url()->current(), ['jukrah-bhabin'])) active @endif">
                    <p style="margin-bottom: 0;">
                        <a href="{{ route('jukrah-bhabin') }}">Petunjuk dan Arahan</a>
                    </p>
                </div>
            @endif
            <div class="footer-item @if(Str::contains(url()->current(), ['halo-bhabin'])) active @endif">
                <p style="margin-bottom: 0;">
                    <a href="{{ route('halo-bhabin') }}">Halo Bhabinkamtibmas</a>
                </p>
            </div>
            @if(role('bhabinkamtibmas'))
                <div class="footer-item">
                    <p style="margin-bottom: 0;">
                        <a href="/pengembangan" style="color: #333;">Anev Kamtibmas</a>
                    </p>
                </div>
            @endif
            <div class="footer-item logout d-flex align-items-center justify-content-center" style="background-color: #f25a5a; font-size: 12px;">
                <a href="{{ route('logout') }}" onclick="logout()" class="logout">Logout</a>
                <form id="frm-logout" action="{{ route('logout') }}" method="POST"
                      style="display: none !important; position: fixed; top:0;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <div style="background: #091833; padding: 4px 0;"></div>
    <div style="background: #1E4588; padding: 20px 0; white-space: normal;"
         class="text-center text-white footer-alamat">
        <h5>KORBINMAS BAHARKAM POLRI</h5>
        <p>Jalan Trunojoyo No. 3, Kebayoran Baru, Jakarta Selatan, DKI Jakarta. 12110 (021) 7218141</p>
    </div>

    <div class="signature" style="background:#091833; padding: 10px;">
        <p class="text-center" style="color: #A7BEE5; margin-bottom: 0; font-size: 10px;">
            Copyright © 2021 Kepolisian Negara Republik Indonesia
        </p>
    </div>
</footer>
@push('scripts')
    <script>

    </script>
@endpush
