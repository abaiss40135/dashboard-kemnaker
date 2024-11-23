<?php

namespace App\Services;

use App\Helpers\Constants;
use App\Http\Traits\FileUploadTrait;
use App\Models\Problem_solving;
use App\Models\User;
use App\Repositories\Abstracts\PSSengketaRepositoryAbstract;
use App\Services\Interfaces\PSSengketaServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PSSengketaService implements PSSengketaServiceInterface
{
    use FileUploadTrait;

	protected $psSengketaRepository;

	public function __construct(PSSengketaRepositoryAbstract $psSengketaRepository)
    {
        $this->psSengketaRepository = $psSengketaRepository;
    }

    public function getDatatable()
    {
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();
        $query = $this->psSengketaRepository->getFilterWithQuery($request)->with('keywords:id,keyword');
        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<a data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete mt-2" title="hapus laporan"><i class="far fa-trash-alt"></i></a>';
                $button .= '<a href="' . route('problem-solving.sengketa.edit', $collection->id) . '" class="btn btn-sm btn-warning mt-2" title="edit laporan"><i class="fas fa-pen"></i></a>';
                $button .= '<a data-id="' . $collection->id . '" class="btn btn-sm btn-primary btn-eskalasi mt-2" title="pihak eskalasi"><i class="fas fa-share text-white"></i></a>';
                $button .= '<button onclick="confirmSatuanPersonel('. $collection->id .')" class="btn btn-sm btn-info mt-2" title="download laporan"><i class="fas fa-print text-white"></i></button>';
                $button .= '<button onclick="confirmSatuanPersonel('. $collection->id .', \'skb\')" class="btn btn-sm btn-success mt-2 " title="download template skb"><i class="fas fa-file-alt"></i></button>';
                $button .= '<a href="' . route('download', ['url' => $collection->url_skb]) . '" class="btn btn-sm mt-2 bg-olive text-white'. (isset($collection->surat_kesepakatan) ? '' : ' disabled') .'"><i class="fas fa-download"></i></a>';
                return $button;
            })
            ->addColumn('deleteAction', function($collection) {
                return '<button data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete my-2"><i class="far fa-trash-alt"></i></button>';
            })
            ->addColumn('keyword', function ($collection) {
                return isset($collection->keywords) ? $collection->keywords->implode('keyword', ', ') : '';
            })
            ->rawColumns(['action', 'deleteAction'])
            ->toJson();
    }

    public function getCurrentLocation()
    {
        return auth()->user()->lokasiPenugasans()->with(['provinsi', 'kota'])->first()->toArray();
    }

    public static function getByNrp(
        int|string $nrp,
        ?string    $date_s = null,
        ?string    $date_e = null
    ) {
        return Problem_solving::whereHas('user', fn ($q) => $q->where('nrp', $nrp))
            ->when(isset($date_s) && isset($date_e), fn ($q) => $q->whereBetween('created_at', [$date_s, $date_e]))
            ->with('keywords:keyword')
            ->get()
            ->unique('uraian_kejadian')
            ->values();
    }

    public function getSelectPihakTerkait()
    {
        $this->psSengketaRepository->limit = 0;
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();

        return Cache::remember('ps-sengketa.pihak-terkait.select2.' . json_encode($request), defaultCacheTime(Constants::CACHE1DAY), function () use ($request) {
            $pihak_1 = $this->psSengketaRepository->getFilterWithAllData($request, ['nama_pihak_1']);
            $pihak_2 = $this->psSengketaRepository->getFilterWithAllData($request, ['nama_pihak_2']);
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

    public function export(array $request)
    {
        return $this->psSengketaRepository
            ->getFilterWithQuery($request)
            ->with([
                'personel:user_id,nama,pangkat,satuan1,satuan2,satuan3',
                'user:id,nrp'
            ])
            ->select('id', 'user_id', 'uraian_kejadian', 'created_at')
            ->get();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $problemSolving = Problem_solving::find($id);
            $this->deleteSKB($id);
            if ($problemSolving->has('keywords')) {
                $problemSolving->keywords()->detach();
            }
            $problemSolving::destroy($id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function deleteSKB($id)
    {
        $url = Problem_solving::where('id' , $id)->pluck('surat_kesepakatan');
        $this->deleteFiles($url);
    }
    
}
