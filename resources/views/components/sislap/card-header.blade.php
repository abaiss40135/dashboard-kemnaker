<div class="card-header p-4">
    <div class="d-flex justify-content-stretch justify-content-sm-start">
        <div class="pr-3">
            <a href="{{ $template_excel }}"
               class="btn btn-success">Unduh Format Laporan</a>
        </div>
        @if (isset($other))
            <div class="pr-3">
                <a href="{{ $other }}" class="btn btn-warning">{{ $other_text }}</a>
            </div>
        @endif
        <div>
            @if(!empty(auth()->user()->personel->kode_satuan) && can('lapsubjar_create'))
            <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#modalUpload">Unggah Laporan</button>
            <div class="modal fade" id="modalUpload" tabindex="-1"
                 role="dialog" aria-hidden="true">
                 <div class="modal-dialog" role="document">
                    <form action="{{ $import_excel }}"
                          method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Unggah Laporan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <div class="custom-file">
                                        @csrf
                                        <input type="file" class="custom-file-input" required
                                            name="file-laporan" id="file-laporan"
                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                            onchange="setFileLabel(this)">
                                        <label for="file-laporan" class="custom-file-label form-control">Pastikan file excel sesuai dengan template</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button class="btn btn-primary" type="submit">Unggah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
