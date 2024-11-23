<div class="card mb-4">
    <div class="card-header py-3">
        <h5 class="text-center text-white mb-0"><b>Naskah</b></h5>
    </div>
    <div class="card-body">
        <form method="post" id="form_naskah" class="form-inline">
            <div class="input-group mb-2 mr-sm-2">
                <input name="naskah" id="naskah" class="form-control" placeholder="Cari Naskah">
                <button type="submit" class="input-group-text btn">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        <div class="mt-4">
            <div id="naskah-content-wrapper" class="row"></div>
            <div id="naskah-message-wrapper"></div>
            <div class="row mt-2">
                <div class="col-md-12 d-flex justify-content-center">
                    <ul id="paginator-naskah" class="pagination my-0"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const naskah = new ComponentWithPagination({
        contentWrapper: '#naskah-content-wrapper',
        messageWrapper: '#naskah-message-wrapper',
        paginator: '#paginator-naskah',
        searchState: {
            url: "{{ route('show-naskah') }}",
            data: {}
        },
        content: (item) => {
            return `
                <div class="uu-container py-2">
                    <div class="d-flex flex-row">
                        <img src="{{ asset('img/bhabin/icon/pdf.svg') }}" width="42px" alt="img">
                        <div style="margin-inline: 0.4em; display: flex; align-self: center;">
                            ${item.nama_naskah}
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-preview text-white bg-blue d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#modal_naskah_${item.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="modal fade" id="modal_naskah_${item.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Naskah</h5>
                                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>${item.nama_naskah}</h5>
                                        <p>${item.deskripsi_naskah ?? ''}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" onclick="copy('${item.url_file_naskah}', 'App\\Models\\Naskah', '${item.id}')">
                                            <i class="fas fa-link"></i>Salin Link
                                        </button>
                                        <a class="btn btn-primary"
                                            href="${route('download', {'url': item.file_naskah, 'type': 'App\\Models\\Naskah', 'id': item.id})}">
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

    document.getElementById('form_naskah').addEventListener('submit', (event) => {
        event.preventDefault()
        naskah.updateState('naskah', document.querySelector('input[name=naskah]').value)
        naskah.updateState('page', 1)
        naskah.destroyPaginator()
        naskah.fetchData()
    })
</script>
@endpush
