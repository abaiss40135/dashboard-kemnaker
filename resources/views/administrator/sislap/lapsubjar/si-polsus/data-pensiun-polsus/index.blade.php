@php
    $isAdmin = role('administrator');
    $isOperatorPolda = auth()->user()->haveRole('operator_polsus_polda');
    $aksesPolsus = auth()->user()?->polsus?->jenis_polsus;
@endphp

@extends('templates.admin.main')
@section('mainComponent')
    <div class="wrapper">
        <div class="content-wrapper">
            @component('components.admin.content-header')
                @slot('title', 'Laporan Data Polisi Khusus yang sudah Pensiun')
            @endcomponent
            <section class="content">
                <div class="container-fluid row mx-0 justify-content-center">
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polsuspas')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polsuspas.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="100px" src="https://www.pngitem.com/pimgs/m/246-2463355_polsuspas-logo-polsuspas-png-transparent-png.png" alt="">
                                    <h4 class="mt-2"><b>Polsuspas</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polhut_lhk')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polhut-lhk.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="100px" src="https://upload.wikimedia.org/wikipedia/commons/4/4d/Lambang_Polhut.png" alt="">
                                    <h4 class="mt-2"><b>Polhut LHK</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polhut_perhutani')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polhut-perhutani.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="100px" src="data:image/png;base64,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" alt="">
                                    <h4 class="mt-2"><b>Polhut Perhutani</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polsus_cagar_budaya')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polsus-cagar-budaya.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="100px" src="https://upload.wikimedia.org/wikipedia/commons/4/44/Logo_Direktorat_Pelestarian_Cagar_Budaya_dan_Permuseuman.png" alt="">
                                    <h4 class="mt-2"><b>Polsus Cagar Budaya</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polsuska')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polsuska.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="130px" height="100px" src="https://1.bp.blogspot.com/-gcPW4R5n3hs/YKzMAOc8bwI/AAAAAAAAFEA/9jH2ImUDmkATv85lfi5N_My63hJyQTxnQCLcBGAsYHQ/s1600/Logo%2BKAI%2B%2528Kereta%2BApi%2BIndonesia%2529.png" alt="">
                                    <h4 class="mt-2"><b>Polsuska</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polsus_pwp3k')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polsus-pwp3k.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="130px" height="100px" src="https://www.suarasurabaya.net/wp-content/uploads/2020/01/kk231219_clip10.jpg" alt="">
                                    <h4 class="mt-2"><b>Polsus PWP3K</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polsus_karantina_ikan')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polsus-karantina-ikan.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="100px" src="https://pbs.twimg.com/media/C5uV2hLUsAAqOmd.png" alt="">
                                    <h4 class="mt-2"><b>Polsus Karantina Ikan</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polsus_barantan')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polsus-barantan.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column align-items-center p-3">
                                    <img width="100px" height="100px" src="https://upload.wikimedia.org/wikipedia/commons/0/03/Logo_Barantan.png" alt="">
                                    <h4 class="mt-2"><b>Polsus Barantan</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polsus_dishubdar')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polsus-dishubdar.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="100px" height="100px" src="https://seeklogo.com/images/D/dishub-logo-FA3095CFFE-seeklogo.com.png" alt="">
                                    <h4 class="mt-2"><b>Polsus Dishubdar</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($isAdmin || $isOperatorPolda || $aksesPolsus == 'polsus_satpol_pp')
                    <div class="col-sm-6 col-md-4">
                        <a href="{{route('data-pensiun-polsus.polsus-satpol-pp.index')}}" class="card">
                            <div class="text-center d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column p-3 align-items-center">
                                    <img width="100px" src="https://www.kibrispdr.org/data/115/download-logo-satpol-pp-png-15.png" alt="">
                                    <h4 class="mt-2"><b>Polsus Satpol PP</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
