<?php


namespace App\Services\Interfaces;


interface RiwayatSioServiceInterface extends DatatableServiceInterface, ResourceServiceInterface, ExportInterface
{
    public function getDatatable(string $options = '');    
}
