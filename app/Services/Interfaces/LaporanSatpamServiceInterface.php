<?php


namespace App\Services\Interfaces;


interface LaporanSatpamServiceInterface extends ExportInterface
{
    public function filter(array $request);

    public function getTaggedMap(array $request);

    public function getProvinceStatistic(array $request);

    public function getRekapLaporanSatpam() :array;

    public function getRekapBidangLaporan() :array;
}
