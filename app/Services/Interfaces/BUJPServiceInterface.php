<?php


namespace App\Services\Interfaces;


interface BUJPServiceInterface extends SelectInterface, ExportInterface
{
    public function getSelect2Wilayah();
}
