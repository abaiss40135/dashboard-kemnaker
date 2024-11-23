<?php


namespace App\Services\Interfaces;


interface PersonelServiceInterface extends DatatableServiceInterface, ResourceServiceInterface
{
    public function showByNrp($nrp);
}
