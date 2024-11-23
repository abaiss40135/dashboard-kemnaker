<?php


namespace App\Repositories;


use App\Models\Kecamatan;
use App\Repositories\Abstracts\KecamatanRepositoryAbstract;

class KecamatanRepository extends KecamatanRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return Kecamatan::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['name'])){
            $query->where('name', 'ilike', '%'.$filter['name'].'%');
        }
        if (!empty($filter['city_code'])){
            $query->where('city_code', $filter['city_code']);
        }
    }
}
