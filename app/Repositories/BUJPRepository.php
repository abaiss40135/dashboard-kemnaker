<?php


namespace App\Repositories;


use App\Models\Bujp;
use App\Repositories\Abstracts\BUJPRepositoryAbstract;

class BUJPRepository extends BUJPRepositoryAbstract
{
    public $recordPerPage = 10;

    public function model()
    {
        return BUJP::class;
    }

    public function filterData(array $filter, $query)
    {
        /**
         * Filter by global search
         */
        if (!empty($filter['search'])) {
            $search = $filter['search'];
            $query->where(function ($query) use ($search) {
                return $query->where('bujps.nama_badan_usaha', 'ilike', '%' . $search . '%')
                    ->orWhere('bujps.bidang_usaha', 'ilike', '%' . $search . '%')
                    ->orWhere('users.email', 'ilike', '%' . $search . '%')
                    ->orWhere('bujps.detail_alamat', 'ilike', '%' . $search . '%');
            });
        }
        /**
         * filter by wilayah provinsi
         */
        if (!empty($filter['provinsi'])) {
            $query->where('bujps.provinsi', $filter['provinsi']);
        }

        /**
         * filter by wilayah provinsi satpam
         */
        if (!empty($filter['provinsi_satpam'])) {
            $query->whereHas('satpams', function ($query) use ($filter) {
                $query->where('provinsi', 'ilike', '%' . $filter['provinsi_satpam'] . '%');
            });
        }

        /**
         * filter rentang terakhir login
         */
        if (!empty($filter['last_login_at'])) {
            $query->whereNotNull('users.last_login_at')
                ->whereDate('users.last_login_at', '>=', now()->subDays($filter['last_login_at']));
        }
        if (!empty($filter['nama_badan_usaha'])) {
            $query->where('nama_badan_usaha', 'ilike', '%' . $filter['nama_badan_usaha'] . '%');
        }
        /**
         * filter pengurutan
         */
        if (!empty($filter['sort_by'])) {
            $query->orderBy($filter['sort_by']);
        }
    }
}
