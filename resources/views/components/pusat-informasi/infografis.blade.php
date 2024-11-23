<div class="col-md-6">
    <div class="card mb-4 infografis-card">
        <div class="card-header py-3">
            <h5 class="text-center text-white mb-0"><b>Infografis</b></h5>
        </div>
        <div class="card-body">
            <form method="post" id="form_infografis" class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                    <input name="infografis" id="infografis" class="form-control"
                        placeholder="Cari Infografis">
                    <button type="submit" class="input-group-text btn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
            <div class="mt-4">
                <div id="infografis-content-wrapper" class="row g-3"></div>
                <div id="infografis-message-wrapper"></div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <ul id="paginator-infografis" class="pagination my-0"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const infografis = new ComponentWithPagination({
        contentWrapper: '#infografis-content-wrapper',
        messageWrapper: '#infografis-message-wrapper',
        paginator: '#paginator-infografis',
        searchState: {
            url: route('show-infografis'),
            data: dataKontenInformasi ?? {}
        },
        content: (item) => {
            return `
                <div class="col-12 col-lg-4 mb-3">
                    <div class="img-container text-center">
                        <img src="${ item.url_gambar }" alt="${ item.judul}" loading="lazy">
                        <label for="button_modal_infografis_${ item.id }" class="py-2 btn-preview">
                            <i class="fas fa-eye"></i> Detail
                        </label>
                    </div>
                </div>
                <button class="btn d-none text-white bg-blue" id="button_modal_infografis_${ item.id }"
                    data-bs-toggle="modal" data-bs-target="#modal_infografis_${ item.id }">Unduh</button>
                <div class="modal fade" id="modal_infografis_${ item.id }" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail infografis</h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="${ item.url_gambar }" class="w-100 mb-4"
                                    alt="${ item.judul}" loading="lazy">
                                <h5>${ item.judul }</h5>
                                <p>${ item.deskripsi }</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" onclick="copy('${item.url_gambar}', 'App\\Models\\Infografis', '${item.id}')">
                                    <i class="fas fa-link"></i>Salin Link
                                </button>
                                <a class="btn btn-primary"
                                    href="${route('download', {'url': item.gambar, 'type': 'App\\Models\\Infografis', 'id': item.id})}">
                                    <i class="fas fa-download mr-2"></i>Unduh
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `
        }
    })

    document.getElementById('form_infografis').addEventListener('submit', (event) => {
        event.preventDefault()
        infografis.updateState('infografis', document.querySelector('input[name=infografis]').value)
        infografis.updateState('page', 1)
        infografis.destroyPaginator()
        infografis.fetchData()
    })
</script>
@endpush
