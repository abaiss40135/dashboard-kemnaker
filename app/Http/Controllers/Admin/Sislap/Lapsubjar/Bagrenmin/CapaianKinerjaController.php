<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bagrenmin;

use App\Exports\Sislap\Lapsubjar\Bagrenmin\CapaianKinerjaExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bagrenmin\CapaianKinerja;
use App\Services\Sislap\Lapsubjar\Bagrenmin\CapaianKinerjaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class CapaianKinerjaController extends Controller
{
    protected $model = CapaianKinerja::class;
    protected $capaianKinerjaService;

    public function __construct(CapaianKinerjaService $capaianKinerjaService)
    {
        $this->capaianKinerjaService = $capaianKinerjaService;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.bagrenmin.capaian-kinerja.index', ['model' => addcslashes($this->model, "\\")]);
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
            'laporan.*.sasaran' => 'required',
            'laporan.*.indikator' => 'required',
            'laporan.*.target' => 'required',
            'laporan.*.realisasi' => 'required',
            'laporan.*.kegiatan' => 'required',
            'laporan.*.hasil' => 'required',
            'laporan.*.hambatan' => 'nullable',
            'laporan.*.solusi_hambatan' => 'nullable',
            'laporan.*.keterangan' => 'nullable',
            'laporan.*.triwulan' => 'required',
            'laporan.*.tahun' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('capaian-kinerja.index')->withErrors($validator);
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
                    $laporan = CapaianKinerja::create(array_merge($item, [
                        'user_id'           => $user->id,
                        'kode_satuan'       => $kode_satuan,
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

        return redirect()->route('capaian-kinerja.index');
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
            'sasaran' => 'required',
            'indikator' => 'required',
            'target' => 'required',
            'realisasi' => 'required',
            'kegiatan' => 'required',
            'hasil' => 'required',
            'hambatan' => 'nullable',
            'solusi_hambatan' => 'nullable',
            'keterangan' => 'nullable',
            'triwulan' => 'required',
            'tahun' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('capaian-kinerja.index')->withErrors($validator);
        }

        $validated = $validator->validate();

        try {
            CapaianKinerja::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('capaian-kinerja.index');
    }

    public function destroy($id)
    {
        try {
            CapaianKinerja::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->capaianKinerjaService, true), 'Laporan Evaluasi Capaian Kinerja.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bagrenmin.capaian-kinerja.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan evaluasi capaian kinerja - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->capaianKinerjaService->search($request->all()));
    }
}
