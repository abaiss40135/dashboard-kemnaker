<?php

namespace App\Http\Controllers\Admin\DashboardKamtibmas;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\LaporanSatpamServiceInterface;
use Illuminate\Http\Request;

class DashboardSatpamController extends Controller
{
    public function __construct(LaporanSatpamServiceInterface $laporanSatpamService)
    {
        $this->laporanSatpamService = $laporanSatpamService;
    }

    public function index()
    {
        return view('administrator.dashboard.satpam');
    }

    public function filter(Request $request)
    {
        return $this->laporanSatpamService->filter($request->all());
    }

    public function getHighlightProvince()
    {
        return $this->laporanSatpamService->getTaggedMap(request()->all());
    }

    public function getProvinceStatistics()
    {
        return $this->laporanSatpamService->getProvinceStatistic(request()->all());
    }

    public function getRekapLaporanSatpam()
    {
        return $this->laporanSatpamService->getRekapLaporanSatpam();
    }

    public function getRekapBidangLaporan()
    {
        return $this->laporanSatpamService->getRekapBidangLaporan();
    }
}
