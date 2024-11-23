<?php


namespace App\Repositories;


use App\Models\PendapatWarga;
use App\Repositories\Abstracts\PendapatWargaRepositoryAbstract;

class PendapatWargaRepository extends PendapatWargaRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return PendapatWarga::class;
    }

    public function filterData(array $filter, $query)
    {
        // TODO FilterS
    }
}
