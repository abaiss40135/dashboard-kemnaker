<?php


namespace App\Repositories\Abstracts;


use App\Models\RiwayatSio;

abstract class BUJPRepositoryAbstract extends BaseRepositoryAbstract
{
    /**
     * Get paginated filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilterWithPaginatedData(array $filter, array $columns = ['*'])
    {
        $columns[] = "bujps.nib";
//        $columns[] = "nomor_induk_berusaha.id as id_nib";
//        $columns[] = "nomor_induk_berusaha.id_izin as id_izin_nib";
//        $columns[] = "data_checklist.id as id_checklist";
//        $columns[] = "riwayat_sio.type as type_riwayat_sio";
//        $columns[] = "riwayat_sio.id as id_riwayat_sio";
//        $columns[] = "riwayat_sio.id_izin as id_izin_riwayat_sio";
//        $columns[] = "data_checklist.nib_id as nib_id_data_checklist";
//        $columns[] = "data_checklist.id_izin as id_izin_data_checklist";
//        $columns[] = "log_status_riwayat_sio.keterangan as keterangan_log_status_riwayat_sio";

        $query = $this->getQuery()
            ->leftJoin('users', 'users.id', '=', 'bujps.user_id')
//            ->leftJoin('nomor_induk_berusaha', 'nomor_induk_berusaha.nib', '=', 'bujps.nib')
//            ->leftJoin('data_checklist', 'data_checklist.nib_id', '=', 'nomor_induk_berusaha.id')
//            ->rightJoin('riwayat_sio', 'riwayat_sio.id_izin', '=', 'data_checklist.id_izin')
//            ->leftJoin('log_status_riwayat_sio', 'log_status_riwayat_sio.riwayat_sio_id', '=', 'riwayat_sio.id')
            ->with('nib:id_izin,nib,id,kd_daerah',
                'nib.checklists:id_izin,id,nib_id,id_proyek',
                'nib.checklists.riwayatSio:id_izin,type,id',
                'nib.checklists.proyek:id,nib_id,id_proyek',
                'nib.checklists.proyek.lokasi:alamat_usaha,data_proyek_id,id_proyek_lokasi')
            ->select($columns)
            ->withCount('satpams');
        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }
        return $query->groupBy('bujps.id', 'users.id')
            ->paginate($this->recordPerPage, ['*'], 'halaman', empty($filter['page']) ? 1 : $filter['page']);
    }

    /**
     * Get all filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFilterWithExportData(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery()
            ->leftJoin('users', 'users.id', '=', 'bujps.user_id')
            ->select($columns)
            ->withCount('satpams');

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query->get($columns);
    }
}
