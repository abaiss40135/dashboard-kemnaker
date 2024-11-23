<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binanevpolsus;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binanevpolsus\DataSenpi as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binanevpolsus\DataSenpi;
use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataSenpiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DataSenpiController extends Controller
{
    protected $model = DataSenpi::class;
    private $service;

    public function __construct(DataSenpiService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binanevpolsus.data-senpi.index', [
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
            'laporan.*.kementerian_lembaga' => 'required',
            'laporan.*.senpi_larpan_jml' => 'required|numeric',
            'laporan.*.senpi_larpan_bb' => 'required|numeric',
            'laporan.*.senpi_larpan_rr' => 'required|numeric',
            'laporan.*.senpi_larpan_rb' => 'required|numeric',
            'laporan.*.senpi_larpend_jml' => 'required|numeric',
            'laporan.*.senpi_larpend_bb' => 'required|numeric',
            'laporan.*.senpi_larpend_rr' => 'required|numeric',
            'laporan.*.senpi_larpend_rb' => 'required|numeric',
            'laporan.*.amunisi_larpan_jml' => 'required|numeric',
            'laporan.*.amunisi_larpan_bb' => 'required|numeric',
            'laporan.*.amunisi_larpan_rr' => 'required|numeric',
            'laporan.*.amunisi_larpan_rb' => 'required|numeric',
            'laporan.*.amunisi_larpend_jml' => 'required|numeric',
            'laporan.*.amunisi_larpend_bb' => 'required|numeric',
            'laporan.*.amunisi_larpend_rr' => 'required|numeric',
            'laporan.*.amunisi_larpend_rb' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->route('data-senpi.index')->withErrors($validator);
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
                        'user_id'     => $user->id,
                        'kode_satuan' => $kode_satuan
                    ]);
                    $laporan = DataSenpi::create($item);
                    if ($level === 'polda') {
                        $laporan->approvals()->create([
                            'keterangan'        => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level'             => $level,
                        ]);
                    }
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-senpi.index');
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
            'kementerian_lembaga' => 'required',
            'senpi_larpan_jml' => 'required|numeric',
            'senpi_larpan_bb' => 'required|numeric',
            'senpi_larpan_rr' => 'required|numeric',
            'senpi_larpan_rb' => 'required|numeric',
            'senpi_larpend_jml' => 'required|numeric',
            'senpi_larpend_bb' => 'required|numeric',
            'senpi_larpend_rr' => 'required|numeric',
            'senpi_larpend_rb' => 'required|numeric',
            'amunisi_larpan_jml' => 'required|numeric',
            'amunisi_larpan_bb' => 'required|numeric',
            'amunisi_larpan_rr' => 'required|numeric',
            'amunisi_larpan_rb' => 'required|numeric',
            'amunisi_larpend_jml' => 'required|numeric',
            'amunisi_larpend_bb' => 'required|numeric',
            'amunisi_larpend_rr' => 'required|numeric',
            'amunisi_larpend_rb' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->route('data-senpi.index')->withErrors($validator);
        }
        $validated = $validator->validate();
        try {
            DataSenpi::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-senpi.index');
    }

    public function destroy($id) {
        try {
            DataSenpi::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'laporan data senpi dan amunisi.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binanevpolsus.data-senpi.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'laporan data senpi dan amunisi - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
