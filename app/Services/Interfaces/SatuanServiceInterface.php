<?php

namespace App\Services\Interfaces;

interface SatuanServiceInterface extends SelectInterface
{
    public function getDataAndKeyByCode();

    public function getSelectData();
}
