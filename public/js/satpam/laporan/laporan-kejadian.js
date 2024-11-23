const jumlahSaksi = document.querySelector('#jumlah_saksi')
const saksi = document.querySelector('#saksi')

let i = parseInt(jumlahSaksi.value);

const add = () => {
    i++
  
    let el =  ` <div>
                <div class=" row">
                    <br>
                    <div class="col-md">
                        <label for="nama_saksi[${i}]" class="form-label mt-3">Nama</label>
                        <input type="text" class="form-control" placeholder="Nama Saksi"
                            id="nama_saksi${i}" name="saksi[${i}][nama]" aria-describedby="emailHelp"required>
                    </div>
                        <div class="col-md">
                        <label for="umur_saksi[${i}]" class="form-label mt-3">Umur</label>
                        <input type="text" class="form-control" placeholder="Umur Saksi"
                            id="umur_saksi${i}" name="saksi[${i}][umur]" aria-describedby="emailHelp" required>
                    </div>
                </div>

                <div class=" row mt-3">
                    <br>
                    <div class="col-md">
                        <label for="pekerjaan_saksi[${i}]" class="form-label mt-3">Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="Pekerjaan Saksi"
                            id="pekerjaan_saksi${i}" name="saksi[${i}][pekerjaan]" aria-describedby="emailHelp" required>
                    </div>
                        <div class="col-md">
                        <label for="nomor_telepon_saksi[${i}]" class="form-label mt-3">Nomor Telepon</label>
                        <input type="tel" class="form-control" placeholder="Nomor Telepon Saksi"
                            id="nomor_telepon_saksi${i}" name="saksi[${i}][nomor_telepon]" aria-describedby="emailHelp" required>
                    </div>
                </div>
                <div class=" row mt-3">
                    <br>
                    <div class="col-md">
                        <label for="alamat_saksi${i}">Alamat Saksi</label>
                        <textarea style="height: 200px;" name="saksi[${i}][alamat]" id="alamat_saksi${i}"
                            class="form-control mt-3 " placeholder="masukkan Alamat Saksi" required></textarea>
                    </div>

                </div>
                    
                    
                    <button type="button" class="d-block " style="margin-top:20px;margin-left:auto; padding: 7px 18px ; background: #F92B13; color: #fff;"
                    onclick="remove()"><i class="fas fa-minus" style="font-size: 15px; "></i></button>
            </div> `

    
    saksi.innerHTML += el;
    jumlahSaksi.value = parseInt(jumlahSaksi.value) + 1;

}


const remove = () => {
    
    saksi.removeChild(saksi.lastElementChild);
    jumlahSaksi.value = parseInt(jumlahSaksi.value) - 1;
    i--
}

// const inputValue = (el) => {
//         el.parentElement.querySelector('.form-control').placeholder = el.files[0].name;
    
// }
