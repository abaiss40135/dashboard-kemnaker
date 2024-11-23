@extends('templates.admin.main')
@section('customcss')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
    @include('assets.css.select2')
@endsection
@section('mainComponent')
<div class="wrapper">
    <div class="content-wrapper">
        @component('components.admin.content-header')
            @slot('title', 'Laporan Harian Vaksinasi')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('laphar-vaksinasi.template-excel'))
                        @slot('import_excel', route('laphar-vaksinasi.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Harian Vaksinasi </b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('laphar-vaksinasi.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                              @foreach ($laporan[0] as $key => $item)
                                                    @if($key > 1)
                                                        <div class="mb-3">
                                                            <span class="d-flex justify-content-between align-items-center bg-olive text-white p-3"
                                                                data-target="#collapse{{ $key }}"
                                                                aria-controls="collapse{{ $key }}" data-toggle="collapse"
                                                                aria-expanded="false" type="button" onclick="angleIcon(this)">
                                                                <h5 class="mb-0">{{ $item[0] }}</h5>
                                                                <i class="fas fa-angle-right d-flex"></i>
                                                            </span>
                                                            <div id="collapse{{ $key }}" class="row mt-3 collapse show">
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][kab_kota]">Kabupaten/Kota</label>
                                                                    <input type="text" name="laporan[{{ $key }}][kab_kota]"
                                                                        id="laporan[{{ $key }}][kab_kota]"
                                                                        class="form-control" value="{{ $item[1] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_sdm_kesehatan]">Sasaran Vaksinasi SDM Kesehatan Pasien</label>
                                                                    <input type="text" name="laporan[{{ $key }}][vaksinasi_sdm_kesehatan]"
                                                                        id="laporan[{{ $key }}][vaksinasi_sdm_kesehatan]"
                                                                        class="form-control" value="{{ $item[2] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov1]">SDM Kesehatan Vaksin Cov-1</label>
                                                                    <input type="text" name="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov1]"
                                                                        id="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov1]"
                                                                        class="form-control" value="{{ $item[3] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov1]">SDM Kesehatan % Vaksin Cov-1</label>
                                                                    <input type="text" name="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov1]"
                                                                        id="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov1]"
                                                                        class="form-control" value="{{ $item[4] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov2]">SDM Kesehatan Divaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov2]"
                                                                        id="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov2]"
                                                                        class="form-control" value="{{ $item[5] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov2]">SDM Kesehatan % Vaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov2]"
                                                                        id="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov2]"
                                                                        class="form-control" value="{{ $item[6] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov3]">SDM Kesehatan Divaksin Cov-3</label>
                                                                    <input type="text" name="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov3]"
                                                                    id="laporan[{{ $key }}][sdm_kesehatan_divaksin_cov3]"
                                                                    class="form-control" value="{{ $item[7] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov3]">SDM Kesehatan % Vaksin Cov-3</label>
                                                                    <input type="text" name="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov3]"
                                                                        id="laporan[{{ $key }}][sdm_kesehatan_vaksin_cov3]"
                                                                        class="form-control" value="{{ $item[8] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_lansia_divaksin_cov1]">Sasaran Vaksinasi Lansia Divaksin Cov-1</label>
                                                                    <input type="text" name="laporan[{{ $key }}][vaksinasi_lansia_divaksin_cov1]"
                                                                        id="laporan[{{ $key }}][vaksinasi_lansia_divaksin_cov1]"
                                                                        class="form-control" value="{{ $item[9] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_lansia_vaksin_cov1]">Sasaran Vaksinasi Lansia % Vaksin Cov-1</label>
                                                                    <input type="text" name="laporan[{{ $key }}][vaksinasi_lansia_vaksin_cov1]"
                                                                    id="laporan[{{ $key }}][vaksinasi_lansia_vaksin_cov1]"
                                                                    class="form-control" value="{{ $item[10] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_lansia_divaksin_cov2]">Sasaran Vaksinasi Lansia Divaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][vaksinasi_lansia_divaksin_cov2]"
                                                                    id="laporan[{{ $key }}][vaksinasi_lansia_divaksin_cov2]"
                                                                    class="form-control" value="{{ $item[11] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_lansia_vaksin_cov2]">Sasaran Vaksinasi Lansia % Vaksin Cov-2</label>
                                                                    <input type="number" name="laporan[{{ $key }}][vaksinasi_lansia_vaksin_cov2]"
                                                                    id="laporan[{{ $key }}][vaksinasi_lansia_vaksin_cov2]"
                                                                    class="form-control" value="{{ $item[12] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_yanpublik_divaksin_cov1]">Sasaran Vaksinasi Yanpublik Divaksin Cov-1</label>
                                                                    <input type="number" name="laporan[{{ $key }}][vaksinasi_yanpublik_divaksin_cov1]"
                                                                    id="laporan[{{ $key }}][vaksinasi_yanpublik_divaksin_cov1]"
                                                                    class="form-control" value="{{ $item[13] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_yanpublik_vaksin_cov1]">Sasaran Vaksinasi Yanpublik % Vaksin Cov-1</label>
                                                                    <input type="number" name="laporan[{{ $key }}][vaksinasi_yanpublik_vaksin_cov1]"
                                                                    id="laporan[{{ $key }}][vaksinasi_yanpublik_vaksin_cov1]"
                                                                    class="form-control" value="{{ $item[14] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_yanpublik_divaksin_cov2]">Sasaran Vaksinasi Yanpublik Divaksin Cov-2</label>
                                                                    <input type="number" name="laporan[{{ $key }}][vaksinasi_yanpublik_divaksin_cov2]"
                                                                    id="laporan[{{ $key }}][vaksinasi_yanpublik_divaksin_cov2]"
                                                                    class="form-control" value="{{ $item[15] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][vaksinasi_yanpublik_vaksin_cov2]">Sasaran Vaksinasi Yanpublik % Vaksin Cov-2</label>
                                                                    <input type="number" name="laporan[{{ $key }}][vaksinasi_yanpublik_vaksin_cov2]"
                                                                    id="laporan[{{ $key }}][vaksinasi_yanpublik_vaksin_cov2]"
                                                                    class="form-control" value="{{ $item[16] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][mu_divaksin_cov1]">Sasaran Vaksinasi Masyarakat Umum Divaksin Cov-1</label>
                                                                    <input type="number" name="laporan[{{ $key }}][mu_divaksin_cov1]"
                                                                    id="laporan[{{ $key }}][mu_divaksin_cov1]"
                                                                    class="form-control" value="{{ $item[17] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][mu_vaksin_cov1]">Sasaran Vaksinasi Masyarakat Umum % vaksin Cov-1</label>
                                                                    <input type="number" name="laporan[{{ $key }}][mu_vaksin_cov1]"
                                                                    id="laporan[{{ $key }}][mu_vaksin_cov1]"
                                                                    class="form-control" value="{{ $item[18] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][mu_divaksin_cov2]">Sasaran Vaksinasi Masyarakat Umum Divaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][mu_divaksin_cov2]"
                                                                        id="laporan[{{ $key }}][mu_divaksin_cov2]"
                                                                        class="form-control" value="{{ $item[19] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][mu_vaksin_cov2]">Sasaran Vaksinasi Masyarakat Umum % Vaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][mu_vaksin_cov2]"
                                                                        id="laporan[{{ $key }}][mu_vaksin_cov2]"
                                                                        class="form-control" value="{{ $item[20] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][remaja_divaksin_cov1]">Remaja Divaksin Cov-1</label>
                                                                    <input type="text" name="laporan[{{ $key }}][remaja_divaksin_cov1]"
                                                                        id="laporan[{{ $key }}][remaja_divaksin_cov1]"
                                                                        class="form-control" value="{{ $item[21] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][remaja_vaksin_cov1]">Remaja % Vaksin Cov-1</label>
                                                                    <input type="text" name="laporan[{{ $key }}][remaja_vaksin_cov1]"
                                                                        id="laporan[{{ $key }}][remaja_vaksin_cov1]"
                                                                        class="form-control" value="{{ $item[22] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][remaja_divaksin_cov2]">Remaja Divaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][remaja_divaksin_cov2]"
                                                                        id="laporan[{{ $key }}][remaja_divaksin_cov2]"
                                                                        class="form-control" value="{{ $item[23] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][remaja_vaksin_cov2]">Remaja % Vaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][remaja_vaksin_cov2]"
                                                                        id="laporan[{{ $key }}][remaja_vaksin_cov2]"
                                                                        class="form-control" value="{{ $item[24] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][gr_divaksin_cov1]">Gotong Royong Divaksin Cov-1</label>
                                                                    <input type="text" name="laporan[{{ $key }}][gr_divaksin_cov1]"
                                                                        id="laporan[{{ $key }}][gr_divaksin_cov1]"
                                                                        class="form-control" value="{{ $item[25] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][gr_vaksin_cov1]">Gotong Royong % Vaksin Cov-1</label>
                                                                    <input type="text" name="laporan[{{ $key }}][gr_vaksin_cov1]"
                                                                        id="laporan[{{ $key }}][gr_vaksin_cov1]"
                                                                        class="form-control" value="{{ $item[26] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][gr_divaksin_cov2]">Gotong Royong Divaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][gr_divaksin_cov2]"
                                                                        id="laporan[{{ $key }}][gr_divaksin_cov2]"
                                                                        class="form-control" value="{{ $item[27] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][gr_vaksin_cov2]">Gotong Royong % Vaksin Cov-2</label>
                                                                    <input type="text" name="laporan[{{ $key }}][gr_vaksin_cov2]"
                                                                        id="laporan[{{ $key }}][gr_vaksin_cov2]"
                                                                        class="form-control" value="{{ $item[28] }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="laporan[{{ $key }}][jumlah]">Jumlah</label>
                                                                    <input type="text" name="laporan[{{ $key }}][jumlah]"
                                                                        id="laporan[{{ $key }}][jumlah]"
                                                                        class="form-control" value="{{ $item[29] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                              @endforeach
                                          </tbody>
                                      </table>
                                    @can('lapsubjar_create')
                                      <div class="d-flex justify-content-center justify-content-md-end mb-3">
                                          <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                                      </div>
                                    @endcan
                                </form>
                            </div>
                        </div>
                        @else
                        <div>
                            <h2 class="h4 text-center"><b>Laporan Harian Vaksinasi </b></h2>
                            <form action="{{ route('laphar-vaksinasi.export-excel') }}"
                                  class="form" method="post">
                                @csrf
                                <hr>
                                <div class="alert alert-gray">
                                    <h5><i class="icon fas fa-filter"></i> Filter</h5>
                                    <div class="row">
                                        @if(roles(['administrator', 'operator_bagopsnalev_mabes']))
                                        <div class="form-group col-sm-4">
                                            <label for="select-polda">Satuan Polda</label>
                                            <select name="polda" id="select-polda" class="form-control select2">
                                                <option></option>
                                            </select>
                                        </div>
                                        @endif
                                        <div class="form-group col-sm-4">
                                            <label for="search">Pencarian umum</label>
                                            <input type="text" id="search" name="search" class="form-control"
                                                    placeholder="Cari berdasarkan kolom-kolom di tabel">
                                        </div>
                                        <div class="form-group col">
                                            <label for="start_date">Mulai Tanggal</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control">
                                        </div>
                                        <div class="form-group col">
                                            <label for="end_date">Sampai Tanggal</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control">
                                        </div>
                                        <div class="col-12 form-group w-100 d-flex justify-content-center justify-content-sm-end">
                                            <div>
                                                <button class="btn btn-success" type="submit">
                                                    <i class="fa fa-file-alt"></i>&ensp;Ekspor Excel
                                                </button>
                                                <button type="reset" class="btn btn-warning">Reset</button>
                                                <button class="btn btn-primary" id="btn-search">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </form>
                            @component('components.sislap.form-search')
                                @slot('route', route('laphar-vaksinasi.export-excel'))
                                @slot('className', 'd-none')
                            @endcomponent
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            @can('sislap_approval_create')
                                            <th class="align-middle text-center" width="4%" rowspan="3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check_all" id="check-all">
                                                    <label class="form-check-label" for="check-all"></label>
                                                </div>
                                            </th>
                                            @endcan
                                            <th class="align-middle" rowspan="2">No</th>
                                            <th class="align-middle" rowspan="2">Kab/Kota</th>
                                            <th class="align-middle" rowspan="2">Sasaran Vaksinasi SDM Kesehatan </th>
                                            <th class="align-middle" colspan="6">SDM Kesehatan</th>
                                            <th class="align-middle" colspan="4">Sasaran Vaksinasi Lansia</th>
                                            <th class="align-middle" colspan="4">Sasaran Vaksinasi Yanpublik</th>
                                            <th class="align-middle" colspan="4">Sasaran Vaksinasi Masyarakat Umum</th>
                                            <th class="align-middle" colspan="4">Remaja</th>
                                            <th class="align-middle" colspan="4">Gotong Royong</th>
                                            <th class="align-middle" rowspan="2">Jumlah</th>
                                            <th class="align-middle" width="10" rowspan="3">Tanggal Laporan</th>
                                            @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                                            <th class="align-middle" width="4%" rowspan="3">Aksi</th>
                                            @endcanany
                                        </tr>
                                        <tr class="bg-primary text-white text-center">
                                            <td>Divaksin cov-1</td>
                                            <td>% Vaksin cov-1</td>
                                            <td>Divaksin cov-2</td>
                                            <td>% Vaksin cov-2</td>
                                            <td>Divaksin cov-3</td>
                                            <td>% Vaksin cov-3</td>
                                            <td>Divaksin cov-1</td>
                                            <td>% Vaksin cov-1</td>
                                            <td>Divaksin cov-2</td>
                                            <td>% Vaksin cov-2</td>
                                            <td>Divaksin cov-1</td>
                                            <td>% Vaksin cov-1</td>
                                            <td>Divaksin cov-2</td>
                                            <td>% Vaksin cov-2</td>
                                            <td>Divaksin cov-1</td>
                                            <td>% Vaksin cov-1</td>
                                            <td>Divaksin cov-2</td>
                                            <td>% Vaksin cov-2</td>
                                            <td>Divaksin cov-1</td>
                                            <td>% Vaksin cov-1</td>
                                            <td>Divaksin cov-2</td>
                                            <td>% Vaksin cov-2</td>
                                            <td>Divaksin cov-1</td>
                                            <td>% Vaksin cov-1</td>
                                            <td>Divaksin cov-2</td>
                                            <td>% Vaksin cov-2</td>
                                        </tr>
                                    </thead>
                                    <tbody id="content-wrapper"></tbody>
                                </table>
                            </div>
                            <div id="shimmer-wrapper">
                                <table class="table table-hover text-center">
                                    @component('components.shimmer.table-shimmer') @endcomponent
                                </table>
                            </div>
                            <div id="message-wrapper"></div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <ul id="paginator-wrapper" class="my-0"></ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<div class="modal fade" id="modalEdit" tabindex="-1"
         aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Laporan</h5>
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form-edit">
                        @csrf
                        @method('PATCH')
                        <div class="form-group col-md-6">
                            <label for="kab_kota">Kabupaten/Kota</label>
                            <input type="text" name="kab_kota" id="kab_kota" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_sdm_kesehatan">Sasaran Vaksinasi SDM Kesehatan</label>
                            <input type="text" name="vaksinasi_sdm_kesehatan" id="vaksinasi_sdm_kesehatan" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sdm_kesehatan_divaksin_cov1">SDM Kesehatan Divaksin Cov-1</label>
                            <input type="text" name="sdm_kesehatan_divaksin_cov1" id="sdm_kesehatan_divaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sdm_kesehatan_vaksin_cov1">SDM Kesehatan Vaksin Cov-1</label>
                            <input type="text" name="sdm_kesehatan_vaksin_cov1" id="sdm_kesehatan_vaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sdm_kesehatan_divaksin_cov2">SDM Kesehatan Divaksin Cov-2</label>
                            <input type="text" name="sdm_kesehatan_divaksin_cov2" id="sdm_kesehatan_divaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sdm_kesehatan_vaksin_cov2">SDM Kesehatan Vaksin Cov-2</label>
                            <input type="text" name="sdm_kesehatan_vaksin_cov2" id="sdm_kesehatan_vaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sdm_kesehatan_divaksin_cov3">SDM Kesehatan Divaksin Cov-3</label>
                            <input type="text" name="sdm_kesehatan_divaksin_cov3" id="sdm_kesehatan_divaksin_cov3" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sdm_kesehatan_vaksin_cov3">SDM Kesehatan Vaksin Cov-3</label>
                            <input type="text" name="sdm_kesehatan_vaksin_cov3" id="sdm_kesehatan_vaksin_cov3" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_lansia_divaksin_cov1">Vaksinasi Lansia Divaksin Cov-1</label>
                            <input type="text" name="vaksinasi_lansia_divaksin_cov1" id="vaksinasi_lansia_divaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_lansia_vaksin_cov1">Vaksinasi Lansia Vaksin Cov-1</label>
                            <input type="text" name="vaksinasi_lansia_vaksin_cov1" id="vaksinasi_lansia_vaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_lansia_divaksin_cov2">Vaksinasi Lansia Divaksin Cov-2</label>
                            <input type="text" name="vaksinasi_lansia_divaksin_cov2" id="vaksinasi_lansia_divaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_lansia_vaksin_cov2">Vaksinasi Lansia Vaksin Cov-2</label>
                            <input type="text" name="vaksinasi_lansia_vaksin_cov2" id="vaksinasi_lansia_vaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_yanpublik_divaksin_cov1">Vaksinasi Yanpublik Divaksin Cov-1</label>
                            <input type="text" name="vaksinasi_yanpublik_divaksin_cov1" id="vaksinasi_yanpublik_divaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_yanpublik_vaksin_cov1">Vaksinasi Yanpublik Vaksin Cov-1</label>
                            <input type="text" name="vaksinasi_yanpublik_vaksin_cov1" id="vaksinasi_yanpublik_vaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_yanpublik_divaksin_cov2">Vaksinasi Yanpublik Divaksin Cov-2</label>
                            <input type="text" name="vaksinasi_yanpublik_divaksin_cov2" id="vaksinasi_yanpublik_divaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vaksinasi_yanpublik_vaksin_cov2">Vaksinasi Yanpublik Vaksin Cov-2</label>
                            <input type="text" name="vaksinasi_yanpublik_vaksin_cov2" id="vaksinasi_yanpublik_vaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mu_divaksin_cov1">Vaksinasi Masyarakat Umum Divaksin Cov-1</label>
                            <input type="text" name="mu_divaksin_cov1" id="mu_divaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mu_vaksin_cov1">Vaksinasi Masyarakat Umum vaksin Cov-1</label>
                            <input type="text" name="mu_vaksin_cov1" id="mu_vaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mu_divaksin_cov2">Vaksinasi Masyarakat Umum Divaksin Cov-2</label>
                            <input type="text" name="mu_divaksin_cov2" id="mu_divaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mu_vaksin_cov2">>Vaksinasi Masyarakat Umum vaksin Cov-2</label>
                            <input type="text" name="mu_vaksin_cov2" id="mu_vaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="remaja_divaksin_cov1">Remaja Divaksin Cov-1</label>
                            <input type="text" name="remaja_divaksin_cov1" id="remaja_divaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="remaja_vaksin_cov1">Remaja Vaksin Cov-1</label>
                            <input type="text" name="remaja_vaksin_cov1" id="remaja_vaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="remaja_divaksin_cov2">Remaja Divaksin Cov-2</label>
                            <input type="text" name="remaja_divaksin_cov2" id="remaja_divaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="remaja_vaksin_cov2">Remaja Vaksin Cov-2</label>
                            <input type="text" name="remaja_vaksin_cov2" id="remaja_vaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gr_divaksin_cov1">Gotong Royong Divaksin Cov-1</label>
                            <input type="text" name="gr_divaksin_cov1" id="gr_divaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gr_vaksin_cov1">Gotong Royong Divaksin Cov-1</label>
                            <input type="text" name="gr_vaksin_cov1" id="gr_vaksin_cov1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gr_divaksin_cov2">Gotong Royong Divaksin Cov-2</label>
                            <input type="text" name="gr_divaksin_cov2" id="gr_divaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gr_vaksin_cov2">Gotong Royong Vaksin Cov-2</label>
                            <input type="text" name="gr_vaksin_cov2" id="gr_vaksin_cov2" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jumlah">Jumlah</label>
                            <input type="text" name="jumlah" id="jumlah" class="form-control">
                        </div>

                        <div class="d-flex justify-content-end col-12">
                            <div>
                                <button type="reset" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@include('assets.js.twbs-pagination')
