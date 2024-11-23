<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Http\Controllers\Controller;
use App\Models\Sislap\Nonlapbul\LapharMinyakGoreng;
use Illuminate\Http\Request;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Exports\Sislap\Nonlapbul\LapharMinyakGoreng as templateLaporan;
use App\Services\Sislap\Nonlapbul\LapharMinyakGorengService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class NeoLapharMinyakGorengController extends Controller
{
    protected $model = LapharMinyakGoreng::class;

    private $lapharMinyakGorengService;

    public function __construct()
    {
        $this->lapharMinyakGorengService = new LapharMinyakGorengService();
    }

    public function index() {
        return view('administrator.sislap.nonlapbul.neo-laphar-minyak-goreng.index', [
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

        $validator = Validator::make($request->all(), [
            'laporan.*.kab_kota'        => 'required',
            'laporan.*.kelurahan'       => 'required',
            'laporan.*.nama_pasar'      => 'required',
            'laporan.*.alamat_pasar'    => 'required',
            'laporan.*.ketersediaan'    => 'required',
            'laporan.*.kebutuhan'       => 'required',
            'laporan.*.pola_pengiriman' => 'required',
            'laporan.*.harga_tertinggi' => 'required|numeric',
            'laporan.*.harga_terendah'  => 'required|numeric',
            'laporan.*.harga_rerata'    => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->route('neo-laphar-minyak-goreng.index')->withErrors($validator);
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
                    $laporan = LapharMinyakGoreng::create(array_merge($item, [
                        'user_id'               => $user->id,
                        'kode_satuan'           => $kode_satuan
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
        return redirect()->route('neo-laphar-minyak-goreng.index');
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
            'kab_kota'        => 'required',
            'kelurahan'       => 'required',
            'nama_pasar'      => 'required',
            'alamat_pasar'    => 'required',
            'ketersediaan'    => 'required',
            'kebutuhan'       => 'required',
            'pola_pengiriman' => 'required',
            'harga_tertinggi' => 'required|numeric',
            'harga_terendah'  => 'required|numeric',
            'harga_rerata'    => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->route('neo-laphar-minyak-goreng.index')->withErrors($validator);
        }

        $validated = $validator->validate();

        try {
            LapharMinyakGoreng::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('neo-laphar-minyak-goreng.index');
    }

    public function destroy($id) {
        try {
            LapharMinyakGoreng::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel()
    {
        return (new TemplateLaporan(true))->download('laphar minyak goreng.xlsx');
    }

    public function templateData()
    {
        return response()->download(public_path('files/data-pasar-nasional.xlsx'));
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.nonlapbul.neo-laphar-minyak-goreng.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel()
    {
        return (new templateLaporan())
            ->download('laporan harian minyak goreng - '
                .now()->translatedFormat(config('app.long_date_without_day_format'))
                .'.xlsx'
            );
    }

    public function search(Request $request) {
        return response()->json($this->lapharMinyakGorengService->search($request));
    }
}
