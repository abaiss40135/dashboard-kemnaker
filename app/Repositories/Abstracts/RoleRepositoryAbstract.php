<?php


namespace App\Repositories\Abstracts;


use App\Models\User;

abstract class RoleRepositoryAbstract extends BaseRepositoryAbstract
{
    public function getQuery()
    {
        return $this->model->newQuery()
            ->where('id', "!=", User::ADMIN);
    }
}
