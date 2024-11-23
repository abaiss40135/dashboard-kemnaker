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
                @slot('title', 'Register Akun Polsus')
            @endcomponent
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            @if(isset($laporan))
                                <div>
                                    <h2 class="h4 text-center mb-3"><b>Preview Data Akun Polsus Yang akan Didaftarkan</b></h2>
                                    <div class="table-responsive mb-4">
                                        <form action="{{ route('register-polsus.store') }}"
                                              method="POST" onclick="disableButtonSubmit()">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered">
                                                    <thead class="text-center bg-primary">
                                                    <tr>
                                                        <th  style="text-align: center">No</th>
                                                        <th  style="text-align: center; min-width: 400px;">Hak Akses di Aplikasi</th>
                                                        <th  style="text-align: center; min-width: 200px;">Email</th>
                                                        <th  style="text-align: center; min-width: 200px;">Password</th>
                                                        <th  style="text-align: center; min-width: 200px;">Nama</th>
                                                        <th  style="text-align: center; min-width: 200px;">Tempat Lahir</th>
                                                        <th  style="text-align: center; min-width: 200px;">Tanggal Lahir</th>
                                                        <th  style="text-align: center; min-width: 200px;">Golongan</th>
                                                        <th  style="text-align: center; min-width: 200px;">Pangkat</th>
                                                        <th  style="text-align: center; min-width: 200px;">NIP</th>
                                                        <th  style="text-align: center; min-width: 250px;">No. Handphone Aktif</th>
                                                        <th  style="text-align: center; min-width: 200px;">Jabatan</th>
                                                        <th  style="text-align: center; min-width: 200px;">Provinsi</th>
                                                        <th  style="text-align: center; min-width: 200px;">Kota/Kabupaten</th>
                                                        <th  style="text-align: center; min-width: 200px;">Kecamatan</th>
                                                        <th  style="text-align: center; min-width: 200px;">Kelurahan/Desa</th>
                                                        <th  style="text-align: center; min-width: 450px;">Detail Alamat</th>
                                                        <th  style="text-align: center; min-width: 150px;">RT</th>
                                                        <th  style="text-align: center; min-width: 150px;">RW</th>
                                                        <th  style="text-align: center; min-width: 200px;">Jenjang Diklat Polsus</th>
                                                        <th  style="text-align: center; min-width: 170px;">No. Ijazah</th>
                                                        <th  style="text-align: center; min-width: 270px;">Tempat Dikeluarkan Ijazah</th>
                                                        <th  style="text-align: center; min-width: 270px;">Tanggal Dikeluarkan Ijazah</th>
                                                        <th  style="text-align: center; min-width: 350px;">No. SKEP Pengangkat Anggota Polsus</th>
                                                        <th  style="text-align: center; min-width: 200px;">No. KTA Anggota Polsus</th>
                                                        <th  style="text-align: center; min-width: 300px;">Pejabat yang Mengeluarkan KTA</th>
                                                        <th  style="text-align: center; min-width: 170px;">KTA Berlaku hingga</th>
                                                        <th  style="text-align: center; min-width: 300px;">No. Izin Pegang Senpi dan Amunisi</th>
                                                        <th  style="text-align: center; min-width: 500px;">Pejabat yang Mengeluarkan Izin Pegang Senpi dan Amunisi</th>
                                                        <th  style="text-align: center; min-width: 400px;">Masa Belaku Izin Pegang Senpi dan Amunisi</th>
                                                        <th  style="text-align: center; min-width: 350px;">Kelengkapan Perorangan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($laporan[0] as $key => $item)
                                                        @if($key > 0)
                                                            <tr>
                                                                <th class="text-center">{{ $item[0] }}</th>
                                                                <td>
                                                                    <select name="role_id[{{$key}}][]" id="select-role" multiple="multiple"
                                                                            class="form-control select2 w-100  @error('role_id') is-invalid @enderror">
                                                                        <option></option>
                                                                    </select>
                                                                    @error('role_id')
                                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="email" class="form-control"
                                                                           name="laporan[{{ $key }}][email]"
                                                                           id="laporan[{{ $key }}][email]"
                                                                           value="{{ $item[1] ?? "-" }}">
                                                                </td>
                                                                <td>
                                                                    <input type="password" class="form-control"
                                                                           name="laporan[{{ $key }}][password]"
                                                                           id="laporan[{{ $key }}][password]"
                                                                           value="{{ $item[2] ?? "-" }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][nama]"
                                                                           id="laporan[{{ $key }}][nama]"
                                                                           value="{{ $item[3] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][tempat_lahir]"
                                                                           id="laporan[{{ $key }}][tempat_lahir]"
                                                                           value="{{ $item[4] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="date" class="form-control"
                                                                           name="laporan[{{ $key }}][tanggal_lahir]"
                                                                           id="laporan[{{ $key }}][tanggal_lahir]"
                                                                           value="{{ date($item[5]) }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][golongan]"
                                                                           id="laporan[{{ $key }}][golongan]"
                                                                           value="{{ $item[6] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][pangkat]"
                                                                           id="laporan[{{ $key }}][pangkat]"
                                                                           value="{{ $item[7] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][nip]"
                                                                           id="laporan[{{ $key }}][nip]"
                                                                           value="{{ $item[8] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][no_hp]"
                                                                           id="laporan[{{ $key }}][no_hp]"
                                                                           value="{{ $item[9] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][jabatan]"
                                                                           id="laporan[{{ $key }}][jabatan]"
                                                                           value="{{ $item[10] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][provinsi]"
                                                                           id="laporan[{{ $key }}][provinsi]"
                                                                           value="{{ $item[11] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][kabupaten]"
                                                                           id="laporan[{{ $key }}][kabupaten]"
                                                                           value="{{ $item[12] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][kecamatan]"
                                                                           id="laporan[{{ $key }}][kecamatan]"
                                                                           value="{{ $item[13] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][kelurahan]"
                                                                           id="laporan[{{ $key }}][kelurahan]"
                                                                           value="{{ $item[14] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][detail_alamat]"
                                                                           id="laporan[{{ $key }}][detail_alamat]"
                                                                           value="{{ $item[15] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control"
                                                                           name="laporan[{{ $key }}][rt]"
                                                                           id="laporan[{{ $key }}][rt]"
                                                                           value="{{ $item[16] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control"
                                                                           name="laporan[{{ $key }}][rw]"
                                                                           id="laporan[{{ $key }}][rw]"
                                                                           value="{{ $item[17] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][jenjang_diklat]"
                                                                           id="laporan[{{ $key }}][jenjang_diklat]"
                                                                           value="{{ $item[18] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][no_ijazah]"
                                                                           id="laporan[{{ $key }}][no_ijazah]"
                                                                           value="{{ $item[19] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][tempat_dikeluarkan_ijazah]"
                                                                           id="laporan[{{ $key }}][tempat_dikeluarkan_ijazah]"
                                                                           value="{{ $item[20] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="date" class="form-control"
                                                                           name="laporan[{{ $key }}][tanggal_dikeluarkan_ijazah]"
                                                                           id="laporan[{{ $key }}][tanggal_dikeluarkan_ijazah]"
                                                                           value="{{ $item[21] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][no_skep]"
                                                                           id="laporan[{{ $key }}][no_skep]"
                                                                           value="{{ $item[22] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][no_kta]"
                                                                           id="laporan[{{ $key }}][no_kta]"
                                                                           value="{{ $item[23] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][pejabat_yang_mengeluarkan_kta]"
                                                                           id="laporan[{{ $key }}][pejabat_yang_mengeluarkan_kta]"
                                                                           value="{{ $item[24] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="date" class="form-control"
                                                                           name="laporan[{{ $key }}][expired_kta]"
                                                                           id="laporan[{{ $key }}][expired_kta]"
                                                                           value="{{ $item[25] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][no_izin_pegang_senpi]"
                                                                           id="laporan[{{ $key }}][no_izin_pegang_senpi]"
                                                                           value="{{ $item[26] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           name="laporan[{{ $key }}][pejabat_yang_mengeluarkan_izin_pegang_senpi]"
                                                                           id="laporan[{{ $key }}][pejabat_yang_mengeluarkan_izin_pegang_senpi]"
                                                                           value="{{ $item[27] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="date" class="form-control"
                                                                           name="laporan[{{ $key }}][expired_izin_pegang]"
                                                                           id="laporan[{{ $key }}][expired_izin_pegang]"
                                                                           value="{{ $item[28] ?? 0 }}">
                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control" name="laporan[{{ $key }}][kelengkapan_perorangan]" id="laporan[{{ $key }}][kelengkapan_perorangan]" cols="30"
                                                                              rows="3">{{ $item[29] ?? '-' }}</textarea>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center justify-content-md-end">
                                                <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('customjs')
    @include('assets.js.select2')
    <script src="{{ asset('js/component-with-pagination.js') }}"></script>
    <script>
        buildSelect2Search({
            placeholder: 'pilih hak akses',
            url: route('role.select2'),
            minimumInputLength: 0,
            selector: [
                { id: $('#select-role') },
                { id: $('#select-role-import') }
            ],
            query: function (params) {
                return { alias: params.term }
            }
        });
    </script>
@endsection
