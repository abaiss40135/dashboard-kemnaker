<?php

namespace App\Http\Controllers\Bujp\SIO;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\StatusSioServiceInterface;

class StatusSioController extends Controller
{
    /**
     * @var StatusSioServiceInterface
     */
    private $statusSioService;

    public function __construct(StatusSioServiceInterface $statusSioService)
    {
        $this->statusSioService = $statusSioService;
    }

    public function getSelect2()
    {
        return $this->statusSioService->getSelectData();
    }
}
