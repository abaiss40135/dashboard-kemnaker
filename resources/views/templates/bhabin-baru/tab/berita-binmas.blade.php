@push('styles')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
@endpush
<div class="container-tab-content" id="berita">
    {{-- konten berita --}}
    <div class="content-left w-100">
        <div class="loader">
            @component('components.shimer-berita-binmas') @endcomponent
        </div>
        <div id="berita-binmas-list" class="page-content hide"></div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <ul id="pagination-berita-binmas" class="pagination"></ul>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const tabBeritaBinmas = document.querySelector("#beritaBinmas");
        const beritaBinmasList = $('#berita-binmas-list');
        const selectorPaginationBeritaBinmas = $('#pagination-berita-binmas');

        tabBeritaBinmas.addEventListener('click', function () {
            ajaxBeritaBinmas();
        })

        const ajaxBeritaBinmas = () => {
            showLoaderBerita();
            loadBeritaBinmasList({url : "{{ route('berita-binmas.index') }}"});
        }
        ajaxBeritaBinmas();

        function loadBeritaBinmasList(options){
            // Make a request for a user with a given ID
            $.ajax({
                type: 'GET',
                url: options.url,
                data: options[0] ?? {},
                dataType: 'JSON',
                success: function (result) {

                    hideLoaderBerita();
                    generateListBerita(result)
                    if (result.last_page > 1){
                        initPaginateBinmas(result)
                    }
                }
            });
        }

        function initPaginateBinmas(data){
            const totalPages = data.last_page;
            const defaultOpts = {
                totalPages: totalPages,
                first: '<i class="fa fa-angle-double-left"></i> Pertama',
                last: 'Terakhir <i class="fa fa-angle-double-right"></i> ',
                prev: '<i class="fa fa-angle-left"></i> Sebelumnya',
                next: 'Selanjutnya <i class="fa fa-angle-right"></i> ',
            }
            const currentPage = selectorPaginationBeritaBinmas.twbsPagination('getCurrentPage');
            selectorPaginationBeritaBinmas.twbsPagination(defaultOpts);
            selectorPaginationBeritaBinmas.twbsPagination('destroy');
            selectorPaginationBeritaBinmas.twbsPagination($.extend({}, defaultOpts, {
                startPage: currentPage,
                totalPages: totalPages
            }));
            let newOptions = {
                url : data.path
            }
            selectorPaginationBeritaBinmas.on('page', function (evt, page) {
                const request = Object.assign( newOptions, [{
                    page: page,
                }]);
                getDataBerita(request);
            });
        }

        function generateListBerita(data) {
            beritaBinmasList.html('');
            data.data?.map((item) => {
                beritaBinmasList.append(generateCardBeritaBinmas(item));
            });
        }

        function generateCardBeritaBinmas(options) {
            let url = "{{ route('berita-binmas.show', ':id') }}";
            let urlRead = url.replace(':id', options.id);
            let linkIcon = "{{ asset('images/icons/link.png') }}"

            if(options.link == null){
                  return `
                    <div class="row mt-3 bg-white p-3 rounded mx-3" id="row_berita">
                        <div class="col-3" style="width: 100px; height:100px; background-image: url('${options.url_gambar}'); background-position: center; background-size:cover;">
                        </div>
                        <div class="col">
                            <a href="${urlRead}" class="text-body text-decoration-none">
                                <h6 class="news-title" style="font-size: 18px">${options.judul}</h6>
                            </a>
                            <p class="news-date" style=" height:fit-content; margin-top:-5px; color: #919191;">
                                <small>${ options.tanggal_dibuat }</small>
                            </p>
                        </div>
                    </div>`;
            }
            else{
                return `
                    <div class="row mt-3 bg-white p-3 rounded mx-3" id="row_berita">
                        <div class="col-3" style="width: 100px; height:100px;  background-image: url('${linkIcon}'); background-position: center; background-size:cover;">
                        </div>
                        <div class="col">
                            <a href="${urlRead}" class="text-body text-decoration-none">
                                <h6 class="news-title" style="font-size: 18px">${options.judul}</h6>
                            </a>
                            <p class="news-date" style=" height:fit-content; margin-top:-5px; color: #919191;"><small> ${ options.created_at }</small></p>

                        </div>
                    </div>`;
            }
        }

        function showLoaderBerita() {
            $('.loader').show();
            hideContentBerita();
        }

        function hideLoaderBerita() {
            $('.loader').hide();
            showContentBerita();
        }

        function showContentBerita() {
            beritaBinmasList.show();
        }

        function hideContentBerita() {
            beritaBinmasList.hide();
        }

        function getDataBerita(options) {
            showLoaderBerita();
            loadBeritaBinmasList(options);
        }

        function showPaginationBerita(){
            selectorPaginationBeritaBinmas.show();
        }

        function destroyPagination(){
            showPaginationBerita();
            selectorPaginationBeritaBinmas.twbsPagination('destroy');
        }
    </script>
@endpush
