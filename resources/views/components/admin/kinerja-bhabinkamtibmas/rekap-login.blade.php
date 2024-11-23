@include('components.admin.kinerja-bhabinkamtibmas.bar-chart-login')

<div class="card mt-4">
    <div class="header">
        Presentase Ketercapaian Per Polda
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                    onclick="angleIcon(this)">
                <i class="fas fa-angle-down" style="font-size: 1.4em"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        @if(auth()->user()->haveRoleID(\App\Models\User::OPERATOR_BHABINKAMTIBMAS_POLDA))
            <div class="mb-4">
                <a href="{{route("perubahan-jumlah-bhabinkamtibmas.index")}}" class="btn btn-primary">Update Jumlah Bhabinkamtibmas</a>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center">
                <thead>
                <tr>
                    <th class="align-middle">No</th>
                    <th class="align-middle">Polda</th>
                    <th class="align-middle">Jumlah Bhabinkamtibmas</th>
                    <th class="align-middle">Bhabinkamtibmas Sudah Login</th>
                    <th class="align-middle">Presentase</th>
                    <th class="align-middle">Aksi</th>
                </tr>
                </thead>
                <tbody id="table-presentase"></tbody>
            </table>
            <div class="text-center preloader">
                <img class="img-fluid" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">
            </div>
        </div>
    </div>
</div>

@push('modals')
    <!-- model filter export uraian laporan -->
    <div class="modal fade" id="modalFilterExportUraian"
         data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modalFilterExportUraianLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-center" id="modalFilterExportUraianLabel">Pilih Waktu dan Kata Kunci Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" class="form" id="form-filter-export-uraian" method="POST" onsubmit="disableSubmitButtonTemporarily(this);">
                        @csrf
                        <input type="hidden" name="start_created_at">
                        <input type="hidden" name="end_created_at">
                        <div class="form-group">
                            <label for="datetime-filter-export-uraian">Rentang Waktu Laporan</label>
                            <input type="text" id="datetime-filter-export-uraian" class="datetimepicker form-control">
                        </div>
                        <div class="form-group">
                            <label for="katakunci-filter-export-uraian">Kata Kunci</label>
                            <input type="text" id="katakunci-filter-export-uraian"
                                   placeholder="Kata Kunci laporan"
                                   name="keyword" class="form-control">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Ekspor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal filter export akumulasi laporan -->
    <div class="modal fade" id="modalFilterExportAkumulasi"
         data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modalFilterExportAkumulasiLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-center" id="modalFilterExportAkumulasiLabel">Pilih Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" class="form" id="form-filter-export-akumulasi" method="POST" onsubmit="disableSubmitButtonTemporarily(this)">
                        @csrf
                        <input type="hidden" name="province_code">
                        <div class="form-group">
                            <label for="periode-filter-export-akumulasi">Periode</label>
                            <select class="form-control form-select" name="periode" id="periode-filter-export-akumulasi">
                                <option value="" selected disabled>Pilih Periode</option>
                                @foreach($periods as $period)
                                    <option value="{{$period['id']}}">{{$period['text']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Ekspor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script>
        const initTableRekapitulasi = (data) => {
            for (let i = 0; i < data.loginPerPolda.length; i++) {
                let row = document.createElement('tr');
                row.innerHTML = (
                   `
                    <td>${i + 1}</td>
                    <td>${data.listPolda[i]}</td>
                    <td>${data.jumlahBhabinPerPolda[i]}</td>
                    <td>${data.loginPerPolda[i]}</td>
                    <td>${((data.loginPerPolda[i] / data.jumlahBhabinPerPolda[i]) * 100).toFixed(2)}%</td>
                    <td>
                        <button type="button" class="btn btn-success"
                        onclick="setModalFilterisasiEksporAkumulasi('${data.province_code[i]}')">
                            <i class="fas fa-file-alt"></i> Akumulasi
                        </button>
                        <button type="button" class="btn btn-success"
                        onclick="setModalFilterisasiEksporUraian('${data.listPolda[i]}')">
                            <i class="fas fa-file-alt"></i> Laporan
                        </button>
                    </td>`
                )
                tablePresentase.append(row)
            }
        }

        axios.post(route('master-bhabin.chart'))
            .then((res) => res.data).then((data) => {
                document.querySelectorAll('.preloader').forEach((loader) => {
                    loader.classList.add('d-none')
                })

                initChartRekapitulasi(data)
                initTableRekapitulasi(data)
            }).catch((err) => {
                console.error(err)
            })

        const tablePresentase = document.querySelector('#table-presentase')

        const modalFilterisasiEksporUraian = $('#modalFilterExportUraian');
        const modalFilterisasiEksporAkumulasi = $('#modalFilterExportAkumulasi');

        function initDatetimePickerFormFilter(){
            const {ranges, startDate, ...datePickerConfig} = datetimeSetup;
            datePickerConfig.timePicker = true;
            datePickerConfig.timePicker24Hour = true;
            datePickerConfig.locale.format = 'DD/MM/YYYY HH:mm';
            $('.datetimepicker').daterangepicker(datePickerConfig , function (start, end, label) {
                $('#form-filter-export-uraian').find('input[name="start_created_at"]').val(start.format('YYYY-MM-DD HH:mm:ss'));
                $('#form-filter-export-uraian').find('input[name="end_created_at"]').val(end.format('YYYY-MM-DD HH:mm:ss'));
            });
        }

        modalFilterisasiEksporUraian.on('hidden.bs.modal', function (e) {
            resetForm($('#form-filter-export-uraian'));
        })

        modalFilterisasiEksporAkumulasi.on('hidden.bs.modal', function (e) {
            resetForm($('#form-filter-export-akumulasi'));
        })

        modalFilterisasiEksporUraian.on('show.bs.modal', function (e) {
            if (navigator.userAgent.toLowerCase().indexOf('firefox') !== -1) {
                $.fn.modal.Constructor.prototype.enforceFocus = function (){};
            }
        })

        modalFilterisasiEksporUraian.on('shown.bs.modal', function (e) {
            // this timepicker bugged in firefox, TODO
            if (navigator.userAgent.toLowerCase().indexOf('firefox') !== -1) {
                $.fn.modal.Constructor.prototype.enforceFocus = function (){};
            }
            initDatetimePickerFormFilter()
        })


        function setModalFilterisasiEksporUraian(polda) {
            if (polda !== null && polda !== 'polda') {
                modalFilterisasiEksporUraian.modal(modalOptions);
                $('#form-filter-export-uraian').attr('action', route('master-bhabin.excel.uraian-informasi', {polda: polda}));
            }
        }

        function setModalFilterisasiEksporAkumulasi(code) {
            if (code !== null) {
                $('#form-filter-export-akumulasi input[name=province_code]').val(code);
                $('#form-filter-export-akumulasi').attr('action', route('kinerja-bhabinkamtibmas.export-akumulasi'));
                modalFilterisasiEksporAkumulasi.modal(modalOptions);
            }
        }

        (function () {
            let today = moment().format('YYYY-MM-DD');
            $('#form-filter-export-uraian').find('input[name="start_date"]').val(today + ' 00:00:00');
            $('#form-filter-export-uraian').find('input[name="end_date"]').val(today + ' 23:59:59');
        })();
    </script>
@endpush
