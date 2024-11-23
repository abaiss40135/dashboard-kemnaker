<div class="modal fade" id="editDataSenpiAmunisiModal" tabindex="-1" aria-labelledby="editDataSenpiAmunisiModalLabel" aria-hidden="true">
    <form class="form-edit-data-senpi-amunisi" action="#" method="post">
        @csrf
        @method('PATCH')

        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataSenpiAmunisiModalLabel">Form Edit Data Senpi dan Amunisi Polsus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <p class="text-center form-edit-loading-image">
                            <img src="https://s3.scoopwhoop.com/anj/loading/594155876.gif" alt="loading gif" width="400px">
                        </p>
                        <div class="wrapper-input-form-edit d-none">
                            <table class="table table-bordered table-info table-lg">
                                <tr>
                                    <th>Provinsi</th>
                                    <th>Kabupaten/Kota</th>
                                    <th class="th-kategori-title">Kategori</th>
                                </tr>
                                <tr>
                                    <td class="value-table-edit-provinsi">Banten</td>
                                    <td class="value-table-edit-kotakab">Kabupaten Lebak</td>
                                    <td class="value-table-edit-kategori">Senpi</td>
                                </tr>
                            </table>

                            <div class="card shadow-md">
                                <div class="card-header">
                                    Data Senpi
                                </div>
                                <div class="card-body body-senpi">

                                </div>
                            </div>
                            <hr>
                            <div class="card shadow-md">
                                <div class="card-header">
                                    Data Amunisi
                                </div>
                                <div class="card-body body-amunisi">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
            </div>
        </div>
    </form>
</div>

    <script>
        const editSenpiAmunisi = ({jenis_polsus, id_senpi, id_amunisi}) => {
            $(".form-edit-data-senpi-amunisi").attr('action', route("input-data-senpi-amunisi.update", {
                jenisPolsus: jenis_polsus,
                dataSenpi: id_senpi,
                dataAmunisi: id_amunisi
            }));

            $(".form-edit-loading-image").removeClass('d-none');
            $(".wrapper-input-form-edit").addClass('d-none');

            const request = fetch(route("input-data-senpi-amunisi.detail-data", {
                dataSenpi: id_senpi,
                dataAmunisi: id_amunisi
            }))
                .then(response => response.json())
                .then(data => {
                    $(".form-edit-loading-image").addClass('d-none');
                    $(".wrapper-input-form-edit").removeClass('d-none');

                    $(".value-table-edit-provinsi").html(data.provinsi);
                    $(".value-table-edit-kotakab").html(data.kabupaten);


                    const jenisPolsusHasKategori = ["polsuspas", "polsuska", "polhut_lhk", "polhut_perhutani"];
                    if(jenisPolsusHasKategori.includes(jenis_polsus)) {
                        let kategori = '';
                        switch (jenis_polsus) {
                            case 'polsuspas':
                                kategori = 'Nama Lapas';
                                break;
                            case 'polsuska':
                                kategori = 'Nama Daops';
                                break;
                            case 'polhut_lhk':
                                kategori = 'Nama Balai';
                                break;
                            case 'polhut_perhutani':
                                kategori = 'Nama Devisi Regional';
                                break;
                        }
                        $(".th-kategori-title").html(kategori);
                        $(".value-table-edit-kategori").html(data.kategori);
                    } else {
                        $(".th-kategori-title").addClass('d-none');
                        $(".value-table-edit-kategori").addClass('d-none');
                    }


                    let htmlForm = '';
                    let key = 1;
                    data.senpi.forEach(senpi => {
                        htmlForm += `
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="senpi_genggam">Senpi Genggam</label>
                                    <input required value="${senpi.genggam}" id="senpi_genggam" name="${senpi.id}_senpi_genggam" type="number" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label for="senpi_panjang">Senpi Panjang</label>
                                    <input required value="${senpi.panjang}" id="senpi_panjang" name="${senpi.id}_senpi_panjang" type="number" class="form-control">
                                </div>
                                <small class="d-block ml-2">Laporan ke-${key}, dibuat oleh operator polsus dengan email <span class="text-decoration-underline text-info">${senpi.email}</span> pada: <span class="text-primary">${senpi.created_at}</span></small>
                            </div>
                            <hr>
                        `;
                        key++;
                    })
                    $(".body-senpi").html(htmlForm)

                    htmlForm = '';
                    key = 1;

                    data.amunisi.forEach(amunisi => {
                        htmlForm += `
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="amunisi_genggam">Amunisi Genggam</label>
                                    <input required value="${amunisi.genggam}" id="amunisi_genggam" name="${amunisi.id}_amunisi_genggam" type="number" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label for="amunisi_panjang">Amunisi Panjang</label>
                                    <input required value="${amunisi.panjang}" id="amunisi_panjang" name="${amunisi.id}_amunisi_panjang" type="number" class="form-control">
                                </div>
                                <small class="d-block ml-2">Laporan ke-${key}, dibuat oleh operator polsus dengan email <span class="text-decoration-underline text-info">${amunisi.email}</span> pada: <span class="text-primary">${amunisi.created_at}</span></small>
                            </div>
                            <hr>
                        `;
                        key++;
                    })
                    $(".body-amunisi").html(htmlForm)
                })
                .catch(error => console.error(error))

        };
    </script>
