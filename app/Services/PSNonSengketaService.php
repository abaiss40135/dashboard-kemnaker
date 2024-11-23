<?php

namespace App\Services;

use App\Helpers\Constants;
use App\Models\PsNonSengketa;
use App\Models\User;
use App\Repositories\Abstracts\PSNonSengketaRepositoryAbstract;
use App\Services\Interfaces\PSNonSengketaServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PSNonSengketaService implements PSNonSengketaServiceInterface
{
    /**
     * @var PSNonSengketaRepositoryAbstract
     */
    private $psNonSengketaRepository;

    public function __construct(PSNonSengketaRepositoryAbstract $PSNonSengketaRepository)
    {
        $this->psNonSengketaRepository = $PSNonSengketaRepository;
    }

    public static function getByNrp(
        int|string $nrp,
        ?string    $date_s = null,
        ?string    $date_e = null
    ) {
        return PsNonSengketa::whereHas('user', fn ($q) => $q->where('nrp', $nrp))
            ->when(isset($date_s) && isset($date_e), fn ($q) => $q->whereBetween('created_at', [$date_s, $date_e]))
            ->with('keywords:keyword')
            ->get()
            ->unique('uraian_masalah')
            ->values();
    }

    public function getDatatable()
    {
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();
        $query = $this->psNonSengketaRepository
            ->getFilterWithQuery($request)
            ->with('keywords:id,keyword');
        return DataTables::eloquent($query)
            ->addColumn('action', function ($ps) {
                $button = '<a href="' . route('problem-solving.non-sengketa.edit', $ps->id) . '" class="btn btn-sm btn-warning" title="edit laporan"><i class="fas fa-edit"></i></a>';
                $button .= '<a data-id="' . $ps->id . '" class="btn btn-sm btn-danger btn-delete" title="hapus laporan"><i class="fa fa-trash"></i></a>';
                $button .= '<button onclick="confirmSatuanPersonel('. $ps->id .')" class="btn btn-sm btn-info text-white" title="hapus laporan"><i class="far fa-file"></i></button>';
                return '<div class="action-button">'.$button.'</div>';
            })
            ->addColumn('deleteAction', function($collection) {
                return '<button data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete my-2"><i class="far fa-trash-alt"></i></button>';
            })
            ->addColumn('keyword', function ($ps) {
                return isset($ps->keywords) ? $ps->keywords->implode('keyword', ', ') : '';
            })
            ->addColumn('waktu_kejadian', function ($ps){
                return "<b>{$ps->tanggal_kejadian}</b> {$ps->waktu_kejadian}";
            })
            ->rawColumns(['action', 'waktu_kejadian', 'deleteAction'])
            ->toJson();
    }

    public function getSelectNamaNarasumber()
    {
        $this->psNonSengketaRepository->limit = 0;
        $request = auth()->user()->haveRoleID(User::BHABIN) ? array_merge(request()->all(), ['user_id' => auth()->user()->id]) : request()->all();

        return Cache::remember('ps-non-sengketa.narasumber.select2.' . json_encode($request), defaultCacheTime(Constants::CACHE1DAY), function () use ($request) {
            return $this->psNonSengketaRepository
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

    public function export(array $request)
    {
        return $this->psNonSengketaRepository
            ->getFilterWithQuery($request)
            ->with([
                'personel:user_id,nama,pangkat,satuan1,satuan2,satuan3',
                'user:id,nrp'
            ])
            ->select('id', 'user_id', 'uraian_masalah', 'created_at')
            ->get();
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $psNonSengketa = PsNonSengketa::find($id);
            $psNonSengketa->keywords()->detach();
            $psNonSengketa::destroy($id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
