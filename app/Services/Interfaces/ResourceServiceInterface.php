<?php

namespace App\Services\Interfaces;

interface ResourceServiceInterface
{
    public function store(array $data);
    public function show($id);
    public function update(array $data, $id);
    public function delete($id);
}
