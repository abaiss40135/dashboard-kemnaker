@push('styles')
    @include('assets.css.select2')
@endpush
<header class="main-header">
    <div class="flex items-center logo-box justify-start">
        <a href="{{ route('dashboard-kemnaker.index') }}" class="logo">
            <div class="logo-mini w-64">
                <img src="{{ asset('img/logo-mini.png') }}" alt="logo">
            </div>
            <div class="logo-lg">
                <img src="{{ asset('img/dashboard-text.png') }}" alt="logo">
            </div>
        </a>
    </div>
    <nav class="navbar navbar-static-top flow-root">
        <div class="float-left">
            <ul class="header-megamenu nav flex items-center">
                <li class="btn-group nav-item inline-flex">
                    <a href="#" class="waves-effect waves-light nav-link push-btn bg-blue-600"
                        data-toggle="push-menu" role="button">
                        <i data-feather="menu"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="navbar-custom-menu r-side inline-flex items-center float-right">
            <ul class="nav navbar-nav inline-flex items-center">
                <li class="dropdown notifications-menu btn-group ">
                    <a id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                        class="btn-primary-light svg-bt-icon hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-3 text-center inline-flex items-center"
                        title="Notifications" type="button">
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full top-[1.4rem] end-[0.7rem]">
                            8</div><i data-feather="bell"></i>
                        <div class="pulse-wave"></div>
                    </a>

                    <div id="dropdown"
                        class="dropdown-menu z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow !w-max">
                        <ul class="py-2 text-sm text-gray-700"
                            aria-labelledby="dropdownDefaultButton">
                            <li class="header">
                                <div class="p-20 border-b">
                                    <div class="flexbox">
                                        <div>
                                            <div class="text-xl mb-0 mt-0">Notifications</div>
                                        </div>
                                        <div>
                                            <a href="#" class="text-danger">Clear All</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <ul class="menu sm-scrol">
                                    <li class="border-b">
                                        <a href="#" class="p-3 block m-0 overflow-hidden text-base whitespace-nowrap text-ellipsis">
                                            <i class="fa fa-users text-info"></i>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, cupiditate.
                                        </a>
                                    </li>
                                    <li class="border-b">
                                        <a href="#" class="p-3 block m-0 overflow-hidden text-base whitespace-nowrap text-ellipsis">
                                            <i class="fa fa-warning text-warning"></i>
                                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Incidunt, maxime.
                                        </a>
                                    </li>
                                    <li class="border-b">
                                        <a href="#" class="p-3 block m-0 overflow-hidden text-base whitespace-nowrap text-ellipsis">
                                            <i class="fa fa-users text-danger"></i>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat, dolor.
                                        </a>
                                    </li>
                                    <li class="border-b">
                                        <a href="#" class="p-3 block m-0 overflow-hidden text-base whitespace-nowrap text-ellipsis">
                                            <i class="fa fa-shopping-cart text-success"></i>
                                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam, magnam.
                                        </a>
                                    </li>
                                    <li class="border-b">
                                        <a href="#"
                                            class="p-3 block m-0 overflow-hidden text-base whitespace-nowrap text-ellipsis">
                                            <i class="fa fa-user text-danger"></i>
                                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Optio, quisquam.
                                        </a>
                                    </li>
                                    <li class="border-b">
                                        <a href="#"
                                            class="p-3 block m-0 overflow-hidden text-base whitespace-nowrap text-ellipsis">
                                            <i class="fa fa-user text-primary"></i>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nostrum!
                                        </a>
                                    </li>
                                    <li class="border-b">
                                        <a href="#"
                                            class="p-3 block m-0 overflow-hidden text-base whitespace-nowrap text-ellipsis">
                                            <i class="fa fa-user text-success"></i>
                                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eius, quod.
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer p-3 text-center border-t">
                                <a href="#">View all</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="inline-flex rounded-md nav-item max-[1199px]:hidden min-[1200px]:inline-flex">
                    <a href="#" data-provide="fullscreen"
                        class="waves-effect waves-light nav-link btn-primary-light svg-bt-icon" title="Full Screen">
                        <i data-feather="maximize"></i>
                    </a>
                </li>

                <li class="btn-group d-xl-inline-flex d-none">
                    <a
                        href="#"
                        id="dropdownDividerButton"
                        data-dropdown-toggle="dropdownDivider-2"
                        class="justify-center btn-primary-light hover:text-white svg-bt-icon hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm !px-px !py-px text-center inline-flex items-center"
                        type="button"
                    >
                        <i data-feather="user" class="avatar rounded-full !h-11 !w-11 mt-1 border-2"></i>
                    </a>

                    <div id="dropdownDivider-2"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700 drop-shadow-lg"
                            aria-labelledby="dropdownDividerButton">
                            <li>
                                <a href="#" class="items-center m-0 text-base flex px-4 py-2 hover:bg-gray-100">
                                    <i class="fa fa-user-circle-o me-3 text-xl" aria-hidden="true"></i>
                                    My Profile
                                </a>
                            </li>
                            <li>
                                <a href="/" class="items-center m-0 text-base flex px-4 py-2 hover:bg-red-100">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-3 text-xl" aria-hidden="true"></i>
                                    Log Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
