<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binanevpolsus;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binanevpolsus\DataDiklatPolsus as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binanevpolsus\DataDiklatPolsus;
use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataDiklatPolsusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DataDiklatPolsusController extends Controller
{
    protected $model = DataDiklatPolsus::class;
    private $service;

    public function __construct(DataDiklatPolsusService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binanevpolsus.data-diklat-polsus.index', [
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
            'laporan.*.polda' => 'required',
            'laporan.*.instansi' => 'required',
            'laporan.*.tempat' => 'required',
            'laporan.*.nama_diklat' => 'required',
            'laporan.*.pria' => 'required',
            'laporan.*.wanita' => 'required',
            'laporan.*.jumlah' => 'required',
            'laporan.*.tgl_buka' => 'required',
            'laporan.*.tgl_tutup' => 'required',
            'laporan.*.lama_hari' => 'required',
            'laporan.*.keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('data-diklat-polsus.index')->withErrors($validator);
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
                    $laporan = DataDiklatPolsus::create(array_merge($item, [
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

        return redirect()->route('data-diklat-polsus.index');
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
            'polda' => 'required',
            'instansi' => 'required',
            'tempat' => 'required',
            'nama_diklat' => 'required',
            'pria' => 'required',
            'wanita' => 'required',
            'jumlah' => 'required',
            'tgl_buka' => 'required',
            'tgl_tutup' => 'required',
            'lama_hari' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('data-diklat-polsus.index')->withErrors($validator);
        }
        $validated = $validator->validate();

        try {
            DataDiklatPolsus::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-diklat-polsus.index');
    }

    public function destroy($id) {
        try {
            DataDiklatPolsus::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'laporan data diklat polsus.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binanevpolsus.data-diklat-polsus.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'laporan data diklat polsus - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
