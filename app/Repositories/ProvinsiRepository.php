<?php


namespace App\Repositories;


use App\Models\Provinsi;
use App\Repositories\Abstracts\ProvinsiRepositoryAbstract;

class ProvinsiRepository extends ProvinsiRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return Provinsi::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['name'])){
            $query->where('name', 'ilike', '%'.$filter['name'].'%');
        }
        if (!empty($filter['polda'])){
            $query->where('polda', 'ilike', '%'.$filter['polda'].'%');
        }
        $query->orderBy('name');
    }
}
