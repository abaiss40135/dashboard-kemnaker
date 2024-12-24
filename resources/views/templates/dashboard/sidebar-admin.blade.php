<aside class="main-sidebar">
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 98%;">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview {{ !request()->is('dashboard/kemnaker/*') ?: 'active menu-open' }}">
                        <x-nav-item feather-icon="pie-chart" title="Dashboard<br>Kemnaker" />
                        <ul class="treeview-menu">
                            <x-nav-link route="dashboard.kemnaker.rekapitulasi-keuangan" title="Rekapitulasi Keuangan" />
                            <x-nav-link route="dashboard.kemnaker.bmn" title="BMN" />
                            <x-nav-link route="dashboard.kemnaker.sdm" title="SDM" />
                            <x-nav-link route="dashboard.kemnaker.kpi" title="KPI" />
                            <x-nav-link route="dashboard.kemnaker.tlhp" title="TLHP" />
                            <x-nav-link route="dashboard.kemnaker.pengelolaan-proyek" title="Status Pengelolaan Proyek" />
                        </ul>
                    </li>
                    <li class="treeview {{ !request()->is('dashboard/ketenagakerjaan/*') ?: 'active menu-open' }}">
                        <x-nav-item feather-icon="grid" title="Dashboard Ketenagakerjaan" />
                        <ul class="treeview-menu">
                            <x-nav-link route="dashboard.ketenagakerjaan.pekerja" title="Penduduk yang Bekerja" />
                            <x-nav-link route="dashboard.ketenagakerjaan.upah" title="Rata-rata Upah Sebulan" />
                            <x-nav-link route="dashboard.ketenagakerjaan.jam-kerja" title="Rata-rata Jam Kerja Seminggu" />
                            <x-nav-link route="dashboard.ketenagakerjaan.pengangguran-terbuka" title="Pengangguran Terbuka" />
                        </ul>
                    </li>
                    <li class="treeview {{ !request()->is('dashboard/entry-data/*') ?: 'active menu-open' }}">
                        <x-nav-item feather-icon="database" title="Entry Data<br>Dashboard" />
                        <ul class="treeview-menu">
                            <x-nav-link route="dashboard.entry-data.kemnaker.index" title="Dashboard Kemnaker" />
                            <x-nav-link route="dashboard.entry-data.ketenagakerjaan.index" title="Dashboard Ketenagakerjaan" />
                        </ul>
                    </li>
                </ul>

                <div class="sidebar-widgets"></div>
            </div>
        </div>
    </section>
</aside>
