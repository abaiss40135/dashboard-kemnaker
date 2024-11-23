function toggleJenisPendapat(context) {
    let checkPilihanPendapat = $(".checkbox-pendapat-warga:checked").length;
    if(!checkPilihanPendapat) {
        context.prop('checked', true);
        swalWarning('Anda harus memilih setidaknya satu jenis pendapat warga');
        return false;
    }

    let jenis = context.val();
    let checked = $(context).is(':checked');
    let wrapper = document.getElementById('wrapper-' + jenis + '-warga');
    if (checked) {
        wrapper.classList.remove('d-none');
    } else {
        wrapper.classList.add('d-none');
    }
}
// anggota keluarga
const parent = document.querySelector('.anggota-keluarga')
const jumlahKeluarga = document.querySelector('#jumlah_anggota_keluarga_serumah')


let i = jumlahKeluarga ? parseInt(jumlahKeluarga.value) :  0;

const add = () => {
    i++

    let el =  ` <div class="mb-4">
                <span><ul><li><h5>Anggota Keluarga ${i}</h5></li></ul></span>
                <hr>
                <div class=" row">
                        <br>
                        <div class="col-md">
                            <label for="nama_penghuni_rumah_[${i}]" class="form-label mt-3">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama Anggota Keluarga"
                                id="nama_penghuni_rumah_${i}" name="anggota[${i}][nama]" aria-describedby="emailHelp">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <label for="" class="mt-3">Jenis Kelamin</label>
                            <br>

                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="anggota[${i}][jenis_kelamin]" id="laki_laki_penghuni_rumah_${i}"
                                    value="laki-laki">
                                <label class="form-check-label" for="laki_laki_penghuni_rumah_${i}">Laki - Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="anggota[${i}][jenis_kelamin]" id="perempuan_penghuni_rumah_${i}"
                                    value="perempuan">
                                <label class="form-check-label" for="perempuan_penghuni_rumah_${i}">Perempuan</label>
                            </div>
                        </div>

                        <div class="col-md">
                            <label for="" class="mt-3 mb-2">Hubungan</label>
                            <div>
                                <select id="hubungan" name="anggota[${i}][hubungan]" class="form-select"
                                    onchange="lainnya(this, 'hubungan')">
                                    <option value="">-- pilih hubungan --</option>
                                    <option value="Istri" {{ old('hubungan') == 'Istri' ? 'selected' : '' }} >Istri</option>
                                    <option value="Anak kandung">Anak Kandung</option>
                                    <option value="Anak Tiri">Anak Tiri</option>
                                    <option value="Orang Tua - Ibu">Orang Tua - Ibu</option>
                                    <option value="Orang Tua - Bapak">Orang Tua - Bapak</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <label for="nomor_telepon_${i}" class="form-label mt-3">Nomor Telepon</label>
                            <input type="tel" maxlength="12" class="form-control"
                                placeholder="masukkan nomor yang dapat dihubungi" name="anggota[${i}][nomor_telepon]" id="nomor_telepon_${i}"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="col-md">
                            <label for="tempat_lahir_penghuni_rumah_${i}" class="mt-3 mb-2">Tempat Lahir</label>
                            <input type="text" class="form-control" name="anggota[${i}][tempat_lahir]" id="tempat_lahir_penghuni_rumah_${i}"
                                placeholder="masukkan tempat lahir" >

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <label for="tanggal_lahir_${i}" class="form-label mt-3">Tanggal Lahir</label>
                            <input type="date" name="anggota[${i}][tanggal_lahir]" class="form-control" id="tanggal_lahir_${i}"
                                aria-describedby="emailHelp">
                        </div>

                        <div class="col-md">
                            <label for="" class="mt-3 mb-2">Status Pekerjaan</label>
                            <select class="form-select" id="status_pekerjaan_${i}" name="anggota[${i}][status_pekerjaan]" aria-label="Default select example">
                                <option value="">-- pilih status pekerjaan --</option>
                                <option value="sudah bekerja">Sudah Bekerja</option>
                                <option value="belum bekerja">Belum Bekerja</option>
                                <option value="sekolah">Sekolah</option>
                            </select>
                        </div>
                    </div>


            </div> `


    parent.innerHTML += el;
    jumlahKeluarga.value = parseInt(jumlahKeluarga.value) + 1;

}

