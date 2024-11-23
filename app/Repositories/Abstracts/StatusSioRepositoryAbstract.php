<?php


namespace App\Repositories\Abstracts;


abstract class StatusSioRepositoryAbstract extends BaseRepositoryAbstract
{
    public function getFilterWithAllData(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery();

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }
        $query->orderBy('id');
        if ($this->limit > 0){
            return $query->limit($this->limit)->get($columns);
        } else {
            return $query->get($columns);
        }
    }
}
