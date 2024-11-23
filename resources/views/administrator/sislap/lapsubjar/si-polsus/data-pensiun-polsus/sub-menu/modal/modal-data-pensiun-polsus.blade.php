<!-- Modal -->
<div class="modal fade" id="dataPensiunModal" tabindex="-1" role="dialog" aria-labelledby="dataPensiunModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Polsus Pensiun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center preloader">
                    <img class="img-fluid" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
                </div>
                <div id="data-polsus">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const preLoader = document.querySelector('.preloader')
        const modalDataPolsus = document.querySelector('#data-polsus')

        const tampilkanDataPolsus = kota => {
            modalDataPolsus.innerHTML = ''
            preLoader.classList.remove('d-none')

            axios.get(route('{{$route}}', kota))
                .then(res => res.data)
                .then(data => {

                    let result = ''
                    data.forEach(polsus => {
                        result+= `
                            <div class="d-lg-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-center">
                                    <img width="200px" class="img-thumbnail rounded" src="${polsus.foto_profile}" alt="Foto Profile">
                                </div>
                                <div class="text-center text-md-left mt-3">
                                    <p>Nama: ${polsus.nama}</p>
                                    <p>Pangkat: ${polsus.pangkat}-${polsus.golongan}</p>
                                    <p>NIP: ${polsus.no_nip}</p>
                                    <p>No. Handphone: ${polsus.no_hp}</p>
                                </div>
                            </div>
                            <hr>
                        `
                    })

                    preLoader.classList.add('d-none')
                    modalDataPolsus.innerHTML = result
                })
        }
    </script>
@endpush
