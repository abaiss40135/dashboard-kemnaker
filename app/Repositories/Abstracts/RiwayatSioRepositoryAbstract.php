<?php


namespace App\Repositories\Abstracts;


abstract class RiwayatSioRepositoryAbstract extends BaseRepositoryAbstract
{
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
            ->with([
                'status_terakhir.statusSio:id,status',
                'checklist.nib:id,nama_perseroan,email_perusahaan',
                'dokumens'
            ])->select($columns);

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }
        return $query->get($columns);
    }
}
