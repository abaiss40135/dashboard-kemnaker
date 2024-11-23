<?php


namespace App\Services\Interfaces\Sislap;


interface SislapServiceInterface
{
    public function filterQueryByRole($query, int $paginate = 10);
}
