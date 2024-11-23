<?php


namespace App\Repositories\Abstracts;


use App\Helpers\Constants;
use Illuminate\Support\Str;

abstract class ProvinsiRepositoryAbstract extends BaseRepositoryAbstract
{
    public function getQuery()
    {
        $query = $this->model->newQuery();
        if (auth()->user()->haveRole(Constants::OPERATOR_BHABINKAMTIBMAS)){
            $query->where('polda', Str::after(auth()->user()->personel->polda, 'POLDA '));
        }
        return $query;
    }
}
