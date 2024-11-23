<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus\DataPensiunPolsus;

use App\Exports\Sislap\Lapsubjar\Sipolsus\DataPensiunPolsusExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Services\Sislap\Lapsubjar\Sipolsus\DataPensiunPolsusService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PolsusPwp3kController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new DataPensiunPolsusService('polsus_pwp3k');
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.si-polsus.data-pensiun-polsus.sub-menu.polsus-pwp3k');
    }

    public function exportExcel() {
        $template = new TemplateLaporan('polsus_pwp3k');
        return Excel::download($template, 'Laporan Data Anggota Aktif dan Pensiun Polsus PWP3K - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
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
