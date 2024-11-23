<?php

namespace App\Http\Controllers\Admin\Sislap\Lapbul\Pembinaan;

use App\Exports\Sislap\Lapbul\Pembinaan\RealisasiAnggaran as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapbul\Pembinaan\RealisasiAnggaran;
use App\Services\Sislap\Lapbul\Pembinaan\RealisasiAnggaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RealisasiAnggaranController extends Controller
{
    protected $model = RealisasiAnggaran::class;
    private $service;

    public function __construct(RealisasiAnggaranService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('administrator.sislap.lapbul.pembinaan.format-4-11.index', [
            'model' => addcslashes($this->model, "\\")
        ]);
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
            'laporan.*.program_kegiatan' => 'required',
            'laporan.*.bulan' => 'required',
            'laporan.*.pagu_awal' => 'required|numeric',
            'laporan.*.pagu_revisi' => 'required|numeric',
            'laporan.*.realisasi_rupiah' => 'required|numeric',
            'laporan.*.realisasi_persen' => 'required|numeric',
            'laporan.*.sisa_rupiah' => 'required|numeric',
            'laporan.*.sisa_persen' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('realisasi-anggaran.index')->withErrors($validator);
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
                    $laporan = RealisasiAnggaran::create(array_merge($item, [
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

        return redirect()->route('realisasi-anggaran.index');
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
            'program_kegiatan' => 'required',
            'bulan' => 'required',
            'pagu_awal' => 'required|numeric',
            'pagu_revisi' => 'required|numeric',
            'realisasi_rupiah' => 'required|numeric',
            'realisasi_persen' => 'required|numeric',
            'sisa_rupiah' => 'required|numeric',
            'sisa_persen' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('realisasi-anggaran.index')->withErrors($validator);
        }

        $validated = $validator->validate();

        try {
            RealisasiAnggaran::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('realisasi-anggaran.index');
    }

    public function destroy($id)
    {
        try {
            RealisasiAnggaran::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'data realisasi anggaran.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapbul.pembinaan.format-4-11.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'data realisasi anggaran - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
