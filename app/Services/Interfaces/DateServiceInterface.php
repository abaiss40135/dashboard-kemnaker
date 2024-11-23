<?php


namespace App\Services\Interfaces;


interface DateServiceInterface
{
    public function getAllFullTextMonth();

    public function getFullTextMonth(int $month);
}
