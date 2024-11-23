<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataFkpmKawasanExport;
use App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\LaporanBinpolmasExport;
use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Abstracts\LokasiPenugasanRepositoryAbstract;
use App\Services\Interfaces\ProvinsiServiceInterface;
use App\Services\ProvinsiService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\ChartDataBinpolmasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChartDataBinpolmasController extends Controller
{

    private $chartDataBinpolmasService;
    private $provinsiService;
    private $lokasiPenugasanRepository;

    public function __construct(
        ProvinsiServiceInterface $provinsiService,
        LokasiPenugasanRepositoryAbstract $lokasiPenugasanRepository,
    )
    {
        $this->chartDataBinpolmasService = new ChartDataBinpolmasService();
        $this->provinsiService = $provinsiService;
        $this->lokasiPenugasanRepository = $lokasiPenugasanRepository;
    }

    public function tahap1()
    {
        $data = $this->chartDataBinpolmasService->tahap1();

        return response()->json([
            'data' => $data
        ]);
    }

    public function tahap2($type)
    {
        $data = $this->chartDataBinpolmasService->tahap2($type);

        return response()->json([
            'data' => $data
        ]);
    }

    public function tahap3($type, $polda)
    {
        $data = $this->chartDataBinpolmasService->tahap3($polda, $type);

        return response()->json([
            'data' => $data
        ]);
    }

    public function tahap4($type, $polres)
    {
        $data = $this->chartDataBinpolmasService->tahap4($polres, $type);

        return response()->json([
            'data' => $data
        ]);
    }

    public function chartOperatorLogin()
    {
        $mappingTotalOperatorBinpolmas = $this->countPerPolda();
        $listProvinsi = $this->provinsiService->getDataAndKeyByCode();
        $loginPerPolda = $mappingTotalOperatorBinpolmas['login'];
        $jumlahOperatorBinpolmas = User::isOperatorBinpolmas()
            ->has('personel')
            ->selectRaw('CASE WHEN last_login_at IS NULL THEN 0 ELSE 1 END AS is_logged_in')
            ->get()->countBy('is_logged_in');

        $notLogin = isset($jumlahOperatorBinpolmas[0]) ? $jumlahOperatorBinpolmas[0] : 0;
        $hasLogin = $jumlahOperatorBinpolmas[1];

        return response()->json([
            'jumlahOperatorBinpolmas' => User::isOperatorBinpolmas()->has('personel')->count(),
            'rekapitulasi' => $this->listOperatorBinpolmasPerPolda($mappingTotalOperatorBinpolmas),
            'hasLogin' => $hasLogin,
            'notLogin' => $notLogin,
            'loginPerPolda' => $loginPerPolda,
            'listPolda' => $listProvinsi->pluck('polda'),
            'province_code' => $listProvinsi->keys(),
            'jumlahOperatorBinpolmasPerPolda' => $mappingTotalOperatorBinpolmas['total'],
        ]);
    }

    public function dataOperatorPolresLogin($polda)
    {
        $data = $this->chartDataBinpolmasService->dataOperatorPolresLogin($polda);

        return response()->json($data);
    }

    public function exportRekapitulasiLaporan(Request $request)
    {
        // middleware only admin role
        if (!role('administrator') && !role('pimpinan_polri')){
            abort(403);
        }

        // validation start and end date
        if(!isset($request->start_date)) {
            $request->merge([
                'start_date' => date('Y-m-d', strtotime('first day of january this year')),
            ]);
        }
        if(!isset($request->end_date)) {
            $request->merge([
                'end_date' => date('Y-m-d', strtotime('today'))
            ]);
        }

        $additionalNotes = $request->satuan . ' ' . $request->start_date . ' - ' . $request->end_date;
        return (new LaporanBinpolmasExport())
            ->download('Rekapitulasi Laporan Binpolmas '
                .$additionalNotes
                .'.xlsx'
            );
    }

    public function getTaggedMap(Request $request)
    {
        $data = $this->chartDataBinpolmasService->getTaggedMap($request->all());
        $presentase = round(count($data) / count(Constants::MAP_PATH) * 100, 2);

        return response()->json([
            'data' => [
                'highlight_path' => $data,
                'presentase_operator_polda_login' => $presentase,
            ],
        ]);
    }

    private function countPerPolda()
    {
        $listLoginPerPolda = [];
        $listTotalPerPolda = [];

        foreach ($this->provinsiService->getDataAndKeyByCode() as $code => $name) {
            $listLoginPerPolda[] = Cache::remember('countLoggedInPerPoldaOperatorBinpolmas4'.$code, defaultCacheTime(Constants::CACHE1DAY), fn () => User::query()
                ->isOperatorBinpolmas()
                ->has('personel')
                ->whereNotNull('last_login_at')
                ->whereHas('personel', fn ($p) => $p->where('satuan1', 'ilike', '%' . $name->polda . '%'))
                ->count()
            );

            $listTotalPerPolda[] = Cache::remember('countTotalPerPoldaOperatorBinpolmas4'.$code, defaultCacheTime(Constants::CACHE1DAY), fn () => User::query()
                ->isOperatorBinpolmas()
                ->has('personel')
                ->whereHas('personel', fn ($p) => $p->where('satuan1', 'ilike', '%' . $name->polda . '%'))
                ->count()
            );
        }

        return [
            'login' => $listLoginPerPolda,
            'total' => $listTotalPerPolda,
        ];
    }

    private function listOperatorBinpolmasPerPolda($dataOperatorBinpolmas)
    {
        $operatorBinpolmasPerPolda = $dataOperatorBinpolmas['total'];
        $loggedIn = $dataOperatorBinpolmas['login'];

        $chart1Jumlah = array_slice($operatorBinpolmasPerPolda, 0, 17);
        $chart2Jumlah = array_slice($operatorBinpolmasPerPolda, 17);
        $chart1loggedIn = array_slice($loggedIn, 0, 17);
        $chart2loggedIn = array_slice($loggedIn, 17);

        return [[$chart1Jumlah, $chart1loggedIn], [$chart2Jumlah, $chart2loggedIn]];
    }
}
