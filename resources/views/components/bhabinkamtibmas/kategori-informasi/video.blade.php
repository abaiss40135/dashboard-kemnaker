<div>
    <div class="card-body">
        <div id="video-content-wrapper" class="row"></div>
        <div id="video-message-wrapper"></div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <ul id="paginator-video" class="pagination my-0"></ul>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const video = new ComponentWithPagination({
            contentWrapper: '#video-content-wrapper',
            messageWrapper: '#video-message-wrapper',
            paginator: '#paginator-video',
            searchState: {
                url: route('pencarian-informasi.grouped'),
                data: {
                    type: 'video',
                    search: "{{ $slot }}",
                    paginate: 1,
                    first: 1,
                    latest: true
                }
            },
            content: (data) => {
                let url = `{{config('filesystems.storage_url')}}${data.body.thumbnail}`.replace(/([^:]\/)\/+/g, "$1");
                return `
                    <div class="position-relative w-100" style="height: 200px;">
                        <video
                            style="position: absolute; inset: 0; object-fit: cover; object-position: center; width: 100%; height: 100%"
                            controls preload="metadata" class="video-landing" id="bhabin-video${data.id}">
                            <source src="${url}" type="video/mp4">
                        </video>
                    </div>
                    <div class="py-1 px-0 text-primary">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                           <h6 class="fw-bold">${data.body.title.length > 72 ? `${data.body.title.substring(0, 72)}...` : data.body.title}</h6>
                           <a class="btn btn-sm btn-primary"
                              href="${route('download', {'url': data.body.file, 'type': data.body.key, 'id': data.body.id})}"><i class="fas fa-download"></i></a>
                        </div>
                    </div>
                `
            }
        })
    </script>
@endpush
