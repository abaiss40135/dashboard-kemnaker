<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus\DataSenpiAmunisi;

use App\Exports\Sislap\Lapsubjar\Sipolsus\DataSenpiAmunisiExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Services\Sislap\Lapsubjar\Sipolsus\DataSenpiAmunisiService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PolsusBarantanController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new DataSenpiAmunisiService('polsus_barantan');
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.si-polsus.data-senpi-amunisi.sub-menu.polsus-barantan', [
            "attributes" => $this->service->attributes
        ]);
    }

    public function exportExcel() {
        $template = new TemplateLaporan('polsus_barantan');
        return Excel::download($template, 'Laporan Data Senpi dan Amunisi Polsus Barantan - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        $result = $this->service->search($request);

        return response()->json($result);
    }
}
