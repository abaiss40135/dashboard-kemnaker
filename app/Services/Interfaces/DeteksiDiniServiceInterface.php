<?php


namespace App\Services\Interfaces;




interface DeteksiDiniServiceInterface extends DatatableServiceInterface, ResourceServiceInterface , CurrentLocationInterface
{
    public function getSelectNarasumber();
}
