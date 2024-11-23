<?php

namespace App\Http\Controllers\Laporan\Bhabin\Giat;

use App\Models\Deteksi_dini;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bhabin\Laporan\ValidateDeteksiDiniRequest;
use App\Models\Provinsi;
use App\Services\Interfaces\DeteksiDiniServiceInterface;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;

class DeteksiDiniController extends Controller
{
    private $deteksiDiniService;

    /**
     * DeteksiDiniController constructor.
     * @param DeteksiDiniServiceInterface $deteksiDiniService
     */
    public function __construct(DeteksiDiniServiceInterface $deteksiDiniService)
    {
        $this->deteksiDiniService = $deteksiDiniService;
    }

    public function index()
    {
        return view('bhabin.laporan.giat.deteksi-dini.index', [
            'countDeteksiDini' => Deteksi_dini::where('user_id', auth()->user()->id)->count()
        ]);
    }

    public function getDatatable()
    {
        if (request()->ajax()) {
            return $this->deteksiDiniService->getDatatable();
        }
    }

    public function create()
    {
        $provinsi = Provinsi::orderBy('id')->pluck('name', 'code');

        return view('bhabin.laporan.giat.deteksi-dini.create', [
            'provinsi' => $provinsi
        ]);
    }

    public function store(ValidateDeteksiDiniRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->deteksiDiniService->store($request->validated());
            DB::commit();
            $this->flashSuccess('Berhasil Menambahkan Laporan');
            return redirect()->route('deteksi-dini.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
        }

    }

    public function show()
    {

    }

    public function edit($id)
    {
        $provinsi = Provinsi::pluck('name', 'code');
        $laporan = $this->deteksiDiniService->show($id);

        if (!$laporan) {
            $this->flashError('Anda tidak memiliki hak akses ke laporan ini.');
            return redirect()->back();
        }

        return view('bhabin.laporan.giat.deteksi-dini.edit', compact('provinsi', 'laporan'));
    }

    public function update(ValidateDeteksiDiniRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->deteksiDiniService->update($request->validated(), $id);
            DB::commit();
            $this->flashSuccess('Berhasil Mengedit Laporan');
            return redirect()->route('deteksi-dini.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->deteksiDiniService->delete($id);
            DB::commit();

            return $this->responseSuccess([
                'message' => 'Berhasil menghapus data'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseError($exception);
        }
    }

    public function search(Request $request)
    {
        $laporanQuery = Deteksi_dini::where('user_id', auth()->user()->id)->where('nama_narasumber', 'ilike', '%' . $request->cari . '%')
            ->orWhere('keyword', 'ilike', '%' . $request->cari . '%')->paginate(10);
        return view('bhabin.laporan.giat.deteksi-dini.index', compact('laporanQuery'));
    }

    public function pdf($id)
    {
        $data = Deteksi_dini::with('laporan_informasi')
                            ->leftJoin('personel', 'personel.user_id', '=', 'deteksi_dinis.user_id')
                            ->findOrFail($id);
        $lokasi = explode(',', auth()->user()->lokasiPenugasans()->first()->lokasi);
        $pdf = PDF::loadView('bhabin.laporan.giat.deteksi-dini.pdf', compact('data', 'lokasi'));
        return $pdf->stream('laporan.pdf');
    }

    public function getNarasumber()
    {
        return $this->deteksiDiniService->getSelectNarasumber();
    }

    public function getLatestReport()
    {
        $data = Deteksi_dini::where('user_id', auth()->user()->id)
            ->with('laporan_informasi')
            ->orderBy('created_at', 'desc')->first();

        return response()->json($data);
    }
}
