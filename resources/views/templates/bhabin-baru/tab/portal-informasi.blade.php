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
        <div class="d-flex justify-content-center align-items-center">
            <h6 style="font-size: 1.35em;" class="mt-3 pl-2">Materi & Informasi</h6>
        </div>
        <hr style="background: #1E4588; height: 3px; opacity:1">

        {{-- paparan --}}
        <div style="border-radius: 20px" class="{{ $configData['navbarColor'] }} py-2">
            <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">Paparan</h6>
        </div>
        <div class="slick-3-item mb-5">
            @foreach($paparan as $item)
                <div class="bg-white m-3 rounded-3">
                    <div class="position-relative w-100" style="height: 300px">
                        <img src="{{ $item->url_thumbnail }}" width="100%" height="100%" loading="lazy"
                             style="position: absolute; inset: 0; object-fit: cover; object-positon: center">
                    </div>
                    <div class="p-3" style="height: 128px; position: relative;">
                        <div style="width: 85%;" class="row justify-content-between">
                            <div class="col-lg-9 col-md-11">
                                    <p style="font-size: 0.9em;"><b>{{ substr($item->nama_paparan, 0, 52) }} @if(strlen($item->nama_paparan) > 52)...@endif</b></p>
                            </div>
                            <div class="col-lg-2 col-md-1">
                                <form action="{{ route('download') }}" method="get">
                                    <input type="hidden" name="url" value="{{ $item->gambar }}">
                                    <button style="font-size: 0.9em;" type="submit" class="btn {{role('satpam') ? 'btn-dark' : 'btn-primary'}}">Unduh</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- infografis --}}
        <div style="border-radius: 20px" class="{{ $configData['navbarColor'] }} py-2">
            <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">Infografis</h6>
        </div>
        <div class="slick-3-item">
            @foreach($infografis as $item)
                <div class="bg-white m-3 rounded-3">
                <div class="position-relative w-100" style="height: 300px">
                    <img src="{{ $item->url_gambar }}" width="100%" height="100%" loading="lazy"
                         style="position: absolute; inset: 0; object-fit: cover; object-positon: center">
                </div>
                <div class="p-3" style="height: 128px; position: relative;">
                    <div style="width:85%;" class="row justify-content-between">
                        <div class="col-lg-9 col-md-11">
                            <p style="font-size: 0.9em;"><b>{{ substr($item->judul, 0, 52) }} @if(strlen($item->judul) > 52)...@endif</b></p>
                        </div>
                        <div class="col-lg-2 col-md-1">
                            <form action="{{ route('download') }}" method="get">
                                <input type="hidden" name="url" value="{{ $item->gambar }}">
                                <button style="font-size: 0.9em;" type="submit" class="btn {{role('satpam') ? 'btn-dark' : 'btn-primary'}}">Unduh</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

{{--        Poster atau Meme--}}
        <div style="border-radius: 20px" class="{{ $configData['navbarColor'] }} py-2">
            <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">Poster atau Meme</h6>
        </div>
        <div class="slick-3-item">
            @foreach($meme as $item)
                <div class="bg-white m-3 rounded-3">
                    <div class="position-relative w-100" style="height: 300px">
                        <img src="{{ $item->url_gambar }}" width="100%" height="100%" loading="lazy"
                             style="position: absolute; inset: 0; object-fit: cover; object-positon: center">
                    </div>
                    <div class="p-3" style="height: 128px; position: relative;">
                        <div style="width:85%;" class="row justify-content-between">
                            <div class="col-lg-9 col-md-11">
                                <p style="font-size: 0.9em;"><b>{{ substr($item->nama_meme, 0, 52) }} @if(strlen($item->nama_meme) > 52)...@endif</b></p>
                            </div>
                            <div class="col-lg-2 col-md-1">
                                <form action="{{ route('download') }}" method="get">
                                    <input type="hidden" name="url" value="{{ $item->gambar }}">
                                    <button style="font-size: 0.9em;" type="submit" class="btn {{role('satpam') ? 'btn-dark' : 'btn-primary'}}">Unduh</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

{{--        bagian ke 2--}}
        <div class="d-flex justify-content-center align-items-center">
            <h6 style="font-size: 1.35em;" class="mt-3 pl-2">UU & Peraturan</h6>
        </div>
        <hr style="background: #1E4588; height: 3px; opacity:1">

        <div class="row">
            {{-- naskah --}}
            <div class="card mb-4" style="background-color: @if(role('satpam')) #8A8A8A @else #BADAFF @endif;">
                <div class="d-flex justify-content-center mt-3">
                    <div style="border-radius: 20px; width: 30vw;" class="rounded-3 {{ $configData['navbarColor'] }} py-2">
                        <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">Naskah</h6>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-lg-flex justify-content-between align-items-center mb-4">
                        @foreach($naskah as $item)
                            <div class="py-3 bg-white m-2 w-auto rounded-3 uu-container px-2">
                                <div class="d-flex flex-row">
                                    <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                         width="30px" alt="img" loading="lazy">
                                    <div style="font-size: 0.8em; margin-inline: 0.4em; display: flex; align-self: center;">
                                        {{ $item->nama_naskah }}
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-preview d-flex align-items-center"
                                            id="button_uu_{{ $item->id }}"
                                            data-bs-toggle="modal" data-bs-target="#modal_uu_{{ $item->id }}">
                                        <i style="font-size: 0.8em;" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- modal naskah --}}
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
                                                <button type="submit" class="btn {{role('satpam') ? 'btn-dark' : 'btn-primary'}}">
                                                    <i class="fas fa-download"></i> Unduh
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

