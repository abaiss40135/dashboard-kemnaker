<?php


namespace App\Repositories;


use App\Models\LaporanSatpam;
use App\Repositories\Abstracts\LaporanSatpamRepositoryAbstract;

class LaporanSatpamRepository extends LaporanSatpamRepositoryAbstract
{
    public function model()
    {
        return LaporanSatpam::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nama'])) {
            $query->where('nama', 'ilike', '%' . $filter['nama'] . '%');
        }
        if (!empty($filter['narasumber'])) {
            $query->where('narasumber', 'ilike', '%' . $filter['narasumber'] . '%');
        }
        if (!empty($filter['keyword']) || !empty($filter['search'])) {
            $query->where('tags', 'ilike', '%' . ($filter['keyword'] ?? $filter['search']) . '%');
        }
        if (!empty($filter['province'])) {
            $query->where('provinsi', 'ilike', '%' . $filter['province']);
        }
        if (!empty($filter['provinsi'])) {
            $query->where('provinsi', 'ilike', '%' . $filter['provinsi']);
        }
        if (!empty($filter['start_date'])) {
            $query->where('tanggal_laporan', '>=', $filter['start_date']);
        }
        if (!empty($filter['end_date'])) {
            $query->where('tanggal_laporan', '<=', $filter['end_date']);
        }
    }
}
