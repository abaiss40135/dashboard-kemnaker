<?php

namespace App\Repositories;

use App\Models\Berita;
use App\Repositories\Abstracts\BeritaRepositoryAbstract;

class BeritaRepository extends BeritaRepositoryAbstract
{
    public $recordPerPage = 10;

    public function model()
    {
        return Berita::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['judul'])){
            $query->where('judul', 'ilike', '%'.$filter['judul'].'%');
        }
        if (!empty($filter['pembuat_berita'])){
            $query->where('pembuat_berita', 'ilike', '%'.$filter['pembuat_berita'].'%');
        }
    }
}
