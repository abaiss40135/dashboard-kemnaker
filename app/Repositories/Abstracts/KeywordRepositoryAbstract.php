<?php


namespace App\Repositories\Abstracts;


use App\Models\LaporanPublik;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

abstract class KeywordRepositoryAbstract extends BaseRepositoryAbstract
{
    public function create(array $data)
    {
        $model = $this->model;
        $queryIfExist = $model->where('keyword', $data['keyword']);
        if ($queryIfExist->exists()) {
            $keyword = $queryIfExist->first();
//            if ($data['state'] != 'update'){
                //TODO we need to remove this update method, especially li count(), slow query
                //$queryIfExist->update(['jumlah' => $keyword->laporanInformasis()->count()]);
//            }
            return $keyword;
        } else {
            return $model->create($data);
        }
    }

    public function getFilterPopularData(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery()
                    ->has('laporanInformasis');

        if (role('operator_bhabinkamtibmas_polda')){
            $query->whereHas('laporanInformasis.form', function ($query){
                if ($query->getModel()->getTable() === LaporanPublik::query()->getModel()->getTable()) {
                    $query->where('provinsi', Lang::get('alias-polda')[auth()->user()->personel->polda]);
                } else {
                    $query->where('polda', Str::between(auth()->user()->personel->satuan1, 'POLDA ', '-'));
                }
            });
        }

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query
            ->orderByDesc('jumlah')
            ->limit($this->popularLimit)
            ->get($columns);
    }

    public function getFilterWithAllData(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery()->latest('is_valid')->latest('jumlah');

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }
        if ($this->limit > 0){
            return $query->limit($this->limit)->get($columns);
        } else {
            return $query->get($columns);
        }
    }
}
