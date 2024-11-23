<div>
    <div class="card" id="form-card">
        <input type="text" name="provinsi_code" class="d-none">
        <input type="text" name="kabupaten_code" class="d-none">
        <input type="text" name="kecamatan_code" class="d-none">
        <input type="text" name="desa_code" class="d-none">
        <div class="card-header d-flex bg-primary align-items-center justify-content-between">
            <h3 class="card-title w-50" id="data-fkpm"></h3>
            <div class="card-tools d-flex w-50 justify-content-end">
                <button type="button" class="btn btn-danger remove-data" id="delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="polda">Polda</label>
                    <div class="col-lg-10">
                        <input type="text"
                               name="polda"
                               id="polda"
                               class="form-control"
                               required
                               maxlength="255"
                               placeholder="Contoh: POLDA JATENG"
                               value="{{ auth()->user()?->personel?->polda }}"
                               @if(auth()->user()?->personel?->polda) readonly @endif
                        >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="polres">Polres</label>
                    <div class="col-lg-10">
                        <input type="text"
                               name="polres"
                               id="polres"
                               class="form-control"
                               required
                               maxlength="255"
                               placeholder="Contoh: POLRESTA SEMARANG"
                               value="{{ auth()->user()?->personel?->polres }}"
                               @if(auth()->user()?->personel?->polres) readonly @endif
                        >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="nama_fkpm">Nama FKPM</label>
                    <div class="col-lg-10">
                        <input type="text"
                               name="nama_fkpm"
                               id="nama_fkpm"
                               class="form-control"
                               required
                               maxlength="255">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="nama_petugas_polmas">Nama Petugas Polmas</label>
                    <div class="col-lg-10">
                        <input type="text"
                               name="nama_petugas_polmas"
                               id="nama_petugas_polmas"
                               class="form-control"
                               required
                               maxlength="255">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="pangkat_petugas_polmas">Pangkat Petugas Polmas</label>
                    <div class="col-lg-10">
                        <select name="pangkat_petugas_polmas" id="pangkat_petugas_polmas" class="form-control">
                            <option value="KOMBES POL">KOMBES POL</option>
                            <option value="AKBP">AKBP</option>
                            <option value="KOMPOL">KOMPOL</option>
                            <option value="AKP">AKP</option>
                            <option value="IPTU">IPTU</option>
                            <option value="IPDA">IPDA</option>
                            <option value="AIPTU">AIPTU</option>
                            <option value="AIPDA">AIPDA</option>
                            <option value="BRIPKA">BRIPKA</option>
                            <option value="BRIGPOL">BRIGPOL</option>
                            <option value="BRIPTU">BRIPTU</option>
                            <option value="BRIPDA">BRIPDA</option>
                            <option value="ABRIP">ABRIP</option>
                            <option value="ABRIPTU">ABRIPTU</option>
                            <option value="ABRIPDA">ABRIPDA</option>
                            <option value="BHARAKA">BHARAKA</option>
                            <option value="BHARATU">BHARATU</option>
                            <option value="BHARADA">BHARADA</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="no_hp_petugas_polmas">No Handphone/WA Petugas Polmas</label>
                    <div class="col-lg-10">
                        <input type="number"
                               name="no_hp_petugas_polmas"
                               id="no_hp_petugas_polmas"
                               class="form-control"
                               required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="jumlah_anggota_fkpm">Jumlah Anggota FKPM</label>
                    <div class="col-lg-10">
                        <input type="number"
                               name="jumlah_anggota_fkpm"
                               id="jumlah_anggota_fkpm"
                               class="form-control"
                               required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="wilayah">Model {{ucwords($type)}}</label>
                    @if($type == "wilayah")
                        <div class="col-lg-10">
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_rw"
                                   class="form-radio-label"
                                   value="RW">
                            <label for="{{$type}}_rw">RW</label>
                            <br>
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_dusun"
                                   class="form-radio-label"
                                   value="Dusun">
                            <label for="{{$type}}_dusun">Dusun</label>
                            <br>
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_desa"
                                   class="form-radio-label"
                                   value="Desa/Kelurahan">
                            <label for="{{$type}}_desa">Desa/Kelurahan</label>
                        </div>
                    @elseif($type == "kawasan")
                        <div class="col-lg-10">
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_perdagangan"
                                   class="form-radio-label"
                                   value="Perdagangan">
                            <label for="{{$type}}_perdagangan">Perdagangan</label>
                            <br>
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_perkantoran"
                                   class="form-radio-label"
                                   value="Perkantoran">
                            <label for="{{$type}}_perkantoran">Perkantoran</label>
                            <br>
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_industri"
                                   class="form-radio-label"
                                   value="Industri">
                            <label for="{{$type}}_industri">Industri</label>
                            <br>
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_pergudangan"
                                   class="form-radio-label"
                                   value="Pergudangan">
                            <label for="{{$type}}_pergudangan">Pergudangan</label>
                            <br>
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_pelabuhan"
                                   class="form-radio-label"
                                   value="Pelabuhan">
                            <label for="{{$type}}_pelabuhan">Pelabuhan</label>
                            <br>
                            <input type="radio"
                                   name="{{$type}}"
                                   id="{{$type}}_pendidikan"
                                   class="form-radio-label"
                                   value="Pendidikan">
                            <label for="{{$type}}_pendidikan">Pendidikan</label>
                            <br>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="bkpm">BKPM</label>
                    <div class="col-lg-10">
                        <select name="bkpm" id="bkpm" class="form-control">
                            <option value="Ada">Ada</option>
                            <option value="Tidak ada">Tidak Ada</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="provinsi">Provinsi</label>
                    <div class="col-lg-10">
                        <select name="provinsi"
                                id="provinsi"
                                class="form-control"
                                required>
                            <option value="">pilih provinsi</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="kabupaten">Kota/Kabupaten</label>
                    <div class="col-lg-10">
                        <select name="kab_kota"
                                id="kabupaten"
                                class="form-control"
                                required>
                            <option value="">pilih provinsi terlebih dahulu</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="kecamatan">Kecamatan</label>
                    <div class="col-lg-10">
                        <select name="kecamatan"
                                id="kecamatan"
                                class="form-control"
                                required>
                            <option value="">pilih kota/kabupaten terlebih dahulu</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="desa">Desa/Kelurahan</label>
                    <div class="col-lg-10">
                        <select name="desa_kel"
                                id="desa"
                                class="form-control"
                                required>
                            <option value="">pilih kecamatan terlebih dahulu</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="jalan">Detail Alamat</label>
                    <div class="col-lg-10">
                        <input type="text"
                               name="keterangan"
                               id="jalan"
                               class="form-control"
                               required
                               maxlength="255">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="rt">Dusun</label>
                    <div class="col-lg-10">
                        <input type="text"
                               name="dusun"
                               id="dusun"
                               class="form-control"
                               required
                               maxlength="255">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="rw">RW</label>
                    <div class="col-lg-10">
                        <input type="text"
                               name="rw"
                               id="rw"
                               class="form-control"
                               required
                               maxlength="255">
                    </div>
                </div>
            </div>
            <div class="flex-row d-flex justify-content-between">
                <div class="justify-content-start">
                    <button type="button"
                            class="btn btn-primary"
                            id="back"><i class="fas fa-backward"></i> Sebelumnya</button>
                </div>
                <div class="justify-content-end">
                    <button type="button"
                            class="btn btn-primary"
                            id="next"><i class="fas fa-forward"></i> Selanjutnya</button>
                    <button type="submit"
                            class="btn btn-success"
                            id="submit"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const form = $('#form-fkpm');

        function ignite() {
            const next = document.querySelector("#next");
            const back = document.querySelector("#back");
            const submit = document.querySelector("#submit");
            const del = document.querySelector("#delete");

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

                    formData.forEach((value, key) => {
                        if (key === 'sumber_dana') {
                            object[key] = ''
                            object[key] = [...document.querySelectorAll(`[name="sumber_dana"]:checked`)]
                                .map(item => item.value)
                                .join(', ')
                        } else {
                            object[key] = value
                        }
                    })

                    return object;
                }
                switch (action) {
                    case "ADD":
                        const addData = saveFormData('form-fkpm');
                        state.data[state.position] = addData;
                        state.position = state.position + 1;
                        break;
                    case 'BACK':
                        const backData = saveFormData('form-fkpm');
                        state.data[state.position] = backData;
                        state.position = state.position - 1;
                        break;
                    case "DELETE":
                        state.data = state.data.filter((item, index) => index !== state.position);
                        state.position = state.data.length - 1;
                        break;
                    case "SUBMIT":
                        state.data[state.position] = saveFormData('form-fkpm');
                        const btnSubmit = document.querySelector('#form-fkpm').querySelector('button[type="submit"]')
                        btnSubmit.disabled = true;
                        setTimeout(function () {
                            btnSubmit.disabled = false;
                        }, 5000);
                        $.ajax({
                            url: route('{{$route_store}}'),
                            method: 'post',
                            data: {
                                "data": JSON.stringify(state.data)
                            },
                            success: function (response) {
                                swalSuccess("Berhasil menambahkan laporan");
                                setTimeout(function () {
                                    window.location.href = route('{{$route_index}}');
                                }, 2000);
                            },
                        });
                        break;
                    default:
                        state.position = 0;
                }

                document.getElementById('data-fkpm').textContent = state.position + 1;
                return state;
            }

            const store = createStore(initialState, reducer);

            function updateUI() {
                resetForm(form)

                const data = store.getState().data
                const position = store.getState().position

                if (data.length === 0 || position === 0) back.classList.add('d-none')
                else back.classList.remove('d-none')

                $('#polda').val('{{ auth()->user()?->personel?->polda }}');
                $('#polres').val('{{ auth()->user()?->personel?->polres }}');

                const codes = document.querySelectorAll('[name$="_code"]')
                for (let code of codes) code.value = data[position - 1]?.[code.name] ?? null

                const checkboxes = document.querySelectorAll(`input[type="checkbox"]`)
                for (let checkbox of checkboxes) checkbox.checked = false

                const radios = document.querySelectorAll('input[type="radio"]')
                for (let radio of radios) radio.checked = false

                let values = data[position]

                if (values === undefined) return

                for (let name in values) {
                    let input = form.find(`[name="${name}"]`);
                    const value = values[name]

                    if (name === 'sumber_dana') {
                        const items = value.split(', ')
                        for (let item of items) {
                            const input = document.querySelector(`input[value="${item}"]`)
                            if (input) input.checked = true
                        }
                    } else if (name === 'type') {
                        const input = document.querySelector(`input[value="${value}"]`)
                        if (input) input.checked = true
                        if (value === 'RW') label.textContent = 'RW'
                        else if (value === 'Dusun') label.textContent = 'Dusun'
                        else if (value === 'Desa/Kelurahan') label.textContent = 'Desa/Kelurahan'
                    } else if (input.is('select')) {
                        const id = values[name+'_code']
                        input.empty()
                        input.append(`<option value="${value}" id="${id}" selected>${value}</option>`)
                    } else {
                        input.val(value);
                    }
                }

                fetchProvinsi(false, values['provinsi_code'])
            }
            updateUI();

            next.addEventListener("click", async (e) => {
                e.preventDefault();
                store.dispatch("ADD");
            });
            back.addEventListener("click", async (e) => {
                e.preventDefault();
                store.dispatch("BACK");
            });
            submit.addEventListener("click", async (e) => {
                e.preventDefault();
                store.dispatch("SUBMIT");
            });
            del.addEventListener("click", async (e) => {
                e.preventDefault();
                store.dispatch("DELETE");
            });
        }
        ignite();

        let provinsi  = $('#provinsi');
        let kabupaten = $('#kabupaten');
        let kecamatan = $('#kecamatan');
        let desa      = $('#desa');

        async function fetchProvinsi(clear = true, selected = null) {
            const res = await fetch(route('alamat-provinsi'))
            const data = await res.json()

            if (clear) {
                provinsi.empty()
                provinsi.append(`<option value="" selected disabled>pilih provinsi</option>`)
            }

            for (let id in data) {
                if (selected == id) continue
                else provinsi.append(`<option value="${data[id]}" id="${id}">${data[id]}</option>`)
            }
        }

        fetchProvinsi()

        provinsi.on('change', () => {
            setOptionAlamat(
                provinsi,
                route('alamat-kota'),
                kabupaten,
                'kota/kabupaten'
            )
            const provinsi_code = provinsi.find('option:selected').attr('id')
            document.querySelector('[name="provinsi_code"]').value = provinsi_code
        })

        kabupaten.on('change', () => {
            setOptionAlamat(
                kabupaten,
                route('alamat-kecamatan'),
                kecamatan,
                'kecamatan'
            )

            const kabupaten_code = kabupaten.find('option:selected').attr('id')
            document.querySelector('[name="kabupaten_code"]').value = kabupaten_code
        })

        kecamatan.on('change', () => {
            setOptionAlamat(
                kecamatan,
                route('alamat-desa'),
                desa,
                'kelurahan/desa'
            )

            const kecamatan_code = kecamatan.find('option:selected').attr('id')
            document.querySelector('[name="kecamatan_code"]').value = kecamatan_code
        })

        desa.on('change', () => {
            const desa_code = desa.find('option:selected').attr('id')
            document.querySelector('[name="desa_code"]').value = desa_code
        })

        const types = document.querySelectorAll('input[type="radio"][name="type"]');
        const label = document.querySelector('label[for="dasar_hukum"]');

        for (let type of types) {
            type.addEventListener('change', () => {
                if (type.value === 'AHU') {
                    label.textContent = 'Nomor AHU Kemenkumham';
                } else if (type.value === 'SKT') {
                    label.textContent = 'SKT Kemendagri';
                }
            })
        }
    </script>
@endpush
