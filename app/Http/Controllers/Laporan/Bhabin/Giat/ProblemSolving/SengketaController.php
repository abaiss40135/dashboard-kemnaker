<?php

namespace App\Http\Controllers\Laporan\Bhabin\Giat\ProblemSolving;

use App\Models\Problem_solving;
use App\Models\Provinsi;
use App\Services\Interfaces\KeywordServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bhabin\Laporan\StorePsSengketaRequest;
use App\Services\Interfaces\PSSengketaServiceInterface;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SengketaController extends Controller
{
    private $keywordService, $psSengketaService;

    /**
     * ProblemSolvingController constructor.
     * @param KeywordServiceInterface $keywordService
     */
    public function __construct(KeywordServiceInterface $keywordService, PSSengketaServiceInterface $psSengketaService)
    {
        $this->keywordService = $keywordService;
        $this->psSengketaService = $psSengketaService;
    }

    private function addSKB($file)
    {
        $this->uploadPath = auth()->user()->nrp;
        $this->folderName = 'sengketa/skb/';

        return $this->saveFiles($file);
    }

    public function getDatatable()
    {
        if (request()->ajax()) return $this->psSengketaService->getDatatable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('bhabin.laporan.giat.problem-solving.sengketa.index', [
            'existLaporan' => Problem_solving::where('user_id', auth()->user()->id)->exists()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = Provinsi::orderBy('id')->pluck('name', 'code');
        $latest_laporan = Problem_solving::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();

        return view('bhabin.laporan.giat.problem-solving.sengketa.create', [
            'provinsi' => $provinsi,
            'latest_laporan' => $latest_laporan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePsSengketaRequest $request) {
        $data = $request->except('surat_kesepakatan', 'keyword');
        $data["surat_kesepakatan"] = $this->addSKB($request->surat_kesepakatan);
        $data["penulis"] = auth()->user()->personel->nama;
        $data["polda"]   = Str::after(auth()->user()->personel->polda, 'POLDA ');
        $data["user_id"] = auth()->user()->id;
        DB::beginTransaction();
        try {
            $problemSolving = Problem_solving::create($data);
            $this->saveKeywords($request, $problemSolving);
            DB::commit();
            $this->flashSuccess('Berhasil menambahkan laporan problem solving');
            return redirect()->route('problem-solving.sengketa.index');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $laporan = auth()->user()->psSengketas()->with('keywords:id,keyword')->find($id);
        $provinsi = Provinsi::pluck('name', 'code');

        if (!$laporan) {
            $this->flashError('Anda tidak memiliki hak akses ke laporan ini.');
            return redirect()->back();
        }

        return view('bhabin.laporan.giat.problem-solving.sengketa.edit', compact('laporan', 'provinsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StorePsSengketaRequest $request, $id)
    {
        $data = $request->except('surat_kesepakatan', 'keyword');
        if ($request->surat_kesepakatan) {
            $this->psSengketaService->deleteSKB($id);
            $data["surat_kesepakatan"] = $this->addSKB($request->surat_kesepakatan);
        }
        $data["penulis"] = auth()->user()->personel->nama;
        $data["user_id"] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $problem_solving = Problem_solving::find($id);
            $problem_solving->update($data);
            $this->saveKeywords($request, $problem_solving);
            DB::commit();

            $this->flashSuccess('Berhasil mengupdate laporan problem solving');
            return redirect()->route('problem-solving.sengketa.index');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->psSengketaService->delete($id);
        } catch (\Throwable $th) {
            $this->flashError($th->getMessage());
            return redirect()->route('problem-solving.sengketa.index');
        }

        $this->flashSuccess('Sukses menghapus data');
        return redirect()->route('problem-solving.sengketa.index');
    }

    private function saveKeywords(Request $request, $laporan)
    {
        $keywords = $this->keywordService->store([
            'keyword' => $request->keyword,
            'tanggal' => $request->tanggal
        ]);
        $laporan->keywords()->sync(collect($keywords)->pluck('id'));
    }

    public function pdf($id){
        $data = Problem_solving::with('personel')
            ->findOrFail($id);
        $lokasi = explode(',', auth()->user()->lokasiPenugasans()->first()->lokasi);
        $locationType = auth()->user()->lokasiPenugasans()->first()->jenis_lokasi;
        $pdf = PDF::loadView('bhabin.laporan.giat.problem-solving.template.pdf.single-pdf-template', compact('data', 'lokasi' , 'locationType'));
        return $pdf->stream('problem-solving.pdf');
    }

    public function skb($id) {
        $data = Problem_solving::with('personel')
                        ->findOrFail($id);
        $lokasi = explode(',', auth()->user()->lokasiPenugasans()->first()->lokasi);
        $locationType = auth()->user()->lokasiPenugasans()->first()->jenis_lokasi;
        $pdf = PDF::loadView('bhabin.laporan.giat.problem-solving.sengketa.skb', compact('data', 'lokasi' , 'locationType'))->setPaper('a4', 'potrait');
        return $pdf->stream('skb.pdf');
    }

    public function getPihakTerkait()
    {
        return $this->psSengketaService->getSelectPihakTerkait();
    }
}
