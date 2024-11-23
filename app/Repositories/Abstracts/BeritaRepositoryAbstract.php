<?php


namespace App\Repositories\Abstracts;


abstract class BeritaRepositoryAbstract extends BaseRepositoryAbstract
{
    protected $recordPerPageAjax = 7;

    /**
     * @param array $filter
     * @param array|string[] $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilterWithPaginatedAjaxData(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery();

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query->latest()->paginate($this->recordPerPageAjax, $columns);
    }
}
