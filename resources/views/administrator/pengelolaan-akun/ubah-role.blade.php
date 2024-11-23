@extends('templates.admin-lte.admin', ['title' => 'Ubah Hak Akses'])
@section('customcss')
    @include('assets.css.select2')
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('ubah-role.store') }}" method="POST"
              class="card-body" onsubmit="disableSubmitButtonTemporarily(this)">
            @csrf
            <div class="row form-group">
                <label class="font-weight-normal col-lg-2">Hak Akses di Aplikasi (Role)</label>
                <div class="col-lg-10">
                    <select name="role[]" id="select-role" multiple="multiple"
                            class="form-control select2 w-100">
                        <option></option>
                    </select>
                    <small class="text-muted">hak akses yang dimiliki personel.</small>
                    <small class="text-danger">bhabinkamtibmas yang pindah tempat penugasan dan masih seorang bhabinkamtibmas di penugasan barunya, role tetap bhabinkamtibmas, bukan bhabinkamtibmas mutasi.</small>
                </div>
            </div>
            <div class="row form-group">
                <label class="font-weight-normal col-lg-2">NRP atau Email</label>
                <div class="col-lg-10">
                    <input type="text" name="nrp" id="nrp"
                           class="form-control" value="{{old('nrp')}}" required>
                    <small class="text-muted">email atau nrp personel yang terdaftar</small>
                </div>
            </div>
            <div class="row form-group">
                <label class="font-weight-normal col-lg-2">Keterangan</label>
                <div class="col-lg-10">
                    <textarea id="desc" name="desc" class="form-control" rows="3"
                            maxlength="200"></textarea>
                    <small class="text-muted">keterangan kenapa personel diubah hak aksesnya</small>
                </div>
            </div>
            <div class="form-group">
                <div class="d-flex align-items-center">
                    <input type="checkbox" name="mutasi" id="mutasi"
                           name="mutasi" class="form-control d-inline-block"
                           value="true" style="width: 1.4rem">
                    <label class="font-weight-normal mb-0 ml-2">Mutasi</label>
                </div>
                <small class="text-danger">Mencentang mutasi akan membuat personel tidak bisa mengakses BOSv2</small><br>
                <small class="text-muted">Centang mutasi hanya jika personel pensiun, atau sebab lain yang membuat personel tidak boleh mengakses BOSv2</small><br>
                <small class="text-muted">Jangan centang mutasi jika personel mutasi tempat penugasan tapi masih dalam Satuan Bhabinkamtibmas</small>
            </div>
            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-warning mr-2">Reset</button>
                <button type="submit" class="btn btn-primary">Ubah Role</button>
            </div>
        </form>
    </div>
@endsection
@section('customjs')
@include('assets.js.select2')
    <script>
        $(function () {
            buildSelect2Search({
                placeholder: '-- Pilih Hak Akses --',
                url: route('role.select2'),
                minimumInputLength: 0,
                selector: [{ id: $('#select-role') }],
                query: function (params) {
                    return { alias: params.term }
                }
            });
        });
    </script>
@endsection
