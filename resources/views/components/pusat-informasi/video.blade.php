<div class="card mb-4 video-card">
    <div class="card-header py-3">
        <h5 class="text-center text-white mb-0"><b>Video Informasi</b></h5>
    </div>
    <div class="card-body">
        <form method="post" id="form_video" class="form-inline">
            <div class="input-group mb-2 mr-sm-2">
                <input name="video" id="video" class="form-control" placeholder="Cari Video">
                <button type="submit" class="input-group-text btn">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        <div class="mt-4">        
            <div id="video-content-wrapper" class="row g-3"></div>
            <div id="video-message-wrapper"></div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <ul id="paginator-video" class="pagination my-0"></ul>
                </div>
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
            url: "{{ route('show-video') }}",
            data: dataKontenInformasi ?? {}
        },
        content: (item) => {
            return `                
                <div class="col-sm-6 col-md-4 pb-3">
                    <div style="background: rgba(50, 50, 50, 0.16)">
                        <video controls preload="metadata" width="100%">
                            <source src="${item.url_file_video}" type="video/mp4">
                        </video>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p><b>${item.judul_video}</b></p>
                                <small>${item.tanggal_diunggah}</small>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-primary"
                                    href="${route('download', {'url': item.file_video, 'type': 'App\\Models\\VideoLanding', 'id': item.id})}">
                                    <i class="fas fa-download mr-2"></i>Unduh
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `
        }
    })

    document.getElementById('form_video').addEventListener('submit', (event) => {
        event.preventDefault()
        video.updateState('video', document.querySelector('input[name=video]').value)
        video.updateState('page', 1)
        video.destroyPaginator()
        video.fetchData()
    })

</script>
@endpush
