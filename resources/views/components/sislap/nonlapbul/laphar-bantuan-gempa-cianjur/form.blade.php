<div>
    <div class="jumbotron">
        <p class="lead text-bold">Format ini terkhusus untuk kegiatan bantuan gempa di luar wilayah Kabupaten Cianjur</p>
        <hr class="my-4">
        <p>Silahkan tekan tombol berikut untuk menambahkan laporan kegiatan</p>
        <p class="lead">
            <a class="btn btn-success" href="#" role="button" id="add-data">Buat Laporan Kegiatan</a>
        </p>
    </div>
    <div class="card d-none" id="form-card">
        <div class="card-header d-flex bg-primary align-items-center justify-content-between">
            <h3 class="card-title w-50" id="data-petugas"></h3>
            <div class="card-tools d-flex w-50 justify-content-end">
                <button type="button" class="btn btn-danger remove-data" id="delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name="personel_id_text">
            <input type="hidden" name="district_id_text">
            <input type="hidden" name="jenis_kegiatan_text">
            <input type="hidden" name="tanggal" id="waktu-kegiatan" value="{{ date('Y-m-d') }}">
            <div class="form-group">
                <label for="select-petugas">Nama Petugas</label>
                <select type="text" class="form-control select2" id="select-petugas" name="personel_id">
                    <option></option>
                </select>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan Petugas</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan" readonly>
            </div>
            <div class="form-group">
                <label for="kesatuan">Kesatuan Petugas</label>
                <input type="text" class="form-control" id="kesatuan" name="kesatuan" placeholder="Satuan tugas" readonly>
            </div>
            <div class="form-group">
                <label for="kesatuan">Lokasi Kegiatan</label>
                <div class="form-row">
                    <div class="col-4">
                        <input type="text" name="lokasi" id="lokasi" class="form-control text-uppercase"
                               placeholder="contoh: Balai Desa, Pengungsian">
                    </div>
                    <div class="col-8">
                        <select class="form-control form-select select2" id="select-lokasi" name="district_code">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="tanggal">Waktu Kegiatan</label>
                <input type="text" class="form-control" id="tanggal" placeholder="Waktu Kegiatan">
            </div>
            <div class="form-group">
                <label for="select-jenis-kegiatan">Jenis Kegiatan</label>
                <select class="form-control form-select text-uppercase select2" id="select-jenis-kegiatan"
                        name="jenis_kegiatan">
                    <option></option>
                </select>
            </div>
            <div class="form-group">
                <label for="uraian_kegiatan">Uraian Kegiatan</label>
                <textarea id="uraian_kegiatan" name="uraian_kegiatan" class="form-control text-uppercase"></textarea>
            </div>
            <div class="flex-row d-flex justify-content-between">
                <div class="justify-content-start">
                    <button type="button" class="btn btn-primary" id="back"><i class="fas fa-backward"></i> Sebelumnya
                    </button>
                </div>
                <div class="justify-content-end">
                    <button type="button" class="btn btn-primary" id="next"><i class="fas fa-forward"></i> Selanjutnya
                    </button>
                    <button type="submit" class="btn btn-success" id="submit"><i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const initSelectPetugas = (el) => {
            buildSelect2Search({
                placeholder: '-- Cari NRP atau Nama Petugas --',
                url: route('personel.select2'),
                minimumInputLength: 0,
                selector: [{ id: el }],
                query: function (params) {
                    return {
                        q: params.term,
                        withPangkat: true
                    }
                }
            });
        }

        const initSelectJenisKegiatan = (el) => {
            buildSelect2Search({
                placeholder: '-- Pilih Jenis Kegiatan --',
                url: route('nonlapbul.jenis-kegiatan.select2'),
                minimumInputLength: 0,
                selector: [{id: el}],
                tags: true,
                createTag: (params) => {
                    let term = $.trim(params.term).toUpperCase();
                    if (term === '') {
                        return null;
                    }
                    
                    let data = axios.post(route('jenis-kegiatan.store'), {
                        nama: term,
                        slug: slugify(term),
                        jenis_laporan: "BANTUAN"
                    }).then(res => res.data);

                    return {
                        id: data.slug,
                        text: data.nama,
                        newTag: true // add additional parameters
                    }
                },
                query: function (params) {
                    return {
                        q: params.term,
                        jenis_laporan: 'BANTUAN'
                    }
                }
            });
        }

        const initSelectLokasi = (el) => {
            buildSelect2Search({
                placeholder: '-- Cari Kecamatan/Kabupaten --',
                url: route('lokasi.select2'),
                selector: [{id: el}],
                query: function (params) {
                    return {
                        q: params.term
                    }
                }
            });
        }

        document.getElementById('add-data').addEventListener('click', function () {
            ignite();
        });

        function toggleJumbotron() {
            document.querySelector('.jumbotron').classList.toggle('d-none', true);
            document.querySelector('#form-card').classList.remove('d-none');
        }

        const $form = $('#form-bantuan-pasca-gempa');

        function ignite() {
            const $next = document.querySelector("#next");
            const $back = document.querySelector("#back");
            const $submit = document.querySelector("#submit");
            const $delete = document.querySelector("#delete");

            function createStore(initialState, reducer) {
                const state = new Proxy(
                    {value: initialState},
                    {
                        set(obj, prop, value) {
                            obj[prop] = value;
                            updateUI();
                        },
                    }
                );

                function getState() {
                    // This only works if `initialState` is an Object
                    return {...state.value};
                }

                function dispatch(action) {
                    const prevState = getState();
                    state.value = reducer(prevState, action);
                }

                return {
                    getState,
                    dispatch,
                };
            }

            const initialState = {
                data: [],
                position: 0
            };

            function reducer(state, action) {
                const saveFormData = (formId) => {
                    let object = {};
                    let formData = new FormData(document.getElementById(formId));
                    formData.forEach((value, key) => object[key] = value)
                    return object;
                }
                switch (action) {
                    case "ADD":
                        state.data[state.position] = saveFormData('form-bantuan-pasca-gempa');
                        state.position = state.position + 1;
                        document.getElementById('data-petugas').textContent = state.position + 1;
                        break;
                    case 'BACK':
                        //kembali ke posisi sebelumnya berserta form datanya
                        state.data[state.position] = saveFormData('form-bantuan-pasca-gempa');
                        state.position = state.position - 1;
                        break;
                    case "DELETE":
                        //hapus data posisi sekarang dan kembali ke posisi terakhir
                        state.data = state.data.remove(state.position);
                        state.position = state.data.length - 1;
                        break;
                    case "SUBMIT":
                        state.data[state.position] = saveFormData('form-bantuan-pasca-gempa');
                        //ajax post data to server
                        $.ajax({
                            url: route('bantuan-pasca-gempa-cianjur.store'),
                            method: 'post',
                            data: {
                                "data": JSON.stringify(state.data)
                            },
                            success: function (response) {
                                swalSuccess(response.message);
                                //delay 2 sec
                                setTimeout(function () {
                                    window.location.href = route('bantuan-pasca-gempa-cianjur.index');
                                }, 2000);
                            },
                        });
                        break;
                    default:
                        state.position = 0;
                        break;
                }

                return state;
            }

            const store = createStore(initialState, reducer);

            function updateUI() {
                toggleJumbotron();
                resetForm($form)
                resetSelect2TagsInForm($form);
                initSelectPetugas($('#select-petugas'));
                $('#select-petugas').on('select2:select', function (e) {
                    const data = e.params.data;
                    const nama  = $(this).closest('.card-body').find('[name="personel_id_text"]');
                    const jabatan = $(this).closest('.card-body').find('#jabatan');
                    const kesatuan = $(this).closest('.card-body').find('#kesatuan');
                    const titleCard = document.getElementById('data-petugas');
                    nama.val(data.text);
                    jabatan.val(data.jabatan);
                    kesatuan.val(data.polres);
                    titleCard.textContent = (store.getState().position + 1) + '. ' + data.text;
                });
                initSelectJenisKegiatan($('#select-jenis-kegiatan'));
                $('#select-jenis-kegiatan').on('select2:select', function (e) {
                    const data = e.params.data;
                    $(this).closest('.card-body').find('[name="jenis_kegiatan_text"]').val(data.text);
                });
                initSelectLokasi($('#select-lokasi'));
                $('#select-lokasi').on('select2:select', function (e) {
                    const data = e.params.data;
                    const kecamatan  = $(this).closest('.card-body').find('[name="district_id_text"]');
                    kecamatan.val(data.text);
                });
                $('#tanggal').daterangepicker(Object.assign(datetimeSetup, {
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 2022,
                    maxYear: parseInt(moment().format('YYYY'), 10),
                    locale: {
                        format: 'dddd, DD-MM-YYYY'
                    },
                    startDate: moment().format('dddd, DD-MM-YYYY')
                }), function (start, end, label) {
                    $('#waktu-kegiatan').val(start.format('YYYY-MM-DD'));
                });
                $('#select-jenis-kegiatan').on('select2:select', function (e) {
                    updateUraian();
                });
                $('#tanggal').on('change', function () {
                    updateUraian();
                });

                function updateUraian() {
                    const uraian = $('#uraian_kegiatan');
                    if ($('#select-lokasi').select2('data')[0] !== undefined) {
                        uraian.val('Hari ' + $('#tanggal').val() + ' di ' + $('#lokasi').val() + ' ' + $('#select-lokasi').select2('data')[0].text + '.');
                    } else {
                        uraian.val('Hari ' + $('#tanggal').val() + ' di ' + $('#lokasi').val() + '.');
                    }
                }

                if (store.getState().data.length === 0 || store.getState().position === 0) {
                    $back.classList.add('d-none');
                } else {
                    $back.classList.remove('d-none');
                }
                if (store.getState().data[store.getState().position] !== undefined) {
                    const titleCard = document.getElementById('data-petugas');
                    let oldData = store.getState().data[store.getState().position];
                    titleCard.textContent = (store.getState().position + 1) + '. ' + oldData.personel_id_text;

                    Object.keys(oldData).forEach((name, key) => {
                        let input = $form.find(`[name="${name}"]`);
                        if (input.is('select') && input.hasClass('select2')) {
                            input.append(appendSelectOption(oldData[name + '_text'], oldData[name])).trigger('change');
                        } else {
                            input.val(oldData[name]);
                        }
                    });
                }
            }
            updateUI();

            $next.addEventListener("click", async (e) => {
                e.preventDefault();
                store.dispatch("ADD");
            });
            $back.addEventListener("click", async (e) => {
                e.preventDefault();
                await store.dispatch("BACK");
                updateInputDataByPosition(store.getState().position);
            });
            $submit.addEventListener("click", async (e) => {
                e.preventDefault();
                store.dispatch("SUBMIT");
            });
            $delete.addEventListener("click", async (e) => {
                e.preventDefault();
                await store.dispatch("DELETE");
                updateInputDataByPosition(store.getState().position);
            });
        }
    </script>
@endpush
