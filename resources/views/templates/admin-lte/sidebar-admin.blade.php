<aside class="main-sidebar">
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 98%;">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview {{ !request()->is('dashboard-kemnaker/*') ?: 'active menu-open' }}">
                        <a href="#" class="!flex items-center space-x-2">
                            <i data-feather="pie-chart"></i>
                            <span class="inline-block text-wrap break-words">Dashboard<br>Kemnaker</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ !request()->routeIs('dashboard-kemnaker.rekapitulasi-keuangan') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-kemnaker.rekapitulasi-keuangan') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">Rekapitulasi Keuangan</span>
                                </a>
                            </li>
                            <li class="{{ !request()->routeIs('dashboard-kemnaker.bmn') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-kemnaker.bmn') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">BMN</span>
                                </a>
                            </li>
                            <li class="{{ !request()->routeIs('dashboard-kemnaker.sdm') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-kemnaker.sdm') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">SDM</span>
                                </a>
                            </li>
                            <li class="{{ !request()->routeIs('dashboard-kemnaker.kpi') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-kemnaker.kpi') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">KPI</span>
                                </a>
                            </li>
                            <li class="{{ !request()->routeIs('dashboard-kemnaker.tlhp') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-kemnaker.tlhp') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">TLHP</span>
                                </a>
                            </li>
                            <li class="{{ !request()->routeIs('dashboard-kemnaker.pengelolaan-proyek') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-kemnaker.pengelolaan-proyek') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">Status Pengelolaan Proyek</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview {{ !request()->is('dashboard-ketenagakerjaan/*') ?: 'active menu-open' }}">
                        <a href="#" class="!flex items-center space-x-2">
                            <i data-feather="grid"></i>
                            <span class="inline-block text-wrap break-words">Dashboard Ketenagakerjaan</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ !request()->routeIs('dashboard-ketenagakerjaan.pekerja') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-ketenagakerjaan.pekerja') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">Penduduk yang Bekerja</span>
                                </a>
                            </li>
                            <li class="{{ !request()->routeIs('dashboard-ketenagakerjaan.upah') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-ketenagakerjaan.upah') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">Rata-rata Upah Sebulan</span>
                                </a>
                            </li>
                            <li class="{{ !request()->routeIs('dashboard-ketenagakerjaan.jam-kerja') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-ketenagakerjaan.jam-kerja') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">Rata-rata Jam Kerja Seminggu</span>
                                </a>
                            </li>
                            <li class="{{ !request()->routeIs('dashboard-ketenagakerjaan.pengangguran-terbuka') ?: 'active' }}">
                                <a
                                    href="{{ route('dashboard-ketenagakerjaan.pengangguran-terbuka') }}"
                                    class="!flex items-center space-x-2"
                                >
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">Pengangguran Terbuka</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#" class="!flex items-center space-x-2">
                            <i data-feather="database"></i>
                            <span class="inline-block text-wrap break-words">Entry Data<br>Dashboard</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        
                        <ul class="treeview-menu">
                            <li>
                                <a href="#" class="!flex items-center space-x-2">
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">Dashboard Kemnaker</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="!flex items-center space-x-2">
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="inline-block text-wrap break-words">Dashboard Ketenagakerjaan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="sidebar-widgets"></div>
            </div>
        </div>
    </section>
</aside>
