<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus\DataPensiunPolsus;

use App\Exports\Sislap\Lapsubjar\Sipolsus\DataSenpiAmunisiExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Services\Sislap\Lapsubjar\Sipolsus\DataPensiunPolsusService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PolsuspasController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new DataPensiunPolsusService('polsuspas');
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.si-polsus.data-pensiun-polsus.sub-menu.polsuspas');
    }

    public function exportExcel() {
        $template = new TemplateLaporan('polsuspas');
        return Excel::download($template, 'Laporan Data Anggota Aktif dan Pensiun Polsuspas - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        $result = $this->service->search($request);

        return response()->json($result);
    }

    public function getDataPolsusPensiun($kabupaten) {
        $result = $this->service->dataPolsusPensiun($kabupaten);

        return response()->json($result);
    }
}