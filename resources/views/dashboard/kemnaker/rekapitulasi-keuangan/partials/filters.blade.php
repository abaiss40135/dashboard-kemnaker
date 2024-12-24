
<div class="box rounded-2xl">
    <div class="box-header flex b-0 justify-start items-center">
        <h2 class="mt-0"><i class="icon fas fa-filter"></i> Filter</h2>
    </div>
    <div class="box-body pt-0 summery-box">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label for="unit-kerja" class="block text-sm font-medium text-gray-700">Nama Unit Kerja</label>
                <select
                    id="unit-kerja"
                    name="unit-kerja"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                >
                    <option value="02601">02601 | SEKRETARIS JENDERAL</option>
                    <option value="02602">02602 | INSPEKTUR JENDERAL</option>
                    <option value="02604">02604 | DITJEN PEMBINAAN PENEMPATAN TENAGA KERJA DAN PERLUASAN KESEMPATAN KERJA</option>
                    <option value="02605">02605 | DIRJEN PEMBINAAN HUBUNGAN INDUSTRIAL & JAMINAN SOSIAL KETENAGAKERJAAN</option>
                    <option value="02608">02608 | DITJEN PEMBINAAN PENGAWASAN KETENAGAKERJAAN DAN KESELAMATAN DAN KESEHATAN KERJA</option>
                    <option value="02611">02611 | BADAN PERENCANAAN DAN PENGEMBANGAN KETENAGAKERJAAN</option>
                    <option value="02613">02613 | DIRJEN PEMBINAAN PELATIHAN DAN PRODUKTIVITAS</option>
                  </select>
            </div>
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Pencarian Umum</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Cari berdasarkan kolom-kolom di tabel"
                >
            </div>
        
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    >
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    >
                </div>
            </div>
        </div>                
    </div>
</div>

@push('scripts')
@include('assets.js.select2')
    <script>
        if (window.screen.width < 480) setTimeout(function() {
            document.body.classList.remove('sidebar-closed', 'sidebar-collapse')
            document.body.classList.add('sidebar-open')
        }, 3000)


        buildSelect2({
            placeholder: '-- Pilih Unit Kerja --',
            minimumInputLength: 0,
            minimumResultsForSearch: Infinity,
            selector: [{
                id: $('#unit-kerja')
            }],
            data: [{
                    code: "02601",
                    name: "SEKRETARIS JENDERAL"
                },
                {
                    code: "02602",
                    name: "INSPEKTUR JENDERAL"
                },
                {
                    code: "02604",
                    name: "DITJEN PEMBINAAN PENEMPATAN TENAGA KERJA DAN PERLUASAN KESEMPATAN KERJA"
                },
                {
                    code: "02605",
                    name: "DIRJEN PEMBINAAN HUBUNGAN INDUSTRIAL & JAMINAN SOSIAL KETENAGAKERJAAN"
                },
                {
                    code: "02608",
                    name: "DITJEN PEMBINAAN PENGAWASAN KETENAGAKERJAAN DAN KESELAMATAN DAN KESEHATAN KERJA"
                },
                {
                    code: "02611",
                    name: "BADAN PERENCANAAN DAN PENGEMBANGAN KETENAGAKERJAAN"
                },
                {
                    code: "02613",
                    name: "DIRJEN PEMBINAAN PELATIHAN DAN PRODUKTIVITAS"
                }
            ]
        })

        const changeTable2 = () => {
            $('#reset-table-2-btn').removeClass('hidden')
            $('#table-2-child').removeClass('hidden')
            $('#table-2-parent').addClass('hidden')
        }

        const resetTable2 = () => {
            $('#reset-table-2-btn').addClass('hidden')
            $('#table-2-child').addClass('hidden')
            $('#table-2-parent').removeClass('hidden')
        }
    </script>
@endpush