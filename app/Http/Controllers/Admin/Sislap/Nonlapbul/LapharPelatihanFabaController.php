<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\Lapharpelatihanfaba\LapharPelatihanFaba as Templatelaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Nonlapbul\LapharPelatihanFaba;
use App\Services\Sislap\Nonlapbul\LapharPelatihanFabaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class LapharPelatihanFabaController extends Controller
{
    protected $model = LapharPelatihanFaba::class;
    protected $LapharPelatihanFabaService;

    public function __construct(LapharPelatihanFabaService $LapharPelatihanFabaService)
    {
        $this->LapharPelatihanFabaService = $LapharPelatihanFabaService;
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.laphar-pelatihan-faba.index', ['model' => addcslashes($this->model, "\\")]);
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
                    $laporan = LapharPelatihanFaba::create([
                        'polda'          => $item['polda'],
                        'lokasi_pelatihan'   => $item['lokasi_pelatihan'],
                        'nama_trainer'        => $item['nama_trainer'],
                        'jumlah_peserta'        => $item['jumlah_peserta'],
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

        return redirect()->route('laphar-pelatihan-faba.index');
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
            LapharPelatihanFaba::find($id)->update([
                'polda'                => $request->polda,
                'lokasi_pelatihan'  => $request->lokasi_pelatihan,
                'nama_trainer'          => $request->nama_trainer,
                'jumlah_peserta'   => $request->jumlah_peserta,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('laphar-pelatihan-faba.index');
    }

    public function destroy($id)
    {
        try {
            LapharPelatihanFaba::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->LapharPelatihanFabaService, true), 'laporan_pelatihan_faba.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.nonlapbul.laphar-pelatihan-faba.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $excelLaphar)
    {
        return $excel->download($excelLaphar, 'laporan harian pelatihan faba - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->LapharPelatihanFabaService->search($request));
    }
}
