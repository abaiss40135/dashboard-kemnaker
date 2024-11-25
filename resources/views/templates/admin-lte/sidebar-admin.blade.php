<aside class="main-sidebar sidebar-dark-light elevation-4"
       style="background-color: hsl(212, 45%, 27%);">
    <a href="{{ url('/')}}" class="brand-link text-center">
        <h5 class="logo-lg" id="logoText">Dashboard Kemnaker</h5>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="{{ asset('img/logo_kemnaker_saja_putih.png') }}"
                     class="img-circle" alt="user image"
                     style="width: 2.6rem; height: 2.6rem; object-fit: cover; border: 2px solid white">
            </div>
            <div class="info">
                <a href="#" class="d-block font-weight-bold text-wrap">
                    Administrator
                </a>
            </div>
        </div>

        <nav class="mt-2 mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="" class="nav-link d-flex align-items-center {{ request()->is('*transaksi-bujp*') ? 'active' : '' }}" onclick="toggleNav(this)">
                        <i class="nav-icon fa fa-chart-bar"></i>
                        <p>Dashboard <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=""
                               class="nav-link d-flex align-items-center">
                                <i class="far fa-{{ request()->is('*daftar*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Dashboard Anggaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=""
                               class="nav-link">
                                <i class="far fa-{{ request()->is('*perluasan-bujp*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Dashboard Prog. Unggulan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=""
                               class="nav-link {{ request()->is('*perpanjangan*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*perpanjangan*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Dashboard Data Naker</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#"
                       class="nav-link d-flex align-items-center">
                        <i class="fa fa-archive nav-icon"></i>
                        <p>Entry Data</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#"
                       class="nav-link d-flex align-items-center">
                        <i class="fa fa-compass nav-icon"></i>
                        <p>Monitoring</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
