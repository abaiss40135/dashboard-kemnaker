<?php


namespace App\Repositories;


use App\Helpers\Constants;
use App\Models\User;
use App\Repositories\Abstracts\UserRepositoryAbstract;

class UserRepository extends UserRepositoryAbstract
{
    const NONAKTIF = [
        '0' => 'Tidak Aktif',
        '1' => 'Aktif'
    ];
    public function model()
    {
        return User::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['is_aktif'])) {
            if ($filter['is_aktif']) {
                $query->whereHas('roles', function ($query) {
                    $query->whereNotIn('id',[User::BHABINKAMTIBMAS_PENSIUN, User::BHABINKAMTIBMAS_MUTASI]);
                })->where(function ($query){
                    $query->doesntHave('mutasi')->orWhereHas('mutasi', function ($query){
                        $query->where('mutasi', false);
                    });
                });
            } else {
                $query->where(function ($query){
                    $query->whereHas('roles', function ($query) {
                        $query->whereIn('id', [User::BHABINKAMTIBMAS_PENSIUN, User::BHABINKAMTIBMAS_MUTASI]);
                    })->orWhereHas('mutasi', function ($query) {
                        $query->where('mutasi', true);
                    });
                });
            }
        }
        if (!empty($filter['nrp'])){
            $query->where('nrp', $filter['nrp']);
        }
        if (!empty($filter['email'])){
            $query->where('email', $filter['email']);
        }
        if (!empty($filter['is_login']) || (array_key_exists("is_login", $filter) && $filter['is_login'] != '')) {
            if ($filter['is_login']){
                $query->whereNotNull('last_login_at');
            } else {
                $query->whereNull('last_login_at');
            }
        }
        if (!empty($filter['role'])){
            $query->whereHas('roles', function ($query) use ($filter){
                $query->where('name', 'ilike', '%' . $filter['role']);
            });
        }
        if (!empty($filter['username'])){
            $query->where(function ($query) use ($filter) {
                $query->where('nrp', $filter['username'])
                    ->orWhere('email', $filter['username']);
            });
        }
        if (!empty($filter['start_date'])){
            $query->whereDate('last_login_at', '>=', $filter['start_date']);
        }
        if (!empty($filter['end_date'])){
            $query->whereDate('last_login_at', '<=', $filter['end_date']);
        }
        if (!empty($filter['polda'])) {
            $query->whereHas('personel', function ($query) use ($filter) {
                $query->where('satuan1', 'ilike', $filter['polda'] . '%');
            });
        }
        if (!empty($filter['polres'])) {
            $query->whereHas('personel', function ($query) use ($filter) {
                $query->where('satuan2', 'ilike', $filter['polres'] . '%');
            });
        }
        if (!empty($filter['province'])) {
            $query->whereHas('lokasiPenugasans', function ($query) use ($filter) {
                $query->where('province_code', $filter['province']);
            });
        }
        if (!empty($filter['city'])) {
            $query->whereHas('lokasiPenugasans', function ($query) use ($filter) {
                $query->where('city_code', $filter['city']);
            });
        }
        if (!empty($filter['district'])) {
            $query->whereHas('lokasiPenugasans', function ($query) use ($filter) {
                $query->where('district_code', $filter['district']);
            });
        }
        if (!empty($filter['village'])) {
            $query->whereHas('lokasiPenugasans', function ($query) use ($filter) {
                $query->where('village_code', $filter['village']);
            });
        }
        if (!empty($filter['klaster_rutinitas'])) {
            $klaster = strtoupper($filter['klaster_rutinitas']);
            $query->where(function ($query) use ($klaster) {
                $query->whereHas('latest_klaster_rutinitas', function ($query) use ($klaster) {
                    $query->where('klaster_rutinitas', $klaster);
                })->when($klaster === Constants::RUTINITAS_KURANG, function ($query) {
                    $query->orWhereDoesntHave('latest_klaster_rutinitas');
                });
            });
        }
        // untuk daftar bhabin | kinerja bhabinkamtibmas
        if(!empty($filter['nama'])) {
            $query->whereHas('personel', function($q) use($filter) {
                $q->where('personel_id', $filter['nama']);
            });
        }

        if(!empty($filter['identity'])) {
            $query->where(function ($q) use ($filter) {
                $q->where('nrp', 'ilike', $filter['identity'].'%')
                    ->orWhere('email', 'ilike', $filter['identity'].'%');
            });
        }

        if (!empty($filter['level'])) {
            $query->whereHas('roles', function ($q) use($filter) {
                $q->where('level', '<=', $filter['level']);
            });
        }
    }
}
