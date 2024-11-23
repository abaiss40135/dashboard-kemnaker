<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bintibsos;

use App\Exports\Sislap\Lapsubjar\Bintibsos\GiatLinsek as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bintibsos\GiatLinsek;
use App\Services\Sislap\Lapsubjar\Bintibsos\GiatLinsekService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class GiatLinsekController extends Controller
{
    protected $model = GiatLinsek::class;
    private $giatLinsekService;

    public function __construct(GiatLinsekService $giatLinsekService)
    {
        $this->giatLinsekService = $giatLinsekService;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.bintibsos.giat-linsek.index', ['model' => addcslashes($this->model, "\\")]);
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
                    $laporan = GiatLinsek::create([
                        'kesatuan'      => $item['kesatuan'],
                        'jenis_kegiatan'        => $item['jenis_kegiatan'],
                        'materi_pembahasan'       => $item['materi_pembahasan'],
                        'instansi_terlibat'         => $item['instansi_terlibat'],
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

        return redirect()->route('giat-linsek.index');
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
            GiatLinsek::find($id)->update([
                'kesatuan' => $request->kesatuan,
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'keterangan' => $request->keterangan,
                'materi_pembahasan' => $request->materi_pembahasan,
                'instansi_terlibat' => $request->instansi_terlibat,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('giat-linsek.index');
    }

    public function destroy($id)
    {
        try {
            GiatLinsek::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->giatLinsekService, true), 'laporan_giat_linsek.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bintibsos.giat-linsek.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan_giat_linsek'.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->giatLinsekService->search($request->all()));
    }
}
