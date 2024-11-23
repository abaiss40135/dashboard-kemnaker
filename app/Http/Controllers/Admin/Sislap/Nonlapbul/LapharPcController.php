<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\Lapharpc\LapharPc as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Nonlapbul\LapharPc;
use App\Services\Sislap\Nonlapbul\LapharPcService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class LapharPcController extends Controller
{
    protected $model = LapharPc::class;
    protected $lapharPcService;

    public function __construct(LapharPcService $lapharPcService)
    {
        $this->lapharPcService = $lapharPcService;
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.laphar-pc.index', ['model' => addcslashes($this->model, "\\")]);
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
                    $laporan = LapharPc::create([
                        'satker'                => $item['satker'],
                        'perbelanjaan'          => $item['perbelanjaan'],
                        'perkantoran'           => $item['perkantoran'],
                        'pemukiman'             => $item['pemukiman'],
                        'kawasan'               => $item['kawasan'],
                        'transportasi_publik'   => $item['transportasi_publik'],
                        'tempat_wisata'         => $item['tempat_wisata'],
                        'komunitas_hobi'        => $item['komunitas_hobi'],
                        'jumlah_komunitas'      => $item['jumlah_komunitas'],
                        'user_id'               => $user->id,
                        'kode_satuan'           => $kode_satuan
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
            $this->flashError($exception);
        }

        return redirect()->route('laphar-pc.index');
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
            LapharPc::find($id)->update([
                'satker'                => $request->satker,
                'perbelanjaan'          => $request->perbelanjaan,
                'perkantoran'           => $request->perkantoran,
                'pemukiman'             => $request->pemukiman,
                'kawasan'               => $request->kawasan,
                'transportasi_publik'   => $request->transportasi_publik,
                'tempat_wisata'         => $request->tempat_wisata,
                'komunitas_hobi'        => $request->komunitas_hobi,
                'jumlah_komunitas'      => $request->jumlah_komunitas,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('laphar-pc.index');
    }

    public function destroy($id)
    {
        try {
            LapharPc::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->lapharPcService, true), 'laporan harian pc pen.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.nonlapbul.laphar-pc.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $excelLaphar)
    {
        return $excel->download($excelLaphar, 'laporan harian pc pen - ' . now()->translatedFormat(config('app.long_date_without_day_format')) . '.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->lapharPcService->search($request));
    }
}
