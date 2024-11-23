<div class="card mt-4">
    <div class="header">Daftar Pemanfaatan Informasi Oleh Bhabinkamtibmas
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                    onclick="angleIcon(this)">
                <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form action="#" class="form row" id="filter-pemanfaatan">
            @csrf
            <h5 class="col-12">Cari Berdasarkan:</h5>
            <div class="form-group col-sm-4">
                <label for="select-polda-p">Satuan Polda</label>
                <select name="polda" id="select-polda-p" class="form-control select2">
                    <option></option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="nrp-p">NRP</label>
                <input type="text" id="nrp-p" name="nrp" class="form-control">
            </div>
            <div class="form-group col-sm-4">
                <label for="date">date</label>
                <input type="text" name="date" id="date" class="form-control">
            </div>
            <div class="col-12 form-group w-100 d-flex justify-content-center justify-content-sm-end">
                <div>
                    <button class="btn btn-success btn-export-excel">
                        <i class="fa fa-file-alt"></i>&ensp;Ekspor Excel
                    </button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <hr>
        <table class="table table-hover table-bordered text-center w-100" id="table-pemanfaatan">
            <thead>
            <tr style="background-color: #1E4588">
                <th class="align-middle text-white">No</th>
                <th class="align-middle text-white">Nama</th>
                <th class="align-middle text-white">NRP</th>
                <th class="align-middle text-white">Polda</th>
                <th class="align-middle text-white">Polres</th>
                <th class="align-middle text-white">Polsek</th>
                <th class="align-middle text-white">Jumlah Konten</th>
            </tr>
            </thead>
            <tbody id="table-pemanfaatan-body"></tbody>
        </table>
    </div>
</div>

