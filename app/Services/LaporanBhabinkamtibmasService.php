<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Models\Dds_warga;
use App\Repositories\Abstracts\LaporanBhabinkamtibmasRepositoryAbstract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LaporanBhabinkamtibmasService implements Interfaces\LaporanBhabinkamtibmasServiceInterface
{
    protected $laporanBhabinkamtibmasRepository;

    /**
     * AgamaService constructor.
     * @param LaporanBhabinkamtibmasRepositoryAbstract $laporanBhabinkamtibmasRepositoryAbstract
     */
    public function __construct(LaporanBhabinkamtibmasRepositoryAbstract $laporanBhabinkamtibmasRepositoryAbstract)
    {
        $this->laporanBhabinkamtibmasRepository = $laporanBhabinkamtibmasRepositoryAbstract;
    }

    public function export(array $request)
    {

        $queryRequest = $request;
        return $this->laporanBhabinkamtibmasRepository
            ->getFilterWithQuery($queryRequest, ['nama_personel', 'pangkat', 'nrp', 'polda', 'polres', 'polsek', 'uraian_informasi'])
            ->orderBy('kode_satuan')
            ->get();
    }

    public function filter(array $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . 'dashboard.dashboard-bhabinkamtibmas.filter.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () use ($request) {
            return $this->laporanBhabinkamtibmasRepository
                ->getFilterWithQuery($request)
                ->orderByDesc('tanggal_laporan')
                ->paginate($this->laporanBhabinkamtibmasRepository->recordPerPage);
        });
    }

    public function getTaggedMap(array $request)
    {
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . 'dashboard.dashboard-bhabinkamtibmas.tagged-map.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () use ($request) {
            return $this->laporanBhabinkamtibmasRepository
                ->getFilterWithQuery($request)
                ->pluck('polda')
                ->map(function ($polda, $key) {
                    return Constants::MAP_PATH[Str::after($polda, 'POLDA ')] ?? null;
                })->filter()->all();
        });
    }

    public function getProvinceStatistic(array $request)
    {
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . 'dashboard.dashboard-bhabinkamtibmas.get-province-statistics.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () use ($request) {
            $query = $this->laporanBhabinkamtibmasRepository->getFilterWithQuery($request);
            return response()->json([
                'total' => $query->count(),
                'totalToday' => $query->whereDate('tanggal_laporan', now())->count()
            ]);
        });
    }

    public function getRekapLaporanBhabinkamtibmas(): array
    {
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . '.dashboard.dashboard-bhabinkamtibmas.get-rekap-laporan-bhabinkamtibmas.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () {
            return $this->laporanBhabinkamtibmasRepository->getFilterWithQuery(request()->all())
                ->selectRaw("case when form_type = '" . Dds_warga::class . "' then 'DDS Warga' else 'Deteksi Dini' end as form_type, count(*) as total")
                ->groupBy('form_type')
                ->pluck('total', 'form_type')
                ->all();
        });
    }

    public function getRekapBidangInformasi(): array
    {
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . '.dashboard.dashboard-bhabinkamtibmas.get-rekap-bidang-informasi.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () {
            return $this->laporanBhabinkamtibmasRepository->getFilterWithQuery(request()->all())
                ->selectRaw('INITCAP(bidang) AS bidang, count(*) as total')
                ->groupBy('bidang')
                ->pluck('total', 'bidang')
                ->all();
        });
    }
}
