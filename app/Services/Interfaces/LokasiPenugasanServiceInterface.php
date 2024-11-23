<?php


namespace App\Services\Interfaces;


interface LokasiPenugasanServiceInterface extends ResourceServiceInterface, DatatableServiceInterface
{
    public function get(array $request, array $columns = ['*']);
}
