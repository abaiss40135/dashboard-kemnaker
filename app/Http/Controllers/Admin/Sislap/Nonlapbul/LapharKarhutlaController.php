<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\Lapharkarhutla\LapharKarhutla as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Nonlapbul\LapharKarhutla;
use App\Services\Sislap\Nonlapbul\LapharKarhutlaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class LapharKarhutlaController extends Controller
{
    protected $model = LapharKarhutla::class;
    protected $lapharKarhutlaService;

    public function __construct(LapharKarhutlaService $lapharKarhutlaService)
    {
        $this->lapharKarhutlaService = $lapharKarhutlaService;
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.laphar-karhutla.index', ['model' => addcslashes($this->model, "\\")]);
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
                    $laporan = LapharKarhutla::create([
                        'polres'          => $item['polres'],
                        'himbauan'   => $item['himbauan'],
                        'fgd'        => $item['fgd'],
                        'maklumat_kapolda'        => $item['maklumat_kapolda'],
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

        return redirect()->route('laphar-karhutla.index');
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
            LapharKarhutla::find($id)->update([
                'polres' => $request->kesatuan,
                'himbauan' => $request->uraian_kegiatan,
                'fgd' => $request->keterangan,
                'maklumat_kapolda' => $request->keterangan,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('laphar-karhutla.index');
    }

    public function destroy($id)
    {
        try {
            LapharKarhutla::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->lapharKarhutlaService, true), 'laporan_kegiatan_subditbintibsos.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.nonlapbul.laphar-karhutla.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $excelLaphar)
    {
        return $excel->download($excelLaphar, 'laporan harian karhutla - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->lapharKarhutlaService->search($request));
    }
}
