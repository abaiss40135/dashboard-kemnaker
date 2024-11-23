<?php

namespace App\Http\Controllers\Laporan\Bhabin\Giat\ProblemSolving;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bhabin\Laporan\ProblemSolving\ValidateNonSengketaRequest;
use App\Models\PsNonSengketa;
use App\Services\Interfaces\PSNonSengketaServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Services\Interfaces\KeywordServiceInterface;

class NonSengketaController extends Controller
{
    private $keywordService;
    /**
     * @var PSNonSengketaServiceInterface
     */
    private $PSNonSengketaService;

    public function __construct(KeywordServiceInterface $keywordService, PSNonSengketaServiceInterface $PSNonSengketaService)
    {
        $this->keywordService = $keywordService;
        $this->PSNonSengketaService = $PSNonSengketaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $countLaporan = PsNonSengketa::where('user_id', auth()->user()->id)->count();
        return view('bhabin.laporan.giat.problem-solving.non-sengketa.index', compact(
             'countLaporan'
        ));
    }

    public function getDatatable()
    {
        return $this->PSNonSengketaService->getDatatable();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $latest_laporan = PsNonSengketa::where('user_id', auth()->user()->id)
                                       ->orderBy('created_at', 'desc')->first();
        return view('bhabin.laporan.giat.problem-solving.non-sengketa.create', [
            'latest_laporan' => $latest_laporan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ValidateNonSengketaRequest $request)
    {
        $data = $request->except(['_token', 'keyword']);
        $data['penulis'] = auth()->user()->personel->nama;
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $psNonSengketa = PsNonSengketa::create($data);
            $this->saveKeywords($request, $psNonSengketa);
            DB::commit();
            $this->flashSuccess('Berhasil Menambahkan Laporan Problem Solving 2');
            return redirect()->route('problem-solving.non-sengketa.index');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laporan = auth()->user()->psNonSengketas()->with('keywords:id,keyword')->find($id);

        if (!$laporan) {
            $this->flashError('Anda tidak memiliki hak akses ke laporan ini.');
            return redirect()->back();
        }

        return view('bhabin.laporan.giat.problem-solving.non-sengketa.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ValidateNonSengketaRequest $request, $id)
    {
        $data = $request->except(['_token', 'keyword']);
        $oldKeyword = PsNonSengketa::find($id)->first();

        DB::beginTransaction();
        try {
            $psNonSengketa = PsNonSengketa::find($id);
            $psNonSengketa->update($data);
            $this->saveKeywords($request, $psNonSengketa);
            DB::commit();

            $this->flashSuccess('Berhasil Mengedit Laporan Problem Solving 2');
            return redirect()->route('problem-solving.non-sengketa.index');
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->PSNonSengketaService->delete($id);
        } catch (\Throwable $th) {
            $this->flashError($th->getMessage());
            return redirect()->route('problem-solving.non-sengketa.index');
        }

        $this->flashSuccess('Berhasil menghapus laporan');
        return redirect()->route('problem-solving.non-sengketa.index');
    }

    private function saveKeywords(Request $request, $laporan)
    {
        $keywords = $this->keywordService->store([
            'keyword' => $request->keyword,
            'tanggal' => $request->tanggal_kejadian
        ]);
        $laporan->keywords()->sync(collect($keywords)->pluck('id'));
    }

    public function pdf($id){
        $data = PsNonSengketa::with('personel')->where('ps_non_sengketas.id', $id)->leftJoin('personel', 'personel.user_id', '=', 'ps_non_sengketas.user_id')->first();
        $lokasi = explode(',', auth()->user()->lokasiPenugasans()->first()->lokasi);
        $locationType = auth()->user()->lokasiPenugasans()->first()->jenis_lokasi;
        $pdf = PDF::loadView('bhabin.laporan.giat.problem-solving.template.pdf.single-pdf-template', compact('data', 'lokasi' , 'locationType'));
        return $pdf->stream('problem-solving.pdf');
    }

    public function getNarasumber()
    {
        return $this->PSNonSengketaService->getSelectNamaNarasumber();
    }
}
