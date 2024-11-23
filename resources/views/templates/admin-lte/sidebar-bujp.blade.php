<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('bujp') }}" class="brand-link text-center">
        <span class="logo-lg">
        <h5 id="logoText" onclick="redirect()">Binmas Online System</h5>
        </span>
    </a>
    <div class="sidebar">
        <nav class="mt-2 mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('bujp') }}"
                       class="nav-link {{ request()->is('*dashboard*') ? 'active' : '' }} d-flex align-items-center">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item mt-3 {{ request()->is('*transaksi-bujp*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="" class="nav-link d-flex align-items-center {{ request()->is('*transaksi-bujp*') ? 'active' : '' }}" onclick="toggleNav(this)">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>Transaksi BUJP <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('transaksi.pendaftaran-sio.index') }}"
                               class="nav-link {{ request()->is('*pendaftaran-sio*') ? 'active' : '' }} d-flex align-items-center">
                                <i class="far fa-{{ request()->is('*daftar*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Pendaftaran SIO Baru <br>Kantor Pusat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transaksi.perluasan-bujp.index') }}"
                               class="nav-link {{ request()->is('*perluasan-bujp*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*perluasan-bujp*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Perluasan BUJP</p>
                            </a>
                        </li>
                        @if(app()->environment(['local', 'development']))
                        <li class="nav-item">
                            <a href="{{ url('bujp/transaksi-bujp/perpanjangan') }}"
                               class="nav-link {{ request()->is('*perpanjangan*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*perpanjangan*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Perpanjangan BUJP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('bujp/transaksi-bujp/laporan-semester') }}"
                               class="nav-link {{ request()->is('*laporan-semester*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*laporan-semster*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Laporan Semester</p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('transaksi.ticket.index') }}"
                               class="nav-link {{ request()->is('*ticket*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*ticket*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Tiket Kendala Perizinan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item mt-3 {{ request()->is('transaksi-satpam') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="" class="nav-link {{ request()->is('transaksi-satpam') ? 'active' : '' }} d-flex align-items-center">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>Transaksi Satpam  <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('bujp/transaksi-satpam/master-data-diri-satpam') }}"
                               class="nav-link {{ request()->is('*master-data-diri-satpam*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*master-data-diri-satpam*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Master Data Diri Satpam</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ url('bujp/transaksi-satpam/rencana-pelatihan') }}"
                               class="nav-link {{ request()->is('*rencana-pelatihan*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*rencana-pelatihan*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Rencana Pelatihan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('bujp/transaksi-satpam/surat-persetujuan') }}"
                               class="nav-link {{ request()->is('*surat-persetujuan*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*surat-persetujuan*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Surat Persetujuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('bujp/transaksi-satpam/laporan-kegiatan') }}"
                               class="nav-link {{ request()->is('*laporan-kegiatan*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*laporan-kegiatan*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Laporan Kegiatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('bujp/transaksi-satpam/ijazah-pelatihan') }}"
                               class="nav-link {{ request()->is('*ijazah-pelatihan*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*ijazah-pelatihan*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Ijazah Pelatihan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('bujp/transaksi-satpam/kartu-tanda-anggota') }}"
                               class="nav-link {{ request()->is('*kartu-tanda-anggota*') ? 'active' : '' }}">
                                <i class="far fa-{{ request()->is('*kartu-tanda-anggota*') ? 'dot-circle' : 'circle' }} nav-icon"></i>
                                <p>Kartu Tanda Anggota</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
