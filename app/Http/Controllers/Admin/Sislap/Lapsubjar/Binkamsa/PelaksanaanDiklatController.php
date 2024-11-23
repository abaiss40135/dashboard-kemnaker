<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binkamsa;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binkamsa\PelaksanaanDiklatExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binkamsa\PelaksanaanDiklat;
use App\Services\Sislap\Lapsubjar\Binkamsa\PelaksanaanDiklatService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PelaksanaanDiklatController extends Controller
{
    protected $model = PelaksanaanDiklat::class;
    private $service;

    public function __construct(PelaksanaanDiklatService $pelaksanaanDiklatService)
    {
        $this->service = $pelaksanaanDiklatService;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binkamsa.pelaksanaan-diklat.index',
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
            'laporan.*.polda' => 'required',
            'laporan.*.bujp' => 'required',
            'laporan.*.tempat' => 'required',
            'laporan.*.waktu' => 'required',
            'laporan.*.pria' => 'required|numeric',
            'laporan.*.wanita' => 'required|numeric',
            'laporan.*.jumlah_peserta' => 'required|numeric',
            'laporan.*.tanggal_buka' => 'required',
            'laporan.*.tanggal_tutup' => 'required',
            'laporan.*.sendiri' => 'required|numeric',
            'laporan.*.kerma' => 'required|numeric',
            'laporan.*.latdik' => 'required',
            'laporan.*.keterangan' => 'required',
            'laporan.*.jumlah' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pelaksanaan-diklat.index')->withErrors($validator);
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
                    $laporan = PelaksanaanDiklat::create(array_merge($item, [
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

        return redirect()->route('pelaksanaan-diklat.index');
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
            'polda'     => 'required',
            'bujp'      => 'required',
            'tempat'    => 'required',
            'waktu'     => 'required',
            'pria'      => 'required|numeric',
            'wanita'    => 'required|numeric',
            'jumlah_peserta' => 'required|numeric',
            'tanggal_buka'   => 'required',
            'tanggal_tutup'  => 'required',
            'sendiri'   => 'required|numeric',
            'kerma'     => 'required|numeric',
            'latdik'    => 'required',
            'keterangan'     => 'required',
            'jumlah'    => 'required|numeric',
        ]);

        $validated = $validator->validate();

        try {
            PelaksanaanDiklat::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('pelaksanaan-diklat.index');
    }

    public function destroy($id) {
        try {
            PelaksanaanDiklat::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'Laporan Rencana Pelaksanaan Diklat.xlsx');
    }

    public function importExcel(Request $request) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binkamsa.pelaksanaan-diklat.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'Laporan Rencana Pelaksanaan Diklat - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
