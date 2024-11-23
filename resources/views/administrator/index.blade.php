@php use App\Helpers\Constants; @endphp
@extends('templates.admin-lte.admin', ['title' => 'Selamat Datang'])
@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/administrator/dashboard.css') }}">
    @include('assets.css.datetimepicker')
    @include('assets.css.select2')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="card-text">Selamat datang di Dashboard Kementerian Ketenagakerjaan Republik Indonesia
{{--                <b>{{ isset(auth()->user()->personel->name) ? auth()->user()->personel->name : auth()->user()->roleName() }}</b>--}}
            </p>
        </div>
    </div>

    <section class="row my-3" style="row-gap: 1rem">
        <div class="col-sm-3">
            <a href="https://bos.braindevs.com/administrator/sislap/lapsubjar/si-polsus" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Sipolsus</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Binpolmas</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="https://bos.braindevs.com/administrator/sislap/lapsubjar/bhabin" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Bhabinkamtibmas</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binkamsa" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-book-reader" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Binkamsa</b></h4>
                </div>
            </a>
        </div>
    </section>

    <div class="card">
        <div class="card-header bg-primary">
            <h5><i class="icon fas fa-filter"></i> Filter</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="select-polda">Satuan Polda</label>
                    <select name="polda" id="select-polda" class="form-control select2 select2-hidden-accessible" data-select2-id="select2-data-select-polda" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="select2-data-2-j4c2"></option>
                    </select><span class="select2 select2-container select2-container--bootstrap-5" dir="ltr" data-select2-id="select2-data-1-3jzg" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select-polda-container" aria-controls="select2-select-polda-container"><span class="select2-selection__rendered" id="select2-select-polda-container" role="textbox" aria-readonly="true" title="-- Pilih Polda --"><span class="select2-selection__placeholder">-- Pilih Polda --</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
                <div class="form-group col-sm-4">
                    <label for="search">Pencarian umum</label>
                    <input type="text" id="search" name="search" class="form-control" placeholder="Cari berdasarkan kolom-kolom di tabel">
                </div>
                <div class="form-group col">
                    <label for="start_date">Mulai Tanggal</label>
                    <input type="date" id="start_date" name="start_date" class="form-control">
                </div>
                <div class="form-group col">
                    <label for="end_date">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <section class="row mt-5 mb-3" style="row-gap: 1rem">
        <div class="col-sm-3">
            <div href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center bg-primary text-light">
                <div class="text-center" style="padding-top: 40px;">
                    <h1 style="font-size: 64px" class="text-center"><b>70.400</b></h1>
                    <h4>Data Pekerja GenZ</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center bg-primary text-light">
                <div class="text-center" style="padding-top: 40px;">
                    <h1 style="font-size: 64px" class="text-center"><b>70.400</b></h1>
                    <h4>Data Pekerja GenZ</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center bg-primary text-light">
                <div class="text-center" style="padding-top: 40px;">
                    <h1 style="font-size: 64px" class="text-center"><b>70.400</b></h1>
                    <h4>Data Pekerja GenZ</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center bg-primary text-light">
                <div class="text-center" style="padding-top: 40px;">
                    <h1 style="font-size: 64px" class="text-center"><b>70.400</b></h1>
                    <h4>Data Pekerja GenZ</h4>
                </div>
            </div>
        </div>
    </section>

    @include('administrator.sislap.lapsubjar.binpolmas.chart-binpolmas')

    <table class="table table-hover table-bordered text-center w-100" id="table-pemanfaatan">
        <thead>
        <tr style="background-color: #1E4588">
            <th class="align-middle text-white" rowspan="2">No</th>
            <th class="align-middle text-white" colspan="2">Lokasi Pemungutan Suara</th>
            <th class="align-middle text-white" rowspan="2">Suara Pasangan 01</th>
            <th class="align-middle text-white" rowspan="2">Suara Pasangan 02</th>
            <th class="align-middle text-white" rowspan="2">Suara Pasangan 03</th>
            <th class="align-middle text-white" rowspan="2">Suara Tidak Sah</th>
            <th class="align-middle text-white" rowspan="2">Tanggal Laporan Terbaru</th>
        </tr>
        <tr style="background-color: #1E4588">
            <th class="align-middle text-white">Kecamatan</th>
            <th class="align-middle text-white">Desa/Kelurahan</th>
        </tr>
        </thead>
        <tbody id="table-pemanfaatan-body">
            <tr>
                <td>1.</td>
                <td>Tlogosari Kulon</td>
                <td>Kalicari</td>
                <td>150</td>
                <td>250</td>
                <td>800</td>
                <td>50</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Gayamsari</td>
                <td>Kalicari</td>
                <td>100</td>
                <td>300</td>
                <td>1050</td>
                <td>10</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Palebon</td>
                <td>Kalicari</td>
                <td>50</td>
                <td>350</td>
                <td>700</td>
                <td>14</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Pedurungan Tengah</td>
                <td>Pedurungan</td>
                <td>200</td>
                <td>500</td>
                <td>600</td>
                <td>24</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Tlogomulyo</td>
                <td>Pedurungan</td>
                <td>89</td>
                <td>137</td>
                <td>741</td>
                <td>60</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Cabean</td>
                <td>Semarang Barat</td>
                <td>60</td>
                <td>340</td>
                <td>872</td>
                <td>51</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Bongsari</td>
                <td>Semarang Barat</td>
                <td>82</td>
                <td>327</td>
                <td>641</td>
                <td>20</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Krapyak</td>
                <td>Semarang Barat</td>
                <td>230</td>
                <td>410</td>
                <td>541</td>
                <td>13</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Tawang Mas</td>
                <td>Semarang Barat</td>
                <td>121</td>
                <td>58</td>
                <td>549</td>
                <td>20</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
            <tr>
                <td>10.</td>
                <td>Rejosari</td>
                <td>Semarang Timur</td>
                <td>100</td>
                <td>83</td>
                <td>431</td>
                <td>19</td>
                <td>14 Februari 2024, 13:25</td>
            </tr>
        </tbody>
    </table>
@endsection
@section('customjs')
    <script>
        if (window.screen.width < 480) setTimeout(function() {
            document.body.classList.remove('sidebar-closed', 'sidebar-collapse')
            document.body.classList.add('sidebar-open')
        }, 3000)
    </script>
@endsection
