{{-- @dd($laporan) --}}
@extends('templates.admin.main')
@section('customcss')
    @include('assets.css.shimmer')
    @include('assets.css.pagination-responsive')
@endsection
@section('mainComponent')
<div class="wrapper">
    <div class="content-wrapper">
        @component('components.admin.content-header')
            @slot('title', 'Laporan Data Kommas')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    @component('components.sislap.card-header')
                        @slot('template_excel', route('kommas-kbpp.template-excel'))
                        @slot('import_excel', route('kommas-kbpp.import-excel'))
                    @endcomponent
                    <div class="card-body">
                        @if(isset($laporan))
                        <div>
                            <h2 class="h4 text-center mb-3"><b>Preview Laporan Data Kommas</b></h2>
                            <div class="table-responsive mb-4">
                                <form action="{{ route('kommas-kbpp.store') }}"
                                      method="POST" onclick="disableSubmitButtonTemporarily()">
                                      @csrf
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                                <tr class="text-center bg-primary">
                                                    <th>No</th>
                                                    <th>Kesatuan</th>
                                                    <th>KBPP Polri</th>
                                                    <th>Senkom</th>
                                                    <th>Fkppi</th>
                                                </tr>
                                                @foreach ($laporan[0] as $key => $item)
                                                  @if($key !== 0)
                                                      <tr>
                                                          <th class="text-center">{{ $item[0] }}</th>
                                                          <td><textarea class="form-control" name="laporan[{{ $key }}][kesatuan]"
                                                                        id="laporan[{{ $key }}][kesatuan]" rows="4" maxlength="30">{{ $item[1] ?? '-' }}</textarea></td>
                                                          <td><textarea class="form-control" name="laporan[{{ $key }}][kbpp_polri]"
                                                                        id="laporan[{{ $key }}][kbpp_polri]" rows="4">{{ $item[2] ?? '-' }}</textarea></td>
                                                          <td><textarea class="form-control" name="laporan[{{ $key }}][senkom]"
                                                                        id="laporan[{{ $key }}][senkom]" rows="4" maxlength="100">{{ $item[3] ?? '-' }}</textarea></td>
                                                          <td><textarea class="form-control" name="laporan[{{ $key }}][fkppi]"
                                                                        id="laporan[{{ $key }}][fkppi]" rows="4" maxlength="255">{{ $item[4] ?? '-' }}</textarea></td>
                                                      </tr>
                                                  @endif
                                              @endforeach
                                          </tbody>
                                      </table>
                                      <div class="d-flex justify-content-center justify-content-md-end">
                                          <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                                      </div>
                                </form>
                            </div>
                        </div>
                        @else
                        <div>
                            <h2 class="h4 text-center"><b>Laporan Data KBPP POLRI</b></h2>
                            @component('components.sislap.form-search')
                                @slot('route', route('kommas-kbpp.export-excel'))
                            @endcomponent
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            <th class="align-middle" width="4%">No</th>
                                            <th class="align-middle" width="12%">Kesatuan</th>
                                            <th class="align-middle" width="16%">KBPP Polri</th>
                                            <th class="align-middle" width="8%">Senkom</th>
                                            <th class="align-middle" width="18%">FKPPI</th>
                                            <th class="align-middle" width="4%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content-wrapper"></tbody>
                                </table>
                            </div>
                            <div id="shimmer-wrapper">
                                <table class="table table-hover text-center">
                                    @component('components.shimmer.table-shimmer') @endcomponent
                                </table>
                            </div>
                            <div id="message-wrapper"></div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <ul id="paginator-wrapper" class="my-0"></ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<div class="modal fade" id="modalEdit" tabindex="-1"
         aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Laporan</h5>
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form-edit" class="form row">
                        @csrf
                        @method('PATCH')
                        <div class="form-group col-md-6">
                            <label for="kesatuan">Kesatuan</label>
                            <input type="text" id="kesatuan" name="kesatuan"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kbpp_polri">Kbpp Polri</label>
                            <input type="text" id="kbpp_polri" name="kbpp_polri"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="senkom">Senkom</label>
                            <input type="text" id="senkom" name="senkom"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fkppi">FKPPI</label>
                            <input type="text" id="fkppi" name="fkppi"
                                   class="form-control">
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <div>
                                    <button type="reset" class="btn btn-warning" data-toggle="modal"
                                            data-target="#modalEdit">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@include('assets.js.twbs-pagination')
@endsection
@section('customjs')
    <script src="{{ asset('js/component-with-pagination.js') }}"></script>
    <script>
        const urlDelete = "{{ route('kommas-kbpp.destroy', 'id') }}"

        const listLaporan = new ComponentWithPagination({
            contentWrapper: '#content-wrapper',
            messageWrapper: '#message-wrapper',
            paginator: '#paginator-wrapper',
            loader: '#shimmer-wrapper',
            searchState: {
                url: "{{ route('kommas-kbpp.search') }}",
                data: {}
            },
            content: (item, rowNumber) => {
                return `
                    <tr>
                        <th class="align-middle text-center">${ rowNumber }</th>
                        <td class="align-middle text-center">${ item.kesatuan }</td>
                        <td class="align-middle text-center">${ item.kbpp_polri }</td>
                        <td class="align-middle text-center">${ item.senkom }</td>
                        <td class="align-middle text-center">${ item.fkppi }</td>
                        <td class="align-middle text-center">
                            <button class="btn btn-edit btn-warning mb-1"
                                    data-toggle="modal" data-target="#modalEdit"
                                    onclick="insertValueToFormEdit({
                                        id: '${item.id}',
                                        kesatuan: '${item.kesatuan}',
                                        kbpp_polri: '${item.kbpp_polri}',
                                        senkom: '${item.senkom}',
                                        fkppi: '${item.fkppi}'
                                    })">
                                <i class="fa fa-edit"></i>
                            </button>
                            <form action="${ urlDelete.replace(/id$/, item.id) }" method="post" id="${ item.id }">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger btn-delete" type="submit" onclick="event.preventDefault(); deleteConfirm(${ item.id })">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                `
            }
        })

        document.getElementById('btn-search').addEventListener('click', (event) => {
            event.preventDefault()
            listLaporan.updateState('search', document.querySelector('input[name=search]').value)
            listLaporan.updateState('page', 1)
            listLaporan.fetchData()
        })

        const insertValueToFormEdit = ({id, kesatuan, kbpp_polri, senkom, fkppi}) => {
            const elFormEdit = document.getElementById('form-edit')
            const elBtnReset = elFormEdit.querySelector('button[type="reset"]')

            elBtnReset.dispatchEvent(new Event('click'))
            elFormEdit.setAttribute('action', route('kommas-kbpp.update', id))
            elFormEdit.querySelector('input[name="kesatuan"]').value    = kesatuan
            elFormEdit.querySelector('input[name="kbpp_polri"]').value  = kbpp_polri
            elFormEdit.querySelector('input[name="senkom"]').value      = senkom
            elFormEdit.querySelector('input[name="fkppi"]').value       = fkppi
        }
    </script>
@endsection
