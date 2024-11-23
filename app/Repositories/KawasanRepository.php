<?php


namespace App\Repositories;


use App\Models\Kawasan;
use App\Repositories\Abstracts\KawasanRepositoryAbstract;

class KawasanRepository extends KawasanRepositoryAbstract
{
    public function model()
    {
        return Kawasan::class;
    }

    public function filterData(array $filter, $query)
    {
        $query->when($filter['province_code'], function ($query, $code){
            $query->where('province_code', $code);
        });

        if (!empty($filter['name'])){
            $query->where('name', 'ilike', '%'.$filter['name'].'%');
        }
    }
}
