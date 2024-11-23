<?php


namespace App\Services\Interfaces;


interface LaporanBhabinkamtibmasServiceInterface extends ExportInterface
{
    public function filter(array $request);

    public function getTaggedMap(array $request);

    public function getProvinceStatistic(array $request);

    public function getRekapLaporanBhabinkamtibmas() :array;

    public function getRekapBidangInformasi() :array;
}
