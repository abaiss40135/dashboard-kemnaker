<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binkamsa;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binkamsa\PrestasiSatpamExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use Illuminate\Http\Request;
use App\Models\Sislap\Lapsubjar\Binkamsa\PrestasiSatpam;
use App\Services\Sislap\Lapsubjar\Binkamsa\PrestasiSatpamService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PrestasiSatpamController extends Controller
{
    protected $model = PrestasiSatpam::class;
    private PrestasiSatpamService $service;

    public function __construct(PrestasiSatpamService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binkamsa.prestasi-satpam.index',
            ['model' => addcslashes($this->model, "\\")]
        );
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
            'laporan.*.nama' => 'required',
            'laporan.*.jenis_kelamin' => 'required',
            'laporan.*.kualifikasi' => 'required',
            'laporan.*.kantor' => 'required',
            'laporan.*.prestasi' => 'required',
            'laporan.*.keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('prestasi-satpam.index')->withErrors($validator);
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
                    $laporan = PrestasiSatpam::create(array_merge($item, [
                        'user_id'       => $user->id,
                        'kode_satuan'   => $kode_satuan
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

        return redirect()->route('prestasi-satpam.index');
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
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'kualifikasi' => 'required',
            'kantor' => 'required',
            'prestasi' => 'required',
            'keterangan' => 'required',
        ]);

        $validated = $validator->validate();

        try {
            PrestasiSatpam::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('prestasi-satpam.index');
    }

    public function destroy($id) {
        try {
            PrestasiSatpam::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'Laporan Data Satpam Berprestasi.xlsx');
    }

    public function importExcel(Request $request) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binkamsa.prestasi-satpam.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'Laporan Data Satpam Berprestasi - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
