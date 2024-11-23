@push('styles')
    @include('assets.css.select2')
    @include('assets.css.shimmer')
    @include('assets.css.datetimepicker')
    <link href="{{ asset('/css/gl.css')}}" rel="stylesheet" />
    <style>
        .datetimepicker {
            z-index: 1600 !important
        }
        .mapboxgl-popup {
            max-width: 420px !important
        }
        .mapboxgl-popup-content {
            padding: 1.5rem;
            border: 0.2rem solid #264364;
            border-radius: 0.5rem;
        }
        .mapboxgl-popup-close-button {
            margin-right: 0.5rem !important;
            margin-top: 0.5rem !important;
            font-size: 1.5rem !important
        }
        .popup-pic {
            position: absolute;
            top: -7rem;
            left: 0;
            right: 0;
            margin: auto;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            border: 0.2rem solid #264364;
            background-color: #fff;
            z-index: 2;
        }

        .popup-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush
<div class="card">
    <div class="card-body">
        <form
            action="#"
            class="form"
            id="filter-form">
            @csrf
            <div class="alert alert-gray mb-0">
                <h5><i class="icon fas fa-filter"></i> Filter</h5>
                <hr>
                <div class="row">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label for="select-provinsi">provinsi</label>
                                <select
                                    name="provinsi"
                                    id="select-provinsi"
                                    class="form-control select2">
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="select-kota">kota/Kabupaten</label>
                                <select
                                    name="kota"
                                    id="select-kota"
                                    class="form-control select2">
                                    <option value="">-- Pilih provinsi terlebih dahulu --</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="nrp">NRP</label>
                                <input
                                    type="text"
                                    id="nrp"
                                    name="nrp"
                                    class="form-control"
                                    placeholder="8 Digit NRP Personel">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="date">Rentang Waktu Login</label>
                                <input
                                    type="text"
                                    name="date"
                                    id="date"
                                    class="form-control">
                                <input
                                    type="time"
                                    name="start_date"
                                    id="start-date"
                                    class="d-none">
                                <input
                                    type="time"
                                    name="end_date"
                                    id="end-date"
                                    class="d-none">
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-12 col-lg-2 d-flex align-items-end mb-3"
                        style="column-gap: 0.5rem">
                        <button
                            type="reset"
                            class="btn w-100 btn-warning"
                            onclick="resetForm()">Reset</button>
                        <button
                            type="submit"
                            class="btn w-100 btn-primary">
                            <i class="fa fa-search"></i> cari
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="w-100" style="height: 100vh" id="map"></div>
    </div>
