<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binkamsa;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binkamsa\PagelaranSatpamExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binkamsa\PagelaranSatpam;
use App\Services\Sislap\Lapsubjar\Binkamsa\PagelaranSatpamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PagelaranSatpamController extends Controller
{
    protected $model = PagelaranSatpam::class;
    private $service;

    public function __construct(PagelaranSatpamService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binkamsa.pagelaran-satpam.index',
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
            'laporan.*.jenis_perusahaan' => 'required',
            'laporan.*.pria'         => 'required|numeric',
            'laporan.*.wanita'       => 'required|numeric',
            'laporan.*.jumlah'       => 'required|numeric',
            'laporan.*.gada_pratama' => 'required|numeric',
            'laporan.*.gada_madya'   => 'required|numeric',
            'laporan.*.gada_utama'   => 'required|numeric',
            'laporan.*.belum'        => 'required|numeric',
            'laporan.*.outsourcing'  => 'required|numeric',
            'laporan.*.organik'      => 'required|numeric',
            'laporan.*.keterangan'   => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pagelaran-satpam.index')->withErrors($validator);
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
                    $laporan = PagelaranSatpam::create(array_merge($item, [
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

        return redirect()->route('pagelaran-satpam.index');
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
            'jenis_perusahaan' => 'required',
            'pria'         => 'required|numeric',
            'wanita'       => 'required|numeric',
            'jumlah'       => 'required|numeric',
            'gada_pratama' => 'required|numeric',
            'gada_madya'   => 'required|numeric',
            'gada_utama'   => 'required|numeric',
            'belum'        => 'required|numeric',
            'outsourcing'  => 'required|numeric',
            'organik'      => 'required|numeric',
            'keterangan'   => 'required',
        ]);

        $validated = $validator->validate();

        try {
            PagelaranSatpam::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('pagelaran-satpam.index');
    }

    public function destroy($id) {
        try {
            PagelaranSatpam::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'Laporan Data Pagelaran Satpam.xlsx');
    }

    public function importExcel(Request $request) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binkamsa.pagelaran-satpam.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'Laporan Data Pagelaran Satpam - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
