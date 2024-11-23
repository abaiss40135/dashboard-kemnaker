<?php

namespace App\Http\Controllers\Admin\Sislap\Lapbul\Operasional;

use App\Exports\Sislap\Lapbul\Operasional\KomunitasBinaan as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapbul\Operasional\KomunitasBinaan;
use App\Services\Sislap\Lapbul\Operasional\KomunitasBinaanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class KomunitasBinaanController extends Controller
{
    protected $model = KomunitasBinaan::class;
    private $service;

    public function __construct(KomunitasBinaanService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('administrator.sislap.lapbul.operasional.format-4-8.index', [
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

        $validator = Validator::make($request->all(), [
            'laporan.*.komunitas_binaan' => 'required',
            'laporan.*.jumlah_komunitas_binaan' => 'required',
            'laporan.*.jumlah_anggota' => 'required',
            'laporan.*.peran_polri' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('komunitas-binaan.index')->withErrors($validator);
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
                    $laporan = KomunitasBinaan::create(array_merge($item, [
                        'user_id'           => $user->id,
                        'kode_satuan'       => $kode_satuan
                    ]));
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

        return redirect()->route('komunitas-binaan.index');
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
        $validator = Validator::make($request->all(), [
            'komunitas_binaan' => 'required',
            'jumlah_komunitas_binaan' => 'required',
            'jumlah_anggota' => 'required',
            'peran_polri' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('komunitas-binaan.index')->withErrors($validator);
        }

        $validated = $validator->validate();

        try {
            KomunitasBinaan::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('komunitas-binaan.index');
    }

    public function destroy($id)
    {
        try {
            KomunitasBinaan::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'komunitas binaan yang dilaksanakan oleh ditbinmas.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapbul.operasional.format-4-8.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'komunitas binaan yang dilaksanakan oleh ditbinmas - '.
        now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
