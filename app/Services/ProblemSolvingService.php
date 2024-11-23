<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Http\Traits\FileUploadTrait;
use App\Models\Problem_solving;
use App\Models\User;
use App\Repositories\Abstracts\ProblemSolvingRepositoryAbstract;
use App\Services\Interfaces\KeywordServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProblemSolvingService implements Interfaces\ProblemSolvingServiceInterface
{
    use FileUploadTrait;

    protected $problemSolvingRepository, $keywordService;

    /**
     * ProblemSolving constructor.
     * @param ProblemSolvingRepositoryAbstract $problemSolvingRepository
     */
    public function __construct(ProblemSolvingRepositoryAbstract $problemSolvingRepository,
                                KeywordServiceInterface          $keywordService)
    {
        $this->problemSolvingRepository = $problemSolvingRepository;
        $this->keywordService = $keywordService;
    }

    public function store(array $data)
    {
        $surat_kesepakatan = null;
        if (request()->hasFile('surat_kesepakatan')) {
            $this->uploadPath = 'bhabin/' . auth()->user()->nrp . '/laporan/problem-solving/' . now()->isoFormat('dddd , D MMMM Y');
            $file = $data['surat_kesepakatan'];
            $this->fileName = auth()->user()->nrp . '-surat_kesepakatan-' . time() . '.' . $file->getClientOriginalExtension();
            $surat_kesepakatan = $this->saveFiles($file);
        }
        $problemSolving = Problem_solving::create([
            "tanggal" => $data['tanggal'],
            "waktu_kejadian" => $data['waktu_kejadian'],
            "nama_pihak_1" => $data['nama_pihak_1'],
            "pekerjaan_pihak_1" => $data['pekerjaan_pihak_1'],
            "alamat_pihak_1" => $data['alamat_pihak_1'],
            "provinsi_pihak_1" => $data['provinsi_pihak_1'],
            "kabupaten_pihak_1" => $data['kabupaten_pihak_1'],
            "kecamatan_pihak_1" => $data['kecamatan_pihak_1'],
            "desa_pihak_1" => $data['desa_pihak_1'],
            "rt_pihak_1" => $data['rt_pihak_1'],
            "rw_pihak_1" => $data['rw_pihak_1'],
            "nama_pihak_2" => $data['nama_pihak_2'],
            "pekerjaan_pihak_2" => $data['pekerjaan_pihak_2'],
            "alamat_pihak_2" => $data['alamat_pihak_2'],
            "provinsi_pihak_2" => $data['provinsi_pihak_2'],
            "kabupaten_pihak_2" => $data['kabupaten_pihak_2'],
            "kecamatan_pihak_2" => $data['kecamatan_pihak_2'],
            "desa_pihak_2" => $data['desa_pihak_2'],
            "rt_pihak_2" => $data['rt_pihak_2'],
            "rw_pihak_2" => $data['rw_pihak_2'],
            "bidang_masalah" => $data['bidang_masalah'],
            "keyword" => $data['keyword'],
            "uraian_kejadian" => $data['uraian_kejadian'],
            "saksi" => $data['saksi'],
            "nama_narasumber" => $data['nama_narasumber'],
            "pekerjaan_narasumber" => $data['pekerjaan_narasumber'],
            "alamat_narasumber" => $data['alamat_narasumber'],
            "hari_masalah_selesai" => $data['hari_selesai'],
            "tanggal_masalah_selesai" => $data['hari_selesai'],
            "uraian_problem_solving" => $data['uraian_problem_solving'],
            "surat_kesepakatan" => $surat_kesepakatan,
            "penulis" => auth()->user()->personel->nama,
            "user_id" => auth()->user()->id,
            "polda" => auth()->user()->personel->polda
        ]);
        $this->keywordService->syncKeywords($data['keyword'], $data['tanggal'], $problemSolving);
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function getSelectPihakTerkait()
    {
        $this->problemSolvingRepository->limit = 0;
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();

        return Cache::remember('ps-sengketa.pihak-terkait.select2.' . json_encode($request), defaultCacheTime(Constants::CACHE1DAY), function () use ($request) {
            $pihak_1 = $this->problemSolvingRepository->getFilterWithAllData($request, ['nama_pihak_1']);
            $pihak_2 = $this->problemSolvingRepository->getFilterWithAllData($request, ['nama_pihak_2']);
            return $pihak_1
                ->unique('nama_pihak_1')
                ->map(function ($item) {
                    return [
                        'id' => $item['nama_pihak_1'],
                        'text' => $item['nama_pihak_1']
                    ];
                })->merge($pihak_2->unique('nama_pihak_2')->map(function ($item) {
                    return [
                        'id' => $item['nama_pihak_2'],
                        'text' => $item['nama_pihak_2']
                    ];
                }))->values()->toArray();
        });
    }
}
