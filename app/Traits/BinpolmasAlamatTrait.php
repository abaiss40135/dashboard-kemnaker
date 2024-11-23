<?php

namespace App\Traits;



trait BinpolmasAlamatTrait
{
    private function valOrEmpty(String $value): String
    {
        return $value ? $value : '';
    }

    public function getAlamat(array $value)
    {
        $provinsi  = 'Provinsi ' . $this->valOrEmpty($value['provinsi']);
        $kabupaten = $this->valOrEmpty($value['kabupaten']);
        $kecamatan = $this->valOrEmpty($value['kecamatan']);
        $desa      = $this->valOrEmpty($value['desa']);

        return ucwords(strtolower($provinsi . ', ' . $kabupaten . ', ' . $kecamatan . ', ' . $desa))
            . ', ' . $value['jalan']
            . ', RT ' . $value['rt']
            . ', RW ' . $value['rw'];
    }
}