<?php


namespace App\Services\Interfaces;


interface DDSWargaServiceInterface extends DatatableServiceInterface, ResourceServiceInterface , CurrentLocationInterface
{
    public function getPencarianLaporan();

    public function getSelectedRegionMap();

    public function countDds();

    public function getSelectKepalaKeluarga();
}
