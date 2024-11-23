<?php


namespace App\Repositories;


use App\Models\BerkasPendaftaranSio;
use App\Repositories\Abstracts\BerkasPendaftaranSioRepositoryAbstract;

class BerkasPendaftaranSioRepository extends BerkasPendaftaranSioRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return BerkasPendaftaranSio::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['jenis_berkas'])){
            $query->where('jenis_berkas', 'ilike', '%'.$filter['jenis_berkas'].'%');
        }
    }
}
