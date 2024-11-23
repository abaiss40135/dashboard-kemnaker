<?php


namespace App\Services\Interfaces;


interface ProvinsiServiceInterface extends ResourceServiceInterface, SelectInterface
{
    public function getDataAndKeyByCode();

    public function getSelectDataPolda();

    public function getSelectProvinsiData();
}
