<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasLama;

use App\Exports\Sislap\Lapsubjar\Binpolmas\DataSenkomExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataSenkom;
use App\Services\Sislap\Lapsubjar\Binpolmas\DataSenkomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class DataSenkomController extends Controller
{
    protected $model = DataSenkom::class;
    private DataSenkomService $service;

    public function __construct(DataSenkomService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.data-senkom.index', ['model' => addcslashes($this->model, "\\")]);
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
            'laporan.*.daerah'              => 'required',
            'laporan.*.alamat_sekretariat'  => 'required',
            'laporan.*.nama_ketua'          => 'required',
            'laporan.*.no_hp'               => 'required|numeric',
            'laporan.*.jumlah_anggota'      => 'required|numeric',
            'laporan.*.kegiatan'            => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('data-senkom.index')->withErrors($validator);
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
                    $laporan = DataSenkom::create(array_merge($item, [
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
        return redirect()->route('data-senkom.index');
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
            DataSenkom::find($id)->update([
                'daerah'                => $request->daerah,
                'alamat_sekretariat'    => $request->alamat_sekretariat,
                'nama_ketua'            => $request->nama_ketua,
                'no_hp'                 => $request->no_hp,
                'jumlah_anggota'        => $request->jumlah_anggota,
                'kegiatan' => $request->kegiatan,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-senkom.index');
    }

    public function destroy($id)
    {
        try {
            DataSenkom::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->service, true), 'laporan data senkom mitra polri.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binpolmas.data-senkom.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan data senkom mitra polri - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
