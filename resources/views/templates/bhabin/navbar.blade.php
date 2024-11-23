@php
    $configData = \App\Helpers\AppHelper::applClasses();
    $isBhabinkamtibmas = role('bhabinkamtibmas');
@endphp

<nav class="{{ $configData['navbarClass'] }} navbar {{ $configData['navbarColor'] }}">
    <div class="container d-flex align-items-center justify-content-between" id="nav-container">
        <div class="brand">
            <a href="{{ url('/') }}" class="navbar-brand d-flex " style="align-items: center;">
                <img src="{{ asset('img/bhabin/bos-logo-v2.webp') }}"
                     class="block mr-2 mx-auto" id="logo" width="180px" alt="" srcset="">
            </a>
        </div>
        <div class="d-flex align-items-center justify-content-end justify-content-sm-start justify-content-md-center"
             style="{{ $display ?? '' }}">
            <span class="d-lg-none" onclick="openSearchHero()"><i class="fa fa-search text-white"
                                                                  style="font-size: 1.9em"></i></span>
            <a href="{{ route('notification') }}">
                <div class="d-flex mb-0 px-3 px-md-2 align-items-center text-light"
                     style="position: relative">
                    <i class="far fa-bell" style="font-size: 1.9em"></i>
                     @if($navbarNotificationCount = auth()->user()->unreadNotifications()->count()) <small class="badge bg-danger" style="position: absolute; right: 0; top: 0; font-size: 0.615em">{{ $navbarNotificationCount }}</small> @endif
                </div>
            </a>
            <a href="{{ url('/profile') }}" >
                <img src=" {{ $isBhabinkamtibmas ? (session('personel')['foto'] ?? \App\Helpers\Constants::PLACEHOLDER_IMG) : (role("polsus") ? auth()->user()?->polsus?->fotoProfile() : auth()->user()?->satpam?->foto_profile) }} "
                    id="user" width="50px" class="d-block rounded-circle img-profile mx-sm-2 mx-md-3" alt="" srcset="">
            </a>
            <div class="text-white d-none d-lg-block">
                <h6 class="mb-1 text-white"
                    style="font-weight: 700">
                    @if(role('polsus'))
                        {{auth()->user()->polsus?->nama}}
                    @elseif(role('satpam'))
                        {{auth()->user()->satpam->nama}}
                    @else
                        {{auth()->user()->personel->nama}}
                    @endif
                </h6>
                <p class="mb-0"
                   style="font-size: 0.735em">{{ str_replace('_', ' ', strtoupper(auth()->user()->role())) }}</p>
                <p class="mb-0 d-none d-lg-block"
                   style="font-size: 0.735em">
                    @if($isBhabinkamtibmas)
                        {{auth()->user()->lokasiPenugasans->first()?->lokasi_singkat}}
                    @elseif(role('polsus'))
                        {{auth()->user()->polsus->instansi->instansi}}
                    @elseif(role('satpam'))
                        {{auth()->user()->satpam?->lokasi}}
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div id="FullScreenOverlay" class="overlay">
        <span class="closebtn" onclick="closeSearchHero()" title="Close Overlay">×</span>
        <div class="overlay-content">
            <form action="{{ route('pencarian-umum') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control fs-6" placeholder="Informasi apa yang anda cari?"
                           aria-label="Informasi apa yang anda cari?" aria-describedby="search-box">
                    <button style="{{role("satpam") ? "background: #6d6d6d; color: white;" : ""}}" class="btn {{!role("satpam") ? "btn-primary btn-outline-secondary" : ""}}" type="submit"><i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>
