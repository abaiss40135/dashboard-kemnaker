<?php


namespace App\Services\Interfaces;


interface AtensiPimpinanServiceInterface extends DatatableServiceInterface, SelectInterface, ResourceServiceInterface
{
    public function getFrontendData();
}
