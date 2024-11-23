<script>
    function fillAtLeastOne(options){
        let errors = [];
        const data = [...options.selector.serializeArray()];
        data?.map((item)=>{
            if(!((item.value) && options.excepts.includes(item.name)) && (item.value)){
                errors.push(item.name);
            }
        })
        return errors.length > 0;
    }

    function initChartPendapatWarga(provinsi){
        $('#parent-chart-pendapat-warga').removeClass('d-none');
        $.ajax({
            url: route('dashboard.get-pendapat-warga-statistics', {provinsi: provinsi}),
            type: 'GET',
            beforeSend: function () {
                $('#wrapper-chart-pendapat-warga').html(preloader);
            },
            success: function (response, status, xhr) {
                $('#wrapper-chart-pendapat-warga').html(`<canvas id="chart-pendapat-warga" width="200" height="200"></canvas>`);
                const pendapatWargactx = document.getElementById('chart-pendapat-warga').getContext('2d');

                let pendapat = response;
                let pendapatWargaData = {
                    labels: Object.keys(pendapat),
                    datasets: [{
                        axis: 'y',
                        label: 'Keluhan',
                        data: Object.values(pendapat).map(item => item.keluhan),
                        fill: false,
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgb(153, 102, 255)'
                        ],
                        borderWidth: 1
                    },{
                        axis: 'y',
                        label: 'Harapan',
                        data: Object.values(pendapat).map(item => item.harapan),
                        fill: false,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)'
                        ],
                        borderWidth: 1
                    }]
                };

                let chartPendapatWarga = new Chart(pendapatWargactx, {
                    type: 'bar',
                    data: pendapatWargaData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                    }
                });
            }
        })
    }

    let keyword = '{{ role('operator_bhabinkamtibmas_polda') ? \Illuminate\Support\Str::between(auth()->user()->personel->polda, 'POLDA ', '-')  : "" }}';

    // Search Query
    const SEARCH_STATE = {
        url     : null,
        data    : {},
        type    : null,
        selector: null
    }

    function generateKeywordTrendingHariIni(data){

        let trending = $('#trending-today');
        trending.html('<ul class="kejadian_baru"></ul>');
        if (data.length > 0){
            data.map((item, key) => {
                trending.children().last().append(`<li style="list-style : none"> ${key + 1} .  ${item.keyword}</li>`);
            });
        } else {
            trending.children().last().append(`<li style="list-style : none"> Trending hari ini tidak ditemukan. </li>`);
        }

    }

    function initPaginate(data){
        const selector = $('#pagination-laporan');
        const totalPages = data.last_page;
        const defaultOpts = {
            totalPages: totalPages,
            first: '<i class="fa fa-angle-double-left"></i> Pertama',
            last: 'Terakhir <i class="fa fa-angle-double-right"></i> ',
            prev: '<i class="fa fa-angle-left"></i> Sebelumnya',
            next: 'Selanjutnya <i class="fa fa-angle-right"></i> ',
        }
        const currentPage = selector.twbsPagination('getCurrentPage');
        selector.twbsPagination(defaultOpts);
        selector.twbsPagination('destroy');
        selector.twbsPagination($.extend({}, defaultOpts, {
            startPage: currentPage,
            totalPages: totalPages
        }));
        selector.on('page', function (evt, page) {
            let data = SEARCH_STATE.data;
            Object.assign(data , {
                page: page,
            });

            filterDashboard(Object.assign(SEARCH_STATE, {
                url: URL_FILTER_DASHBOARD,
                data: data,
                type: 'paging'
            }));
        });
    }

    function generateListLaporan(data){
        const searchLaporanList = $('#laporan-list');
        searchLaporanList.html('<div class="row mt-3"></div>');
        searchLaporanList.prepend('<p class="pl-1 pb-1 pt-2" style="text-transform: capitalize;"><b>'+addCommas(data.total)+'</b> laporan ditemukan'+'</p>');
        data.data?.map((item)=>{
            searchLaporanList.children().last().append(generateCardPencarianLaporan(item));
        });
    }

    function generateCardPencarianLaporan(laporan) {
        let keywords = laporan.tags.split(',').map((val, index) => {
            let elem = val.includes(keyword) ? 'mark' : 'span';
            return `<${elem}>${val}</${elem}>`;
        }).join(',')

        const showDetail = (laporan.jenis_laporan === 'DDS Warga')
            ? `<a class="btn btn-primary" title="lihat detail laporan"
                    href="${route('detail-dds-warga', laporan.form_id)}">
                    <i class="fa fa-eye"></i> Lihat Detail
                </a>`
            : ''
        const showTelepon = (laporan.handphone.toString().length > 0) ? `
                <a href="tel:${laporan.handphone}" class="btn btn-success ${laporan.handphone ? '': 'disabled'}">
                    <i class="fa fa-phone"></i> ${laporan.handphone}
                </a>` : ''

        return `
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header header">
                             ${laporan.jenis_laporan}
                        </div>
                        <div class="card-body">
                            <h5>Pelapor</h5>
                            <div class="row">
                                <label class="col-sm-2">Nama</label>
                                <div class="col-sm-8">
                                    <p>${laporan.nama_personel}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2">Satuan</label>
                                <div class="col-sm-8">
                                    <p>${laporan.polda} ${laporan.polres} ${laporan.polsek}</p>
                                </div>
                            </div>
                            <hr class="mt-0">
                            <h5>Narasumber</h5>
                            <div class="row">
                                <label class="col-sm-2">Nama</label>
                                <div class="col-sm-8">
                                    <p>${laporan.narasumber}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2">Alamat</label>
                                <div class="col-sm-8">
                                    <p>${laporan.alamat}</p>
                                </div>
                            </div>
                            <hr class="mt-0">
                            <h5>Informasi</h5>
                            <div class="row">
                                <div class="col-sm-10">
                                    <p>${keywords}</p>
                                </div>
                                <div class="col-sm-2 d-flex justify-content-end">
                                    <p>${laporan.tanggal_laporan}</p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">${laporan.uraian_informasi}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <p class="text-muted">Laporan diperbarui pada: ${ moment(laporan.updated_at).locale('id').format('DD-MM-YYYY') }</p>
                            <div class="ml-auto mr-0">
                                ${showDetail} &nbsp;
                                ${showTelepon}
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
    }

    function rollbackTitlePopularCard()
    {
        SELECTOR_PENCARIAN_KEYWORD_POPULAR.find('.card-title:first').html('Trending Keyword Populer Citizen');
        SELECTOR_PENCARIAN_KEYWORD_POPULAR.find('.card-title:last').html('Trending Hari ini');
    }

    function showLoader(){
        $('.loader').show();
        hideLaporanList();
    }

    function hideLoader(){
        $('.loader').hide();
        showLaporanList();
    }

    function showLaporanList() {
        $('#laporan-list').show();
    }

    function hideLaporanList() {
        $('#laporan-list').hide();
    }

    function scrollDownTo(href){
        $('html, body').animate({
            scrollTop: $('#'+href+'').offset().top + "px"
        }, 700);
    }
</script>
