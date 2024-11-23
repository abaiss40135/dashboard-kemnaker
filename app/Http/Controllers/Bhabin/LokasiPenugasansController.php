<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bhabin\LokasiPenugasan\StoreArrayLokasiPenugasanRequest;
use App\Http\Requests\Bhabin\LokasiPenugasan\StoreLokasiPenugasanRequest;
use App\Http\Requests\Bhabin\LokasiPenugasan\UpdateLokasiPenugasanRequest;
use App\Models\LokasiPenugasan;
use App\Services\DDSWargaService;
use App\Services\Interfaces\LokasiPenugasanServiceInterface;
use App\Services\ProvinsiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\IFTTTHandler;

class LokasiPenugasansController extends Controller
{
    private $lokasiPenugasanService;
    private $provinsiService;

    /**
     * LokasiPenugasansController constructor.
     * @param LokasiPenugasanServiceInterface $lokasiPenugasanService
     */
    public function __construct(LokasiPenugasanServiceInterface $lokasiPenugasanService, ProvinsiService $provinsiService)
    {
        $this->lokasiPenugasanService = $lokasiPenugasanService;
        $this->provinsiService = $provinsiService;
    }

    public function getDatatable()
    {
        if (request()->ajax()){
            return $this->lokasiPenugasanService->getDatatable();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $provinces  = $this->provinsiService->getSelectData();
        $polda      = auth()->user()->personel->polda;
        return view('bhabin.lokasi-penugasan.create', compact('provinces', 'polda'));
    }

    public function storeSatuan(StoreLokasiPenugasanRequest $request)
    {
        DB::beginTransaction();
        try {
            $lokasi = $this->lokasiPenugasanService->store($request->validated());
            DB::commit();
            return $this->responseSuccess([
                'data' => $lokasi,
                'message' => 'Data lokasi penugasan berhasil ditambahkan'
            ]);
        } catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
            return $this->responseError($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreArrayLokasiPenugasanRequest $request)
    {
        DB::beginTransaction();
        try {
            $lokasi = $this->lokasiPenugasanService->store($request->validated());
            $this->flashSuccess('Terima kasih, lokasi Penugasan berhasil ditambahkan!');
            DB::commit();
            return redirect()->route(auth()->user()->role());
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param LokasiPenugasan $lokasiPenugasan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->lokasiPenugasanService->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LokasiPenugasan $lokasiPenugasan
     * @return \Illuminate\Http\Response
     */
    public function edit(LokasiPenugasan $lokasiPenugasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLokasiPenugasanRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLokasiPenugasanRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $lokasi = $this->lokasiPenugasanService->update($request->validated(), $id);
            DB::commit();
            return $this->responseSuccess([
                'message' => 'Data lokasi penugasan berhasil diperbarui',
                'data' => $lokasi
            ]);
        } catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
            return $this->responseError($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->lokasiPenugasanService->delete($id);
            return $this->responseSuccess([
                'message' => 'Data lokasi penugasan berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }
}
