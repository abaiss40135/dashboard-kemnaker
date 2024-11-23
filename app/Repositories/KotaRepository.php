<?php


namespace App\Repositories;


use App\Models\Kota;
use App\Repositories\Abstracts\KotaRepositoryAbstract;

class KotaRepository extends KotaRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return Kota::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['name'])){
            $query->where('name', 'ilike', '%'.$filter['name'].'%');
        }
        if (!empty($filter['province_code'])){
            $query->where('province_code', $filter['province_code']);
        }
    }
}
