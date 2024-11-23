<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bhabin;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Bhabin\RekapPenggelaranExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bhabin\RekapPenggelaran;
use App\Services\Sislap\Lapsubjar\Bhabin\RekapPenggelaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class RekapPenggelaranController extends Controller
{
    protected $model = RekapPenggelaran::class;
    private $service;

    public function __construct(RekapPenggelaranService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.bhabin.rekap-penggelaran.index', [
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
            'laporan.*.tgl_input_data' => 'required',
            'laporan.*.polres' => 'required',
            'laporan.*.jumlah_desa' => 'required',
            'laporan.*.jumlah_kelurahan' => 'required',
            'laporan.*.jumlah_bhabin' => 'required',
            'laporan.*.bina1_desa' => 'required',
            'laporan.*.bina2_desa' => 'required',
            'laporan.*.bina3_desa' => 'required',
            'laporan.*.bina4_desa' => 'required',
            'laporan.*.desa_kel_binaan' => 'required',
            'laporan.*.desa_kel_sentuhan' => 'required',
            'laporan.*.desa_kel_pantauan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('rekap-penggelaran.index')->withErrors($validator);
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
                    $item = array_merge($item, [
                        'user_id' => $user->id,
                        'kode_satuan' => $kode_satuan
                    ]);
                    $laporan = RekapPenggelaran::create($item);
                    if ($level === 'polda') {
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

        return redirect()->route('rekap-penggelaran.index');
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
            'tgl_input_data' => 'required',
            'polres' => 'required',
            'jumlah_desa' => 'required',
            'jumlah_kelurahan' => 'required',
            'jumlah_bhabin' => 'required',
            'bina1_desa' => 'required',
            'bina2_desa' => 'required',
            'bina3_desa' => 'required',
            'bina4_desa' => 'required',
            'desa_kel_binaan' => 'required',
            'desa_kel_sentuhan' => 'required',
            'desa_kel_pantauan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('rekap-penggelaran.index')->withErrors($validator);
        }
        $validated = $validator->validate();
        try {
            RekapPenggelaran::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('rekap-penggelaran.index');
    }

    public function destroy($id) {
        try {
            RekapPenggelaran::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->service, true), 'laporan penggelaran bhabinkamtibmas.xlsx');
    }

    public function importExcel(Request $request, Excel $excel) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bhabin.rekap-penggelaran.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan penggelaran bhabinkamtibmas - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
