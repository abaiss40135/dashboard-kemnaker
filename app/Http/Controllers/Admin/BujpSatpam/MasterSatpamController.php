<?php

namespace App\Http\Controllers\Admin\BujpSatpam;

use App\Exports\SatpamExport;
use App\Models\Satpam;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;
use App\Services\Interfaces\SatpamServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\Export\MasterSatpam\ExcelSatpam;

class MasterSatpamController extends Controller
{
    /**
     * @var SatpamServiceInterface
     */
    private $satpamService;

    public function __construct(SatpamServiceInterface $satpamService)
    {
        $this->satpamService = $satpamService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {

        $this->checkPermission('master_satpam_access');
        return view('administrator.bujp-satpam.master-satpam');
    }

    public function getSelect2Provinsi()
    {
        return $this->satpamService->getSelect2Provinsi();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        $this->checkPermission('master_satpam_edit');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkPermission('master_satpam_destroy');
        Satpam::destroy($id);
        Alert::success('Berhasil' , 'data berhasil dihapus');
        return back();
    }

    public function search(Request $request)
    {
        return $this->satpamService->search($request->all());
    }

    public function excel(Request $request, Excel $excel, SatpamExport $export) {
        $fileName = 'rekap-satpams-' . strtolower(str_replace(' ', '_', $request->search)) .
                    '-' . strtolower(str_replace(' ', '', $request->bujp_id)) .
                    '-' . strtolower(str_replace(' ', '', $request->provinsi)) .
                    '-' . Carbon::now()->isoFormat('D-MMMM-Y') . '.xlsx';

        return $excel->download($export, $fileName);
    }
}
