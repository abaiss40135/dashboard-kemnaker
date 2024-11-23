@extends('templates.admin-lte.admin', ['title' => 'Rekap Laporan Harian Pasca Gempa Cianjur'])
@section('customcss')
    @include('assets.css.select2')
    @include('assets.css.datetimepicker')
@endsection
@section('content')
    <section class="card">
        <div class="card-body">
            <form action="{{ route('rekap-laphar-pasca-gempa-cianjur.excel') }}"
                  class="form" id="filter">
                @csrf
                <div class="alert alert-gray">
                    <h5 ><i class="icon fas fa-filter"></i> Filter</h5>
                    <hr>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="select-polda">Satuan Polda</label>
                            <select name="polda" id="select-polda" class="form-control select2">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="date">Tanggal</label>
                            <input type="text" name="date" id="date" class="form-control">
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center justify-content-sm-end">
                        <div>
                            <button type="submit" class="btn btn-success">Ekspor</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="button" class="btn btn-primary btn-search">Cari</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table id="rekap-table" class="table table-hover table-bordered">
                    <thead class="text-center bg-primary">
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Kesatuan</th>
                            <th id="giat-header">Jenis Giat</th>
                        </tr>
                        <tr id="giat-subheader"></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>            
        </div>
    </section>
@endsection
@section('customjs')
    @include('assets.js.select2')
    @include('assets.js.datetimepicker')
    <script>
        const date = {
            start_date: null,
            end_date: null
        }

        $('#date').daterangepicker(datetimeSetup, function (start, end, label) {
            date.start_date = start.format('YYYY-MM-DD')
            date.end_date = end.format('YYYY-MM-DD')
        })
        
        buildSelect2Search({
            placeholder: '-- Pilih Polda --',
            url: route('polda.select2'),
            minimumInputLength: 0,
            selector: [{ id: $('#select-polda') }],
            query: function (params) {
                return {
                    polda: params.term,
                }
            }
        })

        /**
         * Create HTMLElement with class [text-center, align-middle]
         * 
         * @argument String text, String type Default 'td'
         * 
         * @return HTMLElement
         */
        function createCol(text, type = 'td') {
            const column = document.createElement(type)
            column.textContent = text
            column.classList.add('text-center')
            column.classList.add('align-middle')

            return column
        }

        /**
         * Set colspan of HTMLElement
         * 
         * @arguments HTMLElement col, Integer length
         * @return void
         */
        function setColumnSpan(col, length) {
            col.setAttribute('colspan', length)
        }

        /**
         * Set table header columns
         * 
         * @arguments HTMLElement container, Array<String> data
         * @return void
         */
        function setHeader(container, data) {
            data.forEach(header => {
                const el = createCol(header, 'th')
                container.appendChild(el)
            })
        }

        /**
         * Set table body
         * 
         * @arguments HTMLElement container, Object<Object> data, Integer col_len
         * @return void
         */
        function setBody(container, data, col_len) {
            let iterator = 1

            if (Object.keys(data).length == 0) {
                let empty = createCol('Data tidak ditemukan')
                setColumnSpan(empty, col_len)

                container.appendChild(empty)
            }

            for (let prop in data) {
                const row = document.createElement('tr')
                row.appendChild(createCol(iterator++))
                row.appendChild(createCol(prop))

                for (let jumlah in data[prop]) row.appendChild(createCol(data[prop][jumlah]))

                container.appendChild(row)
            }
        }

        /**
         * Clear innerHTML of header & body of table
         * 
         * @arguments HTMLElement header, HTMLElement body
         * @return void 
         */
        function clearTable(header, body) {
            header.innerHTML = ''
            body.innerHTML = ''
        }

        /**
         * Set rekap table
         * 
         * @arguments Array<String> headers, Object<Object> body
         * @return void
         */
        function setTable(headers, body) {
            const table = document.querySelector('#rekap-table')
            const giat_header = table.querySelector('#giat-header')
            const giat_subheader_container = table.querySelector('#giat-subheader')
            const body_container = table.querySelector('tbody')

            clearTable(giat_subheader_container, body_container)
            setColumnSpan(giat_header, headers.length)
            setHeader(giat_subheader_container, headers)
            setBody(body_container, body, headers.length + 2)
        }

        function getData() {
            axios(route('rekap-laphar-pasca-gempa-cianjur.data'), {
                params: {
                    polda: $('#select-polda').select2('data')[0].text,
                    start_date: date.start_date,
                    end_date: date.end_date
                }
            })
            .then((res) => res.data)
            .then((data) => { setTable(data.headers, data.body) })
        }
        getData()

        document
        .querySelector('#filter button.btn-search')
        .addEventListener('click', (e) => {
            e.preventDefault()
            getData()
        })
    </script>
@endsection