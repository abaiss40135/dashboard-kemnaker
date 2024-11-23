<?php


namespace App\Repositories;


use App\Models\LaporanPublik;
use App\Repositories\Abstracts\LaporanPublikRepositoryAbstract;

class LaporanPublikRepository extends LaporanPublikRepositoryAbstract
{

    public function model()
    {
        return LaporanPublik::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['user_id'])){
            $query->where('user_id', $filter['user_id']);
        }
    }
}
