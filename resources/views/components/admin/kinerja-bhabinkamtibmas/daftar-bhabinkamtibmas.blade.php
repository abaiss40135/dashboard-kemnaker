<div class="card mt-4">
    <div class="header">Daftar Bhabinkamtibmas
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                    onclick="angleIcon(this)">
                <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form action="#" class="form row" id="filter-bhabin">
            @csrf
            <h5 class="col-12">Cari Berdasarkan:</h5>
{{--            <div class="form-group col-sm-4">--}}
{{--                <label for="select-polda">Satuan Polda</label>--}}
{{--                <select name="polda" id="select-polda" class="form-control select2">--}}
{{--                    <option></option>--}}
{{--                </select>--}}
{{--            </div>--}}

            <div class="form-group col-sm-3">
                <label for="nama">Nama</label>
                <select name="nama" id="select-nama-bhabin" class="form-control select2"></select>
            </div>
            <div class="form-group col-sm-3">
                <label for="nrp">NRP</label>
                <input type="text" id="nrp" name="nrp" class="form-control">
            </div>
            <div class="form-group col-sm-3">
                <label for="klaster">Klaster Keaktifan</label>
                <select name="klaster_rutinitas" id="klaster" class="form-control">
                    <option disabled selected>-- pilih klaster keaktifan --</option>
                    <option value="{{ \App\Helpers\Constants::RUTINITAS_AKTIF }}">Aktif</option>
                    <option value="{{ \App\Helpers\Constants::RUTINITAS_CUKUP }}">Cukup aktif</option>
                    <option value="{{ \App\Helpers\Constants::RUTINITAS_KURANG }}">Kurang aktif</option>
                </select>
            </div>
            <div class="form-group col-sm-3">
                <label for="is_login">Status Login</label>
                <select name="is_login" id="is_login" class="form-control">
                    <option disabled selected>-- pilih status login --</option>
                    <option value="1">Sudah Login</option>
                    <option value="0">Belum Login</option>
                </select>
            </div>
            <div class="form-group col-6 col-md-3">
                <label for="province" class="form-label">Provinsi</label>
                <select id="province" name="province" class="form-control select2"></select>
            </div>
            <div class="form-group col-6 col-md-3">
                <label for="city" class="form-label">Kota/Kabupaten</label>
                <select id="city" name="city" class="form-control select2"></select>
            </div>
            <div class="form-group col-6 col-md-3">
                <label for="district" class="form-label">Kecamatan</label>
                <select id="district" name="district" class="form-control select2"></select>
            </div>
            <div class="form-group col-6 col-md-3">
                <label for="village" class="form-label">Desa</label>
                <select id="village" name="village" class="form-control select2"></select>
            </div>
            <div class="col-12 form-group w-100 d-flex justify-content-center justify-content-sm-end">
                <div>
                    <button class="btn btn-success" onclick="downloadExcelKlaster(this)">
                        <i class="fa fa-file-alt"></i>&ensp;Ekspor Excel
                    </button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <div class="d-none px-3">
            <hr>
            <div id="chart-laporan"></div>
        </div>
        <hr>
        <div class="table-responsive mt-4">
            <table class="table table-hover table-bordered text-center w-100" id="table-personel">
                <thead>
                <tr style="background-color: #1E4588">
                    <th class="align-middle text-white">No</th>
                    <th class="align-middle text-white">Nama Bhabinkamtibmas</th>
                    <th class="align-middle text-white">Pangkat</th>
                    <th class="align-middle text-white">NRP</th>
                    <th class="align-middle text-white">Polda</th>
                    <th class="align-middle text-white">Polres</th>
                    <th class="align-middle text-white">Polsek</th>
                    <th class="align-middle text-white">Lokasi Penugasan</th>
                    <th class="align-middle text-white">Status Login</th>
                    <th class="align-middle text-white">Jumlah Laporan Minggu Ini</th>
                    <th class="align-middle text-white">Jumlah Laporan Bulan Ini</th>
                    <th class="align-middle text-white">Klasterisasi Rutinitas Laporan</th>
                    <th class="align-middle text-white">Aksi</th>
                </tr>
                </thead>
                <tbody id="bhabin"></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>
