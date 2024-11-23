<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Http\Traits\FileUploadTrait;
use App\Models\Dds_warga;
use App\Models\User;
use App\Repositories\Abstracts\AnggotaKeluargaRepositoryAbstract;
use App\Repositories\Abstracts\DDSWargaRepositoryAbstract;
use App\Repositories\Abstracts\LaporanInformasiRepositoryAbstract;
use App\Repositories\Abstracts\PendapatWargaRepositoryAbstract;
use App\Services\Interfaces\DDSWargaServiceInterface;
use App\Services\Interfaces\KeywordServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DDSWargaService implements DDSWargaServiceInterface
{
    use FileUploadTrait;

    protected $ddsWargaRepository,
        $anggotaKeluargaRepository,
        $pendapatWargaRepository,
        $laporanInformasiRepository;

    protected $keywordService;

    /**
     * DDSWargaService constructor.
     * @param DDSWargaRepositoryAbstract $ddsWargaRepository
     */
    public function __construct(DDSWargaRepositoryAbstract         $ddsWargaRepository,
                                AnggotaKeluargaRepositoryAbstract  $anggotaKeluargaRepository,
                                PendapatWargaRepositoryAbstract    $pendapatWargaRepository,
                                LaporanInformasiRepositoryAbstract $laporanInformasiRepository,
                                KeywordServiceInterface            $keywordService)
    {
        $this->ddsWargaRepository = $ddsWargaRepository;
        $this->anggotaKeluargaRepository = $anggotaKeluargaRepository;
        $this->pendapatWargaRepository = $pendapatWargaRepository;
        $this->laporanInformasiRepository = $laporanInformasiRepository;

        $this->keywordService = $keywordService;
    }

    /**
     * @return int
     */
    public function countDds()
    {
        return $this->ddsWargaRepository->getFilterWithQuery(['user_id' => auth()->user()->id])->count();
    }

    public function getPencarianLaporan()
    {
        return $this->ddsWargaRepository
            ->getFilterWithPaginatedData(request()->all());
    }

    public function getSelectedRegionMap()
    {
        return $this->ddsWargaRepository->getFilterWithAllData(request()->all())
            ->pluck('provinsi_kepala_keluarga')->unique()->map(function ($item) {
                return Constants::MAP_PATH[$item];
            });
    }

    public function getCurrentLocation()
    {
        return auth()->user()->lokasiPenugasans()->with(['provinsi', 'kota'])->first()->toArray();
    }

    public function getDatatable()
    {
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();
        $query = $this->ddsWargaRepository
            ->getFilterWithQuery($request, [
                'nama_kepala_keluarga', 'kunjungan_ke', 'tanggal', 'desa_kepala_keluarga', 'nama_penerima_kunjungan'
            ])
            ->with('keywords', 'laporan_informasi.keywords:keyword');
        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<a href="' . route('dds-warga.edit', $collection->id) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-warning my-0"><i class="far fa-edit"></i></a>';
                $button .= '<a data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete my-2"><i class="far fa-trash-alt"></i></a>';
                $button .= '<button onclick="confirmSatuanPersonel(' . $collection->id . ')"  class="btn btn-sm btn-info "><i class="fa s fa-file-alt text-white"></i></button>';
                $button .= '<a href="' . route('dds-warga.create-exist', $collection->id) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-primary mt-2"><i class="fas fa-user-plus text-white" style="font-size : 10px"></i></a>';
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

    public function getExistData($id)
    {
        return $this->ddsWargaRepository->find($id);
    }

    public function getExistLaporan($nama_kepala_keluarga): int
    {
        return $this->ddsWargaRepository->getQuery()
            ->where('user_id', auth()->user()->id)
            ->where('nama_kepala_keluarga', 'ilike', $nama_kepala_keluarga)
            ->count();
    }

    public function store(array $data)
    {
        try {
            $formData = Arr::except($data, ['pendapat', 'anggota', 'laporan_informasi', 'foto_kunjungan']);
            if ($this->ddsWargaRepository->getFilterWithQuery(['user_id' => auth()->user()->id])
                    ->where('nama_kepala_keluarga', 'ilike', $formData['nama_kepala_keluarga'])
                    ->whereDate('tanggal', $formData['tanggal'])->count() > 0
            ) {
                throw new \Exception('Hanya dapat melaporkan satu kali kunjungan ke satu kepala keluarga dalam satu hari');
            }
            $formData['penulis'] = auth()->user()->personel->nama;
            $formData['user_id'] = auth()->user()->id;
            $formData['polda'] = !empty(session('personel')['satuan1']) ? Str::between(auth()->user()->personel->satuan1, 'POLDA ', '-') : __('abbreviation.' . $data['provinsi_kepala_keluarga']);

            // Check jika mengupload file
            if (request()->hasFile('foto_kunjungan')) {
                $formData['foto_kunjungan'] = $this->saveImage($data['foto_kunjungan']);
            }
            $ddsWarga = $this->ddsWargaRepository->create($formData);
            $this->saveRelationship($data, $ddsWarga);
            return $ddsWarga;
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }

    public function show($id)
    {
        return $this->ddsWargaRepository->getQuery()
            ->when(auth()->user()->haveRole('bhabinkamtibmas'), function($q) {
                $q->where('user_id', auth()->user()->id);
            })
            ->with('laporan_informasi.keywords:id,keyword', 'anggota_keluargas', 'pendapat_warga.keywords:id,keyword', 'user.personel', 'personel')
            ->findOrFail($id);
    }

    public function getLatestFromAuthUser()
    {
        $check = $this->ddsWargaRepository
            ->getFilterWithQuery(['user_id' => auth()->user()->id])
            ->orderByDesc('created_at')
            ->select('dds_wargas.id')
            ->first();

//        Log::info($check);

        return $check
            ? $check->load('laporan_informasi', 'pendapat_warga')
            : null;
    }

    public function update(array $data, $id)
    {
        try {
            $formData = Arr::except($data, ['pendapat', 'anggota', 'laporan_informasi', 'foto_kunjungan']);
            $formData['penulis'] = auth()->user()->personel->nama;
            $formData['user_id'] = auth()->user()->id;
            $formData['polda'] = !empty(session('personel')['satuan1']) ? Str::between(session('personel')['satuan1'], 'POLDA ', '-') : __('abbreviation.' . $data['provinsi_kepala_keluarga']);

            // Check jika mengupload file
            if (request()->hasFile('foto_kunjungan')) {
                $formData['foto_kunjungan'] = $this->saveImage($data['foto_kunjungan']);
            }
            $ddsWarga = $this->ddsWargaRepository->update($formData, $id);
            $this->updateRelationship($data, $this->ddsWargaRepository->find($id));
            return $ddsWarga;
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $ddsWarga = $this->ddsWargaRepository->find($id, ['id']);
            $ddsWarga->anggota_keluargas()->delete();
            $ddsWarga->pendapat_warga()->delete();
            $ddsWarga->laporan_informasi()->delete();
            $ddsWarga->keywords()->detach();
            $this->ddsWargaRepository->delete($id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function saveRelationship($data, $ddsWarga)
    {
        /**
         *  Anggota Keluarga
         */
        if (!empty($data['anggota'])) {
            foreach ($data['anggota'] as $anggotaKeluarga) {
                $this->anggotaKeluargaRepository->create(array_merge($anggotaKeluarga, ['dds_warga_id' => $ddsWarga->id]));
            }
        }
        /**
         * Pendapat Warga
         */
        foreach ($data['pendapat'] as $pendapat) {
            if (!empty($pendapat['jenis_pendapat'])) {
                $pendapatWarga = $this->pendapatWargaRepository->create(array_merge($pendapat, ['dds_warga_id' => $ddsWarga->id]));
                $this->syncKeywords($pendapat['keyword'], $ddsWarga['tanggal'], $pendapatWarga, 'store');
            }
        }
        /**
         * Laporan Informasi
         */
        if (!empty($data['laporan_informasi']['keyword'])) {
            $laporanInformasi = $this->laporanInformasiRepository->create(array_merge($data['laporan_informasi'], [
                'form_id' => $ddsWarga->id,
                'form_type' => $this->ddsWargaRepository->model()
            ]));
            $this->syncKeywords($data['laporan_informasi']['keyword'], $ddsWarga['tanggal'], $laporanInformasi, 'store');
        }
    }

    private function updateRelationship($data, $ddsWarga)
    {
        /**
         *  Anggota Keluarga
         */
        if (empty($data['anggota'])) {
            $ddsWarga->anggota_keluargas()->delete();
        } else {
            $this->anggotaKeluargaRepository->makeModel()
                ->where('dds_warga_id', $ddsWarga->id)
                ->whereNotIn('id', collect($data['anggota'])->pluck('id'))
                ->delete();
            foreach ($data['anggota'] as $anggotaKeluarga) {
                if (isset($anggotaKeluarga['id'])) {
                    $this->anggotaKeluargaRepository->update(array_merge($anggotaKeluarga, ['dds_warga_id' => $ddsWarga->id]), $anggotaKeluarga['id']);
                } else {
                    $this->anggotaKeluargaRepository->create(array_merge($anggotaKeluarga, ['dds_warga_id' => $ddsWarga->id]));
                }
            }
        }

        /**
         * Pendapat Warga
         */
        foreach ($data['pendapat'] as $pendapat) {
            if ($pendapat['uraian'] != null && $pendapat['keyword'] != null) {
                if (!isset($pendapat['id'])) {
                    $pendapatWarga = $this->pendapatWargaRepository->create(array_merge($pendapat, ['dds_warga_id' => $ddsWarga->id]));
                    $this->syncKeywords($pendapat['keyword'], $ddsWarga['tanggal'], $pendapatWarga, 'store');
                } else {
                    $this->pendapatWargaRepository->update(array_merge($pendapat, ['dds_warga_id' => $ddsWarga->id]), $pendapat['id']);
                    $this->syncKeywords($pendapat['keyword'], $ddsWarga['tanggal'], $this->pendapatWargaRepository->find($pendapat['id'], 'id'), 'update');
                }
            }

        }
        $this->pendapatWargaRepository->makeModel()
            ->where('dds_warga_id', $ddsWarga->id)
            ->whereNotIn('jenis_pendapat', collect($data['pendapat'])->pluck('jenis_pendapat')->filter())
            ->delete();

        /**
         * Laporan Informasi
         */
        if (!empty($data['laporan_informasi']['id'])) {
            $this->laporanInformasiRepository->update(array_merge($data['laporan_informasi'], [
                'form_id' => $ddsWarga->id,
                'form_type' => $this->ddsWargaRepository->model()
            ]), $data['laporan_informasi']['id']);
            $this->syncKeywords($data['laporan_informasi']['keyword'], $ddsWarga['tanggal'], $this->laporanInformasiRepository->find($data['laporan_informasi']['id'], 'id'), 'update');
        } else {
            $laporanInformasi = $this->laporanInformasiRepository->updateOrCreate([
                'form_id' => $ddsWarga->id,
                'form_type' => $this->ddsWargaRepository->model()
            ], $data['laporan_informasi']);
            $this->syncKeywords($data['laporan_informasi']['keyword'], $ddsWarga['tanggal'], $laporanInformasi, 'store');
        }
    }

    private function syncKeywords(array $incomingKeyword, $tanggal, $model, $state)
    {
        //array keyword
        $keywords = $this->keywordService->save([
            'keyword' => $incomingKeyword,
            'tanggal' => $tanggal,
        ], $state);
        $model->keywords()->sync(collect($keywords)->pluck('id'), ['created_at' => now(), 'polda' => auth()->user()->personel->polda ?? null]);
    }

    private function saveImage($image)
    {
        /** Prepare state file upload */
        $this->disk = config('filesystems.cloud');
        $this->uploadPath = auth()->user()->nrp;
        $this->folderName = 'dds-warga';
        $this->fileName = $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
        return $this->saveFiles($image);
    }

    /**
     * @param int|string $nrp
     * @param string|null $date_s
     * @param string|null $date_e
     * @return Collection
     */
    public static function getByNrp(
        int|string $nrp,
        ?string    $date_s = null,
        ?string    $date_e = null
    ): \Illuminate\Support\Collection
    {
        return Dds_warga::whereHas('user', fn ($q) => $q->where('nrp', $nrp))
            ->has('laporan_informasi')
            ->with('laporan_informasi.keywords:keyword', 'pendapat_warga.keywords:keyword')
            ->when(isset($date_s) && isset($date_e), fn ($q) => $q->whereBetween('created_at', [$date_s, $date_e]))
            ->get()
            ->unique('laporan_informasi.uraian')
            ->values();
    }

    public function getSelectKepalaKeluarga()
    {
        $this->ddsWargaRepository->limit = 0;
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();

        return Cache::remember('kepala-keluarga.select2.' . json_encode($request), defaultCacheTime(Constants::CACHE1DAY), function () use ($request) {
            return $this->ddsWargaRepository
                ->getFilterWithAllData($request)
                ->unique('nama_kepala_keluarga')
                ->map(function ($item) {
                    return [
                        'id'    => $item['nama_kepala_keluarga'],
                        'text'  => $item['nama_kepala_keluarga']
                    ];
                });
        });
    }
}