@push('modals')
    <div class="modal fade" id="pemanfaatanInformasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Daftar Pemanfaatan Informasi Kamtibmas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 80vh; overflow-y: scroll">
                    <div class="text-center" id="pemanfaatanInformasiLoader">
                        <img class="img-fluid" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
                    </div>
                    <div id="pemanfaatanInformasiWrapper"></div>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script>
        const date = {
            start_date: null,
            end_date: null
        }

        $('#date').daterangepicker(datetimeSetup, function (start, end, label) {
            Object.assign(date, {
                start_date: start.format('YYYY-MM-DD'),
                end_date: end.format('YYYY-MM-DD')
            });
        });

        initSelectPolda($('#select-polda-p'))

        document.querySelector('#filter-pemanfaatan button[type=reset]')
                .addEventListener('click', () => {
            resetForm($('#filter-pemanfaatan'))
        })

        document.querySelector('#filter-pemanfaatan').addEventListener('submit', (e) => {
            e.preventDefault()
            let nrp = $('#filter-pemanfaatan input[name=nrp]').val()
            if (nrp.length !== 0 && nrp.length !== 8 && !nrp.match(/^[0-9]+$/)) {
                swalWarning('Input Filter NRP harus berupa angka dengan 8 karakter!')
                return
            }

            pemanfaatanInformasiTable()
        })

        document.querySelector('#filter-pemanfaatan .btn-export-excel')
                .addEventListener('click', () => {
            swalSuccess('proses ekspor excel sedang berlangsung, mohon tidak berpindah halaman')
            location.href = route('pemanfaatan-informasi.excel') 
                +'?nrp='+$('#filter-pemanfaatan input[name=nrp]').val()
                +'&polda='+$('#filter-pemanfaatan select[name=polda]').select2('data')[0].text
                +'&start_date='+date.start_date
                +'&end_date='+date.end_date
        })

        function pemanfaatanInformasiTable () {
            generateDataTable({
                dom: 'rtip',
                selector: $('#table-pemanfaatan'),
                url: route('pemanfaatan-informasi.datatable'),
                order: [[6, 'desc']],
                data: function (d) {
                    d.nrp = $('#filter-pemanfaatan input[name=nrp]').val()  
                    d.polda = $('#filter-pemanfaatan select[name=polda]').select2('data')[0].text
                    d.start_date = date.start_date
                    d.end_date = date.end_date
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        width: '5%',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    }, {
                        data: 'nama',
                        name: 'nama',
                        render: function (data, type, row, meta) {
                            return `${row.pangkat} ${data}`
                        }
                    }, {
                        data: 'nrp',
                        name: 'nrp',
                    }, {
                        data: 'satuan1',
                        name: 'satuan1',
                        render: function (data, type, row, meta) {
                            return data && data.split('-')[0]
                        }
                    }, {
                        data: 'satuan2',
                        name: 'satuan2',
                        render: function (data, type, row, meta) {
                            return (data && data.split('-')[0]) ?? '-'
                        }
                    }, {
                        data: 'satuan3',
                        name: 'satuan3',
                        render: function (data, type, row, meta) {
                            return (data && data.split('-')[0]) ?? '-'
                        }
                    }, {
                        data: 'total',
                        name: 'total',
                        width: '5%',
                        render: function (data, type, row, meta) {
                            return (
                               `<button type="button" id="btnPemanfaatanInformasi"
                                        class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#pemanfaatanInformasiModal"
                                        onclick="setPemanfaatanInformasiContent('${row.nrp}', '${this.date.start_date}', '${this.date.end_date}')">
                                    <b>${data}&nbsp;</b>
                                    <i class="fas fa-info-circle"></i>
                                </button>`
                            )
                        }
                    }
                ],
            })
        }
        pemanfaatanInformasiTable()

        const pemanfaatanInformasiModal = $('#pemanfaatanInformasiModal')
        const pemanfaatanInformasiLoader = document.querySelector('#pemanfaatanInformasiLoader')
        const pemanfaatanInformasiWrapper = document.querySelector('#pemanfaatanInformasiWrapper')

        pemanfaatanInformasiModal.on('hidden.bs.modal', function (e) {
            pemanfaatanInformasiLoader.classList.remove('d-none')
            pemanfaatanInformasiWrapper.innerHTML = ''
        })

        function showMedia (data) {
            switch(data['type']) {
                case 'video':
                    return (
                        `<video controls preload="none" width="100%">
                            <source src="${data['file']}">
                        </video>`
                    )
                case 'image':
                    return (
                        `<a href="${route('download', {'url': data['file']})}">
                            <img src="${data['thumbnail']}" width="100%" alt="${data['title']}">
                        </a>`
                    )
                case 'doc':
                    return (
                        `<a href="${route('download', {'url': data['file']})}">
                            <img src="{{ asset('img/bhabin/icon/pdf.svg') }}"
                                 width="40px" height="40px" alt="${data['title']}">
                        </a>`
                    )
                default:
                    return ''
            }
        }

        function setPemanfaatanInformasiContent(nrp, start, end) {
            pemanfaatanInformasiModal.modal(modalOptions)
            axios.get(route('pemanfaatan-informasi.show', {nrp, start, end}))
                .then((res) => res.data)
                .then((res) => {
                    if (!res) return

                    pemanfaatanInformasiLoader.classList.add('d-none')
                    res.map((item, index) => {
                        content = document.createElement('div')
                        content.innerHTML = (
                            `<div class="row">
                                <div class="col-md-3"><p>${item['title']}</p></div>
                                <div class="col-md-4"><p>${item['description']}</p></div>
                                <div class="col-md-2">
                                    ${item['download']}x download<br>
                                    ${item['copy_link']}x copy link
                                </div>
                                <div class="col-md-3">${showMedia(item)}</div>
                            </div>
                            ${(index < (res.length - 1) ? `<hr>` : '')}`
                        )

                        pemanfaatanInformasiWrapper.appendChild(content)
                    })
                })
                .catch((err) => alert(err))
        }
    </script>
@endpush
