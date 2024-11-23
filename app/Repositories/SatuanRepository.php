<?php

namespace App\Repositories;

use App\Models\Sipp\Satuan;
use App\Repositories\Abstracts\SatuanRepositoryAbstract;

class SatuanRepository extends SatuanRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return Satuan::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nama_satuan'])){
            $query->where('nama_satuan', 'ilike', '%'.$filter['nama_satuan'].'%');
        }
        if (!empty($filter['kode_satuan'])){
            $query->where('kode_satuan', 'ilike', $filter['kode_satuan'].'%');
        }
    }
}
