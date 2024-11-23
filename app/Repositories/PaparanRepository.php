<?php


namespace App\Repositories;


use App\Models\Paparan;

class PaparanRepository extends Abstracts\PaparanRepositoryAbstract
{
    public function model()
    {
        return Paparan::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nama_paparan'])){
            $query->where('nama_paparan', 'ilike', '%'.$filter['nama_paparan'].'%');
        }
    }
}
