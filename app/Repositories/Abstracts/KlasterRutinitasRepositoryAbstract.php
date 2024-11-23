<?php


namespace App\Repositories\Abstracts;


use App\Helpers\Constants;

abstract class KlasterRutinitasRepositoryAbstract extends BaseRepositoryAbstract
{
    public function getQuery()
    {
        $query = $this->model->newQuery();
        if (auth()->user()->haveRole(Constants::OPERATOR_BHABINKAMTIBMAS)){
            $query->where('kode_satuan', 'like', auth()->user()->personel->kode_satuan . '%');
        }

        return $query;
    }
}
