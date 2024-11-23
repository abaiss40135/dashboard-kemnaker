<div class="col-md-6">
    <div class="card mb-4 meme-card">
        <div class="card-header py-3">
            <h5 class="text-center text-white mb-0"><b>Meme</b></h5>
        </div>
        <div class="card-body">
            <form method="post" id="form_meme" class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                    <input name="meme" id="meme" class="form-control" placeholder="Cari Meme">
                    <button type="submit" class="input-group-text btn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
            <div class="mt-4">
                <div id="meme-content-wrapper" class="row g-3"></div>
                <div id="meme-message-wrapper"></div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <ul id="paginator-meme" class="pagination my-0"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const meme = new ComponentWithPagination({
        contentWrapper: '#meme-content-wrapper',
        messageWrapper: '#meme-message-wrapper',
        paginator: '#paginator-meme',
        searchState: {
            url: "{{ route('show-meme') }}",
            data: dataKontenInformasi ?? {}
        },
        content: (item) => {
            return `
                <div class="col-12 col-lg-4 mb-3">
                    <div class="img-container text-center">
                        <img src="${ item.url_gambar }" loading="lazy"
                            alt="${ item.nama_meme }">
                        <label for="button_modal_meme_${ item.id }" class="py-2 btn-preview">
                            <i class="fas fa-eye"></i> Detail
                        </label>
                    </div>
                </div>
                <button class="btn d-none text-white bg-blue" id="button_modal_meme_${ item.id }"
                    data-bs-toggle="modal" data-bs-target="#modal_meme_${ item.id }">Unduh</button>
                <div class="modal fade" id="modal_meme_${ item.id }" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Meme</h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="${ item.url_gambar }" class="w-100 mb-4"
                                    alt="${ item.nama_meme}" loading="lazy">
                                <h5>${ item.nama_meme }</h5>
                                <p>${ item.caption }</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" onclick="copy('${item.url_gambar}', 'App\\Models\\Meme', '${item.id}')">
                                    <i class="fas fa-link"></i>Salin Link
                                </button>
                                <a class="btn btn-primary"
                                    href="${route('download', {'url': item.gambar, 'type': 'App\\Models\\Meme', 'id': item.id})}">
                                    <i class="fas fa-download mr-2"></i>Unduh
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `
        }
    })

    document.getElementById('form_meme').addEventListener('submit', (event) => {
        event.preventDefault()
        meme.updateState('meme', document.querySelector('input[name=meme]').value)
        meme.updateState('page', 1)
        meme.destroyPaginator()
        meme.fetchData()
    })
</script>
@endpush
