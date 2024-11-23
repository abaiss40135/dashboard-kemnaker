<?php


namespace App\Repositories\Abstracts;


use App\Helpers\Constants;
use App\Models\User;
use Illuminate\Support\Facades\DB;

abstract class UserRepositoryAbstract extends BaseRepositoryAbstract
{
    public function create(array $data)
    {
        $queryUser = User::where('nrp', $data['nrp']);
        if ($queryUser->exists()){
            return $queryUser->first();
        }
        return $this->model->create($data);
    }

    public function getUserBhabinkamtibmasQuery(array $filter, array $columns = ['users.*'])
    {
        $query = $this->getQuery()
            ->hasNrp()
            ->isBhabinkamtibmas()
            ->leftJoin('personel', 'users.id', '=', 'personel.user_id');

        if (auth()->user()->haveRole(Constants::OPERATOR_BHABINKAMTIBMAS)){
            $query->whereRaw("(CASE
           WHEN personel.satuan7 IS NOT NULL THEN split_part(personel.satuan7::text, '-'::text, 2)
           WHEN personel.satuan6 IS NOT NULL THEN split_part(personel.satuan6::text, '-'::text, 2)
           WHEN personel.satuan5 IS NOT NULL THEN split_part(personel.satuan5::text, '-'::text, 2)
           WHEN personel.satuan4 IS NOT NULL THEN split_part(personel.satuan4::text, '-'::text, 2)
           WHEN personel.satuan3 IS NOT NULL THEN split_part(personel.satuan3::text, '-'::text, 2)
           WHEN personel.satuan2 IS NOT NULL THEN split_part(personel.satuan2::text, '-'::text, 2)
           WHEN personel.satuan1 IS NOT NULL THEN split_part(personel.satuan1::text, '-'::text, 2)
           ELSE NULL::text
           END) like ?", [auth()->user()->personel->kode_satuan . '%']);
        }
        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query->select($columns)->orderBy('nrp');
    }

    public function findBy($attribute, $value, $columns = array('*'), $otherAttribute = null, $otherValue = null)
    {
        $query = $this->model->where($attribute, '=', $value);
        if ($otherAttribute){
            $query->orWhere($otherAttribute, $otherValue);
        }
        $query->first($columns);
    }
}
