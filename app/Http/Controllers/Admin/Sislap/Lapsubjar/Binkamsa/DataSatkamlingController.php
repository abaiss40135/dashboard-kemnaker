<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binkamsa;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binkamsa\DataSatkamlingExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binkamsa\DataSatkamling;
use App\Services\Sislap\Lapsubjar\Binkamsa\DataSatkamlingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DataSatkamlingController extends Controller
{
    protected $model = DataSatkamling::class;
    private DataSatkamlingService $service;

    public function __construct(DataSatkamlingService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binkamsa.data-satkamling.index',
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
            'laporan.*.kesatuan' => 'required',
            'laporan.*.jml_poskamling' => 'required|numeric',
            'laporan.*.aktif' => 'required|numeric',
            'laporan.*.pasif' => 'required|numeric',
            'laporan.*.ketua_pelaksana' => 'required',
            'laporan.*.pelaksana' => 'required',
            'laporan.*.jml_pecalang' => 'required|numeric',
            'laporan.*.jml_pokdarkamtibmas' => 'required|numeric',
            'laporan.*.jml_siswa' => 'required|numeric',
            'laporan.*.jml_mahasiswa' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('data-satkamling.index')->withErrors($validator);
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
                    $laporan = DataSatkamling::create(array_merge($item, [
                        'user_id'            => $user->id,
                        'kode_satuan'        => $kode_satuan
                    ]));
                    if ($level === 'polda'){
                        $laporan->approvals()->create([
                            'keterangan'     => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level'          => $level,
                        ]);
                    }
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('data-satkamling.index');
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
            'kesatuan' => 'required',
            'jml_poskamling' => 'required|numeric',
            'aktif' => 'required|numeric',
            'pasif' => 'required|numeric',
            'ketua_pelaksana' => 'required',
            'pelaksana' => 'required',
            'jml_pecalang' => 'required|numeric',
            'jml_pokdarkamtibmas' => 'required|numeric',
            'jml_siswa' => 'required|numeric',
            'jml_mahasiswa' => 'required|numeric',
        ]);

        $validated = $validator->validate();

        try {
            DataSatkamling::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-satkamling.index');
    }

    public function destroy($id) {
        try {
            DataSatkamling::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'Laporan Data Satkamling.xlsx');
    }

    public function importExcel(Request $request) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binkamsa.data-satkamling.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'Laporan Data Satkamling - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
