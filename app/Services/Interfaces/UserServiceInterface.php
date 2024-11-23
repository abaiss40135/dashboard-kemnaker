<?php


namespace App\Services\Interfaces;


interface UserServiceInterface extends DatatableServiceInterface, ExportInterface, SelectInterface
{
    public function store(array $data, array $roles);

    public function update(array $data, $id, array $roles = []);

    public function findBy($attribute, $value, $otherAttribute = null, $otherValue = null);
}
