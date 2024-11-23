<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binkamsa;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binkamsa\DataBujpExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binkamsa\DataBujp;
use App\Services\Sislap\Lapsubjar\Binkamsa\DataBujpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class DataBujpController extends Controller
{
    protected $model = DataBujp::class;
    private DataBujpService $service;

    public function __construct(DataBujpService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binkamsa.data-bujp.index',
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
            'laporan.*.nama_perusahaan'         => 'required',
            'laporan.*.konsultasi_aktif'        => 'required|numeric',
            'laporan.*.konsultasi_tidak_aktif'  => 'required|numeric',
            'laporan.*.penerapan_aktif'         => 'required|numeric',
            'laporan.*.penerapan_tidak_aktif'   => 'required|numeric',
            'laporan.*.pelatihan_aktif'         => 'required|numeric',
            'laporan.*.pelatihan_tidak_aktif'   => 'required|numeric',
            'laporan.*.penyediaan_aktif'        => 'required|numeric',
            'laporan.*.penyediaan_tidak_aktif'  => 'required|numeric',
            'laporan.*.jasa_aktif'              => 'required|numeric',
            'laporan.*.jasa_tidak_aktif'        => 'required|numeric',
            'laporan.*.kawal_aktif'             => 'required|numeric',
            'laporan.*.kawal_tidak_aktif'       => 'required|numeric',
            'laporan.*.perluasan'               => 'required',
            'laporan.*.total'                   => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('data-bujp.index')->withErrors($validator);
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
                    $laporan = DataBujp::create(array_merge($item, [
                        'user_id'                   => $user->id,
                        'kode_satuan'               => $kode_satuan
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

        return redirect()->route('data-bujp.index');
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
            'nama_perusahaan'       => 'required',
            'konsultasi_aktif'      => 'required|numeric',
            'konsultasi_tidak_aktif'=> 'required|numeric',
            'penerapan_aktif'       => 'required|numeric',
            'penerapan_tidak_aktif' => 'required|numeric',
            'pelatihan_aktif'       => 'required|numeric',
            'pelatihan_tidak_aktif' => 'required|numeric',
            'penyediaan_aktif'      => 'required|numeric',
            'penyediaan_tidak_aktif'=> 'required|numeric',
            'jasa_aktif'            => 'required|numeric',
            'jasa_tidak_aktif'      => 'required|numeric',
            'kawal_aktif'           => 'required|numeric',
            'kawal_tidak_aktif'     => 'required|numeric',
            'perluasan'             => 'required',
            'total'                 => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('data-bujp.index')->withErrors($validator);
        }

        $validated = $validator->validate();

        try {
            DataBujp::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-bujp.index');
    }

    public function destroy($id) {
        try {
            DataBujp::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->service, true), 'Data BUJP.xlsx');
    }

    public function importExcel(Request $request, Excel $excel) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binkamsa.data-bujp.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'Data BUJP - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
