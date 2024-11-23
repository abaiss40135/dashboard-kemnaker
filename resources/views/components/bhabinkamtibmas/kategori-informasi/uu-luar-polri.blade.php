<div>
    <div class="card-body p-0">
        <div id="regulasi-eksternal-content-wrapper" class="row row-cols-3"></div>
        <div id="regulasi-eksternal-message-wrapper"></div>
        <div class="row py-2">
            <div class="col-md-12 d-flex justify-content-center">
                <ul id="paginator-regulasi-eksternal" class="pagination my-0"></ul>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const regulasiEksternal = new ComponentWithPagination({
            contentWrapper: '#regulasi-eksternal-content-wrapper',
            messageWrapper: '#regulasi-eksternal-message-wrapper',
            paginator: '#paginator-regulasi-eksternal',
            searchState: {
                url: route('pencarian-informasi.grouped'),
                data: {
                    type: 'uu luar polri',
                    search: '{{ $slot }}',
                    paginate: 10,
                    first: 1,
                    latest: true,
                    all_type: 1
                }
            },
            content: (data) => {
                return `
                    <div class="col-12 py-1">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('img/bhabin/icon/pdf.svg') }}" width="40px" height="40px" loading="lazy" alt="${data.body.title}">
                            <small class="fw-bold w-100 mx-2"> ${data.body.title} </small>
                            <a class="btn btn-sm btn-primary nav-text-small"
                               href="${route('download', {'url': data.body.file, 'type': data.body.key, 'id': data.body.id})}"><i class="fas fa-download"></i></a>
                        </div>
                    </div>
                `
            }
        })
    </script>
@endpush
