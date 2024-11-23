<div class="card mb-4 card-pusat-informasi">
    <div style="border-radius: 10px" class="{{$bgColor}} py-2 new-container mb-3">
        <h6 style="font-size: 1.3em;" class="text-center text-white mb-0">Undang-Undang</h6>
    </div>
    <div class="card-body">
        <form method="post" id="form_uu" class="form-inline container">
            <div class="input-group mb-2 mr-sm-2">
                <input name="uu" id="uu" class="form-control" placeholder="Cari Undang-Undang">
                <button type="submit" class="{{$buttonSearchClass}}">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        <div class="mt-4">
            <div id="uu-content-wrapper" class="d-md-flex justify-content-between"></div>
            <div id="uu-message-wrapper"></div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <ul id="paginator-uu" class="pagination my-0"></ul>
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
                <div class="w-auto py-3 bg-white m-2 px-2 rounded-3 uu-container">
                    <div class="d-flex flex-row" style="width: 80%;">
                        <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                             width="30px" alt="img" loading="lazy">
                        <div style="font-size: 0.8em; margin-inline: 0.4em; display: flex; align-self: center;">
                            ${item.deskripsi_uu}
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button class="btn btn-preview d-flex align-items-center py-1 px-3" style="font-size: 1em"
                            id="button_uu_${item.id }"
                            data-bs-toggle="modal" data-bs-target="#modal_uu_${item.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

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
                                    <a class="btn {{$btnColor}}"
                                        href="${route('download', {'url': item.file_uu, 'type': 'App\\Models\\Uu', 'id': item.id})}">
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

        document.getElementById('form_uu').addEventListener('submit', (event) => {
            event.preventDefault()
            uu.updateState('uu', document.querySelector('input[name=uu]').value)
            uu.updateState('page', 1)
            uu.destroyPaginator()
            uu.fetchData()
        })
    </script>
@endpush