</div>
@push('scripts')
    @include('assets.js.select2')
    @include('assets.js.datetimepicker')
    <script src="{{ asset('/js/gl.js')}}" type="text/javascript"></script>
    <script>
        gl.accessToken = @json(config('app.map_api_key'));

        const ZOOM_LEVEL = 4.56
        const FILTER_FORM = $('#filter-form')
        const FILTER_PROVINSI = $('#select-provinsi')
        const FILTER_KOTA = $('#select-kota')
        const FILTER_NRP = $('#nrp')
        const FILTER_START_DATE = $('#start-date')
        const FILTER_END_DATE = $('#end-date')
        const mapContainer = document.querySelector('#map')
        const markers = []

        let stoppedByOtherFetch = false

        const getScalePercent = (zoom) => 1 + (zoom - 4)  * 0.32

        const map = new gl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [117.921327, -1.289275],
            zoom: ZOOM_LEVEL
        })

        map.on('load', () => {
            const clearMarks = () => {
                for (marker of markers) marker.remove()
                markers.length = 0
            }

            map.addSource('bhabinkamtibmas-locations', {
                type: 'geojson',
                data: route('dashboard-lokasi.bhabinkamtibmas.get-locs'),
                cluster: true,
                clusterMaxZoom: 14,
                clusterRadius: 50
            })

            map.addLayer({
                id: 'cluster',
                type: 'circle',
                source: 'bhabinkamtibmas-locations',
                filter: ['has', 'point_count'],
                paint: {
                    'circle-color': ['step', ['get', 'point_count'], '#83bbfc', 100, '#72a3db', 750, '#608aba'],
                    'circle-radius': ['step', ['get', 'point_count'], 20, 100, 30, 750, 40]
                }
            })

            map.addLayer({
                id: 'cluster-count',
                type: 'symbol',
                source: 'bhabinkamtibmas-locations',
                filter: ['has', 'point_count'],
                layout: {
                    'text-field': ['get', 'point_count_abbreviated'],
                    'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                    'text-size': 12
                }
            })

            map.on('click', 'cluster', (e) => {
                const features = map.queryRenderedFeatures(e.point, {
                    layers: ['cluster']
                });

                const clusterId = features[0].properties.cluster_id;

                map.getSource('bhabinkamtibmas-locations').getClusterExpansionZoom(
                    clusterId,
                    (err, zoom) => {
                        if (err) return;

                        map.easeTo({
                            center: features[0].geometry.coordinates,
                            zoom: zoom
                        });
                    }
                );
            });

            map.loadImage("{{ asset('images/icons/bhabin.png') }}", (error, image) => {
                if (error) throw error

                map.addImage('bhabin', image);

                map.addLayer({
                    id: 'unclustered-point',
                    type: 'symbol',
                    source: 'bhabinkamtibmas-locations',
                    filter: ['!', ['has', 'point_count']],
                    layout: {
                        'icon-image': 'bhabin',
                        'icon-size': 1.5
                    }
                })

                map.on('click', 'unclustered-point', async (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice()
                    const user_id = e.features[0].properties.user_id
                    const el_id = `popup-${user_id}`

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360
                    }

                    new gl.Popup()
                        .setLngLat(coordinates)
                        .setDOMContent(popupTemplate(el_id))
                        .addTo(map)

                    const data = await fetchProfile(el_id, user_id)
                    renderProfile(el_id, data)
                })

                map.on('mouseenter', 'unclustered-point', () => {
                    map.getCanvas().style.cursor = 'pointer'
                })

                map.on('mouseleave', 'unclustered-point', () => {
                    map.getCanvas().style.cursor = ''
                })
            })

            const fetchProfile = async (id, user_id) => {
                const url = route('dashboard-lokasi.bhabinkamtibmas.get-profile', { user_id: user_id })
                const res = await fetch(url)

                return await res.json()
            }

            const scaleIt = (el) => {
                el.style.transform = `scale(${getScalePercent(map.getZoom())})`
                el.style.transformOrigin = 'bottom'
            }

            const popupTemplate = (id) => {
                const createElement = (tag, options = {}) => {
                    const element = document.createElement(tag)
                    Object.assign(element, options)
                    return element
                }

                const container = createElement('div')
                const shimmer = createElement('div', { id: `${id}-shimmer`, style: 'width: 360px' })
                const box_container = createElement('div', { className: 'd-flex justify-content-center' })
                const box = createElement('div', { className: 'box shine mt-0 mb-4' })
                const lines_title = createElement('span', { className: 'lines-title shine w-100 mt-0 mb-2' })
                const lines_1 = createElement('span', { className: 'lines shine w-75 mt-0 mb-4' })
                const lines_2 = createElement('span', { className: 'lines shine w-100 mt-0 mb-2' })
                const lines_3 = createElement('span', { className: 'lines shine w-75 m-0' })
                const content = createElement('div', { id: `${id}-content`, className: 'd-none', style: 'display: relative'})
                const img_container = createElement('div', { className: 'popup-pic' })
                const img = createElement('img', { id: `${id}-foto`, alt: 'foto_personel' })
                const h5 = createElement('h5', { className: 'mb-2', style: 'margin-top: 5rem' })
                const pangkat = createElement('span', { id: `${id}-pangkat`, className: 'font-weight-bold' })
                const nama = createElement('span', { id: `${id}-nama`, className: 'font-weight-bold ml-2' })
                const br = createElement('br')
                const nrp = createElement('span', { id: `${id}-nrp`, className: 'font-weight-bold' })
                const hr = createElement('hr', { style: 'border-color: #264364' })
                const divisi_title = createElement('h6', { className: 'font-weight-bold mb-0' })
                divisi_title.innerText = 'Divisi'
                const jabatan = createElement('span', { id: `${id}-jabatan`, className: 'mb-4 d-inline-block' })
                const lokasi_title = createElement('h6', { className: 'font-weight-bold mb-0' })
                lokasi_title.innerText = 'Lokasi Penugasan'
                const lokasi_tugas_container = createElement('span', { className: 'd-inline-block mb-2' })
                const lokasi_tugas = createElement('ul', { id: `${id}-lokasi-tugas`, style: 'padding-inline-start: 24px' })
                const terakhir_login_title = createElement('h6', { className: 'font-weight-bold mb-0' })
                terakhir_login_title.innerText = 'Terakhir Login'
                const terakhir_login = createElement('span', { id: `${id}-terakhir-login`, className: 'd-inline-block' })
                const hr_2 = createElement('hr', { style: 'border-color: #264364' })
                const contact_container = createElement('div', { className: 'd-flex', style: 'column-gap: 0.5rem' })
                const wa = createElement('a', { id: `${id}-wa`, href: '', className: 'btn w-100 text-white', style: 'background-color: #25d366' })
                const wa_icon = createElement('i', { className: 'fa-brands fab fa-whatsapp', 'aria-hidden': 'true' })
                const wa_text = createElement('span', { innerText: 'WhatsApp', style: 'margin-left: 0.5rem' })
                const handphone = createElement('a', { id: `${id}-handphone`, href: '', className: 'btn w-100 btn-primary' })
                const handphone_icon = createElement('i', { className: 'fa fa-phone', 'aria-hidden': 'true' })
                const handphone_text = createElement('span', { innerText: 'Telepon', style: 'margin-left: 0.5rem' })

                box_container.appendChild(box)
                shimmer.append( box_container, lines_title, lines_1, lines_2, lines_3)
                img_container.appendChild(img)
                h5.append(pangkat, nama, br, nrp)
                lokasi_tugas_container.appendChild(lokasi_tugas)
                wa.append(wa_icon, wa_text)
                handphone.append(handphone_icon, handphone_text)
                contact_container.append(wa, handphone)
                content.append(img_container, h5, hr, divisi_title, jabatan, lokasi_title, lokasi_tugas_container, terakhir_login_title, terakhir_login, hr_2, contact_container)
                container.appendChild(shimmer)
                container.appendChild(content)

                return container
            }

            const renderProfile = (el_id, data) => {
                const { personel, user, lokasi_penugasan } = data
                const container = document.querySelector(`#${el_id}-content`)

                document.querySelector(`#${el_id}-shimmer`).classList.add('d-none')
                container.classList.remove('d-none')

                container.querySelector(`#${el_id}-foto`).src = personel.foto
                container.querySelector(`#${el_id}-pangkat`).textContent = personel.pangkat
                container.querySelector(`#${el_id}-nama`).textContent = personel.nama
                container.querySelector(`#${el_id}-nrp`).textContent = user.nrp
                container.querySelector(`#${el_id}-jabatan`).textContent = personel.jabatan

                const list_lokasi_tugas = lokasi_penugasan.map((lp) => `<li>${lp.lokasi}</li>`).join('')
                container.querySelector(`#${el_id}-lokasi-tugas`).innerHTML = list_lokasi_tugas

                const formatted_last_login = new Date(user.last_login_at).toLocaleString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                })
                container.querySelector(`#${el_id}-terakhir-login`).textContent = formatted_last_login

                const handphone = personel.handphone.trim().replace(/^0/, '62').replace(/,.*/, '')
                container.querySelector(`#${el_id}-handphone`).href = `tel:${handphone}`
                container.querySelector(`#${el_id}-wa`).href = `https://wa.me/${handphone}`
            }

            const createMarker = async (loc) => {
                const el_id = `popup-${loc.user_id}`

                const marker = new gl.Marker({
                    color: "#FF0000",
                    draggable: false,
                    scale: 0.14
                })
                .setLngLat([loc.longitude, loc.latitude])
                .setPopup(
                    new gl.Popup({ offset: 25 })
                    .setDOMContent(popupTemplate(el_id))
                )
                .addTo(map)

                const marker_el = marker.getElement().children[0]
                marker_el.addEventListener('click', async () => {
                    const data = await fetchProfile(el_id, loc.user_id)
                    renderProfile(el_id, data)
                })
                scaleIt(marker_el)

                markers.push(marker)
            }

            map.addControl(new gl.FullscreenControl({ container: mapContainer }))
            map.addControl(new gl.NavigationControl({ showCompass: false }))
            map.on('zoom', () => {
                for (let marker of markers) scaleIt(marker.getElement().children[0])
            })

            buildSelect2Search({
                placeholder: '-- Pilih Provinsi --',
                url: route('provinsi.select2'),
                minimumInputLength: 0,
                selector: [{ id: FILTER_PROVINSI }],
                query: function (params) {
                    return {
                        name: params.term,
                        text: 'name'
                    }
                }
            })

            const buildSelect2Kota = (provinsi_code) => {
                buildSelect2Search({
                    placeholder: '-- Pilih Kota --',
                    url: route('kota.select2'),
                    minimumInputLength: 0,
                    selector: [{ id: FILTER_KOTA } ],
                    query: function (params) {
                        return {
                            name: params.term,
                            province_code: provinsi_code
                        }
                    }
                })
            }

            FILTER_PROVINSI.on('select2:select', function (e) {
                let data = e.params.data
                buildSelect2Kota(data.id)
            })

            FILTER_PROVINSI.on('select2:unselect', function (e) {
                FILTER_KOTA.val(null).trigger('change')
                FILTER_KOTA.empty()
                FILTER_KOTA.append('<option value="">-- Pilih Kota/Kabupaten --</option>')
            })

            $('#date').daterangepicker(datetimeSetup, function (start, end) {
                FILTER_START_DATE.val(start.format('YYYY-MM-DD'))
                FILTER_END_DATE.val(end.format('YYYY-MM-DD'))
            })

            FILTER_FORM.on('submit', function (e) {
                e.preventDefault()

                const params = {
                    provinsi: FILTER_PROVINSI.val(),
                    kota: FILTER_KOTA.val(),
                    nrp: FILTER_NRP.val(),
                    start_date: FILTER_START_DATE.val(),
                    end_date: FILTER_END_DATE.val(),
                }

                fetch(route('dashboard-lokasi.bhabinkamtibmas.get-locs', params))
                    .then(response => response.json())
                    .then(data => {
                        map.getSource('bhabinkamtibmas-locations').setData(data)

                    })
                    .catch(error => {
                    console.error('Error fetching data:', error)
                    })
            })
        })
    </script>
@endpush