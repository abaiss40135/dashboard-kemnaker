<?php


namespace App\Repositories;


use App\Models\Problem_solving;
use App\Repositories\Abstracts\ProblemSolvingRepositoryAbstract;
use Illuminate\Support\Carbon;

class ProblemSolvingRepository extends ProblemSolvingRepositoryAbstract
{
    public function model()
    {
        return Problem_solving::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['user_id'])){
            $query->where('user_id', $filter['user_id']);
        }
        if (!empty($filter['pihak_terkait'])){
            $query->where(function ($query) use ($filter) {
                $query->where('nama_pihak_1', 'ilike', $filter['pihak_tekait'] . '%')
                    ->orWhere('nama_pihak_2', 'ilike', $filter['pihak_tekait'] . '%');
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
    }
}