{{--            uu --}}
            <div class="card mb-4" style="background-color: @if(role('satpam')) #8A8A8A @else #BADAFF @endif;">
                <div class="d-flex justify-content-center mt-3">
                    <div style="border-radius: 20px; width: 30vw;" class="rounded-3 {{ $configData['navbarColor'] }} py-2">
                        <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">Undang Undang</h6>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-lg-flex justify-content-between align-items-center mb-4">
                        @foreach($undangUndang as $item)
                            <div class="w-auto py-3 bg-white m-2 px-2 rounded-3 uu-container">
                                <div class="d-flex flex-row">
                                    <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                         width="30px" alt="img" loading="lazy">
                                    <div style="font-size: 0.8em; margin-inline: 0.4em; display: flex; align-self: center;">
                                        {{ $item->deskripsi_uu }}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-preview d-flex align-items-center"
                                            id="button_uu_{{ $item->id }}"
                                            data-bs-toggle="modal" data-bs-target="#modal_uu_{{ $item->id }}">
                                        <i style="font-size: 0.8em;" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- modal uu --}}
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
                                                <button type="submit" class="btn {{role('satpam') ? 'btn-dark' : 'btn-primary'}}">
                                                    <i class="fas fa-download"></i> Unduh
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

{{--            peraturan di lingkungan polri--}}
            <div class="col-lg-6 mb-4">
                <div class="card" style="background-color: @if(role('satpam')) #8A8A8A @else #BADAFF @endif;">
                    <div class="d-flex justify-content-center mt-3">
                        <div style="border-radius: 20px; width: 30vw;" class="rounded-3 {{ $configData['navbarColor'] }} py-2">
                            <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">Peraturan di Lingkungan POLRI</h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($peraturanDalam as $item)
                                <div class="d-flex justify-content-center">
                                    <div style="width: 97%;" class="uu-container py-3 my-2 bg-light rounded-3">
                                        <div style="width: 85%;" class="d-flex flex-row">
                                            <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                                    width="35px" alt="img" loading="lazy">
                                            <div style="font-size: 0.9em; margin-inline: 0.4em; display: flex; align-self: center;">
                                                {{ $item->deskripsi_uu }}
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mx-2">
                                            <button class="btn btn-preview d-flex align-items-center"
                                                id="button_uu_{{ $item->id }}"
                                                data-bs-toggle="modal" data-bs-target="#modal_uu_{{ $item->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

{{--                                modal--}}
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
                                                    <button type="submit" class="btn {{role('satpam') ? 'btn-dark' : 'btn-primary'}}">
                                                        <i class="fas fa-download mr-2"></i> Unduh
                                                    </button>
                                                </form>
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
                <div class="card" style="background-color: @if(role('satpam')) #8A8A8A @else #BADAFF @endif;">
                    <div class="d-flex justify-content-center mt-3">
                        <div style="border-radius: 20px; width: 30vw;" class="rounded-3 {{ $configData['navbarColor'] }} py-2">
                            <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">Peraturan di Luar Lingkungan POLRI</h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($peraturanLuar as $item)
                                <div class="d-flex justify-content-center">
                                    <div style="width: 97%;" class="uu-container py-3 my-2 bg-light rounded-3">
                                        <div style="width: 85%;" class="d-flex flex-row">
                                            <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                                 width="35px" alt="img" loading="lazy">
                                            <div style="font-size: 0.9em; margin-inline: 0.4em; display: flex; align-self: center;">
                                                {{ $item->deskripsi_uu }}
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mx-2">
                                            <button class="btn btn-preview d-flex align-items-center"
                                                    id="button_uu_{{ $item->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#modal_uu_{{ $item->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

{{--                                modal--}}
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
                                                    <button type="submit" class="btn {{role('satpam') ? 'btn-dark' : 'btn-primary'}}">
                                                        <i class="fas fa-download"></i> Unduh
                                                    </button>
                                                </form>
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



        {{-- link website terkait --}}
        <div class="d-flex justify-content-center align-items-center">
            <h6 style="font-size: 1.35em;" class="mt-3 pl-2">Link Satker Internal POLRI</h6>
        </div>
        <hr style="background: #1E4588; height: 3px; opacity:1">

       @component('components.link-satker-bhabin-baru', ['link' => $link]) @endcomponent

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
