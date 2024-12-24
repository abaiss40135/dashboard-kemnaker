<div class="box rounded-2xl">
    <div class="box-header flex b-0 justify-between items-center">
        <h2 class="mt-0">Capaian Indikator Pelaksanaan Anggaran Kemnaker</h2>
        <button onclick="resetTable2()" id="reset-table-2-btn" class="mt-2 mb-4 btn btn-warning hidden">Kembali ke Tampilan Awal</button>
    </div>
    <div class="box-body pt-0 summery-box">
        <div class="overflow-x-auto">
            <table class="table table-striped b-1 border-dark table-bordered w-full" id="table-2-parent">
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
                        <td class="text-center">
                            <span style="cursor: pointer; text-decoration: underline;" class="text-primary" onclick="changeTable2()">DITJEN PHI & JAMSOS TK</span>
                        </td>
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
            <table class="table table-striped b-1 border-dark table-bordered w-full hidden" id="table-2-child">
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
