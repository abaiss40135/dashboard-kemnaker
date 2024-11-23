<?php

namespace App\Http\Controllers\Admin\DashboardKamtibmas;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\LaporanBhabinkamtibmasServiceInterface;
use Illuminate\Http\Request;

class DashboardBhabinkamtibmasController extends Controller
{

    /**
     * @var LaporanBhabinkamtibmasServiceInterface
     */
    private $laporanBhabinkamtibmasService;

    public function __construct(LaporanBhabinkamtibmasServiceInterface $laporanBhabinkamtibmasService)
    {
        $this->laporanBhabinkamtibmasService = $laporanBhabinkamtibmasService;
    }

    public function getRekapLaporanBhabinkamtibmas()
    {
        return $this->laporanBhabinkamtibmasService->getRekapLaporanBhabinkamtibmas();
    }

    public function getRekapBidangInformasi()
    {
        return $this->laporanBhabinkamtibmasService->getRekapBidangInformasi();
    }

    public function filter(Request $request)
    {
        return $this->laporanBhabinkamtibmasService->filter($request->all());
    }

    public function getHighlightProvince(Request $request)
    {
        return $this->laporanBhabinkamtibmasService->getTaggedMap($request->all());
    }

    public function getProvinceStatistics(Request $request)
    {
        return $this->laporanBhabinkamtibmasService->getProvinceStatistic($request->all());
    }
}
