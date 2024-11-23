<?php

namespace App\Http\Controllers\Laporan\Bhabin\Giat\DDS;

use App\Http\Requests\Bhabin\Laporan\DDSWarga\TempatUsaha\StoreDDSTempatUsahaRequest;
use App\Http\Requests\Bhabin\Laporan\DDSWarga\TempatUsaha\UpdateDDSTempatUsahaRequest;
use App\Models\Giat\DDSTempatUsaha;
use App\Services\Interfaces\DDSTempatUsahaServiceInterface;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;

class DDSUsahaController extends Controller
{
    /**
     * @var DDSTempatUsahaServiceInterface
     */
    private $DDSTempatUsahaService;

    public function __construct(DDSTempatUsahaServiceInterface $DDSTempatUsahaService)
    {
        $this->DDSTempatUsahaService = $DDSTempatUsahaService;
    }

    public function getDatatable()
    {
        return $this->DDSTempatUsahaService->getDatatable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countLaporan = DDSTempatUsaha::where('user_id', auth()->user()->id)->count();
        return view('bhabin.laporan.giat.dds.usaha.index', compact('countLaporan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $DDS = null;
        if (request()->has('dds_tempat_usaha_id')){
            $DDS = DDSTempatUsaha::with(['karyawans', 'penanggung_jawab_usaha', 'penanggung_jawab_keamanan'])->find(request()->get('dds_tempat_usaha_id'));
        }
        return view('bhabin.laporan.giat.dds.usaha.create', compact('DDS'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDDSTempatUsahaRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDDSTempatUsahaRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->DDSTempatUsahaService->store($request->validated());
            DB::commit();
            $this->flashSuccess('Laporan DDS Tempat Usaha berhasil ditambahkan');
            return redirect()->route('dds.tempat-usaha.index');
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
        return $this->DDSTempatUsahaService->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $DDS = $this->DDSTempatUsahaService->show($id);
        return view('bhabin.laporan.giat.dds.usaha.edit', compact('DDS'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDDSTempatUsahaRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDDSTempatUsahaRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $this->DDSTempatUsahaService->update($request->validated(), $id);
            $this->flashSuccess('DDS Tempat Usaha berhasil diupdate');
            return redirect()->route('dds.tempat-usaha.index');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->DDSTempatUsahaService->delete($id);
            return $this->responseSuccess([
                'message' => 'Laporan DDS Tempat Usaha berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function exportPDF($id)
    {
        $pdf = PDF::loadView('bhabin.laporan.giat.dds.usaha.pdf', [
            'data' => $this->DDSTempatUsahaService->show($id)->load('personel')
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-dds-tempat-usaha.pdf');
    }
}
