@extends('templates.dashboard.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-x-4">
    <x-recap-link
        title="Penduduk yang Bekerja"
        icon="fa-briefcase"
        bg="bg-primary-light"
        attrs="data-modal-target='ketenagakerjaan-modal' data-modal-toggle='ketenagakerjaan-modal'"    
    />
    <x-recap-link
        title="Rata-rata Upah Sebulan"
        icon="fa-coins"
        bg="bg-info-light"
        attrs="data-modal-target='ketenagakerjaan-modal' data-modal-toggle='ketenagakerjaan-modal'"    
    />
    <x-recap-link
        title="Rata-rata Jam Kerja Seminggu"
        icon="fa-stopwatch"
        bg="bg-warning-light"
        attrs="data-modal-target='ketenagakerjaan-modal' data-modal-toggle='ketenagakerjaan-modal'"    
    />
    <x-recap-link
        title="Jumlah Pengangguran Terbuka"
        icon="fa-tachometer-alt"
        bg="bg-warning-light"
        attrs="data-modal-target='ketenagakerjaan-modal' data-modal-toggle='ketenagakerjaan-modal'"    
    />
</div>
@endsection

@push('modals')
<div
        id="ketenagakerjaan-modal"
        data-modal-backdrop="static"
        tabindex="-1"
        aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[1000] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full "
    >
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Unggah Data
                    </h3>
                    <button
                        type="button"
                        class="waves-effect waves-light btn btn-flat btn-light"
                        data-modal-hide="ketenagakerjaan-modal"
                    >
                        <i class="fa-solid fa-times me-0 fs-24 rounded-3"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="p-4 md:p-5">
                    <div class="flex items-center justify-center w-full mb-5">
                        <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg
                                    class="w-8 h-8 mb-4 text-gray-500"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 20 16"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                                    />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                </p>
                            </div>
                            <input type="file" accept=".xls,.xlsx,.csv" class="hidden" />
                        </label>
                    </div>
                    <div class="flex items-center px-4 pt-4 md:px-5 md:pt-5 border-t border-gray-200 rounded-b">
                        <button
                            type="button"
                            class="waves-effect waves-light btn btn-info"
                        >
                            Unduh template
                        </button>
                        <button
                            data-modal-hide="ketenagakerjaan-modal"
                            type="submit"
                            class="ms-auto waves-effect waves-light btn btn-primary"
                        >
                            Simpan
                        </button>
                        <button
                            data-modal-hide="ketenagakerjaan-modal"
                            type="button"
                            class="ms-3 waves-effect waves-light btn btn-secondary"
                        >
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush