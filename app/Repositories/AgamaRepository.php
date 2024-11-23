<?php


namespace App\Repositories;


use App\Models\Agama;
use App\Repositories\Abstracts\AgamaRepositoryAbstract;

class AgamaRepository extends AgamaRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return Agama::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nama'])){
            $query->where('nama', 'ilike', '%'.$filter['nama'].'%');
        }
    }
}