@push('modals')
    <!-- modal filterisasi export laporan bhabinkamtibmas -->
    <div id="modalLaporanBhabinkamtibmas" class="modal fade" tabindex="-1"
         role="dialog" data-backdrop="static"
         aria-labelledby="modalLaporanBhabinkamtibmasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-center" id="modalLaporanBhabinkamtibmasLabel">Pilih Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('master-bhabin.excel.laporan-bhabinkamtibmas') }}"
                          class="form" id="formFilterLaporanBhabinkamtibmas"
                          method="GET" onsubmit="disableSubmitButtonTemporarily(this)">
                        @csrf
                        <input type="hidden" name="nrp">
                        <div class="form-group">
                            <label for="month" class="form-label">Bulan</label>
                            <input type="month" name="month" id="month" class="form-control">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Ekspor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit role/password personel -->
    <div class="modal fade" id="modalPermissionPersonel"
         data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modalPermissionPersonelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalPermissionPersonelLabel">Hak Akses dan Sandi Personel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="modalPermissionLoader">
                        <img class="img-fluid" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
                    </div>
                    <div class="" id="wrapperPermissionPersonel"></div>
                    <form method="POST" id="formPermissionPersonel" action="#">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" id="nrp-personel" name="nrp">
                        <input type="hidden" name="personel">
                        <div class="form-group">
                            <label for="role_id">Pensiun/Mutasi <small>(biarkan apabila tidak terjadi perubahan)</small></label>
                            <select name="role_id" id="role_id" class="form-control select2">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input id="password" name="password" type="password" autocomplete="new-password"
                                   class="form-control  @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="error invalid-feedback" style="">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input id="password_confirmation" name="password_confirmation"
                                   autocomplete="new-password" type="password"
                                   class="form-control  @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <span class="error invalid-feedback" style="">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" id="submit-btn-permission" class="btn btn-primary"
                                    style="background-color: #30589A">{{ __('locale.Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script>
        const modalPermissionPersonel = $('#modalPermissionPersonel');
        const modalLaporanBhabinkamtibmas = $('#modalLaporanBhabinkamtibmas')
        const formFilterLaporanBhabinkamtibmas = $('#formFilterLaporanBhabinkamtibmas')

        // button-reset.onclick -> clear localStorage & reload list bhabin
        document.querySelector('#filter-bhabin button[type=reset]').addEventListener('click', () => {
            resetForm($('#filter-bhabin'));
        });

        // form.onsubmit -> get list of bhabin (filtered)
        document.querySelector('#filter-bhabin').addEventListener('submit', (evt) => {
            evt.preventDefault();
            let filterNrp = $('#filter-bhabin input[name=nrp]').val();
            // filter apabila input filter nrp, harus 8 karakter dan berupa angka
            if (filterNrp.length !== 0 && filterNrp.length !== 8 && !filterNrp.match(/^[0-9]+$/)) {
                swalWarning('Input Filter NRP harus berupa angka dengan 8 karakter!');
                return;
            }

            showChartLaporan()
            personelTable();
        });

        function showChartLaporan () {
            const is_login = $('#filter-bhabin select[name="is_login"]').val();
            const chartLaporan = document.querySelector('#chart-laporan');
            if (is_login) {
                axios.post(route("master-bhabin.chart-laporan"), {
                    is_login: is_login,
                }).then((res) => {
                    chartLaporan.parentElement.classList.remove('d-none')
                    const canvas = document.createElement('canvas')
                    canvas.setAttribute('height', '360px')
                    chartLaporan.innerHTML = ''
                    chartLaporan.appendChild(canvas)
                    new Chart(chartLaporan.querySelector('canvas').getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: [`DDS`, `Problem Solving`, 'Deteksi Dini'],
                            datasets: [{
                                data: [res.data.dds, res.data.ps, res.data.dd],
                                backgroundColor: ['hsl(0, 88%, 51%)', 'hsl(120, 88%, 51%)', 'hsl(210, 88%, 51%)'],
                            }]
                        },
                        options: {maintainAspectRatio: false,}
                    })
                }).catch((error) => {
                    console.log(error)
                })
            } else chartLaporan.parentElement.classList.add('d-none')
        }

        function personelTable() {
            generateDataTable({
                dom: 'rtip',
                selector: $('#table-personel'),
                url: route('master-bhabin.datatable'),
                data: function (d) {
                    d.nrp      = $('#filter-bhabin input[name=nrp]').val();
                    // d.polda    = $('#filter-bhabin select[name=polda]').select2('data')[0].text;
                    d.klaster_rutinitas = $('#filter-bhabin select[name=klaster_rutinitas]').val();
                    d.is_login = $('#filter-bhabin select[name="is_login"]').val();
                    d.province = $('#filter-bhabin select[name="province"]').val();
                    d.city     = $('#filter-bhabin select[name="city"]').val();
                    d.district = $('#filter-bhabin select[name="district"]').val();
                    d.village  = $('#filter-bhabin select[name="village"]').val();
                    d.nama = $('#select-nama-bhabin').val();
                },
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
                        data: 'personel.nama',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'personel.pangkat',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'nrp',
                        name: 'nrp',
                    },
                    {
                        data: 'personel.polda',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'personel.polres',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'personel.polsek',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'lokasi_penugasans',
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            return data.reduce((prev, curr) => prev + "\n" + curr.lokasi, "")
                        }
                    }, {
                        data: 'status_login',
                        name: 'last_login_at',
                        width: '7%',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'latest_klaster_rutinitas.total_laporan',
                        width: '7%',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'latest_akumulasi_laporan.total_laporan',
                        width: '7%',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: 'status_klaster',
                        name: 'latest_klaster_rutinitas.klaster_rutinitas',
                        width: '7%',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '14%',
                        sortable: false,
                        searchable: false,
                    }
                ],
                columnDefs: [
                    {className: 'text-center', targets: [0, -1]},
                    {responsivePriority: 1, targets: 1},
                    {responsivePriority: 2, targets: -1},
                ],
                initComplete: function (settings, json) {}
            })
        }

        function downloadExcelKlaster (el) {
            // let polda   = $('#filter-bhabin select[name=polda]').select2('data')[0].text
            let isLogin = $('#filter-bhabin select[name="is_login"]').val()
            let nrp     = $('#filter-bhabin input[name=nrp]').val()
            let klaster = $('#filter-bhabin select[name=klaster_rutinitas]').val()

            // if (!polda) {
            //     swalWarning('harus memilih satuan polda terlebih dahulu')
            //     return
            // }

            if(!isLogin) {
                swalWarning('harus memilih status login terlebih dahulu')
                return
            }

            el.setAttribute('disabled', 'disabled')
            setTimeout(function() { el.removeAttribute('disabled') }, 3000)

            // location.href = route('master-bhabin.excel-klaster', {polda: polda, nrp: nrp, klaster_rutinitas: klaster})
            location.href = route('master-bhabin.excel-klaster', {is_login: is_login, nrp: nrp, klaster_rutinitas: klaster})
        }

        function setModalPermissionPersonelContent(nrp, userId) {
            if (!nrp || !userId) throw new Error('nrp tidak boleh kosong');

            document
            .getElementById('formPermissionPersonel')
            .setAttribute('action', route('user.update', userId));

            modalPermissionPersonel.modal(modalOptions)

            axios.post(route('tambah-akun.search-personel'), { nrp: nrp })
            .then(function (response) {
                if (response.status === 200) {
                    let personel = response.data;
                    if (personel.length === 0) {
                        swalWarning('Data personel dengan nrp ' + nrp + ' tidak ditemukan');
                        return;
                    }

                    document
                    .getElementById('wrapperPermissionPersonel')
                    .innerHTML = `<div class="box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid" id="personel_foto"
                                    src="${personel['foto_file']}"
                                    alt="personel picture">
                        </div>
                        <h3 class="profile-username text-center" id="header_nama">${personel['nama']}</h3>
                        <p class="text-center" style="margin-bottom: 0;">
                            <span id="header_pangkat">${personel['pangkat']}</span> / <span id="header_nrp">${personel['nrp']}</span>
                        </p>
                        <p class="text-center" style="margin-bottom: 0;" id="header_jabatan">${personel['jabatan']}</p>
                    </div>
                    <hr>`;

                    if (personel['role_id']) {
                        $('#role_id').val(personel['role_id']).trigger('change');
                    }

                    document.getElementById('modalPermissionLoader').classList.add('d-none');
                }
            })
            .catch(function (error) { swalWarning(error.message) })
            .finally(function () {
                document.getElementById('nrp-personel').value = nrp;
                document.getElementById('modalPermissionLoader').classList.add('d-none');
            });
        }

        function setModalLaporanBhabinkamtibmas(nrp) {
            modalLaporanBhabinkamtibmas.find('[name="nrp"]').val(nrp)
            modalLaporanBhabinkamtibmas.modal(modalOptions)
        }

        const initSelectHakAkses = () => {
            buildSelect2({
                placeholder: '-- Pilih Hak Akses (Aktif/Pensiun/Mutasi) --',
                minimumInputLength: 0,
                selector: [{ id: $('#role_id') }],
                data: [
                    {
                        id: '{{ \App\Models\User::BHABIN }}',
                        text: 'AKTIF'
                    },
                    {
                        id: '{{ \App\Models\User::BHABINKAMTIBMAS_PENSIUN }}',
                        text: 'PENSIUN'
                    },
                    {
                        id: '{{ \App\Models\User::BHABINKAMTIBMAS_MUTASI }}',
                        text: 'MUTASI'
                    }
                ]
            });
        }

        (function (){
            initSelectPolda();
            initSelectHakAkses();
            personelTable();
            $("#formPermissionPersonel").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url:$(this).attr("action"),
                    data: new FormData(this),
                    type:$(this).attr("method"),
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $("#submit-btn-permission").attr("disabled",true);
                    },
                    complete:function() {
                        $("#submit-btn-permission").attr("disabled",false);
                    },
                    success:function(data) {
                        modalPermissionPersonel.modal('hide')
                        swalSuccess(data.message);
                        personelTable();
                    }
                });
                return false;
            });

            modalPermissionPersonel.on('hidden.bs.modal', function (e) {
                document.getElementById('modalPermissionLoader').classList.remove('d-none');
                document.getElementById('wrapperPermissionPersonel').innerHTML = '';
                document.getElementById('nrp').value = '';
                resetForm($('#formPermissionPersonel'));
            })

            buildSelect2Search({
                placeholder: '-- Cari berdasarkan nama Bhabinkamtibmas --',
                url: route('master-bhabin.get-select-nama-bhabin'),
                minimumInputLength: 0,
                selector: [
                    {
                        id: $('#select-nama-bhabin')
                    }
                ],
                query: function (params) {
                    return {
                        id: 'nama',
                        nama: params.term
                    }
                }
            });
        })();

        let selectProvinsi  = $('#province');
        let selectKota      = $('#city');
        let selectKecamatan = $('#district');
        let selectDesa      = $('#village');

        function initSelect2Provinsi () {
            buildSelect2Search({
                placeholder: '-- Pilih Provinsi --',
                url: route('provinsi.select2'),
                minimumInputLength: 0,
                selector: [{id: selectProvinsi}],
                query: function (params) {
                    return {
                        name: params.term,
                        text: 'name'
                    }
                }
            });
        }

        function initSelect2Kota (province_code) {
            buildSelect2Search({
                placeholder: '-- Pilih Kota/Kabupaten --',
                url: route('kota.select2'),
                minimumInputLength: 0,
                selector: [{id: selectKota}],
                query: function (params) {
                    return {
                        name: params.term,
                        province_code: province_code
                    }
                }
            });
        }

        function initSelect2Kecamatan (city_code) {
            buildSelect2Search({
                placeholder: '-- Pilih Kecamatan --',
                url: route('kecamatan.select2'),
                minimumInputLength: 0,
                selector: [{id: selectKecamatan}],
                query: function (params) {
                    return {
                        name: params.term,
                        city_code: city_code,
                    }
                }
            });
        }

        function initSelect2Desa (district_code) {
            buildSelect2Search({
                placeholder: '-- Pilih Desa --',
                url: route('desa.select2'),
                minimumInputLength: 0,
                selector: [{id: selectDesa}],
                query: function (params) {
                    return {
                        name: params.term,
                        district_code: district_code,
                    }
                }
            });
        }

        selectProvinsi.on('select2:select', function (e) {
            initSelect2Kota(e.params.data.id);
        })

        selectKota.on('select2:select', function (e) {
            initSelect2Kecamatan(e.params.data.id);
        })

        selectKecamatan.on('select2:select', function (e) {
            initSelect2Desa(e.params.data.id);
        })

        initSelect2Provinsi()
        initSelect2Kota()
        initSelect2Kecamatan()
        initSelect2Desa()
    </script>
@endpush
