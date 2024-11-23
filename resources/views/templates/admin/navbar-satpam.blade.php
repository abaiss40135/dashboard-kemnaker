 {{-- <!-- Navbar --> --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    {{-- <!-- Left navbar links --> --}}
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    {{-- <!-- Right navbar links --> --}}
    <ul class="navbar-nav ml-auto">
      {{-- <!-- profile --> --}}
      <div class="dropdown">
        <img src="{{ asset('img/bhabin/binmas.svg') }}" width="70px"  alt="" srcset="">
        <button class="btn btn-secondary dropdown-toggle mr-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ auth()->user()->bujp->nama_badan_usaha }}
        </button>
        {{-- <!-- Messages Dropdown Menu --> --}}
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="#">Ubah Sandi</a>
          <a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Keluar</a>
          <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none !important; position: fixed; top:0;">
                @csrf
          </form>
        </div>
      </div>


      {{-- <!-- Notifications Dropdown Menu --> --}}
    </ul>
  </nav>
  {{-- <!-- /.navbar --> --}}
