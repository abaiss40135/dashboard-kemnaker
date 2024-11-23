<?php


namespace App\Repositories\Abstracts;


abstract class AtensiPimpinanRepositoryAbstract extends BaseRepositoryAbstract
{
    public function getFilterWithPaginatedData(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery();

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query->latest()->paginate($this->recordPerPage, $columns);
    }
}
