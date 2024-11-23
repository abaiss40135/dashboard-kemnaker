<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Komsatpam;

use App\Exports\Sislap\Lapsubjar\Komsatpam\DataAssesor as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Komsatpam\DataAssesor;
use App\Services\Sislap\Lapsubjar\Komsatpam\DataAssesorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class DataAssesorController extends Controller
{
    protected $model = DataAssesor::class;
    private $dataAssesorService;

    public function __construct(DataAssesorService $dataAssesorService)
    {
        $this->dataAssesorService = $dataAssesorService;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.komsatpam.data-assesor.index', ['model' => addcslashes($this->model, "\\")]);
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
                    $laporan = DataAssesor::create([
                        'nama'          => $item['nama'],
                        'polri'         => $item['polri'],
                        'non_polri'     => $item['non_polri'],
                        'no_reg_assesor'=> $item['no_reg_assesor'],
                        'gu'            => $item['gu'],
                        'gm'            => $item['gm'],
                        'gp'            => $item['gp'],
                        'jml'           => $item['jml'],
                        'status'        => $item['status'],
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

        return redirect()->route('data-assesor.index');
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
            DataAssesor::find($id)->update([
                'nama' => $request->nama,
                'polri' => $request->polri,
                'keterangan' => $request->keterangan,
                'non_polri' => $request->non_polri,
                'no_reg_assesor' => $request->no_reg_assesor,
                'gu' => $request->gu,
                'gm' => $request->gm,
                'gp' => $request->gp,
                'jml' => $request->jml,
                'status' => $request->status,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-assesor.index');
    }

    public function destroy($id)
    {
        try {
            DataAssesor::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->dataAssesorService, true), 'laporan data assesor.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.komsatpam.data-assesor.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan data assesor'.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->dataAssesorService->search($request->all()));
    }
}
