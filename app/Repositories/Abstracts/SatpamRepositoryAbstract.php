<?php


namespace App\Repositories\Abstracts;



abstract class SatpamRepositoryAbstract extends BaseRepositoryAbstract
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
        $query = $this->getQuery()
                    ->leftJoin('bujps', 'bujps.id', '=', 'satpams.bujp_id');

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query->select($columns)->paginate($this->recordPerPage, ['*'], 'halaman');
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
            ->leftJoin('bujps', 'bujps.id', '=', 'satpams.bujp_id')
            ->leftJoin('users', 'users.id', '=', 'satpams.user_id')
            ->select($columns);

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query->get($columns);
    }
}
