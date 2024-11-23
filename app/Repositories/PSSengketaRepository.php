<?php


namespace App\Repositories;


use App\Models\Problem_solving;
use App\Repositories\Abstracts\PSSengketaRepositoryAbstract;
use Illuminate\Support\Carbon;

class PSSengketaRepository extends PSSengketaRepositoryAbstract
{
    public $recordPerPage = 6;

    public function model()
    {
        return Problem_solving::class;
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
        if (!empty($filter['pihak_terkait'])){
            $query->where(function ($query) use ($filter) {
                $query->where('nama_pihak_1', 'ilike', $filter['pihak_terkait'] . '%')
                    ->orWhere('nama_pihak_2', 'ilike', $filter['pihak_terkait'] . '%');
            });
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
