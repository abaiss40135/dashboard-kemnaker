<?php


namespace App\Repositories;


use App\Models\AkumulasiLaporanBhabinkamtibmas;
use App\Repositories\Abstracts\AkumulasiLaporanBhabinkamtibmasRepositoryAbstract;

class AkumulasiLaporanBhabinkamtibmasRepository extends AkumulasiLaporanBhabinkamtibmasRepositoryAbstract
{

    public function model()
    {
        return AkumulasiLaporanBhabinkamtibmas::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['user_id'])){
            $query->where('user_id', $filter['user_id']);
        }
        if (!empty($filter['personel_id'])){
            $query->where('personel_id', $filter['personel_id']);
        }
        if (!empty($filter['nama'])){
            $query->whereHas('personel', function ($query) use ($filter) {
                $query->where('nama', 'ilike', '%'.$filter['nama'].'%');
            });
        }
        if (!empty($filter['nrp']) && strlen($filter['nrp']) == 8){
            $query->whereHas('user', function ($query) use ($filter) {
                $query->where('nrp', $filter['nrp']);
            });
        }
        if (!empty($filter['polda'])){
            $query->whereHas('personel', function ($query) use ($filter) {
                $query->where('satuan1', 'ilike', $filter['polda'].'%');
            });
        }
        if (!empty($filter['is_logged_in'])){
            $query->whereHas('user', function ($query) use ($filter) {
                if ($filter['is_logged_in'] == 1){
                    $query->whereNotNull('is_logged_in');
                } else {
                    $query->whereNull('is_logged_in');
                }
            });
        }
        if (!empty($filter['periode'])){
            $query->where('periode', $filter['periode']);
        }
    }
}
