<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\LaporanInformasi;
use App\Models\LaporanPublik;
use App\Services\Interfaces\LaporanInformasiServiceInterface;
use App\Services\Interfaces\PendapatWargaServiceInterface;
use App\Services\KeywordService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    protected $keyword;
    protected $keywordService, $laporanInformasiService, $pendapatWargaService;

    public function __construct(
        KeywordService $keywordService,
        LaporanInformasiServiceInterface $laporanInformasiService,
        PendapatWargaServiceInterface $pendapatWargaService)
    {
        $this->keywordService = $keywordService;
        $this->laporanInformasiService = $laporanInformasiService;
        $this->pendapatWargaService = $pendapatWargaService;
    }

    public function index()
    {
        return view('administrator.index');
    }

    public function dashboardBhabinkamtibmas()
    {
        return view('dashboard.bhabinkamtibmas.index');
    }

    public function json()
    {
        $queryCountLaporanInformasi = LaporanInformasi::query()
                                    ->select(DB::raw('INITCAP(bidang) AS bidang'))
                                    ->has('keywords')
                                    ->has('form');

        $queryCountDDS = Dds_warga::has('laporan_informasi.keywords');
        $queryCountDeteksiDini = Deteksi_dini::has('laporan_informasi.keywords');
//        $queryCountProblemSolving = Problem_solving::has('laporan_informasi.keywords');

        if (role('operator_bhabinkamtibmas_polda')){
            $polda = Str::between(auth()->user()->personel->satuan1, 'POLDA ', '-');
            $queryCountLaporanInformasi->whereHas('form', function ($query) use ($polda){
                if ($query->getModel()->getTable() === LaporanPublik::query()->getModel()->getTable()) {
                    $query->where('provinsi', Lang::get('alias-polda')[auth()->user()->personel->polda]);
                } else {
                    $query->where('polda', $polda);
                }
            });
            $queryCountDDS->where('polda', $polda);
            $queryCountDeteksiDini->where('polda', $polda);
//            $queryCountProblemSolving->where('polda', $polda);
        }

        return [
            'laporanInformasi' => $queryCountLaporanInformasi
                                    ->get('bidang')
                                    ->countBy('bidang'),

            'laporanBhabin' => [
                'DDS Warga' => $queryCountDDS->count(),
                'Deteksi Dini' => $queryCountDeteksiDini->count(),
//                'Problem Solving' => $queryCountProblemSolving->count(),
            ]
        ];
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonPopularKeyword(){
        return response()->json($this->keywordService->getPopularKeyword());
    }

    public function filterDashboardBhabinkamtibmas(Request $request)
    {
        return $this->laporanInformasiService->filter($request->all());
    }

    public function getProvinceStatistics(Request $request)
    {
        return $this->laporanInformasiService->getProvinceStatistics($request->all());
    }

    public function getPendapatWargaChartData()
    {
        return response()->json($this->pendapatWargaService->getChartPendapatWarga());
    }
}
