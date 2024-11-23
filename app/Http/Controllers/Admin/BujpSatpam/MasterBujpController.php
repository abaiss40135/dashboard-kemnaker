<?php

namespace App\Http\Controllers\Admin\BujpSatpam;

use App\Exports\BujpExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\UpdateBujpRequest;
use App\Services\Interfaces\BUJPServiceInterface;
use App\Services\Interfaces\PencarianBUJPServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class MasterBujpController extends Controller
{

    /**
     * @var BUJPServiceInterface
     */
    private $bujpService;
    /**
     * @var PencarianBUJPServiceInterface
     */
    private $pencarianBUJPService;

    public function __construct(BUJPServiceInterface $BUJPService, PencarianBUJPServiceInterface $pencarianBUJPService)
    {
        $this->bujpService = $BUJPService;
        $this->pencarianBUJPService = $pencarianBUJPService;
    }

    public function index()
    {
        $this->checkPermission('master_bujp_access');
        return view('administrator.bujp-satpam.master-bujp');
    }

    public function getSelect2()
    {
        return $this->bujpService->getSelectData();
    }

    public function getSelect2Wilayah()
    {
        return $this->bujpService->getSelect2Wilayah();
    }

    public function list()
    {
        return $this->pencarianBUJPService->list(request()->all());
    }

    public function search(Request $request)
    {
        return $this->pencarianBUJPService->list($request->all());
    }

    public function export(Excel $excel, BujpExport $export)
    {
        return $excel->download($export, 'Ekspor BUJP - ' . now()->translatedFormat(config('app.long_date_without_day_format')) . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBujpRequest $request, $id)
    {
        $this->checkPermission('master_bujp_edit');

        $this->bujpService->update($request->validated(), $id);

        $this->flashSuccess("Berhasil mengedit data BUJP!");
        return redirect()->route("master-bujp.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkPermission('master_bujp_destroy');

        $this->bujpService->destroy($id);

        $this->flashSuccess("Berhasil menghapus data BUJP!");
        return redirect()->route("master-bujp.index");
    }
}
