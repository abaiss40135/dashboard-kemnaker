<?php


namespace App\Repositories;


use App\Models\KlasterRutinitasBhabinkamtibmas;
use App\Repositories\Abstracts\KlasterRutinitasRepositoryAbstract;

class KlasterRutinitasRepository extends KlasterRutinitasRepositoryAbstract
{

    public function model()
    {
        return KlasterRutinitasBhabinkamtibmas::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nama'])) {
            $query->whereHas('personel', function ($query) use ($filter) {
                $query->where('nama', 'ilike', '%' . $filter['nama'] . '%');
            });
        }
        if (!empty($filter['nrp']) && strlen($filter['nrp']) == 8) {
            $query->whereHas('personel', function ($query) use ($filter) {
                $query->where('nrp', $filter['nrp']);
            });
        }
        if (!empty($filter['polda'])) {
            $query->whereHas('personel', function ($query) use ($filter) {
                $query->where('satuan1', 'ilike', $filter['polda'] . '%');
            });
        }
        if (!empty($filter['polres'])) {
            $query->whereHas('personel', function ($query) use ($filter) {
                $query->where('satuan2', 'ilike', $filter['polres'] . '%');
            });
        }
        if (!empty($filter['is_logged_in'])) {
            $query->whereHas('user', function ($query) use ($filter) {
                if ($filter['is_logged_in'] == 1) {
                    $query->whereNotNull('is_logged_in');
                } else {
                    $query->whereNull('is_logged_in');
                }
            });
        }
        if (!empty($filter['klaster_rutinitas'])) {
            $query->where('klaster_rutinitas', strtoupper($filter['klaster_rutinitas']));
        }
    }
}
