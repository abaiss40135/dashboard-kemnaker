<?php

namespace App\Http\Controllers\Admin\Sislap\Lapbul\Pembinaan;

use App\Exports\Sislap\Lapbul\Pembinaan\PersonelKorbinmas as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapbul\Pembinaan\PersonelKorbinmas;
use App\Services\Sislap\Lapbul\Pembinaan\PersonelKorbinmasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PersonelKorbinmasController extends Controller
{
    protected $model = PersonelKorbinmas::class;
    private $service;

    public function __construct(PersonelKorbinmasService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('administrator.sislap.lapbul.pembinaan.format-4-15.index', [
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
            'laporan.*.satker' => 'required',
            'laporan.*.bulan' => 'required',
            'laporan.*.irjen_dsp' => 'numeric',
            'laporan.*.irjen_riil' => 'numeric',
            'laporan.*.brigjen_dsp' => 'numeric',
            'laporan.*.brigjen_riil' => 'numeric',
            'laporan.*.kbp_dsp' => 'numeric',
            'laporan.*.kbp_riil' => 'numeric',
            'laporan.*.akbp_dsp' => 'numeric',
            'laporan.*.akbp_riil' => 'numeric',
            'laporan.*.kp_dsp' => 'numeric',
            'laporan.*.kp_riil' => 'numeric',
            'laporan.*.akp_dsp' => 'numeric',
            'laporan.*.akp_riil' => 'numeric',
            'laporan.*.ip_dsp' => 'numeric',
            'laporan.*.ip_riil' => 'numeric',
            'laporan.*.ba_ta_dsp' => 'numeric',
            'laporan.*.ba_ta_riil' => 'numeric',
            'laporan.*.pns_4_dsp' => 'numeric',
            'laporan.*.pns_4_riil' => 'numeric',
            'laporan.*.pns_3_dsp' => 'numeric',
            'laporan.*.pns_3_riil' => 'numeric',
            'laporan.*.pns_1_2_dsp' => 'numeric',
            'laporan.*.pns_1_2_riil' => 'numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('personel-korbinmas.index')->withErrors($validator);
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
                    $laporan = PersonelKorbinmas::create(array_merge($item, [
                        'user_id'       => $user->id,
                        'kode_satuan'   => $kode_satuan
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

        return redirect()->route('personel-korbinmas.index');
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
            'satker' => 'required',
            'bulan' => 'required',
            'irjen_dsp' => 'numeric',
            'irjen_riil' => 'numeric',
            'brigjen_dsp' => 'numeric',
            'brigjen_riil' => 'numeric',
            'kbp_dsp' => 'numeric',
            'kbp_riil' => 'numeric',
            'akbp_dsp' => 'numeric',
            'akbp_riil' => 'numeric',
            'kp_dsp' => 'numeric',
            'kp_riil' => 'numeric',
            'akp_dsp' => 'numeric',
            'akp_riil' => 'numeric',
            'ip_dsp' => 'numeric',
            'ip_riil' => 'numeric',
            'ba_ta_dsp' => 'numeric',
            'ba_ta_riil' => 'numeric',
            'pns_4_dsp' => 'numeric',
            'pns_4_riil' => 'numeric',
            'pns_3_dsp' => 'numeric',
            'pns_3_riil' => 'numeric',
            'pns_1_2_dsp' => 'numeric',
            'pns_1_2_riil' => 'numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('personel-korbinmas.index')->withErrors($validator);
        }

        $validated = $validator->validate();

        try {
            PersonelKorbinmas::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('personel-korbinmas.index');
    }

    public function destroy($id)
    {
        try {
            PersonelKorbinmas::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan($this->service, true), 'data personel korbinmas.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapbul.pembinaan.format-4-15.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel(TemplateLaporan $template) {
        return Excel::download($template, 'data personel korbinmas - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        return response()->json($this->service->search($request->all()));
    }
}
