<?php


namespace App\Repositories;


use App\Models\OSS\NIB;
use App\Repositories\Abstracts\NIBRepositoryAbstract;

class NIBRepository extends NIBRepositoryAbstract
{

    public function model()
    {
        return NIB::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nib'])){
            $query->where('nib', '=', $filter['nib']);
        }
    }
}
