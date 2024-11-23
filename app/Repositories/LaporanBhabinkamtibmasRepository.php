<?php


namespace App\Repositories;


use App\Models\Laporan\LaporanBhabinkamtibmas;
use App\Repositories\Abstracts\LaporanBhabinkamtibmasRepositoryAbstract;
use Illuminate\Support\Facades\Lang;

class LaporanBhabinkamtibmasRepository extends LaporanBhabinkamtibmasRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return LaporanBhabinkamtibmas::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['nama_personel'])) {
            $query->where('nama_personel', 'ilike', '%' . $filter['nama_personel'] . '%');
        }
        if (!empty($filter['nama_narasumber'])) {
            $query->where('nama_narasumber', 'ilike', '%' . $filter['nama_narasumber'] . '%');
        }
        if (!empty($filter['keyword']) || !empty($filter['search'])) {
            $query->where('tags', 'ilike', '%' . ($filter['keyword'] ?? $filter['search']) . '%');
        }
        if (!empty($filter['polda'])) {
            $query->where(function ($query) use ($filter) {
                $query->where('polda', $filter['polda'])
                    ->orWhere('polda', 'ilike', '%' . $filter['polda']);
            });
        }
        if (!empty($filter['province'])) {
            $query->where('polda', 'like', '%' . Lang::get('abbreviation')[strtoupper($filter['province'])]);
        }
        if (!empty($filter['start_date'])) {
            $query->whereDate('tanggal_laporan', '>=', $filter['start_date']);
        }
        if (!empty($filter['end_date'])) {
            $query->whereDate('tanggal_laporan', '<=', $filter['end_date']);
        }
        if (!empty($filter['start_created_at'])) {
            $query->where('created_at', '>=', $filter['start_created_at']);
        }
        if (!empty($filter['end_created_at'])) {
            $query->where('created_at', '<=', $filter['end_created_at']);
        }
    }
}