@endsection
@section('customjs')
    @include('assets.js.twbs-pagination')
    @include('assets.js.select2')
    <script src="{{ asset('js/component-with-pagination.js') }}"></script>
    <script>
        const getSelectedChecklist = () => {
            let selected = document.querySelectorAll('.checklist-approval:checked');
            if (selected.length === 0) {
                swalWarning('Anda belum memilih data laporan. Mohon pilih terlebih dahulu')
                return false;
            }
            let approvalRequestId = [];
            selected.forEach((item) => { approvalRequestId.push(item.dataset.id) });
            return approvalRequestId
        }
        const decline = (laporan_id) => {
            if (laporan_id != null) {
                Swal.fire({
                    input: 'textarea',
                    inputLabel: 'Catatan',
                    inputPlaceholder: 'Input catatan tidak valid...',
                    inputAttributes: {
                        autocapitalize: 'off',
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: function (message) {
                        sendApproval([laporan_id], false, message)
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    console.log(result)
                })
            }
        }

        @can('sislap_approval_create')
        const initListenerApprovalAll = () => {
            document.getElementById('check-all').addEventListener('change', function () {
                if (this.checked) {
                    document.querySelectorAll(".checklist-approval").forEach((checkbox) => {checkbox.setAttribute('checked', 'checked')})
                } else {
                    document.querySelectorAll(".checklist-approval").forEach((checkbox) => {checkbox.removeAttribute('checked')})
                }
            })
        }

        document.getElementById('btn-ajukan-approval').addEventListener('click', function () {
            let data = getSelectedChecklist()
            if (data) {
                sendApproval(data)
            }
        })
        @endcan

        let sendApproval = (approvalRequestId,
                            approval    = null,
                            keterangan  = null) => {
            axios.post(route('approval-laporan.store'), {
                approvable_id: approvalRequestId,
                approvable_type: "{{ $model }}",
                is_approve: approval,
                keterangan: keterangan
            })
            .then(function (response) {
                if (response.status === 200){
                    swalSuccess(response.data.message)
                    listLaporan.updateState('page', 1)
                    listLaporan.fetchData()
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        @can('sislap_approval_edit')
            document.getElementById('btn-approve-approval').addEventListener('click', function () {
                sendApproval(getSelectedChecklist(), true)
            })
        @endcan

        const listLaporan = new ComponentWithPagination({
            contentWrapper: '#content-wrapper',
            messageWrapper: '#message-wrapper',
            paginator: '#paginator-wrapper',
            loader: '#shimmer-wrapper',
            searchState: {
                url: route('laphar-vaksinasi.search'),
                data: {}
            },
            content: (item, rowNumber) => {
                let haveApprovals       = item.approvals.length > 0;
                let checklistApproval   = item.need_approve ? `<div class="form-check">
                                                                <input type="checkbox" class="form-check-input checklist-approval" name="check_approval[${item.id}]" data-id="${ item.id }" aria-label="check-row">
                                                            </div>` : '';
                let table = `
                    <tr ${ haveApprovals && item.approval.is_approve === false ? 'class="bg-orange"': ''} ${ haveApprovals ? 'data-widget="expandable-table" aria-expanded="false"' : '' }>
                        @can('sislap_approval_create')
                            <th class="align-middle text-center">
                                ${ checklistApproval }
                            </th>
                        @endcan
                        <th class="align-middle text-center">${ rowNumber }</th>
                        <td class="align-middle ">${ item.personel ? ('<b>(' + item.personel.polda  + ')</b>') : ''} ${ item.kab_kota }</td>
                        <td class="align-middle ">${ item.vaksinasi_sdm_kesehatan }</td>
                        <td class="align-middle ">${ item.sdm_kesehatan_divaksin_cov1 }</td>
                        <td class="align-middle ">${ item.sdm_kesehatan_vaksin_cov1 }</td>
                        <td class="align-middle ">${ item.sdm_kesehatan_divaksin_cov2 }</td>
                        <td class="align-middle ">${ item.sdm_kesehatan_vaksin_cov2 }</td>
                        <td class="align-middle ">${ item.sdm_kesehatan_divaksin_cov3 }</td>
                        <td class="align-middle ">${ item.sdm_kesehatan_vaksin_cov3 }</td>
                        <td class="align-middle ">${ item.vaksinasi_lansia_divaksin_cov1 }</td>
                        <td class="align-middle ">${ item.vaksinasi_lansia_vaksin_cov1 }</td>
                        <td class="align-middle ">${ item.vaksinasi_lansia_divaksin_cov2 }</td>
                        <td class="align-middle ">${ item.vaksinasi_lansia_vaksin_cov2 }</td>
                        <td class="align-middle ">${ item.vaksinasi_yanpublik_divaksin_cov1 }</td>
                        <td class="align-middle ">${ item.vaksinasi_yanpublik_vaksin_cov1 }</td>
                        <td class="align-middle ">${ item.vaksinasi_yanpublik_divaksin_cov2 }</td>
                        <td class="align-middle ">${ item.vaksinasi_yanpublik_vaksin_cov2 }</td>
                        <td class="align-middle ">${ item.mu_divaksin_cov1 }</td>
                        <td class="align-middle ">${ item.mu_vaksin_cov1 }</td>
                        <td class="align-middle ">${ item.mu_divaksin_cov2 }</td>
                        <td class="align-middle ">${ item.mu_vaksin_cov2 }</td>
                        <td class="align-middle ">${ item.remaja_divaksin_cov1 }</td>
                        <td class="align-middle ">${ item.remaja_vaksin_cov1 }</td>
                        <td class="align-middle ">${ item.remaja_divaksin_cov2 }</td>
                        <td class="align-middle ">${ item.remaja_vaksin_cov2 }</td>
                        <td class="align-middle ">${ item.gr_divaksin_cov1 }</td>
                        <td class="align-middle ">${ item.gr_vaksin_cov1 }</td>
                        <td class="align-middle ">${ item.gr_divaksin_cov2 }</td>
                        <td class="align-middle ">${ item.gr_vaksin_cov2 }</td>
                        <td class="align-middle ">${ item.jumlah }</td>
                        <td class="align-middle text-center">${ formatDate(item.created_at) }</td>
                        @canany(['lapsubjar_edit', 'lapsubjar_destroy'])
                        <td class="align-middle text-center">
                        @can('sislap_approval_approve')
                            ${ !item.need_approve ? `` : `
                                <button class="btn btn-approve btn-success mb-1"
                                        onclick="sendApproval([${item.id}], true)">
                                        <i class="fas fa-check-circle"></i>
                                </button>`}
                            @endcan
                            @can('sislap_approval_decline')
                            ${ !haveApprovals || item.approval.is_approve === null || item.approval.is_approve ? `
                                <button class="btn btn-decline btn-danger mb-1"
                                        onclick="decline(${item.id})">
                                        <i class="fas fa-times-circle"></i>
                                </button>
                            ` : ``}
                            @endcan
                            @can('lapsubjar_edit')
                            ${ haveApprovals && !item.need_approve ? `` : `
                                <button class="btn btn-edit btn-warning mb-1"
                                        data-toggle="modal" data-target="#modalEdit"
                                        onclick="insertValueToFormEdit({
                                            id:                                '${item.id}',
                                            kab_kota:                       '${item.kab_kota}',
                                            sdm_kesehatan_divaksin_cov1:                     '${item.sdm_kesehatan_divaksin_cov1}',
                                            sdm_kesehatan_vaksin_cov1:       '${item.sdm_kesehatan_vaksin_cov1}',
                                            sdm_kesehatan_divaksin_cov2:           '${item.sdm_kesehatan_divaksin_cov2}',
                                            sdm_kesehatan_vaksin_cov2:       '${item.sdm_kesehatan_vaksin_cov2}',
                                            sdm_kesehatan_divaksin_cov3: '${item.sdm_kesehatan_divaksin_cov3}',
                                            sdm_kesehatan_vaksin_cov3:        '${item.sdm_kesehatan_vaksin_cov3}',
                                            vaksinasi_lansia_divaksin_cov1:          '${item.vaksinasi_lansia_divaksin_cov1}',
                                            vaksinasi_lansia_vaksin_cov1:      '${item.vaksinasi_lansia_vaksin_cov1}',
                                            vaksinasi_lansia_divaksin_cov2:             '${item.vaksinasi_lansia_divaksin_cov2}',
                                            vaksinasi_lansia_vaksin_cov2:      '${item.vaksinasi_lansia_vaksin_cov2}',
                                            vaksinasi_yanpublik_divaksin_cov1:     '${item.vaksinasi_yanpublik_divaksin_cov1}',
                                            vaksinasi_yanpublik_vaksin_cov1:     '${item.vaksinasi_yanpublik_vaksin_cov1}',
                                            vaksinasi_yanpublik_divaksin_cov2:    '${item.vaksinasi_yanpublik_divaksin_cov2}',
                                            vaksinasi_yanpublik_vaksin_cov2:    '${item.vaksinasi_yanpublik_vaksin_cov2}',
                                            vaksinasi_sdm_kesehatan:   '${item.vaksinasi_sdm_kesehatan}',
                                            mu_divaksin_cov1:                             '${item.mu_divaksin_cov1}',
                                            mu_vaksin_cov1:                      '${item.mu_vaksin_cov1}',
                                            mu_divaksin_cov2:       '${item.mu_divaksin_cov2}',
                                            mu_vaksin_cov2:              '${item.mu_vaksin_cov2}',
                                            remaja_divaksin_cov1:       '${item.remaja_divaksin_cov1}',
                                            remaja_vaksin_cov1:      '${item.remaja_vaksin_cov1}',
                                            remaja_divaksin_cov2:      '${item.remaja_divaksin_cov2}',
                                            remaja_vaksin_cov2:     '${item.remaja_vaksin_cov2}',
                                            gr_divaksin_cov1:           '${item.gr_divaksin_cov1}',
                                            gr_vaksin_cov1:   '${item.gr_vaksin_cov1}',
                                            gr_divaksin_cov2:       '${item.gr_divaksin_cov2}',
                                            gr_vaksin_cov2:         '${item.gr_vaksin_cov2}',
                                            jumlah:          '${item.jumlah}',
                                        })">
                                    <i class="fa fa-edit"></i>
                                </button> ` }
                            @endcan
                            @can('lapsubjar_destroy')
                            ${ !haveApprovals || !item.approval.is_approve ? `
                            <form action="${ route('laphar-vaksinasi.destroy', item.id) }" method="post" id="${ item.id }">
                                @method('delete')
                            @csrf
                            <button class="btn btn-danger btn-delete" type="submit" onclick="event.preventDefault(); deleteConfirm(${ item.id })">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>` : ``}
                            @endcan
                        </td>
                        @endcanany
                    </tr>`;
                if (haveApprovals){
                    table += listRiwayatApproval(item.approvals, 33);
                }
                return table;
            },
            @can('sislap_approval_create')
            completeEvent: initListenerApprovalAll()
            @endcan
        })

        const initSelectPolda = (el = $('#select-polda')) => {
            buildSelect2Search({
                placeholder: '-- Pilih Polda --',
                url: '{{ route('polda.select2') }}',
                minimumInputLength: 0,
                selector: [{ id: el }],
                query: function (params) {
                    return {
                        polda: params.term,
                    }
                }
            });
        }
        initSelectPolda();

        document.getElementById('btn-search').addEventListener('click', (event) => {
            event.preventDefault()
            listLaporan.updateState('search', document.querySelector('input[name=search]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })

        const insertValueToFormEdit = ({
                id, kab_kota, sdm_kesehatan_divaksin_cov1,
                sdm_kesehatan_vaksin_cov1, sdm_kesehatan_divaksin_cov2,
                sdm_kesehatan_vaksin_cov2, sdm_kesehatan_divaksin_cov3,
                sdm_kesehatan_vaksin_cov3, vaksinasi_lansia_divaksin_cov1,
                vaksinasi_lansia_vaksin_cov1, vaksinasi_lansia_divaksin_cov2,
                vaksinasi_lansia_vaksin_cov2, vaksinasi_yanpublik_divaksin_cov1,
                vaksinasi_yanpublik_vaksin_cov1, vaksinasi_yanpublik_divaksin_cov2,
                vaksinasi_yanpublik_vaksin_cov2, vaksinasi_sdm_kesehatan,
                mu_divaksin_cov1, mu_vaksin_cov1, mu_divaksin_cov2,
                mu_vaksin_cov2, remaja_divaksin_cov1, remaja_vaksin_cov1,
                remaja_divaksin_cov2, remaja_vaksin_cov2, gr_divaksin_cov1,
                gr_vaksin_cov1, gr_divaksin_cov2, gr_vaksin_cov2, jumlah
            }) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('laphar-vaksinasi.update', id))
            elFormEdit.querySelector('input[name="nama_polres"]').value          = kab_kota
            elFormEdit.querySelector('input[name="vaksinasi_sdm_kesehatan"]').value           = sdm_kesehatan_divaksin_cov1
            elFormEdit.querySelector('input[name="sdm_kesehatan_divaksin_cov1"]').value       = sdm_kesehatan_vaksin_cov1
            elFormEdit.querySelector('input[name="sdm_kesehatan_vaksin_cov1"]').value         = sdm_kesehatan_divaksin_cov2
            elFormEdit.querySelector('input[name="sdm_kesehatan_divaksin_cov2"]').value       = sdm_kesehatan_vaksin_cov2
            elFormEdit.querySelector('input[name="sdm_kesehatan_vaksin_cov2"]').value         = sdm_kesehatan_divaksin_cov3
            elFormEdit.querySelector('input[name="sdm_kesehatan_divaksin_cov3"]').value       = sdm_kesehatan_vaksin_cov3
            elFormEdit.querySelector('input[name="sdm_kesehatan_vaksin_cov3"]').value         = vaksinasi_lansia_divaksin_cov1
            elFormEdit.querySelector('input[name="vaksinasi_lansia_divaksin_cov1"]').value    = vaksinasi_lansia_vaksin_cov1
            elFormEdit.querySelector('input[name="vaksinasi_lansia_vaksin_cov1"]').value      = vaksinasi_lansia_divaksin_cov2
            elFormEdit.querySelector('input[name="vaksinasi_lansia_divaksin_cov2"]').value    = vaksinasi_lansia_vaksin_cov2
            elFormEdit.querySelector('input[name="vaksinasi_lansia_vaksin_cov2"]').value      = vaksinasi_yanpublik_divaksin_cov1
            elFormEdit.querySelector('input[name="vaksinasi_yanpublik_divaksin_cov1"]').value = vaksinasi_yanpublik_vaksin_cov1
            elFormEdit.querySelector('input[name="vaksinasi_yanpublik_vaksin_cov1"]').value   = vaksinasi_yanpublik_divaksin_cov2
            elFormEdit.querySelector('input[name="vaksinasi_yanpublik_divaksin_cov2"]').value = vaksinasi_yanpublik_vaksin_cov2
            elFormEdit.querySelector('input[name="vaksinasi_yanpublik_vaksin_cov2"]').value   = vaksinasi_sdm_kesehatan
            elFormEdit.querySelector('input[name="mu_divaksin_cov1"]').value                  = mu_divaksin_cov1
            elFormEdit.querySelector('input[name="mu_vaksin_cov1"]').value                    = mu_vaksin_cov1
            elFormEdit.querySelector('input[name="mu_divaksin_cov2"]').value                  = mu_divaksin_cov2
            elFormEdit.querySelector('input[name="mu_vaksin_cov2"]').value                    = mu_vaksin_cov2
            elFormEdit.querySelector('input[name="remaja_divaksin_cov1"]').value              = remaja_divaksin_cov1
            elFormEdit.querySelector('input[name="remaja_vaksin_cov1"]').value                = remaja_vaksin_cov1
            elFormEdit.querySelector('input[name="remaja_divaksin_cov2"]').value              = remaja_divaksin_cov2
            elFormEdit.querySelector('input[name="remaja_vaksin_cov2"]').value                = remaja_vaksin_cov2
            elFormEdit.querySelector('input[name="gr_divaksin_cov1"]').value                  = gr_divaksin_cov1
            elFormEdit.querySelector('input[name="gr_vaksin_cov1"]').value                    = gr_vaksin_cov1
            elFormEdit.querySelector('input[name="gr_divaksin_cov2"]').value                  = gr_divaksin_cov2
            elFormEdit.querySelector('input[name="gr_vaksin_cov2"]').value                    = gr_vaksin_cov2
            elFormEdit.querySelector('input[name="jumlah"]').value                            = jumlah
        }
    </script>
@endsection
