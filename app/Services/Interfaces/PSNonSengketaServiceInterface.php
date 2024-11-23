<?php


namespace App\Services\Interfaces;


interface PSNonSengketaServiceInterface extends DatatableServiceInterface
{
    public function getSelectNamaNarasumber();
    public function export(array $request);
}
