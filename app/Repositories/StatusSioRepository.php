<?php


namespace App\Repositories;


use App\Models\StatusSio;
use App\Repositories\Abstracts\StatusSioRepositoryAbstract;

class StatusSioRepository extends StatusSioRepositoryAbstract
{

    public function model()
    {
        return StatusSio::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['status'])){
            $query->where('status', 'ilike', '%'.$filter['status'].'%');
        }
    }
}
