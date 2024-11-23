<nav class="fixed-top navbar">
    <div class="container d-flex align-items-center justify-content-between" id="nav-container">
        <div class="brand">
            <a href="{{ url('/') }}" class="navbar-brand d-flex " style="align-items: center;">
                <img src="{{ asset('img/bhabin/bos-logo-v2.webp') }}" class="block mr-2 mx-auto" id="logo" width="180px" alt="" srcset="">
            </a>
        </div>
        <div class="d-flex align-items-center justify-content-end" style="{{ $display ?? '' }}">
            <div class="text-white d-none d-sm-block">
                <h6 class="mb-1" style="font-weight: 700">Karno Nur Cahyo</h6>
                <p style="font-size: 0.735em; margin-bottom: 0">Bhabinkantibmas</p>
                <p style="font-size: 0.735em; margin-bottom: 0">Kaliwungu</p>
            </div>
            <a href="{{ url('/profile') }}" style="margin-left: 1rem">
                <img src="{{ asset('img/bhabin/user/karno2.svg') }}" id="user" width="50px" class="d-block" alt="" srcset="">
            </a>
        </div>
    </div>
</nav>
