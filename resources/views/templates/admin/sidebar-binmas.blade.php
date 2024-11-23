<aside class="main-sidebar sidebar-dark-light elevation-4"
       style="background-color: hsl(212, 45%, 27%);">
    <a href="{{ url('/administrator')}}" class="brand-link text-center">
        <span class="logo-lg">
            <h5 id="logoText">Binmas Online System</h5>
        </span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="align-items: center !important;">
            <div class="image">
                <img src="{{ auth()->user()->role() == 'operator_divhumas' ? asset('img/logo/divhumas.png') : (auth()->user()->nrp == null ? asset('images/icons/user.svg') : (isset(session('personel')['foto']) ? session('personel')['foto']  : asset('images/icons/user.svg'))) }}"
                     class="img-circle" alt="user image"
                     style="width: 2.6rem; height: 2.6rem; object-fit: cover; object-position: center; border: 2px solid white">
            </div>
            <div class="info">
                <a href="#" class="d-block font-weight-bold text-wrap">
                    @auth()
                    {!! auth()->user()->roles->implode('alias', '<br>')  !!}
                    @endauth
                </a>
                <i class="fa fa-circle text-success" style="font-size: 10px;"></i>
                <small class="text-white" style="font-size: 12px;">Online</small>
            </div>
        </div>

        <nav class="mt-2 mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
            @can('dashboard_lokasi_bhabinkamtibmas_access')
                <li class="nav-item">
                    <a href="{{ route('dashboard-lokasi.bhabinkamtibmas.index') }}"
                    class="nav-link d-flex align-items-center{{ request()->is('*dashboard-lokasi/bhabinkamtibmas*') ? ' active' : '' }}">
                        <i class="far fa-map nav-icon"></i>
                        <p>Peta Sebaran<br/>Bhabinkamtibmas</p>
                    </a>
                </li>
            @endcan
            @can('dashboard_access')
                <li class="nav-item {{ request()->is('*dashboard*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link d-flex align-items-center {{ request()->is('*dashboard*') ? 'active' : '' }}">
                        <i class="far fa-newspaper nav-icon"></i>
                        <p>Dashboard Situasi<br/>Kamtibmas</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav-treeview ml-4" style="display: none">
                        <li class="nav">
                            <a href="{{ route('dashboard.bhabin') }}"
                               class="nav-link {{ request()->is('*dashboard/bhabinkamtibmas*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bhabinkamtibmas</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('dashboard.publik') }}"
                               class="nav-link {{ request()->is('*dashboard/publik*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Publik</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('dashboard.satpam') }}"
                               class="nav-link {{ request()->is('*dashboard/satpam*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Satpam</p>
                            </a>
                        </li>
                        @if(can('dashboard_trending_keyword_access'))
                            <li class="nav">
                                <a href="{{ route('dashboard.keyword-laporan.index') }}"
                                   class="nav-link {{ request()->is('*dashboard/keyword-laporan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Trending Keyword</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endcan
            @can('pusat_informasi_menu')
                <li class="nav-item {{ request()->is('*pusat-informasi*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link d-flex align-items-center {{ request()->is('*pusat-informasi*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Pusat Informasi<br/>Kamtibmas<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav-treeview ml-4" style="display: none">
                        <li class="nav">
                            <a href="{{ route('regulasi.index') }}"
                               class="nav-link {{ request()->is('*pusat-informasi/regulasi*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>UU dan Peraturan</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('pusat-informasi.video.index') }}"
                               class="nav-link {{ request()->is('*pusat-informasi/video*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Video</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('infografis.index') }}"
                               class="nav-link {{ request()->is('*pusat-informasi/infografis*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Infografis</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('pusat-informasi.meme.index') }}"
                               class="nav-link {{ request()->is('*pusat-informasi/meme*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Meme</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('paparan.index') }}"
                               class="nav-link {{ request()->is('*pusat-informasi/paparan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Paparan</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('naskah.index') }}"
                               class="nav-link {{ request()->is('*pusat-informasi/naskah*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Naskah</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('pusat-informasi.link.index') }}"
                               class="nav-link {{ request()->is('*pusat-informasi/link*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Link Terkait</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('pusat-informasi.kategori-informasi.index') }}"
                               class="nav-link {{ request()->is('*pusat-informasi/kategori-informasi*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Informasi</p>
                            </a>
                        </li>
                        <li class="nav">
                            <a href="{{ route('panduan.index') }}"
                               class="nav-link {{ request()->is('*panduan-penggunaan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Panduan BOS</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('berita_access')
                <li class="nav-item">
                    <a href="{{ route('berita.index') }}"
                       class="nav-link {{ request()->is('*berita*') ? 'active' : '' }}">
                        <i class="far fa-newspaper nav-icon"></i>
                        <p>Berita</p>
                    </a>
                </li>
            @endcan
            @can('atensi_pimpinan_menu')
                <li class="nav-item {{ request()->is('*atensi-pimpinan*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*atensi-pimpinan*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Atensi Pimpinan<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav-treeview ml-4" style="display: none">
                    @can('atensi_pimpinan_bhabinkamtibmas_access')
                        <li class="nav">
                            <a href="{{ route('atensi-pimpinan.index', ['sasaran' => 'bhabinkamtibmas']) }}"
                               class="nav-link {{ (request()->is('*atensi-pimpinan*') && request('sasaran') == 'bhabinkamtibmas') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bhabinkamtibmas</p>
                            </a>
                        </li>
                    @endcan
                    @can('atensi_pimpinan_satpam_access')
                        <li class="nav">
                            <a href="{{ route('atensi-pimpinan.index', ['sasaran' => 'satpam']) }}"
                               class="nav-link {{ (request()->is('*atensi-pimpinan*') && request('sasaran') == 'satpam') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Satpam</p>
                            </a>
                        </li>
                    @endcan
                    @can('atensi_pimpinan_publik_access')
                        <li class="nav">
                            <a href="{{ route('atensi-pimpinan.index', ['sasaran' => 'publik']) }}"
                               class="nav-link {{ (request()->is('*atensi-pimpinan*') && request('sasaran') == 'publik') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Publik</p>
                            </a>
                        </li>
                    @endcan
                    </ul>
                </li>
            @endcan
            @can('jukrah_access')
                <li class="nav-item{{ request()->is('*jukrah*') ? ' menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link{{ request()->is('*jukrah*') ? ' active' : '' }}">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Jukrah<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav-treeview ml-4" style="display: none">
                        <li class="nav">
                            <a href="{{ route('jukrah.index', ['type' => 'bhabinkamtibmas']) }}"
                               class="nav-link{{ request('type') == 'bhabinkamtibmas' && request()->is('*jukrah*') ? ' active' : '' }}">
                                <i class="fas fa-book-reader nav-icon"></i>
                                <p>Bhabinkamtibmas</p>
                            </a>
                        </li>
                        {{--<li class="nav">
                            <a href="{{ route('jukrah.index', ['type' => 'polisi_rw']) }}"
                               class="nav-link{{ request('type') == 'polisi_rw' && request()->is('*jukrah*') ? ' active' : '' }}">
                                <i class="fas fa-book-reader nav-icon"></i>
                                <p>Polisi RW</p>
                            </a>
                        </li>--}}
                    </ul>
                </li>
            @endcan
            @can('master_bhabin_access')
                <li class="nav-item">
                    <a href="{{ route('master-bhabin.index') }}"
                       class="nav-link d-flex align-items-center {{ request()->is('*master-bhabin*') ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Kinerja<br>Bhabinkamtibmas</p>
                    </a>
                </li>
            @endcan
            @can('pengelolaan_akun_access')
                <li class="nav-item">
                    <a href="{{ url('/administrator/pengelolaan-akun') }}"
                       class="nav-link d-flex align-items-center {{ request()->is('*pengelolaan-akun*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle nav-icon d-flex"></i>
                        <p>Pengelolaan Akun</p>
                    </a>
                </li>
            @endcan
            @can('both_access')
                <li class="nav-item">
                    <a href="{{ route('both.index') }}"
                       class="nav-link d-flex align-items-center {{ request()->is('*both*') ? 'active' : '' }}">
                        <i class="fas fa-video nav-icon d-flex"></i>
                        <p>Bhabinkamtibmas<br/>On The Hotspot</p>
                    </a>
                </li>
            @endcan
            @can('terobosan_kreatif_access')
                <li class="nav-item">
                    <a href="{{ route('terobosan-kreatif.index') }}"
                       class="nav-link d-flex align-items-center {{ request()->is('*terobosan-kreatif*') ? 'active' : '' }}">
                        <i class="fa fa-lightbulb nav-icon d-flex"></i>
                        <p>Terobosan Kreatif<br/>dan Inovatif</p>
                    </a>
                </li>
            @endcan
            @can('foto_bhabinkamtibmas_menu')
                <li class="nav-item">
                    <a href="{{ route('slider-picture.index') }}" class="nav-link {{ request()->is('*slider-picture*') ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Foto Bhabinkamtibmas</p>
                    </a>
                </li>
            @endcan
            @can('sislap_menu')
                <li class="nav-item {{ request()->is('*sislap*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link d-flex align-items-center {{ request()->is('*sislap*') ? 'active' : '' }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Sislap<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav-treeview ml-4" style="display: none">
                        @can('lapbul_access')
                        <li class="nav">
                            <a href="{{ route('lapbul') }}" class="nav-link d-block w-100 {{ request()->is('*sislap/lapbul*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Bulanan</p>
                            </a>
                        </li>
                        @endcan
                        @can('lapsubjar_access')
                        <li class="nav">
                            <a href="{{ route('lapsubjar') }}" class="nav-link d-block w-100 {{ request()->is('*sislap/lapsubjar*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Subdit</p>
                            </a>
                        </li>
                        @endcan
                        @can('nonlapbul_access')
                        <li class="nav">
                            <a href="{{route('nonlapbul')}}" class="nav-link d-block w-100 {{ request()->is('*sislap/nonlapbul*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Harian Rutin </p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav">
                            <a href="{{route('video')}}" class="nav-link d-block w-100 {{ request()->is('*sislap/video*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Video Tutorial </p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('manajemen_bujp_satpam_menu')
                <li class="nav-item {{ request()->is('*bujp-satpam*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link d-flex align-items-center {{ request()->is('*bujp-satpam*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Manajemen<br>BUJP-Satpam</p>
                        <i class="right fas fa-angle-left mt-3"></i>
                    </a>
                    <ul class="nav-treeview ml-2" style="display: none">
                        @can('sio_access')
                            <li class="nav-item {{ request()->is('*surat-izin-operasional*') ? 'menu-is-opening menu-open' : ''}}">
                                <a href="#" class="nav-link {{ request()->is('*surat-izin-operasional*') ? 'active' : '' }}">
                                    <i class="fas fa-people-arrows nav-icon"></i>
                                    <p>Surat Izin Operasional</p>
                                    <i class="right fas fa-angle-left"></i>
                                </a>
                                <ul class="nav-treeview" style="display: none">
                                    <li class="nav">
                                        <a href="{{ route('surat-izin-operasional.index') }}"
                                           class="nav-link w-100 {{ request()->is('*surat-izin-operasional') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kantor Pusat</p>
                                        </a>
                                    </li>
                                    <li class="nav">
                                        <a href="{{ route('surat-izin-operasional.perluasan.index') }}"
                                           class="nav-link w-100 {{ request()->is('*perluasan') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kantor Cabang</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('master_bujp_access')
                        <li class="nav">
                            <a href="{{ url('administrator/bujp-satpam/master-bujp') }}"
                               class="nav-link w-100 {{ request()->is('*master-bujp*') ? 'active' : '' }}">
                                <i class="fas fa-building nav-icon"></i>
                                <p>Master BUJP</p>
                            </a>
                        </li>
                        @endcan
                        @can('master_satpam_access')
                        <li class="nav">
                            <a href="{{ url('administrator/bujp-satpam/master-satpam') }}"
                               class="nav-link w-100 {{ request()->is('*master-satpam*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Master Satpam</p>
                            </a>
                        </li>
                        @endcan
                        @can('laporan_semester_bujp_access')
                            <li class="nav">
                                <a href="{{ url('administrator/bujp-satpam/laporan-semester-bujp') }}"
                                   class="nav-link w-100{{ request()->is('*laporan-semester-bujp*') ? ' active' : '' }}">
                                    <i class="fas fa-book-reader nav-icon"></i>
                                    <p>Laporan Semester BUJP</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('manajemen_publik_access')
                <li class="nav-item mb-3">
                    <a href="{{ url('/administrator/manajemen-publik') }}"
                    class="nav-link d-flex align-items-center {{ request()->is('*manajemen-publik*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Manajemen Publik</p>
                    </a>
                </li>
            @endcan
            </ul>
        </nav>
    </div>
</aside>
