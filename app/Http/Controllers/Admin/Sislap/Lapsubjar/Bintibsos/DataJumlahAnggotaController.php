<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bintibsos;

use App\Exports\Sislap\Lapsubjar\Bintibsos\DataJumlahAnggota as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bintibsos\DataJumlahAnggota;
use App\Services\Sislap\Lapsubjar\Bintibsos\DataJumlahAnggotaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class DataJumlahAnggotaController extends Controller
{
    protected $model = DataJumlahAnggota::class;
    private $dataJumlahAnggotaService;

    public function __construct(DataJumlahAnggotaService $dataJumlahAnggotaService)
    {
        $this->dataJumlahAnggotaService = $dataJumlahAnggotaService;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.bintibsos.data-jumlah-anggota.index', ['model' => addcslashes($this->model, "\\")]);
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
                    $laporan = DataJumlahAnggota::create([
                        'kesatuan'      => $item['kesatuan'],
                        'jmlsaka_pa'    => $item['jmlsaka_pa'],
                        'jmlsaka_pi'    => $item['jmlsaka_pi'],
                        'kmdsaka_pa'    => $item['kmdsaka_pa'],
                        'kmdsaka_pi'    => $item['kmdsaka_pi'],
                        'kmlsaka_pa'    => $item['kmlsaka_pa'],
                        'kmlsaka_pi'    => $item['kmlsaka_pi'],
                        'jmlpamong_pa'  => $item['jmlpamong_pa'],
                        'jmlpamong_pi'  => $item['jmlpamong_pi'],
                        'kmdpamong_pa'  => $item['kmdpamong_pa'],
                        'kmdpamong_pi'  => $item['kmdpamong_pi'],
                        'kmlpamong_pa'  => $item['kmlpamong_pa'],
                        'kmlpamong_pi'  => $item['kmlpamong_pi'],
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

        return redirect()->route('data-jumlah-anggota.index');
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
            DataJumlahAnggota::find($id)->update([
                'kesatuan'      => $request->kesatuan,
                'jmlsaka_pa'    => $request->jmlsaka_pa,
                'jmlsaka_pi'    => $request->jmlsaka_pi,
                'kmdsaka_pa'    => $request->kmdsaka_pa,
                'kmdsaka_pi'    => $request->kmdsaka_pi,
                'kmlsaka_pa'    => $request->kmlsaka_pa,
                'kmlsaka_pi'    => $request->kmlsaka_pi,
                'jmlpamong_pa'  => $request->jmlpamong_pa,
                'jmlpamong_pi'  => $request->jmlpamong_pi,
                'kmdpamong_pa'  => $request->kmdpamong_pa,
                'kmdpamong_pi'  => $request->kmdpamong_pi,
                'kmlpamong_pa'  => $request->kmlpamong_pa,
                'keterangan'    => $request->keterangan,
                'kmlpamong_pi'  => $request->kmlpamong_pi,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-jumlah-anggota.index');
    }

    public function destroy($id)
    {
        try {
            DataJumlahAnggota::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->dataJumlahAnggotaService, true), 'laporan data jumlah anggota.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bintibsos.data-jumlah-anggota.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan data jumlah anggota - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->dataJumlahAnggotaService->search($request->all()));
    }
}
