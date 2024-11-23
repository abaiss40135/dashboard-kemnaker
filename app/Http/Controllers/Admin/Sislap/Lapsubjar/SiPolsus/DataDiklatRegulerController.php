<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus;

use App\Exports\Sislap\Lapsubjar\Sipolsus\DataDiklatDanKepemilikanKtaExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Http\Traits\CustomPaginationTrait;
use App\Models\Instansi;
use App\Services\Sislap\Lapsubjar\Sipolsus\DataDiklatDanKepemilikanKtaService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataDiklatRegulerController extends Controller
{
    use CustomPaginationTrait;

    private $service;
    private $jenjang_diklat = "reguler";

    public function __construct()
    {
        $this->service = new DataDiklatDanKepemilikanKtaService($this->jenjang_diklat);
    }

    public function index() {
        $instansis = Instansi::get();
        return view('administrator.sislap.lapsubjar.si-polsus.data-diklat-reguler.index', [
            "polices" => $this->service->polices,
            "attributes" => $this->service->attributes,
            'instansis' => $instansis,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function exportExcel() {
        $template = new TemplateLaporan($this->jenjang_diklat);
        return Excel::download($template, 'Laporan Data Polsus Berdasarkan Diklat Reguler - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        $result = $this->service->search($request);

        return response()->json($result);
    }
}
