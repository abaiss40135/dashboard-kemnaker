<?php


namespace App\Repositories;


use App\Models\Suku;
use App\Repositories\Abstracts\SukuRepositoryAbstract;

class SukuRepository extends SukuRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return Suku::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nama'])){
            $query->where('nama', 'ilike', '%'.$filter['nama'].'%');
        }
    }
}
