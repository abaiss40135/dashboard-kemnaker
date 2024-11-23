<?php


namespace App\Repositories;


use App\Models\Desa;
use App\Repositories\Abstracts\DesaRepositoryAbstract;

class DesaRepository extends DesaRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return Desa::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['name'])){
            $query->where('name', 'ilike', $filter['name']);
        }
        if (!empty($filter['district_code'])){
            $query->where('district_code', $filter['district_code']);
        }
    }
}
