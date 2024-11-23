<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Komsatpam;

use App\Exports\Sislap\Lapsubjar\Komsatpam\DataSatpam as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Komsatpam\DataSatpam;
use App\Services\Sislap\Lapsubjar\Komsatpam\DataSatpamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class DataSatpamController extends Controller
{
    protected $model = DataSatpam::class;
    private $dataSatpamService;

    public function __construct(DataSatpamService $dataSatpamService)
    {
        $this->dataSatpamService = $dataSatpamService;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.komsatpam.data-satpam.index', ['model' => addcslashes($this->model, "\\")]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
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
                    $laporan = DataSatpam::create([
                        'polda'      => $item['polda'],
                        'diklat_gp'        => $item['diklat_gp'],
                        'diklat_gm'       => $item['diklat_gm'],
                        'diklat_gu'         => $item['diklat_gu'],
                        'bersertifikasi_gp'    => $item['bersertifikasi_gp'],
                        'bersertifikasi_gm'    => $item['bersertifikasi_gm'],
                        'bersertifikasi_gu'    => $item['bersertifikasi_gu'],
                        'belum_bersertifikasi_gm'    => $item['belum_bersertifikasi_gm'],
                        'belum_bersertifikasi_gp'    => $item['belum_bersertifikasi_gp'],
                        'belum_bersertifikasi_gu'    => $item['belum_bersertifikasi_gu'],
                        'keterangan'    => $item['keterangan'],
                        'user_id'       => $user->id,
                        'kode_satuan'   => $kode_satuan
                    ]);
                    if ($level === 'polda'){
                        $laporan->approvals()->create([
                            'keterangan'    => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level'         => $level,
                        ]);
                    }
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('data-satpam.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            DataSatpam::find($id)->update([
                'polda' => $request->polda,
                'diklat_gp' => $request->diklat_gp,
                'diklat_gm' => $request->diklat_gm,
                'diklat_gu' => $request->diklat_gu,
                'bersertifikasi_gp' => $request->bersertifikasi_gp,
                'bersertifikasi_gm' => $request->bersertifikasi_gm,
                'bersertifikasi_gu' => $request->bersertifikasi_gu,
                'belum_bersertifikasi_gm' => $request->belum_bersertifikasi_gm,
                'belum_bersertifikasi_gp' => $request->belum_bersertifikasi_gp,
                'belum_bersertifikasi_gu' => $request->belum_bersertifikasi_gu,
                'keterangan' => $request->keterangan,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-satpam.index');
    }

    public function destroy($id)
    {
        try {
            DataSatpam::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->dataSatpamService, true), 'laporan data satpam.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.komsatpam.data-satpam.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template)
    {
        return $excel->download($template, 'laporan data satpam - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->dataSatpamService->search($request->all()));
    }
}
