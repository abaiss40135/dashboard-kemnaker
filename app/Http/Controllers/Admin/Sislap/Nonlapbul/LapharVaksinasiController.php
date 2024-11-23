<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Nonlapbul\Lapharvaksinasi\LapharVaksinasi as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Nonlapbul\LapharVaksinasi;
use App\Services\Sislap\Nonlapbul\LapharVaksinasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class LapharVaksinasiController extends Controller
{
    protected $model = LapharVaksinasi::class;

    private $lapharVaksinasiService;

    public function __construct(LapharVaksinasiService $lapharVaksinasiService)
    {
        $this->lapharVaksinasiService = $lapharVaksinasiService;
    }

    public function index() {
        return view('administrator.sislap.nonlapbul.laphar-vaksinasi.index', [
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request) {
        $user   = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level  = end($levels);

        $personel   = $user->personel;
        $satuan     = $personel->satuan7 ??
                      $personel->satuan6 ??
                      $personel->satuan5 ??
                      $personel->satuan4 ??
                      $personel->satuan3 ??
                      $personel->satuan2 ??
                      $personel->satuan1;
        $kode_satuan = preg_match('/\d*$/', $satuan, $out) ? $out[0] : null;

        try {
            DB::transaction(function () use ($level, $user, $request, $kode_satuan) {
                foreach($request->laporan as $item) {
                    $laporan = LapharVaksinasi::create([
                        'kab_kota' => $item['kab_kota'],
                        'vaksinasi_sdm_kesehatan' => $item['vaksinasi_sdm_kesehatan'],
                        'sdm_kesehatan_divaksin_cov1' => $item['sdm_kesehatan_divaksin_cov1'],
                        'sdm_kesehatan_vaksin_cov1' => $item['sdm_kesehatan_vaksin_cov1'],
                        'sdm_kesehatan_divaksin_cov2' => $item['sdm_kesehatan_divaksin_cov2'],
                        'sdm_kesehatan_vaksin_cov2' => $item['sdm_kesehatan_vaksin_cov2'],
                        'sdm_kesehatan_divaksin_cov3' => $item['sdm_kesehatan_divaksin_cov3'],
                        'sdm_kesehatan_vaksin_cov3' => $item['sdm_kesehatan_vaksin_cov3'],
                        'vaksinasi_lansia_divaksin_cov1' => $item['vaksinasi_lansia_divaksin_cov1'],
                        'vaksinasi_lansia_vaksin_cov1' => $item['vaksinasi_lansia_vaksin_cov1'],
                        'vaksinasi_lansia_divaksin_cov2' => $item['vaksinasi_lansia_divaksin_cov2'],
                        'vaksinasi_lansia_vaksin_cov2' => $item['vaksinasi_lansia_vaksin_cov2'],
                        'vaksinasi_yanpublik_divaksin_cov1' => $item['vaksinasi_yanpublik_divaksin_cov1'],
                        'vaksinasi_yanpublik_vaksin_cov1' => $item['vaksinasi_yanpublik_vaksin_cov1'],
                        'vaksinasi_yanpublik_divaksin_cov2' => $item['vaksinasi_yanpublik_divaksin_cov2'],
                        'vaksinasi_yanpublik_vaksin_cov2' => $item['vaksinasi_yanpublik_vaksin_cov2'],
                        'mu_divaksin_cov1' => $item['mu_divaksin_cov1'],
                        'mu_vaksin_cov1' => $item['mu_vaksin_cov1'],
                        'mu_divaksin_cov2' => $item['mu_divaksin_cov2'],
                        'mu_vaksin_cov2' => $item['mu_vaksin_cov2'],
                        'remaja_divaksin_cov1' => $item['remaja_divaksin_cov1'],
                        'remaja_vaksin_cov1' => $item['remaja_vaksin_cov1'],
                        'remaja_divaksin_cov2' => $item['remaja_divaksin_cov2'],
                        'remaja_vaksin_cov2' => $item['remaja_vaksin_cov2'],
                        'gr_divaksin_cov1' => $item['gr_divaksin_cov1'],
                        'gr_vaksin_cov1' => $item['gr_vaksin_cov1'],
                        'gr_divaksin_cov2' => $item['gr_divaksin_cov2'],
                        'gr_vaksin_cov2' => $item['gr_vaksin_cov2'],
                        'jumlah' => $item['jumlah'],
                        'user_id'               => $user->id,
                        'kode_satuan'           => $kode_satuan
                    ]);
                    if ($level === 'polda') {
                        $laporan->approvals()->create([
                            'keterangan'        => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level'             => $level,
                        ]);
                    }
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('laphar-vaksinasi.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id) {
        try {
            LapharVaksinasi::find($id)->update([
                'kab_kota'                            => $request->kab_kota,
                'vaksinasi_sdm_kesehatan'             => $request->vaksinasi_sdm_kesehatan,
                'sdm_kesehatan_divaksin_cov1'         => $request->sdm_kesehatan_divaksin_cov1,
                'sdm_kesehatan_vaksin_cov1'           => $request->sdm_kesehatan_vaksin_cov1,
                'sdm_kesehatan_divaksin_cov2'         => $request->sdm_kesehatan_divaksin_cov2,
                'sdm_kesehatan_vaksin_cov2'           => $request->sdm_kesehatan_vaksin_cov2,
                'sdm_kesehatan_divaksin_cov3'         => $request->sdm_kesehatan_divaksin_cov3,
                'sdm_kesehatan_vaksin_cov3'           => $request->sdm_kesehatan_vaksin_cov3,
                'vaksinasi_lansia_divaksin_cov1'      => $request->vaksinasi_lansia_divaksin_cov1,
                'vaksinasi_lansia_vaksin_cov1'        => $request->vaksinasi_lansia_vaksin_cov1,
                'vaksinasi_lansia_divaksin_cov2'      => $request->vaksinasi_lansia_divaksin_cov2,
                'vaksinasi_lansia_vaksin_cov2'        => $request->vaksinasi_lansia_vaksin_cov2,
                'vaksinasi_yanpublik_divaksin_cov1'   => $request->vaksinasi_yanpublik_divaksin_cov1,
                'vaksinasi_yanpublik_vaksin_cov1'     => $request->vaksinasi_yanpublik_vaksin_cov1,
                'vaksinasi_yanpublik_divaksin_cov2'   => $request->vaksinasi_yanpublik_divaksin_cov2,
                'vaksinasi_yanpublik_vaksin_cov2'     => $request->vaksinasi_yanpublik_vaksin_cov2,
                'mu_divaksin_cov1'                    => $request->mu_divaksin_cov1,
                'mu_vaksin_cov1'                      => $request->mu_vaksin_cov1,
                'mu_divaksin_cov2'                    => $request->mu_divaksin_cov2,
                'mu_vaksin_cov2'                      => $request->mu_vaksin_cov2,
                'remaja_divaksin_cov1'                => $request->remaja_divaksin_cov1,
                'remaja_vaksin_cov1'                  => $request->remaja_vaksin_cov1,
                'remaja_divaksin_cov2'                => $request->remaja_divaksin_cov2,
                'remaja_vaksin_cov2'                  => $request->remaja_vaksin_cov2,
                'gr_divaksin_cov1'                    => $request->gr_divaksin_cov1,
                'gr_vaksin_cov1'                      => $request->gr_vaksin_cov1,
                'gr_divaksin_cov2'                    => $request->gr_divaksin_cov2,
                'gr_vaksin_cov2'                      => $request->gr_vaksin_cov2,
                'jumlah'                              => $request->jumlah,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('laphar-vaksinasi.index');
    }

    public function destroy($id) {
        try {
            LapharVaksinasi::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->lapharVaksinasiService, true), 'laporan harian vaksinasi.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.nonlapbul.laphar-vaksinasi.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $excelLaphar)
    {
        return $excel->download($excelLaphar, 'laporan harian vaksinasi - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->lapharVaksinasiService->search($request));
    }
}
