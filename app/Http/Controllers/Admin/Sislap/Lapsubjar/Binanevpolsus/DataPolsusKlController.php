<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binanevpolsus;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binanevpolsus\DataPolsusKl as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binanevpolsus\DataPolsusKl;
use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataPolsusKlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DataPolsusKlController extends Controller
{
    protected $model = DataPolsusKl::class;
    private $service;

    public function __construct(DataPolsusKlService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.binanevpolsus.data-polsus-kl.index', [
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
            'laporan.*.kementerian' => 'required',
            'laporan.*.nama' => 'required',
            'laporan.*.pangkat' => 'required',
            'laporan.*.nip' => 'required',
            'laporan.*.golongan' => 'required',
            'laporan.*.ttl' => 'required',
            'laporan.*.jenis_kelamin' => 'required',
            'laporan.*.agama' => 'required',
            'laporan.*.jabatan' => 'required',
            'laporan.*.wilayah_penugasan' => 'required',
            'laporan.*.dik_umum' => 'required',
            'laporan.*.tuk' => 'required',
            'laporan.*.bang' => 'required',
            'laporan.*.pim' => 'required',
            'laporan.*.keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('data-polsus-kl.index')->withErrors($validator);
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
                    $laporan = DataPolsusKl::create($item);
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

        return redirect()->route('data-polsus-kl.index');
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
            'kementerian' => 'required',
            'nama' => 'required',
            'pangkat' => 'required',
            'nip' => 'required',
            'golongan' => 'required',
            'ttl' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'jabatan' => 'required',
            'wilayah_penugasan' => 'required',
            'dik_umum' => 'required',
            'tuk' => 'required',
            'bang' => 'required',
            'pim' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('data-polsus-kl.index')->withErrors($validator);
        }
        $validated = $validator->validate();
        try {
            DataPolsusKl::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-polsus-kl.index');
    }

    public function destroy($id) {
        try {
            DataPolsusKl::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'laporan data anggota polsus.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binanevpolsus.data-polsus-kl.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'laporan data anggota polsus - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}