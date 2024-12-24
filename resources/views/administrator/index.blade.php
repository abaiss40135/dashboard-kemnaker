@php use App\Helpers\Constants; @endphp
@extends('templates.admin-lte.admin', ['title' => 'Selamat datang di Dashboard Kementerian Ketenagakerjaan Republik Indonesia '])
@section('customcss')
    @include('assets.css.select2')
@endsection
@section('content')
    <div class="grid grid-cols-1 gap-x-5">
        <div class="box">
            <div class="box-header items-center border-0">
                <h2 class="mt-0">Sistem pencatatan dan monitoring capaian atas pelaksanaan program dan kegiatan Kementerian Ketenagakerjaan</h2>
            </div>
        </div>

        <div class="box-body pt-0 px-0 summery-box">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                <a href="#" class="col-lg-3 col-md-6">
                    <div class="box border border-primary rounded-2xl pull-up py-10 h-full">
                        <div class="box-body ">
                            <i class="fas fa-chart-bar mb-8 text-8xl"></i>
                            <h2 class="fw-600 mb-0 text-2xl">Rekap Realisasi Belanja Per Jenis Belanja</h2>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-lg-3 col-md-6">
                    <div class="box border border-primary rounded-2xl pull-up py-10 h-full">
                        <div class="box-body ">
                            <i class="fas fa-chart-area mb-8 text-8xl"></i>
                            <h2 class="fw-600 mb-0 text-2xl">Rekap Realisasi Belanja Per Wilayah</h2>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-lg-3 col-md-6">
                    <div class="box border border-primary rounded-2xl pull-up py-10 h-full">
                        <div class="box-body ">
                            <i class="fas fa-chart-line mb-8 text-8xl"></i>
                            <h2 class="fw-600 mb-0 text-2xl">Rekap Realisasi Belanja Per Sumber Dana</h2>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-lg-3 col-md-6">
                    <div class="box border border-primary rounded-2xl pull-up py-10 h-full">
                        <div class="box-body ">
                            <i class="fas fa-chart-pie mb-8 text-8xl"></i>
                            <h2 class="fw-600 mb-0 text-2xl">Capaian IKPA Kemnaker</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="box rounded-2xl">
            <div class="box-header flex b-0 justify-start items-center">
                <h2 class="mt-0"><i class="icon fas fa-filter"></i> Filter</h2>
            </div>
            <div class="box-body pt-0 summery-box">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label for="unit-kerja" class="block text-sm font-medium text-gray-700">Nama Unit Kerja</label>
                        <select id="unit-kerja" name="unit-kerja" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
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
                        <input type="text" id="search" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Cari berdasarkan kolom-kolom di tabel">
                    </div>
                
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
                            <input type="date" id="start_date" name="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" id="end_date" name="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                </div>                
            </div>
        </div>

        <div class="box-body pt-0 px-0 summery-box">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="box pull-up mb-sm-0 bg-dark h-full py-10">
                    <div class="box-body">
                        <h2 class="fw-800 text-6xl text-center mb-6"><b>70,90%</b></h2>
                        <h3 class="fw-500 mb-0 text-2xl text-center">Presentase realisasi anggaran</h3>
                    </div>
                </div>
                <div class="box pull-up mb-sm-0 bg-dark h-full py-10">
                    <div class="box-body">
                        <h2 class="fw-800 text-6xl text-center mb-6"><b>60,2%</b></h2>
                        <h3 class="fw-500 mb-0 text-2xl text-center">Jumlah Tender Selesai/Total Tender</h3>
                    </div>
                </div>
                <div class="box pull-up mb-sm-0 bg-dark h-full py-10">
                    <div class="box-body">
                        <h2 class="fw-800 text-6xl text-center mb-6"><b>67.72</b></h2>
                        <h3 class="fw-500 mb-0 text-2xl text-center">Nilai IKPA</h3>
                    </div>
                </div>
            </div>
        </div>

        @include('administrator.sislap.lapsubjar.binpolmas.chart-binpolmas')

        <div class="box rounded-2xl">
            <div class="box-header flex b-0 justify-start items-center">
                <h2 class="mt-0">Realisasi Anggaran Kemnaker</h2>
            </div>
            <div class="box-body pt-0 summery-box">
                <div class="overflow-x-auto">
                    <table class="table b-1 border-dark table-bordered w-full" id="table-pemanfaatan">
                        <thead class="text-base uppercase bg-dark">
                            <tr>
                                <th scope="col" rowspan="2">NO</th>
                                <th scope="col" rowspan="2">ESELON 1</th>
                                <th scope="col" colspan="3">PEGAWAI</th>
                                <th scope="col" colspan="3">BARANG</th>
                                <th scope="col" colspan="3">MODAL</th>
                                <th scope="col" colspan="3">TOTAL</th>
                            </tr>
                            <tr>
                                <th scope="col">PAGU</th>
                                <th scope="col">REAL</th>
                                <th scope="col">%</th>
                                <th scope="col">PAGU</th>
                                <th scope="col">REAL</th>
                                <th scope="col">%</th>
                                <th scope="col">PAGU</th>
                                <th scope="col">REAL</th>
                                <th scope="col">%</th>
                                <th scope="col">PAGU</th>
                                <th scope="col">REAL</th>
                                <th scope="col">%</th>
                            </tr>
                        </thead>
                        <tbody id="table-pemanfaatan-body">
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">SETJEN</td>
                                <td class="text-center">73.515.751.000</td>
                                <td class="text-center">60.203.552.697</td>
                                <td class="text-center">81.89</td>
                                <td class="text-center">318.465.851.000</td>
                                <td class="text-center">241.352.747.288</td>
                                <td class="text-center">75.79</td>
                                <td class="text-center">60.094.685.000</td>
                                <td class="text-center">46.995.226.074</td>
                                <td class="text-center">78.20</td>
                                <td class="text-center">452.076.287.000</td>
                                <td class="text-center">348.551.526.059</td>
                                <td class="text-center">77.10</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-center">ITJEN</td>
                                <td class="text-center">19.453.126.000</td>
                                <td class="text-center">15.498.492.973</td>
                                <td class="text-center">79.67</td>
                                <td class="text-center">46.910.911.000</td>
                                <td class="text-center">34.958.931.315</td>
                                <td class="text-center">74.52</td>
                                <td class="text-center">2.106.337.000</td>
                                <td class="text-center">1.466.985.000</td>
                                <td class="text-center">69.65</td>
                                <td class="text-center">68.470.374.000</td>
                                <td class="text-center">51.924.409.288</td>
                                <td class="text-center">75.83</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td class="text-center">DITJEN BINAPENTA & PKK</td>
                                <td class="text-center">49.677.704.000</td>
                                <td class="text-center">41.063.841.255</td>
                                <td class="text-center">82.66</td>
                                <td class="text-center">770.121.986.000</td>
                                <td class="text-center">616.105.053.691</td>
                                <td class="text-center">80.00</td>
                                <td class="text-center">23.308.277.000</td>
                                <td class="text-center">7.773.352.892</td>
                                <td class="text-center">33.35</td>
                                <td class="text-center">843.107.967.000</td>
                                <td class="text-center">664.942.247.838</td>
                                <td class="text-center">78.87</td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td class="text-center">DITJEN PHI & JAMSOS TK</td>
                                <td class="text-center">30.936.838.000</td>
                                <td class="text-center">24.385.123.646</td>
                                <td class="text-center">78.82</td>
                                <td class="text-center">1.510.482.282.000</td>
                                <td class="text-center">1.180.393.908.013</td>
                                <td class="text-center">78.15</td>
                                <td class="text-center">4.864.560.000</td>
                                <td class="text-center">3.387.666.400</td>
                                <td class="text-center">69.64</td>
                                <td class="text-center">1.546.283.680.000</td>
                                <td class="text-center">1.208.166.698.059</td>
                                <td class="text-center">78.13</td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td class="text-center">DITJEN BINWASNAKER</td>
                                <td class="text-center">65.681.760.000</td>
                                <td class="text-center">58.803.973.791</td>
                                <td class="text-center">89.53</td>
                                <td class="text-center">205.981.727.000</td>
                                <td class="text-center">147.782.897.012</td>
                                <td class="text-center">71.75</td>
                                <td class="text-center">87.716.581.000</td>
                                <td class="text-center">58.213.688.051</td>
                                <td class="text-center">66.37</td>
                                <td class="text-center">359.380.068.000</td>
                                <td class="text-center">264.800.558.854</td>
                                <td class="text-center">73.68</td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td class="text-center">BARENBANG</td>
                                <td class="text-center">20.023.075.000</td>
                                <td class="text-center">16.289.424.510</td>
                                <td class="text-center">81.35</td>
                                <td class="text-center">190.237.969.000</td>
                                <td class="text-center">128.789.890.720</td>
                                <td class="text-center">67.70</td>
                                <td class="text-center">11.163.386.000</td>
                                <td class="text-center">1.909.973.700</td>
                                <td class="text-center">17.11</td>
                                <td class="text-center">221.424.430.000</td>
                                <td class="text-center">146.989.288.930</td>
                                <td class="text-center">66.38</td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td class="text-center">DITJEN BINAVALOTAS</td>
                                <td class="text-center">278.745.369.000</td>
                                <td class="text-center">209.068.248.909</td>
                                <td class="text-center">75.00</td>
                                <td class="text-center">1.969.948.869.000</td>
                                <td class="text-center">1.252.830.344.196</td>
                                <td class="text-center">63.60</td>
                                <td class="text-center">372.364.921.000</td>
                                <td class="text-center">186.013.605.521</td>
                                <td class="text-center">49.95</td>
                                <td class="text-center">2.621.059.159.000</td>
                                <td class="text-center">1.647.912.198.626</td>
                                <td class="text-center">62.87</td>
                            </tr>
                            <tr class="bg-dark">
                                <td colspan="2">KEMNAKER</td>
                                <td class="text-center">538.033.623.000</td>
                                <td class="text-center">425.312.657.781</td>
                                <td class="text-center">79.05</td>
                                <td class="text-center">5.012.149.595.000</td>
                                <td class="text-center">3.602.213.772.235</td>
                                <td class="text-center">71.87</td>
                                <td class="text-center">561.618.747.000</td>
                                <td class="text-center">305.760.497.638</td>
                                <td class="text-center">54.44</td>
                                <td class="text-center">6.111.801.965.000</td>
                                <td class="text-center">4.333.286.927.654</td>
                                <td class="text-center">70.90</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="box rounded-2xl">
            <div class="box-header flex b-0 justify-between items-center">
                <h2 class="mt-0">Capaian Indikator Pelaksanaan Anggaran Kemnaker</h2>
                <button onclick="resetTable2()" id="reset-table-2-btn" class="mt-2 mb-4 btn btn-warning hidden">Kembali ke Tampilan Awal</button>
            </div>
            <div class="box-body pt-0 summery-box">
                <div class="overflow-x-auto">
                    <table class="table b-1 border-dark table-bordered w-full" id="table-2-parent">
                        <thead class="text-base uppercase bg-dark">
                            <tr>
                                <th scope="col" rowspan="2">NO</th>
                                <th scope="col" rowspan="2">NAMA ES1</th>
                                <th scope="col" colspan="2">KUALITAS PERENCANAAN ANGGARAN</th>
                                <th scope="col" colspan="4">KUALITAS PELAKSANAAN ANGGARAN</th>
                                <th scope="col" colspan="1">KUALITAS HASIL PELAKSANAAN ANGGARAN</th>
                                <th scope="col" rowspan="2">NILAI IKPA</th>
                            </tr>
                            <tr>
                                <th scope="col">REVISI DIPA</th>
                                <th scope="col">DEVIASI HALAMAN III DIPA</th>
                                <th scope="col">PENYERAPAN ANGGARAN</th>
                                <th scope="col">BELANJA KONTRAKTUAL</th>
                                <th scope="col">PENYELESAIAN TAGIHAN</th>
                                <th scope="col">PENGELOLAAN UP DAN TUP</th>
                                <th scope="col">CAPAIAN OUTPUT</th>
                            </tr>
                        </thead>
                        <tbody id="table-pemanfaatan-body">
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">SETJEN</td>
                                <td class="text-center">100</td>
                                <td class="text-center">80.16</td>
                                <td class="text-center">92.22</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">95.76</td>
                                <td class="text-center">0</td>
                                <td class="text-center">70.04</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-center">ITJEN</td>
                                <td class="text-center">100</td>
                                <td class="text-center">79.72</td>
                                <td class="text-center">95.42</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">0</td>
                                <td class="text-center">71.04</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td class="text-center">DITJEN BINAPENTA & PKK</td>
                                <td class="text-center">99.49</td>
                                <td class="text-center">67.16</td>
                                <td class="text-center">86.5</td>
                                <td class="text-center">99.5</td>
                                <td class="text-center">98.82</td>
                                <td class="text-center">92.33</td>
                                <td class="text-center">0</td>
                                <td class="text-center">66.39</td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td class="text-center"><span style="cursor: pointer; text-decoration: underline;" class="text-primary" onclick="changeTable2()">DITJEN PHI & JAMSOS TK</span></td>
                                <td class="text-center">100</td>
                                <td class="text-center">71.43</td>
                                <td class="text-center">84.15</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">93.92</td>
                                <td class="text-center">0</td>
                                <td class="text-center">66.94</td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td class="text-center">DITJEN BINWASNAKER</td>
                                <td class="text-center">100</td>
                                <td class="text-center">72.23</td>
                                <td class="text-center">86.9</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">95.83</td>
                                <td class="text-center">0</td>
                                <td class="text-center">67.8</td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td class="text-center">BARENBANG</td>
                                <td class="text-center">100</td>
                                <td class="text-center">76.03</td>
                                <td class="text-center">86.98</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">98.01</td>
                                <td class="text-center">0</td>
                                <td class="text-center">68.6</td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td class="text-center">DITJEN BINAVALOTAS</td>
                                <td class="text-center">100</td>
                                <td class="text-center">80.29</td>
                                <td class="text-center">81.86</td>
                                <td class="text-center">98.72</td>
                                <td class="text-center">99.55</td>
                                <td class="text-center">96.79</td>
                                <td class="text-center">0</td>
                                <td class="text-center">67.92</td>
                            </tr>
                            <tr class="bg-dark">
                                <td colspan="2">KEMNAKER</td>
                                <td class="text-center">99.89</td>
                                <td class="text-center">74.8</td>
                                <td class="text-center">85.28</td>
                                <td class="text-center">99.35</td>
                                <td class="text-center">99.59</td>
                                <td class="text-center">95.65</td>
                                <td class="text-center">0</td>
                                <td class="text-center">67.72</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table b-1 border-dark table-bordered w-full hidden" id="table-2-child">
                        <thead class="text-base uppercase bg-dark">
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">KODE SATKER</th>
                                <th scope="col">URAIAN SATKER</th>
                                <th scope="col">REVISI DIPA</th>
                                <th scope="col">DEVIASI HALAMAN III DIPA</th>
                                <th scope="col">PENYERAPAN ANGGARAN</th>
                                <th scope="col">BELANJA KONTRAKTUAL</th>
                                <th scope="col">PENYELESAIAN TAGIHAN</th>
                                <th scope="col">PENGELOLAAN UP DAN TUP</th>
                                <th scope="col">CAPAIAN OUTPUT</th>
                                <th scope="col">NILAI IKPA</th>
                            </tr>
                        </thead>
                        <tbody id="table-pemanfaatan-body">
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">049009</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI YOGYAKARTA</td>
                                <td class="text-center">100</td>
                                <td class="text-center">91.29</td>
                                <td class="text-center">79.29</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">91.09</td>
                                <td class="text-center">0</td>
                                <td class="text-center">68.66</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-center">451270</td>
                                <td class="text-center">DITJEN. PEMBINAAN HUBUNGAN INDUSTRIAL DAN JAMINAN SOSIAL TENAGA KERJA</td>
                                <td class="text-center">100</td>
                                <td class="text-center">72.24</td>
                                <td class="text-center">84.23</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">98.48</td>
                                <td class="text-center">0</td>
                                <td class="text-center">67.53</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td class="text-center">199010</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROPINSI SULAWESI SELATAN</td>
                                <td class="text-center">100</td>
                                <td class="text-center">81.99</td>
                                <td class="text-center">77.8</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">95.84</td>
                                <td class="text-center">0</td>
                                <td class="text-center">67.44</td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td class="text-center">209016</td>
                                <td class="text-center">DINAS TRANSMIGRASI DAN TENAGA KERJA PROVINSI SULAWESI TENGGARA</td>
                                <td class="text-center">100</td>
                                <td class="text-center">92.49</td>
                                <td class="text-center">91.6</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">99.68</td>
                                <td class="text-center">0</td>
                                <td class="text-center">65.20</td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td class="text-center">229014</td>
                                <td class="text-center">DINAS KETENAGAKERJAAN DAN ENERGI SUMBER DAYA MINERAL PROVINSI BALI</td>
                                <td class="text-center">100</td>
                                <td class="text-center">58.36</td>
                                <td class="text-center">80.65</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">96.66</td>
                                <td class="text-center">0</td>
                                <td class="text-center">64.55</td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td class="text-center">29010</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI JAWA BARAT</td>
                                <td class="text-center">100</td>
                                <td class="text-center">50.85</td>
                                <td class="text-center">81.12</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">97.69</td>
                                <td class="text-center">0</td>
                                <td class="text-center">63.62</td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td class="text-center">249012</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROV. NUSA TENGGARA TIMUR</td>
                                <td class="text-center">100</td>
                                <td class="text-center">81.74</td>
                                <td class="text-center">90.7</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">96.83</td>
                                <td class="text-center">0</td>
                                <td class="text-center">62.61</td>
                            </tr>
                            <tr>
                                <td class="text-center">8</td>
                                <td class="text-center">99000</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI RIAU</td>
                                <td class="text-center">100</td>
                                <td class="text-center">90.66</td>
                                <td class="text-center">87.19</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">78.23</td>
                                <td class="text-center">0</td>
                                <td class="text-center">61.08</td>
                            </tr>
                            <tr>
                                <td class="text-center">9</td>
                                <td class="text-center">239219</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROV. NTB</td>
                                <td class="text-center">100</td>
                                <td class="text-center">65.74</td>
                                <td class="text-center">94.39</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">99.45</td>
                                <td class="text-center">0</td>
                                <td class="text-center">60.86</td>
                            </tr>
                            <tr>
                                <td class="text-center">10</td>
                                <td class="text-center">269009</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI BENGKULU</td>
                                <td class="text-center">100</td>
                                <td class="text-center">67.82</td>
                                <td class="text-center">100</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">85.16</td>
                                <td class="text-center">0</td>
                                <td class="text-center">60.86</td>
                            </tr>
                            <tr>
                                <td class="text-center">11</td>
                                <td class="text-center">69075</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN MOBILITAS PENDUDUK PROVINSI NAD</td>
                                <td class="text-center">100</td>
                                <td class="text-center">74.87</td>
                                <td class="text-center">88</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">95.29</td>
                                <td class="text-center">0</td>
                                <td class="text-center">60.45</td>
                            </tr>
                            <tr>
                                <td class="text-center">12</td>
                                <td class="text-center">299018</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI BANTEN</td>
                                <td class="text-center">100</td>
                                <td class="text-center">51.85</td>
                                <td class="text-center">66.33</td>
                                <td class="text-center">100</td>
                                <td class="text-center">100</td>
                                <td class="text-center">93.75</td>
                                <td class="text-center">0</td>
                                <td class="text-center">60.42</td>
                            </tr>
                            <tr>
                                <td class="text-center">13</td>
                                <td class="text-center">339003</td>
                                <td class="text-center">DINAS TRANSMIGRASI DAN TENAGA KERJA PROVINSI PAPUA</td>
                                <td class="text-center">100</td>
                                <td class="text-center">78.1</td>
                                <td class="text-center">84.56</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">92.51</td>
                                <td class="text-center">0</td>
                                <td class="text-center">59.85</td>
                            </tr>
                            <tr>
                                <td class="text-center">14</td>
                                <td class="text-center">39091</td>
                                <td class="text-center">DINAS TENAGA KERJA DAN TRANSMIGRASI PROVINSI JAWA TENGAH</td>
                                <td class="text-center">100</td>
                                <td class="text-center">74.68</td>
                                <td class="text-center">83.63</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">98.3</td>
                                <td class="text-center">0</td>
                                <td class="text-center">59.7</td>
                            </tr>
                            <tr>
                                <td class="text-center">15</td>
                                <td class="text-center">219006</td>
                                <td class="text-center">DINAS NAKERTRANS PROVINSI MALUKU</td>
                                <td class="text-center">100</td>
                                <td class="text-center">66.22</td>
                                <td class="text-center">85.47</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td class="text-center">99.97</td>
                                <td class="text-center">0</td>
                                <td class="text-center">58.78</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="box rounded-2xl">
            <div class="box-header flex b-0 justify-start items-center">
                <h2 class="mt-0">Data Realisasi Pengadaan Barang/Jasa Mekanisme Tender/Seleksi Pada Aplikasi LPSE 2024</h2>
            </div>
            <div class="box-body pt-0 summery-box">
                <div class="overflow-x-auto">
                    <table class="table b-1 border-dark table-bordered w-full" id="table-pemanfaatan">
                        <thead class="text-base uppercase bg-dark">
                            <tr>
                                <th scope="col" rowspan="2">NO</th>
                                <th scope="col" rowspan="2">ESELON I</th>
                                <th scope="col" colspan="2">PAKET TENDER/SELEKSI</th>
                                <th scope="col" colspan="3">TENDER/SELEKSI SELESAI</th>
                                <th scope="col" colspan="2">SISA PAKET TENDER/SELEKSI</th>
                            </tr>
                            <tr>
                                <th scope="col">JUMLAH PAKET TENDER/SELEKSI</th>
                                <th scope="col">TOTAL PAGU (Rp.)</th>
                                <th scope="col">JUMLAH PAKET TENDER/SELESAI</th>
                                <th scope="col">TOTAL PAGU (Rp.)</th>
                                <th scope="col">NILAI KONTRAK (Rp.)</th>
                                <th scope="col">SISA JUMLAH PAKET TENDER/SELEKSI</th>
                                <th scope="col">SISA TOTAL PAGU (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody id="table-pemanfaatan-body">
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">Sekretariat Jenderal</td>
                                <td class="text-center">8</td>
                                <td class="text-center">20.837.924.000</td>
                                <td class="text-center">8</td>
                                <td class="text-center">20.837.924.000</td>
                                <td class="text-center">15.759.890.101</td>
                                <td class="text-center">0</td>
                                <td class="text-center">-</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-center">Ditjen Binalavotas</td>
                                <td class="text-center">72</td>
                                <td class="text-center">325.363.311.000</td>
                                <td class="text-center">47</td>
                                <td class="text-center">149.305.841.000</td>
                                <td class="text-center">131.652.709.834</td>
                                <td class="text-center">26</td>
                                <td class="text-center">76.057.470.000</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td class="text-center">Ditjen Binapenta & PKK</td>
                                <td class="text-center">13</td>
                                <td class="text-center">15.715.416.000</td>
                                <td class="text-center">4</td>
                                <td class="text-center">5.427.085.000</td>
                                <td class="text-center">4.630.431.486</td>
                                <td class="text-center">9</td>
                                <td class="text-center">10.288.331.000</td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td class="text-center">Ditjen PHI & Jamsos TK</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td class="text-center">Ditjen Binwasnaker &K3</td>
                                <td class="text-center">10</td>
                                <td class="text-center">19.238.072.000</td>
                                <td class="text-center">6</td>
                                <td class="text-center">18.624.799.000</td>
                                <td class="text-center">16.198.223.946</td>
                                <td class="text-center">4</td>
                                <td class="text-center">613.273.000</td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td class="text-center">Inspektorat Jenderal</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td class="text-center">Barenbang Ketenagakerjaan</td>
                                <td class="text-center">34</td>
                                <td class="text-center">20.940.596.000</td>
                                <td class="text-center">18</td>
                                <td class="text-center">9.833.375.000</td>
                                <td class="text-center">6.078.704.600</td>
                                <td class="text-center">16</td>
                                <td class="text-center">11.107.221.000</td>
                            </tr>
                            <tr class="text-light">
                                <td colspan="2">TOTAL KEMNAKER</td>
                                <td class="text-center">138</td>
                                <td class="text-center">302.095.319.000</td>
                                <td class="text-center">83</td>
                                <td class="text-center">204.029.024.000</td>
                                <td class="text-center">174.319.959.967</td>
                                <td class="text-center">55</td>
                                <td class="text-center">98.066.295.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
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
@endsection
