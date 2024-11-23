<div class="col-md-6">
    <div style="border-radius: 20px" class="{{$bgColor}} py-2 new-container mb-3">
        <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">Paparan</h6>
    </div>

    <div class="mb-4 uu-container d-block" style="background-color: {{$cardColor}};">
        <form method="post" id="form_paparan" class="form-inline new-container mt-3">
            <div class="input-group mb-2 mr-sm-2">
                <input name="paparan" id="paparan" class="form-control" placeholder="Cari Paparan">
                <button type="submit" class="{{$buttonSearchClass}}">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        <div class="mt-4 ">
            <div id="paparan-content-wrapper" class="row g-3"></div>
            <div id="paparan-message-wrapper"></div>
            <div class="row mb-2">
                <div class="col-md-12 d-flex justify-content-center">
                    <ul id="paginator-paparan" class="pagination my-0"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const paparan = new ComponentWithPagination({
        contentWrapper: '#paparan-content-wrapper',
        messageWrapper: '#paparan-message-wrapper',
        paginator: '#paginator-paparan',
        searchState: {
            url: route('show-paparan'),
            data: {}
        },
        content: (item) => {
            return `
                <div class="col-12 pb-3">
                    <div class="rounded-3 bg-white m-4 mx-5">
                        <div class="thumbnail-paparan-infografis">
                            <img width="100%" height="100%" src="${ item.url_thumbnail }"
                                alt="${item.nama_paparan}" loading="lazy">
                        </div>
                        <div class="d-block p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div style="width: 75%">
                                    <p><b>${item.nama_paparan}</b></p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <label id="detail_paparan_${item.id}" data-bs-toggle="modal"
                                        data-bs-target="#modal_paparan_${item.id}"
                                        class="btn {{$btnColor}} p-2">
                                        <i class="fas fa-eye me-1"></i><span>Detail</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_paparan_${item.id}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Paparan</h5>
                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="${item.url_thumbnail}" loading="lazy"
                                        alt="${item.nama_paparan}" class="w-100 mb-4">
                                    <p>${item.nama_paparan}</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" onclick="copy('${item.url_gambar}', 'App\\Models\\Paparan', '${item.id}')">
                                        <i class="fas fa-link"></i>Salin Link
                                    </button>
                                    <a class="btn {{$btnColor}}"
                                        href="${route('download', {'url': item.gambar, 'type': 'App\\Models\\Paparan', 'id': item.id})}">
                                        <i class="fas fa-download mr-2"></i>Unduh
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `
        }
    })

    document.getElementById('form_paparan').addEventListener('submit', (event) => {
        event.preventDefault()
        paparan.updateState('paparan', document.querySelector('input[name=paparan]').value)
        paparan.updateState('page', 1)
        paparan.destroyPaginator()
        paparan.fetchData()
    })
</script>
@endpush
