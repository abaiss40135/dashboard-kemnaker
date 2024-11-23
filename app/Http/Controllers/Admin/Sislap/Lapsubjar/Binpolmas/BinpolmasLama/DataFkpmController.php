<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasLama;

use App\Exports\Sislap\Lapsubjar\Binpolmas\DataFkpmExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataFkpm;
use App\Services\Sislap\Lapsubjar\Binpolmas\DataFkpmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class DataFkpmController extends Controller
{
    protected $model = DataFkpm::class;
    private $service;

    public function __construct(DataFkpmService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.data-fkpm.index', ['model' => addcslashes($this->model, "\\")]);
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
            'laporan.*.nama_fkpm'        => 'required',
           'laporan.*.nama_anggota_fkpm' => 'required',
           'laporan.*.model_kawasan'     => 'required',
            'laporan.*.model_wilayah'    => 'required',
           'laporan.*.bkpm'              => 'required',
           'laporan.*.desa_kel'          => 'required',
           'laporan.*.kecamatan'         => 'required',
           'laporan.*.kab_kota'          => 'required',
           'laporan.*.provinsi'          => 'required',
           'laporan.*.keterangan'        => 'required',
       ]);

        if ($validator->fails()) {
            return redirect()->route('data-fkpm.index')->withErrors($validator);
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
                    $laporan = DataFkpm::create(array_merge($item, [
                        'user_id'           => $user->id,
                        'kode_satuan'       => $kode_satuan
                    ]));
                    if ($level === 'polda') {
                        $laporan->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $level,
                        ]);
                    }
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-fkpm.index');
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
        try {
            DataFkpm::find($id)->update([
                'nama_fkpm'         => $request->nama_fkpm,
                'nama_anggota_fkpm' => $request->nama_anggota_fkpm,
                'model_kawasan'     => $request->model_kawasan,
                'model_wilayah'     => $request->model_wilayah,
                'bkpm'              => $request->bkpm,
                'desa_kel'          => $request->desa_kel,
                'kecamatan'         => $request->kecamatan,
                'kab_kota'          => $request->kab_kota,
                'provinsi'          => $request->provinsi,
                'keterangan'        => $request->keterangan,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-fkpm.index');
    }

    public function destroy($id)
    {
        try {
            DataFkpm::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->service, true), 'laporan data fkpm.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binpolmas.data-fkpm.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan data fkpm - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
