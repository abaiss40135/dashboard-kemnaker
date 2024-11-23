<?php


namespace App\Services\Interfaces;


interface PSSengketaServiceInterface extends DatatableServiceInterface , CurrentLocationInterface
{
    public function getSelectPihakTerkait();
    public function export(array $request);
}
