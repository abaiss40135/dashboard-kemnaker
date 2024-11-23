<div class="col-lg-4">
    <div class="card mb-4">
        <div class="card-header py-3">
            <h5 class="text-center text-white mb-0"><b>Undang-Undang</b></h5>
        </div>
        <div class="card-body">
            <form method="post" id="form_uu" class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                    <input name="uu" id="uu" class="form-control" placeholder="Cari Undang-Undang">
                    <button type="submit" class="input-group-text btn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
            <div class="mt-4">
                <div id="uu-content-wrapper" class="row"></div>
                <div id="uu-message-wrapper"></div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <ul id="paginator-uu" class="pagination my-0"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const uu = new ComponentWithPagination({
        contentWrapper: '#uu-content-wrapper',
        messageWrapper: '#uu-message-wrapper',
        paginator: '#paginator-uu',
        searchState: {
            url: route('show-uu'),
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
                            id="button_uu_${item.id }"
                            data-bs-toggle="modal" data-bs-target="#modal_uu_${item.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="modal fade" id="modal_uu_${item.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Undang-Undang</h5>
                                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>${item.nama_uu}</h5>
                                        <p>${item.deskripsi_uu}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" onclick="copy('${item.url_file_uu}', 'App\\Models\\Uu', '${item.id}')">
                                            <i class="fas fa-link"></i>Salin Link
                                        </button>
                                        <a class="btn btn-primary"
                                            href="${route('download', {'url': item.file_uu, 'type': 'App\\Models\\Uu', 'id': item.id})}">
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

    document.getElementById('form_uu').addEventListener('submit', (event) => {
        event.preventDefault()
        uu.updateState('uu', document.querySelector('input[name=uu]').value)
        uu.updateState('page', 1)
        uu.destroyPaginator()
        uu.fetchData()
    })
</script>
@endpush
