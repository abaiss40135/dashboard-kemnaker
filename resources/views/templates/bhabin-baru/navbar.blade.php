@php
    $configData = \App\Helpers\AppHelper::applClasses();
    $isBhabinkamtibmas = role('bhabinkamtibmas');
@endphp

<nav class="{{ $configData['navbarClass'] }} navbar {{ $configData['navbarColor'] }}">
    <div class="container d-flex align-items-center justify-content-between" id="nav-container">
        <div class="hamburger d-none d-lg-inline">
            <input id="menu-toggle" type="checkbox" />
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class="menu">
                <li>
                    <a class="text-light" href="{{ role('polisi_rw') ? route('polisi-rw.laporan.index') : url('laporan') }}">Laporan Kegiatan</a>
                </li>
                <li>
                    <a href="{{ url('pusat-informasi') }}">Pusat Informasi</a>
                </li>
                <li>
                    <a href="{{ route('halo-bhabin') }}">Halo Bhabinkamtibmas</a>
                </li>
                @if($isBhabinkamtibmas)
                    <li>
                        <a href="{{ route('jukrah-bhabin') }}">Petunjuk dan Arahan</a>
                    </li>
                    <li>
                        <a href="{{ url('dashboard-lokasi') }}">Lokasi Bhabinkamtibmas</a>
                    </li>
                    <li>
                        <a href="/pengembangan">Kinerja Bhabinkamtibmas</a>
                    </li>
                    <li>
                        <a href="/pengembangan">Anev Kamtibmas</a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="brand">
            <a href="{{ url('/') }}" class="navbar-brand d-flex " style="align-items: center; margin-right: 150px;">
                <img src="{{ asset('img/bhabin/bos-logo-v2.webp') }}"
                     class="block mx-auto" id="logo" width="180px" alt="" srcset="">
            </a>
        </div>

        <div class="search-bar d-none d-lg-inline">
            <form action="{{ route('pencarian-umum') }}" method="GET">
                <div class="input-group">
                    <input id="pencarian-umum" style="margin-left: -150px; width: 40vw; {{role('satpam') ? 'background-color: #9D9D9D !important;' : 'background-color: #9DB2D6 !important;'}} border-radius: 20px 0 0 20px;" type="text" name="search" class="form-control fs-6 border-0 text-white" placeholder="Informasi apa yang anda cari?"
                           aria-label="Informasi apa yang anda cari? <i class='fa fa-search'></i>" aria-describedby="search-box">
                    <button style="{{role("satpam") ? "background: #6d6d6d; color: white;" : "background: #9DB2D6;"}} border-radius: 0 20px 20px 0;" class="btn {{!role("satpam") ? "btn-outline-secondary" : ""}}" type="submit"><i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="d-flex align-items-center justify-content-end justify-content-sm-start justify-content-md-center"
             style="margin-left: 70px; {{ $display ?? '' }}">
            <span class="d-lg-none" onclick="openSearchHero()"><i class="fa fa-search text-white mr-2"
                                                                  style="font-size: 1.9em"></i></span>
            <a href="{{ route('notification') }}">
                <div class="d-flex mb-0 px-3 px-md-2 align-items-center text-light"
                     style="position: relative">
                    <i class="far fa-bell" style="font-size: 1.9em"></i>
                     @if($navbarNotificationCount = auth()->user()->unreadNotifications()->count()) <small class="badge bg-danger" style="position: absolute; right: 0; top: 0; font-size: 0.615em">{{ $navbarNotificationCount }}</small> @endif
                </div>
            </a>

            <div class="profile">
                <img src=" {{ $isBhabinkamtibmas ? (session('personel')['foto'] ?? \App\Helpers\Constants::PLACEHOLDER_IMG) : (role("polsus") ? auth()->user()?->polsus?->fotoProfile() : auth()->user()?->satpam?->foto_profile) }} "
                    id="user" width="50px" class="d-block rounded-circle img-profile mx-sm-2 mx-md-3" alt="" srcset="">
                <input id="profile-toggle" type="checkbox" />

                <ul class="menu">
                        <li>
                            <a href="{{ url('/profile') }}">Profil Akun</a>
                        </li>
                        <li>
                            <a href="{{ route('notification') }}">Lihat Semua Notifikasi</a>
                        </li>
                        <li class="bg-warning">
                            <a class="text-black" href="{{ url('/reset') }}">Ubah Password</a>
                        </li>
                        <li class="bg-danger ">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-button text-white bg-transparent border-0 ">Logout</button>
                            </form>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
</nav>
