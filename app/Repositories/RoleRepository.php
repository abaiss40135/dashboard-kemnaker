<?php


namespace App\Repositories;


use App\Helpers\Constants;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Abstracts\RoleRepositoryAbstract;

class RoleRepository extends RoleRepositoryAbstract
{

    public $limit = 0; // unlimit

    public function model()
    {
        return Role::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!auth()->user()->haveRole('administrator')) {
            $query->where('level', '<', auth()->user()->roles()->orderByDesc('level')->first(['level'])->level);
        }
        if (auth()->user()->roles()->where('name', 'ilike', 'operator%')->exists()) {
            $query->where(function ($query) {
                $query->where('name', 'ilike', '%operator');
                if (auth()->user()->haveRole('operator_mabes')) {
                    $query->orWhere('name', 'ilike', '%operator_mabes%');
                }
                if (auth()->user()->haveRole(Constants::OPERATOR_BHABINKAMTIBMAS)) {
                    $query->orWhere('name', 'ilike', '%bhabinkamtibmas%');
                }
                if (auth()->user()->haveRole(Constants::OPERATOR_BAGOPSNALEV)) {
                    $query->orWhere('name', 'ilike', '%operator_bagopsnalev%');
                }
                if (auth()->user()->haveRole(Constants::OPERATOR_POLSUS)) {
                    $query->orWhere('name', 'ilike', '%polsus%');
                }
                if (auth()->user()->haveRole(Constants::OPERATOR_BINPOLMAS)) {
                    $query->orWhere('name', 'ilike', '%operator_binpolmas%');
                }
            });
        }

        if (!empty($filter['name'])) {
            $query->where('name', 'ilike', '%'.$filter['name'].'%');
        }
        if (!empty($filter['alias'])) {
            $query->where('alias', 'ilike', '%'.$filter['alias'].'%');
        }
        if(!empty($filter['type-page-request'])) {
            if($filter['type-page-request'] == 'tambah-akun-page') {
                $query->where('name', 'not ilike', '%mutasi%');
            }

            if($filter['type-page-request'] == 'tambah-polsus-page') {
                $query->where('name', 'ilike', '%polsus%');
            }
        }
    }
}
