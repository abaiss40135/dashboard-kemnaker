<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bintibsos;

use App\Exports\Sislap\Lapsubjar\Bintibsos\GiatPembinaan as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bintibsos\GiatPembinaan;
use App\Services\Sislap\Lapsubjar\Bintibsos\GiatPembinaanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class GiatPembinaanController extends Controller
{
    protected $model = GiatPembinaan::class;
    private $giatPembinaanService;

    public function __construct(GiatPembinaanService $giatPembinaanService)
    {
        $this->giatPembinaanService = $giatPembinaanService;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.bintibsos.giat-pembinaan.index', [
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
                    $laporan = GiatPembinaan::create([
                        'kesatuan'              => $item['kesatuan'],
                        'bulan'                 => $item['bulan'],
                        'bencana_dan_pembinaan' => $item['bencana_dan_pembinaan'],
                        'penyuluhan'            => $item['penyuluhan'],
                        'sambang'               => $item['sambang'],
                        'sosialisasi'           => $item['sosialisasi'],
                        'upacara'               => $item['upacara'],
                        'polisi_cilik'          => $item['polisi_cilik'],
                        'olahraga'              => $item['olahraga'],
                        'baksos'                => $item['baksos'],
                        'trauma_healing'        => $item['trauma_healing'],
                        'evakuasi'              => $item['evakuasi'],
                        'lain_lain'             => $item['lain_lain'],
                        'jumlah'                => $item['jumlah'],
                        'keterangan'            => $item['keterangan'],
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
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('giat-pembinaan.index');
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
            GiatPembinaan::find($id)->update([
                'kesatuan'      => $request->kesatuan,
                'bulan'         => $request->bulan,
                'bencana_dan_pembinaan'=> $request->bencana_dan_pembinaan,
                'penyuluhan'    => $request->penyuluhan,
                'sambang'       => $request->sambang,
                'sosialisasi'   => $request->sosialisasi,
                'upacara'       => $request->upacara,
                'polisi_cilik'  => $request->polisi_cilik,
                'olahraga'      => $request->olahraga,
                'baksos'        => $request->baksos,
                'trauma_healing'=> $request->trauma_healing,
                'evakuasi'      => $request->evakuasi,
                'lain_lain'     => $request->lain_lain,
                'jumlah'        => $request->jumlah,
                'keterangan'    => $request->keterangan
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('giat-pembinaan.index');
    }

    public function destroy($id)
    {
        try {
            GiatPembinaan::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->giatPembinaanService, true), 'kegiatan pembinaan dan penanganan bencana alam.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);
        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bintibsos.giat-pembinaan.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'kegiatan pembinaan dan penanganan bencana alam'.
                       now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->giatPembinaanService->search($request->all()));
    }
}
