<?php


namespace App\Repositories;


use App\Models\Personel;
use App\Repositories\Abstracts\PersonelRepositoryAbstract;

class PersonelRepository extends PersonelRepositoryAbstract
{

    public function model()
    {
        return Personel::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nama'])){
            $query->where('nama', 'ilike', '%'.$filter['nama'].'%');
        }
    }
}
