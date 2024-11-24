@php use App\Helpers\Constants; @endphp
@extends('templates.admin-lte.admin', ['title' => 'Selamat datang di Dashboard Kementerian Ketenagakerjaan Republik Indonesia '])
@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/administrator/dashboard.css') }}">
    @include('assets.css.datetimepicker')
    @include('assets.css.select2')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="card-text">Sistem pencatatan dan monitoring capaian atas pelaksanaan program dan kegiatan Kementerian Ketenagakerjaan
                {{--                <b>{{ isset(auth()->user()->personel->name) ? auth()->user()->personel->name : auth()->user()->roleName() }}</b>--}}
            </p>
        </div>
    </div>

    <section class="row my-3" style="row-gap: 1rem">
        <div class="col-sm-3">
            <a href="https://bos.braindevs.com/administrator/sislap/lapsubjar/si-polsus" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-chart-bar" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Rekap Realisasi Belanja Per Jenis Belanja </b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-chart-area" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Rekap Realisasi Belanja Per Wilayah </b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="https://bos.braindevs.com/administrator/sislap/lapsubjar/bhabin" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-chart-line" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Rekap Realisasi Belanja Per Sumber Dana</b></h4>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binkamsa" class="card h-100 d-flex align-items-center">
                <div class="card-header text-center py-4">
                    <i class="fas fa-chart-pie" style="font-size: 100px"></i>
                </div>
                <div class="card-body py-1 d-flex align-items-center">
                    <h4 class="text-center"><b>Capaian IKPA Kemnaker</b></h4>
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
                    <label for="select-polda">Nama Unit Kerja</label>
                    <select name="unit-kerja" id="unit-kerja" class="form-control select2" tabindex="-1" aria-hidden="true">
                        <option value="02601">02601 | SEKRETARIS JENDERAL</option>
                        <option value="02602">02602 | INSPEKTUR JENDERAL</option>
                        <option value="02604">02604 | DITJEN PEMBINAAN PENEMPATAN TENAGA KERJA DAN PERLUASAN KESEMPATAN KERJA</option>
                        <option value="02605">02605 | DIRJEN PEMBINAAN HUBUNGAN INDUSTRIAL & JAMINAN SOSIAL KETENAGAKERJAAN</option>
                        <option value="02608">02608 | DITJEN PEMBINAAN PENGAWASAN KETENAGAKERJAAN DAN KESELAMATAN DAN KESEHATAN KERJA</option>
                        <option value="02611">02611 | BADAN PERENCANAAN DAN PENGEMBANGAN KETENAGAKERJAAN</option>
                        <option value="02613">02613 | DIRJEN PEMBINAAN PELATIHAN DAN PRODUKTIVITAS</option>
                    </select>
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
        <div class="col-sm-4">
            <div href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center bg-primary text-light">
                <div class="text-center" style="padding-top: 40px;">
                    <h1 style="font-size: 64px" class="text-center"><b>70,90%</b></h1>
                    <h4>Presentase realisasi anggaran</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center bg-primary text-light">
                <div class="text-center" style="padding-top: 40px;">
                    <h1 style="font-size: 64px" class="text-center"><b>60,2%</b></h1>
                    <h4>Jumlah Tender Selesai/Total Tender</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div href="https://bos.braindevs.com/administrator/sislap/lapsubjar/binpolmas" class="card h-100 d-flex align-items-center bg-primary text-light">
                <div class="text-center" style="padding-top: 40px;">
                    <h1 style="font-size: 64px" class="text-center"><b>67.72</b></h1>
                    <h4>Nilai IKPA</h4>
                </div>
            </div>
        </div>
    </section>

    @include('administrator.sislap.lapsubjar.binpolmas.chart-binpolmas')

    <div class="mt-5"></div>

    <h4 class="h4">Tabel 1</h4>
    <table class="table table-hover table-bordered text-center w-100" id="table-pemanfaatan">
        <thead>
        <tr style="background-color: #1E4588">
            <th rowspan="2" class="align-middle text-white">NO</th>
            <th rowspan="2" class="align-middle text-white">ESELON 1</th>
            <th colspan="3" class="align-middle text-white">PEGAWAI</th>
            <th colspan="3" class="align-middle text-white">BARANG</th>
            <th colspan="3" class="align-middle text-white">MODAL</th>
            <th colspan="3" class="align-middle text-white">TOTAL</th>
        </tr>
        <tr style="background-color: #1E4588">
            <th class="align-middle text-white">PAGU</th>
            <th class="align-middle text-white">REAL</th>
            <th class="align-middle text-white">%</th>
            <th class="align-middle text-white">PAGU</th>
            <th class="align-middle text-white">REAL</th>
            <th class="align-middle text-white">%</th>
            <th class="align-middle text-white">PAGU</th>
            <th class="align-middle text-white">REAL</th>
            <th class="align-middle text-white">%</th>
            <th class="align-middle text-white">PAGU</th>
            <th class="align-middle text-white">REAL</th>
            <th class="align-middle text-white">%</th>
        </tr>
        </thead>
        <tbody id="table-pemanfaatan-body">
        <tr>
            <td>1</td>
            <td>SETJEN</td>
            <td>73.515.751.000</td>
            <td>60.203.552.697</td>
            <td>81.89</td>
            <td>318.465.851.000</td>
            <td>241.352.747.288</td>
            <td>75.79</td>
            <td>60.094.685.000</td>
            <td>46.995.226.074</td>
            <td>78.20</td>
            <td>452.076.287.000</td>
            <td>348.551.526.059</td>
            <td>77.10</td>
        </tr>
        <tr>
            <td>2</td>
            <td>ITJEN</td>
            <td>19.453.126.000</td>
            <td>15.498.492.973</td>
            <td>79.67</td>
            <td>46.910.911.000</td>
            <td>34.958.931.315</td>
            <td>74.52</td>
            <td>2.106.337.000</td>
            <td>1.466.985.000</td>
            <td>69.65</td>
            <td>68.470.374.000</td>
            <td>51.924.409.288</td>
            <td>75.83</td>
        </tr>
        <tr>
            <td>3</td>
            <td>DITJEN BINAPENTA & PKK</td>
            <td>49.677.704.000</td>
            <td>41.063.841.255</td>
            <td>82.66</td>
            <td>770.121.986.000</td>
            <td>616.105.053.691</td>
            <td>80.00</td>
            <td>23.308.277.000</td>
            <td>7.773.352.892</td>
            <td>33.35</td>
            <td>843.107.967.000</td>
            <td>664.942.247.838</td>
            <td>78.87</td>
        </tr>
        <tr>
            <td>4</td>
            <td>DITJEN PHI & JAMSOS TK</td>
            <td>30.936.838.000</td>
            <td>24.385.123.646</td>
            <td>78.82</td>
            <td>1.510.482.282.000</td>
            <td>1.180.393.908.013</td>
            <td>78.15</td>
            <td>4.864.560.000</td>
            <td>3.387.666.400</td>
            <td>69.64</td>
            <td>1.546.283.680.000</td>
            <td>1.208.166.698.059</td>
            <td>78.13</td>
        </tr>
        <tr>
            <td>5</td>
            <td>DITJEN BINWASNAKER</td>
            <td>65.681.760.000</td>
            <td>58.803.973.791</td>
            <td>89.53</td>
            <td>205.981.727.000</td>
            <td>147.782.897.012</td>
            <td>71.75</td>
            <td>87.716.581.000</td>
            <td>58.213.688.051</td>
            <td>66.37</td>
            <td>359.380.068.000</td>
            <td>264.800.558.854</td>
            <td>73.68</td>
        </tr>
        <tr>
            <td>6</td>
            <td>BARENBANG</td>
            <td>20.023.075.000</td>
            <td>16.289.424.510</td>
            <td>81.35</td>
            <td>190.237.969.000</td>
            <td>128.789.890.720</td>
            <td>67.70</td>
            <td>11.163.386.000</td>
            <td>1.909.973.700</td>
            <td>17.11</td>
            <td>221.424.430.000</td>
            <td>146.989.288.930</td>
            <td>66.38</td>
        </tr>
        <tr>
            <td>7</td>
            <td>DITJEN BINAVALOTAS</td>
            <td>278.745.369.000</td>
            <td>209.068.248.909</td>
            <td>75.00</td>
            <td>1.969.948.869.000</td>
            <td>1.252.830.344.196</td>
            <td>63.60</td>
            <td>372.364.921.000</td>
            <td>186.013.605.521</td>
            <td>49.95</td>
            <td>2.621.059.159.000</td>
            <td>1.647.912.198.626</td>
            <td>62.87</td>
        </tr>
        <tr style="background-color: #1E4588" class="text-light">
            <td colspan="2">KEMNAKER</td>
            <td>538.033.623.000</td>
            <td>425.312.657.781</td>
            <td>79.05</td>
            <td>5.012.149.595.000</td>
            <td>3.602.213.772.235</td>
            <td>71.87</td>
            <td>561.618.747.000</td>
            <td>305.760.497.638</td>
            <td>54.44</td>
            <td>6.111.801.965.000</td>
            <td>4.333.286.927.654</td>
            <td>70.90</td>
        </tr>
        </tbody>
    </table>

    <hr>
    <div class="d-flex justify-content-between">
        <h4 class="h4 mt-3">Tabel 2</h4>
        <button onclick="resetTable2()" id="reset-table-2-btn" class="mt-2 mb-4 btn btn-warning d-none">Kembali ke Tampilan Awal</button>
    </div>
    <table class="table table-hover table-bordered text-center w-100" id="table-2-parent">
        <thead>
        <tr style="background-color: #1E4588">
            <th rowspan="2" class="align-middle text-white">NO</th>
            <th rowspan="2" class="align-middle text-white">NAMA ES1</th>
            <th colspan="2" class="align-middle text-white">KUALITAS PERENCANAAN ANGGARAN</th>
            <th colspan="4" class="align-middle text-white">KUALITAS PELAKSANAAN ANGGARAN</th>
            <th colspan="1" class="align-middle text-white">KUALITAS HASIL PELAKSANAAN ANGGARAN</th>
            <th rowspan="2" class="align-middle text-white">NILAI IKPA</th>
        </tr>
        <tr style="background-color: #1E4588">
            <th class="align-middle text-white">REVISI DIPA</th>
            <th class="align-middle text-white">DEVIASI HALAMAN III DIPA</th>
            <th class="align-middle text-white">PENYERAPAN ANGGARAN</th>
            <th class="align-middle text-white">BELANJA KONTRAKTUAL</th>
            <th class="align-middle text-white">PENYELESAIAN TAGIHAN</th>
            <th class="align-middle text-white">PENGELOLAAN UP DAN TUP</th>
            <th class="align-middle text-white">CAPAIAN OUTPUT</th>
        </tr>
        </thead>
        <tbody id="table-pemanfaatan-body">
        <tr>
            <td>1</td>
            <td>SETJEN</td>
            <td>100</td>
            <td>80.16</td>
            <td>92.22</td>
            <td>100</td>
            <td>100</td>
            <td>95.76</td>
            <td>0</td>
            <td>70.04</td>
        </tr>
        <tr>
            <td>2</td>
            <td>ITJEN</td>
            <td>100</td>
            <td>79.72</td>
            <td>95.42</td>
            <td>100</td>
            <td>100</td>
            <td>100</td>
            <td>0</td>
            <td>71.04</td>
        </tr>
        <tr>
            <td>3</td>
            <td>DITJEN BINAPENTA & PKK</td>
            <td>99.49</td>
            <td>67.16</td>
            <td>86.5</td>
            <td>99.5</td>
            <td>98.82</td>
            <td>92.33</td>
            <td>0</td>
            <td>66.39</td>
        </tr>
        <tr>
            <td>4</td>
            <td><span style="cursor: pointer; text-decoration: underline;" class="text-blue" onclick="changeTable2()">DITJEN PHI & JAMSOS TK</span></td>
            <td>100</td>
            <td>71.43</td>
            <td>84.15</td>
            <td>100</td>
            <td>100</td>
            <td>93.92</td>
            <td>0</td>
            <td>66.94</td>
        </tr>
        <tr>
            <td>5</td>
            <td>DITJEN BINWASNAKER</td>
            <td>100</td>
            <td>72.23</td>
            <td>86.9</td>
            <td>100</td>
            <td>100</td>
            <td>95.83</td>
            <td>0</td>
            <td>67.8</td>
        </tr>
        <tr>
            <td>6</td>
            <td>BARENBANG</td>
            <td>100</td>
            <td>76.03</td>
            <td>86.98</td>
            <td>100</td>
            <td>100</td>
            <td>98.01</td>
            <td>0</td>
            <td>68.6</td>
        </tr>
        <tr>
            <td>7</td>
            <td>DITJEN BINAVALOTAS</td>
            <td>100</td>
            <td>80.29</td>
            <td>81.86</td>
            <td>98.72</td>
            <td>99.55</td>
            <td>96.79</td>
            <td>0</td>
            <td>67.92</td>
        </tr>
        <tr style="background-color: #1E4588" class="text-light">
            <td colspan="2">KEMNAKER</td>
            <td>99.89</td>
            <td>74.8</td>
            <td>85.28</td>
            <td>99.35</td>
            <td>99.59</td>
            <td>95.65</td>
            <td>0</td>
            <td>67.72</td>
        </tr>
        </tbody>
    </table>
    <table class="table table-hover table-bordered text-center w-100 d-none" id="table-2-child">
        <thead>
        <tr style="background-color: #1E4588">
            <th class="align-middle text-white">NO</th>
            <th class="align-middle text-white">KODE SATKER</th>
            <th class="align-middle text-white">URAIAN SATKER</th>
            <th class="align-middle text-white">REVISI DIPA</th>
            <th class="align-middle text-white">DEVIASI HALAMAN III DIPA</th>
            <th class="align-middle text-white">PENYERAPAN ANGGARAN</th>
            <th class="align-middle text-white">BELANJA KONTRAKTUAL</th>
            <th class="align-middle text-white">PENYELESAIAN TAGIHAN</th>
            <th class="align-middle text-white">PENGELOLAAN UP DAN TUP</th>
            <th class="align-middle text-white">CAPAIAN OUTPUT</th>
            <th class="align-middle text-white">NILAI IKPA</th>
        </tr>
        </thead>
        <tbody id="table-pemanfaatan-body">
        <tr>
            <td>1</td>
            <td>049009</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI YOGYAKARTA</td>
            <td>100</td>
            <td>91.29</td>
            <td>79.29</td>
            <td>100</td>
            <td>100</td>
            <td>91.09</td>
            <td>0</td>
            <td>68.66</td>
        </tr>
        <tr>
            <td>2</td>
            <td>451270</td>
            <td>DITJEN. PEMBINAAN HUBUNGAN INDUSTRIAL DAN JAMINAN SOSIAL TENAGA KERJA</td>
            <td>100</td>
            <td>72.24</td>
            <td>84.23</td>
            <td>100</td>
            <td>100</td>
            <td>98.48</td>
            <td>0</td>
            <td>67.53</td>
        </tr>
        <tr>
            <td>3</td>
            <td>199010</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROPINSI SULAWESI SELATAN</td>
            <td>100</td>
            <td>81.99</td>
            <td>77.8</td>
            <td>100</td>
            <td>100</td>
            <td>95.84</td>
            <td>0</td>
            <td>67.44</td>
        </tr>
        <tr>
            <td>4</td>
            <td>209016</td>
            <td>DINAS TRANSMIGRASI DAN TENAGA KERJA PROVINSI SULAWESI TENGGARA</td>
            <td>100</td>
            <td>92.49</td>
            <td>91.6</td>
            <td>0</td>
            <td>0</td>
            <td>99.68</td>
            <td>0</td>
            <td>65.20</td>
        </tr>
        <tr>
            <td>5</td>
            <td>229014</td>
            <td>DINAS KETENAGAKERJAAN DAN ENERGI SUMBER DAYA MINERAL PROVINSI BALI</td>
            <td>100</td>
            <td>58.36</td>
            <td>80.65</td>
            <td>100</td>
            <td>100</td>
            <td>96.66</td>
            <td>0</td>
            <td>64.55</td>
        </tr>
        <tr>
            <td>6</td>
            <td>29010</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI JAWA BARAT</td>
            <td>100</td>
            <td>50.85</td>
            <td>81.12</td>
            <td>100</td>
            <td>100</td>
            <td>97.69</td>
            <td>0</td>
            <td>63.62</td>
        </tr>
        <tr>
            <td>7</td>
            <td>249012</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROV. NUSA TENGGARA TIMUR</td>
            <td>100</td>
            <td>81.74</td>
            <td>90.7</td>
            <td>0</td>
            <td>0</td>
            <td>96.83</td>
            <td>0</td>
            <td>62.61</td>
        </tr>
        <tr>
            <td>8</td>
            <td>99000</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI RIAU</td>
            <td>100</td>
            <td>90.66</td>
            <td>87.19</td>
            <td>0</td>
            <td>0</td>
            <td>78.23</td>
            <td>0</td>
            <td>61.08</td>
        </tr>
        <tr>
            <td>9</td>
            <td>239219</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROV. NTB</td>
            <td>100</td>
            <td>65.74</td>
            <td>94.39</td>
            <td>0</td>
            <td>0</td>
            <td>99.45</td>
            <td>0</td>
            <td>60.86</td>
        </tr>
        <tr>
            <td>10</td>
            <td>269009</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI BENGKULU</td>
            <td>100</td>
            <td>67.82</td>
            <td>100</td>
            <td>0</td>
            <td>0</td>
            <td>85.16</td>
            <td>0</td>
            <td>60.86</td>
        </tr>
        <tr>
            <td>11</td>
            <td>69075</td>
            <td>DINAS TENAGA KERJA DAN MOBILITAS PENDUDUK PROVINSI NAD</td>
            <td>100</td>
            <td>74.87</td>
            <td>88</td>
            <td>0</td>
            <td>0</td>
            <td>95.29</td>
            <td>0</td>
            <td>60.45</td>
        </tr>
        <tr>
            <td>12</td>
            <td>299018</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI BANTEN</td>
            <td>100</td>
            <td>51.85</td>
            <td>66.33</td>
            <td>100</td>
            <td>100</td>
            <td>93.75</td>
            <td>0</td>
            <td>60.42</td>
        </tr>
        <tr>
            <td>13</td>
            <td>339003</td>
            <td>DINAS TRANSMIGRASI DAN TENAGA KERJA PROVINSI PAPUA</td>
            <td>100</td>
            <td>78.1</td>
            <td>84.56</td>
            <td>0</td>
            <td>0</td>
            <td>92.51</td>
            <td>0</td>
            <td>59.85</td>
        </tr>
        <tr>
            <td>14</td>
            <td>39091</td>
            <td>DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI JAWA TENGAH</td>
            <td>100</td>
            <td>74.68</td>
            <td>83.63</td>
            <td>0</td>
            <td>0</td>
            <td>98.3</td>
            <td>0</td>
            <td>59.7</td>
        </tr>
        <tr>
            <td>15</td>
            <td>219006</td>
            <td>DINAS NAKERTRANS PROVINSI MALUKU</td>
            <td>100</td>
            <td>66.22</td>
            <td>85.47</td>
            <td>0</td>
            <td>0</td>
            <td>99.97</td>
            <td>0</td>
            <td>58.78</td>
        </tr>
        </tbody>
    </table>

    <hr>
    <h4 class="h4 mt-3">Tabel 3</h4>
    <table class="table table-hover table-bordered text-center w-100" id="table-pemanfaatan">
        <thead>
        <tr style="background-color: #1E4588">
            <th rowspan="2" class="align-middle text-white">NO</th>
            <th rowspan="2" class="align-middle text-white">ESELON I</th>
            <th colspan="2" class="align-middle text-white">PAKET TENDER/SELEKSI</th>
            <th colspan="3" class="align-middle text-white">TENDER/SELEKSI SELESAI</th>
            <th colspan="2" class="align-middle text-white">SISA PAKET TENDER/SELEKSI</th>
        </tr>
        <tr style="background-color: #1E4588">
            <th class="align-middle text-white">JUMLAH PAKET TENDER/SELEKSI</th>
            <th class="align-middle text-white">TOTAL PAGU (Rp.)</th>
            <th class="align-middle text-white">JUMLAH PAKET TENDER/SELESAI</th>
            <th class="align-middle text-white">TOTAL PAGU (Rp.)</th>
            <th class="align-middle text-white">NILAI KONTRAK (Rp.)</th>
            <th class="align-middle text-white">SISA JUMLAH PAKET TENDER/SELEKSI</th>
            <th class="align-middle text-white">SISA TOTAL PAGU (Rp.)</th>
        </tr>
        </thead>
        <tbody id="table-pemanfaatan-body">
        <tr>
            <td>1</td>
            <td>Sekretariat Jenderal</td>
            <td>8</td>
            <td>20.837.924.000</td>
            <td>8</td>
            <td>20.837.924.000</td>
            <td>15.759.890.101</td>
            <td>0</td>
            <td>-</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Ditjen Binalavotas</td>
            <td>72</td>
            <td>325.363.311.000</td>
            <td>47</td>
            <td>149.305.841.000</td>
            <td>131.652.709.834</td>
            <td>26</td>
            <td>76.057.470.000</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Ditjen Binapenta & PKK</td>
            <td>13</td>
            <td>15.715.416.000</td>
            <td>4</td>
            <td>5.427.085.000</td>
            <td>4.630.431.486</td>
            <td>9</td>
            <td>10.288.331.000</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Ditjen PHI & Jamsos TK</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Ditjen Binwasnaker &K3</td>
            <td>10</td>
            <td>19.238.072.000</td>
            <td>6</td>
            <td>18.624.799.000</td>
            <td>16.198.223.946</td>
            <td>4</td>
            <td>613.273.000</td>
        </tr>
        <tr>
            <td>6</td>
            <td>Inspektorat Jenderal</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>7</td>
            <td>Barenbang Ketenagakerjaan</td>
            <td>34</td>
            <td>20.940.596.000</td>
            <td>18</td>
            <td>9.833.375.000</td>
            <td>6.078.704.600</td>
            <td>16</td>
            <td>11.107.221.000</td>
        </tr>
        <tr style="background-color: #1E4588" class="text-light">
            <td colspan="2">TOTAL KEMNAKER</td>
            <td>138</td>
            <td>302.095.319.000</td>
            <td>83</td>
            <td>204.029.024.000</td>
            <td>174.319.959.967</td>
            <td>55</td>
            <td>98.066.295.000</td>
        </tr>
        </tbody>
    </table>


