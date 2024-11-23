<?php


namespace App\Repositories;


use App\Models\Satpam;
use App\Repositories\Abstracts\SatpamRepositoryAbstract;
use Carbon\Carbon;

class SatpamRepository extends SatpamRepositoryAbstract
{
    public $recordPerPage = 10;
    public $limit = 0;

    public function model()
    {
        return Satpam::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['has_kta'])) {
            $query->whereNotNull('no_kta')->whereNotNull('no_reg');
        }
        if (!empty($filter['search'])) {
            $search = $filter['search'];
            $query->where(function ($query) use ($search) {
                return $query->where('satpams.no_kta', 'ilike', '%' . $search . '%')
                    ->orWhere('satpams.nama', 'ilike', '%' . $search . '%')
                    ->orWhere('satpams.tempat_tugas', 'ilike', '%' . $search . '%')
                    ->orWhere('satpams.no_kta', 'ilike', '%' . $search . '%')
                    ->orWhere('bujps.nama_badan_usaha', 'ilike', '%' . $search . '%');
            });
        }
        if (!empty($filter['bujp_id'])) {
            $bujp_id = $filter['bujp_id'];
            $query->when($bujp_id != "NON", function ($query, $filter) use ($bujp_id) {
                return $query->where('bujp_id', $bujp_id);
            }, function ($query) {
                return $query->doesntHave('bujp');
            });
        }
        if (!empty($filter['nama'])) {
            $query->where('nama', 'ilike', '%' . $filter['nama'] . '%');
        }
        if (!empty($filter['provinsi'])) {
            $query->where('satpams.provinsi', 'ilike', '%' . $filter['provinsi'] . '%');
        }
        if (!empty($filter['sort_by'])) {
            if ($filter['sort_by'] === 'masa_berlaku_kta_asc') {
                $query->whereNotNull('masa_berlaku_kta')->orderBy('masa_berlaku_kta');
            } else if ($filter['sort_by'] === 'masa_berlaku_kta_desc') {
                $query->whereNotNull('masa_berlaku_kta')->orderByDesc('masa_berlaku_kta');
            }
            else if($filter['sort_by'] === 'masa_berlaku_kta_expired') {
                $query->whereNotNull('masa_berlaku_kta')->orderBy('masa_berlaku_kta')->where('masa_berlaku_kta', '<', Carbon::now()->toDateString());
            }
            else {
                $query->orderBy($filter['sort_by']);
            }
        } else {
            $query->orderBy('satpams.created_at', 'DESC');
        }
    }
}
