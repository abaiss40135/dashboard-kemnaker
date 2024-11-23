<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasLama;

use App\Exports\Sislap\Lapsubjar\Binpolmas\DataDaiExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataDai;
use App\Services\Sislap\Lapsubjar\Binpolmas\DataDaiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class DataDaiController extends Controller
{
    protected $model = DataDai::class;
    private DataDaiService $service;

    public function __construct(DataDaiService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.data-dai.index', ['model' => addcslashes($this->model, "\\")]);
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

        $validator = Validator::make($request->all(), [
            'laporan.*.nama_dai'             => 'required',
            'laporan.*.perorangan_kelompok'  => 'required',
            'laporan.*.no_hp'                => 'required|numeric',
            'laporan.*.rt_rw'                => 'required',
            'laporan.*.desa_kel'             => 'required',
            'laporan.*.kecamatan'            => 'required',
            'laporan.*.kab_kota'             => 'required',
            'laporan.*.keterangan'           => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('data-dai.index')->withErrors($validator);
        }

        $validated = $validator->validate();

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
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach($validated['laporan'] as $item) {
                    $laporan = DataDai::create(array_merge($item, [
                        'user_id'           => $user->id,
                        'kode_satuan'       => $kode_satuan
                    ]));
                    if ($level === 'polda') {
                        $laporan->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $level,
                        ]);
                    }
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-dai.index');
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
            DataDai::find($id)->update([
                'nama_dai' => $request->nama_dai,
                'perorangan_kelompok' => $request->perorangan_kelompok,
                'keterangan' => $request->keterangan,
                'no_hp' => $request->no_hp,
                'rt_rw' => $request->rt_rw,
                'desa_kel' => $request->desa_kel,
                'kecamatan' => $request->kecamatan,
                'kab_kota' => $request->kab_kota,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-dai.index');
    }

    public function destroy($id)
    {
        try {
            DataDai::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->service, true), 'laporan data dai kamtibmas.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binpolmas.data-dai.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan data dai kamtibmas - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
