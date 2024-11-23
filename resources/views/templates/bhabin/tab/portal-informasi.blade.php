@push('styles')
    <style>
        .uu-container {
            display: flex;
            justify-content: space-between;
        }

        .uu-container:hover {
            background-color: #eaeaea
        }

        .card .card-header {
            border-bottom: 3px solid #a7bee5;
        }

        .badge {
            position: absolute;
            right: 1rem;
            top: 31%;
        }
    </style>
@endpush
<div class="row container-tab-content mb-5" id="uu">
    <!-- untuk kontent tanggal dan isi berita -->
    <div class="content-left mt-3 px-4">
        <h6 style="color: #1E4588" class="mt-3 pl-2">Materi dan Informasi</h6>
        <hr style="background: #1E4588; height: 2px; opacity:1">

        {{-- paparan --}}
        <div class="card mb-4">
            <div class="card-header bg-light text-center h5">
                Paparan
{{--                <span class="badge bg-danger" id="paparanTab">{{ $paparanNotification }}</span>--}}
            </div>
            <div class="p-3">
                <div class="slick-3-item">
                    @foreach($paparan as $item)
                        <div class="px-1">
                            <div class="position-relative w-100" style="height: 300px">
                                <img src="{{ $item->url_thumbnail }}" width="100%" height="100%" loading="lazy"
                                     style="position: absolute; inset: 0; object-fit: cover; object-positon: center">
                            </div>
                            <div class="p-3" style="height: 128px; position: relative; background: rgba(50, 50, 50, 0.16)">
                                <p><b>{{ substr($item->nama_paparan, 0, 72) }} @if(strlen($item->nama_paparan) > 72)...@endif</b></p>
                                <div style="position: absolute; right: 1.2rem; bottom: 1.2rem">
                                    <div class="d-flex justify-content-end align-items-end">
                                        <form action="{{ route('download') }}" method="get">
                                            <input type="hidden" name="url" value="{{ $item->gambar }}">
                                            <button type="submit" class="btn btn-primary">Unduh</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- infografis --}}
        <div class="card mb-4">
            <div class="card-header bg-light text-center h5">
                Infografis
{{--                <span class="badge bg-danger" id="infografisTab">{{ $infografisNotification }}</span>--}}
            </div>
            <div class="p-3">
                <div class="slick-3-item">
                    @foreach($infografis as $item)
                    <div class="px-1">
                        <div class="position-relative w-100" style="height: 300px">
                            <img src="{{ $item->url_gambar }}" width="100%" height="100%" loading="lazy"
                                 style="position: absolute; inset: 0; object-fit: cover; object-positon: center">
                        </div>
                        <div class="p-3" style="height: 128px; position: relative; background: rgba(50, 50, 50, 0.16)">
                            <p><b>{{ substr($item->judul, 0, 72) }} @if(strlen($item->judul) > 72)...@endif</b></p>
                            <div style="position: absolute; right: 1.2rem; bottom: 1.2rem">
                                <div class="d-flex justify-content-end align-items-end">
                                    <form action="{{ route('download') }}" method="get">
                                        <input type="hidden" name="url" value="{{ $item->gambar }}">
                                        <button type="submit" class="btn btn-primary">Unduh</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-light text-center h5">
                Poster atau Meme
{{--                <span class="badge bg-danger" id="memeTab">{{ $memeNotification }}</span>--}}
            </div>
            <div class="body-poster p-3">
                <div class="slick-3-item">
                    @foreach($meme as $item)
                        <div class="paparan-item px-1">
                            <div class="position-relative w-100" style="height: 300px">
                                <img src="{{ $item->url_gambar }}" width="100%" height="100%" loading="lazy"
                                    style="position: absolute; inset: 0; object-fit: cover; object-positon: center">
                            </div>
                            <div class="p-3" style="height: 128px; position: relative; background: rgba(50, 50, 50, 0.16)">
                                <p><b>{{ substr($item->nama_meme, 0, 72) }} @if(strlen($item->nama_meme) > 72)...@endif</b></p>
                                <div style="position: absolute; right: 1.2rem; bottom: 1.2rem">
                                    <div class="d-flex justify-content-end align-items-end">
                                        <form action="{{ route('download') }}" method="get">
                                            <input type="hidden" name="url" value="{{ $item->gambar }}">
                                            <button type="submit" class="btn btn-primary">Unduh</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <h6 style="color: #1E4588" class="mt-4 ml-2">UU & Peraturan</h6>
        <hr style="background: #1E4588; height: 2px; opacity:1">

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-light text-center h5">
                        Peraturan <br>di Lingkungan Polri
{{--                        <span class="badge bg-danger" id="peraturanDalamTab">{{ $peraturanDalamNotification }}</span>--}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($peraturanDalam as $item)
                                <div class="uu-container py-3">
                                    <div class="d-flex flex-row">
                                        <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                                width="42px" alt="img" loading="lazy">
                                        <div style="margin-inline: 0.4em; display: flex; align-self: center;">
                                            {{ $item->deskripsi_uu }}
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-preview d-flex align-items-center"
                                            id="button_uu_{{ $item->id }}"
                                            data-bs-toggle="modal" data-bs-target="#modal_uu_{{ $item->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="modal_uu_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header"><b>{{ $item->nama_uu }}</b></div>
                                                    <div class="modal-body">
                                                        <p>{{ $item->deskripsi_uu }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary bg-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <form action="{{ route('download') }}" method="GET">
                                                            <input type="hidden" name="url" value="{{ $item->file_uu }}">
                                                            <button type="submit" class="btn btn-primary bg-primary">
                                                                <i class="fas fa-download mr-2"></i> Unduh
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- peraturan luar polri --}}
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-light text-center h5">
                        Peraturan <br>di Luar Lingkungan Polri
{{--                        <span class="badge bg-danger" id="peraturanLuarTab">{{ $uuLuarPolriNotification }}</span>--}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($peraturanLuar as $item)
                                <div class="uu-container py-3">
                                    <div class="d-flex flex-row">
                                        <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                                width="42px" alt="img" loading="lazy">
                                        <div style="margin-inline: 0.4em; display: flex; align-self: center;">
                                            {{ $item->deskripsi_uu }}
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-preview d-flex align-items-center"
                                            id="button_uu_{{ $item->id }}"
                                            data-bs-toggle="modal" data-bs-target="#modal_uu_{{ $item->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="modal_uu_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header"><b>{{ $item->nama_uu }}</b></div>
                                                    <div class="modal-body">
                                                        <p>{{ $item->deskripsi_uu }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary bg-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <form action="{{ route('download') }}" method="GET">
                                                            <input type="hidden" name="url" value="{{ $item->file_uu }}">
                                                            <button type="submit" class="btn btn-primary bg-primary">
                                                                <i class="fas fa-download"></i> Unduh
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- uu --}}
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header bg-light text-center h5">
                        Undang-Undang
{{--                        <span class="badge bg-danger" id="undangUndangTab">{{ $undangUndangNotification }}</span>--}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($undangUndang as $item)
                                <div class="uu-container py-3">
                                    <div class="d-flex flex-row">
                                        <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                                width="42px" alt="img" loading="lazy">
                                        <div style="margin-inline: 0.4em; display: flex; align-self: center;">
                                            {{ $item->deskripsi_uu }}
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-preview d-flex align-items-center"
                                            id="button_uu_{{ $item->id }}"
                                            data-bs-toggle="modal" data-bs-target="#modal_uu_{{ $item->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="modal_uu_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header"><b>{{ $item->nama_uu }}</b></div>
                                                    <div class="modal-body">
                                                        <p>{{ $item->deskripsi_uu }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary bg-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <form action="{{ route('download') }}" method="GET">
                                                            <input type="hidden" name="url" value="{{ $item->file_uu }}">
                                                            <button type="submit" class="btn btn-primary bg-primary">
                                                                <i class="fas fa-download"></i> Unduh
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- naskah --}}
        <div class="card mb-4">
            <div class="card-header bg-light text-center h5">
{{--                Naskah <span class="badge bg-danger" id="naskahTab">{{ $naskahNotification }}</span>--}}
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($naskah as $item)
                        <div class="uu-container py-3">
                            <div class="d-flex flex-row">
                                <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                        width="42px" alt="img" loading="lazy">
                                <div style="margin-inline: 0.4em; display: flex; align-self: center;">
                                    {{ $item->nama_naskah }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-preview d-flex align-items-center"
                                    id="button_uu_{{ $item->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modal_uu_{{ $item->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="modal fade" id="modal_uu_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h5>{{ $item->nama_naskah }}</h5>
                                                <p>{{ $item->deskripsi_naskah }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary bg-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <form action="{{ route('download') }}" method="GET">
                                                    <input type="hidden" name="url" value="{{ $item->file_naskah }}">
                                                    <button type="submit" class="btn btn-primary bg-primary">
                                                        <i class="fas fa-download"></i> Unduh
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- link website terkait --}}
        <div class="card">
            <div class="card-header bg-light text-center h5">
                Link Satker Internal Polri
            </div>
            <div class="card-body">
               @component('components.link-satker', ['link' => $link]) @endcomponent
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    const portal_informasi_btn = document.querySelector('#portalInformasi');
    /*const infografisTab = document.querySelector('#infografisTab')
    const paparanTab = document.querySelector('#paparanTab')
    const memeTab = document.querySelector('#memeTab')
    const peraturanDalamTab = document.querySelector('#peraturanDalamTab')
    const peraturanLuarTab = document.querySelector('#peraturanLuarTab')
    const undangUndangTab = document.querySelector('#undangUndangTab')
    const naskahTab = document.querySelector('#naskahTab')

    if (infografisTab.textContent <= 0) infografisTab.style.display = 'none';
    if (paparanTab.textContent <= 0) paparanTab.style.display = 'none';
    if (memeTab.textContent <= 0) memeTab.style.display = 'none';
    if (peraturanDalamTab.textContent <= 0) peraturanDalamTab.style.display = 'none';
    if (peraturanLuarTab.textContent <= 0) peraturanLuarTab.style.display = 'none';
    if (undangUndangTab.textContent <= 0) undangUndangTab.style.display = 'none';
    if (naskahTab.textContent <= 0) naskahTab.style.display = 'none';*/

    // mengurangi jumlah notifikasi ketika sudah mengklik tab portal informasi
    portal_informasi_btn.addEventListener('click', function(){
        /*$.ajax({
            type : 'POST',
            url  : '/notification-infografis',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            success : function (result){}
        })
        $.ajax({
            type : 'POST',
            url  : '/notification-paparan',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            success : function (result){}
        })
        $.ajax({
            type : 'POST',
            url  : '/notification-meme',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            success : function (result){}
        })
        $.ajax({
            type : 'POST',
            url  : '/notification-peraturan-dalam-polri',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            success : function (result){}
        })
        $.ajax({
            type : 'POST',
            url  : '/notification-peraturan-luar-polri',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            success : function (result){}
        })
        $.ajax({
            type : 'POST',
            url  : '/notification-undang-undang',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            success : function (result){}
        })
        $.ajax({
            type : 'POST',
            url  : '/notification-naskah',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            success : function (result){}
        })*/
    })
</script>
@endpush
