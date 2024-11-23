<?php


namespace App\Services\Interfaces;


interface LaporanInformasiServiceInterface extends SelectInterface, ResourceServiceInterface
{
    public function filter(array $filter);

    public function getProvinceStatistics(array $filter);
}
