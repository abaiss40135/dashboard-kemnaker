<?php


namespace App\Services\Interfaces;



interface KeywordServiceInterface extends ResourceServiceInterface, SelectInterface, DatatableServiceInterface
{
    public function getPencarianLaporan();

    public function getSelectedRegionMap();

    public function getPopularKeyword();

    public function getPopularKeywordByProvince($province);

    public function save(array $data, $state);

    public function syncKeywords(array $keyword, $tanggal, $model);

}
