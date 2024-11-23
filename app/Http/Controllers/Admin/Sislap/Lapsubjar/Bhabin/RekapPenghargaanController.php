<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bhabin;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Bhabin\RekapPenghargaanExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bhabin\RekapPenghargaan;
use App\Services\Sislap\Lapsubjar\Bhabin\RekapPenghargaanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class RekapPenghargaanController extends Controller
{
    protected $model = RekapPenghargaan::class;
    private $service;

    public function __construct(RekapPenghargaanService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.bhabin.rekap-penghargaan.index', [
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request) {
        $user   = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level  = end($levels);
        $validator = $validator = Validator::make($request->all(), [
            'laporan.*.polres' => 'required',
            'laporan.*.kapolri' => 'required',
            'laporan.*.kabaharkam' => 'required',
            'laporan.*.kakorbinmas' => 'required',
            'laporan.*.kapolda' => 'required',
            'laporan.*.dirbinmas' => 'required',
            'laporan.*.kapolres' => 'required',
            'laporan.*.kapolsek' => 'required',
            'laporan.*.instansi' => 'required',
            'laporan.*.lain_lain' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('rekap-penghargaan.index')->withErrors($validator);
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
                    $item = array_merge($item, [
                        'user_id'       => $user->id,
                        'kode_satuan'   => $kode_satuan
                    ]);
                    $laporan = RekapPenghargaan::create($item);
                    if ($level === 'polda') {
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

        return redirect()->route('rekap-penghargaan.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id) {
        $validator = $validator = Validator::make($request->all(), [
            'polres' => 'required',
            'kapolri' => 'required',
            'kabaharkam' => 'required',
            'kakorbinmas' => 'required',
            'kapolda' => 'required',
            'dirbinmas' => 'required',
            'kapolres' => 'required',
            'kapolsek' => 'required',
            'instansi' => 'required',
            'lain_lain' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('rekap-penghargaan.index')->withErrors($validator);
        }
        $validated = $validator->validate();
        try {
            RekapPenghargaan::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('rekap-penghargaan.index');
    }

    public function destroy($id) {
        try {
            RekapPenghargaan::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->service, true), 'rekapitulasi penghargaan bhabinkamtibmas.xlsx');
    }

    public function importExcel(Request $request, Excel $excel) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bhabin.rekap-penghargaan.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'rekapitulasi penghargaan bhabinkamtibmas - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
