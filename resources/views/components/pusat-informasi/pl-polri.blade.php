<div class="col-lg-4 col-md-6">
    <div class="card mb-4">
        <div class="card-header py-3">
            <h5 class="text-center text-white mb-0">
                <b>Peraturan di Luar Lingkungan Polri</b>
            </h5>
        </div>
        <div class="card-body">
            <form method="post" id="form_pl_polri" class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                    <input name="pl_polri" id="pl_polri" class="form-control"
                            placeholder="Cari Peraturan di Luar Polri">
                    <button type="submit" class="input-group-text btn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
            <div class="mt-4">
                <div id="pl_polri-content-wrapper" class="row"></div>
                <div id="pl_polri-message-wrapper"></div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <ul id="paginator-pl_polri" class="pagination my-0"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const pl_polri = new ComponentWithPagination({
        contentWrapper: '#pl_polri-content-wrapper',
        messageWrapper: '#pl_polri-message-wrapper',
        paginator: '#paginator-pl_polri',
        searchState: {
            url: route('show-pl-polri'),
            data: {}
        },
        content: (item) => {
            return `
                <div class="uu-container py-3">
                    <div class="d-flex flex-row">
                        <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                            width="36px" alt="img" loading="lazy">
                        <div style="margin-inline: 0.4em; display: flex; align-self: center;">
                        ${item.deskripsi_uu}
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-preview d-flex align-items-center"
                            id="button_pl_polri_${item.id}"
                            data-bs-toggle="modal" data-bs-target="#modal_pl_polri_${item.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="modal fade" id="modal_pl_polri_${item.id}"
                            tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail peraturan luar</h5>
                                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>${item.nama_uu}</h5>
                                        <p>${item.deskripsi_uu}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" onclick="copy('${item.url_file_uu}', 'App\\Models\\UuLuarPolri', '${item.id}')">
                                            <i class="fas fa-link"></i>Salin Link
                                        </button>
                                        <a class="btn btn-primary"
                                            href="${route('download', {'url': item.file_uu, 'type': 'App\\Models\\UuLuarPolri', 'id': item.id})}">
                                            <i class="fas fa-download mr-2"></i>Unduh
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `
        }
    })

    document.getElementById('form_pl_polri').addEventListener('submit', (event) => {
        event.preventDefault()
        pl_polri.updateState('pl_polri', document.querySelector('input[name=pl_polri]').value)
        pl_polri.updateState('page', 1)
        pl_polri.destroyPaginator()
        pl_polri.fetchData()
    })
</script>
@endpush
