<?php

namespace App\Http\Controllers\Laporan\Bhabin\Giat\ProblemSolving;

use App\Http\Controllers\Controller;
use App\Models\PsEksekutif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Interfaces\KeywordServiceInterface;
class EksekutifController extends Controller
{
    private $keywordService;

    public function __construct(KeywordServiceInterface $keywordService)
    {
        $this->keywordService = $keywordService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $listLaporan = PsEksekutif::where('user_id', auth()->user()->id)->get();
        $countLaporan = PsEksekutif::where('user_id', auth()->user()->id)->count();
        return view('bhabin.laporan.giat.problem-solving.eksekutif.index', compact(
            'listLaporan', 'countLaporan'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bhabin.laporan.giat.problem-solving.eksekutif.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "tanggal_kejadian" => "required",
            "waktu_kejadian" => "required",
            "lokasi_kejadian" => "required",
            "bidang_masalah" => "required",
            "uraian_kejadian" => "required",
            "keyword" => "required",
            "saksi" => "required",
            "uraian_problem_solving" => "required",
            "pihak_eskalasi_problem_solving" => "required",
        ]);
        $data['penulis'] = auth()->user()->personel->nama;
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $psEksekutif = PsEksekutif::create($data);
            $this->saveKeywords($request, $psEksekutif);
            DB::commit();
            $this->flashSuccess('Sukses menambahkan laporan problem solving');
            return redirect()->route('problem-solving.eksekutif.index');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laporan = PsEksekutif::find($id);
        return view('bhabin.laporan.giat.problem-solving.eksekutif.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "tanggal_kejadian" => "required",
            "waktu_kejadian" => "required",
            "lokasi_kejadian" => "required",
            "bidang_masalah" => "required",
            "uraian_kejadian" => "required",
            "keyword" => "required",
            "saksi" => "required",
            "uraian_problem_solving" => "required",
            "pihak_eskalasi_problem_solving" => "required",
        ]);

        DB::beginTransaction();
        try {
            $psEksekutif = PsEksekutif::find($id);
            $psEksekutif->update($data);
            $this->saveKeywords($request, $psEksekutif);
            DB::commit();

            $this->flashSuccess('Sukses mengupdate laporan');
            return redirect()->route('problem-solving.eksekutif.index');
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
        $psEksekutif = PsEksekutif::find($id);
        $psEksekutif->keywords()->detach();
        $psEksekutif::destroy($id);
        $this->flashSuccess('Sukses menghapus laporan');
        return redirect()->route('problem-solving.eksekutif.index');
    }

    private function saveKeywords(Request $request, $laporan)
    {
        $keyword = explode(',', $request->keyword);
        $keywords = $this->keywordService->store([
            'keyword' => $keyword,
            'tanggal' => $request->tanggal_kejadian
        ]);
        $laporan->keywords()->sync(collect($keywords)->pluck('id'));
    }
}
