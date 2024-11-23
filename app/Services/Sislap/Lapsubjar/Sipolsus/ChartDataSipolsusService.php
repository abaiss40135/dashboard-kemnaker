<?php

namespace App\Services\Sislap\Lapsubjar\Sipolsus;

use App\Models\Polsus;

class ChartDataSipolsusService
{
    /*
     * semua data polsus yang dihasilkan adalah data polsus yang aktif (belum pensiun)
     * */

    public function queryJenjangDiklat($jenjang_diklat)
    {
        return Polsus::filterByJenjangDiklat($jenjang_diklat)->filterPolsusAktif()->filterRolePolisiKhusus()->filterByPolsusProvinceAndKabupaten()->filterKategoriNotNullPolsus();
    }

    public function queryKepemilikanKta()
    {
        return Polsus::query()->where('kepemilikan_kta', '1')->filterPolsusAktif()->filterRolePolisiKhusus()->filterByPolsusProvinceAndKabupaten()->filterKategoriNotNullPolsus();
    }

    public function queryPolsusPensiun()
    {
        return Polsus::filterPolsusPensiun()->filterByPolsusProvinceAndKabupaten();
    }

    // query tahap 2 dari chart yaitu mapping data ke tiap tiap polsus
    public function queryTahap2($type, $jenis_polsus)
    {
        $newFormatType = $this->changeToSnakeCase($type);
        $query = match($type) {
            'polsus-memiliki-kta' => $this->queryKepemilikanKta(),
            'polsus-pensiun' => $this->queryPolsusPensiun(),
            default => $this->queryJenjangDiklat($newFormatType)
        };

        return $query->filterByAttributeUser()->filterByJenisPolsus($jenis_polsus)->filterByPolsusProvinceAndKabupaten();
    }

    // change format string from kebab-case to snake_case
    public function changeToSnakeCase ($type)
    {
        return implode('_', explode('-', $type));
    }
}
