<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bhabin;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Bhabin\RekapKegiatanExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bhabin\RekapKegiatan;
use App\Services\Sislap\Lapsubjar\Bhabin\RekapKegiatanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class RekapKegiatanController extends Controller
{
    protected $model = RekapKegiatan::class;
    private $service;

    public function __construct(RekapKegiatanService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.bhabin.rekap-kegiatan.index', [
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
            'laporan.*.polres' => 'required',
            'laporan.*.dds' => 'required',
            'laporan.*.li' => 'required',
            'laporan.*.sosial' => 'required',
            'laporan.*.dana_perdata' => 'required',
            'laporan.*.fisik' => 'required',
            'laporan.*.non_fisik' => 'required',
            'laporan.*.pendampingan_danadesa' => 'required',
            'laporan.*.binluh_narkoba' => 'required',
            'laporan.*.pengendalian_pemotonganruminansia' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('rekap-kegiatan.index')->withErrors($validator);
        }
        $validated = $validator->validate();
        $personel   = $user->personel;
        $satuan     = $personel->satuan7 ?? $personel->satuan6 ??
                      $personel->satuan5 ?? $personel->satuan4 ??
                      $personel->satuan3 ?? $personel->satuan2 ??
                      $personel->satuan1;
        $kode_satuan = preg_match('/\d*$/', $satuan, $out) ? $out[0] : null;

        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach($validated['laporan'] as $item) {
                    $item = array_merge($item, ['user_id' => $user->id,'kode_satuan' => $kode_satuan]);
                    $laporan = RekapKegiatan::create($item);
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

        return redirect()->route('rekap-kegiatan.index');
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
        $validator = Validator::make($request->all(), [
            'polres' => 'required',
            'dds' => 'required',
            'li' => 'required',
            'sosial' => 'required',
            'dana_perdata' => 'required',
            'fisik' => 'required',
            'non_fisik' => 'required',
            'pendampingan_danadesa' => 'required',
            'binluh_narkoba' => 'required',
            'pengendalian_pemotonganruminansia' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('rekap-kegiatan.index')->withErrors($validator);
        }
        $validated = $validator->validate();
        try {
            RekapKegiatan::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('rekap-kegiatan.index');
    }

    public function destroy($id) {
        try {
            RekapKegiatan::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->service, true), 'laporan kegiatan bhabinkamtibmas.xlsx');
    }

    public function importExcel(Request $request, Excel $excel) {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bhabin.rekap-kegiatan.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan kegiatan bhabinkamtibmas - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
