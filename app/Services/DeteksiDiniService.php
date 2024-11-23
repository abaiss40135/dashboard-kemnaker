<?php


namespace App\Services;

use App\Helpers\Constants;
use App\Models\Deteksi_dini;
use App\Models\User;
use App\Repositories\Abstracts\LaporanInformasiRepositoryAbstract;
use App\Repositories\DeteksiDiniRepository;
use App\Services\Interfaces\KeywordServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DeteksiDiniService implements Interfaces\DeteksiDiniServiceInterface
{
    protected $deteksiDiniRepository, $laporanInformasiRepository, $keywordService;

    /**
     * DeteksiDiniService constructor.
     * @param DeteksiDiniRepository $deteksiDiniRepository
     */
    public function __construct(DeteksiDiniRepository $deteksiDiniRepository, LaporanInformasiRepositoryAbstract $laporanInformasiRepository, KeywordServiceInterface $keywordService)
    {
        $this->deteksiDiniRepository = $deteksiDiniRepository;
        $this->laporanInformasiRepository = $laporanInformasiRepository;
        $this->keywordService = $keywordService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDatatable()
    {
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();
        $query = $this->deteksiDiniRepository
            ->getFilterWithQuery($request)
            ->with('laporan_informasi.keywords:keyword');

        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<a href="' . route('deteksi-dini.edit', $collection->id) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></a>';
                $button .= '&nbsp;<a data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete my-1"><i class="far fa-trash-alt"></i></a>';
                $button .= '&nbsp;<button onclick="confirmSatuanPersonel(' . $collection->id . ')"  class="btn btn-sm btn-info "><i class="fa s fa-file-alt text-white"></i></button>';
                return $button;
            })
            ->addColumn('deleteAction', function($collection) {
                return '<button data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete my-2"><i class="far fa-trash-alt"></i></button>';
            })
            ->addColumn('keyword', function ($collection) {
                return isset($collection->laporan_informasi->keywords) ? $collection->laporan_informasi->keywords->implode('keyword', ', ') : '';
            })
            ->rawColumns(['action', 'deleteAction'])
            ->toJson();
    }


    public function getCurrentLocation()
    {
        return auth()->user()->lokasiPenugasans()->with(['provinsi', 'kota'])->first()->toArray();
    }

    public function store(array $data)
    {
        $deteksiDiniData = Arr::except($data, ['laporan_informasi']);
        $deteksiDiniData['penulis'] = auth()->user()->personel->nama;
        $deteksiDiniData['user_id'] = auth()->user()->id;
        $deteksiDiniData['polda'] = !empty(session('personel')['satuan1']) ? Str::between(session('personel')['satuan1'], 'POLDA ', '-') : __('abbreviation.' . $data['provinsi']);

        try {
            $deteksiDini = $this->deteksiDiniRepository->create($deteksiDiniData);
            $this->saveRelatedData($data, $deteksiDini);
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }

    public function show($id)
    {
        return $this->deteksiDiniRepository->getQuery()
            ->when(auth()->user()->haveRole('bhabinkamtibmas'), function($q) {
                $q->where('user_id', auth()->user()->id);
            })
            ->with('laporan_informasi.keywords:id,keyword')
            ->find($id);
    }

    public function update(array $data, $id)
    {
        $deteksiDiniData = Arr::except($data, ['laporan_informasi']);
        $deteksiDiniData['penulis'] = auth()->user()->personel->nama;
        $deteksiDiniData['user_id'] = auth()->user()->id;
        $deteksiDiniData['polda'] = !empty(session('personel')['satuan1']) ? Str::between(session('personel')['satuan1'], 'POLDA ', '-') : __('abbreviation.' . $data['provinsi']);

        try {
            $this->deteksiDiniRepository->update($deteksiDiniData, $id);
            $this->updateRelatedData($data, $this->deteksiDiniRepository->find($id));
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $deteksiDini = Deteksi_dini::find($id);

            $deteksiDini->laporan_informasi->keywords()->detach();
            $deteksiDini->laporan_informasi()->delete();
            $deteksiDini->destroy($id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    private function saveRelatedData(array $data, $deteksiDini)
    {
        /**
         * Laporan Informasi
         */
        $laporanInformasi = $this->laporanInformasiRepository->create(array_merge($data['laporan_informasi'], [
            'form_id' => $deteksiDini->id,
            'form_type' => $this->deteksiDiniRepository->model()
        ]));
        $this->keywordService->syncKeywords($data['laporan_informasi']['keyword'], $data['tanggal'], $laporanInformasi);
    }

    private function updateRelatedData(array $data, $deteksiDini)
    {
        /**
         * Laporan Informasi
         */
        if (isset($deteksiDini->laporan_informasi->id)) {
            $this->laporanInformasiRepository->update(array_merge($data['laporan_informasi'], [
                'form_id' => $deteksiDini->id,
                'form_type' => $this->deteksiDiniRepository->model()
            ]), $deteksiDini->laporan_informasi->id);
            $this->keywordService->syncKeywords($data['laporan_informasi']['keyword'], $data['tanggal'], $this->laporanInformasiRepository->find($deteksiDini->laporan_informasi->id));
        } else {
            $laporanInformasi = $this->laporanInformasiRepository->create(array_merge($data['laporan_informasi'], [
                'form_id' => $deteksiDini->id,
                'form_type' => $this->deteksiDiniRepository->model()
            ]));
            $this->keywordService->syncKeywords($data['laporan_informasi']['keyword'], $data['tanggal'], $laporanInformasi);
        }
    }

    public static function getByNrp(
        int|string $nrp,
        ?string    $date_s = null,
        ?string    $date_e = null
    ): \Illuminate\Support\Collection
    {
        return Deteksi_dini::whereHas('user', fn ($q) => $q->where('nrp', $nrp))
            ->has('laporan_informasi')
            ->with('laporan_informasi.keywords:keyword')
            ->when(isset($date_s) && isset($date_e), fn ($q) => $q->whereBetween('created_at', [$date_s, $date_e]))
            ->get()
            ->unique('laporan_informasi.uraian')
            ->values();
    }

    public function getSelectNarasumber()
    {
        $this->deteksiDiniRepository->limit = 0;
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();

        return Cache::remember('deteksi-dini.narasumber.select2.' . json_encode($request), defaultCacheTime(Constants::CACHE1DAY), function () use ($request) {
            return $this->deteksiDiniRepository
                ->getFilterWithAllData($request)
                ->unique('nama_narasumber')
                ->map(function ($item) {
                    return [
                        'id'    => $item['nama_narasumber'],
                        'text'  => $item['nama_narasumber']
                    ];
                });
        });
    }
}
