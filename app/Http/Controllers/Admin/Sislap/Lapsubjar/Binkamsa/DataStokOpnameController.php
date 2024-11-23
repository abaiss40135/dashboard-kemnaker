<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binkamsa;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binkamsa\DataStokOpnameExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binkamsa\DataStokOpname;
use App\Services\Sislap\Lapsubjar\Binkamsa\DataStokOpnameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DataStokOpnameController extends Controller
{
    protected $model = DataStokOpname::class;
    private $service;

    public function __construct(DataStokOpnameService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binkamsa.data-stok-opname.index',
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
            'laporan.*.bulan'             => 'required',
            'laporan.*.kta_gp_guna'       => 'required|numeric',
            'laporan.*.kta_gp_rusak'      => 'required|numeric',
            'laporan.*.kta_gp_jumlah'     => 'required|numeric',
            'laporan.*.kta_gp_sisa'       => 'required|numeric',
            'laporan.*.kta_gp_no_blangko' => 'required|numeric',
            'laporan.*.kta_gm_guna'       => 'required|numeric',
            'laporan.*.kta_gm_rusak'      => 'required|numeric',
            'laporan.*.kta_gm_jumlah'     => 'required|numeric',
            'laporan.*.kta_gm_sisa'       => 'required|numeric',
            'laporan.*.kta_gm_no_blangko' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('data-stok-opname.index')->withErrors($validator);
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
                    $laporan = DataStokOpname::create(array_merge($item, [
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

        return redirect()->route('data-stok-opname.index');
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
            'bulan'             => 'required',
            'kta_gp_guna'       => 'required|numeric',
            'kta_gp_rusak'      => 'required|numeric',
            'kta_gp_jumlah'     => 'required|numeric',
            'kta_gp_sisa'       => 'required|numeric',
            'kta_gp_no_blangko' => 'required|numeric',
            'kta_gm_guna'       => 'required|numeric',
            'kta_gm_rusak'      => 'required|numeric',
            'kta_gm_jumlah'     => 'required|numeric',
            'kta_gm_sisa'       => 'required|numeric',
            'kta_gm_no_blangko' => 'required|numeric',
        ]);

        $validated = $validator->validate();
        try {
            DataStokOpname::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-stok-opname.index');
    }

    public function destroy($id) {
        try {
            DataStokOpname::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'Laporan Data Stok Opname.xlsx');
    }

    public function importExcel(Request $request) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binkamsa.data-stok-opname.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'Laporan Data Stok Opname - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
