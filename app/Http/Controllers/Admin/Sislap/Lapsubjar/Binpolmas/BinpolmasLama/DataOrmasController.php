<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasLama;

use App\Exports\Sislap\Lapsubjar\Binpolmas\DataOrmasExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataOrmas;
use App\Services\Sislap\Lapsubjar\Binpolmas\DataOrmasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class DataOrmasController extends Controller
{
    protected $model = DataOrmas::class;
    private DataOrmasService $service;

    public function __construct(DataOrmasService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.data-ormas.index', ['model' => addcslashes($this->model, "\\")]);
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
            'laporan.*.nama_kommas'        => 'required',
            'laporan.*.badan_hukum'        => 'required',
            'laporan.*.akta_notaris'       => 'required',
            'laporan.*.pengesahan'         => 'required',
            'laporan.*.npwp'               => 'required',
            'laporan.*.duk_pembina'        => 'required',
            'laporan.*.pengurus'           => 'required',
            'laporan.*.bergerak'           => 'required',
            'laporan.*.kebijakan'          => 'required',
            'laporan.*.jumlah_anggota'     => 'required',
            'laporan.*.keterangan'         => 'required',
        ]);

         if ($validator->fails()) {
             return redirect()->route('data-ormas.index')->withErrors($validator);
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
                     $laporan = DataOrmas::create(array_merge($item, [
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

        return redirect()->route('data-ormas.index');
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
            DataOrmas::find($id)->update([
                'nama_kommas' => $request->nama_kommas,
                'badan_hukum' => $request->badan_hukum,
                'akta_notaris' => $request->akta_notaris,
                'pengesahan' => $request->pengesahan,
                'npwp' => $request->npwp,
                'duk_pembina' => $request->duk_pembina,
                'pengurus' => $request->pengurus,
                'bergerak' => $request->bergerak,
                'kebijakan' => $request->kebijakan,
                'jumlah_anggota' => $request->jumlah_anggota,
                'keterangan' => $request->keterangan,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-ormas.index');
    }

    public function destroy($id)
    {
        try {
            DataOrmas::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel(Excel $excel) {
        return $excel->download(new TemplateLaporan($this->service, true), 'laporan data ormas binaan.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binpolmas.data-ormas.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function exportExcel(Excel $excel, TemplateLaporan $template) {
        return $excel->download($template, 'laporan data ormas binaan - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
