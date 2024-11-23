<?php


namespace App\Services\Interfaces;


interface PencarianUmumServiceInterface
{
    public function query(string $query);

    public function search(string $query);

    public function grouped(string $query, string $type = null);
}
