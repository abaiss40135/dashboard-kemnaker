<?php


namespace App\Services\Interfaces;


interface NIBServiceInterface extends ResourceServiceInterface, DatatableServiceInterface
{
    public function findWithAllRelation($nib);

    public function find($nib);

   public function getChecklistDatatable();
}
