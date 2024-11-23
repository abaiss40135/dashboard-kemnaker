<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <img src="{{ asset('img/bhabin/binmas.svg') }}" width="70px" alt="logo-binmas"
            class="d-none d-md-block">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle mr-3 mt-1"
                    aria-haspopup="true" aria-expanded="false" type="button" 
                    id="dropdownMenuButton" data-toggle="dropdown"
                    >{{ isset(auth()->user()->bujp->id) ? auth()->user()->bujp->nama_badan_usaha : 'BUJP' }}</button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ url('reset') }}">Ubah Sandi</a>
                <a class="dropdown-item" href="#" onclick="this.nextElementSibling.submit()">Log out</a>
                <form id="frm-logout" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </div>
    </ul>
</nav>
