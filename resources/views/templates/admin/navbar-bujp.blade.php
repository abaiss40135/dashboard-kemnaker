<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  {{-- <!-- Left navbar links --> --}}
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  {{-- <!-- Right navbar links --> --}}
  <ul class="navbar-nav ml-auto">
      <img src="{{ asset('img/bhabin/binmas.svg') }}" width="70px" alt="logo-binmas"
           class="d-none d-md-block">
    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle mr-3 mt-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ auth()->user()->bujp->nama_badan_usaha ?? 'BUJP' }}
      </button>
      {{-- <!-- Messages Dropdown Menu --> --}}
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{ url('reset') }}">Ubah Sandi</a>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Keluar</a>
        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none !important; position: fixed; top:0;">
              @csrf
        </form>
      </div>
    </div>


    {{-- <!-- Notifications Dropdown Menu --> --}}
  </ul>
</nav>
