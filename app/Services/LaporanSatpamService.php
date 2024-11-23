<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Models\LaporanInformasiSatpam;
use App\Repositories\Abstracts\LaporanSatpamRepositoryAbstract;
use Illuminate\Support\Str;

class LaporanSatpamService implements Interfaces\LaporanSatpamServiceInterface
{
    /**
     * @var LaporanSatpamRepositoryAbstract
     */
    private $laporanSatpamRepository;

    public function __construct(LaporanSatpamRepositoryAbstract $laporanSatpamRepositoryAbstract)
    {
        return $this->laporanSatpamRepository = $laporanSatpamRepositoryAbstract;
    }

    public function export(array $request)
    {
        $queryRequest = $request;
        return $this->LaporanSatpamRepositoryAbstract
            ->getFilterWithQuery($queryRequest, ['*'])
            ->orderBy('provinsi')
            ->get();
    }

    public function filter(array $request)
    {
        return $this->laporanSatpamRepository
            ->getFilterWithQuery($request)
            ->latest('tanggal_laporan')
            ->paginate($this->laporanSatpamRepository->recordPerPage);
    }

    public function getTaggedMap(array $request)
    {
        return $this->laporanSatpamRepository
            ->getFilterWithQuery($request)
            ->pluck('provinsi')
            ->map(function ($provinsi, $key) {
                return Constants::MAP_PATH[strtoupper($provinsi)] ?? null;
            })->filter()->all();
    }

    public function getProvinceStatistic(array $request)
    {
        $query = $this->laporanSatpamRepository->getFilterWithQuery($request);
        return response()->json([
            'total' => $query->count(),
            'totalToday' => $query->whereDate('tanggal_laporan', now())->count()
        ]);
    }

    public function getRekapLaporanSatpam(): array
    {
        return $this->laporanSatpamRepository->getFilterWithQuery(request()->all())
            ->selectRaw('form_type, count(*) as total')
            ->groupBy('form_type')
            ->get()->mapWithKeys(function ($item, $key) {
                return [($item->form_type === LaporanInformasiSatpam::class ? 'Laporan Informasi' : 'Laporan Kejadian') => $item->total];
            })->all();
    }

    public function getRekapBidangLaporan(): array
    {
        return $this->laporanSatpamRepository->getFilterWithQuery(request()->all())
            ->selectRaw('INITCAP(bidang) AS bidang, count(*) as total')
            ->groupBy('bidang')
            ->get()->mapWithKeys(function ($item, $key) {
                return [str_replace('_', ' ', $item->bidang) => $item->total];
            })->all();
    }
}
