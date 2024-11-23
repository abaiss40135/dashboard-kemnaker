<?php

namespace App\Http\Controllers\Laporan\Bhabin\Giat;

use App\Jobs\UpdateJumlahKeywordJob;
use App\Models\Problem_solving;
use App\Models\Provinsi;
use App\Services\Interfaces\KeywordServiceInterface;
use App\Services\Interfaces\ProblemSolvingServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bhabin\Laporan\StorePsSengketaRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PDF;

class ProblemSolvingController extends Controller
{
    private $keywordService, $problemSolvingService;

    /**
     * ProblemSolvingController constructor.
     * @param KeywordServiceInterface $keywordService
     */
    public function __construct(KeywordServiceInterface $keywordService, ProblemSolvingServiceInterface $problemSolvingService)
    {
        $this->keywordService = $keywordService;
        $this->problemSolvingService = $problemSolvingService;
    }

    public function index() {
        return view('bhabin.laporan.giat.problem-solving.index', [
            'laporanQuery' => Problem_solving::where('user_id', auth()->user()->id)->latest()->paginate(10)
        ]);
    }
    public function create() {
        $provinsi = Provinsi::pluck('name', 'code');
        return view('bhabin.laporan.giat.problem-solving.sengketa.create', compact('provinsi'));
    }
    public function store(StorePsSengketaRequest $request) {
        DB::beginTransaction();
        try {
            $this->problemSolvingService->store($request->validated());
            DB::commit();
            $this->flashSuccess('Problem Solving berhasil ditambahkan');
            return redirect()->route('problem-solving.index');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|Response|View
     */
    public function show()
    {
        //
    }

    public function edit($id) {
        $laporan = Problem_solving::find($id);
        $provinsi = Provinsi::pluck('name', 'code');
        return view('bhabin.laporan.giat.problem-solving.sengketa.edit', compact('laporan', 'provinsi'));
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            "tanggal" => "required",
            "waktu_kejadian" => "required",
            "nama_pihak_1" => "required",
            "pekerjaan_pihak_1" => "required",
            "alamat_pihak_1" => "required",
            "provinsi_pihak_1" => "required",
            "kabupaten_pihak_1" => "required",
            "kecamatan_pihak_1" => "required",
            "desa_pihak_1" => "required",
            "rt_pihak_1" => "required",
            "rw_pihak_1" => "required",
            "nama_pihak_2" => "required",
            "pekerjaan_pihak_2" => "required",
            "alamat_pihak_2" => "required",
            "provinsi_pihak_2" => "required",
            "kabupaten_pihak_2" => "required",
            "kecamatan_pihak_2" => "required",
            "desa_pihak_2" => "required",
            "rt_pihak_2" => "required",
            "rw_pihak_2" => "required",
            "bidang_masalah" => "required",
            "keyword" => "required",
            "uraian_kejadian" => "required",
            "saksi" => "required",
            "nama_narasumber" => $request->nama_narasumber,
            "pekerjaan_narasumber" => $request->pekerjaan_narasumber,
            "alamat_narasumber" => $request->alamat_narasumber,
            "hari_masalah_selesai" => $request->hari_selesai,
            "tanggal_masalah_selesai" => $request->hari_selesai,
            "uraian_problem_solving" => "required",
        ]);
        $data['penulis'] = auth()->user()->personel->nama;
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $problem_solving = Problem_solving::find($id);
            $problem_solving->update($data);
            $this->saveKeywords($request, $problem_solving);
            DB::commit();

            $this->flashSuccess('Berhasil mengupdate data');
            return redirect()->route('problem-solving.index');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id) {
        $problemSolving = Problem_solving::find($id);
        if ($problemSolving->has('keywords')) {
            $problemSolving->keywords()->detach();
        }
        $problemSolving::destroy($id);
        $this->flashSuccess('Berhasil menghapus data');
        return redirect()->route('problem-solving.index');
    }

    public function search(Request $request) {
        $laporanQuery = Problem_solving::where('user_id', auth()->user()->id)->where('nama_pihak_1', 'ilike', '%'.$request->cari.'%')
            ->orWhere('nama_pihak_2', 'ilike', '%'.$request->cari.'%')
            ->orWhere('bidang_masalah', 'ilike', '%'.$request->cari.'%')
            ->orWhere('keyword', 'ilike', '%'.$request->cari.'%')->paginate(10);
        return view('bhabin.laporan.giat.problem-solving.index', compact('laporanQuery'));
    }

    private function saveKeywords($request, $problemSolving)
    {
        $keyword = explode(',', $request->keyword);

        $keywords = $this->keywordService->store([
            'keyword' => $keyword,
            'tanggal' => $request->tanggal_kejadian
        ]);
        $problemSolving->keywords()->sync(collect($keywords)->pluck('id'));
        foreach ($keywords as $keyword) {
            UpdateJumlahKeywordJob::dispatch($keyword, $keyword->loadCount('laporanInformasis')->laporan_informasi_count);
        }
    }

    public function pdf(){
        $ps = Problem_solving::with('personel')->leftJoin('personel', 'personel.user_id', '=', 'problem_solvings.user_id')
                                                ->leftJoin('ps_non_sengketas', 'ps_non_sengketas.user_id', '=', 'problem_solvings.user_id')->get();
        // $nonSengketa = PsNonSengketa::with('personel')->leftJoin('personel', 'personel.user_id', '=', 'ps_non_sengketas.user_id')->get();
        $lokasi = explode(',', auth()->user()->lokasiPenugasans()->first()->lokasi);

        $data = $ps;
        $pdf = PDF::loadView('bhabin.laporan.giat.problem-solving.template.pdf.multiple-pdf-template', compact('data', 'lokasi'));
        return $pdf->stream('problem-solving.pdf');
    }

}
