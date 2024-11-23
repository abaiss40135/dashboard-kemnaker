<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul\Laporan3t;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Nonlapbul\Laporan3t\LapharTracing as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Nonlapbul\Laporan3t\LapharTracing;
use App\Services\Interfaces\Sislap\Nonlapbul\Laporan3t\LapharTracingServiceInterface;
use App\Services\Sislap\Nonlapbul\Laporan3t\LapharTracingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class LapharTracingController extends Controller
{
    protected $model = LapharTracing::class;
    /**
     * @var LapharTracingServiceInterface
     */
    private $lapharTracingService;

    /**
     * @param LapharTracingServiceInterface $lapharTracingService
     */
    public function __construct(LapharTracingService $lapharTracingService)
    {
        $this->lapharTracingService = $lapharTracingService;
    }


    public function index()
    {
        return view('administrator.sislap.nonlapbul.laporan3t.laphar-tracing.index', [
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);

        $validator = Validator::make($request->all(), [
            'laporan.*.nama_polres'     => 'required',
            'laporan.*.jumlah_pasien'   => 'required|numeric',
            'laporan.*.tracing_pasien_sudah_sembuh' => 'required',
            'laporan.*.tracing_pasien_sudah_md'     => 'required',
            'laporan.*.tracing_pasien_tanpa_alamat' => 'required',
            'laporan.*.tracing_pasien_domisi_luar_daerah' => 'required',
            'laporan.*.tracing_pasien_isoman'       => 'required',
            'laporan.*.tracing_pasien_isoter'       => 'required',
            'laporan.*.tracing_pasien_rawat_inap'   => 'required',
            'laporan.*.jumlah_kontak_erat'          => 'required|numeric',
            'laporan.*.tracing_kontak_erat_sehat'   => 'required',
            'laporan.*.tracing_kontak_erat_isoman'  => 'required',
            'laporan.*.tracing_kontak_erat_isoter'  => 'required',
            'laporan.*.tracing_kontak_erat_dirawat' => 'required',
            'laporan.*.tracing_kontak_erat_tanpa_alamat'  => 'required',
            'laporan.*.tracing_kontak_erat_domisili_luar_daerah' => 'required',
            'laporan.*.dll'             => 'required',
            'laporan.*.keterangan'      => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('laphar-tracing.index')->withErrors($validator);
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
                    $laporan = LapharTracing::create(array_merge($item, [
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
        return redirect()->route('laphar-tracing.index');
    }

    public function update(Request $request, $id)
    {
        try {
            LapharTracing::find($id)->update([
                'nama_polres' => $request->nama_polres,
                'jumlah_pasien' => $request->jumlah_pasien,
                'tracing_pasien_sudah_sembuh' => $request->tracing_pasien_sudah_sembuh,
                'tracing_pasien_sudah_md' => $request->tracing_pasien_sudah_md,
                'tracing_pasien_tanpa_alamat' => $request->tracing_pasien_tanpa_alamat,
                'tracing_pasien_domisi_luar_daerah' => $request->tracing_pasien_domisi_luar_daerah,
                'tracing_pasien_isoman' => $request->tracing_pasien_isoman,
                'tracing_pasien_isoter' => $request->tracing_pasien_isoter,
                'tracing_pasien_rawat_inap' => $request->tracing_pasien_rawat_inap,
                'jumlah_kontak_erat' => $request->jumlah_kontak_erat,
                'tracing_kontak_erat_sehat' => $request->tracing_kontak_erat_sehat,
                'tracing_kontak_erat_isoman' => $request->tracing_kontak_erat_isoman,
                'tracing_kontak_erat_isoter' => $request->tracing_kontak_erat_isoter,
                'tracing_kontak_erat_dirawat' => $request->tracing_kontak_erat_dirawat,
                'tracing_kontak_erat_tanpa_alamat' => $request->tracing_kontak_erat_tanpa_alamat,
                'tracing_kontak_erat_domisili_luar_daerah' => $request->tracing_kontak_erat_domisili_luar_daerah,
                'dll' => $request->dll,
                'keterangan' => $request->keterangan,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('laphar-tracing.index');
    }

    public function destroy($id)
    {
        try {
            LapharTracing::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function templateExcel(Excel $excel)
    {
        return $excel->download(new TemplateLaporan($this->lapharTracingService, true),  'laporan data tracing dan kontak erat.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.nonlapbul.laporan3t.laphar-tracing.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportExcel(Excel $excel, TemplateLaporan $excelLaphar)
    {
        return $excel->download($excelLaphar, 'laporan data tracing dan kontak erat - ' . now()->translatedFormat(config('app.long_date_without_day_format')) . '.xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        return response()->json($this->lapharTracingService->search($request));
    }
}
