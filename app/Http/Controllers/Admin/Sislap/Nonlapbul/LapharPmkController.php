<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\Lapharpmk\LapharPmk as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Nonlapbul\LapharPmk;
use App\Services\Sislap\Nonlapbul\LapharPmkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class LapharPmkController extends Controller
{
    protected $model = LapharPmk::class;
    protected $LapharPmkService;

    public function __construct(LapharPmkService $LapharPmkService)
    {
        $this->LapharPmkService = $LapharPmkService;
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.laphar-pmk.index', ['model' => addcslashes($this->model, "\\")]);
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
                    $laporan = LapharPmk::create([
                        'polres'          => $item['polres'],
                        'jml_hewan_terinfeksi'   => $item['jml_hewan_terinfeksi'],
                        'harga_daging'        => $item['harga_daging'],
                        'ketersediaan_daging'        => $item['ketersediaan_daging'],
                        'user_id'           => $user->id,
                        'kode_satuan'       => $kode_satuan
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

        return redirect()->route('laphar-pmk.index');
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
            LapharPmk::find($id)->update([
                'polres'                => $request->polres,
                'jml_hewan_terinfeksi'  => $request->jml_hewan_terinfeksi,
                'harga_daging'          => $request->harga_daging,
                'ketersediaan_daging'   => $request->ketersediaan_daging,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('laphar-pmk.index');
    }

    public function destroy($id)
    {
        try {
            LapharPmk::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->LapharPmkService, true), 'laporan_monitoring_pmk.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.nonlapbul.laphar-pmk.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $excelLaphar)
    {
        return $excel->download($excelLaphar, 'laporan harian monitoring pmk - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->LapharPmkService->search($request));
    }
}
