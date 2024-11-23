<?php


namespace App\Repositories;


use App\Models\PsNonSengketa;
use App\Repositories\Abstracts\PSNonSengketaRepositoryAbstract;
use Illuminate\Support\Carbon;

class PSNonSengketaRepository extends PSNonSengketaRepositoryAbstract
{
    public $recordPerPage = 6;

    public function model()
    {
        return PsNonSengketa::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['keyword_pencarian'])) {
            $query->where("keyword", 'ilike', '%' . $filter['keyword_pencarian'] . '%')
                ->orWhere("penulis", 'ilike', '%' . $filter['keyword_pencarian'] . '%');
        }
        if (!empty($filter['user_id'])){
            $query->where('user_id', $filter['user_id']);
        }
        if (!empty($filter['pihak_terlibat'])){
            $query->where('pihak_terlibat', 'ilike', $filter['pihak_terlibat'] . '%');
        }
        if (!empty($filter['nama_narasumber'])){
            $query->where('nama_narasumber', 'ilike', $filter['nama_narasumber'] . '%');
        }
        if (!empty($filter['bulan'])) {
            try {
                $date = Carbon::createFromFormat('Y-m', $filter['bulan']);
            } catch (\Exception $e) {
                $date = Carbon::now();
            }

            $query->whereBetween('created_at', [
                $date->startOfMonth()->format('Y-m-d H:i:s'),
                $date->endOfMonth()->format('Y-m-d H:i:s')
            ]);
        }
        if (!empty($filter['keyword'])) {
            $query->whereHas('keywords', function ($query) use ($filter) {
                $query->where('keyword', 'ilike', "%{$filter['keyword']}%");
            });
        }
        if (!empty($filter['polda'])) {
            $query->where(function ($query) use ($filter) {
                $query->whereHas('personel', function ($query) use ($filter) {
                    $query->where('satuan1', 'ilike', '%' . $filter['polda'].'%');
                });
            });
        }
        if (!empty($filter['start_created_at'])) {
            $query->where('created_at', '>=', $filter['start_created_at']);
        }
        if (!empty($filter['end_created_at'])) {
            $query->where('created_at', '<=', $filter['end_created_at']);
        }
    }
}
