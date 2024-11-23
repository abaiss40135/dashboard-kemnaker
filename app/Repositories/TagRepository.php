<?php


namespace App\Repositories;


use App\Models\Agama;
use App\Models\Tagging\Tag;
use App\Repositories\Abstracts\AgamaRepositoryAbstract;
use App\Repositories\Abstracts\TagRepositoryAbstract;

class TagRepository extends TagRepositoryAbstract
{
    public function model()
    {
        return Tag::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['name'])){
            $query->where('name', 'ilike', '%'.$filter['name'].'%');
        }
    }
}