@endsection
@section('customjs')
    @include('assets.js.select2')
    <script>
        if (window.screen.width < 480) setTimeout(function() {
            document.body.classList.remove('sidebar-closed', 'sidebar-collapse')
            document.body.classList.add('sidebar-open')
        }, 3000)


        buildSelect2({
            placeholder: '-- Pilih Unit Kerja --'
            , minimumInputLength: 0
            , minimumResultsForSearch: Infinity
            , selector: [{
                id: $('#unit-kerja')
            }]
            , data: [
                { code: "02601", name: "SEKRETARIS JENDERAL" },
                { code: "02602", name: "INSPEKTUR JENDERAL" },
                { code: "02604", name: "DITJEN PEMBINAAN PENEMPATAN TENAGA KERJA DAN PERLUASAN KESEMPATAN KERJA" },
                { code: "02605", name: "DIRJEN PEMBINAAN HUBUNGAN INDUSTRIAL & JAMINAN SOSIAL KETENAGAKERJAAN" },
                { code: "02608", name: "DITJEN PEMBINAAN PENGAWASAN KETENAGAKERJAAN DAN KESELAMATAN DAN KESEHATAN KERJA" },
                { code: "02611", name: "BADAN PERENCANAAN DAN PENGEMBANGAN KETENAGAKERJAAN" },
                { code: "02613", name: "DIRJEN PEMBINAAN PELATIHAN DAN PRODUKTIVITAS" }
            ]
        })

        const changeTable2 = () => {
            $('#reset-table-2-btn').removeClass('d-none')
            $('#table-2-child').removeClass('d-none')
            $('#table-2-parent').addClass('d-none')
        }

        const resetTable2 = () => {
            $('#reset-table-2-btn').addClass('d-none')
            $('#table-2-child').addClass('d-none')
            $('#table-2-parent').removeClass('d-none')
        }
    </script>
@endsection