const remove = () => {

    parent.removeChild(parent.lastElementChild);
    jumlahKeluarga.value = parseInt(jumlahKeluarga.value) - 1;
    i--
}
const removeParent = (el , current) =>  {
    pendapat_index > 0 ? pendapat_index-- : '';
    current.parentElement.querySelector('input').value = pendapat_index
    el.removeChild(el.lastElementChild);

}



// option for every select element
const lainnya = (el , context, name = context) => {
   if(el.value === "lainnya"){

        el.parentElement.innerHTML = `<input type="text" placeholder="masukkan ${context}" id=${name} class="form-control"
                                        name=${name}>`
   }
}



let pendapat_index = 0;
let exist = false;

function addPendapat(el){
    let parent = document.querySelector('#pendapat__warga');
    pendapat_index < 3 ? pendapat_index++ : '';
    el.parentElement.querySelector('input').value = pendapat_index;
    const index = pendapat_index

    if(parent.childElementCount++ < 3){

        parent.innerHTML += `
        <div>
            <div class="col-md-6 my-3" >
                    <label class="form-label">Jenis Pendapat Warga</label>
                    <select name="pendapat[${index}][jenis_pendapat]" id="jenis_pendapat_warga_${index}" onchange="pendapatWarga(this , ${index})"
                            class="form-select ">
                        <option value=""> -- pilih jenis pendapat --</option>
                        <option id="keluhan" value="keluhan">Keluhan</option>
                        <option id="laporan_informasi" value="laporan informasi">Laporan Informasi</option>
                        <option id="harapan" value="harapan">Harapan</option>
                    </select>
                </div>

                <div id="pilihan_${index}"> </div>

            </div>
        `
    }
}
function pendapatWarga(el, index) {
    const pendapat = el
    const parent = el.parentElement.parentElement.querySelector(`#pilihan_${index}`)

    let keluhan  = false;
    let laporan_informasi  = false;
    let harapan  = false;

    const selected = pendapat.options[pendapat.selectedIndex].value
    if (selected === 'keluhan' ) {
        keluhan = true;
        parent.innerHTML = `<section id="bidang_keluhan_${index}">
                        <div class="col-md-12">
                            <label for="bidang_pendapat_warga" class="mt-3 mb-2">Bidang Keluhan</label>
                            <select class="form-select my-3"
                                    name="pendapat[${index}][bidang_pendapat]" id="bidang-keluhan" >
                                <option selected > -- Pilih Bidang Keluhan --</option>
                                <option value="Politik">Politik</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosial">Sosial</option>
                                <option value="Budaya">Budaya</option>
                                <option value="Agama">Agama</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Pembangunan">Pembangunan</option>
                                <option value="Keamanan">Keamanan</option>
                                <option value="Pelayanan Kepolisian">Pelayanan Kepolisian</option>
                                <option value="Pelayanan Publik">Pelayanan Publik</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="uraian-keluhan">Uraian Keluhan Warga</label>
                            <textarea style="height: 200px;" name="pendapat[${index}][uraian]" id="uraian-keluhan"
                                    class="form-control "
                                    placeholder="uraian singkat keluhan warga" ></textarea>
                        </div>

                    </section>`

    }
    if (selected === 'laporan informasi') {
        laporan_informasi = true;

        parent.innerHTML = `
             <section id="bidang_informasi_${index}">
                        <div class="col-md-12 mt-3">
                            <label class="form-label">Bidang Informasi</label><br>
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <input name="pendapat[${index}][bidang_pendapat]" type="radio"
                                           id="politik" value="politik" >
                                    <label for="politik">Politik</label>
                                </div>

                                <div>
                                    <input name="pendapat[${index}][bidang_pendapat]" type="radio"
                                           id="sosbud" value="sosbud" >
                                    <label for="sosbud">Sosbud</label>
                                </div>

                                <div>
                                    <input name="pendapat[${index}][bidang_pendapat]" type="radio"
                                           id="ekonomi" value="ekonomi" >
                                    <label for="ekonomi">Ekonomi</label>
                                </div>
                                <div>
                                    <input name="pendapat[${index}][bidang_pendapat]" type="radio"
                                           id="keamanan" value="keamanan" >
                                    <label for="keamanan">Keamanan</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">

                            <div class="row mt-4 " id="wrapper-nilai-informasi">
                                <div class="col-md" >
                                    <label class="form-label">Nilai Informasi</label>
                                    <div class="d-flex justify-content-between" style="max-width: 600px">
                                        <span>
                                            <input {{ old('pendapat.${index}.nilai_informasi_abjad') == 'A' ? 'checked' : '' }} type="radio" name="pendapat[${index}][nilai_informasi_abjad]" value="A">
                                            <label>A</label>
                                        </span>
                                        <span>
                                            <input {{ old('pendapat.${index}.nilai_informasi_abjad') == 'B' ? 'checked' : '' }} type="radio" name="pendapat[${index}][nilai_informasi_abjad]" value="B">
                                            <label>B</label>
                                        </span>
                                        <span>
                                            <input {{ old('pendapat.${index}.nilai_informasi_abjad') == 'C' ? 'checked' : '' }} type="radio" name="pendapat[${index}][nilai_informasi_abjad]" value="C">
                                            <label>C</label>
                                        </span>
                                        <span>
                                            <input {{ old('pendapat.${index}.nilai_informasi_abjad') == 'D' ? 'checked' : '' }} type="radio" name="pendapat[${index}][nilai_informasi_abjad]" value="D">
                                            <label>D</label>
                                        </span>

                                    </div>
                                    <div class="d-flex justify-content-between" style="max-width: 600px">
                                        <span>
                                            <input {{ old('pendapat.${index}.nilai_informasi_angka') == '1' ? 'checked' : '' }} type="radio" name="pendapat[${index}][nilai_informasi_angka]" value="1">
                                            <label>1</label>
                                        </span>
                                        <span>
                                            <input {{ old('pendapat.${index}.nilai_informasi_angka') == '2' ? 'checked' : '' }} type="radio" name="pendapat[${index}][nilai_informasi_angka]" value="2">
                                            <label>2</label>
                                        </span>
                                        <span>
                                            <input {{ old('pendapat.${index}.nilai_informasi_angka') == '3' ? 'checked' : '' }} type="radio" name="pendapat[${index}][nilai_informasi_angka]" value="3">
                                            <label>3</label>
                                        </span>
                                        <span>
                                            <input {{ old('pendapat.${index}.nilai_informasi_angka') == '4' ? 'checked' : '' }} type="radio" name="pendapat[${index}][nilai_informasi_angka]" value="4">
                                            <label>4</label>
                                        </span>

                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-12">
                            <label for="uraian-informasi">Uraian Informasi Warga</label>
                            <textarea style="height: 200px;" name="pendapat[${index}][uraian]" id="uraian-informasi"
                                    class="form-control "
                                    placeholder="uraian singkat Informasi warga" ></textarea>
                        </div>
                    </section>
        `
    }
    if (selected === 'harapan') {
        harapan = true;
         parent.innerHTML = `
                        <section id="bidang_harapan_${index}">
                        <div class="col-md-12">
                            <label for="bidang-harapan" class="mt-3 mb-2">Bidang Harapan</label>
                            <select class="form-select mb-3"
                                    name="pendapat[${index}][bidang_pendapat]" id="bidang-harapan">
                                <option selected > -- Pilih Bidang Harapan --</option>
                                <option value="Politik">Politik</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosial">Sosial</option>
                                <option value="Budaya">Budaya</option>
                                <option value="Agama">Agama</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Pembangunan">Pembangunan</option>
                                <option value="Keamanan">Keamanan</option>
                                <option value="Pelayanan Kepolisian">Pelayanan Kepolisian</option>
                                <option value="Pelayanan Publik">Pelayanan Publik</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="uraian-harapan">Uraian Harapan Warga</label>
                            <textarea style="height: 200px;" name="pendapat[${index}][uraian]" id="uraian-harapan"
                                    class="form-control "
                                    placeholder="uraian singkat Harapan warga" ></textarea>
                        </div>

                    </section>
        `
    }







}
