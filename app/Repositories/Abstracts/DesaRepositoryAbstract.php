<?php


namespace App\Repositories\Abstracts;


abstract class DesaRepositoryAbstract extends BaseRepositoryAbstract
{
    public function create(array $data)
    {
        $data['code'] = (int) $this->getQuery()->latest('code')->first()->code + 1;
        return $this->model->create($data);
    }
}
