<?php


namespace App\Repositories;


use App\Models\AnggotaKeluarga;
use App\Repositories\Abstracts\AnggotaKeluargaRepositoryAbstract;

class AnggotaKeluargaRepository extends AnggotaKeluargaRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return AnggotaKeluarga::class;
    }

    public function filterData(array $filter, $query)
    {
        // TODO : Filter
    }
}
