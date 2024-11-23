<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bintibsos;

use App\Exports\Sislap\Lapsubjar\Bintibsos\UpayaPreemtif as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bintibsos\UpayaPreemtif;
use App\Services\Sislap\Lapsubjar\Bintibsos\UpayaPreemtifService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class UpayaPreemtifController extends Controller
{
    protected $model = UpayaPreemtif::class;
    private $upayaPreemtifService;

    public function __construct(UpayaPreemtifService $upayaPreemtifService)
    {
        $this->upayaPreemtifService = $upayaPreemtifService;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.bintibsos.upaya-preemtif.index', [
            'model' => addcslashes($this->model, "\\")
        ]);
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
                    $laporan = UpayaPreemtif::create([
                        'kesatuan'          => $item['kesatuan'],
                        'bulan'             => $item['bulan'],
                        'masalah_sosial'    => $item['masalah_sosial'],
                        'dds'               => $item['dds'],
                        'penyuluhan'        => $item['penyuluhan'],
                        'sambang'           => $item['sambang'],
                        'mobil_penling'     => $item['mobil_penling'],
                        'sosialisasi'       => $item['sosialisasi'],
                        'lain_lain'         => $item['lain_lain'],
                        'jumlah'            => $item['jumlah'],
                        'keterangan'        => $item['keterangan'],
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

        return redirect()->route('upaya-preemtif.index');
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
            UpayaPreemtif::find($id)->update([
                'kesatuan' => $request->kesatuan,
                'bulan' => $request->bulan,
                'masalah_sosial' => $request->masalah_sosial,
                'dds' => $request->dds,
                'penyuluhan' => $request->penyuluhan,
                'sambang' => $request->sambang,
                'mobil_penling' => $request->mobil_penling,
                'sosialisasi' => $request->sosialisasi,
                'lain_lain' => $request->lain_lain,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('upaya-preemtif.index');
    }

    public function destroy($id)
    {
        try {
            UpayaPreemtif::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->upayaPreemtifService, true), 'upaya preemtif permasalahan sosial.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bintibsos.upaya-preemtif.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'upaya preemtif permasalahan sosial - '.
                     now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->upayaPreemtifService->search($request->all()));
    }
}
