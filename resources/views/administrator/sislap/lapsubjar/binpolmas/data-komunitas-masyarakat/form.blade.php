<div>
    <div class="card" id="form-card">
        <input type="text" name="provinsi_code" class="d-none">
        <input type="text" name="kabupaten_code" class="d-none">
        <input type="text" name="kecamatan_code" class="d-none">
        <input type="text" name="desa_code" class="d-none">
        <div class="card-header d-flex bg-primary align-items-center justify-content-between">
            <h3 class="card-title w-50" id="data-ormas"></h3>
            <div class="card-tools d-flex w-50 justify-content-end">
                <button type="button" class="btn btn-danger remove-data" id="delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="nama_kommas">Nama Komunitas Masyarakat</label>
                    <div class="col-lg-10">
                        <input type="text"
                            name="nama_kommas"
                            id="nama_kommas"
                            class="form-control"
                            required
                            maxlength="255">
                    </div>
                </div>
            </div>
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
{{--                        <select name="polda" id="select-polda" class="form-control select2">--}}
{{--                            <option></option>--}}
{{--                        </select>--}}
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
                    <label class="col-lg-2" for="akta_notaris">Akta Notaris</label>
                    <div class="col-lg-10">
                        <input type="text"
                            name="akta_notaris"
                            id="akta_notaris"
                            class="form-control"
                            maxlength="255"
                            required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="tanggal_akta_notaris">Tanggal Akta Notaris</label>
                    <div class="col-lg-10">
                        <input type="date"
                            name="tanggal_akta_notaris"
                            id="tanggal_akta_notaris"
                            class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="npwp">NPWP</label>
                    <div class="col-lg-10">
                        <input type="text"
                            name="npwp"
                            id="npwp"
                            class="form-control"
                            required
                            maxlength="255">
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
                        <select name="kabupaten"
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
                    <label class="col-lg-2" for="desa">desa</label>
                    <div class="col-lg-10">
                        <select name="desa"
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
                    <label class="col-lg-2" for="jalan">Jalan</label>
                    <div class="col-lg-10">
                        <input type="text"
                            name="jalan"
                            id="jalan"
                            class="form-control"
                            required
                            maxlength="255">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="rt">RT</label>
                    <div class="col-lg-10">
                        <input type="text"
                            name="rt"
                            id="rt"
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
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="sumber_dana">Sumber Dana</label>
                    <div class="col-lg-10">
                        @php $sumber_dana = \App\Models\Sislap\Lapsubjar\Binpolmas\DataKomunitasMasyarakat::SUMBER_DANA; @endphp
                        @foreach ($sumber_dana as $key => $value)
                            <input
                                type="checkbox"
                                name="sumber_dana"
                                id="sumber_dana_{{ $key }}"
                                value="{{ $value }}">
                            <label for="sumber_dana_{{ $key }}" class="form-check-label">{{ $value }}</label>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="bidang_kegiatan">Bidang Kegiatan</label>
                    <div class="col-lg-10">
                        <input type="text"
                            name="bidang_kegiatan"
                            id="bidang_kegiatan"
                            class="form-control"
                            required
                            maxlength="255">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="jml_anggota">Jumlah Anggota</label>
                    <div class="col-lg-10">
                        <input type="number"
                            name="jml_anggota"
                            id="jml_anggota"
                            class="form-control"
                            required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="nama_ketua">Nama Ketua</label>
                    <div class="col-lg-10">
                        <input type="text"
                            name="nama_ketua"
                            id="nama_ketua"
                            class="form-control"
                            required
                            maxlength="255">
                    </div>
                </div>
            </div><div class="form-group">
                <div class="row">
                    <label class="col-lg-2" for="no_hp_ketua">Nomor Handphone Ketua</label>
                    <div class="col-lg-10">
                        <input type="text"
                            name="no_hp_ketua"
                            id="no_hp_ketua"
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
    @include('assets.js.twbs-pagination')
    @include('assets.js.select2')

    <script>
        const form = $('#form-ormas');

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
                        const addData = saveFormData('form-ormas');
                        state.data[state.position] = addData;
                        state.position = state.position + 1;
                        break;
                    case 'BACK':
                        const backData = saveFormData('form-ormas');
                        state.data[state.position] = backData;
                        state.position = state.position - 1;
                        break;
                    case "DELETE":
                        state.data = state.data.filter((item, index) => index !== state.position);
                        state.position = state.data.length - 1;
                        break;
                    case "SUBMIT":
                        state.data[state.position] = saveFormData('form-ormas');
                        const btnSubmit = document.querySelector('#form-ormas').querySelector('button[type="submit"]')
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
                                swalSuccess(response.message);
                                setTimeout(function () {
                                    window.location.href = route('{{$route_index}}');
                                }, 2000);
                            },
                        });
                        break;
                    default:
                        state.position = 0;
                }

                document.getElementById('data-ormas').textContent = state.position + 1;
                return state;
            }

            const store = createStore(initialState, reducer);

            function updateUI() {
                resetForm(form)

                const data = store.getState().data
                const position = store.getState().position

                if (data.length === 0 || position === 0) back.classList.add('d-none')
                else back.classList.remove('d-none')

                const codes = document.querySelectorAll('[name$="_code"]')
                for (let code of codes) code.value = data[position - 1]?.[code.name] ?? null

                const checkboxes = document.querySelectorAll(`input[type="checkbox"]`)
                for (let checkbox of checkboxes) checkbox.checked = false

                $('#polda').val('{{ auth()->user()?->personel?->polda }}');
                $('#polres').val('{{ auth()->user()?->personel?->polres }}');

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
                    } else if (input.is('select')) {
                        const id = values[name+'_code']
                        input.empty()
                        input.append(`<option value="${value}" id="${id}" selected>${value}</option>`)
                    } else {
                        input.val(value);
                    }
                }

                fetchProvinsi(false, data['provinsi_code'])
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

        {{--const initSelectPolda = (el = $('#select-polda')) => {--}}
        {{--    buildSelect2Search({--}}
        {{--        placeholder: '-- Pilih Polda --',--}}
        {{--        url: '{{ route('polda.select2') }}',--}}
        {{--        minimumInputLength: 0,--}}
        {{--        selector: [{ id: el }],--}}
        {{--        query: function (params) {--}}
        {{--            return {--}}
        {{--                polda: params.term,--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
        {{--initSelectPolda();--}}
    </script>
@endpush
