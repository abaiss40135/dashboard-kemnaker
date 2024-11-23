@php
    $user_last_handphone_update = auth()->user()->personel->last_handphone_update;
@endphp
@if (
    (role('bhabinkamtibmas') && auth()->user()->lokasiPenugasans()->count())
    || roles([
        'operator_bhabinkamtibmas_polsek',
        'operator_bhabinkamtibmas_polres',
        'operator_bhabinkamtibmas_polda'
    ])
)
    @push('styles')
        @include('assets.css.datatables')
    @endpush
    <div class="card" style="min-height: 450px">
        <h6 class="header-title text-white p-2 rounded fw-bolder text-uppercase text-center">
            Laporan Publik
        </h6>
        <div class="card-body">
            <form
                id="form-search"
                action=""
                method="POST"
                onsubmit="disableButtonSubmit(this)"
            >
                @csrf
                <div class="alert alert-gray">
                    <h5 data-bs-toggle="collapse" data-bs-target="#collapseForm">
                        <i class="icon fas fa-filter"></i>
                        Filter
                    </h5>
                    <div id="collapseForm" class="collapse show">
                        <hr>
                        <div class="form-group">
                            <label for="bulan">Bulan:</label>
                            <input
                                type="month"
                                name="bulan"
                                id="bulan" class="form-control"
                                min="2021-05"
                                max="{{ now()->format('Y-m') }}"
                                value="{{ now()->format('Y-m') }}"
                            >
                        </div>
                        <div
                            class="col-sm-6 offset-xl-9 col-xl-3 d-flex justify-content-center align-items-end mt-3 mb-xl-3"
                            style="column-gap: 0.4rem"
                        >
                            <button type="reset" class="btn btn-sm btn-warning w-100 p-2">
                                <i class="fas fa-undo"></i>
                                Reset
                            </button>
                            <button
                                type="button"
                                id="btn-search"
                                class="btn btn-sm btn-primary w-100 p-2"
                            >
                                <i class="fa fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive mt-3">
                <table
                    class="table table-hover table-striped text-center w-100"
                    style="border-color: #1E4588"
                    id="table-laporan-publik"
                >
                    <thead style="background-color: #1E4588; color: white">
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Tanggal</th>
                            <th class="align-middle">Lokasi</th>
                            <th class="align-middle">Uraian</th>
                            <th class="align-middle">Keyword</th>
                            <th class="align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        id="eskalasiLaporan"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eskalasi Laporan</h5>
                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div
                        class="modal-body d-flex flex-column"
                        style="column-gap: 0.6rem"
                    >
                        <input type="hidden" name="escalatable_id">
                        <input type="hidden" name="escalatable_type">
                        <div class="form-group">
                            <label for="escalated_to" class="form-label">Eskalasi ke</label>
                            <select
                                name="escalated_to"
                                id="escalated_to"
                                class="form-control"
                            >
                                <option value="" selected>Pilih eskalasi ke</option>
                                @php
                                    $is_polsek = roles(['operator_bhabinkamtibmas_polsek']);
                                    $is_polres = roles(['operator_bhabinkamtibmas_polres']);
                                    $is_polda = roles(['operator_bhabinkamtibmas_polda']);
                                @endphp
                                @if ($is_polsek)
                                    <option value="polres">Polres</option>
                                    <option value="polda">Polda</option>
                                @elseif ($is_polres)
                                    <option value="polda">Polda</option>
                                @else {{-- expect bhabinkamtibmas --}}
                                    <option value="polsek">Polsek</option>
                                    <option value="polres">Polres</option>
                                    <option value="polda">Polda</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="komentar" class="form-label">Komentar</label>
                            <textarea
                                name="komentar"
                                id="komentar"
                                rows="4"
                                class="form-control"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="reset"
                            class="btn btn-secondary bg-secondary"
                            data-bs-dismiss="modal"
                        >Batal</button>
                        <button
                            type="submit"
                            class="btn btn-primary bg-primary"
                        >Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        id="komentarEskalasiLaporan"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Komentar Laporan</h5>
                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div
                        class="modal-body d-flex flex-column"
                        style="column-gap: 0.6rem"
                    >
                        <input type="hidden" name="escalatable_id">
                        <input type="hidden" name="escalatable_type">
                        <div class="form-group">
                            <label for="komentar" class="form-label">Komentar</label>
                            <textarea
                                name="komentar"
                                id="komentar"
                                rows="4"
                                class="form-control"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="reset"
                            class="btn btn-secondary bg-secondary"
                            data-bs-dismiss="modal"
                        >Batal</button>
                        <button
                            type="submit"
                            class="btn btn-primary bg-primary"
                        >Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    @include('assets.js.datatables')
    <script>
        const formEskalasiLaporan = document.querySelector('#eskalasiLaporan form')
        const formkomentarEskalasiLaporan = document.querySelector('#komentarEskalasiLaporan form')

        function loadEskalasi(id, model) {
            formEskalasiLaporan.reset()
            formEskalasiLaporan.querySelector('[name=escalatable_id]').value = id
            formEskalasiLaporan.querySelector('[name=escalatable_type]').value = model
        }

        function loadKomentarEskalasiLaporan(id, model) {
            formkomentarEskalasiLaporan.reset()
            formkomentarEskalasiLaporan.querySelector('[name=escalatable_id]').value = id
            formkomentarEskalasiLaporan.querySelector('[name=escalatable_type]').value = model
        }


        // This is just for demo purpose
        formEskalasiLaporan.addEventListener('submit', function (e) {
            e.preventDefault()
            $(this).closest('.modal').modal('hide')

            Swal.fire({
                title: 'Berhasil mengajukan eskalasi laporan',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
            }).then(() => {
                document.querySelector('.loader-rotate-container').style.display = 'none'
            })
        })

        formkomentarEskalasiLaporan.addEventListener('submit', function (e) {
            e.preventDefault()
            $(this).closest('.modal').modal('hide')

            Swal.fire({
                title: 'Berhasil mengirim komentar eskalasi laporan',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
            }).then(() => {
                document.querySelector('.loader-rotate-container').style.display = 'none'
            })
        })
        // End of demo purpose

        function generateLaporanPublikDatatable() {
            generateDataTable({
                selector: $('#table-laporan-publik'),
                url: route('laporan-publik-datatable'),
                dom: 'Bfrtip',
                columns: [
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi',
                    },
                    {
                        width: '40%',
                        data: 'laporan_informasi.uraian',
                        name: 'laporan_informasi.uraian',
                    },
                    {
                        data: 'keyword',
                        name: 'keyword',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        sortable: false,
                        searchable: false,
                    }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 },
                ]
            });
        }
        generateLaporanPublikDatatable()
    </script>
    @endpush
@endif