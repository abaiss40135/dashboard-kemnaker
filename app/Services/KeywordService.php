<?php


namespace App\Services;


use App\Helpers\CollectionHelper;
use App\Helpers\Constants;
use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\Problem_solving;
use App\Repositories\Abstracts\KeywordRepositoryAbstract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KeywordService implements Interfaces\KeywordServiceInterface
{
    protected $keywordRepository;

    /**
     * KeywordService constructor.
     * @param KeywordRepositoryAbstract $keywordRepository
     */
    public function __construct(KeywordRepositoryAbstract $keywordRepository)
    {
        $this->keywordRepository = $keywordRepository;
    }

    public function syncKeywords(array $arrayKeyword, $tanggal, $model)
    {
        //array keyword
        $newKeyword = $this->save([
            'keyword' => $arrayKeyword,
            'tanggal' => $tanggal,
        ]);
        $model->keywords()->syncWithPivotValues(collect($newKeyword)->pluck('id'), ['satuan' => auth()->user()->personel->polda ?? null]);
    }

    public function store(array $data, $state = 'store')
    {
        $keywords = [];
        foreach ($data['keyword'] as $keyword) {
            // increament or create new
            $keywords[] = $this->keywordRepository->create([
                'keyword' => trim(strtolower($keyword)),
                'jumlah' => 1,
                'tanggal' => $data['tanggal'],
                'state' => $state
            ]);
        }
        return $keywords;
    }

    public function save(array $data, $state = 'store')
    {
        $keywords = [];
        foreach ($data['keyword'] as $keyword) {
            // increament or create new
            $keywords[] = $this->keywordRepository->create([
                'keyword' => trim(strtolower($keyword)),
                'jumlah' => 1,
                'tanggal' => $data['tanggal'],
                'state' => $state
            ]);
        }
        return $keywords;
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function update(array $data, $id)
    {
        $this->keywordRepository->update($data, $id->id);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPencarianLaporan()
    {
        $keywords = $this->keywordRepository->getFilterWithAllData(request()->all());
        $result = $this->mapCollectionDataLaporanBhabinkantibmas($keywords);
        if (!empty(request('provinsi'))) {
            $result = $result->filter(function ($item) {
                return stripos($item['provinsi'], request('provinsi')) !== false;
            });
        }
        return CollectionHelper::paginate($result, 6);
    }

    /**
     * Fungsi ini mengembalikan collection
     * berisi path provinsi untuk di highlight
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSelectedRegionMap()
    {
        $keywords = $this->keywordRepository->getFilterWithAllData(request()->all(), ['id', 'keyword']);
        return $this->mapCollectionDataLaporanBhabinkantibmas($keywords, 'provinsi')->pluck('provinsi')->map(function ($item) {
            return Constants::MAP_PATH[strtoupper($item)];
        });
    }

    public function getPopularKeyword()
    {
        $today        = date('Y-m-d');
        $user         = auth()->user();
        $personel     = $user->personel;
        $cache_unique = $personel->kode_satuan ?? $user->id;
        $polda        = $personel->polda ?? null;
        $cache_name   = "popular-keyword-dashboard.$cache_unique";
        $cache_time   = defaultCacheTime(3 * Constants::CACHE1HOUR);

        return Cache::remember(
            $cache_name,
            $cache_time,
            fn () => DB::table('keywordables')
                ->join('keywords', function ($join) {
                    $join
                    ->on('keywordables.keyword_id', '=', 'keywords.id')
                    ->where('keywords.is_valid', '=', true);
                })
                ->whereDate('keywordables.updated_at', '=', $today)
                ->when(
                    role('operator_bhabinkamtibmas_polda'),
                    fn ($q) => $q->where('keywordables.satuan', $polda)
                )
                ->select(DB::raw('count(*) as jumlah, keywords.keyword as keyword'))
                ->groupBy('keywords.keyword')
                ->orderByDesc('jumlah')
                ->limit(60)
                ->get()
        );
    }

    /**
     * @param $province
     * @return \Illuminate\Support\Collection
     */
    public function getPopularKeywordByProvince($province)
    {
        if (!empty($province)) {
            $keywords = $this->keywordRepository->getFilterWithAllData(request()->all());
            return $this->mapCollectionDataPopularKeywordByProvince($keywords, request('provinsi'));
        }
        return collect();
    }

    /**
     * Fungsi ini untuk memappingkan data relasi keyword ke jenis laporannya
     *
     * @param $keywords
     * @return \Illuminate\Support\Collection
     */
    private function mapCollectionDataLaporanBhabinkantibmas($keywords, string $column = 'id')
    {
        $result = collect();
        foreach ($keywords as $keyword) {
            $result->push($keyword->laporanInformasis->map(function ($item) {
                if (empty($item->form)) {
                    return [];
                }
                return $this->formatLaporanInformasiFormBhabinkantibmas($item);
            })->first());
        }
        return $result->filter()->unique($column)->values();
    }

    /**
     * Fungsi ini untuk memappingkan data relasi keyword ke jenis laporannya
     *
     * @param $keywords
     * @return \Illuminate\Support\Collection
     */
    private function mapCollectionDataPopularKeywordByProvince($keywords, $provinsi)
    {
        $popularKeyword = collect();
        foreach ($keywords as $keyword) {
            $popularKeyword->push($keyword->laporanInformasis->filter(function ($item) use ($provinsi) {
                if (empty($item->form)) {
                    return false;
                }
                switch ($item->form_type) {
                    case Dds_warga::class:
                        return stripos($item->form->provinsi_kepala_keluarga, $provinsi) !== false;
                    case Deteksi_dini::class:
                        return stripos($item->form->provinsi, $provinsi) !== false;
                    case Problem_solving::class:
                        return stripos($item->form->provinsi_pihak_1, $provinsi) !== false;
                }
            })->pluck('keywords')->first());

            $popularKeyword->push($keyword->ddsWargas->filter(function ($item) use ($provinsi) {
                return stripos($item['provinsi_kepala_keluarga'], $provinsi) !== false;
            })->pluck('keywords')->first());

            $popularKeyword->push($keyword->deteksiDinis->filter(function ($item) use ($provinsi) {
                return stripos($item['provinsi'], $provinsi) !== false;
            })->pluck('keywords')->first());
            $popularKeyword->push($keyword->problemSolvings->filter(function ($item) use ($provinsi) {
                return stripos($item['provinsi_pihak_1'], $provinsi) !== false;
            })->pluck('keywords')->first());
        }
        return $popularKeyword->flatten(1)->unique('id')->filter()->sortByDesc('jumlah')->values();
    }

    /**
     * Fungsi ini digunakan untuk menyelaraskan format laporan yang berbeda
     * menjadi 1 format untuk di consume front-end
     *
     * @param $laporan
     * @return array|string[]
     */
    private function formatLaporanInformasiFormBhabinkantibmas($laporanInformasi)
    {
        switch ($laporanInformasi->form_type) {
            case Dds_warga::class:
                return [
                    'id' => $laporanInformasi->form_id,
                    'jenis' => "DDS Warga",
                    'keyword' => $laporanInformasi->keywords->pluck('keyword'),
                    'provinsi' => $laporanInformasi->form->provinsi_kepala_keluarga,
                    'tanggal' => $laporanInformasi->form->tanggal,
                    'penulis' => $laporanInformasi->form->penulis,
                    'uraian' => $laporanInformasi->uraian,
                ];
            case Deteksi_dini::class:
                return [
                    'id' => $laporanInformasi->form_id,
                    'jenis' => "Deteksi Dini",
                    'keyword' => $laporanInformasi->keywords->pluck('keyword'),
                    'provinsi' => $laporanInformasi->form->provinsi,
                    'tanggal' => $laporanInformasi->form->tanggal_mendapatkan_informasi,
                    'penulis' => $laporanInformasi->form->penulis,
                    'uraian' => $laporanInformasi->uraian,
                ];
            case Problem_solving::class:
                return [
                    'id' => $laporanInformasi->form_id,
                    'jenis' => "Problem Solving",
                    'keyword' => $laporanInformasi->keywords->pluck('keyword'),
                    'provinsi' => $laporanInformasi->form->provinsi_pihak_1,
                    'tanggal' => $laporanInformasi->form->tanggal_kejadian,
                    'penulis' => $laporanInformasi->form->penulis,
                    'uraian' => $laporanInformasi->uraian,
                ];
        }
    }

    /**
     * Fungsi ini digunakan untuk menyelaraskan format laporan yang berbeda
     * menjadi 1 format untuk di consume front-end
     *
     * @param $laporan
     * @return array|string[]
     */
    private function formatDataForLaporanBhabinkantibmas($laporan)
    {
        $baseFormat = [
            'id' => '',
            'keyword' => '',
            'polda' => '',
            'tanggal' => '',
            'penulis' => '',
            'uraian' => '',
        ];
        switch ($laporan->getMorphClass()) {
            case Dds_warga::class:
                return [
                    'id' => $laporan->id,
                    'jenis' => "DDS Warga",
                    'keyword' => $laporan->keywords->pluck('keyword'),
                    'provinsi' => $laporan->provinsi_kepala_keluarga,
                    'tanggal' => $laporan->tanggal,
                    'penulis' => $laporan->penulis,
                    'uraian' => $laporan->uraian_pendapat_warga,
                ];
            case Deteksi_dini::class:
                return [
                    'id' => $laporan->id,
                    'jenis' => "Deteksi Dini",
                    'keyword' => $laporan->keywords->pluck('keyword'),
                    'provinsi' => $laporan->provinsi,
                    'tanggal' => $laporan->tanggal_mendapatkan_informasi,
                    'penulis' => $laporan->penulis,
                    'uraian' => $laporan->uraian_informasi,
                ];
            case Problem_solving::class:
                return [
                    'id' => $laporan->id,
                    'jenis' => "Problem Solving",
                    'keyword' => $laporan->keywords->pluck('keyword'),
                    'provinsi' => $laporan->provinsi_pihak_1,
                    'tanggal' => $laporan->tanggal_kejadian,
                    'penulis' => $laporan->penulis,
                    'uraian' => $laporan->uraian_problem_solving,
                ];
            default:
                return $baseFormat;
        }
    }

    public function getSelectData()
    {
        $request = array_merge(request()->all(), ['is_valid' => true]);
        return Cache::remember('keywordSelect' . json_encode($request), defaultCacheTime(Constants::CACHE1DAY), function () use ($request) {
            return $this->keywordRepository
                ->getFilterWithAllData($request)
                ->map(function ($item) {
                    return [
                        'id' => $item['keyword'],
                        'text' => $item['keyword']
                    ];
                });
        });
    }

    public function getDatatable()
    {
        $query = $this->keywordRepository
            ->getFilterWithQuery(request()->all(), ['id', 'is_valid', 'jumlah'])
            ->latest('is_valid')
            ->latest('jumlah');

        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '&nbsp;<button type="button" data-id="' . $collection->id . '" class="btn btn-sm btn-success btn-validasi"><i class="fas fa-check"></i></button>';
                if ($collection->is_valid) {
                    $button = '&nbsp;<button type="button" data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-times"></i></button>';
                }
                return $button;
            })
            ->editColumn('is_valid', function ($collection) {
                $color = $collection->is_valid ? 'bg-success' : 'bg-danger';
                $text = $collection->is_valid ? 'VALID' : 'TIDAK VALID';
                return '<span class="badge ' . $color . '">
                            ' . $text . '
                        </span>';
            })
            ->rawColumns(['is_valid', 'action'])
            ->toJson();
    }
}
