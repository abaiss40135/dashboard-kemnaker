<?php


namespace App\Repositories\Abstracts;



abstract class LaporanInformasiRepositoryAbstract extends BaseRepositoryAbstract
{
    public function getQuery()
    {
        return $this->model->newQuery()
            ->has('form')
            ->has('keywords');
    }
}
