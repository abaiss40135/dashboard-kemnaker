@php
    $configData = \App\Helpers\AppHelper::applClasses();
@endphp

<nav class="{{ $configData['navbarClass'] }} navbar {{ $configData['navbarColor'] }}">
    <div
        class="container d-flex align-items-center justify-content-between"
        id="nav-container"
    >
        <div class="hamburger d-none d-md-inline">
            <input id="menu-toggle" type="checkbox" />
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class="menu">
                <li>
                    <a
                        class="text-light"
                        href="{{ route('laporan-publik.index') }}"
                    >Laporan Kegiatan</a>
                </li>
                <li>
                    <a href="{{ url('/') }}">Halaman Utama</a>
                </li>
                <li>
                    <a href="{{ url('pusat-informasi') }}">Pusat Informasi</a>
                </li>
                <li>
                    <a href="{{ route('halo-bhabin') }}">Halo Bhabinkamtibmas</a>
                </li>
            </ul>
        </div>
        <div class="brand d-block d-md-none">
            <a href="{{ url('/') }}" class="navbar-brand d-flex " style="align-items: center;">
                <img src="{{ asset('img/bhabin/bos-logo-v2.webp') }}"
                     class="block mr-2 mx-auto" id="logo" width="180px" alt="" srcset="">
            </a>
        </div>
        <div>
            <form
                id="frm-logout"
                action="{{ route('logout') }}"
                method="POST"
                class="d-none"
            >
                @csrf
            </form>
            <div
                class="d-flex align-items-center justify-content-end justify-content-sm-start justify-content-md-center"
                style="{{ $display ?? '' }}"
            >
                <span class="d-md-none" onclick="openSearchHero()">
                    <i
                        class="fa fa-search text-white"
                        style="font-size: 1.9em"
                    ></i>
                </span>
                <a href="{{ route('notification') }}">
                    <div
                        class="d-flex mb-0 px-3 px-md-2 align-items-center text-light"
                        style="position: relative"
                    >
                        <i class="far fa-bell" style="font-size: 1.9em"></i>
                    </div>
                </a>
                <a
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.querySelector('#frm-logout').submit()"
                >
                    <img
                        src="{{ asset('img/bhabin/icon/logout-button.svg') }}"
                        width="40px"
                        class="d-block rounded-circle mx-sm-2 mx-md-3"
                        alt="logout-button"
                    >
                </a>
                <div class="text-white d-none d-lg-block">
                    <h6
                        class="mb-1 text-white"
                        style="font-weight: 700"
                    >{{
                        auth()->user()->personel
                        ? (auth()->user()->personel->nama ?? '')
                        : auth()->user()->satpam->nama
                    }}</h6>
                    <p
                        class="mb-0"
                        style="font-size: 0.735em"
                    >{{ str_replace('_', ' ', strtoupper(auth()->user()->role())) }}</p>
                    <p
                        class="mb-0 d-none d-lg-block"
                        style="font-size: 0.735em"
                    >{{
                        role('bhabinkamtibmas')
                        ? (auth()->user()->lokasiPenugasans->first()->lokasi_singkat ?? "")
                        : auth()->user()->satpam->lokasi ?? ""
                    }}</p>
                </div>
            </div>
            <div id="FullScreenOverlay" class="overlay">
                <span
                    class="closebtn"
                    onclick="closeSearchHero()"
                    title="Close Overlay"
                >×</span>
                <div class="overlay-content">
                    <form action="{{ route('pencarian-umum') }}" method="GET">
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                class="form-control fs-6"
                                placeholder="Informasi apa yang anda cari?"
                                aria-label="Informasi apa yang anda cari?"
                                aria-describedby="search-box"
                            >
                            <button
                                class="btn btn-primary btn-outline-secondary"
                                type="submit"
                            >
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
