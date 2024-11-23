<div>
    <div id="wrapper-data-pelaku-usaha"></div>
    <div id="wrapper-dasar-pembentukan-usaha"></div>
    <div id="wrapper-data-pengurus-saham"></div>
    <div id="wrapper-data-kegiatan-usaha"></div>
</div>
@push('scripts')
<script src="{{ asset('js/OSSConstant.js') }}"></script>
<script>
    (function () {
        let nib = "{{ $nib }}";
        let request = new XMLHttpRequest();
        request.open('GET', route('oss.inquery-nib', {nib: nib}), true);

        request.onload = async function () {
            if (this.status >= 200 && this.status < 400) {
                // Success!
                let resp = JSON.parse(this.response);
                if (resp.code === 200) {
                    let nib = resp.data;

                    let legalitas = '';
                    let penanggungJawab = '';
                    let kegiatanUsaha = '';
                    nib.legalitas.forEach((item, key) => {
                        legalitas += `
                        <tr>
                            <td class="text-center">${key + 1}</td>
                            <td class="text-bold">${OSSConstant.jenisAkta[item.jenis_legal]}</td>
                            <td><strong>${nib.no_pengesahan}</strong>
                                <br> Tanggal Pengesahan : ${nib.tgl_pengesahan}
                            </td>
                            <td><strong>${item.no_legal}</strong>
                                <br> Tanggal : ${item.tgl_legal}
                            </td>
                            <td><strong>${item.nama_notaris}</strong>
                                <br> Alamat Notaris : ${item.alamat_notaris}
                                <br> Telp : ${item.telepon_notaris}
                            </td>
                        </tr>`;
                    });
                    nib.penanggung_jwb.forEach((item, key) => {
                        let modal = nib.pemegang_saham.find(x => x.no_identitas_pemegang_saham === item.no_identitas_penanggung_jwb);
                        penanggungJawab += `
                        <tr class="text-center">
                            <td>${key + 1}</td>
                            <td>${item.jabatan_penanggung_jwb}</td>
                            <td>${item.nama_penanggung_jwb}</td>
                            <td>${item.npwp_penanggung_jwb}</td>
                            <td>${item.email_penanggung_jwb}</td>
                            <td>${OSSConstant.kodeNegara[item.negara_asal_penanggung_jwb]}</td>
                            <td>${item.flag_asing === '-' ? '-' : (item.flag_asing === 'Y' ? 'Luar Negeri' : 'Dalam Negeri')}</td>
                            <td>Rp${new Intl.NumberFormat('id-ID').format(modal == null ? 0 : modal['total_modal_pemegang'])}</td>
                        </tr>`;
                    });
                    for (const item of nib.data_proyek.filter(proyek => proyek.kbli === "80100")) {
                        const key = nib.data_proyek.filter(proyek => proyek.kbli === "80100").indexOf(item);
                        let bidang = nib.data_checklist.find(x => x.id_proyek === item.id_proyek);
                        kegiatanUsaha += `
                    <tr class="text-center" data-widget="expandable-table" aria-expanded="false">
                        <td>${key + 1}</td>
                        <td>${item.kbli}</td>
                        <td>${item.uraian_usaha}</td>
                        <td>${bidang == null ? '' : bidang['bidang_spesifik']}</td>
                    </tr>
                    <tr class="expandable-body d-none">
                        <td colspan="4">
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Alamat Usaha</label>
                                <span class="col-sm-9">: ${item.data_lokasi_proyek[0].alamat_usaha}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold"></label>
                                <span class="col-sm-9">: ${await OSSConstant.getAlamatDetail(item.data_lokasi_proyek[0].proyek_daerah_id)}</span>
                            </div>
                        </td>
                    </tr>`;
                    }

                    document.getElementById('wrapper-data-pelaku-usaha').innerHTML = `
                    <div class="card {{ $collapse }}">
                        <div class="card-header">
                            <h3 class="card-title">Data Pelaku Usaha</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Jenis Badan Usaha</label>
                                <span
                                    class="col-sm-9">: ${OSSConstant.jenisPerusahaan[nib.jenis_perseroan]}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Status Badan Hukum</label>
                                <span
                                    class="col-sm-9">: ${OSSConstant.statusBadanHukum[nib.status_penanaman_modal]}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Status Penanaman
                                    Modal</label>
                                <span
                                    class="col-sm-9">: ${OSSConstant.statusPermodalan[nib.status_penanaman_modal]}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Alamat Kantor</label>
                                <span class="col-sm-9">: ${nib.alamat_perseroan}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold"></label>
                                <span class="col-sm-9">: ${await OSSConstant.getAlamatDetail(nib.perseroan_daerah_id)}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">RT/RW</label>
                                <span class="col-sm-9">: ${nib.rt_rw_perseroan}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Kode Pos</label>
                                <span class="col-sm-9">: ${nib.kode_pos_perseroan}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Email Badan Usaha</label>
                                <span class="col-sm-9">: ${nib.email_perusahaan}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">NPWP Badan Usaha</label>
                                <span class="col-sm-9">: ${nib.npwp_perseroan}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pemroses</label>
                                <span class="col-sm-9">: ${nib.nama_user_proses}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Alamat Pemroses</label>
                                <span class="col-sm-9">: ${nib.alamat_user_proses}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Email Pemroses</label>
                                <span class="col-sm-9">: ${nib.email_user_proses}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nomor Telepon Pemroses</label>
                                <span class="col-sm-9">: ${nib.hp_user_proses}</span>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nomor Telepon Perseroan</label>
                                <span class="col-sm-9">: ${nib.nomor_telpon_perseroan}</span>
                            </div>
                        </div>
                    </div>`;
                    document.getElementById('wrapper-dasar-pembentukan-usaha').innerHTML = `
                    <div class="card {{ $collapse }}">
                        <div class="card-header">
                            <h3 class="card-title">Data Dasar Pembentukan Badan Usaha</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-striped table-primary w-100">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Dokumen</th>
                                        <th>Nomor</th>
                                        <th>Nomor Akta Pengesahan</th>
                                        <th>Notaris</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        ${legalitas}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;
                    document.getElementById('wrapper-data-pengurus-saham').innerHTML = `
                    <div class="card {{ $collapse }}">
                        <div class="card-header">
                            <h3 class="card-title">Data Pengurus dan Pemegang Saham</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-striped table-primary w-100">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jabatan</th>
                                        <th>Nama</th>
                                        <th>NPWP</th>
                                        <th>Email</th>
                                        <th>Negara Asal</th>
                                        <th>Tipe Jenis Modal</th>
                                        <th>Total Modal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        ${penanggungJawab}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;
                    document.getElementById('wrapper-data-kegiatan-usaha').innerHTML = `
                    <div class="card {{ $collapse }}">
                        <div class="card-header">
                            <h3 class="card-title">Data Kegiatan Usaha</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-striped table-primary w-100">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>KBLI</th>
                                        <th>Judul KBLI</th>
                                        <th>Ruang Lingkup</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        ${kegiatanUsaha}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;
                }
                loaderRotateContainer.style.display = "none";
            } else {
                // We reached our target server, but it returned an error
                loaderRotateContainer.style.display = "none";
            }
        };
        request.onerror = function () {
            // There was a connection error of some sort
            loaderRotateContainer.style.display = "none";
        };
        request.send();
    })();
</script>
@endpush
