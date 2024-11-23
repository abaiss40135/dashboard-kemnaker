<?php

namespace App\Http\Controllers\Laporan\Bhabin\ProgramPemerintah;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bhabin\Laporan\ProgramPemerintah\LaporanPemungutanSuaraCapres2024\LaporanSuaraCapresRequest;
use App\Models\Laporan\ProgramPemerintah\PemungutanSuaraCapres2024;
use App\Services\LaporanPemungutanSuaraCapres2024Service;
use App\Services\ProvinsiService;
use Illuminate\Support\Facades\DB;

class LaporanPemungutanSuaraCapresController extends Controller
{
    private $provinsiService,
        $laporanCapresService;

    public function __construct(LaporanPemungutanSuaraCapres2024Service $laporanPemungutanSuaraCapresService, ProvinsiService $provinsiService)
    {
        $this->laporanCapresService = $laporanPemungutanSuaraCapresService;
        $this->provinsiService = $provinsiService;
    }

    public function getDatatable()
    {
        return $this->laporanCapresService->getDatatable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(403);
        $countLaporan = PemungutanSuaraCapres2024::where('user_id', auth()->user()->id)->count();
        return view('bhabin.laporan.program-pemerintah.laporan-pemungutan-suara-capres.index', compact('countLaporan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['provinsi']   = $this->provinsiService->getSelectProvinsiData()->sortBy('id');
        return view('bhabin.laporan.program-pemerintah.laporan-pemungutan-suara-capres.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaporanSuaraCapresRequest $request)
    {
        DB::beginTransaction();
        try {
            $laporan = $this->laporanCapresService->store($request->validated());

            if($laporan instanceof \Exception){
                throw new \Exception($laporan->getMessage());
            }
            DB::commit();

            $this->flashSuccess('Laporan Pemungutan Suara Capres berhasil ditambahkan untuk wilayah desa ' . $laporan->kelurahan);
            return redirect()->route('program-pemerintah.laporan-pemungutan-suara-capres.index');
        } catch (\Exception $e){
            DB::rollBack();
            $this->flashError($e->getMessage());
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
        $laporan = $this->laporanCapresService->show($id);
        $provinsi   = $this->provinsiService->getSelectProvinsiData()->sortBy('id');
        return view('bhabin.laporan.program-pemerintah.laporan-pemungutan-suara-capres.edit', compact('laporan', 'provinsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LaporanSuaraCapresRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $laporan = $this->laporanCapresService->update($request->validated(), $id);

            if($laporan instanceof \Exception){
                throw new \Exception($laporan->getMessage());
            }
            DB::commit();

            $this->flashSuccess('Laporan berhasil diupdate!');
            return redirect()->route('program-pemerintah.laporan-pemungutan-suara-capres.index');
        } catch (\Exception $exception){
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
        DB::beginTransaction();
        try {
            $this->laporanCapresService->delete($id);
            DB::commit();
            return $this->responseSuccess([
                'message' => 'Laporan Hasil Pemungutan Suara Capres 2024 berhasil dihapus!'
            ]);
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->responseError($exception);
        }
    }
}
