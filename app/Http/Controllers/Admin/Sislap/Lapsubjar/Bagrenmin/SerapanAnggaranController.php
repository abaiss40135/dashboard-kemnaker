<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bagrenmin;

use App\Exports\Sislap\Lapsubjar\Bagrenmin\SerapanAnggaranExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bagrenmin\SerapanAnggaran;
use App\Services\Sislap\Lapsubjar\Bagrenmin\SerapanAnggaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class SerapanAnggaranController extends Controller
{
    protected $model = SerapanAnggaran::class;
    private $serapanAnggaranService;

    public function __construct(SerapanAnggaranService $serapanAnggaranService)
    {
        $this->serapanAnggaranService = $serapanAnggaranService;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.bagrenmin.serapan-anggaran.index', ['model' => addcslashes($this->model, "\\")]);
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
            'laporan.*.kode' => 'required',
            'laporan.*.program' => 'required',
            'laporan.*.bulan' => 'required',
            'laporan.*.pagu' => 'numeric',
            'laporan.*.realisasi' => 'numeric',
            'laporan.*.presentase' => 'numeric',
            'laporan.*.sisa' => 'numeric',
            'laporan.*.pnbp_pagu' => 'numeric',
            'laporan.*.pnbp_realisasi' => 'numeric',
            'laporan.*.pnbp_presentase' => 'numeric',
            'laporan.*.pnbp_sisa' => 'numeric',
            'laporan.*.hambatan' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('serapan-anggaran.index')->withErrors($validator);
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
                    $laporan = SerapanAnggaran::create(array_merge($item, [
                        'user_id' => $user->id,
                        'kode_satuan' => $kode_satuan,
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

        return redirect()->route('serapan-anggaran.index');
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
            'kode' => 'required',
            'program' => 'required',
            'bulan' => 'required',
            'pagu' => 'numeric',
            'realisasi' => 'numeric',
            'presentase' => 'numeric',
            'sisa' => 'numeric',
            'pnbp_pagu' => 'numeric',
            'pnbp_realisasi' => 'numeric',
            'pnbp_presentase' => 'numeric',
            'pnbp_sisa' => 'numeric',
            'hambatan' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('serapan-anggaran.index')->withErrors($validator);
        }

        $validated = $validator->validate();

        try {
            SerapanAnggaran::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('serapan-anggaran.index');
    }

    public function destroy($id)
    {
        try {
            SerapanAnggaran::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->serapanAnggaranService, true), 'laporan serapan anggaran.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bagrenmin.serapan-anggaran.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan serapan anggaran - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->serapanAnggaranService->search($request->all()));
    }
}
