@push('styles')
    <style>
        /* The heart of the matter */
        .kategori-informasi-group > .row {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .kategori-informasi-group > .row > .col-6 {
            display: inline-block;
        }

        .card-kategori {
            height: 60px;
            max-height: 60px;
            border-radius: 0.3rem !important;
            margin-bottom: 0.25rem !important;
            box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%) !important;
            overflow: hidden !important;
        }

        .img-kategori {
            width: 40px;
            height: 40px;
        }
    </style>
@endpush
<div class="container-tab-content" id="uu">
    <div class="w-100">
        <h6 class="text-primary border-primary" style="border-bottom: 2px solid">Materi dan Informasi</h6>
        <div class="card">
            <div class="card-body p-0 pb-2 rounded-3">
                <h6 class="header-title bg-primary text-center text-white p-2 rounded fw-bolder text-uppercase">
                    <span class="border-bottom">Kategori Informasi</span></h6>
                <div class="kategori-informasi-group">
                    <div class="row container pe-1">
                        @foreach($kategori->chunk(6) as $chunk)
                            <div class="col-6">
                                <div class="row">
                                    @foreach($chunk as $item)
                                        <div class="card card-kategori"
                                             onclick="document.location.href='{{ route('home-kategori-informasi', $item->id) }}'">
                                            <div class="card-body text-wrap d-flex flex-row align-items-center p-1">
                                                <img src="{{ $item->icon }}" class="img-kategori me-2"
                                                     alt="icon">
                                                <h6 class="text-primary nav-text-small">{{ $item->name }}</h6>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
