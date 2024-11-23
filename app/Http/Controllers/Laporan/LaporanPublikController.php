<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateLaporanPublikRequest;
use App\Models\LaporanPublik;
use App\Models\Provinsi;
use App\Services\Interfaces\LaporanPublikServiceInterface;
use Illuminate\Support\Facades\DB;

class LaporanPublikController extends Controller
{
    public $laporanPublikService;

    public function __construct(LaporanPublikServiceInterface $laporanPublikService)
    {
        $this->laporanPublikService = $laporanPublikService;
    }

    public function getDatatable() {
        if (request()->ajax()){
            return $this->laporanPublikService->getDatatable();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->checkPermission('laporan_publik_access');
        return view('publik.laporan.index', [
            'countLaporan' => LaporanPublik::where('user_id', auth()->user()->id)->count()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Provinsi::orderBy('id')->pluck('name', 'code');
        return view('publik.laporan.create', ['provinces' => $provinces]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateLaporanPublikRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->laporanPublikService->store($request->validated());
            DB::commit();
            $this->flashSuccess('Berhasil Menambahkan Laporan');
            return redirect()->route('laporan-publik.index');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
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
        $data = LaporanPublik::where('id' , $id)->first();
        return view('publik.laporan.edit' , compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function update(ValidateLaporanPublikRequest $request, $id) {
        DB::beginTransaction();
        try {
            $this->laporanPublikService->update($request->validated(), $id);
            DB::commit();
            $this->flashSuccess('Berhasil Mengedit Laporan');
            return redirect()->route('laporan-publik.index');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::beginTransaction();
        try {
            $laporanPublik = LaporanPublik::find($id);

            $laporanPublik->laporan_informasi->keywords()->detach();
            $laporanPublik->laporan_informasi()->delete();
            $laporanPublik->destroy($id);
            DB::commit();
            $this->flashSuccess('Berhasil Menghapus Laporan');
            return redirect()->route('laporan-publik.index');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
        }
    }
}
