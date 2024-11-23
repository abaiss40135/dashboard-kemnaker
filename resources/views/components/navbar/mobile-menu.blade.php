<nav class="navbar mobile-nav fixed-bottom navbar-expand-sm navbar-white bg-white shadow-lg" id="mobile-nav">
    <div class="container-fluid px-2 mt-2">
        <ul class="navbar-nav w-100 flex-row row-cols-5 justify-content-between text-center nav-text-small">
            <li class="nav-item px-2 col">
                <div class="d-flex flex-column align-items-center">
                    <a href="{{ route(auth()->user()->role()) }}">
                        <img
                            src="{{ asset('img/bhabin/icon/menu/'. $configData['theme']) . (url()->current() === route(auth()->user()->role()) ? '/home-active.svg' : '/home.svg') }}"
                            width="40px" height="40px" alt="home-image">
                        <a class="nav-link p-0 text-primary fw-bold">Home</a>
                    </a>
                </div>
            </li>
            <li class="nav-item px-2 col">
                <div class="d-flex flex-column align-items-center">
                    <a href="{{ url('pusat-informasi') }}">
                        <img
                            src="{{ asset('img/bhabin/icon/menu/'. $configData['theme']) . '/' . (url()->current() == url('pusat-informasi') ? 'pusat-informasi-kamtibmas-active.svg' : 'pusat-informasi-kamtibmas.svg') }}"
                            width="40px"
                            height="40px" alt="home-image">
                        <a class="nav-link p-0 text-primary fw-bold">Baca Informasi Kamtibmas!</a>
                    </a>
                </div>
            </li>
            <li class="nav-item px-2 col">
                @php
                    $route = role('bhabinkamtibmas') ? route('laporan.index') : (role('polisi_rw') ? route('polisi-rw.laporan.index') : route('laporan-publik.index'));
                @endphp
                <div class="d-flex flex-column align-items-center">
                    <a href="{{ $route }}">
                        <img
                            src="{{ asset('img/bhabin/icon/menu/'. $configData['theme']) . (url()->current() === (role('publik') ? route('laporan-publik.index') : route('laporan.index')) ? '/laporan-kegiatan-active.svg' : '/laporan-kegiatan.svg') }}"
                            width="100%" height="40px"
                            alt="home-image">
                        <a class="nav-link p-0 text-primary fw-bold">Laporkan Kegiatan!</a>
                    </a>
                </div>
            </li>
            @if(roles(['bhabinkamtibmas', 'polisi_rw']))
                <li class="nav-item px-2 col">
                    <div class="d-flex flex-column align-items-center">
                        <a href="{{ route('jukrah-bhabin') }}">
                            <img
                                src="{{ asset('img/bhabin/icon/menu/'. $configData['theme']) . '/' . (url()->current() == route('jukrah-bhabin') ? 'jukrah-active.svg': 'jukrah.svg') }}"
                                width="40px" height="40px"
                                alt="home-image">
                            <a class="nav-link p-0 text-primary fw-bold">Jukrah</a>
                        </a>
                    </div>
                </li>
            @endif
            <li class="nav-item px-2 col">
                <div class="d-flex flex-column align-items-center">
                    <a href="{{ route('halo-bhabin') }}">
                        <img
                            src="{{ asset('img/bhabin/icon/menu/'. $configData['theme']) . ( url()->current() === route('halo-bhabin') ? '/halo-bhabinkamtibmas-active.svg' : '/halo-bhabinkamtibmas.svg') }}"
                            width="40px"
                            height="40px" alt="home-image">
                        <a class="nav-link p-0 text-primary fw-bold">Halo Bhabinkamtibmas</a>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
