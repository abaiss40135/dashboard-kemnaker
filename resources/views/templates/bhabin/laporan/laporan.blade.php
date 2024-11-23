<div class="container row mx-auto mb-4">
    {{-- 7 Giat Wajib Harian --}}
    <div class="col-md-4 mt-4">
        <div class="box">
            <div class="header text-center">
                <img src="{{ asset('img/bhabin/icon/laporan/giat.svg') }}" width="60px" class="d-block mx-auto" alt="" srcset="">
                <h5 class="mt-3 text-white">7 Giat Wajib Harian</h5>
            </div>

            <div class="box-body">
                <ul class="list-group  text-center">
                <li class="list-group-item">
                    <a href="{{ route('laporan.dds') }}" class="text-body">Door to Door System (DDS)</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('deteksi-dini.index') }}" class="text-body">Deteksi Dini</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url('/laporan/problem-solving') }}" class="text-body">Problem Solving</a>
                </li>
                <li class="list-group-item">
                    <a href="/pengembangan" class="text-body">Layanan Kepolisian</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('giat-desa.index') }}" class="text-body">Giat Desa atau Kelurahan</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('bina-komunitas.index') }}" class="text-body">Pembinaan Komunitas atau Ormas</a>
                </li>
                <li class="list-group-item" style=" border-bottom-left-radius: 15px !important; border-bottom-right-radius: 15px;">
                    <a href="/pengembangan" class="text-body">Pembinaan Siskamling</a>
                </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Program Polri --}}
    <div class="col-md-4 mt-4">
        <div class="box">
            <div class="header text-center">
                <img src="{{ asset('img/bhabin/icon/laporan/program-polri.svg') }}" width="60px" class="d-block mx-auto" alt="" srcset="">
                <h5 class="mt-3 text-white">Program Polri</h5>
            </div>

            <div class="box-body">
                <ul class="list-group  text-center">
                <li class="list-group-item">
                    <a href="/pengembangan" class="text-body">Program Prioritas Kapolri</a>
                </li>
                <li class="list-group-item">
                    <a href="/pengembangan" class="text-body">Program Berbasis Kearifan Lokal</a>
                </li>
                <li class="list-group-item" style=" border-bottom-left-radius: 15px !important; border-bottom-right-radius: 15px;">
                    <a href="/pengembangan" class="text-body">Program Polri Lainnya</a>
                </li>

                </ul>
            </div>
        </div>
    </div>

    {{-- Atensi Pimpinan --}}
    <div class="col-md-4 mt-4">
        <div class="box">
            <div class="header text-center">
                <img src="{{ asset('img/bhabin/icon/laporan/program-pemerintah.svg') }}" width="60px" class="d-block mx-auto" alt="" srcset="">
                <h5 class="mt-3 text-white">Atensi Pimpinan</h5>
            </div>

            <div class="box-body">
                <ul class="list-group  text-center">
{{--                    <li class="list-group-item">--}}
{{--                        <a href="{{route('program-pemerintah.laporan-pemungutan-suara-capres.index')}}" class="text-body">Laporan Pemungutan Suara Capres 2024</a>--}}
{{--                    </li>--}}
                    {{--<li class="list-group-item">
                        <a href="/pengembangan" class="text-body">Covid-19 (PPKM Mikro)</a>
                    </li>
                    <li class="list-group-item">
                        <a href="/pengembangan" class="text-body">Dana Desa</a>
                    </li>
                    <li class="list-group-item">
                        <a href="/pengembangan" class="text-body">Bantuan Sosial</a>
                    </li>
                    <li class="list-group-item" style=" border-bottom-left-radius: 15px !important; border-bottom-right-radius: 15px;">
                        <a href="/pengembangan" class="text-body">Lainnya</a>
                    </li>--}}
                </ul>
            </div>
        </div>
    </div>

    {{-- Insidentil, Kontinjensi & Kreatifitas --}}
    <div class="col-md-4 mt-4">
        <div class="box">
            <div class="header text-center">
                <i class="fas fa-bolt" style="font-size: 4em; color: #BACDEF"></i>
                <h5 class="mt-3 text-white">Insidentil, Kontinjensi & Kreatifitas</h5>
            </div>
            <div class="box-body">
                <ul class="list-group text-center">
                    <li class="list-group-item">
                        <a href="/pengembangan" class="text-body">Insidentil</a>
                    </li>
                    <li class="list-group-item">
                        <a href="/pengembangan" class="text-body">Kontinjensi</a>
                    </li>
                    <li class="list-group-item" style="border-radius: 0 0 15px 15px !important">
                        <a href="{{route('kreatifitas.index')}}" class="text-body">Terobosan Kreatif dan Inovatif</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bhabinkamtibmas On The Hotspot --}}
    <div class="col-md-4 mt-4">
        <div class="box">
            <div class="header text-center">
                <i class="fas fa-images" style="font-size: 4em; color: #BACDEF"></i>
                <h5 class="mt-3 text-white">BOTH
                <p style="font-size: 14px; font-weight: 500; margin-top: 10px;">Bhabinkamtibmas On The Hotspot</p></h5>
            </div>
            <div class="box-body">
                <ul class="list-group  text-center">
                    <li class="list-group-item">
                        <a href="{{ url('laporan/both/video') }}" class="text-body">Video Both</a>
                    </li>
                    {{-- <li class="list-group-item">
                        <a href="{{ url('laporan/both/meme') }}" class="text-body">Meme atau Foto Both </a>
                    </li>
                    <li class="list-group-item" style=" border-bottom-left-radius: 15px !important; border-bottom-right-radius: 15px;">
                        <a href="{{ url('laporan/both/link') }}" class="text-body">Link Berita Both</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
</div>
