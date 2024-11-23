@push('styles')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
@endpush
<div class="container-tab-content" id="dokumentasi">
    <!-- untuk kontent tanggal dan isi berita -->
    <div class="content-left w-100">
        <!-- isi atensi -->
        <div class="loader">
            @component('components.shimer-atensi') @endcomponent
        </div>
        <div id="atensi-pimpinan-list" class="page-content hide">

        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <ul id="pagination-atensi" class="pagination"></ul>
            </div>
        </div>
        <br>
        <br>
    </div>
</div>
@push('scripts')
    <script>
        const pagination_btn = document.querySelectorAll(".paginate nav ul li span");
        const tab_btn = document.querySelectorAll('.tab-links')
        const atensi_pimpinan_btn = document.querySelector("#atensiPimpinan");
        const atensiPimpinanList = $('#atensi-pimpinan-list');
        const selectorPagination = $('#pagination-atensi');

        atensi_pimpinan_btn.addEventListener('click', function () {
            /* $.ajax({
                 type: 'POST',
                 url: '/notification-atensi-pimpinan',
                 dataType: 'JSON',
                 success: function (result) {

                 }
             })*/

            showLoader();
            loadAtensiPimpinanList({
                url: "{{ route('atensi-pimpinan.index', ['role' => auth()->user()->role()]) }}"
            })
        })

        function loadAtensiPimpinanList(options) {
            // Make a request for a user with a given ID
            axios.get(options.url, options[0] ?? {})
                .then(function (response) {
                    let result = response.data;
                    generateList(result)
                    if (result.last_page > 1) {
                        initPaginate(result)
                    }
                    const isi_atensi = document.querySelectorAll('.isi_atensi')
                    isi_atensi.textContent = result
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                    hideLoader();
                });
        }

        function initPaginate(data) {
            const totalPages = data.last_page;
            const defaultOpts = {
                totalPages: totalPages,
                first: '<i class="fa fa-angle-double-left"></i> Pertama',
                last: 'Terakhir <i class="fa fa-angle-double-right"></i> ',
                prev: '<i class="fa fa-angle-left"></i> Sebelumnya',
                next: 'Selanjutnya <i class="fa fa-angle-right"></i> ',
            }
            const currentPage = selectorPagination.twbsPagination('getCurrentPage');
            selectorPagination.twbsPagination(defaultOpts);
            selectorPagination.twbsPagination('destroy');
            selectorPagination.twbsPagination($.extend({}, defaultOpts, {
                startPage: currentPage,
                totalPages: totalPages
            }));
            let newOptions = {
                url: data.path
            }
            selectorPagination.on('page', function (evt, page) {
                const request = Object.assign(newOptions, [{
                    page: page,
                }]);
                getData(request);
            });
        }

        function generateList(data) {
            atensiPimpinanList.html('');
            data.data?.map((item) => {
                atensiPimpinanList.append(generateCardAtensiPimpinan(item));
            });
        }

        function generateCardAtensiPimpinan(options) {
            let url = "{{ route('bhabinkamtibmas.atensi-pimpinan.show', ':id') }}";
            let urlRead = url.replace(':id', options.id);
            let html = `
            <div class="bg-white atensi-row mt-3" style="margin-left: 20px; border-radius: 12px;">
                <div class="col-md">
                    <div style="padding: 30px;" class='content_container'>
                        <a href="${urlRead}" style="color : #1E4588;" class="text-decoration-none">
                            <p class="judul_atensi" style=" color: #1E4588; font-weight: bold; font-size: 22px;">
                                ${options.judul}
                            </p>
                        </a>
                        <div class="d-md-flex justify-content-md-between">
                            <p style="color: #757575; "><small>${formatDate(options.created_at)}</small></p>
                            <p style="color: #1E4588; font-weight: 500;"><small>Oleh: ${options.pemberi} </small></p>
                        </div>
                        <div class="desc isi_atensi">${options.isi}</div>
                    </div>
                </div>
            </div>`;
            return html;
        }

        function showLoader() {
            $('.loader').show();
            hideContent();
        }

        function hideLoader() {
            $('.loader').hide();
            showContent();
        }

        function showContent() {
            atensiPimpinanList.show();
        }

        function hideContent() {
            atensiPimpinanList.hide();
        }

        function getData(options) {
            showLoader();
            loadAtensiPimpinanList(options);
        }

        function showPagination() {
            selectorPagination.show();
        }

        function destroyPagination() {
            showPagination();
            selectorPagination.twbsPagination('destroy');
        }

    </script>
@endpush
