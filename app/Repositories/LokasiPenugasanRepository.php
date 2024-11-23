<?php


namespace App\Repositories;


use App\Helpers\Constants;
use App\Models\LokasiPenugasan;
use App\Repositories\Abstracts\LokasiPenugasanRepositoryAbstract;

class LokasiPenugasanRepository extends LokasiPenugasanRepositoryAbstract
{
    public function model()
    {
        return LokasiPenugasan::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['user_id'])) {
            $query->where('user_id', $filter['user_id']);
        }
        if (!empty($filter['province_code'])) {
            $query->where(function ($query) use ($filter) {
                $kecamatanService   = new \App\Services\KecamatanService();
                $kecamatanPMJ       = $kecamatanService->getDistrictCodePoldaMetroJaya();
                $kecamatanBanten    = $kecamatanService->getIdTambahanPoldaBanten();
                $query->where('province_code', $filter['province_code']);
                if ($filter['province_code'] == Constants::idMetroJaya) {
                    $query->orWhere(function ($query) use ($kecamatanPMJ) {
                        $query->whereIn('city_code', ['3216', '3603', '3275', '3276', '3671', '3674', '3201'])
                            ->where(function ($q) use ($kecamatanPMJ) {
                                $q->whereIn('district_code', $kecamatanPMJ)
                                ->orWhere('kawasan', 'ilike', '%bandara%');
                            });
                    });
                }
                if ($filter['province_code'] == Constants::idBanten) {
                    $query->whereNotIn('district_code', $kecamatanPMJ)
                        ->orWhere(function ($query) use ($kecamatanPMJ, $kecamatanBanten) {
                        $query->whereHas('personel', function ($query) {
                            $query->where('satuan3', 'SIMILAR TO', '%(2131810|2131811)');
                        })->orWhere(function ($query) use ($kecamatanBanten, $kecamatanPMJ) {
                           $query->whereIn('district_code', $kecamatanBanten);
                        });
                    });
                }
            });
        }
        if (!empty($filter['city_code'])) {
            $query->where('city_code', $filter['city_code']);
        }
        if (!empty($filter['district_code'])) {
            $query->where('district_code', $filter['district_code']);
        }
        if (!empty($filter['village_code'])) {
            $query->where('village_code', $filter['village_code']);
        }
    }
}
