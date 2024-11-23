<?php

namespace App\Repositories;

use App\Models\AtensiPimpinan;
use App\Models\Berita;
use App\Repositories\Abstracts\AtensiPimpinanRepositoryAbstract;

class AtensiPimpinanRepository extends AtensiPimpinanRepositoryAbstract
{
    public $recordPerPage = 7;

    public function model()
    {
        return AtensiPimpinan::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['judul'])){
            $query->where('judul', 'ilike', '%'.$filter['judul'].'%');
        }
        if (!empty($filter['pemberi'])){
            $query->where('pembuat', 'ilike', '%'.$filter['pembuat'].'%');
        }
        if (!empty($filter['sasaran'])){
            $query->where('sasaran', '=', $filter['sasaran']);
        }
        if (!empty($filter['created_by'])){
            $query->where('created_by', $filter['created_by']);
        }
        if (!empty($filter['role'])){
            switch ($filter['role']){
                case 'satpam':
                    $query->whereIn('sasaran', ['publik', 'satpam']);
                    break;
                case 'publik':
                    $query->where('sasaran', 'publik');
            }
        }
    }
}
