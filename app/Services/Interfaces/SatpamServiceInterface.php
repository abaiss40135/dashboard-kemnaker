<?php


namespace App\Services\Interfaces;


interface SatpamServiceInterface
{
    public function search(array $request);

    public function getSelect2Provinsi();

    public function exportList(array $request);
}
