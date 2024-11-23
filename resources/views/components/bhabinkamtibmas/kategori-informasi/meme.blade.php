<div>
    <div class="card-body p-0">
        <div id="meme-content-wrapper" class="row row-cols-3" style="--bs-gutter-x: 0.7rem;"></div>
        <div id="meme-message-wrapper"></div>
        <div class="row py-2">
            <div class="col-md-12 d-flex justify-content-center">
                <ul id="paginator-meme" class="pagination my-0"></ul>
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
                url: route('pencarian-informasi.grouped'),
                data: {
                    type: 'meme',
                    search: '{{ $slot }}',
                    first: 1,
                    latest: true
                }
            },
            content: (data) => {
                let url = `{{config('filesystems.storage_url')}}${data.body.thumbnail}`.replace(/([^:]\/)\/+/g, "$1");
                return `
                    <div class="col d-flex flex-column">
                        <img src="${url}" width="100%" class="img-thumbnail-rectangular" loading="lazy" alt="${data.body.title}">
                        <div style="min-height:42px; max-height: 100px; line-height: 1; overflow-y: scroll;" class="my-1">
                            <small class="fw-bold">${data.body.title}</small>
                        </div>
                        <a class="btn btn-sm text-primary nav-text-small"
                           style="background-color: #CFE5F2;"
                           href="${route('download', {'url': data.body.file, 'type': data.body.key, 'id': data.body.id})}">Unduh</a>
                    </div>
                `
            }
        })
    </script>
@endpush
