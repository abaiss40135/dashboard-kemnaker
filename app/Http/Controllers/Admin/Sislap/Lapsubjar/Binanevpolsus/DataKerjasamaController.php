<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binanevpolsus;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binanevpolsus\DataKerjasama as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binanevpolsus\DataKerjasama;
use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataKerjasamaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DataKerjasamaController extends Controller
{
    protected $model = DataKerjasama::class;
    private $service;

    public function __construct(DataKerjasamaService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binanevpolsus.data-kerjasama.index', [
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

        $validator = Validator::make($request->all(), [
            'laporan.*.kementerian_lembaga' => 'required',
            'laporan.*.nota_kesepahaman' => 'required',
            'laporan.*.perjanjian_kerjasama' => 'required',
            'laporan.*.pedoman_kerja' => 'required',
            'laporan.*.standar_operasional' => 'required',
            'laporan.*.no_tgl' => 'required',
            'laporan.*.masa_berlaku' => 'required',
            'laporan.*.tentang_judul' => 'required',
            'laporan.*.ruang_lingkup' => 'required',
            'laporan.*.keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('data-kerjasama.index')->withErrors($validator);
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
                    $laporan = DataKerjasama::create(array_merge($item, [
                        'user_id'               => $user->id,
                        'kode_satuan'           => $kode_satuan
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

        return redirect()->route('data-kerjasama.index');
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
        $validator = Validator::make($request->all(), [
            'kementerian_lembaga' => 'required',
            'nota_kesepahaman' => 'required',
            'perjanjian_kerjasama' => 'required',
            'pedoman_kerja' => 'required',
            'standar_operasional' => 'required',
            'no_tgl' => 'required',
            'masa_berlaku' => 'required',
            'tentang_judul' => 'required',
            'ruang_lingkup' => 'required',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('data-kerjasama.index')->withErrors($validator);
        }
        $validated = $validator->validate();

        try {
            DataKerjasama::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-kerjasama.index');
    }

    public function destroy($id) {
        try {
            DataKerjasama::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'laporan kerja sama polri.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binanevpolsus.data-kerjasama.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'laporan kerja sama polri - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
